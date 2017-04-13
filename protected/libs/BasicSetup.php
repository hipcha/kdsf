<?php
/**
 * 각종 기준 정보 정의
 * 
 * @author Shinwook
 * @since Feb 22, 2017
 */
class BasicSetup{
	public function __construct($params=null){

	}
	
	/**
	 * 각종 상수
	 */
	public function getConstants(){
		# javascript refresh number
		$data[js_refresh_num] = 294;
		
		return $data;
	}
}
