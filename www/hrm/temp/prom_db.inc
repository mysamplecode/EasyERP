<?php



function add_prom($emid = '',$rr = '',$cid= '',$pid = ''){
$sql  = "insert into ".TB_PREF."epromdem(eid,res,cid,pid)

				values(
					'".$emid."',
					 ".db_escape($rr)." ,
					'".$cid."',
					'".$pid."' 
				)
		
		";

db_query($sql);
db_query("update ".TB_PREF."employee set desigid = '$pid' ");
}
function update_prom($id,$rr = '',$pid = ''){
$sql  =	"	update ".TB_PREF."epromdem set 
				res =  ".db_escape($rr)." , 
				pid = '".$pid."'
			where id = '$id'
		" ;
	db_query($sql);
}

function get_prom($id){
$sql =	"select eid as emid,eid as emidi, pid,res,cid from ".TB_PREF."epromdem where id='$id'" ;
$query = db_query($sql);
return db_fetch_assoc($query);
}
function  get_eprom_sql($name = '',$dep = '',$unit = '',$desig = '',$reason = '' ){
  
$sql = "SELECT   concat_ws(' ',".TB_PREF."employee.fname,".TB_PREF."employee.lname) as ename, ".TB_PREF."unit.name as uname,".TB_PREF."department.name as depname,".TB_PREF."designation.name as dname ,".TB_PREF."epromdem.res,".TB_PREF."epromdem.id  from ".TB_PREF."employee inner join  ".TB_PREF."unit on ".TB_PREF."unit.id=".TB_PREF."employee.unitid  inner join ".TB_PREF."department on ".TB_PREF."department.id = ".TB_PREF."employee.depid inner join ".TB_PREF."designation on  ".TB_PREF."employee.desigid=".TB_PREF."designation.id inner join ".TB_PREF."epromdem on  ".TB_PREF."epromdem.eid=".TB_PREF."employee.id  where 
	concat_ws(' ',".TB_PREF."employee.fname,".TB_PREF."employee.lname)  like ".db_escape("%".$name."%")." and
	".TB_PREF."department.name like ".db_escape("%".$dep."%")." and
	".TB_PREF."unit.name like ".db_escape("%".$unit."%")." and
	".TB_PREF."designation.name  like ".db_escape("%".$desig."%")." and
	".TB_PREF."epromdem.res like ".db_escape("%".$reason."%")." 

  ";
return $sql;
}

function delete_prom($id){
	$sql = "delete from ".TB_PREF."epromdem where id ='$id'";
	db_query($sql);
}
?>