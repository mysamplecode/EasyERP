<?php
 

function get_search_sql_eparam($lsize=null,$tol=null,$lpre=null,$care=null,$bleach=null,$dye=null,$hydro=null,$tum=null,$qua=null)
{ 
	$sql = "SELECT lsize,tol,lpre,care,bleach,dye,hydro,tum,qua,id from ".TB_PREF."teparam where 
        lsize like ".db_escape('%'.$lsize.'%')." and  
        tol like ".db_escape('%'.$tol.'%')." and 
        lpre like ".db_escape('%'.$lpre.'%')." and  
        care like ".db_escape('%'.$care.'%')." and 
        bleach like ".db_escape('%'.$bleach.'%')." and  
        dye like ".db_escape('%'.$dye.'%')." and 
        hydro like ".db_escape('%'.$hydro.'%')." and  
        tum like ".db_escape('%'.$tum.'%')." and 
        qua like ".db_escape('%'.$qua.'%');
		return $sql;
} 
function add_eparam($lsize=null,$tol=null,$lpre=null,$care=null,$bleach=null,$dye=null,$hydro=null,$tum=null,$qua=null)
{ 
	$sql = "INSERT INTO ".TB_PREF."teparam (lsize,tol,lpre,care,bleach,dye,hydro,tum,qua) VALUES (
      ".db_escape($lsize). ",
      ".db_escape($tol).",
      ".db_escape($lpre).",
      ".db_escape($care).",
      ".db_escape($bleach).",
      ".db_escape($dye).",
      ".db_escape($hydro).",
      ".db_escape($tum).",
      ".db_escape($qua).")";
	db_query($sql, "could not add unit");
}
function delete_eparam($id)
{
	$sql="DELETE FROM ".TB_PREF."teparam WHERE id=".db_escape($id);
	db_query($sql,"The unit cannot be deleted");
}
function update_eparam($id, $lsize=null,$tol=null,$lpre=null,$care=null,$bleach=null,$dye=null,$hydro=null,$tum=null,$qua=null)
{
 
	$sql = "UPDATE ".TB_PREF."teparam SET 
          lsize=".db_escape($lsize)." ,
          tol=".db_escape($tol)." ,
          lpre=".db_escape($lpre)." ,
          care=".db_escape($care)." ,
          bleach=".db_escape($bleach)." ,
          dye=".db_escape($dye)." ,
          hydro=".db_escape($hydro)." ,
          tum=".db_escape($tum)." ,
          qua=".db_escape($qua)." WHERE id = ".db_escape($id);
	
	db_query($sql, "could not update unit");			
}

function get_eparam($id)
{
	$sql = "SELECT * FROM "
		.TB_PREF."teparam
		WHERE id=".db_escape($id);
	
	$result = db_query($sql, "could not get Unit");
	
	return db_fetch($result);
}
?>