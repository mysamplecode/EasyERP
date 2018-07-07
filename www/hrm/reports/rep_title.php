<?php
//---secutiry and path setting-------- 
$page_security = 'SA_HRM_TITLES';
$path_to_root = "../..";
//----include files--------
include_once($path_to_root . "/reporting/includes/pdf_report.inc");
//----pdf writer settings----------
$fields = array(
			'name' => array(_("$controller Name"),'left',30),
);
//----init the pdf writer---------
$rep = pdf_header_start($controller."s",$fields,'A4','P',10);
//----creating pdf main body------
$sql = $title_db -> search(@$_POST['search_name']);
pdf_body_display($rep,$sql,$fields);
//----end the pdf writer------
pdf_header_end($rep);
?>
