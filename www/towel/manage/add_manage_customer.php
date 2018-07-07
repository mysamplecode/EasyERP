<?php
/**********************************************************************
    Copyright (C) FrontAccounting, LLC.
	Released under the terms of the GNU General Public License, GPL, 
	as published by the Free Software Foundation, either version 3 
	of the License, or (at your option) any later version.
    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  
    See the License here <http://www.gnu.org/licenses/gpl-3.0.html>.
***********************************************************************/
$page_security = 'SS_TOWELM';
$path_to_root = "../..";

include_once($path_to_root . "/includes/db_pager.inc");
include_once($path_to_root . "/includes/session.inc");
include_once($path_to_root . "/includes/ui.inc");
include_once($path_to_root . "/towel/includes/db/customer_db.inc"); 
include_once($path_to_root . "/reporting/includes/reports_classes.inc"); 
include_once($path_to_root . "/gl/includes/gl_db.inc"); 
include_once($path_to_root . "/towel/view/custom_inputs.php"); 
 
$js = "";
 
	simple_page_mode(true);
 
 function edit_link($row){ 
		return button("Edit".$row['id'],1, _("Edit"), ICON_EDIT );
 }
 function delete_link($row){
		
		return button("Delete".$row['id'],1, _("Delete"),ICON_DELETE );
 }
function can_process()
{
	
 global $Mode;
	if (strlen($_POST['address']) == 0)
	{
		display_error(_("The  address cannot be empty."));
		set_focus('address');
		return false;
	}
	if (strlen($_POST['ntn']) == 0)
	{
		display_error(_("The  ntn cannot be empty."));
		set_focus('ntn');
		return false;
	}
	if (strlen($_POST['contact_pname']) == 0)
	{
		display_error(_("The  contact name cannot be empty."));
		set_focus('contact_pname');
		return false;
	}
	if (strlen($_POST['contact_pdesig']) == 0)
	{
		display_error(_("The  contact designation cannot be empty."));
		set_focus('contact_pdesig');
		return false;
	}
	if (strlen($_POST['contact_pno']) == 0)
	{
		display_error(_("The  contact no cannot be empty."));
		set_focus('contact_pno');
		return false;
	}
	if (strlen($_POST['stype']) == 0)
	{
		display_error(_("The  customer cannot be empty."));
		set_focus('stype');
		return false;
	}
	if (!ctype_digit($_POST['ntn']))
	{
		display_error(_("The  ntn can contain only number."));
		set_focus('ntn');
		return false;
	}
	if (!ctype_digit($_POST['contact_pno']))
	{
		display_error(_("The  contact number can contain only number."));
		set_focus('contact_pno');
		return false;
	}
	if (!ctype_alpha($_POST['contact_pname']))
	{
		display_error(_("The  contact name can contain only letters."));
		set_focus('contact_pname');
		return false;
	}
	if (!ctype_alpha($_POST['contact_pdesig']))
	{
		display_error(_("The  contact designation can contain only letters."));
		set_focus('contact_pdesig');
		return false;
	}
 
	return true;
}
	
if ($Mode=='ADD_ITEM' && can_process())
{

 	add_tsupplier($_POST['address'],@$_POST['ntn'],@$_POST['contact_pname'],$_POST['contact_pdesig'],@$_POST['contact_pno'],@$_POST['stype'],$_POST['name']);
	display_notification(_('New customer has been added'));

 	$Mode = 'RESET';
}
if ($Mode=='UPDATE_ITEM' && can_process() )
{

	update_tsupplier($selected_id, $_POST['address'],@$_POST['ntn'],@$_POST['contact_pname'],$_POST['contact_pdesig'],@$_POST['contact_pno'],@$_POST['stype'],$_POST['name']);
	display_notification(_('Selected customer has been updated'));
	$Mode = 'RESET';
}
if ($Mode == 'Delete')
{
 //	if (key_in_foreign_table($selected_id, 'department', 'unitid'))
//	{
//		display_error(_("Cannot delete this Unit because it is used in some departments."));
//		$Mode = 'RESET';
//	} else { 
		delete_tsupplier($selected_id);
		display_notification(_('Selected customer has been deleted'));
		$Mode = 'RESET';
//	 }
}
if(isset($_POST['PrintOrders'])){ 
$rep_file = find_custom_file("/towel/reports/rep_customer.php");
if ($rep_file) {
	require($rep_file);
}
 
die();

} 
if ($Mode == 'RESET')
{
	refresh_pager('supplier_tbl');
	$selected_id = -1; 
	unset($_POST); 
}	
page(_($help_context = "Towel  customers"), false, false, "", ''); 

 

