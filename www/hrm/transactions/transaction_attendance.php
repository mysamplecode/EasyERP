<?php 
//----security and path settings---------
$page_security = 'SA_HRM_ATTENDANCE_ENTRY';
$path_to_root = "../..";
//----include files------------
include_once($path_to_root . "/includes/db_pager.inc");
include_once($path_to_root . "/includes/session.inc");
include_once($path_to_root . "/includes/ui.inc");
include_once($path_to_root . "/includes/validation.inc");
include_once($path_to_root . "/includes/plusql.inc");
include_once($path_to_root . "/hrm/models/hrm_db.inc");
//----Models-------
if(isset($_REQUEST['action']))
{
	if($_REQUEST['action'] == 'update_attendance')
	{
		$attendance_db = new attendance_model();
		echo json_encode($attendance_db -> listen(strtolower(trim($_REQUEST['value'])))); 
		die();
	}
}
//----Controller-------
$controller = "Attendance";
//----Attendance JS-------
add_js_file("jquery.js");
add_js_file("jquery.clock.js");
add_js_file("attendance.js");
//----Attendance CSS------
$style = "margin-left:220px;";
//----page start-----------
simple_page_mode(true);
//---set the HTML----------	
page_start($controller."s");
//----start the new section of the page-----
new_headers_start($controller."s");
label_row("Employee First Name",'N/A',"","style = 'text-align:center;'",0,'first_name');
label_row("Employee Last Name",'N/A',"","style = 'text-align:center;'",0,'last_name');
display_image_row("Employee Picture", "path_to_picture", NO_IMAGE,200,200,$style,1);
label_row("Machine Timer",'N/A',"","style = 'text-align:center;font-size:18px;color:green;font-weight:bold'",0,'digital-clock');
label_row("System Response",'N/A',"","style = 'text-align:center;font-size:18px;color:red;font-weight:bold'",0,'code');
text_row_ex(_("Employee Code").':', 'attendance',100,100);
new_headers_end($selected_id,0);
//----end the page---------
page_end();
?>