<?php

function show_personal_employee($id=-1){
	 global $Mode,$selected_id; 
	 if($Mode=="RESET" )
	 unset($_POST);
	 
	 if($id>0 && $Mode!='RESET' && $Mode!='ADD_ITEM' && $Mode!='UPDATE_ITEM' && $Mode!='Delete' && $Mode!="Edit" && !isset($_POST['unitid']) && empty($_POST['unitid']) ) {
	 	$row  = get_employee($selected_id);
		$_POST = array_merge($_POST,$row);
		$_POST['jdate'] = date("m/d/Y",$_POST['jdate']);
		$_POST['dobe'] = date("m/d/Y",$_POST['dobe']);
 	if($_POST['pstart']!=0 && $_POST['pend']!=0){
		$_POST['probation'] = "yes";
		$_POST['pend'] = date("m/d/Y",$_POST['pend']);
		$_POST['pstart'] = date("m/d/Y",$_POST['pstart']);
	}
	 }
 if(@$_POST['unitid']==get_unitid_db($id) && $Mode!='UPDATE_ITEM'){
     
      $_POST['unitid'] = get_unitid_db($id) ;
    
  }
   
   
   
if($Mode == "ADD_ITEM"  && can_process_personal()){
$cv_name = '';
$pic_name = '';
if(isset($_FILES['cv']) && !empty($_FILES['cv']['name'])){
	$cv_name = "cv-".time();
	$ext = explode(".",$_FILES['cv']['name']);	
	$cv_name = $cv_name.".".$ext[count($ext)-1];
	move_uploaded_file($_FILES['cv']['tmp_name'], company_path().'/cv/'.$cv_name);
}
if(isset($_FILES['picture']) && !empty($_FILES['picture']['name'])){
	$pic_name = "profile-".time();
	$ext = explode(".",$_FILES['picture']['name']);
	$pic_name = $pic_name.".".$ext[count($ext)-1];
	move_uploaded_file($_FILES['picture']['tmp_name'], company_path().'/profile_pics/'.$pic_name);
}
	add_employee(@$_POST['unitid'],@$_POST['depid'],@$_POST['statusid'],$_POST['titleid'],$_POST['fname'],$_POST['lname'],strtotime(@$_POST['jdate']),@$_POST['gfname'],@$_POST['glname'],@$_POST['grel'],@$_POST['pcont'],@$_POST['scont'],$cv_name,$pic_name,@$_POST['paddress'],@$_POST['taddress'],@$_POST['city'],@$_POST['country'],@$_POST['domicile'],@$_POST['gender'],@$_POST['nation'],@$_POST['marital'],@$_POST['nlanguage'],@$_POST['blood'],@$_POST['religion'],@$_POST['cast'],@$_POST['disab'],@$_POST['remarks'],@$_POST['desigid'],strtotime(@$_POST['dobe']), @$_POST['cnic'], @$_POST['emstatus'], @$_POST['overtime'],@$_POST['shiftid'],strtotime(@$_POST['pstart']),strtotime(@$_POST['pend']));
 
	
 display_notification(_("Employee added!"));
 refresh_pager('employee_tbl');
}
if($Mode == "UPDATE_ITEM" && can_process_personal()){
$cv_name = '';
$pic_name = '';
if(isset($_FILES['cv']) && !empty($_FILES['cv']['name']) ){
	$cv_name = "cv-".time();
	$ext = explode(".",$_FILES['cv']['name']);	
	$cv_name = $cv_name.".".$ext[count($ext)-1];
	if(!file_exists(company_path().'/cv/'.$cv_name))
	move_uploaded_file($_FILES['cv']['tmp_name'], company_path().'/cv/'.$cv_name);
}
if(isset($_FILES['picture']) && !empty($_FILES['picture']['name'])){
	$pic_name = "profile-".time();
	$ext = explode(".",$_FILES['picture']['name']);
	$pic_name = $pic_name.".".$ext[count($ext)-1];
	if(!file_exists(company_path().'/profile_pics/'.$pic_name))
	move_uploaded_file($_FILES['picture']['tmp_name'], company_path().'/profile_pics/'.$pic_name);
}
 update_employee($id,@$_POST['unitid'],@$_POST['depid'],@$_POST['statusid'],$_POST['titleid'],$_POST['fname'],$_POST['lname'],strtotime(@$_POST['jdate']),@$_POST['gfname'],@$_POST['glname'],@$_POST['grel'],@$_POST['pcont'],@$_POST['scont'],$cv_name,$pic_name,@$_POST['paddress'],@$_POST['taddress'],@$_POST['city'],@$_POST['country'],@$_POST['domicile'],@$_POST['gender'],@$_POST['nation'],@$_POST['marital'],@$_POST['nlanguage'],@$_POST['blood'],@$_POST['religion'],@$_POST['cast'],@$_POST['disab'],@$_POST['remarks'],@$_POST['desigid'],strtotime(@$_POST['dobe']), @$_POST['cnic'], @$_POST['emstatus'], @$_POST['overtime'],@$_POST['shiftid'],@$_POST['shiftid'],strtotime(@$_POST['pstart']),strtotime(@$_POST['pend']));
 display_notification(_("Employee updated!"));
 	refresh_pager('employee_tbl');
 
}
    br(3);  	start_table(TABLESTYLE);
    row_start();
    echo "<td>";
  	start_table(TABLESTYLE2);
    show_units("unitid","depid","desigid");
 
    show_select_row("Designation: ","desigid","designation");
 
    row_start();
    show_select("Employee Status: ","statusid","employee_status");
    show_select("Employee Title: ","titleid","title");
	
    show_select_row("Shift: ","shiftid","shift");	
	custom_prob_row(_("Probation:"), 'probation');
    row_end();
    
		text_row_ex(_("First Name:"), 'fname',50,100);
		text_row_ex(_("Last Name:"), 'lname',  50,100);
		custom_select_row(_("Status:"), 'emstatus',array("On roll"=>"On roll","Left"=>"Left"));
		custom_select_row(_("Overtime:"), 'overtime',array("Allowed"=>"Allowed","Not allowed"=>"Not allowed"));
		date_row(_("Joining Date:"), 'jdate');
		text_row_ex(_("Guardian First Name:"), 'gfname',50,100);
		text_row_ex(_("Guardian Last Name:"), 'glname',50,100);
		text_row_ex(_("Guardian Relation:"), 'grel',50,100);
		text_row_ex(_("Primary Contact:"), 'pcont',50,100);
		text_row_ex(_("Secondary Contact:"), 'scont',50,100);
    file_row("CV","cv","cv");
	if(isset($_POST['cv']) && !empty($_POST['cv'])){
		row_start();
		echo '<td><a href="'.company_path().'/cv/'.$_POST['cv'].'">Cv link</a></td>';
		row_end();
	}
    file_row("Profile Picture","picture","picture");
    
	if(isset($_POST['picture']) && !empty($_POST['picture'])){
		row_start();
		echo '<td><a href="'.company_path().'/profile_pics/'.$_POST['picture'].'"><img src="'.company_path().'/profile_pics/'.$_POST['picture'].'" width="50" height="50"/></a>';
		row_end();
	}
	textarea_row(_("Permanent Address:"), 'paddress', @$_POST['paddress'], 35, 5);
    end_table(1);
echo "</td><td width='5%'></td>";
echo "<td>";
  	start_table(TABLESTYLE2);
	textarea_row(_("Temporary Address:"), 'taddress', @$_POST['taddress'], 35, 5);
	text_row_ex(_("City:"), 'city',50,100);
	text_row_ex(_("CNIC:"), 'cnic',50,200);
	date_row(_("DOB:"), 'dobe');
	text_row_ex(_("Country:"), 'country',50,100);
	text_row_ex(_("Domicile:"), 'domicile',50,100);
 
  custom_select_row("Gender: ","gender",array("man"=>"Male","woman"=>"Female"));
 
	text_row_ex(_("Nationality:"), 'nation',50,100); 
  custom_select_row("Marital Status: ","marital",array("single"=>"Single","maried"=>"Maried","divorced"=>"Divorced","widow"=>"Widow","Widower"=>"Widower"));

  custom_select_row("Native Language: ","nlanguage",array("Urdu"=>"Urdu","English"=>"English","Punjabi"=>"Punjabi","Pashto"=>"Pashto","Pashto"=>"Pashto","Sindhi"=>"Sindhi","Siraiki"=>"Siraiki","Blochi"=>"Blochi"));
  custom_select_row("Blood Group: ","blood",array("A+"=>"A+","B+"=>"B+","AB+"=>"AB+","0+"=>"0+","0-"=>"0+","B-"=>"B-","A-"=>"A-","AB-"=>"AB-"));
	text_row_ex(_("Religion:"), 'religion',50,100); 
	text_row_ex(_("Cast:"), 'cast',50,100); 
	text_row_ex(_("Disabilities:"), 'disab',50,100); 
	text_row_ex(_("Remarks:"), 'remarks',50,100);
  end_table(1);  
 echo "</td>";
row_end();

  end_table(1);
 submit_add_or_update_center($id == -1, '', 'both');
 br(3);
}






