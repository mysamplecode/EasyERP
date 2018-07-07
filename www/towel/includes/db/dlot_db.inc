<?php
function  get_dlot_sql( ){
 
$sql = "select lno,descr,pdate,id from ".TB_PREF."tlots where dispatch = '1'";
return $sql;
}
function get_dispatch(){

$sql = "select lno,id from ".TB_PREF."tlots where issue = '1' and process = '1' && dispatch = '0'";
return db_query($sql);
}
  
function add_lot($id,$cuid){
	$sql  = "update ".TB_PREF."tlots set dispatch = '1',cuid = '$cuid',dispatch_date='".strtotime(date("m/d/Y"))."' where id = '$id'";
	db_query($sql);
}
function remove_lot($id ){
	$sql  = "update ".TB_PREF."tlots set dispatch = '0',cuid = '0',dispatch_date='' where id = '$id'";
	db_query($sql);
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
	if($row['tumbl_bool'] == 'yes'){
		$str[] = "Tumbler";
	}
	if($row['quality_bool'] == 'yes'){
		$str[]= " Quality ";
	}
	return implode(",",$str);
}
 function get_lot($id){
  $sql = "select cuid,id from ".TB_PREF."tlots where id='$id'";
  
  $result = db_query($sql);
  return db_fetch_assoc($result);
 }
?>