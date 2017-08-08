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
class upgradeMembership extends FormHandler
	{
		/**
		 * upgradeMembership::populateSubscriptionVariables()
		 *
		 * @return
		 */
		public function populateSubscriptionVariables()
			{
				global $smartyObj;
				$payment_details = array();
				if($this->getFormField('payment_gateway')=='paypal')
					{
						$payment_details['paypal']['item_detail'] = $this->LANG['membership_upgrade_title'];
						$payment_details['paypal']['success_url'] = getUrl('upgrademembership', '?status=success', '?status=success', 'members');
						$payment_details['paypal']['cancel_url'] = getUrl('upgrademembership', '?status=cancel', '?status=cancel', 'members');
						$payment_details['paypal']['notify_url'] = getUrl('upgrademembership', '?status=notify', '?status=notify', 'root');
						$payment_details['paypal']['net_amount'] = $this->CFG['feature']['membership_charge'];
						$payment_details['paypal']['user_defined']['UID'] = $this->CFG['user']['user_id'];
						$payment_details['paypal']['user_defined']['GATEWAY'] = 'paypal';
						$payment_details['paypal']['submit_value'] = $this->LANG['upgrade_submit'];
					}
				$smartyObj->assign('payment_details', $payment_details);
			}

		/**
		 * upgradeMembership::updateMembershipStatus()
		 *
		 * @param mixed $user_id
		 * @return
		 */
		public function updateMembershipStatus($user_id)
			{
				$sql = 'UPDATE '.$this->CFG['db']['tbl']['users'].
						' SET is_paid_member=\'Yes\' WHERE user_id='.$this->dbObj->Param('user_id');
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($user_id));
				writeLog('paypal', "update sql\n-------\n".$sql);
				writeLog('paypal', "userid sql\n-------\n".$user_id);
				if (!$rs)
					{
						trigger_db_error($this->dbObj);
					}
			}

		/**
		 * upgradeMembership::sendWelcomeMessage()
		 *
		 * @return
		 */
		public function sendWelcomeMessage()
			{
				$user_detail = $this->getUserDetail('user_id', $this->getFormField('user_id'));
				$this->fields_arr = array_merge($user_detail, $this->fields_arr);

				$this->setEmailTemplateValue('user_name', $this->fields_arr['user_name']);
				$this->setEmailTemplateValue('link', $this->CFG['site']['url']);

				$this->setEmailTemplateValue('', getUserDisplayName($this->fields_arr));
				$is_ok = $this->_sendMail($this->fields_arr['email'], $this->LANG['membership_welcome_email_subject'], $this->LANG['membership_welcome_email_content'], $this->CFG['site']['noreply_name'], $this->CFG['site']['noreply_email']);

				if($is_ok){	writeLog('paypal', "message \n-------\n"."true");}
			}

		/**
		 * upgradeMembership::updateOurTransaction()
		 *
		 * @param mixed $paypal_ipn
		 * @param mixed $status
		 * @return
		 */
		public function updateOurTransaction($paypal_ipn, $status)
			{
				$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['transaction'].' SET'.
						' user_id='.$this->dbObj->Param('user_id').','.
						' txn_id='.$this->dbObj->Param('txn_id').','.
						' price='.$this->dbObj->Param('price').','.
						' currency_code='.$this->dbObj->Param('currency_code').','.
						' txn_date= now(),'.
						' status='.$this->dbObj->Param('status');

				$value_arr = array(
								$this->getFormField('user_id'),
								$paypal_ipn->getPayPalVar('txn_id'),
								$paypal_ipn->getPayPalVar('payment_gross'),
								$paypal_ipn->getPayPalVar('mc_currency'),
								$status
								);
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, $value_arr);
				    if (!$rs)
					    writeLog('paypal', "updateOurTransaction sql error\n-------\n".$this->dbObj->ErrorMsg());
			}
	}

$membership = new upgradeMembership();
$membership->setDBObject($db);
$CFG['feature']['auto_hide_success_block'] =false;
$membership->makeGlobalize($CFG, $LANG);
$membership->setPageBlockNames(array('block_upgrade_form', 'block_msg_form_success','block_msg_form_error'));
$membership->setFormField('payment_gateway', 'paypal');
$membership->setFormField('status', '');
$membership->setFormField('user_id', '');
$membership->sanitizeFormInputs($_REQUEST);
if($CFG['feature']['membership_payment']==false)
	{
		Redirect2URL($CFG['redirect']['dsabled_module_url']);
	}
if(!$membership->getFormField('status'))
	{
		$membership->populateSubscriptionVariables();
		$membership->setAllPageBlocksHide();
		$membership->setPageBlockShow('block_upgrade_form');
	}

if($membership->getFormField('status')=='success')
	{
		$membership->setAllPageBlocksHide();
		//writeLog('paypal', "success\n-------\n".serialize($_POST));
		//everything fine. show success
		chkAndUpdatePaidMember();
		$membership->setCommonSuccessMsg($membership->LANG['membership_success']);
		$membership->setPageBlockShow('block_msg_form_success');
	}
