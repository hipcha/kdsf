<?php
/**
 * Application Component
 * 
 * @author Shinwook
 * @since Feb 22, 2017
 */
class Application{
	private $cmd;
	private $mem_id;
	
	/**
	 * Constructor
	 */
	public function __construct(){
		$this->cmd = Yii::app()->db->createCommand();
		
		# session
		$this->mem_id = Yii::app()->user->getState("front_mem_id");
	}
		
	public function checkEmail($email){
		$sql = "SELECT email FROM tb_mem WHERE email=:email";
		$this->cmd->text = $sql;
		$this->cmd->bindParam(':email', $email, PDO::PARAM_STR);
		$is_email = $this->cmd->queryScalar();
		
		$result['status'] = $is_email=="" ? true : false;
		
		return $result;
	}
	
	public function saveStep1($app, $activity){
		try{
			$email = $app[email];
			
			if($this->mem_id > 0){
				unset($app[email]);
				unset($app[pwd]);
				$app[upd_dtime] = new CDbExpression('NOW()');
				$this->cmd->update("tb_mem", $app, "mem_id=:mem_id", array(":mem_id"=>$this->mem_id));
				
				# delete activities
				$this->cmd->delete("tb_activities", "mem_id=:mem_id", array(":mem_id"=>$this->mem_id));
				
				$mem_id = $this->mem_id;
			}
			else{
				# password encryption
				$pbkdf2 = new Pbkdf2();
				$app[pwd] = $pbkdf2->create_hash($app[pwd]);
				
				# insert main table
				$this->cmd->insert("tb_mem", $app);
				$mem_id = Yii::app()->db->getLastInsertID();
				
				$detail['mem_id'] = $mem_id;
				$this->cmd->insert("tb_mem_detail", $detail);
				unset($detail);
				
				# set session
				Yii::app()->user->setState("front_mem_id", $mem_id);
				
				# set cookie
				$cookie = new CHttpCookie('front_mem_id', $mem_id);
				$cookie->expire = time()+60*60*24*180;
				Yii::app()->request->cookies['front_mem_id'] = $cookie;
			}
			
			# insert activities
			foreach($activity['place'] as $key => $activity_place){
				if($activity_place!=""){
					$column['mem_id'] = $mem_id;
					$column['activity_place'] = $activity_place;
					$column['activity_from'] = $activity['from'][$key];
					$column['activity_to'] = $activity['to'][$key];
					$column['activity_contents'] = $activity['contents'][$key];
					$column['activity_role'] = $activity['role'][$key];
			
					$this->cmd->insert("tb_activities", $column);
					unset($column);
				}
			}
			
			# send mail
			$util = new BasicUtil();
			$subject = "[사랑장학회] 장학생 신청이 접수되었습니다.";			
			$util->sendMail($email, $subject, 'signup');
			
			$result['status'] = true;
		}
		catch(Exception $e){
			$result['status'] = false;
			$result['err_msg'] = $e->getMessage();
		}
		
		return $result;
	}
	
	public function getAppCode($ctg_cd, $level){
		$basic = new BasicUtil();
		$app_cd = $basic->generateAppCode($ctg_cd, $level);
	
		# application code 중복체크
		$sql = "SELECT app_cd FROM tb_mem WHERE app_cd=:app_cd";
		$this->cmd->text = $sql;
		$this->cmd->bindParam(':app_cd', $app_cd, PDO::PARAM_STR);
		$is_app_cd = $this->cmd->queryScalar();
		if($is_app_cd!=""){
			$app_cd = $this->getAppCode($ctg_cd, $level);
		}
	
		return $app_cd;
	}
		
	public function memberInfo($mem_id){
		$sql = "
			SELECT a.*, b.*
			FROM tb_mem a
			LEFT JOIN tb_mem_detail b ON b.mem_id=a.mem_id
			WHERE a.mem_id=:mem_id
		";
		$this->cmd->text = $sql;
		$this->cmd->bindParam(':mem_id', $mem_id, PDO::PARAM_INT);
		$row = $this->cmd->queryRow();
		
		return $row;
	}
	
	public function memberInfoEmail($email){
		$sql = "
			SELECT a.*, b.*
			FROM tb_mem a
			LEFT JOIN tb_mem_detail b ON b.mem_id=a.mem_id
			WHERE a.email=:email
		";
		$this->cmd->text = $sql;
		$this->cmd->bindParam(':email', $email, PDO::PARAM_STR);
		$row = $this->cmd->queryRow();
	
		return $row;
	}
	
	public function memberDetail($mem_id){
		$sql = "SELECT a.* FROM tb_mem_detail a	WHERE a.mem_id=:mem_id";
		$this->cmd->text = $sql;
		$this->cmd->bindParam(':mem_id', $mem_id, PDO::PARAM_INT);
		$row = $this->cmd->queryRow();
	
		return $row;
	}
	
