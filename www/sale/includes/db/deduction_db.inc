<?php
function get_all_deductions()
{
	$sql = "SELECT * FROM "
		.TB_PREF."deduction ";
	
	return db_query($sql, "could not get deductions");
} 


function check_deduction($name){
$sql = "select * from "
		.TB_PREF."deduction where name=".db_escape($name);
  $res = db_query($sql);
if(db_num_rows($res)>0){
return true;
}else{
return false;
}

}
 function get_compare_sign($value){
 switch($value){
 case 0:
	return " >= ";
 break;
 case 1:
	return " <= ";
 break;
 case 2:
	return " = ";
 break;
 
 
 }
 
 
 }
function get_search_sql_deduction($name=null,$descr=null,$type=null)
{ 
$conds= '';
if($type!='' && $type !=null){
 $conds = " and type like ".db_escape($type);
}
	$sql = "SELECT name,descr,type,id from ".TB_PREF."deduction where
		name like ".db_escape('%'.$name.'%'). " and
		descr like ".db_escape('%'.$descr.'%'). " 
		$conds 
		";
		return $sql;
} 



 
function add_deduction($name,$desc,$type)
{
	$sql = "INSERT INTO ".TB_PREF."deduction (name,descr,type) VALUES (".db_escape($name)
			. ",
			".db_escape($desc)
			. ",
			".db_escape($type) 
			. ")";
	db_query($sql, "could not add deduction");
}
function delete_deduction($id)
{
	$sql="DELETE FROM ".TB_PREF."deduction WHERE id=".db_escape($id);
	db_query($sql,"The deduction cannot be deleted");
}
function update_deduction($id, $name,$desc,$type)
{

	$sql = "UPDATE ".TB_PREF."deduction SET name=".db_escape($name)
				.",
	descr=".db_escape($desc)
				.",
	type=".db_escape($type)
				." WHERE id = ".db_escape($id);
	
	db_query($sql, "could not update deduction");			
}

function get_deduction($id)
{
	$sql = "SELECT name,id,type,descr FROM "
		.TB_PREF."deduction 
		WHERE id=".db_escape($id);
	
	$result = db_query($sql, "could not get deduction");
	
	return db_fetch($result);
}
?>