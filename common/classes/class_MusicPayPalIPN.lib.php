<?php
/**
 * class_PayPalIPN.lib.php
 * +--------------------------------+
 * | paypal_transaction_log         |
 * +--------------------------------+--------+-------------+--------------+---------------+-------------+----------------+----------------+-----------------+----------+------+------------------+
 * | id | date_added | ip | user_id | txn_id | payer_email | payment_date | payment_gross | payment_fee | payment_status | receiver_email | paypal_response | error_no | memo | paypal_post_vars |
 * +----+------------+----+---------+--------+-------------+--------------+---------------+-------------+----------------+----------------+-----------------+----------+------+------------------+
 *
 * @version $Id class_PayPalIPN.lib.php$
 * @version $Revision 1.0$ 2003-03-21 - 2003-03-24
 * @version initial version
 * @author rajesh_04ag02
 * @version $Revision 2.0$ 2003-05-22
 * @version To trap exact error with error no
 * @author rajesh_04ag02
 * @version $Revision 3.0$ 2003-05-23
 * @version For easy validation of receiver email
 * @author rajesh_04ag02
 * @version $Revision 4.0$ 2003-05-23
 * @version To avoid undefined index errors & To avoid socket connection error
 * @version	Added referer_url in table to fetch fraud URLs
 * @author rajesh_04ag02
 * @version $Revision 5.0$ 2003-06-02
 * @version To avoid complexity in validation of transactions
 * @author rajesh_04ag02
 * @version $Revision 6.0$ 2003-06-03
 * @version User defined variable ADV_ID is added,Removed referer_url because of no use
 * @author rajesh_04ag02
 * @version $Revision 7.0$ 2003-06-04
 * @version Code added to fetch all available user-defined variables & values
 * @version	Added Index in table
 * @author rajesh_04ag02
 * @version $Revision 8.0$ 2003-07-29
 * @version Added _getCurrentIP() to get error free IP
 * @version	Modified code so that db & table name can be set via methods
 * @author rajesh_04ag02
 * @version $Revision 9.0$ 2005-03-03
 * @version converted the documentation style
 * @version converted " to '
 * @version setDbObject method for setDblink method
 * @version trigger error on error
 * @author vasanthi_19ag04
 * @version $Revision 10.0$ 2005-03-03
 * @version converted to PHP5
 * @author vasanthi_19ag04
 * @version $Revision 11.0$ 2005-03-03
 * @version used the db object in query
 * @author vasanthi_19ag04
 * @version $Revision 12.0$ 2005-03-03
 * @version added / in query
 * @author vasanthi_19ag04
 * @version $Revision 13.0$ 2005-03-12
 * @version changed ' to "  in query
 * @author vasanthi_19ag04
 * @version $Revision 14.0$ 2005-03-12
 * @version Changed the style for framework compliance. Fixed single quote bug (can't use single quote for control characters).
 * @author rajesh_04ag02
 *
 * @link http://www.paypal.com/cgi-bin/webscr?cmd=p/acc/ipn-info-outside
 * @link http://www.webmasterinabox.net/paypal_ipn.html
 * @see ./common/classes/db/mysql4.php|DB
 *
 * @todo Test the new methods. If possible, improve the style for elegance.
 *
 * @since 2004-10-15
 * @copyright 	Copyright (c) 2009 - 2010 {@link http://www.mediabox.uz Uzdc Infoway}
 */

/*Logic:
  		PayPal is the online banking system where the money transfer is done via PayPal account (email address) than any credit cards.
  		To sell any product, we have to post some variables (via form) like: item name, return url, cancel url, etc to PayPal.
  		On successful transaction, the PayPal will return to the successful url & error to cancel url. Depending upon the url the PayPal has returned, we can check for the validity of the transaction.
  	  IPN:
  		There is a flaw in the above process. ie, the user can 'view source' and may directly enter into success url even without payment. And so IPN has introduced.
  		The seller has to add the url of 'check IPN file' in his account. So, the end user won't be aware of the url and the process.
  		While processing, the PayPal will post many variables including the status to the 'check IPN file' and 'check IPN file' has to process the variables & other transactions.
 */
