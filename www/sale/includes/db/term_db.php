<?php
function get_employee(){
$query = db_query("SELECT concat_ws(' ', fname,lname) as ename,id from ".TB_PREF."employee  ");
return $query;
}

function get_dets($id){ 
		$query = db_query("SELECT   ".TB_PREF."unit.name as uname,".TB_PREF."department.name as depname,".TB_PREF."designation.name as dname,".TB_PREF."employee_status.name as esname,".TB_PREF."employee.picture,".TB_PREF."employee.jdate from ".TB_PREF."employee inner join  ".TB_PREF."unit on ".TB_PREF."unit.id=".TB_PREF."employee.unitid  inner join ".TB_PREF."department on ".TB_PREF."department.id = ".TB_PREF."employee.depid inner join ".TB_PREF."designation on  ".TB_PREF."employee.desigid=".TB_PREF."designation.id inner join ".TB_PREF."employee_status on  ".TB_PREF."employee_status.id=".TB_PREF."employee.statusid    where ".TB_PREF."employee.id = '$id' ");
		return db_fetch_assoc($query);
}
function add_resig($emid = '',$rr = '' ,$nperiod = '',$rdays = ''){
$sql  = "insert into ".TB_PREF."eterm(eid,rr,nperiod,rdays)

				values(
					'".$emid."',
					 ".db_escape($rr)." , 
					'".$nperiod."',
					 ".db_escape($rdays)." 
				)
		
		";

db_query($sql);

}
function update_resig($id,$rr = '',   $rday = ''){
$sql  =	"	update ".TB_PREF."eterm set 
				rr =  ".db_escape($rr)." , 
				rdays = '".$rday."'
			where id = '$id'
		" ;
	db_query($sql);
}

function get_resig($id){
$sql =	"select eid as emid,eid as emidi, rr, nperiod,rdays from ".TB_PREF."eterm where id='$id'" ;
$query = db_query($sql);
return db_fetch_assoc($query);
}
function  get_eterm_sql($name = '',$dep = '',$unit = '',$desig = '',$reason = '',$date = ''){
	$date_conds = '';
 
$sql = "SELECT   concat_ws(' ',".TB_PREF."employee.fname,".TB_PREF."employee.lname) as ename, ".TB_PREF."unit.name as uname,".TB_PREF."department.name as depname,".TB_PREF."designation.name as dname ,".TB_PREF."eterm.rr ,".TB_PREF."eterm.id as rid  from ".TB_PREF."employee inner join  ".TB_PREF."unit on ".TB_PREF."unit.id=".TB_PREF."employee.unitid  inner join ".TB_PREF."department on ".TB_PREF."department.id = ".TB_PREF."employee.depid inner join ".TB_PREF."designation on  ".TB_PREF."employee.desigid=".TB_PREF."designation.id inner join ".TB_PREF."eterm on  ".TB_PREF."eterm.eid=".TB_PREF."employee.id  where 
	concat_ws(' ',".TB_PREF."employee.fname,".TB_PREF."employee.lname)  like ".db_escape("%".$name."%")." and
	".TB_PREF."department.name like ".db_escape("%".$dep."%")." and
	".TB_PREF."unit.name like ".db_escape("%".$unit."%")." and
	".TB_PREF."designation.name  like ".db_escape("%".$desig."%")." and
	".TB_PREF."eterm.rr like ".db_escape("%".$reason."%")." $date_conds

  ";
return $sql;
}

function delete_resig($id){
	$sql = "delete from ".TB_PREF."eterm where id ='$id'";
	db_query($sql);
}
?>