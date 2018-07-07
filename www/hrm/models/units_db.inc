<?php
class unit_model
{
	//---gets all the units from the table----
	public $table;
	public $id;
	public function __construct()
	{
		global $prefix; 
		$this -> table = $prefix."unit";
		$this -> id = "unit_id";
	}
	function select($id = null,&$post)
	{
		$myrow =  select_PluSQL($this -> table, array($this -> id => strip($id)));
		$post['name'] = $myrow -> name; 
	}
	//--------
	function search($name = null)
	{
		return $this -> search_advanced(array('name' => strip($name),$this -> id => ''));
	}
	//--------
	function search_advanced($arr)
	{
		return search_PluSQL($this -> table, $arr);
	}
	//-------- 
	function insert($name)
	{
		$arr = array('name' => $name);
		return insert_PluSQL($this -> table,$arr,$this -> id,'name',$name);
	}
	//-----------
	function delete($id)
	{
		delete_PluSQL($this -> table,$this -> id,strip($id));
	}
	//------------
	function update($id, $name)
	{
		$update = array('name' => $name);
		update_PluSQL($this -> table,$update,$this -> id,strip($id));
	}	
}
?>