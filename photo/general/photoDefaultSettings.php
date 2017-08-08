<?php
/**
 * PhotoDefaultSettings
 *
 * @package		general
 * @author 		mangalam_020at09
 * @copyright 	Copyright (c) 2008 {@link http://www.mediabox.uz Uzdc Infoway}
 * @access 		public
 **/

class photoDefaultSettings extends PhotoUploadLib
{
	public $hidden_arr = array();
	public $multi_hidden_arr = array();
	public $fp = false;


	/**
	 * photoDefaultSettings::validationFormFields1()
	 *
	 * @return void
	 */
	public function validationFormFields1()
	{
		$this->chkIsNotEmpty('photo_tags', $this->LANG['common_err_tip_required']) and
			$this->chkValidTagList('photo_tags', 'photo_tags', $this->LANG['common_photo_err_tip_invalid_tag']);
		if(isset($_POST['photo_category_type'])  && $_POST['photo_category_type']!='Porn')
		{
			if($_POST['photo_category_id']== '')
				$this->chkIsNotEmpty('photo_category_id', $this->LANG['common_photo_err_tip_compulsory']);
		}
		elseif(isset($_POST['photo_category_type']) && $_POST['photo_category_type']=='Porn')
		{
			if($_POST['photo_category_id_porn']== '')
				$this->chkIsNotEmpty('photo_category_id_porn', $this->LANG['common_photo_err_tip_compulsory']);
		}
		else
		{
			$this->chkIsNotEmpty('photo_category_id', $this->LANG['common_photo_err_tip_compulsory']);
		}

	}

