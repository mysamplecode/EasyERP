<?php
//----security and path settings---------
$page_security = 'SA_HRM_RESIGNATION_ENTRY';
$path_to_root = "../..";
//----include files------------
include_once($path_to_root . "/includes/db_pager.inc");
include_once($path_to_root . "/includes/session.inc");
include_once($path_to_root . "/includes/ui.inc");
include_once($path_to_root . "/includes/validation.inc");
include_once($path_to_root . "/includes/plusql.inc");
include_once($path_to_root . "/hrm/models/hrm_db.inc");
//----page start-----------
simple_page_mode(true);
//----pager defined--------
$pager = "resignation_tbl";
//----Database model defined--------
$employee_transaction_db = new employee_transaction_model();
$unit_db = new unit_model();
$department_db = new department_model();
$employee_db = new employee_model();
$transaction_code = EMPLOYEE_RESIGNATION;
//----message controller----
$controller = "Resignation";
$print_controller = "employee_transaction";
$comparision_operator = '<';
//---loggers----------------
pr("selected ID = $selected_id and Mode = $Mode");
pr($_POST);
//----form specific helper function	
function can_process()
{
	global $controller;
	return 
			(!is_empty($_POST['transaction_reason'], ' Confirmation Reason'))  &&
			(!is_empty($_POST['unit_id'], 'Unit')) &&  
			(!is_empty($_POST['department_id'], 'Department')) &&
			(!is_empty($_POST['employee_id'], 'Employee')) &&
			(!is_empty($_POST['transaction_int2'], 'Notice Period')) &&
				(
					($_POST['transaction_int2'] == 1) ? 
					(!is_empty($_POST['transaction_int3'], 'Notice Days')) && 
					(is_number($_POST['transaction_int3'], 'Notice Days')) :
					(1)
				)  
			;
}
//---add item----------------
if( (strcmp($Mode,'ADD_ITEM')==0) && can_process() )
{
	$flag = $employee_transaction_db -> insert($transaction_code,$_POST);
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
	$employee_transaction_db -> update($selected_id, $transaction_code, $_POST);
	update_msg($controller);
	$Mode = 'RESET';
}
//---delete item--------------
if(strcmp($Mode,'Delete')==0)
{	//need to fill in later on
 	if(0)
	//if (key_in_foreign_table($selected_id, '', ''))
	{
		delete_error_msg($controller, 'Fiscal Leave');
		$Mode = 'RESET';
	} 
	else 
	{ 
		$flag = $employee_transaction_db -> delete($selected_id,$transaction_code);
		if($flag)
		{
			delete_msg($controller);
			$Mode = 'RESET';	
		}
	 }
}
//---print item---------------
if(isset($_POST['PrintOrders']))
{ 
	$rep_file = find_custom_file("/hrm/reports/rep_".strtolower($print_controller).".php");
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
		$employee_transaction_db -> select($selected_id,$transaction_code,&$_POST); 
		$comparision_operator = '<=';
	}
	hidden('selected_id', $selected_id);
}
row_start(); 
$arr = array('unit_id' => null,'name' => null);
multiple_array_selector('unit_id', _("Unit"), $unit_db -> search_advanced($arr));
row_end();
row_start();			
$arr = array('department_id' => null,'name' => null,'unit_id' => $_POST['unit_id']);
multiple_array_selector('department_id', _("Department"), $department_db -> search_advanced($arr));
row_end();
row_start();			
$arr = array('employee_id' => null,'first_name' => null,'unit_id' => $_POST['unit_id'],'department_id' => $_POST['department_id'], 
			  'employee_status_id' => array('table' => $prefix."employee",'label' => 'employee_status_id', 
			  								'value' => array( 
														array('operator' => $comparision_operator,'attachment' => 'and','value' => employee_status_model::RESIGNED)
														)));
multiple_array_selector('employee_id', _("Employee"), $employee_db -> search_advanced($arr));
row_end();
textarea_row(_("Reason:"), 'transaction_reason', @$_POST['transaction_reason'], 35, 5);
row_start();
$arr = array(0 => 'Not Allowed', 2 => 'Allowed');
multiple_array_selector('transaction_int2', _("Notice Period"), $arr, 0, 0);
row_end();
if($_POST['transaction_int2'] == 1)
{
	text_row_ex(_("Notice Period Days"), 'transaction_int3',20,20);
}
new_headers_end($selected_id);
//----start the search and print section of the page------------
search_headers_start($controller."s");

row_start();
ref_cells(_("$controller First Name"), 'search_first_name', '',null, '', true);
check_cells("", "print_first_name", 1);
row_end();

row_start();
ref_cells(_("$controller Last Name"), 'search_last_name', '',null, '', true);
check_cells("", "print_last_name", 1);
row_end();

row_start();
$arr = array('name' => null);
multiple_array_selector('search_unit_id', _("Unit"), $unit_db -> search_advanced($arr), 0);
check_cells("", "print_unit_id", 1);
row_end();

row_start();
$arr = array('name' => null);
multiple_array_selector('search_department_id', _("Department"), $department_db -> search_advanced($arr), 0);
check_cells("", "print_department_id", 1);
row_end();

search_headers_end();
//----start the pager section of the page---------
$th = array(_("First Name"),_("Last Name"),_("Department"),_("Unit"),_("Time Stamp"));
$sql = $employee_transaction_db -> search($transaction_code,@$_POST['search_first_name'],@$_POST['search_last_name'],@$_POST['search_unit_id'],@$_POST['search_department_id']);
pager_display($pager,$th,$sql,"60%",$controller);
//----end the page---------
page_end();
?>