<?php
function get_all_designations()
{
	$sql = "SELECT * FROM "
		.TB_PREF."designation ";
	
	return db_query($sql, "could not get designations");
} 
 function  get_curencies_array(){
 $sql = "select currency,curr_abrev from  "
		.TB_PREF."currencies ";
 return db_query($sql, "could not get designations");
 }
function check_desig($name){
$sql = "select * from "
		.TB_PREF."designation where name=".db_escape($name);
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
function get_search_sql_desig($name=null,$descr=null,$start=0,$end=0,$compare_end=0,$compare_start=0,$curency='')
{
$compare_start = get_compare_sign($compare_start);
$compare_end = get_compare_sign($compare_end);
$cur_cond  = '';
if($curency!=''){
	$cur_cond = " and curency like  ".db_escape($curency) ;

}
	$sql = "SELECT name,descr,start,end,curency,id from ".TB_PREF."designation where
		name like ".db_escape('%'.$name.'%'). " and
		descr like ".db_escape('%'.$descr.'%'). " and 
		start $compare_start ".db_escape($start ). "+0 and
		end  $compare_end ".db_escape($end). "+0 $cur_cond 

		";
		return $sql;
} 
function add_designation($name,$desc,$start,$end,$curency)
{
	$sql = "INSERT INTO ".TB_PREF."designation (name,descr,start,end,curency) VALUES (".db_escape($name)
			. ",
			".db_escape($desc)
			. ",
			".db_escape($start)
			. ",
			".db_escape($end)
			. ",
			".db_escape($curency)
			. ")";
	db_query($sql, "could not add designation");
}
function delete_designation($id)
{
	$sql="DELETE FROM ".TB_PREF."designation WHERE id=".db_escape($id);
	db_query($sql,"The designation cannot be deleted");
}
function update_designation($id, $name,$desc,$start,$end,$curency)
{

	$sql = "UPDATE ".TB_PREF."designation SET name=".db_escape($name)
				.",
	descr=".db_escape($desc)
				.",
	start=".db_escape($start)
				.",
	end=".db_escape($end)
				.",
	curency=".db_escape($curency)
				." WHERE id = ".db_escape($id);
	
	db_query($sql, "could not update designation");			
}

function get_designation($id)
{
	$sql = "SELECT name,id,start,end,descr,curency FROM "
		.TB_PREF."designation 
		WHERE id=".db_escape($id);
	
	$result = db_query($sql, "could not get designation");
	
	return db_fetch($result);
}
?>