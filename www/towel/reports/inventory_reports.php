<?php
$page_security = 'SS_TOWELM';
$path_to_root = "../..";

include_once($path_to_root . "/includes/db_pager.inc");
include_once($path_to_root . "/includes/session.inc");
include_once($path_to_root . "/includes/ui.inc");
include_once($path_to_root . "/towel/includes/db/inventoryr_db.inc"); 
include_once($path_to_root . "/reporting/includes/reports_classes.inc"); 
include_once($path_to_root . "/gl/includes/gl_db.inc"); 

if(isset($_POST['isAjax']))
{
	if($_POST['isAjax'] == "save_search")
	{
		db_query("insert into ".TB_PREF."tssearch(name,dom) values(".db_escape($_POST['name']).",".db_escape($_POST['doom']).")");
		$sids =get_searches();
		while($sid  = db_fetch_assoc($sids))
		{
			echo "<option value='".$sid['id']."'>".$sid['name']."</option>";
		}
		die();
	}	
	if($_POST['isAjax'] == "load_search")
	{
		$result = db_query("select dom from ".TB_PREF."tssearch where id = '".$_POST['id']."' limit 1");
		$row = db_fetch_assoc($result);
		echo html_entity_decode($row['dom']);
		die();
	}
	if($_POST['isAjax'] == "update_fields")
	{
		$allid = get_filtered_ids();
		$output = array();
		if(!isset($_POST['data']['invsup_panel']))
		{
			$output["invsup_panel"] = get_sup_filtered($allid);
		}
		if(!isset($_POST['data']['invcus_panel']))
		{
			$output["invcus_panel"] = get_cus_filtered($allid);
		}
		if(!isset($_POST['data']['invlot_panel']))
		{
			$output["invlot_panel"] = get_lot_filtered($allid);
		}
		if(!isset($_POST['data']['invinv_panel']))
		{
			$output["invinv_panel"] = get_inv_filtered($allid);
		}
		echo json_encode($output);
	}
	if($_POST['isAjax'] == "print_raport")
	{
		$_POST['REP_ID'] =  'report_inventory' ;
		print_raport();
	}
	die();
}

