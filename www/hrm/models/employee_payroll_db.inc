<?php

class employee_payroll_model
{  //this class is mostly about the payroll transactions which are very complex.
    //so most of the functions include raw queries
    //---gets all the units from the table----

    public $table;
    public $id;
    private $employee_db;

    public function __construct()
    {
        global $prefix;
        $this->table = $prefix . "employee_payroll";
        $this->id = "employee_id"; //one big exception, keeping in mind the close relationship with the employee
        $this->employee_db = new employee_model();
        //if(!isset($_SESSION['PAYROLL_UPDATED']))
        {
            //$_SESSION['PAYROLL_UPDATED'] = 1;
        }
    }

    //--------
    function select_overdue_total( $transaction_code, $employee_id = null, $department_id = null, $unit_id = null, $limit = "" )
    {
        global $prefix, $profile;
        $query =
                "SELECT 
			SUM(" . $prefix . "employee_payroll.total) as tt
			FROM 
			" . $prefix . "employee_payroll 
			INNER JOIN " . $prefix . "employee ON " . $prefix . "employee.employee_id = " . $prefix . "employee_payroll.employee_id
			INNER JOIN " . $prefix . "department ON " . $prefix . "employee.department_id = " . $prefix . "department.department_id 
			INNER JOIN " . $prefix . "unit ON " . $prefix . "employee.unit_id = " . $prefix . "unit.unit_id
			";
        $wtrue = false;
        $where = "";
        if ( $unit_id != null )
        {
            $wtrue = true;
            $where .= "  " . $prefix . "unit.unit_id = " . $unit_id . " and";
        }
        if ( $department_id != null )
        {
            $wtrue = true;
            $where .= "  " . $prefix . "department.department_id = " . $department_id . " and";
        }
        if ( $employee_id != null )
        {
            $wtrue = true;
            $where .= "  " . $prefix . "employee.employee_id = " . $employee_id . " and";
        }
        if ( 1 )
        {
            $wtrue = true;
            $where .= "  " . $prefix . "employee.employee_status_id <= " . EMPLOYEE_CONFIRMATION . " and";
        }
        if ( $wtrue == true )
        {
            $where{strlen( $where ) - 1} = " ";
            $where{strlen( $where ) - 2} = " ";
            $where{strlen( $where ) - 3} = " ";
            $query .= " where $where";
        }
        $basic = PluSQL::against( $profile )->run( $query );
        while ( $row = $basic->nextRow() )
        {
            return $row[ "tt" ];
        }
        return "0.00";
    }
    //--------
    function select_overdue_payable( $transaction_code, $employee_id = null, $department_id = null, $unit_id = null, $limit = "" )
    {
        global $prefix, $profile;
        $query =
                "SELECT 
			SUM(" . $prefix . "employee_payroll.payable_salary) as tt
			FROM 
			" . $prefix . "employee_payroll 
			INNER JOIN " . $prefix . "employee ON " . $prefix . "employee.employee_id = " . $prefix . "employee_payroll.employee_id
			INNER JOIN " . $prefix . "department ON " . $prefix . "employee.department_id = " . $prefix . "department.department_id 
			INNER JOIN " . $prefix . "unit ON " . $prefix . "employee.unit_id = " . $prefix . "unit.unit_id
			";
        $wtrue = false;
        $where = "";
        if ( $unit_id != null )
        {
            $wtrue = true;
            $where .= "  " . $prefix . "unit.unit_id = " . $unit_id . " and";
        }
        if ( $department_id != null )
        {
            $wtrue = true;
            $where .= "  " . $prefix . "department.department_id = " . $department_id . " and";
        }
        if ( $employee_id != null )
        {
            $wtrue = true;
            $where .= "  " . $prefix . "employee.employee_id = " . $employee_id . " and";
        }
        if ( 1 )
        {
            $wtrue = true;
            $where .= "  " . $prefix . "employee.employee_status_id <= " . EMPLOYEE_CONFIRMATION . " and";
        }
        if ( $wtrue == true )
        {
            $where{strlen( $where ) - 1} = " ";
            $where{strlen( $where ) - 2} = " ";
            $where{strlen( $where ) - 3} = " ";
            $query .= " where $where";
        }
        $basic = PluSQL::against( $profile )->run( $query );
        while ( $row = $basic->nextRow() )
        {
            return $row[ "tt" ];
        }
        return "0.00";
    }
    //--------
    function update_overdue_payroll( $employee_id = null, $department_id = null, $unit_id = null, $limit = "", $forced = false )
    {
        global $prefix, $profile;
        $arr = array(
            'employee_id' => $employee_id,
            'department_id' => array( 'table' => $prefix . "department", 'label' => 'department_id', 'value' => $department_id ),
            'unit_id' => array( 'table' => $prefix . "unit", 'label' => 'unit_id', 'value' => $unit_id )
        );
        $sql = querygen_PluSQL( $prefix . "employee", $arr, array( 'enable_where' => 1 ) );
        $sql .= $limit;
        $basic = PluSQL::against( $profile )->run( $sql );
        while ( $row = $basic->nextRow() )
        {
            $this->update_employee_payroll( $row[ $prefix . "employee" . '$employee_id' ], $forced );
        }
    }

