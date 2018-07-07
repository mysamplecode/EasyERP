<?php

function get_all_unit_ids()
{
	$sql = "SELECT name,id FROM "
		.TB_PREF."unit ";
	
	return db_query($sql, "could not get unit");
} 
function get_all_dep_ids($unit)
{
	$sql = "SELECT name,id FROM "
		.TB_PREF."department where unitid=".db_escape($unit);
	
	return db_query($sql, "could not get department");
}

function get_ent_name($id,$table){
$res = db_query("select name from   ".TB_PREF."$table order by id desc limit 1");
$row = db_fetch($res);
return $row['name'];

}
function get_all_desig_ids()
{
	$sql = "SELECT name,id FROM "
		.TB_PREF."designation";
	
	return db_query($sql, "could not get department");
} 
function get_all_items($table){
	$sql = "SELECT name,id FROM "
		.TB_PREF."$table ";
	
	return db_query($sql, "could not get item");


}
function get_employee($id){
	$sql = "SELECT * FROM ".TB_PREF."employee  where id=".db_escape($id);
	$result = db_query($sql, "could not get employee");
	
	return db_fetch($result);

}
function get_ehistory($id){
	$sql = "SELECT * FROM ".TB_PREF."employment_history  where id=".db_escape($id);
	$result = db_query($sql, "could not get employee");
	
	return db_fetch($result);

}
function get_erefer($id){
	$sql = "SELECT * FROM ".TB_PREF."references  where id=".db_escape($id);
	$result = db_query($sql, "could not get employee");
	
	return db_fetch($result);

}
function get_equalify($id){
	$sql = "SELECT * FROM ".TB_PREF."course  where id=".db_escape($id);
	$result = db_query($sql, "could not get employee");
	
	return db_fetch($result);

}
function get_edepend($id){
	$sql = "SELECT * FROM ".TB_PREF."dependent  where id=".db_escape($id);
	$result = db_query($sql, "could not get employee");
	
	return db_fetch($result);

}
function get_salary2($id){
	$sql = "SELECT * FROM ".TB_PREF."salary_details  where id=".db_escape($id);
	$result = db_query($sql, "could not get employee");
	
	return db_fetch($result);

}
function get_eleave($id){
	$sql = "SELECT * FROM ".TB_PREF."eleave  where id=".db_escape($id);
	$result = db_query($sql, "could not get employee");
	
	return db_fetch($result);

}
function delete_employee($id){
	$sql = "delete from  ".TB_PREF."employee  where id=".db_escape($id);
	$result = db_query($sql, "could not get employee");
	 

}
function delete_ehistory($id){
	$sql = "delete from  ".TB_PREF."employment_history where id=".db_escape($id);
	$result = db_query($sql, "could not get employee");
	 

}
function delete_equalify($id){
	$sql = "delete from  ".TB_PREF."course where id=".db_escape($id);
	$result = db_query($sql, "could not get employee");
	 

}
function delete_edepend($id){
	$sql = "delete from  ".TB_PREF."dependent where id=".db_escape($id);
	$result = db_query($sql, "could not get employee");
	 

}
function delete_erefer($id){
	$sql = "delete from  ".TB_PREF."references where id=".db_escape($id);
	$result = db_query($sql, "could not get employee");
	 

}
function delete_eleave($id){
	$sql = "delete from  ".TB_PREF."eleave where id=".db_escape($id);
	$result = db_query($sql, "could not get employee");
	 

}
function delete_salary2($id){
	$sql = "delete from  ".TB_PREF."salary_details  where id=".db_escape($id);
	$result = db_query($sql, "could not get employee");
	 

}
function get_next_id(){
$res = db_query("select id from   ".TB_PREF."employee order by id desc limit 1");
$row = db_fetch($res);
return $row['id']+1;
}
function add_employee($unitid,$depid,$statusid,$titleid,$fname,$lname,$jdate,$gfname,$glname,$grel,$pcont,$scont,$cv,$picture,$paddress,$taddress,$city,$country,$domicile,$gender,$nation,$marital,$nlanguage,$blood,$religion,$cast,$disab,$remarks,$desigid,$dobe,$cnic,$emstatus,$overtime,$shiftid,$pstart,$pend){
$id = get_next_id();
$md5  = md5($id);
	$sql = "INSERT INTO ".TB_PREF."employee  (id,unitid,depid,statusid,titleid,fname,lname,jdate,gfname,glname,grel,pcont,scont,cv,picture,paddress,taddress,city,country,domicile,gender,nation,marital,nlanguage,blood,religion,cast,disab,remarks,desigid,dobe,cnic,emstatus,overtime,shiftid,pstart,pend,hash) values('$id', 
	".db_escape($unitid).",
	 ".db_escape($depid)." ,
	 ".db_escape($statusid)." ,
	 ".db_escape($titleid)." ,
	 ".db_escape($fname)." ,
	 ".db_escape($lname)." ,
	 ".db_escape($jdate)." ,
	 ".db_escape($gfname)." ,
	 ".db_escape($glname)." ,
	 ".db_escape($grel)." ,
	 ".db_escape($pcont)." ,
	 ".db_escape($scont)." ,
	 ".db_escape($cv)." ,
	 ".db_escape($picture)." ,
	 ".db_escape($paddress)." ,
	 ".db_escape($taddress)." ,
	 ".db_escape($city)." ,
	 ".db_escape($country)." ,
	 ".db_escape($domicile)." ,
	 ".db_escape($gender)." ,
	 ".db_escape($nation)." ,
	 ".db_escape($marital)." ,
	 ".db_escape($nlanguage)." ,
	 ".db_escape($blood)." ,
	 ".db_escape($religion)." ,
	 ".db_escape($cast)." ,
	 ".db_escape($disab)." ,
	 ".db_escape($remarks).", 
	 ".db_escape($desigid)." , 
	 ".db_escape($dobe)."  , 
	 ".db_escape($cnic).", 
	 ".db_escape($emstatus).", 
	 ".db_escape($overtime)." , 
	 ".db_escape($shiftid)." , 
	 ".db_escape($pstart)." , 
	 ".db_escape($pend)." ,
	 ".db_escape($md5)." 
	
	)";
	db_query($sql, "could not add title");
}
function update_employee($id,$unitid,$depid,$statusid,$titleid,$fname,$lname,$jdate,$gfname,$glname,$grel,$pcont,$scont,$cv,$picture,$paddress,$taddress,$city,$country,$domicile,$gender,$nation,$marital,$nlanguage,$blood,$religion,$cast,$disab,$remarks,$desigid,$dobe,$cnic,$emstatus,$overtime,$shiftid,$pstart,$pend){

	$sql = "update ".TB_PREF."employee 
	 set unitid = ".db_escape($unitid).",
	 depid = ".db_escape($depid)." ,
	 statusid =  ".db_escape($statusid)." ,
	 titleid = ".db_escape($titleid)." ,
	 fname =  ".db_escape($fname)." ,
	 lname = ".db_escape($lname)." ,
	 jdate = ".db_escape($jdate)." ,
	 gfname = ".db_escape($gfname)." ,
	 glname = ".db_escape($glname)." ,
	 grel = ".db_escape($grel)." ,
	 pcont = ".db_escape($pcont)." ,
	 scont = ".db_escape($scont)." ,
	 cv = ".db_escape($cv)." ,
	 picture =  ".db_escape($picture)." ,
	 paddress = ".db_escape($paddress)." ,
	 taddress = ".db_escape($taddress)." ,
	 city = ".db_escape($city)." ,
	 country = ".db_escape($country)." ,
	 domicile = ".db_escape($domicile)." ,
	 gender = ".db_escape($gender)." ,
	 nation = ".db_escape($nation)." ,
	 marital = ".db_escape($marital)." ,
	 nlanguage = ".db_escape($nlanguage)." ,
	 blood = ".db_escape($blood)." ,
	 religion = ".db_escape($religion)." ,
	 cast =  ".db_escape($cast)." ,
	 disab = ".db_escape($disab)." ,
	 remarks = ".db_escape($remarks)." ,
	 desigid = ".db_escape($desigid)." ,
	 dobe = ".db_escape($dobe)."  ,
	 cnic = ".db_escape($cnic).", 
	 emstatus = ".db_escape($emstatus)." , 
	 overtime = ".db_escape($overtime)." , 
	 shiftid = ".db_escape($shiftid)."  , 
	 pstart = ".db_escape($pstart)."  , 
	 pend = ".db_escape($pend)." 
	 where id='$id'
	
	 ";
	db_query($sql, "could not aupdate employee");
}

