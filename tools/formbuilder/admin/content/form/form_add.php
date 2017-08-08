<?php
	if(!empty($_POST))
	{
		$d = $_POST;
		$formId = $db->getBeforeID(TBL_CATEGORY, 'id', true, true);
		$query = "INSERT INTO " . TBL_FORM . " (";
		$query .= "title, submit_label, theme,
				subject, email, url,
				mode, id, creator_id";
		$query .= ') VALUES (';
		$query .= $db->quote($d['title'], 'text') . ", " . $db->quote($d['submit_label'], 'text') . ", " . $db->quote($d['theme'], 'text') .
		" ";
		if(($d['mode'] == 'both' || $d['mode'] == 'email'))
		{
			$query .= ", " . $db->quote($d['subjec'], 'text') . ", " . $db->quote($d['email'], 'text');
		}else
		{
			$query .= ", " . $db->quote('', 'text') . ", " . $db->quote('', 'text');
		}
		$query .= ", " . $db->quote($d['url'], 'text');
		$query .= ", " . $db->quote($d['mode'], 'text') . ", " . $formId ;
		if($auth->isSuperAdmin())
		{
			$query .= ", " . $db->quote($d['creator_id'], 'integer');
		}else
		{
			$query .= ", " .  $db->quote($auth->getUserId(), 'integer');
		}

		$query .= ")";
		$result = $db->exec($query);
		if($result)
		{
			redirect(URL_SITE_ADMIN_INDEX . '?tab=' . $_GET['tab'] . '&module=' . $_GET['module']);
		}else
		{
			$msg->setErrMsg(FAILED_TO_ADD_FORM);
		}
	}else
	{
		$d = array(
			'title'=>'',
			'creator_id'=>$auth->getUserId(),
			'theme'=>'default',
			'subject'=>'',
			'email'=>'',
			'url'=>'',
			'submit_label'=>'',
			'mode'=>'db',
			'id'=>'',
		);
	}
	include_once(DIR_INC_FF . 'class.fireform.php');
	$fireForm = new FireForm();
?>
<form method="POST" action="">
	<input type="hidden" name="id" value="<?php echo $d['id']; ?>">
	<table id="fireFormfireForm" class="tableForm" cellpadding="0" cellspacing="0">
		<thead>
			<tr>
				<th colspan="2"><?php echo BTN_ADD_FORM; ?></th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<th>
					<label>
						<?php echo PANEL_FS_FORM_TITLE; ?>
					</label>
				</th>
				<td>
					<input type="text" class="input" name="title" value="<?php echo $d['title']; ?>">
				</td>
			</tr>
			<?php
				if($auth->isSuperAdmin())
				{
			?>
			<tr>
				<th>
					<label>
						<?php echo PANEL_FS_CREATOR; ?>
					</label>
				</th>
				<td>
						<select name="creator_id" class="fireformSelect">
								<?php
									$query = "SELECT * FROM " . TBL_USER . " ORDER BY last_name, first_name";
									$result = $db->query($query);
									while ($v = $result->fetchrow())
									{
										?>
										<option value="<?php echo ($v['id']); ?>" <?php echo ($d['creator_id'] == $v['id']?'selected':''); ?>><?php echo $v['first_name'] . ' ' . $v['last_name']; ?></option>
										<?php
									}
								?>
							</select>
				</td>
			</tr>
			<?php
				}
			?>
			<tr>
				<th>
					<label>
						<?php echo PANEL_FS_BTN_LABEL; ?>
					</label>
				</th>
				<td>
					<input type="text" class="input" name="submit_label" value="<?php echo $d['submit_label']; ?>">
				</td>
			</tr>
			<tr>
				<th>
					<label>
						<?php echo PANEL_FS_URL; ?>
					</label>
				</th>
				<td>
					<input type="text" class="input" name="url" value="<?php echo $d['url']; ?>">
				</td>
			</tr>

			<tr>
				<th>
					<label>
						<?php echo PANEL_FS_THEME; ?>
					</label>
				</th>
				<td>
					<select name="theme" class="fireformSelect">
						<?php

							foreach ($fireForm->getThemes() as $k=>$v)
							{
								?>
								<option value="<?php echo ($k); ?>" <?php echo ($k == $d['theme']?'selected':''); ?>><?php echo $v; ?></option>
								<?php
							}
						?>
					</select>
				</td>
			</tr>
			<tr>
					<th><label><?php echo PANEL_FS_MODE; ?></label></th>
						<td>
							<?php
								$modes = array(
									'both'=>PANEL_FS_MODE_BOTH,
									'email'=>PANEL_FS_MODE_EMAIL,
									'db'=>PANEL_FS_MODE_DB,
								);
								foreach ($modes as $k=>$v)
								{
									?>
									<input onclick="javascript:refreshFireFormMode();" type="radio" name="mode" value="<?php echo $k; ?>" <?php echo ($d['mode'] == $k?'checked':''); ?> class="fireformRadio"> <?php echo $v; ?>
									<?php
								}

								$emailModes = array('both', 'email');
							?>

						</td>
			</tr>
			<tr  class="fireformEmail" <?php echo array_search($d['mode'], $emailModes) !== false?'':'style="display:none"'; ?>>
				<th><label><?php echo PANEL_FS_EMAIL; ?><label></th>
				<td>
					<input type="text" class="fireformInput" value="<?php echo $d['email']; ?>" name="email">
				</td>
			</tr>
			<tr class="fireformEmail"  <?php echo array_search($d['mode'], $emailModes) !== false?'':'style="display:none"'; ?>>
				<th><label ><?php echo PANEL_FS_SUBJECT; ?></label></th>
				<td >
					<input type="text" class="fireformInput" value="<?php echo $d['subject']; ?>" name="subject">
				</td>
			</tr>
		</tbody>
		<tfoot>
			<tr>
				<th>&nbsp;</th>
				<td><input type="submit" class="button" value="<?php echo BTN_ADD_FORM; ?>"></td>
			</tr>
		</tfoot>
	</table>

</form>