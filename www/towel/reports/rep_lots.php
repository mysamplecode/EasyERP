<?php
 
$page_security = 'SS_TOWELM';

// ----------------------------------------------------------------
// $ Revision:	2.0 $
// Creator:	Joe Hunt
// date_:	2005-05-19
// Title:	Customer Balances
// ----------------------------------------------------------------
$path_to_root = "../..";


//----------------------------------------------------------------------------------------------------
$m = "Print";
		foreach ($_POST as $p => $pvar) {
			if (strpos($p, $m) === 0) {
        $pid = strtr(substr($p, strlen($m)), array('%2E'=>'.'));
			//	unset($_POST['_focus']); // focus on first form entry
				$pid = quoted_printable_decode(substr($p, strlen($m)));
			//	$Ajax->activate('_page_body');
      //		$Mode = $m;
		 
			}
    } 
// trial_inquiry_controls();
if(isset($pid)){
 
  if($pid>0){
  
  print_lot($pid); 
  die();

  
 }
}
function print_lot($id)
{
  global $path_to_root, $systypes_array; 
	//$destination = $_POST["printType"];
	//if ($destination)
	//include_once($path_to_root . "/reporting/includes/excel_report.inc");
    //else
	include_once($path_to_root . "/reporting/includes/pdf_report.inc");
    
	$cols = array(0,120,170,220,270,320,400,460,520,550);

	$params =   array( 	0 => '',
    			);
	$params[] = array('text' => _('#'), 'from' => get_ent_name('lno','tlots',$id), 'to' => '');
	$params[] = array('text' => _('Description'), 'from' => get_ent_name('descr','tlots',$id), 'to' => '');
	$params[] = array('text' => _('Process Date'), 'from' =>  date("m/d/Y",get_ent_name('pdate','tlots',$id)), 'to' => ''); 
	 $params[] = array('text' => _('Steps'), 'from' => get_steps_string($id), 'to' => ''); 
	 
	 
	$headers = array(_('Towel Size'),_('Bale'),_('Pally'),_('Gross Wt'),_('Net Wt'),_('Shade'),_('Tag info'),_('Remarks'),_('Type')); 
	$aligns = array('left','left','left','left','left','left','left','left','left');
    $rep = new FrontReport(_('Inventory'), "Inventory", user_pagesize());
    $rep->Font();
    
    $rep->Info($params, $cols, $headers, $aligns);
    $rep->NewPage();
  
	$sql = "select ".TB_PREF."tsize.name, ".TB_PREF."tbales.bale, ".TB_PREF."tbales.gweight, ".TB_PREF."tbales.nweight, ".TB_PREF."tbales.shade, ".TB_PREF."tbales.pally, ".TB_PREF."tbales.taginfo, ".TB_PREF."tbales.remarks, ".TB_PREF."tbales.ptype,".TB_PREF."tbales.id from ".TB_PREF."tbales,".TB_PREF."tsize where ".TB_PREF."tbales.tsize = ".TB_PREF."tsize.id and lotid = '$id'";
    $result = db_query($sql, "The bales could not be retrieved");
	
	while ($myrow = db_fetch($result))
	{		
			
      		$rep->TextCol(0, 1, $myrow['name']);
      		$rep->TextCol(1, 2, $myrow['bale']);
      		$rep->TextCol(2, 3, $myrow['pally']);
      		$rep->TextCol(3, 4, $myrow['gweight']);
      		$rep->TextCol(4, 5, $myrow['nweight']);
      		$rep->TextCol(5, 6, $myrow['shade']);
      		$rep->TextCol(6,7, $myrow['taginfo']); 
      		$rep->TextCol(7,8, $myrow['remarks']); 
      		$rep->TextCol(8,9, $myrow['ptype']); 				
			$rep->NewLine(1, 2);    
  
  } 
 
	$rep->Line($rep->row  - 4);
	$rep->NewLine();
    $rep->End();
   
 
}
?>
