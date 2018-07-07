<?php
function get_all_Type(){
$sql = "SELECT * FROM "
		.TB_PREF."sale_order_type ";
	
	return db_query($sql, "could not get customers");

}
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
function get_all_customers()
{
	$sql = "SELECT * FROM "
		.TB_PREF."cust_branch ";
	
	return db_query($sql, "could not get customers");
} 


function check_email($email){
$sql = "select * from "
		.TB_PREF."cust_branch where email=".db_escape($email);
  $res = db_query($sql);
if(db_num_rows($res)>0){
return true;
}else{
return false;
}

}

function check_contact_email($email){
$sql = "select * from "
		.TB_PREF."cust_branch where cont_email=".db_escape($email);
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
function get_search_sql_customer($customer_type=null,$name=null,$code=null,$address=null,$city=null,$state=null,$country=null,$website=null,$postal=null,$phone=null,$fax=null,$email=null,$cont_name=null,$cont_designation=null,$cont_number=null,$cont_email=null)
{ 
/*a.address,a.city,a.state,a.country,a.website,a.postal,*/
	$sql = "SELECT b.type ,a.name,a.code,a.telephone,a.fax,a.email,a.cont_name,a.cont_designation,a.cont_number,a.cont_email,a.branch_code from ".TB_PREF."cust_branch a join ".TB_PREF."sale_order_type b on (a.customer_type=b.id)  where 
		a.customer_type like ".db_escape('%'.$customer_type.'%'). " and
		a.name like ".db_escape('%'.$name.'%'). " and
		a.code like ".db_escape('%'.$code.'%'). " and
		a.address like ".db_escape('%'.$address.'%'). " and
		a.city like ".db_escape('%'.$city.'%'). " and
		
		
		a.state like ".db_escape('%'.$state.'%'). " and
		a.country like ".db_escape('%'.$country.'%'). " and
		a.website like ".db_escape('%'.$website.'%'). " and
		a.postal like ".db_escape('%'.$postal.'%'). " and
		a.telephone like ".db_escape('%'.$phone.'%'). " and
		a.fax like ".db_escape('%'.$fax.'%'). " and
		a.email like ".db_escape('%'.$email.'%'). " and
		a.cont_name like ".db_escape('%'.$cont_name.'%'). " and
		a.cont_designation like ".db_escape('%'.$cont_designation.'%'). " and
		a.cont_number like ".db_escape('%'.$cont_number.'%'). " and
		a.cont_email like ".db_escape('%'.$cont_email.'%'). " 
	
		";
		
		return $sql;
} 



function add_customers($customer_type=null,$name=null,$code=null,$address=null,$city=null,$state=null,$country=null,$website=null,$postal=null,$phone=null,$fax=null,$email=null,$cont_name=null,$cont_designation=null,$cont_number=null,$cont_email=null)
{
	$sql = "INSERT INTO ".TB_PREF."cust_branch  (customer_type,name,code,address,city,state,country,website,postal,telephone,fax,email,cont_name,cont_designation,cont_number,cont_email) VALUES ( 
													".db_escape($customer_type).",
													".db_escape($name).",
													".db_escape($code).",
													".db_escape($address).",
													".db_escape($city).",
													".db_escape($state).",	
													".db_escape($country).",
													".db_escape($website).",
													".db_escape($postal).",
													".db_escape($phone).",
													".db_escape($fax).",
    												".db_escape($email).",
													".db_escape($cont_name).",
													".db_escape($cont_designation).",
													".db_escape($cont_number).",
													".db_escape($cont_email)
													. ")";
	// $sql;
	
	db_query($sql, "could not add customer");
}
function delete_customers($id)
{
	$sql="DELETE FROM ".TB_PREF."cust_branch WHERE branch_code=".db_escape($id);
	db_query($sql,"The customer cannot be deleted");
}
function update_customers($id,$customer_type=null,$name=null,$code=null,$address=null,$city=null,$state=null,$country=null,$website=null,$postal=null,$phone=null,$fax=null,$email=null,$cont_name=null,$cont_designation=null,$cont_number=null,$cont_email=null)
{

	$sql = "UPDATE ".TB_PREF."cust_branch SET customer_type=".db_escape($customer_type)
				.",
	name=".db_escape($name)
				.",
	code=".db_escape($code)
				.",
	address=".db_escape($address)
				.",
	city=".db_escape($city)
				.",
	state=".db_escape($state)
				.",
	city=".db_escape($city)
				.",
	country=".db_escape($country)
				.",
	website=".db_escape($website)
				.",
	postal=".db_escape($postal)
				.",
	telephone=".db_escape($phone)
				.",
	fax=".db_escape($fax)
				.",
    email=".db_escape($email)
				.",
	cont_name=".db_escape($cont_name)
				.",
	cont_designation=".db_escape($cont_designation)
				.",
	cont_number=".db_escape($cont_number)
				.",
	cont_email=".db_escape($cont_email)
				." WHERE branch_code = ".db_escape($id);
	
	db_query($sql, "could not update customer");			
}

function get_customers($id)
{
	$sql = "SELECT * FROM "
		.TB_PREF."cust_branch 
		WHERE branch_code=".db_escape($id);
	
	$result = db_query($sql, "could not get customer");
	
	return db_fetch($result);
}

?>