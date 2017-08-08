<?php
/**
 * View Musi Cart
 *
 * @package		general
 * @author 		mangalam_020at09
 * @copyright 	Copyright (c) 2009 - 2010 {@link http://www.mediabox.uz Uzdc Infoway}
 * @access 		public
 **/
class ViewCart extends MusicHandler
{
	public function populateCartDetails()
	{
		global $smartyObj;
		$musics_folder = $this->CFG['media']['folder'] . '/' . $this->CFG['admin']['musics']['folder'] . '/' . $this->CFG['admin']['musics']['thumbnail_folder'] . '/';
		$total_price = 0;
		$this->musicrecordFound = false;
		$this->albumrecordFound = false;
		$this->recordFound = false;
		$pricedetails = '';
		if(isset($_SESSION['user']['add_cart']))
		{
			$products = array();
			$inc = 0;
			$avail_add_cart_musicid_arr=explode(',',$_SESSION['user']['add_cart']);

			foreach($avail_add_cart_musicid_arr as $music_id)
			{
				if(!isUserPurchased($music_id))
				{
					$sql = 'SELECT m.music_id, m.music_title, m.music_price, m.medium_width, m.medium_height, '.
							' m.music_thumb_ext, m.music_server_url, file_name '.
							'FROM '.
							$this->CFG['db']['tbl']['music'].
							' as m JOIN '.
							$this->CFG['db']['tbl']['music_files_settings'].
							' ON music_file_id = m.thumb_name_id'.
							' WHERE music_id='.$this->dbObj->Param('music_id');
					$stmt = $this->dbObj->Prepare($sql);
					$rs = $this->dbObj->Execute($stmt, array($music_id));
					if (!$rs)
						trigger_error($this->dbObj->ErrorNo().' '.
						$this->dbObj->ErrorMsg(), E_USER_ERROR);
					$this->recordFound = false;
					if($row = $rs->FetchRow())
					{
						$this->recordFound = true;
						$this->musicrecordFound = true;
						$products[$inc]['record']=$row;
						$products[$inc]['img_src'] = $row['music_server_url'] . $musics_folder . getMusicImageName($row['music_id'],$row['file_name']) . $this->CFG['admin']['musics']['medium_name'] . '.' .$row['music_thumb_ext'];
		                if (($row['music_thumb_ext'] == ''))
					    {
		                    $products[$inc]['img_src'] = $this->CFG['site']['url'].'music/design/templates/'.
															$this->CFG['html']['template']['default'].'/root/images/'.
																$this->CFG['html']['stylesheet']['screen']['default'].'/no_image/noImage_audio_T.jpg';
		                }
			            $products[$inc]['view_music_link'] = getUrl('viewmusic', '?music_id=' . $row['music_id'] . '&title=' . $this->changeTitle($row['music_title']), $row['music_id'] . '/' . $this->changeTitle($row['music_title']) . '/', '', 'music');
			            $products[$inc]['music_title_word_wrap'] = $row['music_title'];
						$inc++;
						$total_price = $total_price + $row['music_price'];
						$pricedetails .= 'music_'.$row['music_id'].':'.$row['music_price'].',';
					}
				}
			}
			$smartyObj->assign('music_list_result', $products);
		}

		if(isset($_SESSION['user']['album_add_cart']))
		{
			$products = array();
			$inc = 0;
			$avail_add_cart_albumid_arr=explode(',',$_SESSION['user']['album_add_cart']);
			foreach($avail_add_cart_albumid_arr as $album_id)
			{
				if(!isUserAlbumPurchased($album_id))
				{
					$sql = 'SELECT music_album_id, album_title, album_price '.
							'FROM '.
							$this->CFG['db']['tbl']['music_album'].
							' WHERE music_album_id='.$this->dbObj->Param('album_id');
					$stmt = $this->dbObj->Prepare($sql);
					$rs = $this->dbObj->Execute($stmt, array($album_id));
					if (!$rs)
						trigger_error($this->dbObj->ErrorNo().' '.
						$this->dbObj->ErrorMsg(), E_USER_ERROR);
					if($row = $rs->FetchRow())
					{
						$this->recordFound = true;
						$this->albumrecordFound = true;
						$products[$inc]['record']=$row;
			            $products[$inc]['view_album_link'] = getUrl('viewalbum', '?album_id='.$row['music_album_id'].'&title='.$this->changeTitle($row['album_title']),$row['music_album_id'].'/'.$this->changeTitle($row['album_title']).'/', '', 'music');
			            $products[$inc]['album_title_word_wrap'] = $row['album_title'];
						$inc++;
						$total_price = $total_price + $row['album_price'];
						$pricedetails .= 'album_'.$row['music_album_id'].':'.$row['album_price'].',';
					}
				}
			}
			$smartyObj->assign('album_list_result', $products);
			//$total_price = $total_price + $album_total_price;
		}
		$smartyObj->assign('total_price', $total_price);
		$smartyObj->assign('pricedetails', $pricedetails);
	}

