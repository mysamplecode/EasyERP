<?php
function get_all_supliers(){
$sql = "select ".TB_PREF."tsupplier.id,".TB_PREF."tsupplier.name from ".TB_PREF."tsupplier,".TB_PREF."tinventory where ".TB_PREF."tsupplier.id = ".TB_PREF."tinventory.sup group by ".TB_PREF."tinventory.sup ";

$result = db_query($sql);
return $result;
}
function get_all_invs(){
$sql = "select ".TB_PREF."tbales.invid as id from ".TB_PREF."tbales,".TB_PREF."tlots where  ".TB_PREF."tbales.lotid = ".TB_PREF."tlots.id and ".TB_PREF."tlots.issue = '0' group by ".TB_PREF."tbales.invid ";

$result = db_query($sql);
return $result;
}
function get_all_lots(){
$sql = "select ".TB_PREF."tlots.lno ,".TB_PREF."tlots.id from ".TB_PREF."tlots where ".TB_PREF."tlots.issue = '1'  and  ".TB_PREF."tlots.process = '0'  and  ".TB_PREF."tlots.dispatch = '0' ";

$result = db_query($sql);
return $result;
}
function  get_all_customers(){
$sql = "select ".TB_PREF."tcustomer.id ,".TB_PREF."tcustomer.name from ".TB_PREF."tcustomer,".TB_PREF."tlots where ".TB_PREF."tlots.issue = '1'  and  ".TB_PREF."tlots.process = '1'  and  ".TB_PREF."tlots.dispatch = '1' and ".TB_PREF."tcustomer.id = ".TB_PREF."tlots.cuid  group by ".TB_PREF."tcustomer.id";

$result = db_query($sql);
return $result;
}
function  get_ninvs_ids($sql){
if($sql!=''){
	$sql = " and $sql";
}
$sql = "select ".TB_PREF."tinventory.id from ".TB_PREF."tinventory where ".TB_PREF."tinventory.id>0 $sql and id in(select ".TB_PREF."tbales.invid as id from ".TB_PREF."tbales,".TB_PREF."tlots where  ".TB_PREF."tbales.lotid = ".TB_PREF."tlots.id and ".TB_PREF."tlots.issue = '0' group by ".TB_PREF."tbales.invid)";

$result = db_query($sql);
 $ids = array();
 while($r  = db_fetch_assoc($result)){
	$ids[] = $r['id'];
 }
 return $ids;
}
function  get_linvs_ids($sql){
if($sql!=''){
	$sql = " and $sql";
}
$mysql = "select ".TB_PREF."tinventory.id from ".TB_PREF."tinventory where ".TB_PREF."tinventory.id>0 $sql ";

$result = db_query($mysql);
 $ids = array();
 while($r  = db_fetch_assoc($result)){
	$ids[] = $r['id'];
 }
 return $ids;
}
 
function get_dinv($sql){
if($sql!=''){
	$sql = " and $sql";
}
$mysql = "select ".TB_PREF."tbales.invid as id from ".TB_PREF."tbales,".TB_PREF."tlots where  ".TB_PREF."tbales.lotid = ".TB_PREF."tlots.id and ".TB_PREF."tlots.issue = '1' and ".TB_PREF."tlots.process = '1'and ".TB_PREF."tlots.dispatch = '1' $sql group by ".TB_PREF."tbales.invid ";

$result = db_query($mysql);
 $ids = array();
 while($r  = db_fetch_assoc($result)){
	$ids[] = $r['id'];
 }
 return $ids;


} 
function get_pinv($sql){
if($sql!=''){
	$sql = " and $sql";
}
$mysql = "select ".TB_PREF."tbales.invid as id from ".TB_PREF."tbales,".TB_PREF."tlots where  ".TB_PREF."tbales.lotid = ".TB_PREF."tlots.id and ".TB_PREF."tlots.issue = '1' and ".TB_PREF."tlots.process = '1'and ".TB_PREF."tlots.dispatch = '0' $sql group by ".TB_PREF."tbales.invid ";

$result = db_query($mysql);
 $ids = array();
 while($r  = db_fetch_assoc($result)){
	$ids[] = $r['id'];
 }
 return $ids;


}
function get_iinv($sql){
if($sql!=''){
	$sql = " and $sql";
}
$mysql = "select ".TB_PREF."tbales.invid as id from ".TB_PREF."tbales,".TB_PREF."tlots where  ".TB_PREF."tbales.lotid = ".TB_PREF."tlots.id and ".TB_PREF."tlots.issue = '1' and ".TB_PREF."tlots.process = '0'and ".TB_PREF."tlots.dispatch = '0' $sql group by ".TB_PREF."tbales.invid ";

$result = db_query($mysql);
 $ids = array();
 while($r  = db_fetch_assoc($result)){
	$ids[] = $r['id'];
 }
 return $ids;


}


