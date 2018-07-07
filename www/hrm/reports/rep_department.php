<?php
//---secutiry and path setting-------- 
$page_security = 'SA_HRM_DEPARTMENTS';
$path_to_root = "../..";
//----include files--------
include_once($path_to_root . "/reporting/includes/pdf_report.inc");
//----pdf writer settings----------
$fields = array(
			'name' => array(_('Name'),'left',30),
			'strength' => array(_('Strength'),'left',10),
			'unit_id' => array(_('Unit Name'),'left',30)
);
//----init the pdf writer---------
$rep = pdf_header_start($controller."s",$fields,'A4','P',10);
//----creating pdf main body------
$sql = $department_db -> search(@$_POST['search_name'],@$_POST['search_strength'],@$_POST['search_unit_id']);
pdf_body_display($rep,$sql,$fields);
//----end the pdf writer------
pdf_header_end($rep);
?>











