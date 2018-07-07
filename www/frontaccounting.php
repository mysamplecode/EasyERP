<?php
if (!isset($path_to_root) || isset($_GET['path_to_root']) || isset($_POST['path_to_root']))
{
	die("Restricted access");
}
	
include_once($path_to_root . '/applications/application.php');
include_once($path_to_root . '/applications/hrm.php');
include_once($path_to_root . '/applications/sale.php');
include_once($path_to_root . '/applications/customers.php');
include_once($path_to_root . '/applications/suppliers.php');
include_once($path_to_root . '/applications/inventory.php');
include_once($path_to_root . '/applications/manufacturing.php');
include_once($path_to_root . '/applications/dimensions.php');
include_once($path_to_root . '/applications/generalledger.php');
include_once($path_to_root . '/applications/towel.php');
include_once($path_to_root . '/applications/setup.php');
include_once($path_to_root . '/installed_extensions.php');

class front_accounting
{
	var $user;
	var $settings;
	var $applications;
	var $selected_application;
	var $menu;
	//constructor
	function front_accounting()
	{
		
	}
	//function that add applications
	function add_application(&$app)
	{	
		if ($app->enabled) // skip inactive modules
		{
			$this->applications[$app->id] = &$app;
		}
	}
	//function that returns an application by an ID
	function get_application($id)
	{
		if (isset($this->applications[$id]))
		{
			return $this->applications[$id];
		}
		return null;
	}
	//function that returns the selected application
	function get_selected_application()
	{ 
 
		if (isset($this->selected_application))
		{
      
			return $this->applications[$this->selected_application];
		}else 
                {
                    foreach ($this->applications as $application)
                    {
                            return $application;
                    }
                }
		return null;
	}
	//function that displays the selected application
	function display()
	{
		global $path_to_root;
			
		include_once($path_to_root . "/themes/".user_theme()."/renderer.php");

		$this->init();
		$rend = new renderer();
		$rend->wa_header();

		$rend->display_applications($this);

		$rend->wa_footer();
		$this->renderer =& $rend;
	}
	//function that starts everything
	function init()
	{

		$this->menu = new menu(_("Main  Menu"));
		$this->menu->add_item(_("Main  Menu"), "index.php");
		$this->menu->add_item(_("Logout"), "/account/access/logout.php");
		$this->applications = array();
		$this->add_application(new hrm_app());
		$this->add_application(new sale_app());
		$this->add_application(new customers_app());
		$this->add_application(new suppliers_app());
		$this->add_application(new inventory_app());
		$this->add_application(new towel_app());
		$this->add_application(new manufacturing_app());
		$this->add_application(new dimensions_app());
		$this->add_application(new general_ledger_app());
		$this->add_application(new setup_app());
		hook_invoke_all('install_tabs', $this);

	//	$this->add_application(new setup_app());
	}
}
?>