    //--------
    function update_employee_payroll( $employee_id, $forced = false, $force_skip = false)
    {
        global $profile, $prefix;
        $transaction_code = EMPLOYEE_PAYROLL; //hard coded -- need to bring it through some other way
        $exist = true;
        $skip = false;
        try
        {
            $temp = array( );
            $this->select( $employee_id, $temp );
            $tmp = explode( " ", $temp[ 'last_update_timestamp' ] );
            if ( strcmp( trim( $tmp[ 0 ] ), date( 'Y-m-d', time() ) ) == 0 )
            {//this has been updated on the very same day - return back
                $skip = true;
            }
        }
        catch ( EmptySetException $e )
        {
            $exist = false;
        }
        if(!$force_skip)
        {
            if ( $skip )
            {
                pr( "Skipping id = $employee_id" );
                return false;
            }
        }    
        $payroll_tbl = array( );
        $employee_tbl_personal = array( );
        $employee_tbl_salary = array( );
        $employee_transaction_db = new employee_transaction_model();
        $attendance_db = new attendance_model();
        $tpost = array( );
        $allowances_db = new employee_allowance_model();
        $deductions_db = new employee_deduction_model();
        //define the models
        $this->employee_db->select( $employee_id, employee_model::PERSONAL, $employee_tbl_personal, array( 'enable_where' => 1 ) );
        $this->employee_db->select( $employee_id, employee_model::SALARY_TERMS, $employee_tbl_salary, array( 'enable_where' => 1 ) );
        //start updating the payroll table
        $payroll_tbl[ 'employee_id' ] = $employee_id;
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
        $timestamp = timestamp_breakup( $salary_paid_timestamp );
        $breakup = timestamp_diff( $now, $timestamp );
        $overdue_days = 0;
        $basic_salary = 0;
        $org_basic_salary = 0;
        $payable_salary = 0;
        $allowances = 0;
        $deductions = 0;
        $late_minutes = 0;
        $absents = 0;
        $payable_late_minutes = 0;
        $payable_absents = 0;
        $advances = 0;
        $installments = 0;

        foreach ( $breakup as $break )
        {
            $attendance_days = 1;
            if ( isset( $break[ 'START_MONTH' ] ) )
            {
                $overdue_days += 0;
                $org_basic_salary += $employee_tbl_salary[ 'basic_salary' ];
                $basic_salary += $break[ 'total_days' ] * ($employee_tbl_salary[ 'basic_salary' ] / $break[ 'total_days' ]);
                $payable_salary += $break[ 'total_days' ] * ($employee_tbl_salary[ 'basic_salary' ] / $break[ 'total_days' ]);
                $attendance_days = $break[ 'total_days' ];
            }
            else if ( isset( $break[ 'SAME_MONTH' ] ) )
            {
                $overdue_days += $break[ 'days' ];
                $basic_salary += $break[ 'days' ] * ($employee_tbl_salary[ 'basic_salary' ] / $break[ 'total_days' ]);
                $payable_salary += 0;
                $attendance_days = $break[ 'days' ];
            }
            else
            {
                $overdue_days += $break[ 'days' ];
                $org_basic_salary += $employee_tbl_salary[ 'basic_salary' ];
                $basic_salary += $break[ 'days' ] * ($employee_tbl_salary[ 'basic_salary' ] / $break[ 'total_days' ]);
                $payable_salary += $break[ 'days' ] * ($employee_tbl_salary[ 'basic_salary' ] / $break[ 'total_days' ]);
                $attendance_days = $break[ 'days' ];
            }
            //---------allowances and deductions------------------
            if ( !isset( $break[ 'SAME_MONTH' ] ) )
            {
                $basic = PluSQL::against( $profile )->run( $allowances_db->search( $employee_id ) );
                while ( $myrow = $basic->nextRow() )
                {
                    foreach ( $myrow as $k => $i )
                    {
                        $temp = explode( '$', $k );
                        if ( strcmp( $temp[ 1 ], 'allowance_amount' ) == 0 )
                        {
                            $allowances += $myrow[ $k ];
                        }
                    }
                }
                $basic = PluSQL::against( $profile )->run( $deductions_db->search( $employee_id ) );
                while ( $myrow = $basic->nextRow() )
                {
                    foreach ( $myrow as $k => $i )
                    {
                        $temp = explode( '$', $k );
                        if ( strcmp( $temp[ 1 ], 'deduction_amount' ) == 0 )
                        {
                            $deductions += $myrow[ $k ];
                        }
                    }
                }
            }
            //---------advances and installments------------------
            if ( !isset( $break[ 'SAME_MONTH' ] ) )
            {
                $monstr = $break[ 'month' ];
                if ( $monstr < 10 )
                {
                    $monstr = '0' . $monstr;
                }
                $arr = array
                    (
                    'transaction_dec1' => null,
                    'transaction_dec2' => null,
                    'transaction_string1' => $break[ 'year' ] . '-' . $monstr,
                    'employee_id' => $employee_id,
                    'transaction_code' => EMPLOYEE_ADVANCE,
                );
                $basic = PluSQL::against( $profile )->run( $employee_transaction_db->search_advanced( $arr ) );
                while ( $myrow = $basic->nextRow() )
                {
                    $advances += $myrow[ $prefix . 'employee_transaction$transaction_dec2' ] - $myrow[ $prefix . 'employee_transaction$transaction_dec1' ];
                }
                $arr = array
                    (
                    'transaction_dec1' => null,
                    'transaction_dec2' => null,
                    'transaction_string1' => $break[ 'year' ] . '-' . $monstr,
                    'employee_id' => $employee_id,
                    'transaction_code' => EMPLOYEE_INSTALLMENT,
                );
                pr( $employee_transaction_db->search_advanced( $arr ) );
                $basic = PluSQL::against( $profile )->run( $employee_transaction_db->search_advanced( $arr ) );
                while ( $myrow = $basic->nextRow() )
                {
                    $installments += $myrow[ $prefix . 'employee_transaction$transaction_dec2' ] - $myrow[ $prefix . 'employee_transaction$transaction_dec1' ];
                }
            }
        }
        //--------------------------------
        $attendance = $attendance_db->update_employee_attendance( $employee_id, $salary_paid_timestamp, date( 'Y-m-d h:i:s', time() ), $forced );
        foreach ( $attendance as $break )
        {
            $month_days = $break[ 'total_days' ];
            $absents += $break[ 'absents_count' ] * ($employee_tbl_salary[ 'basic_salary' ] / $month_days);
            $late_minutes += ($break[ 'late_minutes_count' ] / 60 / 24) * ($employee_tbl_salary[ 'basic_salary' ] / $month_days);
            if ( !isset( $break[ 'SAME_MONTH' ] ) )
            {
                $payable_absents += $break[ 'absents_count' ] * ($employee_tbl_salary[ 'basic_salary' ] / $month_days);
                $payable_late_minutes += ($break[ 'late_minutes_count' ] / 60 / 24) * ($employee_tbl_salary[ 'basic_salary' ] / $month_days);
            }
        }

        $deductions *= -1;
        $installments *= -1;
        $payroll_tbl[ 'overdue_days' ] = $overdue_days;
        $payroll_tbl[ 'basic_salary' ] = $basic_salary;
        $payroll_tbl[ 'allowances' ] = $allowances;
        $payroll_tbl[ 'deductions' ] = $deductions;
        $payroll_tbl[ 'absents' ] = $absents;
        $payroll_tbl[ 'lates' ] = $late_minutes;
        $payroll_tbl[ 'advances' ] = $advances;
        $payroll_tbl[ 'installments' ] = $installments;
        $payroll_tbl[ 'field1' ] = $payable_absents;
        $payroll_tbl[ 'field2' ] = $payable_late_minutes;
        $payroll_tbl[ 'field3' ] = $org_basic_salary;
        //----------------------------------------------------------
        $payroll_tbl[ 'total' ] = $basic_salary + $allowances + $deductions + $absents + $late_minutes + $advances + $installments;
        $payroll_tbl[ 'payable_salary' ] = $payable_salary + $allowances + $deductions + $payable_absents + $payable_late_minutes + $advances + $installments;
        //exit(1);
        //update the database
        if ( $exist )
        {
            $this->update( $employee_id, $payroll_tbl );
        }
        else
        {
            $this->insert( $employee_id, $payroll_tbl );
        }
    }

