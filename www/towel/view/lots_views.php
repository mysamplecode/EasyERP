<?php
function show_lots_general($tol){
 if(check_tolerance($tol)){
				display_error("Total gross weight is not in the lot size tollerance interval!");
 
				return false;
 }
start_table(TABLESTYLE2);  
 text_row_ex(_("Lot #:"), 'lotno',50,100);
 text_row_ex(_("Description:"), 'descr',50,100);
 date_row(_("Process date:"), 'pdate');  
 check_row("Lot preparation", "preparation", @$_POST['preparation']);
 check_row("Care section", "care",  @$_POST['care']);
 check_row("Bleach Section", "bleach",  @$_POST['bleach']);
 check_row("Dyeing Section", "dyeing",  @$_POST['dyeing']);
 check_row("Hydro Section", "hydro",  @$_POST['hydro']);
 check_row("Tumbler section", "tumbler",  @$_POST['tumbler']);
 check_row("Quality section", "quality",  @$_POST['quality']);
end_table(1); 



}
function show_lots_bales(){
	global $selected_id;
start_table(TABLESTYLE2);
show_inventory_row("Inventories","invent",true);
end_table(1); 
 $th = array ("Towel size",_('Bale'),_('Gross Weight'),_('Net Weight'),_('# pieces'),  _(' Suplier'),_('# inventory') )  ;
 
 array_append($th, array(_("Gate in")=>array('insert'=>true, 'fun'=>'format_dateg'),array('insert'=>true, 'fun'=>'add_link') ));
$sql  = get_bales_sql(@$_POST['invent']);
$table = &new_db_pager('tbaleinv_tbl', $sql , $th);  
$table->width = "80%";

display_db_pager($table);
submit_center('Update', _("Update"), true, '', null);
 
 br(2);
 display_heading("Bales from lot");
 $th = array ("Towel size",_('Bale'),_('Gross Weight'),_('Net Weight'),_('# pieces'),  _(' Suplier'),_('# inventory') )  ;
 
 array_append($th, array(_("Gate in")=>array('insert'=>true, 'fun'=>'format_dateg'),array('insert'=>true, 'fun'=>'remove_link') ));
$sql  = get_baleslot_sql($selected_id);
$table = &new_db_pager('tbaleinvlot_tbl', $sql , $th);  
$table->width = "80%";

display_db_pager($table);
submit_center('Update', _("Update"), true, '', null);
 
 
}
function format_dateg($row){

	return  date("m/d/Y",$row['gate_in']);

}
function show_inventory_row($label,$name,$ajax = false){
	$result = get_all_inventories();
	$items = array(""=>"None");
while ($row = db_fetch($result))
{
 	$items[$row['id']] = $row['id'];
}
	echo "<tr><td>$label</td><td>";
	echo  array_selector($name, null, $items, 
		array( 
			'select_submit'=>$ajax,
			'async' => false ) ); // FIX?
	echo "</td></tr>\n";
 
	show_bales_invent(); 
}

 function add_link($row){ 
		return   submit("tbale_".$row['id'], "ADD", false, "ADD"  );
 }
 function remove_link($row){ 
		return   submit("tbremove_".$row['id'], "REMOVE", false, "REMOVE"  );
 }
function show_bales_invent($id = null ){
 
 

	foreach($_POST as $pk=>$pv){ 
		 
		if(strpos($pk, "bale_")>0)
		{
			$balarr = explode("_",$pk);
			 db_query("update ".TB_PREF."tbales  set lotid = '-1' where id = '".$balarr[1]."' and lotid='0'");
			 refresh_pager('tbaleinv_tbl');
			 refresh_pager('tbaleinvlot_tbl');
		}
		if(strpos($pk, "bremove")>0)
		{
			$balarr = explode("_",$pk);
			 db_query("update ".TB_PREF."tbales  set lotid = '0' where id = '".$balarr[1]."'");
			 refresh_pager('tbaleinv_tbl');
			 refresh_pager('tbaleinvlot_tbl');
		}
	
	}

}
?>