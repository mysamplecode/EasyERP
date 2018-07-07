<?php

$page_security = 'SA_HRMADMG';
$path_to_root = "../..";
 
include_once($path_to_root . "/includes/db_pager.inc");
include_once($path_to_root . "/includes/session.inc");
include_once($path_to_root . "/includes/ui.inc");
include_once($path_to_root . "/sale/includes/db/shippings_db.inc"); 
include_once($path_to_root . "/reporting/includes/reports_classes.inc"); 
include_once($path_to_root . "/gl/includes/gl_db.inc"); 


simple_page_mode(true);
function shippingtype_list(){
 
	$items = array();
	$items[''] = _('All Type');
	$items['1'] = 'By Air';
	$items['2'] = 'By Sea';
	
		echo "<td>Customer Type</td>\n";
	echo "<td>";
	echo  array_selector("shipping_type", null, $items, 
		array( 
			'select_submit'=> false,
			'async' => false ) ); // FIX?
	echo "</td>\n";

	
 

}
function search_shippingtype_list()
{
	$items = array();
	$items[''] = _('All Type');
	$items['1'] = 'By Air';
	$items['2'] = 'By Sea';

		echo "<td>Search Customer Type</td>\n";
	echo "<td>";
	echo  array_selector("bShipping_type", null, $items, 
		array( 
			'select_submit'=> false,
			'async' => false ) ); // FIX?
	echo "</td>\n";
}
 
 function edit_link($row){ 
		return button("Edit".$row['id'],1, _("Edit"), ICON_EDIT );
 }
 function delete_link($row){
		
		return button("Delete".$row['id'],1, _("Delete"),ICON_DELETE );
 } 
function can_process()
{
	
	global $Mode;
	
 		
	if (strlen($_POST['shipping_type']) == 0)
	{
		display_error(_("Please choose shipping type."));
		set_focus('shipping_type');
		return false;
	}

	
	if ( strlen($_POST['air_destination_airport'])>0 && !ctype_alnum(str_replace(" ","",$_POST['air_destination_airport'])))
	{
		display_error(_("The Air Destination Airport it's a alpha numeric data."));
		set_focus('air_destination_airport');
		return false;
	}
	if (strlen($_POST['air_destination_city'])>0 && !ctype_alnum(str_replace(" ","",$_POST['air_destination_city'])))
	{
		display_error(_("The Air Destination City it's a alpha numeric data."));
		set_focus('air_destination_city');
		return false;
	}
	if (strlen($_POST['air_destination_country'])>0 && !ctype_alnum(str_replace(" ","",$_POST['air_destination_country'])))
	{
		display_error(_("The Air Destination Country it's a alpha numeric data."));
		set_focus('air_destination_country');
		return false;
	}
	if (strlen($_POST['sea_destination_port'])>0 && !ctype_alnum(str_replace(" ","",$_POST['sea_destination_port'])))
	{
		display_error(_("The Sea Destination Port it's a alpha numeric data."));
		set_focus('sea_destination_port');
		return false;
	}
	if (strlen($_POST['sea_destination_city'])>0 && !ctype_alnum(str_replace(" ","",$_POST['sea_destination_city'])))
	{
		display_error(_("The Sea Destination City it's a alpha numeric data."));
		set_focus('sea_destination_city');
		return false;
	}
	if (strlen($_POST['sea_destination_country'])>0 && !ctype_alnum(str_replace(" ","",$_POST['sea_destination_country'])))
	{
		display_error(_("The Sea Destination Country it's a alpha numeric data."));
		set_focus('sea_destination_country');
		return false;
	}

	return true;
}
	
if ($Mode=='ADD_ITEM' && can_process())
{
	
 	add_shippings($_POST['shipping_type'],$_POST['air_destination_airport'],$_POST['air_destination_city'],$_POST['air_destination_country'],$_POST['sea_destination_port'],$_POST['sea_destination_city'],$_POST['sea_destination_country']);
	display_notification(_('New shipping has been added'));

 	$Mode = 'RESET';
}
if ($Mode=='UPDATE_ITEM' && can_process())
{

	update_shippings($selected_id, $_POST['shipping_type'],$_POST['air_destination_airport'],$_POST['air_destination_city'],$_POST['air_destination_country'],$_POST['sea_destination_port'],$_POST['sea_destination_city'],$_POST['sea_destination_country']);
	display_notification(_('Selected shipping has been updated'));
	$Mode = 'RESET';
}
if ($Mode == 'Delete')
{
/*	if (key_in_foreign_table($selected_id, 'department', 'unit'))
	{
		display_error(_("Cannot delete this Unit because it is used in some departments."));
	} else {*/
		delete_shippings($selected_id);
		display_notification(_('Selected Customer has been deleted'));
		$Mode = 'RESET';
	//}
}
if(isset($_POST['PrintOrders'])){ 
$rep_file = find_custom_file("/sale/reports/rep_shippings.php");
if ($rep_file) {
	require($rep_file);
}
 
die();

} 
if ($Mode == 'RESET')
{
	refresh_pager('shippings_tbls');
	$selected_id = -1; 
	unset($_POST); 
}	

