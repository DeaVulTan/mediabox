<?php
/**
* Watermark  class
* Put watermark in image with randomize effect
*
* Last change: 2004-04-16
*
* author Lionel Micault <lionel 'dot' micault 'at' laposte 'dot' net>
* version 1.01
*
* public function markImageFile ( $imageFile, $resultImageFile="")
* public function markImage ( $imageResource)
* public function setStampPosition ( $Xposition, $Yposition)
* public function setStamp( $stampFile)
* public function getLastErrror()
*/
set_time_limit(0);
ini_set('memory_limit','256M');

// position constants
define ("watermarkOnTop", -1);
define ("watermarkOnMiddle", 0);
define ("watermarkOnBottom", 1);
define ("watermarkOnLeft", -1);
define ("watermarkOnCenter", 0);
define ("watermarkOnRight", 1);

// randomize level constants
define ("watermarkRandPixelLightLevel", 1);
define ("watermarkRandPixelPositionLevel", 2);

class watermarkClass
{
	var $stampImage=0;
	var $stampWidth;
	var $stampHeight;
	var $stampPositionX= watermarkOnRight;
	var $stampPositionY= watermarkOnTop;
	var $errorMsg="";


	/**
	* setImagePosition
	*
	* @param string $imagePostions  stamp image position if empty top_right is default
	* @return boolean
	* @access public
	* @uses setImagePosition()
	*/
	public function setImagePosition($imagePostions="")
	{
		if(strtolower($imagePostions)== 'top_right')
		{
			$this->stampPositionX = watermarkOnRight;
			$this->stampPositionY = watermarkOnTop;
		}
		elseif(strtolower($imagePostions)== 'top_left')
		{
			$this->stampPositionX = watermarkOnLeft;
			$this->stampPositionY = watermarkOnTop;
		}
		elseif(strtolower($imagePostions)== 'bottom_right')
		{
			$this->stampPositionX = watermarkOnRight;
			$this->stampPositionY = watermarkOnBottom;
		}
		elseif(strtolower($imagePostions)== 'bottom_left')
		{
			$this->stampPositionX = watermarkOnLeft;
			$this->stampPositionY = watermarkOnBottom;
		}
		elseif(strtolower($imagePostions)== 'center')
		{
			$this->stampPositionX = watermarkOnCenter;
			$this->stampPositionY = watermarkOnMiddle;
		}
	}

	/**
	* setLogoFile
	*
	* @param string $stampFile  filename of stamp image
	* @return boolean
	* @access public
	* @uses setStamp()
	*/
	public function setLogoFile( $stampFile="")
	{
		return( $this->setStamp( $stampFile));
	}
	/**
	* checkFileSize
	*
	* @param string $original_image  filename with full path of original image
	* @param string $watermark_image  filename with full path of water mark image
	* @return boolean
	* @access public
	* @uses checkFileSize()
	*/
	public function checkFileSize($original_image, $watermark_image)
	{
		list($ori_width, $ori_height, $ori_type, $ori_attr) = getimagesize($original_image);
		list($water_width, $water_height, $water_type, $water_attr) = getimagesize($watermark_image);
		if(($water_width >= $ori_width || $water_height >= $ori_height))
		{
			return false;
		}
		else
		{
			return true;
		}
	}



	/**
	* mark an image file and  display/save it
	*
	* @param int $imageFile  image file (JPEG or PNG format)
	* @param int $resultImageFile new image file (same format)
	* @return boolean
	* @access public
	* @uses readImage()
	* @uses markImage()
	* @uses writeImage()
	* @uses readImage()
	* @uses errorMsg
	*/
	public function markImageFile ( $imageFile, $resultImageFile="")
	{
		if (!$this->stampImage)
		{
			$this->errorMsg="Stamp image is not set.";
			return(false);
		}
		$imageinfos = @getimagesize($imageFile);
		$type   = $imageinfos[2];
		$image=$this->readImage($imageFile, $type);
		if (!$image)
		{
			$this->errorMsg="Error on loading '$imageFile', image must be a valid PNG or JPEG file.";
			return(false);
		}
		$this->markImage ( $image);
		if ($resultImageFile!="")
		{
			$this->writeImage( $image, $resultImageFile, $type);
		}
		else
		{
			$this->displayImage( $image, $type);
		}
		return( true);
	}

