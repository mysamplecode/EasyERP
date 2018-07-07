<?php
function  get_plot_sql( ){
 
$sql = "select lno,descr,pdate,id from ".TB_PREF."tlots where process = '1' and issue = '1'";
return $sql;
}
function get_issued(){

$sql = "select lno,id from ".TB_PREF."tlots where issue = '1' and process = '0' and dispatch = '0'";
return db_query($sql);
}
function get_steps($id){
	
$sql = "select * from ".TB_PREF."steps where lotid = '$id'";

	$result = db_query($sql);
	return db_fetch_assoc($result);
}

function  get_fields_steps($id){
	$rsteps = get_steps($id); 
	$array = array();
	if($rsteps['prep_bool']=='yes'){
			 $array[] = "prep";
	
	}
	if($rsteps['care_bool']=='yes'){
			 
			 $array[] = "care"; 
	}
	if($rsteps['bleach_bool']=='yes'){
	
			 $array[] = "bleach"; 
	}
	if($rsteps['dye_bool']=='yes'){
			
			 $array[] = "dye"; 
	}
	if($rsteps['tumbler_bool']=='yes'){
			
			 $array[] = "tumbl"; 
	}
	if($rsteps['hydro_bool']=='yes'){
			
			 $array[] = "hydro"; 
	}
	if($rsteps['quality_bool']=='yes'){
			
			 $array[] = "quality";  
	}
	return $array;

}

function add_lot($id){
	$sql  = "update ".TB_PREF."tlots set process = '1',process_date = '".strtotime(date("m/d/Y"))."' where id = '$id'";
	db_query($sql);
}
function remove_lot($id){
	$sql  = "update ".TB_PREF."tlots set process = '0',process_date = ''  where id = '$id'";
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

function add_steps($lotno,$care,$dye,$bleach,$prep,$hydro,$quality,$tumbler){
$sql = "update ".TB_PREF."steps set 
			care  = '$care', 
			bleach  = '$bleach', 
			prep  = '$prep', 
			quality  = '$quality', 
			tumbl = '$tumbler', 
			dye  = '$dye', 
			hydro = '$hydro' where lotid = '$lotno'
		";
db_query($sql);
}
function remove_steps($lotno ){
$sql = "update ".TB_PREF."steps set 
			care  = '', 
			bleach  = '', 
			prep  = '', 
			quality  = '', 
			tumbl = '', 
			dye  = '', 
			hydro = '' where id = '$lotno'
		";
db_query($sql);
}
?>