	/**
	 * photoDefaultSettings::chkIsEditMode()
	 *
	 * @return boolean
	 */
	public function chkIsEditMode()
	{
		$sql = 'SELECT user_id FROM '.
				$this->CFG['db']['tbl']['photo_user_default_setting'].
				' WHERE user_id='.$this->dbObj->Param('user_id');
		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($this->CFG['user']['user_id']));
	    if (!$rs)
		    trigger_db_error($this->dbObj);
		if($row = $rs->FetchRow())
			return true;
		return false;
	}
	/**
	 * photoDefaultSettings::checkAlbumPrivateOrPublic()
	 *
	 *
	 */
	public function checkAlbumPrivateOrPublic()
	{
		$sql = 'SELECT photo_album_title,album_access_type FROM '.
				$this->CFG['db']['tbl']['photo_album'].
				' WHERE user_id='.$this->dbObj->Param('user_id').
				' AND photo_album_id='.$this->dbObj->Param('album_id');
		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($this->CFG['user']['user_id'],$this->fields_arr['album_id']));
	    if (!$rs)
		    trigger_db_error($this->dbObj);
		if($row = $rs->FetchRow())
		{
			if($row['album_access_type'] == 'Private')
			{
				$this->fields_arr['photo_album'] = '';
			}
			else
			{
				$this->fields_arr['photo_album'] = $row['photo_album_title'];
				//$this->fields_arr['album_id'] = '';
			}
			$this->fields_arr['photo_album_type'] = $row['album_access_type'];
		}
	}
	/**
	 * photoDefaultSettings::checkAlbumNameExist()
	 *
	 * @return boolean
	 */
	public function checkAlbumNameExist($album_type)
	{
		$qurstr='';
		if($album_type == 'Private')
		{
			$qurstr = ' AND user_id = '.$this->CFG['user']['user_id'];
		}
		else
		{
			$qurstr = ' AND album_access_type = \'Public\' ';
		}
		$sql = 'SELECT photo_album_id FROM '.
				$this->CFG['db']['tbl']['photo_album'].
				' WHERE photo_album_title='.$this->dbObj->Param('photo_album').$qurstr;
		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['photo_album']));
	    if (!$rs)
		    trigger_db_error($this->dbObj);
		if($row = $rs->FetchRow())
		{
			$this->fields_arr['album_id'] = $row['photo_album_id'];
			return true;
		}

		return false;
	}
	/**
	 * photoDefaultSettings::updatePhotoDetailsForUpload()
	 *
	 * @return boolean
	 */
	public function updatePhotoDetailsForUpload($fields_arr = array())
	{
		if($this->fields_arr['photo_category_type']=='Porn')
		{
			$this->fields_arr['photo_category_id'] = $this->fields_arr['photo_category_id_porn'];
		}
		if(!empty($this->fields_arr['photo_album']) && empty($this->fields_arr['album_id']))
		{
			if($this->fields_arr['photo_album_type']=='Private')
				$album_type = 'Private';
			else
				$album_type = 'Public';

			if(!$this->checkAlbumNameExist($album_type))
			{
				$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['photo_album'].
					   	' SET photo_album_title ='.$this->dbObj->Param('photo_album').', '.
					   	' album_access_type ='.$this->dbObj->Param('album_type').', '.
					   	' user_id ='.$this->dbObj->Param('user_id').', '.
					   	' date_added = now()';
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['photo_album'],$album_type,$this->CFG['user']['user_id']));
				if (!$rs)
			    	trigger_db_error($this->dbObj);
			    $this->fields_arr['album_id'] = $this->dbObj->Insert_ID();
		    }
		}
		else
	    {
	    	$this->fields_arr['album_id'] = $this->getFormField('album_id');
		}
		if($this->fields_arr['album_id'] == '' || $this->fields_arr['album_id'] ==0)
			$this->fields_arr['album_id'] = 1;
		$param_value_arr = array();
		if($this->chkIsEditMode())
			$sql = 'UPDATE '.
					$this->CFG['db']['tbl']['photo_user_default_setting'].
					' SET ';
		else
			$sql = 'INSERT INTO '.
				   	$this->CFG['db']['tbl']['photo_user_default_setting'].
				   	' SET ';
		foreach($fields_arr as $key => $fieldname)
		{
			$param_value_arr[] = $this->fields_arr[$fieldname];
			$sql .= $fieldname.'='.$this->dbObj->Param($fieldname).', ';
		}
		if($this->chkIsEditMode())
		{
			$sql = substr($sql, 0, strrpos($sql, ','));
			$sql .= ' WHERE user_id='.$this->dbObj->Param('user_id');
		}
		else
			$sql .= ' user_id='.$this->dbObj->Param('user_id');
		$param_value_arr[] = $this->CFG['user']['user_id'];
		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, $param_value_arr);

		if (!$rs)
		    trigger_db_error($this->dbObj);
		$this->fields_arr['relation_id']= explode(',',$this->fields_arr['relation_id']);
	}


	/**
	 * photoDefaultSettings::validateCommonFormFields()
	 *  To validate common Form fields
	 *
	 * @return void
	 */
	 	public function validateCommonFormFields()
		{
		echo 'odfjigdfi';
			$this->chkIsNotEmpty('photo_tags', $this->LANG['common_photo_err_tip_compulsory']) and
				$this->chkValidTagList('photo_tags', 'photo_tags', $this->LANG['common_photo_err_tip_invalid_tag']);
			if($this->chkAllowedModule(array('content_filter')))
			{
				echo 'here';
				if(isset($_POST['photo_category_id']) && $_POST['photo_category_id']!='' && $_POST['photo_category_type']!='Porn')
				{
					$this->chkIsNotEmpty('photo_category_id', $this->LANG['common_photo_err_tip_compulsory']);
				}
				else
				{
					$this->chkIsNotEmpty('photo_category_id_porn', $this->LANG['common_photo_err_tip_compulsory']);
				}
			}
			else
			{
				$this->chkIsNotEmpty('photo_category_id', $this->LANG['common_photo_err_tip_compulsory']);
			}

		}
/*
	public function validateCommonFormFields()
	{
		$this->chkIsNotEmpty('photo_category_id', $this->LANG['common_photo_err_tip_compulsory'])and
		$this->chkIsNotEmpty('photo_tags', $this->LANG['common_photo_err_tip_compulsory']) and
		$this->chkValidTagList('photo_tags', 'photo_tags', $this->LANG['common_photo_err_tip_invalid_tag']);

	}
*/
}
//echo '<pre>'; print_r($_REQUEST); echo '</pre>';
$photodefaultsetting = new photoDefaultSettings();

if(!chkAllowedModule(array('photo')))
	Redirect2URL($CFG['redirect']['dsabled_module_url']);


$photodefaultsetting->show_div = '';

if(strpos($CFG['site']['current_url'], '/admin/'))
	$photodefaultsetting->left_navigation_div = 'photoMain';
$photodefaultsetting->setPageBlockNames(array('block_photo_default_form'));
$photodefaultsetting->resetFieldsArray();
$photodefaultsetting->setAllPageBlocksHide();
$photodefaultsetting->setPageBlockShow('block_photo_default_form');


