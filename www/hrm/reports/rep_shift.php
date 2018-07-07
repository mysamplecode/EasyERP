<?php
//---secutiry and path setting-------- 
$page_security = 'SA_HRM_SHIFTS';
$path_to_root = "../..";
//----include files--------
include_once($path_to_root . "/reporting/includes/pdf_report.inc");
//----pdf writer settings----------
$_POST['print_standard_shift_start'] = 1;
$_POST['print_standard_shift_end'] = 1;
$_POST['print_standard_relax_start'] = 1;
$_POST['print_standard_relax_end'] = 1;
$fields = array(
			'name' => array(_('Name'),'left',20),
			'description' => array(_('Description'),'left',30),
			'standard_shift_start' => array(_('Shift Start'),'left',10),
			'standard_shift_end' => array(_('Shift End'),'left',10),
			'standard_relax_start' => array(_('Relax Start'),'left',10),
			'standard_relax_end' => array(_('Relax End'),'left',10),
);
//----init the pdf writer---------
$rep = pdf_header_start($controller."s",$fields,'A4','L',9);
//----creating pdf main body------
$sql = $shift_db -> search(@$_POST['search_name'],@$_POST['search_description']);
pdf_body_display($rep,$sql,$fields);
//----end the pdf writer------
pdf_header_end($rep);
unset($_POST['print_standard_shift_start']);
unset($_POST['print_standard_shift_end']);
unset($_POST['print_standard_relax_start']);
unset($_POST['print_standard_relax_end']);

?>
