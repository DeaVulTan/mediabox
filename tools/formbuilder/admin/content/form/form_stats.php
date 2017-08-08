<?php
	if(!empty($_GET['form']) )
	{
		$fireForm = new FireForm();		
		if($fireForm->isPermitted(intval($_GET['form'])))
		{

			$formInfo = $fireForm->get($_GET['form']);
		
		}else 
		{
			die(PERMISSION_DENIED);
		}

		
	}else 
	{
		die(ERR_FORM_NOT_SPECIFIED);
	}	
	$todayTime = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
	$finishDateTime = $todayTime;
	$startDateTime = @strtotime($formInfo['cdatetime']);
	$finishTime =  mktime(0, 0, 0, date('m', $finishDateTime), date('d', $finishDateTime), date('Y', $finishDateTime));
	$startTime =  mktime(0, 0, 0, date('m', $startDateTime), date('d', $startDateTime), date('Y', $startDateTime));
	$finalFinishTime = $finishTime;
	
	
	if(isset($_GET['filter']))
	{
		$d = $_GET;
	}else 
	{
		$d = array(
			'type'=>'monthly',
			'monthly_start_month'=>date('m', $startDateTime),
			'monthly_start_year'=>date('Y', $startDateTime),
			'monthly_end_month'=>date('m', $finalFinishTime),
			'monthly_end_year'=>date('Y', $finalFinishTime),	
			'daily_start_day'=>1,	
			'daily_start_month'=>date('m', $finalFinishTime),
			'daily_start_year'=>date('Y', $finalFinishTime),
			'daily_end_day'=>date('t', $finalFinishTime),
			'daily_end_month'=>date('m', $finalFinishTime),
			'daily_end_year'=>date('Y', $finalFinishTime),					
		);		
	}

	
	include_once(DIR_INC_FF . 'times.php');

?>
<form method="GET" action="">
<input type="hidden" name="tab" value="<?php echo $_GET['tab']; ?>">
<input type="hidden" name="action" value="<?php echo $_GET['action']; ?>">
<input type="hidden" name="module" value="<?php echo $_GET['module']; ?>">
<input type="hidden" name="form" value="<?php echo $_GET['form']; ?>">
<input type="hidden" name="filter" value="">

<table cellpadding="0" cellspacing="0" class="tableForm">
	<thead>
		<tr>
			<th colspan="2"><?php echo FORM_STATS_FILTER; ?></th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<th>
				<label>
					<?php echo FORM_STATS_FILTER_BY; ?>
				</label>
			</th>
			<td>
				<?php
					$types = array(
						'daily'=>FORM_STATS_DAILY,
						'monthly'=>FORM_STATS_MONTHLY,
					);
					foreach ($types as $k=>$v)
					{
						?>
						<input type="radio" onclick="changeStatsDateRange(this);" class="input inputStatsType" name="type" value="<?php echo $k; ?>" <?php echo ($k == $d['type']?'checked':''); ?>> <?php echo $v; ?>&nbsp;&nbsp;
						<?php
					}
				?>
			</td>
		</tr>
		<tr id="monthly"  <?php echo ($d['type'] == 'monthly'?'':'style="display:none"'); ?>>
			<th>
				<label>
					<?php echo FORM_STATS_RANGE; ?>
				</label>
			</th>
			<td>
				<?php
					
					echo getMonthsHTML('monthly_start_month', $d['monthly_start_month']) . '&nbsp;';
					echo getYearsHTML(null, date('Y', $startDateTime), date('Y', $finishDateTime), 'monthly_start_year', $d['monthly_start_year']);
					
					echo ' - ';
					echo getMonthsHTML('monthly_end_month', $d['monthly_end_month']) . '&nbsp;';
					echo getYearsHTML(null, date('Y', $startDateTime), date('Y', $finishDateTime), 'monthly_end_year', $d['monthly_end_year']);
										
					
				?>
			</td>
		</tr>
		<tr id="daily" <?php echo ($d['type'] == 'daily'?'':'style="display:none"'); ?>>
			<th>
				<label>
					<?php echo FORM_STATS_RANGE; ?>
				</label>
			</th>
			<td>
				<?php
					echo getDaysHTML('daily_start_day', $d['daily_start_day']) . '&nbsp;';
					echo getMonthsHTML('daily_start_month', $d['daily_start_month']) . '&nbsp;';
					echo getYearsHTML(null, date('Y', $startDateTime), date('Y', $finishDateTime), 'daily_start_year', $d['daily_start_year']);
					
					echo ' - ';
					echo getDaysHTML('daily_end_day', $d['daily_end_day']) . '&nbsp;';
					echo getMonthsHTML('daily_end_month', $d['daily_end_month']) . '&nbsp;';
					echo getYearsHTML(null, date('Y', $startDateTime), date('Y', $finishDateTime), 'daily_end_year', $d['daily_end_year']);										
					
				?>
			</td>
		</tr>		
	</tbody>
	<tfoot>
		<tr>
			<th>&nbsp;</th>
			<td>
				<input type="submit" class="button" value="<?php echo CONST_SUBMIT; ?>"> 
			</td>
		</tr>
	</tfoot>
