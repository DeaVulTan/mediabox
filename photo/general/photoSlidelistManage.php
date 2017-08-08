<?php
//--------------class photoSlidelistManage--------------->>>//
/**
 * This class is used to manage photo playlist
 *
 * @category	Rayzz
 * @package		manage photo playlist
 * @copyright 	Copyright (c) 2009 - 2010 {@link http://www.mediabox.uz Uzdc Infoway}
 */
class photoSlidelistManage extends PhotoHandler
	{
		/**
		 * photoSlidelistManage::clearForm()
		 *
		 * @return
		 */
		public function clearHistory()
			{
				$this->fields_arr['photo_playlist_id'] = '';
				$this->fields_arr['playlist_name'] = '';
				$this->fields_arr['playlist_description'] = '';
			}

		/**
		 * photoSlidelistManage::showPlaylists()
		 *
		 * @return
		 */
		public function showPlaylists()
			{
				$showPlaylists_arr = array();
				//Image..

				$inc=0;
				$this->photo_playlist_ids=array();
				while($row = $this->fetchResultRecord())
					{
						$showPlaylists_arr[$inc]['anchor']= 'dAlt_'.$row['photo_playlist_id'];
						$showPlaylists_arr[$inc]['photo_playlist_id']=$row['photo_playlist_id'];
						$this->photo_playlist_ids[$inc]=$row['photo_playlist_id'];
						$showPlaylists_arr[$inc]['playlist_name']=nl2br(makeClickableLinks($row['photo_playlist_name']));
						//Playlist image
						$showPlaylists_arr[$inc]['getPlaylistImageDetail'] = $this->getPlaylistImageDetail($row['photo_playlist_id']);// This function return playlist image detail array..//
						$showPlaylists_arr[$inc]['total_photos']=$row['total_photos'];
						$showPlaylists_arr[$inc]['playlist_view_link'] = getUrl('flashshow', '?slideshow=pl&playlist='.$row['photo_playlist_id'], 'pl/'.$row['photo_playlist_id'].'/', '','photo');
						$showPlaylists_arr[$inc]['playlist_edit_link']=getUrl('photolist', '?pg=myplaylist&photo_playlist_id='.$row['photo_playlist_id'], 'myplaylist/?photo_playlist_id='.$row['photo_playlist_id'], '', 'photo');
						$showPlaylists_arr[$inc]['edit_link']=getUrl('photoslidelistmanage', '?photo_playlist_id='.$row['photo_playlist_id'], '?photo_playlist_id='.$row['photo_playlist_id'], '', 'photo');
						$showPlaylists_arr[$inc]['record']=$row;
						$inc++;
					}
				return $showPlaylists_arr;
			}

		/**
		 * photoSlidelistManage::buildConditionQuery()
		 *
		 * @return
		 **/
		public function buildConditionQuery()
			{
				$this->sql_condition = 'pl.created_by_user_id=\''.$this->CFG['user']['user_id'].'\' GROUP BY pl.photo_playlist_id';
			}

		/**
		 * photoSlidelistManage::buildSortQuery()
		 *
		 * @return
		 **/
		public function buildSortQuery()
			{
				$this->sql_sort = 'photo_playlist_id DESC';
			}
	}
//<<<<<-------------- Class photoSlidelistManage end ---------------//
//-------------------- Code begins -------------->>>>>//
$photoSlidelistManage = new photoSlidelistManage();
if(!chkAllowedModule(array('photo')))
	Redirect2URL($CFG['redirect']['dsabled_module_url']);
