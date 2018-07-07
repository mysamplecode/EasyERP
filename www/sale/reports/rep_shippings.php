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
  		
	if(!isset($_POST['remove_shipping_type'])){
		$headers[] = _("Shipping Type");
		$aligns[] = _("left");	
		$size_arr[] = 1;
		$show_cols[] = 'shipping_type';
	}
	if(!isset($_POST['remove_air_destination_airport'])){
		$headers[] = _("Air Destination Airport");
		$aligns[] = _("center");	
		$size_arr[] = 1;
		$show_cols[] = 'air_destination_airport';
	}
	if(!isset($_POST['remove_air_destination_city'])){
		$headers[] = _("Air Destination City");
		$aligns[] = _("center");	
		$size_arr[] = 1;
		$show_cols[] = 'air_destination_city';
	}
	if(!isset($_POST['remove_air_destination_country'])){
		$headers[] = _("Air Destination Country");
		$aligns[] = _("center");	
		$size_arr[] = 1;
		$show_cols[] = 'air_destination_country';
	}
	if(!isset($_POST['remove_sea_destination_port'])){
		$headers[] = _("Sea Destination Port");
		$aligns[] = _("center");	
		$size_arr[] = 1;
		$show_cols[] = 'sea_destination_port';
	}
	if(!isset($_POST['remove_sea_destination_city'])){
		$headers[] = _("Sea Destination City");
		$aligns[] = _("center");	
		$size_arr[] = 1;
		$show_cols[] = 'sea_destination_city';
	}
	if(!isset($_POST['remove_sea_destination_country'])){
		$headers[] = _("Sea Destination Country");
		$aligns[] = _("center");	
		$size_arr[] = 1;
		$show_cols[] = 'sea_destination_country';
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
	$shipping_type = isset($_POST['bShipping_type']) ? $_POST['bShipping_type'] : null  ;
	$air_destination_airport = isset($_POST['bAir_destination_airport']) ? $_POST['bAir_destination_airport'] : null  ;
	$air_destination_city = isset($_POST['bAir_destination_city']) ? $_POST['bAir_destination_city'] : null  ;
	$air_destination_country = isset($_POST['bAir_destination_country']) ? $_POST['bAir_destination_country'] : null  ;
	$sea_destination_port = isset($_POST['bSea_destination_port']) ? $_POST['bSea_destination_port'] : null  ;
	$sea_destination_city= isset($_POST['bSea_destination_city']) ? $_POST['bSea_destination_city'] : null  ;
	$sea_destination_country = isset($_POST['bSea_destination_country']) ? $_POST['bSea_destination_country'] : null  ;
	
	
			$conds =  "where
		shipping_type like ".db_escape('%'.$shipping_type.'%'). " and
		air_destination_airport like ".db_escape('%'.$air_destination_airport.'%'). " and
		air_destination_city like ".db_escape('%'.$air_destination_city.'%'). "  and
		air_destination_country like ".db_escape('%'.$air_destination_country.'%'). "  and
		sea_destination_port like ".db_escape('%'.$sea_destination_port.'%'). "  and
		sea_destination_city like ".db_escape('%'.$sea_destination_city.'%'). "  and
		sea_destination_country like ".db_escape('%'.$sea_destination_country.'%'). " 
		";
			if($shipping_type!=null)
			$params[] = array('text' => _('Shipping Type'), 'from' => $shipping_type, 'to' => '');
			if($air_destination_airport!=null)
			$params[] = array('text' => _('Air Destinatioin Airport'), 'from' =>$air_destination_airport, 'to' => '');
			if($air_destination_city!=null)
			$params[] = array('text' => _('Air Destinatioin City'), 'from' => $air_destination_city, 'to' => '');
			if($air_destination_country!=null)
			$params[] = array('text' => _('Air Destinatioin Country'), 'from' =>$air_destination_country, 'to' => '');
			if($sea_destination_port!=null)
			$params[] = array('text' => _('Sea Destination Port'), 'from' => $sea_destination_port, 'to' => '');
			if($sea_destination_city!=null)
			$params[] = array('text' => _('Sea Destination City'), 'from' =>$sea_destination_city, 'to' => '');
			if($sea_destination_country!=null)
			$params[] = array('text' => _('Sea Destination Country'), 'from' => $sea_destination_country, 'to' => '');
		
	 
		
	 
	}
    $rep = new FrontReport(_('shipping'), "shipping", user_pagesize());
    $rep->Font();
    $rep->Info($params, $cols, $headers, $aligns);
    $rep->NewPage();
 


	$sql = "SELECT shipping_type,air_destination_airport,air_destination_city,air_destination_country,sea_destination_port,sea_destination_city,sea_destination_country FROM ".TB_PREF."sale_shipping $conds ";
	
	$sql .= " ORDER BY shipping_type"; 
	$result = db_query($sql, "The shipping could not be retrieved");
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
