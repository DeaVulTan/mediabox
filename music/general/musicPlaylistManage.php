<?php
//--------------class musicPlaylistManage--------------->>>//
/**
 * This class is used to manage music playlist
 *
 * @category	Rayzz
 * @package		manage music playlist
 * @copyright 	Copyright (c) 2009 - 2010 {@link http://www.mediabox.uz Uzdc Infoway}
 */
class musicPlaylistManage extends MusicHandler
	{
		/**
		 * musicPlaylistManage::clearForm()
		 *
		 * @return
		 */
		public function clearHistory()
			{
				$this->fields_arr['playlist_id'] = '';
				$this->fields_arr['playlist_name'] = '';
				$this->fields_arr['playlist_description'] = '';
				$this->fields_arr['playlist_tags'] = '';
				$this->fields_arr['allow_comments'] = 'Yes';
				$this->fields_arr['allow_ratings'] = 'Yes';
			}

		/**
		 * musicPlaylistManage::showPlaylists()
		 *
		 * @return
		 */
		public function showPlaylists()
			{
				$showPlaylists_arr = array();
				//Image..

				$inc=0;
				while($row = $this->fetchResultRecord())
					{
						$showPlaylists_arr[$inc]['anchor']= 'dAlt_'.$row['playlist_id'];
						$showPlaylists_arr[$inc]['playlist_id']=$row['playlist_id'];
						$showPlaylists_arr[$inc]['playlist_name']=nl2br(makeClickableLinks($row['playlist_name']));
						//Playlist image
						$showPlaylists_arr[$inc]['getPlaylistImageDetail'] = $this->getPlaylistImageDetail($row['playlist_id']);// This function return playlist image detail array..//
						$showPlaylists_arr[$inc]['total_tracks']=$row['total_tracks'];
						$showPlaylists_arr[$inc]['playlist_view_link']= getUrl('viewplaylist', '?playlist_id='.$row['playlist_id'].'&amp;title='.$this->changeTitle($row['playlist_name']), $row['playlist_id'].'/'.$this->changeTitle($row['playlist_name']).'/', '', 'music');
						$showPlaylists_arr[$inc]['playlist_edit_link']=getUrl('musiclist', '?pg=myplaylist&playlist_id='.$row['playlist_id'], 'myplaylist/?playlist_id='.$row['playlist_id'], '', 'music');
						$showPlaylists_arr[$inc]['edit_link']=getUrl('musicplaylistmanage', '?playlist_id='.$row['playlist_id'], '?playlist_id='.$row['playlist_id'], 'members', 'music');
						$showPlaylists_arr[$inc]['record']=$row;
						$inc++;
					}
				return $showPlaylists_arr;
			}

		/**
		 * MyPlaylists::buildConditionQuery()
		 *
		 * @return
		 **/
		public function buildConditionQuery()
			{
				$this->sql_condition = 'pl.user_id=\''.$this->CFG['user']['user_id'].'\'';
			}

		/**
		 * MyPlaylists::buildSortQuery()
		 *
		 * @return
		 **/
		public function buildSortQuery()
			{
				$this->sql_sort = 'playlist_id DESC';
			}
	}
//<<<<<-------------- Class musicPlaylistManage end ---------------//
//-------------------- Code begins -------------->>>>>//
$musicPlaylistManage = new musicPlaylistManage();
if(!chkAllowedModule(array('music')))
	Redirect2URL($CFG['redirect']['dsabled_module_url']);
