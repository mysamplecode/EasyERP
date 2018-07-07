<?php

function get_all_supliers(){
$sql = "select ".TB_PREF."tsupplier.id,".TB_PREF."tsupplier.name from ".TB_PREF."tsupplier,".TB_PREF."tinventory,".TB_PREF."tbales,".TB_PREF."tlots where ".TB_PREF."tsupplier.id = ".TB_PREF."tinventory.sup and ".TB_PREF."tbales.invid = ".TB_PREF."tinventory.id  and ".TB_PREF."tbales.lotid = ".TB_PREF."tlots.id and ".TB_PREF."tlots.issue = '1' and ".TB_PREF."tlots.process = '1' group by ".TB_PREF."tinventory.sup ";

$result = db_query($sql);
return $result;
}
function get_all_invs(){
$sql = "select ".TB_PREF."tbales.invid as id from ".TB_PREF."tbales,".TB_PREF."tlots where  ".TB_PREF."tbales.lotid = ".TB_PREF."tlots.id and ".TB_PREF."tlots.issue = '1' and ".TB_PREF."tlots.process = '1' group by ".TB_PREF."tbales.invid ";

$result = db_query($sql);
return $result;
}
function get_all_lots(){
$sql = "select ".TB_PREF."tlots.id,".TB_PREF."tlots.lno from ".TB_PREF."tlots where    ".TB_PREF."tlots.issue = '1' and ".TB_PREF."tlots.process = '1' group by ".TB_PREF."tlots.id ";

$result = db_query($sql);
return $result;
}

function get_all_custs(){
$sql = "select ".TB_PREF."tcustomer.id,".TB_PREF."tcustomer.name from ".TB_PREF."tlots, ".TB_PREF."tcustomer where    ".TB_PREF."tlots.cuid =  ".TB_PREF."tcustomer.id   group by ".TB_PREF."tcustomer.id ";

$result = db_query($sql);
return $result;
}



function get_filtered_ids(){

		$lotpdate_panel = array();
		$lotidate_panel = array();
		$lotdated_panel = array();
		$ok_issue  = false;
		$ok_process = false;
		$ok_dispatch = false;
		$update_sup  = false;
		$update_lot = false;
		$update_inv = false;
		$update_cus = false;
		$lotlot_panel = array();
		$lotsup_panel = array();
		$lotcust_panel = array();
		$lotinv_panel = array(); 
		$output = array();  
				if(isset($_POST['data']['lotpdate_panel'])){
					foreach( $_POST['data']['lotpdate_panel'] as $lpd ){
						if(trim($lpd['start'])!='' &&  trim($lpd['start'])!='' )
							$lotpdate_panel[] = " ( (".TB_PREF."tlots.process_date+0)>=('".strtotime($lpd['start'])."'+0) and (".TB_PREF."tlots.process_date+0)<=('".strtotime($lpd['end'])."'+0) )";
					}
				
				}
				if(isset($_POST['data']['lotsup_panel'])){
					foreach( $_POST['data']['lotsup_panel'] as $ls ){
					
						if(trim($ls)!='')
							$lotsup_panel[] = " (  ".TB_PREF."tinventory.sup = '$ls' )";
					}
				
				}else{
					$update_sup = true;
				
				}
				if(isset($_POST['data']['lotinv_panel'])){
					foreach( $_POST['data']['lotinv_panel'] as $li ){
					
						if(trim($li)!='')
							$lotinv_panel[] = " (  ".TB_PREF."tbales.invid = '$li' )";
					}
				
				}else{
					
					$update_inv = true;
				}
		 
					if(isset($_POST['data']['lotidate_panel'])){
						foreach( $_POST['data']['lotidate_panel'] as $lii ){
					
							if(trim($lii['start'])!='' && trim($lii['end'])!='')
								$lotidate_panel[] = " ( (".TB_PREF."tlots.issue_date+0)>=('".strtotime($lii['start'])."'+0) and (".TB_PREF."tlots.issue_date+0)<=('".strtotime($lii['end'])."'+0) )";
						}
				
					}
					if(isset($_POST['data']['lotlot_panel'])){
						foreach( $_POST['data']['lotlot_panel'] as $ll ){
					
							if(trim($ll)!='')
								$lotlot_panel[] = " (".TB_PREF."tlots.id = '$ll') ";
						}
				
					}else{
					
						$update_lot = true;
					}
					if(isset($_POST['data']['lotdated_panel'])){
						foreach( $_POST['data']['lotdated_panel'] as $ldd ){
					
							if(trim($ldd['start'])!='' && trim($ldd['end'])!='')
								$lotdated_panel[] = " ( (".TB_PREF."tlots.dispatch_date+0)>=('".strtotime($ldd['start'])."'+0) and (".TB_PREF."tlots.dispatch+0)<=('".strtotime($ldd['end'])."'+0) )";
						}
				
					}
				 
			  
				   
					if(isset($_POST['data']['lotcust_panel'])){
						foreach( $_POST['data']['lotcust_panel'] as $lc ){
					
							if(trim(lc)!='')
								$lotcust_panel[] = " (  ".TB_PREF."tlots.cuid = '$lc' ) ";
						}
				
					}else{
						$update_cus = true;
					}
				 
 
				if(isset($_POST['include'][0]['dispatch'])){
					if($_POST['include'][0]['dispatch'] == 'yes'){
						$ok_dispatch = true;
					}
				}  
				$lsumd = array();
 
				if(count($lotdated_panel)){
				
					$lsumd[] = implode(" and ",$lotdated_panel);
				}
				if(count($lotcust_panel)){
				
					$lsumd[] = implode(" and ",$lotcust_panel);
				}
				  
 
				
 
				$sum = array();
				if(count($lotidate_panel)){
					$sum[] = implode(" and ",$lotidate_panel);
				}
				if(count($lotpdate_panel)){
				
					$sum[] = implode(" and ",$lotpdate_panel);
				}
				if(count($lotsup_panel)){
				
					$sum[] = implode(" and ",$lotsup_panel);
				}
				if(count($lotlot_panel)){
				
					$sum[] = implode(" and ",$lotlot_panel);
				}
				if(count($lotinv_panel)){
				
					$sum[] = implode(" and ",$lotinv_panel);
				} 
				$sql = implode( " and ",$sum ); 
				$dds = array();
				if($ok_dispatch){
					$lsum  = array();
					 
					if(count($lsumd)>0)
						$lsum[] = implode(" and ", $lsumd);
					$lsum[] = $sql;
					$dds = get_dlots(implode(" and ",$lsum)); 
 
				}
				$ninv = get_nlots($sql); 
  
				$allid = array_merge($ninv,$dds);
				$allid = array_unique($allid);
			
				$allid[] = 0;
				
 
return $allid;
}

