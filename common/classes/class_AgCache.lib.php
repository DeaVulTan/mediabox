<?php
/**
 * Class to handle the caching functionality
 *
 * This is having class AgCache to handle the caching functionality
 * Most recent version available from http://acme-web-design.info/php-cache-kit.html
 *
 * PHP version 5.0
 *
 * @category	###Framework###
 * @package		###Common/Classes###
 * @author		selvaraj_47ag04
 * @copyright 	Copyright (c) 2008 {@link http://www.mediabox.uz Uzdc Infoway}
 * @license		http://www.mediabox.uz Uzdc Infoway Licence
 * @version		SVN: $Id : $
 * @since 		2005-22-05
 */
class AgCache
	{
	 	public function fetch($name, $refreshSeconds = 0)
			{
	  			global $CFG;
				$cacheContent = '';
	  			if(!$CFG['feature']['data_cache']['active_status'])
					return false;

				if(!$refreshSeconds)
					$refreshSeconds = 60;

				$cacheFile = AgCache::cachePath($name);
				if(file_exists($cacheFile) and ((time()-filemtime($cacheFile))< $refreshSeconds))
					{
	   					$cacheContent = file_get_contents($cacheFile);
	   				}
	  			return $cacheContent;
	 		}

		public  function save($name, $cacheContent)
			{
	  			global $CFG;
				if(!$CFG['feature']['data_cache']['active_status'])
					return;

				$cacheFile = AgCache::cachePath($name);
				AgCache::savetofile($cacheFile, $cacheContent);
			}

		 // for internal use
		 // ====================
		public function cachePath($name)
			{
			  global $CFG;
			  $cacheFolder = $CFG['site']['project_path'].$CFG['feature']['data_cache']['folder'];
			  if(!$cacheFolder) $cacheFolder = trim($_SERVER['DOCUMENT_ROOT'],'/').'/cache/';
			  return $cacheFolder . md5(strtolower(trim($name))) . '.cache';
		 	}

		public function savetofile($filename, $data)
			{
				$dir = trim(dirname($filename),'/').'/';
				AgCache::forceDirectory($dir);
				$file = fopen($filename, 'w');
				fwrite($file, $data);
				fclose($file);
			}

		public function forceDirectory($dir)
			{
				// force directory structure
	 			return is_dir($dir) or (AgCache::forceDirectory(dirname($dir)) and @mkdir($dir, 0777));
			}
	}
?>