<?php
function get_all_shifts()
{
	$sql = "SELECT * FROM "
		.TB_PREF."shift ";
	
	return db_query($sql, "could not get banks");
} 

function get_all_unit_ids()
{
	$sql = "SELECT name,id FROM "
		.TB_PREF."unit ";
	
	return db_query($sql, "could not get unit");
} 
function get_all_dep_ids($unit)
{
	$sql = "SELECT name,id FROM "
		.TB_PREF."department where unitid=".db_escape($unit);
	
	return db_query($sql, "could not get department");
} 


function check_shift($name){
$sql = "select * from "
		.TB_PREF."shift where name=".db_escape($name);
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
 
 function time2str($time){
 if($time>3600*24){
	$time = $time-3600*24;
 }
	return floor($time/3600).":".floor(($time - floor($time/3600)*3600)/60);
 
 
 
 }
 
 
function get_search_sql_shift($name=null,$unit=null,$dep=null,$start=0,$end=0,$total=null,$relax_start=0,$relax_end=0,$compare_start=0,$compare_end=0,$compare_relaxs=0,$compare_relaxe=0,$compare_total=0)
{
$compare_start = get_compare_sign($compare_start);
$compare_end = get_compare_sign($compare_end);
$compare_relaxs = get_compare_sign($compare_relaxs);
$compare_relaxe = get_compare_sign($compare_relaxe);
$compare_total = get_compare_sign($compare_total);

$mconds = '';
if($start!=''){
$mconds .= " and
		start $compare_start ".db_escape(sstr2time($start)). "+0 ";
	

}
if($end!=''){
$mconds .= " and
		end $compare_end ".db_escape(sstr2time($end)). "+0 ";
	

}
if($total!=''){
$mconds .= " and
		total $compare_total ".db_escape($total). "+0 ";
	

}
if($relax_start!=''){
$mconds .= " and
		relax_start $compare_relaxs ".db_escape(sstr2time($relax_start)). "+0 ";
	

}
if($relax_end!=''){
$mconds .= " and
		relax_end $compare_relaxe ".db_escape(sstr2time($relax_start)). "+0 ";
	

} 
$conds = '';
 
	$sql = "SELECT ".TB_PREF."shift.name,CONCAT(floor(".TB_PREF."shift.start/3600),':',floor((".TB_PREF."shift.start - floor(".TB_PREF."shift.start/3600)*3600)/60)) as start,CONCAT(if (".TB_PREF."shift.end >24*3600 , floor((".TB_PREF."shift.end-3600*24)/3600),floor(".TB_PREF."shift.end/3600)),':',floor((".TB_PREF."shift.end - floor(".TB_PREF."shift.end/3600)*3600)/60)) as end,".TB_PREF."shift.total,CONCAT(floor(".TB_PREF."shift.relax_start/3600),':',floor((".TB_PREF."shift.relax_start - floor(".TB_PREF."shift.relax_start/3600)*3600)/60)) as relax_start,CONCAT(floor(".TB_PREF."shift.relax_end/3600),':',floor((".TB_PREF."shift.relax_end - floor(".TB_PREF."shift.relax_end/3600)*3600)/60)) as relax_end, ".TB_PREF."shift.id from ".TB_PREF."shift    where
		".TB_PREF."shift.name like ".db_escape('%'.$name.'%'). "    $mconds 
		 $conds ";
		 
		return $sql;
} 

function sstr2time($str){


$str = explode(":",$str);

if(count($str)>1){
return  ((int)trim($str[0]) * 3600 + (int)trim($str[1]) * 60);
}else return 0;
}
function str2time($start,$end){
$start = explode(":",$start);
$end = explode(":",$end);
$start = (int)trim($start[0]) * 3600 + (int)trim($start[1]) * 60;

$end = (int)trim($end[0]) * 3600 + (int)trim($end[1]) * 60;

if($start>$end){
$end = $end + 24*3600;
}

return array($start,$end);
}


 
function add_shift($name=null,$unit=null,$dep=null,$start=null,$end=null,$total=null,$relax_start=null,$relax_end=null)
{
list($start,$end) = str2time($start,$end);

list($relax_start,$relax_end) = str2time($relax_start,$relax_end);

	$sql = "INSERT INTO ".TB_PREF."shift (name,start,end,total,relax_start,relax_end) VALUES (".db_escape($name)
			. ",
			".db_escape($start)
			. ",
			".db_escape($end)
			. ",
			".db_escape($total)
			. ",
			".db_escape($relax_start)
			. ",
			".db_escape($relax_end)
			. ")";
	db_query($sql, "could not add shift");
}
function delete_shift($id)
{
	$sql="DELETE FROM ".TB_PREF."shift WHERE id=".db_escape($id);
	db_query($sql,"The shift cannot be deleted");
}
function update_shift($id,$name=null,$unit=null,$dep=null,$start=null,$end=null,$total=null,$relax_start=null,$relax_end=null)
{

	$sql = "UPDATE ".TB_PREF."shift SET name=".db_escape($name)
				.",
	start=".db_escape($start)
				.",
	end=".db_escape($end)
				.",
	total=".db_escape($total)
				.",
	relax_start=".db_escape($relax_start)
				.",
	relax_end=".db_escape($relax_end)
				."
				 WHERE id = ".db_escape($id);
	
	db_query($sql, "could not update bank");			
}

function get_shift($id)
{
	$sql = "SELECT * FROM "
		.TB_PREF."shift 
	WHERE id=".db_escape($id);
	
	$result = db_query($sql, "could not get shift");
	
	return db_fetch($result);
}
?>