function show_salary_employee($id){
global $Mode,$selected_id;
if($id<1){

display_error("You must add first the personal informations in order to add this!");
return false;
} 
 if($id>0 && $Mode!='RESET' && $Mode!='ADD_ITEM' && $Mode!='UPDATE_ITEM' && $Mode!='Delete' && $Mode!="Edit" && !isset($_POST['pmethod']) && empty($_POST['pmethod']) ){
	  $row  = get_employee($selected_id);
		$_POST = array_merge($_POST,$row);
		$_POST['jdate'] = date("m/d/Y",$_POST['jdate']);
		$_POST['dobe'] = date("m/d/Y",$_POST['dobe']);
    $payment_info = json_decode(html_entity_decode($_POST['pmethod_detail']),true);
    if(is_array($payment_info)){
    foreach($payment_info as $pk=>$pi){
      $_POST[$pk] = $pi;
    
    };
    }
}
   if($_POST['pmethod']==get_pmethod_db($id) && $Mode!='UPDATE_ITEM'){
      $payment_info = json_decode(html_entity_decode(get_pmethod_detail($id)),true);
    if(is_array($payment_info)){
    
    foreach($payment_info as $pk=>$pi){
      $_POST[$pk] = $pi;
    
    };
  }
  }
br(2);
start_table(TABLESTYLE);
text_row_ex("Basic salary: ","bsal",50,100);
custom_select_row("Salary type: ","stype",array("fixed"=>"Fixed","wages"=>"Wages"));
  
text_row_ex(_("Increment Bracket"), 'ibracket',50,100); 
show_payment_method("pmethod");
end_table(1);
 submit_add_or_update_center($id == -1, '', 'both');
 br(3);
 
if($Mode == "UPDATE_ITEM" && can_process_salary()){

update_salary($id,@$_POST['stype'] ,@$_POST['ibracket'],@$_POST['pmethod'],@$_POST['bname'],@$_POST['aholdern'],@$_POST['aholderad'],@$_POST['aholderiban'],@$_POST['checkpname'],@$_POST['bsal']);
display_notification("Salary information updated");

}
}


