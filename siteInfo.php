<?php
require_once('./common/configs/config.inc.php');
//include the error text file and the app license specific files
require_once('./common/configs/config_templates.inc.php');
require_once('./common/installFunctions.php');
//-------------------- Code begins -------------->>>>>//
setPageBlockNames(array('msg_form_error'));
setAllPageBlocksHide();
setPageBlockShow('msg_form_error');

$info = isset($_GET['info'])?$_GET['info']:'';
$err_msg = '';

switch($info)
	{
		case 'db':
			$err_msg = "Please check if you have installed properly with (<a href='install.php'>install.php</a>) and the database and license details are configured correctly.";
			break;
		case 'install':
			$err_msg = 'Please remove "install.php" file to proceed further';
			break;

	}
//<<<<<-------------------- Code ends ----------------------//
//--------------------Page block templates begins-------------------->>>>>//
echo '<?xml version="1.0"?>
'."\n"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html lang="en-US" dir="ltr" xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="content-type" content="application/xhtml+xml; charset=UTF-8" />
		<meta http-equiv="content-Language" content="en-US" />
		<meta name="keywords" content="Answers, Questions, Video Answers, Video Questions, Audio Answers, Audio Questions, Blogs, Forums" />
		<meta name="description" content="Visual Answers site is the place where you can post your questions of any type (Text, Video and Audio) and get them clarified. You can also reply to the Questions of any type (Text, Video and Audio) in any formats (Text, Video and Audio). You can also share the views through Blogs and Forums" />

		<link rel="stylesheet" type="text/css" href="<?php echo $CFG['site']['url'];?>design/templates/<?php echo $CFG['html']['template']['default']; ?>/root/css/<?php echo $CFG['html']['stylesheet']['screen']['default']; ?>/header.css" media="screen" title="Default" />
		<link rel="stylesheet" type="text/css" href="<?php echo $CFG['site']['url'];?>design/templates/<?php echo $CFG['html']['template']['default']; ?>/root/css/<?php echo $CFG['html']['stylesheet']['screen']['default']; ?>/footer.css" media="screen" title="Default" />
		<link rel="stylesheet" type="text/css" href="<?php echo $CFG['site']['url'];?>design/templates/<?php echo $CFG['html']['template']['default']; ?>/root/css/<?php echo $CFG['html']['stylesheet']['screen']['default']; ?>/general.css" media="screen" title="Default" />
		<link rel="stylesheet" type="text/css" href="<?php echo $CFG['site']['url'];?>design/templates/<?php echo $CFG['html']['template']['default']; ?>/root/css/<?php echo $CFG['html']['stylesheet']['screen']['default']; ?>/common.css" media="screen" title="Default" />
		<link rel="stylesheet" type="text/css" href="<?php echo $CFG['site']['url'];?>design/templates/<?php echo $CFG['html']['template']['default']; ?>/root/css/<?php echo $CFG['html']['stylesheet']['screen']['default']; ?>/layout.css" media="screen" title="Default" />
		<link rel="stylesheet" type="text/css" href="<?php echo $CFG['site']['url'];?>design/templates/<?php echo $CFG['html']['template']['default']; ?>/root/css/<?php echo $CFG['html']['stylesheet']['screen']['default']; ?>/include.css" media="screen" title="Default" />
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
		<div class="clsInstallPage">
			<div id="<?php echo $CFG['html']['page_id'];?>">
	  		<div id="hideScreen" style="z-index: 100; display: none;" class="VeilStyle1c">&nbsp;</div>
	  		<a href="#" id="alertHyperLink"></a>

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
	  		<div id="main" class="clsInstallMainBar">
	        	<div class="clsInstallPageCont clsOverflow">
	            	<div class="clsInstalRight">
						<div class="lbdisplay">
	                       	<div class="rbdisplay">
	                           	<div class="bbdisplay">
	                               	<div class="blcdisplay">
	                                   	<div class="brcdisplay">
	                                       	<div class="tbdisplay">
	                                           	<div class="tlcdisplay">
	                                               	<div class="trcdisplay">
														<div class="clsPageHeading"><h2><?php echo  $CFG['admin']['product_name'];?></h2></div>
	                    	           				    	<div id="selLogin" class="clsOverflow">
																<?php if(isShowPageBlock('msg_form_error')) { ?>
	                                                            <div id="selMsgError">
	                                                             	<p><?php echo $err_msg;?></p>
	                                                            </div>
																<?php } ?>
		                                                    </div>
		                                                </div>
		                                            </div>
		                                        </div>
		                                    </div>
		                                </div>
		                            </div>
		                        </div>
		                    </div>
	                	</div>
	                </div>
	            </div>
			</div>
		  	<!-- Footer -->
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
		</div>
	</body>
</html>