<?php
  
function check_duplicate($name){
	$sql = "select * from "
		.TB_PREF."tsupplier where name=".db_escape($name);
  $res = db_query($sql);
if(db_num_rows($res)>0){
return true;
}else{
return false;
}
}

function get_search_sql_tsupplier($name = null,$address=null,$ntn=null,$contact_pname=null,$contact_pdesig=null,$contact_pno=null,$stype=null)
{ 
	$sql = "SELECT name,address,ntn,contact_pname,contact_pdesig,contact_pno,stype,id from ".TB_PREF."tsupplier where 
        address like ".db_escape('%'.$address.'%')." and  
        name like ".db_escape('%'.$name.'%')." and 
        ntn like ".db_escape('%'.$ntn.'%')." and 
        contact_pname like ".db_escape('%'.$contact_pname.'%')." and 
        contact_pdesig like ".db_escape('%'.$contact_pdesig.'%')." and  
        contact_pno like ".db_escape('%'.$contact_pno.'%')." and 
        stype like ".db_escape('%'.$stype.'%')." " ;
		return $sql;
} 
function add_tsupplier($name,$address=null,$ntn=null,$contact_pname=null,$contact_pdesig=null,$contact_pno=null,$stype=null)
{ 
	$sql = "INSERT INTO ".TB_PREF."tsupplier (name,address,ntn,contact_pname,contact_pdesig,contact_pno,stype) VALUES (
      ".db_escape($name).",
	  ".db_escape($address). ",
      ".db_escape($ntn).",
      ".db_escape($contact_pname).",
      ".db_escape($contact_pdesig).",
      ".db_escape($contact_pno).",
      ".db_escape($stype).")";
	db_query($sql, "could not add unit");
}
function delete_tsupplier($id)
{
	$sql="DELETE FROM ".TB_PREF."tsupplier WHERE id=".db_escape($id);
	db_query($sql,"The unit cannot be deleted");
}
function update_tsupplier($id, $name=null,$address=null,$ntn=null,$contact_pname=null,$contact_pdesig=null,$contact_pno=null,$stype=null)
{
 
	$sql = "UPDATE ".TB_PREF."tsupplier SET 
          name=".db_escape($name)." ,
          address=".db_escape($address)." ,
          ntn=".db_escape($ntn)." ,
          contact_pname=".db_escape($contact_pname).",
          contact_pdesig=".db_escape($contact_pdesig).",
          contact_pno=".db_escape($contact_pno).",
          stype=".db_escape($stype)." WHERE id = ".db_escape($id);
	
	db_query($sql, "could not update unit");			
}

function get_tsupplier($id)
{
	$sql = "SELECT * FROM "
		.TB_PREF."tsupplier 
		WHERE id=".db_escape($id);
	
	$result = db_query($sql, "could not get Unit");
	
	return db_fetch($result);
}
?>