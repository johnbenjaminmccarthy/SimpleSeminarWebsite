<?php 
$email=base64_decode($_GET['email']);

$lengths=imagettfbbox(12,0, './FiraSans-Regular.ttf', $email);
$width=$lengths[2]-$lengths[0];
$height=$lengths[1]-$lengths[7];

$my_img = imagecreate( $width+10, $height+3 );
$background = imagecolorallocate( $my_img, 255, 255, 255 );
$text_colour = imagecolorallocate( $my_img, 0, 62, 116 );

imagettftext($my_img, 12, 0, 2, 17, $text_colour, './FiraSans-Regular.ttf', $email);

header( "Content-type: image/png" );
imagepng( $my_img );
imagedestroy( $my_img );
?> 
