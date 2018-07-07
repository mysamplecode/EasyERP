<?php
class deduction_model
{
	//---gets all the units from the table----
	public $table;
	public $id;
	public function __construct()
	{
		global $prefix; 
		$this -> table = $prefix."deduction";
		$this -> id = "deduction_id";
	}
	//---gets all the units from the table----
	function select($id = null)
	{
		$myrow =  select_PluSQL($this -> table, array($this -> id => strip($id)));
		$_POST['name'] = $myrow -> name;
		$_POST['description'] = $myrow -> description;
		$_POST['type'] = $myrow -> type;
	}
	//--------
	function search($name = null,$description = null,$type = null)
	{
		global $prefix;
		return $this -> search_advanced(array(
				'name' => strip($name),
				'description' => strip($description),
				'type' => $type,
				$this -> id => ''
		));
	}
	//--------
	function search_advanced($arr)
	{
		return search_PluSQL($this -> table, $arr);
	}
	//-------- 
	function insert($name,$description,$type)
	{
		$arr = array
				(
					'name' => strip($name),
					'description' => strip($description),
					'type' => strip($type)
				);
		return insert_PluSQL($this -> table,$arr,$this -> id,'name',$name);
	}
	//-----------
	function delete($id)
	{
		delete_PluSQL($this -> table,$this -> id,strip($id));
	}
	//------------
	function update($id,$name,$description,$type)
	{
		$update = array
				(
					'name' => strip($name),
					'description' => strip($description),
					'type' => strip($type)
				);
		update_PluSQL($this -> table,$update,$this -> id,strip($id));
	}
}
?>