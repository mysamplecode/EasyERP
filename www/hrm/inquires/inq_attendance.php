<?php

//----security and path settings---------
$page_security = 'SA_HRM_ATTENDANCE_REPORT';
$path_to_root = "../..";
//----include files------------
include_once($path_to_root . "/includes/db_pager.inc");
include_once($path_to_root . "/includes/session.inc");
include_once($path_to_root . "/includes/ui.inc");
include_once($path_to_root . "/includes/validation.inc");
include_once($path_to_root . "/includes/plusql.inc");
include_once($path_to_root . "/hrm/models/hrm_db.inc");
//----date picker JS-------
$js = get_js_date_picker();
add_js_source( $js );
add_js_file( "jquery.js" );
add_js_file( "jqueryui.js" );
add_js_file( "time_picker.js" );
//----page start-----------
simple_page_mode( true );
//----pager defined--------
$pager = "attendance_tbl";
//----Database model defined--------
$unit_db = new unit_model();
$department_db = new department_model();
$employee_db = new employee_model();
$attendance_db = new attendance_model();
//----transaction code--------------
//----message controller----
$controller = "Attendance";
//---loggers----------------
pr( "selected ID = $selected_id and Mode = $Mode" );
pr( $_POST );

//---print item---------------
if ( isset( $_POST[ 'PrintOrders' ] ) )
{
    $rep_file = find_custom_file( "/hrm/reports/rep_" . strtolower( $controller ) . ".php" );
    if ( $rep_file )
    {
        require($rep_file);
    }
    die();
}
//---set the HTML----------
page_start( $controller . "s" );
//----start the search and print section of the page------------
search_headers_start( $controller . "s", 1, 1 );

row_start();
$arr = array( 'unit_id' => null, 'name' => null );
multiple_array_selector( 'search_unit_id', _( "Unit" ), $unit_db->search_advanced( $arr ), 0 );
check_cells( "", "print_unit_id", 1 );
row_end();

row_start();
$arr = array( 'department_id' => null, 'name' => null, 'unit_id' => $_POST[ 'search_unit_id' ] );
multiple_array_selector( 'search_department_id', _( "Department" ), $department_db->search_advanced( $arr ), 0 );
check_cells( "", "print_department_id", 1 );
row_end();

$employee_id = null;
if ( !is_null( $_POST[ 'search_first_name' ] ) && !empty( $_POST[ 'search_first_name' ] ) )
{
    $employee_id = $_POST[ 'search_first_name' ];
}
else if ( !is_null( $_POST[ 'search_last_name' ] ) && !empty( $_POST[ 'search_last_name' ] ) )
{
    $employee_id = $_POST[ 'search_last_name' ];
}
else
{
    
}

row_start();
$arr = array( 'employee_id' => $employee_id, 'first_name' => null, 'unit_id' => @$_POST[ 'search_unit_id' ], 'department_id' => @$_POST[ 'search_department_id' ] );
multiple_array_selector( 'search_first_name', _( "Employee first name" ), $employee_db->search_advanced( $arr ), 0 );
check_cells( "", "print_first_name", 1 );
row_end();

row_start();
$arr = array( 'employee_id' => $employee_id, 'last_name' => null, 'unit_id' => @$_POST[ 'search_unit_id' ], 'department_id' => @$_POST[ 'search_department_id' ] );
multiple_array_selector( 'search_last_name', _( "Employee last name" ), $employee_db->search_advanced( $arr ), 0 );
check_cells( "", "print_last_name", 1 );
row_end();

row_start();
date_cells( "Start Date", 'search_datestamp_start' );
check_cells( "", "print_datestamp_start", 1 );
row_end();

row_start();
date_cells( "End Date", 'search_datestamp_end' );
check_cells( "", "print_datestamp_end", 1 );
row_end();

row_start();
label_cell( "Time Stamp" );
label_cell( "Print Time Stamp" );
check_cells( "", "print_timestamp", 1 );
row_end();


row_start();
multiple_array_selector( 'search_code', 'Attendance Code', $attendance_db -> gate_code, 0, 0 );
check_cells( "", "print_code", 1 );
row_end();

row_start();
multiple_array_selector( 'search_attendance_string1', _( "Possible Issue" ), $attendance_db -> issues, 0, 0 );
check_cells( "", "print_attendance_string1", 1 );
row_end();

row_start();
multiple_array_selector( 'search_gate_code', _( "Gate Code" ), $attendance_db -> reponses, 0, 0 );
check_cells( "", "print_gate_code", 1 );
row_end();

row_start();
multiple_array_selector( 'search_employee_confirmed', _( "Employee Response Confirmed" ), $attendance_db -> con_arr, 0, 0 );
check_cells( "", "print_employee_confirmed", 1 );
row_end();

row_start();
label_cell( "Employee Comments" );
label_cell( "Print Employee Comments" );
check_cells( "", "print_employee_comments", 1 );
row_end();

row_start();
multiple_array_selector( 'search_superior_confirmed', _( "Superior Response Confirmed" ), $attendance_db -> con_arr, 0, 0 );
check_cells( "", "print_superior_confirmed", 1 );
row_end();

row_start();
label_cell( "Superior Comments" );
label_cell( "Print Superior Comments" );
check_cells( "", "print_superior_comments", 1 );
row_end();

search_headers_end( 1, 1, 0 );
//----start the pager section of the page---------
$th = array( _( "First Name" ), _( "Last Name" ), _( "Department" ), _( "Unit" ), _( "Time Stamp" ), _( "Code" ), _( "Possible Issue" ), _( "Gate Code" ), _( "Employee Confirmed" ), _( "Employee Comments" ), _( "Superior Confirmed" ), _( "Superior Comments" ) );
$sql = $attendance_db->search( @$_POST[ 'search_first_name' ], @$_POST[ 'search_last_name' ], @$_POST[ 'search_department_id' ], @$_POST[ 'search_unit_id' ], convert_FA_to_MYSQL( @$_POST[ 'search_datestamp_start' ] ), convert_FA_to_MYSQL( @$_POST[ 'search_datestamp_end' ] ), @$_POST[ 'search_code' ], @$_POST[ 'search_attendance_string1' ], @$_POST[ 'search_gate_code' ], @$_POST[ 'search_employee_confirmed' ], @$_POST[ 'search_superior_confirmed' ] );
pager_display( $pager, $th, $sql, "98%", $controller, null, null, null, null, false, "", _( 'Attendance Records' ), 31 );
//-----------------------------------------------------
page_end();
?>