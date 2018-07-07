<?php

class attendance_model
{
    //------------constants----------------------
    //delay justifications by employee

    const PERSONAL = 'PERSONAL';
    const OFFICAL = 'OFFICIAL';
    const OUT_DOOR = 'OUT DOOR';
    const SHORT_LEAVE = 'SHORT LEAVE';
    const OVER_TIME = 'OVER TIME';
    const DOUBLE_OVER_TIME = 'DOUBLE OVER TIME';
    const NA = 'N/A';
    const RELAX_TIME = 'RELAX TIME';
    // possible delay reasons
    const LATE_GATEIN = 'LATE GATE IN';
    const EARLY_GATEOUT = 'EARLY GATE OUT';
    const MISSING_GATEOUT = 'MISSING GATE OUT';
    const UNANNOUNCED_GATEOUT = 'UNANNOUNCED GATE OUT';
    const ALL_OK = 'NO ISSUES FOUND';
    const OVERTIME = 'POSSIBLE OVERTIME';
    //employee and superior status
    const CONFIRMED = "YES";
    const NOT_CONFIRMED = "NO";
    //attendance code
    const GATE_IN = "GATE-IN";
    const GATE_OUT = "GATE-OUT";
    const ABSENT = "ABSENT";
    const LEAVE = "LEAVE";
    const HOLIDAY = "HOLIDAY";

    //------------private/public variables----------------
    public $response;
    public $issues;
    public $con_arr;
    public $gate_code;
    public $table;
    public $id;
    public $interval = 30;
    public $id_array = array( "0", "1", "2", "3", "4", "5", "6", "7", "8", "9" );
    public $hash_array = array( "y", "w", "v", "r", "t", "j", "k", "l", "p", "q" );
    public $fiscal_year;
    public $holiday_arr;
    public $leave_arr;
    public $rotation_arr;
    public $shift_db;
    public $shift_tbl = array( );
    public $overtime = null;
    public $salary_stamp = null;
    public $weekday_db = null;
    public $weekday_tbl = array( );
    public $count = 1;
    public $last_attendance = null;
    public $last_last_attendance = null;
    public $gate_in;
    public $gate_out;

    //constructor
    public function __construct()
    {
        global $prefix, $profile;
        $this->table = $prefix . "attendance";
        $this->id = "attendance_id";

        $basic = PluSQL::against( $profile )->run( "select * from {$prefix}fiscal_year where closed = 0 limit 0,1" );
        while ( $row = $basic->nextRow() )
        {
            $this->fiscal_year[ 'fiscal_year_id' ] = $row[ 'fiscal_year_id' ];
            $this->fiscal_year[ 'begin' ] = $row[ 'begin' ];
            $this->fiscal_year[ 'end' ] = $row[ 'end' ];
            $this->fiscal_year[ 'closed' ] = $row[ 'closed' ];
        }

        $basic = PluSQL::against( $profile )->run( "select * from {$prefix}holiday where fiscal_year_id = {$this->fiscal_year[ 'fiscal_year_id' ]}" );
        while ( $row = $basic->nextRow() )
        {
            $this->holiday_arr[ ] = $row;
        }
        $this->shift_db = new shift_model();
        $this->weekday_db = new weekday_model();
        $this->weekday_db->select( $this->weekday_tbl );

        $this->response = array
            (
            self::PERSONAL => self::PERSONAL,
            self::OFFICAL => self::OFFICAL,
            self::OUT_DOOR => self::OUT_DOOR,
            self::SHORT_LEAVE => self::SHORT_LEAVE,
            self::OVER_TIME => self::OVER_TIME,
            self::DOUBLE_OVER_TIME => self::DOUBLE_OVER_TIME,
            self::RELAX_TIME => self::RELAX_TIME
        );
        $this->issues = array
            (
            self::LATE_GATEIN => self::LATE_GATEIN,
            self::EARLY_GATEOUT => self::EARLY_GATEOUT,
            self::MISSING_GATEOUT => self::MISSING_GATEOUT,
            self::UNANNOUNCED_GATEOUT => self::UNANNOUNCED_GATEOUT,
            self::ALL_OK => self::ALL_OK,
            self::OVERTIME => self::OVERTIME
        );
        $this->con_arr = array
            (
            self::CONFIRMED => self::CONFIRMED,
            self::NOT_CONFIRMED => self::NOT_CONFIRMED
        );
        $this->gate_code = array
            (
            self::GATE_IN => self::GATE_IN,
            self::GATE_OUT => self::GATE_OUT,
            self::ABSENT => self::ABSENT,
            self::LEAVE => self::LEAVE,
            self::HOLIDAY => self::HOLIDAY
        );
    }

    //-----------------------------------------------------Attendance Marking Sheet Routines-----------------------------------------------------
    //converts id to hash
    public function id2hash( $id )
    {
        $id = ( string ) (100000 - ( int ) $id);
        $len = strlen( $id );
        for ( $i = 5; $i > $len; $i-- )
        {
            $id = "0" . $id;
        }
        $id = str_replace( $this->id_array, $this->hash_array, $id );
        return $id;
    }

    //converts hash back to id
    public function hash2id( $hash )
    {
        $hash = str_replace( $this->hash_array, $this->id_array, $hash );
        $hash = ( int ) (100000 - ( int ) $hash);
        return $hash;
    }

    //listen function for attendance
    public function listen( $hash )
    {
        $employee_id = $this->hash2id( $hash );
        $employee_tbl = array( );
        $success = 1;
        $error = 1;
        $path_to_picture = NO_IMAGE;
        $code = $first_name = $last_name = 'N/A';
        $employee_db = new employee_model();
        if ( $employee_db->select( $employee_id, employee_model::PERSONAL, $employee_tbl, array( 'enable_where' => 1 ) ) )
        {
            if ( $employee_tbl[ 'employee_status_id' ] <= EMPLOYEE_RESIGNATION ) //employee terminated or closed
            {
                $attendance_tbl = array( );
                if ( $this->select( $employee_id, $attendance_tbl ) )
                {
                    $error = 0;
                    $first_name = $employee_tbl[ 'first_name' ];
                    $last_name = $employee_tbl[ 'last_name' ];
                    $path_to_picture = $employee_tbl[ 'path_to_picture' ];
                    $code = self::GATE_IN;
                    if ( strcmp( $attendance_tbl[ 'code' ], 'GATE-IN' ) == 0 )
                    {
                        $code = self::GATE_OUT;
                    }
                    $json_array = array( 'picture' => $path_to_picture, 'first_name' => $first_name, 'last_name' => $last_name, 'code' => $code, 'success' => $success, 'error' => $error, 'timestamp' => date( 'Y-m-d H:i:s', time() ) );
                    $this->insert( $employee_id, $json_array );
                    return $json_array;
                }
                else
                {
                    //interval is not compelte
                    return array( 'picture' => $path_to_picture, 'first_name' => $first_name, 'last_name' => $last_name,
                        'code' => "Employee card cannot be scanned with in {$this->interval} seconds interval", 'success' => 0, 'error' => $error );
                }
            }
            else
            {
                // the employee is out of office
                return array( 'picture' => $path_to_picture, 'first_name' => $first_name, 'last_name' => $last_name,
                    'code' => "Employee status is not confirmed. Cannot register this entry", 'success' => 0, 'error' => $error );
            }
        }
        else
        {
            //in valid id
            return array( 'picture' => $path_to_picture, 'first_name' => $first_name, 'last_name' => $last_name,
                'code' => "Card ID is not valid. Cannot register this entry", 'success' => 0, 'error' => $error );
        }
    }

