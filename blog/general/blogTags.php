<?php
/**
 * Tag
 *
 * @package
 * @author edwin_048at09
 * @copyright 	Copyright (c) 2009 - 2010 {@link http://www.mediabox.uz Uzdc Infoway}
 * @version $Id: $
 * @access public
 **/
class BlogTag extends BlogHandler
{
	/**
	 * BlogTag::chkValidBlog()
	 *
	 * @return
	 */
	public function chkValidBlog()
	{
		    $sql = 'SELECT blog_id,blog_name,blog_title, blog_slogan, user_id,blog_logo_ext FROM '.$this->CFG['db']['tbl']['blogs'].
				' WHERE blog_name='.$this->dbObj->Param('blog_name').
				' AND blog_status=\'Active\'';

			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['blog_name']));
			if (!$rs)
				trigger_db_error($this->dbObj);
			$blog_logo_folder = $this->CFG['media']['folder'].'/'.$this->CFG['admin']['blog']['folder'].'/'.$this->CFG['admin']['blog']['blog_logo_folder'].'/';
			$fields_list = array('user_name', 'first_name', 'last_name');
			if($row = $rs->FetchRow())
			    {
			    if(!isset($this->UserDetails[$row['user_id']]))
					$this->getUserDetail('user_id',$row['user_id'], 'user_name');

			     $this->fields_arr['blog_id']=$row['blog_id'];
			     $this->fields_arr['user_id']=$row['user_id'];
			     $this->fields_arr['blog_title']=$row['blog_title'];
			     $this->fields_arr['blog_slogan']=$row['blog_slogan'];
			     $this->fields_arr['blog_url']=getUrl('viewblog','?blog_name='.$row['blog_name'],$row['blog_name'].'/','root','blog');
			     $this->fields_arr['blog_rss_url']=getUrl('rssblog','?blog_name='.$row['blog_name'],$row['blog_name'].'/','root','blog');
			     $this->fields_arr['blog_logo_src']=$this->CFG['site']['blog_url'].'design/templates/'.$this->CFG['html']['template']['default'].
				 									'/root/images/'.$this->CFG['html']['stylesheet']['screen']['default'].'/default-logo.jpg';
			     if($row['blog_logo_ext'])
			     $this->fields_arr['blog_logo_src'] = $this->CFG['site']['url'].$blog_logo_folder.$row['user_id'].'.'.$row['blog_logo_ext'];
			   	 $this->validBlogId = true;
			  	 return true;
			  	}
			return false;
	}
	public function setFontSizeInsteadOfSearchCount($blogtag_array=array())
	{
		$formattedArray = $blogtag_array;
		$max_qty = max(array_values($formattedArray));
		$min_qty = min(array_values($formattedArray));
		$max_font_size = 28;
		$min_font_size = 12;
		$spread = $max_qty - $min_qty;
		if (0 == $spread) { // Divide by zero
			$spread = 1;
		}
		$step = ($max_font_size - $min_font_size)/($spread);
			foreach ($blogtag_array as $catname => $count)
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
			$sql = 'SELECT tag_name, search_count FROM '.$this->CFG['db']['tbl']['blog_tags'].
				   ' WHERE search_count>0  AND blog_id='.$this->fields_arr['blog_id'].' ORDER BY search_count DESC, result_count DESC, tag_name ASC'.
				   ' LIMIT '.$this->CFG['admin']['tags_count']['all_page'];
		}
		else
		{
		   $sql = 'SELECT tag_name, result_count AS search_count FROM'.
					' '.$this->CFG['db']['tbl']['blog_tags'].
				   ' WHERE result_count>0  AND blog_id='.$this->fields_arr['blog_id'].' ORDER BY result_count DESC, tag_name ASC'.
				   ' LIMIT '.$this->CFG['admin']['tags_count']['all_page'];
		}
		$searchUrl =getUrl('viewblog', '?blog_name='.$this->fields_arr['blog_name'].'&tags=%s', $this->fields_arr['blog_name'].'/?tags=%s', '', 'blog');

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt);
	    if (!$rs)
		   trigger_db_error($this->dbObj);
		if ($rs->PO_RecordCount()>0)
	    {
	    	$return['resultFound']=true;
			$classes = array('clsTagStyleOrange', 'clsTagStyleGrey');
			$blogtagClassArray = array();
	        while($row = $rs->FetchRow())
	        {
					$blogtagArray[$row['tag_name']] = $row['search_count'];
					$class = $classes[rand(0, count($classes))%count($classes)];
					$blogtagClassArray[$row['tag_name']] = $class;
			}
			$blogtagArray = $this->setFontSizeInsteadOfSearchCount($blogtagArray);
			ksort($blogtagArray);
			$inc=0;
			foreach($blogtagArray as $blogtag=>$fontSize)
			{
				$url 	= sprintf($searchUrl, $blogtag);
				$class 	= $blogtagClassArray[$blogtag];
				$fontSizeClass= 'style="font-size:'.$fontSize.'px"';
				$return['item'][$inc]['url']=$url;
				$return['item'][$inc]['class']=$class;
				$return['item'][$inc]['fontSizeClass']=$fontSizeClass;
				$return['item'][$inc]['name']=$blogtag;
				$inc++;
			}
	    }
		return $return;
	}
}
//<<<<<-------------- Class Tag begins ---------------//
//-------------------- Code begins -------------->>>>>//
$blogtag = new BlogTag();
$blogtag->setDBObject($db);
$blogtag->makeGlobalize($CFG,$LANG);
$blogtag->setPageBlockNames(array('allTagBlock'));
$blogtag->setCSSFormFieldErrorTipClass('clsFormFieldErrTip');
$blogtag->setCSSFormLabelCellDefaultClass('clsFormLabelCellDefault');
$blogtag->setCSSFormFieldCellDefaultClass('clsFormFieldCellDefault');
$blogtag->setCSSFormLabelCellErrorClass('clsFormLabelCellError');
$blogtag->setCSSFormFieldCellErrorClass('clsFormFieldCellError');
$blogtag->setFormField('blog_id', '');
$blogtag->setFormField('blog_name', '');
$blogtag->setFormField('user_id', '');
$blogtag->setFormField('blog_url', '');
$blogtag->setFormField('blog_rss_url', '');
$blogtag->setFormField('blog_title', '');
$blogtag->setFormField('blog_slogan', '');
$blogtag->setFormField('blog_logo_src', '');
$blogtag->setFormField('y', '');
$blogtag->setFormField('m', '');
$blogtag->setAllPageBlocksHide();
$blogtag->sanitizeFormInputs($_REQUEST);
$blogtag->LANG['blogtags_page_title'] = str_replace('{blog_name}', $blogtag->getFormField('blog_name'), $LANG['blogtags_page_title']);
if(!chkAllowedModule(array('blog')))
	Redirect2URL($CFG['redirect']['dsabled_module_url']);

if(!$blogtag->chkValidBlog())
  Redirect2URL(getUrl('bloglist','?msg=1','?msg=1','','blog'));

$blogtag->checkBlogAdded = $blogtag->chkThisUserAllowedToPost();
$blogtag->getPreviousBlogLink($blogtag->getFormField('blog_id'));
$blogtag->getNextBlogLink($blogtag->getFormField('blog_id'));
$blogtag->tag_arr=array();
$blogtag->tag_arr=$blogtag->populateTags();
//include the header file
$blogtag->includeHeader();
//include the content of the page
setTemplateFolder('general/',$CFG['site']['is_module_page']);
$smartyObj->display('blogTags.tpl');
//includ the footer of the page
//<<<<<<--------------------Page block templates Ends--------------------//
$blogtag->includeFooter();

