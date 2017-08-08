<?php
//--------------class musicAlbumManage--------------->>>//
/**
 * This class is used to manage music album
 *
 * @category	Rayzz
 * @package		manage music album
 * @copyright 	Copyright (c) 2009 - 2010 {@link http://www.mediabox.uz Uzdc Infoway}
 */
class musicAlbumManage extends MusicHandler
	{
		/**
		 * musicAlbumManage::clearForm()
		 *
		 * @return
		 */
		public function clearHistory()
			{
				$this->fields_arr['music_album_id'] = '';
				$this->fields_arr['album_title'] = '';
				$this->fields_arr['album_price'] = '';
				$this->fields_arr['album_access_type'] = 'Private';
			}

		public function chkIsAlbumEditMode()
		{
			if($this->fields_arr['music_album_id'])
				{
					return true;
				}
			return false;
		}

		public function chkIsAlbumEditable($album_id)
		{
			//cannot edit anonymous album
			if($album_id == 1)
				return false;
			$sql = 'SELECT ma.music_album_id, m.user_id FROM '.
					$this->CFG['db']['tbl']['music_album'].' as ma '.
					' LEFT JOIN '.$this->CFG['db']['tbl']['music'].' as m '.
					' ON ma.music_album_id=m.music_album_id '.
					' WHERE ma.music_album_id='.$this->dbObj->Param('music_album_id').
					' AND ma.user_id='.$this->dbObj->Param('uer_id').
					' AND ma.user_id!=m.user_id';

			$stmt = $this->dbObj->Prepare($sql);
			 $rs = $this->dbObj->Execute($stmt, array($album_id, $this->CFG['user']['user_id']));
			 if (!$rs)
			 	trigger_db_error($this->dbObj);
			if($row = $rs->FetchRow())
			{
				return false;
			}
			return true;
		}

		/**
		 * musicAlbumManage::showAlbums()
		 *
		 * @return
		 */
		public function showAlbums()
		{
			$showAlbums_arr = array();
			//Image..

			$inc=0;
			while($row = $this->fetchResultRecord())
				{
					$showAlbums_arr[$inc]['anchor']= 'dAlt_'.$row['music_album_id'];
					$showAlbums_arr[$inc]['music_album_id']=$row['music_album_id'];
					$showAlbums_arr[$inc]['album_wrap_title']=nl2br(makeClickableLinks($row['album_title']));
					$showAlbums_arr[$inc]['album_title']=$row['album_title'];
					$showAlbums_arr[$inc]['album_price'] = $row['album_price'];
					$showAlbums_arr[$inc]['album_access_type'] = $row['album_access_type'];
					//Playlist image
					//$showAlbums_arr[$inc]['getAlbumImageDetail'] = $this->getAlbumImageDetail($row['music_album_id']);// This function return album image detail array..//
					$showAlbums_arr[$inc]['album_view_link']= getUrl('viewalbum', '?album_id='.$row['music_album_id'].'&amp;title='.$this->changeTitle($row['album_title']), $row['music_album_id'].'/'.$this->changeTitle($row['album_title']).'/', '', 'music');
					$showAlbums_arr[$inc]['album_edit_link']=getUrl('musiclist', '?pg=myalbum&music_album_id='.$row['music_album_id'], 'myalbum/?music_album_id='.$row['music_album_id'], '', 'music');
					// do not allow to edit or delete the default public album..
					if($row['music_album_id'] == 1)
					{
						$showAlbums_arr[$inc]['edit_link'] = '';
					}
					else
					{
						$showAlbums_arr[$inc]['edit_link']=getUrl('musicalbummanage', '?music_album_id='.$row['music_album_id'], '?music_album_id='.$row['music_album_id'], 'members', 'music');

					}

					$showAlbums_arr[$inc]['record']=$row;
					$inc++;
				}
			return $showAlbums_arr;
		}

		/**
		 * MyAlbums::buildConditionQuery()
		 *
		 * @return
		 **/
		public function buildConditionQuery()
		{
			$this->sql_condition = 'pl.user_id=\''.$this->CFG['user']['user_id'].'\'';
		}

		/**
		 * MyAlbums::buildSortQuery()
		 *
		 * @return
		 **/
		public function buildSortQuery()
		{
			$this->sql_sort = $this->fields_arr['orderby_field'].' '.$this->fields_arr['orderby'];
		}

		public function getMusicAlbum()
		{
			if(!$this->chkIsAlbumEditable($this->fields_arr['music_album_id']))
				return false;
			$sql = 'SELECT album_title, album_access_type, album_price, album_for_sale '.
					' FROM '.
					$this->CFG['db']['tbl']['music_album'].
					' WHERE music_album_id ='.$this->dbObj->Param('music_album_id');
			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['music_album_id']));
			if (!$rs)
				trigger_db_error($this->dbObj);
			if($row = $rs->FetchRow())
			{
				$this->fields_arr['album_title'] = $row['album_title'];
				$this->fields_arr['album_access_type'] = $row['album_access_type'];
				$this->fields_arr['album_for_sale'] = $row['album_for_sale'];
				$this->fields_arr['album_price'] = $row['album_price'];
				return true;
			}
			return false;

		}

		public function chkAlbumExists($fields_name, $err_tip='', $album_type='Public')
		{
			$sql = 'SELECT album_title FROM '.
					$this->CFG['db']['tbl']['music_album'].
					' WHERE album_title = '.$this->dbObj->Param('album_title').
					' AND album_access_type = '.$this->dbObj->Param('album_access_type').
					' AND user_id = '.$this->dbObj->Param('user_id');
			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt, array($this->getFormField('album_title'), $album_type, $this->CFG['user']['user_id']));
			if (!$rs)
				trigger_db_error($this->dbObj);
			if($row = $rs->FetchRow())
			{
				$this->fields_err_tip_arr['album_title'] = $err_tip;
				return false;
			}
			return true;
		}

		public function createAlbum()
		{
			$this->fields_arr['album_for_sale'] = 'No';
			if(isset($this->fields_arr['album_price']) and $this->fields_arr['album_price'] != '')
			{
				$this->fields_arr['album_for_sale'] = 'Yes';
			}
			if(isset($this->fields_arr['music_album_id']) and $this->fields_arr['music_album_id'] != '')
			{
				$sql = 'UPDATE ';
			}
			else
				$sql = 'INSERT into ';
			$param_arr = array($this->fields_arr['album_title'], $this->fields_arr['album_access_type'],
								$this->fields_arr['album_price'], $this->fields_arr['album_for_sale'],
								$this->CFG['user']['user_id']);
			$sql .= $this->CFG['db']['tbl']['music_album'].
					' SET '.
					'album_title ='.$this->dbObj->Param('album_title').','.
					'album_access_type ='.$this->dbObj->Param('album_access_type').','.
					'album_price ='.$this->dbObj->Param('album_price').','.
					'album_for_sale ='.$this->dbObj->Param('album_for_sale').','.
					'user_id ='.$this->dbObj->Param('user_id');
			if(isset($this->fields_arr['music_album_id']) and $this->fields_arr['music_album_id'] != '')
			{
				$param_arr[] = $this->fields_arr['music_album_id'];
				$sql .= ' WHERE music_album_id ='.$this->dbObj->Param('music_album_id');
			}
			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt, $param_arr);
			if (!$rs)
				trigger_db_error($this->dbObj);
		}

		public function deleteMusicAlbum()
		{
			$album_ids = $this->fields_arr['music_album_ids'];
			if ($this->chkMusicExists($album_ids))
			return false;
			$sql = 'DELETE FROM '.$this->CFG['db']['tbl']['music_album'].' '.
			'WHERE music_album_id IN ('.$album_ids.') ';
			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt);
			if (!$rs)
			trigger_db_error($this->dbObj);
			return true;
		}

		public function chkMusicExists($album_ids)
		{
			$sql = 'SELECT count( g.music_id ) AS music_count, music_album_id'.
					' FROM '.$this->CFG['db']['tbl']['music'].' g'.
					' WHERE music_album_id IN ( '.$album_ids.' )'.
					' AND music_status!=\'Deleted\''.
					' GROUP BY music_album_id';
			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt);
			if (!$rs)
			trigger_db_error($this->dbObj);
			if ($rs->PO_RecordCount())
				return true;
			return false;
		}
		public function getmusicCount($album_id)
		{
			$sql = 'SELECT count(g.music_id) as music_count '.
					'FROM '.$this->CFG['db']['tbl']['music'].' as g '.
					'WHERE music_album_id = '.$this->dbObj->Param('album_id');
			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt, array($album_id));
			if (!$rs)
			trigger_db_error($this->dbObj);
			$row = $rs->FetchRow();
			return $row['music_count'];
		}

		public function chkIsValidPrice($field_name, $err_tip)
		{
			if($this->fields_arr[$field_name] < 0)
			{
				$this->fields_err_tip_arr[$field_name] = $err_tip;
				return false;
			}
			return true;
		}
	}
