<?php
//----security and path settings---------
$page_security = 'SA_HRM_LEAVES';
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
$pager = "leave_tbl";
//----Database model defined--------
$leave_db = new leave_model();
//----message controller----
$controller = "Leave";
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
			(!is_empty($_POST['minimum_leaves'], 'Minimum Leaves')) &&
			(!is_empty($_POST['maximum_leaves'], 'Maximum Leaves')) &&
			(is_number($_POST['minimum_leaves'], 'Minimum Leaves')) &&
			(is_number($_POST['maximum_leaves'], 'Maximum Leaves'))
			;
}
//---add item----------------
if( (strcmp($Mode,'ADD_ITEM')==0) && can_process() )
{
	$flag = $leave_db -> insert($_POST['name'],$_POST['description'],$_POST['minimum_leaves'],$_POST['maximum_leaves']);
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
	$leave_db -> update($selected_id, $_POST['name'],$_POST['description'],$_POST['minimum_leaves'],$_POST['maximum_leaves']);
	update_msg($controller);
	$Mode = 'RESET';
}
//---delete item--------------
if(strcmp($Mode,'Delete')==0)
{
 	if (key_in_foreign_table($selected_id, 'eleave', 'leave_id'))
	{
		delete_error_msg($controller, 'Employee Leave');
		$Mode = 'RESET';
	} 
	else 
	{ 
		$leave_db -> delete($selected_id);
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
		$myrow = $leave_db -> select($selected_id); 
		$_POST['name'] = $myrow -> name;
		$_POST['description'] = $myrow -> description;
		$_POST['minimum_leaves'] = $myrow -> minimum_leaves;
		$_POST['maximum_leaves'] = $myrow -> maximum_leaves; 
	}
	hidden('selected_id', $selected_id);
} 
text_row_ex(_("$controller Name").':', 'name',50,50);
text_row_ex(_("$controller Description").':', 'description',100,100);
text_row_ex(_("$controller Minimum Leaves").':', 'minimum_leaves',20,20);
text_row_ex(_("$controller Maximum Leaves").':', 'maximum_leaves',20,20); 

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
ref_cells(_("$controller Minimum Leaves"), 'search_minimum_leaves', '',null, '', true);
check_cells("", "print_minimum_leaves", 1);
row_end();

row_start();
ref_cells(_("$controller Maximum Leaves"), 'search_maximum_leaves', '',null, '', true);
check_cells("", "print_maximum_leaves", 1);
row_end();
search_headers_end();
//----start the pager section of the page---------
$th = array(_("$controller Name"),_("$controller Description"),_("Min Leaves"),_("Max Leaves"));
$sql = $leave_db -> search(@$_POST['search_name'],@$_POST['search_description'],@$_POST['search_minimum_leaves'],@$_POST['search_maximum_leaves']);
pager_display($pager,$th,$sql,"70%",$controller);
//----end the page---------
page_end();
?>