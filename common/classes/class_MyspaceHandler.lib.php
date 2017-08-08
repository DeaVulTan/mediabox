<?php

/**
 *
 *
 * @version $Id$
 * @copyright Copyright (c) 2008 {@link http://www.mediabox.uz Uzdc Infoway}
 */
class MyspaceGrab
{
	public $flv_path;
	public $error_message;

	public function getMyspaceVideoDetail($VideoID)
	{
		$filename='http://mediaservices.myspace.com/services/rss.ashx?type=video&mediaID='.$VideoID;
		$xmlstr = @fileGetContentsManual($filename);
		$strPosition = strpos(fileGetContentsManual($filename), '<media:content url="');
		if(!empty($strPosition))
			{
				$xmlstr = explode('<media:content url="', $xmlstr);
				$strPosition = strpos($xmlstr['1'], '" type="video/x-flv"');
				if(!empty($strPosition))
					{
						$xmlstr = explode('" type="video/x-flv"', $xmlstr['1']);
						$this->flv_path	 = $xmlstr['0'];
					}
				else
					{
						$this->error_message = 'Not able to fetch video/x-flv detail from myspace';
					}

			}
		else
			{
				$this->error_message = 'Not able to fetch media:content detail from myspace';
			}

		if($this->flv_path)
			{
				$this->error_message='';
			}
	}
}

?>