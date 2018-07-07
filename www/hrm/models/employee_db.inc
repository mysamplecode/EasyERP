<?php

class employee_model
{

    const PERSONAL = 1;
    const SALARY_TERMS = 2;
    const HIERARCHY = 3;

    //---gets all the units from the table----
    public $table;
    public $id;

    public function __construct()
    {
        global $prefix;
        $this->table = $prefix . "employee";
        $this->id = "employee_id";
    }

    //---gets all the units from the table----
    function select( $id = null, $flag, &$post, $args = array( ) )
    {
        try
        {
            $myrow = select_PluSQL( $this->table, array( $this->id => strip( $id ) ), $args );
            $post[ 'unit_id' ] = $myrow->unit_id;
        }
        catch ( EmptySetException $e )
        {
            return false;
        }
        switch ( $flag )
        {
            case self::PERSONAL:
                $post[ 'unit_id' ] = $myrow->unit_id;
                $post[ 'department_id' ] = $myrow->department_id;
                $post[ 'designation_id' ] = $myrow->designation_id;
                $post[ 'shift_id' ] = $myrow->shift_id;
                $post[ 'employee_status_id' ] = $myrow->employee_status_id;
                $post[ 'title_id' ] = $myrow->title_id;
                $post[ 'first_name' ] = $myrow->first_name;
                $post[ 'last_name' ] = $myrow->last_name;
                $post[ 'primary_contact' ] = $myrow->primary_contact;
                $post[ 'secondary_contact' ] = $myrow->secondary_contact;
                $post[ 'cnic' ] = $myrow->cnic;
                $post[ 'date_of_birth' ] = convert_MYSQL_to_FA( $myrow->date_of_birth );
                $post[ 'sex' ] = $myrow->sex;
                $post[ 'marital_status' ] = $myrow->marital_status;
                $post[ 'native_language' ] = $myrow->native_language;
                $post[ 'blood_group' ] = $myrow->blood_group;
                $post[ 'religion' ] = $myrow->religion;
                $post[ 'guardian_first_name' ] = $myrow->guardian_first_name;
                $post[ 'guardian_last_name' ] = $myrow->guardian_last_name;
                $post[ 'guardian_relation' ] = $myrow->guardian_relation;
                $post[ 'joining_date' ] = convert_MYSQL_to_FA( $myrow->joining_date );
                $post[ 'path_to_cv' ] = $myrow->path_to_cv;
                $post[ 'path_to_picture' ] = $myrow->path_to_picture;
                $post[ 'permenant_address' ] = $myrow->permenant_address;
                $post[ 'temporary_address' ] = $myrow->temporary_address;
                $post[ 'domicile' ] = $myrow->domicile;
                $post[ 'city' ] = $myrow->city;
                $post[ 'country' ] = $myrow->country;
                $post[ 'nationality' ] = $myrow->nationality;
                $post[ 'disability' ] = $myrow->disability;
                $post[ 'remarks' ] = $myrow->remarks;
                $post[ 'overtime' ] = $myrow->overtime;
                break;
            case self::SALARY_TERMS:
                $post[ 'basic_salary' ] = empty( $post[ 'basic_salary' ] ) ? $myrow->basic_salary : $post[ 'basic_salary' ];
                $post[ 'salary_type' ] = empty( $post[ 'salary_type' ] ) ? $myrow->salary_type : $post[ 'salary_type' ];
                $post[ 'payment_method' ] = empty( $post[ 'payment_method' ] ) ? $myrow->payment_method : $post[ 'payment_method' ];
                $post[ 'bank_id' ] = empty( $post[ 'bank_id' ] ) ? $myrow->bank_id : $post[ 'bank_id' ];
                $post[ 'account_holder_name' ] = empty( $post[ 'account_holder_name' ] ) ? $myrow->account_holder_name : $post[ 'account_holder_name' ];
                $post[ 'account_holder_address' ] = empty( $post[ 'account_holder_address' ] ) ? $myrow->account_holder_address : $post[ 'account_holder_address' ];
                $post[ 'check_reciever' ] = empty( $post[ 'check_reciever' ] ) ? $myrow->check_reciever : $post[ 'check_reciever' ];
                $post[ 'advance' ] = empty( $post[ 'advance' ] ) ? $myrow->advance : $post[ 'advance' ];
                $post[ 'installment' ] = empty( $post[ 'installment' ] ) ? $myrow->installment : $post[ 'installment' ];
                $post[ 'paid_installment' ] = empty( $post[ 'paid_installment' ] ) ? $myrow->paid_installment : $post[ 'paid_installment' ];
                break;
            case self::HIERARCHY:
                $post[ 'reports_to' ] = empty( $post[ 'reports_to' ] ) ? $myrow->reports_to : $post[ 'reports_to' ];
                $post[ 'unit_id' ] = $myrow->unit_id;
                $post[ 'department_id' ] = $myrow->department_id;
                $post[ 'employee_id' ] = $myrow->employee_id;
                //--------------------------------------------------
                $employee_tbl = array( );
                $this->select( $post[ 'reports_to' ], self::PERSONAL, $employee_tbl );
                $post[ 'report_to_unit_id' ] = $employee_tbl[ 'unit_id' ];
                $post[ 'report_to_department_id' ] = $employee_tbl[ 'department_id' ];
                break;
        }
        return true;
    }

