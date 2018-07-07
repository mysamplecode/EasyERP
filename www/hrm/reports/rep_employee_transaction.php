<?php
//---secutiry and path setting-------- 
$page_security = 'SA_HRM_EMPLOYEE_ENTRY';
$path_to_root = "../..";
//----include files--------
include_once($path_to_root . "/reporting/includes/pdf_report.inc");
//----pdf writer settings----------
$_POST['print_transaction_timestamp'] = 1;
$fields = array(
			'first_name' => array(_('First Name'),'left',15),
			'last_name' => array(_('Last Name'),'left',15),
			'department_id' => array(_('Department Name'),'left',18),
			'unit_id' => array(_('Unit Name'),'left',14),
			'transaction_timestamp' => array(_('Time Stamp'),'left',19)
);
switch($transaction_code)
{
	case EMPLOYEE_CONFIRMATION:
	case EMPLOYEE_TERMINATION:	
	case EMPLOYEE_RESIGNATION:
		$rep = pdf_header_start($controller."s",$fields,'A3','P',9,true);
		break;
	case EMPLOYEE_DESIGNATION:	
		$fields['transaction_string1'] = array(_('Old Designation'),'left',20);
		$fields['transaction_string2'] = array(_('New Designation'),'left',20);
		$rep = pdf_header_start($controller."s",$fields,'A3','L',9,true);
		break;
	case EMPLOYEE_PENALTY:	
		$fields['transaction_string1'] = array(_('Fiscal Year'),'left',24);
		$fields['transaction_string2'] = array(_('Leave Type'),'left',13);
		$fields['transaction_dec2'] = array(_('Asssigned'),'left',10);
		$fields['transaction_int2'] = array(_('Remaining'),'left',10);
		$rep = pdf_header_start($controller."s",$fields,'A3','L',9,true);
		break;
	case EMPLOYEE_SHIFT:	
		$fields['transaction_string1'] = array(_('Old Shift'),'left',20);
		$fields['transaction_string2'] = array(_('New Shift'),'left',20);
		$rep = pdf_header_start($controller."s",$fields,'A3','L',9,true);
		break;
	case EMPLOYEE_SALARY:	
		$fields['transaction_dec1'] = array(_('Old Salary'),'left',20);
		$fields['transaction_dec2'] = array(_('New Salary'),'left',20);
		$rep = pdf_header_start($controller."s",$fields,'A3','L',9,true);
		break;
	case EMPLOYEE_ADVANCE:	
		$fields['transaction_dec1'] = array(_('Existing Advance'),'left',20);
		$fields['transaction_dec2'] = array(_('New Advance'),'left',20);
		$rep = pdf_header_start($controller."s",$fields,'A3','L',9,true);
		break;
	case EMPLOYEE_INSTALLMENT:	
		$fields['transaction_dec1'] = array(_('Existing Installment'),'left',20);
		$fields['transaction_dec2'] = array(_('New Installment'),'left',20);
		$rep = pdf_header_start($controller."s",$fields,'A3','L',9,true);
		break;
	
}
//----creating pdf main body------
$sql = $employee_transaction_db -> search($transaction_code,@$_POST['search_first_name'],@$_POST['search_last_name'],@$_POST['search_unit_id'],@$_POST['search_department_id']);
pdf_body_display($rep,$sql,$fields,true);
//----end the pdf writer------
pdf_header_end($rep);
?>