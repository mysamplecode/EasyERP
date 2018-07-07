<?php
class holiday_model
{
	//---gets all the units from the table----
	public $table;
	public $id;
	public function __construct()
	{
		global $prefix; 
		$this -> table = $prefix."holiday";
		$this -> id = "holiday_id";
	}
	//---gets all the units from the table----
	function select($id = null)
	{
		$myrow =  select_PluSQL($this -> table, array($this -> id => strip($id)));
		$_POST['name'] = $myrow -> name;
		$_POST['description'] = $myrow -> description;
		$_POST['start_holiday'] = convert_MYSQL_to_FA($myrow -> start_holiday);
		$_POST['end_holiday'] = convert_MYSQL_to_FA($myrow -> end_holiday);
		$_POST['fiscal_year_id'] = $myrow -> fiscal_year_id;
	}
	//--------
	function search($name = null,$description = null,$fiscal_year_id = null)
	{
		global $prefix;
		return $this -> search_advanced(array(
				'name' => strip($name),
				'description' => strip($description),
				'start_holiday' => '',
				'end_holiday' => '',
				'fiscal_begin' => array('table' => $prefix.'fiscal_year','label' => 'begin', 'value' => ''),
				'fiscal_end' => array('table' => $prefix.'fiscal_year','label' => 'end', 'value' => ''),
				'fiscal_id' => array('table' => $prefix.'fiscal_year','label' => 'fiscal_year_id', 'value' => $fiscal_year_id),
				$this -> id => ''
		));
	}
	//--------
	function search_advanced($arr,$args = array())
	{
		return search_PluSQL($this -> table, $arr,$args);
	}
	//-------- 
	function insert($name,$description, $start_holiday,$end_holiday,$fiscal_year)
	{
		$start_holiday = convert_FA_to_MYSQL($start_holiday);
		$end_holiday = convert_FA_to_MYSQL($end_holiday);
		$arr = array
				(
					'name' => strip($name),
					'description' => strip($description),
					'start_holiday' => strip($start_holiday),
					'end_holiday' => strip($end_holiday),
					'fiscal_year_id' => strip($fiscal_year)
				);
		return insert_PluSQL($this -> table,$arr,$this -> id,'name',$name);
	}
	//-----------
	function delete($id)
	{
		delete_PluSQL($this -> table,$this -> id,strip($id));
	}
	//------------
	function update($id,$name,$description, $start_holiday,$end_holiday,$fiscal_year)
	{
		$start_holiday = convert_FA_to_MYSQL($start_holiday);
		$end_holiday = convert_FA_to_MYSQL($end_holiday);
		$update = array
				(
					'name' => strip($name),
					'description' => strip($description),
					'start_holiday' => strip($start_holiday),
					'end_holiday' => strip($end_holiday),
					'fiscal_year_id' => strip($fiscal_year)	
				);
		update_PluSQL($this -> table,$update,$this -> id,strip($id));
	}
}
?>