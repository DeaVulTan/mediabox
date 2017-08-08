<?php
	/**
	 * @author Logan Cai
	 * @access   cailongqun [at] yahoo.com.cn    please replace "  [at] " with "@"
	 * 
	 */
	

	if(!empty($_GET['action']))
	{
		switch ($_GET['action'])
		{
			case ACTION_DELETE:
				if(!empty($_GET['id']) )
				{
					$query = "DELETE FROM " . TBL_USER . " WHERE id=" . $db->quote($_GET['id'], 'integer');
					$result = $db->query($query); 
				}
				break;
		}
	}
?>
<h3><?php echo L_MENU_USERS; ?></h3>
<table cellpadding="0" cellspacing="0" class="tableList">
	<thead>
		<tr>
			<th><?php echo USER_FIRST_NAME ; ?></th>
			<th><?php echo USER_LAST_NAME; ?></th>
			<th><?php echo USER_EMAIL; ?></th>
			<th><?php echo USER_CDATETIME; ?></th>
			<th><?php echo USER_IS_SUPLER_ADMIN; ?></th>
			<th><?php echo USER_ACTIVE; ?></th>
			

			<th>&nbsp;</th>
		</tr>
	</thead>
	<tbody>
		<?php
			$i = 1;
			$query = "SELECT * FROM " . TBL_USER . " ORDER BY last_name, first_name";
			$result = $db->query($query);
			while($v = $result->fetchrow())
			{
				
				?>
				<tr class="<?php echo ($i++%2?'odd':'event'); ?>">
					<td><?php echo htmlentities($v['first_name']); ?></td>
					<td><?php echo htmlentities($v['last_name']); ?></td>
					<td><?php echo htmlentities($v['email']); ?></td>
					<td><?php echo strDateTime($v['cdatetime']); ?></td>
					<td><?php echo (!empty($v['is_super_admin'])?'<span class="flagYes">&nbsp;</span>':'<span class="flagNo">&nbsp;</span>') ?></td>
					<td><?php echo (!empty($v['is_active'])?'<span class="flagYes">&nbsp;</span>':'<span class="flagNo">&nbsp;</span>') ?></td>
			
					<td>

						<a href="<?php echo URL_SITE_ADMIN_INDEX . '?id=' . $v['id'] . '&tab=' . $_GET['tab'] . '&module=' . MODULE_USER . '&action=edit'; ?>" class="linkEdit"><?php echo CONST_EDIT; ?></a>		

						<a class="linkDelete" href="javascript:void(0);" onclick="return confirmDelete('<?php echo URL_SITE_ADMIN_INDEX . '?id=' . $v['id'] . '&tab=' . $_GET['tab'] . '&module=' . MODULE_USER . '&action=delete'; ?>', '<?php echo USER_DELETE_CONFIRM; ?>');"><?php ECHO CONST_DELETE; ?></a>
						
					</td>
				</tr>
				<?php
			}
		?>
	</tbody>
</table>