	public function insertIntoMusicOrderTable($music_id, $album_id)
	{
		$param_arr = array($this->CFG['user']['user_id'],$music_id, $album_id,
							$this->getFormField('total_amount'), $this->CFG['payment']['paypal']['currency_code']);

		$sql = 'INSERT INTO '.
				$this->CFG['db']['tbl']['music_order'].
				' SET '.
				' user_id = '.$this->dbObj->Param('user_id').','.
				' music_id = '.$this->dbObj->Param('music_id').','.
				' album_id = '.$this->dbObj->Param('album_id').','.
				' amount = '.$this->dbObj->Param('amount').','.
				' currency = '.$this->dbObj->Param('currency').','.
				' date_added = NOW(),'.
				' music_order_status = \'No\'';
		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, $param_arr);
		if (!$rs)
			trigger_error($this->dbObj->ErrorNo().' '.
			$this->dbObj->ErrorMsg(), E_USER_ERROR);
		return $this->dbObj->Insert_ID();
	}

	public function getAlbumMusicDetails($albumid)
	{
		$music_id = '';
		$sql = 'SELECT music_id FROM '.
					$this->CFG['db']['tbl']['music'].
					' WHERE music_album_id ='.$this->dbObj->Param('music_album_id').
					' AND music_status = \'Ok\'';
			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt, array($albumid));
			if (!$rs)
				trigger_error($this->dbObj->ErrorNo().' '.
				$this->dbObj->ErrorMsg(), E_USER_ERROR);
			while($row = $rs->FetchRow())
			{
				$music_id .=$row['music_id'].',';
			}

			$music_id = substr($music_id,0,-1);
		return $music_id;
	}

	public function sendMailToUserForMusicSale($music_id)
	{
		$sql = 'SELECT m.music_title,u.user_name, u.email FROM '.
				$this->CFG['db']['tbl']['music'].' as m '.
				' LEFT JOIN '.
				$this->CFG['db']['tbl']['users'].' as u ON m.user_id=u.user_id '.
				' WHERE m.music_id='.$this->dbObj->Param('music_id');
		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($music_id));

		if (!$rs)
			trigger_error($this->dbObj->ErrorNo().' '.
			$this->dbObj->ErrorMsg(), E_USER_ERROR);
		$row = $rs->FetchRow();

		$subject = str_replace('VAR_SITE_NAME', $this->CFG['site']['name'], $this->LANG['music_purchased_subject']);
		$body = $this->LANG['music_purchased_content'];
		$body = str_replace('VAR_LINK', '<a href=\''.$this->CFG['site']['url'].'\'>'.$this->CFG['site']['url'].'</a>', $body);
		$body = str_replace('VAR_USER_NAME', $row['user_name'], $body);
		$body = str_replace('VAR_SITE_NAME', $this->CFG['site']['name'], $body);
		$body = str_replace('VAR_MUSIC_TITLE', $row['music_title'], $body);
		$audio_link = getUrl('viewmusic','?music_id='.$music_id.'&title='.$this->changeTitle($row['music_title']), $music_id.'/'.$this->changeTitle($row['music_title']).'/', 'root','music');
		$body = str_replace('VAR_MUSIC_LINK', '<a href=\''.$audio_link.'\'>'.$audio_link.'</a>', $body);
		//$body=nl2br($body);
		if($this->_sendMail($row['email'], $subject, $body, $this->CFG['site']['noreply_name'], $this->CFG['site']['noreply_email']))
			return true;
		else
			return false;
	}

	public function sendMailToUserForAlbumSale($album_id)
	{
		$sql = 'SELECT ma.album_title,u.user_name, u.email FROM '.
				$this->CFG['db']['tbl']['music_album'].' as ma '.
				' LEFT JOIN '.
				$this->CFG['db']['tbl']['users'].' as u ON ma.user_id=u.user_id '.
				' WHERE ma.music_album_id='.$this->dbObj->Param('album_id');
		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($album_id));

		if (!$rs)
			trigger_error($this->dbObj->ErrorNo().' '.
			$this->dbObj->ErrorMsg(), E_USER_ERROR);
		$row = $rs->FetchRow();

		$subject = str_replace('VAR_SITE_NAME', $this->CFG['site']['name'], $this->LANG['album_purchased_subject']);
		$body = $this->LANG['album_purchased_content'];
		$body = str_replace('VAR_LINK', '<a href=\''.$this->CFG['site']['url'].'\'>'.$this->CFG['site']['url'].'</a>', $body);
		$body = str_replace('VAR_USER_NAME', $row['user_name'], $body);
		$body = str_replace('VAR_SITE_NAME', $this->CFG['site']['name'], $body);
		$body = str_replace('VAR_ALBUM_TITLE', $row['album_title'], $body);
		$audio_link = getUrl('viewalbum','?album_id='.$album_id.'&title='.$this->changeTitle($row['album_title']), $album_id.'/'.$this->changeTitle($row['album_title']).'/', 'root','music');
		$body = str_replace('VAR_ALBUM_LINK', '<a href=\''.$audio_link.'\'>'.$audio_link.'</a>', $body);
		//$body=nl2br($body);
		if($this->_sendMail($row['email'], $subject, $body, $this->CFG['site']['noreply_name'], $this->CFG['site']['noreply_email']))
			return true;
		else
			return false;
	}

	public function updateUserPaymentSettings($music_id='', $album_id='')
	{
		$music_arr = array();
		$album_arr = array();
		if($music_id>0)
			$music_arr = explode(',',$music_id);
		if($album_id>0)
			$album_arr = explode(',',$album_id);
		$total_price = 0;
		if(count($music_arr)>0)
		{
			foreach($music_arr as $musicid)
			{
				$sql = 'SELECT music_price, user_id FROM '.
						$this->CFG['db']['tbl']['music'].
						' WHERE music_id ='.$this->dbObj->Param('music_id').
						' AND for_sale = \'Yes\'';
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($musicid));
				if (!$rs)
					trigger_error($this->dbObj->ErrorNo().' '.
					$this->dbObj->ErrorMsg(), E_USER_ERROR);
				$row = $rs->FetchRow();
				$this->sendMailToUserForMusicSale($music_id, 'music');
				$commission = $row['music_price']*$this->CFG['admin']['musics']['artist_commission']/100;
				$music_price = $row['music_price'] - $commission;

				$sql = 'UPDATE '.
					$this->CFG['db']['tbl']['music_user_payment_settings'].
					' SET '.
					'total_revenue=total_revenue+'.$music_price.','.
					'pending_amount=pending_amount+'.$music_price.','.
					'commission_amount=commission_amount+'.$commission.
					' WHERE user_id = '.$this->dbObj->Param('user_id');
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($row['user_id']));
				if (!$rs)
					trigger_error($this->dbObj->ErrorNo().' '.
					$this->dbObj->ErrorMsg(), E_USER_ERROR);
			}
		}
		if(count($album_arr)>0)
		{
			foreach($album_arr as $albumid)
			{
				$sql = 'SELECT album_price, user_id FROM '.
						$this->CFG['db']['tbl']['music_album'].
						' WHERE music_album_id ='.$this->dbObj->Param('music_album_id').
						' AND album_for_sale = \'Yes\'';
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($albumid));
				if (!$rs)
					trigger_error($this->dbObj->ErrorNo().' '.
					$this->dbObj->ErrorMsg(), E_USER_ERROR);
				$row = $rs->FetchRow();
				$this->sendMailToUserForAlbumSale($albumid);
				$commission = $row['album_price']*$this->CFG['admin']['musics']['artist_commission']/100;
				$album_price = $row['album_price'] - $commission;
				$sql = 'UPDATE '.
					$this->CFG['db']['tbl']['music_user_payment_settings'].
					' SET '.
					'total_revenue=total_revenue+'.$album_price.','.
					'pending_amount=pending_amount+'.$album_price.','.
					'commission_amount=commission_amount+'.$commission.
					' WHERE user_id = '.$this->dbObj->Param('user_id');
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($row['user_id']));
				if (!$rs)
					trigger_error($this->dbObj->ErrorNo().' '.
					$this->dbObj->ErrorMsg(), E_USER_ERROR);
			}
		}

	}

	public function getMusicOwnerId($music_id)
	{
		$sql = 'SELECT user_id FROM '.
				$this->CFG['db']['tbl']['music'].
				' WHERE music_id='.$this->dbObj->Param('music_id');
		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($music_id));
		if (!$rs)
			trigger_error($this->dbObj->ErrorNo().' '.
			$this->dbObj->ErrorMsg(), E_USER_ERROR);
		if($row = $rs->FetchRow())
			return $row['user_id'];
	}

	public function getAlbumOwnerId($album_id)
	{
		$sql = 'SELECT user_id FROM '.
				$this->CFG['db']['tbl']['music_album'].
				' WHERE music_album_id='.$this->dbObj->Param('music_album_id');
		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($album_id));
		if (!$rs)
			trigger_error($this->dbObj->ErrorNo().' '.
			$this->dbObj->ErrorMsg(), E_USER_ERROR);
		if($row = $rs->FetchRow())
			return $row['user_id'];
	}


	public function insertIntoOrderItemTable($order_id, $user_id, $pricedetails)
	{
		$pr_arr = explode(',',$pricedetails);
		foreach($pr_arr as $price)
		{
			$deta = explode(':', $price);
			$this->fields_arr[$deta[0]] = $deta[1];
		}
		$sql = 'SELECT music_id, album_id FROM '.
				$this->CFG['db']['tbl']['music_order'].
				' WHERE music_order_id = '.$this->dbObj->Param('music_order_id');
		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($order_id));
		if (!$rs)
			trigger_error($this->dbObj->ErrorNo().' '.
			$this->dbObj->ErrorMsg(), E_USER_ERROR);

		$row = $rs->FetchRow();
		$this->updateUserPaymentSettings($row['music_id'], $row['album_id']);
		$avail_add_cart_albumid_arr=explode(',',$row['album_id']);

		//$row['music_id'] = $row['music_id'].','.$album_music_id;
		if($row['music_id']!='')
			$avail_add_cart_musicid_arr=explode(',',$row['music_id']);

		if(isset($avail_add_cart_musicid_arr) and $avail_add_cart_musicid_arr!='')
		{
			foreach($avail_add_cart_musicid_arr as $music_id)
			{
				$owner_id = $this->getMusicOwnerId($music_id);
				$param_arr = array($order_id, $user_id, $music_id, $this->fields_arr['music_'.$music_id], $owner_id);
				$sql = 'INSERT INTO '.
						$this->CFG['db']['tbl']['music_purchase_user_details'].
						' SET '.
						' music_order_id = '.$this->dbObj->Param('music_order_id').','.
						' user_id = '.$this->dbObj->Param('user_id').','.
						' music_id = '.$this->dbObj->Param('music_id').','.
						' price = '.$this->dbObj->Param('price').','.
						' owner_id = '.$this->dbObj->Param('owner_id').','.
						' date_added = NOW()';
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, $param_arr);
				if (!$rs)
					trigger_error($this->dbObj->ErrorNo().' '.
					$this->dbObj->ErrorMsg(), E_USER_ERROR);

				$sql = 'UPDATE '.
						$this->CFG['db']['tbl']['music'].
						' SET total_purchases = total_purchases+1'.
						' WHERE music_id = '.$this->dbObj->Param('music_id');
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($music_id));
				if (!$rs)
					trigger_error($this->dbObj->ErrorNo().' '.
					$this->dbObj->ErrorMsg(), E_USER_ERROR);

			}
		}

		foreach($avail_add_cart_albumid_arr as $album_id)
		{
			$owner_id = $this->getAlbumOwnerId($album_id);
			$param_arr = array($order_id, $user_id, $album_id, $this->fields_arr['album_'.$album_id], $owner_id);
			$sql = 'INSERT INTO '.
					$this->CFG['db']['tbl']['music_album_purchase_user_details'].
					' SET '.
					' music_order_id = '.$this->dbObj->Param('music_order_id').','.
					' user_id = '.$this->dbObj->Param('user_id').','.
					' album_id = '.$this->dbObj->Param('album_id').','.
					' price = '.$this->dbObj->Param('price').','.
					' owner_id = '.$this->dbObj->Param('owner_id').','.
					' date_added = NOW()';
			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt, $param_arr);
			if (!$rs)
				trigger_error($this->dbObj->ErrorNo().' '.
				$this->dbObj->ErrorMsg(), E_USER_ERROR);

			$album_music_id = $this->getAlbumMusicDetails($album_id);
			$musicid_arr=explode(',',$album_music_id);
			foreach($musicid_arr as $music_id)
			{
				$params_arr = array($order_id, $user_id, $music_id, $album_id, $owner_id);
				$sql1 = 'INSERT INTO '.
						$this->CFG['db']['tbl']['music_purchase_user_details'].
						' SET '.
						' music_order_id = '.$this->dbObj->Param('music_order_id').','.
						' user_id = '.$this->dbObj->Param('user_id').','.
						' music_id = '.$this->dbObj->Param('music_id').','.
						' album_id = '.$this->dbObj->Param('album_id').','.
						' owner_id = '.$this->dbObj->Param('owner_id').','.
						' date_added = NOW()';
				$stmt1 = $this->dbObj->Prepare($sql1);
				$res = $this->dbObj->Execute($stmt1, $params_arr);
				if (!$res)
					trigger_error($this->dbObj->ErrorNo().' '.
					$this->dbObj->ErrorMsg(), E_USER_ERROR);
			}

			$sql = 'UPDATE '.
					$this->CFG['db']['tbl']['music_album'].
					' SET total_purchases = total_purchases+1'.
					' WHERE music_album_id = '.$this->dbObj->Param('music_album_id');
			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt, array($album_id));
			if (!$rs)
				trigger_error($this->dbObj->ErrorNo().' '.
				$this->dbObj->ErrorMsg(), E_USER_ERROR);

		}
	}

	public function populatePaypalVariables()
	{
		global $smartyObj;
		$payment_details = array();
		$payment_details['paypal']['item_detail'] = $this->LANG['viewmusiccart_shopping_cart'];
		$payment_details['paypal']['success_url'] = getUrl('viewmusiccart', '?status=success', '?status=success', 'members', 'music');
		$payment_details['paypal']['cancel_url'] = getUrl('viewmusiccart', '?status=cancel', '?status=cancel', 'members', 'music');
		$payment_details['paypal']['notify_url'] = getUrl('viewmusiccart', '?status=notify', '?status=notify', 'root', 'music');
		$payment_details['paypal']['net_amount'] = $this->getFormField('total_amount');
		$payment_details['paypal']['user_defined']['UID'] = $this->CFG['user']['user_id'];
		$payment_details['paypal']['user_defined']['order_id'] = $this->getFormField('order_id');
		$payment_details['paypal']['user_defined']['pricedetails'] = $this->getFormField('pricedetails');
		$payment_details['paypal']['user_defined']['GATEWAY'] = 'paypal';
		$payment_details['paypal']['submit_value'] = $this->LANG['viewmusiccart_pay_now'];
		$smartyObj->assign('payment_details', $payment_details);
	}

	public function updateOurTransaction($paypal_ipn, $user_id)
	{
		$order_id = $paypal_ipn->getPayPalVar('order_id');
		$pricedetails = $paypal_ipn->getPayPalVar('pricedetails');
		$sql = 'UPDATE '.
				$this->CFG['db']['tbl']['music_order'].
				' SET '.
				' music_order_status = \'Yes\''.
				' WHERE music_order_id = '.$this->dbObj->Param('order_id');
		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($order_id));
		if (!$rs)
			trigger_error($this->dbObj->ErrorNo().' '.
			$this->dbObj->ErrorMsg(), E_USER_ERROR);
		$this->insertIntoOrderItemTable($order_id, $user_id, $pricedetails);

	}
}

