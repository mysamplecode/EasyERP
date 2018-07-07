<?php

class employee_transaction_model
{

    //---gets all the units from the table----
    public $table;
    private $employee_db;
    public $id;
    public $employee_payroll_db;

    public function __construct()
    {
        global $prefix;
        $this->table = $prefix . "employee_transaction";
        $this->employee_db = new employee_model();
        $this->id = "employee_transaction_id";
        $this -> employee_payroll_db = new employee_payroll_model();
    }

    //---gets all the units from the table----
    function select( $id = null, $transaction_code, &$post )
    {
        $myrow = select_PluSQL( $this->table, array( $this->id => strip( $id ) ) );

        $rpost = array( );
        $this->employee_db->select( $myrow->employee_id, employee_model::PERSONAL, $rpost );
        $post[ 'unit_id' ] = $rpost[ 'unit_id' ];
        $post[ 'department_id' ] = $rpost[ 'department_id' ];
        $post[ 'employee_id' ] = $myrow->employee_id;
        $post[ 'transaction_reason' ] = $myrow->transaction_reason;
        switch ( $transaction_code )
        {
            case EMPLOYEE_CONFIRMATION:
            case EMPLOYEE_TERMINATION:
                $post[ 'transaction_int1' ] = $myrow->transaction_int1;
                break;
            case EMPLOYEE_RESIGNATION:
                $post[ 'transaction_int1' ] = $myrow->transaction_int1;
                $post[ 'transaction_int2' ] = $myrow->transaction_int2;
                $post[ 'transaction_int3' ] = $myrow->transaction_int3;
                break;
            case EMPLOYEE_DESIGNATION:
                $post[ 'transaction_int1' ] = $myrow->transaction_int1;
                $post[ 'transaction_int2' ] = $myrow->transaction_int2;
                break;
            case EMPLOYEE_PENALTY:
                break;
            case EMPLOYEE_LEAVE:
                $post[ 'remaining_leave' ] = $myrow-> transaction_int1; //last remaining leaves
                $post[ 'deduct_leave' ] = $myrow-> transaction_int1 - $myrow-> transaction_int2; //new remianing leaves
                $post[ 'employee_leave_id' ] = $myrow-> transaction_int3;  //employee_leave type id
                $post[ 'leave_start_date' ] = convert_MYSQL_to_FA($myrow-> transaction_timestamp1) ;
                $post[ 'leave_end_date' ] = convert_MYSQL_to_FA($myrow-> transaction_timestamp2) ;
                break;
            case EMPLOYEE_PAYROLL:
                $post[ 'transaction_dec1' ] = $myrow->transaction_dec1;
                $post[ 'transaction_string1' ] = $myrow->transaction_string1;
                $post[ 'transaction_string2' ] = $myrow->transaction_string2;
                $post[ 'transaction_timestamp1' ] = convert_MYSQL_to_FA( $myrow->transaction_timestamp1 );
                $post[ 'transaction_timestamp2' ] = convert_MYSQL_to_FA( $myrow->transaction_timestamp2 );
                break;
            case EMPLOYEE_SHIFT:
                $post[ 'transaction_int1' ] = $myrow->transaction_int1;
                $post[ 'transaction_int2' ] = $myrow->transaction_int2;
                break;
            case EMPLOYEE_SALARY:
                $post[ 'transaction_dec1' ] = $myrow->transaction_dec1;
                $post[ 'transaction_dec2' ] = $myrow->transaction_dec2;
                break;
            case EMPLOYEE_ADVANCE:
            case EMPLOYEE_INSTALLMENT:
                $post[ 'transaction_dec1' ] = $myrow->transaction_dec1;
                $post[ 'transaction_dec2' ] = $myrow->transaction_dec2;
                $post[ 'transaction_string1' ] = $myrow->transaction_string1;
                break;
        }
        pr( "***************************************************************************8" );
        pr( $post );
    }

