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
print_titles();

 
function print_titles()
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
  		
	if(!isset($_POST['remove_type'])){
		$headers[] = _("Type");
		$aligns[] = _("left");	
		$size_arr[] = 1;
		$show_cols[] = 'type';
	}
	if(!isset($_POST['remove_description'])){
		$headers[] = _("Description");
		$aligns[] = _("center");	
		$size_arr[] = 1;
		$show_cols[] = 'description';
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
	$type = isset($_POST['bType']) ? $_POST['bType'] : null  ;
	$description = isset($_POST['bDescription']) ? $_POST['bDescription'] : null  ;
	
			$conds =  "where
		type like ".db_escape('%'.$type.'%'). " and
		description like ".db_escape('%'.$description.'%'). " 
		";
		if($type!=null)
			$params[] = array('text' => _('Type'), 'from' => $type, 'to' => '');
		if($description!=null)
			$params[] = array('text' => _('Description'), 'from' =>$description, 'to' => '');
	 
		
	 
	}
    $rep = new FrontReport(_('sales'), "Sales", user_pagesize());
    $rep->Font();
    $rep->Info($params, $cols, $headers, $aligns);
    $rep->NewPage();
 


	$sql = "SELECT type,description FROM ".TB_PREF."sale_order_type $conds ";
	
	$sql .= " ORDER BY type"; 
	$result = db_query($sql, "The sales order type could not be retrieved");
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
