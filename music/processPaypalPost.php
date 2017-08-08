<?php
/**
 * Process Paypal post file
 *
 * Process Paypal post file
 *
 * PHP version 5.0
 *
 * @category	payment
 * @package
 * @author 		manonmani_51ag05
 * @copyright	Copyright (c) 2005 {@link http://www.mediabox.uz Uzdc Infoway}
 * @license		http://www.mediabox.uz Uzdc Infoway Licence
 * @version		SVN: $Id: processPaypalPost.php 486 2005-10-06 08:11:26Z manonmani_51ag05 $
 * @since 		2005-08-31
 * @filesource
 **/
/**
 * configurations
*/
require_once('../common/configs/config.inc.php');
$CFG['site']['project_path']='../';
/**
 * includes class_PayPalIPN file
*/
$CFG['mods']['include_files'][] = 'common/classes/class_MusicPayPalIPN.lib.php';
/**
 * includes currency_convert file
*/
$CFG['html']['is_use_header'] = false;
/**
 * includes various types of files
*/
$CFG['auth']['is_authenticate'] = false;
require_once($CFG['site']['project_path'].'common/application_top.inc.php');
//--------------------------------------------------------//
//call the userPayment method in api_payment .php with digicurrencysystem, post vars, db object

//ProcessUserPayment('paypal', $_POST, $db);
$paypal_ipn = new PayPalIPN();
$paypal_ipn->setPayPalVars($_POST);
$paypal_ipn->sanitizePayPalVars();
$paypal_ipn->setDBObject($db);
$paypal_ipn->makeGlobalize($CFG, $LANG);
$paypal_ipn->setPayPalLogTableName($CFG['db']['tbl']['paypal_transaction']);
$paypal_ipn->setUserIP($CFG['remote_client']['ip']);
$paypal_ipn->setPayPalReceiverEmail($CFG['payment']['paypal']['merchant_email']);
$paypal_ipn->postResponse2PayPal(); //Post back our response to PayPal
//$paypal_ipn->validateTransaction();
if ($paypal_ipn->getPayPalVar('user_id')!=0 )
	$user_id = $paypal_ipn->getPayPalVar('user_id');
$source_id = $paypal_ipn->logTransactions($user_id);

if ($paypal_ipn->isTransactionOk())
{
	$paypal_ipn->insertUserPayment($source_id);
	$paypal_ipn->updateUserPaymentSettings();
}
require_once($CFG['site']['project_path'].'common/application_bottom.inc.php');

?>