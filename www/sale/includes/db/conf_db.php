<?php
function get_employee(){
	$query = db_query("SELECT concat_ws(' ', fname,lname) as ename,id from ".TB_PREF."employee ");
	return $query;
}

function get_dets($id){ 
		$query = db_query("SELECT   ".TB_PREF."unit.name as uname,".TB_PREF."department.name as depname,".TB_PREF."designation.name as dname,".TB_PREF."designation.id as did,".TB_PREF."employee_status.name as esname,".TB_PREF."employee.picture,".TB_PREF."employee.jdate from ".TB_PREF."employee inner join  ".TB_PREF."unit on ".TB_PREF."unit.id=".TB_PREF."employee.unitid  inner join ".TB_PREF."department on ".TB_PREF."department.id = ".TB_PREF."employee.depid inner join ".TB_PREF."designation on  ".TB_PREF."employee.desigid=".TB_PREF."designation.id inner join ".TB_PREF."employee_status on  ".TB_PREF."employee_status.id=".TB_PREF."employee.statusid    where ".TB_PREF."employee.id = '$id' ");
		return db_fetch_assoc($query);
}
function add_conf($emid = '',$res = '',$dt){
$sql  = "insert into ".TB_PREF."econf(eid,res,dt)

				values(
					'".$emid."',
					 ".db_escape($res)." , 
					 ".db_escape($dt)."  
				)
		
		"; 
db_query($sql,"error"); 
}
function update_conf($id,$res = '',$dt){
$sql  =	"	update ".TB_PREF."econf set 
				res =  ".db_escape($res)." ,
				dt =  ".db_escape($dt)."  
			where id = '$id'
		" ; 
	db_query($sql,'error');
}

function get_conf($id){
$sql =	"select eid as emid,eid as emidi, res,dt from ".TB_PREF."econf where id='$id'" ;
$query = db_query($sql);
return db_fetch_assoc($query);
} 
function  get_econf_sql($name = '',$dep = '',$unit = '',$desig = '' ){
  
$sql = "SELECT   concat_ws(' ',".TB_PREF."employee.fname,".TB_PREF."employee.lname) as ename, ".TB_PREF."unit.name as uname,".TB_PREF."department.name as depname,".TB_PREF."designation.name as dname  ,".TB_PREF."econf.id  from ".TB_PREF."employee inner join  ".TB_PREF."unit on ".TB_PREF."unit.id=".TB_PREF."employee.unitid  inner join ".TB_PREF."department on ".TB_PREF."department.id = ".TB_PREF."employee.depid inner join ".TB_PREF."designation on  ".TB_PREF."employee.desigid=".TB_PREF."designation.id inner join ".TB_PREF."econf on  ".TB_PREF."econf.eid=".TB_PREF."employee.id    where 
	concat_ws(' ',".TB_PREF."employee.fname,".TB_PREF."employee.lname)  like ".db_escape("%".$name."%")." and
	".TB_PREF."department.name like ".db_escape("%".$dep."%")." and
	".TB_PREF."unit.name like ".db_escape("%".$unit."%")." and
	".TB_PREF."designation.name  like ".db_escape("%".$desig."%")." 

  ";
return $sql;
}

function delete_conf($id){
	$sql = "delete from ".TB_PREF."econf where id ='$id'";
	db_query($sql);
}
 
?>