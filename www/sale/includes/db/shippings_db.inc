<?php

function checkEmails($email)
{
	$validButRare = "^[a-z0-9,!#\$%&'\*\+/=\?\^_`\{\|}~-]+(\.[a-z0-9,!#\$%&'\*\+/=\?\^_`\{\|}~-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*\.([a-z]{2,})$"; 
	if (eregi($validButRare, $email)) {
	  return true;
	}
	else
	return false;

}

function isValidURL($url)
{
return preg_match('|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i', $url);
}
function get_all_shipping()
{
	$sql = "SELECT * FROM "
		.TB_PREF."sale_shipping ";
	
	return db_query($sql, "could not get customers");
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
function get_search_sql_shippings($shipping_type=null,$air_destination_airport=null,$air_destination_city=null,$air_destination_country=null,$sea_destination_port=null,$sea_destination_city=null,$sea_destination_country=null)
{ 
	$sql = "SELECT shipping_type,air_destination_airport,air_destination_city,air_destination_country,sea_destination_port,sea_destination_city,sea_destination_country,id from ".TB_PREF."sale_shipping where
		shipping_type like ".db_escape('%'.$shipping_type.'%'). " and
		air_destination_airport like ".db_escape('%'.$air_destination_airport.'%'). " and
		air_destination_city like ".db_escape('%'.$air_destination_city.'%'). " and
		air_destination_country like ".db_escape('%'.$air_destination_country.'%'). " and
		sea_destination_port like ".db_escape('%'.$sea_destination_port.'%'). " and
		
		
		sea_destination_city like ".db_escape('%'.$sea_destination_city.'%'). " and
		sea_destination_country like ".db_escape('%'.$sea_destination_country.'%'). " 
	
		";
		return $sql;
} 



function add_shippings($shipping_type=null,$air_destination_airport=null,$air_destination_city=null,$air_destination_country=null,$sea_destination_port=null,$sea_destination_city=null,$sea_destination_country=null)
{
	$sql = "INSERT INTO ".TB_PREF."sale_shipping  (shipping_type,air_destination_airport,air_destination_city,air_destination_country,sea_destination_port,sea_destination_city,sea_destination_country) VALUES ( 
													".db_escape($shipping_type).",
													".db_escape($air_destination_airport).",
													".db_escape($air_destination_city).",
													".db_escape($air_destination_country).",
													".db_escape($sea_destination_port).",
													".db_escape($sea_destination_city).",	
													".db_escape($sea_destination_country)											
													. ")";
	// $sql;
	
	db_query($sql, "could not add shipping");
}
function delete_shippings($id)
{
	$sql="DELETE FROM ".TB_PREF."sale_shipping WHERE id=".db_escape($id);
	db_query($sql,"The customer cannot be deleted");
}
function update_customers($id,$shipping_type=null,$air_destination_airport=null,$air_destination_city=null,$air_destination_country=null,$sea_destination_port=null,$sea_destination_city=null,$sea_destination_country=null)
{

	$sql = "UPDATE ".TB_PREF."sale_shipping SET 	shipping_type=".db_escape($shipping_type).",
													air_destination_airport=".db_escape($air_destination_airport).",
													air_destination_city=".db_escape($air_destination_city).",
													air_destination_country=".db_escape($air_destination_country).",
													sea_destination_port=".db_escape($sea_destination_port).",
													sea_destination_city=".db_escape($sea_destination_city).",	
													sea_destination_country=".db_escape($sea_destination_country)			 
													." WHERE id = ".db_escape($id);
	
	db_query($sql, "could not update shipping");			
}

function get_shippings($id)
{
	$sql = "SELECT * FROM "
		.TB_PREF."sale_shipping 
		WHERE id=".db_escape($id);
	
	$result = db_query($sql, "could not get customer");
	
	return db_fetch($result);
}

?>