<?php
/**
 * IndexPageHandler
 *
 * @package
 * @author edwin_90ag08
 * @copyright Copyright (c) 2008 {@link http://www.mediabox.uz Uzdc Infoway}
 * @version $Id$
 * @access public
 */
class IndexPageHandler extends VideoHandler
	{
	 /**
	  * IndexPageHandler::getIndexBlock()
	  *
	  * @return
	  */
	 public function getIndexBlock()
	      {
			$sql = 'SELECT block_name,order_no,module_name,display'.
							' FROM '.$this->CFG['db']['tbl']['home_page_modules'].
							' WHERE display=\'Yes\' ORDER BY order_no';

					$stmt = $this->dbObj->Prepare($sql);
					$rs = $this->dbObj->Execute($stmt);
					if (!$rs)
				        trigger_db_error($this->dbObj);

				 	$data_arr = array();
				 	$inc = 0;
					while($row = $rs->FetchRow())
			          	{
							if(isset($this->index_block_settings_arr[$row['block_name']]))
								{
									if($this->index_block_settings_arr[$row['block_name']] == 'mainblock')
										{
							  	  	  	   $data_arr[$inc]['block_name'] = $row['block_name'];
							  	  	  	   $data_arr[$inc]['module_name'] = $row['module_name'];
							  	  	  	   $data_arr[$inc]['order_no'] = $row['order_no'];
							  	  	  	   $data_arr[$inc]['display'] = $row['display'];
							  	  	  	   $inc++;
										}
								}
							else
								{
					  	  	  	   $data_arr[$inc]['block_name'] = $row['block_name'];
					  	  	  	   $data_arr[$inc]['module_name'] = $row['module_name'];
					  	  	  	   $data_arr[$inc]['order_no'] = $row['order_no'];
					  	  	  	   $data_arr[$inc]['display'] = $row['display'];
					  	  	  	   $inc++;
								}


			          	}
			        return $data_arr;

		  }

	 /**
	  * IndexPageHandler::getIndexBlockSettings()
	  *  Get the Block Location settings from video_home_page_settings
	  * @return
	  */
	 public function getIndexBlockSettings()
	      {
	      	global $smartyObj;
			$sql = 'SELECT block_name,location'.
					 ' FROM '.$this->CFG['db']['tbl']['video_home_page_settings'];

			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt);
			if (!$rs)
		        trigger_db_error($this->dbObj);

		 	$data_arr = array();
			while($row = $rs->FetchRow())
	          	{
	  	  	  	   $data_arr[$row['block_name']] = $row['location'];
	          	}

			return $data_arr;
		  }
		public function myHomeActivity()
		{
			global $smartyObj;
			$smartyObj->assign('myobj', $this);
			$smartyObj->assign('LANG', $this->LANG);
			$smartyObj->assign('CFG', $this->CFG);
			setTemplateFolder('members/');
			$smartyObj->display('myHomeActivity.tpl');
		}
	}
$index = new IndexPageHandler();
$index->setFormField('block','');
$index->setFormField('module','');
$index->setFormField('activity_type','');

$index->sanitizeFormInputs($_REQUEST);

if(!chkAllowedModule(array('video')))
	Redirect2URL($CFG['redirect']['dsabled_module_url']);

if(!isAjaxPage())
	{
		$index_block_settings_arr = $index->index_block_settings_arr = $index->getIndexBlockSettings();
		$smartyObj->assign('index_block_settings_arr', $index->index_block_settings_arr);

		$index->includeHeader();
?>

<?php

		setTemplateFolder('general/','video');
		$smartyObj->display('index.tpl');

	}

if($index->isFacebookUser() && isMember())
	{
		$index->setFacebookProfile();
	}

