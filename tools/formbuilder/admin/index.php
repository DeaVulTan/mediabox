<?php
	include_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'inc' . DIRECTORY_SEPARATOR . 'config.php');
	if(!$auth->isLogin())
	{		
		if(!empty($_GET['return_path']))
		{
			redirect(URL_SITE_ADMIN_LOGIN);
		}else 
		{
			redirect(URL_SITE_ADMIN_LOGIN . '?return_path=' . urlencode(appendUrlExc(array())));
		}
		
	}	
	require_once(CLASS_CONTENT_ADMIN);
	
	
	$content = new ContentAdmin();	
	$content->appendCss(URL_ADMIN_CSS . 'admin.css');
	
	$content->appendJs(URL_JS . 'jquery.js');
	$content->appendJs(URL_JS . 'jquery.form.js');
	$content->appendJs(URL_JS . 'common.js');
	$content->appendJs(URL_JS . 'fireformadmin.js');
	$content->setTitle('Fire Form Builder');

	$content->setContent($content->getPage(), true);

	


	include_once(DIR_ADMIN_CONTENT_FF . 'header.php');
?>

		<div id="bodyLC">
			<div id="bodyLCContainer">				
			<?php
			
				foreach($content->getSubMenus() as $category=>$menus)
				{
					?>
					<h3 class="subMenuCategory"><?php echo $category; ?></h3>
					
					<?php
					echo "<ul class=\"subMenu\">\n";
					foreach ($menus as $subMenu)
					{
						if(empty($subMenu['hidden']))
						{
						?>
						<li <?php echo (!empty($subMenu['active'])?'class="active"':''); ?>><a href="<?php echo $subMenu['url']; ?>"><?php echo $subMenu['title']; ?></a></li>
						<?php
						}
					}
					echo "</ul>\n";
				}
			?>
			
			</div>
			<div id="bodyLCBottom"></div>
		</div>
		<div id="bodyRC">	
		<?php
			echo $content->getContent('main');
		?>
		
		</div>	
<?php
	include_once(DIR_ADMIN_CONTENT_FF . 'footer.php');
?>

		