//<<<<<-------------- Class musicAlbumManage end ---------------//
//-------------------- Code begins -------------->>>>>//
$musicAlbumManage = new musicAlbumManage();
if(!chkAllowedModule(array('music')))
	Redirect2URL($CFG['redirect']['dsabled_module_url']);
/*echo '<pre>';
print_r($_REQUEST);
echo '</pre>';*/
$musicAlbumManage->setPageBlockNames(array('create_album_block', 'list_album_block'));
$musicAlbumManage->setFormField('album_title', '');
$musicAlbumManage->setFormField('album_access_type', 'Private');
$musicAlbumManage->setFormField('album_price', '');
$musicAlbumManage->setFormField('music_album_id', '');
$musicAlbumManage->setFormField('music_for_sale', 'No');
$musicAlbumManage->setFormField('total_tracks', '');

$musicAlbumManage->setFormField('music_album_ids', '');
$musicAlbumManage->setFormField('start', '0');
$musicAlbumManage->setFormField('action', '');
$musicAlbumManage->setFormField('music_album_ids', array());
$musicAlbumManage->setFormField('numpg', $CFG['data_tbl']['numpg']);
$musicAlbumManage->setMinRecordSelectLimit(2);
$musicAlbumManage->setMaxRecordSelectLimit($CFG['data_tbl']['max_record_select_limit']);
$musicAlbumManage->setNumPerPageListArr($CFG['data_tbl']['numperpage_list_arr']);

