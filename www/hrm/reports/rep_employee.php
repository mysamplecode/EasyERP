<?php
//---secutiry and path setting-------- 
$page_security = 'SA_HRM_EMPLOYEE_ENTRY';
$path_to_root = "../..";
//----include files--------
include_once($path_to_root . "/reporting/includes/pdf_report.inc");

if(strcmp($Mode,'Print')==0)
{
	pr("Printing the employee profile");
	print_employee_profile($selected_id);
}
 else if(isset($_POST['CardOrders']))
{
	pr("I am here");
	$employee_db = new employee_model();
	
	$sql = $employee_db -> search(@$_POST['search_first_name'],@$_POST['search_last_name'],@$_POST['search_unit'],@$_POST['search_department'],@$_POST['search_designation']);
	print_all_employee_card($sql);
} 
else if(strcmp($Mode,'Card')==0)
{
	pr("Printing the employee card");
	print_employee_card($selected_id);
}
else 
{
	display_warning("Unable to identify a proper Print order");
}

//-----------------------------------------------------------
function print_all_employee_card($sql)
{
	global $prefix,$profile;
	
	$rep = new FrontReport(_("Employee ID Card"), 'employeeidcard', 'A4',9,'P');
	pr("print all employee cards = ".$sql);
	$query = PluSQL::against($profile)->run($sql);
	
	while($row = $query->nextRow())
	{
		print_employee_card($row[$prefix.'employee$employee_id'],$rep);	
	}
	
	$rep->End();
    
}
function print_employee_card($selected_id, $fr = null)
{
	pr("Employee card says: ".$selected_id);
	//---get company details
	$company = get_company_pref();
	//---starting up the models
	$employee_db = new employee_model();
	$unit_db = new unit_model();
	$department_db = new department_model();
	$designation_db = new designation_model();
	$shift_db = new shift_model();
	$employee_status_db = new employee_status_model();
	//----get the selected employee--------
	$emp_row = array();
	$emp_row['employee_db'] = array();
	$emp_row['unit_db'] = array();
	$emp_row['department_db'] = array();
	$emp_row['designation_db'] = array();
	$emp_row['shift_db'] = array();
	$emp_row['employee_status_db'] = array();
	
	$employee_db -> select($selected_id, employee_model::PERSONAL, $emp_row['employee_db']);
	$unit_db -> select($emp_row['employee_db']['unit_id'], $emp_row['unit_db']);
	$department_db -> select($emp_row['employee_db']['department_id'], $emp_row['department_db']);
	$designation_db -> select($emp_row['employee_db']['designation_id'], $emp_row['designation_db']);
	$shift_db -> select($emp_row['employee_db']['shift_id'],$emp_row['shift_db']);
	$employee_status_db -> select($emp_row['employee_db']['employee_status_id'],$emp_row['employee_status_db']);
	//-------------------------------------------------------------------------------
	// A4 - P (w:595px,l:842px)
	//-------------0--1---2----
	$cols = array(0,150,160,350,420);
	$headers = array();
	$aligns = array('left', 'left', 'left');
	if(is_null($fr))
	{
		$rep = new FrontReport(_("Employee ID Card"), 'employeeidcard', 'A4',9,'P');
		$rep->Info(array(0 => ''), $cols, $headers, $aligns);
		$rep->NewPage();	
	}
	else 
	{
		$rep = $fr;
		$rep->Info(array(0 => ''), $cols, $headers, $aligns);
		$rep->NewPage();
	}
	//----------add image to col 6-------------
	if(empty($emp_row['employee_db']['path_to_picture']) || !file_exists($emp_row['employee_db']['path_to_picture']))
	{
		$emp_row['employee_db']['path_to_picture'] = NO_IMAGE;
	}
	$rep->AddImage($emp_row['employee_db']['path_to_picture'], $cols[3] - $rep -> rightMargin + 13, ($rep->pageHeight - 186), IDCARD_PICTURE_WIDTH, IDCARD_PICTURE_HEIGHT); 
	$rep->SetDrawColor(0, 0, 0);
	$rep->rectangle($cols[3] - $rep -> rightMargin + 13, ($rep->pageHeight - 120), IDCARD_PICTURE_WIDTH, IDCARD_PICTURE_HEIGHT);
	$rep->rectangle($cols[1], ($rep->pageHeight - 120), CARD_WIDTH, CARD_HEIGHT);
	//------now add the heading----------
	$cols = array(0,111,292);
	$rep->Info(array(0 => ''), $cols, $headers, $aligns);
	$rep->add_heading($company['coy_name'], 1, 1);
	//----------Employee Personal Information--------------------------
	$rep->NewLine(1);
	$oldfontsize = $rep -> fontSize;
	$rep -> fontSize = $rep -> fontSize - 2;
	
	$cols = array(0,111,160,340);
	$rep->Info(array(0 => ''), $cols, $headers, $aligns);
	$arr = array
	(
		"First Name" => $emp_row['employee_db']['first_name'],
		"Last Name" => $emp_row['employee_db']['last_name'],
		"Unit Name" => $emp_row['unit_db']['name'],
		"Status" => $emp_row['employee_status_db']['name']
	);
	$rep->add_label_value_group($arr,1,2,0,0);
	
	$cols = array(0,111,180,340);
	$rep->Info(array(0 => ''), $cols, $headers, $aligns);
	$arr = array
	(
		"Department" => $emp_row['department_db']['name'],
		"Designation" => $emp_row['designation_db']['name']
	);
	$rep->add_label_value_group($arr,1,2,0,0);
	//now take the row two steps up
	$rep->row = $rep->row + ($rep->lineHeight*2);
	//adjust the cols
	$cols = array(0,290,318,360);
	$rep->Info(array(0 => ''), $cols, $headers, $aligns);
	$arr = array
	(
		"DOB" => $emp_row['employee_db']['date_of_birth'],
		"Sex" => $emp_row['employee_db']['sex']
	);
	$rep->add_label_value_group($arr,1,2,0,0);
	//---------now paste the barcode-------------------
	$attendance_db = new attendance_model();
	
	$len = strlen($company['postal_address']);
	$temp = $len / 2;
	
	$cols = array(0,180,350);
	$rep->Info(array(0 => ''), $cols, $headers, $aligns);
	$rep->row = $rep->row - ($rep->lineHeight*0.5);
	
	$rep->add_clean_heading(substr($company['postal_address'],0,$temp), 1, 1);
	$rep->NewLine();
	
	$cols = array(0,170,350);
	$rep->Info(array(0 => ''), $cols, $headers, $aligns);
	$rep->add_clean_heading(substr($company['postal_address'],$temp,$len), 1, 1);
	
	$cols = array(0,150,175,350,420);
	$rep->Info(array(0 => ''), $cols, $headers, $aligns);
	$rep->SetDrawColor(0, 0, 0);
	$rep->AddImage(COMPANY_LOGO, $cols[2] - $rep -> rightMargin + 13, ($rep->pageHeight - 275), IDCARD_PICTURE_WIDTH - 20, IDCARD_PICTURE_HEIGHT - 20);
	
	$rep->fontSize = $oldfontsize;
	//----------now lets go for the back of the card----------
	$cols = array(0,150,160,350,420);
	$rep->Info(array(0 => ''), $cols, $headers, $aligns);
	$rep->SetDrawColor(0, 0, 0);
	$rep->rectangle($cols[1], ($rep->pageHeight - 286), CARD_WIDTH, CARD_HEIGHT);
	//---------lets add the company logo at the back of the page
	$rep->AddImage(COMPANY_LOGO, $cols[3] - $rep -> rightMargin + 13, ($rep->pageHeight - 354), IDCARD_PICTURE_WIDTH, IDCARD_PICTURE_HEIGHT); 
	//$rep->rectangle($cols[3] - $rep -> rightMargin + 13, ($rep->pageHeight - 286), IDCARD_PICTURE_WIDTH, IDCARD_PICTURE_HEIGHT);
	//------now add the heading----------
	$rep->NewLine(2);
	$rep->row = $rep->row - ($rep->lineHeight * 0.5);
	$cols = array(0,111,292);
	$rep->Info(array(0 => ''), $cols, $headers, $aligns);
	$rep->add_heading($company['coy_name'], 1, 1);
	//------employee personal information----------
	$rep -> fontSize = $rep -> fontSize - 2;
	$rep->NewLine(1);
	$cols = array(0,111,180,340);
	$rep->Info(array(0 => ''), $cols, $headers, $aligns);
	$arr = array
	(
		"CNIC #" => $emp_row['employee_db']['cnic'],
		"Contact #" => $emp_row['employee_db']['primary_contact'],
		"Joining Date" => $emp_row['employee_db']['joining_date'],
		"Blood Group" => $emp_row['employee_db']['blood_group']
	);
	$rep->add_label_value_group($arr,1,2,0,0);
	
	$cols = array(0,111,180,340);
	$rep->Info(array(0 => ''), $cols, $headers, $aligns);
	$arr = array
	(
		"Guardian Name" => $emp_row['employee_db']['guardian_first_name'].' '.$emp_row['employee_db']['guardian_last_name'],
		"Permenant Address" => $emp_row['employee_db']['permenant_address']
	);
	$rep->add_label_value_group($arr,1,2,0,0);
	//---------now paste the barcode-------------------
	$attendance_db = new attendance_model();
	
	$cols = array(0,176,390);
	$rep->Info(array(0 => ''), $cols, $headers, $aligns);
	$rep->write1DBarcode($attendance_db -> id2hash($selected_id), 'C39',$cols[1],$rep->pageHeight - ($rep->row - 5), BARCODE_WIDTH, BARCODE_HEIGHT, 15, array('fgcolor'=>array(0, 0, 0)));
	
	//$rep->write1DBarcode($attendance_db -> id2hash($selected_id), 'C39',$cols[1],$rep->pageHeight - ($rep->row - 5), BARCODE_WIDTH, BARCODE_HEIGHT, 15, array('fgcolor'=>array(0, 0, 0)));
	//----------close and print the PDF--------------------------
	$rep->NewLine(7);
	$rep -> fontSize = $oldfontsize;
	pr("finishing up the card display");
	if(is_null($fr))
	{
		$rep->End();	
	}
}
/*
 
 */
