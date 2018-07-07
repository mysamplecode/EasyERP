<?php
class employee_qualification_model
{
	//---gets all the units from the table----
	public $table;
	public $id;
	public function __construct()
	{
		global $prefix; 
		$this -> table = $prefix."employee_qualification";
		$this -> id = "employee_qualification_id";
	}
	//---gets all the units from the table----
	function select($selected_id = null,$id = null,&$post)
	{
		$myrow = select_PluSQL($this -> table, array($this -> id => strip($id),'employee_id' => $selected_id));
		$post['degree'] = $myrow -> degree;
		$post['university_name'] = $myrow -> university_name;
		$post['university_address'] = $myrow -> university_address;
		$post['degree_start_year'] = convert_MYSQL_to_FA($myrow -> degree_start_year);
		$post['degree_end_year'] = convert_MYSQL_to_FA($myrow -> degree_end_year);
		$post['total_marks'] = $myrow -> total_marks;
		$post['marks_obtained'] = $myrow -> marks_obtained;
		$post['grade'] = $myrow -> grade;
		$post['degree_majors'] = $myrow -> degree_majors;
		
	}
	//--------
	function search($selected_id)
	{
		global $prefix;
		$args = array();
		return $this -> search_advanced(array(
				'degree' => '',
				'university_name' => '',
				'degree_start_year' => '',
				'degree_end_year' => '',
				'marks_obtained' => '',
				'total_marks' => '',
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
			'degree' => $post['degree'],
			'university_name' => $post['university_name'],
			'university_address' => $post['university_address'],
			'degree_start_year' => convert_FA_to_MYSQL($post['degree_start_year']),
			'degree_end_year' => convert_FA_to_MYSQL($post['degree_end_year']),
			'total_marks' => $post['total_marks'],
			'marks_obtained' => $post['marks_obtained'],
			'grade' => $post['grade'],
			'degree_majors' => $post['degree_majors']
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
			'degree' => $post['degree'],
			'university_name' => $post['university_name'],
			'university_address' => $post['university_address'],
			'degree_start_year' => convert_FA_to_MYSQL($post['degree_start_year']),
			'degree_end_year' => convert_FA_to_MYSQL($post['degree_end_year']),
			'total_marks' => $post['total_marks'],
			'marks_obtained' => $post['marks_obtained'],
			'grade' => $post['grade'],
			'degree_majors' => $post['degree_majors'] 
		);
		update_PluSQL($this -> table,$update,$this -> id,strip($id));
	}
}

?>