<?php
class department_model
{
	//---gets all the units from the table----
	public $table;
	public $id;
	public function __construct()
	{
		global $prefix; 
		$this -> table = $prefix."department";
		$this -> id = "department_id";
	}
	//---gets all the units from the table----
	function select($id = null, &$post)
	{
		$myrow = select_PluSQL($this -> table, array($this -> id => strip($id)));
		$post['name'] = $myrow -> name;
		$post['strength'] = $myrow -> strength;
		$post['unit_id'] = $myrow -> unit_id; 
	}
	//--------
	function search($name = null,$strength = null, $unit_id = null)
	{
		global $prefix;
		return $this -> search_advanced(array(
				'name' => strip($name),
				'strength' => strip($strength),
				'unit_id' => array('table' => $prefix.'unit','label' => 'name', 'value' => $unit_id),
				$this -> id => ''
		));
	}
	//--------
	function search_advanced($arr)
	{
		return search_PluSQL($this -> table, $arr);
	}
	//-------- 
	function insert($name,$strength,$unit_id)
	{
		$arr = array('name' => $name,'strength' => $strength, 'unit_id' => $unit_id);
		return insert_PluSQL($this -> table,$arr,$this -> id,'name',$name);
	}
	//-----------
	function delete($id)
	{
		delete_PluSQL($this -> table,$this -> id,strip($id));
	}
	//------------
	function update($id,$name,$strength,$unit_id)
	{
		$update = array('name' => $name,'strength' => $strength, 'unit_id' => $unit_id);
		update_PluSQL($this -> table,$update,$this -> id,strip($id));
	}
}
?>