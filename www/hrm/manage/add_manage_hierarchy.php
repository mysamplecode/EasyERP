<?php

//----security and path settings---------
$page_security = 'SA_HRM_HIERARCHY';
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
$pager = "hierarchy_tbl";
$pager1 = "not_hierarchy_tbl";
//----Database model defined--------
$unit_db = new unit_model();
$department_db = new department_model();
$employee_db = new employee_model();
//----transaction code--------------
$transaction_code = employee_model::HIERARCHY;
//----message controller----
$controller = "Hierarchy";
$print_controller = "employee_transaction";
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
            (!is_empty( $_POST[ 'reports_to' ], 'Report to Employee' )) &&
            (
            1
            )
    ;
}

//---add item----------------
if ( (strcmp( $Mode, 'ADD_ITEM' ) == 0) && can_process() )
{
    $flag = $employee_db->update( $_POST[ 'employee_id' ], $transaction_code, $_POST );
    if ( $flag == true )
    {
        add_msg( $controller );
        $Mode = 'RESET';
    }
    else
    {
        duplicate_msg( $controller );
        set_focus( 'name' );
    }
}
//---update item--------------
if ( (strcmp( $Mode, 'UPDATE_ITEM' ) == 0) && can_process() )
{
    $employee_db->update( $selected_id, $transaction_code, $_POST );
    update_msg( $controller );
    $Mode = 'RESET';
}
//---delete item--------------
if ( strcmp( $Mode, 'Delete' ) == 0 )
{ //need to fill in later on
    if ( 0 )
    {
        //if (key_in_foreign_table($selected_id, '', ''))
        delete_error_msg( $controller, 'Fiscal Leave' );
        $Mode = 'RESET';
    }
    else
    {
        $flag = $employee_db->delete( $selected_id, $transaction_code );
        if ( $flag )
        {
            delete_msg( $controller );
            $Mode = 'RESET';
        }
    }
}
//---reset the page------------
if ( strcmp( $Mode, 'RESET' ) == 0 )
{
    refresh_pager( $pager );
    refresh_pager( $pager1 );
    $selected_id = -1;
    unset( $_POST );
}
//---set the HTML----------
page_start( $controller . "s" );
//----start the new section of the page-----
new_headers_start( $controller . "s" );
if ( $selected_id != -1 )
{
    if ( strcmp( $Mode, 'Edit' ) == 0 )
    {
        $employee_db->select( $selected_id, $transaction_code, &$_POST );
    }
    hidden( 'selected_id', $selected_id );
}
row_start();
$arr = array( 'unit_id' => null, 'name' => null );
multiple_array_selector( 'unit_id', _( "Unit" ), $unit_db->search_advanced( $arr ), 0 );
row_end();
row_start();
$arr = array( 'department_id' => null, 'name' => null, 'unit_id' => $_POST[ 'unit_id' ] );
multiple_array_selector( 'department_id', _( "Department" ), $department_db->search_advanced( $arr, array( 'enable_where' => 1 ) ), 0 );
row_end();
row_start();
$arr = array
( 
    'employee_id' => null, 
    'first_name' => null, 
    'unit_id' => $_POST[ 'unit_id' ], 
    'department_id' => $_POST[ 'department_id' ], 
    'employee_status_id' =>  array('table' => $prefix.'employee', 'label' => 'employee_status_id', 'value' => array(array('label' => 'employee_status_id','value' => EMPLOYEE_CONFIRMATION, 'operator' => '<=', 'attachment' => 'and')))//EMPLOYEE_CONFIRMATION
);
multiple_array_selector( 'employee_id', _( "Employee" ), $employee_db->search_advanced( $arr, array( 'enable_where' => 1 ) ), 0 );
row_end();
if ( $_POST[ 'employee_id' ] > 0 )
{
    $selected_id = $_POST[ 'employee_id' ];
    hidden( 'selected_id', $selected_id );

    row_start();
    $arr = array( 'unit_id' => null, 'name' => null );
    multiple_array_selector( 'report_to_unit_id', _( "Report To Unit" ), $unit_db->search_advanced( $arr ), 0 );
    row_end();
    row_start();
    $arr = array( 'department_id' => null, 'name' => null, 'unit_id' => $_POST[ 'report_to_unit_id' ] );
    multiple_array_selector( 'report_to_department_id', _( "Report To Department" ), $department_db->search_advanced( $arr, array( 'enable_where' => 1 ) ), 0 );
    row_end();
    $arr = array
        (
        'employee_id' =>
        array
            (
            'table' => $prefix . 'employee',
            'label' => 'employee_id',
            'value' => array
                (
                array
                    (
                    'value' => $_POST[ 'employee_id' ],
                    'operator' => '!=',
                    'label' => 'employee_id',
                    'attachment' => 'and'
                )
            )
        ),
        'first_name' => null,
        'reports_to' => array
            (
            'table' => $prefix . 'employee',
            'label' => 'reports_to',
            'value' => array
                (
                array
                    (
                    'value' => 'null',
                    'operator' => 'is',
                    'label' => 'reports_to',
                    'attachment' => 'or',
                    'force_numeric' => 1
                ),
                array
                    (
                    'value' => $_POST[ 'employee_id' ],
                    'operator' => '!=',
                    'label' => 'reports_to',
                    'attachment' => 'and'
                )
            )
        ),
        'department_id' => $_POST[ 'report_to_department_id' ],
        'unit_id' => $_POST[ 'report_to_unit_id' ],
        'employee_status_id' =>  array('table' => $prefix.'employee', 'label' => 'employee_status_id', 'value' => array(array('label' => 'employee_status_id','value' => EMPLOYEE_CONFIRMATION, 'operator' => '<=', 'attachment' => 'and')))//EMPLOYEE_CONFIRMATION
    );
    multiple_array_selector( 'reports_to', _( "Reports To" ), $employee_db->search_advanced( $arr ), 0 );
    row_end();
    if ( $_POST[ 'reports_to' ] > 0 )
    {
        $employee_personal_tbl = array( );
        $department_tbl = array( );
        $unit_tbl = array( );
        $designation_tbl = array( );

        $designation_db = new designation_model();
        $employee_db = new employee_model();
        $department_db = new department_model();
        $unit_db = new unit_model();

        $employee_db->select( $_POST[ 'reports_to' ], employee_model::PERSONAL, $employee_personal_tbl );
        $designation_db->select( $employee_personal_tbl[ 'designation_id' ], $designation_tbl );
        $department_db->select( $employee_personal_tbl[ 'department_id' ], $department_tbl );
        $unit_db->select( $employee_personal_tbl[ 'unit_id' ], $unit_tbl );
        label_row( "First Name", $employee_personal_tbl[ 'first_name' ], "", "style = 'padding-left: 8px;'" );
        label_row( "Last Name", $employee_personal_tbl[ 'last_name' ], "", "style = 'padding-left: 8px;'" );
        label_row( "Designation", $designation_tbl[ 'name' ], "", "style = 'padding-left: 8px;'" );
        label_row( "Department", $department_tbl[ 'name' ], "", "style = 'padding-left: 8px;'" );
        label_row( "Unit", $unit_tbl[ 'name' ], "", "style = 'padding-left: 8px;'" );
    }
    row_start();
    $arr = array
    ( 
        'employee_id' => null, 
        'first_name' => null, 
        'reports_to' => array( 'table' => $prefix . 'employee', 'label' => 'reports_to', 'value' => array( array( 'value' => $_POST[ 'employee_id' ], 'operator' => '=', 'label' => 'reports_to', 'attachment' => 'and' ) ) ), 
        'employee_status_id' =>  array('table' => $prefix.'employee', 'label' => 'employee_status_id', 'value' => array(array('label' => 'employee_status_id','value' => EMPLOYEE_CONFIRMATION, 'operator' => '<=', 'attachment' => 'and')))
    );
    multiple_array_selector( 'reported_by', _( "Reported By" ), $employee_db->search_advanced( $arr ), 0 );
    row_end();
}
new_headers_end( $selected_id );
//----start the search and print section of the page------------
search_headers_start( $controller . "s", 1, 0 );

