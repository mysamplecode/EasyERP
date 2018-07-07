<?php
function get_all_holydays()
{
	$sql = "SELECT * FROM "
		.TB_PREF."holyday ";
	
	return db_query($sql, "could not get leaves");
} 


function check_holyday($name){
$sql = "select * from "
		.TB_PREF."holyday where name=".db_escape($name);
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
 function get_unit_name($name){
 
 	$sql = "SELECT ".TB_PREF."unit.name FROM "
		.TB_PREF."department inner join "
		.TB_PREF."unit on "
		.TB_PREF."department.unitid = "
		.TB_PREF."unit.id 
		WHERE ".TB_PREF."department.name=".db_escape($name);
	
	$result = db_query($sql, "could not get leave");
	
	return db_fetch($result);
 
 
 }
 function get_all_type_ids($type){
 
 	$sql = "SELECT  id,name FROM "
		.TB_PREF."$type";
	
	return db_query($sql, "could not get departments");
 
 
 }
 function get_all_dep_ids($dep_id){
 
 	$sql = "SELECT  id,name FROM "
		.TB_PREF."department where unitid='$dep_id'";
	
	return db_query($sql, "could not get departments");
 
 
 }
 function get_all_years(){
 
 	$sql = "SELECT  id,CONCAT_WS(' - ',".TB_PREF."fiscal_year.begin,".TB_PREF."fiscal_year.end) as name FROM ".TB_PREF."fiscal_year where closed='0' order by id desc";
	
	return db_query($sql, "could not get departments");
 
 
 }
function get_search_sql_holyday($name=null,$descr=null,$unit='',$dep='',$year_id=0,$start=0,$end=0,$compare_start=0,$compare_end=0)
{ 
if($dep!=''){
$type = 'de';
$type_id = $dep;

$type_tbl = 'department';
}else{
if($unit!=''){
$type_id = $unit;
$type = 'un';
$type_tbl = 'unit';
}else{
$type_id = '';
$type = '';

}
}
$conds = '';

$compare_start = get_compare_sign($compare_start);
$compare_end = get_compare_sign($compare_end);
if($type_id!=null || $type_id!='') $conds .= "and
		".TB_PREF."holyday.type_id like ".db_escape($type_id). " ";
if($year_id!=null || $year_id!='') $conds .= "and
		".TB_PREF."holyday.year_id like ".db_escape($year_id). " ";  
if($type==null || $type==''){

 	$sql = "select * from ((  SELECT  ".TB_PREF."holyday.name,".TB_PREF."holyday.descr,CONCAT_WS(' - ',".TB_PREF."fiscal_year.begin,".TB_PREF."fiscal_year.end) as year,".TB_PREF."holyday.start,".TB_PREF."holyday.end,
	".TB_PREF."unit.name as type_name,".TB_PREF."holyday.type,".TB_PREF."holyday.id from  ".TB_PREF."holyday  

	inner join ".TB_PREF."fiscal_year on
	".TB_PREF."fiscal_year.id = ".TB_PREF."holyday.year_id  inner join 
	".TB_PREF."unit on ".TB_PREF."unit.id = ".TB_PREF."holyday.type_id where
		".TB_PREF."holyday.name like ".db_escape('%'.$name.'%'). " and
		".TB_PREF."holyday.descr like ".db_escape('%'.$descr.'%') .$conds." and ".TB_PREF."holyday.type like 'un' and ".TB_PREF."holyday.start $compare_start ".db_escape($start)."+0  and ".TB_PREF."holyday.end $compare_end ".db_escape($end)."+0 )  
UNION
		 (SELECT  ".TB_PREF."holyday.name,".TB_PREF."holyday.descr,CONCAT_WS(' - ',".TB_PREF."fiscal_year.begin,".TB_PREF."fiscal_year.end) as year,".TB_PREF."holyday.start,".TB_PREF."holyday.end,
	".TB_PREF."department.name as type_name,".TB_PREF."holyday.type,".TB_PREF."holyday.id from  ".TB_PREF."holyday  

	inner join ".TB_PREF."fiscal_year on
	".TB_PREF."fiscal_year.id = ".TB_PREF."holyday.year_id  inner join 
	".TB_PREF."department on ".TB_PREF."department.id = ".TB_PREF."holyday.type_id where
		".TB_PREF."holyday.name like ".db_escape('%'.$name.'%'). " and
		".TB_PREF."holyday.descr like ".db_escape('%'.$descr.'%') .$conds." and ".TB_PREF."holyday.type like 'de'  and ".TB_PREF."holyday.start $compare_start ".db_escape($start)."+0  and ".TB_PREF."holyday.end $compare_end ".db_escape($end)."+0  )) as tbl3 

		";




}else{
if($dep==0 || $dep=='' || $dep == null){
$conds2 = " and ".TB_PREF."department.unitid like ".db_escape($type_id);

if($year_id!=null || $year_id!='') $conds2 .= "and
		".TB_PREF."holyday.year_id like ".db_escape($year_id). " "; 
$sql = " select * from ((SELECT  ".TB_PREF."holyday.name,".TB_PREF."holyday.descr,
	CONCAT_WS(' - ',".TB_PREF."fiscal_year.begin,".TB_PREF."fiscal_year.end) as year,".TB_PREF."holyday.start,".TB_PREF."holyday.end,".TB_PREF."$type_tbl.name as type_name,".TB_PREF."holyday.type,".TB_PREF."holyday.id from  ".TB_PREF."holyday  

	inner join ".TB_PREF."fiscal_year on
	".TB_PREF."fiscal_year.id = ".TB_PREF."holyday.year_id  inner join 
	".TB_PREF."$type_tbl on ".TB_PREF."$type_tbl.id = ".TB_PREF."holyday.type_id where
		".TB_PREF."holyday.name like ".db_escape('%'.$name.'%'). "  
		and ".TB_PREF."holyday.descr like ".db_escape('%'.$descr.'%') .$conds."
		and ".TB_PREF."holyday.type like ".db_escape("$type"). "  and ".TB_PREF."holyday.start $compare_start ".db_escape($start)."+0  and ".TB_PREF."holyday.end $compare_end ".db_escape($end)."+0   )
		UNION
		(
		SELECT  ".TB_PREF."holyday.name,".TB_PREF."holyday.descr,
		CONCAT_WS(' - ',".TB_PREF."fiscal_year.begin,".TB_PREF."fiscal_year.end) as year,".TB_PREF."holyday.start,".TB_PREF."holyday.end,".TB_PREF."department.name as type_name,".TB_PREF."holyday.type,".TB_PREF."holyday.id from  ".TB_PREF."holyday  
		inner join ".TB_PREF."fiscal_year on
	".TB_PREF."fiscal_year.id = ".TB_PREF."holyday.year_id  inner join 
	".TB_PREF."department on ".TB_PREF."department.id = ".TB_PREF."holyday.type_id where
		".TB_PREF."holyday.name like ".db_escape('%'.$name.'%'). "  
		and ".TB_PREF."holyday.descr like ".db_escape('%'.$descr.'%') .$conds2."
		 and ".TB_PREF."holyday.type like ".db_escape('de'). "  and ".TB_PREF."holyday.start $compare_start ".db_escape($start)."+0  and ".TB_PREF."holyday.end $compare_end ".db_escape($end)."+0 )) as tbl3
		
		";
}else{
$sql = "SELECT  ".TB_PREF."holyday.name,".TB_PREF."holyday.descr,
	CONCAT_WS(' - ',".TB_PREF."fiscal_year.begin,".TB_PREF."fiscal_year.end) as year,".TB_PREF."holyday.start,".TB_PREF."holyday.end,".TB_PREF."$type_tbl.name as type_name,".TB_PREF."holyday.type,".TB_PREF."holyday.id from  ".TB_PREF."holyday  

	inner join ".TB_PREF."fiscal_year on
	".TB_PREF."fiscal_year.id = ".TB_PREF."holyday.year_id  inner join 
	".TB_PREF."$type_tbl on ".TB_PREF."$type_tbl.id = ".TB_PREF."holyday.type_id where
		".TB_PREF."holyday.name like ".db_escape('%'.$name.'%'). "  
		and ".TB_PREF."holyday.descr like ".db_escape('%'.$descr.'%') .$conds."
		and ".TB_PREF."holyday.type like ".db_escape("$type")."  and ".TB_PREF."holyday.start $compare_start ".db_escape($start)."+0  and ".TB_PREF."holyday.end $compare_end ".db_escape($end)."+0 ";

}
}
		return $sql;
} 



 
function add_holyday($name,$desc,$unit_id,$dep_id,$year_id,$start,$end)
{
if($dep_id!=''){
$type='department';

$type_id = $dep_id;

}else{
$type = 'unit';

$type_id = $unit_id;
}
	$sql = "INSERT INTO ".TB_PREF."holyday (name,descr,type,type_id,year_id,start,end) VALUES (".db_escape($name)
			. ",
			".db_escape($desc)
			. ",
			".db_escape($type)
			. ",
			".db_escape($type_id)
			. ",
			".db_escape($year_id)
			. ",
			".db_escape($start)
			. ",
			".db_escape($end)
			. ")";
	db_query($sql, "could not add leave");
}
function delete_holyday($id)
{
	$sql="DELETE FROM ".TB_PREF."holyday WHERE id=".db_escape($id);
	db_query($sql,"The leave cannot be deleted");
}
function update_holyday($id, $name,$desc,$unit_id,$dep_id,$year_id,$start,$end)
{
if($dep_id!=''){
$type='department';

$type_id = $dep_id;

}else{
$type = 'unit';

$type_id = $unit_id;
}
	$sql = "UPDATE ".TB_PREF."holyday SET name=".db_escape($name)
				.",
	descr=".db_escape($desc)
				.",
	year_id=".db_escape($year_id)
				.",
	type_id=".db_escape($type_id)
				.",
	start=".db_escape($start)
				.",
	end=".db_escape($end)
				.",
	type=".db_escape($type)
				." WHERE id = ".db_escape($id);
	
	db_query($sql, "could not update leave");			
}
function get_unit_id($dep){
	$sql = "SELECT unitid FROM "
		.TB_PREF."department 
		WHERE id=".db_escape($dep);
	
	$result = db_query($sql, "could not get leave");
	
	$res =  db_fetch($result);
   return $res['unitid'];
}
function get_holyday($id)
{
	$sql = "SELECT * FROM "
		.TB_PREF."holyday 
		WHERE id=".db_escape($id);
	
	$result = db_query($sql, "could not get leave");
	
	return db_fetch($result);
}
?>