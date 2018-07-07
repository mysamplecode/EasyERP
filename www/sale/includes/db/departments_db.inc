<?php
function get_all_departments()
{
	$sql = "SELECT name,id,strength FROM "
		.TB_PREF."department ";
	
	return db_query($sql, "could not get departments");
} 
function get_all_strength()
{
	$sql = "SELECT  strength FROM "
		.TB_PREF."department group by strength ";
	
	return db_query($sql, "could not get departments");
}  
function add_department($name,$strength,$unitid)
{
	$sql = "INSERT INTO ".TB_PREF."department (name,strength,unitid) VALUES (".db_escape($name)
			. ",
			".db_escape($strength)
			. ",".db_escape($unitid)
			. ")";
	db_query($sql, "could not add department");
}

function check_deps($name){
$sql = "select * from "
		.TB_PREF."department where name=".db_escape($name);
  $res = db_query($sql);
if(db_num_rows($res)>0){
return true;
}else{
return false;
}


}
function get_search_sql_dep($name=null,$str=null,$unid = null)
{
$conds = '';
if($str!=''){
		$conds .=  " and ".TB_PREF."department.strength like ".db_escape($str);
}
if($unid!=''){
		$conds .=  " and ".TB_PREF."department.unitid like ".db_escape($unid);
}
	$sql = "SELECT ".TB_PREF."department.name as depname,".TB_PREF."department.strength,".TB_PREF."unit.name ,".TB_PREF."department.id from ".TB_PREF."department INNER JOIN ".TB_PREF."unit 
ON ".TB_PREF."unit.id=".TB_PREF."department.unitid where ".TB_PREF."department.name like ".db_escape('%'.$name.'%')
			.$conds;
		return $sql;
} 


function delete_department($id)
{
	$sql="DELETE FROM ".TB_PREF."department WHERE id=".db_escape($id);
	db_query($sql,"The department cannot be deleted");
}
function update_department($id, $name,$strength,$unit)
{

	$sql = "UPDATE ".TB_PREF."department SET name=".db_escape($name)
				.",
	strength=".db_escape($strength)
				." ,
	unitid=".db_escape($unit)
				." WHERE id = ".db_escape($id);
	
	db_query($sql, "could not update department");			
}

function get_department($id)
{
	$sql = "SELECT name,strength,unitid FROM "
		.TB_PREF."department 
		WHERE id=".db_escape($id);
	
	$result = db_query($sql, "could not get department");
	
	return db_fetch($result);
}
?>