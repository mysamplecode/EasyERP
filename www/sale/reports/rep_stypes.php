<?php
 
$page_security = 'SA_CUSTPAYMREP';

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
	if(!isset($_POST['remove_alow'])){
		$headers[] = _("Allowances Apply");
		$aligns[] = _("center");	
		$size_arr[] = 1;
		$show_cols[] = 'alow';
	}
	if(!isset($_POST['remove_ded'])){
		$headers[] = _("Deduction Apply?");
		$aligns[] = _("center");	
		$size_arr[] = 1;
		$show_cols[] = 'ded';
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
		$name = isset($_POST['sName']) ? $_POST['sName'] : null  ;
	$alow = isset($_POST['sAlow']) ? $_POST['sAlow'] : null  ;
	$ded = isset($_POST['sDed']) ? $_POST['sDed'] : null  ;
	
	if($alow) $conds .=" and alow = 'yes' ";
	if($ded) $conds .=" and ded = 'yes' ";
		$sql = "SELECT name,alow,ded,id from ".TB_PREF."salary_type where name like ".db_escape('%'.$name.'%')
			. "  $conds ";
	}
  	 
    $rep = new FrontReport(_('Salary Types'), "Salary Types", user_pagesize());
    $rep->Font();
    $rep->Info($params, $cols, $headers, $aligns);
    $rep->NewPage();

	$grandtotal = array(0,0,0,0);

	$result = db_query($sql, "The customers could not be retrieved");
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
