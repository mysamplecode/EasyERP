<?php
//---secutiry and path setting-------- 
$page_security = 'SA_HRM_ATTENDANCE_CONFIRMATION_ENTRY';
$path_to_root = "../..";
//----include files--------
include_once($path_to_root . "/reporting/includes/pdf_report.inc");
//----pdf writer settings----------
$fields = array();
if(strlen($_POST['reported_by']) > 0)
{
	$fields = array(
				'first_name' => array(_('First Name'),'left',25),
                                'last_name' => array(_('Last Name'),'left',10),
                                'timestamp' => array(_('Scan Stamp'),'left',18),
				'code' => array(_('Gate Code'),'left',8),
				'attendance_string1' => array(_('Issue'),'left',15),
				'gate_code' => array(_('Response'),'left',18),
				'gate_out' => array(_('Start Time'),'left',8),
				'gate_in' => array(_('End Time'),'left',8),
				'attendance_int1' => array(_('Delay (Min)'),'left',8),
				'employee_confirmed' => array(_('Emp Confirmation'),'left',8),
				'employee_comments' => array(_('Emp Comments'),'left',20),
				'superior_confirmed' => array(_('Superior Confirmation'),'left',8),
				'superior_comments' => array(_('Superior Comments'),'left',20)
				
	);
}
else 
{
	$fields = array(
				'first_name' => array(_('First Name'),'left',25),
                                'last_name' => array(_('Last Name'),'left',10),
                                'timestamp' => array(_('Scan Stamp'),'left',18),
				'code' => array(_('Gate Code'),'left',8),
				'attendance_string1' => array(_('Issue'),'left',15),
				'gate_code' => array(_('Response'),'left',18),
				'gate_out' => array(_('Start Time'),'left',8),
				'gate_in' => array(_('End Time'),'left',8),
				'attendance_int1' => array(_('Delay (Min)'),'left',8),
				'employee_confirmed' => array(_('Confirmation'),'left',8),
				'employee_comments' => array(_('Comments'),'left',30)
				
	);
}
//----init the pdf writer---------
global $controller,$employee_id;
$rep = pdf_header_start($controller."s",$fields,'A3','L',8,true);
//----creating pdf main body------
$sql = '';
$attendance_db = new attendance_model();
if(strlen($_POST['reported_by']) > 0)
{
	$sql = $attendance_db -> search_by_month_for_superior_with_name($_POST['attendance_month'],$_POST['reported_by']);
}
else
{
	$sql = $attendance_db -> search_by_month_for_employee_with_name($_POST['attendance_month'],$employee_id);
}
pr($sql);
pdf_body_display($rep,$sql,$fields,true);
//----end the pdf writer------
pdf_header_end($rep);
?>
