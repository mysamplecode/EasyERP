<?php
$page_security = 'SA_HRMADMG';
$path_to_root = "../..";
 
include_once($path_to_root . "/includes/db_pager.inc");
include_once($path_to_root . "/includes/session.inc");
include_once($path_to_root . "/includes/ui.inc");
include_once($path_to_root . "/hrm/includes/db/term_db.php"); 
include_once($path_to_root . "/reporting/includes/reports_classes.inc"); 
include_once($path_to_root . "/gl/includes/gl_db.inc"); 
 add_js_file("jquery.js");
 add_js_file("jqueryui.js");
 add_js_file("autoselect.js");
$js = get_js_date_picker();

		add_js_source($js); 
simple_page_mode(true);

function format_datel($row){

	return  date("m/d/Y",$row['rdate']);

}  
function edit_link($row){  
		return button("Edit".$row['rid'],1, _("Edit"), ICON_EDIT );
 }
 function delete_link($row){
		
		return button("Delete".$row['rid'],1, _("Delete"),ICON_DELETE );
 }
function show_employees(){
 
 
   
 
	$result = get_employee();
	$items = array(""=>"");
while ($row = db_fetch($result))
{
 	$items[$row['id']] = $row['ename'];
}
	echo "<tr><td></td><td  >";
	echo  array_selector("emid", null, $items, 
		array( 
			'select_submit'=>true,
			'async' => false ),true ); // FIX?
	echo "</td></tr>
	<tr>
	<td>".show_em_details(@$_POST['emid'])."</td>
	</tr>
	
	\n"; 
	
}
function show_em_details($id){
global $selected_id;
	if($id>0){
	$dets = get_dets($id);
	
	start_table();
	echo "<tr><td>Unit: </td><td  >".$dets['uname']."</td></tr>";
	echo "<tr><td>Department: </td><td  >".$dets['depname']."</td></tr>";
	echo "<tr><td>Designation: </td><td  >".$dets['dname']."</td></tr>";
	echo "<tr><td>Employee Status: </td><td  >".$dets['esname']."</td></tr>";
	echo "<tr><td>Joining Dare: </td><td  >".date("d/M/Y",$dets['jdate'])."</td></tr>";
	br(3);
	
		textarea_row("Termination Reason", 'rr','',35,5); 
		
		check_row("Notice period", "nperiod", "all",false); 
		 echo "<tr style='display:none' class='ndays_wrapper'><td>Period:  ";
		 text_cells_ex("", 'rday',30,100);
		 echo "</td></tr>";
		 
		end_table();
		br(3);
		submit_add_or_update_center ($selected_id == -1, '', 'both');
		 
	 }
	
}
function can_process(){
	
 global $selected_id;
	 
	 $textnumbers = array( "rr");
	 $numeric = array();
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
if ($Mode=='ADD_ITEM' && can_process())
{

 	add_resig(@$_POST['emid'],@$_POST['rr'] ,@$_POST['nperiod'],@$_POST['rday']);
	display_notification(_('Termination added!!'));
	$Mode = 'RESET';
}

if ($Mode=='UPDATE_ITEM' && can_process() )
{

	update_resig($selected_id, @$_POST['rr'] ,@$_POST['rday']);
	display_notification(_('Termination Updated'));
	$Mode = 'RESET';
}
 
if ($Mode == 'Delete')
{
 
		delete_resig($selected_id);
		display_notification(_('Termination Deleted'));
		$Mode = 'RESET';
	 
}
 
  
if ($Mode == 'RESET')
{
	 refresh_pager('term_tbl');
	$selected_id = -1; 
	unset($_POST); 
}
if(isset($_POST['PrintOrders'])){ 
$rep_file = find_custom_file("/hrm/reports/rep_term.php");
if ($rep_file) {
	require($rep_file);
}
 
die();

}
page(_($help_context = "Allowance"), false, false, "", ''); 

start_form();

 if($Mode ==  "Edit" && $selected_id !=-1){
		start_table(TABLESTYLE2);
		unset($_POST);
		$row = get_resig($selected_id);
		textarea_row("Termination Reason", 'rr',$row['rr'],35,5 ); 
		if($row['nperiod']=='1')  
			text_row_ex("Notice period", 'rday',30,100,null,$row['rdays']); 
		hidden("selected_id",$selected_id);
		
		 end_table();
		 br(2);
		submit_add_or_update_center ($selected_id == -1, '', 'both');
 }else{
 
	display_heading('Employee');
	start_table();
	show_employees();
	end_table();
 }
 
if(isset($_POST['SearchOrders'])){
		hidden("didSearch",$selected_id);
}
 br(1);
 
 display_heading ("Filter employees"); br();
start_table(TABLESTYLE2);
row_start();
ref_cells(_("Search by employee name"), 'SName', '',null, '', true);
row_end();
row_start();
ref_cells(_("Search by unit name"), 'SUn', '',null, '', true);
row_end();
row_start();
ref_cells(_("Search by department name"), 'SDep', '',null, '', true);
row_end();
row_start();
ref_cells(_("Search by designation name"), 'SDesig', '',null, '', true);
row_end();
row_start();
ref_cells(_("Search by reason"), 'SRes', '',null, '', true);
row_end();
row_start();	
date_row("Resignaion Date", 'SDate');
row_end();
	end_table(1); 
br(1); 
start_table(TABLESTYLE2);
  row_start();
submit_cells('SearchOrders', _("Search"),'',_('Select documents')   );
row_end();
end_table(1);
 br(2);
start_table(TABLESTYLE2); 
row_start();

check_cells("Remove name", "remove_ename", "all");
row_end();
row_start();
check_cells("Remove designation", "remove_dname", "all");
row_end();
row_start();
check_cells("Remove department", "remove_depname", "all"); 
row_end();
row_start();
check_cells("Remove unit", "remove_uname", "all"); 
row_end();
row_start();
check_cells("Remove reason", "remove_r", "all");
row_end();
row_start(); 
check_cells("Remove date", "remove_rdate", "all");  
 
row_end();
row_start();
check_cells("Print all records", "allRecords", "all"); 
row_end();
 	hidden('REP_ID', 'eterm' );
end_table(1);
start_table(TABLESTYLE2);
submit_cells('PrintOrders', _("Print"),'',_('Print documents'), 'default');
 end_table(1);
 
br(3);
display_heading("Terminations"); br();
 

$th = array ("Employee",_('Unit'),_('Department'),_('Designation'),"Reason")  ;
 array_append($th, array( array('insert'=>true, 'fun'=>'edit_link') ,array('insert'=>true, 'fun'=>'delete_link') ));
$sql  = get_eterm_sql(@$_POST['SName'],@$_POST['SDep'],@$_POST['SUn'],@$_POST['SDesig'],@$_POST['SRes'] );
$table = &new_db_pager('term_tbl', $sql , $th);  
$table->width = "80%";

display_db_pager($table);
submit_center('Update', _("Update"), true, '', null);
 
 

     
	hidden('REP_ID', 'eterm' ); 
 


end_form();
end_page(false);
?>