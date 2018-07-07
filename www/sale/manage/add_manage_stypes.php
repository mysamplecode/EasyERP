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
$page_security = 'SA_HRMADMG';
$path_to_root = "../..";

include_once($path_to_root . "/includes/db_pager.inc");
include_once($path_to_root . "/includes/session.inc");
include_once($path_to_root . "/includes/ui.inc");
include_once($path_to_root . "/hrm/includes/db/stypes_db.inc"); 
include_once($path_to_root . "/reporting/includes/reports_classes.inc"); 
include_once($path_to_root . "/gl/includes/gl_db.inc"); 
 
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
	if (strlen($_POST['name']) == 0)
	{
		display_error(_("The  name cannot be empty."));
		set_focus('name');
		return false;
	}
 
	if(check_duplicate($_POST['name']) && $Mode!='UPDATE_ITEM'){
	
		display_error(_("Duplicate  name."));
		set_focus('name');
		return false;
	
	}
if (!ctype_alpha(str_replace(" ","",$_POST['name'])))
	{
		display_error(_("The name  can contain only letters."));
		set_focus('name');
		return false;
	}
	return true;
}
	
if ($Mode=='ADD_ITEM' && can_process())
{

 	add_stypes($_POST['name'],@$_POST['alow'],@$_POST['ded']);
	display_notification(_('New salary type has been added'));

 	$Mode = 'RESET';
}
if ($Mode=='UPDATE_ITEM' && can_process() )
{

	update_stypes($selected_id, $_POST['name'],@$_POST['alow'],@$_POST['ded']);
	display_notification(_('Selected salary type has been updated'));
	$Mode = 'RESET';
}
if ($Mode == 'Delete')
{
 //	if (key_in_foreign_table($selected_id, 'department', 'unitid'))
//	{
//		display_error(_("Cannot delete this Unit because it is used in some departments."));
//		$Mode = 'RESET';
//	} else { 
		delete_stypes($selected_id);
		display_notification(_('Selected salary type has been deleted'));
		$Mode = 'RESET';
//	 }
}
if(isset($_POST['PrintOrders'])){ 
$rep_file = find_custom_file("/hrm/reports/rep_stypes.php");
if ($rep_file) {
	require($rep_file);
}
 
die();

} 
if ($Mode == 'RESET')
{
	refresh_pager('stypes_tbl');
	$selected_id = -1; 
	unset($_POST); 
}	
page(_($help_context = " Salary Type"), false, false, "", ''); 

 

start_form();

br();
display_heading("Add new salary type"); br();
start_table(TABLESTYLE2);

if ($selected_id != -1)
{

 	if ($Mode == 'Edit') {
 
		$myrow = get_stype($selected_id); 
		$_POST['name']  = $myrow["name"]; 
		$_POST['alow']  = $myrow["alow"]=='yes' ? 1 : 0; 
		$_POST['ded']  = $myrow["ded"] == 'yes' ? 1 : 0;  
	}
	hidden('selected_id', $selected_id);
} 

text_row_ex(_("Name").':', 'name',100,100); 
check_row("Allowances Apply", "alow", "yes"); 
check_row("Deduction Apply", "ded", "yes");
 
end_table(1);

submit_add_or_update_center($selected_id == -1, '', 'both');
 
	br(2); 
 display_heading ("Print");  
	br(); 
start_table(TABLESTYLE2); 
row_start();

check_cells("Remove name", "remove_name", "all");
check_cells("Remove allowence", "remove_alow", "all");
check_cells("Remove deduction", "remove_ded", "all");
row_end();
check_cells("Print all records", "allRecords", "all");
yesno_list_cells("Export type", "printType", $selected_id, "XLS","PDF");
submit_cells('PrintOrders', _("Print"),'',_('Print documents'), 'default');
	hidden('REP_ID', 'stypes' );
end_table(1); 
 
	 br();
	br(); 
 display_heading ("Filter employee status"); br();
start_table(TABLESTYLE2);
ref_cells(_("Search by salary type name"), 'sName', '',null, '', true);

check_row("Allowances Apply?", "sAlow", "yes",true); 
check_row("Deduction Apply?", "sDed", "yes",true);
end_table(1);	
start_table(TABLESTYLE2); 
submit_cells('SearchOrders', _("Search"),'',_('Select documents'), 'default');
end_table(1);
 $th = array (_('Salary Type Name'),_('Allowances Apply'),_('Deduction Apply') );
 
 array_append($th, array(
		array('insert'=>true, 'fun'=>'edit_link'),
		array('insert'=>true, 'fun'=>'delete_link')));
$sql  = get_search_sql_stypes(@$_POST['sName'],@$_POST['sAlow'],@$_POST['sDed']);
$table = &new_db_pager('stypes_tbl', $sql , $th);  
$table->width = "80%";

display_db_pager($table);
submit_center('Update', _("Update"), true, '', null);
 end_form();
end_page(false);
 
?>
