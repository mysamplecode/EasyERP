<?php
//---secutiry and path setting-------- 
$page_security = 'SA_HRM_BANKS';
$path_to_root = "../..";
//----include files--------
include_once($path_to_root . "/reporting/includes/pdf_report.inc");
//----pdf writer settings----------
$fields = array(
			'name' => array(_('Bank Name'),'left',20),
			'country' => array(_('Country'),'left',15),
			'swift' => array(_('Swift Code'),'left',10),
			'branch' => array(_('Branch Name'),'left',20),
			'branch_number' => array(_('Branch #'),'left',10),
			'address' => array(_('Address'),'left',30),
			'city' => array(_('City'),'left',10),
			'province' => array(_('Province'),'left',10),
			'postal_code' => array(_('Postal Code'),'left',8)
);
//----init the pdf writer---------
$rep = pdf_header_start($controller."s",$fields,'A3','L',8);
//----creating pdf main body------
$sql = $bank_db -> search(@$_POST['search_name'],@$_POST['search_country'],@$_POST['search_swift'],@$_POST['search_branch']
								,@$_POST['search_branch_number'],@$_POST['search_address']
								,@$_POST['search_city'],@$_POST['search_province'],@$_POST['search_postal_code']);
pdf_body_display($rep,$sql,$fields);
//----end the pdf writer------
pdf_header_end($rep);
?>