function get_dlots($sql){
if( (trim($sql))!=''){
	$sql = " and $sql ";
}

$mysql = "select ".TB_PREF."tlots.id  from ".TB_PREF."tlots,".TB_PREF."tbales,".TB_PREF."tsupplier,".TB_PREF."tcustomer ,".TB_PREF."tinventory where ".TB_PREF."tcustomer.id = ".TB_PREF."tlots.cuid and ".TB_PREF."tbales.lotid = ".TB_PREF."tlots.id and ".TB_PREF."tinventory.sup = ".TB_PREF."tsupplier.id and     ".TB_PREF."tlots.issue = '1' and ".TB_PREF."tlots.process = '1' and ".TB_PREF."tlots.dispatch = '1' $sql group by ".TB_PREF."tlots.id ";

 $result = db_query($mysql);
 $ids = array();
 while($r  = db_fetch_assoc($result)){
	$ids[] = $r['id'];
 }
 
 return $ids;

}
function get_nlots($sql){
if((trim($sql))!=''){
	$sql = " and $sql ";
}
 
$mysql = "select ".TB_PREF."tlots.id  from ".TB_PREF."tlots,".TB_PREF."tbales,".TB_PREF."tsupplier  ,".TB_PREF."tinventory where    ".TB_PREF."tbales.lotid = ".TB_PREF."tlots.id and ".TB_PREF."tinventory.sup = ".TB_PREF."tsupplier.id and     ".TB_PREF."tlots.issue = '1' and ".TB_PREF."tlots.process = '1' and ".TB_PREF."tlots.dispatch = '0'  group by ".TB_PREF."tlots.id ";

 $result = db_query($mysql);
 $ids = array();
 while($r  = db_fetch_assoc($result)){
	$ids[] = $r['id'];
 } 
 return $ids;

}
function  get_sup_filtered($ids){
 $sql = " and ".TB_PREF."tlots.id in (".implode(",",$ids).")" ;
 
 
 
$mysql =  "select ".TB_PREF."tsupplier.id,".TB_PREF."tsupplier.name from ".TB_PREF."tsupplier,".TB_PREF."tinventory,".TB_PREF."tbales,".TB_PREF."tlots where ".TB_PREF."tsupplier.id = ".TB_PREF."tinventory.sup and ".TB_PREF."tbales.invid = ".TB_PREF."tinventory.id  and ".TB_PREF."tbales.lotid = ".TB_PREF."tlots.id and ".TB_PREF."tlots.issue = '1' and ".TB_PREF."tlots.process = '1' group by ".TB_PREF."tinventory.sup $sql";
$result = db_query($mysql);
 $ids = array();
 while($r  = db_fetch_assoc($result)){
	$ids[$r['id']] = $r['name'];
 } 
	return $ids;
}
function  get_lot_filtered($ids){
 $sql = " and ".TB_PREF."tlots.id in (".implode(",",$ids).")" ;
 
 
 
$mysql = "select ".TB_PREF."tlots.id,".TB_PREF."tlots.lno from ".TB_PREF."tlots where    ".TB_PREF."tlots.issue = '1' and ".TB_PREF."tlots.process = '1' $sql group by ".TB_PREF."tlots.id ";

$result = db_query($mysql);
 $ids = array();
 while($r  = db_fetch_assoc($result)){
	$ids[$r['id']] = $r['lno'];
 } 
	return $ids;
}
function  get_cus_filtered($ids){
 $sql = " and ".TB_PREF."tlots.id in (".implode(",",$ids).")" ;
 
 
 
$mysql =  "select ".TB_PREF."tcustomer.id,".TB_PREF."tcustomer.name from ".TB_PREF."tlots, ".TB_PREF."tcustomer where    ".TB_PREF."tlots.cuid =  ".TB_PREF."tcustomer.id  $sql group by ".TB_PREF."tcustomer.id ";

$result = db_query($mysql);
 $ids = array();
 while($r  = db_fetch_assoc($result)){
	$ids[$r['id']] = $r['name'];
 } 
	return $ids;
}
function  get_inv_filtered($ids){
 $sql = " and ".TB_PREF."tlots.id in (".implode(",",$ids).")" ;
 
 
 
$mysql =   "select ".TB_PREF."tbales.invid as id from ".TB_PREF."tbales,".TB_PREF."tlots where  ".TB_PREF."tbales.lotid = ".TB_PREF."tlots.id and ".TB_PREF."tlots.issue = '1' and ".TB_PREF."tlots.process = '1' $sql  group by ".TB_PREF."tbales.invid ";

$result = db_query($mysql);
 $ids = array();
 while($r  = db_fetch_assoc($result)){
	$ids[$r['id']] = $r['id'];
 } 
	return $ids;
}

