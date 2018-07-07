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
include_once($path_to_root . "/towel/includes/db/inventory_db.inc"); 
include_once($path_to_root . "/reporting/includes/reports_classes.inc"); 
include_once($path_to_root . "/gl/includes/gl_db.inc"); 
include_once($path_to_root . "/towel/view/custom_inputs.php"); 
include_once($path_to_root . "/towel/view/inventory_views.php"); 
 add_js_file("jquery.js");
 add_js_file("jqueryui.js");
 add_js_file("common.js");

$js = get_js_date_picker();
		add_js_source($js);
 $general_posts =  array("ino","igp" , "recv","recvby" ,"sup","gate_in","goods","driver","vehicle","builty","gate_out" );
 $bale_posts =   array( 'tsize','npieces',"bale","pally","gweight","nweight","shade","taginfo","remarks","ptype");
	simple_page_mode(true);
if(isset($_POST['jselected_id']) && $jselected_id==0)   $jselected_id = $_POST['jselected_id'];
	hidden('jselected_id',$jselected_id);
if(isset($_POST['selected_id']) && $selected_id==0)   $selected_id = $_POST['selected_id'];
	hidden('selected_id',$selected_id);
 function edit_link($row){ 
		return button("Edit".$row['id'],1, _("Edit"), ICON_EDIT );
 }
 function delete_link($row){
		
		return button("Delete".$row['id'],1, _("Delete"),ICON_DELETE );
 }
 function edit_linkj($row){ 
		return button("jEdit".$row['id'],1, _("jEdit"), ICON_EDIT );
 }
 function delete_linkj($row){
		
		return button("jDelete".$row['id'],1, _("jDeletej"),ICON_DELETE );
 }
 function print_link($row){
		
			return button("Print".$row['id'],1, _("Print"),ICON_PRINT );
 }
function can_process_general()
{		
	global $selected_id;
	if(get_post('_tabs_sel') == 'bales') return true; 
	 $unique = array("ino" );
	 $numeric = array("igp","ino" );
	 $text = array("recv","recvby");
	 $textnumbers = array("sup","gate_in","goods","driver","vehicle","builty","gate_out" );
	 $total = array_merge($numeric,$text,$textnumbers);
	 foreach($total as $field){
		if(strlen($_POST[$field]) == 0){
			display_error("Empty field");
			set_focus($field);
			return false;
		}
		if(in_array($field,$numeric)){
			if(!ctype_digit($_POST[$field])){
				display_error("Only numbers allowed");
				set_focus($field);
				return false;
			}
		}
		if(in_array($field,$text)){
			if(!ctype_alpha(str_replace(array(".",",","-"),"",$_POST[$field]))){
				display_error("Only text allowed");
				set_focus($field);
				return false;
			}
		}
		if(in_array($field,$unique)){
			if(check_duplicate("id",$_POST[$field],"tinventory",$selected_id)){
				display_error("Duplicate entry!");
				set_focus($field);
				return false;
			}
		}
	 
	 }
 
	return true;
}
function can_process_bale()
{	
	if(get_post('_tabs_sel') == 'general') return true; 
	 $numeric = array( "bale","npieces","pally","gweight","nweight");
	 $text = array( );
	 $textnumbers = array("shade","taginfo","remarks","ptype");
	 $total = array_merge($numeric,$text,$textnumbers);
	 foreach($total as $field){
		if(strlen($_POST[$field]) == 0){
			display_error("Empty field");
			set_focus($field);
			return false;
		}
		if(in_array($field,$numeric)){
			if(!ctype_digit($_POST[$field])){
				display_error("Only numbers allowed");
				set_focus($field);
				return false;
			}
		}
		if(in_array($field,$text)){
			if(!ctype_alpha(str_replace(array(".",",","-"),"",$_POST[$field]))){
				display_error("Only text allowed");
				set_focus($field);
				return false;
			}
		}
	 
	 }
 
	return true;
}
	