	public function saveStep2($mem_ctg){
		try{
			$columns[upd_dtime] = new CDbExpression('NOW()');
			$columns[mem_ctg] = $mem_ctg;
			$this->cmd->update("tb_mem", $columns, "mem_id=:mem_id", array(":mem_id"=>$this->mem_id));
				
			$result['status'] = true;
		}
		catch(Exception $e){
			$result['status'] = false;
			$result['err_msg'] = $e->getMessage();
		}
	
		return $result;
	}
	
	public function saveStep3($app, $family, $expense, $ref){
		try{
			$memberInfo = $this->memberInfo($this->mem_id);
			$memberDetail = $this->memberDetail($this->mem_id);
			
			if($memberInfo['app_cd']==""){
				$columns[app_cd] = $this->getAppCode($memberInfo[mem_ctg], $app[mem_level]);
				$columns[upd_dtime] = new CDbExpression('NOW()');
				$this->cmd->update("tb_mem", $columns, "mem_id=:mem_id", array(":mem_id"=>$this->mem_id));
			}
			
			if($memberDetail[mem_id] > 0){
				$app[upd_dtime] = new CDbExpression('NOW()');
				$this->cmd->update("tb_mem_detail", $app, "mem_id=:mem_id", array(":mem_id"=>$this->mem_id));
				
				$this->cmd->delete("tb_families", "mem_id=:mem_id", array(":mem_id"=>$this->mem_id));
				$this->cmd->delete("tb_expenses", "mem_id=:mem_id", array(":mem_id"=>$this->mem_id));
				$this->cmd->delete("tb_references", "mem_id=:mem_id", array(":mem_id"=>$this->mem_id));
			}
			else{
				$app[mem_id] = $this->mem_id;
				$this->cmd->insert("tb_mem_detail", $app);
			}
						
			# insert families
			foreach($family['family_name'] as $key => $family_name){
				if($family_name!=""){
					$column['mem_id'] = $this->mem_id;
					$column['family_name'] = $family_name;
					$column['family_relationship'] = $family['family_relationship'][$key];
					$column['family_age'] = $family['family_age'][$key];
					$column['family_occupation'] = $family['family_occupation'][$key];
					$column['family_remark'] = $family['family_remark'][$key];
					$column['family_together'] = $family['family_together'][$key];
					$column['family_marital'] = $family['family_marital'][$key];
					
					$this->cmd->insert("tb_families", $column);
					unset($column);
				}
			}
			
			# insert families
			foreach($expense['expense_type'] as $key => $expense_type){
				if($expense_type!=""){
					$column['mem_id'] = $this->mem_id;
					$column['expense_type'] = $expense_type;
					$column['expense_paidby'] = $expense['expense_paidby'][$key];
					$column['expense_amt'] = $expense['expense_amt'][$key];
					
					$this->cmd->insert("tb_expenses", $column);
					unset($column);
				}
			}
			
			# insert reference
			foreach($ref['ref_name'] as $key => $ref_name){
				if($ref_name!=""){
					$column['mem_id'] = $this->mem_id;
					$column['ref_name'] = $ref_name;
					$column['ref_addr'] = $ref['ref_addr'][$key];
					$column['ref_relation'] = $ref['ref_relation'][$key];
					$column['ref_email'] = $ref['ref_email'][$key];
					$column['ref_tel_no'] = $ref['ref_tel_no'][$key];
					$column['ref_work_employer'] = $ref['ref_work_employer'][$key];
					$column['ref_work_addr'] = $ref['ref_work_addr'][$key];
					$column['ref_work_position'] = $ref['ref_work_position'][$key];
				
					$this->cmd->insert("tb_references", $column);
					unset($column);
				}
			}
			$result['status'] = true;
		}
		catch(Exception $e){
			$result['status'] = false;
			$result['err_msg'] = $e->getMessage();
		}
	
		return $result;
	}
	
	public function getCountryList(){
		$sql = "SELECT * FROM tb_country ORDER BY country_nm ASC";
		$this->cmd->text = $sql;
		$rows = $this->cmd->queryAll();
	
		return $rows;
	}
	
	public function getActivities(){
		$sql = "SELECT * FROM tb_activities WHERE mem_id=:mem_id";
		$this->cmd->text = $sql;
		$this->cmd->bindParam(':mem_id', $this->mem_id, PDO::PARAM_INT);
		$rows = $this->cmd->queryAll();
	
		return $rows;
	}
	
	public function getExpenses(){
		$sql = "SELECT * FROM tb_expenses WHERE mem_id=:mem_id";
		$this->cmd->text = $sql;
		$this->cmd->bindParam(':mem_id', $this->mem_id, PDO::PARAM_INT);
		$rows = $this->cmd->queryAll();
	
		return $rows;
	}
	
	public function getFamilies(){
		$sql = "SELECT * FROM tb_families WHERE mem_id=:mem_id";
		$this->cmd->text = $sql;
		$this->cmd->bindParam(':mem_id', $this->mem_id, PDO::PARAM_INT);
		$rows = $this->cmd->queryAll();
	
		return $rows;
	}

}
