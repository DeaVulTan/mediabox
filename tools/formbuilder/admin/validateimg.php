<?php

require_once(dirname((dirname(__FILE__))) . DIRECTORY_SEPARATOR . "inc" . DIRECTORY_SEPARATOR . "config.base.php");
$rndstring = "";
for($i=0;$i<4;$i++)
{
	$rndstring .= chr(mt_rand(65,90));
}
$_SESSION["validate"]=strtolower($rndstring);
$rndcodelen = strlen($rndstring);
$im = imagecreate(50,20);

//$bgcolor = imagecolorallocate($im, 248,212,20);
//$black = imagecolorallocate($im, 0,0,0);

//$bgcolor = imagecolorallocate($im, 53,160,206);
$theme = (isset($_GET['theme'])?$_GET['theme']:'');

switch($theme)
{

	case 'grey_green':
		$bgcolor = imagecolorallocate($im, 46,85,69);
		$textColor=imagecolorallocate($im, 249,250,252);		
		break;
	case 'grey_blue':
				
	default:
		$bgcolor = imagecolorallocate($im, 83,83,83);
		$textColor=imagecolorallocate($im, 249,250,252);			
}



$boder=imagecolorallocate($im, 255,255,255);
//$boder= imagecolorallocate($im, 123,167,221);

imagerectangle($im, 0, 0, 49, 19,$boder);

for($i=0;$i<$rndcodelen;$i++)
{
	imagestring($im, mt_rand(2,5), $i*10+6, mt_rand(2,5), $rndstring[$i], $textColor);
}

if(function_exists("imagejpeg"))
{ 
 header("content-type:image/jpeg\r\n"); imagejpeg($im, null, 100); 
}
else
{ 
header("content-type:image/png\r\n"); imagepng($im); 
}
imagedestroy($im);
