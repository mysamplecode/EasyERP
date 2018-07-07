<?php

//----security and path settings---------
$page_security = 'SA_HRM_EMPLOYEE_ATTENDANCE_REPORT';
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
$pager = "attendance_profile";
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
//----get paramaters--------------
//----message controller----
$controller = "Employee Monthly Attendance";
$print_controller = "employee_transaction";
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
new_headers_start( $controller . "s", 1, "Employee Monthly Attendance Views" );
row_start();
$arr = array( 'unit_id' => null, 'name' => null );
multiple_array_selector( 'unit_id', _( "Unit" ), $unit_db->search_advanced( $arr ), 0 );
row_end();
row_start();
$arr = array( 'department_id' => null, 'name' => null, 'unit_id' => $_POST[ 'unit_id' ] );
multiple_array_selector( 'department_id', _( "Department" ), $department_db->search_advanced( $arr, array( 'enable_where' => 1 ) ), 0 );
row_end();
row_start();
$arr = array( 'employee_id' => null, 'first_name' => null, 'unit_id' => $_POST[ 'unit_id' ], 'department_id' => $_POST[ 'department_id' ], 'employee_status_id' => array( 'table' => $prefix . 'employee', 'label' => 'employee_status_id', 'value' => array( array( 'value' => EMPLOYEE_CONFIRMATION, 'operator' => '<=', 'label' => 'employee_status_id', 'attachment' => 'and' ) ) ) );
multiple_array_selector( 'employee_id', _( "Employee" ), $employee_db->search_advanced( $arr, array( 'enable_where' => 1 ) ), 0 );
row_end();

if ( $_POST[ 'employee_id' ] > 0 )
{
    $employee_id = $_POST[ 'employee_id' ];
    $employee_db->select( $employee_id, employee_model::PERSONAL, $employee_personal_tbl );
    $designation_db->select( $employee_personal_tbl[ 'designation_id' ], $designation_tbl );
    $department_db->select( $employee_personal_tbl[ 'department_id' ], $department_tbl );
    $unit_db->select( $employee_personal_tbl[ 'unit_id' ], $unit_tbl );

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
}
//-----------------------------------------------------
new_headers_end( $selected_id, 0 );
//------------------------------------
if ( strlen( $_POST[ 'attendance_month' ] ) > 0 )
{
    br( 2 );
    $attendance_db->update_employee_attendance( $employee_id, $_POST[ 'attendance_month' ] . '-01 00:00:00', $_POST[ 'attendance_month' ] . '-31 00:00:00' );
    //----start the pager section of the page---------
    $sql = $attendance_db->search_by_month_for_employee( $_POST[ 'attendance_month' ], $employee_id, !(@$_POST['issue_entries']));
    $th = array( _( "Scan Stamp" ), _( "Gate Code" ), _( "Possible Issue" ), _( "Response" ), _( "Start Time" ), _( "End Time" ), _( "Delay (Mins)" ), _( "Confirmed" ), _( "Comments" ) );
    pager_display( $pager, $th, $sql, "80%", $controller, 'edit_link', null, null, null, true, "/hrm/reports/", 'Confirm Attendance Records [Employee Mode]', 60 );
    //pager_display($name,$th,$sql,$table_width,$hidden_marker,$edit_mode = 'edit_link', $delete_mode = 'delete_link', $print_mode = null, $card_mode = null, $allow_print = false, $path = "", $heading = null,$table_records = null)
    //----end the pager---------	
}
page_end();
?>