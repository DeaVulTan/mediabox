<?php
/**
 * This file hadling reorder the profile blocks
 *
 *
 * PHP version 5.0
 * @category	Rayzz
 * @package		Admin
 */
require_once('../common/configs/config.inc.php');
$CFG['mods']['include_files'][] = 'common/classes/class_ListRecordsHandler.lib.php';
$CFG['lang']['include_files'][] = 'languages/%s/admin/reOrderProfileBlock.php';
$CFG['html']['header'] = 'admin/html_header.php';;
$CFG['html']['footer'] = 'admin/html_footer.php';
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
/**
 * To include application top file
 */
require($CFG['site']['project_path'].'common/application_top.inc.php');
/**
 * This class hadling reorder the profile blocks
 *
 * @category	Rayzz
 * @package		Admin
 */
class ProfileBlockHandler extends ListRecordsHandler
	{
      /**
       * ProfileBlockHandler::getProfileBlock()
       * To get the profile block list position and details
       *
       * @return array
       * @access 	public
       */
      public function getProfileBlock()
	      {
			$sql = 'SELECT module_name, block_name, position, display, order_no, profile_category_id'.
							' FROM '.$this->CFG['db']['tbl']['profile_block'].
							' WHERE display=\'Yes\' ORDER BY order_no';

					$stmt = $this->dbObj->Prepare($sql);
					$rs = $this->dbObj->Execute($stmt);
					if (!$rs)
				        trigger_db_error($this->dbObj);

				 	$data_arr = array();
				 	$inc = 0;
					while($row = $rs->FetchRow())
			          	{
							if(chkAllowedModule(array(strtolower($row['module_name']))) or $row['module_name']=='default')
								{
									$data_arr[$inc]['block_name'] = $row['block_name'];
									$data_arr[$inc]['block_category_name'] = $row['profile_category_id']?str_replace(' ','',$this->getProfileCategoryName($row['profile_category_id'])):$row['block_name'];
									$data_arr[$inc]['position'] = $row['position'];
					  	  	  		$data_arr[$inc]['display'] = $row['display'];
					  	  	  	 	$data_arr[$inc]['order_no'] = $row['order_no'];
					  	  	  	    $inc++;
								}
			          	}
			        return $data_arr;
		  }

		/**
		 * ProfileBlockHandler::getProfileCategoryName()
		 *
		 * @return
		 */
		public function getProfileCategoryName($cat_id)
			 {
			 	$sql = 'SELECT title FROM '.$this->CFG['db']['tbl']['users_profile_category'].
				 		' WHERE id = '.$this->dbObj->Param('cat_id');
			 	$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt,array($cat_id));
				if (!$rs)
				    trigger_db_error($this->dbObj);

			 	if($row = $rs->FetchRow())
					return $form_id = $row['title'];
				return 0;
			 }

	  /**
       * ProfileBlockHandler::updateRightBlockPosition()
       * To update the right block postions
       *
       * @param  array $right_arr right blocks list
       * @return
       * @access 	public
       */
	  public function updateRightBlockPosition($right_arr)
		  {
		   	 foreach($right_arr as $order_no=>$value)
		   	 {
		   	  $sql = 'UPDATE '.$this->CFG['db']['tbl']['profile_block'].' SET'.
						' position=\'right\',order_no='.$order_no.'+1'.
						' WHERE block_name='.$this->dbObj->Param('block_name');

			  $stmt = $this->dbObj->Prepare($sql);
					$rs = $this->dbObj->Execute($stmt,array($value));
					if (!$rs)
				        trigger_db_error($this->dbObj);
			 }
		  }

	  /**
       * ProfileBlockHandler::updateLeftBlockPosition()
       * To update the left block postions
       *
       * @param  array $left_arr left blocks list
       * @return
       * @access 	public
       */
	  public function updateLeftBlockPosition($left_arr)
		  {
		   	 foreach($left_arr as $order_no=>$value)
		   	 {
		   	  $sql = 'UPDATE '.$this->CFG['db']['tbl']['profile_block'].' SET'.
						' position=\'left\',order_no='.$order_no.'+1'.
						' WHERE block_name='.$this->dbObj->Param('block_name');

			  $stmt = $this->dbObj->Prepare($sql);
					$rs = $this->dbObj->Execute($stmt,array($value));
					if (!$rs)
				        trigger_db_error($this->dbObj);
			 }
		  }
	}
$profileblock = new ProfileBlockHandler();
$profileblock->setPageBlockNames(array('show_profile_block'));
$profileblock->setFormField('left', '');
$profileblock->setFormField('right', '');
$profileblock->sanitizeFormInputs($_REQUEST);
$CFG['feature']['auto_hide_success_block'] = false;
if ($profileblock->isFormPOSTed($_POST, 'update_order'))
{
	if($CFG['admin']['is_demo_site'])
		{
			$profileblock->setCommonSuccessMsg($LANG['general_config_not_allow_demo_site']);
			$profileblock->setPageBlockShow('block_msg_form_success');
		}
	else
		{
			$left_str = substr($profileblock->getFormField('left'),0,strlen($profileblock->getFormField('left'))-1);
			$left_arr=explode(',',$left_str);
			$profileblock->updateLeftBlockPosition($left_arr);

			$right_str = substr($profileblock->getFormField('right'),0,strlen($profileblock->getFormField('right'))-1);
			$right_arr=explode(',',$right_str);
			$profileblock->updateRightBlockPosition($right_arr);
			$profileblock->setCommonSuccessMsg($LANG['reorderprofileblock_updated_successfully']);
			$profileblock->setPageBlockShow('block_msg_form_success');
		}
}

$profileblock->show_profile_block['profile_block']=$profileblock->getProfileBlock();
$block_arr=$profileblock->getProfileBlock();
$block_name_arr=array();
foreach($block_arr as $key=>$value)
{
$block_name_arr[]=$value['block_name'];
}
$blog_names=implode('\',\'',$block_name_arr);
$profileblock->left_navigation_div = 'generalList';
//include the header file
$profileblock->includeHeader();
//--------------------Page block templates begins-------------------->>>>>//
//include the content of the page
setTemplateFolder('admin/' );

?>
<script type="text/javascript">
var reorder_section_count = 2;
var modules=Array('<?php echo $blog_names;?>');
</script>
<?php
$smartyObj->display('reOrderProfileBlock.tpl');
//<<<<<-------------------- Page block templates ends -------------------//
$profileblock->includeFooter();
?>


