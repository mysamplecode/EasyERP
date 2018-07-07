<?php

//---secutiry and path setting-------- 
$page_security = 'SA_HRM_ATTENDANCE_CONFIRMATION_ENTRY';
$path_to_root = "../..";
//----include files--------
include_once($path_to_root . "/reporting/includes/pdf_report.inc");

$attendance_db = new attendance_model();
if ( isset($_POST[ 'reported_by' ]) && strlen( $_POST[ 'reported_by' ] ) > 0 )
{
    //$sql = $attendance_db -> search_by_month_for_superior_with_name($_POST['attendance_month'],$_POST['reported_by']);
    print_employee_attendance_profile( $_POST[ 'reported_by' ], $_POST[ 'attendance_month' ] );
}
else
{
    //$sql = $attendance_db -> search_by_month_for_employee_with_name($_POST['attendance_month'],$employee_id);
    print_employee_attendance_profile( $_POST['employee_id'], $_POST[ 'attendance_month' ] );
}

function print_employee_attendance_profile( $selected_id, $attendance_month )
{
    $employee_id = $selected_id;
    $php_master = getdate(  strtotime( "$attendance_month-01" ));
    $ashtex_master = timestamp_breakup("$attendance_month-01 00:00:00");
    
    global $profile;
    //---get company details
    $company = get_company_pref();
    $fyear = get_fiscalyear($company['f_year']);
    //---starting up the models
    $employee_db = new employee_model();
    $unit_db = new unit_model();
    $department_db = new department_model();
    $designation_db = new designation_model();
    $shift_db = new shift_model();
    $employee_status_db = new employee_status_model();
    $attendance_db = new attendance_model();
    //----get the selected employee--------
    $emp_row = array( );
    $emp_row[ 'employee_db' ] = array( );
    $emp_row[ 'employee_salary_db' ] = array( );
    $emp_row[ 'unit_db' ] = array( );
    $emp_row[ 'department_db' ] = array( );
    $emp_row[ 'designation_db' ] = array( );
    $emp_row[ 'shift_db' ] = array( );
    $emp_row[ 'employee_status_db' ] = array( );

    $employee_db->select( $selected_id, employee_model::PERSONAL, $emp_row[ 'employee_db' ] );
    $employee_db->select( $selected_id, employee_model::SALARY_TERMS, $emp_row[ 'employee_salary_db' ] );
    $unit_db->select( $emp_row[ 'employee_db' ][ 'unit_id' ], $emp_row[ 'unit_db' ] );
    $department_db->select( $emp_row[ 'employee_db' ][ 'department_id' ], $emp_row[ 'department_db' ] );
    $designation_db->select( $emp_row[ 'employee_db' ][ 'designation_id' ], $emp_row[ 'designation_db' ] );
    $shift_db->select( $emp_row[ 'employee_db' ][ 'shift_id' ], $emp_row[ 'shift_db' ] );
    $employee_status_db->select( $emp_row[ 'employee_db' ][ 'employee_status_id' ], $emp_row[ 'employee_status_db' ] );
    //-------------------------------------------------------------------------------
    $line_distance = 2;
    $line_type = 1;
    $line_width = 1;
    $line_style = array( 'cap' => 'sqaure', 'dash' => '1,2', 'join' => 'miter' );
    // A4 - P (w:595px,l:842px)
    //-------------0--1---2----
    $cols = array( 0, 160, 300, 420 );
    $headers = array( );
    $aligns = array( 'left', 'left', 'left' );
    $rep = new FrontReport( _( "Employee Attendance Record" ), 'employeeattendancerecord', 'A4', 9, 'P' );
    $rep->Info( array( 0 => '' ), $cols, $headers, $aligns );
    $rep->NewPage();
    //----------add image to col 6-------------
    if ( empty( $emp_row[ 'employee_db' ][ 'path_to_picture' ] ) || !file_exists( $emp_row[ 'employee_db' ][ 'path_to_picture' ] ) )
    {
        $emp_row[ 'employee_db' ][ 'path_to_picture' ] = NO_IMAGE;
    }
    $rep->AddImage( $emp_row[ 'employee_db' ][ 'path_to_picture' ], $cols[ 3 ] - $rep->rightMargin + 0, ($rep->pageHeight - 270 ), PROFILE_PICTURE_WIDTH, PROFILE_PICTURE_HEIGHT );
    $rep->SetDrawColor( 105, 188, 206 );
    $rep->SetLineStyle(array('width' => 1, 'dash' => 0));
    $rep->rectangle( $cols[ 3 ] - $rep->rightMargin, ($rep->pageHeight - 120 ), PROFILE_PICTURE_WIDTH, PROFILE_PICTURE_HEIGHT );
    //----------Employee Personal Information--------------------------
    $cols = array( 0, 135, 150, 235, 250, 335, 350 );
    $headers = array( _( 'Name' ), '', _( 'Unit' ), '', _( 'Department' ) );
    $aligns = array( 'left', 'left', 'left' );
    $rep->Info( array( 0 => '' ), $cols, $headers, $aligns );
    $rep->header_only_3();
    $rep->TextCol( 0, 1, $emp_row[ 'employee_db' ][ 'first_name' ] );
    $rep->TextCol( 2, 3, $emp_row[ 'unit_db' ][ 'name' ] );
    $rep->TextCol( 4, 5, $emp_row[ 'department_db' ][ 'name' ] );
    $rep->NewLine();

    $cols = array( 0, 135, 150, 250, 265, 335, 350 );
    $headers = array( _( 'Designation' ), '', _( 'Shift' ), '', _( 'Status' ) );
    $rep->Info( array( 0 => '' ), $cols, $headers, $aligns );
    $rep->header_only_3();
    $rep->TextCol( 0, 1, $emp_row[ 'designation_db' ][ 'name' ] );
    $rep->TextCol( 2, 3, $emp_row[ 'shift_db' ][ 'name' ] );
    $rep->TextCol( 4, 5, $emp_row[ 'employee_status_db' ][ 'name' ] );
    $rep->NewLine();
    //--------------------------------------------------------------------------------
    $table = $attendance_db->table;
    $basic = PluSQL::from( $profile )->$table->select( "*" )->orderBy( 'timestamp ASC' )->where( "DATE(timestamp) >= '$attendance_month-01' and DATE(timestamp) <= '$attendance_month-31' and employee_id = $employee_id and viewable =1 and attendance_dec1 = 1" )->run()->$table;
    $day_arr = array( );
    $day = 'test';
    $working_days = 0; $holidays = 0; $leaves = 0; $cpl = 0; $absents = 0; $delays = 0; $overtime = 0; $double_overtime = 0;
    foreach ( $basic as $attendance )
    {
        list($date,$time) = explode(' ', $attendance -> timestamp);
        if(!isset($day_arr[$date]))
        {
            $day_arr[$date] = array();
        }
        $day_arr[$date][] = array($attendance -> timestamp,$attendance -> code,$attendance -> attendance_string1,$attendance -> gate_code,$attendance -> attendance_int1 );
        if( (strcmp($attendance -> code,  attendance_model::GATE_IN)==0) || (strcmp($attendance -> code,  attendance_model::GATE_OUT)==0) )
        {
            if(strcmp($day,$date)!=0)
            {
                $working_days++;
                $day = $date;
            }
            if(strcmp($attendance -> attendance_string1,  attendance_model::ALL_OK)!=0)
            {
                if($attendance -> attendance_int1 > 0)
                {
                   if(strcmp($attendance -> gate_code,  attendance_model::OVERTIME)==0) 
                   {
                       $overtime += $attendance -> attendance_int1;
                   }
                   else if(strcmp($attendance -> gate_code,  attendance_model::DOUBLE_OVER_TIME)==0) 
                   {
                       $double_overtime += $attendance -> attendance_int1;
                   }
                }
                else if($attendance -> attendance_int1 < 0)
                {
                   if(strcmp($attendance -> gate_code,  attendance_model::PERSONAL)==0) 
                   {
                       $delays += $attendance -> attendance_int1 * -1 ;
                   }
                }
                else {}
            }
        }
        else if( (strcmp($attendance -> code,  attendance_model::HOLIDAY)==0) )
        {
            $holidays++;
        }
        else if( (strcmp($attendance -> code,  attendance_model::ABSENT)==0) )
        {
            $absents++;
        }
        else if( (strcmp($attendance -> code,  attendance_model::LEAVE)==0) )
        {
            $leaves++;
        }
    }
    //--------------------------------------------------------------------------------
    $cols = array( 0, 160, 295 );
    $headers = array( _( 'Attendance Summary' ) );
    $rep->Info( array( 0 => '' ), $cols, $headers, $aligns );
    $rep->header_only_3( false );
    $rep->NewLine( 1 );
    $arr = array
        (
        "Attendance Month" => $php_master['month'],
        "Attendance Year" => $php_master['year'],
        "Fiscal Year" => "{$fyear['begin']} to {$fyear['end']}",
        "Total Days" => $ashtex_master['month_days'].' days',
        "Working Days" => "$working_days days",
        "Holidays" => "$holidays days",
        "Leaves" => "$leaves days",
        "CPL" => "$cpl days",
        "Absents" => "$absents days",
        "Delays" => "$delays minutes",
        "Over Time" => "$overtime minutes",
        "Double Over Time" => "$double_overtime minutes",
    );
    $rep->add_label_value_group( $arr, 0, 1 );
    $rep->NewLine( 2 );
    $headers = array( _( 'Attendance Details' ) );
    $rep->Info( array( 0 => '' ), $cols, $headers, $aligns );
    $rep->header_only_3( false );
    $rep->NewLine( 1 );
    
    $cols = array( 0, 100, 200, 300, 400, 500 );
    $headers = array( _( 'Stamp' ), _( 'Code' ), _( 'Issue' ), _( 'Response' ), _( 'D/O - MINS' ) );
    $rep->Info( array( 0 => '' ), $cols, $headers, $aligns );
    
    foreach($day_arr as $key => $day)
    {
        $kk = getdate(strtotime($key));
        $rep->add_label( "Day", 0, 1 );
        $rep->UnderlineCell( 0, $line_distance, $line_type, $line_width, $line_style );
        $rep->add_value( $kk['weekday'], 1, 2 );
        $rep->UnderlineCell( 1, $line_distance, $line_type, $line_width, $line_style );
        $rep->add_label( "Date", 2, 3 );
        $rep->UnderlineCell( 2, $line_distance, $line_type, $line_width, $line_style );
        $rep->add_value( $key, 3, 4 );
        $rep->UnderlineCell( 3, $line_distance, $line_type, $line_width, $line_style );
        $rep->NewLine();
        $rep->header_only_3();
        foreach($day as $dd)
        {
            foreach($dd as $k => $d)
            {
                $rep->TextCol( $k, $k + 1, $d);
            }
            $rep->NewLine();
        }
        //$rep->Line($rep->row + ($rep->lineHeight) - 2,1);
    }
    $rep->End();
}

?>
