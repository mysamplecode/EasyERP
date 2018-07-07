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
$pager = "weekday_tbl";
//----Database model defined--------
$weekday_db = new weekday_model();
//----message controller----
$controller = "Working Days";
//---loggers----------------
pr("selected ID = $selected_id and Mode = $Mode");
pr($_POST);
//---update item--------------
if( (strcmp($Mode,'UPDATE_ITEM')==0) )
{
	$weekday_db -> update($_POST);
	update_msg($controller);
	$Mode = 'RESET';
}
//---reset the page------------
if(strcmp($Mode,'RESET')==0)
{
	refresh_pager($pager);
	$selected_id = -1; 
	unset($_POST); 
}
//---set the HTML----------	
page_start("Manage Working Days");
//----start the new section of the page-----
new_headers_start($controller, 1, "Manage Working Days");
$weekday_db -> select(&$_POST); 
hidden('selected_id', 1);
pr($_POST);
row_start();
label_cell('Monday');
check_cells("", "monday", @$_POST['monday']);
row_end();

row_start();
label_cell('Tuesday');
check_cells("", "tuesday", @$_POST['tuesday']);
row_end();

row_start();
label_cell('Wednesday');
check_cells("", "wednesday", @$_POST['wednesday']);
row_end();

row_start();
label_cell('Thursday');
check_cells("", "thursday", @$_POST['thursday']);
row_end();

row_start();
label_cell('Friday');
check_cells("", "friday", @$_POST['friday']);
row_end();

row_start();
label_cell('Saturday');
check_cells("", "saturday", @$_POST['saturday']);
row_end();

row_start();
label_cell('Sunday');
check_cells("", "sunday", @$_POST['sunday']);
row_end();

new_headers_end(1);
//----end the page---------
page_end();
?>