function show_join_employee($id){
global $add_particular;
global $Mode,$selected_id;
global $jselected_id;
  if($Mode=="RESET" ){
	 unset($_POST);
    refresh_pager("employeeh_tbl");
  }
  if(!isset($jselected_id) || empty($jselected_id) && $Mode != 'UPDATE_ITEM' && $Mode != 'jEdit' && $Mode != 'jDelete'){
  $jselected_id= 0;
}
if($id<1){

  display_error("You must add first the personal informations in order to add this!");
  return false;
} 
$jid = -1;
br(2);
if($jid==-1 && $Mode == 'ADD_ITEM' && can_process_join()){
    display_notification("Employee history record added");
    add_ehistory($selected_id,@$_POST['lorg'],@$_POST['ldesig'],@$_POST['type'],@$_POST['lsalary'],strtotime(@$_POST['start']),strtotime(@$_POST['end']),@$_POST['leaving']);
    unset($_POST);
    $Mode="RESET"; 
    $jselected_id= 0;
 }  
if($jselected_id>0 && $Mode == 'UPDATE_ITEM' && can_process_join()){
    display_notification("Employee history record updated");
    update_ehistory($jselected_id,@$_POST['lorg'],@$_POST['ldesig'],@$_POST['type'],@$_POST['lsalary'],strtotime(@$_POST['start']),strtotime(@$_POST['end']),@$_POST['leaving']);
    unset($_POST);
    $Mode="RESET"; 
    $jselected_id= 0;
}
if($Mode == 'jDelete' ){
    display_notification("Employee history record deleted");
    delete_ehistory($jselected_id);
    unset($_POST);
    $Mode="RESET"; 
      $jselected_id= 0;
     refresh_pager("employeeh_tbl");
}
if($Mode == "jEdit"){
  $rowj = get_ehistory($jselected_id);
  $_POST = array_merge($_POST,$rowj);
  $_POST['jselected_id'] = $jselected_id;
  $_POST['start'] =  date("m/d/Y",$_POST['start']);
  $_POST['end'] =  date("m/d/Y",$_POST['end']);
}
start_table(TABLESTYLE);
text_row_ex(_("Last Organization"), 'lorg',50,100); 
text_row_ex(_("Last Designation"), 'ldesig',50,100); 
custom_select_row("Type","type",array("Gouvernament"=>"Gouvernament","Private"=>"Private"));

text_row_ex(_("Last Salary"), 'lsalary',50,100); 

		date_row(_("Job Start Date:"), 'start');
		date_row(_("Job End Date:"), 'end');
    
text_row_ex(_("Reason for leaving"), 'leaving',50,100); 
end_table(1);
 submit_add_or_update_center((int)$jselected_id ==0, '', 'both');
 br(3);
 
 br(1);
display_heading("Employee hystory");
br(1);
 $th2 = array (_('Last Organization'),_('Last Designation'),_('Type'),_('Reason for leaving'));
 
 array_append($th2, array(
    _("Start Date")=>array('insert'=>true, 'fun'=>'format_dates'),
		_("End Date")=>array('insert'=>true, 'fun'=>'format_datee'),
		 
		array('insert'=>true, 'fun'=>'edit_linkj'),
		array('insert'=>true, 'fun'=>'delete_linkj')));
 $sql2  = get_employeeh_sql($id);
$table2 = &new_db_pager('employeeh_tbl', $sql2 , $th2);  
$table2->width = "80%";
 
display_db_pager($table2);

 refresh_pager("employeeh_tbl");
br(3);

}