$common_err_tip_invalid_tag_min = str_replace('VAR_MIN', $CFG['fieldsize']['photo_tags']['min'],
													$LANG['common_photo_err_tip_invalid_tag']);
$LANG['common_err_tip_invalid_tag'] = str_replace('VAR_MAX', $CFG['fieldsize']['photo_tags']['max'],
													$common_err_tip_invalid_tag_min);
$photodefaultsetting->edit_completed = false;
$CFG['feature']['auto_hide_success_block'] = false;
$photodefaultsetting->sanitizeFormInputs($_REQUEST);

if(isAjaxPage())
{
	if($photodefaultsetting->isFormPOSTed($_POST, 'cid')) //Populate SubCategory
	{
		$photodefaultsetting->includeAjaxHeaderSessionCheck();
		$photodefaultsetting->populatePhotoSubCatagory($photodefaultsetting->getFormField('cid'));
		$photodefaultsetting->includeAjaxFooter();
		exit;
	}

}
else
{

	if($photodefaultsetting->isFormPOSTed($_POST, 'upload_photo')) //To Update other fields when uploading #also for edit photo updation
	{
		$photodefaultsetting->setAllPageBlocksHide();
		$photodefaultsetting->sanitizeFormInputs($_POST);
		$photodefaultsetting->validationFormFields1();
		if($photodefaultsetting->isValidFormInputs())
		{
			if(isset($_POST['photo_category_id']))
				$photodefaultsetting->setFormField('photo_category_id', $_POST['photo_category_id']);
			else
				$photodefaultsetting->setFormField('photo_category_id', isset($_POST['photo_category_id_porn'])?$_POST['photo_category_id_porn']:'');
			if($photodefaultsetting->getFormField('photo_access_type')=='Private')
			{
				$relation_id = implode(',',$photodefaultsetting->getFormField('relation_id'));
				$photodefaultsetting->setFormField('relation_id', $relation_id);
			}
			else
				$photodefaultsetting->setFormField('relation_id','');

			if($photodefaultsetting->getFormField('album_id_public')!='')
			{
				$photodefaultsetting->setFormField('album_id', $photodefaultsetting->getFormField('album_id_public'));
			}

			$fields_arr = array('photo_category_id','photo_sub_category_id','photo_tags','allow_tags',
								'photo_access_type','allow_comments','allow_ratings','album_id','relation_id'
								);
			$photodefaultsetting->updatePhotoDetailsForUpload($fields_arr);
			$photodefaultsetting->setCommonSuccessMsg($LANG['photoupload_msg_success_default_settings']);
			$photodefaultsetting->setPageBlockShow('block_photo_default_form');
			$photodefaultsetting->setPageBlockShow('block_msg_form_success');
		}
		else
		{
			$photodefaultsetting->setCommonErrorMsg($LANG['common_photo_msg_error_sorry']);
			$photodefaultsetting->setPageBlockShow('block_msg_form_error');
			$photodefaultsetting->setPageBlockShow('block_photo_default_form');

		}
	}

}
//default form fields and values...
if($photodefaultsetting->chkIsEditMode() && !$photodefaultsetting->isFormPOSTed($_POST, 'upload_photo'))
{
	$photodefaultsetting->populateDefaultPhotoDetails();
	$photodefaultsetting->getPhotoCategoryType();
}
if($photodefaultsetting->getFormField('album_id'))
{
	$photodefaultsetting->checkAlbumPrivateOrPublic();
}
$photodefaultsetting->photoUpload_tags_msg = str_replace(array('{tag_min_chars}','{tag_max_chars}'),
										array($CFG['fieldsize']['photo_tags']['min'],$CFG['fieldsize']['photo_tags']['max']),
											$LANG['photoupload_tags_msg1']);


$photodefaultsetting->content_filter = false;

if($photodefaultsetting->chkAllowedModule(array('content_filter')) && isAdultUser('','photo'))
{
	$photodefaultsetting->content_filter = true;
	$photodefaultsetting->Porn = $photodefaultsetting->General = 'none';
	$photo_category_type = $photodefaultsetting->getFormField('photo_category_type');
	$$photo_category_type = '';
}
else
{
	$photodefaultsetting->Porn = $photodefaultsetting->General = '';
}
if($photodefaultsetting->getFormField('photo_category_type') == 'General')
{
	$photodefaultsetting->General ='';
}
else
{
	$photodefaultsetting->Porn = '';
}

