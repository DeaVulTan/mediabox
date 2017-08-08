<?php
/**
 * frp conect, upload file and delete file
 *
 * PHP version 5.0
 *
 * @category	rayzz
 * @package		Common
 * @author 		selvaraj_35ag05
 * @copyright 	Copyright (c) 2008 {@link http://www.mediabox.uz Uzdc Infoway}
 * @license		http://www.mediabox.uz Uzdc Infoway Licence
 * @version		SVN: $Id: $
 * @since 		2006-05-02
 **/ 

/**
 * StripTags
 * 
 * @package 
 * @author Selvaraj
 * @copyright Copyright (c) 2008 {@link http://www.mediabox.uz Uzdc Infoway}
 * @version $Id$
 * @access public
 **/
class StripTags 
	{
		/**
		 * StripTags::StripTagsAndClass()
		 * 
		 * @param $htmlstring
		 * @param array $disallowed_tag
		 * @param array $disallowed_empty_tag
		 * @param array $disallowed_style_class
		 * @return 
		 **/
		public function StripTagsAndClass($htmlstring, $editor, $disallowed_tag = array(), $disallowed_empty_tag = array(), $disallowed_style_class=array(), $disallowed_attributes = array())
			{				
				return html_entity_decode($htmlstring);
				if($editor=='FCK')
					{
						$htmlstring = str_replace('&lt;br /&gt;&lt;br /&gt;','&lt;br&gt;',$htmlstring);
						$htmlstring = str_replace('&lt;br /&gt;','',$htmlstring);
						$htmlstring = str_replace('amp;','',$htmlstring);
						$htmlstring = str_replace('&lt;span class=&quot;start-tag&quot;&gt;','',$htmlstring);
						$htmlstring = str_replace('&lt;span class=&quot;end-tag&quot;&gt;','',$htmlstring);
						$htmlstring = str_replace('&lt;span class=&quot;attribute-name&quot;&gt;','',$htmlstring);
						$htmlstring = str_replace('&lt;span class=&quot;attribute-value&quot;&gt;','',$htmlstring);
						$htmlstring = str_replace('&lt;!--StartFragment --&gt;&nbsp;','',$htmlstring);
						$htmlstring = str_replace('&lt;/span&gt;','',$htmlstring);
					}
				//echo $htmlstring;exit;
				$htmlstring = html_entity_decode($htmlstring);
				
				//clean and repair the source
				$htmlstring = tidy_parse_string($htmlstring);
				tidy_clean_repair($htmlstring);
					
				//remove unnecessary style properties
				if($disallowed_style_class)
					$htmlstring = $this->removeStyleClasses($htmlstring, $disallowed_style_class);
				
				//remove unnecessary tags with contents
				if($disallowed_tag)
					$htmlstring = $this->removeTags($htmlstring, $disallowed_tag);
					
				//remove unnecessary tags with contents
				if($disallowed_attributes)
					$htmlstring = $this->removeAttributes($htmlstring, $disallowed_attributes);
				
				$htmlstring = str_replace('<a','<a target="_blank"', $htmlstring);
				
				//clean and repair the source
				$htmlstring = tidy_parse_string($htmlstring);
				tidy_clean_repair($htmlstring);
				
				//remove unnecessary empty tags
				if($disallowed_empty_tag)
					$htmlstring = $this->removeEmptyTags($htmlstring, $disallowed_empty_tag);
					
				return $htmlstring;
			}
		
		/**
		 * StripTags::removeStyleClasses()
		 * 
		 * @param $htmlstring
		 * @param array $disallowed_style_class
		 * @return 
		 **/
		public function removeStyleClasses($htmlstring, $disallowed_style_class=array())
			{
				
				foreach($disallowed_style_class as $class)					
					$htmlstring = preg_replace('\''.$class.'[^{]*.*}\'siU','',$htmlstring);
				return $htmlstring;
			}
			
		/**
		 * StripTags::removeEmptyTags()
		 * 
		 * @param $htmlstring
		 * @param array $disallowed_empty_tag
		 * @return 
		 **/
		public function removeEmptyTags($htmlstring, $disallowed_empty_tag = array())
			{
				foreach($disallowed_empty_tag as $tag)
					$htmlstring = preg_replace("/<\/?" . $tag . "(.|\s)*?>/","",$htmlstring);
				return $htmlstring;
			}
		
		/**
		 * StripTags::removeTags()
		 * 
		 * @param $htmlstring
		 * @param array $disallowed_tag
		 * @return 
		 **/
		public function removeTags($htmlstring, $disallowed_tag = array())
			{
				foreach($disallowed_tag as $tag)
					{
						$format = '\'<'.$tag.'[^>]*>.*</'.$tag.'>\'siU';												
						$htmlstring = preg_replace($format,'',$htmlstring);
					}				
				return $htmlstring;
			}
		
		/**
		 * StripTags::removeAttributes()
		 * 
		 * @param $htmlstring
		 * @param array $disallowed_attributes
		 * @return 
		 **/
		public function removeAttributes($htmlstring, $disallowed_attributes = array())
			{				
				foreach($disallowed_attributes as $attribute)
					{
					     $htmlstring = str_replace($attribute, 'dummy', $htmlstring);
						 //$htmlstring = preg_replace("' ($attribute)=\"(.*?)\"'i", '', $htmlstring);
					}				
				return $htmlstring;
			}
	} 
?>