function show_qualify_employee($id){
global $add_particular;
global $Mode,$selected_id;
global $jselected_id;
  if($Mode=="RESET" ){
	 unset($_POST);
    refresh_pager("employeeq_tbl");
  }
  if(!isset($jselected_id) || empty($jselected_id) && $Mode != 'UPDATE_ITEM' && $Mode != 'jEdit' && $Mode != 'jDelete'){
  $jselected_id= 0;
}
if($id<1){

  display_error("You must add first the personal informations in order to add this!");
  return false;
} 
$jid = -1;
br(2);
if($jid==-1 && $Mode == 'ADD_ITEM' && can_process_qualify()){
    display_notification("Employee  qualification  record added");
    add_equalify($selected_id,@$_POST['course'],@$_POST['board'],strtotime(@$_POST['sesion']),@$_POST['marks'],@$_POST['tmarks'],@$_POST['grade'],@$_POST['majors'],strtotime(@$_POST['sesione']) );
        unset($_POST);
    $Mode="RESET"; 
      $jselected_id= 0;
}  
if($jselected_id>0 && $Mode == 'UPDATE_ITEM' && can_process_qualify()){
    display_notification("Employee qualification  record updated");
    update_equalify($jselected_id,@$_POST['course'],@$_POST['board'],strtotime(@$_POST['sesion']),@$_POST['marks'],@$_POST['tmarks'],@$_POST['grade'],@$_POST['majors'],strtotime(@$_POST['sesione']));
    unset($_POST);
    $Mode="RESET"; 
      $jselected_id= 0;
}
if($Mode == 'jDelete' ){
    display_notification("Employee qualification record deleted");
    delete_equalify($jselected_id);
    unset($_POST);
    $Mode="RESET"; 
     $jselected_id= 0;
     refresh_pager("employeeq_tbl");
}
if($Mode == "jEdit"){
  $rowj = get_equalify($jselected_id);
  $_POST = array_merge($_POST,$rowj);
  $_POST['jselected_id'] = $jselected_id;
  $_POST['sesion'] =  date("m/d/Y",$_POST['sesion']);
  $_POST['sesione'] =  date("m/d/Y",$_POST['sesione']);
}
start_table(TABLESTYLE);
text_row_ex(_("Course"), 'course',50,100); 
text_row_ex(_("Board"), 'Board',50,100); 
date_row(_("Sesion/Year Start:"), 'sesion');
date_row(_("Sesion/Year End:"), 'sesione');
text_row_ex(_("Marks obtained"), 'marks',50,100); 
text_row_ex(_("Total Marks"), 'tmarks',50,100); 
text_row_ex(_("Grade"), 'grade',50,100); 
text_row_ex(_("Majors"), 'majors',50,100); 
end_table(1);
 submit_add_or_update_center((int)$jselected_id ==0, '', 'both');
 br(3);
 
 br(1);
display_heading("Employee qualifications");
br(1);
 $th2 = array (_('Course'),_('Board'),_('Marks obtained'),_('Total Marks'),_('Grade'),_('Majors'));
 
 array_append($th2, array(
    _("Sesion/Year")=>array('insert'=>true, 'fun'=>'format_dateyr'),
		 
		array('insert'=>true, 'fun'=>'edit_linkj'),
		array('insert'=>true, 'fun'=>'delete_linkj')));
 $sql2  = get_employeeq_sql($id);
$table2 = &new_db_pager('employeeq_tbl', $sql2 , $th2);  
$table2->width = "80%";
 
display_db_pager($table2);

 refresh_pager("employeeq_tbl");
br(3);

}


