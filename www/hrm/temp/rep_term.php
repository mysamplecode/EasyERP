<?php
 
$page_security = 'SA_CUSTPAYMREP';

// ----------------------------------------------------------------
// $ Revision:	2.0 $
// Creator:	Joe Hunt
// date_:	2005-05-19
// Title:	Customer Balances
// ----------------------------------------------------------------
$path_to_root = "../..";


//----------------------------------------------------------------------------------------------------

// trial_inquiry_controls();
print_units();

 
function print_units()
{
    	global $path_to_root, $systypes_array;
  
 
		include_once($path_to_root . "/reporting/includes/pdf_report.inc");

 $cols = array(0,30);

	$headers = array(_('#')); 
	$aligns = array('left');
	$params =   array(0=>'', array('text' => _(' '), 'from' =>'', 'to' => '' )
	 );
	$new_cols = array();
	$show_cols = array();
  $size_arr = array();
	if(!isset($_POST['remove_ename'])){
		$headers[] = _("Name");
		$aligns[] = _("left");	
		$size_arr[] = 1;
		$show_cols[] = 'ename';
	} 
	if(!isset($_POST['remove_dname'])){
		$headers[] = _("Designation");
		$aligns[] = _("left");	
		$size_arr[] = 1;
		$show_cols[] = 'dname';
	} 
	if(!isset($_POST['remove_depname'])){
		$headers[] = _("Department");
		$aligns[] = _("left");	
		$size_arr[] = 1;
		$show_cols[] = 'depname';
	} 
	if(!isset($_POST['remove_uname'])){
		$headers[] = _("Unit");
		$aligns[] = _("left");	
		$size_arr[] = 1;
		$show_cols[] = 'uname';
	} 
	if(!isset($_POST['remove_rr'])){
		$headers[] = _("Reason");
		$aligns[] = _("left");	
		$size_arr[] = 2;
		$show_cols[] = 'rr';
	} 
 
   
   $units_sizes = 530/array_sum($size_arr);
  foreach($size_arr as $us){
  $new_cols[] = $us*$units_sizes;
  
  }
  
	foreach($new_cols as $value){
		$cols[] = $cols[count($cols)-1] + $value;
	}
 	$conds = '';
	if(!isset($_POST['allRecords'])){
	$name = isset($_POST['SName']) ? $_POST['SName'] : null  ;
	$dep = isset($_POST['SUn']) ? $_POST['SUn'] : null  ;
	$unit = isset($_POST['SDep']) ? $_POST['SDep'] : null  ;
	$desig = isset($_POST['SDesig']) ? $_POST['SDesig'] : null  ;
	$reason = isset($_POST['SRes']) ? $_POST['SRes'] : null  ;
	$date = isset($_POST['SDate']) ? $_POST['SDate'] : null  ;
	 	$date_conds = '';
 
$sql = "SELECT   concat_ws(' ',".TB_PREF."employee.fname,".TB_PREF."employee.lname) as ename, ".TB_PREF."unit.name as uname,".TB_PREF."department.name as depname,".TB_PREF."designation.name as dname ,".TB_PREF."eterm.rr   from ".TB_PREF."employee inner join  ".TB_PREF."unit on ".TB_PREF."unit.id=".TB_PREF."employee.unitid  inner join ".TB_PREF."department on ".TB_PREF."department.id = ".TB_PREF."employee.depid inner join ".TB_PREF."designation on  ".TB_PREF."employee.desigid=".TB_PREF."designation.id inner join ".TB_PREF."eterm on  ".TB_PREF."eterm.eid=".TB_PREF."employee.id  where 
	concat_ws(' ',".TB_PREF."employee.fname,".TB_PREF."employee.lname)  like ".db_escape("%".$name."%")." and
	".TB_PREF."department.name like ".db_escape("%".$dep."%")." and
	".TB_PREF."unit.name like ".db_escape("%".$unit."%")." and
	".TB_PREF."designation.name  like ".db_escape("%".$desig."%")." and
	".TB_PREF."eterm.rr like ".db_escape("%".$reason."%")."  

  ";
	}
  	 
    $rep = new FrontReport(_('Resignation raports'), "Resignation raports", user_pagesize());
    $rep->Font();
    $rep->Info($params, $cols, $headers, $aligns);
    $rep->NewPage();
 

	$result = db_query($sql, "The customers could not be retrieved");
	$num_lines = 0;

	while ($myrow = db_fetch($result))
	{
		 
	 
	  	$num_lines++; 
		$rep->TextCol(0, 1, $num_lines);   
		$col_cnt = 1;
		foreach($show_cols as $sc){
			$rep->TextCol($col_cnt, $col_cnt+1, $myrow["$sc"]);   
			$col_cnt ++;
		}
				$rep->NewLine(1, 2);  
 
	 
	}   
	$rep->Line($rep->row  - 4);
	$rep->NewLine();
    $rep->End();
}

?>
