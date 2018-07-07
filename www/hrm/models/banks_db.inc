<?php
class bank_model
{
	//---gets all the units from the table----
	public $table;
	public $id;
	public function __construct()
	{
		global $prefix; 
		$this -> table = $prefix."bank";
		$this -> id = "bank_id";
	}
	//---gets all the units from the table----
	function select($id = null, &$post)
	{
		$myrow =  select_PluSQL($this -> table, array($this -> id => strip($id)));
		$post['name'] = $myrow -> name;
		$post['country'] = $myrow -> country;
		$post['swift'] = $myrow -> swift;
		$post['branch'] = $myrow -> branch;
		$post['branch_number'] = $myrow -> branch_number;
		$post['address'] = $myrow -> address;
		$post['city'] = $myrow -> city;
		$post['province'] = $myrow -> province;
		$post['postal_code'] = $myrow -> postal_code;
	}
	//--------
	function search($name = null, $country = null, $swift = null, $branch = null, $branch_number = null, $address = null 
								,$city = null ,$province = null ,$postal_code = null)
	{
		global $prefix;
		return $this -> search_advanced(array(
				'name' => strip($name),
				'country' => strip($country),
				'swift' => strip($swift),
				'branch' => strip($branch),
				'branch_number' => strip($branch_number),
				'address' => strip($address),
				'city' => strip($city),
				'province' => strip($province),
				'postal_code' => strip($postal_code),
				$this -> id => ''
		));
	}
	//--------
	function search_advanced($arr)
	{
		return search_PluSQL($this -> table, $arr);
	}
	//-------- 
	function insert($name , $country , $swift , $branch , $branch_number , $address  
								,$city  ,$province  ,$postal_code )
	{
		$arr = array
				(
					'name' => strip($name),
					'country' => strip($country),
					'swift' => strip($swift),
					'branch' => strip($branch),
					'branch_number' => strip($branch_number),
					'address' => strip($address),
					'city' => strip($city),
					'province' => strip($province),
					'postal_code' => strip($postal_code)
				);
		return insert_PluSQL($this -> table,$arr,$this -> id,'branch_number',$branch_number);
	}
	//-----------
	function delete($id)
	{
		delete_PluSQL($this -> table,$this -> id,strip($id));
	}
	//------------
	function update($id,$name , $country , $swift , $branch , $branch_number , $address  
								,$city  ,$province  ,$postal_code )
	{
		$update = array
				(
					'name' => strip($name),
					'country' => strip($country),
					'swift' => strip($swift),
					'branch' => strip($branch),
					'branch_number' => strip($branch_number),
					'address' => strip($address),
					'city' => strip($city),
					'province' => strip($province),
					'postal_code' => strip($postal_code)
				);
		update_PluSQL($this -> table,$update,$this -> id,strip($id));
	}
}
?>