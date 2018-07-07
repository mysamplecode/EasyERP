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
include_once($path_to_root . "/towel/includes/db/lots_db.inc"); 
include_once($path_to_root . "/reporting/includes/reports_classes.inc"); 
include_once($path_to_root . "/gl/includes/gl_db.inc"); 
$js = get_js_date_picker();
		add_js_source($js);
if(!isset($_POST['_tabs_sel'])){
 db_query("update ".TB_PREF."tbales set lotid = '0' where lotid = '-1'");
}
include_once($path_to_root . "/towel/view/custom_inputs.php"); 
include_once($path_to_root . "/towel/view/lots_views.php"); 

$js = "";
 $general_posts =  array( );
 $bale_posts =   array(  );
 $steps_posts =   array(  );
 simple_page_mode(true); 
if(isset($_POST['selected_id']) && $selected_id==-1)   $selected_id = $_POST['selected_id'];
	hidden('selected_id',$selected_id);
 function edit_link($row){ 
 
		if(isset($row['issue'])){
			if($row['issue'] == 1) return ''; 
		}
		return button("Edit".$row['id'],1, _("Edit"), ICON_EDIT );
 }
 function delete_link($row){
		if(isset($row['issue'])){
			if($row['issue'] == 1) return ''; 
		}
		return button("Delete".$row['id'],1, _("Delete"),ICON_DELETE );
 }
 
 function print_link($row){
		
			return button("Print".$row['id'],1, _("Print"),ICON_PRINT );
 }
 function format_datel($row){

	return  date("m/d/Y",$row['pdate']);

}
function can_process_lot()
{		
	global $selected_id;
	if(get_post('_tabs_sel') == 'bales'){
		
				display_error("Please add the general information from general tab!");
				return false;
	} 
	 if(check_tolerance(@$_POST['totalg'])){
				display_error("Total gross weight is not in the lot size tollerance interval!");
 
				return false;
	}
	 $unique = array( "lotno"); 
	 $textnumbers = array("descr");
	 $numeric = array( );
	 $text= array( );
	 $total = array_merge($numeric,$text,$textnumbers,$unique);
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
			 
			if(check_duplicate("lno",$_POST[$field],"tlots",get_ent_name("lno","tlots",$selected_id))){
				display_error("Duplicate entry!");
				set_focus($field);
				return false;
			}
		}
	 
	 }

	return true;
} 
  $_POST['totali'] = get_total_itemst($selected_id);
 $_POST['totaln'] = get_total_nweightt($selected_id);
 $_POST['totalg'] = get_total_gweightt($selected_id);	
if ($Mode=='ADD_ITEM' && can_process_lot() ){ 
	$selected_id = add_lot(@$_POST['lotno'],@$_POST['descr'],strtotime(@$_POST['pdate']));
	add_steps($selected_id, isset($_POST['preparation']) ? "yes":"no",  isset($_POST['care']) ? "yes":"no",  isset($_POST['bleach']) ? "yes":"no",  isset($_POST['dyeing']) ? "yes":"no",  isset($_POST['hydro']) ? "yes":"no",  isset($_POST['tumbler']) ? "yes":"no",  isset($_POST['quality']) ? "yes":"no"  );
	add_bales($selected_id);
	display_notification("Lot added!");
	$Mode = "RESET";
}
 
if ($Mode=='UPDATE_ITEM' && can_process_lot()  )
{	
	update_lot($selected_id,@$_POST['lotno'],@$_POST['descr'],strtotime(@$_POST['pdate']));
	update_steps($selected_id, isset($_POST['preparation']) ? "yes":"no",  isset($_POST['care']) ? "yes":"no",  isset($_POST['bleach']) ? "yes":"no",  isset($_POST['dyeing']) ? "yes":"no",  isset($_POST['hydro']) ? "yes":"no",  isset($_POST['tumbler']) ? "yes":"no",  isset($_POST['quality']) ? "yes":"no"  );
	add_bales($selected_id);
	display_notification("Lot updated!");
	$Mode= "RESET";
}
 
if ($Mode == 'Delete')
{
	delete_lot($selected_id);
	display_notification("Lot deleted!!");
	$Mode = "RESET";
} 
$rep_file = find_custom_file("/towel/reports/rep_lots.php");
if ($rep_file) {
	require($rep_file);
}
  
  

 
page(_($help_context = "Towel  Lots"), false, false, "", ''); 

 

