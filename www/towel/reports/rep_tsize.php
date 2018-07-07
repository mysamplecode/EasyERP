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
	if(!isset($_POST['remove_width'])){
		$headers[] = _("Width");
		$aligns[] = _("left");	
		$size_arr[] = 2;
		$show_cols[] = 'width';
	}
	if(!isset($_POST['remove_length'])){
		$headers[] = _("Length");
		$aligns[] = _("center");	
		$size_arr[] = 1;
		$show_cols[] = 'length';
	}
	if(!isset($_POST['remove_weight'])){
		$headers[] = _("Weight");
		$aligns[] = _("center");	
		$size_arr[] = 1;
		$show_cols[] = 'weight';
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
		$width = isset($_POST['sWidth']) ? $_POST['sWidth'] : null  ; 
		$length= isset($_POST['sLength']) ? $_POST['sLength'] : null  ; 
		$weight = isset($_POST['sWeight']) ? $_POST['sWeight'] : null  ; 
		$weight = isset($_POST['sName']) ? $_POST['sName'] : null  ;  
	}
  
		$sql = "SELECT name,width,length,weight,id from ".TB_PREF."tsize where 
        name like ".db_escape('%'.@$name.'%')." and  
        width like ".db_escape('%'.@$width.'%')." and  
        weight like ".db_escape('%'.@$length.'%')." and 
        length like ".db_escape('%'.@$weight.'%');
		 
  	 
    $rep = new FrontReport(_('Towel Sizes'), "Towel sizes", user_pagesize());
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
