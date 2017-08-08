<?php

/**
 *
 *
 * @version $Id$
 * @copyright Copyright (c) 2008 {@link http://www.mediabox.uz Uzdc Infoway}
 */
class GoogleGrab
{
	public $flv_path;
	public $error_message;

	public function getGoogleVideoDetail($docid)
	{
		$filename='http://video.google.com/videofeed?docid='.$docid;
		if($xmlstr = @fileGetContentsManual($filename) and $this->setDOMObject($xmlstr))
		{
			$media_node = $this->xp->query("channel/item/media:group");
			foreach($media_node as $media_details)
			{
				 foreach ($media_details->childNodes  as $details)
				{
					if (($details->nodeName == 'media:content') && ($details->nodeType == 1))
					{
						if ( $details -> getAttribute('type') == 'video/x-flv')
							{
								$this->flv_path	 = $details -> getAttribute('url');
							}
							else
							{
								$this->error_message = 'Not able to fetch video/x-flv detail from google';
							}
					}
					else
					{
						$this->error_message = 'Not able to fetch media:content detail from google';
					}
				}
			}

		}
		else
		{
			$this->error_message = 'Not able to fetch the video detail from google';
		}
		if($this->flv_path)
		{
			$this->error_message='';
		}

	}
	public function setDOMObject($xmlstr)
	{
			$xmlstr=utf8_encode($xmlstr);
			//$xmlstr=mb_convert_encoding($xmlstr,'UTF-8');
			$this->dom = new DomDocument();
			//for testing purpose static file name is given
			//if ($this->dom->load('..\..\delgoogle.xml'))
			if ($this->dom->loadXML($xmlstr))
				{
					$this->xp = new domxpath($this->dom);
				}
			else
				{
					trigger_error('Invalid xml string error', E_USER_ERROR);
					return false;
				}
			return true;
	}


}

?>