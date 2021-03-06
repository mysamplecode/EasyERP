<?php
define('MENU_ENTRY', 'menu_entry');
define('MENU_TRANSACTION', 'menu_transaction');
define('MENU_INQUIRY', 'menu_inquiry');
define('MENU_REPORT', 'menu_report');
define('MENU_MAINTENANCE', 'menu_maintenance');
define('MENU_UPDATE', 'menu_update');
define('MENU_SETTINGS', 'menu_settings');
define('MENU_SYSTEM', 'menu_system');
//---class menu-item
class menu_item
{
	var $label;
	var $link;
		
	function menu_item($label, $link) 
	{
		$this->label = $label;
		$this->link = $link;
	}
}
//---class menu
class menu 
{
	var $title;
	var $items;
		
	function menu($title) 
	{
		$this->title = $title;
		$this->items = array();
	}
		
	function add_item($label, $link) 
	{
		$item = new menu_item($label,$link);
		array_push($this->items,$item);
		return $item;
	}
		
}
//--- class app function
class app_function 
{
	var $label;
	var $link;
	var $access;
    var $category;
		
	function app_function($label,$link,$access='SA_OPEN',$category='')
	{
		$this->label = $label;
		$this->link = $link;
		$this->access = $access;
        $this->category = $category;
	}
}
//----class module
class module 
{
	var $name;
	var $icon;
	var $lappfunctions;
	var $rappfunctions;
		
	function module($name,$icon = null) 
	{
		$this->name = $name;
		$this->icon = $icon;
		$this->lappfunctions = array();
		$this->rappfunctions = array();
	}
		
	function add_lapp_function($label,$link="",$access='SA_OPEN',$category='')
	{
		$appfunction = new app_function($label,$link,$access,$category);
		//array_push($this->lappfunctions,$appfunction);
		$this->lappfunctions[] = $appfunction;
		return $appfunction;
	}

	function add_rapp_function($label,$link="",$access='SA_OPEN',$category='')
	{
		$appfunction = new app_function($label,$link,$access,$category);
		//array_push($this->rappfunctions,$appfunction);
		$this->rappfunctions[] = $appfunction;
		return $appfunction;
	}
}

class application 
{
	var $id;
	var $name;
	var $help_context;
	var $modules;
	var $enabled;
		
	function application($id, $name, $enabled=true) 
	{
		$this->id = $id;
		$this->name = $name;
		$this->enabled = $enabled;
		$this->modules = array();
	}
		
	function add_module($name, $icon = null) 
	{
		$module = new module($name,$icon);
		//array_push($this->modules,$module);
		$this->modules[] = $module;
		return $module;
	}
		
	function add_lapp_function($level, $label,$link="",$access='SA_OPEN',$category='')
	{
		$this->modules[$level]->lappfunctions[] = new app_function($label, $link, $access, $category);
	}
		
	function add_rapp_function($level, $label,$link="",$access='SA_OPEN',$category='')
	{
		$this->modules[$level]->rappfunctions[] = new app_function($label, $link, $access, $category);
	}
		
	function add_extensions()
	{
		hook_invoke_all('install_options', $this);
	}
	//
	// Helper returning link to report class added by extension module.
	//
	function report_class_url($class)
	{
		global $installed_extensions;
		// TODO : konwencja lub ?
		$classno = 7;
		//if (file_exists($path_to_root.'/'.$mod['path'].'/'.$entry['url']
		//.'/'.'reporting/reports_custom.php'))
		return "reporting/reports_main.php?Class=".$class;
		//else
		//return '';
	}
}
?>