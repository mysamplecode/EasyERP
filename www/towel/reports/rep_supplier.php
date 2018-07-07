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

// ----------------------------------------------------------------
// $ Revision:	2.0 $
// Creator:	Joe Hunt
// date_:	2005-05-19
// Title:	Customer Balances
// ----------------------------------------------------------------
$path_to_root = "../..";


//----------------------------------------------------------------------------------------------------

// trial_inquiry_controls();
print_units();

 
function print_units()
{
    	global $path_to_root, $systypes_array;
 
		$destination = $_POST["printType"];
	if ($destination)
		include_once($path_to_root . "/reporting/includes/excel_report.inc");
	else
		include_once($path_to_root . "/reporting/includes/pdf_report.inc");

 $cols = array(0,30);

	$headers = array(_('#')); 
	$aligns = array('left');
	$params =   array( 	0 => '',
    			);
	$new_cols = array();
	$show_cols = array();
  $size_arr = array();
	if(!isset($_POST['remove_name'])){
		$headers[] = _("Name");
		$aligns[] = _("left");	
		$size_arr[] = 1;
		$show_cols[] = 'name';
	}
	if(!isset($_POST['remove_address'])){
		$headers[] = _("Address");
		$aligns[] = _("left");	
		$size_arr[] = 2;
		$show_cols[] = 'address';
	}
	if(!isset($_POST['remove_ntn'])){
		$headers[] = _("NTN");
		$aligns[] = _("center");	
		$size_arr[] = 1;
		$show_cols[] = 'ntn';
	}
	if(!isset($_POST['remove_contact_pname'])){
		$headers[] = _("Contact Name");
		$aligns[] = _("center");	
		$size_arr[] = 1;
		$show_cols[] = 'contact_pname';
	}
	if(!isset($_POST['remove_contact_pdesig'])){
		$headers[] = _("Contact Designation");
		$aligns[] = _("center");	
		$size_arr[] = 1;
		$show_cols[] = 'contact_pdesig';
	}
	if(!isset($_POST['remove_contact_pno'])){
		$headers[] = _("Contact NO.");
		$aligns[] = _("center");	
		$size_arr[] = 1;
		$show_cols[] = 'contact_pno';
	}
	if(!isset($_POST['remove_stype'])){
		$headers[] = _("Supplier Type");
		$aligns[] = _("center");	
		$size_arr[] = 1;
		$show_cols[] = 'stype';
	}
   
   $units_sizes = 530/array_sum($size_arr);
  foreach($size_arr as $us){
      $new_cols[] = $us*$units_sizes;
  }
  
	foreach($new_cols as $value){
		$cols[] = $cols[count($cols)-1] + $value;
	} 
 	$conds = '';
	if(!isset($_POST['allRecords'])){
		$address = isset($_POST['sAddress']) ? $_POST['sAddress'] : null  ;
		$name = isset($_POST['sName']) ? $_POST['sName'] : null  ; 
		$ntn = isset($_POST['sNtn']) ? $_POST['sNtn'] : null  ; 
		$contact_pname = isset($_POST['sContact_pname']) ? $_POST['sContact_pname'] : null  ; 
		$contact_pdesig = isset($_POST['sContact_pdesig']) ? $_POST['sContact_pdesig'] : null  ; 
		$contact_pno = isset($_POST['sContact_pno']) ? $_POST['sContact_pno'] : null  ; 
		$stype = isset($_POST['sStype']) ? $_POST['sStype'] : null  ; 
	
	}
  
	$sql = "SELECT name,address,ntn,contact_pname,contact_pdesig,contact_pno,stype,id from ".TB_PREF."tsupplier where 
        name like ".db_escape('%'.@$name.'%')." and  
        address like ".db_escape('%'.@$address.'%')." and  
        ntn like ".db_escape('%'.@$ntn.'%')." and 
        contact_pname like ".db_escape('%'.@$contact_pname.'%')." and 
        contact_pdesig like ".db_escape('%'.@$contact_pdesig.'%')." and  
        contact_pno like ".db_escape('%'.@$contact_pno.'%')." and 
        stype like ".db_escape('%'.@$stype.'%')." " ;
  	 
    $rep = new FrontReport(_('Towel Suppliers'), "Towel Supplierss", user_pagesize());
    $rep->Font();
    $rep->Info($params, $cols, $headers, $aligns);
    $rep->NewPage();

	$grandtotal = array(0,0,0,0);

	$result = db_query($sql, "The suppliers could not be retrieved");
	$num_lines = 0;

	while ($myrow = db_fetch($result))
	{
		 
	 
	  	$num_lines++; 
		$rep->TextCol(0, 1, $num_lines);   
		$col_cnt = 1;
		foreach($show_cols as $sc){
			$rep->TextCol($col_cnt, $col_cnt+1, $myrow["$sc"]);   
			$col_cnt ++;
		}
				$rep->NewLine(1, 2);  
 
	 
	}   
	$rep->Line($rep->row  - 4);
	$rep->NewLine();
    $rep->End();
	echo $rep->filname;
}

?>