function show_refer_employee($id){
global $add_particular;
global $Mode,$selected_id;
global $jselected_id;
  if($Mode=="RESET" ){
	 unset($_POST);
    refresh_pager("employeer_tbl");
  }
  if(!isset($jselected_id) || empty($jselected_id) && $Mode != 'UPDATE_ITEM' && $Mode != 'jEdit' && $Mode != 'jDelete'){
  $jselected_id= 0;
}
if($id<1){

  display_error("You must add first the personal informations in order to add this!");
  return false;
} 
$jid = -1;
br(2);
if($jid==-1 && $Mode == 'ADD_ITEM' && can_process_refer()){
    display_notification("Employee  References  record added");
    add_erefer($selected_id,@$_POST['rname'],@$_POST['radrees'],@$_POST['rrel'],strtotime(@$_POST['ksince']),@$_POST['cno']);
        unset($_POST);
    $Mode="RESET"; 
      $jselected_id= 0;
}  
if($jselected_id>0 && $Mode == 'UPDATE_ITEM' && can_process_refer()){
    display_notification("Employee  References  record updated");
    update_erefer($jselected_id,@$_POST['rname'],@$_POST['radrees'],@$_POST['rrel'],strtotime(@$_POST['ksince']),@$_POST['cno']);
    unset($_POST);
    $Mode="RESET"; 
      $jselected_id= 0;
}
if($Mode == 'jDelete' ){
    display_notification("Employee References record deleted");
    delete_erefer($jselected_id);
    unset($_POST);
    $Mode="RESET"; 
     $jselected_id= 0;
     refresh_pager("employeer_tbl");
}
if($Mode == "jEdit"){
  $rowj = get_erefer($jselected_id);
  $_POST = array_merge($_POST,$rowj);
  $_POST['jselected_id'] = $jselected_id;
  $_POST['ksince'] =  date("m/d/Y",$_POST['ksince']);
}
start_table(TABLESTYLE);
text_row_ex(_("Name"), 'rname',50,100); 
text_row_ex(_("Address"), 'radress',50,100); 
text_row_ex(_("Relation"), 'rrel',50,100); 
date_row(_("Known since"), 'ksince');
text_row_ex(_("Contact nomber:"), 'cno',50,100);  
end_table(1);
 submit_add_or_update_center((int)$jselected_id ==0, '', 'both');
 br(3);
 
 br(1);
display_heading("Employee Reference");
br(1);
 $th2 = array (_('Name'),_('Address'),_('Relation'),_('Contact No.'));
 
 array_append($th2, array(
    _('Known since')=>array('insert'=>true, 'fun'=>'format_dateks'),
		 
		array('insert'=>true, 'fun'=>'edit_linkj'),
		array('insert'=>true, 'fun'=>'delete_linkj')));
 $sql2  = get_employeer_sql($id);
$table2 = &new_db_pager('employeer_tbl', $sql2 , $th2);  
$table2->width = "80%";
 
display_db_pager($table2);

 refresh_pager("employeer_tbl");
br(3);

}






