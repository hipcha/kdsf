<?php
/**
 * 신청서관련 Controller
 * 
 * @author Shinwook
 * @since Feb 11, 2017
 */
class AppController extends Controller{
	public $layout = '//frontend/layouts/base';
	private $app;
	private $mem_id;
	
	/**
	 * Constructor
	 */
	public function __construct(){		
		# session
		$this->mem_id = Yii::app()->user->getState("front_mem_id");

		$this->app = new Application();
	}
	
	public function actionSignin(){
		if($this->mem_id > 0){
			$this->redirect("/y/app/step1");
		}
		
		$this->render('/frontend/app/signIn', array(
			
		));
	}
	
	public function actionSignInComplete(){
		if(Yii::app()->request->isAjaxRequest){
			# parameter
			$email = Yii::app()->request->getParam("email");
			$pwd = Yii::app()->request->getParam("pwd");
			
			# check member
			$data = $this->app->memberInfoEmail($email);

			# check admin
			if($data['mem_id']==""){
				$result['status'] = false;
				$result['url'] = "";
				$result['err_type'] = "email";
				$result['err_msg'] = "Please check your Email.";
				
				echo json_encode($result);
				Yii::app()->end();
			}
			
			# encrypt class
			$pbkdf2 = new Pbkdf2();
			
			# 암호화된 패스워드가 일치하는지 확인
			if($pbkdf2->validate_password($pwd, $data[pwd])){
				# set session
				Yii::app()->user->setState("front_mem_id",$data[mem_id]);
				
				# cookie setting
				$cookie = new CHttpCookie('front_mem_id', $data[mem_id]);
				$cookie->expire = time()+60*60*24*180;
				Yii::app()->request->cookies['front_mem_id'] = $cookie;
				
				$result['status'] = true;
				echo json_encode($result);
			}
			else{	# error
				$result['status'] = false;
				$result['url'] = "";
				$result['err_type'] = "pwd";
				$result['err_msg'] = "Please check your password.";
				
				echo json_encode($result);
			}
		}
		else{
			throw new CHttpException(500, "Invalid Access");
		}
	}

	public function actionSignOut(){
		unset(Yii::app()->request->cookies['mem_id']);
	
		Yii::app()->user->logout();
	
		$this->redirect('/');
	}
	
	public function actionStep1(){
		if($this->mem_id > 0){
			$memInfo = $this->app->memberInfo($this->mem_id);
			
			if($memInfo['mem_ctg']==""){
				$this->redirect("/y/app/step2");
			}
			
			if($memInfo['mem_ctg']!="" && $memInfo['mem_level']==""){
				$this->redirect("/y/app/step3");
			}
		}
		
		$countryList = $this->app->getCountryList();
		
		$activityList = $this->app->getActivities();
		
		$this->render('/frontend/app/step1', array(
			'memInfo'=>$memInfo,
			'countryList'=>$countryList,
			'activityList'=>$activityList,
		));
	}
	
	public function actionStep2(){
		if($this->mem_id==""){
			$this->redirect("/y/app/step1");
		}
		else{
			$memInfo = $this->app->memberInfo($this->mem_id);
		}
		
		$this->render('/frontend/app/step2', array(
			'memInfo'=>$memInfo,
		));
	}
	
	public function actionStep3(){
		if($this->mem_id==""){
			$this->redirect("/y/app/step1");
		}
		else{
			$memInfo = $this->app->memberInfo($this->mem_id);
		
			if($memInfo['mem_ctg']==""){
				$this->redirect("/y/app/step2");
			}
		}
		
		$countryList = $this->app->getCountryList();
		
		$expenseList = $this->app->getExpenses();
		
		$familyList = $this->app->getFamilies();
		
		$this->render('/frontend/app/step3', array(
			'memInfo'=>$memInfo,
			'countryList'=>$countryList,
			'expenseList'=>$expenseList,
			'familyList'=>$familyList,
		));
	}
	
	/**
	 * Email check
	 * 
	 * @throws CHttpException
	 */
	public function actionCheckEmail(){
		if(Yii::app()->request->isAjaxRequest){
			# parameter
			$email = Yii::app()->request->getParam("email");
			$result = $this->app->checkEmail($email);
			echo json_encode($result);
		}
		else{
			throw new CHttpException(500, "Invalid Access");
		}
	}
		
