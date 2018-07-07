<?php 
//-----Adds an print link to the form--------
function print_link($row)
{
	return button("Print".end($row),1, _("Print"),ICON_PRINT );
}
//-----Adds an edit link to the form-------- 
function edit_link($row)
{ 
	return button("Edit".end($row),1, _("Edit"), ICON_EDIT );
}
//-----Adds a delete link to the form--------
function delete_link($row)
{
	return button("Delete".end($row),1, _("Delete"),ICON_DELETE );
}
//-----Adds a card link to the form--------
function card_link($row)
{
	return button("Card".end($row),1, _("Card"),ICON_CARD);
}
//-------------------------------------------
function compare_list($name,$title)
{
	$items = array();  
 
 	$items[] = ">=";
 	$items[] = "=<";
 	$items[] = "==";

  
	echo "<td>$title &nbsp;&nbsp;";
	echo  array_selector($name, null, $items, 
		array( 
			'select_submit'=>true,
			'async' => false ) ); // FIX?
	echo "</td>\n";

	
}
function jedit_link($row)
{ 
	return button("jEdit".end($row),1, _("jEdit"), ICON_EDIT );
}
function jdelete_link($row)
{
	return button("jDelete".end($row),1, _("jDelete"),ICON_DELETE);
}

?>