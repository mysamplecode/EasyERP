<?php
class leave_model
{
	//---gets all the units from the table----
	public $table;
	public $id;
	public function __construct()
	{
		global $prefix; 
		$this -> table = $prefix."leave";
		$this -> id = "leave_id";
	}
	//---gets all the units from the table----
	function select($id = null)
	{
		return select_PluSQL($this -> table, array($this -> id => strip($id)));
	}
	//--------
	function search($name = null,$description = null, $min_leaves = null, $max_leaves = null)
	{
		global $prefix;
		return $this -> search_advanced(array(
				'name' => strip($name),
				'description' => strip($description),
				'minimum_leaves' => strip($min_leaves),
				'maximum_leaves' => strip($max_leaves),
				$this -> id => ''
		));
	}
	//--------
	function search_advanced($arr,$args = array())
	{
		return search_PluSQL($this -> table, $arr,$args);
	}
	//-------- 
	function insert($name,$description,$min_leaves,$max_leaves)
	{
		$arr = array(
			'name' => strip($name),
			'description' => strip($description),
			'minimum_leaves' => strip($min_leaves),
			'maximum_leaves' => strip($max_leaves),
		);
		return insert_PluSQL($this -> table,$arr,$this -> id,'name',$name);
	}
	//-----------
	function delete($id)
	{
		delete_PluSQL($this -> table,$this -> id,strip($id));
	}
	//------------
	function update($id,$name,$description,$min_leaves,$max_leaves)
	{
		$update = array(
			'name' => strip($name),
			'description' => strip($description),
			'minimum_leaves' => strip($min_leaves),
			'maximum_leaves' => strip($max_leaves),
		);
		update_PluSQL($this -> table,$update,$this -> id,strip($id));
	}
}
?>