<?php
/**
 * Tag
 *
 * @package
 * @author Selvaraj
 * @copyright Copyright (c) 2008 {@link http://www.mediabox.uz Uzdc Infoway}
 * @version $Id: $
 * @access public
 **/
class Tag extends VideoHandler
	{
		public function setFontSizeInsteadOfSearchCount($tag_array=array())
			{
				$formattedArray = $tag_array;
				$max_qty = max(array_values($formattedArray));
				$min_qty = min(array_values($formattedArray));
				$max_font_size = 28;
				$min_font_size = 12;
				$spread = $max_qty - $min_qty;
				if (0 == $spread) { // Divide by zero
					$spread = 1;
				}
				$step = ($max_font_size - $min_font_size)/($spread);
					foreach ($tag_array as $catname => $count)
					{
						$size = $min_font_size + ($count - $min_qty) * $step;
						$formattedArray[$catname] = ceil($size);
					}
				return $formattedArray;
			}

		/**
		 * Tag::populateTags()
		 *
		 * @return
		 **/
		public function populateTags()
			{
				$return = array();
				$return['resultFound']=false;
				if($this->CFG['admin']['tagcloud_based_search_count'])
				{
					if(isMember() and chkIsSubscriptionEnabled()
						and chkIsSubscriptionEnabledForModule()
							and $this->fields_arr['action'] == 'mysubscriptions')
						{
							$sql = 'SELECT tv.tag_name, search_count FROM '.$this->CFG['db']['tbl']['tags_video'].' as tv '.
									'JOIN '.$this->CFG['db']['tbl']['subscription'].' as s ON tv.tag_name = s.tag_name '.
								    ' WHERE search_count>0 AND s.status=\'Yes\' AND s.module = \'video\''.
									' AND s.subscriber_id='.$this->CFG['user']['user_id'].
									' ORDER BY search_count DESC, result_count DESC, tv.tag_name ASC'.
								    ' LIMIT '.$this->CFG['admin']['tags_count']['all_page'];
						}
					else
						{
							$sql = 'SELECT tag_name, search_count FROM '.$this->CFG['db']['tbl']['tags_video'].
								   ' WHERE search_count>0 ORDER BY search_count DESC, result_count DESC, tag_name ASC'.
								   ' LIMIT '.$this->CFG['admin']['tags_count']['all_page'];
						}
				}
				else
				{
					if(isMember() and chkIsSubscriptionEnabled()
						and chkIsSubscriptionEnabledForModule()
							and $this->fields_arr['action'] == 'mysubscriptions')
						{
							$sql = 'SELECT tv.tag_name, result_count AS search_count FROM'.
									' '.$this->CFG['db']['tbl']['tags_video'].' as tv '.
									'JOIN '.$this->CFG['db']['tbl']['subscription'].' as s ON tv.tag_name = s.tag_name '.
								    ' WHERE result_count>0 AND s.status=\'Yes\' AND s.module = \'video\' '.
									' AND s.subscriber_id='.$this->CFG['user']['user_id'].
									' ORDER BY result_count DESC, tv.tag_name ASC'.
								    ' LIMIT '.$this->CFG['admin']['tags_count']['all_page'];
						}
					else
						{
							$sql = 'SELECT tag_name, result_count AS search_count FROM'.
									' '.$this->CFG['db']['tbl']['tags_video'].
								   ' WHERE result_count>0 ORDER BY result_count DESC, tag_name ASC'.
								   ' LIMIT '.$this->CFG['admin']['tags_count']['all_page'];
						}

				}
				$searchUrl = getUrl('videolist', '?pg=videonew&tags=%s','videonew/?tags=%s','','video');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
		    	if (!$rs)
			    trigger_db_error($this->dbObj);
				if ($rs->PO_RecordCount()>0)
				    {
				    	$return['resultFound']=true;
						$classes = array('clsTagStyleOrange', 'clsTagStyleGrey');
						$tagClassArray = array();
				        while($row = $rs->FetchRow())
				        {
								$tagArray[$row['tag_name']] = $row['search_count'];
								$class = $classes[rand(0, count($classes))%count($classes)];
								$tagClassArray[$row['tag_name']] = $class;
						}
						$tagArray = $this->setFontSizeInsteadOfSearchCount($tagArray);
						ksort($tagArray);
						$inc=0;
						foreach($tagArray as $tag=>$fontSize)
						{
							$url 	= sprintf($searchUrl, $tag);
							$class 	= $tagClassArray[$tag];
							$fontSizeClass= 'style="font-size:'.$fontSize.'px"';
							$return['item'][$inc]['url']=$url;
							$return['item'][$inc]['class']=$class;
							$return['item'][$inc]['fontSizeClass']=$fontSizeClass;
							$return['item'][$inc]['name']=$tag;
							$inc++;
						}
				    }
				return $return;
			}
	}
//<<<<<-------------- Class Tag begins ---------------//
//-------------------- Code begins -------------->>>>>//
$Tag = new Tag();

if(!chkAllowedModule(array('video')))
	Redirect2URL($CFG['redirect']['dsabled_module_url']);

$Tag->setPageBlockNames(array('allTagBlock'));
$Tag->setFormField('action', '');
$Tag->my_subscription_url = getUrl('tags', '?pg=videos&action=mysubscriptions', 'videos/mysubscriptions/', '', 'video');

$Tag->setAllPageBlocksHide();
$Tag->sanitizeFormInputs($_REQUEST);

if($Tag->getFormField('action') == 'mysubscriptions')
	$Tag->LANG['page_video_title'] = $LANG['videotag_my_subscribed_tags'];

$Tag->tag_arr=array();
$Tag->tag_arr=$Tag->populateTags();

//include the header file
$Tag->includeHeader();
//include the content of the page
setTemplateFolder('general/','video');
$smartyObj->display('tags.tpl');
//includ the footer of the page
//<<<<<<--------------------Page block templates Ends--------------------//
$Tag->includeFooter();