/*echo '<pre>';
print_r($_REQUEST);
echo '</pre>';*/
$musicPlaylistManage->setPageBlockNames(array('create_playlist_block', 'list_playlist_block'));
$musicPlaylistManage->setFormField('playlist_name', '');
$musicPlaylistManage->setFormField('playlist_description', '');
$musicPlaylistManage->setFormField('playlist_tags', '');
$musicPlaylistManage->setFormField('playlist_id', '');
$musicPlaylistManage->setFormField('allow_comments', 'Yes');
$musicPlaylistManage->setFormField('allow_ratings', 'Yes');
$musicPlaylistManage->setFormField('allow_embed', 'Yes');
$musicPlaylistManage->setFormField('playlist_ids', '');
$musicPlaylistManage->setFormField('start', '0');
$musicPlaylistManage->setFormField('action', '');
$musicPlaylistManage->setFormField('playlist_ids', array());
$musicPlaylistManage->setFormField('numpg', $CFG['data_tbl']['numpg']);
$musicPlaylistManage->setMinRecordSelectLimit(2);
$musicPlaylistManage->setMaxRecordSelectLimit($CFG['data_tbl']['max_record_select_limit']);
$musicPlaylistManage->setNumPerPageListArr($CFG['data_tbl']['numperpage_list_arr']);
$musicPlaylistManage->setTableNames(array($CFG['db']['tbl']['music_playlist'].' as pl LEFT JOIN '.$CFG['db']['tbl']['music'].' as p ON pl.thumb_music_id=p.music_id' ));
$musicPlaylistManage->setReturnColumns(array('pl.playlist_id', 'pl.playlist_name', 'pl.date_added', 'pl.thumb_music_id as music_id', 'pl.thumb_ext as music_ext', 'pl.total_tracks', 'p.small_width', 'p.small_height', 'p.music_server_url'));
$musicPlaylistManage->setAllPageBlocksHide();
$musicPlaylistManage->setPageBlockShow('create_playlist_block');
$musicPlaylistManage->setPageBlockShow('list_playlist_block');
$musicPlaylistManage->sanitizeFormInputs($_REQUEST);
$musicPlaylistManage->createplaylist_url = getUrl('musicplaylistmanage', '', '', 'members', 'music');
if($musicPlaylistManage->isFormPOSTed($_POST, 'playlist_submit'))
	{
		$musicPlaylistManage->chkIsNotEmpty('playlist_name', $LANG['musicplaylist_tip_compulsory'])and
		$musicPlaylistManage->chkIsValidSize('playlist_name','music_playlist_name',$LANG['musicplaylist_invalid_size'])and
		$musicPlaylistManage->chkPlaylistExits('playlist_name', $LANG['musicplaylist_err_tip_alreay_exists']);
		$musicPlaylistManage->chkIsNotEmpty('playlist_description', $LANG['musicplaylist_tip_compulsory']);
		$musicPlaylistManage->chkIsNotEmpty('playlist_tags', $LANG['musicplaylist_tip_compulsory']);
		$musicPlaylistManage->chkValidTagList('playlist_tags','music_playlist_tags', $LANG['musicplaylist_err_tip_invalid_tag']);
		$musicPlaylistManage->setPageBlockShow('create_playlist_block');
		if($musicPlaylistManage->isValidFormInputs())
			{
				$musicPlaylistManage->createplaylist();
				if($musicPlaylistManage->getFormField('playlist_id'))
					{
						$musicPlaylistManage->setPageBlockShow('block_msg_form_success');
						$musicPlaylistManage->setCommonSuccessMsg($LANG['musicplaylist_update_successfully']);
					}
				else
					{
						$musicPlaylistManage->setPageBlockShow('block_msg_form_success');
						$musicPlaylistManage->setCommonSuccessMsg($LANG['musicplaylist_created_successfully']);
					}
				$musicPlaylistManage->clearHistory();
			}
		else
			{
				$musicPlaylistManage->setPageBlockShow('block_msg_form_error');
				$musicPlaylistManage->setCommonErrorMsg($LANG['musicplaylist_create_failure']);
			}
	}
if($musicPlaylistManage->getFormField('playlist_id'))
	{
		if(!$musicPlaylistManage->getMusicPlaylist())
			{
				$musicPlaylistManage->setPageBlockShow('block_msg_form_error');
				$musicPlaylistManage->setCommonErrorMsg($LANG['musicplaylist_invalid_id']);
			}
	}
if($musicPlaylistManage->getFormField('action'))
	{
		$musicPlaylistManage->setAllPageBlocksHide();
		$musicPlaylistManage->setPageBlockShow('create_playlist_block');
		$musicPlaylistManage->setPageBlockShow('list_playlist_block');
		switch($musicPlaylistManage->getFormField('action'))
			{
				case 'delete':
					$musicPlaylistManage->deleteMusicPlaylist();
					$musicPlaylistManage->setCommonSuccessMsg($LANG['musicplaylist_delete_successfully']);
					$musicPlaylistManage->setPageBlockShow('block_msg_form_success');
				break;
			}
	}