function get_sup_filtered($ids){
 
	$sql = " and ".TB_PREF."tinventory.id in (".implode(",",$ids).")" ;
 
 
 
$mysql = "select ".TB_PREF."tsupplier.id,".TB_PREF."tsupplier.name from ".TB_PREF."tsupplier,".TB_PREF."tinventory where ".TB_PREF."tsupplier.id = ".TB_PREF."tinventory.sup $sql";

$result = db_query($mysql);
 $ids = array();
 while($r  = db_fetch_assoc($result)){
	$ids[$r['id']] = $r['name'];
 }
 return $ids;

}

function get_inv_filtered($ids){
 
	$sql = " and ".TB_PREF."tinventory.id in (".implode(",",$ids).")" ;
 
 
 
$mysql = "select ".TB_PREF."tinventory.id from ".TB_PREF."tinventory where ".TB_PREF."tinventory.id >0  $sql";

$result = db_query($mysql);
 $ids = array();
 while($r  = db_fetch_assoc($result)){
	$ids[$r['id']] = $r['id'];
 }
 return $ids;

}

function get_lot_filtered($ids){
 
	$sql = " and ".TB_PREF."tbales.invid in (".implode(",",$ids).")" ;
 
 
 
$mysql = "select ".TB_PREF."tlots.lno,".TB_PREF."tlots.id from ".TB_PREF."tlots,".TB_PREF."tbales where ".TB_PREF."tbales.lotid = ".TB_PREF."tlots.id $sql";

$result = db_query($mysql);
 $ids = array();
 while($r  = db_fetch_assoc($result)){
	$ids[$r['id']] = $r['lno'];
 }
 return $ids;

}

function get_cus_filtered($ids){
 
	$sql = " and ".TB_PREF."tbales.invid in (".implode(",",$ids).")" ;
 
 
 
$mysql = "select ".TB_PREF."tcustomer.id,".TB_PREF."tcustomer.name from ".TB_PREF."tcustomer where id in(select ".TB_PREF."tlots.cuid from ".TB_PREF."tlots,".TB_PREF."tbales where ".TB_PREF."tbales.lotid = ".TB_PREF."tlots.id $sql)";

$result = db_query($mysql);
 $ids = array();
 while($r  = db_fetch_assoc($result)){
	$ids[$r['id']] = $r['name'];
 }
 return $ids;

}

