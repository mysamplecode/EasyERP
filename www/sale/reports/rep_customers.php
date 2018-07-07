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
  		
	if(!isset($_POST['remove_customer_type'])){
		$headers[] = _("Customer Type");
		$aligns[] = _("left");	
		$size_arr[] = 1;
		$show_cols[] = 'customer_type';
	}
	if(!isset($_POST['remove_name'])){
		$headers[] = _("Name");
		$aligns[] = _("center");	
		$size_arr[] = 1;
		$show_cols[] = 'name';
	}
	if(!isset($_POST['remove_code'])){
		$headers[] = _("Code");
		$aligns[] = _("center");	
		$size_arr[] = 1;
		$show_cols[] = 'code';
	}
	if(!isset($_POST['remove_address'])){
		$headers[] = _("Address");
		$aligns[] = _("center");	
		$size_arr[] = 1;
		$show_cols[] = 'address';
	}
	if(!isset($_POST['remove_city'])){
		$headers[] = _("City");
		$aligns[] = _("center");	
		$size_arr[] = 1;
		$show_cols[] = 'city';
	}
	if(!isset($_POST['remove_state'])){
		$headers[] = _("State");
		$aligns[] = _("center");	
		$size_arr[] = 1;
		$show_cols[] = 'state';
	}
	if(!isset($_POST['remove_country'])){
		$headers[] = _("Country");
		$aligns[] = _("center");	
		$size_arr[] = 1;
		$show_cols[] = 'country';
	}
	if(!isset($_POST['remove_website'])){
		$headers[] = _("Website");
		$aligns[] = _("center");	
		$size_arr[] = 1;
		$show_cols[] = 'website';
	}
	if(!isset($_POST['remove_postal'])){
		$headers[] = _("Postal Code");
		$aligns[] = _("center");	
		$size_arr[] = 1;
		$show_cols[] = 'postal';
	}
	if(!isset($_POST['remove_phone'])){
		$headers[] = _("Telephone");
		$aligns[] = _("center");	
		$size_arr[] = 1;
		$show_cols[] = 'telephone';
	}
	if(!isset($_POST['remove_fax'])){
		$headers[] = _("Fax");
		$aligns[] = _("center");	
		$size_arr[] = 1;
		$show_cols[] = 'fax';
	}
	if(!isset($_POST['remove_email'])){
		$headers[] = _("Primary Email");
		$aligns[] = _("center");	
		$size_arr[] = 1;
		$show_cols[] = 'email';
	}
	if(!isset($_POST['remove_cont_name'])){
		$headers[] = _("Contact Person Name");
		$aligns[] = _("center");	
		$size_arr[] = 1;
		$show_cols[] = 'cont_name';
	}
	if(!isset($_POST['remove_cont_designation'])){
		$headers[] = _("Contact Person Designation");
		$aligns[] = _("center");	
		$size_arr[] = 1;
		$show_cols[] = 'cont_designation';
	}
	if(!isset($_POST['remove_cont_number'])){
		$headers[] = _("Contact Person Number");
		$aligns[] = _("center");	
		$size_arr[] = 1;
		$show_cols[] = 'cont_number';
	}
	if(!isset($_POST['remove_cont_email'])){
		$headers[] = _("Contact Person Email");
		$aligns[] = _("center");	
		$size_arr[] = 1;
		$show_cols[] = 'cont_email';
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
	$customer_type = isset($_POST['bCustomer_type']) ? $_POST['bCustomer_type'] : null  ;
	$name = isset($_POST['bName']) ? $_POST['bName'] : null  ;
	$code = isset($_POST['bCode']) ? $_POST['bCode'] : null  ;
	$address = isset($_POST['bAddress']) ? $_POST['bAddress'] : null  ;
	$city = isset($_POST['bCity']) ? $_POST['bCity'] : null  ;
	$state= isset($_POST['bState']) ? $_POST['bState'] : null  ;
	$country = isset($_POST['bCountry']) ? $_POST['bCountry'] : null  ;
	$website = isset($_POST['bWebsite']) ? $_POST['bWebsite'] : null  ;
	$postal = isset($_POST['bPostal']) ? $_POST['bPostal'] : null  ;
	$phone = isset($_POST['bPhone']) ? $_POST['bPhone'] : null  ;
	$fax = isset($_POST['bFax']) ? $_POST['bFax'] : null  ;
	$email = isset($_POST['bEmail']) ? $_POST['bEmail'] : null  ;
	$cont_name = isset($_POST['bCont_name']) ? $_POST['bCont_name'] : null  ;
	$cont_designation = isset($_POST['bCont_designation']) ? $_POST['bCont_designation'] : null  ;
	$cont_number = isset($_POST['bCont_number']) ? $_POST['bCont_number'] : null  ;
	$cont_email = isset($_POST['bCont_email']) ? $_POST['bCont_email'] : null  ;
	
			$conds =  "where
		customer_type like ".db_escape('%'.$customer_type.'%'). " and
		name like ".db_escape('%'.$name.'%'). " 
		";
			if($customer_type!=null)
			$params[] = array('text' => _('Customer Type'), 'from' => $customer_type, 'to' => '');
			if($name!=null)
			$params[] = array('text' => _('Name'), 'from' =>$name, 'to' => '');
			if($code!=null)
			$params[] = array('text' => _('Code'), 'from' => $code, 'to' => '');
		if($address!=null)
			$params[] = array('text' => _('Address'), 'from' =>$address, 'to' => '');
			if($city!=null)
			$params[] = array('text' => _('City'), 'from' => $city, 'to' => '');
		if($state!=null)
			$params[] = array('text' => _('State'), 'from' =>$state, 'to' => '');
			if($country!=null)
			$params[] = array('text' => _('Country'), 'from' => $country, 'to' => '');
		if($website!=null)
			$params[] = array('text' => _('Website'), 'from' =>$website, 'to' => '');
		if($postal!=null)
			$params[] = array('text' => _('Postal Code'), 'from' => $postal, 'to' => '');
		if($phone!=null)
			$params[] = array('text' => _('Telephone'), 'from' =>$phone, 'to' => '');
		if($fax!=null)
			$params[] = array('text' => _('Fax'), 'from' => $fax, 'to' => '');
		if($email!=null)
			$params[] = array('text' => _('Primary Email'), 'from' =>$email, 'to' => '');
			if($cont_name!=null)
			$params[] = array('text' => _('Contact Person Name'), 'from' => $cont_name, 'to' => '');
		if($cont_designation!=null)
			$params[] = array('text' => _('Contact Person Designation'), 'from' =>$cont_designation, 'to' => '');
			if($cont_number!=null)
			$params[] = array('text' => _('Contact Person Number'), 'from' => $cont_number, 'to' => '');
		if($cont_email!=null)
			$params[] = array('text' => _('Contact Person Email'), 'from' =>$cont_email, 'to' => '');
	 
		
	 
	}
    $rep = new FrontReport(_('customers'), "customers", user_pagesize());
    $rep->Font();
    $rep->Info($params, $cols, $headers, $aligns);
    $rep->NewPage();
 


	$sql = "SELECT customer_type,name,code,address,city,state,country,website,postal,telephone,fax,email,cont_name,cont_designation,cont_number,cont_email FROM ".TB_PREF."cust_branch $conds ";
	
	$sql .= " ORDER BY name"; 
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