	/**
	* mark an image
	*
	* @param int $imageResource resource of image
	* @return boolean
	* @access public
	* @uses stampWidth
	* @uses stampHeight
	* @uses stampImage
	* @uses stampPositionX
	* @uses stampPositionY
	*/
	public function markImage ( $imageResource)
	{
		if (!$this->stampImage)
		{
			$this->errorMsg="Stamp image is not set.";
			return(false);
		}
		$imageWidth  = imagesx( $imageResource);
		$imageHeight = imagesy( $imageResource);

		//set position of logo
		switch ($this->stampPositionX)
		{
			case watermarkOnLeft:
				$leftStamp=0;
				break;
			case watermarkOnCenter:
				$leftStamp=($imageWidth - $this->stampWidth)/2;
				break;
			case watermarkOnRight:
				$leftStamp=$imageWidth - $this->stampWidth;
				break;
			default :
				$leftStamp=0;
		}
		switch ($this->stampPositionY)
		{
			case watermarkOnTop:
				$topStamp=0;
				break;
			case watermarkOnMiddle:
				$topStamp=($imageHeight - $this->stampHeight)/2;
				break;
			case watermarkOnBottom:
				$topStamp=$imageHeight - $this->stampHeight;
				break;
			default:
				$topStamp=0;
		}

		// randomize position
		$leftStamp+=rand(-watermarkRandPixelPositionLevel, +watermarkRandPixelPositionLevel);
		$topStamp+=rand(-watermarkRandPixelPositionLevel, +watermarkRandPixelPositionLevel);

		// for each pixel of stamp
		for ($x=0; $x<$this->stampWidth; $x++)
		{
			if (($x+$leftStamp<0)||($x+$leftStamp>=$imageWidth)) continue;
			for ($y=0; $y<$this->stampHeight; $y++)
			{
				if (($y+$topStamp<0)||($y+$topStamp>=$imageHeight)) continue;
				// search RGB values of stamp image pixel
				$indexStamp=ImageColorAt($this->stampImage, $x, $y);
				$rgbStamp=imagecolorsforindex ( $this->stampImage, $indexStamp);
				// search RGB values of image pixel
				$indexImage=ImageColorAt( $imageResource, $x+$leftStamp, $y+$topStamp);
				$rgbImage=imagecolorsforindex ( $imageResource, $indexImage);
				// randomize light shift
				$stampAverage=($rgbStamp["red"]+$rgbStamp["green"]+$rgbStamp["blue"])/3;
				if ($stampAverage>10) $randomizer=rand(-watermarkRandPixelLightLevel, +watermarkRandPixelLightLevel);
				else $randomizer=0;
				// compute new values of colors pixel
				$r=max( min($rgbImage["red"]+$rgbStamp["red"]+$randomizer-0x80, 0xFF), 0x00);
				$g=max( min($rgbImage["green"]+$rgbStamp["green"]+$randomizer-0x80, 0xFF), 0x00);
				$b=max( min($rgbImage["blue"]+$rgbStamp["blue"]+$randomizer-0x80, 0xFF), 0x00);
				// change  image pixel
				imagesetpixel ( $imageResource, $x+$leftStamp, $y+$topStamp, ($r<<16)+($g<<8)+$b);
			}
		}
	}

	/**
	* set stamp position on image
	*
	* @param int $Xposition x position
	* @param int $Yposition y position
	* @return void
	* @access public
	* $this->stampPositionX
	* $this->stampPositionY
	* @uses errorMsg
	*/
	public function setStampPosition ( $Xposition, $Yposition)
	{
		// set X position
		switch ($Xposition)
		{
			case watermarkOnLeft:
			case watermarkOnCenter:
			case watermarkOnRight:
				$this->stampPositionX=$Xposition;
				break;
		}
		// set Y position
		switch ($Yposition)
		{
			case watermarkOnTop:
			case watermarkOnMiddle:
			case watermarkOnBottom:
				$this->stampPositionY=$Yposition;
				break;
		}
	}

	/**
	* set stamp image for watermak
	*
	* @param string $stampFile  image file (JPEG or PNG)
	* @return boolean
	* @access public
	* @uses readImage()
	* @uses stampImage
	* @uses stampWidth
	* @uses stampHeight
	* @uses errorMsg
	*/
	public function setStamp( $stampFile)
	{
		$imageinfos = @getimagesize($stampFile);
		$width  = $imageinfos[0];
		$height = $imageinfos[1];
		$type   = $imageinfos[2];

		if ($this->stampImage) imagedestroy( $this->stampImage);

		$this->stampImage=$this->readImage($stampFile, $type);

		if (!$this->stampImage)
		{
			$this->errorMsg="Error on loading '$stampFile', stamp image must be a valid PNG or JPEG file.";
			return(false);
		}
		else
		{
			$this->stampWidth=$width;
			$this->stampHeight=$height;
			return(true);
		}
	}

	/**
	* retrieve last error message
	*
	* @return string
	* @access public
	* @uses errorMsg
	*/
	public function getLastErrror()
	{
		return($this->errorMsg);
	}

	/**
	* read image from file
	*
	* @param string $file  image file (JPEG or PNG)
	* @param int $type  file type (2:JPEG or 3:PNG)
	* @return resource
	* @access protected
	* @uses errorMsg
	*/
	public function readImage( $file, $type)
	{
		switch ($type)
		{
			case 2:	//JPEG
				return(ImageCreateFromJPEG($file));
				break;

			case 3:	//PNG
				return(ImageCreateFromPNG($file));
				break;

			default:
				$this->errorMsg="File format not supported.";
				return(false);
		}
	}
	/**
	* write image to file
	*
	* @param resource $image  image
	* @param string $file  image file (JPEG or PNG)
	* @param int $type  file type (2:JPEG or 3:PNG)
	* @return void
	* @access protected
	* @uses errorMsg
	*/
	public function writeImage( $image, $file, $type)
	{
		switch ($type)
		{
			case 2:	//JPEG
				Imagejpeg( $image, $file);
				break;

			case 3:	//PNG
				Imagepng( $image, $file);
				break;

			default:
				$this->errorMsg="File format not supported.";
		}
	}
	/**
	* send image to stdout
	*
	* @param resource $image  image
	* @param int $type  image type (2:JPEG or 3:PNG)
	* @return void
	* @access protected
	* @uses errorMsg
	*/
	public function displayImage( $image, $type)
	{
		switch ($type)
		{
			case 2:	//JPEG
				header("Content-Type: image/jpeg");
				Imagejpeg( $image);
				break;

			case 3:	//PNG
				header("Content-Type: image/png");
				Imagepng( $image);
				break;

			default:
				$this->errorMsg="File format not supported.";
		}
	}
}
?>