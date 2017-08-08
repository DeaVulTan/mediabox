<?php
/**
 * Tag
 *
 * @package
 * @author naveenkumar_126at09
 * @copyright 	Copyright (c) 2009 - 2010 {@link http://www.mediabox.uz Uzdc Infoway}
 * @version $Id: $
 * @access public
 **/
class Tag extends ArticleHandler
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
			$sql = 'SELECT tag_name, search_count FROM '.$this->CFG['db']['tbl']['article_tags'].
				   ' WHERE search_count>0 ORDER BY search_count DESC, result_count DESC, tag_name ASC'.
				   ' LIMIT '.$this->CFG['admin']['tags_count']['all_page'];
		}
		else
		{
			$sql = 'SELECT tag_name, result_count AS search_count FROM'.
					' '.$this->CFG['db']['tbl']['article_tags'].
				   ' WHERE result_count>0 ORDER BY result_count DESC, tag_name ASC'.
				   ' LIMIT '.$this->CFG['admin']['tags_count']['all_page'];
		}
		$searchUrl = getUrl('articlelist', '?pg=articlenew&tags=%s', 'articlenew/?tags=%s', '', 'article');

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
$tag->setAllPageBlocksHide();
$tag->sanitizeFormInputs($_REQUEST);
if(!chkAllowedModule(array('article')))
	Redirect2URL($CFG['redirect']['dsabled_module_url']);
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

