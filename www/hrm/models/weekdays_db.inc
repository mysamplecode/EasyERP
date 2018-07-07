<?php
class weekday_model
{
	//---gets all the units from the table----
	public $table;
	public $id;
	public function __construct()
	{
		global $prefix; 
		$this -> table = $prefix."weekday";
		$this -> id = "weekday_id";
	}
	function select(&$post)
	{
            try{
                $myrow =  select_PluSQL($this -> table, array($this -> id => 1));
		$post['monday'] = $myrow -> monday; 
                $post['tuesday'] = $myrow -> tuesday; 
                $post['wednesday'] = $myrow -> wednesday; 
                $post['thursday'] = $myrow -> thursday; 
                $post['friday'] = $myrow -> friday; 
                $post['saturday'] = $myrow -> saturday; 
                $post['sunday'] = $myrow -> sunday; 
            }
            catch(EmptySetException $e)
            {
                insert_advanced_PluSQL($this -> table,array('weekday_id' => 1),$this -> id);
            }
	}
	//------------
	function update($post = array())
	{
		$post['weekday_id'] = 1;
                
                if(!isset($post['monday']))$post['monday'] = 0;
                if(!isset($post['tuesday']))$post['tuesday'] = 0;
                if(!isset($post['wednesday']))$post['wednesday'] = 0;
                if(!isset($post['thursday']))$post['thursday'] = 0;
                if(!isset($post['friday']))$post['friday'] = 0;
                if(!isset($post['saturday']))$post['saturday'] = 0;
                if(!isset($post['sunday']))$post['sunday'] = 0;
                
		update_PluSQL($this -> table,$post,$this -> id,strip(1));
	}	
}
?>