/*echo '<pre>';
print_r($_REQUEST);
echo '</pre>';*/
$photoSlidelistManage->setPageBlockNames(array('create_playlist_block', 'list_playlist_block'));
$photoSlidelistManage->setFormField('playlist_name', '');
$photoSlidelistManage->setFormField('playlist_description', '');
$photoSlidelistManage->setFormField('photo_playlist_id', '');
$photoSlidelistManage->setFormField('photo_playlist_ids', '');
$photoSlidelistManage->setFormField('start', '0');
$photoSlidelistManage->setFormField('action', '');
$photoSlidelistManage->setFormField('photo_playlist_ids', array());
$photoSlidelistManage->setFormField('numpg', $CFG['data_tbl']['numpg']);
$photoSlidelistManage->setMinRecordSelectLimit(2);
$photoSlidelistManage->setMaxRecordSelectLimit($CFG['data_tbl']['max_record_select_limit']);
$photoSlidelistManage->setNumPerPageListArr($CFG['data_tbl']['numperpage_list_arr']);
//$photoSlidelistManage->setTableNames(array($CFG['db']['tbl']['photo_playlist'].' as pl LEFT JOIN '.$CFG['db']['tbl']['photo'].' as p ON pl.photo_playlist_id=p.photo_id' ));
$photoSlidelistManage->setTableNames(array($CFG['db']['tbl']['photo_playlist'].' AS pl LEFT JOIN '.$CFG['db']['tbl']['photo_in_playlist'].' AS pip ON pip.photo_playlist_id = pl.photo_playlist_id
  LEFT JOIN '.$CFG['db']['tbl']['photo'].' As p ON pip.photo_id=p.photo_id' ));
$photoSlidelistManage->setReturnColumns(array('pl.photo_playlist_id', 'pl.photo_playlist_name', 'pl.date_added', 'pl.total_photos', 'p.photo_ext', 'p.s_width', 'p.s_height', 'p.photo_server_url'));
$photoSlidelistManage->setAllPageBlocksHide();
$photoSlidelistManage->setPageBlockShow('create_playlist_block');
$photoSlidelistManage->setPageBlockShow('list_playlist_block');
$photoSlidelistManage->sanitizeFormInputs($_REQUEST);
$photoSlidelistManage->createplaylist_url = getUrl('photoslidelistmanage', '', '', '', 'photo');
if($photoSlidelistManage->isFormPOSTed($_POST, 'playlist_submit'))
	{
		$photoSlidelistManage->chkIsNotEmpty('playlist_name', $LANG['photoslidelist_tip_compulsory'])and
		$photoSlidelistManage->chkIsValidSize('playlist_name','photo_playlist_name',$LANG['photoslidelist_invalid_size'])and
		$photoSlidelistManage->chkPlaylistExits('playlist_name', $LANG['photoslidelist_err_tip_alreay_exists']);
		$photoSlidelistManage->chkIsNotEmpty('playlist_description', $LANG['photoslidelist_tip_compulsory']);
		$photoSlidelistManage->setPageBlockShow('create_playlist_block');
		if($photoSlidelistManage->isValidFormInputs())
			{
				$photoSlidelistManage->createplaylist();
				if($photoSlidelistManage->getFormField('photo_playlist_id'))
					{
						$photoSlidelistManage->setPageBlockShow('block_msg_form_success');
						$photoSlidelistManage->setCommonSuccessMsg($LANG['photoslidelist_update_successfully']);
					}
				else
					{
						$photoSlidelistManage->setPageBlockShow('block_msg_form_success');
						$photoSlidelistManage->setCommonSuccessMsg($LANG['photoslidelist_created_successfully']);
					}
				$photoSlidelistManage->clearHistory();
			}
		else
			{
				$photoSlidelistManage->setPageBlockShow('block_msg_form_error');
				$photoSlidelistManage->setCommonErrorMsg($LANG['photoslidelist_create_failure']);
			}
	}
if($photoSlidelistManage->getFormField('photo_playlist_id'))
	{
		if(!$photoSlidelistManage->getPhotoPlaylist())
			{
				$photoSlidelistManage->setPageBlockShow('block_msg_form_error');
				$photoSlidelistManage->setCommonErrorMsg($LANG['photoslidelist_invalid_id']);
			}
	}
if($photoSlidelistManage->getFormField('action'))
	{
		$photoSlidelistManage->setAllPageBlocksHide();
		$photoSlidelistManage->setPageBlockShow('create_playlist_block');
		$photoSlidelistManage->setPageBlockShow('list_playlist_block');
		switch($photoSlidelistManage->getFormField('action'))
			{
				case 'delete':
					$photoSlidelistManage->deletePhotoPlaylist();
					$photoSlidelistManage->setCommonSuccessMsg($LANG['photoslidelist_delete_successfully']);
					$photoSlidelistManage->setPageBlockShow('block_msg_form_success');
				break;
			}
	}
$playlistIds='';
//<<<<<-------------- Code end ----------------------------------------------//
//-------------------- Page block templates begins -------------------->>>>>//
if ($photoSlidelistManage->isShowPageBlock('list_playlist_block'))
	{
		/****** navigtion continue*********/
		$photoSlidelistManage->buildSelectQuery();
		$photoSlidelistManage->buildConditionQuery();
		$photoSlidelistManage->buildSortQuery();
		$photoSlidelistManage->buildQuery();
		//$photoSlidelistManage->printQuery();
		$photoSlidelistManage->homeExecuteQuery();
		if($photoSlidelistManage->isResultsFound())
			{
				$photoSlidelistManage->hidden_arr = array('start');
				$photoSlidelistManage->list_playlist_block['showPlaylists'] =$playlistArr=$photoSlidelistManage->showPlaylists();
				$playlistIds=implode('\',\'',$photoSlidelistManage->photo_playlist_ids);
				$smartyObj->assign('smarty_paging_list', $photoSlidelistManage->populatePageLinksGET($photoSlidelistManage->getFormField('start'), array()));
			}
	}
if ($photoSlidelistManage->chkIsAdminSide())
	$photoSlidelistManage->left_navigation_div = 'photoMain';
//print_r($playlistIds);
//include the header file
$photoSlidelistManage->includeHeader();
//include the content of the page
setTemplateFolder('general/','photo');
$smartyObj->display('photoSlidelistManage.tpl');
//includ the footer of the page
//<<<<<<--------------------Page block templates Ends--------------------//
?>
<link rel="stylesheet" type="text/css" href="<?php echo $CFG['site']['url'];?>design/templates/<?php echo $CFG['html']['template']['default'];?>/admin/css/reOrder.css">
<link rel="stylesheet" type="text/css" href="<?php echo $CFG['site']['url'];?>design/templates/<?php echo $CFG['html']['template']['default'];?>/admin/css/fonts-min.css">
<script language="javascript"   type="text/javascript">
	var block_arr= new Array('selMsgConfirm', 'selMsgConfirmSingle');
	var replace_url = '<?php echo $CFG['site']['url'];?>login.php';
	var please_select_action = '<?php echo $LANG['err_tip_select_action'];?>';
	var photo_site_url = '<?php echo $CFG['site']['photo_url'];?>';
	var confirm_message = '';
	var manage_slidelist_ids = Array('<?php echo $playlistIds?>');
	function getAction(act_value)
		{
			if(act_value)
				{
					switch (act_value)
						{
							case 'delete':
								confirm_message = '<?php echo $LANG['photoslidelist_multi_delete_confirmation'];?>';
								break;
						}
					$Jq('#confirmMessage').html(confirm_message);
					document.msgConfirmform.action.value = act_value;
					Confirmation('selMsgConfirm', 'msgConfirmform', Array('photo_playlist_ids'), Array(multiCheckValue), Array('value'),'selFormForums');
				}
				else
					alert_manual(please_select_action);
		}
</script>
<?php
if($CFG['feature']['jquery_validation'] and $photoSlidelistManage->isShowPageBlock('create_playlist_block'))
	{
?>
		<script type="text/javascript">
			$Jq("#photoPlayListManage").validate({
				rules: {
					playlist_name: {
						required: true,
						minlength: <?php echo $CFG['fieldsize']['photo_playlist_name']['min']; ?>,
		    			maxlength: <?php echo $CFG['fieldsize']['photo_playlist_name']['max']; ?>
				    },
				    playlist_description: {
						required: true
				    }

				},
				messages: {
					playlist_name: {
						required: "<?php echo $LANG['common_err_tip_required'];?>",
						minlength: jQuery.format("{0} <?php echo $LANG['common_err_tip_min_characters'];?>"),
						maxlength: jQuery.format("<?php echo $LANG['common_err_tip_max_characters'];?> {0}")
					},
					playlist_description: {
						required: "<?php echo $LANG['common_err_tip_required']; ?>"
				    }

				}
			});
		</script>
<?php
	}
$photoSlidelistManage->includeFooter();
?>