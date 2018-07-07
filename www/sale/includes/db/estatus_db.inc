<?php
  
function check_duplicate($name){
	$sql = "select * from "
		.TB_PREF."employee_status where name=".db_escape($name);
  $res = db_query($sql);
if(db_num_rows($res)>0){
return true;
}else{
return false;
}
}

function get_search_sql_estatus($name=null)
{
	$sql = "SELECT name,id from ".TB_PREF."employee_status where name like ".db_escape('%'.$name.'%')
			. " ";
		return $sql;
} 
function add_estatus($name)
{
	$sql = "INSERT INTO ".TB_PREF."employee_status (name) VALUES (".db_escape($name)
			. ")";
	db_query($sql, "could not add unit");
}
function delete_estatus($id)
{
	$sql="DELETE FROM ".TB_PREF."employee_status WHERE id=".db_escape($id);
	db_query($sql,"The unit cannot be deleted");
}
function update_estatus($id, $name)
{

	$sql = "UPDATE ".TB_PREF."employee_status SET name=".db_escape($name)
				." WHERE id = ".db_escape($id);
	
	db_query($sql, "could not update unit");			
}

function get_estatus($id)
{
	$sql = "SELECT name FROM "
		.TB_PREF."employee_status 
		WHERE id=".db_escape($id);
	
	$result = db_query($sql, "could not get Unit");
	
	return db_fetch($result);
}
?>