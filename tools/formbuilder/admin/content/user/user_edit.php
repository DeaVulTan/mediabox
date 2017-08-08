<?php

	if(!empty($_POST['id']))
	{
		$d = $_POST;
		$query = "UPDATE " . TBL_USER . " SET first_name=" . $db->quote($d['first_name'], 'text') . 
			", last_name=" . $db->quote($d['last_name'], 'text') . 
			", email=" . $db->quote($d['email'], 'text') . 
			", username=" . $db->quote($d['username'], 'text') . 
			", is_super_admin=" . $db->quote($d['is_super_admin'], 'text') . 
			", is_active=" . $db->quote($d['is_active'], 'text');		
		if(!empty($_POST['change_password']))
		{
			$_POST['password'] = md5($_POST['password']);

				$query .= ", password=" . $db->quote(md5($d['password']));
				

		}
		$query .= ", mdatetime=" . $db->quote(date('Y-m-d H:i:s'), 'timestamp');
		$query .= " WHERE id=" . $db->quote($d['id'], 'integer');
		$affected = $db->exec($query);
		if($affected)
		{
			redirect(URL_SITE_ADMIN_INDEX . '?tab=' . $_GET['tab'] . '&module=' . $_GET['module']);
		}else 
		{
			$msg->setErrMsg(USER_ERR_FAILED_EDIT);
		}
	}elseif(!empty($_GET['id']))
	{
		$query = "SELECT * FROM " . TBL_USER . " WHERE id=" . $db->quote($_GET['id'], 'integer');
		$result = $db->query($query);
		$d = $result->fetchrow();
	}
	
	if(empty($d))
	{
		redirect(URL_SITE_ADMIN_INDEX . '?tab=' . $_GET['tab'] . '&module=' . $_GET['module']);
	}
	
	$formTitle = L_MENU_USER_EDIT;
	include_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'user_form.php');
	