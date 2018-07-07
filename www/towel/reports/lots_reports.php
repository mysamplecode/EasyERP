<?php
$page_security = 'SS_TOWELM';
$path_to_root = "../..";
include_once($path_to_root . "/includes/db_pager.inc");
include_once($path_to_root . "/includes/session.inc");
include_once($path_to_root . "/includes/ui.inc");
include_once($path_to_root . "/towel/includes/db/lotsr_db.inc"); 
include_once($path_to_root . "/reporting/includes/reports_classes.inc"); 
include_once($path_to_root . "/gl/includes/gl_db.inc"); 
if(isset($_POST['isAjax'])){
	if($_POST['isAjax'] == "save_search"){
		db_query("insert into ".TB_PREF."tsesearch(name,dom) values(".db_escape($_POST['name']).",".db_escape($_POST['doom']).")");
		 $sids =get_searches();
							while($sid  = db_fetch_assoc($sids)){
								echo "<option value='".$sid['id']."'>".$sid['name']."</option>";
							}
		die();
	}	
	if($_POST['isAjax'] == "load_search"){
			$result = db_query("select dom from ".TB_PREF."tsesearch where id = '".$_POST['id']."' limit 1");
			$row = db_fetch_assoc($result);
			echo html_entity_decode($row['dom']);
		die();
	}
	if($_POST['isAjax'] == "update_fields"){
			$allid = get_filtered_ids(); 
				if(!isset($_POST['data']['lotsup_panel'])){ 
					$output["lotsup_panel"] = get_sup_filtered($allid);
				}
				if(!isset($_POST['data']['lotcust_panel'])){ 
					$output["lotcust_panel"] = get_cus_filtered($allid);
				}
				if(!isset($_POST['data']['invlot_panel'])){ 
					$output["lotlot_panel"] = get_lot_filtered($allid);
				}
				if(!isset($_POST['data']['invinv_panel'])){ 
					$output["lotinv_panel"] = get_inv_filtered($allid);
				}
				
				echo json_encode($output);
		}
		
		 
	
	if($_POST['isAjax'] == "print_raport"){
 
	 $_POST['REP_ID'] =  'report_inventory' ;
				print_raport();
				 
	 }
		
		 
	 
die();
}

$js = get_js_date_picker();
 add_js_file("jquery.js");
 add_js_file("jqueryui.js");
 add_js_file("tlots.js");