start_form();

br();
display_heading("Add new customer type"); br();
start_table(TABLESTYLE2);

if ($selected_id != -1)
{

 	if ($Mode == 'Edit') {
 
		$myrow = get_tsupplier($selected_id); 
		$_POST['address']  = $myrow["address"];  
		$_POST['ntn']  = $myrow["ntn"];  
		$_POST['contact_pname']  = $myrow["contact_pname"];  
		$_POST['contact_pdesig']  = $myrow["contact_pdesig"];  
		$_POST['contact_pno']  = $myrow["contact_pno"];  
		$_POST['stype']  = $myrow["stype"];   
		$_POST['name']  = $myrow["name"];  
	}
	hidden('selected_id', $selected_id);
} 

text_row_ex(_("Address").':', 'address',50,500);
text_row_ex(_("Name").':', 'name',50,500);  
text_row_ex(_("NTN").':', 'ntn',50,100);  
text_row_ex(_("Contact Person Name").':', 'contact_pname',50,200);  
text_row_ex(_("Contact Person Designation").':', 'contact_pdesig',50,200);  
text_row_ex(_("Contact Person Number").':', 'contact_pno',50,200);  
 custom_select_row("customer Type","stype",array("Commercial Dyer"=>"Commercial Dyer","Greige Manufacturer"=>"Greige Manufacturer"));
end_table(1);

submit_add_or_update_center($selected_id == -1, '', 'both');
 
	br(2); 
 display_heading ("Print");  
	br(); 
start_table(TABLESTYLE2); 
row_start();
  
check_cells("Remove name", "remove_name", "all");
row_end();
row_start();
check_cells("Remove address", "remove_address", "all");
row_end();
row_start();
check_cells("Remove ntn", "remove_ntn", "all");
row_end();
row_start();
check_cells("Remove contact name", "remove_contact_pname", "all");
row_end();
row_start();
check_cells("Remove contact designation", "remove_contact_pdesig", "all");
row_end();
row_start();
check_cells("Remove contact no", "remove_contact_pno", "all");
row_end();
row_start();
check_cells("Remove customer type", "remove_stype", "all");
row_end();
row_start();
check_cells("Print all records", "allRecords", "all");
row_end();
row_start();
yesno_list_cells("Export type", "printType", $selected_id, "XLS","PDF");
row_end(); end_table(1);
br(1);
start_table(TABLESTYLE2); 
row_start();
submit_cells('PrintOrders', _("Print"),'',_('Print documents'), 'default');
	hidden('REP_ID', 'tsupplier' );
end_table(1); 
 
	 br();
	br(); 
 display_heading ("Filter customers"); br();
start_table(TABLESTYLE2);
row_start();
ref_cells(_("Search by name"), 'sName', '',null, '', true);
row_end();
row_start();
ref_cells(_("Search by address"), 'sAddress', '',null, '', true);
row_end();
row_start();
ref_cells(_("Search by ntn "), 'sNtn', '',null, '', true);
row_end();
row_start();
ref_cells(_("Search by contact person name"), 'sContact_pname', '',null, '', true);
row_end();
row_start();
ref_cells(_("Search by contact person designation name"), 'sContact_pdesig', '',null, '', true);
row_end();
row_start();
ref_cells(_("Search by contact person number type name"), 'sContact_pno', '',null, '', true);
row_end();
row_start();
 
 custom_select_row("Search by supplier type","sStype",array(""=>"All","Commercial Dyer"=>"Commercial Dyer","Greige Manufacturer"=>"Greige Manufacturer"),true);
row_end(); 
end_table(1);	
start_table(TABLESTYLE2); 
submit_cells('SearchOrders', _("Search"),'',_('Select documents'), 'default');
end_table(1);
 $th = array (_('Name'),_('Address'),_('NTN'),_('Contact Person Name'),_('Contact Person Designation'),_('Contact Person Number'),_('customer Type') );
 
 array_append($th, array(
		array('insert'=>true, 'fun'=>'edit_link'),
		array('insert'=>true, 'fun'=>'delete_link')));
$sql  = get_search_sql_tsupplier(@$_POST['sName'],@$_POST['sAddress'],@$_POST['sNtn'],@$_POST['sContact_pname'],@$_POST['sContact_pdesig'],@$_POST['sContact_pno'],@$_POST['sStype']);
$table = &new_db_pager('supplier_tbl', $sql , $th);  
$table->width = "80%";

display_db_pager($table);
submit_center('Update', _("Update"), true, '', null);
 end_form();
end_page(false);
 
?>
