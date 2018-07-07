<?php
//----security and path settings---------
$page_security = 'SA_HRM_DESIGNATIONS';
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
$pager = "designation_tbl";
//----Database model defined--------
$designation_db = new designation_model();
//----message controller----
$controller = "Designation";
$currency_sql = "select curr_abrev from ".$prefix."currencies";
//---loggers----------------
pr("selected ID = $selected_id and Mode = $Mode");
pr($_POST);
//----form specific helper function	
function can_process()
{
	global $controller;
	return 
			(!is_empty($_POST['name'], ' Designation Name'))  &&
			(!is_empty($_POST['description'], 'Designation Description')) &&  
			(!is_empty($_POST['start_salary_bracket'], 'Starting Salary Bracket')) &&
			(!is_empty($_POST['end_salary_bracket'], 'Ending Salary Bracket')) &&
			(!is_empty($_POST['curr_abrev'], 'Currency')) &&
			(is_number($_POST['start_salary_bracket'], 'Starting Salary Bracket')) &&
			(is_number($_POST['end_salary_bracket'], 'Ending Salary Bracket'))
			;
}
//---add item----------------
if( (strcmp($Mode,'ADD_ITEM')==0) && can_process() )
{
	$flag = $designation_db -> insert($_POST['name'],$_POST['description'],$_POST['start_salary_bracket'],$_POST['end_salary_bracket'],$_POST['curr_abrev']);
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
	$designation_db -> update($selected_id, $_POST['name'],$_POST['description'],$_POST['start_salary_bracket'],$_POST['end_salary_bracket'],$_POST['curr_abrev']);
	update_msg($controller);
	$Mode = 'RESET';
}
//---delete item-------------
if(strcmp($Mode,'Delete')==0)
{
 	if (key_in_foreign_table($selected_id, 'employee', 'designation_id'))
	{
		delete_error_msg($controller, 'Employee');
		$Mode = 'RESET';
	} 
	else 
	{ 
		$designation_db -> delete($selected_id);
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
		$designation_db -> select($selected_id,$_POST); 
	}
	hidden('selected_id', $selected_id);
} 
text_row_ex(_("$controller Name").':', 'name',50,50);
text_row_ex(_("$controller Description").':', 'description',100,100);
text_row_ex(_("$controller Starting Salary").':', 'start_salary_bracket',20,20);
text_row_ex(_("$controller Ending Salary").':', 'end_salary_bracket',20,20);
multiple_array_selector('curr_abrev', _("Currency"), $currency_sql, 1);
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

row_start();
ref_cells(_("$controller Starting Salary"), 'search_start_salary_bracket', '',null, '', true);
check_cells("", "print_start_salary_bracket", 1);
row_end();

row_start();
ref_cells(_("$controller Ending Salary"), 'search_end_salary_bracket', '',null, '', true);
check_cells("", "print_end_salary_bracket", 1);
row_end();

row_start();
multiple_array_selector('search_curr_abrev', _("Currency"), $currency_sql, 1);
check_cells("", "print_curr_abrev", 1);
row_end();

search_headers_end();
//----start the pager section of the page---------
$th = array(_("$controller Name"),_("$controller Description"),_("$controller Starting Salary"),_("$controller Ending Salary"),_("Currency"));
$sql = $designation_db -> search($_POST['search_name'],$_POST['search_description'],$_POST['search_start_salary_bracket'],$_POST['search_end_salary_bracket'],$_POST['search_curr_abrev']);
pager_display($pager,$th,$sql,"80%",$controller);
//----end the page---------
page_end();
?>