    //--------
    function search( $first_name = null, $last_name = null, $unit_id = null, $department_id = null, $designation_id = null )
    {
        global $prefix;
        return $this->search_advanced( array(
                    'first_name' => strip( $first_name ),
                    'last_name' => strip( $last_name ),
                    'unit_id' => array( 'table' => $prefix . 'unit', 'label' => 'name', 'value' => $unit_id ),
                    'deparmtent_id' => array( 'table' => $prefix . 'department', 'label' => 'name', 'value' => $department_id ),
                    'designation_id' => array( 'table' => $prefix . 'designation', 'label' => 'name', 'value' => $designation_id ),
                    $this->id => array( 'table' => $prefix . 'employee', 'label' => $this->id, 'value' => array( array( 'label' => 'employee_status_id', 'value' => EMPLOYEE_CLOSED, 'attachment' => 'and', 'operator' => '!=' ) ) )
                ) );
    }

    //--------
    function search_advanced( $arr, $args = array( ) )
    {
        return search_PluSQL( $this->table, $arr, $args );
    }

    //-------- 
    function insert( $flag, $post )
    {
        global $path_to_cv;
        global $path_to_picture;
        $arr = array( );
        switch ( $flag )
        {
            case self::PERSONAL:
                $arr = array
                    (
                    'unit_id' => $post[ 'unit_id' ],
                    'department_id' => $post[ 'department_id' ],
                    'designation_id' => $post[ 'designation_id' ],
                    'shift_id' => $post[ 'shift_id' ],
                    'employee_status_id' => $post[ 'employee_status_id' ],
                    'title_id' => $post[ 'title_id' ],
                    'first_name' => $post[ 'first_name' ],
                    'last_name' => $post[ 'last_name' ],
                    'primary_contact' => $post[ 'primary_contact' ],
                    'secondary_contact' => $post[ 'secondary_contact' ],
                    'cnic' => $post[ 'cnic' ],
                    'date_of_birth' => convert_FA_to_MYSQL( $post[ 'date_of_birth' ] ),
                    'sex' => $post[ 'sex' ],
                    'marital_status' => $post[ 'marital_status' ],
                    'native_language' => $post[ 'native_language' ],
                    'blood_group' => $post[ 'blood_group' ],
                    'religion' => $post[ 'religion' ],
                    'guardian_first_name' => $post[ 'guardian_first_name' ],
                    'guardian_last_name' => $post[ 'guardian_last_name' ],
                    'guardian_relation' => $post[ 'guardian_relation' ],
                    'joining_date' => convert_FA_to_MYSQL( $post[ 'joining_date' ] ),
                    'permenant_address' => $post[ 'permenant_address' ],
                    'temporary_address' => $post[ 'temporary_address' ],
                    'domicile' => $post[ 'domicile' ],
                    'city' => $post[ 'city' ],
                    'country' => $post[ 'country' ],
                    'nationality' => $post[ 'nationality' ],
                    'disability' => $post[ 'disability' ],
                    'overtime' => $post[ 'overtime' ],
                    'remarks' => $post[ 'remarks' ]
                );
                if ( isset( $_FILES[ 'path_to_cv' ] ) && !empty( $_FILES[ 'path_to_cv' ][ 'name' ] ) )
                {
                    $cv_name = "cv-" . uniqid();
                    $ext = explode( ".", $_FILES[ 'path_to_cv' ][ 'name' ] );
                    $cv_name = $cv_name . "." . $ext[ count( $ext ) - 1 ];
                    if ( !file_exists( $path_to_cv . $cv_name ) ) move_uploaded_file( $_FILES[ 'path_to_cv' ][ 'tmp_name' ], $path_to_cv . $cv_name );
                    $arr[ 'path_to_cv' ] = $post[ 'path_to_cv' ] = $path_to_cv . $cv_name;
                }
                if ( isset( $_FILES[ 'path_to_picture' ] ) && !empty( $_FILES[ 'path_to_picture' ][ 'name' ] ) )
                {
                    if ( $picname = save_resized_image( $path_to_picture, $_FILES[ 'path_to_picture' ] ) )
                    {
                        $arr[ 'path_to_picture' ] = $post[ 'path_to_picture' ] = $picname;
                    }
                }
                //insert conditions 
                $conds = array
                    (
                    'unit_id' => $post[ 'unit_id' ],
                    'department_id' => $post[ 'department_id' ],
                    'designation_id' => $post[ 'designation_id' ],
                    'shift_id' => $post[ 'shift_id' ],
                    'employee_status_id' => $post[ 'employee_status_id' ],
                    'title_id' => $post[ 'title_id' ],
                    'first_name' => $post[ 'first_name' ],
                    'last_name' => $post[ 'last_name' ]
                );
                break;
            case self::SALARY_TERMS:
                $arr = array
                    (
                    'basic_salary' => $post[ 'basic_salary' ],
                    'salary_type' => $post[ 'salary_type' ],
                    'payment_method' => $post[ 'payment_method' ],
                    'bank_id' => @$post[ 'bank_id' ],
                    'account_holder_name' => @$post[ 'account_holder_name' ],
                    'account_holder_address' => @$post[ 'account_holder_address' ],
                    'check_reciever' => @$post[ 'check_reciever' ],
                    'advance' => @$post[ 'advance' ],
                    'installment' => @$post[ 'installment' ],
                    'paid_installment' => @$post[ 'paid_installment' ],
                );
                break;
            case self::HIERARCHY:
                $arr = array
                    (
                    'reports_to' => $post[ 'reports_to' ]
                );
                break;
        }
        return insert_advanced_PluSQL( $this->table, $arr, $this->id, $conds );
    }