    //---gets all the units from the table----
    function select( $employee_id = null, &$post )
    {
        $myrow = select_PluSQL( $this->table, array( $this->id => strip( $employee_id ) ), array( 'enable_where' => 1 ) );
        $post[ 'employee_id' ] = $myrow->employee_id;
        $post[ 'basic_salary' ] = $myrow->basic_salary;
        $post[ 'payable_salary' ] = $myrow->payable_salary;
        $post[ 'allowances' ] = $myrow->allowances;
        $post[ 'deductions' ] = $myrow->deductions;
        $post[ 'lates' ] = $myrow->lates;
        $post[ 'absents' ] = $myrow->absents;
        $post[ 'leaves' ] = $myrow->leaves;
        $post[ 'advances' ] = $myrow->advances;
        $post[ 'installments' ] = $myrow->installments;
        $post[ 'field1' ] = $myrow->field1;
        $post[ 'field2' ] = $myrow->field2;
        $post[ 'field3' ] = $myrow->field3;
        $post[ 'field4' ] = $myrow->field4;
        $post[ 'field5' ] = $myrow->field5;
        $post[ 'field6' ] = $myrow->field6;
        $post[ 'total' ] = $myrow->total;
        $post[ 'overdue_days' ] = $myrow->overdue_days;
        $post[ 'last_update_timestamp' ] = $myrow->last_update_timestamp;
    }

