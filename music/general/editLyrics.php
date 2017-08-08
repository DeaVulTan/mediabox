<?php
//--------------class musicLyricsList--------------->>>//
/**
 * This class is used to list music Lyrics
 *
 * @category	Rayzz
 * @package		manage music Lyrics
 * @copyright 	Copyright (c) 2009 - 2010 {@link http://www.mediabox.uz Uzdc Infoway}
 */
class EditLyrics extends MusicHandler
{
	public $record_count = '';
	public $lyric = '';
	public $user_name = '';
	public $user_url = false;
	/**
	* EditLyrics::isValidLyricID()
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
	* EditLyrics::showEditLyrics()
	*
	* @return
	*/
	public function showEditLyrics()
	{
		$sql = 'SELECT ml.music_lyric_id, ml.lyric, ml.lyric_status, ml.best_lyric, u.user_id, u.user_name FROM '.
		       $this->CFG['db']['tbl']['music_lyric'].' as ml JOIN '.$this->CFG['db']['tbl']['users'] .' as u ON ml.user_id=u.user_id WHERE '
			   .' u.usr_status=\'Ok\' AND ml.music_lyric_id='.$this->dbObj->Param('music_lyric_id').' ORDER BY ml.music_lyric_id LIMIT 0,1';
		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['music_lyric_id']));
		if (!$rs)
		trigger_db_error($this->dbObj);
		while($row = $rs->FetchRow())
		{
			if($row['lyric']!='')
			{
				return $row['lyric'];
			}
			else
			{
				return '';
			}
		}
	}
	/**
	* EditLyrics::updateEditLyrics()
	*
	* @return
	*/
	public function updateEditLyrics()
	{
		$sql = 'UPDATE '.$this->CFG['db']['tbl']['music_lyric'].' '.
		' SET lyric = '.$this->dbObj->Param('edit_lyrics').
		' WHERE music_lyric_id = '.$this->dbObj->Param('music_lyric_id');
		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['edit_lyrics'],$this->fields_arr['music_lyric_id']));
		if (!$rs)
		trigger_db_error($this->dbObj);
		return true;
	}
}
//<<<<<-------------- Class editLyrics end ---------------//
//-------------------- Code begins -------------->>>>>//
$editLyrics = new EditLyrics();
if(!chkAllowedModule(array('music')))
	Redirect2URL($CFG['redirect']['dsabled_module_url']);
$editLyrics->setPageBlockNames(array('show_edit_block'));
$editLyrics->setAllPageBlocksHide();
$editLyrics->setFormField('music_id', '');
$editLyrics->setFormField('music_title', '');
$editLyrics->setFormField('pg', '');
$editLyrics->setFormField('action', '');
$editLyrics->setFormField('page', '');
$editLyrics->setFormField('music_lyric_id', '');
$editLyrics->setFormField('start', '0');
$editLyrics->setFormField('edit_lyrics', '');
$editLyrics->setFormField('edit_submit', '');
$editLyrics->setFormField('numpg', $CFG['data_tbl']['numpg']);
$editLyrics->sanitizeFormInputs($_REQUEST);
$editLyrics->flag = true;
if($editLyrics->getFormField('music_id')!='' && $editLyrics->getFormField('music_lyric_id')!='')
{
	if($editLyrics->isValidMusicID($editLyrics->getFormField('music_id'), 'viewlyrics') and $editLyrics->isValidLyricID())
	{
		$editLyrics->setAllPageBlocksHide();
		$editLyrics->setPageBlockShow('show_edit_block');
	}
	else
	{
		$editLyrics->flag = false;
		$editLyrics->setAllPageBlocksHide();
		$editLyrics->setCommonErrorMsg($LANG['managelyrics_invalid_id']);
		$editLyrics->setPageBlockShow('block_msg_form_error');
	}
}
if ($editLyrics->isFormPOSTed($_POST, 'edit_submit'))
{
	$editLyrics->updateEditLyrics();
	$editLyrics->setCommonSuccessMsg($LANG['managelyrics_edit_successfully']);
	$editLyrics->setPageBlockShow('block_msg_form_success');
}
//<<<<<-------------- Code end ----------------------------------------------//
//-------------------- Page block templates begins -------------------->>>>>//
if ($editLyrics->chkIsAdminSide())
	$editLyrics->left_navigation_div = 'musicMain';
if(isAjaxPage())
	$editLyrics->includeAjaxHeaderSessionCheck();
else
	$editLyrics->includeHeader();
//include the content of the page
setTemplateFolder('general/','music');
$smartyObj->display('editLyrics.tpl');
if ($editLyrics->isShowPageBlock('show_edit_block') and $CFG['feature']['jquery_validation']) {
?>
<script type="text/javascript">
	$Jq("#editFormLyrics").validate({
		rules: {
		    edit_lyrics: {
		    	required: true
		    }
		},
		messages: {
			edit_lyrics: {
				required: "<?php echo $editLyrics->LANG['common_err_tip_compulsory'];?>"
			}
		}
	});
</script>
<?php
}
if(isAjaxPage())
	$editLyrics->includeAjaxFooter();
else
	$editLyrics->includeFooter();
?>