    function select_advanced( $transaction_code, $fields, &$post, $args = array( ) )
    {
        try
        {
            $args[ 'limit' ] = '0,1'; //forcing it to one record for this model
            $myrow = select_PluSQL( $this->table, $fields, $args );
            $post[ 'employee_transaction_id' ] = $myrow->employee_transaction_id;
            $post[ 'employee_id' ] = $myrow->employee_id;
            $post[ 'transaction_code' ] = $myrow->transaction_code;
            $post[ 'transaction_reason' ] = $myrow->transaction_reason;
            $post[ 'transaction_timestamp' ] = $myrow->transaction_timestamp;
            $post[ 'transaction_int1' ] = $myrow->transaction_int1;
            $post[ 'transaction_int2' ] = $myrow->transaction_int2;
            $post[ 'transaction_int3' ] = $myrow->transaction_int3;
            $post[ 'transaction_dec1' ] = $myrow->transaction_dec1;
            $post[ 'transaction_dec2' ] = $myrow->transaction_dec2;
            $post[ 'transaction_dec3' ] = $myrow->transaction_dec3;
            $post[ 'transaction_timestamp1' ] = ($myrow->transaction_timestamp1 != null) ? convert_MYSQL_to_FA( $myrow->transaction_timestamp1 ) : null;
            $post[ 'transaction_timestamp2' ] = ($myrow->transaction_timestamp2 != null) ? convert_MYSQL_to_FA( $myrow->transaction_timestamp2 ) : null;
            $post[ 'transaction_timestamp3' ] = ($myrow->transaction_timestamp3 != null) ? convert_MYSQL_to_FA( $myrow->transaction_timestamp3 ) : null;
            $post[ 'transaction_string1' ] = $myrow->transaction_string1;
            $post[ 'transaction_string2' ] = $myrow->transaction_string2;
            $post[ 'transaction_string3' ] = $myrow->transaction_string3;
            return true;
        }
        catch ( EmptySetException $e )
        {
            $post[ 'employee_transaction_id' ] = 0;
            $post[ 'employee_id' ] = 0;
            $post[ 'transaction_code' ] = 0;
            $post[ 'transaction_reason' ] = '';
            $post[ 'transaction_timestamp' ] = '0000-00-00 00:00:00';
            $post[ 'transaction_int1' ] = 0;
            $post[ 'transaction_int2' ] = 0;
            $post[ 'transaction_int3' ] = 0;
            $post[ 'transaction_dec1' ] = 0.0;
            $post[ 'transaction_dec2' ] = 0.0;
            $post[ 'transaction_dec3' ] = 0.0;
            $post[ 'transaction_timestamp1' ] = '0000-00-00 00:00:00';
            $post[ 'transaction_timestamp2' ] = '0000-00-00 00:00:00';
            $post[ 'transaction_timestamp3' ] = '0000-00-00 00:00:00';
            $post[ 'transaction_string1' ] = '';
            $post[ 'transaction_string2' ] = '';
            $post[ 'transaction_string3' ] = '';
            return false;
        }
    }

    //--------
    function search( $transaction_code, $first_name = null, $last_name = null, $unit_id = null, $department_id = null )
    {
        global $prefix;
        $args = array( 'join_type' => 1, 'skip_prefix' => 1 );
        $arr = array(
            'first_name' => array( 'table' => $prefix . 'employee', 'label' => $prefix . 'employee.'.'first_name', 'value' => $first_name ),
            'last_name' => array( 'table' => $prefix . 'employee', 'label' => $prefix . 'employee.'.'last_name', 'value' => $last_name ),
            'department_id' => array( 'table' => $prefix . 'department', 'label' => $prefix . 'department.'.'name', 'value' => $department_id ),
            'unit_id' => array( 'table' => $prefix . 'unit', 'label' => $prefix . 'unit.'.'name', 'value' => $unit_id ),
            'transaction_timestamp' => null );
        switch ( $transaction_code )
        {
            case EMPLOYEE_CONFIRMATION:
            case EMPLOYEE_TERMINATION:
            case EMPLOYEE_RESIGNATION:
            case EMPLOYEE_DESIGNATION:
                $arr[ 'transaction_string1' ] = null;
                $arr[ 'transaction_string2' ] = null;
                break;
            case EMPLOYEE_PENALTY:
            case EMPLOYEE_LEAVE:
                $arr[ 'transaction_string1' ] = null;
                $arr[ 'transaction_timestamp1' ] = array('table' => $prefix.'employee_transaction', 'label' => 'DATE(transaction_timestamp1)','value' => null);
                $arr[ 'transaction_timestamp2' ] = array('table' => $prefix.'employee_transaction', 'label' => 'DATE(transaction_timestamp2)','value' => null);
                $arr[ 'transaction_string2' ] = null;
                $arr[ 'transaction_dec2' ] = null;
                $arr[ 'transaction_int2' ] = null;
                //$args['skip_prefix'] = 1;
                break;
            case EMPLOYEE_PAYROLL:
                $arr[ 'transaction_dec1' ] = null;
                $arr[ 'transaction_string1' ] = null;
                $arr[ 'transaction_string2' ] = null;
                break;
            case EMPLOYEE_SHIFT:
                $arr[ 'transaction_string1' ] = null;
                $arr[ 'transaction_string2' ] = null;
                break;
            case EMPLOYEE_SALARY:
            case EMPLOYEE_ADVANCE:
            case EMPLOYEE_INSTALLMENT:
                $arr[ 'transaction_dec1' ] = null;
                $arr[ 'transaction_dec2' ] = null;
                break;
        }
        $arr[ 'transaction_code' ] = $transaction_code;
        $arr[ $this->id ] = '';
        return $this->search_advanced( $arr, $args );
    }

