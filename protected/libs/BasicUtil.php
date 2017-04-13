<?php
/**
 * 각종 Utility
 * 
 * @author Shinwook
 * @since Feb 25, 2017
 */
class BasicUtil{
	public function get_next_day($date_str, $days=1, $format = 'Y/m/d'){
		$date_str = str_replace('-','',$date_str);
		if(strlen($date_str)<1) $date_str = date('Ymd');
		$end_date = date($format,mktime(0,0,0, substr($date_str, 4,2) ,  substr($date_str, 6,2)  + $days,  substr($date_str, 0,4) ));
		return $end_date;
	}
	
	public function strcut_utf8($str, $len, $checkmb=true, $tail='...') {
		preg_match_all('/[\xEA-\xED][\x80-\xFF]{2}|./', $str, $match);
		$m    = $match[0];
		$slen = strlen($str);  // length of source string
		$tlen = strlen($tail); // length of tail string
		$mlen = count($m);    // length of matched characters
	
		if ($slen <= $len) return $str;
		if (!$checkmb && $mlen <= $len) return $str;
	
		$ret  = array();
		$count = 0;
	
		for ($i=0; $i < $len; $i++) {
			$count += ($checkmb && strlen($m[$i]) > 1)?2:1;
			if ($count + $tlen > $len) break;
			$ret[] = $m[$i];
		}
		return join('', $ret).$tail;
	}
	
	public function print_date($date_str, $format = '-'){
		if(strlen($date_str) >0) $result = substr($date_str, 0, 4).$format.substr($date_str, 4, 2).$format.substr($date_str, 6, 2);	return $result;
	}
	
	/**
	 * paging
	 * @param string $baseUrl
	 * @param integer $pg_total_page
	 * @param integer $pg_current_page
	 * @param integer $pg_page_per_section
	 */
	public function pagingFront($baseUrl, $total_page, $page, $page_per_section, $options=''){
		if($total_page > 0) {
			$base_page = $page - (($page % $page_per_section) == 0 ? $page_per_section : ($page % $page_per_section));
			
			if($base_page != 0) {
				$nav_list[] = array("page" => $base_page, "page_name" => "prev");
			}
			
			for ($i = 1; $i <= $page_per_section && (($i + $base_page) <= $total_page); $i++) {
				$nav_list[] = array("page" => $i + $base_page, "page_name" => $i + $base_page);
			}
			
			if (($base_page + $page_per_section) < $total_page) {
				$nav_list[] = array("page" => $base_page + $page_per_section + 1, "page_name" => "next");
			}
		}
	
		for($i=0 ; $i<count($nav_list) ; $i++){
			if($page == $nav_list[$i]["page"]){
				$_html .= '<a href="#" class="on">'.$nav_list[$i]["page_name"].'</a>';
			}
			else{
				if($nav_list[$i]["page_name"]=="prev"){
					$_html .= $options[link]=="onclick" ? '<a href="#none" onclick="'.$options[fn_nm].'('.$nav_list[$i]["page"].');" class="prev">Prev</a>' : '<a href="'.$baseUrl.'?page='.$nav_list[$i]["page"].'" class="prev">Prev</a>';
				}
				elseif($nav_list[$i]["page_name"]=="next"){
					$_html .= $options[link]=="onclick" ? '<a href="#none" onclick="'.$options[fn_nm].'('.$nav_list[$i]["page"].');" class="next">Next</a>' : '<a href="'.$baseUrl.'?page='.$nav_list[$i]["page"].'" class="next">Next</a>';
				}
				else{
					$_html .= $options[link]=="onclick" ? '<a href="#none" onclick="'.$options[fn_nm].'('.$nav_list[$i]["page"].');">'.$nav_list[$i]["page_name"].'</a>' : '<a href="'.$baseUrl.'?page='.$nav_list[$i]["page"].'">'.$nav_list[$i]["page_name"].'</a>';
				}
			}
		}
	
		return $_html;
	}
	
