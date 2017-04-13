<?php
/**
 * Report Component
 * 
 * @author Shinwook
 * @since Mar 15, 2017
 */
class Report{
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
	 * 지원자 통계
	 * 
	 * @param string $where
	 * @return array
	 */
	public function getMembertotal(){
		# total member
		$sql = "SELECT COUNT(*) FROM tb_mem";
		$this->cmd->text = $sql;
		$total = $this->cmd->queryScalar();
	
		# total per category
		$sql = "SELECT a.mem_ctg, COUNT(*) AS cnt FROM tb_mem a GROUP BY a.mem_ctg";
		$this->cmd->text = $sql;
		$rows = $this->cmd->queryAll();
		foreach($rows as $row){
			$cat[$row['mem_ctg']] = $row['cnt'];
		}
	
		# total per level
		$sql = "SELECT a.mem_level, COUNT(*) AS cnt FROM tb_mem_detail a GROUP BY a.mem_level";
		$this->cmd->text = $sql;
		$rows = $this->cmd->queryAll();
		foreach($rows as $row){
			$level[$row['mem_level']] = $row['cnt'];
		}
		
		# total per level
		$sql = "
			SELECT a.mem_ctg, b.mem_level, COUNT(DISTINCT a.mem_id) AS cnt
			FROM tb_mem a
			JOIN tb_mem_detail b ON b.mem_id=a.mem_id
			GROUP BY a.mem_ctg, b.mem_level
			ORDER BY a.mem_ctg ASC
		";
		$this->cmd->text = $sql;
		$rows = $this->cmd->queryAll();
		foreach($rows as $row){
			$cl[$row['mem_ctg']][$row['mem_level']] = $row['cnt'];
		}
		return array('total'=>$total, 'categoryTotal'=>$cat, 'levelTotal'=>$level, 'cl'=>$cl);
	}
	
}