    //--------
    function search_advanced( $arr, $args = array( ) )
    {
        return search_PluSQL( $this->table, $arr, $args );
    }

    //-------- 
    function insert( $transaction_code, $post )
    {
        //update the related table
        $arr = array
            (
            'employee_id' => ($post[ 'employee_id' ]),
            'transaction_code' => ($transaction_code),
            'transaction_reason' => ($post[ 'transaction_reason' ])
        );
        switch ( $transaction_code )
        {
            case EMPLOYEE_CONFIRMATION:
                $rpost = array( );
                $this->employee_db->select( $post[ 'employee_id' ], employee_model::PERSONAL, $rpost );
                $old_status = $rpost[ 'employee_status_id' ];
                $rpost[ 'employee_status_id' ] = employee_status_model::CONFIRMED;
                $this->employee_db->update( $post[ 'employee_id' ], employee_model::PERSONAL, $rpost );
                $arr[ 'transaction_int1' ] = $old_status;
                break;
            case EMPLOYEE_RESIGNATION:
                $rpost = array( );
                $this->employee_db->select( $post[ 'employee_id' ], employee_model::PERSONAL, $rpost );
                $old_status = $rpost[ 'employee_status_id' ];
                $rpost[ 'employee_status_id' ] = employee_status_model::RESIGNED;
                $this->employee_db->update( $post[ 'employee_id' ], employee_model::PERSONAL, $rpost );
                $arr[ 'transaction_int1' ] = $old_status;
                $arr[ 'transaction_int2' ] = $post[ 'transaction_int2' ];
                $arr[ 'transaction_int3' ] = @$post[ 'transaction_int3' ];
                break;
            case EMPLOYEE_TERMINATION:
                $rpost = array( );
                $this->employee_db->select( $post[ 'employee_id' ], employee_model::PERSONAL, $rpost );
                $old_status = $rpost[ 'employee_status_id' ];
                $rpost[ 'employee_status_id' ] = employee_status_model::TERMINATED;
                $this->employee_db->update( $post[ 'employee_id' ], employee_model::PERSONAL, $rpost );
                $arr[ 'transaction_int1' ] = $old_status;
                break;
            case EMPLOYEE_DESIGNATION:
                $rpost = array( );
                $this->employee_db->select( $post[ 'employee_id' ], employee_model::PERSONAL, $rpost );
                $old_status = $rpost[ 'designation_id' ];
                $rpost[ 'designation_id' ] = $post[ 'new_designation' ];
                $this->employee_db->update( $post[ 'employee_id' ], employee_model::PERSONAL, $rpost );
                $arr[ 'transaction_int1' ] = $old_status;
                $arr[ 'transaction_int2' ] = $post[ 'new_designation' ];
                //save the designation names in the extra fields
                $dpost = array( );
                $designation_db = new designation_model();
                $designation_db->select( $old_status, $dpost );
                $arr[ 'transaction_string1' ] = $dpost[ 'name' ];
                $designation_db->select( $post[ 'new_designation' ], $dpost );
                $arr[ 'transaction_string2' ] = $dpost[ 'name' ];
                break;
            case EMPLOYEE_PENALTY:
                $arr[ 'transaction_int1' ] = $post[ 'remaining_leave' ]; //last remaining leaves
                $arr[ 'transaction_int2' ] = $post[ 'remaining_leave' ] - $post[ 'deduct_leave' ]; //new remianing leaves
                $arr[ 'transaction_int3' ] = $post[ 'employee_leave_id' ]; //employee_leave type id
                $fyear = get_current_fiscalyear();
                $arr[ 'transaction_dec1' ] = $fyear[ 'fiscal_year_id' ]; //fiscal year id 
                $arr[ 'transaction_dec2' ] = $post[ 'assigned_leave' ]; //assigned leaves
                $arr[ 'transaction_string1' ] = $fyear[ 'begin' ] . " to " . $fyear[ 'end' ]; //fiscal year string
                $arr[ 'transaction_string2' ] = $post[ 'leave_type' ]; //leaves type
                break;
            case EMPLOYEE_LEAVE:
                $arr[ 'transaction_int1' ] = $post[ 'remaining_leave' ]; //last remaining leaves
                $arr[ 'transaction_int2' ] = $post[ 'remaining_leave' ] - $post[ 'deduct_leave' ]; //new remianing leaves
                $arr[ 'transaction_int3' ] = $post[ 'employee_leave_id' ]; //employee_leave type id
                $fyear = get_current_fiscalyear();
                $arr[ 'transaction_dec1' ] = $fyear[ 'fiscal_year_id' ]; //fiscal year id 
                $arr[ 'transaction_dec2' ] = $post[ 'assigned_leave' ]; //assigned leaves
                $arr[ 'transaction_string1' ] = $fyear[ 'begin' ] . " to " . $fyear[ 'end' ]; //fiscal year string
                $arr[ 'transaction_string2' ] = $post[ 'leave_type' ]; //leaves type
                $arr[ 'transaction_timestamp1' ] = convert_FA_to_MYSQL( $post[ 'leave_start_date' ] );
                $arr[ 'transaction_timestamp2' ] = convert_FA_to_MYSQL( $post[ 'leave_end_date' ] );
                break;
            case EMPLOYEE_PAYROLL:
                global $prefix, $profile;
                $sql_arr = array(
                    'employee_id' => $_POST[ 'employee_id' ],
                    'employee_status_id' => array( 'table' => $prefix . 'employee', 'label' => 'employee_status_id', 'value' =>
                        array( array( 'label' => 'employee_status_id', 'attachment' => 'and', 'operator' => '<=', 'value' => EMPLOYEE_CONFIRMATION ) ) ),
                    'department_id' => array( 'table' => $prefix . "department", 'label' => 'department_id', 'value' => $_POST[ 'department_id' ] ),
                    'unit_id' => array( 'table' => $prefix . "unit", 'label' => 'unit_id', 'value' => $_POST[ 'unit_id' ] )
                );
                $sql = querygen_PluSQL( $prefix . "employee", $sql_arr, array( 'enable_where' => 1 ) );
                $basic = PluSQL::against( $profile )->run( $sql );
                $now = getdate();
                if ( $now[ 'mon' ] == 1 )
                {
                    $now[ 'mon' ] = 12;
                    $now[ 'year' ] = $now[ 'year' ] - 1;
                }
                else
                {
                    $now[ 'mon' ] = $now[ 'mon' ] - 1;
                }
                $mon = $now[ 'mon' ];
                if ( $mon < 10 )
                {
                    $mon = '0' . $mon;
                }
                $now = getdate( strtotime( $now[ 'year' ] . '-' . $mon . '-01' ) );
                $current = getdate();
                $cur = $current[ 'mon' ];
                if ( $cur < 10 )
                {
                    $cur = '0' . $cur;
                }
                $err_msg = true;
                while ( $row = $basic->nextRow() )
                {
                    $employee_id = $row[ $prefix . 'employee$employee_id' ];
                    $payroll_tbl = array( );
                    $this -> employee_payroll_db ->select( $employee_id, $payroll_tbl );
                    if ( $payroll_tbl[ 'payable_salary' ] > 0 )
                    {
                        $arr[ 'transaction_dump' ] = serialize( $payroll_tbl );
                        $arr[ 'transaction_dec1' ] = $payroll_tbl[ 'payable_salary' ];
                        $arr[ 'transaction_string1' ] = $now[ 'month' ];
                        $arr[ 'transaction_string2' ] = $now[ 'year' ];
                        $arr[ 'transaction_timestamp1' ] = convert_FA_to_MYSQL( $now[ 'year' ] . '-' . $mon . '-01' );
                        $arr[ 'transaction_timestamp2' ] = convert_FA_to_MYSQL( $current[ 'year' ] . '-' . $cur . '-01' );
                        $arr[ 'employee_id' ] = $employee_id;
                        insert_advanced_PluSQL( $this->table, $arr, $this->id );
                        pr( $arr );
                        $this -> employee_payroll_db -> update_employee_payroll($employee_id, false, true);
                    }
                    else
                    {
                        $employee_tbl_personal = array();
                        $this->employee_db->select( $employee_id, employee_model::PERSONAL, $employee_tbl_personal, array( 'enable_where' => 1 ) );
                        $msg = _( "{$employee_tbl_personal['first_name']}'s payable salary is zero. Request Ignored" );
                        display_error( $msg );
                        $err_msg = false;
                    }
                }
                
                return $err_msg;
                break;
            case EMPLOYEE_SHIFT:
                $rpost = array( );
                $this->employee_db->select( $post[ 'employee_id' ], employee_model::PERSONAL, $rpost );
                $old_status = $rpost[ 'shift_id' ];
                $rpost[ 'shift_id' ] = $post[ 'new_shift' ];
                $this->employee_db->update( $post[ 'employee_id' ], employee_model::PERSONAL, $rpost );
                $arr[ 'transaction_int1' ] = $old_status;
                $arr[ 'transaction_int2' ] = $post[ 'new_shift' ];
                //save the designation names in the extra fields
                $dpost = array( );
                $shift_db = new shift_model();
                $shift_db->select( $old_status, $dpost );
                $arr[ 'transaction_string1' ] = $dpost[ 'name' ];
                $designation_db->select( $post[ 'new_designation' ], $dpost );
                $arr[ 'transaction_string2' ] = $dpost[ 'name' ];
                break;
            case EMPLOYEE_SALARY:
                $rpost = array( );
                $this->employee_db->select( $post[ 'employee_id' ], employee_model::SALARY_TERMS, $rpost );
                $old_status = $rpost[ 'basic_salary' ];
                $rpost[ 'basic_salary' ] = $post[ 'new_salary' ];
                $this->employee_db->update( $post[ 'employee_id' ], employee_model::SALARY_TERMS, $rpost );
                $arr[ 'transaction_dec1' ] = $old_status;
                $arr[ 'transaction_dec2' ] = $post[ 'new_salary' ];
                break;
            case EMPLOYEE_ADVANCE:
                $rpost = array( );
                $this->employee_db->select( $post[ 'employee_id' ], employee_model::SALARY_TERMS, $rpost );
                $old_status = $rpost[ 'advance' ];
                $rpost[ 'advance' ] = $old_status + $post[ 'advance' ];
                $this->employee_db->update( $post[ 'employee_id' ], employee_model::SALARY_TERMS, $rpost );
                $arr[ 'transaction_dec1' ] = $old_status;
                $arr[ 'transaction_dec2' ] = $rpost[ 'advance' ];
                $arr[ 'transaction_string1' ] = $post[ 'fiscal_month' ];
                break;
            case EMPLOYEE_INSTALLMENT:
                $rpost = array( );
                $this->employee_db->select( $post[ 'employee_id' ], employee_model::SALARY_TERMS, $rpost );
                $old_status = $rpost[ 'installment' ];
                $rpost[ 'installment' ] = $old_status + $post[ 'installment' ];
                $this->employee_db->update( $post[ 'employee_id' ], employee_model::SALARY_TERMS, $rpost );
                $arr[ 'transaction_dec1' ] = $old_status;
                $arr[ 'transaction_dec2' ] = $rpost[ 'installment' ];
                $arr[ 'transaction_string1' ] = $post[ 'fiscal_month' ];
                break;
        }
        return insert_advanced_PluSQL( $this->table, $arr, $this->id );
    }

