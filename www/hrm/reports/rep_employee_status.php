<?php 
//---secutiry and path setting-------- 
$page_security = 'SA_HRM_CONFIRMATION_ENTRY';
$path_to_root = "../..";
//----include files--------
include_once($path_to_root . "/reporting/includes/pdf_report.inc");
//----pdf writer settings----------
$fields = array(
			'name' => array(_('Name'),'left',20)
);
//----init the pdf writer---------
$rep = pdf_header_start($controller."s",$fields,'A4','P',9);
//----creating pdf main body------
$sql = $holiday_db -> search(@$_POST['search_name']);
pdf_body_display($rep,$sql,$fields);
//----end the pdf writer------
pdf_header_end($rep);
?>