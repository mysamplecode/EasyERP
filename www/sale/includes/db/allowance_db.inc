<?php
function get_all_allowances()
{
	$sql = "SELECT * FROM "
		.TB_PREF."allowance ";
	
	return db_query($sql, "could not get allowances");
} 


function check_allowance($name){
$sql = "select * from "
		.TB_PREF."allowance where name=".db_escape($name);
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
function get_search_sql_allowance($name=null,$descr=null,$type=null)
{ 
$conds= '';
if($type!='' && $type !=null){
 $conds = " and type like ".db_escape($type);
}
	$sql = "SELECT name,descr,type,id from ".TB_PREF."allowance where
		name like ".db_escape('%'.$name.'%'). " and
		descr like ".db_escape('%'.$descr.'%'). " 
		$conds 
		";
		return $sql;
} 



 
function add_allowance($name,$desc,$type)
{
	$sql = "INSERT INTO ".TB_PREF."allowance (name,descr,type) VALUES (".db_escape($name)
			. ",
			".db_escape($desc)
			. ",
			".db_escape($type) 
			. ")";
	db_query($sql, "could not add allowance");
}
function delete_allowance($id)
{
	$sql="DELETE FROM ".TB_PREF."allowance WHERE id=".db_escape($id);
	db_query($sql,"The allowance cannot be deleted");
}
function update_allowance($id, $name,$desc,$type)
{

	$sql = "UPDATE ".TB_PREF."allowance SET name=".db_escape($name)
				.",
	descr=".db_escape($desc)
				.",
	type=".db_escape($type)
				." WHERE id = ".db_escape($id);
	
	db_query($sql, "could not update allowance");			
}

function get_allowance($id)
{
	$sql = "SELECT name,id,type,descr FROM "
		.TB_PREF."allowance 
		WHERE id=".db_escape($id);
	
	$result = db_query($sql, "could not get allowance");
	
	return db_fetch($result);
}
?>