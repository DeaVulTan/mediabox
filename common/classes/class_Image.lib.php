<?php
/**
 * Members Profile View/Edit Page
 *
 * PHP version 5.0
 *
 * @category	rayzz
 * @package		Members
 * @author 		selvaraj_35ag05
 * @copyright 	Copyright (c) 2008 {@link http://www.mediabox.uz Uzdc Infoway}
 * @license		http://www.mediabox.uz Uzdc Infoway Licence
 * @version		SVN: $Id: class_Image.lib.php 1912 2006-07-31 12:51:59Z sridharan_08ag04 $
 * @since 		2006-05-02
 **/

/**
 * ImageHandler
 *
 * @package
 * @author selvaraj_35ag05
 * @copyright Copyright (c) 2008 {@link http://www.mediabox.uz Uzdc Infoway}
 * @version $Id: class_Image.lib.php 1912 2006-07-31 12:51:59Z sridharan_08ag04 $
 * @access public
 **/
class ImageHandler
	{
		//image resource for original image
	    protected $file_original; //file for original image
	    protected $image_original_width; //dimensions of the original image
	    protected $image_original_height;
	    protected $image_original_type_code; //type code for the original image
	    protected $image_original_type_abbr; //Abbreviation for the code above (JPG, PNG etc)
	    protected $image_original_html_sizes; // same fields for resized image

		// resized image
	    protected $image_resized;

		// these are filled only when you save resized image to the file
	    protected $file_resized;
	    protected $image_resized_width;
	    protected $image_resized_height;
	    protected $image_resized_type_code;
	    protected $image_resized_type_abbr;
	    protected $image_resized_html_sizes;

		// some settings
	    protected $jpeg_quality;
	    protected $use_gd2;

	    // **********************************************
	    // * Now lets construct the image from the file:
	    // **********************************************

	    /**
	     * ImageHandler::ImageHandler()
	     *
	     * @param $file_original
	     * @return
	     **/
	    public function ImageHandler($file_original)
		    {
		        // constructor of the class
		        // it takes given file and creates image out of it
		        global $ERR;
		        $this->clear(); // set all class properties to the start values
		        if (file_exists($file_original)) {
		            $this->file_original = $file_original;
		            $this->image_original = $this->imagecreatefromfile($file_original);
		            if (!$this->image_original) {
		//                $this->error($ERR["IMAGE_NOT_CREATED_FROM_FILE"] . " file=$file_original");
						return false;
		            }
		        } else {
		//            $this->error($ERR["FILE_DOESNOT_EXSIT"] . " file=$file_original");
		        }
		    }

	    // ***************************************************************************************************
	    // * The constructor has introduced three new things to us: array $ERR and methods clear() and
	    // * ImageCreatefromFile(). The array is just associative array with error strings included in file
	    // * class_image.lib.php. Method clear() simply sets some initial values to the properties of the
	    // ***************************************************************************************************

		/**
		 * ImageHandler::clear()
		 *
		 * @return
		 **/
		public function clear()
		    {
		        // clear all the class member variables
		        $this->image_original = 0;
		        $this->file_original = "";
		        $this->image_original_width = 0;
		        $this->image_original_height = 0;
		        $this->image_original_type_code = 0;
		        $this->image_original_type_abbr = "";
		        $this->image_original_html_sizes = "";
		        $this->image_resized = 0;
		        $this->file_resized = "";
		        $this->image_resized_width = 0;
		        $this->image_resized_height = 0;
		        $this->image_resized_type_code = -1;
		        $this->image_resized_type_abbr = "";
		        $this->image_resized_html_sizes = "";
		        $this->set_parameters();
		    }

	    // *********************************************************************************************
	    // * Method setparameters() is needed to set just two properties – use GD2 flag and JPEG quality:
	    // **********************************************************************************************

		/**
		 * ImageHandler::set_parameters()
		 *
		 * @param string $jpeg_quality
		 * @param boolean $use_gd2
		 * @return
		 **/
		public function set_parameters($jpeg_quality = "85", $use_gd2 = true)
		    {
		        $this->jpeg_quality = $jpeg_quality;
		        $this->use_gd2 = $use_gd2;
		    }

		// *******************************************************************************************************
	    // * Much more interesting is method ImageCreateFromFile().
		// * Main purpose of this method is to create image resource
	    // * basing on image type.
	    // *******************************************************************************************************

	    /**
	     * ImageHandler::imagecreatefromfile()
	     *
	     * @param $img_file
	     * @return
	     **/
	    public function imagecreatefromfile($img_file)
		    {
		        global $ERR;
		        $img = 0;
		        $img_sz = getimagesize($img_file); // returns array with some
		        // properties like dimensions and type;
		        // Now create original image from uploaded file. Be careful!
		        // GIF is often not supported, as far as I remember from GD 1.6
		        switch ($img_sz[2]) {
		            case 1:
		                $img = $this->_imagecheckandcreate("ImageCreateFromGif", $img_file);
		                $img_type = "GIF";
		                break;
		            case 2:
		                $img = $this->_imagecheckandcreate("ImageCreateFromJpeg", $img_file);
		                $img_type = "JPG";
		                break;
		            case 3:
		                $img = $this->_imagecheckandcreate("ImageCreateFromPng", $img_file);
		                $img_type = "PNG";
		                break;
		            // would be nice if this function will be finally supported
		            case 4:
		                $img = $this->_imagecheckandcreate("ImageCreateFromSwf", $img_file);
		                $img_type = "SWF";
		                break;
		            default:
		                $img = 0;
		                $img_type = "UNKNOWN";
		//                $this->error($ERR["IMG_NOT_SUPPORTED"] . " $img_file");
		                break;
		        } //switch
		        if ($img) {
		            $this->image_original_width = $img_sz[0];
		            $this->image_original_height = $img_sz[1];
		            $this->image_original_type_code = $img_sz[2];
		            $this->image_original_type_abbr = $img_type;
		            $this->image_original_html_sizes = $img_sz[3];
		        } else {
		            $this->clear();
		        }

		        return $img;
		    }

	    // ******************************************************************************************************
	    // * Basically image is created in method _imagecheckandcreate();
	    // * which takes two parameters -- name of GD function ImagegeCreateFromXXX and filename of the image.
	    // * this method checks if the function exists and if yes calls it:
	    // *******************************************************************************************************

		/**
		 * ImageHandler::_imagecheckandcreate()
		 *
		 * @param $function
		 * @param $img_file
		 * @return
		 **/
		public function _imagecheckandcreate($function, $img_file)
		    {
		        // inner function used from imagecreatefromfile().
		        // Checks if the function exists and returns
		        // created image or false
		        global $ERR;
		        if (function_exists($function)) {
		            $img = false;
		            $img = @$function($img_file);
		        } else {
		            $img = false;
		//            $this->error($ERR["FUNCTION_DOESNOT_EXIST"] . " " . $function);
		        }

		        return $img;
		    }

	    /**
	     * ImageHandler::resize()
	     *
	     * @param $desired_width
	     * @param $desired_height
	     * @param string $mode
	     * @return
	     **/
	    public function resize($desired_width, $desired_height, $mode = "-")
		    {
		        // this is core function--it resizes created image
		        // if any of dimensions == "*" then no resizing on this dimension
		        // >> mode = "+" then image is resized to cover the region specified by desired_width, _height
		        // >> mode = "-" then image is resized to fit into the region specified by desired_width, _height
		        // width-to-height ratio is all the time the same
		        // >>mode=0 then image will be exactly resized to $desired_width _height.
		        // geometrical distortion can occur in this case.
		        // say u have picture 400x300 and there is circle on the picture
		        // now u resized in mode=0 to 800x300 -- circle shape will be distorted and will look like ellipse.
		        // GD2 provides much better quality but is not everywhere installed
		        global $ERR;

		        if ($desired_width == "*" && $desired_height == "*") {
		            // This is stupid to specify that we don't care about both dimensions
		            // That just means that no resizing should occur at all
		            $this->image_resized = $this->image_original;
		            Return true;
		        }
		        if ($this->image_original_width < $desired_width &&  $this->image_original_height < $desired_height)
					{
						$new_width = $this->image_original_width;
						$new_height = $this->image_original_height;
			    	}
			    else
			    	{
				        switch ($mode)
						{
				            case "-":
				            case '+':
				                // multipliers
				                if ($desired_width != "*") $mult_x = $desired_width / $this->image_original_width;
				                if ($desired_height != "*") $mult_y = $desired_height / $this->image_original_height;
				                $ratio = $this->image_original_width / $this->image_original_height;
				                // here we handle case when we don't care about resizing
				                // on one of the dimensions
				                if ($desired_width == "*") {
				                    $new_height = $desired_height;
				                    $new_width = $ratio * $desired_height;
				                } elseif ($desired_height == "*") {
				                    $new_height = $desired_width / $ratio;
				                    $new_width = $desired_width;
				                } else {
				                    // if we are here that means that both dimensions are specified and we have
				                    // to calculate $new_width $new_height according to the resize mode:
				                    if ($mode == "-") {
				                        // image must be smaller than given $desired_ region
				                        // test which multiplier gives us best result
				                        if ($this->image_original_height * $mult_x < $desired_height) {
				                            // $mult_x does the job
				                            $new_width = $desired_width;
				                            $new_height = $this->image_original_height * $mult_x;
				                        } else {
				                            // $mult_y does the job
				                            $new_width = $this->image_original_width * $mult_y;
				                            $new_height = $desired_height;
				                        }
				                    } else {
				                        // mode == "+"
				                        // cover the region
				                        // image must be bigger than given $desired_ region
				                        // test which multiplier gives us best result
				                        if ($this->image_original_height * $mult_x > $desired_height) {
				                            // $mult_x does the job
				                            $new_width = $desired_width;
				                            $new_height = $this->image_original_height * $mult_x;
				                        } else {
				                            // $mult_y does the job
				                            $new_width = $this->image_original_width * $mult_y;
				                            $new_height = $desired_height;
				                        }
				                    }
				                }
				                break;

				            case '0':
				                // fit the region exactly.
				                // The easiest resize mode -- no Math is required :)
				                if ($desired_width == "*") $desired_width = $this->image_original_width;
				                if ($desired_height == "*") $desired_height = $this->image_original_height;
				                $new_width = $desired_width;
				                $new_height = $desired_height;

				                break;
				            default:
				                $this->error($ERR["UNKNOWN_RESIZE_MODE"] . "  $mode");
				                break;
				        }
				    }
		        // OK here we have $new_width $new_height
		        // lets create destination image checking for GD2 functions:
		        if ($this->use_gd2) {
		            if (function_exists("imagecreatetruecolor")) {
		                $this->image_resized = imagecreatetruecolor($new_width, $new_height) or $this->error($ERR["GD2_NOT_CREATED"]);
		            } else {
		                $this->error($ERR["GD2_UNAVALABLE"] . " ImageCreateTruecolor()");
		            }
		        } else {
		            $this->image_resized = imagecreate($new_width, $new_height) or $this->error($ERR["IMG_NOT_CREATED"]);
		        }
		        // Resize
		        if ($this->use_gd2) {
		            if (function_exists("imagecopyresampled")) {
		                $res = imagecopyresampled($this->image_resized,
		                    $this->image_original,
		                    0, 0, // dest coord
		                    0, 0, // source coord
		                    $new_width, $new_height, // dest sizes
		                    $this->image_original_width, $this->image_original_height // src sizes
		                    ) or $this->error($ERR["GD2_NOT_RESIZED"]);
		            } else {
		                $this->error($ERR["GD2_UNAVALABLE"] . " ImageCopyResampled()");
		            }
		        } else {
		            // hmmm... GD2 is not available or ImageCopyResampled() is disabled
		            // I had such a problem in my practice
		            // So lets use old function ImageCopyResized()
		            $res = imagecopyresized($this->image_resized,
		                $this->image_original,
		                0, 0, // dest coord
		                0, 0, // source coord
		                $new_width, $new_height, // dest sizes
		                $this->image_original_width, $this->image_original_height // src sizes
		                ) or $this->error($ERR["IMG_NOT_RESIZED"]);
		        }
		    }

		/**
		 * ImageHandler::fitresize()
		 *
		 * @param $reqwidth
		 * @param $reqheight
		 * @return
		 **/
		public function fitresize($reqwidth, $reqheight)
			{
				//this is the revised version of resize here it check wheather the image is need to compressed or
				//store the old value as it is
				//some coding inherit from resize function
				//this function alone developed by pandurengan
				$ratiowidth = $this->image_original_width / $reqwidth;
				$ratioheight = $this->image_original_height / $reqheight;

				if ($this->image_original_width > $reqwidth || $this->image_original_height > $reqheight)
				{
						if ($ratiowidth >$ratioheight)
						{
							$new_width = intval($this->image_original_width / $ratiowidth);
							$new_height = intval($this->image_original_height / $ratiowidth);
						}
						else
						{
							$new_width = intval($this->image_original_width / $ratioheight);
							$new_height = intval($this->image_original_height / $ratioheight);
						}
				}
				else
				{
					$new_width = intval($this->image_original_width) ;
					$new_height = intval($this->image_original_height);
				}

			    if ($this->use_gd2)
				{
			    	if (function_exists("imagecreatetruecolor"))
					{
			                $this->image_resized = imagecreatetruecolor($new_width, $new_height) or $this->error($ERR["GD2_NOT_CREATED"]);
			        }
					else
					{
			                $this->error($ERR["GD2_UNAVALABLE"] . " ImageCreateTruecolor()");
			        }
				}
				else
				{
			    	$this->image_resized = imagecreate($new_width, $new_height) or $this->error($ERR["IMG_NOT_CREATED"]);
			    }
				        // Resize
		        if ($this->use_gd2)
				{
		            if (function_exists("imagecopyresampled"))
					{
		                $res = imagecopyresampled($this->image_resized,
		                    $this->image_original,
		                    0, 0, // dest coord
		                    0, 0, // source coord
		                    $new_width, $new_height, // dest sizes
		                    $this->image_original_width, $this->image_original_height // src sizes
		                    ) or $this->error($ERR["GD2_NOT_RESIZED"]);
		            }
					else
					{
		                error($ERR["GD2_UNAVALABLE"] . " ImageCopyResampled()");
		            }
		        }
				else
				{
		            $res = imagecopyresized($this->image_resized,
		                $this->image_original,
		                0, 0, // dest coord
		                0, 0, // source coord
		                $new_width, $new_height, // dest sizes
		                $this->image_original_width, $this->image_original_height // src sizes
		                ) or $this->error($ERR["IMG_NOT_RESIZED"]);
		        }
			}

	    /**
	     * ImageHandler::output_original()
	     *
	     * @param $destination_file
	     * @param string $image_type
	     * @return
	     **/
	    public function output_original($destination_file, $image_type = "JPG")
		    {
		        // outputs original image
		        // if destination file is empty  image will be output to browser
		        // right now $image_type can be JPG or PNG
		        return $this->_output_image($destination_file, $image_type, $this->image_original);
		    }

	    /**
	     * ImageHandler::output_resized()
	     *
	     * @param $destination_file
	     * @param string $image_type
	     * @return
	     **/
	    public function output_resized($destination_file, $image_type = "JPG")
		    {
		        // if destination file is empty  image will be output to browser
		        // right now $image_type can be JPG or PNG
		        $res = $this->_output_image($destination_file, $image_type, $this->image_resized);
		        if (trim($destination_file)) {
		            $sz = getimagesize($destination_file);
		            $this->file_resized = $destination_file;
		            $this->image_resized_width = $sz[0];
		            $this->image_resized_height = $sz[1];
		            $this->image_resized_type_code = $sz[2];
		            $this->image_resized_html_sizes = $sz[3];
		            // only jpeg and png are really supported, but I'd like to think of future
		            switch ($this->image_resized_html_sizes) {
		                case 0:
		                    $this->image_resized_type_abbr = "GIF";
		                    break;
		                case 1:
		                    $this->image_resized_type_abbr = "JPG";
		                    break;
		                case 2:
		                    $this->image_resized_type_abbr = "PNG";
		                    break;
		                case 3:
		                    $this->image_resized_type_abbr = "SWF";
		                    break;
		                default:
		                    $this->image_resized_type_abbr = "UNKNOWN";
		                    break;
		            }
		        }
		        return $res;
		    }

	    /**
	     * ImageHandler::_output_image()
	     *
	     * @param $destination_file
	     * @param $image_type
	     * @param $image
	     * @return
	     **/
	    public function _output_image($destination_file, $image_type, $image)
		    {
		        // if destination file is empty  image will be output to browser
		        // right now $image_type can be JPEG or PNG
		        global $ERR;
		        $destination_file = trim($destination_file);
		        $res = false;
		        if ($image) {
		            switch ($image_type) {
		                case 'JPEG':
		                case 'JPG':
		                    $res = imagejpeg($image, $destination_file, $this->jpeg_quality);
		                    break;
		                case 'PNG':
		                    $res = imagepng($image, $destination_file);
		                    break;
						case 'GIF':
		                    $res = imagegif($image, $destination_file);
		                    break;
		                default:
		                    $this->error($ERR["UNKNOWN_OUTPUT_FORMAT"] . " $image_type");
		                    break;
		            }
		        } else {
		            $this->error($ERR["NO_IMAGE_FOR_OUTPUT"]);
		        }
		        if (!$res) $this->error($ERR["UNABLE_TO_OUTPUT"] . " $destination_file");
		        return $res;
		    }

	/**
	 * ###Add function short description###
	 *
	 * ###Add function long description###
	 *
	 * @param		.... ....
	 * @return 		....
	 * @access		....
	 */
	public function error($err='')
		{
		}
	public function chkIsNotBlackImage($image_path)
	{
		if(function_exists('imagecreatefromjpeg'))
		{
			$im = imagecreatefromjpeg($image_path);
			$rgb = imagecolorat($im, 10, 15);
			$index = imagecolorsforindex($im,$rgb);
			if($index['red']==0 && $index['blue']==0 & $index['green']==0)
			{
				return false;
			}
			else
			{
				return true;
			}
		}
		else
		{
		return true;
		}

	}
	}

/******************* USAGE ****************************
*  //create object of class hft_image
*    $image    =    new hft_image($original_image);
*    //resize it
*    $image->resize($desired_width, $desired_height, '-');
*    //output to the browser
*    $image->output_resized("", "JPG");
/*************************************************/
?>