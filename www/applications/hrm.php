<?php

class hrm_app extends application
{

    function hrm_app()
    {
        $this->application( "hrm", _( $this->help_context = "&Human Resource" ), true );

        $this->add_module( _( "Transactions" ) );

        $this->add_module( _( "Inquiries and Reports" ) );

        $this->add_module( _( "Maintenance " ) );

        // submenus for transaction module
        $this->add_lapp_function( 0, _( "&Employee Entry" ), "hrm/transactions/transaction_employee.php", 'SA_HRM_EMPLOYEE_ENTRY', MENU_TRANSACTION );
        $this->add_lapp_function( 0, _( "&Confirmation Entry" ), "hrm/transactions/transaction_confirmation.php", 'SA_HRM_CONFIRMATION_ENTRY', MENU_TRANSACTION );
        $this->add_lapp_function( 0, _( "&Resignation Entry	" ), "hrm/transactions/transaction_resignation.php", 'SA_HRM_RESIGNATION_ENTRY', MENU_TRANSACTION );
        $this->add_lapp_function( 0, _( "&Termination Entry" ), "hrm/transactions/transaction_termination.php", 'SA_HRM_TERMINATION_ENTRY', MENU_TRANSACTION );
        $this->add_lapp_function( 0, _( "&Designation Entry	" ), "hrm/transactions/transaction_designation.php", 'SA_HRM_DESIGNATION_ENTRY', MENU_TRANSACTION );
        $this->add_lapp_function( 0, _( "&Penalty Entry" ), "hrm/transactions/transaction_penalty.php", 'SA_HRM_PENALTY_ENTRY', MENU_TRANSACTION );
        $this->add_lapp_function( 0, _( "&Leave Entry	" ), "hrm/transactions/transaction_leave.php", 'SA_HRM_LEAVE_ENTRY', MENU_TRANSACTION );
        $this->add_lapp_function( 0, _( "&Shift Change Entry	" ), "hrm/transactions/transaction_shift.php", 'SA_HRM_SHIFT_CHANGE_ENTRY', MENU_TRANSACTION );
        $this->add_rapp_function( 0, _( "P&rocess Payroll" ), "hrm/transactions/transaction_payroll.php", 'SA_HRM_PROCESS_PAYROLL', MENU_TRANSACTION );
        $this->add_rapp_function( 0, _( "&Final Settlement Entry	" ), "hrm/transactions/transaction_final_settlement.php", 'SA_HRM_FINAL_SETTLEMENT_ENTRY', MENU_TRANSACTION );
        $this->add_rapp_function( 0, _( "Salary C&hange Entry	" ), "hrm/transactions/transaction_salary.php", 'SA_HRM_SALARY_CHANGE_ENTRY', MENU_TRANSACTION );
        $this->add_rapp_function( 0, _( "&Advance Entry	" ), "hrm/transactions/transaction_advance.php", 'SA_HRM_ADVANCE_ENTRY', MENU_TRANSACTION );
        $this->add_rapp_function( 0, _( "&Installment Entry	" ), "hrm/transactions/transaction_installment.php", 'SA_HRM_INSTALLMENT_ENTRY', MENU_TRANSACTION );
        $this->add_rapp_function( 0, _( "CPL Entr&y	" ), "hrm/employee_entries.php", 'SA_HRM_CPL_ENTRY', MENU_TRANSACTION );
        $this->add_rapp_function( 0, _( "Attendance Confir&mation Entry	" ), "hrm/transactions/transaction_attendance_confirmation.php", 'SA_HRM_ATTENDANCE_CONFIRMATION_ENTRY', MENU_TRANSACTION );
        $this->add_rapp_function( 0, _( "Attendance Entry	" ), "hrm/transactions/transaction_attendance.php", 'SA_HRM_ATTENDANCE_ENTRY', MENU_TRANSACTION );
        $this->add_rapp_function( 0, _( "Employee Payroll Slip" ), "hrm/transactions/transaction_payroll_slip.php", 'SA_HRM_PAYROLL_SLIP', MENU_TRANSACTION );
        // submenus for Inquiries and Reports module
        $this->add_lapp_function( 1, _( "Overall Attendance Sheet" ), "hrm/inquires/inq_attendance.php", 'SA_HRM_ATTENDANCE_REPORT', MENU_ENTRY );
        $this->add_lapp_function( 1, _( "Monthly Attendance Sheet" ), "hrm/inquires/inq_employee_attendance.php", 'SA_HRM_EMPLOYEE_ATTENDANCE_REPORT', MENU_ENTRY );
        $this->add_rapp_function( 1, _( "Overall Payroll Sheet" ), "hrm/inquires/inq_payroll.php", 'SA_HRM_PAYROL_REPORT', MENU_ENTRY );
        $this->add_rapp_function( 1, _( "Monthly Payroll Sheet" ), "hrm/inquires/inq_employee_payroll.php", 'SA_HRM_EMPLOYEE_PAYROLL_REPORT', MENU_ENTRY );
        // submenus for Maintenance module
        $this->add_lapp_function( 2, _( "Add and Manage Units" ), "hrm/manage/add_manage_units.php", 'SA_HRM_UNITS', MENU_MAINTENANCE );
        $this->add_rapp_function( 2, _( "Add and Manage Departments	" ), "hrm/manage/add_manage_departments.php", 'SA_HRM_DEPARTMENTS', MENU_MAINTENANCE );
        $this->add_lapp_function( 2, _( "Add and Manage Titles	" ), "hrm/manage/add_manage_titles.php", 'SA_HRM_TITLES', MENU_MAINTENANCE );
        $this->add_rapp_function( 2, _( "Add and Manage Designations	" ), "hrm/manage/add_manage_designations.php", 'SA_HRM_DESIGNATIONS', MENU_MAINTENANCE );
        $this->add_lapp_function( 2, _( "Add and Manage Leaves	" ), "hrm/manage/add_manage_leaves.php", 'SA_HRM_LEAVES', MENU_MAINTENANCE );
        $this->add_lapp_function( 2, _( "Add and Manage Hierarchy	" ), "hrm/manage/add_manage_hierarchy.php", 'SA_HRM_HIERARCHY', MENU_MAINTENANCE );
        $this->add_lapp_function( 2, _( "Add and Manage Attendance" ), "hrm/manage/add_manage_attendance.php", 'SA_HRM_ATTENDANCE', MENU_MAINTENANCE );
        $this->add_rapp_function( 2, _( "Add and Manage Holidays" ), "hrm/manage/add_manage_holidays.php", 'SA_HRM_HOLIDAYS', MENU_MAINTENANCE );
        $this->add_lapp_function( 2, _( "Add and Manage Allowances" ), "hrm/manage/add_manage_allowance.php", 'SA_HRM_ALLOWANCES', MENU_MAINTENANCE );
        $this->add_rapp_function( 2, _( "Add and Manage Deductions" ), "hrm/manage/add_manage_deduction.php", 'SA_HRM_DEDUCTIONS', MENU_MAINTENANCE );
        $this->add_rapp_function( 2, _( "Add and Manage Banks" ), "hrm/manage/add_manage_banks.php", 'SA_HRM_BANKS', MENU_MAINTENANCE );
        $this->add_rapp_function( 2, _( "Add and Manage Shifts" ), "hrm/manage/add_manage_shifts.php", 'SA_HRM_SHIFTS', MENU_MAINTENANCE );
        $this->add_lapp_function( 2, _( "Add and Manage Weekdays" ), "hrm/manage/add_manage_weekdays.php", 'SA_HRM_WEEKDAYS', MENU_MAINTENANCE );
        //closure
        $this->add_extensions();
    }

}

?>