<?php 
define('PROFILE_PICTURE_WIDTH',150);
define('PROFILE_PICTURE_HEIGHT',150);
define('CARD_WIDTH',250);
define('CARD_HEIGHT',160);
define('BARCODE_WIDTH',200);
define('BARCODE_HEIGHT',20);
define('IDCARD_PICTURE_WIDTH',66);
define('IDCARD_PICTURE_HEIGHT',66);
define('NO_IMAGE',"$path_to_root/themes/default/images/noimage.jpg");
define('COMPANY_LOGO',"$path_to_root/themes/default/images/ait.jpg");
function save_resized_image($path, $image)
{
	$ext = explode(".", $image['name']);
	$ext = strtolower($ext[count($ext) - 1]);
	$img = '';
	if ($ext == 'jpg' || $ext == 'jpeg')
		$img = imagecreatefromjpeg($image['tmp_name']);
	else if ($ext == 'png')
		$img = imagecreatefrompng($image['tmp_name']);
	else if ($ext == 'gif')
		$img = imagecreatefromgif($image['tmp_name']);
	else 
		return false;
	$pic_name = "profile-".uniqid().'.png';
	$new_img = resize_image($img,PROFILE_PICTURE_WIDTH,PROFILE_PICTURE_HEIGHT,$image['tmp_name']);
	ob_start();
	$tempo = ob_get_contents();
	imagepng($new_img);
	$temp = ob_get_contents();	
	file_put_contents($path.$pic_name, $temp);
	ob_end_clean();
	imagedestroy($img);
	imagedestroy($new_img);
	return $path.$pic_name;	
}
//-------------------
function resize_image( $img, $new_width, $new_height,$path )
{
	list( $source_image_width, $source_image_height, $source_image_type ) = getimagesize( $path);

    $new_image = imagecreatetruecolor( $new_width, $new_height );

    imagecopyresampled( $new_image, $img, 0, 0, 0, 0, $new_width, $new_height, $source_image_width, $source_image_height );

    return $new_image;
}

?>