<?php
class employee_deduction_model
{
	//---gets all the units from the table----
	public $table;
	public $id;
	public function __construct()
	{
		global $prefix; 
		$this -> table = $prefix."employee_deduction";
		$this -> id = "employee_deduction_id";
	}
	//---gets all the units from the table----
	function select($selected_id = null,$id = null,&$post)
	{
		$myrow = select_PluSQL($this -> table, array($this -> id => strip($id),'employee_id' => $selected_id));
		$post['deduction_id'] = $myrow -> deduction_id;
		$post['deduction_amount'] = $myrow -> deduction_amount; 
	}
	//--------
	function search($selected_id)
	{
		global $prefix;
		$args = array('enable_where' => 1);
		return $this -> search_advanced(array(
				'deduction_id' => array('table' => $prefix.'deduction','label' => 'name', 'value' => ''),
				'deduction_amount' => '',
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
			'deduction_id' => $post['deduction_id'],
			'deduction_amount' => $post['deduction_amount'] 
		);
		$conds = array
		(
			'employee_id' => $employee_id,
			'deduction_id' => $post['deduction_id']
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
			'deduction_id' => $post['deduction_id'],
			'deduction_amount' => $post['deduction_amount'] 
		);
		update_PluSQL($this -> table,$update,$this -> id,strip($id));
	}
}

?>