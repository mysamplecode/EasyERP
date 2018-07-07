<?php
//---secutiry and path setting-------- 
$page_security = 'SA_HRM_ATTENDANCE';
$path_to_root = "../..";
//----include files--------
include_once($path_to_root . "/reporting/includes/pdf_report.inc");
//----pdf writer settings----------
$fields = array(
			'first_name' => array(_('First Name'),'left',15),
                        'last_name' => array(_('Last Name'),'left',8),
			'department_id' => array(_('Department'),'left',11),
                        'unit_id' => array(_('Unit'),'left',9),
                        'timestamp' => array(_('Time Stamp'),'left',19),        
                        'code' => array(_('Code'),'left',7),            
                        'attendance_string1' => array(_('Issue'),'left',12),
                        'gate_code' => array(_('Gate Code'),'left',10),
                        'employee_confirmed' => array(_('Emp Conf.'),'left',6),
                        'employee_comments' => array(_('Employee Comments'),'left',20),    
                        'superior_confirmed' => array(_('Sup Conf.'),'left',6),    
                        'superior_comments' => array(_('Superior Comments'),'left',20),    
			//'type' => array(_('Allowance Type'),'left',18,array('0' => 'Company Based', '1' => 'Government Based'))
);
//----init the pdf writer---------
$rep = pdf_header_start($controller."s",$fields,'A3','L',9);
//----creating pdf main body------
$sql = $attendance_db->search( @$_POST[ 'search_first_name' ],
        @$_POST[ 'search_last_name' ], @$_POST[ 'search_department_id' ],
        @$_POST[ 'search_unit_id' ],
        convert_FA_to_MYSQL( @$_POST[ 'search_datestamp_start' ] ),
        convert_FA_to_MYSQL( @$_POST[ 'search_datestamp_end' ] ),
        @$_POST[ 'search_code' ], @$_POST[ 'search_attendance_string1' ], @$_POST[ 'search_gate_code' ],
        @$_POST[ 'search_employee_confirmed' ],
        @$_POST[ 'search_superior_confirmed' ] );
pdf_body_display($rep,$sql,$fields);
//----end the pdf writer------
pdf_header_end($rep);
?>