function print_employee_profile($selected_id)
{
	//---get company details
	$company = get_company_pref();
	//---starting up the models
	$employee_db = new employee_model();
	$unit_db = new unit_model();
	$department_db = new department_model();
	$designation_db = new designation_model();
	$shift_db = new shift_model();
	$employee_status_db = new employee_status_model();
	//----get additional models-----
	$employee_leave_db = new employee_leave_model();
	$employee_allowance_db = new employee_allowance_model();
	$employee_deduction_db = new employee_deduction_model();
	$employee_dependent_db = new employee_dependent_model();
	$employee_reference_db = new employee_reference_model();
	$employee_qualification_db = new employee_qualification_model();
	$employee_joining_db = new employee_joining_model();
	//----get the selected employee--------
	$emp_row = array();
	$emp_row['employee_db'] = array();
	$emp_row['employee_salary_db'] = array();
	$emp_row['unit_db'] = array();
	$emp_row['department_db'] = array();
	$emp_row['designation_db'] = array();
	$emp_row['shift_db'] = array();
	$emp_row['employee_status_db'] = array();
	
	$employee_db -> select($selected_id, employee_model::PERSONAL, $emp_row['employee_db']);
	$employee_db -> select($selected_id, employee_model::SALARY_TERMS, $emp_row['employee_salary_db']);
	$unit_db -> select($emp_row['employee_db']['unit_id'], $emp_row['unit_db']);
	$department_db -> select($emp_row['employee_db']['department_id'], $emp_row['department_db']);
	$designation_db -> select($emp_row['employee_db']['designation_id'], $emp_row['designation_db']);
	$shift_db -> select($emp_row['employee_db']['shift_id'],$emp_row['shift_db']);
	$employee_status_db -> select($emp_row['employee_db']['employee_status_id'],$emp_row['employee_status_db']);
	//-------------------------------------------------------------------------------
	// A4 - P (w:595px,l:842px)
	//-------------0--1---2----
	$cols = array(0,160,300,420);
	$headers = array();
	$aligns = array('left', 'left', 'left'); 
	$rep = new FrontReport(_("Employee Record"), 'employeerecord', 'A4',9,'P');
	$rep->Info(array(0 => ''), $cols, $headers, $aligns);
	$rep->NewPage();
	//----------add image to col 6-------------
	if(empty($emp_row['employee_db']['path_to_picture']) || !file_exists($emp_row['employee_db']['path_to_picture']))
	{
		$emp_row['employee_db']['path_to_picture'] = NO_IMAGE;
	}
	$rep->AddImage($emp_row['employee_db']['path_to_picture'], $cols[3] - $rep -> rightMargin + 0, ($rep->pageHeight - 270), PROFILE_PICTURE_WIDTH, PROFILE_PICTURE_HEIGHT); 
	$rep->SetDrawColor(170, 0, 0);
	$rep->rectangle($cols[3] - $rep -> rightMargin, ($rep->pageHeight - 120), PROFILE_PICTURE_WIDTH, PROFILE_PICTURE_HEIGHT);
	//----------Employee Personal Information--------------------------
	$arr = array
	(
		"First Name" => $emp_row['employee_db']['first_name'],
		"Last Name" => $emp_row['employee_db']['last_name'],
		"Unit Name" => $emp_row['unit_db']['name'],
		"Department Name" => $emp_row['department_db']['name'],
		"Designation Name" => $emp_row['designation_db']['name'],
		"Shift Name" => $emp_row['shift_db']['name'],
		"Employement Status" => $emp_row['employee_status_db']['name'],
		"Primary Contact" => $emp_row['employee_db']['primary_contact'],
		"Secondary Contact" => $emp_row['employee_db']['secondary_contact'],
		"CNIC Number" => $emp_row['employee_db']['cnic'],
		"Date of Birth" => $emp_row['employee_db']['date_of_birth'],
		"Gender" => $emp_row['employee_db']['sex'],
		"Marital Status" => $emp_row['employee_db']['marital_status'],
		"Blood Group" => $emp_row['employee_db']['blood_group'],
		"Religion" => $emp_row['employee_db']['religion'],
		"Nationality" => $emp_row['employee_db']['nationality'],
		"Joining Date" => $emp_row['employee_db']['joining_date'],
		"City" => $emp_row['employee_db']['city'],
		"Country" => $emp_row['employee_db']['country'],
	);
	$rep->add_label_value_group($arr,0,1);
	$rep->NewLine(2);
	//----------new col definations for the addresses-----------
	//-------------0--1---2----
	$cols = array(0,160,500);
	$headers = array();
	$aligns = array('left', 'left', 'left'); 
	$rep->Info(array(0 => ''), $cols, $headers, $aligns);
	$arr = array
	(
		"Permenant Address" => $emp_row['employee_db']['permenant_address'],
		"Temporary Address" => $emp_row['employee_db']['temporary_address'],
	);
	$rep->add_label_value_group($arr,0,1);
	$rep->NewLine(2);
	//----------new col definations for the salary section-----------
	//-------------0--1---2----
	$cols = array(0,160,300);
	$headers = array();
	$aligns = array('left', 'left', 'left'); 
	$rep->Info(array(0 => ''), $cols, $headers, $aligns);
	$arr = array
	(
		"Basic Salary" => number_format($emp_row['employee_salary_db']['basic_salary'],2).' '.$company['curr_default'],
		"Payment Method" => $emp_row['employee_salary_db']['payment_method']
	);
	if(!empty($emp_row['employee_salary_db']['bank_id']))
	{
		$bank_db = new bank_model();
		$emp_row['bank_db'] = array();
		$bank_db->select($emp_row['employee_salary_db']['bank_id'],$emp_row['bank_db']);
		$arr["Bank Name"] = $emp_row['bank_db']['name'];
	}
	$arr["Account Name"] = @$emp_row['employee_salary_db']['account_holder_name'];
	$arr["Account IBAN"] = @$emp_row['employee_salary_db']['account_iban'];
	$arr["Check Name"] = @$emp_row['employee_salary_db']['check_reciever'];
	$rep->add_label_value_group($arr,0,1);
	//---go back for the table wise reporting---------------
	//---first table employee leaves------------
	$fields = array(
			'leave_id' => array(_('Leave Type'),'left',20),
			'leave_assigned' => array(_('Leaves Assigned'),'left',10)
	);
	pdf_simple_header($rep, $fields);
	$sql = $employee_leave_db -> search($selected_id);
	pdf_body_display($rep,$sql,$fields,true);
	//---second table employee allowances------------
		$fields = array(
			'allowance_id' => array(_('Allowance Type'),'left',20),
			'allowance_amount' => array(_('Allowance Amount'),'left',10,'',PDF_MONEY)
	);
	pdf_simple_header($rep, $fields);
	$sql = $employee_allowance_db -> search($selected_id);
	pdf_body_display($rep,$sql,$fields,true);
	//---third table employee deduction------------
		$fields = array(
			'allowance_id' => array(_('Deduction Type'),'left',20),
			'allowance_amount' => array(_('Deduction Amount'),'left',10,'',PDF_MONEY)
	);
	pdf_simple_header($rep, $fields);
	$sql = $employee_deduction_db -> search($selected_id);
	pdf_body_display($rep,$sql,$fields,true);
	//---fourth table employee joining------------
		$fields = array(
			'last_organization' => array(_('Last Organization'),'left',20),
			'last_salary' => array(_('Last Salary'),'left',10,'',PDF_MONEY),
			'joining_start_date' => array(_('Joining Date'),'left',10),
			'joining_end_date' => array(_('Leaving Date'),'left',10)
	);
	pdf_simple_header($rep, $fields);
	$sql = $employee_joining_db -> search($selected_id);
	pdf_body_display($rep,$sql,$fields,true);
	//---fifth table employee qualification------------
		$fields = array(
			'degree' => array(_('Degree'),'left',15),
			'university_name' => array(_('University Name'),'left',15),
			'degree_start_year' => array(_('Start Year'),'left',10),
			'degree_end_year' => array(_('End Year'),'left',10),
			'marks_obtained' => array(_('Marks Obtained'),'left',10)
	);
	pdf_simple_header($rep, $fields);
	$sql = $employee_qualification_db -> search($selected_id);
	pdf_body_display($rep,$sql,$fields,true);
	//---sixth table reference------------
		$fields = array(
			'reference_name' => array(_('Reference Name'),'left',20),
			'contact_number' => array(_('Contact #'),'left',12),
			'know_since_date' => array(_('Known Since'),'left',10)
	);
	pdf_simple_header($rep, $fields);
	$sql = $employee_reference_db -> search($selected_id);
	pdf_body_display($rep,$sql,$fields,true);
	//---seventh table dependents------------
		$fields = array(
			'dependent_name' => array(_('Dependent Name'),'left',20),
			'dependent_relation' => array(_('Dependent Relation'),'left',15),
			'dependent_date_of_birth' => array(_('Date of Birth'),'left',10),
			'dependent_occupation' => array(_('Dependent Occupation'),'left',35)
	);
	pdf_simple_header($rep, $fields);
	$sql = $employee_reference_db -> search($selected_id);
	pdf_body_display($rep,$sql,$fields,true);
	//----------close and print the PDF--------------------------
	$rep->End();
}
?>
