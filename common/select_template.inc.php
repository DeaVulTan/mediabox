<?php
/**
 * ###Add file short description###
 *
 * ###Add file long description###
 *
 * PHP version 5.0
 *
 * @category	###Framework###
 * @package		###Common/template###
 * @author 		manonmani_51ag05
 * @copyright 	Copyright (c) 2008 {@link http://www.mediabox.uz Uzdc Infoway}
 * @license		http://www.mediabox.uz Uzdc Infoway Licence
 * @version		Release: @package_version@
 * @since 		2005-09-28
 * @todo optimize conditions
 */
//detect requested template
$CFG['html']['template']['temp_default'] = $requested_template = $CFG['html']['template']['default'];
$CFG['html']['stylesheet']['screen']['temp_default'] = $requested_style = $CFG['html']['stylesheet']['screen']['default'];
$is_set_cookie_session = false;
if (!empty($_GET['template']))
	{
		$array = explode('__', $_GET['template']);
		$requested_template = $array[0];
		$requested_style = $array[1];
		$is_set_cookie_session = true;
	}
else if (!empty($_POST['template']))
	{
		$array = explode('__', $_POST['template']);
		$requested_template = $array[0];
		$requested_style = $array[1];
		$is_set_cookie_session = true;
	}
else if (!empty($_COOKIE['template']) and !empty($_COOKIE['style']))
	{
		if(in_array($_COOKIE['template'].'__'.$_COOKIE['style'].'.css', $CFG['html']['stylesheet']['allowed']))
			{
				$requested_template = $_COOKIE['template'];
				$requested_style = $_COOKIE['style'];
			}
	}
else if (!empty($_SESSION['user']['pref_template']) and !empty($_SESSION['user']['pref_style']))
	{
		if(in_array($_SESSION['user']['pref_template'].'__'.$_SESSION['user']['pref_style'].'.css', $CFG['html']['stylesheet']['allowed']))
			{
				$requested_template = $_SESSION['user']['pref_template'];
				$requested_style = $_SESSION['user']['pref_style'];
			}
	}

/**
 * checkAndChangeTemplate()
 *  Check the current Template and screen and change if required
 *
 * @param string $requested_template
 * @param string $requested_style
 * @param boolean $session_enable
 * @return void
 */
function checkAndChangeTemplate($requested_template, $requested_style, $session_enable=false)
	{
		global $CFG;
  		if (is_dir($CFG['site']['project_path'].'design/templates/'.$requested_template.'/')
		  	and is_file($CFG['site']['project_path'].'design/templates/'.$requested_template.'/root/css/'.$requested_style.'/general.css'))
			{
				$CFG['html']['template']['default'] = $requested_template;
				$CFG['html']['stylesheet']['screen']['default'] = $requested_style;
				$CFG['html']['stylesheet']['screen']['default_file']=$requested_style;
				//If module page is accessed change the template to available template and available css
				if(!empty($CFG['site']['is_module_page']))
					{
						//check whether directory exists or not for the current module & current template
						$template_dir_module = $CFG['site']['project_path'].$CFG['site']['is_module_page'].
													'/design/templates/'.$CFG['html']['template']['default'].'/root/';
						if(!is_dir($template_dir_module))
							{
								foreach($CFG['html']['template']['allowed'] as $available_template)
									{
										$available_template_dir = $CFG['site']['project_path'].$CFG['site']['is_module_page'].
																		'/design/templates/'.$available_template.'/root/';
										if(is_dir($available_template_dir))
											{
												$CFG['html']['template']['default'] = $available_template;
												foreach($CFG['html']['stylesheet'][$available_template]['allowed'] as $available_css)
													{
														$available_css_path  = $CFG['site']['project_path'].$CFG['site']['is_module_page'].
																					'/design/templates/'.$available_template.'/root/css/'.$available_css.'/';
														if(is_dir($available_css_path))
															{
																$CFG['html']['stylesheet']['screen']['default'] = $available_css;
																break;
															}

													}
											}
									}
							}
					}

				if($session_enable)
					{
						//set cookie and session...
						setcookie('template', $requested_template, time()+ 4320000, '/'); //expire in 50 days (50x24x60x60)
						$_SESSION['user']['pref_template'] = $requested_template;

						//set cookie and session...
						setcookie('style', $requested_style, time()+ 4320000, '/'); //expire in 50 days (50x24x60x60)
						$_SESSION['user']['pref_style'] = $requested_style;
					}
			}
	}

/**
 * loadAdminTemplateAndScreen()
 *   CHECK AND CHANGE THE ADMIN TEMPLATE SETTINGS (TEMPLATE, SCREEN, DEFAULT FILE)
 *
 * @return
 */
function loadAdminTemplateAndScreen()
	{
		global $CFG;
		$url_arr = explode('/', $_SERVER['REQUEST_URI']);
		if(in_array('admin', $url_arr))
			{
				$CFG['html']['template']['default'] = 'default';
				$CFG['html']['stylesheet']['screen']['default'] = 'screen_grey';
				$CFG['html']['stylesheet']['screen']['default_file'] = 'screen_grey';
				return true;
			}
		else
			return false;
	}

if ($is_set_cookie_session or $requested_template!=$CFG['html']['template']['default']
	or $requested_style!=$CFG['html']['stylesheet']['screen']['default'])
	{
		checkAndChangeTemplate($requested_template, $requested_style, true);
	}
else
	{
		checkAndChangeTemplate($requested_template, $requested_style);
	}

//To change the admin template settings
loadAdminTemplateAndScreen();
?>
