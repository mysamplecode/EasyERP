<?php
//---secutiry and path setting-------- 
$page_security = 'SA_HRM_ALLOWANCES';
$path_to_root = "../..";
//----include files--------
include_once($path_to_root . "/reporting/includes/pdf_report.inc");
//----pdf writer settings----------
$fields = array(
			'name' => array(_('Name'),'left',20),
			'description' => array(_('Description'),'left',30),
			'type' => array(_('Allowance Type'),'left',18,array('0' => 'Company Based', '1' => 'Government Based'))
);
//----init the pdf writer---------
$rep = pdf_header_start($controller."s",$fields,'A4','P',9);
//----creating pdf main body------
$sql = $allowance_db -> search(@$_POST['search_name'],@$_POST['search_description'],@$_POST['search_type']);
pdf_body_display($rep,$sql,$fields);
//----end the pdf writer------
pdf_header_end($rep);
?>
