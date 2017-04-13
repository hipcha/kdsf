<?php
/**
 * 비밀번호 암호화
 * mcrypt, sha256
 * 
 * @author Shinwook
 * @since Jan 28, 2015
 */
class Pbkdf2{
	/**
	 * constant declare
	 */
	const PBKDF2_COMPAT_HASH_ALGORITHM = 'SHA256';
	const PBKDF2_COMPAT_ITERATIONS = 10000;
	const PBKDF2_COMPAT_SALT_BYTES = 24;
	const PBKDF2_COMPAT_HASH_BYTES = 24;
	
	// Calculates a hash from the given password.
	public function create_hash($password, $force_compat = false){
	    // Generate the salt.	    
	    if (function_exists('mcrypt_create_iv')) {
	        $salt = base64_encode(mcrypt_create_iv(self::PBKDF2_COMPAT_SALT_BYTES, MCRYPT_DEV_URANDOM));
	    } elseif (file_exists('/dev/urandom') && $fp = @fopen('/dev/urandom', 'r')) {
	        $salt = base64_encode(fread($fp, self::PBKDF2_COMPAT_SALT_BYTES));
	    } else {
	        $salt = '';
	        for ($i = 0; $i < self::PBKDF2_COMPAT_SALT_BYTES; $i += 2) {
	            $salt .= pack('S', mt_rand(0, 65535));
	        }
	        $salt = base64_encode(substr($salt, 0, self::PBKDF2_COMPAT_SALT_BYTES));
	    }
	    
	    // Determine the best supported algorithm and iteration count.	    
	    $algo = strtolower(self::PBKDF2_COMPAT_HASH_ALGORITHM);
	    $iterations = self::PBKDF2_COMPAT_ITERATIONS;
	    if ($force_compat || !function_exists('hash_algos') || !in_array($algo, hash_algos())) {
	        $algo = false;                         // This flag will be detected by pbkdf2_default()
	        $iterations = round($iterations / 5);  // PHP 4 is very slow. Don't cause too much server load.
	    }
	    
	    // Return format: algorithm:iterations:salt:hash	    
	    $pbkdf2 = $this->pbkdf2_default($algo, $password, $salt, $iterations, self::PBKDF2_COMPAT_HASH_BYTES);
	    $prefix = $algo ? $algo : 'sha1';
	    return $prefix . ':' . $iterations . ':' . $salt . ':' . base64_encode($pbkdf2);
	}
	
	// Checks whether a password matches a previously calculated hash	
	public function validate_password($password, $hash){
	    // Split the hash into 4 parts.	    
	    $params = explode(':', $hash);
	    if (count($params) < 4) return false;
	    
	    // Recalculate the hash and compare it with the original.	    
	    $pbkdf2 = base64_decode($params[3]);
	    $pbkdf2_check = $this->pbkdf2_default($params[0], $password, $params[2], (int)$params[1], strlen($pbkdf2));
	    return $this->slow_equals($pbkdf2, $pbkdf2_check);
	}
	
	// Checks whether a hash needs upgrading.	
	public function needs_upgrade($hash){
	    // Get the current algorithm and iteration count.	    
	    $params = explode(':', $hash);
	    if (count($params) < 4) return true;
	    $algo = $params[0];
	    $iterations = (int)$params[1];
	    
	    // Compare the current hash with the best supported options.	    
	    if (!function_exists('hash_algos') || !in_array($algo, hash_algos())) {
	        return false;
	    } elseif ($algo === strtolower(self::PBKDF2_COMPAT_HASH_ALGORITHM) && $iterations >= self::PBKDF2_COMPAT_ITERATIONS) {
	        return false;
	    } else {
	        return true;
	    }
	}
	
	// Compares two strings $a and $b in length-constant time.	
	public function slow_equals($a, $b){
	    $diff = strlen($a) ^ strlen($b);
	    for($i = 0; $i < strlen($a) && $i < strlen($b); $i++) {
	        $diff |= ord($a[$i]) ^ ord($b[$i]);
	    }
	    return $diff === 0; 
	}
	
