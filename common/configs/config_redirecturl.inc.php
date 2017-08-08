<?php
/**
 * settings for $CFG
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
 * @version		SVN: $Id: config_redirecturl.inc.php 534 2008-04-29 07:42:15Z guruprasad_20ag08 $
 * @since 		2008-04-02
 * @filesource
 **/
/**
 * @var				string show login url name
 * @cfg_label 		Login url filename
 * @cfg_key 		is_login_url_name
 * @cfg_sec_name	login Details
 * @cfg_section 	redirecturl_settings
 */
$CFG['auth']['login_url']['file_name'] = 'login';
/**
 * @var				string show login normal
 * @cfg_label 		Login url normal
 * @cfg_key 		is_login_url_normal
 */
$CFG['auth']['login_url']['normal'] = '';
/**
 * @var				string show login htaccess
 * @cfg_label 		Login url htaccess
 * @cfg_key 		is_login_url_htaccess
 */
$CFG['auth']['login_url']['htaccess'] = '';
/**
 * @var				string show members url name
 * @cfg_label 		Members url filename
 * @cfg_key 		is_members_url_normal
 */
$CFG['auth']['members_url']['file_name'] = 'myhome';
/**
 * @var				string show members normal
 * @cfg_label 		Members url normal
 * @cfg_key 		is_login_url_members
 */
$CFG['auth']['members_url']['normal'] = '';
/**
 * @var				string show members htaccess
 * @cfg_label 		Members url htaccess
 * @cfg_key 		is_login_url_htaccess
 */
$CFG['auth']['members_url']['htaccess'] = '';
/**
 * @var				string show first visit url name
 * @cfg_label 		First visit url filename
 * @cfg_key 		is_first_visit_url
 */
$CFG['auth']['first_visit_url']['file_name'] = 'index';
/**
 * @var				string show first visit normal
 * @cfg_label 		First visit url normal
 * @cfg_key 		is_first_visit_normal
 */
$CFG['auth']['first_visit_url']['normal'] = '';
/**
 * @var				string show first visit htaccess
 * @cfg_label 		First visit url htaccess
 * @cfg_key 		is_first_visit_htaccess
 */
$CFG['auth']['first_visit_url']['htaccess'] = '';
/**
 * @var				string show dsabled module url name
 * @cfg_label 		Disabled module url filename
 * @cfg_key 		is_dsabled_module_url
 */
$CFG['redirect']['dsabled_module_url']['file_name'] = 'index';
/**
 * @var				string show dsabled module url normal
 * @cfg_label 		Disabled module url normal
 * @cfg_key 		is_dsabled_module_url_normal
 */
$CFG['redirect']['dsabled_module_url']['normal'] = '';
/**
 * @var				string show dsabled module url htaccess
 * @cfg_label 		Disabled module url htaccess
 * @cfg_key 		is_dsabled_module_url_htaccess
 */
$CFG['redirect']['dsabled_module_url']['htaccess'] = '';
/**
 * @var				string show maintenance module url name
 * @cfg_label 		Maintenance module url filename
 * @cfg_key 		is_maintenance_module_url
 */
$CFG['redirect']['maintenance_module_url']['file_name'] = 'maintenance';
/**
 * @var				string show maintenance module url normal
 * @cfg_label 		Maintenance module url normal
 * @cfg_key 		is_maintenance_module_url_normal
 */
$CFG['redirect']['maintenance_module_url']['normal'] = '';
/**
 * @var				string show maintenance module url htaccess
 * @cfg_label 		Maintenance module url htaccess
 * @cfg_key 		is_maintenance_module_url_htaccess
 */
$CFG['redirect']['maintenance_module_url']['htaccess'] = '';
?>