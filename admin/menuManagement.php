<?php
/**
 * This file hadling the menu settings
 *
 * This file handling the add, edit and delete the menus and menu settings.
 *
 * PHP version 5.0
 * @category	Rayzz
 * @package		Admin
 */
require_once('../common/configs/config.inc.php');
$CFG['lang']['include_files'][] = 'languages/%s/admin/menuManagement.php';
$CFG['html']['header'] = 'admin/html_header.php';
$CFG['html']['footer'] = 'admin/html_footer.php';

//compulsory
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
/**
 * To include application top file
 */
require($CFG['site']['project_path'].'common/application_top.inc.php');
/**
 * This class hadling the menu settings
 *
 * @category	Rayzz
 * @package		Admin
 */
class manageMenu extends FormHandler
	{
		public $file;
		public $visible_menu_count;
		public $show_channel;
		public $module_structure =array();
		public $mappedModule;
		public $unMappedModule;

		/**
		 * manageMenu::getMenuSettings()
		 * To get the menu settings
		 *
		 * @return 	array
		 * @access 	public
		 */
		public function getMenuSettings()
			{
				$this->menu_keys = array();
				$this->menu_arr = array();
				$sql = 'SELECT * FROM '.$this->CFG['db']['tbl']['menu_settings'].' WHERE 1';
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array());
				if (!$rs)
					trigger_db_error($this->dbObj);

				while($row = $rs->FetchRow())
					{
						$this->setFormField($row['menu_key'],$row['menu_value']);
					}

				$sql='SELECT * FROM '.$this->CFG['db']['tbl']['menu'].' WHERE menu_status=\'Ok\' ORDER BY menu_order';
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array());
				if (!$rs)
					trigger_db_error($this->dbObj);
				if($rs->PO_RecordCount())
					{
						while($row = $rs->FetchRow())
							{
								if($row['module'] != '')
									{
										if(in_array($row['module'], $this->CFG['site']['modules_arr']))
											{
												if(chkAllowedModule(array($row['module'])))
													$this->menu_arr[$row['id']]=$row;
											}
									}
								else
									$this->menu_arr[$row['id']]=$row;
							}
						$this->menu_keys = array_keys($this->menu_arr);
					}
			}

		/**
		 * manageMenu::updateConfigData()
		 * To update the menu settings
		 *
		 * @return
		 * @access 	public
		 */
		public function updateConfigData()
			{
				foreach($_POST as $post=>$value)
					{
						if($post!='update_order' OR $post!='left')
							{
								$sql ='UPDATE '.$this->CFG['db']['tbl']['menu_settings'].
										' SET menu_value='.$this->dbObj->Param('menu_value').
										' WHERE menu_key='.$this->dbObj->Param('menu_key');
								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt, array($value,$post));
								if (!$rs)
									trigger_db_error($this->dbObj);
							}
						if($post=='left')
							{
								$inc=1;
								$menuid_arr = explode(',',$value);
								foreach($menuid_arr as $id)
									{
										$sql ='UPDATE '.$this->CFG['db']['tbl']['menu'].
												' SET menu_order='.$this->dbObj->Param('menu_order').
												' WHERE id='.$this->dbObj->Param('id');
										$stmt = $this->dbObj->Prepare($sql);
										$rs = $this->dbObj->Execute($stmt, array($inc,$id));
										if (!$rs)
											trigger_db_error($this->dbObj);
										$inc++;
									}
							}
					}
			}

		/**
		 * manageMenu::resetFields()
		 * To initialize the form fields
		 *
		 * @return
		 * @access 	public
		 */
		public function resetFields()
			{
				foreach($this->fields_arr as $fields=>$value)
					{
						$this->fields_arr[$fields]='';
					}
			}

		/**
		 * manageMenu::populateMenuList()
		 * To populate the menu list
		 *
		 * @return
		 * @access 	public
		 */
		public function populateMenuList()
			{

				$sql = 'SELECT * FROM '.$this->CFG['db']['tbl']['menu'].' WHERE 1';
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array());
				if (!$rs)
					trigger_db_error($this->dbObj);

				$inc=0;
				$this->menuDetail_arr =array();
				while($row = $rs->FetchRow())
					{
						if((empty($row['module'])) or
							((!empty($row['module']) and in_array($row['module'], $this->CFG['site']['modules_arr']))
								  and chkAllowedModule(array($row['module']))))
							{
					  			$this->menuDetail_arr[$inc]['id']=$row['id'];
								$this->menuDetail_arr[$inc]['menu_name']=$row['menu_name'];

								$this->menuDetail_arr[$inc]['normal_querystring']=$row['normal_querystring'];
								$this->menuDetail_arr[$inc]['seo_querystring']=$row['seo_querystring'];
								$this->menuDetail_arr[$inc]['folder']=$row['folder'];
								$this->menuDetail_arr[$inc]['module']=$row['module'];
								$this->menuDetail_arr[$inc]['member_menu']=$row['is_member_menu'];
								$this->menuDetail_arr[$inc]['hide_member_menu']=$row['is_member_hide_menu'];
								$this->menuDetail_arr[$inc]['is_module_home_page']=$row['is_module_home_page'];
								$this->menuDetail_arr[$inc]['file_name_static']['normal']='';
								$this->menuDetail_arr[$inc]['file_name_static']['seo']='';
								$this->menuDetail_arr[$inc]['file_name']=$row['file_name'];
								if($row['menu_page_type']=='normal')
									{
										$row['menu_page_type'] ='Rayzz File';
										$this->menuDetail_arr[$inc]['file_name']='';
									}
								else if($row['menu_page_type'] =='static')
									{
										$row['menu_page_type'] ='Static page';
										$this->menuDetail_arr[$inc]['file_name_static']['normal']=$this->CFG['site']['url'].'staticPage.php?pg='.$row['file_name'];
										$this->menuDetail_arr[$inc]['file_name_static']['seo']=$this->CFG['site']['url'].'static/'.$row['file_name'].'.html';
									}
								else
									{
										$row['menu_page_type'] ='External Url';
									}

								$this->menuDetail_arr[$inc]['page_type']=$row['menu_page_type'];
								$this->menuDetail_arr[$inc]['order']=$row['menu_order'];

								if($row['menu_status']=='Ok')
									{
										$row['menu_status']='Y';
									}
								$this->menuDetail_arr[$inc]['menu_status']=$row['menu_status'];
								$inc++;
							}
					}

			}

		/**
		 * manageMenu::getFileName()
		 * To get the file name from normal query string
		 *
		 * @param  string $normalQueryString normal query string
		 * @return string
		 * @access 	public
		 */
		public function getFileName($normalQueryString)
			{
				$splitedQuery = $normalQueryString;
				if(strpos($normalQueryString,'/'))
					{
						$splitedQuery =  substr($normalQueryString,strpos($normalQueryString,'/')+1,strlen($normalQueryString));
					}

				$filename	= strtolower(substr($splitedQuery,0,strpos($splitedQuery,'.')));
				return $filename;
			}

		/**
		 * manageMenu::insertMenu()
		 * To add new menu
		 *
		 * @return boolean
		 * @access 	public
		 */
		public function insertMenu()
			{
				if($this->fields_arr['page_type'] == 'normal')
					$this->fields_arr['menu_page_name'] = $this->getFileName($this->fields_arr['menu_normal_query_string']);

				$sql = "SELECT max(menu_order) as menu_order FROM ".
						$this->CFG['db']['tbl']['menu'].' WHERE menu_status=\'Ok\'';
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array());
				if (!$rs)
					trigger_db_error($this->dbObj);

				$row = $rs->FetchRow();
				$order=$row['menu_order']+1;
				if($this->fields_arr['menu_display']=='Ok')
					{
						$this->fields_arr['menu_display']='Ok';
					}
				else
					{
						$this->fields_arr['menu_display']='Deleted';
					}

				$this->fields_arr['page_type'];
				$sql = 'SELECT menu_name FROM '.$this->CFG['db']['tbl']['menu'].' WHERE menu_name='.$this->dbObj->Param('menu_name');
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['menu_name']));
				if (!$rs)
					trigger_db_error($this->dbObj);
				if(!$rs->PO_RecordCount())
					{
						$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['menu'].
								' (menu_name,file_name,normal_querystring,seo_querystring,'.
								' folder,module,menu_order,is_member_menu,is_member_hide_menu,'.
								'is_module_home_page,menu_page_type,menu_status,link_target,class_name)'.
								' VALUES('.$this->dbObj->Param('menu_name').','.
								$this->dbObj->Param('file_name').','.
								$this->dbObj->Param('normal_querystring').','.
								$this->dbObj->Param('seo_querystring').','.
								$this->dbObj->Param('folder').','.
								$this->dbObj->Param('module').','.
								$this->dbObj->Param('order').','.
								$this->dbObj->Param('is_member_menu').','.
								$this->dbObj->Param('is_member_hide_menu').','.
								$this->dbObj->Param('is_module_home_page').','.
								$this->dbObj->Param('menu_page_type').','.
								$this->dbObj->Param('menu_status').','.
								$this->dbObj->Param('link_target').','.
								$this->dbObj->Param('class_name').')';

						$fields_value_arr = array($this->fields_arr['menu_name'],
													$this->fields_arr['menu_page_name'],
													$this->fields_arr['menu_normal_query_string'],
													$this->fields_arr['menu_htaccess_query_string'],
													$this->fields_arr['menu_folder_path'],
													$this->fields_arr['menu_module'], $order, $this->fields_arr['member_menu'],
													$this->fields_arr['hide_member_menu'],
													$this->fields_arr['is_module_home_page'], $this->fields_arr['page_type'],
													$this->fields_arr['menu_display'],$this->fields_arr['link_target'],
													$this->fields_arr['class_name']
												);

						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, $fields_value_arr);
						if (!$rs)
							trigger_db_error($this->dbObj);

						$this->writeLanguageVariables($this->fields_arr['menu_name']);
						$this->resetFields();
						return true;
					}
				return false;

			}

		/**
		 * manageMenu::updateMenu()
		 * To update menu details
		 *
		 * @return boolean
		 * @access 	public
		 */
		public function updateMenu()
			{
				if($this->fields_arr['page_type'] == 'normal')
					$this->fields_arr['menu_page_name'] = $this->getFileName($this->fields_arr['menu_normal_query_string']);
				$this->fields_arr['menu_display'];
				if($this->fields_arr['menu_display']=='Ok')
					{
							$this->fields_arr['menu_display']='Ok';
					}
				else
					{
							$this->fields_arr['menu_display']='Deleted';
					}
				$sql = 'UPDATE '.$this->CFG['db']['tbl']['menu'].' SET '.
						' menu_name				='.$this->dbObj->Param('menu_name').','.
						' file_name				='.$this->dbObj->Param('file_name').','.
						' normal_querystring	='.$this->dbObj->Param('normal_querystring').','.
						' seo_querystring		='.$this->dbObj->Param('seo_querystring').','.
						' folder				='.$this->dbObj->Param('folder').','.
						' module				='.$this->dbObj->Param('module').','.
						' is_member_menu		='.$this->dbObj->Param('is_member_menu').','.
						' is_member_hide_menu	='.$this->dbObj->Param('is_member_hide_menu').','.
						' is_module_home_page	='.$this->dbObj->Param('is_module_home_page').','.
						' menu_page_type		='.$this->dbObj->Param('menu_page_type').','.
						' menu_status			='.$this->dbObj->Param('menu_status').','.
						' link_target			='.$this->dbObj->Param('link_target').','.
						' class_name			='.$this->dbObj->Param('class_name').
						' WHERE id				='.$this->dbObj->Param('id');
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['menu_name'],
															$this->fields_arr['menu_page_name'],$this->fields_arr['menu_normal_query_string'],
															$this->fields_arr['menu_htaccess_query_string'],$this->fields_arr['menu_folder_path'],
															$this->fields_arr['menu_module'],$this->fields_arr['member_menu'],
															$this->fields_arr['hide_member_menu'],$this->fields_arr['is_module_home_page'],
															$this->fields_arr['page_type'],$this->fields_arr['menu_display'],
															$this->fields_arr['link_target'],$this->fields_arr['menu_id'],
															$this->fields_arr['class_name']
														)
											);
				if (!$rs)
					trigger_db_error($this->dbObj);
				$this->writeLanguageVariables($this->fields_arr['menu_name']);
				$this->setFormField('menu_name','');
				$this->setFormField('class_name','');
				$this->setFormField('menu_page_name','');
				$this->setFormField('menu_normal_query_string','');
				$this->setFormField('menu_htaccess_query_string','');
				$this->setFormField('menu_folder_path','');
				$this->setFormField('menu_module','');
				$this->setFormField('member_menu','No');
				$this->setFormField('hide_member_menu','No');
				$this->setFormField('is_module_home_page','No');
				$this->setFormField('menu_display','');
				$this->setFormField('link_target','');
				$this->setFormField('page_type','normal');
				$this->setFormField('action','');

				return true;
			}

		/**
		 * manageMenu::getEditableMenu()
		 * To get the menu details for edit
		 *
		 * @return
		 * @access 	public
		 */
		public function getEditableMenu()
			{
				$sql = 'SELECT * FROM '.$this->CFG['db']['tbl']['menu'].' WHERE id='.$this->dbObj->Param('id');;
				$stmt = $this->dbObj->Prepare($sql);
				$this->fields_arr['menu_id'];
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['menu_id']));
				if (!$rs)
					trigger_db_error($this->dbObj);
				$row = $rs->FetchRow();
				if($rs->PO_RecordCount() and
					((empty($row['module'])) or
						((!empty($row['module']) and in_array($row['module'], $this->CFG['site']['modules_arr']))
						  and chkAllowedModule(array($row['module']))))
					)
					{
						$this->setFormField('menu_name',$row['menu_name']);
						$this->setFormField('class_name',$row['class_name']);
						$this->setFormField('menu_page_name',$row['file_name']);
						$this->setFormField('menu_normal_query_string',$row['normal_querystring']);
						$this->setFormField('menu_htaccess_query_string',$row['seo_querystring']);
						$this->setFormField('menu_folder_path',$row['folder']);
						$this->setFormField('menu_module',$row['module']);
						$this->setFormField('member_menu',$row['is_member_menu']);
						$this->setFormField('hide_member_menu',$row['is_member_hide_menu']);
						$this->setFormField('is_module_home_page',$row['is_module_home_page']);
						$this->setFormField('menu_display',$row['menu_status']);
						$this->setFormField('link_target',$row['link_target']);
						$this->setFormField('page_type',$row['menu_page_type']);
					}
				else
					{
						$this->setCommonErrorMsg($this->LANG['invalid_menu']);
						$this->setPageBlockShow('block_msg_form_error');
					}
			}

		/**
		 * manageMenu::deleteMenu()
		 * To delete the menu
		 *
		 * @return
		 * @access 	public
		 */
		public function deleteMenu()
			{
				$sql = 'SELECT * FROM '.$this->CFG['db']['tbl']['menu'].' WHERE id='.$this->dbObj->Param('id');;
				$stmt = $this->dbObj->Prepare($sql);
				$this->fields_arr['menu_id'];
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['menu_id']));
				if (!$rs)
					trigger_db_error($this->dbObj);
				$row = $rs->FetchRow();
				if($rs->PO_RecordCount() and
					((empty($row['module'])) or
						((!empty($row['module']) and in_array($row['module'], $this->CFG['site']['modules_arr']))
						  and chkAllowedModule(array($row['module']))))
					)
					{
						$sql='DELETE FROM '.$this->CFG['db']['tbl']['menu'].' WHERE id='.$this->dbObj->Param('id');
						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['menu_id']));
						if (!$rs)
							trigger_db_error($this->dbObj);

						return true;
					}
				else
					{
						$this->setCommonErrorMsg($this->LANG['invalid_menu']);
						$this->setPageBlockShow('block_msg_form_error');
					}
				return false;
			}

		/**
		 * manageMenu::writeLanguageVariables()
		 * To write language variables for new menu
		 *
		 * @param  string $menuName Menu name
		 * @return
		 * @access 	public
		 */
		public function writeLanguageVariables($menuName)
			{
				$menuKey=str_replace(' ','_',$menuName);
				$languages='<?php'."\n\r";
				if(!isset($this->LANG['mainMenu'][$menuKey]))
				{
						$this->LANG['mainMenu'][$menuKey]=$menuName;
				}
				foreach($this->LANG['mainMenu'] as $key=>$value)
				{
					$languages .='$LANG[\'mainMenu\'][\''.$key.'\']=\''.$value.'\';'."\n\r";
				}
				$languages.='?>';
				$directory_list = readDirectory($this->CFG['site']['project_path']. 'languages/', 'dir');
				foreach($directory_list as $lang_dir)
					{
						$menuLanguage='../languages/'.$lang_dir.'/general/'.$this->menuLanguageFile;
						$fp=fopen($menuLanguage,'w');
						fwrite($fp,$languages);
						fclose($fp);
					}
			}

		/**
		 * manageMenu::chkVaildInput()
		 * To validate the menu details
		 *
		 * @return
		 * @access 	public
		 */
		public function chkVaildInput()
			{
				$this->chkIsNotEmpty('menu_name', $this->LANG['menumangement_err_tip_compulsory']);
				$this->chkIsValidSize('menu_name','menu_name',$this->LANG['menumangement_err_tip_menu_size']);
				if($this->fields_arr['page_type']!='normal')
					$this->chkIsNotEmpty('menu_page_name', $this->LANG['menumangement_err_tip_compulsory']);

				$this->LANG['menumangement_err_tip_menu_size']=str_replace(array('VAR_MIN','VAR_MAX'),array($this->CFG['fieldsize']['menu_name']['min'],$this->CFG['fieldsize']['menu_name']['max']),$this->LANG['menumangement_err_tip_menu_size'] );
				if($this->fields_arr['page_type'] == 'normal')
					{
						$this->chkIsNotEmpty('menu_normal_query_string', $this->LANG['menumangement_err_tip_compulsory']);
						$this->chkIsNotEmpty('menu_htaccess_query_string', $this->LANG['menumangement_err_tip_compulsory']);
					}
			}

		/**
		 * manageMenu::populateStaticPages()
		 * To populate the static pages list
		 *
		 * @return
		 * @access 	public
		 */
		public function populateStaticPages()
			{
				$sql ='SELECT page_name FROM '.$this->CFG['db']['tbl']['static_pages'].' WHERE status=\'Activate\'';
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array());
				if (!$rs)
					trigger_db_error($this->dbObj);

				$this->staticPage_arr=array();
				while($row = $rs->FetchRow())
					{
						$this->staticPage_arr[$row['page_name']]=ucwords($row['page_name']);
					}
			}
	}

