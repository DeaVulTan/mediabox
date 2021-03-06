<?php
require_once('common/configs/config.inc.php');

echo '<?xml version="1.0"?>
'."\n"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html lang="en-US" dir="ltr" xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="application/xhtml+xml; charset=UTF-8" />
<meta http-equiv="content-Language" content="en-US" />
<meta name="keywords" content="rayzz, rayzz.net, online social networking, video hosting, view, upload and share videos" />
<meta name="description" content="rayzz is a social networking product that provides video hosting service allowing users to view, upload, and share videos." />
<?php
if ($CFG['html']['meta']['MSSmartTagsPreventParsing']) //Disable MSSmartTags?
	{
	?>
<!-- Disable MSSmartTags -->
<meta name="MSSmartTagsPreventParsing" content="true" />
<?php
	}
if ( ! $CFG['html']['meta']['imagetoolbar']) //Disable IE6 image toolbar?
	{
	?>
<!-- Disable IE6 image toolbar -->
<meta http-equiv="imagetoolbar" content="no" />
<?php
	}
?>
<link rel="stylesheet" type="text/css" href="<?php echo $CFG['site']['url'];?>design/templates/<?php echo $CFG['html']['template']['default']; ?>/root/css/<?php echo $CFG['html']['stylesheet']['screen']['default']; ?>/header.css" media="screen" title="Default" />
<link rel="stylesheet" type="text/css" href="<?php echo $CFG['site']['url'];?>design/templates/<?php echo $CFG['html']['template']['default']; ?>/root/css/<?php echo $CFG['html']['stylesheet']['screen']['default']; ?>/footer.css" media="screen" title="Default" />
<link rel="stylesheet" type="text/css" href="<?php echo $CFG['site']['url'];?>design/templates/<?php echo $CFG['html']['template']['default']; ?>/root/css/<?php echo $CFG['html']['stylesheet']['screen']['default']; ?>/common.css" media="screen" title="Default" />
<link rel="stylesheet" type="text/css" href="<?php echo $CFG['site']['url'];?>design/templates/<?php echo $CFG['html']['template']['default']; ?>/root/css/<?php echo $CFG['html']['stylesheet']['screen']['default']; ?>/layout.css" media="screen" title="Default" />
<link rel="stylesheet" type="text/css" href="<?php echo $CFG['site']['url'];?>design/css/print.css" media="print" />
<link rel="shortcut icon" href="<?php echo $CFG['site']['url'];?>design/templates/<?php echo $CFG['html']['template']['default']; ?>/favicon.ico" type="image/x-icon" />
<!-- for link bar -->
<link rel="Home"     href="<?php echo URL($CFG['site']['url']);?>" title="Home page" />
<link rel="Index"    href="<?php echo URL($CFG['site']['url']);?>" title="Index" />
<link rel="search"   href="#" title="Search this site" />

<link rel="contents" href="#" title="Site map" />
<title>Rayzz</title>
</head>
<body>

<div id="selPageBody" class="clsInstallPage">
<div id="<?php echo $CFG['html']['page_id'];?>" class="clsThemeMangeBgLicenceErr">
  <!-- Accessibility Links -->
  <div id="top">
    <ul>
      <li><a href="#main">Skip to main content</a></li>
      <li><a href="#selSubHeader">Skip to Navigation Links</a></li>
      <li><a href="#footer">Skip to Footer</a></li>
    </ul>
  </div>
  <!-- Header -->
<div id="header" class="clsHeaderContainer">
 <div class="clsHeaderShadowImage">
	<div class="clsHeaderBlock">
		<div class="clsMainLogo">
			<h1>
				<a href="<?php echo $CFG['site']['url']?>"><img src="<?php echo $CFG['site']['url']?>/design/templates/<?php echo $CFG['html']['template']['default']; ?>/root/images/<?php echo $CFG['html']['stylesheet']['screen']['default']; ?>/header/logo/logo.gif" alt="<?php echo $CFG['site']['name']?>" title="<?php echo $CFG['site']['name']?>" /></a>
			</h1>
		</div>
	</div>
 </div>
</div>
<!-- Main -->

<div id="main" class="clsInstallMainBar" style="margin:100px auto 0;">
	<div class="clsLicenceErrDiv" style="background:#FFFFFF none repeat scroll 0 0;border:1px solid #F80000 !important;padding-bottom:3.5em;padding-left:3.5em;">
		<h1 style="font:bold 20px arial; color:#f00; text-align:left;padding-top:1.5em;padding-bottom:1.5em;">Error</h1>
		<span style="font:bold 12px arial;text-align:center;padding:1.5em;margin:1em;">
			<?php
				$link='<span><a href="'.$CFG['site']['url'].'install.php" >'.$LANG['invalid_license_install'].'</a></span>';
				$LANG['invalid_license']=str_replace('VAR_INSTALL',$link,$LANG['invalid_license']);
				echo $LANG['invalid_license'];
			?>
		</span>
	</div>
</div>
<!-- Footer -->
</div></div>
<div id="footer">
	<div class="clsFooterMidddleBG">
		<div class="clsFooterContentBG">
			<div class="clsFooterCenterBg">
				<div class="clsFooterRightBG">
					<div class="clsFooterLeftBG">
						<div class="clsFooterContent">
							<div class="clsCopyrightContent">
								<span class="clsCopyrightLogo">&copy; <?php echo $CFG['admin']['coppy_rights_year'].' '.$CFG['site']['name'].'. All rights reserved.'; ?></span>
								<span class="clsPoweredText">Powered By <a href="<?php echo $CFG['dev']['url']; ?>"><?php echo $CFG['dev']['name']; ?></a></span>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
  </div>  
</body>
</html>