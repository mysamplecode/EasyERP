<?php
function get_search_sql_idrep(){
	$sql = " select concat_ws(' ',".TB_PREF."employee.fname,
	".TB_PREF."employee.lname) as ename,
	".TB_PREF."unit.name as uname,
	".TB_PREF."department.name as dname,
	".TB_PREF."employee.id from 
	".TB_PREF."unit,".TB_PREF."employee,".TB_PREF."department 
	where 
	".TB_PREF."unit.id = ".TB_PREF."employee.unitid 
	and ".TB_PREF."department.id = ".TB_PREF."employee.depid ";

	return $sql;
}

?>