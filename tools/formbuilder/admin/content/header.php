<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
	echo $content->getCss();
	
?>
<title><?php echo $content->getTitle(); ?></title>
</head>
<body id="<?php echo $content->getBodyId();  ?>">
	<div id="wrapper">
		
		<div id="header">
			<h1 id="siteName">Fire Form Builder</h1>
			
		</div>
		<div id="menus">
			<ul>
				<?php 
					foreach($content->getMenus() as $k=>$v)
					{
						?>
						<li <?php echo (!empty($v['active'])?'class="active"':''); ?>><a href="<?php echo $v['url']; ?>"><?php echo $v['title']; ?></a></li>
						<?php
					}
				?>
			</ul>	
			<span id="linkLogoff">
			<?php 
				printf(LOGIN_STATUS, $auth->getFirstName() . ' [<a href="javascript:void(0);" onclick="document.getElementById(\'formLogout\').submit();">' . LOGOUT . '</a>]');
			?></span>	
			<form method="POST" id="formLogout" action="">
				<input type="hidden" name="form_event" value="logoff">
			</form>
		</div>