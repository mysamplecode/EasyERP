<?php
  
function check_duplicate($name){
	$sql = "select * from "
		.TB_PREF."salary_type where name=".db_escape($name);
  $res = db_query($sql);
if(db_num_rows($res)>0){
return true;
}else{
return false;
}
}

function get_search_sql_stypes($name=null,$alow='',$ded='')
{
$conds = '';
 if($alow) $conds .=" and alow = 'yes' ";
	if($ded) $conds .=" and ded = 'yes' ";
	$sql = "SELECT name,alow,ded,id from ".TB_PREF."salary_type where name like ".db_escape('%'.$name.'%')
			. "  $conds ";
		return $sql;
} 
function add_stypes($name,$alow='',$ded='')
{
if($alow) $alow = 'yes';  else $alow = 'no';
if($ded) $ded = 'yes';  else $ded = 'no';
	$sql = "INSERT INTO ".TB_PREF."salary_type (name,alow,ded) VALUES (".db_escape($name)
			. ",".db_escape($alow).",".db_escape($ded).")";
	db_query($sql, "could not add unit");
}
function delete_stypes($id)
{
	$sql="DELETE FROM ".TB_PREF."salary_type WHERE id=".db_escape($id);
	db_query($sql,"The unit cannot be deleted");
}
function update_stypes($id, $name,$alow='',$ded='')
{

if($alow) $alow = 'yes';  else $alow = 'no';
if($ded) $ded = 'yes';  else $ded = 'no';
	$sql = "UPDATE ".TB_PREF."salary_type SET name=".db_escape($name)
				." ,alow=".db_escape($alow)
				." , ded=".db_escape($ded)
				." WHERE id = ".db_escape($id);
	
	db_query($sql, "could not update unit");			
}

function get_stype($id)
{
	$sql = "SELECT * FROM "
		.TB_PREF."salary_type 
		WHERE id=".db_escape($id);
	
	$result = db_query($sql, "could not get Unit");
	
	return db_fetch($result);
}
?>