<?php
/**
 * Tag
 *
 * @package
 * @author Selvaraj
 * @copyright 	Copyright (c) 2009 - 2010 {@link http://www.mediabox.uz Uzdc Infoway}
 * @version $Id: $
 * @access public
 **/
class Tag extends MusicHandler
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
					$sql = 'SELECT tag_name, search_count FROM '.$this->CFG['db']['tbl']['music_playlist_tags'].
						   ' WHERE search_count>0 ORDER BY search_count DESC, result_count DESC, tag_name ASC'.
						   ' LIMIT '.$this->CFG['admin']['tags_count']['all_page'];
				}
				else
				{
					$sql = 'SELECT tag_name, result_count AS search_count FROM'.
							' '.$this->CFG['db']['tbl']['music_playlist_tags'].
						   ' WHERE result_count>0 ORDER BY result_count DESC, tag_name ASC'.
						   ' LIMIT '.$this->CFG['admin']['tags_count']['all_page'];
				}
				$searchUrl = getUrl('musicplaylist', '?pg=playlistnew&tags=%s','playlistnew/?tags=%s','','music');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				    if (!$rs)
					    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
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
$Tag->setDBObject($db);
$Tag->makeGlobalize($CFG,$LANG);

$Tag->setPageBlockNames(array('allTagBlock'));
$Tag->setCSSFormFieldErrorTipClass('clsFormFieldErrTip');
$Tag->setCSSFormLabelCellDefaultClass('clsFormLabelCellDefault');
$Tag->setCSSFormFieldCellDefaultClass('clsFormFieldCellDefault');
$Tag->setCSSFormLabelCellErrorClass('clsFormLabelCellError');
$Tag->setCSSFormFieldCellErrorClass('clsFormFieldCellError');

$Tag->setAllPageBlocksHide();
$Tag->sanitizeFormInputs($_REQUEST);

if(!chkAllowedModule(array('music')))
	Redirect2URL($CFG['redirect']['dsabled_module_url']);
$Tag->tag_arr=array();

	$Tag->tag_arr=$Tag->populateTags();

//include the header file
$Tag->includeHeader();
//include the content of the page
setTemplateFolder('general/','music');
$smartyObj->display('tagsPlaylist.tpl');
//includ the footer of the page
//<<<<<<--------------------Page block templates Ends--------------------//
$Tag->includeFooter();