//------------------------------------------------------------
/**
 * class_PayPalIPN
 *
 * @package class_PayPalIPN
 * @version $Revision 1.0$ 2003-03-21 - 2003-03-24
 * @version class File
 * @author rajesh_04ag02
 * @version $Revision 2.0$ 2005-03-03
 * @version modified setDbLink to setDbObject and triggered error on failure
 * @author vasanthi_19ag04
 * @version $Revision 3.0$ 2005-03-03
 * @version converted to PHP5
 * @author vasanthi_19ag04
 * @version $Revision 4.0$ 2005-03-12
 * @version Changed the style for framework compliance. Fixed single quote bug (can't use single quote for control characters).
 * @author rajesh_04ag02
 *
 * @todo Test the new methods. If possible, improve the style for elegance.
 * @since 2003-03-21
 * @copyright 	Copyright (c) 2009 - 2010 {@link http://www.mediabox.uz Uzdc Infoway}
 **/

class PayPalIPN extends FormHandler
{
	private $paypal_post_arr = array(); 			//$_POST array vars
	private $paypal_post_vars_in_str; //the paypal post array vars as string
	private $paypal_response = ''; //paypals response for our posted vars
	private $paypal_receiver_emails = array(); //array of expected paypal receiver emails
	private $errno; //error no of transaction
	private $ip;	//User IP

	 /**
	  * PayPalIPN::__construct()
	  *
	  * @return void
	  * @access public
	  **/
	 public function __construct()
	{
	}

	/**
	 * PayPalIPN::setDBObject()
	 * Sets the Database Object
	 *
	 * @param object $dbObj Database object
	 * @return void The function does not return any value
	 * @access public
	 **/
	public function setDBObject($dbObj)
	{
		$this->dbObj = $dbObj;
	}

	/**
	 * PayPalIPN::setPayPalVars()
	 *
	 * @param $paypal_post_arr
	 * @return void
	 * @access public
	 **/
	public function setPayPalVars($paypal_post_arr)
	{
		//we can directly assign $this->paypal_post_arr = $paypal_post_arr;. But, it is safe to check undefined index...
		//sanitzie via another method
		$this->paypal_post_arr = $paypal_post_arr;
		//get the POST array in a string...
		$this->paypal_post_vars_in_str = '';
		foreach($paypal_post_arr as $key=>$value)
			{
				$value = urlencode(stripslashes($value));
				$this->paypal_post_vars_in_str .= '&'.$key.'='.$value;
			}

		//Commenting out; not necessary as the command variable is prepended before sending...
		//$this->paypal_post_vars_in_str = substr($this->paypal_post_vars_in_str, 1); //remove the first "&" from the string
	}

	/**
	 * PayPalIPN::setUserIP()
	 *
	 * @param $ip
	 * @return
	 * @access public
	 **/
	public function setUserIP($ip)
	{
		$this->ip = $ip;
	}

	/**
	 * PayPalIPN::setPayPalLogTableName()
	 *
	 * @param string $table_name
	 * @return void
	 * @access public
	 **/
	public function setPayPalLogTableName($table_name)
		{
			$this->table_name = $table_name;
		}

	/**
	 * PayPalIPN::setPayPalReceiverEmail()
	 * set expected receiver emails array
	 *
	 * @param string $email
	 * @return void
	 * @access public
	 **/
	public function setPayPalReceiverEmail($email)
	{
		//put it in array so that any number of emails can be set as receiver emails
		$this->paypal_receiver_emails[] = $email;
	}

