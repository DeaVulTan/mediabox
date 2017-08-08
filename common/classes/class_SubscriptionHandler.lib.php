<?php
/**
 * Class to handle the subscription
 *
 * This is having class SubscriptionHandler to handle the subscription related
 * functionalities like subscribe, unsubscribe
 * form fields and to populate the common static array file.
 *
 * PHP version 5.0
 *
 * @category	###Rayzz###
 * @package		###Common/Classes###
 * @author		shankar_044at09
 * @copyright 	Copyright (c) 2008 {@link http://www.mediabox.uz Uzdc Infoway}
 * @license		http://www.mediabox.uz Uzdc Infoway Licence
 */
if(class_exists('MediaHandler'))
	{
		$parent_class = 4;
	}
else if(class_exists('ListRecordsHandler'))
	{
		$parent_class = 3;
	}
else if(class_exists('FormHandler'))
	{
		$parent_class = 2;
	}
else
	{
		$parent_class = 1;
	}

switch($parent_class)
	{
		case 4:
			class SubscriptionExtendHandler extends MediaHandler{}
			break;
		case 3:
			class SubscriptionExtendHandler extends ListRecordsHandler{}
			break;
		case 2:
			class SubscriptionExtendHandler extends FormHandler{}
			break;
		case 1:
		default:
			class SubscriptionExtendHandler{}
			break;
	}

/**
 * SubscriptionHandler
 *
 * @package
 * @author shankar_044at09
 * @copyright Copyright (c) 2010
 * @version $Id$
 * @access public
 */