	public function curlPost($url,$data) {
		$headers[] = 'Accept: text/html, image/gif, image/x-bitmap, image/jpeg, image/pjpeg';
		$headers[] = 'Connection: Keep-Alive';
		$headers[] = 'Content-type: application/x-www-form-urlencoded;charset=UTF-8';
		$user_agent = 'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; .NET CLR 1.0.3705; .NET CLR 1.1.4322; Media Center PC 4.0)';
		
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers); 
		curl_setopt($ch, CURLOPT_HEADER, 1); 
		curl_setopt($ch, CURLOPT_USERAGENT, $user_agent);
		curl_setopt($ch, CURLOPT_ENCODING, 'gzip');
		curl_setopt($ch, CURLOPT_TIMEOUT, 30);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		$return = curl_exec($ch);
		curl_close($ch);
		
		return $return;
	}
	
	public function curlPostSimple($url,$data) {
		$headers[] = 'Content-type: application/json';
		
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers); 
		curl_setopt($ch, CURLOPT_HEADER, 0); 
		curl_setopt($ch, CURLOPT_ENCODING, 'gzip');
		curl_setopt($ch, CURLOPT_TIMEOUT, 30);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($ch, CURLOPT_POST, 1);
		$return = curl_exec($ch);
		curl_close($ch);
	
		return $return;
	}
	
	public function curlGet($url) {
		$headers[] = 'Accept: image/gif, image/x-bitmap, image/jpeg, image/pjpeg';
		$headers[] = 'Connection: Keep-Alive';
		$headers[] = 'Content-type: application/x-www-form-urlencoded;charset=UTF-8';
		$user_agent = 'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; .NET CLR 1.0.3705; .NET CLR 1.1.4322; Media Center PC 4.0)';
		$cookie_file = "/cookies.txt";
		
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_USERAGENT, $user_agent);
		curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_file);
		curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_file);
		curl_setopt($ch, CURLOPT_ENCODING , 'gzip');
		curl_setopt($ch, CURLOPT_TIMEOUT, 30);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		$return = curl_exec($ch);
		curl_close($ch);
		
		return $return;
	}
	
	public function curlGet2($url) {
		if($_SERVER[HTTP_HOST]=="packing.warpex.com" || $_SERVER[HTTP_HOST]=="dev.packing"){
			$cookieFile = "/home/cookies.txt";
		}
		else{
			$cookieFile = "C:\wamp\www\cookies.txt";
		}
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HEADER, 1);
		curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieFile);
		curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieFile);
		$data = curl_exec($ch);
		curl_close($ch);
		return $data;
	}
	
	/**
	 * IP Address 정보
	 * 
	 * @example return : {"ip": "107.131.131.27", "hostname": "107-131-131-27.lightspeed.irvnca.sbcglobal.net", "city": null, "region": null, "country": "US", "loc": "38.0000,-97.0000", "org": "AS7018 AT&T Services, Inc."}
	 * @return json
	 */
	public function getIPInfo(){
		$json = $this->curlGet("ipinfo.io/".$_SERVER[REMOTE_ADDR]."/json");
		
		return $json;
	}
	
	/**
	 * Application Code 생성
	 */
	public function generateAppCode($ctg_cd, $level){
		return date("Y")."-".$ctg_cd.$level."-".sprintf("%04d", rand(0000,9999));
	}
	
	/**
	 * 임시 비밀번호 생성하기.
	 */
	public function generateRandomPwd() {	
		$length = 10;
		$chars = array_merge(range(0,9), range('a','z'), range('A','Z'));
		shuffle($chars);
		$password = implode(array_slice($chars, 0, $length));
		
		return $password;	
	}
	
	/**
	 * 이메일 보내기.
	 */
	public function sendEmail($param){
		
		// 메일을 받을 사람 주소.
		$email = $param[email];
		//$email="paperclip@naver.com";
		// 메일 템플릿 양식.
		$view  = $param[view];
		// 메일 본문 파라미터
		$contentsParams = $param[contentsParams];
		$contentsParams2 = $param[contentsParams];
		// 메일 제목.
		//$subject = $param[subject];
		$subject = "=?EUC-KR?B?".base64_encode(iconv("UTF-8","EUC-KR",$param[subject]))."?=";
		
		$account = new Account();
		
		$amemberInfo = $account->getMemberInfo($email);
		
		# 메일 수신에 동의한 고객에게만 발송함.
		if(substr($view, 0, 25) == 'email_temporary_password_' || $amemberInfo[is_email]==1) {
			
			#$message = new YiiMailMessage;
			
			#$message->view    = $view;
			#$message->subject = $subject;
			#$contentsParams   = array('setParam'=>$contentsParams);
			#$message->setBody($contentsParams, 'text/html');
			#$message->addTo($email);
			
			#$message->from = Yii::app()->params['helpEmail'];
			
			# deprecated email send function. 
			#$receiptCnt = Yii::app()->mail->send($message);
			
			# new email template param
			
			$email_sender = Yii::app()->params['helpEmail'];
			$email_receiver = $email;
			$email_template = Yii::getPathOfAlias(Yii::app()->mail->viewPath.'.'.$view).'.php';
			
			$email_contents = yii::app()->getController()->renderPartial('/frontend/email_template/'.$view, Array( 'setParam' => $param[contentsParams]), true, null);
			
			$smtp = new Smtp();
			$mail_result = $smtp->send($email_sender, $email_receiver, $subject, $email_contents, null, null);
				
			$result = Array();
			#if($receiptCnt > 0) {
				
				$result['status'] = true;
				$result['msg'] = yii::t('common', 'eMail has been sent.');
				
			#} else {
				
			#	$result['status'] = false;
			#	$result['msg'] = yii::t('common', 'Please try it again. !!!!! ');
	
			#}

			# 이메일 발송이력 저장
			if($param['case_no']!=''){
				$common = new Common();
				$params['send_type_cd'] = $param['case_no'];
				$params['mem_id'] = $amemberInfo['mem_id'];
				$params['ref_data'] = $param['ref_data'];
				$common->setEmailHistory($params);
			}
		}
		else {
			$result['status'] = true;
		}
		
		$result['status'] = true;
		
		return $result;
	}
		
	/**
	 * 특수문자제거
	 * @author Jimin Lee
	 * @date 2015/04/14
	 */
	public function removeSpecialChar($string) {
		return str_replace(array('&', '<', '>', '\'', '"', '  ', ' ', '!', '@', '#', '$', '%', '^', '?'),
				array('&amp;', '&lt;', '&gt;', '', '', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' '), $string);
	}

	/**
	 * FTP Upload
	 * 
	 * @param 업로드할 디렉토리명 $base_dir
	 * @param 파일 $files
	 * @return array
	 */
	public function ftpUpload($base_dir, $files){
		# local test
		if($_SERVER[HTTP_HOST]=="localhost.globalomz"){
			$result[status] = true;
			$result[file_path] = "/test";
			
			return $result;
		}
		
		$root_dir = "/backup/ohmyzip/";
		$base_dir = $base_dir."/".date("Ym");
		$ext = pathinfo($files["name"],PATHINFO_EXTENSION);
		$file_name = date('YmdHis')."_".uniqid().".".$ext;
		$ftp = Yii::app()->ftp;
		$ftp->passive(false);
		if($ftp->chdir($root_dir.$base_dir)==false){
			$ftp->mkdir($root_dir.$base_dir);
		}

		$isSuccess = $ftp->put($file_name, $files["tmp_name"], FTP_BINARY);
		if($isSuccess==true){
			$result[status] = true;
			$result[file_path] = "/".$base_dir."/".$file_name;
		}
		else{
			$result[status] = false;
		}		
		
		return $result;
	}
	
	/**
	 * 소숫점 epsilon보정 처리 for 소숫점 비교
	 * 
	 * @param 소수점값 $f1
	 * @param 소수점값 $f2
	 * @param 차이 $epsilon
	 */
	public function isSame($f1, $f2, $epsilon=0.00001){
		return abs(($f1 - $f2) / $f2) < $epsilon;
	}
	
	/**
	 * send mail
	 * 
	 * @param unknown_type $email
	 * @param unknown_type $subject
	 * @param unknown_type $view
	 */
	public function sendMail($email, $subject, $view){
		$app = new Application();
		$memberInfo = $app->memberInfoEmail($email);
		$params['mem_nm'] = $memberInfo['first_nm']." ".$memberInfo['last_nm'];
	
		$email_sender = Yii::app()->params['helpEmail'];
		$email_receiver = $email;
		$contents = Yii::app()->getController()->renderPartial('/frontend/email_templates/'.$view, array('params'=>$params), true, null);
		
		$headers = "Content-Type: text/html; charset=utf-8\r\n";
		$headers .= "From:".$email_sender;
	
		mail($email_receiver,$subject,$contents,$headers);
	}
}
