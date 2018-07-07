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
include_once($path_to_root . "/towel/includes/db/eparam_db.inc"); 
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
	if (strlen($_POST['lsize']) == 0)
	{
		display_error(_("The  lot size cannot be empty."));
		set_focus('lsize');
		return false;
	}
	if (strlen($_POST['tol']) == 0)
	{
		display_error(_("The  tolerance cannot be empty."));
		set_focus('tol');
		return false;
	}
	if (strlen($_POST['lpre']) == 0)
	{
		display_error(_("The  lot preparation cannot be empty."));
		set_focus('lpre');
		return false;
	}
	if (strlen($_POST['care']) == 0)
	{
		display_error(_("The  care section hours cannot be empty."));
		set_focus('care');
		return false;
	}
	if (strlen($_POST['bleach']) == 0)
	{
		display_error(_("The   bleach section hours cannot be empty."));
		set_focus('bleach');
		return false;
	}
	if (strlen($_POST['dye']) == 0)
	{
		display_error(_("The  dye hours cannot be empty."));
		set_focus('dye');
		return false;
	}
	if (strlen($_POST['hydro']) == 0)
	{
		display_error(_("The  hydro section hours cannot be empty."));
		set_focus('hydro');
		return false;
	}
	if (strlen($_POST['tum']) == 0)
	{
		display_error(_("The  tumbler section hours cannot be empty."));
		set_focus('tum');
		return false;
	}
	if (strlen($_POST['qua']) == 0)
	{
		display_error(_("The  Quality Section hours cannot be empty."));
		set_focus('qua');
		return false;
	} 
	if (!ctype_digit(str_replace(array(",","."),"",$_POST['lsize'])))
	{
		display_error(_("Invalid number."));
		set_focus('lsize');
		return false;
	}
	if (!ctype_digit(str_replace(array(",","."),"",$_POST['tol'])) )
	{
		display_error(_("Invalid number."));
		set_focus('tol');
		return false;
	}
	if (!ctype_digit(str_replace(array(",","."),"",$_POST['lpre'])) )
	{
		display_error(_("Invalid number."));
		set_focus('lpre');
		return false;
	}
	if (!ctype_digit(str_replace(array(",","."),"",$_POST['care'])) )
	{
		display_error(_("Invalid number."));
		set_focus('care');
		return false;
	}
	if (!ctype_digit(str_replace(array(",","."),"",$_POST['bleach'])) )
	{
		display_error(_("Invalid number."));
		set_focus('bleach');
		return false;
	}
	if (!ctype_digit(str_replace(array(",","."),"",$_POST['dye'])) )
	{
		display_error(_("Invalid number."));
		set_focus('dye');
		return false;
	}
	if (!ctype_digit(str_replace(array(",","."),"",$_POST['hydro'])) )
	{
		display_error(_("Invalid number."));
		set_focus('hydro');
		return false;
	}
	if (!ctype_digit(str_replace(array(",","."),"",$_POST['tum'])) )
	{
		display_error(_("Invalid number."));
		set_focus('tum');
		return false;
	}
	if (!ctype_digit(str_replace(array(",","."),"",$_POST['qua'])) )
	{
		display_error(_("Invalid number."));
		set_focus('qua');
		return false;
	} 
 
 
	return true;
}
	
