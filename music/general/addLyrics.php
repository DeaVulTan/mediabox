<?php
//--------------class musicLyricsAdd--------------->>>//
/**
 * This class is used to manage music Lyrics
 *
 * @category	Rayzz
 * @package		manage music Lyrics
 * Copyright    (c) 2008 {@link http://www.mediabox.uz Uzdc Infoway}
 */
class musicLyricsAdd extends MusicHandler
	{
		/**
		 * musicLyricsAdd::insertMusicLyrics()
		 *
		 * @return
		 */
		public function insertMusicLyrics($is_admin)
			{
				if($this->chkIsAdminSide())
					{
						$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['music_lyric'].
								' SET lyric_status = \'Yes\', music_id = '.$this->dbObj->Param('music_id').', user_id='.$this->dbObj->Param('user_id').', lyric='.$this->dbObj->Param('lyric').', date_added=CURDATE()';
					}
				else
					{
							$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['music_lyric'].
								' SET music_id = '.$this->dbObj->Param('music_id').', user_id='.$this->dbObj->Param('user_id').', lyric='.$this->dbObj->Param('lyric').', date_added=CURDATE()';
					}

				$value_arr = array($this->fields_arr['music_id'], $this->CFG['user']['user_id'], $this->fields_arr['lyric']);
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, $value_arr);
			    if (!$rs)
					trigger_db_error($this->dbObj);

				return true;
			}
	}
//<<<<<-------------- Class musicLyricsAdd end ---------------//
//-------------------- Code begins -------------->>>>>//

$musicLyricsAdd = new musicLyricsAdd();
if(!chkAllowedModule(array('music')))
	Redirect2URL($CFG['redirect']['dsabled_module_url']);
$musicLyricsAdd->setPageBlockNames(array('add_lyrics_block', 'list_lyrics_block'));
$musicLyricsAdd->setAllPageBlocksHide();
$musicLyricsAdd->setFormField('music_id', '');
$musicLyricsAdd->setFormField('music_title', '');
$musicLyricsAdd->setFormField('lyric', '');
$musicLyricsAdd->setFormField('light_window', '');
$musicLyricsAdd->setFormField('page', '');
$musicLyricsAdd->setFormField('action', '');
$musicLyricsAdd->sanitizeFormInputs($_REQUEST);
if(isAjaxPage())
	{
		$musicLyricsAdd->includeAjaxHeaderSessionCheck();
		if($musicLyricsAdd->getFormField('page') == 'addlyrics')
			{
				$musicLyricsAdd->insertMusicLyrics($is_admin);
				echo $LANG['musicplaylist_created_successfully'];
			}
		if($musicLyricsAdd->getFormField('action') == 'add_lyrics')
		{
			?>
				<script language="javascript" type="text/javascript" >
				var managelyrics_compulsory ='<?php echo $LANG['managelyrics_compulsory'];?>';
				</script>
			<?php
			$musicLyricsAdd->setPageBlockShow('add_lyrics_block');
			setTemplateFolder('general/', 'music');
			$smartyObj->display('addLyrics.tpl');
		}
		$musicLyricsAdd->includeAjaxFooter();
		exit;
	}
// Check validMusicID... //
if($musicLyricsAdd->getFormField('music_id')!='')
	{

		if($musicLyricsAdd->isValidMusicID($musicLyricsAdd->getFormField('music_id'), 'addlyrics') and isMember())
			{
				$musicLyricsAdd->setPageBlockShow('add_lyrics_block');
			}
		else
			{
				$musicLyricsAdd->setAllPageBlocksHide();
				$musicLyricsAdd->setCommonErrorMsg($LANG['managelyrics_invalid_id']);
				$musicLyricsAdd->setPageBlockShow('block_msg_form_error');
			}
	}
else
	{
		$musicLyricsAdd->setAllPageBlocksHide();
		$musicLyricsAdd->setCommonErrorMsg($LANG['managelyrics_invalid_id']);
		$musicLyricsAdd->setPageBlockShow('block_msg_form_error');
	}
if($musicLyricsAdd->isFormPOSTed($_POST, 'submit_button'))
	{
		$musicLyricsAdd->chkIsNotEmpty('lyric', $LANG['managelyrics_tip_compulsory']);
		if($musicLyricsAdd->isValidFormInputs())
			{
				$musicLyricsAdd->insertMusicLyrics($is_admin);
				$musicLyricsAdd->setPageBlockShow('block_msg_form_success');
				if(!$is_admin)
					$musicLyricsAdd->setCommonSuccessMsg($LANG['musicplaylist_created_successfully']);
				else
					$musicLyricsAdd->setCommonSuccessMsg($LANG['musicplaylist_created_successfully_admin']);
			}
	}
// Is Light window checking //
if($musicLyricsAdd->getFormField('light_window')!= '')
	{
		?>
			<!--<script type="text/javascript" src="<?php echo $CFG['site']['music_url'];?>js/lib/tinymce/tiny_mce.js"></script> -->

			<script language="javascript" type="text/javascript" src="<?php echo $CFG['site']['music_url'];?>js/functions.js"></script>
			<script language="javascript" type="text/javascript" >
			var managelyrics_compulsory ='<?php echo $LANG['managelyrics_compulsory'];?>';
			</script>
		<?php
		$musicLyricsAdd->includeHeader();
		$musicLyricsAdd->setPageBlockShow('add_lyrics_block');
		setTemplateFolder('general/', 'music');
		$smartyObj->display('addLyrics.tpl');
		$musicLyricsAdd->includeFooter();
		exit;
	}
//<<<<<-------------- Code end ----------------------------------------------//
//-------------------- Page block templates begins -------------------->>>>>//
//Show lyrics list...//
if ($musicLyricsAdd->isShowPageBlock('list_lyrics_block'))
	{
		$musicLyricsAdd->setTableAndColumns();
		$musicLyricsAdd->buildSelectQuery();
		$musicLyricsAdd->buildQuery();
		$musicLyricsAdd->executeQuery();
		$musicLyricsAdd->list_lyrics_block['displayLyrics'] = array();
		if($musicLyricsAdd->isResultsFound())
			{
				$musicLyricsAdd->list_lyrics_block['displayLyrics'] = $musicLyricsAdd->displayLyrics();
				$musicLyricsAdd->hidden_array = array('music_id');
				$musicLyricsAdd->hidden_arr = array('music_id', 'start');
				$smartyObj->assign('smarty_paging_list', $musicLyricsAdd->populatePageLinksGET($musicLyricsAdd->getFormField('start'), $musicLyricsAdd->hidden_array));
			}
	}
if ($musicLyricsAdd->chkIsAdminSide())
	$musicLyricsAdd->left_navigation_div = 'musicMain';
//include the header file
$musicLyricsAdd->includeHeader();
//include the content of the page
setTemplateFolder('general/','music');
$smartyObj->display('addLyrics.tpl');
$musicLyricsAdd->includeFooter();
?>