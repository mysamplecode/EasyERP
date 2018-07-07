<?php
 class employee_status_model
{
	//---gets all the units from the table----
	public $table;
	public $id;
	const PRIVATE_CODES_START = 1; //inclusive
	const PRIVATE_CODES_END = 4; //inclusive
	const ON_PROBATION = 1;
	const CONFIRMED = 2;
	const RESIGNED = 3;
	const TERMINATED = 4;
	public function __construct()
	{
		global $prefix; 
		$this -> table = $prefix."employee_status";
		$this -> id = "employee_status_id";
	}
	//---gets all the units from the table----
	function select($id = null, &$post)
	{
		$myrow =  select_PluSQL($this -> table, array($this -> id => strip($id)));
		$post['name'] = $myrow -> name;
	}
	//--------
	function search($name = null)
	{
		global $prefix;
		return $this -> search_advanced(array(
				'name' => strip($name),
				$this -> id => ''
		));
	}
	//--------
	function search_advanced($arr)
	{
		return search_PluSQL($this -> table, $arr);
	}
	//-------- 
	function insert($post)
	{
		$arr = array
				(
					'name' => strip($post['name'])
				);
		return insert_PluSQL($this -> table,$arr,$this -> id,'name',$name);
	}
	//-----------
	function delete($id)
	{
		if($id >= self::PRIVATE_CODES_START && $id <= self::PRIVATE_CODES_END)
		{
			display_warning("Cannot delete this entry", true);
			return;
		}
		delete_PluSQL($this -> table,$this -> id,strip($id));
	}
	//------------
	function update($id,$post)
	{
		if($id >= self::PRIVATE_CODES_START && $id <= self::PRIVATE_CODES_END)
		{
			display_warning("Cannot update this entry", true);
			return;
		}
		$update = array
				(
					'name' => strip($post['name'])
				);
		update_PluSQL($this -> table,$update,$this -> id,strip($id));
	}
}
?>