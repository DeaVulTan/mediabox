<?php
/**
 * This file is use for manage plugin
 *
 * This file is having  module vice plugin list, install the plugin and show status.
 *
 * PHP version 5.0
 * @category	Rayzz
 * @package		Admin
 *
 **/
require_once('../common/configs/config.inc.php');
$CFG['lang']['include_files'][] = 'languages/%s/admin/pluginConfig.php';
$CFG['mods']['include_files'][] = 'common/classes/class_ListRecordsHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_Parser.lib.php';
$CFG['html']['header'] = 'admin/html_header.php';
$CFG['html']['footer'] = 'admin/html_footer.php';
if(isset($_REQUEST['action']))
	$CFG['site']['is_module_page'] = $_REQUEST['action'];

$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
require($CFG['site']['project_path'].'common/application_top.inc.php');
//---------------------------- Class pluginHandler begins -------------------->>>>>//
/**
 * This class hadling the plugin
 *
 * @category	Rayzz
 * @package		Admin
 */
class pluginHandler extends ListRecordsHandler
	{
		public $unwanted_files_list_arr = array();
		public $lang_content = array();

		/**
		 * ServerSettingsHandler::displayPluginList()
		 * To display the plugin list
		 *
		 * @return 	array
		 * @access 	public
		 */
		public function displayPluginList()
			{
				$displayPluginList_arr =array();
				if($this->fields_arr['action']){
					$folder_path = 'plugin/'.$this->fields_arr['action'].'/plugin/';
				}else{
					$folder_path = 'plugin/general/plugin/';
					$module_name = 'general';
				}
				if(!is_dir($folder_path))
					return $displayPluginList_arr;

				$parser_obj = new Parser();
				if ($handle = opendir($folder_path))
					{
						$inc = 0;
					  /* This is the correct way to loop over the directory. */
					   while (($file = readdir($handle)) !== false)
				   			{
				   				if (strpos($file, '.php') !== false and (array_search($file, $this->unwanted_files_list_arr) === false))
									{
										$filename = explode('.', $file);
										$pluginname = explode('_', $filename[0]);
										require($folder_path.$file);
										$displayPluginList_arr[$inc]['title'] = $LANG[strtolower($filename[0]).'_title'];
										$displayPluginList_arr[$inc]['version'] = $LANG[strtolower($filename[0]).'_version'];
										$displayPluginList_arr[$inc]['description'] = wordWrap_mb_Manual($LANG[strtolower($filename[0]).'_description'], 50);
										$displayPluginList_arr[$inc]['link'] = $LANG[strtolower($filename[0]).'_link'];
										$displayPluginList_arr[$inc]['pluginname'] = strtolower($pluginname[1]);
										$inc++;
									}
							}
						closedir($handle);
					}
				/*echo '<pre>';
				print_r($displayPluginList_arr);
				echo '</pre>';*/
				return $displayPluginList_arr;
			}

		/**
		 * pluginHandler::chkAlreadyExists()
		 * to check plugin already installed or not
		 *
		 * @param mixed $plugin_name plugin name
		 * @param mixed $module_name module name
		 * @return
		 * @access 	public
		 */
		public function chkAlreadyExists($plugin_name, $module_name)
			{
				$sql = 'SELECT 1 FROM '.$this->CFG['db']['tbl']['install_plugin'].
						' WHERE plugin_name = '.$this->dbObj->Param('plugin_name').' AND module_name='.$this->dbObj->Param('action');

				$stmt = $this->dbObj->Prepare($sql);

				if($module_name == '')
					$module_name = 'general';
				$rs = $this->dbObj->Execute($stmt, array($plugin_name, $module_name));
				if (!$rs)
					trigger_db_error($this->dbObj);

				$row = $rs->FetchRow();

				if(!empty($row))
					return true;
				else
					return false;
			}
	}
//<<<<<---------------class pluginHandler ends -------------///
//--------------------Code begins-------------->>>>>//
$pluginHandler = new pluginHandler();
$pluginHandler->setPageBlockNames(array('plugin_list_block'));
$pluginHandler->setFormField('action','');
$pluginHandler->setFormField('module_name','');
$pluginHandler->setFormField('plugin_name','');
$pluginHandler->setFormField('err','');
$pluginHandler->setAllPageBlocksHide();
$pluginHandler->sanitizeFormInputs($_REQUEST);
$pluginHandler->setPageBlockShow('plugin_list_block');
$pluginHandler->err_msg = '';
$errVal = $pluginHandler->getFormField('err');


	if($pluginHandler->getFormField('plugin_name') && empty($errVal)){
		$success_msg	 = str_replace('VAR_PLUGIN_NAME', str_replace('_',' ',$pluginHandler->getFormField('plugin_name')).' ', $LANG['pluginconfig_successfully']);

		if(!isset($_GET['action']))
			$pluginHandler->setFormField('action','general');

		$pluginHandler->setCommonSuccessMsg($success_msg);
		$pluginHandler->setPageBlockShow('block_msg_form_success');
		if(isset($_SESSION['err_msg']) && !empty($_SESSION['err_msg']))
			$pluginHandler->err_msg = $_SESSION['err_msg'];

	}elseif(!empty($errVal) && $errVal == 1){
		$success_msg	 = str_replace('VAR_PLUGIN_NAME', str_replace('_',' ',$pluginHandler->getFormField('plugin_name')).' ', $LANG['pluginconfig_error']);

		if(!isset($_GET['action']))
			$pluginHandler->setFormField('action','general');

		$pluginHandler->setCommonSuccessMsg($success_msg);
		$pluginHandler->setPageBlockShow('block_msg_form_success');
	}elseif(!empty($errVal) && $errVal == 2){
		$success_msg	 = str_replace('VAR_PLUGIN_NAME', str_replace('_',' ',$pluginHandler->getFormField('plugin_name')).' ', $LANG['pluginconfig_error']);

		if(!isset($_GET['action']))
			$pluginHandler->setFormField('action','general');

		$pluginHandler->setCommonSuccessMsg($success_msg);
		$pluginHandler->setPageBlockShow('block_msg_form_success');
	}

if ($pluginHandler->isShowPageBlock('plugin_list_block')){
		$pluginHandler->plugin_list_block['displayPluginList_arr'] = $pluginHandler->displayPluginList();
	}
if($pluginHandler->getFormField('action'))
	$pluginHandler->left_navigation_div = $pluginHandler->getFormField('action').'Plugin';
else
	$pluginHandler->left_navigation_div = 'generalPlugin';

//<<<<--------------------Code Ends----------------------//
//--------------------Page block templates begins-------------------->>>>>//
$pluginHandler->includeHeader();
//include the content of the page

setTemplateFolder('admin/');
$smartyObj->display('pluginConfig.tpl');
//<<<<<-------------------- Page block templates ends -------------------//
?>
<script language="javascript" type="text/javascript">
function pluginConfigFormSubmit(plugin_val, module_val)
	{
		document.pluginConfig.module_name.value = module_val;
		document.pluginConfig.plugin_name.value = plugin_val;
		document.pluginConfig.submit();
	}
</script>
<?php
$pluginHandler->includeFooter();
?>