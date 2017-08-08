<?php
/**
*
*
* @	Author			: By Haking Br
* @	Author			: Por Haking Br
* @ Brasil
* @	Release on		:	03.10.2011
*
*/

require_once( "config_license.inc.php" );
require_once( "config_app_license.inc.php" );
require_once( "error_description_list_arr.inc.php" );
require_once( "class_ionoLicenseHandler.php" );
$license_obj = new IonoLicenseHandler( );
$license_obj->setErrorTexts( $error_text );
$license_obj->setCFGAppLicenseValues( $CFG );
$err_msg = $license_obj->ionLicenseHandler( $CFG['app']['license_key'], 1 );
if ( $err_msg != "" )
{
    exit( $err_msg );
}
?>