	public function actionSaveStep1(){
		if(Yii::app()->request->isAjaxRequest){
			# parameter
			$app = Yii::app()->request->getParam("app");
			$dob_m = Yii::app()->request->getParam("dob_m");
			$dob_d = Yii::app()->request->getParam("dob_d");
			$dob_y = Yii::app()->request->getParam("dob_y");
			$app[dob] = $dob_m.$dob_d.$dob_y;
			$activity['place'] = Yii::app()->request->getParam("activity_place");
			$activity['from'] = Yii::app()->request->getParam("activity_from");
			$activity['to'] = Yii::app()->request->getParam("activity_to");
			$activity['contents'] = Yii::app()->request->getParam("activity_contents");
			$activity['role'] = Yii::app()->request->getParam("activity_role");
		
			$result = $this->app->saveStep1($app, $activity);
			echo json_encode($result);
		}
		else{
			throw new CHttpException(500, "Invalid Access");
		}
	}
	
	public function actionSaveStep2(){
		if(Yii::app()->request->isAjaxRequest){
			# parameter
			$mem_ctg = Yii::app()->request->getParam("mem_ctg");
	
			$result = $this->app->saveStep2($mem_ctg);
			echo json_encode($result);
		}
		else{
			throw new CHttpException(500, "Invalid Access");
		}
	}

