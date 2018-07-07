<?php

//----security and path settings---------
$page_security = 'SA_HRM_EMPLOYEE_ENTRY';
$path_to_root = "../..";
//----include files------------
include_once($path_to_root . "/includes/db_pager.inc");
include_once($path_to_root . "/includes/session.inc");
include_once($path_to_root . "/includes/ui.inc");
include_once($path_to_root . "/includes/validation.inc");
include_once($path_to_root . "/includes/plusql.inc");
include_once($path_to_root . "/hrm/models/hrm_db.inc");
//----paths----------
$path_to_cv = company_path() . '/cv/';
$path_to_picture = company_path() . '/profile_pics/';
//----date picker JS-------
$js = get_js_date_picker();
add_js_source( $js );
//----page start-----------
pr( $_POST );
simple_page_mode( true );
//----pager defined--------
$pager = "employee_tbl";
//----Database model defined--------
$employee_db = new employee_model();
$unit_db = new unit_model();
$department_db = new department_model();
$designation_db = new designation_model();
//----message controller----
$controller = "Employee";
//---loggers----------------
pr( "selected ID = $selected_id and Mode = $Mode" );
//---set the HTML----------	
page_start( $controller . "s", true );
//---delete item--------------
if ( strcmp( $Mode, 'Delete' ) == 0 )
{
    if ( 0 )
    //if (key_in_foreign_table($selected_id, '', ''))
    {
        delete_error_msg( $controller, 'Fiscal Leave' );
        $Mode = 'RESET';
    }
    else
    {
        $employee_db->delete( $selected_id );
        delete_msg( $controller );
        $Mode = 'RESET';
    }
}
//---print item---------------
if ( isset( $_POST[ 'CardOrders' ] ) )
{
    pr( "now i m here" );
    $rep_file = find_custom_file( "/hrm/reports/rep_" . strtolower( $controller ) . ".php" );
    if ( $rep_file )
    {
        pr( "going to print the cards" );
        require($rep_file);
    }
    die();
}
//---print ID Card or employee profile-----------
if ( $selected_id != -1 )
{
    if ( (strcmp( $Mode, 'Card' ) == 0) || (strcmp( $Mode, 'Print' ) == 0) )
    {
        $rep_file = find_custom_file( "/hrm/reports/rep_" . strtolower( $controller ) . ".php" );
        if ( $rep_file )
        {
            require($rep_file);
        }
        die();
    }
}
//----start the new section of the page-----
$controller_func = strtolower( $controller );
$args = array( );

$tabs = array
    (
    'personal' => array( _( 'Personal Information' ), $controller_func . '_personal' ),
    'salary_terms' => array( _( 'Salary Information' ), $controller_func . '_salary_term' ),
    'leave' => array( _( 'Assigned Leaves' ), $controller_func . '_leave' ),
    'salary_allowance' => array( _( 'Allowances Informtion' ), $controller_func . '_salary_allowance' ),
    'salary_deduction' => array( _( 'Deductions Informtion' ), $controller_func . '_salary_deduction' ),
    'joining' => array( _( 'Joining Information' ), $controller_func . '_joining' ),
    'qualification' => array( _( 'Qualification Information' ), $controller_func . '_qualification' ),
    'reference' => array( _( 'References Information' ), $controller_func . '_reference' ),
    'dependent' => array( _( 'Dependents Information' ), $controller_func . '_dependent' )
);
new_tabs_start( $controller . "_tabs", $tabs, $selected_id );
new_tabs_end();

//----start the search and print section of the page------------
search_headers_start( $controller . "s", 1, 0 );

row_start();
ref_cells( _( "$controller First Name" ), 'search_first_name', '', null, '', true );
//check_cells("", "print_first_name", 1);
row_end();

row_start();
ref_cells( _( "$controller Last Name" ), 'search_last_name', '', null, '', true );
//check_cells("", "print_last_name", 1);
row_end();

row_start();
$arr = array( 'name' => null );
multiple_array_selector( 'search_unit', _( "Unit" ), $unit_db->search_advanced( $arr ), 0 );
//check_cells("", "print_unit", 1);
row_end();

row_start();
$arr = array( 'name' => null );
multiple_array_selector( 'search_department', _( "Department" ), $department_db->search_advanced( $arr ), 0 );
//check_cells("", "print_department", 1);
row_end();

row_start();
$arr = array( 'name' => null );
multiple_array_selector( 'search_designation', _( "Designation" ), $designation_db->search_advanced( $arr ), 0 );
//check_cells("", "print_designation", 1);
row_end();

search_headers_end( 1, 0, 1 );
//----start the pager section of the page---------
$th = array( _( "$controller First Name" ), _( "$controller Last Name" ), _( "$controller Unit" ), _( "$controller Department" ), _( "$controller Designation" ) );
$sql = $employee_db->search( @$_POST[ 'search_first_name' ], @$_POST[ 'search_last_name' ], @$_POST[ 'search_unit' ], @$_POST[ 'search_department' ], @$_POST[ 'search_designation' ] );
pager_display( $pager, $th, $sql, "60%", $controller, 'edit_link', 'delete_link', 'print_link', 'card_link' );
//----end the page---------
page_end();