class SubscriptionHandler extends SubscriptionExtendHandler
	{
		/**
		 * SubscriptionHandler::getSubscriptionDetails()
		 *
		 * @return void
		 */
		public function getSubscriptionDetails()
			{
				global $smartyObj;

				$sql = 'SELECT module, status FROM '.$this->CFG['db']['tbl']['subscription'].
						' WHERE owner_id='.$this->dbObj->Param('owner_id').
						' AND subscriber_id='.$this->dbObj->Param('subscriber_id').
						' AND subscription_type=\'User\'';
						//' AND status=\'Ok\'';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['owner_id'], $this->fields_arr['subscriber_id']));
				if (!$rs)
					trigger_db_error($this->dbObj);

				$subscription_details_arr = array();
				$module_sub_arr = array();
				$inc = 0;
				if($rs->PO_RecordCount())
					{
						while($row = $rs->FetchRow())
							{
								if(chkAllowedModule(array($row['module'])))
									{
										if(chkIsSubscriptionEnabledForModule($row['module']))
											{
												$module_sub_arr[] = $row['module'];
												$subscription_details_arr[$inc]['module'] = $row['module'];
												$subscription_details_arr[$inc]['status'] = $row['status'];
												$sub_lang = str_replace('VAR_USER', $this->fields_arr['user_name'], $this->LANG['common_subscribe_module_msg']);
												$sub_lang = str_replace('VAR_MODULE', ucfirst($row['module']), $sub_lang);
												$unsub_lang = str_replace('VAR_USER', $this->fields_arr['user_name'], $this->LANG['common_unsubscribe_module_msg']);
												$unsub_lang = str_replace('VAR_MODULE', ucfirst($row['module']), $unsub_lang);
												$subscription_details_arr[$inc]['sub_lang'] = $sub_lang;
												$subscription_details_arr[$inc]['unsub_lang'] = $unsub_lang;
												$inc++;
											}
									}

							}
					}

				foreach($this->CFG['site']['modules_arr'] as $key => $module)
					{
						if(!in_array($module, $module_sub_arr))
							{
								if(chkAllowedModule(array($module)))
									{
										if(chkIsSubscriptionEnabledForModule($module))
											{
												$subscription_details_arr[$inc]['module'] = $module;
												$subscription_details_arr[$inc]['status'] = 'No';
												$sub_lang = str_replace('VAR_USER', ucfirst($this->fields_arr['user_name']), $this->LANG['common_subscribe_module_msg']);
												$sub_lang = str_replace('VAR_MODULE', ucfirst($module), $sub_lang);
												$unsub_lang = str_replace('VAR_USER', ucfirst($this->fields_arr['user_name']), $this->LANG['common_unsubscribe_module_msg']);
												$unsub_lang = str_replace('VAR_MODULE', ucfirst($module), $unsub_lang);
												$subscription_details_arr[$inc]['sub_lang'] = $sub_lang;
												$subscription_details_arr[$inc]['unsub_lang'] = $unsub_lang;
												$inc++;
											}
									}
							}
					}
				$smartyObj->assign('subscription_details_arr', $subscription_details_arr);
			}

		/**
		 * SubscriptionHandler::chkIsUserPreviouslySubscribed()
		 *
		 * @return boolean
		 */
		public function chkIsUserPreviouslySubscribed()
			{
				$sql = 'SELECT status FROM '.$this->CFG['db']['tbl']['subscription'].
						' WHERE owner_id='.$this->dbObj->Param('owner_id').
						' AND subscriber_id='.$this->dbObj->Param('subscriber_id').
						' AND module='.$this->dbObj->Param('module').
						' AND subscription_type='.$this->dbObj->Param('sub_type');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['owner_id'], $this->fields_arr['subscriber_id'], $this->fields_arr['sub_module'], $this->fields_arr['sub_type']));
				if (!$rs)
					trigger_db_error($this->dbObj);

				if($rs->PO_RecordCount())
					{
						$row = $rs->FetchRow();
						if($row['status'] == 'Deleted' or $row['status'] == 'No')
							return false;
						if($row['status'] == 'Yes')
							exit;

					}
				return true;
			}

		/**
		 * SubscriptionHandler::subscribeUser()
		 *  To Subscribe User
		 * @return void
		 */
		public function subscribeUser()
			{
				if($this->chkIsUserPreviouslySubscribed())
					{
						$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['subscription'].
							   ' SET '.
							   ' owner_id = '.$this->dbObj->Param('owner_id').','.
							   ' subscriber_id = '.$this->dbObj->Param('subscriber_id').','.
							   ' module = '.$this->dbObj->Param('module').','.
							   ' date_subscribed=NOW()';

						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['owner_id'], $this->fields_arr['subscriber_id'], $this->fields_arr['sub_module']));
						if (!$rs)
						    trigger_db_error($this->dbObj);
					}
				else
					{
						$sql = 'UPDATE '.$this->CFG['db']['tbl']['subscription'].
								' SET status=\'Yes\''.
								' WHERE owner_id='.$this->dbObj->Param('owner_id').
								' AND subscriber_id='.$this->dbObj->Param('subscriber_id').
								' AND module='.$this->dbObj->Param('module');


						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['owner_id'], $this->fields_arr['subscriber_id'], $this->fields_arr['sub_module']));
						if (!$rs)
						    trigger_db_error($this->dbObj);
					}
				return true;
			}

		/**
		 * SubscriptionHandler::unSubscribeUser()
		 *
		 * @return
		 */
		public function unSubscribeUser()
			{
				$sql = 'UPDATE '.$this->CFG['db']['tbl']['subscription'].
						' SET status=\'No\''.
						' WHERE owner_id='.$this->dbObj->Param('owner_id').
						' AND subscriber_id='.$this->dbObj->Param('subscriber_id').
						' AND module='.$this->dbObj->Param('module');


				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['owner_id'], $this->fields_arr['subscriber_id'], $this->fields_arr['sub_module']));
				if (!$rs)
				    trigger_db_error($this->dbObj);
			}

		/**
		 * SubscriptionHandler::chkIsUserPreviouslySubscribedToCategory()
		 *
		 * @return boolean
		 */
		public function chkIsUserPreviouslySubscribedToCategory()
			{
				$sql = 'SELECT status FROM '.$this->CFG['db']['tbl']['subscription'].
						' WHERE category_id='.$this->dbObj->Param('category_id').
						' AND subscriber_id='.$this->dbObj->Param('subscriber_id').
						' AND module='.$this->dbObj->Param('module').
						' AND subscription_type='.$this->dbObj->Param('sub_type');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['category_id'], $this->fields_arr['subscriber_id'], $this->fields_arr['sub_module'], $this->fields_arr['sub_type']));
				if (!$rs)
					trigger_db_error($this->dbObj);

				if($rs->PO_RecordCount())
					{
						$row = $rs->FetchRow();
						if($row['status'] == 'Deleted' or $row['status'] == 'No' or $row['status'] == 'Yes')
							return false;

					}
				return true;
			}

		/**
		 * SubscriptionHandler::subscribeToCategory()
		 *  Subscribe to Category
		 * @return void
		 */
		public function subscribeToCategory()
			{
				if($this->chkIsUserPreviouslySubscribedToCategory())
					{
						$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['subscription'].
							   ' SET '.
							   ' category_id = '.$this->dbObj->Param('category_id').','.
							   ' subscriber_id = '.$this->dbObj->Param('subscriber_id').','.
							   ' module = '.$this->dbObj->Param('module').','.
							   ' subscription_type='.$this->dbObj->Param('sub_type').','.
							   ' date_subscribed=NOW()';

						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['category_id'], $this->fields_arr['subscriber_id'], $this->fields_arr['sub_module'], $this->fields_arr['sub_type']));
						if (!$rs)
						    trigger_db_error($this->dbObj);
					}
				else
					{
						$sql = 'UPDATE '.$this->CFG['db']['tbl']['subscription'].
								' SET status=\'Yes\''.
								' WHERE category_id='.$this->dbObj->Param('category_id').
								' AND subscriber_id='.$this->dbObj->Param('subscriber_id').
							    ' AND subscription_type='.$this->dbObj->Param('sub_type').
								' AND module='.$this->dbObj->Param('module');


						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['category_id'], $this->fields_arr['subscriber_id'], $this->fields_arr['sub_type'], $this->fields_arr['sub_module']));
						if (!$rs)
						    trigger_db_error($this->dbObj);
					}
			}

		/**
		 * SubscriptionHandler::unSubscribeFromCategory()
		 *
		 * @return void
		 */
		public function unSubscribeFromCategory()
			{
				$sql = 'UPDATE '.$this->CFG['db']['tbl']['subscription'].
						' SET status=\'No\''.
						' WHERE category_id='.$this->dbObj->Param('category_id').
						' AND subscriber_id='.$this->dbObj->Param('subscriber_id').
					    ' AND subscription_type='.$this->dbObj->Param('sub_type').
						' AND module='.$this->dbObj->Param('module');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['category_id'], $this->fields_arr['subscriber_id'], $this->fields_arr['sub_type'], $this->fields_arr['sub_module']));
				if (!$rs)
				    trigger_db_error($this->dbObj);
			}

		/**
		 * SubscriptionHandler::getSubscriptionContent()
		 *
		 * @return void
		 */
		public function getSubscriptionContent()
			{
				if($this->fields_arr['category_id'] != '')
					{
						$this->setFormField('sub_type', 'category');
						$sql = 'SELECT 1 FROM '.$this->CFG['db']['tbl']['subscription'].
								' WHERE category_id='.$this->dbObj->Param('category_id').
								' AND module='.$this->dbObj->Param('module').
								' AND subscription_type='.$this->dbObj->Param('subscription_type').
								' AND status=\'Yes\'';

						$stmt = $this->dbObj->Prepare($sql);

						$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['category_id'], $this->fields_arr['sub_module'], $this->fields_arr['sub_type']));
					}
				elseif($this->fields_arr['tag'] != '')
					{
						$this->setFormField('sub_type', 'tag');
						$sql = 'SELECT 1 FROM '.$this->CFG['db']['tbl']['subscription'].
								' WHERE tag_name='.$this->dbObj->Param('tag').
								' AND module='.$this->dbObj->Param('module').
								' AND subscription_type='.$this->dbObj->Param('subscription_type').
								' AND status=\'Yes\'';

						$stmt = $this->dbObj->Prepare($sql);

						$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['tag'], $this->fields_arr['sub_module'], $this->fields_arr['sub_type']));
					}

				if (!$rs)
					trigger_db_error($this->dbObj);

				$this->subscription_status = false;
				if($rs->PO_RecordCount())
					{
						$this->subscription_status = 'yes';
					}
			}

		/**
		 * SubscriptionHandler::chkIsUserPreviouslySubscribedToTag()
		 *
		 * @return boolean
		 */
		public function chkIsUserPreviouslySubscribedToTag()
			{
				$sql = 'SELECT status FROM '.$this->CFG['db']['tbl']['subscription'].
						' WHERE tag_name='.$this->dbObj->Param('tag').
						' AND subscriber_id='.$this->dbObj->Param('subscriber_id').
						' AND module='.$this->dbObj->Param('module').
						' AND subscription_type='.$this->dbObj->Param('sub_type');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['tag'], $this->fields_arr['subscriber_id'], $this->fields_arr['sub_module'], $this->fields_arr['sub_type']));
				if (!$rs)
					trigger_db_error($this->dbObj);

				if($rs->PO_RecordCount())
					{
						$row = $rs->FetchRow();
						if($row['status'] == 'Deleted' or $row['status'] == 'No' or $row['status'] == 'Yes')
							return false;


					}
				return true;
			}

		/**
		 * SubscriptionHandler::subscribeTotag()
		 *  Subscribe to Tag
		 * @return void
		 */
		public function subscribeToTag()
			{
				if($this->chkIsUserPreviouslySubscribedToTag())
					{
						$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['subscription'].
							   ' SET '.
							   ' tag_name = '.$this->dbObj->Param('tag').','.
							   ' subscriber_id = '.$this->dbObj->Param('subscriber_id').','.
							   ' module = '.$this->dbObj->Param('module').','.
							   ' subscription_type='.$this->dbObj->Param('sub_type').','.
							   ' date_subscribed=NOW()';

						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['tag'], $this->fields_arr['subscriber_id'], $this->fields_arr['sub_module'], $this->fields_arr['sub_type']));
						if (!$rs)
						    trigger_db_error($this->dbObj);
					}
				else
					{
						$sql = 'UPDATE '.$this->CFG['db']['tbl']['subscription'].
								' SET status=\'Yes\''.
								' WHERE tag_name='.$this->dbObj->Param('tag').
								' AND subscriber_id='.$this->dbObj->Param('subscriber_id').
							    ' AND subscription_type='.$this->dbObj->Param('sub_type').
								' AND module='.$this->dbObj->Param('module');


						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['tag'], $this->fields_arr['subscriber_id'], $this->fields_arr['sub_type'], $this->fields_arr['sub_module']));
						if (!$rs)
						    trigger_db_error($this->dbObj);
					}
			}

		/**
		 * SubscriptionHandler::unSubscribeFromTag()
		 *
		 * @return void
		 */
		public function unSubscribeFromTag()
			{
				$sql = 'UPDATE '.$this->CFG['db']['tbl']['subscription'].
						' SET status=\'No\''.
						' WHERE tag_name='.$this->dbObj->Param('category_id').
						' AND subscriber_id='.$this->dbObj->Param('subscriber_id').
					    ' AND subscription_type='.$this->dbObj->Param('sub_type').
						' AND module='.$this->dbObj->Param('module');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['tag'], $this->fields_arr['subscriber_id'], $this->fields_arr['sub_type'], $this->fields_arr['sub_module']));
				if (!$rs)
				    trigger_db_error($this->dbObj);
			}
	}
?>