    //-----------------------------------------------------Attendance Processing Routines--------------------------------------------------------
    //Updates the overall attendance - used for manual update
    public function update_overdue_attendance( $employee_id = null, $department_id = null, $unit_id = null, $limit = "", $start_date = null, $end_date = null, $forced = false )
    {
        global $prefix, $profile;
        $arr = array(
            'employee_status_id' => array( 'table' => $prefix . 'employee', 'label' => 'employee_status_id', 'value' => array( array( 'value' => EMPLOYEE_CONFIRMATION, 'operator' => '<=', 'label' => 'employee_status_id', 'attachment' => 'and' ) ) ),
            'employee_id' => $employee_id,
            'department_id' => array( 'table' => $prefix . "department", 'label' => 'department_id', 'value' => $department_id ),
            'unit_id' => array( 'table' => $prefix . "unit", 'label' => 'unit_id', 'value' => $unit_id )
        );
        $sql = querygen_PluSQL( $prefix . "employee", $arr, array( 'enable_where' => 1 ) );
        $sql .= $limit;
        $basic = PluSQL::against( $profile )->run( $sql );
        while ( $row = $basic->nextRow() )
        {
            $this->update_employee_attendance( $row[ $prefix . "employee" . '$employee_id' ], $start_date, $end_date, $forced );
        }
    }

