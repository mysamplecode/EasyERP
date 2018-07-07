<?php
 

function get_search_sql_tsize($name = null,$width=null,$length=null,$weight=null)
{ 
	$sql = "SELECT name,width,length,weight,id from ".TB_PREF."tsize where 
        name like ".db_escape('%'.$name.'%')." and  
        width like ".db_escape('%'.$width.'%')." and  
        weight like ".db_escape('%'.$length.'%')." and 
        length like ".db_escape('%'.$weight.'%');
		return $sql;
} 
function add_tsize($name = null,$width=null,$length=null,$weight=null)
{ 
	$sql = "INSERT INTO ".TB_PREF."tsize (name,width,length,weight) VALUES (
      ".db_escape($name). ",
      ".db_escape($width). ",
      ".db_escape($length).",
      ".db_escape($weight).")";
	db_query($sql, "could not add unit");
}
function delete_tsize($id)
{
	$sql="DELETE FROM ".TB_PREF."tsize WHERE id=".db_escape($id);
	db_query($sql,"The unit cannot be deleted");
}
function update_tsize($id, $name= null,$width=null,$length=null,$weight=null)
{
 
	$sql = "UPDATE ".TB_PREF."tsize SET 
          name=".db_escape($name)." ,
          width=".db_escape($width)." ,
          length=".db_escape($length)." ,
          weight=".db_escape($weight)." WHERE id = ".db_escape($id);
	
	db_query($sql, "could not update unit");			
}

function get_tsize($id)
{
	$sql = "SELECT * FROM "
		.TB_PREF."tsize
		WHERE id=".db_escape($id);
	
	$result = db_query($sql, "could not get Unit");
	
	return db_fetch($result);
}
?>