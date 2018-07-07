<?php
class sale_app extends application 
{
	function sale_app() 
	{
		$this->application("sale", _($this->help_context = "&Sales"),false);
	
		$this->add_module(_("Transactions"));
		
		$this->add_module(_("Inquiries and Reports"));
		
		$this->add_module(_("Maintenance "));
 
		// submenus for transaction module
		  
		$this->add_lapp_function(0, _("Create New Contract "),
			"sale/manage/add_manage_employee.php" , 'SA_HRMADMG'   , MENU_ENTRY); 
	 	$this->add_lapp_function(0, _("Create New Delivery Order "),
			"sale/manage/add_manage_resig.php", 'SA_HRMENTRY', MENU_ENTRY); 
		$this->add_lapp_function(0, _("Create New Allocation Form	"),
			"sale/manage/add_manage_prom.php", 'SA_HRMENTRY', MENU_ENTRY);  
		

		// submenus for Inquiries and Reports module
 
	
	$this->add_lapp_function(1, _("Dynamic Search for the sales Module	"),
			"sale/employee_entries.php", 'SA_HRMENTRY', MENU_INQUIRY); 
	
	
		
		
		// submenus for Maintenance module

	$this->add_lapp_function(2, _("Add and Manage Sale Order Type"),
			"sale/manage/add_manage_sale_order_type.php", 'SA_HRMADMG', MENU_MAINTENANCE); 
	$this->add_rapp_function(2, _("Add and Manage Customers	"),
			"sale/manage/add_manage_customers.php", 'SA_HRMADMG', MENU_MAINTENANCE); 
	$this->add_lapp_function(2, _("Add and Manage Shipping	"),
			"sale/manage/add_manage_shipping.php", 'SA_HRMADMG', MENU_MAINTENANCE); 
	$this->add_rapp_function(2, _("Add and Manage Packaging	"),
			"sale/manage/add_manage_packaging.php", 'SA_HRMADMG', MENU_MAINTENANCE); 
	$this->add_lapp_function(2, _("Add and Manage Payment terms	"),
			"sale/manage/add_manage_payment_terms.php", 'SA_HRMADMG', MENU_MAINTENANCE); 
	$this->add_rapp_function(2, _("Add and Manage Shipping Ports	"),
			"sale/manage/add_manage_shipping_ports.php", 'SA_HRMENTRY', MENU_ENTRY);  
	$this->add_lapp_function(2, _("Add and Manage Agents		"),
			"sale/manage/add_manage_agents.php", 'SA_HRMENTRY', MENU_ENTRY); 
	$this->add_rapp_function(2, _("Add and Manage Currencies		"),
			"sale/manage/add_manage_currencies.php", 'SA_HRMENTRY', MENU_ENTRY);
	$this->add_lapp_function(2, _("Add and Manage Container Types		"),
			"sale/manage/add_manage_container_types.php", 'SA_HRMENTRY', MENU_ENTRY); 
	$this->add_rapp_function(2, _("Add and Manage Terms and Conditions "),
			"sale/manage/add_manage_terms_conditions.php", 'SA_HRMENTRY', MENU_ENTRY); 
	$this->add_rapp_function(2, _("And and Manage Customer permissions"),
			"sale/manage/add_manage_customer_permissions.php", 'SA_HRMENTRY', MENU_ENTRY); 
	

			
		$this->add_extensions();
	}
}


?>