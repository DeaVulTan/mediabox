<?php
//--------------class musicLyricsList--------------->>>//
/**
 * This class is used to list music Lyrics
 *
 * @category	Rayzz
 * @package		manage music Lyrics
 * @copyright 	Copyright (c) 2009 - 2010 {@link http://www.mediabox.uz Uzdc Infoway}
 */
class musicLyricsView extends MusicHandler
	{
		public $record_count = '';
		public $lyric = '';
		public $user_name = '';
		public $user_url = false;

		/**
		 * musicLyricsView::isValidLyricID()
		 *
		 * @return
		 */
		public function isValidLyricID()
			{
				// IS ADMIN OR MUSIC OWNER SHOW LYRICS ELSE NOT SHOW LYRICS//
				if($this->chkIsAdminSide() or ($this->music_owner_id == $this->CFG['user']['user_id']))
					{
						$sql = 'SELECT m.music_lyric_id, m.lyric, m.best_lyric, u.user_id, u.user_name FROM '.$this->CFG['db']['tbl']['music_lyric'].' AS m JOIN '.$this->CFG['db']['tbl']['users'].' AS u'.
								' WHERE m.user_id=u.user_id AND u.usr_status=\'Ok\' AND m.music_id='.$this->dbObj->Param('music_id').' AND m.music_lyric_id = '.$this->dbObj->Param('music_lyric_id');

					}
				else
					{
						$sql = 'SELECT m.music_lyric_id, m.lyric, m.best_lyric, u.user_id, u.user_name FROM '.$this->CFG['db']['tbl']['music_lyric'].' AS m JOIN '.$this->CFG['db']['tbl']['users'].' AS u'.
							' WHERE m.user_id=u.user_id AND m.lyric_status = \'Yes\' AND u.usr_status=\'Ok\' AND m.music_id='.$this->dbObj->Param('music_id').' AND m.music_lyric_id = '.$this->dbObj->Param('music_lyric_id');
					}

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['music_id'], $this->fields_arr['music_lyric_id']));
				if (!$rs)
					trigger_db_error($this->dbObj);

				$row = $rs->FetchRow();
				if(!empty($row))
					{
						$this->record_count = true;

						$this->lyric = nl2br(makeClickableLinks($row['lyric']));
						$this->viewlyricpage = nl2br(makeClickableLinks($row['lyric']));
						$this->user_name = $row['user_name'];
						if(!$this->chkIsAdminSide())
							$this->user_url = getMemberProfileUrl($row['user_id'], $row['user_name']);
						else
							$this->user_url = $this->CFG['site']['url'].'admin/viewProfile.php?user_id='.$row['user_id'];

						return true;
					}
				else
					{
						return false;
					}
			}

		/**
		 * musicLyricsView::chkisMusicOwner()
		 *
		 * @return
		 */
		public function chkisMusicOwner()
			{
				$sql = 'SELECT music_id FROM '.$this->CFG['db']['tbl']['music'].' AS m'.
						' WHERE m.music_id = '.$this->dbObj->Param('music_id').' AND m.user_id = '.$this->dbObj->Param('music_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['music_id'], $this->CFG['user']['user_id']));
				if (!$rs)
					trigger_db_error($this->dbObj);

				$row = $rs->FetchRow();

				if($row['music_id'] != '')
					return true;
				return false;
			}
	}
//<<<<<-------------- Class musicLyricsView end ---------------//
//-------------------- Code begins -------------->>>>>//
$musicLyricsView = new musicLyricsView();
if(!chkAllowedModule(array('music')))
	Redirect2URL($CFG['redirect']['dsabled_module_url']);
$musicLyricsView->setPageBlockNames(array('list_lyrics_block'));
$musicLyricsView->setAllPageBlocksHide();
$musicLyricsView->setFormField('music_id', '');
$musicLyricsView->setFormField('music_title', '');
$musicLyricsView->setFormField('pg', '');
$musicLyricsView->setFormField('action', '');
$musicLyricsView->setFormField('page', '');
$musicLyricsView->setFormField('music_lyric_id', '');
$musicLyricsView->setFormField('start', '0');
$musicLyricsView->setFormField('numpg', $CFG['data_tbl']['numpg']);
$musicLyricsView->sanitizeFormInputs($_REQUEST);
$musicLyricsView->flag = true;
//Check validMusicID...//
if($musicLyricsView->getFormField('music_id')!='' and $musicLyricsView->getFormField('music_lyric_id')!='')
	{
		if($musicLyricsView->isValidMusicID($musicLyricsView->getFormField('music_id'), 'viewlyrics') and $musicLyricsView->isValidLyricID())
			{
				$musicLyricsView->addlyrics_light_window_url = $CFG['site']['music_url'].'addLyrics.php?music_id='.$musicLyricsView->getFormField('music_id').'&light_window=1';
				$musicLyricsView->morelyrics_url = getUrl('morelyrics', '?music_id='.$musicLyricsView->getFormField('music_id'), $musicLyricsView->getFormField('music_id').'/', '', 'music');
				if($musicLyricsView->getFormField('page')=='player')
					$musicLyricsView->morelyrics_url = getUrl('morelyrics', '?music_id='.$musicLyricsView->getFormField('music_id').'&page='.$musicLyricsView->getFormField('page'), $musicLyricsView->getFormField('music_id').'/?page='.$musicLyricsView->getFormField('page'), '', 'music');
				if(isMember())
					{
						if ($musicLyricsView->chkisMusicOwner())
							{
								$musicLyricsView->managelyrics_url = getUrl('managelyrics', '?music_id='.$musicLyricsView->getFormField('music_id'), $musicLyricsView->getFormField('music_id').'/', '', 'music');
							}
					}
				else
					{
						$musicLyricsView->memberviewMusicUrl = getUrl('viewmusic','?mem_auth=true&music_id='.$musicLyricsView->getFormfield('music_id').'&title='.
																		$musicLyricsView->changeTitle($musicLyricsView->getFormfield('music_title')),
																			$musicLyricsView->getFormfield('music_id').'/'.
																				$musicLyricsView->changeTitle($musicLyricsView->getFormfield('music_title')).
																					'/?mem_auth=true','members', 'music');
					}
				$musicLyricsView->setPageBlockShow('list_lyrics_block');
			}
		else
			{
				$musicLyricsView->flag = false;
				$musicLyricsView->setAllPageBlocksHide();
				$musicLyricsView->setCommonErrorMsg($LANG['viewlyrics_invalid_id']);
				$musicLyricsView->setPageBlockShow('block_msg_form_error');
			}
	}
else
	{
		$musicLyricsView->flag = false;
		$musicLyricsView->setAllPageBlocksHide();
		$musicLyricsView->setCommonErrorMsg($LANG['viewlyrics_invalid_id']);
		$musicLyricsView->setPageBlockShow('block_msg_form_error');
	}
//<<<<<-------------- Code end ----------------------------------------------//
//-------------------- Page block templates begins -------------------->>>>>//
if ($musicLyricsView->chkIsAdminSide())
	$musicLyricsView->left_navigation_div = 'musicMain';
if(isAjaxPage())
	$musicLyricsView->includeAjaxHeaderSessionCheck();
else
	$musicLyricsView->includeHeader();
//include the content of the page
setTemplateFolder('general/','music');
$smartyObj->display('viewLyrics.tpl');
if(isAjaxPage())
	$musicLyricsView->includeAjaxFooter();
else
	$musicLyricsView->includeFooter();
?>