    //-----------
    function delete( $id, $transaction_code )
    {
        //get the details for the current id
        $post = array( );
        $this->select( $id, $transaction_code, $post );
        $employee_id = strip( $post[ 'employee_id' ] );
        //now search for the latest record against the employee
        $tpost = array( );
        $res = $this->select_advanced( $transaction_code, array( 'employee_id' => $employee_id ), $tpost, array( 'orderBy' => 'employee_transaction_id DESC' ) );
        if ( $tpost[ 'employee_transaction_id' ] > $id && $res )
        {
            display_error( _( "There is transaction more latest then this one. Cannot delete this entry" ) );
            //for the same employee we have transaction which is more latest then this one, so cannot delete
            return false;
        }
        else
        {
            //we are ok to delete but need to update the old status which is saved in transaction_int1
            $rpost = array( );
            $spost = array( );
            $this->employee_db->select( $post[ 'employee_id' ], employee_model::PERSONAL, $rpost );
            $this->employee_db->select( $post[ 'employee_id' ], employee_model::SALARY_TERMS, $spost );
            switch ( $transaction_code )
            {
                case EMPLOYEE_CONFIRMATION:
                case EMPLOYEE_TERMINATION:
                case EMPLOYEE_RESIGNATION:
                    $rpost[ 'employee_status_id' ] = $post[ 'transaction_int1' ];
                    break;
                case EMPLOYEE_DESIGNATION:
                    $rpost[ 'designation_id' ] = $post[ 'transaction_int1' ];
                    break;
                case EMPLOYEE_PENALTY:
                case EMPLOYEE_LEAVE:
                    break;
                case EMPLOYEE_PAYROLL:
                    break;
                case EMPLOYEE_SHIFT:
                    $rpost[ 'shift_id' ] = $post[ 'transaction_int1' ];
                    break;
                case EMPLOYEE_SALARY:
                    $spost[ 'basic_salary' ] = $post[ 'transaction_dec1' ];
                    break;
                case EMPLOYEE_ADVANCE:
                    $spost[ 'advance' ] = $spost[ 'advance' ] - $post[ 'transaction_dec1' ];
                    break;
                case EMPLOYEE_INSTALLMENT:
                    $spost[ 'installment' ] = $spost[ 'installment' ] - $post[ 'transaction_dec1' ];
                    break;
            }
            $this->employee_db->update( $post[ 'employee_id' ], employee_model::PERSONAL, $rpost );
            $this->employee_db->update( $post[ 'employee_id' ], employee_model::SALARY_TERMS, $spost );
            //now we can safely delete this entry
            delete_PluSQL( $this->table, $this->id, strip( $id ) );
            return true;
        }
    }

