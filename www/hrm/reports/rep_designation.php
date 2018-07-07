<?php
//---secutiry and path setting-------- 
$page_security = 'SA_HRM_DESIGNATIONS';
$path_to_root = "../..";
//----include files--------
include_once($path_to_root . "/reporting/includes/pdf_report.inc");
//----pdf writer settings----------
$fields = array(
			'name' => array(_('Name'),'left',30),
			'description' => array(_('Description'),'left',30),
			'start_salary_bracket' => array(_('Starting Salary'),'right',10,'',PDF_MONEY),
			'end_salary_bracket' => array(_('Ending Salary'),'right',10,'',PDF_MONEY),
			'curr_abrev' => array(_('Currency'),'right',5)
);
//----init the pdf writer---------
$rep = pdf_header_start($controller."s",$fields,'A3','P',9);
//----creating pdf main body------
$sql = $designation_db -> search(@$_POST['search_name'],@$_POST['search_description'],@$_POST['search_start_salary_bracket'],@$_POST['search_end_salary_bracket'],@$_POST['search_curr_abrev']);
pdf_body_display($rep,$sql,$fields);
//----end the pdf writer------
pdf_header_end($rep);
?>