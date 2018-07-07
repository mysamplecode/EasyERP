<?php
function get_all_banks()
{
	$sql = "SELECT * FROM "
		.TB_PREF."bank ";
	
	return db_query($sql, "could not get banks");
} 


function check_bank($name){
$sql = "select * from "
		.TB_PREF."bank where name=".db_escape($name);
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
function get_search_sql_bank($name=null,$country=null,$swift=null,$branch=null,$branch_no=null,$adress=null,$city=null,$province=null,$postal=null)
{ 
	$sql = "SELECT name,country,branch,branch_no,swift,adress,city,province,postal,id from ".TB_PREF."bank where
		name like ".db_escape('%'.$name.'%'). " and
		country like ".db_escape('%'.$country.'%'). " and
		swift like ".db_escape('%'.$swift.'%'). " and
		branch like ".db_escape('%'.$branch.'%'). " and
		branch_no like ".db_escape('%'.$branch_no.'%'). " and
		adress like ".db_escape('%'.$adress.'%'). " and
		city like ".db_escape('%'.$city.'%'). " and
		province like ".db_escape('%'.$province.'%'). " and
		postal like ".db_escape('%'.$postal.'%'). "
		";
		return $sql;
} 



 
function add_bank($name=null,$country=null,$swift=null,$branch=null,$branch_no=null,$adress=null,$city=null,$province=null,$postal=null)
{
	$sql = "INSERT INTO ".TB_PREF."bank (name,country,swift,branch,branch_no,adress,city,province,postal) VALUES (".db_escape($name)
			. ",
			".db_escape($country)
			. ",
			".db_escape($swift)
			. ",
			".db_escape($branch)
			. ",
			".db_escape($branch_no)
			. ",
			".db_escape($adress)
			. ",
			".db_escape($city)
			. ",
			".db_escape($province)
			. ",
			".db_escape($postal)
			. ")";
	db_query($sql, "could not add bank");
}
function delete_bank($id)
{
	$sql="DELETE FROM ".TB_PREF."bank WHERE id=".db_escape($id);
	db_query($sql,"The leave cannot be deleted");
}
function update_bank($id,$name=null,$country=null,$swift=null,$branch=null,$branch_no=null,$adress=null,$city=null,$province=null,$postal=null)
{

	$sql = "UPDATE ".TB_PREF."bank SET name=".db_escape($name)
				.",
	country=".db_escape($country)
				.",
	swift=".db_escape($swift)
				.",
	branch=".db_escape($branch)
				.",
	branch_no=".db_escape($branch_no)
				.",
	adress=".db_escape($adress)
				.",
	city=".db_escape($city)
				.",
	province=".db_escape($province)
				.",
	postal=".db_escape($postal)
				." WHERE id = ".db_escape($id);
	
	db_query($sql, "could not update bank");			
}

function get_bank($id)
{
	$sql = "SELECT * FROM "
		.TB_PREF."bank 
		WHERE id=".db_escape($id);
	
	$result = db_query($sql, "could not get bank");
	
	return db_fetch($result);
}
?>