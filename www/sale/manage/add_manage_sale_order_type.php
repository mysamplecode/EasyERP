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
include_once($path_to_root . "/sale/includes/db/sales_db.inc"); 
include_once($path_to_root . "/reporting/includes/reports_classes.inc"); 
include_once($path_to_root . "/gl/includes/gl_db.inc"); 

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
 	if (check_sale($_POST['type']) && $Mode!='UPDATE_ITEM')
	{
		display_error(_("The type  already exists."));
		set_focus('type');
		return false;
	}
	if (strlen($_POST['type']) == 0)
	{
		display_error(_("The type cannot be empty."));
		set_focus('name');
		return false;
	}
	if (strlen($_POST['description']) == 0)
	{
		display_error(_("The description cannot be empty."));
		set_focus('description');
		return false;
	}
	
	if (!ctype_alnum(str_replace(" ","",$_POST['type'])))
	{
		display_error(_("The description can contain only letters or numeric data."));
		set_focus('type');
		return false;
	}
	if (!ctype_alnum(str_replace(" ","",$_POST['description'])))
	{
		display_error(_("The description can contain only letters or numeric data."));
		set_focus('description');
		return false;
	}
	
  
	return true;
}
	
if ($Mode=='ADD_ITEM' && can_process())
{
 	add_sale($_POST['type'],$_POST['description']);
	display_notification(_('New sales type has been added'));

 	$Mode = 'RESET';
}
if ($Mode=='UPDATE_ITEM' && can_process())
{

	update_sale($selected_id, $_POST['type'],$_POST['description']);
	display_notification(_('Selected sales type has been updated'));
	$Mode = 'RESET';
}
if ($Mode == 'Delete')
{
/*	if (key_in_foreign_table($selected_id, 'department', 'unit'))
	{
		display_error(_("Cannot delete this Unit because it is used in some departments."));
	} else {*/
		delete_sale($selected_id);
		display_notification(_('Selected sales type has been deleted'));
		$Mode = 'RESET';
	//}
}
if(isset($_POST['PrintOrders'])){ 
$rep_file = find_custom_file("/sale/reports/rep_sales.php");
if ($rep_file) {
	require($rep_file);
}
 
die();

} 

if ($Mode == 'RESET')
{
	refresh_pager('banks_tbls');
	$selected_id = -1; 
	unset($_POST); 
}	

page(_($help_context = "Add and Manage Customer Type"), false, false, "", ''); 
 

start_form();
display_heading ("Add Customer Type"); br();
start_table(TABLESTYLE2);

if ($selected_id != -1)
{

 	if ($Mode == 'Edit') {
		$myrow = get_sale($selected_id);

		$_POST['type']  = $myrow["type"]; 
		$_POST['description']  = $myrow["description"]; 
		
	}
	hidden('selected_id', $selected_id);
} 

text_row_ex(_("Type").':', 'type',30,100); 
textarea_row(_("Description").':', 'description','',50,10); 

 

 
end_table(1);


submit_add_or_update_center($selected_id == -1, '', 'both');


br(2);
 display_heading ("Print");  
	br(); 
start_table(TABLESTYLE2); 
row_start();
check_cells("Remove Type", "remove_type", "all"); 
check_cells("Remove Description", "remove_description", "all"); 

row_end();
row_start();
check_cells("Print all records", "allRecords", "all");
yesno_list_cells("Export type", "printType", $selected_id, "XLS","PDF");
row_end();

 hidden('REP_ID', 'bank' );
end_table(1); 
start_table(TABLESTYLE2); 
 submit_cells('PrintOrders', _("Print"),'',_('Print documents'), 'default');
end_table(1); 
	 br();
	br(); 

 display_heading ("Filter Customer Types"); br();
start_table(TABLESTYLE2);
row_start();
ref_cells(_("Search by Type"), 'bType', '',null, '', true);
row_end();
row_start();
ref_cells(_("Search by Description"), 'bDescription', '',null, '', true);
row_end();

 
 
 
end_table(1);	 
	br(2); 

start_table(TABLESTYLE2);
submit_cells('SearchOrders', _("Search"),'',_('Select documents'), 'default');
end_table(1);	
 $th = array (_('Type') ,_('Description'),  );
 
 array_append($th, array(
		array('insert'=>true, 'fun'=>'edit_link'),
		array('insert'=>true, 'fun'=>'delete_link')));
 $sql  = get_search_sql_sale(@$_POST['bType'],@$_POST['bDescription']); 
$table = &new_db_pager('banks_tbls', $sql , $th );  
$table->width = "80%";

display_db_pager($table);

submit_center('Update', _("Update"), true, '', null);
 



 
 end_form();
end_page(false);
?>