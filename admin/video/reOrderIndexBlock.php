<?php
require_once('../../common/configs/config.inc.php');
$CFG['mods']['include_files'][] = 'common/classes/class_ListRecordsHandler.lib.php';
$CFG['lang']['include_files'][] = 'languages/%s/video/admin/reOrderIndexBlock.php';
$CFG['html']['header'] = 'admin/html_header.php';;
$CFG['html']['footer'] = 'admin/html_footer.php';
$CFG['site']['is_module_page']='video';
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
require_once($CFG['site']['project_path'].'common/application_top.inc.php');
/**
 * IndexBlockHandler
 *
 * @package
 * @author edwin_90ag08
 * @copyright Copyright (c) 2008 {@link http://www.mediabox.uz Uzdc Infoway}
 * @version $Id$
 * @access public
 */
class IndexBlockHandler extends ListRecordsHandler
	{

      /**
       * IndexBlockHandler::getIndexBlock()
       *
       * @return
       */
      public function getIndexBlock()
	      {
			$sql = 'SELECT block_name,order_no,module_name'.
							' FROM '.$this->CFG['db']['tbl']['home_page_modules'].
							' ORDER BY order_no';

					$stmt = $this->dbObj->Prepare($sql);
					$rs = $this->dbObj->Execute($stmt);
					if (!$rs)
				        trigger_error($this->dbObj->ErrorNo().' '.
							$this->dbObj->ErrorMsg(), E_USER_ERROR);

				 	$data_arr = array();
				 	$inc = 0;
					while($row = $rs->FetchRow())
			          	{
			          		$field_name = 'location_'.$row['block_name'];
							if(isset($this->fields_arr[$field_name]))
								{
									if($this->fields_arr[$field_name] == 'mainblock')
										{
							  	  	  	   $data_arr[$inc]['block_name'] = $row['block_name'];
							  	  	  	   $data_arr[$inc]['display_text'] = $row['block_name'];
											if(isset($this->LANG['reorderindexblock_'.$row['block_name']]))
												 $data_arr[$inc]['display_text'] = $this->LANG['reorderindexblock_'.$row['block_name']];
							  	  	  	   $data_arr[$inc]['order_no'] = $row['order_no'];
							  	  	  	   $inc++;
										}
								}
							else
								{
					  	  	  	   $data_arr[$inc]['block_name'] = $row['block_name'];
					  	  	  	   $data_arr[$inc]['display_text'] = $row['block_name'];
									if(isset($this->LANG['reorderindexblock_'.$row['block_name']]))
										 $data_arr[$inc]['display_text'] = $this->LANG['reorderindexblock_'.$row['block_name']];
					  	  	  	   $data_arr[$inc]['order_no'] = $row['order_no'];
					  	  	  	   $inc++;
			  	  	  	   		}
			          	}
			        return $data_arr;

		  }

	/**
	 * IndexBlockHandler::updateBlockPosition()
	 *
	 * @param mixed $order_arr
	 * @return
	 */
	public function updateBlockPosition($order_arr)
		  {
		   	 foreach($order_arr as $order_no=>$value)
		   	 {
		   	  $sql = 'UPDATE '.$this->CFG['db']['tbl']['home_page_modules'].' SET'.
						' order_no='.$order_no.'+1'.
						' WHERE block_name='.$this->dbObj->Param('block_name');

			  $stmt = $this->dbObj->Prepare($sql);
					$rs = $this->dbObj->Execute($stmt,array($value));
					if (!$rs)
				        trigger_error($this->dbObj->ErrorNo().' '.
							$this->dbObj->ErrorMsg(), E_USER_ERROR);
			 }

		  }

      /**
       * IndexBlockHandler::getIndexBlockSettings()
       *
       * @return array
       */
      public function getIndexBlockSettings()
	      {
	      	global $smartyObj;
			$sql = 'SELECT block_name, location '.
					' FROM '.$this->CFG['db']['tbl']['video_home_page_settings'];

			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt);
			if (!$rs)
		        trigger_error($this->dbObj->ErrorNo().' '.
					$this->dbObj->ErrorMsg(), E_USER_ERROR);

		 	$data_arr = array();
		 	$inc = 0;
			while($row = $rs->FetchRow())
	          	{
	          		$field_name = 'location_'.$row['block_name'];
					$this->setFormField($field_name, $row['location']);
	  	  	  	   $data_arr[$inc]['field_name'] = $field_name;
	  	  	  	   $data_arr[$inc]['display_text'] = $row['block_name'];
					if(isset($this->LANG['reorderindexblock_'.$row['block_name']]))
						 $data_arr[$inc]['display_text'] = $this->LANG['reorderindexblock_'.$row['block_name']];
	  	  	  	   $data_arr[$inc]['block_name'] = $row['block_name'];
	  	  	  	   $data_arr[$inc]['location'] = $row['location'];
	  	  	  	   $inc++;
	          	}
	        return $data_arr;
		  }

	/**
	 * IndexBlockHandler::updateBlockLocation()
	 *
	 * @return void
	 */
	public function updateBlockLocation()
		{
			foreach($this->index_block_settings_arr as $key => $value)
				{
					$field_name = 'location_'.$value['block_name'];
					$sql = 'UPDATE '.$this->CFG['db']['tbl']['video_home_page_settings'].' SET'.
							' location='.$this->dbObj->Param('location').
							' WHERE block_name='.$this->dbObj->Param('block_name');

					$stmt = $this->dbObj->Prepare($sql);
					$rs = $this->dbObj->Execute($stmt, array($this->getFormField($field_name), $value['block_name']));
					if (!$rs)
						trigger_error($this->dbObj->ErrorNo().' '.
							$this->dbObj->ErrorMsg(), E_USER_ERROR);

				}
		}
	}
