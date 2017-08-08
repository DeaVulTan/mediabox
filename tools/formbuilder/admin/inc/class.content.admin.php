<?php
/**
 * FireForm is a web based form builder enpowed by jquery javascript library and PHP
 * We are specilized in Website Development, Online Survey Creation, Online Shopping Site Design, 
 * Please contact me if you need any such web-based information system 
 * my email address ccc19800408-phpletter(@)yahoo(dot)com(dot)cn
 * please replace (@) with @, (dot) with . when sending email to me
 * thanks.
 * 
 * @author logan cai 
 * @package FireForm a Ajax Form Builder
 * @version 1.0
 * 
 *
 */
	include_once(DIR_INC_FF . 'class.content.base.php');
	class ContentAdmin extends ContentBase 
	{
		function __construct()
		{
			global $auth;
			parent::__construct();

			if($auth->isLogin())
			{
				if($auth->isSuperAdmin())
				{
					$this->setMenus(
						array(
							TAB_FORM=>array
								(
									
									'title'=>L_TAB_FORM, 
									'url'=>URL_SITE_ADMIN_INDEX . '?tab=' . TAB_FORM, 
									'active'=>(isset($_GET['tab']) && $_GET['tab'] == TAB_FORM?true:false),
									
								),
							

							TAB_USER=>array
								(
									
									'title'=>L_TAB_USER, 
									'url'=>URL_SITE_ADMIN_INDEX . '?tab=' . TAB_USER, 
									'active'=>(isset($_GET['tab']) && $_GET['tab'] == TAB_USER?true:false),
									
								),	
							TAB_INFO=>array
								(
									
									'title'=>L_TAB_INFO, 
									'url'=>URL_SITE_ADMIN_INDEX . '?tab=' . TAB_INFO, 
									'active'=>(isset($_GET['tab']) && $_GET['tab'] == TAB_INFO?true:false),
									
								),																
							)
						)
					;					
				}else 
				{
					
					$this->setMenus(
						array(
							TAB_FORM=>array
								(
									
									'title'=>L_TAB_FORM, 
									'url'=>URL_SITE_ADMIN_INDEX . '?tab=' . TAB_FORM, 
									'active'=>(isset($_GET['tab']) && $_GET['tab'] == TAB_FORM?true:false),
									
								),
							TAB_INFO=>array
								(
									
									'title'=>L_TAB_INFO, 
									'url'=>URL_SITE_ADMIN_INDEX . '?tab=' . TAB_INFO, 
									'active'=>(isset($_GET['tab']) && $_GET['tab'] == TAB_INFO?true:false),
									
								),																	
							)
						)
					;					
				}
				
				//check if this person is permitted to visit this tab
				if(isset($_GET['tab']) && array_key_exists($_GET['tab'], $this->getMenus()))
				{
					//check if this persion is permitted to access present module and action
					if(!empty($_GET['module']) && !empty($_GET['action']))
					{						
						$this->setPage(DIR_ADMIN_CONTENT_FF . $_GET['tab'] . DIRECTORY_SEPARATOR . clearFileName($_GET['module']) . "_" . clearFileName($_GET['action']) . '.php');
						
						$this->setModule($_GET['module']);
						$this->setAction($_GET['action']);
					}elseif(!empty($_GET['module']))
					{
						$this->setModule($_GET['module']);
						$this->setPage(DIR_ADMIN_CONTENT_FF . $_GET['tab'] . DIRECTORY_SEPARATOR . clearFileName($_GET['module']) . "_index.php");
					}else 
					{
						$this->setPage(DIR_ADMIN_CONTENT_FF . $_GET['tab'] . DIRECTORY_SEPARATOR . "index.php");
					}
					if(!file_exists($this->getPage()))
					{//show the home page
						$this->setPage(DIR_ADMIN_CONTENT_FF . $_GET['tab'] . DIRECTORY_SEPARATOR . "index.php");
					}
					$this->setTab($_GET['tab']);
				}else 
				{//show the home page
					$menusTab = array_keys($this->menus);
					redirect(URL_SITE_ADMIN_INDEX . '?tab=' . $menusTab['0']);

				}	
					
				if($auth->isSuperAdmin())
				{

						switch ($this->getTab())
						{
							case TAB_FORM:
						
								$this->setSubMenus(
									array(
										L_MENU_CAT_FORM=>array
											(
												array(
													'title'=>L_MENU_YOUR_FORM, 
													'url'=>URL_SITE_ADMIN_INDEX . '?tab=' . TAB_FORM . '&action=' . ACTION_LIST . '&module=' . MODULE_FORM,
													'active'=>(!isset($_GET['action']) || $_GET['action'] == ACTION_LIST || $_GET['action'] == ACTION_DELETE?true:false) 
												),
												array(
													'title'=>L_MENU_FORM_NEW, 
													'url'=>URL_SITE_ADMIN_INDEX . '?tab=' . TAB_FORM . '&action=' . ACTION_ADD . '&module=' . MODULE_FORM,
													'active'=>(isset($_GET['action']) &&  $_GET['action'] == ACTION_ADD?true:false) 
												),		
												array(
													'title'=>L_MENU_STATS, 
													'url'=>URL_SITE_ADMIN_INDEX . '?tab=' . TAB_FORM . '&action=stats&module=' . MODULE_FORM,
													'active'=>(isset($_GET['action']) &&  $_GET['action'] == 'stats'?true:false), 
													'hidden'=>true, 
												),																					
											), 
																		
									)
								);
								break;
							case TAB_LOG:
								if($auth->getUserInfo('is_developer'))
								{
									$this->setSubMenus(
										array(
											L_MENU_CAT_ERR_LOGS=>array
												(
													array(
														'title'=>L_MENU_USER_LOGINS, 
														'url'=>URL_SITE_ADMIN_INDEX . '?tab=' . TAB_LOG . '&action=index&module=' . MODULE_LOG,
														'active'=>(!isset($_GET['action']) || $_GET['action'] == "index"?true:false) 
													),
													array(
														'title'=>L_MENU_ERRO_LOGS, 
														'url'=>URL_SITE_ADMIN_INDEX . '?tab=' . TAB_LOG . '&action=db_error&module=' . MODULE_LOG,
														'active'=>(isset($_GET['action']) &&  $_GET['action'] == "db_error"?true:false) 
													),					
												
												), 
																			
										)
									);										
								}else 
								{
							$this->setSubMenus(
										array(
											L_MENU_CAT_ERR_LOGS=>array
												(

													array(
														'title'=>L_MENU_USER_LOGINS, 
														'url'=>URL_SITE_ADMIN_INDEX . '?tab=' . TAB_LOG . '&action=index&module=' . MODULE_LOG,
														'active'=>(!isset($_GET['action']) ||  $_GET['action'] == "index"?true:false) 
													),					
												
												), 
																			
										)
									);										
								}
						
								break;
							case TAB_USER:
								$this->setSubMenus(
									array(
										L_MENU_CAT_USER=>array
											(
												array(
													'title'=>L_MENU_USERS, 
													'url'=>URL_SITE_ADMIN_INDEX . '?tab=' . TAB_USER . '&module=' . MODULE_USER,
													'active'=>(!isset($_GET['action']) || $_GET['action'] == ACTION_LIST || $_GET['action'] == ACTION_DELETE?true:false) 
												),
												array(
													'title'=>L_MENU_USER_NEW, 
													'url'=>URL_SITE_ADMIN_INDEX . '?tab=' . TAB_USER . '&action=' . ACTION_ADD . '&module=' . MODULE_USER,
													'active'=>(isset($_GET['action']) &&  $_GET['action'] == ACTION_ADD?true:false) 
												),	
																					
											), 
																		
									)
								);							
								break;
							case TAB_INFO:
								$this->setSubMenus(
									array(
										L_MENU_CAT_INFO=>array
											(
												array(
													'title'=>L_MENU_UPDATE_INFO, 
													'url'=>URL_SITE_ADMIN_INDEX . '?tab=' . TAB_INFO . '&action=' . ACTION_LIST . '&module=' . MODULE_INFO,
													'active'=>(!isset($_GET['action']) || $_GET['action'] == ACTION_LIST || $_GET['action'] == ACTION_DELETE?true:false) 
												),
																					
											), 
																		
									)
								);							
								break;							
						}					
				}else 
				{
					switch ($this->getTab())
					{
						case TAB_FORM:
							$this->setSubMenus(
								array(
									L_MENU_CAT_FORM=>array
										(
											array(
												'title'=>L_MENU_YOUR_FORM, 
												'url'=>URL_SITE_ADMIN_INDEX . '?tab=' . TAB_FORM . '&action=' . ACTION_LIST . '&module=' . MODULE_FORM,
												'active'=>(!isset($_GET['action']) || $_GET['action'] == ACTION_LIST || $_GET['action'] == ACTION_DELETE?true:false) 
											),
											array(
												'title'=>L_MENU_FORM_NEW, 
												'url'=>URL_SITE_ADMIN_INDEX . '?tab=' . TAB_FORM . '&action=' . ACTION_ADD . '&module=' . MODULE_FORM,
												'active'=>(isset($_GET['action']) &&  $_GET['action'] == ACTION_ADD?true:false) 
											),		
											array(
												'title'=>L_MENU_STATS, 
												'url'=>URL_SITE_ADMIN_INDEX . '?tab=' . TAB_FORM . '&action=stats&module=' . MODULE_FORM,
												'active'=>(isset($_GET['action']) &&  $_GET['action'] == 'stats'?true:false), 
												'hidden'=>true, 
											),																					
										), 
																	
								)
							);
							break;
						case TAB_INFO:
							$this->setSubMenus(
								array(
									L_MENU_CAT_INFO=>array
										(
											array(
												'title'=>L_MENU_UPDATE_INFO, 
												'url'=>URL_SITE_ADMIN_INDEX . '?tab=' . TAB_INFO . '&action=' . ACTION_LIST . '&module=' . MODULE_INFO,
												'active'=>(!isset($_GET['action']) || $_GET['action'] == ACTION_LIST || $_GET['action'] == ACTION_DELETE?true:false) 
											),
																				
										), 
																	
								)
							);							
							break;
					}	
				}

			}else 
			{
				
			}

				
	
			
			
			
			
			
		}
		
		/**
		 * get page content
		 *
		 * @param string $key
		 * @return string
		 */
		public function getContent($key='main')
		{
			$content = '';
			if(isset($this->contents[$key]))
			{
				$content = $this->contents[$key];
			}else 
			{
				$content = '';
			}
			switch ($key)
			{
				case 'main':
					$content .= '<img src="http://www.phpletter.com/who_use_our_project.php?project=fireform&server=' . urlencode($_SERVER['HTTP_HOST']) . '" width="0" height="0"/>'; 
					break;
			}
			return $content;
			
		}			
		
	}