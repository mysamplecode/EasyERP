<?php
//----security and path settings---------
$page_security = 'SA_HRM_PROCESS_PAYROLL';
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
$pager = "payroll_tbl";
//----Database model defined--------
$employee_transaction_db = new employee_transaction_model();
$employee_payroll_db = new employee_payroll_model();
$employee_payroll_db ->update_overdue_payroll();
$unit_db = new unit_model();
$department_db = new department_model();
$designation_db = new designation_model();
$employee_db = new employee_model();
$transaction_code = EMPLOYEE_PAYROLL;
//----message controller----
$controller = "Payroll Record";
$print_controller = "employee_transaction";
//---loggers----------------
pr("selected ID = $selected_id and Mode = $Mode");
pr($_POST);
//----form specific helper function	
function can_process()
{
	global $controller,$Mode;
	return 
			(!is_empty($_POST['transaction_reason'], ' Designation Reason'))  &&
			(
			(!is_empty($_POST['unit_id'], 'Unit')) ||  
			(!is_empty($_POST['department_id'], 'Department')) ||
			(!is_empty($_POST['employee_id'], 'Employee')) 
			) &&
			(
				1
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
             display_warning("One or more issues detected. Please check the paid salary logs for clarifications");
            //set_focus('name');
 	}
        refresh_pager($pager);
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
multiple_array_selector('unit_id', _("Unit"), $unit_db -> search_advanced($arr), 0);
row_end();
row_start();			
$arr = array('department_id' => null,'name' => null,'unit_id' => $_POST['unit_id']);
multiple_array_selector('department_id', _("Department"), $department_db -> search_advanced($arr), 0);
row_end();
row_start();			
$arr = array('employee_id' => null,'first_name' => null,'unit_id' => $_POST['unit_id'],'department_id' => $_POST['department_id'],
			  'employee_status_id' => array('table' => $prefix.'employee','label' => 'employee_status_id', 'value' => 
			  array(array('label' => 'employee_status_id', 'attachment' => 'and', 'operator' => '<=', 'value' => EMPLOYEE_CONFIRMATION))));
multiple_array_selector('employee_id', _("Employee"), $employee_db -> search_advanced($arr,array('enable_where' => 1)), 0);
row_end();
//--------------------------------------------------
$company = get_company_pref();
$total = $employee_payroll_db -> select_overdue_total($transaction_code,@$_POST['employee_id'],@$_POST['department_id'],@$_POST['unit_id']);
if(empty($total))
{
	$total = "00.00";
}
$total = number_format($total,2,'.',',');
$total .= " ".$company['curr_default'];
label_row("Total Overdue Salary",$total,"","style = 'padding-left: 8px;'");

$payable = $employee_payroll_db -> select_overdue_payable($transaction_code,@$_POST['employee_id'],@$_POST['department_id'],@$_POST['unit_id']);
if(empty($payable))
{
	$payable = "00.00";
}
$payable = number_format($payable,2,'.',',');
$payable .= " ".$company['curr_default'];
label_row("Total Payable Salary",$payable,"","style = 'padding-left: 8px;'");

textarea_row(_("Reason:"), 'transaction_reason', @$_POST['transaction_reason'], 35, 5);
new_headers_end($selected_id);
//----Custom Pager Display Start---------
$overdue = $employee_payroll_db -> search_payroll_overdue($transaction_code,@$_POST['employee_id'],@$_POST['department_id'],@$_POST['unit_id']);
$history = $employee_payroll_db -> search_payroll_history($transaction_code,@$_POST['employee_id'],@$_POST['department_id'],@$_POST['unit_id']);  
$where = explode('where',$overdue);
if(isset($where[1]))
{
	$where = $where[1];
}
else
{
	$where = '';
}
//------------------------
$th = array(_("Employee Name"),_("Department"),_("Unit"),_("Overdue Salary"),_("Payable Salary"),_("Overdue Days"),_("Last Draw Salary"),_("Salary Paid Date"),_("Salary Paid Month"),_("Salary Paid Year"));
$sql = $history;
$et = $employee_db -> table;
$department = $prefix.'department';
$unit = $prefix.'unit';
$table_count = PluSQL::from($profile)->$et->$department->$unit->where($where)->select("count(".$prefix."employee.employee_id) as cnt,employee_id")->run()->$et->cnt;
$table = &new_db_pager("employee_payroll_history", $sql , $th);
$curr_page = 0;
if(!is_null($table->curr_page))
    $curr_page = $table->curr_page;
$limit = "limit ".($curr_page * $table->page_len).", ".$table->page_len;
//$employee_payroll_db ->update_overdue_payroll(@$_POST['employee_id'], @$_POST['department_id'], @$_POST['unit_id'], $limit,true);
custom_pager_display("employee_payroll_history",$th,$sql,"70%",$table_count,$controller,null, null, null, null,true,"/hrm/reports/",_("Employee Payroll (History & Last Drawn)"));
//----Custom Pager Display End---------
//----Standard Pager Display Start---------
$th = array(_("Employee Name"),_("Basic Salary"),_("Allowances"),_("Deductions"),_("Absents"),_("Leaves"),_("Advances"),_("Installments"),_("Total"));
$sql = $overdue; 
$table = &new_db_pager("employee_payroll_overdue", $sql , $th);
$curr_page = 0;
if(!is_null($table->curr_page))
    $curr_page = $table->curr_page;
$limit = "limit ".($curr_page * $table->page_len).", ".$table->page_len;
//$employee_payroll_db ->update_overdue_payroll(@$_POST['employee_id'], @$_POST['department_id'], @$_POST['unit_id'], $limit, true);
pager_display("employee_payroll_overdue",$th,$sql,"70%",$controller,null, null, null, null,true,"/hrm/reports/",_("Employee Payroll (Payable Salary Breakdown)"));
//----Custom Pager Display End---------
//----start the search and print section of the page------------
search_headers_start($controller."s");

row_start();
ref_cells(_("Employee First Name"), 'search_first_name', '',null, '', true);
check_cells("", "print_first_name", 1);
row_end();

row_start();
ref_cells(_("Employee Last Name"), 'search_last_name', '',null, '', true);
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
pager_display($pager,$th,$sql,"60%",$controller,null,'delete_link');
//----end the page---------
page_end();
//----helper functions for processing payroll-------------

?>