start_form();
if ($Mode == 'RESET'  )
{   
	if($selected_id!=-1){
	if(check_tolerance(@$_POST['totalg'])){
				display_error("Total gross weight is not in the lot size tollerance interval!");
 
			 
	}else{
	unset($_POST);
	refresh_pager('tbaleinv_tbl');
	refresh_pager('tbaleinvlot_tbl');
	$selected_id = -1;
	}
	
	
	
	}else{
	unset($_POST);
	refresh_pager('tbaleinv_tbl');
	refresh_pager('tbaleinvlot_tbl');
	$selected_id = -1;
	}
	
}  

br();
display_heading("Add new lot"); br();
 if($Mode = "Edit" && $selected_id !=-1){
	$rlot = get_lot($selected_id);
	$_POST['lotno']  = $rlot['lno'];
	$_POST['descr']  = $rlot['descr'];
	$_POST['pdate']  = date("m/d/Y",$rlot['pdate']);
	$rsteps = get_steps($selected_id);
	if($rsteps['prep_bool']=='yes'){
			$_POST['preparation'] = 1; 
	}
	if($rsteps['care_bool']=='yes'){
			$_POST['care'] = 1; 
	}
	if($rsteps['bleach_bool']=='yes'){
			$_POST['bleach'] = 1; 
	}
	if($rsteps['dye_bool']=='yes'){
			$_POST['dyeing'] = 1; 
	}
	if($rsteps['tumbler_bool']=='yes'){
			$_POST['tumbler'] = 1; 
	}
	if($rsteps['hydro_bool']=='yes'){
			$_POST['hydro'] = 1; 
	}
	if($rsteps['quality_bool']=='yes'){
			$_POST['quality'] = 1; 
	}
	hidden("selected_id",$selected_id);
 }

 
 
 
 $_POST['totali'] = get_total_itemst($selected_id);
 $_POST['totaln'] = get_total_nweightt($selected_id);
 $_POST['totalg'] = get_total_gweightt($selected_id);
 
tabbed_content_start('tabs', array(
		'bales' => array(_('Bales'), $selected_id) ,
		'general' => array(_('General'), $selected_id)
	));
 	
 
	switch (get_post('_tabs_sel')) {
		case 'general': 
			display_heading("General"); 
			show_lots_general($_POST['totalg']);
		break;
		default:
		case 'bales':   
		
			display_heading("Bales"); 
			show_lots_bales();
				$_POST['totali'] = get_total_itemst($selected_id);
				$_POST['totaln'] = get_total_nweightt($selected_id);
				$_POST['totalg'] = get_total_gweightt($selected_id);
		break; 
	};
  tabbed_content_end();
    
 br(2); 
start_table(TABLESTYLE2); 
	text_row_ex(_("Total Items").':', 'totali',10,30,null,null,null,null,true);
	text_row_ex(_("Total Gross Weight").':', 'totalg',10,30,null,null,null,null,true);
	text_row_ex(_("Total Net Weight").':', 'totaln',10,30,null,null,null,null,true);
end_table(1);
  br(3);
 submit_add_or_update_center($selected_id == -1, '', 'both');
 
  br(3);
   display_heading("Search lots");
   start_table(TABLESTYLE2);
	ref_cells(_("Search by # lot"), 'sNo', '',null, '', true);
	ref_cells(_("Search by description"), 'sDescr', '',null, '', true);
	date_cells("Search by processal date", 'sPdate',null,"01","01","1970"); 
	submit_cells('SearchOrders', _("Search"),'',_('Select documents'), 'default');   
 
  end_table(1);	 
  
  

  
  
 display_heading("Lots: ");
 $th = array ("#",_('Description'))  ;
 array_append($th, array(_("Processal Date")=>array('insert'=>true, 'fun'=>'format_datel'),array('insert'=>true, 'fun'=>'edit_link'),array('insert'=>true, 'fun'=>'delete_link'),array('insert'=>true, 'fun'=>'print_link') ));
$sql  = get_lot_sql(@$_POST['sNo'],@$_POST['sDescr'],strtotime(@$_POST['sPdate']));
$table = &new_db_pager('tlot_tbl', $sql , $th);  
$table->width = "80%";

display_db_pager($table);
 
	hidden('REP_ID', 'tinventory' );
submit_center('Update', _("Update"), true, '', null);
 
end_form();
end_page(false);
 
?>
