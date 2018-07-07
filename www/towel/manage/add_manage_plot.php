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
include_once($path_to_root . "/towel/includes/db/plot_db.inc"); 
include_once($path_to_root . "/reporting/includes/reports_classes.inc"); 
include_once($path_to_root . "/gl/includes/gl_db.inc"); 
$js = get_js_date_picker();
		add_js_source($js);
 $okedit = false;
include_once($path_to_root . "/towel/view/custom_inputs.php");  

$js = "";
 $general_posts =  array( );
 $bale_posts =   array(  );
 $steps_posts =   array(  );
 simple_page_mode(true); 
 
function can_process_lot()
{		
 global $selected_id;
	 
	 $textnumbers = array( );
	 $numeric = get_fields_steps(isset($_POST['lotno']) ? $_POST['lotno']: $selected_id); ;
	 $text= array( );
	 $total = array_merge($numeric,$text,$textnumbers );
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
 
 function print_link($row){
		
			return button("Print".$row['id'],1, _("Print"),ICON_PRINT );
 }
function format_datel($row){

	return  date("m/d/Y",$row['pdate']);

} 
 function edit_link($row){ 
		return button("Edit".$row['id'],1, _("Edit"), ICON_EDIT );
 }
 function delete_link($row){
		
		return button("Delete".$row['id'],1, _("Delete"),ICON_DELETE );
 }
 function add_link($row){ 
		return   submit("tbale_".$row['id'], "ADD", false, "ADD"  );
 }
 function remove_link($row){ 
		return   submit("tbremove_".$row['id'], "REMOVE", false, "REMOVE"  );
 }
 
function show_lot_lov(){
global $selected_id ; 
	$result = get_issued();
	$items = array(""=>"None");
	
while ($row = db_fetch($result))
{
 	$items[$row['id']] = $row['lno'];
}
	echo "<tr><td>Lots</td><td>";
	echo  array_selector("lotno", null, $items, 
		array( 
			'select_submit'=>true,
			'async' => false ) ); // FIX?
	echo "</td></tr>\n";
 if(!empty($_POST['lotno'])){ 
	show_steps_lot($_POST['lotno']);
	br(2);
 } 
}
function show_steps_lot($id){
	$rsteps = get_steps($id); 
	if($rsteps['prep_bool']=='yes'){
			 text_row_ex(_("Preparation section").':', 'prep',10,30 );
	
	}
	if($rsteps['care_bool']=='yes'){
			 
			 text_row_ex(_("Care section").':', 'care',10,30 );
	}
	if($rsteps['bleach_bool']=='yes'){
	
			 text_row_ex(_("Bleach section").':', 'bleach',10,30 ); 
	}
	if($rsteps['dye_bool']=='yes'){
			
			 text_row_ex(_("Dyeing section").':', 'dye',10,30 );
	}
	if($rsteps['tumbler_bool']=='yes'){
			
			 text_row_ex(_("Tumbler section").':', 'tumbl',10,30 );
	}
	if($rsteps['hydro_bool']=='yes'){
			
			 text_row_ex(_("Hydro section").':', 'hydro',10,30 ); 
	}
	if($rsteps['quality_bool']=='yes'){
			
			 text_row_ex(_("Quality section").':', 'quality',10,30 ); 
	}
	
} 
 if($Mode == "ADD_ITEM" && can_process_lot()){
	add_lot($_POST['lotno']);
	add_steps(@$_POST['lotno'],@$_POST['care'],@$_POST['dye'],@$_POST['bleach'],@$_POST['prep'],@$_POST['hydro'],@$_POST['quality'],@$_POST['tumbl']);
	$Mode = "RESET";
	refresh_pager("tpslot_tbl");
 } 
 if($Mode == "UPDATE_ITEM" && can_process_lot()){
	 
	add_steps($selected_id,@$_POST['care'],@$_POST['dye'],@$_POST['bleach'],@$_POST['prep'],@$_POST['hydro'],@$_POST['quality'],@$_POST['tumbl']);
	display_notification("Lot updated!");
	$Mode = "RESET";
	refresh_pager("tpslot_tbl");
 }
 if(  $Mode == 'Delete' ){
	remove_lot($selected_id);
	remove_steps($selected_id);
	display_notification("Lot deleted!");
	$Mode = "RESET";
	refresh_pager("tpslot_tbl");
 }
 

$rep_file = find_custom_file("/towel/reports/rep_lots.php");
if ($rep_file) {
	require($rep_file);
}
  
 if($Mode == 'RESET'){
	unset($_POST);
	$selected_id = -1;
 }

 
page(_($help_context = "Towel  Lots"), false, false, "", ''); 

 

start_form();
 
 if($Mode ==  "Edit" && $selected_id !=-1){
		start_table(TABLESTYLE2);
		
		$ssteps = get_steps($selected_id);
		$fields= get_fields_steps($selected_id); ;
		foreach($fields as $field){
			$_POST[$field] = $ssteps[$field];
		}
		
		show_steps_lot($selected_id);
		end_table(1);
		hidden("selected_id",$selected_id);
 }else{
 
 
start_table(TABLESTYLE2); 
	show_lot_lov();
end_table(1);
}
	submit_add_or_update_center($selected_id == -1  , '', 'both'); 
br();
display_heading("Lots"); br();
  
display_heading("Processed Lots"); br();


$th = array ("#",_('Description'))  ;
 array_append($th, array(_("Processal Date")=>array('insert'=>true, 'fun'=>'format_datel'),array('insert'=>true, 'fun'=>'print_link'),array('insert'=>true, 'fun'=>'edit_link') ,array('insert'=>true, 'fun'=>'delete_link') ));
$sql  = get_plot_sql( );
$table = &new_db_pager('tpslot_tbl', $sql , $th);  
$table->width = "80%";

display_db_pager($table);
submit_center('Update', _("Update"), true, '', null);
 
 

     
	hidden('REP_ID', 'tinventory' ); 
 
end_form();
end_page(false);
 
?>