function get_searches(){
		$sql  = " select id,name from ".TB_PREF."tssearch ";
		return db_query($sql);
}
function get_filtered_ids(){

		$invdate_panel = array();
		$invsup_panel = array();
		$ok_issue  = false;
		$ok_process = false;
		$ok_dispatch = false;
		$update_sup  = false;
		$update_lot = false;
		$update_inv = false;
		$update_cus = false;
		$invinv_panel = array();
		$invdatei_panel = array();
		$invlot_panel = array();
		$invdatep_panel = array();
		$invdated_panel = array();
		$invcus_panel = array();
		$output = array();  
				if(isset($_POST['data']['invdate_panel'])){
					foreach( $_POST['data']['invdate_panel'] as $dp ){
						if(trim($dp['start'])!='' &&  trim($dp['start'])!='' )
							$invdate_panel[] = " ( (".TB_PREF."tinventory.gate_in+0)>=('".strtotime($dp['start'])."'+0) and (".TB_PREF."tinventory.gate_in+0)<=('".strtotime($dp['end'])."'+0) )";
					}
				
				}
				if(isset($_POST['data']['invsup_panel'])){
					foreach( $_POST['data']['invsup_panel'] as $ds ){
					
						if(trim($ds)!='')
							$invsup_panel[] = " (  ".TB_PREF."tinventory.sup = '$ds' )";
					}
				
				}else{
					$update_sup = true;
				
				}
				if(isset($_POST['data']['invinv_panel'])){
					foreach( $_POST['data']['invinv_panel'] as $di ){
					
						if(trim($di)!='')
							$invinv_panel[] = " (  ".TB_PREF."tinventory.id = '$di' )";
					}
				
				}else{
					
					$update_inv = true;
				}
		 
					if(isset($_POST['data']['invdatei_panel'])){
						foreach( $_POST['data']['invdatei_panel'] as $ddi ){
					
							if(trim($ddi['start'])!='' && trim($ddi['end'])!='')
								$invdatei_panel[] = " ( (".TB_PREF."tlots.issue_date+0)>=('".strtotime($ddi['start'])."'+0) and (".TB_PREF."tlots.issue_date+0)<=('".strtotime($ddi['end'])."'+0) )";
						}
				
					}
					if(isset($_POST['data']['invlot_panel'])){
						foreach( $_POST['data']['invlot_panel'] as $dli ){
					
							if(trim($dli)!='')
								$invlot_panel[] = " (".TB_PREF."tlots.id = '$dli') ";
						}
				
					}else{
					
						$update_lot = true;
					}
					if(isset($_POST['data']['invdatep_panel'])){
						foreach( $_POST['data']['invdatep_panel'] as $ddp ){
					
							if(trim($ddp['start'])!='' && trim($ddp['end'])!='')
								$invdatep_panel[] = " ( (".TB_PREF."tlots.process_date+0)>=('".strtotime($ddp['start'])."'+0) and (".TB_PREF."tlots.process_date+0)<=('".strtotime($ddp['end'])."'+0) )";
						}
				
					}
				 
			 
					if(isset($_POST['data']['invdated_panel'])){
						foreach( $_POST['data']['invdated_panel'] as $ddd ){
					
							if(trim($ddd['start'])!='' && trim($ddd['end'])!='')
								$invdated_panel[] =  " ( (".TB_PREF."tlots.dispatch_date+0)>=('".strtotime($ddd['start'])."'+0) and (".TB_PREF."tlots.dispatch_date+0)<=('".strtotime($ddd['end'])."'+0) )";
						}
				
					}
				   
					if(isset($_POST['data']['invcus_panel'])){
						foreach( $_POST['data']['invcus_panel'] as $dc ){
					
							if(trim($dc)!='')
								$invcus_panel[] = " (  ".TB_PREF."tlots.cuid = '$dc' ) ";
						}
				
					}else{
						$update_cus = true;
					}
				 
				if(isset($_POST['include']['issue'])){
					if($_POST['include']['issue'] == 'yes'){
						$ok_issue = true;
					}
				}
				if(isset($_POST['include']['process'])){
					if($_POST['include']['process'] == 'yes'){
						$ok_process = true;
					}
				}
				if(isset($_POST['include']['dispatch'])){
					if($_POST['include']['dispatch'] == 'yes'){
						$ok_dispatch = true;
					}
				} 
				$lsumi = array();
				$lsump = array();
				$lsumd = array();
				if(count($invdatei_panel)){
					$lsumi[] = implode(" and ",$invdatei_panel);
				}
				if(count($invlot_panel)){
				
					$lsumi[] = implode(" and ",$invlot_panel);
				}
				if(count($invdatep_panel)){
				
					$lsump[] = implode(" and ",$invdatep_panel);
				}
				if(count($invdated_panel)){
				
					$lsumd[] = implode(" and ",$invdated_panel);
				}
				if(count($invcus_panel)){
				
					$lsumd[] = implode(" and ",$invcus_panel);
				}
				 
				$add_sql = '';
				$dds = array();
				$ids = array();
				$pds = array();
				if($ok_issue){ 
					$ids = get_iinv(implode(" and ",$lsumi)); 
				}
				if($ok_process){
					$lsum = array();
					if(count($lsump)>0)
						$lsum[] = implode(" and ",$lsump);
					if(count($lsumi)>0)
						$lsum[] = implode(" and ", $lsumi);
					$pds = get_pinv(implode(" and ",$lsum)); 
 
				}
				if($ok_dispatch){
					$lsum  = array();
					
					if(count($lsump)>0)
						$lsum[] = implode(" and ",$lsump);
					if(count($lsumi)>0)
						$lsum[] = implode(" and ", $lsumi);
					if(count($lsumd)>0)
						$lsum[] = implode(" and ", $lsumd);
					$dds = get_dinv(implode(" and ",$lsum)); 
 
				}
				$all_ids = array_merge($ids,$pds,$dds);
				$all_ids = array_unique($all_ids);
				
 
				$sum = array();
				if(count($invdate_panel)){
					$sum[] = implode(" and ",$invdate_panel);
				}
				if(count($invsup_panel)){
				
					$sum[] = implode(" and ",$invsup_panel);
				}
				if(count($invinv_panel)){
				
					$sum[] = implode(" and ",$invinv_panel);
				} 
				$sql = implode( " and ",$sum ); 
				
				$ninv = get_ninvs_ids($sql);
				
				if(count($all_ids)>0){
					$sum[]  = " and id in(".implode(",",$all_ids).")";
				}
				$linv = get_linvs_ids(implode( " and ",$sum ));
				$allid = array_merge($ninv,$linv);
				$allid = array_unique($allid);
				$allid[] = 0;
				
 
return $allid;
}
function print_raport(){

	global $path_to_root, $systypes_array; 
	//$destination = $_POST["printType"];
	//if ($destination)
	//include_once($path_to_root . "/reporting/includes/excel_report.inc");
    //else
	include_once($path_to_root . "/reporting/includes/pdf_report.inc");
    $prints = array();
	$names = array();
	$tables  = array();
	$add_conds = array();
	if(isset($_POST['fields']['printinv_panel'])){
		foreach($_POST['fields']['printinv_panel'] as $pinv=>$iname){
			$prints[] = " ".TB_PREF."tinventory.$pinv ";
			$names[]  = $iname;
		}
		$tables[] =  " ".TB_PREF."tinventory " ;
	}
	if(isset($_POST['fields']['printlot_panel'])){
		foreach($_POST['fields']['printlot_panel'] as $plot=>$lname){
			$prints[] = " ".TB_PREF."tlots.$plot ";
			$names[]  = $lname;
		}
		
		$add_conds[] =  " ".TB_PREF."tbales.lotid = ".TB_PREF."tlots.id ";
		$add_conds[] =  "  ".TB_PREF."tbales.invid = ".TB_PREF."tinventory.id ";
		$tables[] =  " ".TB_PREF."tlots " ;
		$tables[] =  " ".TB_PREF."tbales " ;
	}
	if(isset($_POST['fields']['printsup_panel'])){
		foreach($_POST['fields']['printsup_panel'] as $psup=>$sname){
			$prints[] = " ".TB_PREF."tsupplier.$psup ";
			$names[]  = $sname;
		}
	
		$add_conds[] =  " ".TB_PREF."tsupplier.id = ".TB_PREF."tinventory.sup ";
		$tables[] =  " ".TB_PREF."tsupplier " ;
	}
	if(isset($_POST['fields']['printcust_panel'])){
		foreach($_POST['fields']['printcust_panel'] as $pcus=>$cname){
			$prints[] = " ".TB_PREF."tcustomer.$pcus ";
			$names[]  = $cname;
		}
	
		$add_conds[] =  " ".TB_PREF."tcustomer.id = ".TB_PREF."tlots.cuid ";
		$tables[] =  " ".TB_PREF."tcustomer " ;
	} 
	$params =   array( 	0 => '',
    			);
	 
	 
	$headers = $names;
	$no = count($names);
	$cols = array(0);
	$col = ceil(560/$no);
	$aligns = array();
	foreach($names as $name){
		$cols[] = $cols[count($cols)-1]+$col;
		$aligns[] = "left";
	}
    $rep = new FrontReport(_('Inventory'), "Inventory", user_pagesize());
    $rep->Font();
    
    $rep->Info($params, $cols, $headers,$aligns);
    $rep->NewPage();
	$ids = get_filtered_ids();
 
	if(count($prints)==0) return false;
 
	$sql = "select ".implode(",",$prints)." from ".implode(",",$tables)." where  ".implode(" and ",$add_conds)."  ".TB_PREF."tinventory.id in (".implode(",",$ids).")";
    $result = db_query($sql, "The bales could not be retrieved");
	
	$num_lines = 0;

	while ($myrow = db_fetch_assoc($result))
	{ 
	 
	  	$num_lines++;  
		$col_cnt = 0; 
		foreach($myrow as $sc){
			$rep->TextCol($col_cnt, $col_cnt+1, $sc);   
			$col_cnt ++;
		}
		$rep->NewLine(1, 2);   
  
	} 
 
	$rep->Line($rep->row  - 4);
	$rep->NewLine();
    echo $rep->End(0,'',true);
   
 

}

?>