page("Inventroy Reports", false, false, "", $js);?>
<div id="doom_search">
	<table align="center" width="80%" style="border:1px solid #cccccc;">
		<tbody>
			<tr valign="top">
				<td width="50%" id="left_panel">
					<b>Search Options:</b> <br/>
						<a href="#lotpdate_panel"  id="lotpdate">Processed lot by date</a><br/>
						<a href="#lotsup_panel" id="lotsup">Processed lot by supplier</a><br/>
						<a href="#lotinv_panel" id="lotinv">Processed lot by inventory</a><br/>
						<a href="#lotidate_panel" id="lotidate">Processed lot by issued date</a><br/>
		  
						<a href="#lotlot"  id="lotlot">Processed lot by lot #</a><br/> 
	 
					<b>Include dispatched lots:</b><input type="checkbox" name="dispatched_lots" value="1" id="dispatched_lots"/><br/>
					<div id="dispatched_filters" style="padding-left:20px;padding-top:10px;padding-bottom:10px;display:none">
						<a href="#lotcust_panel"  id="lotcust">Processed lots by customer</a><br/> 
						<a href="#lotdated_panel"  id="lotdated">Processed lots by dispatch date</a><br/> 
					</div>
 
				</td>
				<td width="50" style="border-left:1px solid #cccccc;border-right:1px solid #cccccc;padding-left:3px;" id="right_panel">
					<b>Filters:</b> 
					<div id="lotpdate_panel" class="panels" active="active" style="display:none; text-align:center;padding:10px;">
						<div class="filter_wrapper" style="margin:5px;">
							Start Date:<input type="text" name="invadate_input_start" class="invdate_input_start date_field"/> <br/>
							End Date: <input type="text" name="invadate_input_end" class="invdate_input_end date_field"/> 
						</div>
						<a  href="#"   class="add_filter"  ><img src="../../themes/default/images/add.png" height="12"><span>Add</span></a><br/>
						<a  href="#" class="update_filter"  "><img src="../../themes/default/images/button_ok.png" height="12"><span>Update</span></a><br/>
						<a  href="#"  class="block_filter" ><img src="../../themes/default/images/login.gif" height="12"><span>Block</span></a><br/>
						<a  href="#"   class="exclude_filter"  ><img src="../../themes/default/images/delete.gif" height="12"><span>Exclude</span></a>
					</div>		
					<div id="lotidate_panel" class="panels" active="active" style="display:none; text-align:center;padding:10px;">
						<div class="filter_wrapper" style="margin:5px;">
							Start Date:<input type="text" name="invadate_input_start" class="invdate_input_start date_field"/> <br/>
							End Date: <input type="text" name="invadate_input_end" class="invdate_input_end date_field"/> 
						</div>
						<a  href="#"   class="add_filter"  ><img src="../../themes/default/images/add.png" height="12"><span>Add</span></a><br/>
						<a  href="#" class="update_filter"  "><img src="../../themes/default/images/button_ok.png" height="12"><span>Update</span></a><br/>
						<a  href="#"  class="block_filter" ><img src="../../themes/default/images/login.gif" height="12"><span>Block</span></a><br/>
						<a  href="#"   class="exclude_filter"  ><img src="../../themes/default/images/delete.gif" height="12"><span>Exclude</span></a>
					</div>
					<div id="lotsup_panel"  class="panels"  active="active"   style="display:none; text-align:center;padding:10px;">
						<div class="filter_wrapper" style="margin:5px;">
						<select name="lov_select" class="lov_select">
							<option value="">None</option>
							<?php
								$supliers = get_all_supliers();
								while($supplier = db_fetch_assoc($supliers)){
									echo "<option value='".$supplier['id']."'>".$supplier['name']."</option>";
								
								} 
							?>
						</select>
						
						</div>
						<a  href="#"   class="add_filter"  ><img src="../../themes/default/images/add.png" height="12"><span>Add</span></a><br/>
						<a  href="#" class="update_filter"  "><img src="../../themes/default/images/button_ok.png" height="12"><span>Update</span></a><br/>
						<a  href="#"  class="block_filter" ><img src="../../themes/default/images/login.gif" height="12"><span>Block</span></a><br/>
						<a  href="#"   class="exclude_filter"  ><img src="../../themes/default/images/delete.gif" height="12"><span>Exclude</span></a>
					
					</div>
					<div id="lotinv_panel"  class="panels"  active="active"     style="display:none; text-align:center;padding:10px;"> 
						<div class="filter_wrapper" style="margin:5px;">
						<select name="lov_select" class="lov_select">
							<option value="">None</option>
							<?php
								$invs = get_all_invs();
								while($inv = db_fetch_assoc($invs)){
									echo "<option value='".$inv['id']."'>".$inv['id']."</option>";
								
								}
							?>
						</select>
						</div>
						<a  href="#"   class="add_filter"  ><img src="../../themes/default/images/add.png" height="12"><span>Add</span></a><br/>
						<a  href="#" class="update_filter"  "><img src="../../themes/default/images/button_ok.png" height="12"><span>Update</span></a><br/>
						<a  href="#"  class="block_filter" ><img src="../../themes/default/images/login.gif" height="12"><span>Block</span></a><br/>
						<a  href="#"   class="exclude_filter"  ><img src="../../themes/default/images/delete.gif" height="12"><span>Exclude</span></a>
					
					
					</div>
					<div id="lotlot_panel"  class="panels"  active="active"     style="display:none; text-align:center;padding:10px;"> 
						<div class="filter_wrapper" style="margin:5px;">
						<select name="lov_select" class="lov_select">
							<option value="">None</option>
							<?php
								$lots = get_all_lots();
								while($lot = db_fetch_assoc($lots)){
									echo "<option value='".$lot['id']."'>".$lot['lno']."</option>";
								
								}
							?>
						</select>
						</div>
						<a  href="#"   class="add_filter"  ><img src="../../themes/default/images/add.png" height="12"><span>Add</span></a><br/>
						<a  href="#" class="update_filter"  "><img src="../../themes/default/images/button_ok.png" height="12"><span>Update</span></a><br/>
						<a  href="#"  class="block_filter" ><img src="../../themes/default/images/login.gif" height="12"><span>Block</span></a><br/>
						<a  href="#"   class="exclude_filter"  ><img src="../../themes/default/images/delete.gif" height="12"><span>Exclude</span></a>
					
					
					</div>
					<div id="lotcust_panel"  class="panels"   style="display:none; text-align:center;padding:10px;">
					
						<div class="filter_wrapper" style="margin:5px;">
							<select name="lov_select" class="lov_select">
							<option value="">None</option>
							<?php
								$custs = get_all_custs();
								while($cust= db_fetch_assoc($custs)){
									echo "<option value='".$cust['id']."'>".$cust['name']."</option>";
								
								}
							?>
						</select>
						</div>
						<a  href="#"   class="add_filter"  ><img src="../../themes/default/images/add.png" height="12"><span>Add</span></a><br/>
						<a  href="#" class="update_filter"  "><img src="../../themes/default/images/button_ok.png" height="12"><span>Update</span></a><br/>
						<a  href="#"  class="block_filter" ><img src="../../themes/default/images/login.gif" height="12"><span>Block</span></a><br/>
						<a  href="#"   class="exclude_filter"  ><img src="../../themes/default/images/delete.gif" height="12"><span>Exclude</span></a>
					
					
					
					</div>
					<div id="lotdated_panel"  class="panels"   style="display:none; text-align:center;padding:10px;">
						<div class="filter_wrapper" style="margin:5px;">
							Start Date:<input type="text" name="invadate_input_start" class="invdate_input_start date_field"/> <br/>
							End Date: <input type="text" name="invadate_input_end" class="invdate_input_end date_field"/> 
						</div>
						<a  href="#"   class="add_filter"  ><img src="../../themes/default/images/add.png" height="12"><span>Add</span></a><br/>
						<a  href="#" class="update_filter"  "><img src="../../themes/default/images/button_ok.png" height="12"><span>Update</span></a><br/>
						<a  href="#"  class="block_filter" ><img src="../../themes/default/images/login.gif" height="12"><span>Block</span></a><br/>
						<a  href="#"   class="exclude_filter"  ><img src="../../themes/default/images/delete.gif" height="12"><span>Exclude</span></a>
					
					
					
					
					</div> 
				</td> 
			</tr>
		</tbody>
	</table>
	<table align="center" width="80%" style="border:1px solid #cccccc;">
		<tbody>
			<tr valign="top">
				<td width="50%" id="leftpanel_print"  >
					<b>Print options:</b> <br/> 
					 
						<a href="#printsup_panel" id="printsup">Supplier table</a><br/>
						<a href="#printlot_panel" id="printlot">Lot table</a><br/>
						<a href="#printcust_panel" id="printcust">Customer tabler</a><br/>
				</td>
				<td width="50" style="border-left:1px solid #cccccc;border-right:1px solid #cccccc;padding-left:3px;"  id="rightpanel_print"  >
					<b>Print filters:</b> 
 
					<div id="printcust_panel"  style="display:none;  padding:10px;">
						 Name<input type="checkbox" name="name" value="Name"/><br/>
						Adress<input type="checkbox" name="address" value="Adress"/><br/>
						Ntn<input type="checkbox" name="ntn" value="Ntn"/><br/>
						Contact person name<input type="checkbox" name="contact_pname" value="Contact person name"/><br/>
						Contact person designation<input type="checkbox" name="contact_pdesig" value="Contact person designation"/><br/>
						Contact person number<input type="checkbox" name="contact_pno" value="Contact person number"/><br/>
						Customer type<input type="checkbox" name="stype" value="Customer type"/><br/> 
					</div>
					<div id="printlot_panel"  style="display:none;  padding:10px;">
						Lot #<input type="checkbox" name="lno" value="Lot #"/><br/>
						Lot description<input type="checkbox" name="descr" value="	Lot description"/><br/>
						Lot proposed process date<input type="checkbox" name="pdate" value="Lot proposed process date"/><br/>
						  
					</div>
					<div id="printsup_panel"  style="display:none;  padding:10px;">
						Name<input type="checkbox" name="name" value="Name"/><br/>
						Adress<input type="checkbox" name="address" value="Adress"/><br/>
						Ntn<input type="checkbox" name="ntn" value="Ntn"/><br/>
						Contact person name<input type="checkbox" name="contact_pname" value="Contact person name"/><br/>
						COntact person designation<input type="checkbox" name="contact_pdesig" value="COntact person designation"/><br/>
						Contact person number<input type="checkbox" name="contact_pno" value="Contact person number"/><br/>
						Supplier type<input type="checkbox" name="stype" value="Supplier type"/><br/> 
					</div>
				</td> 
			</tr>
		</tbody>
	</table>
	</div>
		<table align="center" width="80%" style="border:1px solid #cccccc;">
		<tbody>
			<tr valign="top">
				<td>
					<div id="menu" style="padding:40px;">
						<a  href="#"   id="save_search" ><img src="../../themes/default/images/ok.gif" height="12"><span>Save Search</span></a> &nbsp; &nbsp; &nbsp; <input type="text" name="save_field" value=""  id="save_field"/><br/>
						<a  href="#"   id="print_btn" ><img src="../../themes/default/images/print.png" height="12"><span>Print</span></a> <br/>
						<a  href="#"   id="load_search" ><img src="../../themes/default/images/edit.gif" height="12"><span>Load Search</span></a> 
						<select id="load_select">
						<?php
	 						$sids =get_searches();
		 				while($sid  = db_fetch_assoc($sids)){
							echo "<option value='".$sid['id']."'>".$sid['name']."</option>";
		  				}
						?>
						</select>
						<br/>
					</div>
				</td>
			</tr>
		</tbody>
		</table>
<?php
end_page();
?>