function show_depend_employee($id){
global $add_particular;
global $Mode,$selected_id;
global $jselected_id;
  if($Mode=="RESET" ){
	 unset($_POST);
    refresh_pager("employeed_tbl");
  }
  if(!isset($jselected_id) || empty($jselected_id) && $Mode != 'UPDATE_ITEM' && $Mode != 'jEdit' && $Mode != 'jDelete'){
  $jselected_id= 0;
}
if($id<1){

  display_error("You must add first the personal informations in order to add this!");
  return false;
} 
$jid = -1;
br(2);
if($jid==-1 && $Mode == 'ADD_ITEM' && can_process_depend()){
    display_notification("Employee  Dependents  record added");
    add_edepend($selected_id,@$_POST['dname'],@$_POST['drel'],strtotime(@$_POST['dob']),@$_POST['dmarital'],@$_POST['docup']);
        unset($_POST);
    $Mode="RESET"; 
      $jselected_id= 0;
}  
if($jselected_id>0 && $Mode == 'UPDATE_ITEM' && can_process_depend()){
    display_notification("Employee  Dependents  record updated");
    update_edepend($jselected_id,@$_POST['dname'],@$_POST['drel'],strtotime(@$_POST['dob']),@$_POST['dmarital'],@$_POST['docup']);
    unset($_POST);
    $Mode="RESET"; 
      $jselected_id= 0;
}
if($Mode == 'jDelete' ){
    display_notification("Employee Dependents record deleted");
    delete_edepend($jselected_id);
    unset($_POST);
    $Mode="RESET"; 
     $jselected_id= 0;
     refresh_pager("employeer_tbl");
}
if($Mode == "jEdit"){
  $rowj = get_edepend($jselected_id);
  $_POST = array_merge($_POST,$rowj);
  $_POST['jselected_id'] = $jselected_id;
  $_POST['dob'] =  date("m/d/Y",$_POST['dob']);
}
start_table(TABLESTYLE);
  text_row_ex(_("Name"), 'dname',50,100); 
  text_row_ex(_("Relationship"), 'drel',50,100); 
  date_row(_("DOB"), 'dob'); 
  custom_select_row("Marital Status: ","dmarital",array("single"=>"Single","maried"=>"Maried","divorced"=>"Divorced"));
  text_row_ex(_("Ocupation"), 'docup',50,200);  
end_table(1);
  submit_add_or_update_center((int)$jselected_id ==0, '', 'both');
br(3);
 
 br(1);
display_heading("Employee Dependent");
br(1);
 $th2 = array (_('Name'),_('Relationship'),_('Ocupation'),_('Marital Status'));
 
 array_append($th2, array(
    _('DOB')=>array('insert'=>true, 'fun'=>'format_datedob'),
		 
		array('insert'=>true, 'fun'=>'edit_linkj'),
		array('insert'=>true, 'fun'=>'delete_linkj')));
 $sql2  = get_employeed_sql($id);
$table2 = &new_db_pager('employeed_tbl', $sql2 , $th2);  
$table2->width = "80%";
 
display_db_pager($table2);

 refresh_pager("employeed_tbl");
br(3);

}