else if($membership->getFormField('status')=='cancel')
	{
		$membership->setAllPageBlocksHide();
		//writeLog('paypal', "cancel\n-------\n".serialize($_POST));
		//everything fine. show success
		$membership->setCommonErrorMsg($membership->LANG['common_msg_error_sorry']);
		$membership->setPageBlockShow('block_msg_form_error');
	}
if($membership->getFormField('status')=='notify')
	{
		writeLog('paypal', "notify\n-------\n".serialize($_POST));
		//$_POST = unserialize('a:34:{s:8:"mc_gross";s:4:"1.00";s:8:"payer_id";s:13:"WHKPRM69C8YWN";s:3:"tax";s:4:"0.00";s:12:"payment_date";s:25:"00:55:05 Apr 14, 2008 PDT";s:14:"payment_status";s:9:"Completed";s:7:"charset";s:12:"windows-1252";s:10:"first_name";s:4:"Test";s:17:"option_selection1";s:2:"43";s:17:"option_selection2";s:1:"2";s:6:"mc_fee";s:4:"0.33";s:14:"notify_version";s:3:"2.4";s:6:"custom";s:0:"";s:12:"payer_status";s:8:"verified";s:8:"business";s:31:"baluka_1200916938_biz@gmail.com";s:8:"quantity";s:1:"1";s:11:"payer_email";s:31:"paypal_1200917704_per@gmail.com";s:11:"verify_sign";s:56:"AFcWxV21C7fd0v3bYYYRCpSSRl31Aj27RwZHCS52IIEoPMtbxTohbA1G";s:12:"option_name1";s:3:"UID";s:12:"option_name2";s:3:"TID";s:6:"txn_id";s:17:"2J746092PF2926351";s:12:"payment_type";s:7:"instant";s:9:"last_name";s:4:"User";s:14:"receiver_email";s:31:"baluka_1200916938_biz@gmail.com";s:11:"payment_fee";s:4:"0.33";s:11:"receiver_id";s:13:"S4SU39KK2MXTA";s:8:"txn_type";s:10:"web_accept";s:9:"item_name";s:25:"Premium User Subscription";s:11:"mc_currency";s:3:"USD";s:11:"item_number";s:0:"";s:17:"residence_country";s:2:"US";s:8:"test_ipn";s:1:"1";s:13:"payment_gross";s:4:"1.00";s:8:"shipping";s:4:"0.00";s:20:"merchant_return_link";s:40:"Return to UzdcBank Uzdc\'s Test Store";}');
		$paypal_ipn = new PayPalIPN();
		$paypal_ipn->setPayPalVars($_POST);
		$paypal_ipn->sanitizePayPalVars();
		$paypal_ipn->setDBObject($db);
		$paypal_ipn->makeGlobalize($CFG, $LANG);
		$paypal_ipn->setPayPalLogTableName($CFG['db']['tbl']['paypal_transaction']);
		$paypal_ipn->setUserIP($CFG['remote_client']['ip']);
		$paypal_ipn->setPayPalReceiverEmail($CFG['payment']['paypal']['merchant_email']);
		$paypal_ipn->postResponse2PayPal(); //Post back our response to PayPal

		$paypal_ipn->validateMemberShipTransaction(); //must to call this function..to set error no
		$user_id = 0;
		if ($paypal_ipn->getPayPalVar('UID')!=0 )
			$user_id = $paypal_ipn->getPayPalVar('UID');
		else if (isset($_SESSION['user']['user_id'])) //this is to just trap whether the user has visited directly by 'view source'
			$user_id = $_SESSION['user']['user_id']; //log the user_id (fraud user--attempted fraud)

		$paypal_ipn->logTransactions($user_id);
		$membership->setFormField('user_id', $user_id);
		if ($paypal_ipn->isTransactionOk())
			{
				writeLog('paypal', "\n\n\r Transaction Ok");
				$membership->sendWelcomeMessage();
				$membership->updateOurTransaction($paypal_ipn, 'Paid');
				$membership->updateMembershipStatus($user_id);
			}
		else
			{
				writeLog('paypal', "\n\n\r Transactionnot Ok");
				 //log valid & invalid transactions
				$membership->updateOurTransaction($paypal_ipn, 'UnPaid');
			}
	}
if($membership->getFormField('status')!='notify')
	{
		if(!isMember())
			{
				Redirect2URL(getUrl('upgrademembership','','','members'));
			}
		$membership->contentText=str_replace(array('VAR_CURRENCY_CODE','VAR_MEMBERSHIP_COST'),array($CFG['payment']['paypal']['currency_code'],$CFG['feature']['membership_charge']),$LANG['membership_upgrade_detail']);
		$membership->includeHeader();
		setTemplateFolder('members/');
		$smartyObj->display('upgradeMembership.tpl');
		$membership->includeFooter();
	}
?>