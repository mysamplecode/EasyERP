<?php
//----security and path settings---------
$page_security = 'SA_HRM_SHIFTS';
$path_to_root = "../..";
//----include files------------
include_once($path_to_root . "/includes/db_pager.inc");
include_once($path_to_root . "/includes/session.inc");
include_once($path_to_root . "/includes/ui.inc");
include_once($path_to_root . "/includes/validation.inc");
include_once($path_to_root . "/includes/plusql.inc");
include_once($path_to_root . "/hrm/models/hrm_db.inc");
include_once($path_to_root . "/reporting/includes/reports_classes.inc"); 
//----Time slider JS-------
add_js_file("jquery.js");
add_js_file("jqueryui.js");
add_js_file("time_picker.js");
//----page start-----------
simple_page_mode(true);
//----pager defined--------
$pager = "shift_tbl";
//----Database model defined--------
$shift_db = new shift_model();
//----message controller----
$controller = "Shift";
//---loggers----------------
pr("selected ID = $selected_id and Mode = $Mode");
pr($_POST);
//----form specific helper function	
function can_process()
{
	global $controller;
	return 
			(!is_empty($_POST['standard_shift_start'], "$controller Start Time"))  &&
			(!is_empty($_POST['standard_shift_end'], "$controller End Time")) &&
			(!is_empty($_POST['standard_relax_start'], "Relax Start Time")) &&
			(!is_empty($_POST['standard_relax_end'], "Relax End Time")) &&  
			(is_time($_POST['standard_shift_start'], "$controller Start Time"))  &&
			(is_time($_POST['standard_shift_end'], "$controller End Time")) &&
			(is_time($_POST['standard_relax_start'], "Relax Start Time")) &&
			(is_time($_POST['standard_relax_end'], "Relax End Time")) &&
			(isset($_POST['rotation_flag']) && $_POST['rotation_flag'] == 1)
			?
				(!is_empty($_POST['rotation_shift_start'], "$controller Start Time"))  &&
				(!is_empty($_POST['rotation_shift_end'], "$controller End Time")) &&
				(!is_empty($_POST['rotation_relax_start'], "Relax Start Time")) &&
				(!is_empty($_POST['rotation_relax_end'], "Relax End Time")) &&  
				(is_time($_POST['rotation_shift_start'], "$controller Start Time"))  &&
				(is_time($_POST['rotation_shift_end'], "$controller End Time")) &&
				(is_time($_POST['rotation_relax_start'], "Relax Start Time")) &&
				(is_time($_POST['rotation_relax_end'], "Relax End Time"))
			:1
			//(time_sanity_check($_POST['shift_start'],$_POST['shift_end'],"$controller Start Time", "$controller End Time")) &&
			//(time_sanity_check($_POST['relax_start'],$_POST['relax_end'],"Relax Start Time", "Relax End Time")) 
			;
}
//---add item----------------
if( (strcmp($Mode,'ADD_ITEM')==0) && can_process() )
{
	$flag = $shift_db -> insert($_POST);
 	if($flag == true)
 	{
 		add_msg($controller);
		$Mode = 'RESET';	
 	}
 	else
 	{
 		duplicate_msg($controller);
		set_focus('name');
 	}
}
//---update item--------------
if( (strcmp($Mode,'UPDATE_ITEM')==0) && can_process() )
{
	$shift_db -> update($selected_id, $_POST);
	update_msg($controller, $_POST);
	$Mode = 'RESET';
}
//---delete item--------------
if(strcmp($Mode,'Delete')==0)
{
 	if (key_in_foreign_table($selected_id, 'employee', 'shift_id'))
	{
		delete_error_msg($controller, 'Employee Book');
		$Mode = 'RESET';
	} 
	else 
	{ 
		$shift_db -> delete($selected_id);
		delete_msg($controller);
		$Mode = 'RESET';
	 }
}
//---print item---------------
if(isset($_POST['PrintOrders']))
{ 
	$rep_file = find_custom_file("/hrm/reports/rep_".strtolower($controller).".php");
	if ($rep_file) 
	{
		require($rep_file);
	}
 	die();
} 
//---reset the page------------
if(strcmp($Mode,'RESET')==0)
{
	refresh_pager($pager);
	$selected_id = -1; 
	unset($_POST); 
}
//---set the HTML----------	
page_start($controller."s");
//----start the new section of the page-----
new_headers_start($controller."s");

if ($selected_id != -1)
{
	if(strcmp($Mode,'Edit')==0)
	{
		$shift_db -> select($selected_id,&$_POST); 
	}
	hidden('selected_id', $selected_id);
} 
text_row_ex(_("$controller Name").':', 'name',50,50);
text_row_ex(_("$controller Description").':', 'description',100,100);
//-----Standard Shift------------------
time_row("Standard Shift Start", 'standard_shift_start');
time_row("Standard Shift End", 'standard_shift_end'); 
time_row("Standard Relax Start", 'standard_relax_start');
time_row("Standard Relax End", 'standard_relax_end'); 
//-----Rotation Shift------------------
row_start(); 
$arr = array(0 => "No",1 => "Yes");
multiple_array_selector('rotation_flag', _("Allow Rotation"), $arr, 0,false);
row_end();
if(isset($_POST['rotation_flag']) && $_POST['rotation_flag'] == 1)
{
	row_start(); 
	$arr = array(2 => "Daily",7 => "Weekly",15 => "Bi-Monthly", 30 => "Monthly");
	multiple_array_selector('rotation_interval', _("Rotation Interval"), $arr, 0,false);
	row_end();
	time_row("Rotation Shift Start", 'rotation_shift_start');
	time_row("Rotation Shift End", 'rotation_shift_end'); 
	time_row("Rotation Relax Start", 'rotation_relax_start');
	time_row("Rotation Relax End", 'rotation_relax_end'); 	
}
//-------------------------------------
new_headers_end($selected_id);
//----start the search and print section of the page------------
search_headers_start($controller."s");

row_start();
ref_cells(_("$controller Name"), 'search_name', '',null, '', true);
check_cells("", "print_name", 1);
row_end();

row_start();
ref_cells(_("$controller Description"), 'search_description', '',null, '', true);
check_cells("", "print_description", 1);
row_end();

search_headers_end();
//----start the pager section of the page---------
$th = array(_("$controller Name"),_("$controller Description"),_("$controller Start Time"),_("$controller End Time"),_("Relax Start Time"),_("Relax End Time"));
$sql = $shift_db -> search(@$_POST['search_name'],@$_POST['search_description']);
pager_display($pager,$th,$sql,"60%",$controller);
//----end the page---------
page_end();
?>