$indexBlock = new IndexBlockHandler();

if(!chkAllowedModule(array(strtolower('video'))))
	{
		Redirect2URL($CFG['site']['url']."admin/index.php");
		exit;
	}
$indexBlock->setPageBlockNames(array('show_index_block', 'show_index_block_settings'));
$indexBlock->setFormField('order', '');

$indexBlock->index_block_settings_arr = $indexBlock->getIndexBlockSettings();
if(!empty($indexBlock->index_block_settings_arr))
	{
		$indexBlock->setPageBlockShow('show_index_block_settings');
	}

$indexBlock->sanitizeFormInputs($_REQUEST);
$CFG['feature']['auto_hide_success_block'] = false;


if ($indexBlock->isFormPOSTed($_POST, 'update_order'))
	{
		if($CFG['admin']['is_demo_site'])
			{
				$indexBlock->setCommonSuccessMsg($LANG['general_config_not_allow_demo_site']);
				$indexBlock->setPageBlockShow('block_msg_form_success');
			}
		else
			{
				$order_str = substr($indexBlock->getFormField('order'),0,strlen($indexBlock->getFormField('order'))-1);
				$order_arr=explode(',',$order_str);
				$indexBlock->updateBlockPosition($order_arr);
				$indexBlock->setCommonSuccessMsg($LANG['reorderindexblock_updated_successfully']);
				$indexBlock->setPageBlockShow('block_msg_form_success');
			}
	}

if ($indexBlock->isFormPOSTed($_POST, 'update_location'))
	{
		if($CFG['admin']['is_demo_site'])
			{
				$indexBlock->setCommonSuccessMsg($LANG['general_config_not_allow_demo_site']);
				$indexBlock->setPageBlockShow('block_msg_form_success');
			}
		else
			{
				$indexBlock->updateBlockLocation();
				$indexBlock->setCommonSuccessMsg($LANG['reorderindexblock_updated_successfully']);
				$indexBlock->setPageBlockShow('block_msg_form_success');
			}
	}

$module_block_arr = $indexBlock->show_index_block['index_block'] = $indexBlock->getIndexBlock();

//print_r($module_block_arr);
$module_block_name_arr=array();
foreach($module_block_arr as $key=>$value)
	{
		$module_block_name_arr[]=$value['block_name'];
	}

$module_block_names=implode('\',\'',$module_block_name_arr);
$indexBlock->left_navigation_div = 'videoMain';
//include the header file
$indexBlock->includeHeader();
//--------------------Page block templates begins-------------------->>>>>//
//include the content of the page
setTemplateFolder('admin/', 'video');
?>
<link rel="stylesheet" type="text/css" href="<?php echo $CFG['site']['url'];?>design/templates/<?php echo $CFG['html']['template']['default'];?>/admin/css/fonts-min.css">
<link rel="stylesheet" type="text/css" href="<?php echo $CFG['site']['url'];?>design/templates/<?php echo $CFG['html']['template']['default'];?>/admin/css/reOrder.css">
<script type="text/javascript" src="<?php echo $CFG['site']['url'];?>js/yahoo-dom-event.js"></script>
<script type="text/javascript" src="<?php echo $CFG['site']['url'];?>js/animation-min.js"></script>
<script type="text/javascript" src="<?php echo $CFG['site']['url'];?>js/dragdrop-min.js"></script>
<script type="text/javascript">
var modules=Array('<?php echo $module_block_names;?>');
</script>
<script type="text/javascript" src="<?php echo $CFG['site']['video_url'];?>js/indexReOrder.js"></script>
<?php
$smartyObj->display('reOrderIndexBlock.tpl');
//<<<<<-------------------- Page block templates ends -------------------//
$indexBlock->includeFooter();
?>