$musicAlbumManage->setFormField('orderby_field', 'album_title');
$musicAlbumManage->setFormField('orderby', 'DESC');

$musicAlbumManage->setTableNames(array($CFG['db']['tbl']['music_album'].' as pl'));
//$musicAlbumManage->setTableNames(array($CFG['db']['tbl']['music_album'].' as pl LEFT JOIN '.$CFG['db']['tbl']['music'].' as m ON pl.user_id=m.user_id'));
$musicAlbumManage->setReturnColumns(array('pl.music_album_id','pl.user_id','pl.album_access_type', 'pl.album_title','album_price', 'pl.date_added'));
$musicAlbumManage->setAllPageBlocksHide();
$musicAlbumManage->setPageBlockShow('create_album_block');
$musicAlbumManage->setPageBlockShow('list_album_block');
$musicAlbumManage->sanitizeFormInputs($_REQUEST);
$musicAlbumManage->createalbum_url = getUrl('musicalbummanage', '', '', 'members', 'music');
if($musicAlbumManage->isFormPOSTed($_POST, 'album_submit'))
	{
		$musicAlbumManage->chkIsNotEmpty('album_title', $LANG['musicalbum_tip_compulsory']);
		if(!$musicAlbumManage->chkIsAlbumEditMode())
			$musicAlbumManage->chkAlbumExists('album_title', $LANG['musicalbum_err_tip_alreay_exists'], $musicAlbumManage->getFormField('album_access_type'));
		if($musicAlbumManage->getFormField('album_price'))
		{
			$musicAlbumManage->chkIsReal('album_price', $LANG['musicalbum_album_error_in_price']);
			$musicAlbumManage->chkIsValidPrice('album_price',$LANG['musicalbum_album_error_in_price']);
			$musicAlbumManage->setFormField('album_for_sale','Yes');
		}
		$musicAlbumManage->setPageBlockShow('create_album_block');
		if($musicAlbumManage->isValidFormInputs())
			{
				$musicAlbumManage->createAlbum();
				if($musicAlbumManage->getFormField('music_album_id'))
					{
						$musicAlbumManage->setPageBlockShow('block_msg_form_success');
						$musicAlbumManage->setCommonSuccessMsg($LANG['musicalbum_update_successfully']);
					}
				else
					{
						$musicAlbumManage->setPageBlockShow('block_msg_form_success');
						$musicAlbumManage->setCommonSuccessMsg($LANG['musicalbum_created_successfully']);
					}
				$musicAlbumManage->clearHistory();
			}
		else
			{
				$musicAlbumManage->setPageBlockShow('block_msg_form_error');
				$musicAlbumManage->setCommonErrorMsg($LANG['musicalbum_create_failure']);
			}
	}
if($musicAlbumManage->getFormField('music_album_id'))
	{
		if($musicAlbumManage->chkIsAlbumEditable($musicAlbumManage->getFormField('music_album_id')))
		{
			if(!$musicAlbumManage->getMusicAlbum())
			{
				$musicAlbumManage->setPageBlockShow('block_msg_form_error');
				$musicAlbumManage->setCommonErrorMsg($LANG['musicalbum_invalid_id']);
			}
		}
		else
		{
			$musicAlbumManage->setPageBlockShow('block_msg_form_error');
			$musicAlbumManage->setCommonErrorMsg($LANG['musicalbum_not_editable']);
		}
	}