row_start();
ref_cells( _( "$controller First Name" ), 'search_first_name', '', null, '', true );
row_end();

row_start();
ref_cells( _( "$controller Last Name" ), 'search_last_name', '', null, '', true );
row_end();

row_start();
$arr = array( 'name' => null );
multiple_array_selector( 'search_unit_id', _( "Unit" ), $unit_db->search_advanced( $arr ), 0 );
row_end();

row_start();
$arr = array( 'name' => null );
multiple_array_selector( 'search_department_id', _( "Department" ), $department_db->search_advanced( $arr ), 0 );
row_end();

search_headers_end( 1, 0, 0 );
//----start the pager section of the page---------
$th = array( _( "First Name" ), _( "Last Name" ), _( "Department" ), _( "Unit" ) );
$arr = array
    (
    'first_name' => $_POST[ 'search_first_name' ],
    'last_name' => $_POST[ 'search_last_name' ],
    'department_id' => array( 'table' => $prefix . 'department', 'label' => 'name', 'value' => $_POST[ 'search_department_id' ] ),
    'unit_id' => array( 'table' => $prefix . 'unit', 'label' => 'name', 'value' => $_POST[ 'search_unit_id' ] ),
    'reports_to' => array( 'table' => $prefix . 'employee', 'label' => 'reports_to', 'value' => array( array( 'force_numeric' => 1, 'value' => 'null', 'operator' => 'is', 'label' => 'reports_to', 'attachment' => 'or' ), array( 'value' => 0, 'operator' => '=', 'label' => 'reports_to', 'attachment' => 'and' ) ) ),
    'employee_status_id' =>  array('table' => $prefix.'employee', 'label' => 'employee_status_id', 'value' => array(array('label' => 'employee_status_id','value' => EMPLOYEE_CONFIRMATION, 'operator' => '<=', 'attachment' => 'and'))),
    'employee_id' => null
);
$sql = $employee_db->search_advanced( $arr );
pager_display( $pager, $th, $sql, "80%", $controller, 'edit_link', null, null, null, false, '', _( 'Un-Assigned Employees' ) );
br( 1 );
//----start the pager section of the page---------
$th = array( _( "First Name" ), _( "Last Name" ), _( "Department" ), _( "Unit" ) );
$arr = array
    (
    'first_name' => $_POST[ 'search_first_name' ],
    'last_name' => $_POST[ 'search_last_name' ],
    'department_id' => array( 'table' => $prefix . 'department', 'label' => 'name', 'value' => $_POST[ 'search_department_id' ] ),
    'unit_id' => array( 'table' => $prefix . 'unit', 'label' => 'name', 'value' => $_POST[ 'search_unit_id' ] ),
    'reports_to' => array( 'table' => $prefix . 'employee', 'label' => 'reports_to', 'value' => array( array( 'force_numeric' => 1, 'value' => 'null', 'operator' => 'is not ', 'label' => 'reports_to', 'attachment' => 'and' ), array( 'value' => 0, 'operator' => '!=', 'label' => 'reports_to', 'attachment' => 'and' ) ) ),
    'employee_status_id' =>  array('table' => $prefix.'employee', 'label' => 'employee_status_id', 'value' => array(array('label' => 'employee_status_id','value' => EMPLOYEE_CONFIRMATION, 'operator' => '<=', 'attachment' => 'and'))),
    'employee_id' => null
);
$sql = $employee_db->search_advanced( $arr );
pager_display( $pager1, $th, $sql, "80%", $controller, 'edit_link', 'delete_link', null, null, false, '', _( 'Assigned Employees' ) );
//-----------------------------------------------------
page_end();
?>