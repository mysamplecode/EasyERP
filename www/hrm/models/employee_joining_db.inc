<?php
class employee_joining_model
{
	//---gets all the units from the table----
	public $table;
	public $id;
	public function __construct()
	{
		global $prefix; 
		$this -> table = $prefix."employee_joining";
		$this -> id = "employee_joining_id";
	}
	//---gets all the units from the table----
	function select($selected_id = null,$id = null,&$post)
	{
		$myrow = select_PluSQL($this -> table, array($this -> id => strip($id),'employee_id' => $selected_id));
		$post['last_organization'] = $myrow -> last_organization;
		$post['last_salary'] = $myrow -> last_salary;
		$post['joining_start_date'] = convert_MYSQL_to_FA($myrow -> joining_start_date);
		$post['joining_end_date'] = convert_MYSQL_to_FA($myrow -> joining_end_date);
		$post['reason_for_leaving'] = $myrow -> reason_for_leaving;
	}
	//--------
	function search($selected_id)
	{
		global $prefix;
		$args = array();
		return $this -> search_advanced(array(
				'last_organization' => '',
				'last_salary' => '',
				'joining_start_date' => '',
				'joining_end_date' => '',
				'employee_id' => array('table' => $prefix.'employee','label' => 'employee_id', 'value' => $selected_id),
				$this -> id => ''
		),$args);
	}
	//--------
	function search_advanced($arr,$args = array())
	{
		return search_PluSQL($this -> table, $arr,$args);
	}
	//-------- 
	function insert($employee_id,$post)
	{
		$arr = array
		(
			'employee_id' => $employee_id,
			'last_organization' => $post['last_organization'],
			'last_salary' => $post['last_salary'],
			'joining_start_date' => convert_FA_to_MYSQL($post['joining_start_date']),
			'joining_end_date' => convert_FA_to_MYSQL($post['joining_end_date']), 
		);
		$conds = array
		(
		);	
		return insert_advanced_PluSQL($this -> table,$arr,$this -> id,$conds);
	}
	//-----------
	function delete($id)
	{
		delete_PluSQL($this -> table,$this -> id,strip($id));
	}
	//------------
	function update($employee_id,$post)
	{
		$update = array
		(
			'employee_id' => $employee_id,
			'last_organization' => $post['last_organization'],
			'last_salary' => $post['last_salary'],
			'joining_start_date' => convert_FA_to_MYSQL($post['joining_start_date']),
			'joining_end_date' => convert_FA_to_MYSQL($post['joining_end_date']), 
		);
		update_PluSQL($this -> table,$update,$this -> id,strip($id));
	}
}

?>