function  update_ehistory($id,$lorg,$ldesig,$type,$lsalary,$start,$end,$leaving){

	$sql = "update ".TB_PREF."employment_history 
	 set lorg = ".db_escape($lorg).",
	 ldesig = ".db_escape($ldesig)." ,
	  type =  ".db_escape($type)." ,
	 lsalary = ".db_escape($lsalary)." ,
	 start =  ".db_escape($start)." ,
	 end = ".db_escape($end)." ,
	 leaving = ".db_escape($leaving)." 
	 where id='$id'
	
	 ";
	db_query($sql, "could not aupdate employee");
}
function  update_equalify($id,$course,$board,$sesion,$marks,$tmarks,$grade,$majors,$sesione){

	$sql = "update ".TB_PREF."course 
	 set course = ".db_escape($course).",
	 board = ".db_escape($board)." ,
	  sesion =  ".db_escape($sesion)." ,
	 marks = ".db_escape($marks)." ,
	 tmarks =  ".db_escape($tmarks)." ,
	 grade = ".db_escape($grade)." ,
	 majors = ".db_escape($majors).",
	 sesione = ".db_escape($sesione)." 
	 where id='$id'
	
	 ";
	db_query($sql, "could not aupdate employee");
}
function  update_edepend($id,$dname,$drel,$dob,$dmarital,$docup){

	$sql = "update ".TB_PREF."dependent 
	 set dname = ".db_escape($dname).",
	 drel = ".db_escape($drel)." ,
	 dob =  ".db_escape($dob)." ,
	 dmarital = ".db_escape($dmarital)." ,
	 docup =  ".db_escape($docup)." 
    where id='$id'
	
	 ";
	db_query($sql, "could not update employee");
}
function  update_erefer($id,$rname,$radress,$rrel,$ksince,$cno){

	$sql = "update ".TB_PREF."references 
	 set rname = ".db_escape($rname).",
	 radress = ".db_escape($radress)." ,
	 rrel =  ".db_escape($rrel)." ,
	 ksince = ".db_escape($ksince)." ,
	 cno =  ".db_escape($cno)."  
	 where id='$id'
	
	 ";
	db_query($sql, "could not aupdate employee");
}
function  update_eleave($id,$lid,$lal){

	$sql = "update ".TB_PREF."eleave 
	 set 
       lid = ".db_escape($lid).",
       lal = ".db_escape($lal)."
	 where id='$id'
	 ";
	db_query($sql, "could not aupdate employee");
}
function  update_salary2($id,$sa,$sv,$sid){

	$sql = "update ".TB_PREF."salary_details  
	 set 
       sa = ".db_escape($sa).",
       sv = ".db_escape($sv).",
       sid = ".db_escape($sid)."
	 where id='$id'
	 ";
	db_query($sql, "could not aupdate employee");
}

