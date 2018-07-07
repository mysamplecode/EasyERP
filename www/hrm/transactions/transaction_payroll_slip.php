<?php

//----security and path settings---------
$page_security = 'SA_HRM_PAYROLL_SLIP';
$path_to_root = "../..";
//----include files------------
include_once($path_to_root . "/includes/db_pager.inc");
include_once($path_to_root . "/includes/session.inc");
include_once($path_to_root . "/includes/ui.inc");
include_once($path_to_root . "/includes/validation.inc");
include_once($path_to_root . "/includes/plusql.inc");
include_once($path_to_root . "/hrm/models/hrm_db.inc");
//----page start-----------
simple_page_mode( true );
//----pager defined--------
$pager = "payroll_profile";
//----Database model defined--------
$employee_personal_tbl = array( );
$department_tbl = array( );
$unit_tbl = array( );
$designation_tbl = array( );

$attendance_db = new attendance_model();
$designation_db = new designation_model();
$employee_db = new employee_model();
$department_db = new department_model();
$unit_db = new unit_model();
$employee_payroll_db = new employee_payroll_model();
$employee_transaction_db = new employee_transaction_model();
//----get paramaters--------------
//----message controller----
$controller = "Payroll Slip";
$print_controller = "payroll_profile";
//---loggers----------------
pr( "selected ID = $selected_id and Mode = $Mode" );
pr( $_POST );
//---reset the page------------
if ( strcmp( $Mode, 'RESET' ) == 0 )
{
    refresh_pager( $pager );
    $selected_id = -1;
    //unset($_POST); 
}
//---set the HTML----------	
page_start( $controller . "s" );
//----start the new section of the page-----
$user = get_user( $_SESSION[ "wa_current_user" ]->user );
$employee_id = $user[ 'employee_id' ];
if ( $employee_id )
{
    $_POST['employee_id'] = $employee_id;
    $employee_db->select( $employee_id, employee_model::PERSONAL, $employee_personal_tbl );
    $designation_db->select( $employee_personal_tbl[ 'designation_id' ], $designation_tbl );
    $department_db->select( $employee_personal_tbl[ 'department_id' ], $department_tbl );
    $unit_db->select( $employee_personal_tbl[ 'unit_id' ], $unit_tbl );

    new_headers_start( $controller . "s", 1, 'Payroll Slip' );
    label_row( "First Name", $employee_personal_tbl[ 'first_name' ], "", "style = 'padding-left: 8px;'" );
    label_row( "Last Name", $employee_personal_tbl[ 'last_name' ], "", "style = 'padding-left: 8px;'" );
    label_row( "Designation", $designation_tbl[ 'name' ], "", "style = 'padding-left: 8px;'" );
    label_row( "Department", $department_tbl[ 'name' ], "", "style = 'padding-left: 8px;'" );
    label_row( "Unit", $unit_tbl[ 'name' ], "", "style = 'padding-left: 8px;'" );
    //-----------
    $company = get_company_prefs();
    row_start();
    multiple_array_selector( 'attendance_month', _( "Attendance Month" ), $attendance_db->search_fiscal_months( $company[ 'f_year' ] ), 0, 0 );
    row_end();
    row_start();
    label_cell('Show Detailed View');
    check_cells("", "issue_entries", @$_POST['issue_entries'],true);
    row_end();
    new_headers_end( $selected_id, 0 );
    //------------------------------------
    if ( strlen( $_POST[ 'attendance_month' ] ) > 0 )
    {
        $post = array();
        list($year,$month) = explode('-',$_POST[ 'attendance_month' ]);
        $mname = getdate(strtotime(strtotime($_POST[ 'attendance_month' ].'-01')));
        if($employee_transaction_db ->select_advanced( EMPLOYEE_PAYROLL, array('transaction_string2' => $year, 'transaction_string1' => $mname['month'], 'employee_id' => $employee_id), $post, array('enable_where' => 1)))
        {
            
        }
        else
        {
            $msg = _( "No Record available for this year & month combination." )
            . "<br>" . _( "Please contact your system administrator for further assistance." );
            display_error( $msg );
        }
    }
}
else
{
    new_headers_start( $controller . "s", 1, 'Select Attendance Month & Year' );
    $msg = _( "HRM settings have not been defined for your user account." )
            . "<br>" . _( "Please contact your system administrator." );
    display_error( $msg );
    new_headers_end( $selected_id, 0 );
}
//-----------------------------------------------------
page_end();
?>