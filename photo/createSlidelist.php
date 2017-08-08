<?php
/**
 * This file for use light window and normal
 *
 * This file is having create photo playlist. Here we create playlist
 *
 *
 * @category	Rayzz/Photo
 * @package		member
 *
 **/
require_once('../common/configs/config.inc.php');
require_once('../common/configs/config_photo_fieldsize.inc.php');
$CFG['site']['is_module_page'] = 'photo';
$CFG['lang']['include_files'][] = 'languages/%s/photo/viewSlidelist.php';
$CFG['lang']['include_files'][] = 'languages/%s/photo/help.inc.php';
$CFG['mods']['include_files'][] = 'common/classes/class_ListRecordsHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MediaHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_PhotoHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_PhotoActivityHandler.lib.php';
$CFG['auth']['is_authenticate'] = 'members';
if(isset($_REQUEST['light_window']))
{
	$CFG['html']['header'] = 'general/html_header_no_header.php';
	$CFG['html']['footer'] = 'general/html_footer_no_footer.php';
	$CFG['mods']['is_include_only']['html_header'] = false;
	$CFG['html']['is_use_header'] = false;
	$CFG['admin']['light_window_page'] = true;
	//To show session expired content inside lightwindow if session got expired
	$CFG['admin']['session_redirect_light_window_page'] = true;
}
else
{
	$CFG['html']['header'] = 'general/html_header.php';
	$CFG['html']['footer'] = 'general/html_footer.php';
	$CFG['mods']['is_include_only']['html_header'] = false;
	$CFG['html']['is_use_header'] = false;
}
require($CFG['site']['project_path'].'common/application_top.inc.php');
//--------------class managePlaylist--------------->>>//
/**
 * This class is used to manage photo playlist
 *
 * @category	Rayzz
 * @package		manage photo playlist
 */
class managePlaylist extends PhotoHandler
{

}
//<<<<<-------------- Class managePlaylist end ---------------//
//-------------------- Code begins -------------->>>>>//
$managePlaylist = new managePlaylist();
if(!chkAllowedModule(array('photo')))
	Redirect2URL($CFG['redirect']['dsabled_module_url']);

$managePlaylist->setPageBlockNames(array('create_playlist_block'));
$managePlaylist->setFormField('photo_id', '');
$managePlaylist->setFormField('photo_playlist_id', '');
$managePlaylist->setFormField('playlist_name', '');
$managePlaylist->setFormField('playlist_tags', '');
$managePlaylist->setFormField('playlist_description', '');
$managePlaylist->setFormField('light_window', '');
$managePlaylist->setFormField('action', '');
$managePlaylist->setFormField('ajaxpage', '');
$managePlaylist->setFormField('allow_comments', 'Yes');
$managePlaylist->setFormField('allow_ratings', 'Yes');
$managePlaylist->setFormField('allow_embed', 'Yes');
$managePlaylist->setFormField('mode', '');
$managePlaylist->setFormField('qm', '');
$managePlaylist->setFormField('page', '');
$managePlaylist->setFormField('playlist_name_select', '');
$CFG['data_tbl']['css_alternative_row_classes']=array();
$managePlaylist->sanitizeFormInputs($_REQUEST);
$managePlaylist->playlist_name_notes = str_replace('VAR_MIN', $CFG['fieldsize']['photo_playlist_name']['min'], $LANG['playlist_name_notes']);
$managePlaylist->playlist_name_notes = str_replace('VAR_MAX', $CFG['fieldsize']['photo_playlist_name']['max'], $managePlaylist->playlist_name_notes);
$managePlaylist->playlist_tags_notes = str_replace('VAR_MIN', $CFG['fieldsize']['photo_playlist_tags']['min'], $LANG['playlist_tags_notes']);
$managePlaylist->playlist_tags_notes = str_replace('VAR_MAX', $CFG['fieldsize']['photo_playlist_tags']['max'], $managePlaylist->playlist_tags_notes);
$managePlaylist->playlistUrl = $CFG['site']['photo_url'].'createSlidelist.php?ajax_page=true&amp;ajaxpage=create_playlist';

if($managePlaylist->getFormField('qm'))
	$managePlaylist->setFormField('photo_id', $_SESSION['user']['photo_quick_mixs']);