	public function actionSaveStep3(){
		$memberDetail = $this->app->memberDetail($this->mem_id);
		
		# parameter
		$app = Yii::app()->request->getParam("app");
		$family['family_name'] = Yii::app()->request->getParam("family_name");
		$family['family_relationship'] = Yii::app()->request->getParam("family_relationship");
		$family['family_age'] = Yii::app()->request->getParam("family_age");
		$family['family_occupation'] = Yii::app()->request->getParam("family_occupation");
		$family['family_remark'] = Yii::app()->request->getParam("family_remark");
		$family['family_together'] = Yii::app()->request->getParam("family_together");
		$family['family_marital'] = Yii::app()->request->getParam("family_marital");
		$expense['expense_type'] = Yii::app()->request->getParam("expense_type");
		$expense['expense_paidby'] = Yii::app()->request->getParam("expense_paidby");
		$expense['expense_amt'] = Yii::app()->request->getParam("expense_amt");
		$ref['ref_name'] = Yii::app()->request->getParam("ref_name");
		$ref['ref_addr'] = Yii::app()->request->getParam("ref_addr");
		$ref['ref_relation'] = Yii::app()->request->getParam("ref_relation");
		$ref['ref_email'] = Yii::app()->request->getParam("ref_email");
		$ref['ref_tel_no'] = Yii::app()->request->getParam("ref_tel_no");
		$ref['ref_work_employer'] = Yii::app()->request->getParam("ref_work_employer");
		$ref['ref_work_addr'] = Yii::app()->request->getParam("ref_work_addr");
		$ref['ref_work_position'] = Yii::app()->request->getParam("ref_work_position");
		
		# 업로드 기본 경로
		$root_path = "/y/files/".$this->mem_id."/";
		$base_path = $_SERVER["DOCUMENT_ROOT"].$root_path;
		
		# 디렉토리 생성
		if(!is_dir($base_path)){
			mkdir($base_path);
			chmod($base_path, 0777);
		}
		
		if($_FILES["file_grade"]["tmp_name"]){
			$extension = pathinfo($_FILES["file_grade"]["name"],PATHINFO_EXTENSION);
			$file_name = "file_grade.".$extension;
			$file_path = $base_path.$file_name;
			$app[file_grade] = $root_path.$file_name;
			move_uploaded_file($_FILES["file_grade"]["tmp_name"], $file_path);
		}else{
			$app[file_grade] = $memberDetail[file_grade];
		}
		
		if($_FILES["file_income"]["tmp_name"]){
			$extension = pathinfo($_FILES["file_income"]["name"],PATHINFO_EXTENSION);
			$file_name = "file_income.".$extension;
			$file_path = $base_path."/".$file_name;
			$app[file_income] = $root_path.$file_name;
			move_uploaded_file($_FILES["file_income"]["tmp_name"], $file_path);
		}else{
			$app[file_income] = $memberDetail[file_income];
		}
		
		if($_FILES["file_missionary_expedition"]["tmp_name"]){
			$extension = pathinfo($_FILES["file_missionary_expedition"]["name"],PATHINFO_EXTENSION);
			$file_name = "file_missionary_expedition.".$extension;
			$file_path = $base_path."/".$file_name;
			$app[file_missionary_expedition] = $root_path.$file_name;
			move_uploaded_file($_FILES["file_missionary_expedition"]["tmp_name"], $file_path);
		}else{
			$app[file_missionary_expedition] = $memberDetail[file_missionary_expedition];
		}
		
		if($_FILES["file_missionary_introduction"]["tmp_name"]){
			$extension = pathinfo($_FILES["file_missionary_introduction"]["name"],PATHINFO_EXTENSION);
			$file_name = "file_missionary_introduction.".$extension;
			$file_path = $base_path."/".$file_name;
			$app[file_missionary_introduction] = $root_path.$file_name;
			move_uploaded_file($_FILES["file_missionary_introduction"]["tmp_name"], $file_path);
		}else{
			$app[file_missionary_introduction] = $memberDetail[file_missionary_introduction];
		}
		
		if($_FILES["file_church_affiliation"]["tmp_name"]){
			$extension = pathinfo($_FILES["file_church_affiliation"]["name"],PATHINFO_EXTENSION);
			$file_name = "file_church_affiliation.".$extension;
			$file_path = $base_path."/".$file_name;
			$app[file_church_affiliation] = $root_path.$file_name;
			move_uploaded_file($_FILES["file_church_affiliation"]["tmp_name"], $file_path);
		}else{
			$app[file_church_affiliation] = $memberDetail[file_church_affiliation];
		}
		
		if($_FILES["file_theology_degree"]["tmp_name"]){
			$extension = pathinfo($_FILES["file_theology_degree"]["name"],PATHINFO_EXTENSION);
			$file_name = "file_theology_degree.".$extension;
			$file_path = $base_path."/".$file_name;
			$app[file_theology_degree] = $root_path.$file_name;
			move_uploaded_file($_FILES["file_theology_degree"]["tmp_name"], $file_path);
		}else{
			$app[file_theology_degree] = $memberDetail[file_theology_degree];
		}
		
		if($_FILES["file_church_news"]["tmp_name"]){
			$extension = pathinfo($_FILES["file_church_news"]["name"],PATHINFO_EXTENSION);
			$file_name = "file_church_news.".$extension;
			$file_path = $base_path."/".$file_name;
			$app[file_church_news] = $root_path.$file_name;
			move_uploaded_file($_FILES["file_church_news"]["tmp_name"], $file_path);
		}else{
			$app[file_church_news] = $memberDetail[file_church_news];
		}
		
		if($_FILES["file_church_budget"]["tmp_name"]){
			$extension = pathinfo($_FILES["file_church_budget"]["name"],PATHINFO_EXTENSION);
			$file_name = "file_church_budget.".$extension;
			$file_path = $base_path."/".$file_name;
			$app[file_church_budget] = $root_path.$file_name;
			move_uploaded_file($_FILES["file_church_budget"]["tmp_name"], $file_path);
		}else{
			$app[file_church_budget] = $memberDetail[file_church_budget];
		}
		
		if($_FILES["file_tuition_bill"]["tmp_name"]){
			$extension = pathinfo($_FILES["file_tuition_bill"]["name"],PATHINFO_EXTENSION);
			$file_name = "file_tuition_bill.".$extension;
			$file_path = $base_path."/".$file_name;
			$app[file_tuition_bill] = $root_path.$file_name;
			move_uploaded_file($_FILES["file_tuition_bill"]["tmp_name"], $file_path);
		}else{
			$app[file_tuition_bill] = $memberDetail[file_tuition_bill];
		}
		
		if($_FILES["file_missionary_recommendation"]["tmp_name"]){
			$extension = pathinfo($_FILES["file_missionary_recommendation"]["name"],PATHINFO_EXTENSION);
			$file_name = "file_missionary_recommendation.".$extension;
			$file_path = $base_path."/".$file_name;
			$app[file_missionary_recommendation] = $root_path.$file_name;
			move_uploaded_file($_FILES["file_missionary_recommendation"]["tmp_name"], $file_path);
		}else{
			$app[file_missionary_recommendation] = $memberDetail[file_missionary_recommendation];
		}
		
		$result = $this->app->saveStep3($app, $family, $expense, $ref);
		
		echo "<script>alert('Your Application has been submitted.');window.location.href='/';</script>";
	}
	
	
	public function actionTest(){
		$this->render('/frontend/email_templates/signup', array(
					
		));		
	}
	
	public function actionMail(){
		$to = "hipcha@naver.com";
		$subject = "This is a test2";
		$message = "Hi!  This is a test 2.";
		$from = "admin@kdsfimsi.sarang.com";
		$headers = "From:" . $from;
		mail($to,$subject,$message,$headers);
		echo "Mail Sent.";
		
		/*
		$to      = 'hipcha@gmail.com';
		$subject = 'the subject';
		$message = 'hello';
		$headers = 'From: admin@kdsfimsi.sarang.com' . "\r\n" .
		    'Reply-To: admin@kdsfimsi.sarang.com' . "\r\n" .
		    'X-Mailer: PHP/' . phpversion();
		
		$a = mail($to, $subject, $message, $headers);
		echo $a;
		*/
	}
}