if($musicAlbumManage->getFormField('action'))
	{
		$musicAlbumManage->setAllPageBlocksHide();
		$musicAlbumManage->setPageBlockShow('create_album_block');
		$musicAlbumManage->setPageBlockShow('list_album_block');
		switch($musicAlbumManage->getFormField('action'))
			{
				case 'delete':
						if($musicAlbumManage->deleteMusicAlbum())
						{
							$musicAlbumManage->setCommonSuccessMsg($LANG['musicalbum_delete_successfully']);
							$musicAlbumManage->setPageBlockShow('block_msg_form_success');
						}
						else
						{
							$musicAlbumManage->setCommonErrorMsg($LANG['musicalbum_music_exists']);
							$musicAlbumManage->setPageBlockShow('block_msg_form_error');
						}

				break;
			}
	}
//<<<<<-------------- Code end ----------------------------------------------//
//-------------------- Page block templates begins -------------------->>>>>//
if ($musicAlbumManage->isShowPageBlock('list_album_block'))
	{
		/****** navigtion continue*********/
		$musicAlbumManage->buildSelectQuery();
		$musicAlbumManage->buildConditionQuery();
		$musicAlbumManage->buildSortQuery();
		$musicAlbumManage->buildQuery();
		$musicAlbumManage->executeQuery();
		if($musicAlbumManage->isResultsFound())
			{
				$musicAlbumManage->hidden_arr = array('start', 'orderby','orderby_field');
				$musicAlbumManage->list_album_block['showAlbums'] = $musicAlbumManage->showAlbums();
				$smartyObj->assign('smarty_paging_list', $musicAlbumManage->populatePageLinksGET($musicAlbumManage->getFormField('start'),array()));
				$musicAlbumManage->deleMusicForm_hidden_arr = array('orderby','orderby_field');
			}
	}
 if ($musicAlbumManage->chkIsAdminSide())
	$musicAlbumManage->left_navigation_div = 'musicMain';
//include the header file
$musicAlbumManage->includeHeader();
//include the content of the page
setTemplateFolder('general/','music');
$smartyObj->display('musicAlbumManage.tpl');
//includ the footer of the page
//<<<<<<--------------------Page block templates Ends--------------------//
?>
<script type="text/javascript" src="<?php echo $CFG['site']['music_url'];?>js/functions.js"></script>
<script type="text/javascript" src="<?php echo $CFG['site']['url'];?>js/JSFCommunicator.js"></script>
<script type="text/javascript" src="<?php echo $CFG['site']['url'];?>js/swfobject.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo $CFG['site']['url'];?>design/templates/<?php echo $CFG['html']['template']['default'];?>/admin/css/reOrder.css" />
<link rel="stylesheet" type="text/css" href="<?php echo $CFG['site']['url'];?>design/templates/<?php echo $CFG['html']['template']['default'];?>/admin/css/fonts-min.css"/>
<script type="text/javascript" src="<?php echo $CFG['site']['url'];?>js/yahoo-dom-event.js"></script>
<script type="text/javascript" src="<?php echo $CFG['site']['url'];?>js/animation-min.js"></script>
<script type="text/javascript" src="<?php echo $CFG['site']['url'];?>js/dragdrop-min.js"></script>
<script type="text/javascript" src="<?php echo $CFG['site']['url'];?>js/reOrder.js"></script>
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
								confirm_message = '<?php echo $LANG['musicalbum_multi_delete_confirmation'];?>';
								break;
						}
					$Jq('#confirmMessage').html(confirm_message);
					document.msgConfirmform.action.value = act_value;
					Confirmation('selMsgConfirm', 'msgConfirmform', Array('music_album_ids'), Array(multiCheckValue), Array('value'),'selFormForums');
				}
				else
					alert_manual(please_select_action);
		}
</script>
<?php
if($musicAlbumManage->isShowPageBlock('create_album_block') and $CFG['feature']['jquery_validation'])
{
	?>
	<script type="text/javascript">
		$Jq("#frmMusicAlbumManage").validate({
			rules: {
			    album_title: {
			    	required: true
			    }
			},
			messages: {
				album_title: {
					required: "<?php echo $musicAlbumManage->LANG['common_err_tip_compulsory'];?>"
				}
			}
		});
	</script>
	<?php
}
$musicAlbumManage->includeFooter();
?>