if(!isAjaxPage())
{
	$module_arr=$index->getIndexBlock();
	foreach($module_arr as $value)
	{
	   $module_block_name=$value['block_name'];
	   $module_name=$value['module_name'];
	   $display=$value['display'];
	   if($module_name=='default')
	   	{
	   		if($module_block_name == 'NewPeople')
	   			{
			   	  	if(file_exists($CFG['site']['project_path'].'/general/index'.ucfirst($module_name).'Block.php'))
					 {
						require_once($CFG['site']['project_path'].'/general/index'.ucfirst($module_name).'Block.php');
						if(file_exists($CFG['site']['project_path'].$CFG['site']['is_module_page'].'/design/templates/'.$CFG['html']['template']['default'].'/general/index'.$module_block_name.'.tpl'))
						 {
							setTemplateFolder('general/', $CFG['site']['is_module_page']);
							$smartyObj->display('index'.$module_block_name.'.tpl');
						 }
						elseif(file_exists($CFG['site']['project_path'].'design/templates/'.$CFG['html']['template']['default'].'/general/index'.$module_block_name.'.tpl'))
						 {
							setTemplateFolder('general/');
							$smartyObj->display('index'.$module_block_name.'.tpl');
						 }
					 }
				}
			else
				{
			   	  	if(file_exists($CFG['site']['project_path'].'/general/index'.ucfirst($module_name).'Block.php'))
					 {
						require_once($CFG['site']['project_path'].'/general/index'.ucfirst($module_name).'Block.php');
						if(file_exists($CFG['site']['project_path'].'design/templates/'.$CFG['html']['template']['default'].'/general/index'.$module_block_name.'.tpl'))
						 {
						setTemplateFolder('general/');
						$smartyObj->display('index'.$module_block_name.'.tpl');
						 }
					 }
				}
		}
		else
		{
			if(file_exists($CFG['site']['project_path'].$module_name.'/general/index'.ucfirst($module_name).'Block.php'))
			 {

				 require_once($CFG['site']['project_path'].$module_name.'/general/index'.ucfirst($module_name).'Block.php');
				 if(file_exists($CFG['site']['project_path'].$module_name.'/design/templates/'.$CFG['html']['template']['default'].'/general/index'.$module_block_name.'.tpl'))
				  {
					setTemplateFolder('general/',$module_name);
					$smartyObj->display('index'.$module_block_name.'.tpl');
				  }
			 }

		}

	}//foreach
}
else if($index->getFormField('activity_type')!= '')
{
	if($index->getFormField('activity_type') == 'Friends' and !$index->getTotalFriends($CFG['user']['user_id']))
		{
			echo '<div class="clsNoRecordsFound">'.$LANG['index_activities_no_friends'].'</div>';
			exit;
		}
	$activity_view_all_url = getUrl('activity', '?pg='.strtolower($index->getFormField('activity_type')), strtolower($index->getFormField('activity_type')).'/updates/', 'members');
	$smartyObj->assign('activity_view_all_url', $activity_view_all_url);
	$Activity = new ActivityHandler();
	$Activity->setActivityType(strtolower($index->getFormField('activity_type')), 'video');
	$index->myHomeActivity();
}
else
{


		$module_block_name=$index->getFormField('block');
		$module_name=$index->getFormField('module');
 	   	if(file_exists($CFG['site']['project_path'].$module_name.'/general/index'.ucfirst($module_name).'Block.php'))
	   	{
		require_once($CFG['site']['project_path'].$module_name.'/general/index'.ucfirst($module_name).'Block.php');
		if(file_exists($CFG['site']['project_path'].$module_name.'/design/templates/'.$CFG['html']['template']['default'].'/general/index'.$module_block_name.'.tpl'))
		    {
		   setTemplateFolder('general/',$module_name);
		   $smartyObj->display('index'.$module_block_name.'.tpl');
	     	}
		}
exit;

}
?>

<script language="javascript" type="text/javascript" >
//This is important for carosel//
var module_name_js = "video";
var video_activity_array = new Array('My', 'Friends', 'All');
var video_index_ajax_url = '<?php echo $CFG['site']['video_url'].'index.php';?>';
var topChart_array = new Array();
</script>
<?php
if(!isAjaxPage())
	$index->includeFooter();
?>