<?php
//--------------class musicLyricsList--------------->>>//
/**
 * This class is used to list music Lyrics
 *
 * @category	Rayzz
 * @package		manage music Lyrics
 * @copyright 	Copyright (c) 2009 - 2010 {@link http://www.mediabox.uz Uzdc Infoway}
 */
class musicLyricsList extends MusicHandler
	{
		/**
		  * musicLyricsList::setTableAndColumns()
		  *
		  * @return
		  */
		 public function setTableAndColumns()
		 	{
				switch ($this->fields_arr['pg'])
					{
						default:
							//Heading
							//Query
							$this->setTableNames(array($this->CFG['db']['tbl']['music_lyric'].' as ml JOIN '.$this->CFG['db']['tbl']['users'].' as u ON ml.user_id=u.user_id'));
							$this->setReturnColumns(array('ml.music_id', 'ml.music_lyric_id', 'ml.lyric', 'ml.lyric_status', 'ml.best_lyric', 'u.user_id', 'u.user_name'));
							$this->sql_condition = 'u.usr_status=\'Ok\' AND lyric_status = \'Yes\' AND ml.music_id='.$this->fields_arr['music_id'];
							$this->sql_sort = 'ml.date_added DESC';
						break;
					}
			}

		/**
		 * musicLyricsList::displayLyrics()
		 *
		 * @return
		 */
		public function displayLyrics()
			{
				$displayLyrics_arr = array();
				$inc = 0;
				while($row = $this->fetchResultRecord())
					{
						$displayLyrics_arr[$inc]['lyrics'] = $row['lyric'];
						$displayLyrics_arr[$inc]['record'] = $row;
						$displayLyrics_arr[$inc]['lyrics_post_user_url'] = getMemberProfileUrl($row['user_id'], $row['user_name']);
						$displayLyrics_arr[$inc]['viewLyrics_url'] = getUrl('viewlyrics', '?music_id='.$row['music_id'].'&amp;music_lyric_id='.$row['music_lyric_id'], '?music_id='.$row['music_id'].'&amp;music_lyric_id='.$row['music_lyric_id'], '', 'music');
						if($this->getFormField('page')=='player')
							$displayLyrics_arr[$inc]['viewLyrics_url'] = getUrl('viewlyrics', '?music_id='.$row['music_id'].'&amp;music_lyric_id='.$row['music_lyric_id'].'&page='.$this->getFormField('page'), '?music_id='.$row['music_id'].'&amp;music_lyric_id='.$row['music_lyric_id'].'&page='.$this->getFormField('page'), '', 'music');

						$inc++;
					}
				return $displayLyrics_arr;
			}
	}

//<<<<<-------------- Class musicLyricsList end ---------------//
//-------------------- Code begins -------------->>>>>//
$musicLyricsList = new musicLyricsList();
if(!chkAllowedModule(array('music')))
	Redirect2URL($CFG['redirect']['dsabled_module_url']);
$musicLyricsList->setPageBlockNames(array('list_lyrics_block'));
$musicLyricsList->setAllPageBlocksHide();
$musicLyricsList->setFormField('music_id', '');
$musicLyricsList->setFormField('page', '');
$musicLyricsList->setFormField('pg', '');
$musicLyricsList->setFormField('action', '');
$musicLyricsList->setFormField('music_lyric_id', '');
$musicLyricsList->setFormField('start', '0');
$musicLyricsList->setFormField('numpg', $CFG['data_tbl']['numpg']);
$musicLyricsList->sanitizeFormInputs($_REQUEST);
//Check validMusicID...//
if($musicLyricsList->getFormField('music_id')!='')
	{
		if($musicLyricsList->isValidMusicID($musicLyricsList->getFormField('music_id'), 'morelyrics'))
			{
				$musicLyricsList->setPageBlockShow('list_lyrics_block');
			}
		else
			{
				$musicLyricsList->setAllPageBlocksHide();
				$musicLyricsList->setCommonErrorMsg($LANG['morelyrics_invalid_id']);
				$musicLyricsList->setPageBlockShow('block_msg_form_error');
			}
	}
else
	{
		$musicLyricsList->setAllPageBlocksHide();
		$musicLyricsList->setCommonErrorMsg($LANG['morelyrics_invalid_id']);
		$musicLyricsList->setPageBlockShow('block_msg_form_error');
	}
//<<<<<-------------- Code end ----------------------------------------------//
//-------------------- Page block templates begins -------------------->>>>>//
//Show lyrics list...//
if ($musicLyricsList->isShowPageBlock('list_lyrics_block'))
	{
		$musicLyricsList->setTableAndColumns();
		$musicLyricsList->buildSelectQuery();
		$musicLyricsList->buildQuery();
		$musicLyricsList->executeQuery();
		$musicLyricsList->list_lyrics_block['displayLyrics'] = array();
		if($musicLyricsList->isResultsFound())
			{
				$musicLyricsList->list_lyrics_block['displayLyrics'] = $musicLyricsList->displayLyrics();
				$musicLyricsList->hidden_array = array('music_id');
				$musicLyricsList->hidden_arr = array('music_id', 'start');
				$smartyObj->assign('smarty_paging_list', $musicLyricsList->populatePageLinksGET($musicLyricsList->getFormField('start'), $musicLyricsList->hidden_array));
			}
	}
//include the header file
$musicLyricsList->includeHeader();
//include the content of the page
setTemplateFolder('general/','music');
$smartyObj->display('moreLyrics.tpl');
$musicLyricsList->includeFooter();
?>