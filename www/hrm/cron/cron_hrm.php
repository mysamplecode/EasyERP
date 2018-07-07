<?php
$path_to_root = "../..";
//----include files------------
include_once($path_to_root . "/includes/plusql.inc");
include_once($path_to_root . "/includes/ui.inc");
include_once($path_to_root . "/includes/db/connect_db.inc");
include_once($path_to_root . "/includes/validation.inc");
include_once($path_to_root . "/hrm/models/hrm_db.inc");

$payroll_db = new employee_payroll_model();
$payroll_db -> update_overdue_payroll();

$attendance_db = new attendance_model();
$attendance_db -> update_overdue_attendance( null, null, null, "", null, null,  intval($argv[6]) );

?>