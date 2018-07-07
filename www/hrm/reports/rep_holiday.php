<?php
//---secutiry and path setting-------- 
$page_security = 'SA_HRM_HOLIDAYS';
$path_to_root = "../..";
//----include files--------
include_once($path_to_root . "/reporting/includes/pdf_report.inc");
//----pdf writer settings----------
$_POST['print_start_holiday'] = 1;
$_POST['print_end_holiday'] = 1;
$_POST['print_fiscal_begin'] = 1;
$_POST['print_fiscal_end'] = 1;
$fields = array(
			'name' => array(_('Name'),'left',20),
			'description' => array(_('Description'),'left',30),
			'start_holiday' => array(_('Holiday Start'),'left',10),
			'end_holiday' => array(_('Holiday End'),'left',10),
			'fiscal_begin' => array(_('Fiscal Start'),'left',10),
			'fiscal_end' => array(_('Fiscal End'),'left',10),
);
//----init the pdf writer---------
$rep = pdf_header_start($controller."s",$fields,'A4','L',9);
//----creating pdf main body------
$sql = $holiday_db -> search(@$_POST['search_name'],@$_POST['search_description'],@$_POST['search_fiscal_year_id']);
pdf_body_display($rep,$sql,$fields);
//----end the pdf writer------
pdf_header_end($rep);
unset($_POST['print_start_holiday']);
unset($_POST['print_end_holiday']);
unset($_POST['print_fiscal_begin']);
unset($_POST['print_fiscal_end']);
?>