function show_leave_employee($id){
global $add_particular;
global $Mode,$selected_id;
global $jselected_id;
  if($Mode=="RESET" ){
	 unset($_POST);
    refresh_pager("employeel_tbl");
  }
  if(!isset($jselected_id) || empty($jselected_id) && $Mode != 'UPDATE_ITEM' && $Mode != 'jEdit' && $Mode != 'jDelete'){
  $jselected_id= 0;
}
if($id<1){

  display_error("You must add first the personal informations in order to add this!");
  return false;
} 
$jid = -1;
br(2);
if($jid==-1 && $Mode == 'ADD_ITEM' && can_process_leave()){
    display_notification("Employee  Leave  record added");
    add_eleave($selected_id,@$_POST['lid'],@$_POST['lal']);
    unset($_POST);
    $Mode="RESET"; 
    $jselected_id= 0;
}  
if($jselected_id>0 && $Mode == 'UPDATE_ITEM' && can_process_leave()){
    display_notification("Employee  Leave  record updated");
    update_eleave($jselected_id,$_POST['lid'],$_POST['lal']);
    unset($_POST);
    $Mode="RESET"; 
    $jselected_id= 0;
}
if($Mode == 'jDelete' ){
    display_notification("Employee Leave record deleted");
    delete_eleave($jselected_id);
    unset($_POST);
    $Mode="RESET"; 
    $jselected_id= 0;
    refresh_pager("employeel_tbl");
}
if($Mode == "jEdit"){
  $rowj = get_eleave($jselected_id);
  $_POST = array_merge($_POST,$rowj);
  $_POST['jselected_id'] = $jselected_id;
}
start_table(TABLESTYLE);
  show_select_row("Leave Type: ","lid","leave");
  text_row_ex(_("Leave Allowed"), 'lal',50,100); 
end_table(1);
submit_add_or_update_center((int)$jselected_id ==0, '', 'both');
br(3);
  display_heading("Employee Leave");
br(1);

$th2 = array (_('Leave Type'),_('Leave Allowed'));
 
 array_append($th2, array(
		array('insert'=>true, 'fun'=>'edit_linkj'),
		array('insert'=>true, 'fun'=>'delete_linkj')));
$sql2  = get_employeel_sql($id);
$table2 = &new_db_pager('employeel_tbl', $sql2 , $th2);  
$table2->width = "80%";
display_db_pager($table2);
refresh_pager("employeel_tbl");
br(3);

}

function  show_salary2_employee($id){
global $add_particular;
global $Mode,$selected_id;
global $jselected_id;
  if($Mode=="RESET" ){
	 unset($_POST);
    refresh_pager("employees2_tbl");
  }
  if(!isset($jselected_id) || empty($jselected_id) && $Mode != 'UPDATE_ITEM' && $Mode != 'jEdit' && $Mode != 'jDelete'){
  $jselected_id= 0;
}
if($id<1){

  display_error("You must add first the personal informations in order to add this!");
  return false;
} 
$jid = -1;
br(2);
if($jid==-1 && $Mode == 'ADD_ITEM' && can_process_leave()){
    display_notification("Employee  salary detail  record added");
    add_salary2($selected_id,@$_POST['st'],@$_POST['sv'],@$_POST['sid']);
    unset($_POST);
    $Mode="RESET"; 
    $jselected_id= 0;
}  
if($jselected_id>0 && $Mode == 'UPDATE_ITEM' && can_process_leave()){
    display_notification("Employee  salary detail  record updated");
    update_salary2($jselected_id,$_POST['st'],$_POST['sv'],@$_POST['sid']);
    unset($_POST);
    $Mode="RESET"; 
    $jselected_id= 0;
}
if($Mode == 'jDelete' ){
    display_notification("Employee  salary detail  deleted");
    delete_salary2($jselected_id);
    unset($_POST);
    $Mode="RESET"; 
    $jselected_id= 0;
    refresh_pager("employeel_tbl");
}
if($Mode == "jEdit"){
  $rowj = get_salary2($jselected_id);
  $_POST = array_merge($_POST,$rowj);
  $_POST['jselected_id'] = $jselected_id;
}
start_table(TABLESTYLE);
  show_salary_row();
  
 text_row_ex(_("Value"), 'sv',50,100); 
end_table(1);
submit_add_or_update_center((int)$jselected_id ==0, '', 'both');
br(3);
  display_heading("Salary information");
br(1);

$th2 = array (_(' Type'),_(' value'));
 
 array_append($th2, array(
    _('Type name')=>array('insert'=>true, 'fun'=>'get_salary_nameent'), 
		array('insert'=>true, 'fun'=>'edit_linkj'),
		array('insert'=>true, 'fun'=>'delete_linkj')));
$sql2  = get_salary2_sql($id);
$table2 = &new_db_pager('salary2_tbl', $sql2 , $th2);  
$table2->width = "80%";
display_db_pager($table2);
refresh_pager("salary2_tbl");
br(3);

}


function show_salary_row(){

$value = "Type: ";
$name = "st";
$items = array("allowance"=>"Allowance","deduction"=>"Deduction");
	echo "<tr><td>$value</td><td>";
	echo  array_selector($name, null, $items, 
		array( 
			'select_submit'=>true,
			'async' => false ) ); // FIX?
	echo "</td></tr>\n";
	echo  show_salary_names(@$_POST[$name]);
}

