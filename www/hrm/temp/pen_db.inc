<?php


function add_pen($emid = '',$res = '',$lid= '',$no = '',$yearid = ''){
$sql  = "insert into ".TB_PREF."epenal(eid,res,lid,no,yearid)

				values(
					'".$emid."',
					 ".db_escape($res)." ,
					'".$lid."',
					'".$no."' ,
					'".$yearid."' 
				)
		
		";

db_query($sql,"error"); 
}
function update_pen($id,$res = '',$lid= '',$no = '',$yearid = ''){
$sql  =	"	update ".TB_PREF."epenal set 
				res =  ".db_escape($res)." ,
				lid =  ".db_escape($lid)." ,
				no =  ".db_escape($no)." , 
				yearid = '".$yearid."'
			where id = '$id'
		" ; 
	db_query($sql,'error');
}

function get_pen($id){
$sql =	"select eid as emid,eid as emidi, res,lid,no,yearid from ".TB_PREF."epenal where id='$id'" ;
$query = db_query($sql);
return db_fetch_assoc($query);
}
function  get_epen_sql($name = '',$dep = '',$unit = '',$desig = '',$lname = '' ){
  
$sql = "SELECT   concat_ws(' ',".TB_PREF."employee.fname,".TB_PREF."employee.lname) as ename, ".TB_PREF."unit.name as uname,".TB_PREF."department.name as depname,".TB_PREF."designation.name as dname ,".TB_PREF."leave.name as lvname,".TB_PREF."epenal.id  from ".TB_PREF."employee inner join  ".TB_PREF."unit on ".TB_PREF."unit.id=".TB_PREF."employee.unitid  inner join ".TB_PREF."department on ".TB_PREF."department.id = ".TB_PREF."employee.depid inner join ".TB_PREF."designation on  ".TB_PREF."employee.desigid=".TB_PREF."designation.id inner join ".TB_PREF."epenal on  ".TB_PREF."epenal.eid=".TB_PREF."employee.id inner join ".TB_PREF."leave on ".TB_PREF."leave.id = ".TB_PREF."epenal.lid  where 
	concat_ws(' ',".TB_PREF."employee.fname,".TB_PREF."employee.lname)  like ".db_escape("%".$name."%")." and
	".TB_PREF."department.name like ".db_escape("%".$dep."%")." and
	".TB_PREF."unit.name like ".db_escape("%".$unit."%")." and
	".TB_PREF."designation.name  like ".db_escape("%".$desig."%")." and
	".TB_PREF."leave.name like ".db_escape("%".$lname."%")." 

  ";
return $sql;
}

function delete_pen($id){
	$sql = "delete from ".TB_PREF."epenal where id ='$id'";
	db_query($sql);
}

?>