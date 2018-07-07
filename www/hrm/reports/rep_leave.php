<?php
//---secutiry and path setting-------- 
$page_security = 'SA_HRM_LEAVE_ENTRY';
$path_to_root = "../..";
//----include files--------
include_once($path_to_root . "/reporting/includes/pdf_report.inc");
//----pdf writer settings----------
$fields = array(
			'name' => array(_('Name'),'left',25),
			'description' => array(_('Description'),'left',25),
			'minimum_leaves' => array(_('Min Leaves'),'left',10),
			'maximum_leaves' => array(_('Max Leaves'),'left',10)
);
//----init the pdf writer---------
$rep = pdf_header_start($controller."s",$fields,'A4','P',9);
//----creating pdf main body------
$sql = $leave_db -> search(@$_POST['search_name'],@$_POST['search_description'],@$_POST['search_minimum_leaves'],@$_POST['search_maximum_leaves']);
pdf_body_display($rep,$sql,$fields);
//----end the pdf writer------
pdf_header_end($rep);
?>