    //-----------
    function delete( $id, $flag = 1 )
    {
        switch ( $flag )
        {
            case self::PERSONAL:
            case self::SALARY_TERMS:
                $update = array
                    (
                    'employee_status_id' => EMPLOYEE_CLOSED
                );
                update_PluSQL( $this->table, $update, $this->id, strip( $id ) );
                //delete_PluSQL($this -> table,$this -> id,strip($id));
                break;
            case self::HIERARCHY:
                $update = array
                    (
                    'reports_to' => 'null'
                );
                update_PluSQL( $this->table, $update, $this->id, strip( $id ) );
                break;
        }
        return true;
    }

    //------------
    function update( $id, $flag, &$post )
    {
        global $path_to_cv;
        global $path_to_picture;
        $update = array( );
        switch ( $flag )
        {
            case self::PERSONAL:
                $update = array
                    (
                    'unit_id' => $post[ 'unit_id' ],
                    'department_id' => $post[ 'department_id' ],
                    'designation_id' => $post[ 'designation_id' ],
                    'shift_id' => $post[ 'shift_id' ],
                    'employee_status_id' => $post[ 'employee_status_id' ],
                    'title_id' => $post[ 'title_id' ],
                    'first_name' => $post[ 'first_name' ],
                    'last_name' => $post[ 'last_name' ],
                    'primary_contact' => $post[ 'primary_contact' ],
                    'secondary_contact' => $post[ 'secondary_contact' ],
                    'cnic' => $post[ 'cnic' ],
                    'date_of_birth' => convert_FA_to_MYSQL( $post[ 'date_of_birth' ] ),
                    'sex' => $post[ 'sex' ],
                    'marital_status' => $post[ 'marital_status' ],
                    'native_language' => $post[ 'native_language' ],
                    'blood_group' => $post[ 'blood_group' ],
                    'religion' => $post[ 'religion' ],
                    'guardian_first_name' => $post[ 'guardian_first_name' ],
                    'guardian_last_name' => $post[ 'guardian_last_name' ],
                    'guardian_relation' => $post[ 'guardian_relation' ],
                    'joining_date' => convert_FA_to_MYSQL( $post[ 'joining_date' ] ),
                    'permenant_address' => $post[ 'permenant_address' ],
                    'temporary_address' => $post[ 'temporary_address' ],
                    'domicile' => $post[ 'domicile' ],
                    'city' => $post[ 'city' ],
                    'country' => $post[ 'country' ],
                    'nationality' => $post[ 'nationality' ],
                    'disability' => $post[ 'disability' ],
                    'overtime' => $post[ 'overtime' ],
                    'remarks' => $post[ 'remarks' ]
                );
                if ( isset( $_FILES[ 'path_to_cv' ] ) && !empty( $_FILES[ 'path_to_cv' ][ 'name' ] ) )
                {
                    $cv_name = "cv-" . uniqid();
                    $ext = explode( ".", $_FILES[ 'path_to_cv' ][ 'name' ] );
                    $cv_name = $cv_name . "." . $ext[ count( $ext ) - 1 ];
                    move_uploaded_file( $_FILES[ 'path_to_cv' ][ 'tmp_name' ], $path_to_cv . $cv_name );
                    $update[ 'path_to_cv' ] = $post[ 'path_to_cv' ] = $path_to_cv . $cv_name;
                }
                if ( isset( $_FILES[ 'path_to_picture' ] ) && !empty( $_FILES[ 'path_to_picture' ][ 'name' ] ) )
                {
                    if ( $picname = save_resized_image( $path_to_picture, $_FILES[ 'path_to_picture' ] ) )
                    {
                        $update[ 'path_to_picture' ] = $post[ 'path_to_picture' ] = $picname;
                    }
                }
                break;
            case self::SALARY_TERMS:
                $update = array
                    (
                    'basic_salary' => $post[ 'basic_salary' ],
                    'salary_type' => $post[ 'salary_type' ],
                    'payment_method' => $post[ 'payment_method' ],
                    'bank_id' => @$post[ 'bank_id' ],
                    'account_holder_name' => @$post[ 'account_holder_name' ],
                    'account_holder_address' => @$post[ 'account_holder_address' ],
                    'check_reciever' => @$post[ 'check_reciever' ],
                    'advance' => @$post[ 'advance' ],
                    'installment' => @$post[ 'installment' ],
                    'paid_installment' => @$post[ 'paid_installment' ],
                );
                break;
            case self::HIERARCHY:
                $update = array
                    (
                    'reports_to' => $post[ 'reports_to' ]
                );
                break;
        }
        update_PluSQL( $this->table, $update, $this->id, strip( $id ) );
    }

}

?>