    //-------- 
    function insert( $employee_id, $post )
    {
        $arr = array
            (
            'employee_id' => $employee_id,
            'basic_salary' => @$post[ 'basic_salary' ],
            'payable_salary' => @$post[ 'payable_salary' ],
            'allowances' => @$post[ 'allowances' ],
            'deductions' => @$post[ 'deductions' ],
            'lates' => @$post[ 'lates' ],
            'absents' => @$post[ 'absents' ],
            'leaves' => @$post[ 'leaves' ],
            'advances' => @$post[ 'advances' ],
            'installments' => @$post[ 'installments' ],
            'field1' => @$post[ 'field1' ],
            'field2' => @$post[ 'field2' ],
            'field3' => @$post[ 'field3' ],
            'field4' => @$post[ 'field4' ],
            'field5' => @$post[ 'field5' ],
            'field6' => @$post[ 'field6' ],
            'total' => @$post[ 'total' ],
            'overdue_days' => @$post[ 'overdue_days' ]
        );
        $conds = array
                (
        );
        return insert_advanced_PluSQL( $this->table, $arr, $this->id, $conds );
    }

    //------------
    function update( $employee_id, $post )
    {
        $update = array
            (
            'employee_id' => $employee_id,
            'basic_salary' => @$post[ 'basic_salary' ],
            'payable_salary' => @$post[ 'payable_salary' ],
            'allowances' => @$post[ 'allowances' ],
            'deductions' => @$post[ 'deductions' ],
            'lates' => @$post[ 'lates' ],
            'absents' => @$post[ 'absents' ],
            'leaves' => @$post[ 'leaves' ],
            'advances' => @$post[ 'advances' ],
            'installments' => @$post[ 'installments' ],
            'field1' => @$post[ 'field1' ],
            'field2' => @$post[ 'field2' ],
            'field3' => @$post[ 'field3' ],
            'field4' => @$post[ 'field4' ],
            'field5' => @$post[ 'field5' ],
            'field6' => @$post[ 'field6' ],
            'total' => @$post[ 'total' ],
            'overdue_days' => @$post[ 'overdue_days' ]
        );
        update_PluSQL( $this->table, $update, $this->id, strip( $employee_id ) );
    }

    //--------
    function search_advanced( $arr, $args = array( ) )
    {
        return search_PluSQL( $this->table, $arr, $args );
    }

    //--------
    function search_payroll_overdue( $transaction_code, $employee_id = null, $department_id = null, $unit_id = null, $limit = "" )
    {
        global $prefix;
        $args = array( 'join_type' => 1, 'enable_where' => 1 );
        return $this->search_advanced( array(
                    'first_name' => array( 'table' => $prefix . 'employee', 'label' => 'first_name', 'value' => array( array( 'value' => $employee_id, 'label' => 'employee_id', 'operator' => '=', 'attachment' => 'and' ) ) ),
                    'field3' => '',
                    'allowances' => '',
                    'deductions' => '',
                    'field1' => '',
                    'field2' => '',
                    'advances' => '',
                    'installments' => '',
                    'payable_salary' => '',
                    'department_id' => array( 'table' => $prefix . 'department', 'label' => 'department_id', 'value' => $department_id ),
                    'unit_id' => array( 'table' => $prefix . 'unit', 'label' => 'unit_id', 'value' => $unit_id ),
                    'employee_status_id' => array( 'table' => $prefix . 'employee', 'label' => 'employee_status_id', 'value' =>
                        array( array( 'label' => 'employee_status_id', 'attachment' => 'and', 'operator' => '<=', 'value' => EMPLOYEE_CONFIRMATION ) ) ),
                    //'employee_status_id' => array('table' => $prefix.'employee','label' => 'employee_status_id', 'value' => array(array('value' => EMPLOYEE_CONFIRMATION,'label' => 'employee_status_id','operator' => '<=', 'attachment' => 'and'))),
                    $this->id => ''
                        ), $args );
    }