	// PBKDF2 key derivation function as defined by RSA's PKCS #5: https://www.ietf.org/rfc/rfc2898.txt
	// Test vectors can be found here: https://www.ietf.org/rfc/rfc6070.txt
	// This implementation of PBKDF2 was originally created by https://defuse.ca
	// With improvements by http://www.variations-of-shadow.com	
	public function pbkdf2_default($algo, $password, $salt, $count, $key_length){
	    // Sanity check.	    
	    if ($count <= 0 || $key_length <= 0) {
	        trigger_error('PBKDF2 ERROR: Invalid parameters.', E_USER_ERROR);
	    }
	    
	    // Check if we should use the fallback function.	    
	    if (!$algo) return $this->pbkdf2_fallback($password, $salt, $count, $key_length);
	    
	    // Check if the selected algorithm is available.	    
	    $algo = strtolower($algo);
	    if (!function_exists('hash_algos') || !in_array($algo, hash_algos())) {
	        if ($algo === 'sha1') {
	            return $this->pbkdf2_fallback($password, $salt, $count, $key_length);
	        } else {
	            trigger_error('PBKDF2 ERROR: Hash algorithm not supported.', E_USER_ERROR);
	        }
	    }
	    
	    // Use built-in function if available.	    
	    if (function_exists('hash_pbkdf2')) {
	        return hash_pbkdf2($algo, $password, $salt, $count, $key_length, true);
	    }
	    
	    // Count the blocks.	    
	    $hash_length = strlen(hash($algo, '', true));
	    $block_count = ceil($key_length / $hash_length);
	    
	    // Hash it!	    
	    $output = '';
	    for ($i = 1; $i <= $block_count; $i++) {
	        $last = $salt . pack('N', $i);                               // $i encoded as 4 bytes, big endian.
	        $last = $xorsum = hash_hmac($algo, $last, $password, true);  // first iteration.
	        for ($j = 1; $j < $count; $j++) {                            // The other $count - 1 iterations.
	            $xorsum ^= ($last = hash_hmac($algo, $last, $password, true));
	        }
	        $output .= $xorsum;
	    }
	    
	    // Truncate and return.	    
	    return substr($output, 0, $key_length);
	}
	
	// Fallback function using sha1() and a pure-PHP implementation of HMAC.
	// The result is identical to the default function when used with SHA-1.
	// But it is approximately 1.6x slower than the hash_hmac() function of PHP 5.1.2+,
	// And approximately 2.3x slower than the hash_pbkdf2() function of PHP 5.5+.	
	public function pbkdf2_fallback($password, $salt, $count, $key_length){
	    // Count the blocks.	    
	    $hash_length = 20;
	    $block_count = ceil($key_length / $hash_length);
	    
	    // Prepare the HMAC key and padding.	    
	    if (strlen($password) > 64) {
	        $password = str_pad(sha1($password, true), 64, chr(0));
	    } else {
	        $password = str_pad($password, 64, chr(0));
	    }
	    
	    $opad = str_repeat(chr(0x5C), 64) ^ $password;
	    $ipad = str_repeat(chr(0x36), 64) ^ $password;
	    
	    // Hash it!	    
	    $output = '';
	    for ($i = 1; $i <= $block_count; $i++) {
	        $last = $salt . pack('N', $i);
	        $xorsum = $last = pack('H*', sha1($opad . pack('H*', sha1($ipad . $last))));
	        for ($j = 1; $j < $count; $j++) {
	            $last = pack('H*', sha1($opad . pack('H*', sha1($ipad . $last))));
	            $xorsum ^= $last;
	        }
	        $output .= $xorsum;
	    }
	    
	    // Truncate and return.	    
	    return substr($output, 0, $key_length);
	}
}