	/**
	 * PayPalIPN::postResponse2PayPal()
	 * post back our response to paypal
	 *
	 * @return void
	 * @access public
	 **/
	public function postResponse2PayPal()
		{
			// post back to PayPal system to validate

			$this->paypal_post_vars_in_str =  'cmd=_notify-validate'.$this->paypal_post_vars_in_str;
			$header = 'POST /cgi-bin/webscr HTTP/1.0'."\r\n";
			$header .= 'Content-Type: application/x-www-form-urlencoded'."\r\n";
			$header .= 'Content-Length: ' . strlen($this->paypal_post_vars_in_str) . "\r\n\r\n";
			//suppress socket connection error by '@'...

			if($this->CFG['payment']['paypal']['test_mode'])
			{
				$url = $this->CFG['payment']['paypal']['test_url'];
			}
			else
				$url=$this->CFG['payment']['paypal']['url'];

			$parsed_url=parse_url($url);
			$host = $parsed_url['host'];

			$fp = @fsockopen ($host, 80, $errno, $errstr, 30);
			if (!$fp)  // ERROR
					$this->paypal_response = $errstr.'('.$errno.')';
				else
					{
						//just post it...
						fputs($fp, $header . $this->paypal_post_vars_in_str);
						while(!feof($fp))
							{
								$resp = fgets($fp, 1024);

								    if (strcmp($resp, 'VERIFIED') == 0)
											$this->paypal_response = 'VERIFIED';
										else if (strcmp($resp, 'INVALID') == 0)
											$this->paypal_response = 'INVALID';
							}
					}
		}

	/**
	 * PayPalIPN::sanitizePayPalVars()
	 * process paypal POST vars so as to avoid undefined index error
	 *
	 * @return void
	 * @access private
	 **/
	public function sanitizePayPalVars()
	{
		$expected_paypal_post_arr = array(
										'txn_id' 		=> '',
										'payer_email' 	=> '',
										'payment_date'	=> '',
										'payment_gross' => '',
										'payment_fee'	=> '',
										'payment_status'=> '',
										'memo'			=> '',
										'receiver_email' => '',
										'mc_currency'  => '',
										'mc_gross'  => '',
										'UID'			=> 0,
										'product_id'    => '',
										'order_id'=> '',
										'pricedetails'=> ''
									);
		//@todo Check if $tmp_arr is really necessary. Can't we do it directly?
		$tmp_arr = array();
		foreach($expected_paypal_post_arr as $key=>$default_value)
			$tmp_arr[$key] = (isset($this->paypal_post_arr[$key])) ? htmlspecialchars(trim($this->paypal_post_arr[$key])) : $default_value;
		//UID is user-defined variable (on0 & os0 in the form)---used to process user_id
		//option_name1==UID & option_selection1==value
		//therefore...
		//fetch all available user-defined variables & values...
		for($i=1; isset($this->paypal_post_arr["option_name{$i}"]) && isset($this->paypal_post_arr["option_selection{$i}"]); ++$i)
				$tmp_arr[$this->paypal_post_arr["option_name{$i}"]] = htmlspecialchars(trim($this->paypal_post_arr["option_selection{$i}"]));
		//following line is to avoid undefined index error...
		$this->paypal_post_arr = $tmp_arr;

	}

	/**
	 * PayPalIPN::_isVerified()
	 * check whether paypal's response is 'VERIFIED' or not
	 *
	 * @return boolean
	 * @access private
	 **/
	private function _isVerified()
	{

		return(strcmp($this->paypal_response, 'VERIFIED')==0);
	}

	/**
	 * PayPalIPN::_isVaidPaymentStatus()
	 * get the payment status: 'Completed', 'Pending', 'Failed', 'Denied'
	 * test whether it is 'Completed'
	 *
	 * @return boolean
	 * @access private
	 **/
	private function _isVaidPaymentStatus()
	{
		//payment status can be : 'Completed', 'Pending', 'Failed', 'Denied'

		return(strcmp($this->paypal_post_arr['payment_status'], 'Completed')==0);
	}

	/**
	 * PayPalIPN::_isTransactionProcessed()
	 * Is txn_id is already processed?
	 *
	 * @return string $txn_id
	 * @access private
	 **/
	private function _isTransactionProcessed()
	{
		$txn_id = $this->paypal_post_arr['txn_id'];
		$sql = 'SELECT COUNT(*) as count FROM '.
					$this->table_name.
					' WHERE txn_id=\''.$txn_id.'\'';

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt);
		    if (!$rs)
			    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