if($managePlaylist->getFormField('action') != '')
{
	switch ($managePlaylist->getFormField('action'))
	{
		case 'save_playlist':
			$managePlaylist->getPlaylistIdInPhoto($managePlaylist->getFormField('photo_id'));
			$managePlaylist->displayCreatePlaylistInterface();
			$managePlaylist->setPageBlockShow('create_playlist_block');
		break;
	}
}
if(isAjaxPage())
{
	$managePlaylist->includeAjaxHeaderSessionCheck();
	$managePlaylist->sanitizeFormInputs($_REQUEST);
	if($managePlaylist->getFormField('ajaxpage') != '')
	{
		switch ($managePlaylist->getFormField('ajaxpage'))
		{
			case 'create_playlist'://CREATE PLAYLIST//
				$flag = 1;
				/*if(($managePlaylist->getFormField('playlist_name')== '') or ($managePlaylist->getFormField('playlist_tags')== ''))
					{
						$flag =0;
						echo '***--***!!!';
						$managePlaylist->setCommonErrorMsg($LANG['photoplaylist_error_tips']);
						$managePlaylist->setPageBlockShow('block_msg_form_error');
						break;
					}*/
				if($managePlaylist->getFormField('playlist_name')!= '')
				{
					if(!$managePlaylist->chkPlaylistExits('playlist_name'))// CHEACK ALREADY EXISTS //
					{
						$flag =0;
						echo '***--***!!!';
						$managePlaylist->setCommonErrorMsg($LANG['viewplaylist_tip_alreay_exists']);
						$managePlaylist->setPageBlockShow('block_msg_form_error');
						break;
					}
					if(!$managePlaylist->chkIsValidSize('playlist_name','photo_playlist_name'))
					{
						$flag =0;
						echo '***--***!!!';
						$subject = str_replace('VAR_MIN', $CFG['fieldsize']['photo_playlist_name']['min'], $LANG['viewplaylist_invalid_size']);
						$subject = str_replace('VAR_MAX', $CFG['fieldsize']['photo_playlist_name']['max'], $subject);
						$managePlaylist->setCommonErrorMsg($subject);
						$managePlaylist->setPageBlockShow('block_msg_form_error');
						break;
					}
				}
				if($managePlaylist->getFormField('playlist_tags')!= '')
				{
					if(!$managePlaylist->chkValidTagList('playlist_tags','photo_playlist_tags'))
					{
						$flag =0;
						echo '***--***!!!';
						$subject = str_replace('VAR_MIN', $CFG['fieldsize']['photo_playlist_tags']['min'], $LANG['viewplaylist_err_tip_invalid_tag']);
						$subject = str_replace('VAR_MAX', $CFG['fieldsize']['photo_playlist_tags']['max'], $subject);
						$managePlaylist->setCommonErrorMsg($subject);
						$managePlaylist->setPageBlockShow('block_msg_form_error');
						break;
					}
				}
				if($flag)
				{
					if($managePlaylist->getFormField('mode')== 'insert')
					{
						$playlist_id = $managePlaylist->createPlaylist();
						$managePlaylist->setCommonSuccessMsg($LANG['viewplaylist_createsuccessfully_msg']);

					}
					else
					{
						$managePlaylist->setCommonSuccessMsg($LANG['viewplaylist_successfully_msg']);
						$playlist_id = $managePlaylist->getFormField('photo_playlist_id');
					}

					$song_id = explode(',', $managePlaylist->getFormField('photo_id'));//INSERT SONG TO PLAYLIST SONG//
					for($inc=0;$inc<count($song_id);$inc++)
						$managePlaylist->insertPhototoPlaylist($playlist_id, $song_id[$inc]);

					if($managePlaylist->getFormField('mode')== 'insert')
					{
						$managePlaylist->playlistCreateActivity($playlist_id);
					}
					$managePlaylist->setPageBlockShow('block_msg_form_success');
				}
			break;
		}

		setTemplateFolder('general/', '');
		$smartyObj->display('information.tpl');
		$managePlaylist->includeAjaxFooter();
		exit;
	}

}
if(!isAjaxPage())
	$managePlaylist->includeHeader();

setTemplateFolder('members/', $CFG['site']['is_module_page']);
if($managePlaylist->getFormField('page')=='viewphoto')
	$smartyObj->display('createSlidelistViewPhoto.tpl');
else
	$smartyObj->display('createSlidelist.tpl');

if(!isAjaxPage())
{
?>
<script language="javascript" type="text/javascript" src="<?php echo $CFG['site']['photo_url'];?>js/createPlaylist.js"></script>
<script language="javascript" type="text/javascript">
var playlist_name_error_msg = '<?php echo $LANG['common_photo_playlist_errortip_select_title']; ?>';
var playlist_tag_error_msg = '<?php echo $LANG['photoplaylist_error_tips']; ?>';
</script>
<?php
}
?>
<script type="text/javascript">
</script>
<?php
if(isAjaxPage())
	$managePlaylist->includeAjaxFooter();
else
	$managePlaylist->includeFooter();
?>