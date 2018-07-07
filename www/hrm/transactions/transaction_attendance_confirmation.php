<?php

//----security and path settings---------
$page_security = 'SA_HRM_ATTENDANCE_CONFIRMATION_ENTRY';
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
$pager = "attendance_confirmation";
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
$controller = "Attendnace Confirmation";
$print_controller = "attendance_profile";
//---loggers----------------
pr( "selected ID = $selected_id and Mode = $Mode" );
pr( $_POST );

//----form specific helper function	
function can_process()
{
    global $controller, $Mode;
    if ( strlen( $_POST[ 'reported_by' ] ) > 0 )
    {
        return
                (!is_empty( $_POST[ 'gate_code' ], 'Superior Response' )) &&
                (!is_empty( $_POST[ 'superior_confirmed' ], 'Superior Confirmation' )) &&
                (!is_empty( $_POST[ 'superior_comments' ], 'Superior Comments' ))
        ;
    }
    else
    {
        return
                (!is_empty( $_POST[ 'gate_code' ], 'Employee Response' )) &&
                (!is_empty( $_POST[ 'employee_confirmed' ], 'Employee Confirmation' )) &&
                (!is_empty( $_POST[ 'employee_comments' ], 'Employee Comments' ))
        ;
    }
}

//---update item--------------
if ( (strcmp( $Mode, 'UPDATE_ITEM' ) == 0) && can_process() )
{
    $attendance_tbl = array( );
    $attendance_db->simple_select( $selected_id, &$attendance_tbl );
    if ( strlen( $_POST[ 'reported_by' ] ) > 0 )
    {
        $rr = $attendance_db->update( $selected_id, array( 'gate_code' => $_POST[ 'gate_code' ], 'superior_confirmed' => $_POST[ 'superior_confirmed' ], 'superior_comments' => $_POST[ 'superior_comments' ] ) );
        if ( $rr )
        {
            update_msg( $controller );
            $Mode = 'RESET';
        }
    }
    else
    {
        if ( strcmp( $attendance_tbl[ 'superior_confirmed' ], attendance_model::CONFIRMED ) == 0 )
        {
            $msg = _( "Your Superior has already confirmed this entry. This cannot be updated" )
                    . "<br>" . _( "Please contact your superior to resolve this issue." );
            display_error( $msg );
        }
        else
        {
            $attendance_db->update( $selected_id, array( 'gate_code' => $_POST[ 'gate_code' ], 'employee_confirmed' => $_POST[ 'employee_confirmed' ], 'employee_comments' => $_POST[ 'employee_comments' ] ) );
            update_msg( $controller );
            $Mode = 'RESET';
        }
    }
}
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

    new_headers_start( $controller . "s", 1, 'Select Attendance Month & Year' );
    label_row( "First Name", $employee_personal_tbl[ 'first_name' ], "", "style = 'padding-left: 8px;'" );
    label_row( "Last Name", $employee_personal_tbl[ 'last_name' ], "", "style = 'padding-left: 8px;'" );
    label_row( "Designation", $designation_tbl[ 'name' ], "", "style = 'padding-left: 8px;'" );
    label_row( "Department", $department_tbl[ 'name' ], "", "style = 'padding-left: 8px;'" );
    label_row( "Unit", $unit_tbl[ 'name' ], "", "style = 'padding-left: 8px;'" );
    //-----------
    row_start();
    $arr = array( 'employee_id' => null, 'first_name' => null, 'reports_to' => array( 'table' => $prefix . 'employee', 'label' => 'reports_to', 'value' => array( array( 'value' => $employee_id, 'operator' => '=', 'label' => 'reports_to', 'attachment' => 'and' ) ) ), 'employee_status_id' => array( 'table' => $prefix . 'employee', 'label' => 'employee_status_id', 'value' => array( array( 'value' => EMPLOYEE_CONFIRMATION, 'operator' => '<=', 'label' => 'employee_status_id', 'attachment' => 'and' ) ) ) );
    multiple_array_selector( 'reported_by', _( "Reported By" ), $employee_db->search_advanced( $arr ), 0 );
    row_end();
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
    //----------------------------
    if ( $selected_id != -1 )
    {
        if ( strcmp( $Mode, 'Edit' ) == 0 )
        {
            
            $tpost = array( );
            $attendance_db->simple_select( $selected_id, &$tpost );
            if ( strcmp( $tpost[ 'gate_code' ], attendance_model::NA ) == 0 )
            {//this entry cannot be edited
                $msg = _( "This entry has no associated issue. Cannot be updated." )
                        . "<br>" . _( "if this is not the case, then please contact your System Adminstrator to resolve this issue." );
                display_error( $msg );
            }
            else
            {
                $attendance_db->simple_select( $selected_id, &$_POST );
                new_headers_start( $controller . "s", 1, 'Edit Attendance Entry' );
                label_row( "Scan Time", $_POST[ 'timestamp' ], "", "style = 'padding-left: 8px;'" );
                label_row( "Issue Start Time", $_POST[ 'gate_out' ], "", "style = 'padding-left: 8px;'" );
                label_row( "Issue End Time", $_POST[ 'gate_in' ], "", "style = 'padding-left: 8px;'" );
                label_row( "Possible Issue", $_POST[ 'attendance_string1' ], "", "style = 'padding-left: 8px;'" );
                if ( strlen( $_POST[ 'reported_by' ] ) > 0 )
                {
                    label_row( "Employee Confirmation", $_POST[ 'employee_confirmed' ], "", "style = 'padding-left: 8px;'" );
                    label_row( "Employee Comments", $_POST[ 'employee_comments' ], "", "style = 'padding-left: 8px;'" );
                }
                row_start();
                multiple_array_selector( 'gate_code', _( "Employee Response" ), $attendance_db->response, 0, 0 );
                row_end();
                if ( strlen( $_POST[ 'reported_by' ] ) > 0 )
                {
                    textarea_row( _( "Superior Comments:" ), 'superior_comments', @$_POST[ 'employee_comments' ], 35, 5 );
                    row_start();
                    multiple_array_selector( 'superior_confirmed', _( "Superior Response Confirmed" ), $attendance_db->con_arr, 0, 0 );
                    row_end();
                }
                else
                {
                    textarea_row( _( "Employee Comments:" ), 'employee_comments', @$_POST[ 'employee_comments' ], 35, 5 );
                    row_start();
                    multiple_array_selector( 'employee_confirmed', _( "Employee Response Confirmed" ), $attendance_db->con_arr, 0, 0 );
                    row_end();
                }
                new_headers_end( $selected_id, 1 );
                hidden( 'selected_id', $selected_id );
            }
            
        }
    }
    //------------------------------------
    if ( strlen( $_POST[ 'attendance_month' ] ) > 0 )
    {
        br( 2 );
        if ( strlen( $_POST[ 'reported_by' ] ) > 0 )
        {
            $attendance_db->update_employee_attendance( $_POST[ 'reported_by' ], $_POST[ 'attendance_month' ] . '-01 00:00:00', $_POST[ 'attendance_month' ] . '-31 00:00:00' );
            //----start the pager section of the page---------
            $sql = $attendance_db->search_by_month_for_superior( $_POST[ 'attendance_month' ], $_POST[ 'reported_by' ],!(@$_POST['issue_entries']) );
            $th = array( _( "Stamp" ), _( "Code" ), _( "Issue" ), _( "Response" ), _( "Issue Start Time" ), _( "Issue End Time" ), _( "D/O-(Min)" ), _( "Emp Conf." ), _( "Emp Comnts" ), _( "Sup Conf." ), _( "Sup Comnts." ) );
            pager_display( $print_controller, $th, $sql, "90%", $controller, 'edit_link', null, null, null, true, "/hrm/reports/", 'Confirm Attendance Records [Superior Mode]', 60 );
            //pager_display($name,$th,$sql,$table_width,$hidden_marker,$edit_mode = 'edit_link', $delete_mode = 'delete_link', $print_mode = null, $card_mode = null, $allow_print = false, $path = "", $heading = null,$table_records = null)
            //----end the pager---------
        }
        else
        {
            $attendance_db->update_employee_attendance( $employee_id, $_POST[ 'attendance_month' ] . '-01 00:00:00', $_POST[ 'attendance_month' ] . '-31 00:00:00' );
            //----start the pager section of the page---------
            $sql = $attendance_db->search_by_month_for_employee( $_POST[ 'attendance_month' ], $employee_id, !(@$_POST['issue_entries']) );
            $th = array( _( "Stamp" ), _( "Code" ), _( "Issue" ), _( "Response" ), _( "Issue Start Time" ), _( " Issue End Time" ), _( "D/O-(Min)" ), _( "Emp Conf." ), _( "Emp Comnts." ), _( "Sup Conf." ), _( "Sup Comnts." ) );
            pager_display( $print_controller, $th, $sql, "90%", $controller, 'edit_link', null, null, null, true, "/hrm/reports/", 'Confirm Attendance Records [Employee Mode]', 60 );
            //pager_display($name,$th,$sql,$table_width,$hidden_marker,$edit_mode = 'edit_link', $delete_mode = 'delete_link', $print_mode = null, $card_mode = null, $allow_print = false, $path = "", $heading = null,$table_records = null)
            //----end the pager---------	
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