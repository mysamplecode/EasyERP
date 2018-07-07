<?php
function get_all_titles()
{
	$sql = "SELECT name,id FROM "
		.TB_PREF."title ";
	
	return db_query($sql, "could not get titles");
}
function check_title($name){
$sql = "select * from "
		.TB_PREF."title where name=".db_escape($name);
  $res = db_query($sql);
if(db_num_rows($res)>0){
return true;
}else{
return false;
}

}


function get_search_sql_title($name=null)
{
 
	$sql = "SELECT name,id from ".TB_PREF."title where name like ".db_escape('%'.$name.'%')  ;
		return $sql;
}

  
function add_title($name)
{
	$sql = "INSERT INTO ".TB_PREF."title (name) VALUES (".db_escape($name)
			. ")";
	db_query($sql, "could not add title");
}
function delete_title($id)
{
	$sql="DELETE FROM ".TB_PREF."title WHERE id=".db_escape($id);
	db_query($sql,"The title cannot be deleted");
}
function update_title($id, $name)
{

	$sql = "UPDATE ".TB_PREF."title SET name=".db_escape($name)
				." WHERE id = ".db_escape($id);
	
	db_query($sql, "could not update title");			
}

function get_title($id)
{
	$sql = "SELECT name FROM "
		.TB_PREF."title 
		WHERE id=".db_escape($id);
	
	$result = db_query($sql, "could not get title");
	
	return db_fetch($result);
}
?>