$viewcart = new ViewCart();
if (!chkAllowedModule(array('music')))
    Redirect2URL($CFG['redirect']['dsabled_module_url']);
$viewcart->setPageBlockNames(array('view_cart_form', 'form_show_payment'));
$viewcart->setAllPageBlocksHide();
$viewcart->setPageBlockShow('view_cart_form');
$viewcart->setFormField('checkoutprocess','');
$viewcart->setFormField('total_amount','');
$viewcart->setFormField('status','');
$viewcart->setFormField('pricedetails','');
$viewcart->setFormField('msg','');
$viewcart->setFormField('action','');
$viewcart->setFormField('checkbox',array());
$viewcart->sanitizeFormInputs($_REQUEST);

if($viewcart->getFormField('status')=='notify')
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

		if ($paypal_ipn->getPayPalVar('UID')!=0 )
			$user_id = $paypal_ipn->getPayPalVar('UID');

		else if (isset($_SESSION['user']['user_id'])) //this is to just trap whether the user has visited directly by 'view source'
			$user_id = $_SESSION['user']['user_id']; //log the user_id (fraud user--attempted fraud)
		else
			$user_id = 0;

		$paypal_ipn->validateTransaction();
		$paypal_ipn->logTransactions($user_id);
		$viewcart->setFormField('user_id', $user_id);
		if ($paypal_ipn->isTransactionOk())
		{
			writeLog('paypal', "\n\n\r Transaction Ok");
			$viewcart->updateOurTransaction($paypal_ipn, $user_id);
		}

}
if($viewcart->getFormField('action')=='deleted')
{
	$viewcart->setAllPageBlocksHide();
	$viewcart->setCommonSuccessMsg($LANG['viewmusiccart_msg_item_remove']);
	$viewcart->setPageBlockShow('block_msg_form_success');
	$viewcart->setPageBlockShow('view_cart_form');
}
if($viewcart->getFormField('status')=='success')
{
	if(isset($_SESSION['user']['add_cart']))
		unset($_SESSION['user']['add_cart']);
	if(isset($_SESSION['user']['album_add_cart']))
		unset($_SESSION['user']['album_add_cart']);
	$viewcart->setAllPageBlocksHide();
	$viewcart->setCommonSuccessMsg($LANG['viewmusiccart_success_payment_message']);
	$viewcart->setPageBlockShow('block_msg_form_success');
	$viewcart->setPageBlockShow('view_cart_form');
}
if($viewcart->getFormField('status')=='cancel')
{
	$viewcart->setAllPageBlocksHide();
	$viewcart->setCommonErrorMsg($LANG['viewmusiccart_cancel_payment_message']);
	$viewcart->setPageBlockShow('block_msg_form_error');
	$viewcart->setPageBlockShow('view_cart_form');
}
if($viewcart->getFormField('status')=='player' and $viewcart->getFormField('msg')=='purchased')
{
	$viewcart->setAllPageBlocksHide();
	$viewcart->setCommonErrorMsg($LANG['musiclist_purchased']);
	$viewcart->setPageBlockShow('block_msg_form_error');
	$viewcart->setPageBlockShow('view_cart_form');
}