		$rs->PO_RecordCount();

		$row = $rs->FetchRow();
		$num_of_txn_id = $row['count'];

		return($num_of_txn_id!=0); //txn_id processed if num!=0
	}

	/**
	 * PayPalIPN::_isValidReceiverEmail()
	 * Is receiver_email is my paypal (expected) email?
	 *
	 * @return boolean
	 * @access private
	 **/
	private function _isValidReceiverEmail()
	{
		//is receiver_email is the expected receiver_emails (one who runs website)??
		return( in_array($this->paypal_post_arr['receiver_email'], $this->paypal_receiver_emails) );
	}

	public function _isValidAmountAndCurrency()
	{
		//$currency  = $this->$CFG['payment']['paypal']['currency_code'];
		$amount_to_pay = $this->getMediaAmount();
		$amount = $amount_to_pay['amount'];
		$currency = $amount_to_pay['currency'];
		if($currency == 'USD')
			$p_gross = 'payment_gross';
        else
			$p_gross = 'mc_gross';

		echo 'werwe'.$amount.'-'.$currency.$this->paypal_post_arr[$p_gross].'-'.$this->paypal_post_arr['mc_currency'];
		if ((float)$this->paypal_post_arr[$p_gross] >= (float)$amount AND strtolower($this->paypal_post_arr['mc_currency']) == strtolower($currency))
			{
					echo 'treu';
					return true;
			}
		else
			return false;
	}

	public function getMediaAmount()
	{
		$sql = 'SELECT amount, currency FROM '.
				$this->CFG['db']['tbl']['music_order'].
				' WHERE music_order_id = '.$this->dbObj->Param('order_id');
		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($this->paypal_post_arr['order_id']));
		if (!$rs)
			trigger_error($this->dbObj->ErrorNo().' '.
			$this->dbObj->ErrorMsg(), E_USER_ERROR);
		if($row = $rs->FetchRow())
		{
			return $row;
		}
	}

	/**
	 * PayPalIPN::getPayPalVar()
	 *
	 * @param $var_name index of PayPal post array
	 * @return void
	 * @access public
	 **/
	public function getPayPalVar($var_name)
	{
		return $this->paypal_post_arr[$var_name];
	}

	/**
	 * PayPalIPN::validateTransaction()
	 * validate transactions ie, to set error no. Must to call this function.
	 *
	 * @return void
	 * @access public
	 **/
	public function validateTransaction()
	{
		//set the error no...
		// check the payment_status is Completed
		// check that txn_id has not been previously processed
		// check that receiver_email is an email address in your PayPal account
		// process payment
		//This is to trap exact error type
		//Logic: bit field logic: 0-no error, ...
		//if all bits are set, then error in all conditions
		$this->errno = 0; //initialize to no error

		$cnt = 0;



		$this->errno  |=  $this->_isVerified() ? 0 : (1<<0);

		$this->errno  |=  $this->_isVaidPaymentStatus() ? 0 : (1<<1);

		$this->errno  |=  (!$this->_isTransactionProcessed()) ? 0 : (1<<2);

		$this->errno  |=  $this->_isValidReceiverEmail() ? 0 : (1<<3);

		$this->errno  |=  $this->_isValidAmountAndCurrency() ? 0 : (1<<4);

	}

		/**
	 * PayPalIPN::validateTransaction()
	 * validate transactions ie, to set error no. Must to call this function.
	 *
	 * @return void
	 * @access public
	 **/
	public function validateMemberShipTransaction()
	{
		//set the error no...
		// check the payment_status is Completed
		// check that txn_id has not been previously processed
		// check that receiver_email is an email address in your PayPal account
		// process payment
		//This is to trap exact error type
		//Logic: bit field logic: 0-no error, ...
		//if all bits are set, then error in all conditions
		$this->errno = 0; //initialize to no error

		$cnt = 0;

		$this->errno  |=  $this->_isVerified() ? 0 : (1<<0);
		$this->errno  |=  $this->_isVaidPaymentStatus() ? 0 : (1<<1);
		$this->errno  |=  (!$this->_isTransactionProcessed()) ? 0 : (1<<2);

	}



	/**
	 * PayPalIPN::isTransactionOk()
	 * a single method to check all above conditions
	 *
	 * @return boolean
	 * @access public
	 **/
	public function isTransactionOk()
	{
		//$this->validateTransaction();

		return( !$this->errno );
	}

	/**
	 * PayPalIPN::logTransactions()
	 *
	 * @param integer $user_id
	 * @return void
	 * @access public
	 **/
	public function logTransactions($user_id)
	{
		//addslashes to every variable in the array....
		//kinda sanitization...
		$this->paypal_post_arr = array_map('addslashes', $this->paypal_post_arr);
		$sql = 'INSERT INTO '.$this->table_name.' SET ' .
				'date_added=NOW(), ' .
				'ip=\''.$this->ip.'\', ' .
				'user_id=\''.$user_id.'\', ' .
				'txn_id=\''.$this->paypal_post_arr['txn_id'].'\', ' .
				'music_order_id=\''.$this->paypal_post_arr['order_id'].'\', ' .
				'currency_type=\''.$this->paypal_post_arr['mc_currency'].'\', ' .
				'payer_email=\''.$this->paypal_post_arr['payer_email'].'\', ' .
				'payment_date=\''.$this->paypal_post_arr['payment_date'].'\', ' .
				'payment_gross=\''.$this->paypal_post_arr['payment_gross'].'\', ' .
				'payment_fee=\''.$this->paypal_post_arr['payment_fee'].'\', ' .
				'payment_status=\''.$this->paypal_post_arr['payment_status'].'\', ' .
				'receiver_email=\''.$this->paypal_post_arr['receiver_email'].'\', ' .
				'paypal_response=\''.$this->paypal_response.'\', ' .
				'error_no=\''.$this->errno.'\', ' .
				'memo=\''.$this->paypal_post_arr['memo'].'\', ' .
				'paypal_post_vars=\''.$this->paypal_post_vars_in_str.'\'';

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt);
		    if (!$rs)
			    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
		return $this->dbObj->Insert_ID();
	}


	public function getTransactionId()
	{
		return $this->paypal_post_arr['txn_id'];
	}

	public function insertUserPayment($source_id)
	{
		$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['user_transaction_log'].
				' SET '.
				' user_id = '.$this->dbObj->Param('user_id').' , '.
				' paypal_transaction_id = '.$this->dbObj->Param('source_id').' , '.
				' disbursement_amount = '.$this->dbObj->Param('amount').' , '.
				' txn_id = '.$this->dbObj->Param('txn_id').' , '.
				' paypal_id = '.$this->dbObj->Param('receiver_email').' , '.
				' payment_status = '.$this->dbObj->Param('payment_status').' , '.
				' currency = '.$this->dbObj->Param('currency').' , '.
				' date_added = NOW()';
		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($this->paypal_post_arr['user_id'], $source_id, $this->paypal_post_arr['mc_gross'],$this->paypal_post_arr['txn_id'], $this->paypal_post_arr['receiver_email'],$this->paypal_post_arr['payment_status'],$this->paypal_post_arr['mc_currency']));
		if (!$rs)
		   trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
	}

	public function updateUserPaymentSettings()
	{
		$sql = 'UPDATE '.$this->CFG['db']['tbl']['music_user_payment_settings'].
				' SET '.
				' pending_amount=pending_amount-'.$this->paypal_post_arr['mc_gross'].','.
				' withdrawl_amount=withdrawl_amount+'.$this->paypal_post_arr['mc_gross'].
				' WHERE user_id='.$this->dbObj->Param('user_id');
		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($this->paypal_post_arr['user_id']));
		if (!$rs)
			trigger_error($this->dbObj->ErrorNo().' '.
			$this->dbObj->ErrorMsg(), E_USER_ERROR);

	}


}
?>
