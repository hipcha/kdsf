<?php
/**
 * Report Controller
 * 
 * @author Shinwook
 * @since Mar 15, 2017
 */
class ReportController extends Controller{
	public $layout = '//backoffice/layouts/base';
	private $report;
	private $mem_id;
	private $app;
	
	/**
	 * Constructor
	 */
	public function __construct(){
		$this->report = new Report();
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
	 * Member List
	 */
	public function actionMemberStat(){
		$total = $this->report->getMembertotal();
	
		$this->render('/backoffice/report/memberStat', array(
			'total' => $total,
		));
	}
	
}
