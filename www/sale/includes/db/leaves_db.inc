<?php
function get_all_leaves()
{
	$sql = "SELECT * FROM "
		.TB_PREF."leave ";
	
	return db_query($sql, "could not get leaves");
} 


function check_leave($name){
$sql = "select * from "
		.TB_PREF."leave where name=".db_escape($name);
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
function get_search_sql_leave($name=null,$descr=null,$start=0,$end=0,$compare_end=0,$compare_start=0)
{
$compare_start = get_compare_sign($compare_start);
$compare_end = get_compare_sign($compare_end);
	$sql = "SELECT name,descr,mins,maxs,id from ".TB_PREF."leave where
		name like ".db_escape('%'.$name.'%'). " and
		descr like ".db_escape('%'.$descr.'%'). " and
		mins $compare_start ".db_escape($start ). "+0 and
		maxs  $compare_end ".db_escape($end). "+0 

		";
		return $sql;
} 



 
function add_leave($name,$desc,$start,$end)
{
	$sql = "INSERT INTO ".TB_PREF."leave (name,descr,mins,maxs) VALUES (".db_escape($name)
			. ",
			".db_escape($desc)
			. ",
			".db_escape($start)
			. ",
			".db_escape($end)
			. ")";
	db_query($sql, "could not add leave");
}
function delete_leave($id)
{
	$sql="DELETE FROM ".TB_PREF."leave WHERE id=".db_escape($id);
	db_query($sql,"The leave cannot be deleted");
}
function update_leave($id, $name,$desc,$start,$end)
{

	$sql = "UPDATE ".TB_PREF."leave SET name=".db_escape($name)
				.",
	descr=".db_escape($desc)
				.",
	mins=".db_escape($start)
				.",
	maxs=".db_escape($end)
				." WHERE id = ".db_escape($id);
	
	db_query($sql, "could not update leave");			
}

function get_leave($id)
{
	$sql = "SELECT name,id,mins,maxs,descr FROM "
		.TB_PREF."leave 
		WHERE id=".db_escape($id);
	
	$result = db_query($sql, "could not get leave");
	
	return db_fetch($result);
}
?>