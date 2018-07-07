<?php
function add_inventory($ino,$sup,$gate_in,$igp,$goods,$driver,$vehicle,$builty,$gate_out,$recv,$recvby){

$sql = "insert into ".TB_PREF."tinventory(id,sup,gate_in, igp,goods,driver,vehicle,builty,gate_out,recv,recvby) values(
		".db_escape($ino).",
		".db_escape($sup).",
		".db_escape($gate_in).",
		".db_escape($igp).",
		".db_escape($goods).",
		".db_escape($driver).",
		".db_escape($vehicle).",
		".db_escape($builty).",
		".db_escape($gate_out).",
		".db_escape($recv).", 
		".db_escape($recvby)."
		)";
	db_query($sql);
	return db_insert_id();
}

function add_bale($id,$tsize,$bale, $pally,$gweight,$nweight,$shade,$taginfo,$remarks,$ptype,$npieces){

$sql = "insert into ".TB_PREF."tbales(tsize,bale,pally, gweight,nweight,shade,taginfo,remarks,ptype,npieces,invid) values(
		".db_escape($tsize).",
		".db_escape($bale).",
		".db_escape($pally).",
		".db_escape($gweight).",
		".db_escape($nweight).",
		".db_escape($shade).",
		".db_escape($taginfo).",
		".db_escape($remarks).",
		".db_escape($ptype)." ,
		".db_escape($npieces)." ,
		".db_escape($id)." 
		)";
	db_query($sql);

}
function get_search_sql_tinventory(){
$sql = "select ".TB_PREF."tsupplier.name, ".TB_PREF."tinventory.igp, ".TB_PREF."tinventory.id from ".TB_PREF."tinventory,".TB_PREF."tsupplier where ".TB_PREF."tinventory.sup = ".TB_PREF."tsupplier.id ";

return $sql;
}
function get_search_sql_tbale($id){
$sql = "select ".TB_PREF."tsize.name, ".TB_PREF."tbales.bale, ".TB_PREF."tbales.gweight, ".TB_PREF."tbales.nweight,".TB_PREF."tbales.id from ".TB_PREF."tbales,".TB_PREF."tsize where ".TB_PREF."tbales.tsize = ".TB_PREF."tsize.id and invid = '$id' and lotid = '0'";

return $sql;
}
function get_inventory($id){
	$sql = "SELECT id as ino,sup,gate_in, igp,goods,driver,vehicle,builty,gate_out,recv,recvby FROM "
		.TB_PREF."tinventory
		WHERE id=".db_escape($id);
	
	$result = db_query($sql, "could not get Unit");
	
	return db_fetch_assoc($result);

}
function get_bale($id){
$sql = "select ".TB_PREF."tbales.npieces,".TB_PREF."tbales.tsize,".TB_PREF."tbales.bale,".TB_PREF."tsize.name,".TB_PREF."tbales.pally,".TB_PREF."tbales.gweight,".TB_PREF."tbales.nweight,".TB_PREF."tbales.shade,".TB_PREF."tbales.taginfo,".TB_PREF."tbales.remarks,".TB_PREF."tbales.ptype from ".TB_PREF."tbales,".TB_PREF."tsize where ".TB_PREF."tbales.tsize = ".TB_PREF."tsize.id and ".TB_PREF."tbales.id='$id'";
	
	$result = db_query($sql, "could not get Unit");
	
	return db_fetch_assoc($result);

}
function update_inventory($id,$ino, $sup,$gate_in,$igp,$goods,$driver,$vehicle,$builty,$gate_out,$recv,$recvby){
$sql = "update ".TB_PREF."tinventory 
		set id = ".db_escape($ino).",
		 sup = ".db_escape($sup).",
		  gate_in = ".db_escape($gate_in).",
		  igp = ".db_escape($igp).",
		  goods = ".db_escape($goods).",
		  driver = ".db_escape($driver).",
		 vehicle = ".db_escape($vehicle).",
		  builty = ".db_escape($builty).",
		  gate_out = ".db_escape($gate_out).",
		  recv = ".db_escape($recv).", 
		 recvby = ".db_escape($recvby)." where id = '$id'" ;
	db_query($sql); 

}
function update_bale($id,$tsize,$bale, $pally,$gweight,$nweight,$shade,$taginfo,$remarks,$ptype,$npieces){
$sql = "update ".TB_PREF."tbales
		set tsize = ".db_escape($tsize).",
		  bale = ".db_escape($bale).",
		  pally = ".db_escape($pally).",
		  gweight = ".db_escape($gweight).",
		  nweight = ".db_escape($nweight).",
		  shade = ".db_escape($shade).",
		  taginfo = ".db_escape($taginfo).",
		  remarks = ".db_escape($remarks).",
		  npieces = ".db_escape($npieces).",
		  ptype = ".db_escape($ptype)." where id = '$id'" ;  
	db_query($sql); 

}
function get_total_itemst($id){
	$sql = "select sum(bale) as total from ".TB_PREF."tbales where invid = '$id' ";
	$result = db_query($sql);
	$rows = db_fetch_assoc($result);
	return $rows['total'];
}
function get_total_nweightt($id){
	$sql = "select sum(nweight) as total   from ".TB_PREF."tbales where invid = '$id' ";
	$result = db_query($sql);
	$rows = db_fetch_assoc($result);
	return $rows['total'];

}
function get_total_gweightt($id){
	$sql = "select sum(gweight) as total from ".TB_PREF."tbales where invid = '$id' ";
	$result = db_query($sql);
	$rows = db_fetch_assoc($result);
	return $rows['total'];

}

function delete_bale($id){
$sql = "delete from ".TB_PREF."tbales where id = '$id'"; 
db_query($sql);
}
function delete_inventory($id){
$sql = "delete from ".TB_PREF."tinventory where id = '$id'";
db_query($sql);
}

function get_ent_name($col,$table,$id){
$sql = "select $col as item from ".TB_PREF."$table where id = '$id'";

 
	$result = db_query($sql);
	$rows = db_fetch_assoc($result);
	return $rows['item'];
}
function check_duplicate($field,$value,$table,$old){
$sql  = "select id from ".TB_PREF."$table where $field = '$value' and $field<>'$old'";
$result = db_query($sql);
if(db_num_rows($result)>0){
	return true;
}else{
	return false;
}
}
?>