
<form method="POST" action="">
	<input type="hidden" name="id" value="<?php echo $d['id']; ?>">
	<table class="tableForm" cellpadding="0" cellspacing="0">
		<thead>
			<tr>
				<th colspan="2"><?php echo $formTitle; ?></th>
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
			<tr>
				<th>
					<label>
						<?php echo USER_IS_SUPLER_ADMIN; ?>
					</label>
				</th>
				<td>
					<input type="hidden" name="is_super_admin" value="0">
					<input type="checkbox" class="input" name="is_super_admin" value="1" <?php echo ($d['is_super_admin']?'checked':''); ?>>
					
				</td>
			</tr>	
			<tr>
				<th>
					<label>
						<?php echo USER_ACTIVE; ?>
					</label>
				</th>
				<td>
					<input type="hidden" name="is_active" value="0">
					<input type="checkbox" class="input" name="is_active" value="1" <?php echo $d['is_active']?'checked':''; ?>>
				</td>
			</tr>													
		</tbody>
		<tfoot>
			<tr>
				<th>&nbsp;</th>
				<td><input type="submit" class="button" value="<?php echo $formTitle; ?>"></td>
			</tr>
		</tfoot>
	</table>

</form>