<?php
function get_all_sales()
{
	$sql = "SELECT * FROM "
		.TB_PREF."sale_order_type ";
	
	return db_query($sql, "could not get sales");
} 


function check_sale($type){
$sql = "select * from "
		.TB_PREF."sale_order_type where type=".db_escape($type);
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
function get_search_sql_sale($type=null,$description=null)
{ 
	$sql = "SELECT type,description,id from ".TB_PREF."sale_order_type where
		type like ".db_escape('%'.$type.'%'). " and
		description like ".db_escape('%'.$description.'%'). " 
		
		";
		return $sql;
} 



 
function add_sale($type=null,$description=null)
{
	
	$sql = "INSERT INTO ".TB_PREF."sale_order_type (type,description) VALUES (
			".db_escape($type)
			. ",
			".db_escape($description)
			. ")";
	db_query($sql, "could not add sales type");
}
function delete_sale($id)
{
	$sql="DELETE FROM ".TB_PREF."sale_order_type WHERE id=".db_escape($id);
	db_query($sql,"The sales type cannot be deleted");
}
function update_sale($id,$type=null,$description=null)
{

			
			$sql = "UPDATE ".TB_PREF."sale_order_type SET type=".db_escape($type)
				.",
	description=".db_escape($description)
	
				." WHERE id = ".db_escape($id);
	
	
	db_query($sql, "could not update sales type");			
}

function get_sale($id)
{
	$sql = "SELECT * FROM "
		.TB_PREF."sale_order_type 
		WHERE id=".db_escape($id);
	
	$result = db_query($sql, "could not get sales type");
	
	return db_fetch($result);
}
function getRandomeCustomerTypeId()
{
	 	$length = 8;
	   $characters = "0123456789abcdefghijklmnopqrstuvwxyz";
	   $string = '';    
	   for($p=0; $p < $length; $p++){
		 $st=mt_rand(0, 30);
		$string .= $characters[$st];
		  }
	   return $string;
}
?>