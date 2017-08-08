<?php
/**
 * This file is to upgradeMembership
 *
 * This file is having upgradeMembership class to submit the form to Paypal for Subcription
 *
 * PHP version 5.0
 *
 * @category
 * @package		Member
 * @author 		vijay_84ag08
 * @copyright 	Copyright (c) 2008 {@link http://www.mediabox.uz Uzdc Infoway}
 * @license		http://www.mediabox.uz Uzdc Infoway Licence
 * @version		SVN: $Id: beFriends.php 656 2007-11-14 05:33:07Z selvaraj_35ag05 $
 * @since 		2009-04-10
 */
require_once('common/configs/config.inc.php');
$CFG['lang']['include_files'][] = 'languages/%s/members/upgradeMembership.php';
$CFG['lang']['include_files'][] = 'languages/%s/common/email_notify.inc.php';
$CFG['html']['header'] = 'general/html_header.php';
$CFG['html']['footer'] = 'general/html_footer.php';

if(isset($_REQUEST['status']) && $_REQUEST['status']=='notify')
	$CFG['auth']['is_authenticate'] = 'root';
else
	$CFG['auth']['is_authenticate'] = 'members';

$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
$CFG['mods']['include_files'][] = 'common/classes/class_PayPalIPN.lib.php';

require_once($CFG['site']['project_path'].'common/application_top.inc.php');
require_once('general/upgradeMembership.php');
?>