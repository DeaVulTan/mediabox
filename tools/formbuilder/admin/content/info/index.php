<?php
	if(!empty($_POST['id']))
	{
		$d = $_POST;
		$query = "UPDATE " . TBL_USER . " SET first_name=" . $db->quote($d['first_name'], 'text') . 
			", last_name=" . $db->quote($d['last_name'], 'text') . 
			", email=" . $db->quote($d['email'], 'text') . 
			", username=" . $db->quote($d['username'], 'text');
		if(!empty($_POST['change_password']))
		{
			$_POST['password'] = md5($_POST['password']);

				$query .= ", password=" . $db->quote(md5($d['password']));
				

		}
		$query .= ", mdatetime=" . $db->quote(date('Y-m-d H:i:s'), 'timestamp');
		$query .= " WHERE id=" . $db->quote($auth->getUserId(), 'integer');
		$affected = $db->exec($query);
		if($affected)
		{
			
			$auth->refreshLoginStatus();
		}else 
		{
			$msg->setErrMsg(USER_ERR_FAILED_UPDATE);
		}
	}
	$d = $auth->getFullUserInfo();
?>
<form method="POST" action="">
	<input type="hidden" name="id" value="<?php echo $d['id']; ?>">
	<table class="tableForm" cellpadding="0" cellspacing="0">
		<thead>
			<tr>
				<th colspan="2"><?php echo USER_CHANGE_DETAILS; ?></th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<th>
					<label>
						<?php echo USER_FIRST_NAME; ?>
					</label>
				</th>
				<td>
					<input type="text" class="input" name="first_name" value="<?php echo $d['first_name']; ?>">
				</td>
			</tr>
			<tr>
				<th>
					<label>
						<?php echo USER_LAST_NAME; ?>
					</label>
				</th>
				<td>
					<input type="text" class="input" name="last_name" value="<?php echo $d['last_name']; ?>">
				</td>
			</tr>	
			<tr>
				<th>
					<label>
						<?php echo USER_USERNAME; ?>
					</label>
				</th>
				<td>
					<input type="text" class="input" name="username" value="<?php echo $d['username']; ?>">
				</td>
			</tr>	
			<tr>
				<th>
					<label>
						<?php echo USER_PASSWORD; ?>
					</label>
				</th>
				<td>
					<input type="password" class="input" name="password" value="">
					<?php
						if(!empty($d['id']))
						{
							?>
							<br>
							<input type="hidden" name="change_password" value="0">
							<input type="checkbox" class="input" name="change_password" value="1"> <?php echo USER_CHANGE_PWD; ?>
							<?php
						}
					?>
				</td>
			</tr>	
			<tr>
				<th>
					<label>
						<?php echo USER_EMAIL; ?>
					</label>
				</th>
				<td>
					<input type="text" class="input" name="email" value="<?php echo $d['email']; ?>">
				</td>
			</tr>												
		</tbody>
		<tfoot>
			<tr>
				<th>&nbsp;</th>
				<td><input type="submit" class="button" value="<?php echo USER_CHANGE_DETAILS; ?>"></td>
			</tr>
		</tfoot>
	</table>

</form>