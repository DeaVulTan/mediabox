<?php
	global $auth;
	if(isset($_POST['id']))
	{
		$d = $_POST;
		$query = "INSERT INTO " . TBL_USER . '(first_name, last_name, email, 
		is_active, is_super_admin, username, 
		password, cdatetime, mdatetime) VALUES (' . 
		$db->quote($d['first_name'], 'text') . ", " . $db->quote($d['last_name'], 'text') . ', ' . $db->quote($d['email'], 'text') . 
		", " . $db->quote($d['is_active'], 'text') . ', ' . $db->quote($d['is_super_admin'], 'text') . ", " . $db->quote($d['username'], 'text')
		. ", " . $db->quote(md5($d['password']), 'text') . ", " . $db->quote(date('Y-m-d H:i:s'), 'timestamp') . ", "  . $db->quote(date('Y-m-d H:i:s'), 'timestamp')
		 . ")";
		$affected = $db->exec($query);
		if($affected)
		{
			redirect(URL_SITE_ADMIN_INDEX . '?tab=' . $_GET['tab'] . '&module=' . $_GET['module']);
		}else 
		{
			$msg->setErrMsg(USER_ERR_FAILED_ADD);
		}
	}
	$d = array(
		'id'=>'',
		'first_name'=>'',
		'last_name'=>'',
		'email'=>'',
		'is_super_admin'=>'0',
		'is_active'=>'1',
		'username'=>'',
		'password'=>'',
	);
	
	
	if(empty($d))
	{
		redirect(URL_SITE_ADMIN_INDEX . '?tab=' . $_GET['tab'] . '&module=' . $_GET['module']);
	}
	
	$formTitle = L_MENU_USER_NEW;
	include_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'user_form.php');
	