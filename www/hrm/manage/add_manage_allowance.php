<?php
//----security and path settings---------
$page_security = 'SA_HRM_ALLOWANCES';
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
$pager = "allowance_tbl";
//----Database model defined--------
$allowance_db = new allowance_model();
//----message controller----
$controller = "Allowance";
//---loggers----------------
pr("selected ID = $selected_id and Mode = $Mode");
pr($_POST);
//----form specific helper function	
function can_process()
{
	global $controller;
	return 
			(!is_empty($_POST['name'], ' Allowance Name'))  &&
			(!is_empty($_POST['description'], 'Allowance Description')) &&  
			(!is_empty($_POST['type'], 'Allowance Type'))
			;
}
//---add item----------------
if( (strcmp($Mode,'ADD_ITEM')==0) && can_process() )
{
	$flag = $allowance_db -> insert($_POST['name'],$_POST['description'],$_POST['type']);
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
	$allowance_db -> update($selected_id, $_POST['name'],$_POST['description'],$_POST['type']);
	update_msg($controller);
	$Mode = 'RESET';
}
//---delete item--------------
if(strcmp($Mode,'Delete')==0)
{	//need to fill in later on
 	if (key_in_foreign_table($selected_id, '', ''))
	{
		delete_error_msg($controller, 'Fiscal Leave');
		$Mode = 'RESET';
	} 
	else 
	{ 
		$allowance_db -> delete($selected_id);
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
		$allowance_db -> select($selected_id); 
	}
	hidden('selected_id', $selected_id);
} 
text_row_ex(_("$controller Name").':', 'name',50,50);
text_row_ex(_("$controller Description").':', 'description',100,100);
$options = array( '0' => 'Company Based', '1' => 'Government Based');
multiple_array_selector('type', _("Allowance Type"), $options, 0, 0);

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
multiple_array_selector('search_type', _("Allowance Type"), $options, 0, 0);
check_cells("", "print_type", 1);
row_end();

search_headers_end();
//----start the pager section of the page---------
$th = array(_("$controller Name"),_("$controller Description"));
array_append($th, array(
			'Type' => array('insert'=>true, 'fun'=>'display_type')
			));
$sql = $allowance_db -> search(@$_POST['search_name'],@$_POST['search_description'],@$_POST['search_type']);
pager_display($pager,$th,$sql,"60%",$controller);
//----end the page---------
page_end();
//helper function
function display_type($row)
{
	global $prefix;
	if(strcmp($row[$prefix.'allowance$type'],'0')==0)
		return "Company Based";
	else
		return "Government Based";
}
?>