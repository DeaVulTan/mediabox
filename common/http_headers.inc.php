<?php
/**
 * File to handle the http header information
 *
 * ###Add file long description###
 *
 * PHP version 5.0
 *
 * @category	Framework
 * @package		Common
 * @author 		rajesh_04ag02
 * @copyright 	Copyright (c) 2008 {@link http://www.mediabox.uz Uzdc Infoway}
 * @license		http://www.mediabox.uz Uzdc Infoway Licence
 * @version		SVN: $Id: http_headers.inc.php 170 2008-04-02 09:49:23Z vidhya_29ag04 $
 * @since 		2005-03-17
 * @todo		Need to add long description for this file.
 */
// Not really essential unless the ini settings are messed up
// Probably should put it in the diagnose script??
//if (ini_get('default_mimetype') != 'text/html')
//		header('Content-Type: '.$CFG['http_headers']['content_type']);
$http_version = isset($_SERVER['SERVER_PROTOCOL']) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.1';
if ($CFG['http_headers']['is_xhtml'])
	{
		//Only Mozilla treat xhtml as different, so check and send proper header
		if (stripos($_SERVER['HTTP_ACCEPT'], 'application/xhtml+xml')!==false)
				header('Content-type: application/xhtml+xml');
//			else
//				header('Content-type: text/html');
	}


//If-Modified-Since
if ($CFG['http_headers']['is_use_if_modified_since'])
	{
	    if ((is_string($CFG['http_headers']['unmodified_pages']) && $CFG['http_headers']['unmodified_pages']=='*')
			|| (is_array($CFG['http_headers']['unmodified_pages']) && in_array($_SERVER['PHP_SELF'], $CFG['http_headers']['unmodified_pages'])))
			{
				$mtime = filemtime($_SERVER['SCRIPT_FILENAME'])-date('Z');
				$gmt_mtime = date('D, d M Y H:i:s', $mtime) . ' GMT';
				//cgi version doesn't have getallheaders() function
				$http_headers = (strpos(php_sapi_name(), 'cgi')!==false) ? array() : getallheaders();  //PHP_SAPI -> cgi-fcgi
				if (isset($http_headers['If-Modified-Since'])
				   && $http_headers['If-Modified-Since'] == $gmt_mtime)
				   {
				       header($http_version.' 304 Not Modified');
				       exit(0);
				   }
				  else
				  		header('Last-Modified: '.$gmt_mtime);
			}
	}
if (isset($_SERVER['HTTP_USER_AGENT'])
		&& strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE')!==false)
	{
		header('Cache-control: private'); // IE 6 Fix.
	}

if ($CFG['http_headers']['is_cache'])
	{

	}
  else //no cache
  	{
		header('Cache-Control: no-store, no-cache, must-revalidate');
		header('Cache-Control: post-check=0, pre-check=0', false);
	}

if ($CFG['http_headers']['is_download_header'])
	{
		header('Content-Type: '.$CFG['http_headers']['content_type']);
		if (isset($_SERVER['HTTP_USER_AGENT'])
				&& strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE')!==false)
			{
				header('Content-Disposition: inline; filename="'.$CFG['http_headers']['download_file_name'].'"');
				header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
				header('Pragma: public');
			}
		  else
		  	{
				header('Content-Disposition: attachment; filename="'.$CFG['http_headers']['download_file_name'].'"');
				header('Pragma: no-cache');
			}
	}

//P3P headers
if ($CFG['http_headers']['p3p_policies']['is_use_p3p'])
	{
		$p3p_header = '';
		if ($CFG['http_headers']['p3p_policies']['policy_location'] != '')
			$p3p_header .= ' policyref="'.$CFG['http_headers']['p3p_policies']['policy_location'].'"';
		if ($CFG['http_headers']['p3p_policies']['compact_policy'] != '')
			$p3p_header .= ' CP="'.$CFG['http_headers']['p3p_policies']['compact_policy'].'"';
		if ($p3p_header != '')
			header ('P3P: '.$p3p_header);
	}
//Block link prefetch
//http://www.mozilla.org/projects/netlib/Link_Prefetching_FAQ.html
if ($CFG['http_headers']['is_block_link_prefetch'])
	{
		if ((isset($_SERVER['HTTP_X_MOZ'])) && ($_SERVER['HTTP_X_MOZ'] == 'prefetch'))
			{
			    //Block prefetch request...
			    //header($http_version.' 403 Forbidden');
			    //echo 'Prefetching not allowed.';
				//Google suggests 404 instead of 403
				//@link http://www.google.com/webmasters/faq.html#prefetchblock
				header($http_version.' 404 Prefetch Forbidden');
			    exit(0);
			}
	}
?>
