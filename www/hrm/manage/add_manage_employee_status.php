<?php
//----security and path settings---------
$page_security = 'SA_HRM_UNITS';
$path_to_root = "../..";
//----include files------------
include_once($path_to_root . "/includes/db_pager.inc");
include_once($path_to_root . "/includes/session.inc");
include_once($path_to_root . "/includes/ui.inc");
include_once($path_to_root . "/includes/validation.inc");
include_once($path_to_root . "/includes/plusql.inc");
include_once($path_to_root . "/hrm/models/hrm_db.inc");
include_once($path_to_root . "/reporting/includes/reports_classes.inc"); 
//----page start-----------
simple_page_mode(true);
//----pager defined--------
$pager = "employee_status_tbl";
//----Database model defined--------
$employee_status_db = new employee_status_model();
//----message controller----
$controller = "Employee_Status";
//---loggers----------------
pr("selected ID = $selected_id and Mode = $Mode");
pr($_POST);
//----form specific helper function	
function can_process()
{
	global $controller;
	return 
			(!is_empty($_POST['name'], "$controller Name"));
			;
}
//---add item----------------
if( (strcmp($Mode,'ADD_ITEM')==0) && can_process() )
{
	$flag = $emplpoyee_status_db -> insert($_POST);
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
	$emplpoyee_status_db -> update($selected_id, $_POST);
	update_msg($controller);
	$Mode = 'RESET';
}
//---delete item--------------
if(strcmp($Mode,'Delete')==0)
{
 	if (key_in_foreign_table($selected_id, 'employee', 'employee_status_id'))
	{
		delete_error_msg($controller, 'Employee Book');
		$Mode = 'RESET';
	} 
	else 
	{ 
		$emplpoyee_status_db -> delete($selected_id);
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
		$emplpoyee_status_db -> select($selected_id, &$_POST); 
	}
	hidden('selected_id', $selected_id);
} 
text_row_ex(_("$controller Name").':', 'name',50,50);

new_headers_end($selected_id);
//----start the search and print section of the page------------
search_headers_start($controller."s");

row_start();
ref_cells(_("$controller Name"), 'search_name', '',null, '', true);
check_cells("", "print_name", 1);
row_end();

search_headers_end();
//----start the pager section of the page---------
$th = array(_("$controller Name"));
$sql = $holiday_db -> search(@$_POST['search_name']);
pager_display($pager,$th,$sql,"40%",$controller);
//----end the page---------
page_end();
?>