function show_salary_names($name){

show_select_row("Name: ","sid",$name);
}







function show_payment_method($name){
global $Mode;
$items = array(""=>"Select payment method","btransfer"=>"Bank Transfer","check"=>"Check","cash"=>"Cash");

 
	echo "<tr><td>Select payment method: </td><td>";
	echo  array_selector($name, null, $items, 
		array( 
			'select_submit'=>true,
			'async' => false ) ); // FIX?
	echo "</td>\n";
echo "<td> ".show_payment_choice(@$_POST[$name])."</td></tr>";
	


}

function show_payment_choice($pm){

switch($pm){
case 'btransfer':
show_select_row("Select bank","bname","bank");
br();
text_row_ex(_("Account Holder Name"), 'aholdern',50,100); 
br();
text_row_ex(_("Account Holder Address"), 'aholderad',50,100); 
br();
text_row_ex(_("IBAN Number"), 'aholderiban',50,100); 
break;
case 'check':

text_row_ex(_("Pay to name"), 'checkpname',50,100); 
break;
case 'cash':

break;
default:
echo "";
break;


}

}
function custom_select_row($label,$name,$items){


	echo "<tr><td>$label</td><td>";
	echo  array_selector($name, null, $items, 
		array( 
			'select_submit'=>false,
			'async' => false ) ); // FIX?
	echo "</td></tr>\n";

	


}
function custom_prob_row($label,$name){

$items = array("no"=>"no","yes"=>"yes");
	echo "<tr><td>$label</td><td>";
	echo  array_selector($name, null, $items, 
		array( 
			'select_submit'=>true,
			'async' => false ) ); // FIX?
	echo "</td></tr><tr>".show_prob_date(@$_POST['probation'])."</tr>\n";

}
function show_prob_date($probation){
if(trim($probation)=='yes'){
	 	date_row(_("Probation start date:"), 'pstart');
	 	date_row(_("Probation end date:"), 'pend');
 
}else{
		$_POST['pdate'] = '';
		$_POST['pend'] = '';
}

}

function custom_select($label,$name,$items){

	echo "<td>$label";
	echo  array_selector($name, null, $items, 
		array( 
			'select_submit'=>false,
			'async' => false ) ); // FIX?
	echo "</td>\n";

	



}


function show_select($label,$name,$table){
	$result = get_all_items($table);
while ($row = db_fetch($result))
{
 	$items[$row['id']] = $row['name'];
}
	echo "<td>$label";
	echo  array_selector($name, null, $items, 
		array( 
			'select_submit'=>false,
			'async' => false ) ); // FIX?
	echo "</td>\n";

	


}
function show_select_row($label,$name,$table){
	$result = get_all_items($table);
while ($row = db_fetch($result))
{
 	$items[$row['id']] = $row['name'];
}
	echo "<tr><td>$label</td><td>";
	echo  array_selector($name, null, $items, 
		array( 
			'select_submit'=>false,
			'async' => false ) ); // FIX?
	echo "</td></tr>\n";

	


}
 

function show_units($unitname,$depname,$designame){

	$items = array(); 
	$result = get_all_unit_ids();
while ($row = db_fetch($result))
{
 	$items[$row['id']] = $row['name'];
}
	echo "<tr><td>Select unit:</td><td> ";
	echo  array_selector($unitname, null, $items, 
		array( 
			'select_submit'=>true,
			'async' => false ) ); // FIX?
	echo "</td></tr><tr><td>Select department: </td><td>".show_deps(@$_POST[$unitname],$depname,$designame)."</td></tr>\n";

	

}

function show_deps($unit=0,$depname,$designame){ 
global $Mode;
$Mode = 'UpdateSelect';
 	$items = array(); 
	 $result = get_all_dep_ids($unit);
while ($row = db_fetch($result))
{
 	$items[$row['id']] = $row['name'];

}

  
	 return array_selector($depname, null, $items, 
		array( 
			'select_submit'=>false,
			'async' => false ) ); // FIX?
 	echo "</td></tr><tr><td>Select designation: </td><td>".show_desigs(@$_POST[$depname],$designame)."</td></tr>\n";

}
 
?>