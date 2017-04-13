<?php
/**
 * Admin Component
 * 
 * @author Shinwook
 * @since Mar 15, 2017
 */
class Admin{
	private $cmd;
	private $mem_id;
	
	/**
	 * Constructor
	 */
	public function __construct(){
		$this->cmd = Yii::app()->db->createCommand();
		
		# login memid
		$this->mem_id = Yii::app()->user->getState("mem_id");
	}
	
	/**
	 * 창고 리스트
	 * 
	 * @param string $where
	 * @return array
	 */
	public function getWhList($where=''){
		$sql = "SELECT tw.*, tc.country_nm FROM tb_warehouse tw LEFT JOIN tb_country tc ON tc.country_cd=tw.country_cd WHERE tw.is_use=1 ".$where." ORDER BY tw.sort_by ASC";
		$this->cmd->text = $sql;
		$rows = $this->cmd->queryAll();
	
		return $rows;
	}
	
	/**
	 * 창고 정보
	 *
	 * @param string $where
	 * @return array
	 */
	public function getWhInfo($where=''){
		$sql = "SELECT * FROM tb_warehouse WHERE is_use=1 ".$where;
		$this->cmd->text = $sql;
		$row = $this->cmd->queryRow();
	
		return $row;
	}
	
	/**
	 * 관리자 정보
	 * 
	 * @param string $where
	 * @return array
	 */
	public function getAdminInfo($where){
		$sql = "
			SELECT tm.*, ta.*, tw.country_cd, tw.time_diff
			FROM tb_mem tm 
			LEFT JOIN tb_admin ta ON ta.mem_id=tm.mem_id 
			LEFT JOIN tb_warehouse tw ON tw.warehouse_cd=ta.warehouse_cd
			WHERE ta.status_cd='A' ".$where."
		";
		$this->cmd->text = $sql;
		$row = $this->cmd->queryRow();
	
		return $row;
	}
	
	/**
	 * 관리자 리스트
	 * 
	 * @param string $where
	 * @return array
	 */
	public function getAdminList($where){
		$sql = "
			SELECT tm.*, ta.*, tug.admin_grp_nm
			FROM tb_mem tm 
			LEFT JOIN tb_admin ta ON ta.mem_id=tm.mem_id 
			LEFT JOIN tb_admin_grp tug ON tug.admin_grp_cd=ta.admin_grp_cd
			WHERE ta.status_cd='A' ".$where."
			ORDER BY tm.mem_nm ASC
		";
		$this->cmd->text = $sql;
		$rows = $this->cmd->queryAll();
	
		return $rows;
	}
	
	/**
	 * 메뉴 리스트
	 * 
	 * @param string $where
	 * @return array
	 */
	public function getMenuList($where){
		$sql = "SELECT * FROM tb_menu WHERE 1=1 ".$where." ORDER BY upper_menu_cd ASC, sort_by ASC";
		$this->cmd->text = $sql;
		$rows = $this->cmd->queryAll();
	
		return $rows;
	}
	
	/**
	 * 메뉴 정보
	 * 
	 * @param string $where
	 * @return array
	 */
	public function getMenuInfo($where){
		$sql = "SELECT * FROM tb_menu WHERE 1=1 ".$where."";
		$this->cmd->text = $sql;
		$row = $this->cmd->queryRow();
	
		return $row;
	}
	
	/**
	 * 현재 메뉴 권한 리스트
	 * 
	 * @param string $where
	 * @return array
	 */
	public function getMenuAuthority($where){
		$sql = "
			SELECT tma.*, tm.path
			FROM tb_menu_authority tma
			LEFT JOIN tb_menu tm ON tma.menu_cd=tm.menu_cd 
			WHERE 1=1 ".$where." 
			ORDER BY tma.menu_cd ASC
		";
		$this->cmd->text = $sql;
		$rows = $this->cmd->queryAll();
	
		return $rows;
	}
	
	/**
	 * 그룹 메뉴 권한 리스트
	 *
	 * @param string $where
	 * @return array
	 */
	public function getGroupMenuAuthority($where){
		$sql = "
			SELECT tma.*
			FROM tb_admin_grp_menu tma
			LEFT JOIN tb_menu tm ON tma.menu_cd=tm.menu_cd
			WHERE 1=1 ".$where."
			ORDER BY tma.menu_cd ASC
		";
		$this->cmd->text = $sql;
		$rows = $this->cmd->queryAll();
	
		return $rows;
	}
	
