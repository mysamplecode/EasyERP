<?php

//----security and path settings---------
$page_security = 'SA_HRM_ATTENDANCE';
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

//----form specific helper function
function can_process()
{
    global $controller, $Mode;
    return
            (!is_empty( $_POST[ 'unit_id' ], 'Unit' )) &&
            (!is_empty( $_POST[ 'department_id' ], 'Department' )) &&
            (!is_empty( $_POST[ 'employee_id' ], 'Employee' )) &&
            (!is_empty( $_POST[ 'timestamp' ], 'Time Stamp' )) &&
            (!is_empty( $_POST[ 'datestamp' ], 'Date Stamp' )) &&
            //(!is_empty( $_POST[ 'gate_code' ], 'Gate Code' )) &&
            (is_time( $_POST[ 'timestamp' ], 'Time Stamp' )) &&
            (is_date( $_POST[ 'datestamp' ], 'Date Stamp' ))
    ;
}

//---add item----------------
if ( (strcmp( $Mode, 'ADD_ITEM' ) == 0) && can_process() )
{
    $flag = $attendance_db->manual_insert( $_POST );
    if ( $flag == 1 )
    {
        add_msg( $controller );
        $Mode = 'RESET';
    }
    else
    {
        set_focus( 'name' );
    }
}
//---reset the page------------
if ( strcmp( $Mode, 'RESET' ) == 0 )
{
    refresh_pager( $pager );
    $selected_id = -1;
    unset( $_POST );
}
//---set the HTML----------
page_start( $controller . "s" );
//----start the new section of the page-----
//----a wanring for this form as this is very sensitive
//display_warning( "This form is only for System Adminstrators. Please use with extreme caution." );

new_headers_start( $controller . "s" );

row_start();
$arr = array( 'unit_id' => null, 'name' => null );
multiple_array_selector( 'unit_id', _( "Unit" ), $unit_db->search_advanced( $arr ), 0 );
row_end();
row_start();
$arr = array( 'department_id' => null, 'name' => null, 'unit_id' => $_POST[ 'unit_id' ] );
multiple_array_selector( 'department_id', _( "Department" ), $department_db->search_advanced( $arr, array( 'enable_where' => 1 ) ), 0 );
row_end();
row_start();
$arr = array( 'employee_id' => null, 'first_name' => null, 'unit_id' => $_POST[ 'unit_id' ], 'department_id' => $_POST[ 'department_id' ] , 'employee_status_id' => array( 'table' => $prefix . 'employee', 'label' => 'employee_status_id', 'value' => array( array( 'value' => EMPLOYEE_CONFIRMATION, 'operator' => '<=', 'label' => 'employee_status_id', 'attachment' => 'and' ) ) ));
multiple_array_selector( 'employee_id', _( "Employee" ), $employee_db->search_advanced( $arr, array( 'enable_where' => 1 ) ), 0 );
row_end();
if ( $_POST[ 'employee_id' ] > 0 )
{
    date_row( "Date Stamp", 'datestamp' );
    time_row( "Time Stamp", 'timestamp' );
}
new_headers_end( -1 );
page_end();
?>