function get_searches(){
		$sql  = " select id,name from ".TB_PREF."tsesearch ";
		return db_query($sql);
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
  
	$tables[] =  " ".TB_PREF."tinventory " ;
 
	if(isset($_POST['fields']['printlot_panel'])){
		foreach($_POST['fields']['printlot_panel'] as $plot=>$lname){
			$prints[] = " ".TB_PREF."tlots.$plot ";
			$names[]  = $lname;
		}
	}	
		$add_conds[] =  " ".TB_PREF."tbales.lotid = ".TB_PREF."tlots.id ";
		$add_conds[] =  "  ".TB_PREF."tbales.invid = ".TB_PREF."tinventory.id ";
		$tables[] =  " ".TB_PREF."tlots " ;
		$tables[] =  " ".TB_PREF."tbales " ;
	
	if(isset($_POST['fields']['printsup_panel'])){
		foreach($_POST['fields']['printsup_panel'] as $psup=>$sname){
			$prints[] = " ".TB_PREF."tsupplier.$psup ";
			$names[]  = $sname;
		}
	}
		$add_conds[] =  " ".TB_PREF."tsupplier.id = ".TB_PREF."tinventory.sup ";
		$tables[] =  " ".TB_PREF."tsupplier " ;
	
	if(isset($_POST['fields']['printcust_panel'])){
		foreach($_POST['fields']['printcust_panel'] as $pcus=>$cname){
			$prints[] = " ".TB_PREF."tcustomer.$pcus ";
			$names[]  = $cname;
		}
	}
		$add_conds[] =  " ".TB_PREF."tcustomer.id = ".TB_PREF."tlots.cuid ";
		$tables[] =  " ".TB_PREF."tcustomer " ;
	 
	if(count($prints)==0) return false;
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
	$ieff = get_ieff();
	$sql = "select ".implode(",",$prints)." from ".implode(",",$tables)." where  ".implode(" and ",$add_conds)." and  ".TB_PREF."tlots.id in (".implode(",",$ids).")";
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
	$rep->NewLine();
	$tprep = ceil(get_prep_eff($ids,$ieff )*100);
	$tbleach = ceil(get_bleach_eff($ids,$ieff )*100);
	$tdye = ceil(get_dye_eff($ids,$ieff )*100);
	$tcare = ceil(get_care_eff($ids,$ieff )*100);
	$thydro = ceil(get_hydro_eff($ids,$ieff )*100);
	$tquality = ceil(get_quality_eff($ids,$ieff )*100);
	$ttumbler = ceil(get_tumbler_eff($ids,$ieff )*100);
			$rep->TextCol(0, 1, "Preparation Effciency : ".$tprep."%" );
	$rep->NewLine(); 
			$rep->TextCol(0, 1, "Care Effciency : ".$tcare."%" ); 
	$rep->NewLine();
			$rep->TextCol(0, 1, "Bleach Effciency : ".$tbleach."%"); 
	$rep->NewLine();
			$rep->TextCol(0, 1, "Dyeing Effciency : ".$tdye."%" ); 
	$rep->NewLine();
			$rep->TextCol(0, 1, "Hydro Effciency : ".$thydro."%" ); 
	$rep->NewLine();
			$rep->TextCol(0, 1, "Quality Effciency : ".$tquality."%" ); 
	$rep->NewLine();
			$rep->TextCol(0, 1, "Tumbler Effciency : ".$ttumbler."%" ); 
	$rep->NewLine();
			$rep->TextCol(0, 1, "Total Effciency : ".ceil(($tcare+$tquality+$ttumbler+$tbleach+$tdye+$tprep+$thydro)/7)."%"); 
	$rep->NewLine();
    echo $rep->End(0,'',true);
   
   

}
function get_ieff(){
	$sql = "select * from ".TB_PREF."teparam limit 1";
	$result = db_query($sql);
	return db_fetch_assoc($result);
}
function get_prep_eff($ids,$ieff){

$sql =  "select avg(prep+0)/('".$ieff['lpre']."'+0) as avgr  from ".TB_PREF."steps where lotid in (".implode(",",$ids).") and prep_bool = 'yes'";
$result = db_query($sql);
$row = db_fetch_assoc($result);
return $row['avgr'];
}
function get_care_eff($ids,$ieff){

$sql =  "select avg(care+0)/('".$ieff['care']."'+0) as avgr  from ".TB_PREF."steps where lotid in (".implode(",",$ids).") and care_bool = 'yes'";
$result = db_query($sql);
$row = db_fetch_assoc($result);
return $row['avgr'];
}
function get_dye_eff($ids,$ieff){

$sql =  "select avg(dye+0)/('".$ieff['dye']."'+0) as avgr  from ".TB_PREF."steps where lotid in (".implode(",",$ids).") and dye_bool = 'yes'";
$result = db_query($sql);
$row = db_fetch_assoc($result);
return $row['avgr'];
}
function get_bleach_eff($ids,$ieff){

$sql =  "select avg(bleach+0)/('".$ieff['bleach']."'+0) as avgr  from ".TB_PREF."steps where lotid in (".implode(",",$ids).") and bleach_bool = 'yes'";
$result = db_query($sql);
$row = db_fetch_assoc($result);
return $row['avgr'];
}
function get_hydro_eff($ids,$ieff){

$sql =  "select avg(hydro+0)/('".$ieff['hydro']."'+0) as avgr  from ".TB_PREF."steps where lotid in (".implode(",",$ids).") and hydro_bool = 'yes'";
$result = db_query($sql);
$row = db_fetch_assoc($result);
return $row['avgr'];
}
function get_quality_eff($ids,$ieff){

$sql =  "select avg(quality+0)/('".$ieff['qua']."'+0) as avgr  from ".TB_PREF."steps where lotid in (".implode(",",$ids).") and quality_bool = 'yes'";
$result = db_query($sql);
$row = db_fetch_assoc($result);
return $row['avgr'];
}
function get_tumbler_eff($ids,$ieff){

$sql =  "select avg(tumbl+0)/('".$ieff['tum']."'+0) as avgr  from ".TB_PREF."steps where lotid in (".implode(",",$ids).") and tumbler_bool = 'yes'";
$result = db_query($sql);
$row = db_fetch_assoc($result);
return $row['avgr'];
}
 

?>