function get_employee_sql($name = '',$dep = '',$un = '',$desig = ''){
return "SELECT concat_ws(' ',fname,lname) , ".TB_PREF."unit.name as uname,".TB_PREF."department.name as depname,".TB_PREF."designation.name as dname,".TB_PREF."employee.id from ".TB_PREF."employee inner join  ".TB_PREF."unit on ".TB_PREF."unit.id=".TB_PREF."employee.unitid  inner join ".TB_PREF."department on ".TB_PREF."department.id = ".TB_PREF."employee.depid inner join ".TB_PREF."designation on  ".TB_PREF."employee.desigid=".TB_PREF."designation.id  where  
	concat_ws(' ',".TB_PREF."employee.lname,".TB_PREF."employee.fname) like ".db_escape("%".$name."%")." and
	".TB_PREF."unit.name like ".db_escape("%".$un."%")." and
	".TB_PREF."designation.name like ".db_escape("%".$desig."%")." and
	".TB_PREF."department.name like ".db_escape("%".$dep."%")." 

	";
}
function get_employeeh_sql($id){
return "SELECT lorg,ldesig,type,lsalary,leaving,start,end,id from ".TB_PREF."employment_history where eid='$id'";

}
function get_employeer_sql($id){
return "SELECT rname,radress,rrel,cno,ksince,id from ".TB_PREF."references where eid='$id'";

}
function get_employeeq_sql($id){
return "SELECT course,board,marks,tmarks,grade,majors,sesion,id,sesione from ".TB_PREF."course where eid='$id'";

}
function get_employeed_sql($id){
return "SELECT dname,drel,dmarital,docup,dob,id from ".TB_PREF."dependent where eid='$id'";

}
function get_employeel_sql($id){
return "SELECT  ".TB_PREF."leave.name, ".TB_PREF."eleave.lal, ".TB_PREF."eleave.id from ".TB_PREF."eleave inner join  ".TB_PREF."leave on  ".TB_PREF."eleave.lid= ".TB_PREF."leave.id  where  ".TB_PREF."eleave.eid='$id'";

}
function get_salary2_sql($id){
return "SELECT  ".TB_PREF."salary_details.sa, ".TB_PREF."salary_details.sv, ".TB_PREF."salary_details.id, ".TB_PREF."salary_details.sid from ".TB_PREF."salary_details   where  ".TB_PREF."salary_details.eid='$id'";

}