</table>
</form>
<h2><?php echo L_MENU_STATS; ?></h2>
<?php
	$i = 0;
	$startTime = mktime(0,0,0, $d['monthly_start_month'], 1, $d['monthly_start_year']);
	$firstStartTime = $startTime;
	$finishDateTime = mktime(23,59,59, $d['monthly_end_month'], 1, $d['monthly_end_year']);
	$finishTime = mktime(23, 59, 59, date('m', $finishDateTime), date('t', $finishDateTime), date('Y', $finishDateTime));
	if($d['type'] == 'monthly')
	{
		$count = 0;
		?>
		<table cellpadding="0" cellspacing="0" class="tableList">
			<thead>
				<tr>
					<th><?php echo FORM_STATS_MONTH; ?></th>
					<th><?php echo FORM_NUMBER_RESPONDS; ?></th>
					<th>&nbsp;</th>
				</tr>
			</thead>
			<tbody>
				<?php
					while($startTime <= $finishTime)
					{
						$endTime = mktime(23, 59, 59, date('m', $startTime), date('t', $startTime), date('Y', $startTime));
						$num = ($fireForm->countResponds($_GET['form'], date('Y-m-d H:i:s', $startTime), date('Y-m-d H:i:s', $endTime)));
						$count += $num;
						?>
						<tr class="<?php echo ($i++%2?'odd':'event'); ?>">
							<td><?php echo date(CMM_MONTHYEAR_FORMAT, $startTime); ?></td>
							<td><?php echo $num; ?></td>
							<td>
								<?php
									if($num)
									{
										
										?>
										<a href="<?php echo URL_ADMIN . 'export_form.php?form=' . $_GET['form'] . '&startdate=' . date('Y-m-d H:i:s', $startTime) . '&finishdate=' . date('Y-m-d H:i:s', $endTime); ?>" target="_blank" class="linkExport"><?php echo CONST_EXPORT; ?></a>	
										<?php
									}else 
									{
										echo CMM_NA;
									}
								?>
							</td>
						</tr>
						<?php
						$startTime = mktime(0, 0, 0, date('m', $startTime) +1, 1, date('Y', $startTime));
					}
					
				?>
			</tbody>
			<tfoot>
				<tr>
					<th class="right"><?php echo CMM_TOTAL; ?></th>
					<td><?php echo $count; ?></td>
					<td>
								<?php
									if($count)
									{
										?>
										<a href="<?php echo URL_ADMIN . 'export_form.php?form=' . $_GET['form'] . '&startdate=' . date('Y-m-d H:i:s', $firstStartTime) . '&finishdate=' . date('Y-m-d H:i:s', $finishTime); ?>" target="_blank" class="linkExport"><?php echo CONST_EXPORT; ?></a>
										<?php
									}else 
									{
										echo CMM_NA;
									}
								?>					
					</td>
				</tr>
			</tfoot>
		</table>
		<?php
	}else 
	{
		$startTime = mktime(0,0,0, $d['daily_start_month'], $d['daily_start_day'], $d['daily_start_year']);
		$finishTime = mktime(0, 0, 0, $d['daily_end_month'], $d['daily_end_day'], $d['daily_end_year']);
		$count = 0;
		$firstStartTime = $startTime;
		?>
		<table cellpadding="0" cellspacing="0" class="tableList">
			<thead>
				<tr >
					<th><?php echo FORM_STATS_DAY; ?></th>
					<th><?php echo FORM_NUMBER_RESPONDS; ?></th>
					<th>&nbsp;</th>
				</tr>
			</thead>
			<tbody>
				<?php
					while($startTime <= $finishTime)
					{
						$endTime = mktime(23, 59, 59, date('m', $startTime), date('d', $startTime), date('Y', $startTime));
						$num = ($fireForm->countResponds($_GET['form'], date('Y-m-d H:i:s', $startTime), date('Y-m-d H:i:s', $endTime)));
						$count += $num;
						?>
						<tr class="<?php echo ($i++%2?'odd':'event'); ?>">
							<td><?php echo date(CMM_DATE_FORMAT, $startTime); ?></td>
							<td><?php echo $num; ?></td>
							<td>
								<?php
									if($num)
									{
										
										?>
										<a href="<?php echo URL_ADMIN . 'export_form.php?form=' . $_GET['form'] . '&startdate=' . date('Y-m-d H:i:s', $startTime) . '&finishdate=' . date('Y-m-d H:i:s', $endTime); ?>" target="_blank" class="linkExport"><?php echo CONST_EXPORT; ?></a>	
										<?php
									}else 
									{
										echo CMM_NA;
									}
								?>							
							</td>
						</tr>
						<?php
						$startTime = mktime(0, 0, 0, date('m', $startTime), date('d', $startTime) + 1, date('Y', $startTime));
					}
					
				?>

			</tbody>
			<tfoot>
				<tr>
					<th class="right"><?php echo CMM_TOTAL; ?></th>
					<td><?php echo $count; ?></td>
					<td>
								<?php
									if($count)
									{
										?>
										<a href="<?php echo URL_ADMIN . 'export_form.php?form=' . $_GET['form'] . '&startdate=' . date('Y-m-d H:i:s', $firstStartTime) . '&finishdate=' . date('Y-m-d H:i:s', $finishTime); ?>" target="_blank" class="linkExport"><?php echo CONST_EXPORT; ?></a>
										<?php
									}else 
									{
										echo CMM_NA;
									}
								?>					
					</td>					
				</tr>
			</tfoot>
		</table>		
		<?php
	}
?>