    //Update the attendance of single employee
    public function update_employee_attendance( $employee_id, $start_date = null, $end_date = null, $forced = false )
    {
        global $profile, $prefix;
        $breakup = array( );
        $transaction_code = EMPLOYEE_PAYROLL; //hard coded -- need to bring it through some other way
        $employee_db = new employee_model();
        $employee_transaction_db = new employee_transaction_model();
        $employee_transaction_tbl = array( );
        $employee_tbl_personal = array( );

        $employee_db->select( $employee_id, employee_model::PERSONAL, $employee_tbl_personal, array( 'enable_where' => 1 ) );
        $this->overtime = false;
        if ( strcmp( strtolower( $employee_tbl_personal[ 'overtime' ] ), 'allowed' ) == 0 )
        {
            $this->overtime = true;
        }

        $tpost = array( );
        $res = $employee_transaction_db->select_advanced( $transaction_code, array( 'employee_id' => $employee_id, 'transaction_code' => $transaction_code ), $tpost, array( 'orderBy' => 'employee_transaction_id DESC', 'limit' => '0,1', 'enable_where' => 1 ) );
        //-----------
        $now = timestamp_breakup( date( 'Y-m-d h:i:s', time() ) );
        $salary_paid_timestamp = "";
        if ( $res == false )
        {
            $salary_paid_timestamp = "{$now[ 'prev_year' ]}-{$now[ 'prev_month' ]}-01 00:00:00";
        }
        else if ( empty( $tpost[ 'transaction_timestamp1' ] ) )
        {
            $salary_paid_timestamp = "{$now[ 'prev_year' ]}-{$now[ 'prev_month' ]}-01 00:00:00";
        }
        else
        {
            $salary_paid_timestamp = convert_FA_to_MYSQL( $tpost[ 'transaction_timestamp2' ] ); //this should be the start of the month
        }
        $this->salary_stamp = get_date( $salary_paid_timestamp );

        $this->leave_arr = array( );
        $basic = PluSQL::against( $profile )->run( "select transaction_timestamp1 as start_date, transaction_timestamp2 as end_date, transaction_string2 as leave_type from {$prefix}employee_transaction 
            where transaction_dec1 = {$this->fiscal_year[ 'fiscal_year_id' ]} and transaction_code = " . EMPLOYEE_LEAVE . " and employee_id = $employee_id" );
        while ( $row = $basic->nextRow() )
        {
            $this->leave_arr[ ] = $row;
        }

        if ( $this->shift_db->select( $employee_tbl_personal[ 'shift_id' ], $this->shift_tbl ) )
        {
            $sql = $employee_transaction_db->search_advanced( array( 'employee_id' => $employee_id, 'transaction_code' => EMPLOYEE_SHIFT ), $employee_transaction_tbl, array( 'orderBy' => 'employee_transaction_id ASC', 'enable_where' => 1 ) );
            $basic = PluSQL::against( $profile )->run( $sql );
            $count = 1;
            $this->rotation_arr = array( );
            while ( $row = $basic->nextRow() )
            {
                if ( $count == 1 )
                {
                    $this->rotation_arr[ ] = array( 'transaction_timestamp' => date( 'Y-m-d h:i:s', strtotime( $employee_tbl_personal[ 'joining_date' ] ) ), 'transaction_int1' => $row[ 'transaction_int1' ], 'transaction_int2' => $row[ 'transaction_int1' ] );
                }
                $this->rotation_arr[ ] = $row;
                $count++;
            }
            if ( empty( $this->rotation_arr ) )
            {
                $this->rotation_arr[ ] = array( 'transaction_timestamp' => date( 'Y-m-d h:i:s', strtotime( $employee_tbl_personal[ 'joining_date' ] ) ), 'transaction_int1' => $employee_tbl_personal[ 'shift_id' ], 'transaction_int2' => $employee_tbl_personal[ 'shift_id' ] );
            }
            $now = timestamp_breakup( $this->fiscal_year[ 'end' ] . " 00:00:00" );
            if ( !is_null( $end_date ) )
            {
                $now = timestamp_breakup( $end_date );
            }
            $timestamp = timestamp_breakup( $this->fiscal_year[ 'begin' ] . " 00:00:00" );
            if ( !is_null( $start_date ) )
            {
                $timestamp = timestamp_breakup( $start_date );
            }
            $breakup = timestamp_diff( $now, $timestamp );
            foreach ( $breakup as &$break )
            {
                $break[ 'absents_count' ] = 0;
                $break[ 'late_minutes_count' ] = 0;
                $attendance_days = 1;
                if ( isset( $break[ 'START_MONTH' ] ) )
                {
                    $attendance_days = $break[ 'total_days' ];
                }
                else
                {
                    $attendance_days = $break[ 'days' ];
                }
                //work out the lates on the basis of shift rotation
                try
                {
                    $late_minutes_count = 0;
                    $absents_count = 0;
                    //--------------------------------------------------------
                    $table = $this->table;
                    $basic = PluSQL::from( $profile )->$table->select( "*" )->orderBy( 'timestamp ASC' )->where( "DATE(timestamp) >= '{$break[ 'year' ]}-{$break[ 'month' ]}-01' and DATE(timestamp) <= '{$break[ 'year' ]}-{$break[ 'month' ]}-$attendance_days' and employee_id = $employee_id" )->run()->$table;
                    $day = '';
                    $day_arr = array( );
                    foreach ( $basic as $attendance )
                    {
                        $temp = explode( ' ', $attendance->timestamp );
                        if ( empty( $day ) )
                        {
                            $next_day = "{$break[ 'year' ]}-{$break[ 'month' ]}-01";
                            $day = $temp[ 0 ];
                            while ( $next_day < $day )
                            {
                                $delay = $this->calculate_delays( $employee_id, $next_day, $day_arr, $forced );
                                if ( $delay == -1 )
                                {
                                    $absents_count += 1;
                                }
                                else
                                {
                                    $late_minutes_count += $delay;
                                }
                                $next_day = date( 'Y-m-d', strtotime( "+1 day", strtotime( $next_day ) ) );
                            }
                            $day_arr[ ] = $attendance;
                            continue;
                        }
                        else
                        {
                            if ( strcmp( $temp[ 0 ], $day ) == 0 ) //same day
                            {
                                $day_arr[ ] = $attendance;
                                continue;
                            }
                            else
                            {
                                $delay = $this->calculate_delays( $employee_id, $day, $day_arr, $forced );
                                if ( $delay == -1 )
                                {
                                    $absents_count += 1;
                                }
                                else
                                {
                                    $late_minutes_count += $delay;
                                }
                                $next_day = date( 'Y-m-d', strtotime( "+1 day", strtotime( $day ) ) );
                                $day = $temp[ 0 ];
                                $day_arr = array( );
                                //this is a new day
                                while ( $next_day < $day )
                                {
                                    $delay = $this->calculate_delays( $employee_id, $next_day, $day_arr, $forced );
                                    if ( $delay == -1 )
                                    {
                                        $absents_count += 1;
                                    }
                                    else
                                    {
                                        $late_minutes_count += $delay;
                                    }
                                    $next_day = date( 'Y-m-d', strtotime( "+1 day", strtotime( $next_day ) ) );
                                }
                                $day_arr[ ] = $attendance;
                            }
                        }
                    }
                    $delay = 1;
                    $delay = $this->calculate_delays( $employee_id, $day, $day_arr, $forced );
                    if ( $delay == -1 )
                    {
                        $absents_count += 1;
                    }
                    else
                    {
                        $late_minutes_count += $delay;
                    }
                    $break[ 'absents_count' ] = $absents_count * -1;
                    $break[ 'late_minutes_count' ] = $late_minutes_count;
                }
                catch ( Exception $e )
                {
                    
                }
            }
            return $breakup;
        }
    }

    //function that sets rotation on daily basis
    public function calculate_delays( $employee_id, $day, $day_arr, $forced = false )
    {
        $work_start_time = $work_end_time = $relax_start_time = $relax_end_time = '';
        $shift_days = 1;

        $prev_rotation = null;
        foreach ( $this->rotation_arr as $rotation )
        {
            $prev_rotation = $rotation;
            $temp1 = explode( ' ', trim( $rotation[ 'transaction_timestamp' ] ) );
            $rday = $temp1[ 0 ];
            if ( $day < $rday )
            {
                break;
            }
        }
        if ( $this->shift_tbl[ 'shift_id' ] != $prev_rotation[ 'transaction_int2' ] ) $this->shift_db->select( $prev_rotation[ 'transaction_int2' ], $this->shift_tbl );
        $date1 = new DateTime( $rday ); //inclusive
        $date2 = new DateTime( $day ); //exclusive
        $diff = $date2->diff( $date1 );
        $shift_days = $diff->format( "%a" );

        $rotation = false;
        if ( $this->shift_tbl[ 'rotation_flag' ] == 1 )
        {
            $div = floor( ($shift_days) / $this->shift_tbl[ 'rotation_interval' ] );
            if ( $div % 2 )
            {
                $rotation = true;
            }
            else
            {
                $rotation = false;
            }
        }

        if ( $rotation )
        {//the selected shift has a rotation
            $work_start_time = $this->shift_tbl[ 'rotation_shift_start' ];
            $work_end_time = $this->shift_tbl[ 'rotation_shift_end' ];
            $relax_start_time = $this->shift_tbl[ 'rotation_relax_start' ];
            $relax_end_time = $this->shift_tbl[ 'rotation_relax_end' ];
        }
        else
        {//the selected shift is not on rotation
            $work_start_time = $this->shift_tbl[ 'standard_shift_start' ];
            $work_end_time = $this->shift_tbl[ 'standard_shift_end' ];
            $relax_start_time = $this->shift_tbl[ 'standard_relax_start' ];
            $relax_end_time = $this->shift_tbl[ 'standard_relax_end' ];
        }
        //--------------------
        $delay = 1;
        $delay = $this->calculate_absents( $employee_id, $day, $day_arr, $forced );
        if ( $delay )
        {
            if ( $work_end_time <= $work_start_time )
            {
                $next_day = date( 'Y-m-d', strtotime( "+1 day", strtotime( $day ) ) );
                //we have overlapping shifts
                $work_start_time1 = $work_start_time;
                $work_end_time1 = "23:59:59";

                $work_start_time2 = "00:00:00";
                $work_end_time2 = $work_end_time;

                global $profile;
                $table = $this->table;

                $day_arr1 = array( );
                $day_arr2 = array( );

                $basic = PluSQL::from( $profile )->$table->select( "*" )->orderBy( 'timestamp ASC' )->where( "timestamp >= '$day $work_start_time1' and timestamp <= '$day $work_end_time1' and employee_id = $employee_id" )->run()->$table;
                foreach ( $basic as $attendance )
                {
                    $day_arr1[ ] = $attendance;
                }

                $basic = PluSQL::from( $profile )->$table->select( "*" )->orderBy( 'timestamp ASC' )->where( "timestamp >= '$next_day $work_start_time2' and timestamp <= '$next_day $work_start_time1' and employee_id = $employee_id" )->run()->$table;
                foreach ( $basic as $attendance )
                {
                    $day_arr2[ ] = $attendance;
                }

                $tmp1 = $this->calculate_attendance( $employee_id, $work_start_time1, $work_end_time1, $relax_start_time, $relax_end_time, $day, $day_arr1, $forced, 1 );
                $tmp2 = $this->calculate_attendance( $employee_id, $work_start_time2, $work_start_time1, $relax_start_time, $relax_end_time, $next_day, $day_arr2, $forced, 2 );
                return $tmp1 + $tmp2;
            }
            else
            {
                $tmp = $this->calculate_attendance( $employee_id, $work_start_time, $work_end_time, $relax_start_time, $relax_end_time, $day, $day_arr, $forced );
                return $tmp;
            }
        }
        return $delay;
    }

    //function which works out on the absents, holiays, CPL's, etc.
    public function calculate_absents( $employee_id, $day, $day_arr, $forced = false )
    {
        global $profile, $prefix;
        if ( $this->salary_stamp >= $day )
        {
            return 1;
        }
        $weekday = getdate( strtotime( $day ) );
        if ( !$this->weekday_tbl[ strtolower( $weekday[ 'weekday' ] ) ] )
        {
            foreach ( $day_arr as $d )
            {
                if ( ( strcmp( $d->code, self::ABSENT ) == 0 ) || ( strcmp( $d->code, self::LEAVE ) == 0 ) || ( strcmp( $d->code, self::GATE_IN ) == 0 ) || ( strcmp( $d->code, self::GATE_OUT ) == 0 ) )
                {
                    $this->delete( $d->attendance_id );
                }
            }
            $apost = array( 'employee_id' => $employee_id, 'gate_code' => self::NA, 'code' => self::HOLIDAY, 'timestamp' => $day . ' 00:00:00', 'attendance_dec1' => 1, 'attendance_string1' => $weekday[ 'weekday' ] . " Off (Company Holiday)" );
            $this->insert_advanced( $apost, array( ) );
            return 0;
        }
        //------------------------------
        foreach ( $this->holiday_arr as $holiday )
        {
            if ( ($holiday[ 'start_holiday' ] <= $day) && ($day <= $holiday[ 'end_holiday' ]) )
            {
                foreach ( $day_arr as $d )
                {
                    if ( ( strcmp( $d->code, self::ABSENT ) == 0 ) || ( strcmp( $d->code, self::LEAVE ) == 0 ) || ( strcmp( $d->code, self::GATE_IN ) == 0 ) || ( strcmp( $d->code, self::GATE_OUT ) == 0 ) )
                    {
                        $this->delete( $d->attendance_id );
                    }
                }
                $apost = array( 'employee_id' => $employee_id, 'gate_code' => self::NA, 'code' => self::HOLIDAY, 'timestamp' => $day . ' 00:00:00', 'attendance_dec1' => 1, 'attendance_string1' => $holiday[ 'name' ] );
                $this->insert_advanced( $apost, array( ) );
                return 0;
            }
        }
        //----------------------------------------
        //check if it is an offical leave
        foreach ( $this->leave_arr as $leave )
        {
            if ( ($leave[ 'start_date' ] <= $day . ' 00:00:00') && ($day . ' 00:00:00' <= $leave[ 'end_date' ]) )
            {
                foreach ( $day_arr as $d )
                {
                    if ( ( strcmp( $d->code, self::ABSENT ) == 0 ) || ( strcmp( $d->code, self::HOLIDAY ) == 0 ) || ( strcmp( $d->code, self::GATE_IN ) == 0 ) || ( strcmp( $d->code, self::GATE_OUT ) == 0 ) )
                    {
                        $this->delete( $d->attendance_id );
                    }
                }
                $apost = array( 'employee_id' => $employee_id, 'gate_code' => self::NA, 'code' => self::LEAVE, 'timestamp' => $day . ' 00:00:00', 'attendance_dec1' => 1, 'attendance_string1' => $leave[ 'leave_type' ] );
                $this->insert_advanced( $apost, array( ) );
                return 0;
            }
        }
        return 1;
    }

    //function that works out on the gate in's and gate out's
    function calculate_attendance( $employee_id, $shift_start, $shift_end, $relax_start, $relax_end, $day, $day_arr, $forced = false, $splitted = 0 )
    {
        global $profile;
        if ( $day >= date( 'Y-m-d', time() ) )
        {
            return 0;
        }
        $table = $this->table;
        $delay = 0;
        $gate_out = null;
        $gate_in = null;
        $start_overtime = null;
        $end_overtime = null;
        try
        {
            //we have some records for attendance
            $count = 1;
            $last_attendance = null;
            $last_last_attendance = null;
            $confirmed = false;
            if ( $splitted == 2 )
            {
                $count = $this->count;
                $last_attendance = $this->last_attendance;
                $last_last_attendance = $this->last_last_attendance;
                $gate_out = $this->gate_out;
                $gate_in = $this->gate_in;
            }
            foreach ( $day_arr as $attendance )
            {
                //remove this if clause
                $confirmed = 0;
                if ( $attendance->attendance_dec1 == 1 ) $confirmed = 1;
                if ( is_null( $attendance->attendance_int1 ) ) $confirmed = 0;
                if ( strcmp( $attendance->code, self::GATE_IN ) == 0 )
                {//gate in
                    if ( $confirmed && !$forced )
                    {
                        $delay += $this->return_delay( $attendance );
                        continue;
                    }
                    if ( $this->salary_stamp >= $day && !$forced )
                    {
                        $this->update_superior_confirmed( $attendance->attendance_id );
                        $delay += $this->return_delay( $attendance );
                        continue;
                    }
                    $gate_in = get_time( $attendance->timestamp );
                    if ( $count == 1 )
                    {
                        if ( get_time( $attendance->timestamp ) > $shift_start )
                        {//delay in coming to office
                            $arr[ ] = array( 'GATE-IN' => get_time( $attendance->timestamp ), 'GATE-OUT' => $shift_start );
                            $delay += $this->update_attendance_status( $attendance, end( $arr ), self::LATE_GATEIN, $forced );
                        }
                        else if ( $this->overtime && get_time( $attendance->timestamp ) < $shift_start )
                        {
                            if ( $start_overtime ) continue;
                            $start_overtime = 1;
                            $arr[ ] = array( 'GATE-IN' => get_time( $attendance->timestamp ), 'GATE-OUT' => $shift_start );
                            $delay += $this->update_attendance_status( $attendance, end( $arr ), self::OVERTIME, $forced );
                        }
                        else
                        {
                            $this->update_all_ok( $attendance->attendance_id );
                        }
                    }
                    else if ( $gate_out != null )
                    {
                        $arr[ ] = array( 'GATE-IN' => $gate_in, 'GATE-OUT' => $gate_out );
                        $delay += $this->update_attendance_status( $last_attendance, end( $arr ), self::UNANNOUNCED_GATEOUT, $forced );
                        $this->update_all_ok( $attendance->attendance_id );
                    }
                    else
                    {
                        $this->update_all_ok( $attendance->attendance_id );
                    }
                    $count++;
                }
                else if ( strcmp( $attendance->code, self::GATE_OUT ) == 0 )
                {//gate out
                    if ( $confirmed && !$forced )
                    {
                        $delay += $this->return_delay( $attendance );
                        continue;
                    }
                    if ( $this->salary_stamp >= $day && !$forced )
                    {
                        $this->update_superior_confirmed( $attendance->attendance_id );
                        $delay += $this->return_delay( $attendance );
                        continue;
                    }
                    if ( $count > 1 )
                    {
                        $gate_out = get_time( $attendance->timestamp );
                        $this->update_all_ok( $attendance->attendance_id );
                    }
                    $count++;
                }
                else
                {
                    if ( ( $confirmed && !$forced ) || ( $this->salary_stamp >= $day && !$forced ) )
                    {
                        if ( strcmp( $attendance->code, self::ABSENT ) == 0 )
                        {
                            if ( strcmp( $attendance->gate_code, self::PERSONAL ) == 0 )
                            {
                                return -1;
                            } //put the else code in this
                            else
                            {
                                return 0;
                            }
                        }
                        return 0;
                    }
                    $this->delete( $attendance->attendance_id );
                }
                $last_last_attendance = $last_attendance;
                $last_attendance = $attendance;
            }
            if ( $confirmed && !$forced ) return $delay;
            if ( $this->salary_stamp >= $day && !$forced ) return $delay;
            if ( $splitted == 1 )
            {
                $this->count = $count;
                $this->last_attendance = $last_attendance;
                $this->last_last_attendance = $last_last_attendance;
                $this->gate_out = $gate_out;
                $this->gate_in = $gate_in;
                return $delay;
            }
            if ( is_null( $gate_in ) )
            {
                $apost = array( 'timestamp' => $day . ' 00:00:00' );
                $this->absent_insert( $employee_id, $apost );
                return -1;
            }
            else if ( is_null( $gate_out ) )
            {
                $arr[ ] = array( 'GATE-OUT' => $shift_start, 'GATE-IN' => $shift_end );
                $delay += $this->update_attendance_status( $last_attendance, end( $arr ), self::MISSING_GATEOUT, $forced );
            }
            else
            {
                if ( $gate_out < $shift_end )
                {
                    $arr[ ] = array( 'GATE-OUT' => $gate_out, 'GATE-IN' => $shift_end );
                    if ( $gate_out < $gate_in )
                    {
                        $delay += $this->update_attendance_status( $last_attendance, end( $arr ), self::MISSING_GATEOUT, $forced );
                        $this->update_all_ok( $last_last_attendance->attendance_id );
                    }
                    else
                    {
                        $delay += $this->update_attendance_status( $last_attendance, end( $arr ), self::EARLY_GATEOUT, $forced );
                    }
                }
                else if ( $this->overtime && ($gate_out > $shift_end) )
                {
                    $arr[ ] = array( 'GATE-IN' => $shift_end, 'GATE-OUT' => $gate_out );
                    $delay += $this->update_attendance_status( $last_attendance, end( $arr ), self::OVERTIME, $forced );
                }
                else
                {
                    $this->update_all_ok( $last_attendance->attendance_id );
                }
            }
            return $delay;
        }
        catch ( Exception $e )
        {
            throw $e;
        }
    }

    //helper function which calculates delay on a specific gate-out and gate-in combination
    function return_delay( $attendance )
    {
        $delay = $attendance->attendance_int1;
        if ( is_null( $delay ) )
        {
            $delay = 0;
        }
        switch ( $attendance->gate_code )
        {
            case self::PERSONAL:
                if ( $delay > 0 ) $delay *= -1;
                return $delay;
                break;
            case self::OFFICAL:
            case self::OUT_DOOR:
            case self::SHORT_LEAVE:
                return 0;
                break;
            case self::OVERTIME:
                return abs( $delay );
                break;
            case self::DOUBLE_OVER_TIME:
                return abs( $delay ) + abs( $delay );
                break;
            case self::NA:
            case self::RELAX_TIME:
                return 0;
                break;
        }
    }

    //called when a value is all ok
    function update_all_ok( $attendance_id )
    {
        $this->update
                (
                $attendance_id, array
            (
            'attendance_string1' => self::ALL_OK,
            'gate_code' => self::NA,
            'attendance_dec1' => 1,
            'gate_in' => '00:00:00',
            'gate_out' => '00:00:00',
            'employee_comments' => 'N/A',
            'employee_confirmed' => self::CONFIRMED,
            'superior_comments' => 'N/A',
            'superior_confirmed' => self::CONFIRMED,
            'attendance_int1' => 0
                )
        );
    }

    //called when a superior confirms an employee attendance
    function update_superior_confirmed( $attendance_id )
    {
        $this->update
                (
                $attendance_id, array
            (
            'superior_confirmed' => self::CONFIRMED,
                )
        );
    }

    //updates the attendance status. Called to set the custom status
    function update_attendance_status( $attendance, $status, $string, $forced = false )
    {
        if ( !$forced )
        {
            if ( $attendance->attendance_dec1 == 1 )
            {
                return $attendance->attendance_int1;
            }
        }

        if ( (strcmp( $attendance->employee_confirmed, self::NOT_CONFIRMED ) == 0) || ($attendance->employee_confirmed == null) || $forced )
        {
            $this->update
                    (
                    $attendance->attendance_id, array
                (
                'gate_code' => (strcmp( $string, self::ALL_OK ) == 0) ? self::NA : self::PERSONAL,
                'gate_in' => $status[ 'GATE-IN' ],
                'gate_out' => $status[ 'GATE-OUT' ],
                'attendance_int1' => get_minutes( $status[ 'GATE-OUT' ], $status[ 'GATE-IN' ] ),
                'attendance_string1' => $string,
                'employee_confirmed' => self::NOT_CONFIRMED,
                'superior_confirmed' => self::NOT_CONFIRMED,
                'attendance_dec1' => 1
                    )
            );
            if ( strcmp( $attendance->gate_code, self::PERSONAL ) == 0 )
            {
                return get_minutes( $status[ 'GATE-OUT' ], $status[ 'GATE-IN' ] );
            }
        }

        return $attendance->attendance_int1;
    }

    //-----------------------------------------------------Search Routines-----------------------------------------------------------------------
    //function to search employee attendance for a specific month (employee view)
    function search_by_month_for_employee( $month, $employee_id, $only_issue = false )
    {
        global $prefix;
        return $this->search_advanced( array(
                    'timestamp' => $month,
                    'code' => null,
                    'attendance_string1' => null,
                    'gate_code' => (!$only_issue)?null:array('table' => $this -> table, 'label' => 'gate_code', 'value' => array(array('label' => 'gate_code','operator' => '!=','value' => self::NA,'attachment'=>'and'))),
                    'gate_out' => null,
                    'gate_in' => null,
                    'attendance_int1' => null,
                    'employee_confirmed' => null,
                    'employee_comments' => null,
                    'superior_confirmed' => null,
                    'superior_comments' => null,
                    'attendance_dec1' => 1,
                    'employee_id' => array( 'label' => 'attendance_id', 'table' => $prefix . 'attendance', 'value' => array( array( 'label' => 'employee_id', 'value' => $employee_id, 'operator' => '=', 'attachment' => 'and' ) ) ),
                    $this->id => ''
                        ), array( 'orderBy' => 'timestamp ASC' ) );
    }

    //function to search employee attendance for a specific month with the employee name (employee view)
    function search_by_month_for_employee_with_name( $month, $employee_id , $only_issue = false )
    {
        global $prefix;
        return $this->search_advanced( array(
                    'first_name' => array( 'table' => $prefix . 'employee', 'label' => 'first_name', 'value' => null ),
                    'last_name' => array( 'table' => $prefix . 'employee', 'label' => 'last_name', 'value' => null ),
                    'timestamp' => $month,
                    'code' => null,
                    'attendance_string1' => null,
                    'gate_code' => (!$only_issue)?null:array('table' => $this -> table, 'label' => 'gate_code', 'value' => array(array('label' => 'gate_code','operator' => '!=','value' => self::NA,'attachment'=>'and'))),
                    'gate_out' => null,
                    'gate_in' => null,
                    'attendance_int1' => null,
                    'employee_confirmed' => null,
                    'employee_comments' => null,
                    'attendance_dec1' => 1,
                    'employee_id' => array( 'label' => 'attendance_id', 'table' => $prefix . 'attendance', 'value' => array( array( 'label' => 'employee_id', 'value' => $employee_id, 'operator' => '=', 'attachment' => 'and' ) ) ),
                    $this->id => ''
                        ), array( 'orderBy' => 'timestamp ASC' ) );
    }

    //function to search employee attendance for a specific month (superior view)
    function search_by_month_for_superior( $month, $employee_id , $only_issue = false )
    {
        global $prefix;
        return $this->search_advanced( array(
                    'timestamp' => $month,
                    'code' => null,
                    'attendance_string1' => null,
                    'gate_code' => (!$only_issue)?null:array('table' => $this -> table, 'label' => 'gate_code', 'value' => array(array('label' => 'gate_code','operator' => '!=','value' => self::NA,'attachment'=>'and'))),
                    'gate_out' => null,
                    'gate_in' => null,
                    'attendance_int1' => null,
                    'employee_confirmed' => null,
                    'employee_comments' => null,
                    'superior_confirmed' => null,
                    'superior_comments' => null,
                    'attendance_dec1' => 1,
                    'employee_id' => array( 'label' => 'attendance_id', 'table' => $prefix . 'attendance', 'value' => array( array( 'label' => 'employee_id', 'value' => $employee_id, 'operator' => '=', 'attachment' => 'and' ) ) ),
                    $this->id => ''
                        ), array( 'orderBy' => 'timestamp ASC' ) );
    }

    //function to search employee attendance for a specific month with the employee name (superior view)
    function search_by_month_for_superior_with_name( $month, $employee_id, $only_issue = false )
    {
        global $prefix;
        return $this->search_advanced( array(
                    'first_name' => array( 'table' => $prefix . 'employee', 'label' => 'first_name', 'value' => null ),
                    'last_name' => array( 'table' => $prefix . 'employee', 'label' => 'last_name', 'value' => null ),
                    'timestamp' => $month,
                    'code' => null,
                    'attendance_string1' => null,
                    'gate_code' => (!$only_issue)?null:array('table' => $this -> table, 'label' => 'gate_code', 'value' => array(array('label' => 'gate_code','operator' => '!=','value' => self::NA,'attachment'=>'and'))),
                    'gate_out' => null,
                    'gate_in' => null,
                    'attendance_int1' => null,
                    'employee_confirmed' => null,
                    'employee_comments' => null,
                    'superior_confirmed' => null,
                    'superior_comments' => null,
                    'attendance_dec1' => 1,
                    'employee_id' => array( 'label' => 'attendance_id', 'table' => $prefix . 'attendance', 'value' => array( array( 'label' => 'employee_id', 'value' => $employee_id, 'operator' => '=', 'attachment' => 'and' ) ) ),
                    $this->id => ''
                        ), array( 'orderBy' => 'timestamp ASC' ) );
    }

    //default function for search
    function search( $first_name = null, $last_name = null, $department_id = null, $unit_id = null, $datestamp_start = null, $datestamp_end = null, $code = null, $attendance_issue = null, $gate_code = null, $employee_confirmed = null, $superior_confirmed = null
    )
    {
        global $prefix;
        $start_time = " 00:00:00";
        $end_time = " 23:59:59";
        if ( is_null( $datestamp_start ) || empty( $datestamp_start ) )
        {
            $start_time = '';
        }
        if ( is_null( $datestamp_end ) || empty( $datestamp_end ) )
        {
            $end_time = '';
        }
        return $this->search_advanced
                        (
                        array
                    (
                    'first_name' => array( 'table' => $prefix . "employee", 'label' => 'first_name', 'value' => '' ),
                    'last_name' => array( 'table' => $prefix . "employee", 'label' => 'last_name', 'value' => '' ),
                    'department_id' => array( 'table' => $prefix . "department", 'label' => 'name', 'value' => array( array( 'label' => 'department_id', 'attachment' => 'and', 'operator' => '=', 'value' => $department_id ) ) ),
                    'unit_id' => array( 'table' => $prefix . "unit", 'label' => 'name', 'value' => array( array( 'label' => 'unit_id', 'attachment' => 'and', 'operator' => '=', 'value' => $unit_id ) ) ),
                    'timestamp' => array( 'table' => $prefix . 'attendance', 'label' => 'timestamp', 'value' => array( array( 'label' => 'timestamp', 'attachment' => 'and', 'operator' => '>=', 'value' => $datestamp_start . $start_time ), array( 'label' => 'timestamp', 'attachment' => 'and', 'operator' => '<=', 'value' => $datestamp_end . $end_time ) ) ),
                    'code' => $code,
                    'attendance_string1' => $attendance_issue,
                    'gate_code' => $gate_code,
                    'employee_confirmed' => $employee_confirmed,
                    'employee_comments' => '',
                    'superior_confirmed' => $superior_confirmed,
                    'superior_comments' => '',
                    'employee_id' => array( 'table' => $prefix . 'attendance', 'label' => 'employee_id', 'value' => array( array( 'label' => 'employee_id', 'attachment' => 'and', 'operator' => '=', 'value' => $last_name ), array( 'label' => 'employee_id', 'attachment' => 'and', 'operator' => '=', 'value' => $first_name ) ) ),
                    $this->id => ''
                        ), array( 'join_type' => 1, 'enable_where' => 1, 'orderBy' => $prefix . 'unit.name ASC, ' . $prefix . 'department.name ASC, ' . $prefix . 'employee.first_name ASC, ' . $prefix . 'employee.last_name ASC, ' . $prefix . 'attendance.timestamp ASC ' )
        );
    }

    //gets the custom list for the current fiscal year months
    function search_fiscal_months( $fiscal_id, $after_now = false )
    {
        return fiscal_months( $fiscal_id, $after_now );
    }

    //the base function which is called for all the searches in this model
    function search_advanced( $arr, $args = array( ) )
    {
        $arr[ 'viewable' ] = 1;
        if(isset($arr[$this -> id]))
        {
            unset($arr[$this -> id]);
            $arr[$this -> id] = '';
        }
        return search_PluSQL( $this->table, $arr, $args );
    }

    //-----------------------------------------------------Select Family Routines----------------------------------------------------------------
    //The simplest select function
    function very_simple_select( &$post, $conditions, $args )
    {
        $args[ 'limit' ] = '0,1000';
        $args[ 'enable_where' ] = 1;
        $count = 1;
        try
        {
            $Myrow = select_PluSQL( $this->table, $conditions, $args );
            foreach ( $Myrow as $myrow )
            {
                if ( $count > 1 )
                {
                    delete_PluSQL( $this->table, $this->id, strip( $myrow->attendance_id ) );
                    continue;
                }
                $post[ 'attendance_id' ] = $myrow->attendance_id;
                $post[ 'employee_id' ] = $myrow->employee_id;
                $post[ 'timestamp' ] = $myrow->timestamp;
                $post[ 'code' ] = $myrow->code;
                $post[ 'attendance_int1' ] = $myrow->attendance_int1;
                $post[ 'attendance_dec1' ] = $myrow->attendance_dec1;
                $post[ 'attendance_string1' ] = $myrow->attendance_string1;
                $post[ 'attendance_timestamp1' ] = $myrow->attendance_timestamp1;
                $post[ 'gate_code' ] = $myrow->gate_code;
                $post[ 'employee_confirmed' ] = $myrow->employee_confirmed;
                $post[ 'employee_comments' ] = $myrow->employee_comments;
                $post[ 'superior_id' ] = $myrow->superior_id;
                $post[ 'superior_confirmed' ] = $myrow->superior_confirmed;
                $post[ 'superior_comments' ] = $myrow->superior_comments;
                $post[ 'gate_in' ] = $myrow->gate_in;
                $post[ 'gate_out' ] = $myrow->gate_out;
                $post[ 'viewable' ] = $myrow->viewable;
                $count++;
            }
            return true;
        }
        catch ( EmptySetException $e )
        {
            return false;
        }
    }

    //The simplest select function
    function simple_select( $id, &$post )
    {
        $myrow = select_PluSQL( $this->table, array( $this->id => strip( $id ), 'viewable' => 1 ), array( 'enable_where' => 1 ) );
        $post[ 'attendance_id' ] = $myrow->attendance_id;
        $post[ 'employee_id' ] = $myrow->employee_id;
        $post[ 'timestamp' ] = $myrow->timestamp;
        $post[ 'code' ] = $myrow->code;
        $post[ 'attendance_int1' ] = $myrow->attendance_int1;
        $post[ 'attendance_dec1' ] = $myrow->attendance_dec1;
        $post[ 'attendance_string1' ] = $myrow->attendance_string1;
        $post[ 'attendance_timestamp1' ] = $myrow->attendance_timestamp1;
        $post[ 'gate_code' ] = $myrow->gate_code;
        $post[ 'employee_confirmed' ] = $myrow->employee_confirmed;
        $post[ 'employee_comments' ] = $myrow->employee_comments;
        $post[ 'superior_id' ] = $myrow->superior_id;
        $post[ 'superior_confirmed' ] = $myrow->superior_confirmed;
        $post[ 'superior_comments' ] = $myrow->superior_comments;
        $post[ 'gate_in' ] = $myrow->gate_in;
        $post[ 'gate_out' ] = $myrow->gate_out;
    }

    //The special select which allows non-viewable entries
    function special_select( $id, &$post )
    {
        $myrow = select_PluSQL( $this->table, array( $this->id => strip( $id ) ), array( 'enable_where' => 1 ) );
        $post[ 'attendance_id' ] = $myrow->attendance_id;
        $post[ 'employee_id' ] = $myrow->employee_id;
        $post[ 'timestamp' ] = $myrow->timestamp;
        $post[ 'code' ] = $myrow->code;
        $post[ 'attendance_int1' ] = $myrow->attendance_int1;
        $post[ 'attendance_dec1' ] = $myrow->attendance_dec1;
        $post[ 'attendance_string1' ] = $myrow->attendance_string1;
        $post[ 'attendance_timestamp1' ] = $myrow->attendance_timestamp1;
        $post[ 'gate_code' ] = $myrow->gate_code;
        $post[ 'employee_confirmed' ] = $myrow->employee_confirmed;
        $post[ 'employee_comments' ] = $myrow->employee_comments;
        $post[ 'superior_id' ] = $myrow->superior_id;
        $post[ 'superior_confirmed' ] = $myrow->superior_confirmed;
        $post[ 'superior_comments' ] = $myrow->superior_comments;
        $post[ 'gate_in' ] = $myrow->gate_in;
        $post[ 'gate_out' ] = $myrow->gate_out;
    }

    //The select function which also ensures that we are not voilating the minimum delay policy
    function select( $id, &$post, $timestamp = null )
    {
        if ( is_null( $timestamp ) )
        {
            $time = time();
        }
        else
        {
            $time = strtotime( $timestamp );
        }
        global $prefix;
        try
        {
            $myrow = select_PluSQL
                    (
                    $this->table, array
                (
                'employee_id' => strip( $id ),
                'viewable' => 1,
                'interval' => array( 'table' => $prefix . 'attendance', 'label' => 'interval', 'value' =>
                    array( array( 'label' => "DATE_ADD(timestamp,INTERVAL +{$this->interval} SECOND)", 'attachment' => 'and', 'operator' => '>', 'value' => date( 'Y-m-d H:i:s', $time ) ) ) )
                    ), array( 'enable_where' => 1, 'skip_prefix' => 1 )
            );
            $post[ 'employee_id' ] = $myrow->employee_id;
            return false;
        }
        catch ( EmptySetException $e )
        {
            try
            {
                $myrow = select_PluSQL
                        (
                        $this->table, array
                    (
                    'employee_id' => strip( $id ),
                    'viewable' => 1,
                    'interval' =>
                    array
                        (
                        'table' => $prefix . 'attendance', 'label' => 'interval', 'value' =>
                        array
                            (
                            array( 'label' => "timestamp", 'attachment' => 'and', 'operator' => '>=', 'value' => date( 'Y-m-d', $time ) . " 00:00:00" ),
                            array( 'label' => "timestamp", 'attachment' => 'and', 'operator' => '<=', 'value' => date( 'Y-m-d', $time ) . " 23:59:59" )
                        )
                    )
                        ), array( 'orderBy' => 'attendance_id DESC', 'limit' => '0,1', 'enable_where' => 1 )
                );
                $post[ 'employee_id' ] = $myrow->employee_id;
                $post[ 'code' ] = $myrow->code;
                $post[ 'timestamp' ] = $myrow->timestamp;
            }
            catch ( EmptySetException $e )
            {
                $post[ 'code' ] = 'GATE-OUT';
            }
        }
        return true;
    }

    //-----------------------------------------------------Insert Family Routines----------------------------------------------------------------
    //Simplest Insert
    function insert( $employee_id, $post )
    {
        $arr = array
            (
            'employee_id' => $employee_id,
            'code' => $post[ 'code' ],
            'timestamp' => $post[ 'timestamp' ],
            'attendance_dec1' => 0,
            'attendance_string1' => self::ALL_OK,
            'gate_code' => self::NA,
            'employee_confirmed' => self::NOT_CONFIRMED,
            'superior_confirmed' => self::NOT_CONFIRMED,
            'attendance_int1' => 0,
            'gate_in' => '00:00:00',
            'gate_out' => '00:00:00',
        );
        return $this -> insert_advanced($arr, array( ) );
    }

    //Insert used for marking an absent 
    function absent_insert( $employee_id, $post )
    {
        $arr = array
            (
            'employee_id' => $employee_id,
            'code' => self::ABSENT,
            'timestamp' => $post[ 'timestamp' ],
            'attendance_dec1' => 1,
            'attendance_string1' => self::ABSENT,
            'gate_code' => self::PERSONAL,
            'employee_confirmed' => self::NOT_CONFIRMED,
            'superior_confirmed' => self::NOT_CONFIRMED,
            'attendance_int1' => 0,
            'gate_in' => '00:00:00',
            'gate_out' => '00:00:00',
        );
        return $this -> insert_advanced( $arr, array( ) );
    }

    //Function used for manual inserts
    function manual_insert( $post )
    {
        global $profile;
        if ( convert_FA_to_MYSQL( $post[ 'datestamp' ] ) >= date( 'Y-m-d', time() ) )
        {
            display_warning( "Additions in the current date are not allowed", true );
            return false;
        }
        if ( !$this->salary_stamp_check( null, $post[ 'datestamp' ], $post ) )
        {
            return false;
        }
        if ( $this->simple_insert( $post ) )
        { //correct the gate_ins and outs
            $code = null; //0 - gatein, 1 - gateout
            $ts = convert_FA_to_MYSQL( $post[ 'datestamp' ] );
            $employee_id = $post[ 'employee_id' ];
            $table = $this->table;
            $basic = PluSQL::from( $profile )->$table->select( "*" )->orderBy( 'timestamp ASC' )->where( "DATE(timestamp) >= '$ts' and DATE(timestamp) <= '$ts' and employee_id = $employee_id" )->run()->$table;
            foreach ( $basic as $attendance )
            {
                if ( ( strcmp( $attendance->code, self::GATE_IN ) == 0 ) || ( strcmp( $attendance->code, self::GATE_OUT ) == 0 ) )
                {
                    if ( is_null( $code ) )
                    {
                        $code = self::GATE_IN;
                    }
                    else if ( strcmp( $code, self::GATE_IN ) == 0 )
                    {
                        $code = self::GATE_OUT;
                    }
                    else
                    {
                        $code = self::GATE_IN;
                    }
                    //if ( ( strcmp( $attendance->code, $code ) != 0 ) )
                    {
                        $this->update( $attendance->attendance_id, array( 'code' => $code, 'attendance_dec1' => 0 ) );
                    }
                }
                else
                {
                    $this->update( $attendance->attendance_id, array( 'attendance_dec1' => 0 ) );
                }
            }
            $this->update_employee_attendance( $employee_id, $ts, $ts, false );
        }
        return true;
    }

    //Function used by the manual insert function
    function simple_insert( $post )
    {
        $apost = array( );
        $code = self::GATE_IN;
        $arr = array
            (
            'employee_id' => $post[ 'employee_id' ],
            'code' => $code,
            'timestamp' => convert_FA_to_MYSQL( $post[ 'datestamp' ] ) . ' ' . $post[ 'timestamp' ],
            'attendance_dec1' => 0
        );
        return $this -> insert_advanced($arr, array( ) );
    }

    //Function primarly used for inserting holidays,leaves,CPL's,etc
    function insert_advanced( $arr, $args = array( ) )
    {
        $apost = array( );
        if ( $this->very_simple_select( $apost, $arr, $args ) )
        {
            return update_PluSQL( $this->table, $arr, $this->id, strip( $apost[ 'attendance_id' ] ) );
        }
        else
        {
            return insert_advanced_PluSQL( $this->table, $arr, $this->id, array( ) );
        }
    }

    //-----------------------------------------------------Delete Family Routines----------------------------------------------------------------
    //Function that deletes the attendance's by makring them non-visible
    function delete( $id )
    {
        //if ( $this->salary_stamp_check( $id, null, array(), false ) )
        {
            update_PluSQL( $this->table, array( 'viewable' => 0, 'attendance_dec1' => 0 ), $this->id, strip( $id ) );
        }
    }

    //-----------------------------------------------------Update Family Routines----------------------------------------------------------------
    //Function that updates the record - simplest form possible
    function update( $id, $update, $args = array( ) )
    {
        //if ( $this->salary_stamp_check( $id, null, array(), false ) )
        {
            $update[ 'viewable' ] = 1;
            update_PluSQL( $this->table, $update, $this->id, strip( $id ) );
            return true;
        }
        return false;
    }

    //function used with manual attendance to update records
    function salary_stamp_check( $id, $dday = null, $arr = array( ), $echo = true )
    {
        $attendance_tbl = array( );
        if ( is_null( $dday ) )
        {
            $this->special_select( $id, &$attendance_tbl );
            $day = get_date( $attendance_tbl[ 'timestamp' ] );
        }
        else
        {
            $day = convert_FA_to_MYSQL( $dday );
            $attendance_tbl = $arr;
        }

        $employee_transaction_db = new employee_transaction_model();
        $tpost = array( );
        $transaction_code = EMPLOYEE_PAYROLL;
        $res = $employee_transaction_db->select_advanced( $transaction_code, array( 'employee_id' => $attendance_tbl[ 'employee_id' ], 'transaction_code' => $transaction_code ), $tpost, array( 'orderBy' => 'employee_transaction_id DESC', 'limit' => '0,1', 'enable_where' => 1 ) );
        //-----------
        $now = timestamp_breakup( date( 'Y-m-d h:i:s', time() ) );
        $salary_paid_timestamp = "";
        if ( $res == false )
        {
            $salary_paid_timestamp = "{$now[ 'prev_year' ]}-{$now[ 'prev_month' ]}-01 00:00:00";
        }
        else if ( empty( $tpost[ 'transaction_timestamp1' ] ) )
        {
            $salary_paid_timestamp = "{$now[ 'prev_year' ]}-{$now[ 'prev_month' ]}-01 00:00:00";
        }
        else
        {
            $salary_paid_timestamp = convert_FA_to_MYSQL( $tpost[ 'transaction_timestamp2' ] ); //this should be the start of the month
        }
        $this->salary_stamp = get_date( $salary_paid_timestamp );

        if ( $this->salary_stamp >= $day )
        {
            if ( $echo )
            {
                $msg = _( "The Salary has already been paid against this attendance entry. This cannot be updated" )
                        . "<br>" . _( "Please contact your System Administrator to resolve this issue." );
                display_error( $msg );
            }
            return false;
           
        }
        else
        {
            return true;
        }
    }

}

?>