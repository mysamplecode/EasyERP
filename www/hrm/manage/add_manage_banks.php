<?php
//----security and path settings---------
$page_security = 'SA_HRM_BANKS';
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
$pager = "bank_tbl";
//----Database model defined--------
$bank_db = new bank_model();
//----message controller----
$controller = "Bank";
//---loggers----------------
pr("selected ID = $selected_id and Mode = $Mode");
pr($_POST);
//----form specific helper function	
function can_process()
{
	global $controller;
	return 
			(!is_empty($_POST['name'], "$controller Name"))  &&
			(!is_empty($_POST['country'], "$controller Country"))  &&
			(!is_empty($_POST['swift'], "$controller Swift"))  &&
			(!is_empty($_POST['branch'], "$controller Branch Name"))  &&
			(!is_empty($_POST['branch_number'], "$controller Branch #"))  &&
			(!is_empty($_POST['address'], "$controller Address"))  &&
			(!is_empty($_POST['city'], "$controller City"))  &&
			(!is_empty($_POST['province'], "$controller Province"))  &&
			(!is_empty($_POST['postal_code'], "$controller Postal Code"))  
			;
}
//---add item----------------
if( (strcmp($Mode,'ADD_ITEM')==0) && can_process() )
{
	$flag = $bank_db -> insert($_POST['name'],$_POST['country'],$_POST['swift'],$_POST['branch'],$_POST['branch_number'],$_POST['address']
								,$_POST['city'],$_POST['province'],$_POST['postal_code']);
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
	$bank_db -> update($selected_id, $_POST['name'],$_POST['country'],$_POST['swift'],$_POST['branch'],$_POST['branch_number'],$_POST['address']
								,$_POST['city'],$_POST['province'],$_POST['postal_code']);
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
		$bank_db -> delete($selected_id);
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
		$bank_db -> select($selected_id, &$_POST); 
	}
	hidden('selected_id', $selected_id);
} 
text_row_ex(_("$controller Name").':', 'name',50,50);
text_row_ex(_("Country").':', 'country',50,50);
text_row_ex(_("Swift Code").':', 'swift',50,50);
text_row_ex(_("Branch Name").':', 'branch',50,50);
text_row_ex(_("Branch #").':', 'branch_number',50,50);
text_row_ex(_("Address").':', 'address',100,100);
text_row_ex(_("City").':', 'city',50,50);
text_row_ex(_("Province").':', 'province',50,50);
text_row_ex(_("Postal Code").':', 'postal_code',50,50);

new_headers_end($selected_id);
//----start the search and print section of the page------------
search_headers_start($controller."s");

row_start();
ref_cells(_("$controller Name"), 'search_name', '',null, '', true);
check_cells("", "print_name", 1);
row_end();

row_start();
ref_cells(_("Country"), 'search_country', '',null, '', true);
check_cells("", "print_country", 1);
row_end();

row_start();
ref_cells(_("Swift Code"), 'search_swift', '',null, '', true);
check_cells("", "print_swift", 1);
row_end();

row_start();
ref_cells(_("Branch Name"), 'search_branch', '',null, '', true);
check_cells("", "print_branch", 1);
row_end();

row_start();
ref_cells(_("Branch #"), 'search_branch_number', '',null, '', true);
check_cells("", "print_branch_number", 1);
row_end();

row_start();
ref_cells(_("Address"), 'search_address', '',null, '', true);
check_cells("", "print_address", 1);
row_end();

row_start();
ref_cells(_("City"), 'search_city', '',null, '', true);
check_cells("", "print_city", 1);
row_end();

row_start();
ref_cells(_("Province"), 'search_province', '',null, '', true);
check_cells("", "print_province", 1);
row_end();

row_start();
ref_cells(_("Postal Code"), 'search_postal_code', '',null, '', true);
check_cells("", "print_postal_code", 1);
row_end();

search_headers_end();
//----start the pager section of the page---------
$th = array(_("$controller Name"),_("Country"),_("Swift Code"),_("Branch Name"),_("Branch #"),_("Address"),_("City"),_("Province"),_("Postal Code"));
$sql = $bank_db -> search(@$_POST['search_name'],@$_POST['search_country'],@$_POST['search_swift'],@$_POST['search_branch']
								,@$_POST['search_branch_number'],@$_POST['search_address']
								,@$_POST['search_city'],@$_POST['search_province'],@$_POST['search_postal_code']);
pager_display($pager,$th,$sql,"95%",$controller);
//----end the page---------
page_end();
?>