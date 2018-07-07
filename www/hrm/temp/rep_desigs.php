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
print_titles();


function print_titles()
{
    	global $path_to_root, $systypes_array;
 
		$destination = $_POST["printType"];
	if ($destination)
		include_once($path_to_root . "/reporting/includes/excel_report.inc");
	else
		include_once($path_to_root . "/reporting/includes/pdf_report.inc");

 
   

	$cols = array(0,30);

	$headers = array(_('#')); 
	$aligns = array('left');
	$params =   array( 	0 => '',
    			);
	$new_cols = array();
	$show_cols = array();
  $size_arr = array();
	if(!isset($_POST['remove_name'])){
		$headers[] = _("Name");
		$aligns[] = _("left");	
		$size_arr[] = 1;
		$show_cols[] = 'name';
	}
	if(!isset($_POST['remove_desc'])){
		$headers[] = _("Description");
		$aligns[] = _("center");	
		$size_arr[] = 2;
		$show_cols[] = 'descr';
	}
	if(!isset($_POST['remove_start'])){
		$headers[] = _("Start salary");
		$aligns[] = _("center");	
		$size_arr[] = 1;
		$show_cols[] = 'start';
	}
	if(!isset($_POST['remove_end'])){
		$headers[] = _("End salary");
		$aligns[] = _("center");	
		$size_arr[] = 1;
		$show_cols[] = 'end';
	} 
	if(!isset($_POST['remove_curency'])){
		$headers[] = _("Curency");
		$aligns[] = _("center");	
		$size_arr[] = 1;
		$show_cols[] = 'curency';
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
	$name = isset($_POST['DesigName']) ? $_POST['DesigName'] : null  ;
	$descr = isset($_POST['DesigDescr']) ? $_POST['DesigDescr'] : null  ;
	$start = isset($_POST['DesigStart']) ? $_POST['DesigStart'] : 0  ;
	$end = isset($_POST['DesigEnd']) ? $_POST['DesigEnd'] : 0  ;
	$curency = isset($_POST['DesigCurency']) ? $_POST['DesigCurency'] : 0  ;
	$compare_start = get_compare_sign($_POST['start_salary']);
	$compare_end = get_compare_sign($_POST['end_salary']);
	$cur_cond='';
	if($curency!=''){
	$cur_cond = " and curency like  ".db_escape($curency) ;

	}
		$conds =  "where
		name like ".db_escape('%'.$name.'%'). " and
		descr like ".db_escape('%'.$descr.'%'). " and
		start $compare_start ".db_escape($start ). "+0 and
		end  $compare_end ".db_escape($end). "+0 $cur_cond";
		if($name!=null)
			$params[] = array('text' => _('Designation name'), 'from' => $name, 'to' => '');
		if($descr!=null)
			$params[] = array('text' => _('Designation description'), 'from' =>$descr, 'to' => '');
		if($start!=0)
			$params[] = array('text' => _('Start salary '), 'from' => $compare_start.$start, 'to' => '');
		if($end!=null)
			$params[] = array('text' => _('End salary'), 'from' => $compare_end.$end, 'to' => '');
		if($curency!='')
			$params[] = array('text' => _('Curency'), 'from' => $curency, 'to' => '');
		
	}
    $rep = new FrontReport(_('Designations'), "Designations", user_pagesize());
    $rep->Font();
    $rep->Info($params, $cols, $headers, $aligns);
    $rep->NewPage();

	$grandtotal = array(0,0,0,0);


	$sql = "SELECT name,descr,start,end,curency FROM ".TB_PREF."designation $conds ";
	
	$sql .= " ORDER BY name"; 
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