    //------------
    function update( $id, $transaction_code, $post )
    {
        $etpost = array( );
        $this->select( $id, $transaction_code, $etpost );
        $employee_id = strip( $etpost[ 'employee_id' ] );
        $tpost = array( );
        $res = $this->select_advanced( $transaction_code, array( 'employee_id' => $employee_id ), $tpost, array( 'orderBy' => 'employee_transaction_id DESC' ) );
        if ( $tpost[ 'employee_transaction_id' ] > $id && $res )
        {
            display_error( _( "There is transaction more latest then this one. Cannot update this entry" ) );
            //for the same employee we have transaction which is more latest then this one, so cannot delete
            return false;
        }
        $update = array
            (
            'transaction_reason' => ($post[ 'transaction_reason' ])
        );
        switch ( $transaction_code )
        {
            case EMPLOYEE_CONFIRMATION:
                break;
            case EMPLOYEE_RESIGNATION:
                $update[ 'transaction_int2' ] = $post[ 'transaction_int2' ];
                $update[ 'transaction_int3' ] = @$post[ 'transaction_int3' ];
                break;
            case EMPLOYEE_TERMINATION:
            case EMPLOYEE_DESIGNATION:
            case EMPLOYEE_PENALTY:
            case EMPLOYEE_LEAVE:
                break;
            case EMPLOYEE_PAYROLL:
                break;
            case EMPLOYEE_SALARY:
            case EMPLOYEE_SHIFT:
            case EMPLOYEE_ADVANCE:
            case EMPLOYEE_INSTALLMENT:
                break;
        }
        update_PluSQL( $this->table, $update, $this->id, strip( $id ) );
        return true;
    }

}
?>

