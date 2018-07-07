<?php
//---secutiry and path setting-------- 
$page_security = 'SA_HRM_UNITS';
$path_to_root = "../..";
//----include files--------
include_once($path_to_root . "/reporting/includes/pdf_report.inc");
//----pdf writer settings----------
$fields = array(
			'name' => array(_("$controller Name"),'left',30) //name,alignment,width
);
//----init the pdf writer---------
$rep = pdf_header_start($controller."s",$fields,'A4','P',10);
//----creating pdf main body------
$sql = $unit_db -> search(@$_POST['search_name']);
pdf_body_display($rep,$sql,$fields);
//----end the pdf writer------
pdf_header_end($rep);
?>
