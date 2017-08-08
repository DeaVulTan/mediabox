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
class Tag extends PhotoHandler
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

	public function populateMySubTags()
	{
		$sql = 'SELECT tag_name FROM '.$this->CFG['db']['tbl']['subscription'].
			    ' WHERE status=\'Yes\' AND module = \'photo\''.
				' AND subscriber_id='.$this->CFG['user']['user_id'].
				' ORDER BY tag_name ASC';
		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt);
	    if (!$rs)
		    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
		if ($rs->PO_RecordCount()>0)
	    {
	    	$mySubTagArray = array();
	    	while($row = $rs->FetchRow())
	        {
	        	if($row['tag_name']<>'')
					$mySubTagArray[] = $row['tag_name'];
			}
			return $mySubTagArray;
	    }
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

			if(isMember() and chkIsSubscriptionEnabled() and chkIsSubscriptionEnabledForModule() and $this->fields_arr['action'] == 'mysubscriptions')
			{
				$sql = 'SELECT tp.tag_name, search_count FROM '.$this->CFG['db']['tbl']['photo_tags'].' as tp '.
						'JOIN '.$this->CFG['db']['tbl']['subscription'].' as s ON tp.tag_name = s.tag_name '.
					    ' WHERE search_count>0 AND s.status=\'Yes\' AND s.module = \'photo\''.
						' AND s.subscriber_id='.$this->CFG['user']['user_id'].
						' ORDER BY search_count DESC, result_count DESC, tp.tag_name ASC'.
					    ' LIMIT '.$this->CFG['admin']['tags_count']['all_page'];
			}
			else
			{
				$sql = 'SELECT tag_name, search_count FROM '.$this->CFG['db']['tbl']['photo_tags'].
					   ' WHERE search_count>0 ORDER BY search_count DESC, result_count DESC, tag_name ASC'.
				   	   ' LIMIT '.$this->CFG['admin']['tags_count']['all_page'];
			}
		}
		else
		{
			if(isMember() and chkIsSubscriptionEnabled() and chkIsSubscriptionEnabledForModule() and $this->fields_arr['action'] == 'mysubscriptions')
			{
				$sql = 'SELECT tp.tag_name, result_count AS search_count FROM'.
						' '.$this->CFG['db']['tbl']['photo_tags'].' as tp '.
						'JOIN '.$this->CFG['db']['tbl']['subscription'].' as s ON tp.tag_name = s.tag_name '.
					    ' WHERE result_count>0 AND s.status=\'Yes\' AND s.module = \'photo\' '.
						' AND s.subscriber_id='.$this->CFG['user']['user_id'].
						' ORDER BY result_count DESC, tp.tag_name ASC'.
					    ' LIMIT '.$this->CFG['admin']['tags_count']['all_page'];
			}
			else
			{
				$sql = 'SELECT tag_name, result_count AS search_count FROM'.
						' '.$this->CFG['db']['tbl']['photo_tags'].
				   		' WHERE result_count>0 ORDER BY result_count DESC, tag_name ASC'.
				   		' LIMIT '.$this->CFG['admin']['tags_count']['all_page'];
			}
		}
		$searchUrl = getUrl('photolist', '?pg=photonew&tags=%s', 'photonew/?tags=%s', '', 'photo');

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt);
	    if (!$rs)
		    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
		if ($rs->PO_RecordCount()>0)
	    {
	    	if(isMember() and chkIsSubscriptionEnabled() and chkIsSubscriptionEnabledForModule())
			{
				$mySubTagArr = array();
	    		$mySubTagArr=$this->populateMySubTags();
	    	}
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
				if(isMember() and chkIsSubscriptionEnabled() and chkIsSubscriptionEnabledForModule())
				{
					$return['item'][$inc]['subscription']=false;
					if(!empty($mySubTagArr))
					{
						if(in_array($tag,$mySubTagArr))
						{
							$return['item'][$inc]['subscription']=true;
						}
					}
				}
				$return['item'][$inc]['add_slash_name']=addslashes($tag);
				$return['item'][$inc]['change_title_name']=$this->changeTitle($tag);
				$return['item'][$inc]['inc']=$inc;
				$inc++;
			}
	    }
		return $return;
	}
}
//<<<<<-------------- Class Tag begins ---------------//
//-------------------- Code begins -------------->>>>>//
$tag = new Tag();
$tag->setDBObject($db);
$tag->makeGlobalize($CFG,$LANG);
$tag->setPageBlockNames(array('allTagBlock'));
$tag->setCSSFormFieldErrorTipClass('clsFormFieldErrTip');
$tag->setCSSFormLabelCellDefaultClass('clsFormLabelCellDefault');
$tag->setCSSFormFieldCellDefaultClass('clsFormFieldCellDefault');
$tag->setCSSFormLabelCellErrorClass('clsFormLabelCellError');
$tag->setCSSFormFieldCellErrorClass('clsFormFieldCellError');
$tag->setFormField('pg', '');
$tag->setFormField('action', '');
$tag->setAllPageBlocksHide();
$tag->sanitizeFormInputs($_REQUEST);
if(!chkAllowedModule(array('photo')))
	Redirect2URL($CFG['redirect']['dsabled_module_url']);
$tag->my_subscription_url =getUrl('mysubscription', '?pg=tag_subscription&tag_module='.$CFG['site']['is_module_page'], 'tag_subscription/?tag_module='.$CFG['site']['is_module_page'], 'members');
if($tag->getFormField('action') == 'mysubscriptions')
	$tag->LANG['page_photo_title'] = $LANG['phototag_my_subscribed_tags'];
$tag->tag_arr=array();
$tag->tag_arr=$tag->populateTags();
//include the header file
$tag->includeHeader();
//include the content of the page
setTemplateFolder('general/',$CFG['site']['is_module_page']);
$smartyObj->display('tags.tpl');
//includ the footer of the page
//<<<<<<--------------------Page block templates Ends--------------------//
$tag->includeFooter();

