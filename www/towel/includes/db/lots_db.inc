<?php
function get_all_inventories(){
$sql = "select id from ".TB_PREF."tinventory  ";

 
	$result = db_query($sql);
	
	return $result;
}
function get_bales_sql($id){
 
$sql = "select  ".TB_PREF."tsize.name as tsize , ".TB_PREF."tbales.bale,".TB_PREF."tbales.gweight,".TB_PREF."tbales.nweight,".TB_PREF."tbales.npieces,".TB_PREF."tsupplier.name as supl,".TB_PREF."tinventory.id as ino,".TB_PREF."tinventory.gate_in,".TB_PREF."tbales.id from ".TB_PREF."tbales, ".TB_PREF."tsupplier,".TB_PREF."tinventory,".TB_PREF."tsize where ".TB_PREF."tbales.invid = '$id' and ".TB_PREF."tbales.lotid = '0' and ".TB_PREF."tbales.tsize  = ".TB_PREF."tsize.id and ".TB_PREF."tinventory.id = '$id' and  ".TB_PREF."tsupplier.id = ".TB_PREF."tinventory.sup";

  
	
	return $sql;


}
function get_baleslot_sql($id = -1){
 
$sql = "select  ".TB_PREF."tsize.name as tsize , ".TB_PREF."tbales.bale,".TB_PREF."tbales.gweight,".TB_PREF."tbales.nweight,".TB_PREF."tbales.npieces,".TB_PREF."tsupplier.name as supl,".TB_PREF."tinventory.id as ino,".TB_PREF."tinventory.gate_in,".TB_PREF."tbales.id from ".TB_PREF."tbales, ".TB_PREF."tsupplier,".TB_PREF."tinventory,".TB_PREF."tsize where   ".TB_PREF."tbales.lotid = '$id' and ".TB_PREF."tbales.tsize  = ".TB_PREF."tsize.id and ".TB_PREF."tinventory.id = ".TB_PREF."tbales.invid  and  ".TB_PREF."tsupplier.id = ".TB_PREF."tinventory.sup";

  
	
	return $sql;


}

function get_total_itemst($id ){
	$sql = "select sum(bale) as total from ".TB_PREF."tbales where lotid = '$id'  or lotid = '-1' ";
	$result = db_query($sql);
	$rows = db_fetch_assoc($result);
	return $rows['total'];
}
function get_total_nweightt($id ){
	$sql = "select sum(nweight) as total   from ".TB_PREF."tbales where lotid = '$id' or lotid = '-1' ";
	$result = db_query($sql);
	$rows = db_fetch_assoc($result);
	return $rows['total'];

}
function get_total_gweightt( $id){
	$sql = "select sum(gweight) as total from ".TB_PREF."tbales where lotid = '$id' or lotid = '-1'  ";
	$result = db_query($sql);
	$rows = db_fetch_assoc($result);
	return $rows['total'];

}
function add_lot($id,$desc,$pdate){

$sql = "insert into ".TB_PREF."tlots(lno,descr,pdate) values('$id',".db_escape($desc).",'$pdate')";
db_query($sql);
return db_insert_id();
}
function update_lot($lid,$id,$desc,$pdate){

$sql = "update ".TB_PREF."tlots set descr = ".db_escape($desc).", pdate = '$pdate',lno = '$id' where id = '$lid'";
db_query($sql); 
}
function check_duplicate($field,$value,$table,$old){
$sql  = "select * from ".TB_PREF."$table where $field = '$value' and $field<>'$old'";
$result = db_query($sql);
if(db_num_rows($result)>0){
	return true;
}else{
	return false;
}
}

function add_steps($id,$prep = 'no',$care = 'no',$bleach = 'no',$dye = 'no',$hydro = 'no',$tum = 'no',$qual = 'no'){
$sql = "insert into ".TB_PREF."steps(prep_bool,care_bool,bleach_bool,dye_bool,hydro_bool,tumbler_bool,quality_bool,lotid) values('$prep','$care','$bleach','$dye','$hydro','$tum','$qual','$id')";

db_query($sql);

}
function update_steps($id,$prep = 'no',$care = 'no',$bleach = 'no',$dye = 'no',$hydro = 'no',$tum = 'no',$qual = 'no'){
$sql = "update ".TB_PREF."steps set  prep_bool = '$prep' ,care_bool = '$care',bleach_bool = '$bleach',  dye_bool = '$dye',hydro_bool = '$hydro',tumbler_bool = '$tum',quality_bool = '$qual'   ";

db_query($sql);

}

function  get_lot_sql($id,$descr,$date){
$date_cond = array();
if($date!=strtotime("01/01/1970")) {
	$date_cond[] = " pdate  =  '$date'";
}
if($id!=''){
	$date_cond[] = " lno like    '%$id%'  ";

}
if($descr!=''){

	$date_cond[] = " descr like   '%$descr%'";
}
$str = '';
if(count($date_cond)>0){

	$str = " where ".implode(" and ",$date_cond	);
}
$sql = "select lno,descr,pdate,id,issue from ".TB_PREF."tlots $str";
return $sql;
}
function add_bales($id){
db_query("update ".TB_PREF."tbales set lotid = '$id' where lotid = '-1'");
}
function check_tolerance($value){
	$value = (int)$value;
	$result = db_query("select lsize, tol from ".TB_PREF."teparam limit 1");
	
	$rows = db_fetch_assoc($result);
	
	$tol = (int)$rows['tol'];
	$lsize = (int)$rows['lsize'];
	
	if($value>=($lsize-($lsize/$tol)) && $value<=($lsize+($lsize/$tol))){
	
		return false;
	}
	else{
		return true;
	}
}
function delete_lot($id){
$sql = "delete from ".TB_PREF."tlots where id = '$id'";
db_query($sql);

$sql = "delete from ".TB_PREF."steps where lotid = '$id'";
db_query($sql);
$sql = "update ".TB_PREF."tbales set lotid = '0' where lotid = '$id' ";
db_query($sql);

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
function get_lot($id){
 $sql = "select * from ".TB_PREF."tlots where id = '$id'";
 $result = db_query($sql);
 return db_fetch_assoc($result);
}
function get_ent_name($col,$table,$id){
$sql = "select $col as item from ".TB_PREF."$table where id = '$id'";

 
	$result = db_query($sql);
	$rows = db_fetch_assoc($result);
	return $rows['item'];
}
function get_steps($id){
	
$sql = "select prep_bool,care_bool,bleach_bool,dye_bool,hydro_bool,tumbler_bool,quality_bool from ".TB_PREF."steps where lotid = '$id'";

	$result = db_query($sql);
	return db_fetch_assoc($result);
}
?>