//------functions for each of the tabs-----------------
//------------------------------------------------------------------------------------------------------------
function employee_personal( $arr = array( ) )
{
    global $Mode, $selected_id;
    global $path_to_cv;
    global $path_to_picture;
    //----pager defined--------
    $pager = "personal_tbl";
    //----Database model defined--------
    $employee_db = new employee_model();
    $unit_db = new unit_model();
    $department_db = new department_model();
    $designation_db = new designation_model();
    $title_db = new title_model();
    $shift_db = new shift_model();
    $employee_status_db = new employee_status_model();
    //----message controller----
    $controller = "Employee";
    //---loggers----------------
    pr( "selected ID = $selected_id and Mode = $Mode" );

    //---internal functions------
    function can_process()
    {
        return
                (!is_empty( $_POST[ 'first_name' ], 'First Name' )) &&
                (!is_empty( $_POST[ 'last_name' ], 'Last Name' )) &&
                (!is_empty( $_POST[ 'unit_id' ], 'Unit' )) &&
                (!is_empty( $_POST[ 'department_id' ], 'Department' )) &&
                (!is_empty( $_POST[ 'designation_id' ], 'Designation' )) &&
                (!is_empty( $_POST[ 'shift_id' ], 'Shift' )) &&
                (!is_empty( $_POST[ 'title_id' ], 'Title' )) &&
                (!is_empty( $_POST[ 'employee_status_id' ], 'Employee Status' )) &&
                (is_number( $_POST[ 'primary_contact' ], 'Primary Contact' )) &&
                (is_number( $_POST[ 'secondary_contact' ], 'Secondary Contact' )) &&
                (is_date( $_POST[ 'joining_date' ], 'Joining Date' )) &&
                (is_date( $_POST[ 'date_of_birth' ], 'Date of Birth' ))
        ;
    }

    //---add item----------------
    if ( (strcmp( $Mode, 'ADD_ITEM' ) == 0) && can_process() )
    {
        $flag = $employee_db->insert( $employee_db::PERSONAL, $_POST );
        if ( $flag == true )
        {
            add_msg( $controller );
            $Mode = 'Edit';
        }
        else
        {
            duplicate_msg( $controller );
            set_focus( 'unit_id' );
        }
    }
    //---update item--------------
    if ( (strcmp( $Mode, 'UPDATE_ITEM' ) == 0) && can_process() )
    {
        $employee_db->update( $selected_id, $employee_db::PERSONAL, &$_POST );
        update_msg( $controller );
        $Mode = 'Edit';
    }
    //---reset the page------------
    if ( strcmp( $Mode, 'RESET' ) == 0 )
    {
        refresh_pager( $pager );
        $selected_id = -1;
        unset( $_POST );
    }
    //---if we have edit mode
    if ( $selected_id != -1 )
    {
        if ( strcmp( $Mode, 'Edit' ) == 0 )
        {
            $employee_db->select( $selected_id, $employee_db::PERSONAL, &$_POST );
        }
        hidden( 'selected_id', $selected_id );
    }
    display_heading_with_breaks( "Employee Personal Information", 1, 1 );
    start_table( TABLESTYLE );
    row_start();
    {
        cell_start();
        {

            start_table( TABLESTYLE2 );

            row_start();
            $arr = array( 'unit_id' => null, 'name' => null );
            multiple_array_selector( 'unit_id', _( "Unit" ), $unit_db->search_advanced( $arr ), 0 );
            row_end();

            row_start();
            $arr = array( 'department_id' => null, 'name' => null, 'unit_id' => $_POST[ 'unit_id' ] );
            multiple_array_selector( 'department_id', _( "Department" ), $department_db->search_advanced( $arr ), 0 );
            row_end();

            row_start();
            $arr = array( 'designation_id' => null, 'name' => null );
            multiple_array_selector( 'designation_id', _( "Designation" ), $designation_db->search_advanced( $arr ), 0 );
            row_end();

            row_start();
            $arr = array( 'shift_id' => null, 'name' => null );
            multiple_array_selector( 'shift_id', _( "Shift" ), $shift_db->search_advanced( $arr ), 0 );
            row_end();

            row_start();
            $arr = array( 'employee_status_id' => null, 'name' => null );
            multiple_array_selector( 'employee_status_id', _( "Emplpoyee Status" ), $employee_status_db->search_advanced( $arr ), 0 );
            row_end();

            row_start();
            $arr = array( 'title_id' => null, 'name' => null );
            multiple_array_selector( 'title_id', _( "Title" ), $title_db->search_advanced( $arr ), 0 );
            row_end();

            text_row_ex( _( "$controller First Name" ) . ':', 'first_name', 50, 50 );
            text_row_ex( _( "$controller Last Name" ) . ':', 'last_name', 50, 50 );
            text_row_ex( _( "Primary Contact:" ), 'primary_contact', 30, 30 );
            text_row_ex( _( "Secondary Contact:" ), 'secondary_contact', 30, 30 );
            text_row_ex( _( "CNIC:" ), 'cnic', 20, 20 );
            date_row( "Date of Birth", 'date_of_birth' );

            row_start();
            $arr = array( 'Male' => 'Male', 'Female' => 'Female' );
            multiple_array_selector( 'sex', _( "Gender" ), $arr, 0, 0 );
            row_end();

            row_start();
            $arr = array( 'Single' => 'Single', 'Married' => 'Married', 'Divorced' => 'Divorced', 'Widow' => 'Widow', 'Widower' => 'Widower' );
            multiple_array_selector( 'marital_status', _( "Marital Status" ), $arr, 0, 0 );
            row_end();

            row_start();
            $arr = array( 'Urdu' => 'Urdu', 'English' => 'English', 'Punjabi' => 'Punjabi', 'Phasto' => 'Phasto', 'Sindhi' => 'Sindhi', 'Siriaki' => 'Siriaki', 'Blochi' => 'Blochi' );
            multiple_array_selector( 'native_language', _( "Native Language" ), $arr, 0, 0 );
            row_end();

            row_start();
            $arr = array( 'A +' => 'A +', 'B +' => 'B +', 'AB +' => 'AB +', 'O +' => 'O +', 'A -' => 'A -', 'B -' => 'B -', 'AB -' => 'AB -', 'O -' => 'O -' );
            multiple_array_selector( 'blood_group', _( "Blood Group" ), $arr, 0, 0 );
            row_end();

            text_row_ex( _( "Religion:" ), 'religion', 20, 20 );
            text_row_ex( _( "Guardian First Name:" ), 'guardian_first_name', 50, 50 );
            text_row_ex( _( "Guardian Last Name:" ), 'guardian_last_name', 50, 50 );
            text_row_ex( _( "Guardian Relation:" ), 'guardian_relation', 30, 30 );

            date_row( "Joining Date", 'joining_date' );

            $arr = array( 'Allowed' => 'Allowed', 'Not Allowed' => 'Not Allowed' );
            multiple_array_selector( 'overtime', _( "Overtime" ), $arr, 0, 0 );

            end_table();
        }
        cell_end();
        cell_start();
        {

            start_table( TABLESTYLE2 );

            file_row( "Upload CV", "path_to_cv", "path_to_cv", "path_to_cv" );
            display_link_row( "Link to existing upload", "path_to_cv", '' );

            file_row( "Upload Picture", "path_to_picture", "path_to_picture", "path_to_picture" );
            display_image_row( "Existing uploaded image", "path_to_picture", '' );

            textarea_row( _( "Permanent Address:" ), 'permenant_address', @$_POST[ 'permenant_address' ], 35, 5 );
            textarea_row( _( "Temporary Address:" ), 'temporary_address', @$_POST[ 'temporary_address' ], 35, 5 );

            text_row_ex( _( "Domicile:" ), 'domicile', 20, 20 );
            text_row_ex( _( "City:" ), 'city', 20, 20 );
            text_row_ex( _( "Country:" ), 'country', 20, 20 );
            text_row_ex( _( "Nationality:" ), 'nationality', 30, 30 );

            textarea_row( _( "Disabilities if any:" ), 'disability', @$_POST[ 'disability' ], 35, 5 );
            textarea_row( _( "Remarks:" ), 'remarks', @$_POST[ 'remarks' ], 35, 5 );

            end_table();
        }
        cell_end();
    }
    row_end();
    end_table( 1 );
    submit_add_or_update_center( $selected_id == -1, '', 'both' );
    br( 1 );
}

