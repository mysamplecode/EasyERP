<?php
function get_all_units()
{
	$sql = "SELECT name,id FROM "
		.TB_PREF."unit ";
	
	return db_query($sql, "could not get units");
}  
function check_duplicate($name){
	$sql = "select * from "
		.TB_PREF."unit where name=".db_escape($name);
  $res = db_query($sql);
if(db_num_rows($res)>0){
return true;
}else{
return false;
}
}

function get_search_sql_unit($name=null)
{
	$sql = "SELECT name,id from ".TB_PREF."unit where name like ".db_escape('%'.$name.'%')
			. " ";
		return $sql;
} 
function add_unit($name)
{
	$sql = "INSERT INTO ".TB_PREF."unit (name) VALUES (".db_escape($name)
			. ")";
	db_query($sql, "could not add unit");
}
function delete_unit($id)
{
	$sql="DELETE FROM ".TB_PREF."unit WHERE id=".db_escape($id);
	db_query($sql,"The unit cannot be deleted");
}
function update_unit($id, $name)
{

	$sql = "UPDATE ".TB_PREF."unit SET name=".db_escape($name)
				." WHERE id = ".db_escape($id);
	
	db_query($sql, "could not update unit");			
}

function get_unit($id)
{
	$sql = "SELECT name FROM "
		.TB_PREF."unit 
		WHERE id=".db_escape($id);
	
	$result = db_query($sql, "could not get Unit");
	
	return db_fetch($result);
}
?>