$menu = new manageMenu();
$menu->setDBObject($db);
$menu->makeGlobalize($CFG,$LANG);
$menu->menuLanguageFile='mainMenu.php';
$menu->setFormField('left','');
$menu->setPageBlockNames(array('block_add_menu','block_menu_manage','block_msg_form_error','block_msg_form_success'));
$menu->sanitizeFormInputs($_REQUEST);
$menu->left_navigation_div = 'generalMenu';
$menu->includeHeader();

if($menu->isFormGETed($_GET, 'action'))
	{
		$menu->module = array();
		foreach($CFG['site']['modules_arr'] as $key => $mod_value)
			{
				if(chkAllowedModule(array($mod_value)))
					$menu->module[] = $mod_value;
			}
		if(!empty($menu->module))
			sort($menu->module);
		$menu->setFormField('menu_name','');
		$menu->setFormField('class_name','');
		$menu->setFormField('default_class_name','clsDefaultMenu');
		$menu->setFormField('menu_page_name','');
		$menu->setFormField('menu_page_name_normal','');
		$menu->setFormField('menu_page_name_static','');
		$menu->setFormField('menu_normal_query_string','');
		$menu->setFormField('menu_htaccess_query_string','');
		$menu->setFormField('menu_folder_path','');
		$menu->setFormField('menu_module','');
		$menu->setFormField('menu_display','');
		$menu->setFormField('link_target','');
		$menu->setFormField('action','');
		$menu->setFormField('menu_id','');
		$menu->setFormField('member_menu','No');
		$menu->setFormField('hide_member_menu','No');
		$menu->setFormField('is_module_home_page','No');
		$menu->setFormField('increament','');
		$menu->setFormField('page_type','normal');
		$menu->setPageBlockShow('block_add_menu','');
		$menu->sanitizeFormInputs($_REQUEST);
		if ($menu->getFormField('menu_display') == 'Y')
			$menu->setFormField('menu_display','Ok');
		$menu->populateStaticPages();
		if($menu->getFormField('page_type')=='static')
			{
				$menu->setFormField('menu_page_name',$menu->getFormField('menu_page_name_static'));
			}
		else
			{
				$menu->setFormField('menu_page_name',$menu->getFormField('menu_page_name_normal'));
			}

		if($menu->getFormField('action')=='edit' AND !$menu->isFormPOSTed($_POST, 'menu_add_submit'))
			{
				$menu->getEditableMenu();
			}
		else if($menu->getFormField('action')=='edit' AND $menu->isFormPOSTed($_POST, 'menu_add_submit'))
			{
				if($CFG['admin']['is_demo_site'])
					{
						$menu->setCommonSuccessMsg($LANG['general_config_not_allow_demo_site']);
						$menu->setPageBlockShow('block_msg_form_success');
					}
				else
					{
					 	$menu->chkVaildInput();
						if($menu->isValidFormInputs())
							{
								$menu->updateMenu();
								$menu->setCommonSuccessMsg($LANG['menu_edited_success']);
								$menu->setPageBlockShow('block_msg_form_success');
							}
						else
							{
								$menu->setCommonErrorMsg($LANG['menu_errors_found']);
								$menu->setPageBlockShow('block_msg_form_error');
							}
					}
			}
		else if($menu->getFormField('action')=='delete')
			{
				if($CFG['admin']['is_demo_site'])
					{
						$menu->setCommonSuccessMsg($LANG['general_config_not_allow_demo_site']);
						$menu->setPageBlockShow('block_msg_form_success');
					}
				else
					{
						if($menu->deleteMenu())
							{
								$menu->setCommonSuccessMsg($LANG['menu_deleted_success']);
								$menu->setPageBlockShow('block_msg_form_success');
							}
					}
			}
		else if($menu->isFormPOSTed($_POST, 'menu_add_submit'))
			{
				if($CFG['admin']['is_demo_site'])
					{
						$menu->setCommonSuccessMsg($LANG['general_config_not_allow_demo_site']);
						$menu->setPageBlockShow('block_msg_form_success');
					}
				else
					{
						$menu->chkVaildInput();
						if($menu->isValidFormInputs())
							{
								if($menu->insertMenu())
									{
										$menu->setCommonSuccessMsg($LANG['menu_inserted_success']);
										$menu->setPageBlockShow('block_msg_form_success');
									}
								else
									{
										$menu->setCommonErrorMsg($LANG['menu_added_already']);
										$menu->setPageBlockShow('block_msg_form_error');
									}
							}
						else
							{
								$menu->setCommonErrorMsg($LANG['menu_errors_found']);
								$menu->setPageBlockShow('block_msg_form_error');
							}
					}
			}

		$menu->populateMenuList();
	}
