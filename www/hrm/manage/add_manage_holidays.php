<?php
//----security and path settings---------
$page_security = 'SA_HRM_HOLIDAYS';
$path_to_root = "../..";
//----include files------------
include_once($path_to_root . "/includes/db_pager.inc");
include_once($path_to_root . "/includes/session.inc");
include_once($path_to_root . "/includes/ui.inc");
include_once($path_to_root . "/includes/validation.inc");
include_once($path_to_root . "/includes/plusql.inc");
include_once($path_to_root . "/hrm/models/hrm_db.inc");
include_once($path_to_root . "/reporting/includes/reports_classes.inc"); 
//----date picker JS-------
$js = get_js_date_picker();
add_js_source($js);
//----page start-----------
simple_page_mode(true);
//----pager defined--------
$pager = "holiday_tbl";
//----Database model defined--------
$holiday_db = new holiday_model();
$fiscal_year_query = "select  fiscal_year_id,CONCAT_WS(' to ',begin,end ) as tyear from ".$prefix."fiscal_year";
//----message controller----
$controller = "Holiday";
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
			(!is_empty($_POST['start_holiday'], 'Start Holiday Date')) &&
			(!is_empty($_POST['end_holiday'], 'End Holiday Date')) &&
			(!is_empty($_POST['fiscal_year_id'], 'Fiscal Year')) &&
			(is_date($_POST['start_holiday'], 'Start Holiday Date')) &&
			(is_date($_POST['end_holiday'], 'End Holiday Date')) &&
			(date_sanity_check($_POST['start_holiday'],$_POST['end_holiday'],'Start Holiday Date', 'End Holiday Date'))
			;
}
//---add item----------------
if( (strcmp($Mode,'ADD_ITEM')==0) && can_process() )
{
	$flag = $holiday_db -> insert($_POST['name'],$_POST['description'],$_POST['start_holiday'],$_POST['end_holiday'],$_POST['fiscal_year_id']);
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
	$holiday_db -> update($selected_id, $_POST['name'],$_POST['description'],$_POST['start_holiday'],$_POST['end_holiday'],$_POST['fiscal_year_id']);
	update_msg($controller);
	$Mode = 'RESET';
}
//---delete item--------------
if(strcmp($Mode,'Delete')==0)
{
 	if(0)//if (key_in_foreign_table($selected_id, '', ''))
	{
		delete_error_msg($controller, 'Fiscal Leave');
		$Mode = 'RESET';
	} 
	else 
	{ 
		$holiday_db -> delete($selected_id);
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
		$holiday_db -> select($selected_id); 
	}
	hidden('selected_id', $selected_id);
} 
text_row_ex(_("$controller Name").':', 'name',50,50);
text_row_ex(_("$controller Description").':', 'description',100,100);
date_row("Start Holiday date", 'start_holiday');
date_row("End Holiday date", 'end_holiday'); 
multiple_array_selector('fiscal_year_id', _("Fiscal Year"), $fiscal_year_query, 0);

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
multiple_array_selector('search_fiscal_year_id', _("Fiscal Year"), $fiscal_year_query, 0);
check_cells("", "print_fiscal_year_id", 1);
row_end();

search_headers_end();
//----start the pager section of the page---------
$th = array(_("$controller Name"),_("$controller Description"),_("Start Holiday"),_("End Holiday"),_("Year Start"),_("Year End"));
$sql = $holiday_db -> search(@$_POST['search_name'],@$_POST['search_description'],@$_POST['search_fiscal_year_id']);
pager_display($pager,$th,$sql,"80%",$controller);
//----end the page---------
page_end();
?>