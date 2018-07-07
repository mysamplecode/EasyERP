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
include_once($path_to_root . "/towel/includes/db/ilot_db.inc"); 
include_once($path_to_root . "/reporting/includes/reports_classes.inc"); 
include_once($path_to_root . "/gl/includes/gl_db.inc"); 
$js = get_js_date_picker();
		add_js_source($js);
 
include_once($path_to_root . "/towel/view/custom_inputs.php");  

$js = "";
 $general_posts =  array( );
 $bale_posts =   array(  );
 $steps_posts =   array(  );
 simple_page_mode(true); 
 
 
 function print_link($row){
		
			return button("Print".$row['id'],1, _("Print"),ICON_PRINT );
 }
function format_datel($row){

	return  date("m/d/Y",$row['pdate']);

} 
  
 function add_link($row){ 
		return   submit("tbale_".$row['id'], "ADD", false, "ADD"  );
 }
 function remove_link($row){ 
		return   submit("tbremove_".$row['id'], "REMOVE", false, "REMOVE"  );
 }
 
 
 
 
$rep_file = find_custom_file("/towel/reports/rep_lots.php");
if ($rep_file) {
	require($rep_file);
}
  
  

 
page(_($help_context = "Towel  Lots"), false, false, "", ''); 

 

start_form();
 	foreach($_POST as $pk=>$pv){ 
		 
		if(strpos($pk, "bale_")>0)
		{
			$balarr = explode("_",$pk);
			 db_query("update ".TB_PREF."tlots  set issue = '1',issue_date  = '".strtotime(date("m/d/Y"))."' where id = '".$balarr[1]."'  ");
			 refresh_pager('tlotn_tbl');
			 refresh_pager('tislot_tbl');
		}
		if(strpos($pk, "bremove")>0)
		{
			$balarr = explode("_",$pk);
			 db_query("update ".TB_PREF."tlots  set issue = '0',issue_date  = '' where id = '".$balarr[1]."'  ");
			 refresh_pager('tlotn_tbl');
			 refresh_pager('tislot_tbl');
		}
	
	}

br();
display_heading("Lots"); br();
 

 
$th = array ("#",_('Description'))  ;
 array_append($th, array(_("Processal Date")=>array('insert'=>true, 'fun'=>'format_datel'),array('insert'=>true, 'fun'=>'add_link') ));
 
$sql  = get_nlot_sql( );
$table = &new_db_pager('tlotn_tbl', $sql , $th);  
$table->width = "80%";

display_db_pager($table);
submit_center('Update', _("Update"), true, '', null);
 
  
display_heading("Issued Lots"); br();


$th = array ("#",_('Description'))  ;
 array_append($th, array(_("Processal Date")=>array('insert'=>true, 'fun'=>'format_datel'),array('insert'=>true, 'fun'=>'print_link'),array('insert'=>true, 'fun'=>'remove_link') ));
$sql  = get_ilot_sql( );
$table = &new_db_pager('tislot_tbl', $sql , $th);  
$table->width = "80%";

display_db_pager($table);
submit_center('Update', _("Update"), true, '', null);
 
 

     
	hidden('REP_ID', 'tinventory' ); 
 
end_form();
end_page(false);
 
?>