//<<<<<-------------- Code end ----------------------------------------------//
//-------------------- Page block templates begins -------------------->>>>>//
if ($musicPlaylistManage->isShowPageBlock('list_playlist_block'))
	{
		/****** navigtion continue*********/
		$musicPlaylistManage->buildSelectQuery();
		$musicPlaylistManage->buildConditionQuery();
		$musicPlaylistManage->buildSortQuery();
		$musicPlaylistManage->buildQuery();
		$musicPlaylistManage->executeQuery();
		if($musicPlaylistManage->isResultsFound())
			{
				$musicPlaylistManage->hidden_arr = array('start');
				$musicPlaylistManage->list_playlist_block['showPlaylists'] = $musicPlaylistManage->showPlaylists();
				$smartyObj->assign('smarty_paging_list', $musicPlaylistManage->populatePageLinksGET($musicPlaylistManage->getFormField('start'), array()));
			}
	}
 if ($musicPlaylistManage->chkIsAdminSide())
	$musicPlaylistManage->left_navigation_div = 'musicMain';
//include the header file
$musicPlaylistManage->includeHeader();
//include the content of the page
setTemplateFolder('general/','music');
$smartyObj->display('musicPlaylistManage.tpl');
//includ the footer of the page
//<<<<<<--------------------Page block templates Ends--------------------//
?>
<script type="text/javascript" src="<?php echo $CFG['site']['url'];?>js/JSFCommunicator.js"></script>
<script type="text/javascript" src="<?php echo $CFG['site']['url'];?>js/swfobject.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo $CFG['site']['url'];?>design/templates/<?php echo $CFG['html']['template']['default'];?>/admin/css/reOrder.css">
<link rel="stylesheet" type="text/css" href="<?php echo $CFG['site']['url'];?>design/templates/<?php echo $CFG['html']['template']['default'];?>/admin/css/fonts-min.css">
<script type="text/javascript" src="<?php echo $CFG['site']['url'];?>js/yahoo-dom-event.js"></script>
<script type="text/javascript" src="<?php echo $CFG['site']['url'];?>js/animation-min.js"></script>
<script type="text/javascript" src="<?php echo $CFG['site']['url'];?>js/dragdrop-min.js"></script>
<script type="text/javascript" src="<?php echo $CFG['site']['url'];?>js/reOrder.js"></script>
<script type="text/javascript" src="<?php echo $CFG['site']['music_url'];?>js/organizeList.js"></script>
<script language="javascript"   type="text/javascript">
	var block_arr= new Array('selMsgConfirm', 'selMsgConfirmSingle');
	var replace_url = '<?php echo $CFG['site']['url'];?>login.php';
	var please_select_action = '<?php echo $LANG['err_tip_select_action'];?>';
	var site_url = '<?php echo $CFG['site']['music_url'];?>';
	var confirm_message = '';
	function getAction(act_value)
		{
			if(act_value)
				{
					switch (act_value)
						{
							case 'delete':
								confirm_message = '<?php echo $LANG['musicplaylist_multi_delete_confirmation'];?>';
								break;
						}
					$Jq('#confirmMessage').html(confirm_message);
					document.msgConfirmform.action.value = act_value;
					Confirmation('selMsgConfirm', 'msgConfirmform', Array('playlist_ids'), Array(multiCheckValue), Array('value'),'selFormForums');
				}
				else
					alert_manual(please_select_action);
		}
</script>
<?php
if($musicPlaylistManage->isShowPageBlock('create_playlist_block') and $CFG['feature']['jquery_validation'])
{
	?>
		<script type="text/javascript">
			$Jq("#musicPlayListManage").validate({
				rules: {
					playlist_name: {
						required: true,
						minlength: <?php echo $CFG['fieldsize']['music_playlist_name']['min']; ?>,
						maxlength: <?php echo $CFG['fieldsize']['music_playlist_name']['max']; ?>
				    },
				    playlist_description: {
				    	required: true
				    },
				    playlist_tags: {
				    	required: true,
				    	minlength: <?php echo $CFG['fieldsize']['music_playlist_tags']['min']; ?>,
						maxlength: <?php echo $CFG['fieldsize']['music_playlist_tags']['max']; ?>
				    }
				},
				messages: {
					playlist_name: {
						required: "<?php echo $musicPlaylistManage->LANG['common_err_tip_compulsory'];?>"
					},
					playlist_description: {
						required: "<?php echo $musicPlaylistManage->LANG['common_err_tip_compulsory'];?>"
					},
					playlist_tags: {
						required: "<?php echo $musicPlaylistManage->LANG['common_err_tip_compulsory'];?>"
					}
				}
			});
		</script>
	<?php
}
$musicPlaylistManage->includeFooter();
?>