else
	{
		$menu->setPageBlockShow('block_menu_manage');
		if($menu->isFormPOSTed($_POST, 'update_order'))
			{
				if($CFG['admin']['is_demo_site'])
					{
						$menu->setCommonSuccessMsg($LANG['general_config_not_allow_demo_site']);
						$menu->setPageBlockShow('block_msg_form_success');
					}
				else
					{
						$menu->updateConfigData();
						$menu->setCommonSuccessMsg($LANG['menu_inserted_success']);
						$menu->setPageBlockShow('block_msg_form_success');
					}
			}
		$menu->makeGlobalize($CFG,$LANG);
		$menu->getMenuSettings();
		$menu->dom_element=implode('\',\'',$menu->menu_keys);
?>
<script type="text/javascript">
var modules = Array('<?php echo $menu->dom_element;?>');
var reorder_section_count = 1;
</script>
<?php
	}
?>
<script type="text/javascript">
var externalLink ="<?php echo $LANG['menumanagment_external_link'];?>";
var normalPage ="<?php echo $LANG['menu_page_name'];?>";
var block_arr= new Array('selMsgChangeStatus', 'selMsgConfirm');
var normalText="<?php echo $LANG['menu_normal_text'];?>";
var seoText="<?php echo $LANG['menu_seo_text'];?>";
function showElement() {
	ele=$Jq('#page_type').val();
	$Jq('#normalspan').css('display', 'none');
	$Jq('#staticspan').css('display', 'none');

	if(ele!='normal')
	{
		$Jq('#menu_normal_query_string').val('');
		$Jq('#menu_htaccess_query_string').val('');
		$Jq('.normal_elemtents').each(function(index, ele){
			ele.style.display = 'none';
		});
	}
	else
	{
		$Jq('#menu_page_name_normal').val('');
		$Jq('#menu_page_name_static').val('');
		$Jq('#menu_module').disabled=false;
		$Jq('.normal_elemtents').each(function(index, ele){
			ele.style.display = '';
		});
	}

	$Jq('#pg_row_ext').hide();
	$Jq('#pg_row_ext_label').hide();
	if(ele=='static')
	{
	//$('menu_folder_path').disabled=false;
	$Jq('#pg_row_ext').show();
	$Jq('#pg_row_ext_label').show();
	}
	if(ele=='external_link')
	{
		ele='normal';
		$Jq('#pg_name').html(externalLink);
		$Jq('#pg_row_ext').hide();
		$Jq('#pg_row_ext_label').hide();
	}
	else
	{
		$Jq('#pg_name').html(normalPage);
	}
	ele="#"+ele+"span";
	$Jq(ele).css('display', 'block');
}
function getStaticUrl() {
	page = $Jq('#menu_page_name_static').val();
	staticNormal=cfg_site_url+'staticPage.php?pg='+page;
	staticSeo=cfg_site_url+'static/'+page+'.html';
	staticUrl ='<div><p>Preview Url</p><p>Normal : <a href="'+staticNormal+'">'+staticNormal+'</a> <br> SEO : <a href="'+staticSeo+'">'+staticSeo+'</a></p></div>';
	$Jq('#staticUrl').html(staticUrl);
}
</script>
<?php
setTemplateFolder('admin/');
$smartyObj->display('menuManagement.tpl');
if($menu->isFormGETed($_GET, 'action'))
{
?>
<script type="text/javascript">
showElement();
</script>
<?php
	}

//includ the footer of the page
//<<<<<<--------------------Page block templates Ends--------------------//
$menu->includeFooter();
?>