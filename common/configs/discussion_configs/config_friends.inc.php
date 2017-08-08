<?php
/**
 * friends config settings
 * ..
 *
 * PHP version 5.0
 *
 * @category	..
 * @package		..
 * @author 		karthiselvam_75ag08
 * @copyright	Copyright (c) 2009 - 2010 {@link http://www.mediabox.uz Uzdc Infoway}
 * @license		http://www.mediabox.uz Uzdc Infoway Licence
 * @version		SVN: $Id: $
 * @since 		2008-12-19
 * @filesource
 **/
/**
 * @var				boolean Friends allowed
 * @cfg_sub_head 	Users Friends settings
 * @cfg_label 		Is Friends allowed
 * @cfg_key 		admin_friends_allowed
 * @cfg_sec_name
 * @cfg_section 	users_setting
 */
$CFG['admin']['friends']['allowed'] = true;
/**
 * @var				boolean Is friend request allowed
 * @cfg_label 		Is friend request allowed
 * @cfg_key 		admin_friends_request_allowed
 */
$CFG['admin']['friends_request']['allowed'] = true;
?>