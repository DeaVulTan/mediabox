<?php
/**
 * settings for $CFG['db']['hostname']
 *
 * ..
 *
 * PHP version 5.0
 *
 * @category	..
 * @package		..
 * @author 		selvaraj_47ag04
 * @copyright 	Copyright (c) 2008 {@link http://www.mediabox.uz Uzdc Infoway}
 * @license		http://www.mediabox.uz Uzdc Infoway Licence
 * @version		SVN: $Id: config_debugmode.inc.php 478 2008-04-28 06:58:17Z guruprasad_20ag08 $
 * @since 		2008-04-02
 * @filesource
 **/

if (!defined('E_STRICT')) //available only in PHP5
	define('E_STRICT', 2048); 	//Run-time notices. Enable to have PHP suggest changes to your code which will ensure the best interoperability and forward compatibility of your code.
$CFG['debug']['error_level'] = (E_ALL|E_STRICT);

$CFG['debug']['debug_css_url'] = $CFG['site']['url'].'design/css/debug.css';
$CFG['smarty']['error_reporting'] = E_ALL;
?>