    //--------
    function search_payroll_history( $transaction_code, $employee_id = null, $department_id = null, $unit_id = null, $limit = "" )
    {
        global $prefix;
        $query =
                "SELECT 
			" . $prefix . "employee.first_name as employee_first_name,
			" . $prefix . "department.name as department_name,
			" . $prefix . "unit.name as unit_name,
			" . $prefix . "employee_payroll.total as employee_overdue_salary,
			" . $prefix . "employee_payroll.payable_salary as employee_payable_salary,
			" . $prefix . "employee_payroll.overdue_days as employee_overdue_days,
			et.transaction_dec1 as last_draw_salary,
			et.transaction_timestamp1 as salary_paid_timestamp,
			et.transaction_string1 as salary_paid_month,
			et.transaction_string2 as fiscal_year
			FROM 
			" . $prefix . "employee 
			INNER JOIN " . $prefix . "department ON " . $prefix . "employee.department_id = " . $prefix . "department.department_id 
			INNER JOIN " . $prefix . "unit ON " . $prefix . "employee.unit_id = " . $prefix . "unit.unit_id
			LEFT JOIN " . $prefix . "employee_payroll ON " . $prefix . "employee.employee_id = " . $prefix . "employee_payroll.employee_id 
			LEFT JOIN (
			    select * 
			    from " . $prefix . "employee_transaction 
			    RIGHT JOIN 
			    (
			        select MAX(employee_transaction_id) as m 
			        from " . $prefix . "employee_transaction 
			        group by transaction_code,employee_id
			    ) tt 
			    on 
			    (tt.m = " . $prefix . "employee_transaction.employee_transaction_id ) 
			    where transaction_code = $transaction_code 
			) et 
			ON (
			    (" . $prefix . "employee.employee_id = et.employee_id) 
			    AND 
			    (et.transaction_code = $transaction_code) 
			)";
        $wtrue = false;
        $where = "";
        if ( $unit_id != null )
        {
            $wtrue = true;
            $where .= "  " . $prefix . "unit.unit_id = " . $unit_id . " and";
        }
        if ( $department_id != null )
        {
            $wtrue = true;
            $where .= "  " . $prefix . "department.department_id = " . $department_id . " and";
        }
        if ( $employee_id != null )
        {
            $wtrue = true;
            $where .= "  " . $prefix . "employee.employee_id = " . $employee_id . " and";
        }
        if ( 1 )
        {
            $wtrue = true;
            $where .= "  " . $prefix . "employee.employee_status_id <= " . EMPLOYEE_CONFIRMATION . " and";
        }
        if ( $wtrue == true )
        {
            $where{strlen( $where ) - 1} = " ";
            $where{strlen( $where ) - 2} = " ";
            $where{strlen( $where ) - 3} = " ";
            $query .= " where $where";
        }
        return $query;
    }

}

/*
  //level 3
  SELECT
 *
  FROM
  0_employee
  INNER JOIN 0_department ON 0_employee.department_id = 0_department.department_id
  INNER JOIN 0_unit ON 0_employee.unit_id = 0_unit.unit_id
  LEFT JOIN (
  select *
  from 0_employee_transaction
  RIGHT JOIN
  (
  select MAX(employee_transaction_id) as m
  from 0_employee_transaction
  group by transaction_code,employee_id
  ) tt
  on
  (tt.m = 0_employee_transaction.employee_transaction_id )
  where transaction_code = 5
  ) et
  ON (
  (0_employee.employee_id = et.employee_id)
  AND
  (et.transaction_code = 5)
  );
  //level 2
  select *
  from 0_employee_transaction
  RIGHT JOIN
  (
  select MAX(employee_transaction_id) as m
  from 0_employee_transaction
  group by transaction_code,employee_id
  ) tt
  on
  (tt.m = 0_employee_transaction.employee_transaction_id )
  where transaction_code = 5 ;
  level 1
  select MAX(employee_transaction_id) as m
  from 0_employee_transaction
  group by transaction_code,employee_id;
 */
?>