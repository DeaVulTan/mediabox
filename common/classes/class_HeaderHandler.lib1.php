<?php
/**
 * Class Handle the right navigation and header related functions
 *
 * PHP version 5.0
 *
 * @category	###Framework###
 * @package		###Common/Classes###
 * @author		selvaraj_47ag04
 * @copyright 	Copyright (c) 2008 {@link http://www.mediabox.uz Uzdc Infoway}
 * @license		http://www.mediabox.uz Uzdc Infoway Licence
 * @version		SVN: $Id : $
 * @since 		2005-22-05
 */
class HeaderHandler extends FormHandler
	{
		public $_navigationArr = array();
		public $_clsActiveLink = ' clsActiveLink';
		public $_clsInActiveLink = ' clsInActiveLink';
		public $_currentPage = '';

		public function HeaderHandler()
			{
				global $CFG, $LANG, $db;
				$this->setFormField('config_file_name', '');
				$this->setFormField('module', '');
				$this->setFormField('action', '');
				$this->setFormField('folder', '');
				$this->setFormField('act', '');
				$this->setFormField('uname', '');
				$this->setFormField('browse', '');
				$this->setFormField('srch', '');
				$this->setFormField('group_id', '');
				$this->setFormField('user_id', '');
				$this->setFormField('action', '');
				$this->setFormField('mode', '');
				$this->setFormField('cid', '');
				$this->setFormField('main_title', '');
				$this->sanitizeFormInputs($_REQUEST);
				//frequently used objects initialized
				if(isset($db) and $db)
					$this->setDBObject($db);
				$this->makeGlobalize($CFG, $LANG);
				//for highlighting
				$this->_currentPage = strtolower($this->CFG['html']['current_script_name']);
			}

		/**
		 * HeaderHandler::populateUserName()
		 *
		 * @return
		 */
		public function populateUserName()
			{
				if(!isMember())
					return;

				return str_replace('VAR_USER_NAME', $this->CFG['user']['name'], $this->LANG['header_welcome_username']);
			}

		/**
		 *
		 * @return 		void
		 * @access 		public
		 */
		public function populateLoginFormFields($obj)
			{
				$_SESSION['popup_login_redirect_url'] = urlencode(getCurrentUrl(true));
				$login_field = 'username';
				if($this->CFG['admin']['email_using_to_login'])
					$login_field = 'email';
				$obj->setFormField('user_name', '');
				$obj->setFormField('password', '');
				$obj->setFormField('remember', '');
				$obj->setFormField('url', '');
				$obj->setPageBlockShow('form_login');
				$obj->form_login['login_field'] = $login_field;
				$obj->form_login['login_field_label'] = $this->LANG['common_'.$login_field];
			}

		/**
		 * HeaderHandler::populateLanguageDetails()
		 *
		 * @return
		 */
		public function populateLanguageDetails()
			{
				global $smartyObj;
				$arr = array();
				foreach($this->CFG['lang']['available_languages'] as $key=>$value)
					{
						if($this->CFG['published_languages'][$key] == 'true')
							{
								$arr[$key] = $value;
							}
					}
				//show language switcher if we have more than 1 published language
				if($this->CFG['lang']['is_multi_lang_support'] AND count($arr) > 1)
					$show_language = true;
				else
					$show_language = false;
				$smartyObj->assign('smarty_available_languages', $arr);
				$smartyObj->assign('show_languages', $show_language);
			}

		/**
		 * HeaderFormHandler::chooseLang()
		 *
		 * @param mixed $lang
		 * @return
		 */
		public function chooseLang($lang)
			{
			   	$url=getCurrentUrl(false);
			   	$url .= '?lang='.$lang;
				foreach($_GET as $key=>$value)
			   		{
			   			if($key!='lang')
			   				{
			   					$url .= '&'.$key.'='.$value;
							}
					}
			   return $url;
			}

		/**
		 * HeaderHandler::populateTemplateDetails()
		 *
		 * @return
		 */
		public function populateTemplateDetails()
			{
				global $smartyObj;

				////assign for populate the template list in header
				if(isset($CFG['site']['module_name']) and in_array($CFG['site']['module_name'], array('forum')))
					{
						$root_dir = $this->CFG['site']['project_path']. $CFG['site']['module_name'].'/design/templates/';
					}
				else
					{
						$root_dir = $this->CFG['site']['project_path']. 'design/templates/';
					}
				$dir_array = readDirectory($root_dir, 'dir');
				$template_arr = array();
				$style_count_arr = 0;
				foreach($dir_array as $template)
					{
						if(!in_array($template, $this->CFG['html']['template']['allowed']))
     						continue;

                              $css_array = readDirectory($root_dir.$template.'/root/css/', 'dir');
                            // echo '<pre>';print_r($this->CFG['html']['stylesheet']['allowed']);echo '</pre>';
                              //echo '<pre>';print_r($css_array);echo '</pre>';exit;
						foreach($css_array as $css)
							{
								if(!in_array($template.'__'.$css.'.css', $this->CFG['html']['stylesheet']['allowed']))
     								continue;

                                 $template_arr[$template][] = $css;
                                 $style_count_arr++;
							}
					}
				$smartyObj->assign('template_arr', $template_arr);
				if(isset($template_arr[$this->CFG['html']['template']['default']]))
					{
						$smartyObj->assign('default_css_list_arr', $template_arr[$this->CFG['html']['template']['default']]);
					}
				else
					{
						$smartyObj->assign('default_css_list_arr', array());
					}
				//if template count is 1 and style count is also 1 need not show the template switcher
				if($style_count_arr <= 1)
					{
						$show_templates = false;
					}
				else
					{
						$show_templates = true;
					}
				$smartyObj->assign('show_templates', $show_templates);
			}

		/**
		 * HeaderHandler::getNavClass()
		 *
		 * @param mixed $identifier
		 * @return
		 */
		public function getNavClass($identifier)
			{
				$identifier = strtolower($identifier);
				return isset($this->_navigationArr[$identifier])?$this->_navigationArr[$identifier]:$this->_clsInActiveLink;
			}

		/**
		 * HeaderHandler::populateDefaultMemberNavigation()
		 *
		 * @return
		 */
		public function populateDefaultMemberNavigation()
			{
				global $smartyObj;

				if(!$this->chkAllowedModule(array()))
					return;

				//main links
				$this->_navigationArr['left_'.$this->_currentPage] = $this->_clsActiveLink;

				//edit profile sublinks
				$editProfile_arr = array('editprofile', 'mysettings', 'myevent', 'profile', 'friends', 'befriends');
				if(in_array($this->_currentPage, $editProfile_arr))
					{
						if((!in_array($this->_currentPage, array('profile', 'friends', 'befriends'))) or (in_array($this->_currentPage, array('profile', 'friends', 'befriends')) and $this->getFormField('uname')==$this->CFG['user']['user_name']))
							{
								$this->_navigationArr['left_editprofile_head'] = $this->_clsActiveLink;
							}
					}

				// for members sublinks
				if($this->_currentPage=='profile' and $this->getFormField('uname')!=$this->CFG['user']['user_name'])
					{
						$this->_navigationArr['left_userprofiles'] = $this->_clsActiveLink;
					}

				//eventManagement sublinks Member
				$eventManagement_arr = array('eventlist', 'eventadd', 'eventview');
				if(in_array($this->_currentPage, $eventManagement_arr))
					{
						$this->_navigationArr['left_eventmanagement_head'] = $this->_clsActiveLink;
					}

				if($this->chkAllowedModule(array('mail')))
					{
						//for mail module highlighting
						$mail_arr = array('mail', 'mailread', 'mailcompose');
						if(in_array($this->_currentPage, $mail_arr))
							{
								$this->_navigationArr['left_mail'] = $this->_clsActiveLink;
							}

						//edit config sublinks
						if($this->getFormField('folder'))
							{
								$page = $this->_currentPage.'_'.strtolower($this->getFormField('folder'));
								if($this->_currentPage == 'mailread')
									{
										$page = 'mail_'.strtolower($this->getFormField('folder'));
									}
								$this->_navigationArr['left_'.$page] = $this->_clsActiveLink;
							}
					}
				if(isMember())
					{
						$this->populateDefaultMemberNavigation['url']['friends'] = getUrl('friends', '?uname='.$this->CFG['user']['user_name'], $this->CFG['user']['user_name'].'/friends/', 'members');
						$this->populateDefaultMemberNavigation['url']['befriends'] = getUrl('befriends', '?uname='.$this->CFG['user']['user_name'], $this->CFG['user']['user_name'].'/befriends/', 'members');
					}
				$smartyObj->display('../general/header_links.tpl');
			}

		/**
		 * HeaderHandler::populateTopNavigation()
		 *
		 * @return
		 */
		public function populateTopNavigation()
			{
				global $smartyObj;

				if(!$this->chkAllowedModule(array()))
					return;
				//main links
				$this->_navigationArr['left_'.$this->_currentPage] = $this->_clsActiveLink;

			}

		/**
		 * HeaderHandler::populateAdminTopNavigation()
		 *
		 * @return
		 */
		public function populateAdminTopNavigation()
			{
				global $smartyObj;

				if(!$this->chkAllowedModule(array()))
					return;

				//main links
				$this->_navigationArr['left_'.$this->_currentPage] = $this->_clsActiveLink;

				$smartyObj->display('../admin/top_navigation_links.tpl');
			}

		/**
		 * HeaderHandler::populateAdminDefaultLeftNavigation()
		 *
		 * @return
		 */
		public function populateAdminDefaultLeftNavigation()
			{
				global $smartyObj;

				if(!$this->chkAllowedModule(array()))
					return;

				//main links
				$this->_navigationArr['left_'.$this->_currentPage] = $this->_clsActiveLink;
				//edit config sublinks
				if($this->getFormField('config_file_name'))
					{
						$page = $this->_currentPage.'_'.strtolower($this->getFormField('config_file_name'));
						$this->_navigationArr['left_'.$page] = $this->_clsActiveLink;
						if($this->_currentPage=='editconfig')
							{
								$this->_navigationArr['left_'.$this->_currentPage] = $this->_clsInActiveLink;
								$menuLink = 'edit'.$this->getFormField('config_file_name');
								$this->_navigationArr['left_'.$menuLink] = $this->_clsActiveLink;
							}
					}
								//code added to highlight different menus when editting the config data
				if($this->_currentPage=='editconfigdata')
					{
						$module = ($this->getFormField('module')) ? $this->getFormField('module') : 'general';
						$this->_navigationArr['left_'.$this->_currentPage] = $this->_clsInActiveLink;
						$menuLink = 'editconfigdata_'.$module;
						$this->_navigationArr['left_'.$menuLink] = $this->_clsActiveLink;
					}


				if($this->_currentPage=='managequestions')
					{
					   $this->_navigationArr['left_addprofilecategory'] = $this->_clsActiveLink;
					}
				elseif($this->_currentPage=='editprofile' or $this->_currentPage=='viewprofile')
					{
					   $this->_navigationArr['left_membermanage'] = $this->_clsActiveLink;
					}
				elseif($this->_currentPage=='manageprofileblock')
					{
						 $this->_navigationArr['left_reorderprofileblock'] = $this->_clsActiveLink;
					}

				elseif($this->_currentPage=='newsletterview')
					{
						 $this->_navigationArr['left_addnewsletter'] = $this->_clsActiveLink;
					}
				/*elseif($this->_currentPage=='newsletterarchive')
					{
						 $this->_navigationArr['left_addnewsletter'] = $this->_clsActiveLink;
					}*/

				//edit config sublinks
				if($this->getFormField('act'))
					{
						$page = $this->_currentPage.'_'.strtolower($this->getFormField('act'));
						$this->_navigationArr['left_'.$page] = $this->_clsActiveLink;
					}

				if($this->getFormField('mode'))
					{
						$page = $this->_currentPage.'_'.strtolower($this->getFormField('mode'));
						$this->_navigationArr['left_'.$page] = $this->_clsActiveLink;
					}
				//for aco section module highlighting
				$acosection_arr = array('gaclacoobject');
				if(in_array($this->_currentPage, $acosection_arr))
					{
						$this->_navigationArr['left_gaclacosections'] = $this->_clsActiveLink;
					}
				if($this->getFormField('action'))
					{
						$page = $this->_currentPage.'_'.strtolower($this->getFormField('action'));
						$page = ($page == $this->_currentPage.'_edit')?$this->_currentPage.'_add':$page;
						$this->_navigationArr['left_'.$page] = $this->_clsActiveLink;
						 if($this->_currentPage=='usertype' or $this->_currentPage=='announcement' or $this->_currentPage=='menumanagement')
						 	{
								$this->_navigationArr['left_'.$this->_currentPage] = $this->_clsInActiveLink;
							}
					}
				//  Module Check
				$module_function_check_passed_arr= array();
				foreach($this->CFG['site']['modules_arr'] as $value)
					{
					   if(chkAllowedModule(array(strtolower($value))))
							{
								$module_function_check_passed_arr[$value] = false;
							   	$function_name='populateAdmin'.ucfirst($value).'LeftNavigation';
							   	if(function_exists($function_name))
							   		$module_function_check_passed_arr[$value] = true;
							}
					}
				$smartyObj->assign('module_function_check_passed_arr', $module_function_check_passed_arr);
				$smartyObj->display('../admin/left_navigation_links.tpl');
				//  Module function call..
			   	foreach($this->CFG['site']['modules_arr'] as $value)
					{
					   if(chkAllowedModule(array(strtolower($value))))
							{
								$function_name='populateAdmin'.ucfirst($value).'LeftNavigation';
							   	if($module_function_check_passed_arr[$value])
									$function_name($this);
							}
					}
			}

		/**
		 * HeaderHandler::getMetaKeywords()
		 *
		 * @return
		 */
		public function getMetaKeywords()
			{
				return (isset($this->LANG['meta_'.$this->_currentPage.'_keywords']) AND $this->LANG['meta_'.$this->_currentPage.'_keywords'])?$this->LANG['meta_'.$this->_currentPage.'_keywords']:$this->CFG['html']['meta']['keywords'];
			}

		/**
		 * HeaderHandler::getMetaDescription()
		 *
		 * @return
		 */
		public function getMetaDescription()
			{
				return (isset($this->LANG['meta_'.$this->_currentPage.'_description']) AND $this->LANG['meta_'.$this->_currentPage.'_description'])?$this->LANG['meta_'.$this->_currentPage.'_description']:$this->CFG['html']['meta']['description'];
			}

		/**
		 * HeaderHandler::getPageTitle()
		 *
		 * @return
		 */
		public function getPageTitle()
			{
				if(isset($this->LANG['meta_'.$this->_currentPage.'_title']) AND $this->LANG['meta_'.$this->_currentPage.'_title'])
					{
						return $this->buildDisplayText($this->LANG['meta_'.$this->_currentPage.'_title']);
					}
				else
					{
						return $this->CFG['site']['title'];
					}
			}

		/**
		 * HeaderHandler::isAffiliateMember()
		 *
		 * @return
		 */
		public function isAffiliateMember()
			{
				$sql = 'SELECT is_affiliate_type FROM '.$this->CFG['db']['tbl']['users'].
						' WHERE user_id = '.$this->dbObj->Param('user_id');
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->CFG['user']['user_id']));
				    if (!$rs)
					    trigger_db_error($this->dbObj);

				if($row = $rs->FetchRow())
					{
						if ($row['is_affiliate_type'] == 'Yes')
							 {
								//check if the user has any ad set
								return true;
							}
						else
							return false;
					}
				else
						return false;
			}

		/**
		 * HeaderHandler::setMyRelations()
		 *
		 * @return
		 */
		public function setMyRelations()
			{
				$userId = $this->CFG['user']['user_id'];
				$sql = 'SELECT relation_id, relation_name ,total_contacts'.
						' FROM '.$this->CFG['db']['tbl']['friends_relation_name'].
						' where user_id = '.$this->dbObj->Param($userId).
						' ORDER BY relation_name ';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($userId));
			    if (!$rs)
				    trigger_db_error($this->dbObj);

				$row = array();
				$relation = array();
				$relationCount = array();

				if ($rs->PO_RecordCount())
					{
			    		while($row = $rs->FetchRow())
						    {
								$relation[$row['relation_id']] = $row['relation_name'];
								$relationCount[$row['relation_id']] = $row['total_contacts'];
	 					    }
					}
				$this->myRelation = $relation;
				$this->myRelationCount = $relationCount;
			}

		/**
		 * HeaderHandler::includeJsFiles()
		 *
		 * @return
		 */
		public function includeJsFiles()
			{
				$this->loadJsScriptVariables();
				$this->includeJSLanguageFile();
?>
				<script language="javascript" type="text/javascript" src="<?php echo $this->CFG['site']['url'];?>js/lib/jquery.js"></script>
				<link rel="stylesheet" type="text/css" href="<?php echo $this->CFG['site']['url'];?>js/lib/jQuery_plugins/ui-lightness/jquery.ui.all.css" media="screen"/>
				  <script language="javascript" type="text/javascript">
					//Initialize Jquery in $Jq variable
					var $Jq = jQuery.noConflict();
				</script>
				<script language="javascript" type="text/javascript" src="<?php echo $this->CFG['site']['url'];?>js/lib/jQuery_plugins/jquery.pngfix.js"></script>
				<script language="javascript" type="text/javascript" src="<?php echo $this->CFG['site']['url'];?>js/lib/jQuery_plugins/jquery.tooltip.js"></script>
				<script language="javascript" type="text/javascript" src="<?php echo $this->CFG['site']['url'];?>js/lib/jQuery_plugins/jquery.ui.core.js"></script>
				<script language="javascript" type="text/javascript" src="<?php echo $this->CFG['site']['url'];?>js/lib/jQuery_plugins/jquery.ui.widget.js"></script>
				<script language="javascript" type="text/javascript" src="<?php echo $this->CFG['site']['url'];?>js/lib/jQuery_plugins/jquery.ui.mouse.js"></script>
				<script language="javascript" type="text/javascript" src="<?php echo $this->CFG['site']['url'];?>js/lib/jQuery_plugins/jquery.ui.draggable.js"></script>
				<script language="javascript" type="text/javascript" src="<?php echo $this->CFG['site']['url'];?>js/lib/jQuery_plugins/jquery.ui.sortable.js"></script>
				<script language="javascript" type="text/javascript" src="<?php echo $this->CFG['site']['url'];?>js/lib/jQuery_plugins/jquery.ui.position.js"></script>
				<script language="javascript" type="text/javascript" src="<?php echo $this->CFG['site']['url'];?>js/lib/jQuery_plugins/jquery.ui.dialog.js"></script>
				<script language="javascript" type="text/javascript" src="<?php echo $this->CFG['site']['url'];?>js/lib/jQuery_plugins/jquery.ui.slider.js"></script>
				<script language="javascript" type="text/javascript" src="<?php echo $this->CFG['site']['url'];?>js/lib/jQuery_plugins/jquery.autocomplete.js"></script>
				<script language="javascript" type="text/javascript" src="<?php echo $this->CFG['site']['url'];?>js/lib/jQuery_plugins/jquery.jeditable.js"></script>
				<script language="javascript" type="text/javascript" src="<?php echo $this->CFG['site']['url'];?>js/lib/jQuery_plugins/jquery.string.js"></script>
				<script language="javascript" type="text/javascript" src="<?php echo $this->CFG['site']['url'];?>js/lib/jQuery_plugins/jquery.json.js"></script>
				<script language="javascript" type="text/javascript" src="<?php echo $this->CFG['site']['url'];?>js/lib/jQuery_plugins/jquery.fancybox.js"></script>
<?php
				//if(!in_array($this->_currentPage, array('index', 'myhome', 'myprofile')))

				if(isset($this->CFG['site']['is_module_page']) AND $this->CFG['site']['is_module_page']=='music' AND !in_array($this->_currentPage, array('index', 'myhome', 'myprofile','musicuploadpopup')))
					{
?>
				<script language="javascript" type="text/javascript" src="<?php echo $this->CFG['site']['url'];?>js/lib/jQuery_plugins/jquery.ui.minmax.js"></script>
<?php
					}
?>
				<script language="javascript" type="text/javascript" src="<?php echo $this->CFG['site']['url'];?>js/lib/jQuery_plugins/jquery.ui.tabs.js"></script>
				<script language="javascript" type="text/javascript" src="<?php echo $this->CFG['site']['url'];?>js/lib/jQuery_plugins/jquery.effect.shake.js"></script>
				<link rel="stylesheet" type="text/css" href="<?php echo $this->CFG['site']['url'];?>js/lib/jQuery_plugins/jScrollPane/jScrollPane.css"/>
				<script language="javascript" type="text/javascript" src="<?php echo $this->CFG['site']['url'];?>js/lib/jQuery_plugins/jquery.mousewheel.js"></script>
				<script language="javascript" type="text/javascript" src="<?php echo $this->CFG['site']['url'];?>js/lib/jQuery_plugins/jScrollPane.js"></script>
				<script language="javascript" type="text/javascript" src="<?php echo $this->CFG['site']['url'];?>js/functions.js"></script>
				<script language="javascript" type="text/javascript" src="<?php echo $this->CFG['site']['url'];?>js/brwsniff.js"></script>

<?php
				if($this->CFG['feature']['jquery_validation'])
					{
?>
				<script language="javascript" type="text/javascript" src="<?php echo $this->CFG['site']['url'];?>js/lib/jQuery_plugins/jquery.validate.js"></script>
				<script language="javascript" type="text/javascript" src="<?php echo $this->CFG['site']['url'];?>js/lib/jQuery_plugins/jquery.validation.rules.js"></script>
<?php
					}
				if(in_array($this->_currentPage, array('viewprofile','profilecomments','profilebasic', 'profileinfo', 'contactus', 'reportbugs', 'friendadd', 'membersinvite', 'adddiscussiontitle', 'boards', 'solutions')))
					{
?>				<link rel="stylesheet" type="text/css" href="<?php echo $this->CFG['site']['url'];?>js/lib/jQuery_plugins/ui-lightness/jquery.inputlimiter.css" media="screen"/>
				<script language="javascript" type="text/javascript" src="<?php echo $this->CFG['site']['url'];?>js/lib/jQuery_plugins/jquery.inputlimiter.js"></script>
<?php
					}
				if(in_array($this->_currentPage, array('editconfigdata','indexmediatabsettings', 'viewvideo')))
					{
?>
				<script language="javascript" type="text/javascript">
					$Jq(function() {
						$Jq("#tabsview").tabs({
							ajaxOptions: {
								error: function(xhr, status, index, anchor) {
									Jq(anchor.hash).html("Couldn't load this tab. We'll try to fix this as soon as possible. If this wouldn't be a demo.");
								}
							}
						});
					});
				</script>
<?php
					}
				if($this->CFG['admin']['calendar_page'])
					{
?>
				<script language="javascript" type="text/javascript" src="<?php echo $this->CFG['site']['url'];?>js/lib/jQuery_plugins/jquery.ui.datepicker.js"></script>
<?php
					}
				if($this->_currentPage != 'managequestions')
					{
?>
				<script language="javascript" type="text/javascript" src="<?php echo $this->CFG['site']['url'];?>js/script.js"></script>
<?php
					}
				if(in_array($this->_currentPage, array('devmanageconfig')))
					{
?>
				<script language="javascript" type="text/javascript">
					$Jq(document).ready(function(){
						/* drop down menu with click */
						$Jq(document).click(dropDownLinkClick);
					});
				</script>
<?php
					}
				if(in_array($this->_currentPage, array('myhome', 'profilecamavatar', 'index')))
					{
?>
				<link rel="stylesheet" type="text/css" href="<?php echo $this->CFG['site']['url'];?>design/templates/<?php echo $this->CFG['html']['template']['default'];?>/root/css/<?php echo $this->CFG['html']['stylesheet']['screen']['default'];?>/carousel/tango/skin.css" />
				<script language="javascript" type="text/javascript" src="<?php echo $this->CFG['site']['url'];?>js/lib/jQuery_plugins/jquery.jcarousel.js"></script>
<?php
					}
				if(in_array($this->_currentPage, array('memberslist')))
					{
?>
				<script language="javascript" type="text/javascript" language="javascript" src="<?php echo $this->CFG['site']['url'];?>js/videoDetailsToolTip.js"></script>
<?php
					}
				if(in_array($this->_currentPage, array('translate', 'verifytranslation')))
					{
?>
				<script language="javascript" type="text/javascript" src="<?php echo $this->CFG['site']['url'].'js/translate.js';?>"></script>
<?php
					}
				if(in_array($this->_currentPage, array('viewfriends', 'myfriends')))
					{
?>
				<script language="javascript" type="text/javascript" src="<?php echo $this->CFG['site']['url']; ?>js/floating-gallery.js"></script>
<?php
					}
				if(in_array($this->_currentPage, array('profilebackground', 'profiletheme')))
					{
?>
				<script language="javascript" type="text/javascript" src="<?php echo $this->CFG['site']['url'];?>js/lib/jQuery_plugins/mColorPicker/javascripts/mColorPicker.js"></script>
<?php
					}
				if(in_array($this->_currentPage, array('selectusernames')))
					{
?>
				<script language="javascript" type="text/javascript" src="<?php echo $this->CFG['site']['url'];?>js/selectUsernames.js"></script>
<?php
					}
				if(in_array($this->_currentPage, array('menumanagement', 'reorderprofileblock', 'viewprofile', 'myprofile', 'indexcontentglidersettings')))
					{
?>
				<link rel="stylesheet" type="text/css" href="<?php echo $this->CFG['site']['url'];?>design/templates/<?php echo $this->CFG['html']['template']['default'];?>/admin/css/fonts-min.css" />
				<link rel="stylesheet" type="text/css" href="<?php echo $this->CFG['site']['url'];?>design/templates/<?php echo $this->CFG['html']['template']['default'];?>/admin/css/reOrder.css" />
				<script language="javascript" type="text/javascript" src="<?php echo $this->CFG['site']['url'];?>js/yahoo-dom-event.js"></script>
				<script language="javascript" type="text/javascript" src="<?php echo $this->CFG['site']['url'];?>js/animation-min.js"></script>
				<script language="javascript" type="text/javascript" src="<?php echo $this->CFG['site']['url'];?>js/dragdrop-min.js"></script>
				<script language="javascript" type="text/javascript" src="<?php echo $this->CFG['site']['url'];?>js/reOrder.js"></script>
<?php
					}
				if(in_array($this->_currentPage, array('activity', 'myhome')))
					{
?>
				<script language="javascript" type="text/javascript"	src="<?php echo $this->CFG['site']['url'];?>js/myHome.js"></script>
<?php
					}
				if(method_exists($this, 'getCurrentStatus'))
					{
?>
				<script language="javascript" type="text/javascript" src="<?php echo $this->CFG['site']['url'];?>js/online.js"></script>
				<script language="javascript" type="text/javascript"	src="<?php echo $this->CFG['site']['url'];?>js/memberStatus.js"></script>
				<script language="javascript" type="text/javascript">
					onlineTimer = setInterval('logInUser()', 10000);
					curStatus = '<?php echo $this->getCurrentStatus();?>';
				</script>
<?php
					}
				if (isset($this->headerBlock['navigationBar_js_allowed']) and $this->headerBlock['navigationBar_js_allowed'])
					{
?>
				<script language="javascript" type="text/javascript" src="<?php echo $this->CFG['site']['url'];?>js/navigationBar.js"></script>
<?php
					}
				else
					{
?>
				<script language="javascript" type="text/javascript" src="<?php echo $this->CFG['site']['url'];?>js/navigationBarShow.js"></script>
<?php
					}
?>
				<script language="javascript" type="text/javascript" src="<?php echo $this->CFG['site']['url'];?>js/menu.js"></script>
<?php
				//added for music module
				if(isset($this->CFG['site']['is_module_page']) AND $this->CFG['site']['is_module_page']=='music')
				{
?>
					<script language="javascript" type="text/javascript"	src="<?php echo $this->CFG['site']['music_url'];?>js/functions.js"></script>
<?php
				}
?>
<?php
				if($this->CFG['site']['jserror_block'])
					{
?>
				<script language="javascript" type="text/javascript">
					function blockError(){ return true; }
			        window.onerror = blockError;
				</script>
<?php
					}
			}

		/**
		 * HeaderHandler::loadJsScriptVariables()
		 *
		 * @return
		 */
		public function loadJsScriptVariables()
			{
				global $LANG_LIST_ARR

?>
				<script language="javascript" type="text/javascript">
					var LANG_STATUS_ERROR_MSG = '<?php echo $this->LANG['header_new_status_error_message']; ?>';
					var status_string_length = '<?php echo $this->CFG['admin']['status_message_text_length']; ?>';
					var status_string_total_length = '<?php echo $this->CFG['admin']['status_message_text_total_length']; ?>';
					var cfg_site_url = '<?php echo $this->CFG['site']['url'];?>';
					var cfg_site_name = '<?php echo $this->CFG['site']['name'];?>';
					var siteUserId='<?php echo $this->CFG['user']['user_id'];?>';
					var pageId='<?php echo $this->CFG['html']['page_id'];?>';
					var cfg_login_url = '<?php echo getUrl('login');?>';
					var replace_url = '<?php echo $this->CFG['site']['url'];?>login.php';
					var statusSettingUrl = '<?php echo getUrl('profilesettings');?>';
			        var logoutUrl = '<?php echo getUrl('logout', '', '', 'root');?>';
					var cfg_login_check_url = '<?php echo getUrl('logincheck');?>';
					var cfg_html_template_default = '<?php echo $this->CFG['html']['template']['default'];?>';
					var cfg_html_stylesheet_screen_default = '<?php echo $this->CFG['html']['stylesheet']['screen']['default'];?>';
					var LANG_LOADING = '<?php echo $this->LANG['common_loading']; ?>';
					var LANG_OR = '<?php echo $this->LANG['common_or']; ?>';
					var LANG_CLOSE = '<?php echo $this->LANG['common_close']; ?>';
					var LANG_CANCEL = '<?php echo $this->LANG['common_cancel']; ?>';
					var FLAG_SUCCESS = '<?php echo $this->LANG['common_cancel']; ?>';
					var template_default = '<?php echo $this->CFG['html']['template']['default']; ?>';
					var stylesheet_screen_default = '<?php echo $this->CFG['html']['stylesheet']['screen']['default']; ?>';
					var LANG_NEW_STATUS = '<?php echo $this->LANG['header_new_status']; ?>';
					var LANG_SETTINGS = '<?php echo $this->LANG['header_nav_profile_settings']; ?>';
					var LANG_LOGOUT = '<?php echo $this->LANG['header_logout_link']; ?>';
					var MY_PROFILE_URL = '<?php echo getUrl('myprofile', '', '', 'members');?>';
					var LANG_MY_PROFILE = '<?php echo $this->LANG['header_myprofilelinks_profile'];?>';
					var PROFILE_BASIC_URL = '<?php echo getUrl('profilebasic', '', '', 'members');?>';
					var LANG_PROFILE_BASIC = '<?php echo $this->LANG['header_myprofilelinks_profile_basic'];?>';
					var MY_VIDEOS_URL = '<?php if (chkAllowedModule(array('video'))) echo getUrl('videolist', '?pg=myvideos', 'myvideos/', '', 'video');?>';
					var LANG_MY_VIDEOS = '<?php if (chkAllowedModule(array('video'))) echo $this->LANG['header_myprofilelinks_videos'];?>';
					var LANG_JS_REQUIRED = '<?php echo $this->LANG['common_js_required'];?>';
					var LANG_JS_NUMBER = '<?php echo $this->LANG['common_js_number'];?>';
					var LANG_JS_DIGITS = '<?php echo $this->LANG['common_js_digits'];?>';
					var LANG_JS_ALPHA = '<?php echo $this->LANG['common_js_alpha'];?>';
					var LANG_JS_ALPHANUM = '<?php echo $this->LANG['common_js_alphanum'];?>';
					var LANG_JS_DATE = '<?php echo $this->LANG['common_js_date'];?>';
					var LANG_JS_EMAIL = '<?php echo $this->LANG['common_js_email'];?>';
					var LANG_JS_URL = '<?php echo $this->LANG['common_js_url'];?>';
					var LANG_JS_DATEAU = '<?php echo $this->LANG['common_js_dateau'];?>';
					var LANG_JS_CURRENCY_DOLLAR = '<?php echo $this->LANG['common_js_currency_dollar'];?>';
					var LANG_JS_SELECTION = '<?php echo $this->LANG['common_js_selection'];?>';
					var LANG_JS_ONE_REQUIRED = '<?php echo $this->LANG['common_js_select_one'];?>';
					var LANG_JS_err_tip_required = '<?php echo $this->LANG['common_err_tip_required'];?>';
					var LANG_JS_SUBSCRIBE = '<?php echo $this->LANG['common_subscribe'];?>';
					var LANG_JS_UNSUBSCRIBE = '<?php echo $this->LANG['common_unsubscribe'];?>';
					var LANG_JS_err_tip_country = '<?php echo $this->LANG['common_err_tip_country'];?>';
					var LANG_JS_err_tip_email = '<?php echo $this->LANG['common_err_tip_email'];?>';
					var LANG_JS_err_tip_date_format = '<?php echo $this->LANG['common_err_tip_date_invalid'];?>';
					var LANG_JS_err_tip_invalid_tag = '<?php echo $this->LANG['common_err_tip_invalid_tag'];?>';
					var LANG_JS_relation_name_length = '<?php echo $this->LANG['common_err_tip_relation_name_length'];?>';
					var LANG_JS_and = '<?php echo $this->LANG['common_and'];?>';
					var LANG_JS_common_remaining_char_count = '<?php echo addslashes($this->LANG['common_remaining_char_count']);?>';
					var LANG_JS_common_stop_typing_after_reached_limit = '<?php echo addslashes($this->LANG['common_stop_typing_after_reached_limit']);?>';
					var LANG_JS_common_allowed_char_limit = '<?php echo addslashes($this->LANG['common_allowed_char_limit']);?>';
					var member_manipulation_url = '<?php echo getUrl('memberhandling', '', '', 'members'); ?>';
					var LANG_JS_invalid_file_format= '<?php echo $this->LANG['common_err_tip_invalid_image_format'];?>';
					var LANG_JS_date_valid_format= '<?php echo $this->LANG['common_err_tip_date_invalid'];?>';
					var LANG_JS_time_valid_format= '<?php echo $this->LANG['common_err_tip_invalid_time_format'];?>';

					//added for datepicker
					var lang_js_datapicker_arr = new Array();
					lang_js_datapicker_arr['closeText'] = '<?php echo $this->LANG['datepicker_closeText'] ?>';
					lang_js_datapicker_arr['prevText'] = '<?php echo $this->LANG['datepicker_prevText'] ?>';
					lang_js_datapicker_arr['nextText'] = '<?php echo $this->LANG['datepicker_nextText'] ?>';

					var monthNamesShort_arr = new Array();
<?php
					if(isset($LANG_LIST_ARR['months']))
						{
		   					foreach ($LANG_LIST_ARR['months'] as $month_name)
		    				{
								print "monthNamesShort_arr.push(\"$month_name\" );";
							}
						}
					if(!$this->chkIsAdminSideIsViewed())
						{
?>
					/*var menu_channel_left_position = <?php echo $this->CFG['admin'][$this->CFG['html']['template']['default']]['menu_channel_left']; ?>;
					var menu_channel_top_position = <?php echo $this->CFG['admin'][$this->CFG['html']['template']['default']]['menu_channel_top']; ?>;
					var menu_more_left_position = <?php echo $this->CFG['admin'][$this->CFG['html']['template']['default']]['menu_more_left']; ?>;
					var menu_more_top_position = <?php echo $this->CFG['admin'][$this->CFG['html']['template']['default']]['menu_more_top']; ?>;
					var search_header_left_pos = <?php echo $this->CFG['admin'][$this->CFG['html']['template']['default']]['search_header_left']; ?>;
					var search_header_top_pos = <?php echo $this->CFG['admin'][$this->CFG['html']['template']['default']]['search_header_top']; ?>;
					var search_footer_left_pos = <?php echo $this->CFG['admin'][$this->CFG['html']['template']['default']]['search_footer_left']; ?>;
					var search_footer_top_pos = <?php echo $this->CFG['admin'][$this->CFG['html']['template']['default']]['search_footer_top']; ?>;*/
<?php
						}
					if(method_exists($this, 'displayStatusAsJsObject'))
						{
?>
					var status_all='<?php echo $this->displayStatusAsJsObject();?>';
<?php
						}
?>
				</script>
<?php
					//added for music module
					if(isset($this->CFG['site']['is_module_page']) AND $this->CFG['site']['is_module_page']=='discussions')
					{
						populateDiscuzzJsVariables();
						populateDiscuzzJsVariables2();
					}
			}

		/**
		 * HeaderFormHandler::getSiteLogoAndFavicon()
		 * To get site and favicon based on type
		 * @param string $dir_name, string $type
		 * @return string
		 */
		public function getSiteLogoAndFavicon($dir_name, $type)
		{
			$image_extn='';
			if(is_dir($dir_name))
			{
				if ($hndDir = opendir($dir_name))
				{
					while (false !== ($strFilename = readdir($hndDir)))
					{
						if ($strFilename != "." && $strFilename != "..")
						{
							$log_file_name = $strFilename;
							$extern = substr($log_file_name,strrpos($log_file_name, '.')+1);
			 				$original_file_name = substr($log_file_name, 0,strrpos($log_file_name, '.'));
			 				if($original_file_name == 'logo' and $type == 'logo')
			 				{
								$image_extn =  $extern;
							}
							if($original_file_name == 'favicon' and $type == 'favicon')
			 				{
								$image_extn =  $extern;
							}
						}
					}
					closedir($hndDir);
					return $image_extn;
				}
			}
		}
		/**
		* HeaderFormHandler::displayEnabledModuleUploadLinks()
		* To Enable module upload link.
		* @param
		* @return
		*/
		public function displayEnabledModuleUploadLinks()
		{
			// Check Module Upload
			$displayModuleUploadLinks_val = '';
			$hideModuleUploadLinksArr = array("blog", "article", "discussions");
			foreach($this->CFG['site']['modules_arr'] as $value)
			{
				if(chkAllowedModule(array(strtolower($value))))
				{
					if (!in_array($value,$hideModuleUploadLinksArr, TRUE))
					{
						$displayModuleUploadLinks_val .= '<li class="cls'.$value.'UploadLink"><a href="'.getUrl($value.'uploadpopup', '', '', 'members', $value).'">'.$this->LANG['common_'.$value.'_upload'].'</a></li>';
					}
				}
			}
			return $displayModuleUploadLinks_val;
		}
	}
?>