//------------------------------------------------------------------------------------------------------------
function employee_salary_term( $arr = array( ) )
{
    global $Mode, $selected_id;
    //inital check
    if ( $selected_id < 1 )
    {
        display_error( "Please fill and save the personal information" );
        return false;
    }
    //----pager defined--------
    $pager = "salary_terms_tbl";
    //----Database model defined--------
    $employee_db = new employee_model();
    $bank_db = new bank_model();
    //----message controller----
    $controller = "Salary Terms";
    //---loggers----------------
    pr( "selected ID = $selected_id and Mode = $Mode" );

    //---internal functions------
    function can_process()
    {
        return
                (!is_empty( $_POST[ 'basic_salary' ], 'Basic Salary' )) &&
                (!is_empty( $_POST[ 'salary_type' ], 'Salary Type' )) &&
                (!is_empty( $_POST[ 'payment_method' ], 'Payment Method' )) &&
                (is_number( $_POST[ 'basic_salary' ], 'Basic Salary' ))
        ;
    }

    //---add item----------------
    if ( (strcmp( $Mode, 'ADD_ITEM' ) == 0) && can_process() )
    {
        $flag = $employee_db->insert( $employee_db::SALARY_TERMS, $_POST );
        if ( $flag == true )
        {
            add_msg( $controller );
            $Mode = 'Edit';
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
        $employee_db->update( $selected_id, $employee_db::SALARY_TERMS, $_POST );
        update_msg( $controller );
        $Mode = 'Edit';
    }
    //---reset the page------------
    if ( strcmp( $Mode, 'RESET' ) == 0 )
    {
        refresh_pager( $pager );
        $selected_id = -1;
        unset( $_POST );
    }
    //---if we have edit mode
    if ( $selected_id != -1 )
    {
        //special modifications for this form only
        //if(strcmp($Mode,'Edit')==0)
        {
            $employee_db->select( $selected_id, $employee_db::SALARY_TERMS, $_POST );
        }
        hidden( 'selected_id', $selected_id );
    }
    display_heading_with_breaks( "Employee Salary Information", 1, 1 );
    start_table( TABLESTYLE2 );
    text_row_ex( _( "Basic Salary" ) . ':', 'basic_salary', 30, 30 );
    row_start();
    $arr = array( 'Fixed' => 'Fixed', 'Wages' => 'Wages' );
    multiple_array_selector( 'salary_type', _( "Salary Type" ), $arr, 0, 0 );
    row_end();
    row_start();
    $arr = array( 'Bank Transfer' => 'Bank Transfer', 'Check' => 'Check', 'Cash' => 'Cash' );
    multiple_array_selector( 'payment_method', _( "Payment Method" ), $arr, 0, 0 );
    row_end();
    if ( strcmp( $_POST[ 'payment_method' ], 'Bank Transfer' ) == 0 )
    {
        row_start();
        $arr = array( 'bank_id' => null, 'name' => null );
        multiple_array_selector( 'bank_id', _( "Bank Name" ), $bank_db->search_advanced( $arr ), 0 );
        row_end();
        text_row_ex( _( "Account Holder Name" ) . ':', 'account_holder_name', 50, 50 );
        textarea_row( _( "Account Holder Address:" ), 'account_holder_address', @$_POST[ 'account_holder_address' ], 35, 5 );
    }
    else if ( strcmp( $_POST[ 'payment_method' ], 'Check' ) == 0 )
    {
        text_row_ex( _( "Check Pay To" ) . ':', 'check_reciever', 50, 50 );
    }
    else
    {
        //just do nothing.	
    }
    end_table( 1 );
    submit_add_or_update_center( $selected_id == -1, '', 'both' );
    br( 1 );
}

//------------------------------------------------------------------------------------------------------------
function employee_salary_allowance( $arr = array( ) )
{
    global $Mode, $jMode, $selected_id, $jselected_id;
    //----pager defined--------
    $pager = "allowance_employee_tbl";
    //----Database model defined--------
    $employee_allowance_db = new employee_allowance_model();
    $allowance_db = new allowance_model();
    //----message controller----
    $controller = "Employee Allowance";
    //---loggers----------------
    pr( "selected ID = $selected_id and Mode = $Mode" );

    //---internal functions------
    function can_process()
    {
        return
                (!is_empty( $_POST[ 'allowance_id' ], 'Allowance Type' )) &&
                (!is_empty( $_POST[ 'allowance_amount' ], 'Allowance Amount' )) &&
                (is_number( $_POST[ 'allowance_amount' ], 'Allowance Amount' ))
        ;
    }

    //---add item----------------
    if ( (strcmp( $Mode, 'ADD_ITEM' ) == 0) && can_process() )
    {
        $flag = $employee_allowance_db->insert( $selected_id, $_POST );
        if ( $flag == true )
        {
            add_msg( $controller );
            $Mode = 'Edit';
            $jMode = 'jEdit';
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
        $employee_allowance_db->update( $selected_id, $_POST );
        update_msg( $controller );
        $Mode = 'Edit';
        $jMode = 'jEdit';
    }
    //---reset the page------------
    if ( strcmp( $Mode, 'RESET' ) == 0 )
    {
        refresh_pager( $pager );
        $_POST[ 'allowance_id' ] = '';
        $_POST[ 'allowance_amount' ] = '';
    }
    //---delete item-------------
    if ( strcmp( $jMode, 'jDelete' ) == 0 )
    {
        //if (key_in_foreign_table($jselected_id, '', ''))
        if ( 0 )
        {
            delete_error_msg( $controller, 'Employee' );
            $Mode = 'RESET';
        }
        else
        {
            $employee_allowance_db->delete( $jselected_id );
            delete_msg( $controller );
            $Mode = 'RESET';
        }
    }
    //---if we have edit mode
    if ( $jselected_id != -1 )
    {
        if ( strcmp( $jMode, 'jEdit' ) == 0 )
        {
            $employee_allowance_db->select( $selected_id, $jselected_id, &$_POST );
        }
        hidden( 'jselected_id', $jselected_id );
    }
    if ( $selected_id != -1 )
    {
        hidden( 'selected_id', $selected_id );
    }
    display_heading_with_breaks( "Employee Allowance Information", 1, 1 );
    start_table( TABLESTYLE2 );
    $arr = array( 'allowance_id' => null, 'name' => null );
    multiple_array_selector( 'allowance_id', _( "Allowance Type" ), $allowance_db->search_advanced( $arr ), 0 );
    text_row_ex( _( "Allowance" ) . ':', 'allowance_amount', 30, 30 );
    end_table( 1 );
    submit_add_or_update_center( $jselected_id == -1, '', 'both' );
    br( 1 );
    //----start the pager section of the page---------
    $th = array( _( "$controller Name" ), _( "$controller Value" ) );
    $sql = $employee_allowance_db->search( $selected_id );
    pager_display( $pager, $th, $sql, "40%", $controller, 'jedit_link', 'jdelete_link' );
    //----end the page---------
    br( 2 );
}

//------------------------------------------------------------------------------------------------------------
function employee_salary_deduction( $arr = array( ) )
{
    global $Mode, $jMode, $selected_id, $jselected_id;
    //----pager defined--------
    $pager = "deduction_employee_tbl";
    //----Database model defined--------
    $employee_deduction_db = new employee_deduction_model();
    $deduction_db = new deduction_model();
    //----message controller----
    $controller = "Employee Deduction";
    //---loggers----------------
    pr( "selected ID = $selected_id and Mode = $Mode" );
    pr( $_POST );

    //---internal functions------
    function can_process()
    {
        return
                (!is_empty( $_POST[ 'deduction_id' ], 'Deduction Type' )) &&
                (!is_empty( $_POST[ 'deduction_amount' ], 'Deduction Amount' )) &&
                (is_number( $_POST[ 'deduction_amount' ], 'Deduction Amount' ))
        ;
    }

    //---add item----------------
    if ( (strcmp( $Mode, 'ADD_ITEM' ) == 0) && can_process() )
    {
        $flag = $employee_deduction_db->insert( $selected_id, $_POST );
        if ( $flag == true )
        {
            add_msg( $controller );
            $Mode = 'Edit';
            $jMode = 'jEdit';
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
        $employee_deduction_db->update( $selected_id, $_POST );
        update_msg( $controller );
        $Mode = 'Edit';
        $jMode = 'jEdit';
    }
    //---reset the page------------
    if ( strcmp( $Mode, 'RESET' ) == 0 )
    {
        refresh_pager( $pager );
        $_POST[ 'deduction_id' ] = '';
        $_POST[ 'deduction_amount' ] = '';
    }
    //---delete item-------------
    if ( strcmp( $jMode, 'jDelete' ) == 0 )
    {
        //if (key_in_foreign_table($jselected_id, '', ''))
        if ( 0 )
        {
            delete_error_msg( $controller, 'Employee' );
            $Mode = 'RESET';
        }
        else
        {
            $employee_deduction_db->delete( $jselected_id );
            delete_msg( $controller );
            $Mode = 'RESET';
        }
    }
    //---if we have edit mode
    if ( $jselected_id != -1 )
    {
        if ( strcmp( $jMode, 'jEdit' ) == 0 )
        {
            $employee_deduction_db->select( $selected_id, $jselected_id, &$_POST );
        }
        hidden( 'jselected_id', $jselected_id );
    }
    if ( $selected_id != -1 )
    {
        hidden( 'selected_id', $selected_id );
    }
    display_heading_with_breaks( "Employee Deduction Information", 1, 1 );
    start_table( TABLESTYLE2 );
    $arr = array( 'deduction_id' => null, 'name' => null );
    multiple_array_selector( 'deduction_id', _( "Deduction Type" ), $deduction_db->search_advanced( $arr ), 0 );
    text_row_ex( _( "Deduction" ) . ':', 'deduction_amount', 30, 30 );
    end_table( 1 );
    submit_add_or_update_center( $jselected_id == -1, '', 'both' );
    br( 1 );
    //----start the pager section of the page---------
    $th = array( _( "$controller Name" ), _( "$controller Value" ) );
    $sql = $employee_deduction_db->search( $selected_id );
    pager_display( $pager, $th, $sql, "40%", $controller, 'jedit_link', 'jdelete_link' );
    //----end the page---------
    br( 2 );
}

//------------------------------------------------------------------------------------------------------------
function employee_joining( $arr = array( ) )
{
    global $Mode, $jMode, $selected_id, $jselected_id;
    //----pager defined--------
    $pager = "employee_joining_tbl";
    //----Database model defined--------
    $employee_joining_db = new employee_joining_model();
    //----message controller----
    $controller = "Employee Joining";
    //---loggers----------------
    pr( "selected ID = $selected_id and Mode = $Mode" );
    pr( $_POST );

    //---internal functions------
    function can_process()
    {
        return
                (!is_empty( $_POST[ 'last_organization' ], 'Last Organization' )) &&
                (!is_empty( $_POST[ 'last_salary' ], 'Last Salary' )) &&
                (is_number( $_POST[ 'last_salary' ], 'Last Salary' )) &&
                (is_date( $_POST[ 'joining_start_date' ], 'Joining Date' )) &&
                (is_date( $_POST[ 'joining_end_date' ], 'Leaving Date' ))
        ;
    }

    //---add item----------------
    if ( (strcmp( $Mode, 'ADD_ITEM' ) == 0) && can_process() )
    {
        $flag = $employee_joining_db->insert( $selected_id, $_POST );
        if ( $flag == true )
        {
            add_msg( $controller );
            $Mode = 'Edit';
            $jMode = 'jEdit';
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
        $employee_joining_db->update( $selected_id, $_POST );
        update_msg( $controller );
        $Mode = 'Edit';
        $jMode = 'jEdit';
    }
    //---reset the page------------
    if ( strcmp( $Mode, 'RESET' ) == 0 )
    {
        refresh_pager( $pager );
        $_POST[ 'last_organization' ] = '';
        $_POST[ 'last_salary' ] = '';
        $_POST[ 'joining_start_date' ] = '';
        $_POST[ 'joining_end_date' ] = '';
        $_POST[ 'reason_for_leaving' ] = '';
    }
    //---delete item-------------
    if ( strcmp( $jMode, 'jDelete' ) == 0 )
    {
        //if (key_in_foreign_table($jselected_id, '', ''))
        if ( 0 )
        {
            delete_error_msg( $controller, 'Employee' );
            $Mode = 'RESET';
        }
        else
        {
            $employee_joining_db->delete( $jselected_id );
            delete_msg( $controller );
            $Mode = 'RESET';
        }
    }
    //---if we have edit mode
    if ( $jselected_id != -1 )
    {
        if ( strcmp( $jMode, 'jEdit' ) == 0 )
        {
            $employee_joining_db->select( $selected_id, $jselected_id, &$_POST );
        }
        hidden( 'jselected_id', $jselected_id );
    }
    if ( $selected_id != -1 )
    {
        hidden( 'selected_id', $selected_id );
    }
    display_heading_with_breaks( "Employee Joining Information", 1, 1 );
    start_table( TABLESTYLE2 );

    text_row_ex( _( "Last Organization" ) . ':', 'last_organization', 50, 50 );
    text_row_ex( _( "Last Salary" ) . ':', 'last_salary', 30, 30 );
    date_row( "Joining Date", 'joining_start_date' );
    date_row( "Leaving Date", 'joining_end_date' );
    textarea_row( _( "Reasons for Leaving:" ), 'reason_for_leaving', @$_POST[ 'reason_for_leaving' ], 35, 5 );

    end_table( 1 );
    submit_add_or_update_center( $jselected_id == -1, '', 'both' );
    br( 1 );
    //----start the pager section of the page---------
    $th = array( _( "Last Organization" ), _( "Last Salary" ), _( "Joining Date" ), _( "Leaving Date" ) );
    $sql = $employee_joining_db->search( $selected_id );
    pager_display( $pager, $th, $sql, "40%", $controller, 'jedit_link', 'jdelete_link' );
    //----end the page---------
    br( 2 );
}

//------------------------------------------------------------------------------------------------------------
function employee_qualification( $arr = array( ) )
{
    global $Mode, $jMode, $selected_id, $jselected_id;
    //----pager defined--------
    $pager = "employee_qualification_tbl";
    //----Database model defined--------
    $employee_qualification_db = new employee_qualification_model();
    //----message controller----
    $controller = "Employee Qualification";
    //---loggers----------------
    pr( "selected ID = $selected_id and Mode = $Mode" );
    pr( $_POST );

    //---internal functions------
    function can_process()
    {
        return
                (!is_empty( $_POST[ 'degree' ], 'Degree' )) &&
                (!is_empty( $_POST[ 'university_name' ], 'University Name' ))
        ;
    }

    //---add item----------------
    if ( (strcmp( $Mode, 'ADD_ITEM' ) == 0) && can_process() )
    {
        $flag = $employee_qualification_db->insert( $selected_id, $_POST );
        if ( $flag == true )
        {
            add_msg( $controller );
            $Mode = 'Edit';
            $jMode = 'jEdit';
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
        $employee_qualification_db->update( $selected_id, $_POST );
        update_msg( $controller );
        $Mode = 'Edit';
        $jMode = 'jEdit';
    }
    //---reset the page------------
    if ( strcmp( $Mode, 'RESET' ) == 0 )
    {
        refresh_pager( $pager );
        $_POST[ 'degree' ] = '';
        $_POST[ 'university_name' ] = '';
        $_POST[ 'university_address' ] = '';
        $_POST[ 'degree_start_year' ] = '';
        $_POST[ 'degree_end_year' ] = '';
        $_POST[ 'total_marks' ] = '';
        $_POST[ 'marks_obtained' ] = '';
        $_POST[ 'grade' ] = '';
        $_POST[ 'degree_majors' ] = '';
    }
    //---delete item-------------
    if ( strcmp( $jMode, 'jDelete' ) == 0 )
    {
        //if (key_in_foreign_table($jselected_id, '', ''))
        if ( 0 )
        {
            delete_error_msg( $controller, 'Employee' );
            $Mode = 'RESET';
        }
        else
        {
            $employee_qualification_db->delete( $jselected_id );
            delete_msg( $controller );
            $Mode = 'RESET';
        }
    }
    //---if we have edit mode
    if ( $jselected_id != -1 )
    {
        if ( strcmp( $jMode, 'jEdit' ) == 0 )
        {
            $employee_qualification_db->select( $selected_id, $jselected_id, &$_POST );
        }
        hidden( 'jselected_id', $jselected_id );
    }
    if ( $selected_id != -1 )
    {
        hidden( 'selected_id', $selected_id );
    }
    display_heading_with_breaks( "Employee qualification Information", 1, 1 );
    start_table( TABLESTYLE2 );

    text_row_ex( _( "Degree" ) . ':', 'degree', 50, 50 );
    text_row_ex( _( "School/College/University Name" ) . ':', 'university_name', 70, 70 );
    textarea_row( _( "School/College/University Address:" ), 'university_address', @$_POST[ 'university_address' ], 35, 5 );
    date_row( "Session Start Date", 'degree_start_year' );
    date_row( "Session End Date", 'degree_end_year' );
    text_row_ex( _( "Marks Obtained" ) . ':', 'marks_obtained', 20, 20 );
    text_row_ex( _( "Total Marks" ) . ':', 'total_marks', 20, 20 );
    text_row_ex( _( "Grade" ) . ':', 'grade', 20, 20 );
    text_row_ex( _( "Degree Major's" ) . ':', 'degree_majors', 80, 80 );

    end_table( 1 );
    submit_add_or_update_center( $jselected_id == -1, '', 'both' );
    br( 1 );
    //----start the pager section of the page---------
    $th = array( _( "$controller Degree" ), _( "School/College/University Name" ), _( "Session Start Date" ), _( "Session End Date" ), _( "Marks Obtained" ), _( "Total Marks" ) );
    $sql = $employee_qualification_db->search( $selected_id );
    pager_display( $pager, $th, $sql, "70%", $controller, 'jedit_link', 'jdelete_link' );
    //----end the page---------
    br( 2 );
}

//------------------------------------------------------------------------------------------------------------
function employee_reference( $arr = array( ) )
{
    global $Mode, $jMode, $selected_id, $jselected_id;
    //----pager defined--------
    $pager = "employee_reference_tbl";
    //----Database model defined--------
    $employee_reference_db = new employee_reference_model();
    //----message controller----
    $controller = "Employee Reference";
    //---loggers----------------
    pr( "selected ID = $selected_id and Mode = $Mode" );
    pr( $_POST );

    //---internal functions------
    function can_process()
    {
        return
                (!is_empty( $_POST[ 'reference_name' ], 'Reference Name' ))
        ;
    }

    //---add item----------------
    if ( (strcmp( $Mode, 'ADD_ITEM' ) == 0) && can_process() )
    {
        $flag = $employee_reference_db->insert( $selected_id, $_POST );
        if ( $flag == true )
        {
            add_msg( $controller );
            $Mode = 'Edit';
            $jMode = 'jEdit';
        }
        else
        {
            duplicate_msg( $controller );
            set_focus( 'reference_name' );
        }
    }
    //---update item--------------
    if ( (strcmp( $Mode, 'UPDATE_ITEM' ) == 0) && can_process() )
    {
        $employee_reference_db->update( $selected_id, $_POST );
        update_msg( $controller );
        $Mode = 'Edit';
        $jMode = 'jEdit';
    }
    //---reset the page------------
    if ( strcmp( $Mode, 'RESET' ) == 0 )
    {
        refresh_pager( $pager );
        $_POST[ 'reference_name' ] = '';
        $_POST[ 'reference_address' ] = '';
        $_POST[ 'contact_number' ] = '';
        $_POST[ 'know_since_date' ] = '';
    }
    //---delete item-------------
    if ( strcmp( $jMode, 'jDelete' ) == 0 )
    {
        //if (key_in_foreign_table($jselected_id, '', ''))
        if ( 0 )
        {
            delete_error_msg( $controller, 'Employee' );
            $Mode = 'RESET';
        }
        else
        {
            $employee_reference_db->delete( $jselected_id );
            delete_msg( $controller );
            $Mode = 'RESET';
        }
    }
    //---if we have edit mode
    if ( $jselected_id != -1 )
    {
        if ( strcmp( $jMode, 'jEdit' ) == 0 )
        {
            $employee_reference_db->select( $selected_id, $jselected_id, &$_POST );
        }
        hidden( 'jselected_id', $jselected_id );
    }
    if ( $selected_id != -1 )
    {
        hidden( 'selected_id', $selected_id );
    }
    display_heading_with_breaks( "Employee Reference Information", 1, 1 );
    start_table( TABLESTYLE2 );

    text_row_ex( _( "Reference Name" ) . ':', 'reference_name', 50, 50 );
    textarea_row( _( "Reference Address:" ), 'reference_address', @$_POST[ 'reference_address' ], 35, 5 );
    text_row_ex( _( "Reference Contact #" ) . ':', 'contact_number', 30, 30 );
    date_row( "Know Since", 'know_since_date' );

    end_table( 1 );
    submit_add_or_update_center( $jselected_id == -1, '', 'both' );
    br( 1 );
    //----start the pager section of the page---------
    $th = array( _( "$controller Name" ), _( "$controller Contact #" ), _( "Know Since" ) );
    $sql = $employee_reference_db->search( $selected_id );
    pager_display( $pager, $th, $sql, "40%", $controller, 'jedit_link', 'jdelete_link' );
    //----end the page---------
    br( 2 );
}

//------------------------------------------------------------------------------------------------------------
function employee_dependent( $arr = array( ) )
{
    global $Mode, $jMode, $selected_id, $jselected_id;
    //----pager defined--------
    $pager = "employee_dependent_tbl";
    //----Database model defined--------
    $employee_dependent_db = new employee_dependent_model();
    //----message controller----
    $controller = "Employee Dependent";
    //---loggers----------------
    pr( "selected ID = $selected_id and Mode = $Mode" );
    pr( $_POST );

    //---internal functions------
    function can_process()
    {
        return
                (!is_empty( $_POST[ 'dependent_name' ], 'Dependent Name' ))
        ;
    }

    //---add item----------------
    if ( (strcmp( $Mode, 'ADD_ITEM' ) == 0) && can_process() )
    {
        $flag = $employee_dependent_db->insert( $selected_id, $_POST );
        if ( $flag == true )
        {
            add_msg( $controller );
            $Mode = 'Edit';
            $jMode = 'jEdit';
        }
        else
        {
            duplicate_msg( $controller );
            set_focus( 'reference_name' );
        }
    }
    //---update item--------------
    if ( (strcmp( $Mode, 'UPDATE_ITEM' ) == 0) && can_process() )
    {
        $employee_dependent_db->update( $selected_id, $_POST );
        update_msg( $controller );
        $Mode = 'Edit';
        $jMode = 'jEdit';
    }
    //---reset the page------------
    if ( strcmp( $Mode, 'RESET' ) == 0 )
    {
        refresh_pager( $pager );
        $_POST[ 'dependent_name' ] = '';
        $_POST[ 'dependent_relation' ] = '';
        $_POST[ 'dependent_date_of_birth' ] = '';
        $_POST[ 'dependent_occupation' ] = '';
    }
    //---delete item-------------
    if ( strcmp( $jMode, 'jDelete' ) == 0 )
    {
        //if (key_in_foreign_table($jselected_id, '', ''))
        if ( 0 )
        {
            delete_error_msg( $controller, 'Employee' );
            $Mode = 'RESET';
        }
        else
        {
            $employee_dependent_db->delete( $jselected_id );
            delete_msg( $controller );
            $Mode = 'RESET';
        }
    }
    //---if we have edit mode
    if ( $jselected_id != -1 )
    {
        if ( strcmp( $jMode, 'jEdit' ) == 0 )
        {
            $employee_dependent_db->select( $selected_id, $jselected_id, &$_POST );
        }
        hidden( 'jselected_id', $jselected_id );
    }
    if ( $selected_id != -1 )
    {
        hidden( 'selected_id', $selected_id );
    }
    display_heading_with_breaks( "Employee Dependent Information", 1, 1 );
    start_table( TABLESTYLE2 );

    text_row_ex( _( "Dependent Name" ) . ':', 'dependent_name', 50, 50 );
    text_row_ex( _( "Dependent Relation" ) . ':', 'dependent_relation', 50, 50 );
    date_row( "Date of Birth", 'dependent_date_of_birth' );
    text_row_ex( _( "Dependent Occupation" ) . ':', 'dependent_occupation', 50, 50 );

    end_table( 1 );
    submit_add_or_update_center( $jselected_id == -1, '', 'both' );
    br( 1 );
    //----start the pager section of the page---------
    $th = array( _( "Dependent Name" ), _( "Dependent Relation" ), _( "Date of Birth" ), _( "Dependent Occupation" ) );
    $sql = $employee_dependent_db->search( $selected_id );
    pager_display( $pager, $th, $sql, "60%", $controller, 'jedit_link', 'jdelete_link' );
    //----end the page---------
    br( 2 );
}

//------------------------------------------------------------------------------------------------------------
function employee_leave( $arr = array( ) )
{
    global $Mode, $jMode, $selected_id, $jselected_id;
    //----pager defined--------
    $pager = "leave_employee_tbl";
    //----Database model defined--------
    $employee_leave_db = new employee_leave_model();
    $leave_db = new leave_model();
    //----message controller----
    $controller = "Employee Leave";
    //---loggers----------------
    pr( "selected ID = $selected_id and Mode = $Mode" );
    pr( $_POST );

    //---internal functions------
    function can_process()
    {
        return
                (!is_empty( $_POST[ 'leave_id' ], 'Leave Type' )) &&
                (!is_empty( $_POST[ 'leave_assigned' ], 'Leaves Assigned' )) &&
                (is_number( $_POST[ 'leave_assigned' ], 'Leaves Assigned' ))
        ;
    }

    //---add item----------------
    if ( (strcmp( $Mode, 'ADD_ITEM' ) == 0) && can_process() )
    {
        $flag = $employee_leave_db->insert( $selected_id, $_POST );
        if ( $flag == true )
        {
            add_msg( $controller );
            $Mode = 'Edit';
            $jMode = 'jEdit';
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
        $employee_leave_db->update( $selected_id, $_POST );
        update_msg( $controller );
        $Mode = 'Edit';
        $jMode = 'jEdit';
    }
    //---reset the page------------
    if ( strcmp( $Mode, 'RESET' ) == 0 )
    {
        refresh_pager( $pager );
        $_POST[ 'leave_id' ] = '';
        $_POST[ 'leave_assigned' ] = '';
    }
    //---delete item-------------
    if ( strcmp( $jMode, 'jDelete' ) == 0 )
    {
        //if (key_in_foreign_table($jselected_id, '', ''))
        if ( 0 )
        {
            delete_error_msg( $controller, 'Employee' );
            $Mode = 'RESET';
        }
        else
        {
            $employee_deduction_db->delete( $jselected_id );
            delete_msg( $controller );
            $Mode = 'RESET';
        }
    }
    //---if we have edit mode
    if ( $jselected_id != -1 )
    {
        if ( strcmp( $jMode, 'jEdit' ) == 0 )
        {
            $employee_leave_db->select( $selected_id, $jselected_id, &$_POST );
        }
        hidden( 'jselected_id', $jselected_id );
    }
    if ( $selected_id != -1 )
    {
        hidden( 'selected_id', $selected_id );
    }
    display_heading_with_breaks( "Employee Leave Information", 1, 1 );
    start_table( TABLESTYLE2 );
    $arr = array( 'leave_id' => null, 'name' => null );
    multiple_array_selector( 'leave_id', _( "Leave Type" ), $leave_db->search_advanced( $arr ), 0 );
    text_row_ex( _( "Leaves Assigned" ) . ':', 'leave_assigned', 30, 30 );
    end_table( 1 );
    submit_add_or_update_center( $jselected_id == -1, '', 'both' );
    br( 1 );
    //----start the pager section of the page---------
    $th = array( _( "$controller Name" ), _( "$controller Assigned" ) );
    $sql = $employee_leave_db->search( $selected_id );
    pager_display( $pager, $th, $sql, "40%", $controller, 'jedit_link', 'jdelete_link' );
    //----end the page---------
    br( 2 );
}

?>