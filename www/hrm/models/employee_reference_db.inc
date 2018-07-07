<?php
class employee_reference_model
{
	//---gets all the units from the table----
	public $table;
	public $id;
	public function __construct()
	{
		global $prefix; 
		$this -> table = $prefix."employee_reference";
		$this -> id = "employee_reference_id";
	}
	//---gets all the units from the table----
	function select($selected_id = null,$id = null,&$post)
	{
		$myrow = select_PluSQL($this -> table, array($this -> id => strip($id),'employee_id' => $selected_id));
		$post['reference_name'] = $myrow -> reference_name;
		$post['reference_address'] = $myrow -> reference_address;
		$post['contact_number'] = $myrow -> contact_number;
		$post['know_since_date'] = convert_MYSQL_to_FA($myrow -> know_since_date);
	}
	//--------
	function search($selected_id)
	{
		global $prefix;
		$args = array();
		return $this -> search_advanced(array(
				'reference_name' => '',
				'contact_number' => '',
				'know_since_date' => '',
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
			'reference_name' => $post['reference_name'],
			'reference_address' => $post['reference_address'],
			'contact_number' => $post['contact_number'],
			'know_since_date' => convert_FA_to_MYSQL($post['know_since_date'])
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
			'reference_name' => $post['reference_name'],
			'reference_address' => $post['reference_address'],
			'contact_number' => $post['contact_number'],
			'know_since_date' => convert_FA_to_MYSQL($post['know_since_date']) 
		);
		update_PluSQL($this -> table,$update,$this -> id,strip($id));
	}
}
?>