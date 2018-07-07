<?php
class designation_model
{
	//---gets all the units from the table----
	public $table;
	public $id;
	public function __construct()
	{
		global $prefix; 
		$this -> table = $prefix."designation";
		$this -> id = "designation_id";
	}
	//---gets all the units from the table----
	function select($id = null,&$post)
	{
		$myrow = select_PluSQL($this -> table, array($this -> id => strip($id)));
		$post['name'] = $myrow -> name;
		$post['description'] = $myrow -> description;
		$post['start_salary_bracket'] = $myrow -> start_salary_bracket;
		$post['end_salary_bracket'] = $myrow -> end_salary_bracket;
		$post['curr_abrev'] = $myrow -> curr_abrev;  
	}
	//--------
	function search($name = null,$description = null, $start_salary_bracket = null,$end_salary_bracket = null,$curr_abrev = null)
	{
		global $prefix;
		return $this -> search_advanced(array(
				'name' => strip($name),
				'description' => strip($description),
				'start_salary_bracket' => strip($start_salary_bracket),
				'end_salary_bracket' => strip($end_salary_bracket),
				'curr_abrev' => array('table' => $prefix.'currencies','label' => 'curr_abrev', 'value' => $curr_abrev),
				$this -> id => ''
		));
	}
	//--------
	function search_advanced($arr)
	{
		return search_PluSQL($this -> table, $arr);
	}
	//-------- 
	function insert($name,$description,$start_salary_bracket,$end_salary_bracket,$curr_abrev)
	{
		$arr = array
				(
					'name' => strip($name),
					'description' => strip($description),
					'start_salary_bracket' => strip($start_salary_bracket),
					'end_salary_bracket' => strip($end_salary_bracket),
					'curr_abrev' => strip($curr_abrev)
				);
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
		$update = array
				(
					'name' => strip($name),
					'description' => strip($description),
					'start_salary_bracket' => strip($start_salary_bracket),
					'end_salary_bracket' => strip($end_salary_bracket),
					'curr_abrev' => strip($curr_abrev)
				);
		update_PluSQL($this -> table,$update,$this -> id,strip($id));
	}
}
?>