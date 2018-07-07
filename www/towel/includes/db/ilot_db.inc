<?php
function  get_ilot_sql( ){
 
$sql = "select lno,descr,pdate,id from ".TB_PREF."tlots where issue = '1' and process = '0' and dispatch = '0'";
return $sql;
}
function  get_nlot_sql( ){
 
$sql = "select lno,descr,pdate,id from ".TB_PREF."tlots where issue = '0'";
return $sql;
}
function get_ent_name($col,$table,$id){
$sql = "select $col as item from ".TB_PREF."$table where id = '$id'";

 
	$result = db_query($sql);
	$rows = db_fetch_assoc($result);
	return $rows['item'];
}
function  get_steps_string($id){
	$sql = "select * from ".TB_PREF."steps where lotid = '$id' limit 1";
	$result = db_query($sql);
	$row = db_fetch_assoc($result);
	$str = array();
	if($row['prep_bool'] == 'yes'){
		$str[] = "Preparation ";
	}
	if($row['care_bool'] == 'yes'){
		$str[]= " Care";
	}
	if($row['bleach_bool'] == 'yes'){
		$str[]= " Bleach ";
	}
	if($row['dye_bool'] == 'yes'){
		$str[] = " Dyeing ";
	}
	if($row['hydro_bool'] == 'yes'){
		$str[]= "Hydro";
	}
	if($row['tumbler_bool'] == 'yes'){
		$str[] = "Tumbler";
	}
	if($row['quality_bool'] == 'yes'){
		$str[]= " Quality ";
	}
	return implode(",",$str);
}	
?>