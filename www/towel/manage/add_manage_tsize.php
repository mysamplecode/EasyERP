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
include_once($path_to_root . "/towel/includes/db/tsize_db.inc"); 
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
	if (strlen($_POST['name']) == 0)
	{
		display_error(_("The  width cannot be empty."));
		set_focus('width');
		return false;
	}	
	if (strlen($_POST['width']) == 0)
	{
		display_error(_("The  width cannot be empty."));
		set_focus('width');
		return false;
	}
	if (strlen($_POST['weight']) == 0)
	{
		display_error(_("The  weight cannot be empty."));
		set_focus('weight');
		return false;
	}
	if (strlen($_POST['length']) == 0)
	{
		display_error(_("The  length cannot be empty."));
		set_focus('length');
		return false;
	}
	if (!ctype_digit($_POST['length']))
	{
		display_error(_("The  length can only be a number"));
		set_focus('length');
		return false;
	}
	if (!ctype_digit($_POST['width']) )
	{
		display_error(_("The  width can only be a number."));
		set_focus('width');
		return false;
	}
	if (!ctype_digit($_POST['weight']) )
	{
		display_error(_("The  weight can only be a number."));
		set_focus('weight');
		return false;
	} 
 
	return true;
}
	
if ($Mode=='ADD_ITEM' && can_process())
{

 	add_tsize($_POST['name'],$_POST['width'],@$_POST['length'],@$_POST['weight']);
	display_notification(_('New towel size has been added'));

 	$Mode = 'RESET';
}
if ($Mode=='UPDATE_ITEM' && can_process() )
{

	update_tsize($selected_id, $_POST['name'], $_POST['width'],@$_POST['length'],@$_POST['weight']);
	display_notification(_('Selected towel size has been updated'));
	$Mode = 'RESET';
}
if ($Mode == 'Delete')
{
 //	if (key_in_foreign_table($selected_id, 'department', 'unitid'))
//	{
//		display_error(_("Cannot delete this Unit because it is used in some departments."));
//		$Mode = 'RESET';
//	} else { 
		delete_tsize($selected_id);
		display_notification(_('Selected supplier has been deleted'));
		$Mode = 'RESET';
//	 }
}
if(isset($_POST['PrintOrders'])){ 
$rep_file = find_custom_file("/towel/reports/rep_tsize.php");
if ($rep_file) {
	require($rep_file);
}
 
die();

} 
if ($Mode == 'RESET')
{
	refresh_pager('tsize_tbl');
	$selected_id = -1; 
	unset($_POST); 
}	
page(_($help_context = "Towel  size"), false, false, "", ''); 

 

start_form();

br();
display_heading("Add new towel size"); br();
start_table(TABLESTYLE2);

if ($selected_id != -1)
{

 	if ($Mode == 'Edit') {
 
		$myrow = get_tsize($selected_id); 
		$_POST['name']  = $myrow["name"];  
		$_POST['width']  = $myrow["width"];  
		$_POST['length']  = $myrow["length"];  
		$_POST['weight']  = $myrow["weight"];
	}
	hidden('selected_id', $selected_id);
} 

text_row_ex(_("Name").':', 'name',50,500);
text_row_ex(_("Width").':', 'width',50,500);  
text_row_ex(_("Length").':', 'length',50,100);  
text_row_ex(_("Weight").':', 'weight',50,200);   
end_table(1);

submit_add_or_update_center($selected_id == -1, '', 'both');
 
	br(2); 
 display_heading ("Print");  
	br(); 
start_table(TABLESTYLE2); 
row_start();

check_cells("Remove name", "remove_name", "all");
check_cells("Remove width", "remove_width", "all");
check_cells("Remove length", "remove_length", "all");
check_cells("Remove weight", "remove_weight", "all"); 
row_end();
check_cells("Print all records", "allRecords", "all");
yesno_list_cells("Export type", "printType", $selected_id, "XLS","PDF");
submit_cells('PrintOrders', _("Print"),'',_('Print documents'), 'default');
	hidden('REP_ID', 'tsupplier' );
end_table(1); 
 
	 br();
	br(); 
 display_heading ("Filter towel sizes"); br();
start_table(TABLESTYLE2);
row_start();
ref_cells(_("Search by name"), 'sName', '',null, '', true);

row_end();
row_start();
ref_cells(_("Search by width"), 'sWidth', '',null, '', true);
row_end();
row_start();
ref_cells(_("Search by length"), 'sLength', '',null, '', true);
row_end();
row_start();
ref_cells(_("Search by weight"), 'sweight', '',null, '', true);
row_end(); 
 

end_table(1);	
start_table(TABLESTYLE2); 
submit_cells('SearchOrders', _("Search"),'',_('Select documents'), 'default');
end_table(1);
 $th = array (_('Name'),_('Width'),_('Length'),_('Weight'));
 
 array_append($th, array(
		array('insert'=>true, 'fun'=>'edit_link'),
		array('insert'=>true, 'fun'=>'delete_link')));
$sql  = get_search_sql_tsize(@$_POST['sName'],@$_POST['sWidth'],@$_POST['sLength'],@$_POST['sWeight'] );
$table = &new_db_pager('tsize_tbl', $sql , $th);  
$table->width = "80%";

display_db_pager($table);
submit_center('Update', _("Update"), true, '', null);
 end_form();
end_page(false);
 
?>
