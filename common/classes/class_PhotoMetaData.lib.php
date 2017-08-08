<?php

/**
 *This class is is used to get a photo meta data.
 *
 * In this class $default_meta_data_array have the default photo meta datas.
 * the method setFile we pass the photo name with full path for this methos
 * the method setPhotoMetaDataArray we are able to set the particular meta data for photo.
 * If we are send a needed meta data array to setPhotoMetaDataArray method we will get the $default_meta_data_array.
 * Method getPhotoMetaData return the associate array of metadata. we can use this return array key as label.
 *
 * @version $Id$
 * @copyright 2009
 *
 *
 */
require_once("phpExifRW/exifReader.inc");
class ImageMetaDataClass
{
	// set the default photo meta data.
	var $default_meta_data_array = array('FileSize',        //Photo file  Size
										 'flashUsed',       //Flash used or not
										 'make',            // Camera Name
										 'model',           // Camera Type
										 'xResolution',     // Photo Xaxis Resolution.
										 'yResolution',     // Photo Yaxis Resolution
										 'fileModifiedDate',// Photo File Modified Date
										 'exposureTime',    // Photo Exposure Time
										 'fnumber',         // F Number
										 'exposure',        // Exposure Method
										 'DateTime',        // Photo File Created Date Time
										 'jpegQuality',     // Photo quality.
										 'whiteBalance',    // Photo White Balance
										 'focalLength',     // Focal Length
										 'flashpixVersion', // camera Flash version
										 'Width',           // Photo width
										 'Height',          // Photo Height
										 'screenCaptureType',// Photo capture type
										 'contrast',        // Photo contrast
										 'saturation',      // Photo Saturation
										 'sharpness',       // Photo Sharpness
										 'resolution',      // Photo resolution
										 'orientation',     // orientation
										 'color',           // Photo color or black and white
										 'artist',          // Photo Owner
                                         'copyright',       // Copyright details.
										 'software',        // Software
                                         'brightness',      // Photo brightnessss
										 'zoomRatio'        //Photo zoomration
										);
	/**
	* To set the jpeg file for get  photo meta data.
	*
	* @param 		string $filename filename with full path
	* @return 		void
	* @access 		public
	*/
   	public function setFile($filename)
   	{
   		$this->file = $filename;
   	}
	/**
	* To create a class object for exif class.
	*
	* @return 		void
	* @access 		public
	*/
	public function createExifObject()
	{
		$this->exifObj = new phpExifReader($this->file);
		$this->exifObj->Debugging = 1;
	}
	/**
	* To get the photo metata and store it in array.
	*
	* @return 		photo meta data array
	* @access 		public
	*/
	public function imageMetaData()
	{
		$this->createExifObject();
		$image_meta_data=$this->exifObj->getImageInfo();
		if(!empty($image_meta_data))
			return $image_meta_data;
		else
			return	false;
	}
	/**
	* To set an array for needed photo meta data.
	*
	* @param 		array $expected_meta_data_array needed meta data array or empty
	* @return 		void
	* @access 		public
	*/
	public function setPhotoMetaDataArray($expected_meta_data_array = array())
	{
		$this->expected_meta_data_array = $expected_meta_data_array;
	}
	/**
	* To get an array for photo meta data.
	*
	* @return 		array photo meta data array.
	* @access 		public
	*/
	public function getPhotoMetaData()
	{
		global $LANG;
		$return_meta_data = array();
		$whole_meta_data=$this->imageMetaData();
		if(empty($this->expected_meta_data_array) || count($this->expected_meta_data_array)<=0)
			$this->expected_meta_data_array = $this->default_meta_data_array;
		foreach($whole_meta_data as $key => $value)
		{
			foreach($this->expected_meta_data_array as $data)
			{
				if (strtolower($data) == strtolower($key))
				{
					switch($data)
					{
						case 'resolutionUnit':
							$label = 'photo_resolution_unit';
							break;
						case 'FileName':
							$label = 'photo_photo_name';
							break;
						case 'FileSize':
							$label = 'photo_photo_size';
							break;
						case 'FlashUsed':
							$label = 'photo_flash_used';
							break;
						case 'imageDesc':
							$label = 'photo_photo_description';
							break;
						case 'make':
							$label = 'photo_camera';
							break;
						case 'model':
							$label = 'photo_camera_model';
							break;
						case 'xResolution':
							$label = 'photo_photo_xaxis_resolution';
							break;
						case 'yResolution':
							$label = 'photo_photo_yaxis_resolution';
							break;
						case 'fileModifiedDate':
							$label = 'photo_photo_modified_date';
							break;
						case 'exposureTime':
							$label = 'photo_exposure_time';
							break;
						case 'fnumber':
							$label = 'photo_fnumber';
							break;
						case 'exposure':
							$label = 'photo_exposure';
							break;
						case 'exifVersion':
							$label = 'photo_exif_version';
							break;
						case 'DateTime':
							$label = 'photo_photo_created_date';
							break;
						case 'dateTimeDigitized':
							$label = 'photo_photo_created_date';
							break;
						case 'componentConfig':
							$label = 'photo_component_config';
							break;
						case 'jpegQuality':
							$label = 'photo_photo_quality';
							break;
						case 'exposureBias':
							$label = 'photo_exposure_bias';
							break;
						case 'aperture':
							$label = 'photo_aperture';
							break;
						case 'meteringMode':
							$label = 'photo_metering_mode';
							break;
						case 'whiteBalance':
							$label = 'photo_white_balance';
							break;
						case 'flashUsed':
							$label = 'photo_flash_used';
							break;
						case 'focalLength':
							$label = 'photo_focal_length';
							break;
						case 'makerNote':
							$label = 'photo_maker_note';
							break;
						case 'flashpixVersion':
							$label = 'photo_maker_note';
							break;
						case 'Width':
							$label = 'photo_photo_width';
							break;
						case 'Height':
							$label = 'photo_photo_height';
							break;
						case 'exposureMode':
							$label = 'photo_exposure_mode';
							break;
						case 'screenCaptureType':
							$label = 'photo_screen_capture_type';
							break;
						case 'contrast':
							$label = 'photo_photo_contrast';
							break;
						case 'saturation':
							$label = 'photo_photo_saturation';
							break;
						case 'sharpness':
							$label = 'photo_photo_sharpness';
							break;
						case 'compressScheme':
							$label = 'photo_compress_scheme';
							break;
						case 'IsColor':
							$label = 'photo_is_color';
							break;
						case 'Process':
							$label = 'photo_process';
							break;
						case 'resolution':
							$label = 'photo_photo_resolution';
							break;
						case 'orientation':
							$label = 'photo_photo_orientation';
							break;
						case 'color':
							$label = 'photo_photo_color';
							break;
						case 'jpegProcess':
							$label = 'photo_jpeg_process';
							break;
						case 'artist':
							$label = 'photo_artist';
							break;
						case 'copyright':
							$label = 'photo_copyright';
							break;
						case 'focusDistance':
							$label = 'photo_focus_distance';
							break;
						case 'Distance':
							$label = 'photo_distance';
							break;
						case 'software':
							$label = 'photo_software';
							break;
						case 'relatedSoundFile':
							$label = 'photo_related_sound_file';
							break;
						case 'brightness':
							$label = 'photo_photo_brightness';
							break;
						case 'gainControl':
							$label = 'photo_gain_control';
							break;
						case 'zoomRatio':
							$label = 'photo_zoom_ratio';
							break;
						case 'sensing':
							$label = 'photo_sensing';
							break;
						default:
							$label = $data;
							break;
					}
					$return_meta_data[$label] = $whole_meta_data[$key];
				}
			}
		}
		if(!empty($return_meta_data))
			return $return_meta_data;
		else
			return false;
	}
}
?>