function update_salary($id,$stype,$ibracket,$pmethod,$bname,$aholdern,$aholderad,$aholderiban,$checkpname,$bsal){
$pmethod_detail = get_payment_detail($pmethod,$bname,$aholdern,$aholderad,$aholderiban,$checkpname);
	$sql = "update ".TB_PREF."employee 
	 set 
		stype = ".db_escape($stype).",
 	 ibracket = ".db_escape($ibracket)." ,
	 pmethod = ".db_escape($pmethod)." ,
	 pmethod_detail = ".db_escape($pmethod_detail).",
	 bsal = ".db_escape($bsal)."
	 where id='$id'
	
	 ";
	db_query($sql, "could not add title");
}
function get_payment_detail($pmethod,$bname,$aholdern,$aholderad,$aholderiban,$checkpname){
switch($pmethod){
default:
return json_encode(array());
break;
case  "btransfer":
return json_encode(array("bname"=>$bname,"aholdern"=>$aholdern,"aholderad"=>$aholderad,"aholderiban"=>$aholderiban));
break;
case "check":
return json_encode(array("checkpname"=>$checkpname));
break;
case "cash":
return json_encode(array());
break;
}

};

function get_pmethod_db($id){
$res = db_query("select pmethod from   ".TB_PREF."employee where id='$id'");
$row = db_fetch($res);
return $row['pmethod'];

}
function get_pmethod_detail($id){
$res = db_query("select pmethod_detail from   ".TB_PREF."employee where id='$id'");
$row = db_fetch($res);
return $row['pmethod_detail'];

}
function get_unitid_db($id){
$res = db_query("select unitid from   ".TB_PREF."employee where id='$id'");
$row = db_fetch($res);
return $row['unitid'];

}

function   add_ehistory($id,$lorg,$ldesig,$type,$lsalary,$start,$end,$leaving){
$sql = "INSERT INTO ".TB_PREF."employment_history  (eid,lorg,ldesig,type,lsalary,start,end,leaving) values('$id', 
	".db_escape($lorg).",
	 ".db_escape($ldesig)." ,
	 ".db_escape($type)." ,
	 ".db_escape($lsalary)." ,
	 ".db_escape($start)." ,
	 ".db_escape($end)." ,
	 ".db_escape($leaving)."
	)";
	db_query($sql, "could not add employee history");

}

function   add_equalify($id,$course,$board,$sesion,$marks,$tmarks,$grade,$majors,$sesione){
$sql = "INSERT INTO ".TB_PREF."course  (eid,course,board,sesion,marks,tmarks,grade,majors,sesione) values('$id', 
	".db_escape($course).",
	 ".db_escape($board)." ,
	 ".db_escape($sesion)." ,
	 ".db_escape($marks)." ,
	 ".db_escape($tmarks)." ,
	 ".db_escape($grade)." ,
	 ".db_escape($majors).",
	 ".db_escape($sesione)."
	)";
	db_query($sql, "could not add employee history");

}
function   add_erefer($id,$rname,$radress,$rrel,$ksince,$cno){
$sql = "INSERT INTO ".TB_PREF."references  (eid,rname,radress,rrel,ksince,cno) values('$id', 
	".db_escape($rname).",
	 ".db_escape($radress)." ,
	 ".db_escape($rrel)." ,
	 ".db_escape($ksince)." ,
	 ".db_escape($cno)." 
	)";
	db_query($sql, "could not add employee history");

}

function   add_edepend($id,$dname,$drel,$dob,$dmarital,$docup){
$sql = "INSERT INTO ".TB_PREF."dependent  (eid,dname,drel,dob,dmarital,docup) values('$id', 
	".db_escape($dname).",
	 ".db_escape($drel)." ,
	 ".db_escape($dob)." ,
	 ".db_escape($dmarital)." ,
	 ".db_escape($docup)." 
	)";
	db_query($sql, "could not add employee history");

}
function   add_eleave($id,$lid,$lal){
$sql = "INSERT INTO ".TB_PREF."eleave  (eid,lid,lal) values('$id',
	 ".db_escape($lid)." ,
	 ".db_escape($lal)."  
	)";
	db_query($sql, "could not add employee history");

}
function   add_salary2($id,$sa,$sv,$sid){
$sql = "INSERT INTO ".TB_PREF."salary_details  (eid,sa,sv,sid) values('$id',
	 ".db_escape($sa)." ,
	 ".db_escape($sv)." ,
	 ".db_escape($sid)."  
	)";
	db_query($sql, "could not add employee history");

}

function get_types_name($name,$id){
$res = db_query("select name from   ".TB_PREF."$name where id='$id'");
$row = db_fetch($res);
return $row['name'];

}
?>