page(_($help_context = "Add and Manage Shipping"), false, false, "", ''); 

 

start_form();
display_heading ("Add Shipping"); br();
start_table(TABLESTYLE2);

if ($selected_id != -1)
{

 	if ($Mode == 'Edit') {
		$myrow = get_shippings($selected_id);

		$_POST['shipping_type']  = $myrow["shipping_type"]; 
		$_POST['air_destination_airport']  = $myrow["air_destination_airport"]; 
		$_POST['air_destination_city']  = $myrow["air_destination_city"]; 
		$_POST['air_destination_country']  = $myrow["air_destination_country"]; 
		$_POST['sea_destination_port']  = $myrow["sea_destination_port"]; 
		$_POST['sea_destination_city']  = $myrow["sea_destination_city"]; 
		$_POST['sea_destination_country']  = $myrow["sea_destination_country"]; 
		
		
		
	}
	hidden('selected_id', $selected_id);
} 

//text_row_ex(_("Customer Type").':', 'customer_type',30,100); 
shippingtype_list();
text_row_ex(_("Air Destination Airport").':', 'air_destination_airport',50,100); 
text_row_ex(_("Air Destination City").':', 'air_destination_city',50,100); 
text_row_ex(_("Air Destination Country").':', 'air_destination_country',50,10); 
text_row_ex(_("Sea Destination Port").':', 'sea_destination_port',50,100); 
text_row_ex(_("Sea Destination City").':', 'sea_destination_city',50,100); 
text_row_ex(_("Sea Destination Country").':', 'sea_destination_country',50,100); 

end_table(1);


submit_add_or_update_center($selected_id == -1, '', 'both');


br(2);
 display_heading ("Print");  
	br(); 
start_table(TABLESTYLE2); 
row_start();
check_cells("Remove Air Destination Airport", "remove_air_destination_airport", "all"); 
row_end();
row_start();
check_cells("Remove Air Destination City", "remove_air_destination_city", "all"); 
row_end();
check_cells("Remove Air Destination Country", "remove_air_destination_country", "all"); 
row_end();
row_start();
check_cells("Remove Sea Destination Port", "remove_sea_destination_port", "all"); 
row_end();
row_start();
check_cells("Remove Sea Destination City", "remove_sea_destination_city", "all"); 
row_end();
check_cells("Remove Sea Destination Country", "remove_sea_destination_country", "all"); 
row_end();


row_start();
check_cells("Print all records", "allRecords", "all");
row_end();
row_start();
yesno_list_cells("Export type", "printType", $selected_id, "XLS","PDF");
row_end();

 hidden('REP_ID', 'bank' );
end_table(1); 
start_table(TABLESTYLE2); 
 submit_cells('PrintOrders', _("Print"),'',_('Print documents'), 'default');
end_table(1); 
	 br();
	br(); 

 display_heading ("Filter Shipping"); br();
start_table(TABLESTYLE2);
row_start();

search_shippingtype_list();
row_end();
row_start();
ref_cells(_("Search by Air Destination Airport"), 'bAir_destination_airport', '',null, '', true);
row_end();
row_start();
ref_cells(_("Search by Air Destination City"), 'bAir_destination_city', '',null, '', true);
row_end();
row_start();
ref_cells(_("Search by Air Destination Country"), 'bAir_destination_country', '',null, '', true);
row_end();
row_start();
ref_cells(_("Search by Sea Destination Port"), 'bSea_destination_port', '',null, '', true);
row_end();
row_start();
ref_cells(_("Search by Sea Destination City"), 'bSea_destination_city', '',null, '', true);
row_end();
row_start();
ref_cells(_("Search by Sea Destination Country"), 'bSea_destination_country', '',null, '', true);
row_end();



 
 
 
end_table(1);	 
	br(2); 

start_table(TABLESTYLE2);
submit_cells('SearchOrders', _("Search"),'',_('Select documents'), 'default');
end_table(1);	
 $th = array (_('Shipping Type') ,_('Air Destination Airport'), _('Air Destination City') ,_('Air Destination Country'),_('Sea Destination Port') ,_('Sea Destination City'), _('Sea Destination Country')  );
 
 array_append($th, array(
		array('insert'=>true, 'fun'=>'edit_link'),
		array('insert'=>true, 'fun'=>'delete_link')));
 $sql  = get_search_sql_shippings(@$_POST['bShipping_type'],@$_POST['bAir_destination_airport'],@$_POST['bAir_destination_city'],@$_POST['bAir_destination_country'],@$_POST['bSea_destination_port'],@$_POST['bSea_destination_city'],@$_POST['bSea_destination_country']); 
$table = &new_db_pager('shippings_tbls', $sql , $th );  
$table->width = "100%";

display_db_pager($table);

submit_center('Update', _("Update"), true, '', null);
 



 
 end_form();
end_page(false);
?>