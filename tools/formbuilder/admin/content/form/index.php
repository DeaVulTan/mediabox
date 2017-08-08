<?php
	/**
	 * @author Logan Cai
	 * @access   cailongqun [at] yahoo.com.cn    please replace "  [at] " with "@"
	 *
	 */

	include_once(DIR_INC_FF . 'class.fireform.php');
	$fireForm = new FireForm();
	if(!empty($_GET['action']))
	{
		switch ($_GET['action'])
		{
			case ACTION_DELETE:
				$query = "DELETE FROM " . TBL_CATEGORY . " WHERE id=" . $db->quote($_GET['id'],'integer') . ($auth->isSuperAdmin()?'': ' AND creator_id=' . $db->quote($auth->getUserId(), 'integer'));
				$result = $db->exec($query);
				break;
		}
	}
?>
<h3><?php echo FORM_YOUR_FORM; ?></h3>
<table cellpadding="0" cellspacing="0" class="tableList">
	<thead>
		<tr>
			<th><?php echo FORM_FORM_TITLE; ?></th>

			<th><?php echo FORM_NUMBER_RESPONDS; ?></th>
			<?php
				if($auth->isSuperAdmin())
				{
					?>
					<th><?php echo FORM_CREATOR; ?></th>
					<?php
				}
			?>
			<th><?php echo CONST_CDATETIME; ?></th>
			<th>&nbsp;</th>
		</tr>
	</thead>
	<tbody>
		<?php
			$i = 1;

			foreach ($fireForm->getYourForms($auth->isSuperAdmin()?null:$auth->getUserId()) as $v)
			{

				?>
				<tr class="<?php echo ($i++%2?'odd':'event'); ?>" >
					<td><?php echo $v['title']; ?></td>

					<td><?php echo number_format($fireForm->countResponds($v['id'])); ?></td>
					<?php
						if($auth->isSuperAdmin())
						{
							?>
							<td><?php echo $v['first_name'] . ' ' . $v['last_name']; ?></td>
							<?php
						}
					?>
					<td><?php echo strDateTime($v['cdatetime']); ?></td>
					<td>
						<a target="_blank"  href="<?php echo URL_SITE . 'fireform.php?id=' . $v['id']; ?>" class="linkView" target="_blank"><?php echo CONST_TEST; ?></a>

						<a target="_blank"  href="<?php echo URL_SITE . 'manageQuestions.php?id=' . $v['id']; ?>" class="linkEdit"><?php echo CONST_EDIT; ?></a>
						<?php
							if($v['mode'] == 'both' || $v['mode'] == 'db')
							{
						?>
						<a href="<?php echo URL_ADMIN . 'export_form.php?form=' . $v['id']; ?>" target="_blank" class="linkExport"><?php echo CONST_EXPORT; ?></a>
						<?php
							}
						?>
						<a href="<?php echo URL_SITE_ADMIN_INDEX . '?tab=' . TAB_FORM . '&action=stats&module=' . MODULE_FORM . '&form=' . $v['id']; ?>"  class="linkStats"><?php echo CONST_STATS; ?></a>
						<a class="linkDelete" href="javascript:void(0);" onclick="return confirmDelete('<?php echo URL_SITE_ADMIN_INDEX . '?id=' . $v['id'] . '&tab=' . TAB_FORM . '&module=' . MODULE_FORM . '&action=delete'; ?>', '<?php echo USER_DELETE_CONFIRM; ?>');"><?php ECHO CONST_DELETE; ?></a>

					</td>
				</tr>
				<?php
			}
		?>
	</tbody>
</table>