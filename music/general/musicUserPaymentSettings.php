<?php
/**
 * Music User Payment Settings Page
 *
 * @package		general
 * @author 		mangalam_020at09
 * @copyright 	Copyright (c) 2009 - 2010 {@link http://www.mediabox.uz Uzdc Infoway}
 * @access 		Members
 **/
class UserPayment extends MusicHandler
{
	public function populatePaymentDetailsToEdit()
	{
		$sql = 'SELECT paypal_id, threshold_amount FROM '.
				$this->CFG['db']['tbl']['music_user_payment_settings'].
				' WHERE user_id = '.$this->dbObj->Param('user_id');
		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($this->CFG['user']['user_id']));
		if (!$rs)
			trigger_error($this->dbObj->ErrorNo().' '.
			$this->dbObj->ErrorMsg(), E_USER_ERROR);
		if($row = $rs->FetchRow())
		{
			$this->fields_arr['paypal_id'] = $row['paypal_id'];
			$this->fields_arr['threshold_amount'] = $row['threshold_amount'];
		}
	}

	public function chkIsEditMode()
	{
		$sql = 'SELECT user_id FROM '.
				$this->CFG['db']['tbl']['music_user_payment_settings'].
				' WHERE user_id='.$this->dbObj->Param('user_id');
		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($this->CFG['user']['user_id']));
	    if (!$rs)
		    trigger_error($this->dbObj->ErrorNo().' '.
				$this->dbObj->ErrorMsg(), E_USER_ERROR);

		if($row = $rs->FetchRow())
			return true;
		return false;
	}

	public function updateMusicPaymentDetails($fields_arr = array())
	{
		$param_value_arr = array();
		if($this->chkIsEditMode())
			$sql = 'UPDATE '.
					$this->CFG['db']['tbl']['music_user_payment_settings'].
					' SET ';
		else
			$sql = 'INSERT INTO '.
				   	$this->CFG['db']['tbl']['music_user_payment_settings'].
				   	' SET ';
		foreach($fields_arr as $key => $fieldname)
		{
			$param_value_arr[] = $this->fields_arr[$fieldname];
			$sql .= $fieldname.'='.$this->dbObj->Param($fieldname).', ';
		}
		if($this->chkIsEditMode())
		{
			$sql = substr($sql, 0, strrpos($sql, ','));
			$sql .= ' WHERE user_id='.$this->dbObj->Param('user_id');
		}
		else
			$sql .= ' user_id='.$this->dbObj->Param('user_id');

		$param_value_arr[] = $this->CFG['user']['user_id'];
		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, $param_value_arr);

		if (!$rs)
		    trigger_error($this->dbObj->ErrorNo().' '.
				$this->dbObj->ErrorMsg(), E_USER_ERROR);
	}

	public function validateFormFields1()
	{
		$this->chkIsValidEmail('paypal_id',$this->LANG['musicupdatepaymentsettings_err_msg_invalid']);
		$this->chkIsReal('threshold_amount',$this->LANG['musicupdatepaymentsettings_err_msg_invalid']);
	}
}

$userpayment = new UserPayment();

if(!chkAllowedModule(array('music')))
	Redirect2URL($CFG['redirect']['dsabled_module_url']);

$userpayment->setFormField('paypal_id','');
$userpayment->setFormField('threshold_amount','');

$userpayment->setPageBlockNames(array('block_music_payment_settings_form'));
$userpayment->setPageBlockShow('block_music_payment_settings_form');
if($userpayment->chkIsEditMode())
	$userpayment->populatePaymentDetailsToEdit();

$userpayment->includeHeader();

if($userpayment->isFormPOSTed($_POST, 'update_payment'))
{
	$userpayment->sanitizeFormInputs($_POST);
	$userpayment->validateFormFields1();
	if($userpayment->isValidFormInputs())
	{
		$fields_arr = array('paypal_id','threshold_amount');
		$userpayment->updateMusicPaymentDetails($fields_arr);
		$userpayment->setCommonSuccessMsg($LANG['musicuserpaymentsettings_msg_success']);
		$userpayment->setPageBlockShow('block_music_payment_settings_form');
		$userpayment->setPageBlockShow('block_msg_form_success');
	}
	else
	{
		$userpayment->setCommonErrorMsg($LANG['common_music_msg_error_sorry']);
		$userpayment->setPageBlockShow('block_msg_form_error');
		$userpayment->setPageBlockShow('block_music_payment_settings_form');
	}
}
?>
<script type="text/javascript" src="<?php echo $CFG['site']['music_url'];?>js/functions.js"></script>
<script type="text/javascript" src="<?php echo $CFG['site']['url']; ?>js/lib/validation/validation.js"></script>

<?php
setTemplateFolder('general/', 'music');
$smartyObj->display('musicUserPaymentSettings.tpl');
$userpayment->includeFooter();
?>