$photodefaultsetting->includeHeader();
?>
<script type="text/javascript" src="<?php echo $CFG['site']['url']; ?>js/lib/validation/validation.js"></script>

<?php
setTemplateFolder('general/', $CFG['site']['is_module_page']);
$smartyObj->display('photoDefaultSettings.tpl');

?>
<script type="text/javascript">
var block_arr= new Array('selMsgConfirm');
/**
 *
 * @access public
 * @return void
 **/
function checkPublic()
{
	if($Jq('#photo_album_type').is(':checked'))
	{
		$Jq('#selAlbumId').css('display', 'block');
		$Jq('#selAlbumName').css('display', 'none');
		$Jq('#photo_album').val('');
		$Jq('#album_id').val('');
		$Jq('#album_id_public').val('');
	}
	else
	{
		$Jq('#photo_album').val(old_photo_album_name);
		$Jq('#selAlbumId').css('display', 'none');
		$Jq('#selAlbumName').css('display', 'block');
		$Jq('#album_id').val('');
	}

}
/**
 *
 * @access public
 * @return void
 **/
function changToText()
{
	$Jq('#selAlbumId').css('display', 'none');
	$Jq('#selAlbumName').css('display', 'block');
	$Jq('#selPhotoAlbumTextBox').css('display', 'block');
	$Jq('#photo_album').val('');
	$Jq('#album_id').val('');
}
/**
 *
 * @access public
 * @return void
 **/
function changToDropdown()
{
	$Jq('#selAlbumId').css('display', 'block');
	$Jq('#selAlbumName').css('display', 'none');
	$Jq('#album_id').val('');
	$Jq('#photo_album').val('');
}

function changToAlbumTextBox()
{
	$Jq('#selPhotoAlbumTextBox').css('display', 'block');
	$Jq('#album_id').val('');
	$Jq('#photo_album').val('');
}
/**
 *
 * @access public
 * @return void
 **/
function changToDropdownPublic()
{
	$Jq('#selPhotoAlbumTextBox').css('display', 'none');
	$Jq('#selOpenTextBox').css('display', 'block');
	$Jq('#album_id').val('');
	$Jq('#photo_album').val('');
}


function populatePhotoSubCategory(cat)
	{
			var url = '<?php echo $CFG['site']['photo_url'].'photoDefaultSettings.php';?>';
			var pars = 'ajax_page=true&cid='+cat;
			<?php if($photodefaultsetting->getFormField('photo_sub_category_id')){?>
			pars = pars+'&photo_sub_category_id=<?php echo $photodefaultsetting->getFormField('photo_sub_category_id');?>';
			<?php }?>
			var method_type = 'post';
			populateSubCategoryRequest(url, pars, method_type);
	}
<?php if($photodefaultsetting->getFormField('photo_category_id')){?>
	populatePhotoSubCategory('<?php echo $photodefaultsetting->getFormField('photo_category_id'); ?>');
<?php }?>
</script>
<?php
/* Added code to validate mandataory fields in photo defaut settings page */
if ($CFG['feature']['jquery_validation'] && $photodefaultsetting->isShowPageBlock('block_photo_default_form'))
{
?>
	<script type="text/javascript">
	var tag_min='<?php echo  $CFG['fieldsize']['photo_tags']['min']; ?>';
	var tag_max='<?php echo  $CFG['fieldsize']['photo_tags']['max']; ?>';
	$Jq("#photo_upload_form").validate({
		rules: {
		    photo_tags: {
				required: true,
				chkValidTags: Array(tag_min, tag_max)
			},
			photo_category_id: {
		         required: "div#selGeneralCategory:visible"
			},
			photo_category_id_porn: {
		          required: "div#selPornCategory:visible"
			}
		},
		messages: {
			photo_tags: {
				required: "<?php echo $LANG['common_err_tip_required'];?>",
				chkValidTags: "<?php echo $LANG['common_err_tip_invalid_tag'];?>"
			},
			photo_category_id: {
				required: "<?php echo $LANG['common_err_tip_required'];?>"
			},
			photo_category_id_porn: {
				required: "<?php echo $LANG['common_err_tip_required'];?>"
			}
		}
	});
</script>
<?php
}
$photodefaultsetting->includeFooter();
?>