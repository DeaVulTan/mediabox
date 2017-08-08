<?php
class createTextImageClass
{
	var $rgb_array = array(
			                'white'          => '255, 255, 255',
			                'snow'           => '255, 250, 250',
			                'PeachPuff'      => '255, 218, 185',
			                'ivory'          => '255, 255, 240',
			                'lavender'       => '230, 230, 250',
			                'black'          => '  0,   0,   0',
			                'DimGrey'        => '105, 105, 105',
			                'gray'           => '190, 190, 190',
			                'grey'           => '190, 190, 190',
			                'navy'           => '  0,   0, 128',
			                'SlateBlue'      => '106,  90, 205',
			                'blue'           => '  0,   0, 255',
			                'SkyBlue'        => '135, 206, 235',
			                'cyan'           => '  0, 255, 255',
			                'DarkGreen'      => '  0, 100,   0',
			                'green'          => '  0, 255,   0',
			                'YellowGreen'    => '154, 205,  50',
			                'yellow'         => '255, 255,   0',
			                'orange'         => '255, 165,   0',
			                'gold'           => '255, 215,   0',
			                'peru'           => '205, 133,  63',
			                'beige'          => '245, 245, 220',
			                'wheat'          => '245, 222, 179',
			                'tan'            => '210, 180, 140',
			                'brown'          => '165,  42,  42',
			                'salmon'         => '250, 128, 114',
			                'red'            => '255,   0,   0',
			                'pink'           => '255, 192, 203',
			                'maroon'         => '176,  48,  96',
			                'magenta'        => '255,   0, 255',
			                'violet'         => '238, 130, 238',	
			                'plum'           => '221, 160, 221',
			                'orchid'         => '218, 112, 214',
			                'purple'         => '160,  32, 240',
			                'azure1'         => '240, 255, 255',
			                'aquamarine1'    => '127, 255, 212'
			              );
		var $text_size  = array(
							 '3'  => 'Small',		
			                 '4' => 'Medium',
			                 '5'  => 'Large'
						  );




	/**
	* set a Color code array
	*
	* */
	public function setColorCode()
	{
		$this->colorCode = $this->rgb_array;
	}


	/**
	* create a image for given text and color using php image functions
	*
	* @param str $text image string.
	* @param int $textSize text size
	* @param int $x text x axis value
	* @param int $y text y axis value
	* @param int $imgWidth Image width
	* @param int $imgHeight Image Height
	* @param str $textColor Image text color
	* @param str $textBackgroundColor Image text back ground color
	* @param str $imgStorePath Water mark image storeage path
	* @return boolean
	* @access public
	*
	*/
	public function creatTextImage($text, $textSize, $x, $y, $imgWidth, $imgHeight, $textColor, $textBackgroundColor, $imgStorePath, $redirectUrl)
	{
		$this->setColorCode();
		header("Content-type: image/jpeg");
		$image = @imagecreate($imgWidth, $imgHeight) or die("Cannot Initialize new GD image stream");
		$this->background_colorarr = split(',',$this->colorCode[$textBackgroundColor]);
		$background_color =  imagecolorallocate($image, $this->background_colorarr[0], $this->background_colorarr[1], $this->background_colorarr[2]);
		$this->text_colorarr = split(',',$this->colorCode[$textColor]);
		$text_color = imagecolorallocate($image, $this->text_colorarr[0],$this->text_colorarr[1], $this->text_colorarr[2]);
		imagestring($image, $textSize, $x, $y,  $text, $text_color);
		imagejpeg($image, $imgStorePath);
		imagedestroy($image);
		header("Location:$redirectUrl?msg=1");
	}

}
?>