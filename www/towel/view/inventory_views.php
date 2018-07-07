<?php
function show_inventory_general(){
global $selected_id,$Mode; 


start_table(TABLESTYLE2);
 text_row_ex(_("Inventory No:"), 'ino',50,100);
 show_select_row("Supplier: ","sup","tsupplier");
 date_row(_("Gate In:"), 'gate_in');
 text_row_ex(_("IGP No:"), 'igp',50,100);
 text_row_ex(_("Description of goods:"), 'goods',50,100);
 text_row_ex(_("Driver Name:"), 'driver',50,100);
 text_row_ex(_("Vehicle:"), 'vehicle',50,100);
 text_row_ex(_("Builty:"), 'builty',50,100);
 date_row(_("Gate Out:"), 'gate_out');
 text_row_ex(_("Received by:"), 'recv',50,100);
 text_row_ex(_("Received by designation:"), 'recvby',50,100);
end_table(1);
 submit_add_or_update_center($selected_id == -1, '', 'both');

}
function show_inventory_bales(){
global $selected_id;
global $jselected_id,$Mode,$bale_posts; 
if($selected_id == -1) {
	$_POST['_tabs_sel'] = 'general';
	display_error("You didnt configured the general inventory settings. Please do that in order to add bales");
	return false;
}  


start_table(TABLESTYLE2); 
 show_select_row("Towel Size: ","tsize","tsize"); 
 text_row_ex(_("Bale:"), 'bale',50,100);
 text_row_ex(_("Pally:"), 'pally',50,100);
 text_row_ex(_("Gross Weight:"), 'gweight',50,100);
 text_row_ex(_("Net Weight:"), 'nweight',50,100);
 text_row_ex(_("# pieces:"), 'npieces',50,100);
 text_row_ex(_("Shade:"), 'shade',50,100);
 text_row_ex(_("Tag Information:"), 'taginfo',50,100);
 text_row_ex(_("Remarks:"), 'remarks',50,100);
 custom_select_row("Packing Type","ptype",array("Bale"=>"Bale","Roll"=>"Roll"));
 
end_table(1); 
 submit_add_or_update_center( $jselected_id == 0  , '', 'both');
br(2);
 
 $th = array (_('Towel Size'),_('Bale'),_('Gross Weight'),_('Net Weight') ) ;
 
 array_append($th, array(array('insert'=>true, 'fun'=>'edit_linkj'),
		array('insert'=>true, 'fun'=>'delete_linkj')));
$sql  = get_search_sql_tbale($selected_id);
$table = &new_db_pager('tbale_tbl', $sql , $th);  
$table->width = "80%";

display_db_pager($table);
submit_center('Update', _("Update"), true, '', null);
 
 
}



?>