	/**
	 * 메뉴 권한 저장
	 * 
	 * @param integer $s_mode
	 * @param integer $obj_id
	 * @param string $menu_cds
	 * @return array
	 */
	public function setMenuAuthority($s_mode,$obj_id,$menu_cds){
		$transaction = Yii::app()->db->beginTransaction();
		
		try{
			if($s_mode==0){	# 관리자
				# 기존 권한 삭제
				$this->cmd->delete("tb_menu_authority", "mem_id=:mem_id", array(":mem_id"=>$obj_id));
			
				# 메뉴 권한 등록
				$aMenuCds = explode(",", $menu_cds);
				for($i=0;$i<count($aMenuCds);$i++){
					$menu_cd = $aMenuCds[$i];
					$columns = array(
						"mem_id" => $obj_id,
						"menu_cd" => $menu_cd,
						"ins_mem_id" => $this->mem_id,
						"upd_mem_id" => $this->mem_id,
						"upd_dtime" => new CDbExpression('NOW()'),
					);
					$this->cmd->insert("tb_menu_authority", $columns);
				}
			}
			else{	# 그룹
				# 기존 권한 삭제
				$this->cmd->delete("tb_admin_grp_menu", "admin_grp_cd=:admin_grp_cd", array(":admin_grp_cd"=>$obj_id));
					
				# 메뉴 권한 등록
				$aMenuCds = explode(",", $menu_cds);
				for($i=0;$i<count($aMenuCds);$i++){
					$menu_cd = $aMenuCds[$i];
					$columns = array(
						"admin_grp_cd" => $obj_id,
						"menu_cd" => $menu_cd,
						"warehouse_cd" => $this->warehouse_cd,
						"ins_mem_id" => $this->mem_id,
						"upd_mem_id" => $this->mem_id,
						"upd_dtime" => new CDbExpression('NOW()'),
					);
					$this->cmd->insert("tb_admin_grp_menu", $columns);
				}
			}
			unset($columns);
			
			$transaction->commit();
			
			$result['status'] = true;
		}
		catch(Exception $e){
			$transaction->rollback();
			
			$result['status'] = false;
			$result['err_msg'] = $e->getMessage();
		}
		
		return $result;
	}	
	
	/**
	 * 에러 기록
	 */
	public function writeErrorLog($err_msg, $referrer=''){
		$mem_id = Yii::app()->user->getState("mem_id_front")=="" ? Yii::app()->user->getState("mem_id") : Yii::app()->user->getState("mem_id_front");
	
		# 제외할 URI
		$aExceptUri = array(
			'js/jquery.number.min.js.map',
			'favicon.ico',
			'call_time_location.php',
			'help/news.php',
			'robots.txt',
			'browserconfig.xml',
		);
	
		# 제외할 확장자
		$aExceptExt = array(
			'png',
			'jpg',
			'gif',
			'css',
			'.js',
		);
	
		if(!in_array(Yii::app()->request->getPathInfo(), $aExceptUri)
			&& Yii::app()->request->getPathInfo()!=""
			&& !in_array(strtolower(substr(Yii::app()->request->getPathInfo(),-3)), $aExceptExt)){
				
			$columns[error] = $err_msg;
			$columns[uri] = Yii::app()->request->getPathInfo();
			$columns[ip] = $_SERVER[REMOTE_ADDR];
			$columns[referrer] = $referrer;
			$columns[ins_mem_id] = $mem_id;
			$this->cmd->insert("tb_error_log", $columns);
		}
	}
	
	public function getMemberList($andWhere=''){
		//$sql = "SELECT * FROM tb_mem a WHERE a.is_admin=0 ORDER BY a.ins_dtime DESC";
		$sql = "
			SELECT a.*, b.mem_level
			FROM tb_mem a
			JOIN tb_mem_detail b ON b.mem_id=a.mem_id 
			WHERE 1=1 
			  ".$andWhere." 
			ORDER BY a.ins_dtime DESC
		";
		$this->cmd->text = $sql;
		$rows = $this->cmd->queryAll();
	
		return $rows;
	}
	
}