if ($Mode=='ADD_ITEM' && can_process_general() && get_post('_tabs_sel') != 'bales')
{

	 $selected_id = add_inventory($_POST['ino'],@$_POST['sup'],strtotime(@$_POST['gate_in']),@$_POST['igp'],@$_POST['goods'],@$_POST['driver'],@$_POST['vehicle'],@$_POST['builty'],strtotime(@$_POST['gate_out']),@$_POST['recv'],@$_POST['recvby']);
 	 display_notification(_('New inventory has been added'));
	 refresh_pager('tinventory_tbl');
	 $selected_id = $_POST['ino'];
	 $Mode =  'Edit';
}
if ($Mode=='ADD_ITEM' && can_process_bale() && get_post('_tabs_sel') != 'general')
{
 	
	 add_bale($selected_id,@$_POST['tsize'],@$_POST['bale'], @$_POST['pally'],@$_POST['gweight'],@$_POST['nweight'],@$_POST['shade'],@$_POST['taginfo'],@$_POST['remarks'],@$_POST['ptype'],@$_POST['npieces']);
	
	 refresh_pager('tbale_tbl');
	 foreach($bale_posts as $bp) unset($_POST[$bp]);  
	 $jselected_id = 0 ;
 	 display_notification(_('New bale has been added'));
 
}
if ($Mode=='UPDATE_ITEM' && can_process_general() && get_post('_tabs_sel') == 'general' )
{
	update_inventory($selected_id,$_POST['ino'],@$_POST['sup'],strtotime(@$_POST['gate_in']),@$_POST['igp'],@$_POST['goods'],@$_POST['driver'],@$_POST['vehicle'],@$_POST['builty'],strtotime(@$_POST['gate_out']),@$_POST['recv'],@$_POST['recvby']); 
	display_notification(_('Selected inventory has been updated'));
	refresh_pager('tinventory_tbl');
	foreach($general_posts as $gp) unset($_POST[$gp]); 
	$selected_id = -1;
}
if ($Mode=='UPDATE_ITEM' && can_process_bale() && get_post('_tabs_sel') == 'bales' )
{	 
	update_bale($jselected_id,@$_POST['tsize'],@$_POST['bale'], @$_POST['pally'],@$_POST['gweight'],@$_POST['nweight'],@$_POST['shade'],@$_POST['taginfo'],@$_POST['remarks'],@$_POST['ptype'],@$_POST['npieces']); 
	display_notification(_('Selected bale has been updated'));
	refresh_pager('tbale_tbl');
	foreach($bale_posts as $bp) unset($_POST[$bp]);  
	$jselected_id = 0 ;
}
if ($Mode == 'Delete' && get_post('_tabs_sel') == 'general')
{
		delete_inventory($selected_id);
		display_notification(_('Selected supplier has been deleted'));
		$Mode = 'RESET';
 
}
if ($Mode == 'jDelete' && get_post('_tabs_sel') == 'bales')
{
		delete_bale($jselected_id);
		display_notification(_('Selected bale has been deleted'));
		$Mode = 'RESET';
 
} 
$rep_file = find_custom_file("/towel/reports/rep_inventory.php");
if ($rep_file) {
	require($rep_file);
}
  
  
if ($Mode == 'RESET' &&  get_post('_tabs_sel') == 'general')
{ 
	 refresh_pager('inventory_tbl');
	 $selected_id = -1; 
	 foreach($general_posts as $gp) unset($_POST[$gp]); 
} 
if ($Mode == 'RESET' &&  get_post('_tabs_sel') == 'bales')
{ 
	 refresh_pager('tbale_tbl');
	 $jselected_id = 0; 
	 foreach($bale_posts as $bbp) unset($_POST[$bbp]); 
}	

 
page(_($help_context = "Towel  Inventory"), false, false, "", ''); 

 

start_form();

br();
display_heading("Add new inventory"); br();
 

 
 
 
 
tabbed_content_start('tabs', array(
		'general' => array(_('General'), $selected_id),
		'bales' => array(_('Bales'), $selected_id) 
	));
if ($selected_id != -1)
{
		
		$row = get_inventory($selected_id); 
		foreach($row as $k=>$v){
			$_POST[$k] = $v;
		}  
		$_POST['gate_in'] = date("m/d/Y",$_POST['gate_in']);
		$_POST['gate_out'] = date("m/d/Y",$_POST['gate_out']);
		hidden('selected_id', $selected_id); 
}
if ($jselected_id != 0 && isset($jselected_id))
{
		
		$row = get_bale($jselected_id);
		
		foreach($row as $k=>$v){
			$_POST[$k] = $v;
		}   
		hidden('jselected_id', $jselected_id); 
}	
 
	switch (get_post('_tabs_sel')) {
		default:
		case 'general': 
			display_heading("General"); 
			show_inventory_general();
		break;
		case 'bales':   
			display_heading("Bales"); 
			show_inventory_bales();
		break; 
	};
  tabbed_content_end();
  
 br(2);
 
 $_POST['totali'] = get_total_itemst($selected_id);
 $_POST['totaln'] = get_total_nweightt($selected_id);
 $_POST['totalg'] = get_total_gweightt($selected_id);
start_table(TABLESTYLE2); 
	text_row_ex(_("Total Items").':', 'totali',10,30);
	text_row_ex(_("Total Gross Weight").':', 'totalg',10,30);
	text_row_ex(_("Total Net Weight").':', 'totaln',10,30);
end_table(1);
  br(3);

 $th = array (_('Supplier'),_('IGP NO') ) ;
 
 array_append($th, array(
		array('insert'=>true, 'fun'=>'edit_link'),
		array('insert'=>true, 'fun'=>'delete_link'),
		array('insert'=>true, 'fun'=>'print_link')));
$sql  = get_search_sql_tinventory();
$table = &new_db_pager('tinventory_tbl', $sql , $th);  
$table->width = "80%";

display_db_pager($table);

	hidden('REP_ID', 'tinventory' );
submit_center('Update', _("Update"), true, '', null);
end_form();
end_page(false);
 
?>
