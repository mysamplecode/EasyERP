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
	if(!isset($_POST['remove_lsize'])){
		$headers[] = _("Lot size");
		$aligns[] = _("center");
		$size_arr[] = 1;
		$show_cols[] = 'lsize';
	}
	if(!isset($_POST['remove_tol'])){
		$headers[] = _("Tolerance");
		$aligns[] = _("center");	
		$size_arr[] = 1;
		$show_cols[] = 'tol';
	}
	if(!isset($_POST['remove_lpre'])){
		$headers[] = _("Lot preparation");
		$aligns[] = _("center");	
		$size_arr[] = 1;
		$show_cols[] = 'lpre';
	} 
	if(!isset($_POST['remove_care'])){
		$headers[] = _("Care section");
		$aligns[] = _("center");	
		$size_arr[] = 1;
		$show_cols[] = 'care';
	}
	if(!isset($_POST['remove_bleach'])){
		$headers[] = _("Bleach");
		$aligns[] = _("center");	
		$size_arr[] = 1;
		$show_cols[] = 'bleach';
	}
	if(!isset($_POST['remove_dye'])){
		$headers[] = _("Dye");
		$aligns[] = _("center");	
		$size_arr[] = 1;
		$show_cols[] = 'dye';
	} 	
	if(!isset($_POST['remove_hydro'])){
		$headers[] = _("Hydro");
		$aligns[] = _("center");
		$size_arr[] = 1;
		$show_cols[] = 'hydro';
	}
	if(!isset($_POST['remove_tum'])){
		$headers[] = _("Tumbler");
		$aligns[] = _("center");	
		$size_arr[] = 1;
		$show_cols[] = 'tum';
	}
	if(!isset($_POST['remove_qua'])){
		$headers[] = _("Quality");
		$aligns[] = _("center");	
		$size_arr[] = 1;
		$show_cols[] = 'qua';
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
		$lsize = isset($_POST['sLsize']) ? $_POST['sLsize'] : null  ; 
		$lpre= isset($_POST['sTol']) ? $_POST['sTol'] : null  ; 
		$tol = isset($_POST['sLpre']) ? $_POST['sLpre'] : null  ; 
		$care = isset($_POST['sCare']) ? $_POST['sCare'] : null  ; 
		$bleach= isset($_POST['sBleach']) ? $_POST['sBleach'] : null  ; 
		$dye = isset($_POST['sDye']) ? $_POST['sDye'] : null  ; 
		$hydro = isset($_POST['sHydro']) ? $_POST['sHydro'] : null  ; 
		$tum= isset($_POST['sTum']) ? $_POST['sTum'] : null  ; 
		$qua = isset($_POST['sQua']) ? $_POST['sQua'] : null  ;  
	}
  
		$sql = "SELECT lsize,tol,lpre,care,bleach,dye,hydro,tum,qua,id from ".TB_PREF."teparam where 
        lsize like ".db_escape('%'.@$lsize.'%')." and  
        tol like ".db_escape('%'.@$tol.'%')." and 
        lpre like ".db_escape('%'.@$lpre.'%')." and  
        care like ".db_escape('%'.@$care.'%')." and 
        bleach like ".db_escape('%'.@$bleach.'%')." and  
        dye like ".db_escape('%'.@$dye.'%')." and 
        hydro like ".db_escape('%'.@$hydro.'%')." and  
        tum like ".db_escape('%'.@$tum.'%')." and 
        qua like ".db_escape('%'.@$qua.'%');
		 
  	 
    $rep = new FrontReport(_('Efficiency parameters'), "Efficiency parameters", user_pagesize());
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
}

?>