if ($Mode=='ADD_ITEM' && can_process())
{

 	add_eparam($_POST['lsize'],@$_POST['tol'],@$_POST['lpre'],$_POST['care'],@$_POST['bleach'],@$_POST['dye'],$_POST['hydro'],@$_POST['tum'],@$_POST['qua']);
	display_notification(_('New parameter has been added'));

 	$Mode = 'RESET';
}
if ($Mode=='UPDATE_ITEM' && can_process() )
{

	update_eparam($selected_id, $_POST['lsize'],@$_POST['tol'],@$_POST['lpre'],$_POST['care'],@$_POST['bleach'],@$_POST['dye'],$_POST['hydro'],@$_POST['tum'],@$_POST['qua']);
	display_notification(_('Selected parameter has been updated'));
	$Mode = 'RESET';
}
if ($Mode == 'Delete')
{
 //	if (key_in_foreign_table($selected_id, 'department', 'unitid'))
//	{
//		display_error(_("Cannot delete this Unit because it is used in some departments."));
//		$Mode = 'RESET';
//	} else { 
		delete_eparam($selected_id);
		display_notification(_('Selected set has been deleted'));
		$Mode = 'RESET';
//	 }
}
if(isset($_POST['PrintOrders'])){ 
$rep_file = find_custom_file("/towel/reports/rep_eparam.php");
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
page(_($help_context = "Efficiency parameters"), false, false, "", ''); 

 

start_form();

br();
display_heading("Add new parameter size"); br();
start_table(TABLESTYLE2);

if ($selected_id != -1)
{

 	if ($Mode == 'Edit') {
 
		$myrow = get_eparam($selected_id); 
		$_POST['lsize']  = $myrow["lsize"];  
		$_POST['tol']  = $myrow["tol"];  
		$_POST['lpre']  = $myrow["lpre"];
		$_POST['care']  = $myrow["care"];  
		$_POST['bleach']  = $myrow["bleach"];  
		$_POST['dye']  = $myrow["dye"];
		$_POST['hydro']  = $myrow["hydro"];  
		$_POST['tum']  = $myrow["tum"];  
		$_POST['qua']  = $myrow["qua"];
	}
	hidden('selected_id', $selected_id);
	
text_row_ex(_("Lot size (kg)").':', 'lsize',50,500);  
text_row_ex(_("Tolerance (%)").':', 'tol',50,500);  
text_row_ex(_("Lot preparation (hours)").':', 'lpre',50,500);  
text_row_ex(_("Care section (hours)").':', 'care',50,500);  
text_row_ex(_("Bleach section (hours)").':', 'bleach',50,500);  
text_row_ex(_("Dyeing section (hours)").':', 'dye',50,500);  
text_row_ex(_("Hydro section (hours)").':', 'hydro',50,500);  
text_row_ex(_("Tumbler section (hours)").':', 'tum',50,500);  
text_row_ex(_("Quality sectio (hours)").':', 'qua',50,500);      
end_table(1);

submit_add_or_update_center($selected_id == -1, '', 'both');
 br(2);
} 
$ref = db_query("select * from ".TB_PREF."teparam ");
if(db_num_rows($ref)==0){

text_row_ex(_("Lot size (kg)").':', 'lsize',50,500);  
text_row_ex(_("Tolerance (%)").':', 'tol',50,500);  
text_row_ex(_("Lot preparation (hours)").':', 'lpre',50,500);  
text_row_ex(_("Care section (hours)").':', 'care',50,500);  
text_row_ex(_("Bleach section (hours)").':', 'bleach',50,500);  
text_row_ex(_("Dyeing section (hours)").':', 'dye',50,500);  
text_row_ex(_("Hydro section (hours)").':', 'hydro',50,500);  
text_row_ex(_("Tumbler section (hours)").':', 'tum',50,500);  
text_row_ex(_("Quality sectio (hours)").':', 'qua',50,500);      
end_table(1);

submit_add_or_update_center($selected_id == -1, '', 'both');
 br(2);
}

  
 $th = array (_('Lot size (kg)'),_('Tolerance (%)'),_('Lot preparation (hours)'),_('Care section (hours)'),_('Bleach Section (hours)'),_('Dyeing section (hours)'),_('Hydro section (hours)'),_('Tumbler section (hours)'),_('Quality section (hours)'));
 
 array_append($th, array(
		array('insert'=>true, 'fun'=>'edit_link') ));
$sql  = get_search_sql_eparam(@$_POST['sLsize'],@$_POST['sTol'],@$_POST['sLpre'],@$_POST['sCare'],@$_POST['sBleach'],@$_POST['sDye'],@$_POST['sHydro'],@$_POST['sTum'],@$_POST['sQua']);
$table = &new_db_pager('tsize_tbl', $sql , $th);  
$table->width = "80%";

display_db_pager($table);
submit_center('Update', _("Update"), true, '', null);
 end_form();
end_page(false);
 
?>
