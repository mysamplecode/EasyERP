<?php
class shift_model
{
	//---gets all the units from the table----
	public $table;
	public $id;
	public function __construct()
	{
		global $prefix; 
		$this -> table = $prefix."shift";
		$this -> id = "shift_id";
	}
	//---gets all the units from the table----
	function select($id = null,&$post)
	{
		try 
		{
			$myrow =  select_PluSQL($this -> table, array($this -> id => strip($id)));
			$post['shift_id'] = $myrow -> shift_id;
                        $post['name'] = $myrow -> name;
			$post['description'] = $myrow -> description;
			$post['standard_shift_start'] = $myrow -> standard_shift_start;
			$post['standard_shift_end'] = $myrow -> standard_shift_end;
			$post['standard_relax_start'] = $myrow -> standard_relax_start;
			$post['standard_relax_end'] = $myrow -> standard_relax_end;
			
			$post['rotation_flag'] = $myrow -> rotation_flag;
			$post['rotation_interval'] = $myrow -> rotation_interval;
			
			$post['rotation_shift_start'] = $myrow -> rotation_shift_start;
			$post['rotation_shift_end'] = $myrow -> rotation_shift_end;
			$post['rotation_relax_start'] = $myrow -> rotation_relax_start;
			$post['rotation_relax_end'] = $myrow -> rotation_relax_end;
			return true;			
		}
		catch (EmptySetException $e)
		{
			return false;
		}
	}
	//--------
	function search($name = null,$description = null,$fiscal_year_id = null)
	{
		global $prefix;
		return $this -> search_advanced(array(
				'name' => strip($name),
				'description' => strip($description),
				'standard_shift_start' => '',
				'standard_shift_end' => '',
				'standard_relax_start' => '',
				'standard_relax_end' => '',
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
					'name' => ($post['name']),
					'description' => ($post['description']),
					'standard_shift_start' => ($post['standard_shift_start']),
					'standard_shift_end' => ($post['standard_shift_end']),
					'standard_relax_start' => ($post['standard_relax_start']),
					'standard_relax_end' => ($post['standard_relax_end']),
					'rotation_flag' => (@$post['rotation_flag']),
					'rotation_interval' => (@$post['rotation_interval']),
					'rotation_shift_start' => (@$post['rotation_shift_start']),
					'rotation_shift_end' => (@$post['rotation_shift_end']),
					'rotation_relax_start' => (@$post['rotation_relax_start']),
					'rotation_relax_end' => (@$post['rotation_relax_end']),
				);
		return insert_PluSQL($this -> table,$arr,$this -> id,'name',$post['name']);
	}
	//-----------
	function delete($id)
	{
		delete_PluSQL($this -> table,$this -> id,strip($id));
	}
	//------------
	function update($id ,$post)
	{
		$update = array
				(
					'name' => strip($post['name']),
					'description' => strip($post['description']),
					'standard_shift_start' => ($post['standard_shift_start']),
					'standard_shift_end' => ($post['standard_shift_end']),
					'standard_relax_start' => ($post['standard_relax_start']),
					'standard_relax_end' => ($post['standard_relax_end']),
					'rotation_flag' => (@$post['rotation_flag']),
					'rotation_interval' => (@$post['rotation_interval']),
					'rotation_shift_start' => (@$post['rotation_shift_start']),
					'rotation_shift_end' => (@$post['rotation_shift_end']),
					'rotation_relax_start' => (@$post['rotation_relax_start']),
					'rotation_relax_end' => (@$post['rotation_relax_end']),	
				);
		update_PluSQL($this -> table,$update,$this -> id,strip($id));
	}
}

?>