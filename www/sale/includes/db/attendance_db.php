<?php
function id2hash($id){
$id = (string)(100000 - (int)$id);
$len = strlen($id);
for($i = 5;$i>$len;$i--)
	$id = "0".$id;
	
 $id = str_replace(array("0","1","2","3","4","5","6","7","8","9"),array("y","w","v","r","t","j","k","l","p","q"),$id);
 
 return $id;
}
function hash2id($hash){
 	
 $hash = str_replace(array("y","w","v","r","t","j","k","l","p","q"),array("0","1","2","3","4","5","6","7","8","9"),$hash);
 $hash = (int)(100000-(int)$hash);
 return $hash;
}

?>