if ($viewcart->isFormPOSTed($_POST, 'confirm_order'))
{
	$music_id = '';
	$album_id = '';
	if(isset($_SESSION['user']['add_cart']) and $_SESSION['user']['add_cart']!='')
		$music_id= $_SESSION['user']['add_cart'];

	if(isset($_SESSION['user']['album_add_cart']) and $_SESSION['user']['album_add_cart']!='')
		$album_id= $_SESSION['user']['album_add_cart'];

	$order_id = $viewcart->insertIntoMusicOrderTable($music_id, $album_id);
	if($order_id)
	{
		//$viewcart->insertIntoOrderItemTable($order_id, $CFG['user']['user_id'], $viewcart->getFormField('pricedetails'));
		$viewcart->setFormField('order_id',$order_id);
		$viewcart->setAllPageBlocksHide();
		$viewcart->setPageBlockShow('form_show_payment');
	}
}
if ($viewcart->isFormPOSTed($_POST, 'delete_cart'))
{
	$ids = explode(',', $viewcart->getFormField('checkbox'));
	foreach($ids as $value)
	{
		if(strstr($value, 'music_'))
		{
			$music_id = str_replace('music_', '', $value);
			rayzzMusicRemoveCart($music_id);
		}
		if(strstr($value, 'album_'))
		{
			$album_id = str_replace('album_', '', $value);
			rayzzAlbumRemoveCart($album_id);
		}
	}
	$viewcart->setCommonSuccessMsg('Selected Items Removed Successfully');
	$viewcart->setPageBlockShow('block_msg_form_success');

}
$viewcart->includeHeader();
?>
<script type="text/javascript" src="<?php echo $CFG['site']['music_url'];?>js/functions.js"></script>
<?php
if($viewcart->isShowPageBlock('view_cart_form'))
{
	$viewcart->populateCartDetails();
	if(!isMember())
		{
			$_SESSION['cart']['add_cart'] = $_SESSION['user']['add_cart'];
			echo $_SESSION['user']['add_cart'];
			echo $_SESSION['cart']['add_cart'];
		}
}

if ($viewcart->isShowPageBlock('form_show_payment'))
{
	$viewcart->populatePaypalVariables();
}
// include the content of the page
setTemplateFolder('general/', 'music');
$smartyObj->display('viewMusicCart.tpl');
// includ the footer of the page
$viewcart->includeFooter();
?>