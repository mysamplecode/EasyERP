<?php

function custom_select_row($label,$name,$items,$ajax=false){


	echo "<tr><td>$label</td><td>";
	echo  array_selector($name, null, $items, 
		array( 
			'select_submit'=>$ajax,
			'async' => false ) ); // FIX?
	echo "</td></tr>\n";

	


}
 

function custom_select($label,$name,$items,$ajax=false){

	echo "<td>$label";
	echo  array_selector($name, null, $items, 
		array( 
			'select_submit'=>$ajax,
			'async' => false ) ); // FIX?
	echo "</td>\n";

	



}

function show_select($label,$name,$table,$ajax = false){
	$result = get_all_items($table);
while ($row = db_fetch($result))
{
 	$items[$row['id']] = $row['name'];
}
	echo "<td>$label";
	echo  array_selector($name, null, $items, 
		array( 
			'select_submit'=>$ajax,
			'async' => false ) ); // FIX?
	echo "</td>\n";

	


}
function show_select_row($label,$name,$table,$ajax = false){
	$result = get_all_items($table);
	$items = array(""=>"None");
while ($row = db_fetch($result))
{
 	$items[$row['id']] = $row['name'];
}
	echo "<tr><td>$label</td><td>";
	echo  array_selector($name, null, $items, 
		array( 
			'select_submit'=>$ajax,
			'async' => false ) ); // FIX?
	echo "</td></tr>\n";

	


}
function get_all_items($table){
	$sql = "SELECT name,id FROM "
		.TB_PREF."$table ";
	
	return db_query($sql, "could not get item");


}

?>