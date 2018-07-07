<?php
//controller specific db files
include_once($path_to_root . "/admin/db/fiscalyears_db.inc");
include_once($path_to_root . "/hrm/models/allowance_db.inc");
include_once($path_to_root . "/hrm/models/attendance_db.inc");
include_once($path_to_root . "/hrm/models/banks_db.inc");
include_once($path_to_root . "/hrm/models/deduction_db.inc");
include_once($path_to_root . "/hrm/models/departments_db.inc");
include_once($path_to_root . "/hrm/models/designations_db.inc");
include_once($path_to_root . "/hrm/models/employee_db.inc");
include_once($path_to_root . "/hrm/models/employee_status_db.inc");
include_once($path_to_root . "/hrm/models/employee_allowance_db.inc");
include_once($path_to_root . "/hrm/models/employee_deduction_db.inc");
include_once($path_to_root . "/hrm/models/employee_joining_db.inc");
include_once($path_to_root . "/hrm/models/employee_qualification_db.inc");
include_once($path_to_root . "/hrm/models/employee_reference_db.inc");
include_once($path_to_root . "/hrm/models/employee_dependent_db.inc");
include_once($path_to_root . "/hrm/models/employee_leave_db.inc");
include_once($path_to_root . "/hrm/models/employee_transaction_db.inc");
include_once($path_to_root . "/hrm/models/employee_payroll_db.inc");
include_once($path_to_root . "/hrm/models/holidays_db.inc");
include_once($path_to_root . "/hrm/models/leaves_db.inc");
include_once($path_to_root . "/hrm/models/shifts_db.inc");
include_once($path_to_root . "/hrm/models/titles_db.inc");
include_once($path_to_root . "/hrm/models/units_db.inc");
include_once($path_to_root . "/hrm/models/weekdays_db.inc");
//--------------
//---------defining codes for the trasactions-----------
define("EMPLOYEE_CONFIRMATION",2);
define("EMPLOYEE_RESIGNATION",3);
define("EMPLOYEE_TERMINATION",4);
define("EMPLOYEE_CLOSED",10);
define("EMPLOYEE_DESIGNATION",5);
define("EMPLOYEE_PENALTY",6);
define("EMPLOYEE_LEAVE",7);
define("EMPLOYEE_PAYROLL",8);
define("EMPLOYEE_SHIFT",9);
define("EMPLOYEE_SALARY",11);
define("EMPLOYEE_ADVANCE",12);
define("EMPLOYEE_INSTALLMENT",13);
define("EMPLOYEE_FINAL_SETTLEMENT",14);
?>