<?php
class employee_dependent_model
{
	//---gets all the units from the table----
	public $table;
	public $id;
	public function __construct()
	{
		global $prefix; 
		$this -> table = $prefix."employee_dependent";
		$this -> id = "employee_dependent_id";
	}
	//---gets all the units from the table----
	function select($selected_id = null,$id = null,&$post)
	{
		$myrow = select_PluSQL($this -> table, array($this -> id => strip($id),'employee_id' => $selected_id));
		$post['dependent_name'] = $myrow -> dependent_name;
		$post['dependent_relation'] = $myrow -> dependent_relation;
		$post['dependent_date_of_birth'] = convert_MYSQL_to_FA($myrow -> dependent_date_of_birth);
		$post['dependent_occupation'] = $myrow -> dependent_occupation;
	}
	//--------
	function search($selected_id)
	{
		global $prefix;
		$args = array();
		return $this -> search_advanced(array(
				'dependent_name' => '',
				'dependent_relation' => '',
				'dependent_date_of_birth' => '',
				'dependent_occupation' => '',
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
			'dependent_name' => $post['dependent_name'],
			'dependent_relation' => $post['dependent_relation'],
			'dependent_date_of_birth' => convert_FA_to_MYSQL($post['dependent_date_of_birth']),
			'dependent_occupation' => $post['dependent_occupation']
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
			'dependent_name' => $post['dependent_name'],
			'dependent_relation' => $post['dependent_relation'],
			'dependent_date_of_birth' => convert_FA_to_MYSQL($post['dependent_date_of_birth']),
			'dependent_occupation' => $post['dependent_occupation'] 
		);
		update_PluSQL($this -> table,$update,$this -> id,strip($id));
	}
}
?>