$js = get_js_date_picker();
add_js_file("jquery.js");
add_js_file("jqueryui.js");
add_js_file("treports.js");
page("Inventroy Reports", false, false, "", $js);?>
<div id="doom_search">
	<table align="center" width="80%" style="border:1px solid #cccccc;">
		<tbody>
			<tr valign="top">
				<td width="50%" id="left_panel">
					<b>Search Options:</b> <br/>
						<a href="#invdate_panel"  id="invdate">Inventory by date</a><br/>
						<a href="#invsup_panel" id="invsup">Inventory by Supplier</a><br/>
						<a href="#invinv_panel" id="invinv">Inventory by Inventory #</a><br/>
					<b>Include issued inventories:</b><input type="checkbox" name="issued_inventories" value="1" id="issued_inventories"/><br/>
					<div id="issued_filters" style="padding-left:20px;padding-top:10px;padding-bottom:10px;display:none">
						<a href="#invdatei_panel"  id="invdatei">Inventory by issued date</a><br/>
						<a href="#invlot_panel" id="invlot">Inventory by Lot #</a><br/> 
					</div>
					<b>Include processed inventories:</b><input type="checkbox" name="processed_inventories" value="1" id="processed_inventories"/><br/>
					<div id="processed_filters" style="padding-left:20px;padding-top:10px;padding-bottom:10px;display:none">
						<a href="#invdatep_panel"  id="invdatep">Inventory by processed date</a><br/> 
					</div>
					<b>Include dispatch inventories:</b><input type="checkbox" name="dispatch_inventories" value="1" id="dispatch_inventories"/><br/>
					<div id="dispatch_filters" style="padding-left:20px;padding-top:10px;padding-bottom:10px;display:none">
						<a href="#invdated_panel"  id="invdated">Inventory by dispatch date</a><br/>
						<a href="#invcus_panel" id="invcus">Inventory by customer</a><br/> 
					</div>
				</td>
				<td width="50" style="border-left:1px solid #cccccc;border-right:1px solid #cccccc;padding-left:3px;" id="right_panel">
					<b>Filters:</b> 
					<div id="invdate_panel" class="panels" active="active" style="display:none; text-align:center;padding:10px;">
						<div class="filter_wrapper" style="margin:5px;">
							Start Date:<input type="text" name="invadate_input_start" class="invdate_input_start date_field"/> <br/>
							End Date: <input type="text" name="invadate_input_end" class="invdate_input_end date_field"/> 
						</div>
						<a  href="#"   class="add_filter"  ><img src="../../themes/default/images/add.png" height="12"><span>Add</span></a><br/>
						<a  href="#" class="update_filter"  "><img src="../../themes/default/images/button_ok.png" height="12"><span>Update</span></a><br/>
						<a  href="#"  class="block_filter" ><img src="../../themes/default/images/login.gif" height="12"><span>Block</span></a><br/>
						<a  href="#"   class="exclude_filter"  ><img src="../../themes/default/images/delete.gif" height="12"><span>Exclude</span></a>
					</div>
					<div id="invsup_panel"  class="panels"  active="active"   style="display:none; text-align:center;padding:10px;">
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
					<div id="invinv_panel"  class="panels"  active="active"     style="display:none; text-align:center;padding:10px;"> 
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
					<div id="invdatei_panel"  class="panels"   style="display:none; text-align:center;padding:10px;">
					
						<div class="filter_wrapper" style="margin:5px;">
							Start Date:<input type="text" name="invadate_input_start" class="invdate_input_start date_field"/> <br/>
							End Date: <input type="text" name="invadate_input_end" class="invdate_input_end date_field"/> 
						</div>
						<a  href="#"   class="add_filter"  ><img src="../../themes/default/images/add.png" height="12"><span>Add</span></a><br/>
						<a  href="#" class="update_filter"  "><img src="../../themes/default/images/button_ok.png" height="12"><span>Update</span></a><br/>
						<a  href="#"  class="block_filter" ><img src="../../themes/default/images/login.gif" height="12"><span>Block</span></a><br/>
						<a  href="#"   class="exclude_filter"  ><img src="../../themes/default/images/delete.gif" height="12"><span>Exclude</span></a>
					
					
					
					</div>
					<div id="invlot_panel"  class="panels"   style="display:none; text-align:center;padding:10px;">
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
					<div id="invdatep_panel"  class="panels"   style="display:none; text-align:center;padding:10px;">
						<div class="filter_wrapper" style="margin:5px;">
							Start Date:<input type="text" name="invadate_input_start" class="invdate_input_start date_field"/> <br/>
							End Date: <input type="text" name="invadate_input_end" class="invdate_input_end date_field"/> 
						</div>
				 
						<a  href="#"   class="add_filter"  ><img src="../../themes/default/images/add.png" height="12"><span>Add</span></a><br/>
						<a  href="#" class="update_filter"  "><img src="../../themes/default/images/button_ok.png" height="12"><span>Update</span></a><br/>
						<a  href="#"  class="block_filter" ><img src="../../themes/default/images/login.gif" height="12"><span>Block</span></a><br/>
						<a  href="#"   class="exclude_filter"  ><img src="../../themes/default/images/delete.gif" height="12"><span>Exclude</span></a>
					
					
					
					</div>
					<div id="invdated_panel"  class="panels"   style="display:none; text-align:center;padding:10px;">
						<div class="filter_wrapper" style="margin:5px;">
							Start Date:<input type="text" name="invadate_input_start" class="invdate_input_start date_field"/> <br/>
							End Date: <input type="text" name="invadate_input_end" class="invdate_input_end date_field"/> 
						</div>
						<a  href="#"   class="add_filter"  ><img src="../../themes/default/images/add.png" height="12"><span>Add</span></a><br/>
						<a  href="#" class="update_filter"  ><img src="../../themes/default/images/button_ok.png" height="12"><span>Update</span></a><br/>
						<a  href="#"  class="block_filter" ><img src="../../themes/default/images/login.gif" height="12"><span>Block</span></a><br/>
						<a  href="#"   class="exclude_filter"  ><img src="../../themes/default/images/delete.gif" height="12"><span>Exclude</span></a>
					
					
					
					
					
					</div>
					<div id="invcus_panel"  class="panels"   style="display:none; text-align:center;padding:10px;">
					<div class="filter_wrapper" style="margin:5px;">
						<select name="lov_select" class="lov_select">
							<option value="">None</option>
							<?php
								$custs = get_all_customers();
								while($cust = db_fetch_assoc($custs)){
									echo "<option value='".$cust['id']."'>".$cust['name']."</option>";
								
								}
							?>
						</select>
					</div>
						<a  href="#"   class="add_filter"  ><img src="../../themes/default/images/add.png" height="12"><span>Add</span></a><br/>
						<a  href="#" class="update_filter"  ><img src="../../themes/default/images/button_ok.png" height="12"><span>Update</span></a><br/>
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
					
						<a href="#printinv_panel"  id="printinv">Inventory table</a><br/>
						<a href="#printsup_panel" id="printsup">Supplier table</a><br/>
						<a href="#printlot_panel" id="printlot">Lot table</a><br/>
						<a href="#printcust_panel" id="printcust">Customer tabler</a><br/>
				</td>
				<td width="50" style="border-left:1px solid #cccccc;border-right:1px solid #cccccc;padding-left:3px;"  id="rightpanel_print"  >
					<b>Print filters:</b> 
					<div id="printinv_panel"  style="display:none;  padding:10px;">
						Inventory #<input type="checkbox" name="id" value="Inventory #"/><br/>
						Supplier<input type="checkbox" name="sup" value="Supplier"/><br/>
						Gate in<input type="checkbox" name="gate_in" value="Gate in"/><br/>
						IGP<input type="checkbox" name="igp" value="IGP"/><br/>
						Description of Goods<input type="checkbox" name="goods" value="Description of Goods"/><br/>
						Driver Name<input type="checkbox" name="driver" value="Driver Name"/><br/>
						Vehicle<input type="checkbox" name="vehicle" value="Vehicle"/><br/>
						Gate out<input type="checkbox" name="gate_out" value="Gate out"/><br/>
						Received by<input type="checkbox" name="recv" value="Received by"/><br/>
						Received by designation<input type="checkbox" name="recvby" value="Received by designation"/><br/> 
					</div>
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