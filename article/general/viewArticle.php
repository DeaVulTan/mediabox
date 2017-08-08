<?php
/**
 * File to allow the users to view article
 *
 * Provides an interface to view article and attachments, download attachments,
 * post comments, Flag content, Email to Friends, Add to favourites,
 * rate the article and add to bookmarking sites.
 *
 */

/**
 * ViewArticle
 *
 * @category	Rayzz
 * @package		General
 */
class ViewArticle extends ArticleHandler
	{
		public $enabled_edit_fields = array();
		public $captchaText = '';
		public $publickey;
		public $privatekey;
		public $error = null;
		public $resp = null;
		public $article_response_links = '';
		public $file_root_path = '../';


		/**
		 * ViewArticle::pageRefreshed()
		 *
		 * @return boolean
		 */
		public function pageRefreshed()
			{
				if($_SERVER['HTTP_CACHE_CONTROL'] == 'max-age=0')
					return true;
				return false;
			}



		/**
		 * ViewArticle::deleteComment()
		 *
		 * @return
		 */
		public function deleteComment()
			{
				$sql = 'SELECT article_id, article_comment_main_id  FROM '.$this->CFG['db']['tbl']['article_comments'].' WHERE'.
						' article_comment_id='.$this->dbObj->Param('article_comment_id').' LIMIT 0,1';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['comment_id']));
				    if (!$rs)
					    trigger_db_error($this->dbObj);

				$row = $rs->FetchRow();

				$sql = 'DELETE FROM '.$this->CFG['db']['tbl']['article_comments'].
						' WHERE article_comment_id='.$this->dbObj->Param('article_comment_id');
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['comment_id']));
				    if (!$rs)
					   trigger_db_error($this->dbObj);

				if($row['article_comment_main_id']==0)
				{
					if($this->dbObj->Affected_Rows())
						{

							$sql = 'UPDATE '.$this->CFG['db']['tbl']['article'].' SET total_comments = total_comments-1'.
									' WHERE article_id='.$this->dbObj->Param('article_id');

							$stmt = $this->dbObj->Prepare($sql);
							$rs = $this->dbObj->Execute($stmt, array($row['article_id']));
							    if (!$rs)
								    trigger_db_error($this->dbObj);
						}
				}
				echo '<div id="selMsgSuccess" class="clsSuccessMsg">'.$this->LANG['success_deleted'].'</div>';
			}


		/**
		 * ViewArticle::getArticleTitle()
		 *
		 * @param Integer $article_id
		 * @return Integer
		 */
		public function getArticleTitle($article_id)
			{
				$sql = 'SELECT article_title FROM '.$this->CFG['db']['tbl']['article'].
						' WHERE article_id='.$this->dbObj->Param('article_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($article_id));
				    if (!$rs)
					    trigger_db_error($this->dbObj);

				if($row = $rs->FetchRow())
					return $row['article_title'];
				return;
			}

		/**
		 * ViewArticle::selectFavorite()
		 *
		 * @param string $condition
		 * @param array $value
		 * @param string $returnType
		 * @return mixed
		 */
		public function selectFavorite($condition, $value, $returnType='')
		{
			$sql = 'SELECT article_favorite_id FROM '.$this->CFG['db']['tbl']['article_favorite'].
						' WHERE '.$condition;

			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt, $value);
			if (!$rs)
				trigger_db_error($this->dbObj);

			if(!$returnType)
				return $rs->PO_RecordCount();
			else
				return $rs;
		}

		/**
		 * ViewArticle::getFavorite()
		 *
		 * @return array
		 */
		public function getFavorite()
		{
			$favorite['added']='';
			$favorite['id']='';
			if(!isMember())
			{
				$favorite['url'] = getUrl('viewarticle', '?article_id='.
									$this->fields_arr['article_id'].'&title='.$this->changeTitle($this->fields_arr['article_title']),
										$this->fields_arr['article_id'].'/'.$this->changeTitle($this->fields_arr['article_title']).'/', 'members', 'article');
			}
			else
			{
				$condition = 'article_id='.$this->dbObj->Param('article_id').
					 		 ' AND user_id='.$this->dbObj->Param('user_id').' LIMIT 0,1';

				$condtionValue = array($this->fields_arr['article_id'], $this->CFG['user']['user_id']);

				$favorite['url'] = $this->CFG['site']['article_url'].'viewArticle.php?article_id='.
									  $this->fields_arr['article_id'].'&ajax_page=true&page=favorite';

				if($rs = $this->selectFavorite($condition, $condtionValue, 'full'))
				{
					if($rs->PO_RecordCount())
					{
						$row = $rs->FetchRow();
						$favorite['added'] = true;
						$favorite['id'] = $row['article_favorite_id'];
					}
				}
			}
			return $favorite;
		}

		/**
		 * ViewArticle::getFavoriteBlock()
		 *
		 * @return void
		 */
		public function getFavoriteBlock()
			{
				global $smartyObj;
				$getFavoriteBlock_arr = array();
				$sql = 'SELECT COUNT(1) AS total_favorites FROM '.$this->CFG['db']['tbl']['article_favorite'].
						' WHERE user_id='.$this->dbObj->Param('user_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->CFG['user']['user_id']));
				    if (!$rs)
					    trigger_db_error($this->dbObj);

				$row = $rs->FetchRow();

				$getFavoriteBlock_arr['row'] = $row;
				$smartyObj->assign('getFavoriteBlock_arr', $getFavoriteBlock_arr);
			}


		/**
		 * ViewArticle::insertFavoriteArticle()
		 *
		 * @return void
		 */
		public function insertFavoriteArticle()
			{
				if($this->fields_arr['favorite'])
				{
					$condition = 'article_id='.$this->dbObj->Param('article_id').' AND user_id='.$this->dbObj->Param('user_id');
					$condtionValue = array($this->fields_arr['article_id'], $this->CFG['user']['user_id']);

					if(!$this->selectFavorite($condition, $condtionValue))
					{
						$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['article_favorite'].' SET'.
							   ' user_id='.$this->dbObj->Param('user_id').','.
							   ' article_id='.$this->dbObj->Param('article_id').','.
						       ' date_added=NOW()';

						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, array($this->CFG['user']['user_id'], $this->fields_arr['article_id']));
						if (!$rs)
							trigger_db_error($this->dbObj);

						if($this->dbObj->Insert_ID())
						{
							$favorite_id = $this->dbObj->Insert_ID();
							$sql = 'UPDATE '.$this->CFG['db']['tbl']['article'].' SET total_favorites = total_favorites+1'.
									' WHERE article_id='.$this->dbObj->Param('article_id');

							$stmt = $this->dbObj->Prepare($sql);
							$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['article_id']));
							if (!$rs)
								trigger_db_error($this->dbObj);

							echo $this->LANG['viewarticle_favorite_added_successfully'];

							//Srart Post article favorite article activity	..
							$sql = 'SELECT pf.article_favorite_id, pf.article_id, pf.user_id as favorite_user_id, u.user_name, '.
									'p.article_title, p.user_id, p.article_server_url '.
									'FROM '.$this->CFG['db']['tbl']['article_favorite'].' as pf, '.$this->CFG['db']['tbl']['users'].
									' as u, '.$this->CFG['db']['tbl']['article'].' as p '.
									' WHERE u.user_id = pf.user_id AND pf.article_id = p.article_id '.
									' AND pf.article_favorite_id = '.$this->dbObj->Param('favorite_id');

							$stmt = $this->dbObj->Prepare($sql);
							$rs = $this->dbObj->Execute($stmt, array($favorite_id));
							if (!$rs)
								trigger_db_error($this->dbObj);

							$row = $rs->FetchRow();
							$activity_arr = $row;
							$activity_arr['action_key']	= 'article_favorite';
							$articleActivityObj = new articleActivityHandler();
							$articleActivityObj->addActivity($activity_arr);
							//end
						}
					}
				}
			}


		/**
		 * ViewArticle::deleteFavoriteArticle()
		 *
		 * @return void
		 */
		public function deleteFavoriteArticle($article_id, $user_id)
			{
				$sql = 'SELECT pf.article_favorite_id, pf.user_id as favorite_user_id, p.user_id '.
						' FROM '.$this->CFG['db']['tbl']['article_favorite'].' as pf, '.
						$this->CFG['db']['tbl']['users'].' as u, '.$this->CFG['db']['tbl']['article'].' as p '.
						' WHERE u.user_id = pf.user_id AND pf.article_id = p.article_id AND pf.user_id = '.
						$this->dbObj->Param('user_id').' AND pf.article_id = '.$this->dbObj->Param('article_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($user_id, $article_id));
				if (!$rs)
					trigger_db_error($this->dbObj);

				$row = $rs->FetchRow();
				$activity_arr = $row;
				$activity_arr['action_key']	= 'delete_article_favorite';
				$articleActivityObj = new articleActivityHandler();
				$articleActivityObj->addActivity($activity_arr);

				$sql = 'DELETE FROM '.$this->CFG['db']['tbl']['article_favorite'].' WHERE'.
						' user_id=' . $this->dbObj->Param('user_id') . ' AND' . ' article_id=' . $this->dbObj->Param('article_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($user_id, $article_id));
				if (!$rs)
					trigger_db_error($this->dbObj);

				if ($this->dbObj->Affected_Rows())
				{
					$sql = 'UPDATE '.$this->CFG['db']['tbl']['article'].' SET total_favorites = total_favorites-1'.
				 			' WHERE article_id=' . $this->dbObj->Param('article_id');

					$stmt   = $this->dbObj->Prepare($sql);
					$rs     = $this->dbObj->Execute($stmt, array($article_id));
					if (!$rs)
						trigger_db_error($this->dbObj);
				}
			}

		/**
		 * ViewArticle::insertFlagArticleTable()
		 *
		 * @return void
		 **/
		public function insertFlagArticleTable()
		{
			echo $this->LANG['viewarticle_your_request'];
			$sql = 'SELECT 1 FROM '.$this->CFG['db']['tbl']['flagged_contents'].' WHERE'.
					' content_type=\'Article\' AND'.
					' content_id='.$this->dbObj->Param('content_id').' AND'.
					' reporter_id='.$this->dbObj->Param('reporter_id').' AND'.
					' status=\'Ok\'';

			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['article_id'], $this->CFG['user']['user_id']));
		    if (!$rs)
			    trigger_db_error($this->dbObj);

			if(!$rs->PO_RecordCount())
			{
				if($this->fields_arr['flag'])
				{
					$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['flagged_contents'].' SET'.
							' content_id='.$this->dbObj->Param('content_id').','.
							' content_type=\'Article\', flag='.$this->dbObj->Param('flag').','.
							' flag_comment='.$this->dbObj->Param('flag_comment').','.
							' reporter_id='.$this->dbObj->Param('reporter_id').','.
							' date_added=NOW()';

					$stmt = $this->dbObj->Prepare($sql);
					$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['article_id'], $this->fields_arr['flag'], $this->fields_arr['flag_comment'], $this->CFG['user']['user_id']));
				    if (!$rs)
					    trigger_db_error($this->dbObj);
				}
				else if($this->fields_arr['flag_comment'])
				{
					$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['flagged_contents'].' SET'.
							' content_id='.$this->dbObj->Param('content_id').','.
							' content_type=\'Article\', flag=\'Others\','.
							' flag_comment='.$this->dbObj->Param('flag_comment').','.
							' reporter_id='.$this->dbObj->Param('reporter_id').','.
							' date_added=NOW()';

					$stmt = $this->dbObj->Prepare($sql);
					$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['article_id'], $this->fields_arr['flag_comment'], $this->CFG['user']['user_id']));
				    if (!$rs)
					    trigger_db_error($this->dbObj);
				}

				//Inform flagged article to admin through mail\\
				//Subject..
				$flagged_subject = str_replace('VAR_USER_NAME', $this->CFG['user']['user_name'], $this->LANG['article_flagged_subject']);
				$flagged_subject = str_replace('VAR_ARTICLE_TITLE', $this->fields_arr['article_title'], $flagged_subject);
				//Content..
				$sql ='SELECT article_title, article_caption'.' FROM '.$this->CFG['db']['tbl']['article'].
						' WHERE article_id='.$this->dbObj->Param('article_id').' LIMIT 0,1';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['article_id']));
				if (!$rs)
					trigger_db_error($this->dbObj);

				$row = $rs->FetchRow();
				//article title
				$flagged_message = str_replace('VAR_ARTICLE_TITLE', $row['article_title'], $this->LANG['article_flagged_content']);

				$articlelink = getUrl('viewarticle','?article_id='.$this->fields_arr['article_id'].
								'&amp;title='.$this->changeTitle($row['article_title']), $this->fields_arr['article_id'].'/'.
									$this->changeTitle($row['article_title']).'/', 'root','article');

				//article description
				$article_description = strip_tags($row['article_caption']);
				$flagged_message = str_replace('VAR_ARTICLE_DESCRIPTION', $article_description, $flagged_message);
				//flagged title, flagged content
				$admin_link = $this->CFG['site']['url'].'admin/article/manageFlaggedArticle.php';
				$flagged_title = '<a href="'.$admin_link.'">'.$this->fields_arr['flag'].'</a>';
				$flagged_message = str_replace('VAR_FLAGGED_TITLE', $flagged_title, $flagged_message);
				$flagged_message = str_replace('VAR_FLAGGED_CONTENT', $this->fields_arr['flag_comment'], $flagged_message);
				//User name
				$flagged_message = str_replace('VAR_USER_NAME', $this->CFG['user']['user_name'], $flagged_message);
				//site name
				$flagged_message = str_replace('VAR_SITE_NAME', $this->CFG['site']['name'], $flagged_message);
				$is_ok = $this->_sendMail($this->CFG['site']['webmaster_email'],
							$flagged_subject, $flagged_message, $this->CFG['site']['noreply_name'], $this->CFG['site']['noreply_email']);
			}
		}

		/**
		 * ViewArticle::getCaptchaText()
		 *
		 * @return string
		 */
		public function getCaptchaText()
			{
				$captcha_length = 5;
				$this->captchaText = rand(pow(10, $captcha_length-1), pow(10, $captcha_length)-1);
				return $this->captchaText;
			}

		/**
		 * ViewArticle::insertRating()
		 *
		 * @return void
		 **/
		public function insertRating()
			{
				if($this->fields_arr['rate'])
					{
						$rate_old = $this->chkAlreadyRated();
						$rate_new = $this->fields_arr['rate'];
						if($rate_new==1 && $rate_old==1)
							return true;

						if($rate_old > 0)
							{
								$rating_id = '';
								$diff = $rate_new - $rate_old;
								if($diff==0)
									return true;

								$sql = 'UPDATE '.$this->CFG['db']['tbl']['article_rating'].' SET'.
										' rate='.$this->dbObj->Param('rate').','.
										' date_added=NOW() '.
										' WHERE article_id='.$this->dbObj->Param('article_id').' AND '.
										' user_id='.$this->dbObj->Param('user_id');

								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['rate'], $this->fields_arr['article_id'], $this->CFG['user']['user_id']));
							    if (!$rs)
								    trigger_db_error($this->dbObj);

								if($diff >= 0)
									{
										$sql = 'UPDATE '.$this->CFG['db']['tbl']['article'].' SET'.
												' rating_total=rating_total+'.$diff.' '.
												' WHERE article_id='.$this->dbObj->Param('article_id');
									}
								else
									{
										$sql = 'UPDATE '.$this->CFG['db']['tbl']['article'].' SET'.
												' rating_total=rating_total'.$diff.' '.
												' WHERE article_id='.$this->dbObj->Param('article_id');
									}

								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['article_id']));
							    if (!$rs)
								    trigger_db_error($this->dbObj);

								//Find rating for rating article activity..
								$sql = 'SELECT rating_id '.
										'FROM '.$this->CFG['db']['tbl']['article_rating'].' '.
										' WHERE article_id='.$this->dbObj->Param('article_id').' AND '.
										' user_id='.$this->dbObj->Param('user_id');

								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['article_id'],  $this->CFG['user']['user_id']));
								if (!$rs)
									trigger_db_error($this->dbObj);

								$row = $rs->FetchRow();
								$rating_id = $row['rating_id'];
							}
						else
							{
								$sql =  ' INSERT INTO '.$this->CFG['db']['tbl']['article_rating'].
										' (article_id, user_id, rate, date_added ) '.
										' VALUES ( '.
										$this->dbObj->Param('article_id').','.$this->dbObj->Param('user_id').','.$this->dbObj->Param('rate').',NOW()'.
										' ) ';

								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['article_id'], $this->CFG['user']['user_id'], $this->fields_arr['rate']));
							    if (!$rs)
								    trigger_db_error($this->dbObj);

								$rating_id = $this->dbObj->Insert_ID();

								$sql =  ' UPDATE '.$this->CFG['db']['tbl']['article'].' SET'.
										' rating_total=rating_total+'.$this->fields_arr['rate'].','.
										' rating_count=rating_count+1'.
										' WHERE article_id='.$this->dbObj->Param('article_id');

								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['article_id']));
							    if (!$rs)
								    trigger_db_error($this->dbObj);
							}

							//Code to store article rating activity in Article Activity table
							$sql = 'SELECT ar.rating_id, ar.article_id, ar.user_id as rating_user_id, ar.rate, '.
									'u.user_name, a.article_title, a.user_id, a.article_server_url '.
									'FROM '.$this->CFG['db']['tbl']['article_rating'].' as ar, '.
									$this->CFG['db']['tbl']['users'].' as u, '.$this->CFG['db']['tbl']['article'].' as a '.
									' WHERE u.user_id = ar.user_id AND ar.article_id = a.article_id AND ar.rating_id = '.
									$this->dbObj->Param('rating_id');

							$stmt = $this->dbObj->Prepare($sql);
							$rs = $this->dbObj->Execute($stmt, array($rating_id));
							if (!$rs)
								trigger_db_error($this->dbObj);

							$row = $rs->FetchRow();
							$activity_arr = $row;
							$activity_arr['action_key']	= 'article_rated';
							$articleActivityObj = new articleActivityHandler();
							$articleActivityObj->addActivity($activity_arr);
					}
			}

		/**
		 * ViewArticle::getTotalRatingImage()
		 *
		 * @return void
		 **/
		public function getTotalRatingImage()
			{

				if($this->populateArticlelistDetails())
					{
					    $rating = round($this->fields_arr['rating_total']/$this->fields_arr['rating_count'],0);
						$this->populateRatingImagesForAjax($rating);
						$rating_text = ($this->fields_arr['rating_count'] >1 )?$this->LANG['viewarticle_total_ratings']:$this->LANG['viewarticle_rating'];
						echo '<span>('.$this->fields_arr['rating_count'].')</span>';
					}

			}

		/**
		 * ViewArticle::populateArticlelistDetails()
		 *
		 * @return boolean
		 **/
		public function populateArticlelistDetails()
			{
				$sql = 'SELECT rating_total, rating_count FROM '.$this->CFG['db']['tbl']['article'].
						' WHERE article_id='.$this->dbObj->Param('article_id').' LIMIT 0,1';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['article_id']));
				    if (!$rs)
					    trigger_db_error($this->dbObj);

				if($row = $rs->FetchRow())
					{
						$this->fields_arr['rating_total'] = $row['rating_total'];
						$this->fields_arr['rating_count'] = $row['rating_count'];
						return true;
					}
				return false;
			}

		/**
		 * ViewArticle::chkAllowRating()
		 *
		 * @return boolean
		 */
		public function chkAllowRating()
			{
				$sql = 'SELECT 1 FROM '.$this->CFG['db']['tbl']['article'].
						' WHERE article_id='.$this->dbObj->Param('article_id').
						' AND allow_ratings=\'Yes\' AND article_status=\'Ok\' LIMIT 0,1';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['article_id']));
				    if (!$rs)
					    trigger_db_error($this->dbObj);

				if($rs->PO_RecordCount())
					return true;
				return false;
			}

		/**
		 * ViewArticle::getCommentsBlock()
		 *
		 * @return void
		 */
		public function getCommentsBlock()
			{
				global $smartyObj;
				$getCommentsBlock_arr = array();

				if($this->CFG['admin']['articles']['captcha'] and $this->CFG['admin']['articles']['captcha_method']=='image')
					{
						$getCommentsBlock_arr['captcha_comment_url'] = $this->CFG['site']['url'].'captchaComment.php?captcha_key=articlecomment&amp;captcha_value='.$this->getCaptchaText();
					}

				$smartyObj->assign('getCommentsBlock_arr', $getCommentsBlock_arr);
				setTemplateFolder('general/', 'article');
				$smartyObj->display('getCommentsBlock.tpl');

			}

		/**
		 * ViewArticle::getChannelOfThisArticle()
		 *
		 * @return array
		 **/
		public function getChannelOfThisArticle()
			{
				$getChannelOfThisArticle_arr = array();
				$sql = 'SELECT article_category_name FROM '.$this->CFG['db']['tbl']['article_category'].
						' WHERE article_category_id='.$this->dbObj->Param('article_category_id').' LIMIT 0,1';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['article_category_id']));
				    if (!$rs)
					    trigger_db_error($this->dbObj);

				if($row = $rs->FetchRow())
					{
						$getChannelOfThisArticle_arr['channel_url'] = getUrl('articlelist', '?pg=articlenew&amp;cid='.$this->fields_arr['article_category_id'], 'articlenew/?cid='.$this->fields_arr['article_category_id'], '', 'article');
						$getChannelOfThisArticle_arr['article_category_name'] = $row['article_category_name'];
					}
				return $getChannelOfThisArticle_arr;
			}

		/**
		 * ViewArticle::getTagsOfThisArticle()
		 *
		 * @return array
		 **/
		public function getTagsOfThisArticle()
			{
				$getTagsOfThisArticle_arr = array();
				$tags_arr = explode(' ',$this->fields_arr['article_tags']);
				$inc = 0;
				foreach($tags_arr as $tagkey => $tags)
					{
						$getTagsOfThisArticle_arr[$inc]['url'] = getUrl('articlelist', '?pg=articlenew&amp;tags='.$tags, 'articlenew/?tags='.$tags, '', 'article');
						$getTagsOfThisArticle_arr[$inc]['tags'] = $tags;
						if($tagkey < (count($tags_arr)-1))
							$getTagsOfThisArticle_arr[$inc]['tags'].=', ';
						$inc++;
					}
				return $getTagsOfThisArticle_arr;
			}

		/**
		 * ViewArticle::chkValidArticleId()
		 *
		 * @return boolean
		 **/
		public function chkValidArticleId()
			{
				$articleId = $this->fields_arr['article_id'];
				$articleId = is_numeric($articleId)?$articleId:0;
				if (!$articleId)
				    {
				        return false;
				    }
				$userId = $this->CFG['user']['user_id'];

				//Added condition to view article only by article owner and admin if article status is not set as OK
				if($this->chkisArticleOwner() || isAdmin())
				{
					$condition = 'p.article_status!=\'Deleted\' AND p.article_id='.$this->dbObj->Param($articleId).
								' AND (p.user_id = '.$this->dbObj->Param($userId).' OR'.
								' p.article_access_type = \'Public\''.$this->getAdditionalQuery('p.').')';
				}
				else
				{
					$condition = 'p.article_status =\'Ok\' AND p.article_id='.$this->dbObj->Param($articleId).
								' AND (p.user_id = '.$this->dbObj->Param($userId).' OR'.
								' p.article_access_type = \'Public\''.$this->getAdditionalQuery('p.').')';
				}

				$sql = 'SELECT p.article_attachment, p.total_favorites, p.total_views, p.total_comments, p.total_downloads, article_server_url,'.
						' p.allow_comments,p.article_category_id,p.article_tags, p.article_status, DATE_FORMAT(p.date_of_publish,\''.$this->CFG['format']['date'].'\') as date_of_publish,'.
						' p.allow_ratings, p.rating_total, p.rating_count, p.user_id, p.flagged_status, p.article_caption, p.article_summary,'.
						' (p.rating_total/p.rating_count) as rating,'.
						' p.article_title, DATE_FORMAT(date_added,\''.$this->CFG['format']['date'].'\') as date_added'.
						' FROM '.$this->CFG['db']['tbl']['article'].' as p WHERE '.$condition.' LIMIT 0,1';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($articleId, $userId));
				    if (!$rs)
					    trigger_db_error($this->dbObj);

				$fields_list = array('user_name', 'first_name', 'last_name');
				if($row = $rs->FetchRow())
					{
						if(!isset($this->UserDetails[$row['user_id']]))
							getUserDetail('user_id', $row['user_id']);

						$name = getUserDetail('user_id', $row['user_id'], 'user_name');
						$this->fields_arr['user_id'] = $row['user_id'];
						$this->fields_arr['article_server_url'] = $row['article_server_url'];
						$this->fields_arr['allow_comments'] = $row['allow_comments'];
						$this->fields_arr['allow_ratings'] = $row['allow_ratings'];
						$this->fields_arr['article_title'] = $row['article_title'];
						$this->fields_arr['article_summary'] = stripslashes($row['article_summary']);
						$this->fields_arr['article_caption'] = strip_selected_article_tags(stripslashes($row['article_caption']));
						$this->fields_arr['date_added'] = $row['date_added'];
						$this->fields_arr['date_of_publish'] = $row['date_of_publish'];
						$this->fields_arr['article_status'] = $row['article_status'];
						$this->fields_arr['user_name'] = $name;
						$this->fields_arr['rating_total'] = $row['rating_total'];
						$this->fields_arr['rating_count'] = $row['rating_count'];
						$this->article_rating = round($row['rating']);
						$this->fields_arr['flagged_status'] = $row['flagged_status'];
						$this->fields_arr['comments'] = $row['total_comments']?$row['total_comments']:0;

						$this->fields_arr['favorited'] = $row['total_favorites'];
						$this->fields_arr['total_views'] = $row['total_views'];
						$this->fields_arr['total_comments'] = $row['total_comments'];
						$this->fields_arr['article_category_id'] = $row['article_category_id'];
						$this->fields_arr['article_tags'] = $row['article_tags'];
						$this->fields_arr['name'] = $name;
						$this->fields_arr['article_attachment'] = $row['article_attachment'];
						$this->fields_arr['total_downloads'] = $row['total_downloads'];
						return true;
					}
				return false;
			}

		/**
		 * ViewArticle::getAttachmentDetails()
		 *
		 * @return void
		 */
		public function getAttachmentDetails()
			{
				global $smartyObj;
				$getAttachmentDetails_arr = array();

				$sql = 'SELECT attachment_id, file_name, '.
						' DATE_FORMAT(date_added,\''.$this->CFG['format']['date'].'\') as date_added'.
						' FROM '.$this->CFG['db']['tbl']['article_attachments'].' WHERE article_id='.$this->dbObj->Param('attahcment_article_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['article_id']));
				    if (!$rs)
					    trigger_db_error($this->dbObj);

				$getAttachmentDetails['row'] = array();
				$inc = 1;
				while($row = $rs->FetchRow())
					{
						$getAttachmentDetails['row'][$inc]['record'] = $row;
						$getAttachmentDetails['row'][$inc]['download_url'] = getUrl('viewarticle', '?article_id='.$this->fields_arr['article_id'].'&amp;title='.$this->changeTitle($this->fields_arr['article_title']).'&amp;attachment_id='.$row['attachment_id'], $this->fields_arr['article_id'].'/'.$this->changeTitle($this->fields_arr['article_title']).'/?attachment_id='.$row['attachment_id'], 'members', 'article');;
						$inc++;
					}

				$smartyObj->assign('getAttachmentDetails', $getAttachmentDetails);
			}


		/**
		 * ViewArticle::populateRatingImagesForAjax()
		 *
		 * @param Integer rating
		 * @return void
		 **/
		public function populateRatingImagesForAjax($rating)
			{
				$rating_total = $this->CFG['admin']['total_rating'];
				for($i=1;$i<=$rating;$i++)
				{
?>
					<a onClick="return callAjaxRate('<?php echo $this->CFG['site']['article_url'].'viewArticle.php?ajax_page=true&article_id='.
					$this->fields_arr['article_id'].'&'.'rate='.$i;?>&show=<?php echo $this->fields_arr['show'];?>','selRatingArticle')"
					onMouseOver="ratingArticleMouseOver(<?php echo $i;?>, 'article')" onMouseOut="ratingArticleMouseOut(<?php echo $i;?>)">
					<img id="img<?php echo $i;?>" src="<?php echo $this->CFG['site']['article_url'].'design/templates/'.
					$this->CFG['html']['template']['default'].'/root/images/'.$this->CFG['html']['stylesheet']['screen']['default'].
					'/icon-articleratehover.gif'; ?>"  title="<?php echo $i;?>" /></a>
<?php
				}
				for($i=$rating;$i<$rating_total;$i++)
				{
?>
					<a onClick="return callAjaxRate('<?php echo $this->CFG['site']['article_url'].'viewArticle.php?ajax_page=true&article_id='.
					$this->fields_arr['article_id'].'&'.'rate='.($i+1);?>&show=<?php echo $this->fields_arr['show'];?>','selRatingArticle')"
					 onMouseOver="ratingArticleMouseOver(<?php echo ($i+1);?>, 'article')" onMouseOut="ratingArticleMouseOut(<?php echo ($i+1);?>)">
					 <img id="img<?php echo ($i+1);?>" src="<?php echo $this->CFG['site']['article_url'].'design/templates/'.
					 $this->CFG['html']['template']['default'].'/root/images/'.$this->CFG['html']['stylesheet']['screen']['default'].
					 '/icon-articlerate.gif'; ?>"  title="<?php echo ($i+1);?>" /></a>
<?php
				}
			}


		/**
		 * ViewArticle::getReferrerUrl()
		 *
		 * @return void
		 **/
		public function getRefererUrl()
			{
				//return;
				if($this->fields_arr['vpkey'])
					{
						if(isset($_SESSION['vpb'][$this->fields_arr['vpkey']]))
							{
?>
<span class="clsGoBack"><a href="<?php echo $_SESSION['vpb'][$this->fields_arr['vpkey']];?>"><?php echo $this->LANG['viewarticle_go_back'];?></a></span>
<?php
							}
						else
							{
?>
<span class="clsGoBackDisable"><?php echo $this->LANG['viewarticle_go_back'];?></span>
<?php
							}
					}
				else
					{
						if(isset($_SERVER['HTTP_REFERER']) and !strstr($_SERVER['HTTP_REFERER'],'viewArticle') and !strstr($_SERVER['HTTP_REFERER'],'articlePostComment') and !strstr($_SERVER['HTTP_REFERER'],'viewAllArticleComments'))
							{
								$key = substr(md5(microtime()),0,10);
								$_SESSION['vpb'][$key] = $_SERVER['HTTP_REFERER'];
								$this->fields_arr['vpkey'] = $key;
?>
<span class="clsGoBack"><a href="<?php echo $_SESSION['vpb'][$this->fields_arr['vpkey']];?>"><?php echo $this->LANG['viewarticle_go_back'];?></a></span>
<?php
							}
						else
							{
?>
<span class="clsGoBackDisable"><?php echo $this->LANG['viewarticle_go_back'];?></span>
<?php
							}
					}
			}

		/**
		 * ViewArticle::chkAlreadyRated()
		 *
		 * @return Integer
		 **/
		public function chkAlreadyRated()
			{
				$sql = 'SELECT rate FROM '.$this->CFG['db']['tbl']['article_rating'].
						' WHERE user_id='.$this->dbObj->Param('user_id').' AND'.
						' article_id='.$this->dbObj->Param('article_id').' LIMIT 0,1';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->CFG['user']['user_id'], $this->fields_arr['article_id']));
				    if (!$rs)
					    trigger_db_error($this->dbObj);

				if($row = $rs->FetchRow())
					return $row['rate'];
				return 0;
			}

		/**
		 * ViewArticle::populateRatingDetails()
		 *
		 * @return Integer
		 **/
		public function populateRatingDetails()
			{
				if($this->fields_arr['rating_count'])
					{
						$rating = 0;
						if($this->fields_arr['rating_count'])
							$rating = round($this->fields_arr['rating_total']/$this->fields_arr['rating_count'],0);
						return $rating;
					}
			}

		/**
		 * ViewArticle::getRating()
		 *
		 * @param Integer $user_id
		 * @return Integer
		 */
		public function getRating($user_id)
			{
				$sql = 'SELECT rate FROM '.$this->CFG['db']['tbl']['article_rating'].
						' WHERE user_id='.$this->dbObj->Param('user_id').' AND'.
						' article_id='.$this->dbObj->Param('article_id').' LIMIT 0,1';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($user_id, $this->fields_arr['article_id']));
				    if (!$rs)
					    trigger_db_error($this->dbObj);

				if($row = $rs->FetchRow())
					{
						return $row['rate'];
					}
				return 0;
			}

		/**
		 * ViewArticle::populateReply()
		 *
		 * @param Integer $comment_id
		 * @return array
		 */
		public function populateReply($comment_id)
			{
				$populateReply_arr = array();
				$sql = 'SELECT article_comment_id,article_comment_main_id, comment_user_id,'.
						' comment, TIMEDIFF(NOW(), date_added) as pc_date_added, date_added, NOW() as date_current,'.
						' TIME_TO_SEC(TIMEDIFF(NOW(), date_added)) AS date_edit'.
						' FROM '.$this->CFG['db']['tbl']['article_comments'].
						' WHERE article_id='.$this->dbObj->Param('article_id').' AND'.
						' article_comment_main_id='.$this->dbObj->Param('article_comment_main_id').
						' ORDER BY article_comment_id DESC';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['article_id'], $comment_id));
				    if (!$rs)
					    trigger_db_error($this->dbObj);

				$populateReply_arr['row'] = array();
				$populateReply_arr['PO_RecordCount'] = $rs->PO_RecordCount();
				if($rs->PO_RecordCount())
					{

						$fields_list = array('user_name', 'first_name', 'last_name', 'icon_id', 'icon_type','image_ext', 'sex');
						$inc = 0;
						while($row = $rs->FetchRow())
							{
								if(!isset($this->UserDetails[$row['comment_user_id']]))
									$this->UserDetails = getUserDetail('user_id', $row['comment_user_id'], 'user_name');

								$populateReply_arr['row'][$inc]['name'] = getUserDetail('user_id', $row['comment_user_id'], 'user_name');
								$populateReply_arr['row'][$inc]['icon'] = getMemberAvatarDetails($row['comment_user_id']);

								$populateReply_arr['row'][$inc]['memberProfileUrl'] = getMemberProfileUrl($row['comment_user_id'], $this->UserDetails);

								//$row['pc_date_added'] = getTimeDiffernceFormat($row['pc_date_added']);
								$row['pc_date_added'] = ($row['date_added'] != '') ? getTimeDiffernceFormat($this->getDateTimeDiff($row['date_added'],$row['date_current'])):'';
								$populateReply_arr['row'][$inc]['record'] = $row;

								$populateReply_arr['row'][$inc]['class'] = 'clsNotEditable';
								if($row['comment_user_id']==$this->CFG['user']['user_id'])
									{
										$time = $this->CFG['admin']['articles']['comment_edit_allowed_time']-$row['date_edit'];
										if($time>2)
											{
												$populateReply_arr['row'][$inc]['class'] = "clsEditable";
											}
									}

								$populateReply_arr['row'][$inc]['comment_memberProfileUrl'] = getMemberProfileUrl($row['comment_user_id'], $this->UserDetails);
								$populateReply_arr['row'][$inc]['comment_makeClickableLinks'] = nl2br(makeClickableLinks($row['comment']));

								if(isMember() and $row['comment_user_id']==$this->CFG['user']['user_id'])
									{
										$populateReply_arr['row'][$inc]['time'] = $this->CFG['admin']['articles']['comment_edit_allowed_time']-$row['date_edit'];
										if($populateReply_arr['row'][$inc]['time']>2)
											{
												$this->enabled_edit_fields[$row['article_comment_id']] = $populateReply_arr['row'][$inc]['time'];
											}
									}
								$inc++;
							}
					}
				return $populateReply_arr;
			}

		/**
		 * ViewArticle::getTotalComments()
		 *
		 * @return Integer
		 */
		public function getTotalComments()
			{
				$sql = 'SELECT total_comments FROM '.$this->CFG['db']['tbl']['article'].
						' WHERE article_id='.$this->dbObj->Param('article_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['article_id']));
				    if (!$rs)
					    trigger_db_error($this->dbObj);

				$row = $rs->FetchRow();
				return $this->fields_arr['total_comments'] = $row['total_comments']?$row['total_comments']:0;
			}


		/**
		 * ViewArticle::populateCommentOptionsArticle()
		 *
		 * @return
		 */
		public function populateCommentOptionsArticle()
			{
				$this->CFG['admin']['articles']['total_comments']=$this->fields_arr['show']=='all'?'100000':$this->CFG['admin']['articles']['total_comments'];

				$sql = 'SELECT vc.article_comment_id, vc.comment_user_id,'.
						' vc.comment, TIMEDIFF(NOW(), vc.date_added) as pc_date_added,'.
						' TIME_TO_SEC(TIMEDIFF(NOW(), vc.date_added)) AS date_edit'.
						' FROM '.$this->CFG['db']['tbl']['article_comments'].' AS vc'.
						' WHERE vc.article_id='.$this->dbObj->Param('article_id').' AND'.
						' vc.article_comment_main_id=0 AND'.
						' vc.comment_status=\'Yes\' ORDER BY vc.article_comment_id DESC LIMIT '.$this->CFG['admin']['articles']['total_comments'];

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['article_id']));
				    if (!$rs)
					    trigger_db_error($this->dbObj);

				$total_comments = $rs->PO_RecordCount();
				$this->fields_arr['total_comments'] = $this->getTotalComments();
				$this->comment_approval = 0;
				if(isMember())
					{
						$this->commentUrl = $this->CFG['site']['article_url'].'viewArticle.php?type=add_comment&article_id='.$this->getFormField('article_id');
					}
				else
					{
						$this->commentUrl =getUrl('viewarticle','?article_id='.$this->fields_arr['article_id'].'&title='.$this->changeTitle($this->fields_arr['article_title']).'&loginrequired=1', $this->fields_arr['article_id'].'/'.$this->changeTitle($this->fields_arr['article_title']).'/?loginrequired=1', '','article');
					}
				if($this->getFormField('allow_comments')=='Kinda')
					{
						$this->comment_approval = 0;

					}
				else if($this->getFormField('allow_comments')=='Yes')
					{
						$this->comment_approval = 1;
					}
			}


		/**
		 * ViewArticle::populateCommentOfThisArticle()
		 *
		 * @return void
		 **/

		public function populateCommentOfThisArticle()
			{
				global $smartyObj;
				//Array to store article comments

				$populateCommentOfThisArticle_arr = array();
                $this->setTableNames(array($this->CFG['db']['tbl']['article_comments'].' AS vc', $this->CFG['db']['tbl']['users'].' AS u'));
				$this->setReturnColumns(array('vc.article_comment_id', 'vc.comment_user_id', 'vc.comment', 'TIMEDIFF(NOW(), vc.date_added) as pc_date_added', 'TIME_TO_SEC(TIMEDIFF(NOW(), vc.date_added)) AS date_edit'));
               $this->sql_condition = 'vc.article_id=\''.$this->fields_arr['article_id'].'\' AND vc.article_comment_main_id=0 AND u.user_id=vc.comment_user_id AND u.usr_status=\'Ok\' AND vc.comment_status=\'Yes\'';
                $this->sql_sort = 'vc.article_comment_id DESC';

			    /**
			     * ***** navigtion continue********
			     */

				$this->buildSelectQuery();
			    $this->buildQuery();
			    $this->executeQuery();
			    //$this->printQuery();
			    /**
			     * ****** Navigation End *******
			     */
				$paging_arr = array();
			    $smartyObj->assign('paging_arr', $paging_arr);


				$populateCommentOfThisArticle_arr['comment_approval'] = 0;

				if($this->getFormField('allow_comments')=='Kinda')
					{
						$populateCommentOfThisArticle_arr['comment_approval'] = 0;
						if(!isMember())
							{
								$populateCommentOfThisArticle_arr['approval_url'] = getUrl('viewarticle', '?article_id='.$this->fields_arr['article_id'].'&amp;title='.$this->changeTitle($this->fields_arr['article_title']), $this->fields_arr['article_id'].'/'.$this->changeTitle($this->fields_arr['article_title']).'/', 'members', 'article');
							}
					}
				else if($this->getFormField('allow_comments')=='Yes')
					{
						$populateCommentOfThisArticle_arr['comment_approval'] = 1;
						if(!isMember())
							{
								$populateCommentOfThisArticle_arr['post_comment_url'] = getUrl('viewarticle', '?article_id='.$this->fields_arr['article_id'].'&amp;title='.$this->changeTitle($this->fields_arr['article_title']), $this->fields_arr['article_id'].'/'.$this->changeTitle($this->fields_arr['article_title']).'/', 'members', 'article');
							}
					}

				$populateCommentOfThisArticle_arr['row'] = array();

			    if ($this->isResultsFound())
					{
						$this->fields_arr['ajaxpaging'] = 1;
						$populateCommentOfThisArticle_arr['hidden_arr'] = array('start', 'ajaxpaging');
					$smartyObj->assign('smarty_paging_list', $this->populatePageLinksPOSTViaAjax($this->getFormField('start'),'frmVideoComments', 'selCommentBlock'));
						$this->fields_arr['total_comments'] = (isset($this->fields_arr['total_comments']) and $this->fields_arr['total_comments'])?$this->fields_arr['total_comments']:$this->getTotalComments();

						$fields_list = array('user_name', 'first_name', 'last_name', 'icon_id', 'icon_type', 'sex');
						$this->UserDetails = array();
						$inc = 0;

						while($row = $this->fetchResultRecord())
							{
								if(!isset($this->UserDetails[$row['comment_user_id']]))
									$this->getUserDetail('user_id', $row['comment_user_id'], 'user_name');
								$user_name= $this->getUserDetail('user_id',$row['comment_user_id'], 'user_name');
								$populateCommentOfThisArticle_arr['row'][$inc]['name'] = $this->getUserDetail('user_id',$row['comment_user_id'], 'user_name');
								$populateCommentOfThisArticle_arr['row'][$inc]['icon'] = getMemberAvatarDetails($row['comment_user_id']);
								$populateCommentOfThisArticle_arr['row'][$inc]['memberProfileUrl'] = getMemberProfileUrl($row['comment_user_id'], $user_name);
								$row['pc_date_added'] = getTimeDiffernceFormat($row['pc_date_added']);
								$populateCommentOfThisArticle_arr['row'][$inc]['class'] = 'clsNotEditable';

								if($row['comment_user_id']==$this->CFG['user']['user_id'])
									{
										$time = $this->CFG['admin']['articles']['comment_edit_allowed_time']-$row['date_edit'];
										if($time>2)
											{
												$populateCommentOfThisArticle_arr['row'][$inc]['class'] = "clsEditable";
											}
									}
								$row['comment'] = $row['comment'];
								$populateCommentOfThisArticle_arr['row'][$inc]['record'] = $row;
								$populateCommentOfThisArticle_arr['row'][$inc]['reply_url']= $this->CFG['site']['url'].'article/viewArticle.php?article_id='.$this->getFormField('article_id').'&vpkey='.$this->getFormField('vpkey').'&show='.$this->getFormField('show').'&comment_id='.$row['article_comment_id'].'&type=comment_reply';

								$populateCommentOfThisArticle_arr['row'][$inc]['delete_comment_url'] = getUrl('viewarticle', '?article_id='.$this->fields_arr['article_id'].'&title='.$this->changeTitle($this->fields_arr['article_title']).'&comment_id='.$row['article_comment_id'].'&ajax_page=true&page=deletecomment', $this->fields_arr['article_id'].'/'.$this->changeTitle($this->fields_arr['article_title']).'/?comment_id='.$row['article_comment_id'].'&ajax_page=true&page=deletecomment', '', 'article');
								$populateCommentOfThisArticle_arr['row'][$inc]['comment_member_profile_url'] = getMemberProfileUrl($row['comment_user_id'], $user_name);

								$populateCommentOfThisArticle_arr['row'][$inc]['makeClickableLinks'] = nl2br(makeClickableLinks($row['comment']));


								if(isMember() and $row['comment_user_id']==$this->CFG['user']['user_id'])
									{
										$populateCommentOfThisArticle_arr['row'][$inc]['time'] = $this->CFG['admin']['articles']['comment_edit_allowed_time']-$row['date_edit'];
										if($populateCommentOfThisArticle_arr['row'][$inc]['time'] > 2)
											{
												$this->enabled_edit_fields[$row['article_comment_id']] = $populateCommentOfThisArticle_arr['row'][$inc]['time'];
											}
									}
								else
									{
										if(!isMember())
											{
												$populateCommentOfThisArticle_arr['row'][$inc]['comment_reply_url'] = getUrl('viewarticle', '?article_id='.$this->fields_arr['article_id'].'&amp;title='.$this->changeTitle($this->fields_arr['article_title']), $this->fields_arr['article_id'].'/'.$this->changeTitle($this->fields_arr['article_title']), '', 'article');
											}
									}
								$populateCommentOfThisArticle_arr['row'][$inc]['populateReply_arr'] = $this->populateReply($row['article_comment_id']);
								$inc++;
							} //while

						if($this->fields_arr['total_comments']>$this->CFG['admin']['articles']['total_comments'])
							{
						  		$populateCommentOfThisArticle_arr['view_all_comments_url'] = getUrl('viewarticle', '?article_id='.$this->fields_arr['article_id'].'&amp;title='.$this->changeTitle($this->fields_arr['article_title']).'&amp;vpkey='.$this->fields_arr['vpkey'].'&amp;show=all', $this->fields_arr['article_id'].'/'.$this->changeTitle($this->fields_arr['article_title']).'/?vpkey='.$this->fields_arr['vpkey'].'&amp;show=all', '', 'article');
								$populateCommentOfThisArticle_arr['view_all_comments'] = sprintf($this->LANG['view_all_comments'],'<span id="total_comments2">'.$this->fields_arr['total_comments'].'</span>');
						  	}
				    }
				$smartyObj->assign('populateCommentOfThisArticle_arr', $populateCommentOfThisArticle_arr);

				setTemplateFolder('general/', 'article');
				$smartyObj->display('populateCommentOfThisArticle.tpl');
			}


		/**
		 * ViewArticle::insertCommentAndArticleTable()
		 *
		 * @return void
		 */

		public function insertCommentAndArticleTable()
			{
			global $smartyObj;



				$sql = 'SELECT allow_comments FROM '.$this->CFG['db']['tbl']['article'].
						' WHERE article_id='.$this->dbObj->Param('article_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['article_id']));
				    if (!$rs)
					   trigger_db_error($this->dbObj);

				$row = $rs->FetchRow();
				$this->fields_arr['allow_comments'] = $row['allow_comments'];
				$comment_status = 'Yes';


				if($row['allow_comments']=='Kinda')
					$comment_status = 'No';

				$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['article_comments'].' SET'.
						' article_id='.$this->dbObj->Param('article_id').','.
						' article_comment_main_id='.$this->dbObj->Param('article_comment_main_id').','.
						' comment_user_id='.$this->dbObj->Param('comment_user_id').','.
						' comment='.$this->dbObj->Param('comment').','.
						' comment_status='.$this->dbObj->Param('comment_status').','.
						' date_added=NOW()';


				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['article_id'], $this->fields_arr['comment_id'], $this->CFG['user']['user_id'], $this->fields_arr['f'], $comment_status));
				    if (!$rs)
					    trigger_db_error($this->dbObj);

				$next_id = $this->dbObj->Insert_ID();


				if($next_id and $comment_status=='Yes' and (!$this->fields_arr['comment_id']))
					{
						$sql = 'UPDATE '.$this->CFG['db']['tbl']['article'].' SET total_comments = total_comments+1'.
								' WHERE article_id='.$this->dbObj->Param('article_id');

						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['article_id']));
						    if (!$rs)
							    trigger_db_error($this->dbObj);
					}

				//SEND MAIL TO ARTICLE OWNER
				//if($this->CFG['user']['user_id'] != $this->fields_arr['user_id'])
				//	$this->sendMailToUserForVideoComment();



				$sql = 'SELECT bc.article_comment_id, bc.comment_user_id, u.user_name, '.
						'bp.article_title, bp.user_id '.
						'FROM '.$this->CFG['db']['tbl']['article_comments'].' as bc, '.
						$this->CFG['db']['tbl']['users'].' as u, '.$this->CFG['db']['tbl']['article'].' as bp '.
						' WHERE u.user_id = bc.comment_user_id AND '.
						' bc.article_comment_id = '.$this->dbObj->Param('next_id');

			//	echo $sql;
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($next_id));
				if (!$rs)
					trigger_db_error($this->dbObj);

				$row = $rs->FetchRow();
				$activity_arr = $row;
				$activity_arr['action_key']	= 'article_comment';
				$articleActivityObj = new ArticleActivityHandler();
			//	$videoActivityObj->addActivity($activity_arr);


				//echo $this->fields_arr['comment_id'];


					if ($this->fields_arr['comment_id'])
					{

						$cmValue['populateReply_arr'] = $this->populateReply($this->fields_arr['comment_id']);
						$smartyObj->assign('cmValue', $cmValue);
						setTemplateFolder('general/', 'article');
						$smartyObj->display('populateReplyForCommentsOfThisArticle.tpl');
					}
				else
					{
						$this->populateCommentOfThisArticle();
					}
			}

		/**
		 * ViewArticle::populateReplyCommentOfThisArticle()
		 *
		 * @return
		 */
		public function populateReplyCommentOfThisArticle()
			{
				global $smartyObj;
				$cmValue['populateReply_arr'] = $this->populateReply($this->fields_arr['maincomment_id']);
				$smartyObj->assign('cmValue', $cmValue);
				setTemplateFolder('general/', 'article');
				$smartyObj->display('populateReplyForCommentsOfThisArticle.tpl');
			}




		/**
		 * ViewArticle::updateCommentAndArticleTable()
		 *
		 * @return void
		 **/
		public function updateCommentAndArticleTable()
			{
				$sql = 'UPDATE '.$this->CFG['db']['tbl']['article_comments'].' SET'.
						' comment='.$this->dbObj->Param('comment').
						' WHERE article_comment_id='.$this->dbObj->Param('article_comment_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['f'], $this->fields_arr['comment_id']));
			    if (!$rs)
				    trigger_db_error($this->dbObj);

				$this->setPageBlockShow('update_comment');
			}

		/**
		 * ViewArticle::getExistingRecords()
		 *
		 * @param mixed $sql
		 * @return
		 */
		public function getExistingRecords($sql)
			{
				$stmt = $this->dbObj->Prepare($sql);
				//echo $sql.'<br />';
				$rs = $this->dbObj->Execute($stmt);
				 if (!$rs)
				    trigger_db_error($this->dbObj);
				$row = $rs->FetchRow();
				return 	$row['count'];
			}

		/**
		 * ViewArticle::getComment()
		 *
		 * @return string
		 **/
		public function getComment()
			{
				$sql = 'SELECT comment FROM '.$this->CFG['db']['tbl']['article_comments'].' WHERE'.
						' article_comment_id='.$this->dbObj->Param('article_comment_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['comment_id']));
			    if (!$rs)
				    trigger_db_error($this->dbObj);

				if($row = $rs->FetchRow())
					{
						return $row['comment'];
					}
			}

		/**
		 * ViewArticle::getFavoriteLink()
		 *
		 * @return array
		 **/
		public function getFavoriteLink()
			{
				$getFavoriteLink_arr = array();
				if(!isMember())
					{
						$getFavoriteLink_arr['view_article_url'] = getUrl('viewarticle', '?mem_auth=true&article_id='.$this->fields_arr['article_id'].'&amp;title='.$this->changeTitle($this->fields_arr['article_title']), $this->fields_arr['article_id'].'/'.$this->changeTitle($this->fields_arr['article_title']).'/?mem_auth=true', 'members', 'article');
					}
				$sql = 'SELECT count(1) as count FROM '.$this->CFG['db']['tbl']['article_favorite'].
						' WHERE article_id='.$this->dbObj->Param('article_id').
						' AND user_id='.$this->dbObj->Param('user_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['article_id'], $this->CFG['user']['user_id']));
			    if (!$rs)
				    trigger_db_error($this->dbObj);

				$row = $rs->FetchRow();
				$getFavoriteLink_arr['row'] = $row;
				return $getFavoriteLink_arr;
			}

		/**
		 * ViewArticle::populateRelatedArticle()
		 *
		 * @param string $pg
		 * @return void
		 */
		public function populateRelatedArticle($pg = 'tag')
			{
				global $smartyObj;
				$populateRelatedArticle_arr = array();
				$default_fields = 'article_caption, article_summary, article_server_url, article_id, article_title, TIMEDIFF(NOW(), date_added) as date_added, user_id, (rating_total/rating_count) as rating, total_views, article_tags, article_status, TIMEDIFF(NOW(), last_view_date) as article_last_view_date, user_id';

				$add_fields = '';
				$order_by = 'v.article_id DESC';
				switch($pg)
					{
						case 'top':
							$sql_condition = 'v.article_id!=\''.addslashes($this->fields_arr['article_id']).'\''.
										' AND v.rating_total>0 AND v.article_status=\'Ok\''.$this->getAdultQuery('v.', 'article').
										' AND (v.user_id = '.$this->CFG['user']['user_id'].' OR'.
										' v.article_access_type = \'Public\''.$this->getAdditionalQuery('v.').')';

							$more_link = getUrl('articlelist', '?pg=articletoprated', 'articletoprated/', '', 'article');
							break;

						case 'user':
							$sql_condition = 'v.article_id!=\''.addslashes($this->fields_arr['article_id']).'\''.
										' AND v.user_id=\''.$this->fields_arr['user_id'].'\' AND v.article_status=\'Ok\''.$this->getAdultQuery('v.', 'article').
										' AND (v.user_id = '.$this->CFG['user']['user_id'].' OR'.
										' v.article_access_type = \'Public\''.$this->getAdditionalQuery('v.').')';
							$more_link = getUrl('articlelist', '?pg=userarticlelist&amp;user_id='.$this->fields_arr['user_id'], 'userarticlelist/?user_id='.$this->fields_arr['user_id'], '', 'article');
							break;

						case 'tag':
							$article_tags = $this->fields_arr['article_tags'];
							$sql_condition = 'v.article_id!=\''.addslashes($this->fields_arr['article_id']).'\' AND'.
									' v.article_status=\'Ok\''.$this->getAdultQuery('v.', 'article').' AND'.
									' '.getSearchRegularExpressionQueryModified($article_tags, 'article_tags', '').
									' AND (v.user_id = '.$this->CFG['user']['user_id'].' OR'.
									' v.article_access_type = \'Public\''.$this->getAdditionalQuery('v.').')';

							$add_fields = '';

							$order_by = 'v.article_id DESC';
							//$more_link = getUrl('articlelist', '?pg=articlenew&amp;tags='.$article_tags, 'articlenew/?tags='.$article_tags, '', 'article');
							break;
					}

				$sql = 'SELECT '.$default_fields.$add_fields.' FROM '.$this->CFG['db']['tbl']['article'].' AS v'.
						' WHERE '.$sql_condition.' ORDER BY '.$order_by.
						' LIMIT '.$this->CFG['admin']['articles']['total_related_article'];



				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				    if (!$rs)
					    trigger_db_error($this->dbObj);

				$total_records = $rs->PO_RecordCount();
				$populateRelatedArticle_arr['total_records'] = $total_records;
				if ($total_records)
				    {
						$fields_list = array('user_name', 'first_name', 'last_name', 'icon_id', 'icon_type', 'sex');
						$articles_folder = $this->CFG['media']['folder'].'/'.$this->CFG['admin']['articles']['folder'].'/';

						$populateRelatedArticle_arr['row'] = array();
						$inc = 0;
						while($row = $rs->FetchRow())
							{
								if(!isset($this->UserDetails[$row['user_id']]))
									$this->UserDetails = getUserDetail('user_id', $row['user_id'], 'user_name');

								$populateRelatedArticle_arr['row'][$inc]['name'] = getUserDetail('user_id', $row['user_id'], 'user_name');

								$populateRelatedArticle_arr['row'][$inc]['article_title_url'] = getUrl('viewarticle', '?article_id='.$row['article_id'].'&amp;title='.$this->changeTitle($row['article_title']).'&amp;vpkey='.$this->fields_arr['vpkey'], $row['article_id'].'/'.$this->changeTitle($row['article_title']).'/?vpkey='.$this->fields_arr['vpkey'], '', 'article');
								$populateRelatedArticle_arr['row'][$inc]['article_title'] = $row['article_title'];
								$populateRelatedArticle_arr['row'][$inc]['article_summary'] = strip_tags($row['article_summary']);
						        $populateRelatedArticle_arr['row'][$inc]['row_total_views'] = $row['total_views'];
						        $populateRelatedArticle_arr['row'][$inc]['memberProfileUrl'] = getMemberProfileUrl($row['user_id'], $this->UserDetails);
								$inc++;
							}
						if($total_records==$this->CFG['admin']['articles']['total_related_article'] && $pg != 'tag')
							{
								$populateRelatedArticle_arr['more_link'] = $more_link;
							}
						//Assign the pg vale to restrict more link for ralted articles since article_tag may conatains multiple tags separated by spaces
						$populateRelatedArticle_arr['pg'] = $pg;
					}

				$smartyObj->assign('populateRelatedArticle_arr', $populateRelatedArticle_arr);
				setTemplateFolder('general/', 'article');
				$smartyObj->display('populateRelatedArticle.tpl');
			}

		/**
		 * ViewArticle::displayArticle()
		 *
		 * @return void
		 **/
		public function displayArticle()
			{
				global $smartyObj;
				$displayArticle_arr = array();
				$displayArticle_arr['page_break'] = false;
				$displayArticle_arr['read_more'] = false;
				$this->rankUsersRayzz = false;
				$this->rating='';

				if(rankUsersRayzz($this->CFG['admin']['articles']['allow_self_ratings'], $this->fields_arr['user_id']))
				{
					$this->rankUsersRayzz=true;
					$this->rating = $this->getRating($this->CFG['user']['user_id']);
				}
				$this->ratingDetatils = ($rating=$this->populateRatingDetails())?$rating:0;

				if(!$this->fields_arr['start_break'])
					$this->fields_arr['start_break'] = 1;
				$pgno = $this->fields_arr['start_break'];

				$articles_folder = $this->CFG['media']['folder'].'/'.$this->CFG['admin']['articles']['folder'].'/';

				$regex = '#<hr([^>]*?)class=(\"|\'|&quot;)system-pagebreak(\"|\'|&quot;)([^>]*?)\/*>#iU';

				$page_title_regex = '/title=("|\')[a-zA-Z0-9\s]{1,300}["|\']/';
				preg_match_all($regex,$this->fields_arr['article_caption'],$matches);
				$title_array = $matches[0];

				for($title_count=0;$title_count<count($title_array);$title_count++)
					{
						preg_match_all($page_title_regex,$title_array[$title_count],$title);
						$title = isset($title[0])?$title[0]:'';
						$page  = isset($title[0])?$title[0]:'';
						$page_name_arr = explode('title="',$page);
						$page_name = isset($page_name_arr[1])?substr($page_name_arr[1], 0, -1):'';
						$page_title[$title_count] = $page_name;
					}

				// Added code to search  alt tag in article caption  to display table of contents title in article index
				$page_toc_regex = '/alt=("|\')[a-zA-Z0-9\s]{1,300}["|\']/';
				preg_match_all($regex,$this->fields_arr['article_caption'],$toc_matches);
				$toc_array = $toc_matches[0];

				//Added code to fetch table of contents title assigned for each pagebreak in alt tag
				for($toc_count=0;$toc_count<count($toc_array);$toc_count++)
					{
						preg_match_all($page_toc_regex,$toc_array[$toc_count],$toc);
						$toc = isset($toc[0])?$toc[0]:'';
						$page_toc  = isset($toc[0])?$toc[0]:'';
						$page_toc_name_arr = explode('alt="',$page_toc);
						$page_toc_name = isset($page_toc_name_arr[1])?substr($page_toc_name_arr[1], 0, -1):'';
						$page_toc_title[$toc_count] = $page_toc_name;
					}

				$pattern = '#<hr\s+id=("|\')system-readmore("|\')\s*\/*>#i';
				$pageBrake = preg_replace($regex, '<!--PAGEBREAK-->', $this->fields_arr['article_caption']);

				if (preg_match($pattern, $this->fields_arr['article_caption']))
					{
						$displayArticle_arr['read_more'] = true;
						$readMore = str_replace("<hr id=\"system-readmore\" />", '<!--READMORE-->', $this->fields_arr['article_caption']);
						$readMoreArray = explode('<!--READMORE-->',$readMore);
						$page = count($readMoreArray);
						$pgno = $this->fields_arr['start_break'];
						$displayArticle_arr['viewmore_link'] = getUrl('viewarticle', '?article_id='.$this->fields_arr['article_id'].'&amp;title='.$this->changeTitle($this->fields_arr['article_title']).'&start_break=1&view=all', $this->fields_arr['article_id'].'/'.$this->changeTitle($this->fields_arr['article_title']).'/?start_break=1&view=all', '', 'article');
						if($this->fields_arr['view']=='all')
							{
								$displayArticle_arr['read_more'] = false;
								$displayArticle_arr['article_caption'] = $readMore;
								//$displayArticle_arr['article_caption'] = $readMore;
							}
						else{
								$displayArticle_arr['article_caption'] = $readMoreArray[$pgno-1];
								//$displayArticle_arr['article_caption'] = $readMoreArray[$pgno-1];
							}
					}
				if (strpos($this->fields_arr['article_caption'] , 'class="system-pagebreak') === false && strpos($this->fields_arr['article_caption'], 'class=\'system-pagebreak') === false)
					{
						if (!preg_match($pattern, $this->fields_arr['article_caption']))
						{
							$displayArticle_arr['article_caption'] = $this->fields_arr['article_caption'];
							//$displayArticle_arr['article_caption'] = $this->fields_arr['article_caption'];
						}
					}
				else
					{
						$displayArticle_arr['page_break'] = true;

						if($this->fields_arr['showall'] == 1)
							{
								$pageArray = array(0=>$pageBrake);
							}
						else
							{
								$pageArray = explode('<!--PAGEBREAK-->',$pageBrake);
							}

						$page = count($pageArray);

						for($k=0;$k<count($page_title);$k++)
							{
								$page_all = $k+2;
								// if page title is empty, show in the TOC as Page No
								if($page_title[$k] == '')
								{
									//$page_title[$k] = $this->LANG['viewarticle_page'].$page_all;
									$page_title[$k] = 0;
								}
								$page_break_titles[$page_all] = $page_title[$k];

							}
						$displayArticle_arr['pagebreak_title_arr'] = $page_break_titles;


						//Added code to diaplay page title in Article index if table of content title for the corresponding page not exist
						for($t=0;$t<count($page_toc_title);$t++)
							{
								$page_toc_all = $t+2;
								// if page title is empty, show in the TOC as Page No
								if($page_toc_title[$t] == '')
								{
									if($page_title[$t] == '')
										$page_toc_title[$t] = $this->LANG['viewarticle_page'].$page_toc_all;
									else
										$page_toc_title[$t] = $page_title[$t];
								}
								$page_break_toc_titles[$page_toc_all] = $page_toc_title[$t];
								$page_break_toc_title_manuals[$page_toc_all] = $page_toc_title[$t];
							}

						$displayArticle_arr['pagebreak_toc_title_arr'] = $page_break_toc_titles;
						$displayArticle_arr['pagebreak_toc_title_manual_arr'] = $page_break_toc_title_manuals;

						$displayArticle_arr['article_caption'] = $pageArray[$pgno-1];
						//$displayArticle_arr['article_caption'] = ($pageArray[$pgno-1]);

						$prev = $this->fields_arr['start_break'] - 1;
						if($prev == 0)
							{
								$prev = 1;
							}
						$next = $this->fields_arr['start_break'] + 1;
						if($next>$page)
							{
								$next = $page;
							}

						$displayArticle_arr['disable_prev_link'] = false;
						$displayArticle_arr['disable_next_link'] = false;

						if($pgno != $prev)
							$displayArticle_arr['disable_prev_link'] = true;

						if($pgno != $next)
							$displayArticle_arr['disable_next_link'] = true;

						$displayArticle_arr['page_break_home'] = getUrl('viewarticle', '?article_id='.$this->fields_arr['article_id'].'&amp;title='.$this->changeTitle($this->fields_arr['article_title']).'&amp;start_break=1', $this->fields_arr['article_id'].'/'.$this->changeTitle($this->fields_arr['article_title']).'/?start_break=1', '', 'article');
						$displayArticle_arr['page_break_show_all'] = getUrl('viewarticle', '?article_id='.$this->fields_arr['article_id'].'&amp;title='.$this->changeTitle($this->fields_arr['article_title']).'&amp;showall=1', $this->fields_arr['article_id'].'/'.$this->changeTitle($this->fields_arr['article_title']).'/?showall=1', '', 'article');

						//Added code to display page title if page break exist
						if(isset($page_break_titles[$prev]))
							$pagePrevTitle = '&page_title='.$page_break_titles[$prev];
						else
							$pagePrevTitle = '&page_title=0';

						if(isset($page_break_titles[$next]))
							$pageNextTitle = '&page_title='.$page_break_titles[$next];
						else
							$pageNextTitle = '&page_title=0';

						$displayArticle_arr['previous_link'] = getUrl('viewarticle', '?article_id='.$this->fields_arr['article_id'].'&amp;title='.$this->changeTitle($this->fields_arr['article_title']).'&amp;start_break='.$prev.$pagePrevTitle, $this->fields_arr['article_id'].'/'.$this->changeTitle($this->fields_arr['article_title']).'/?start_break='.$prev.$pagePrevTitle, '', 'article');

						$displayArticle_arr['next_link'] = getUrl('viewarticle', '?article_id='.$this->fields_arr['article_id'].'&amp;title='.$this->changeTitle($this->fields_arr['article_title']).'&amp;start_break='.$next.$pageNextTitle, $this->fields_arr['article_id'].'/'.$this->changeTitle($this->fields_arr['article_title']).'/?start_break='.$next.$pageNextTitle, '', 'article');

						$displayArticle_arr['pagebreak_title_link'] = getUrl('viewarticle', '?article_id='.$this->fields_arr['article_id'].'&amp;title='.$this->changeTitle($this->fields_arr['article_title']).'&amp;start_break=', $this->fields_arr['article_id'].'/'.$this->changeTitle($this->fields_arr['article_title']).'/?start_break=', '', 'article');
					}

				$displayArticle_arr['article_attachment'] = $this->fields_arr['article_attachment'];
				$displayArticle_arr['total_downloads'] = $this->fields_arr['total_downloads'];
				if($this->fields_arr['article_attachment'])
					{
						$this->getAttachmentDetails();
					}

				$displayArticle_arr['more_article_user_url'] = getUrl('viewarticle', '?ajax_page=true&more_articles=user&article_id='.$this->fields_arr['article_id'], $this->fields_arr['article_id'].'/?ajax_page=true&more_articles=user', '', 'article');

				$displayArticle_arr['more_article_tag_url'] = getUrl('viewarticle', '?ajax_page=true&more_articles=tag&article_id='.$this->fields_arr['article_id'], $this->fields_arr['article_id'].'/?ajax_page=true&more_articles=tag', '', 'article');

				$displayArticle_arr['more_article_top_url'] = getUrl('viewarticle', '?ajax_page=true&more_articles=top&article_id='.$this->fields_arr['article_id'], $this->fields_arr['article_id'].'/?ajax_page=true&more_articles=top', '', 'article');

				if(!isMember())
					$this->relatedUrl = $this->CFG['site']['article_url'].'viewArticle.php';
				else
					$this->relatedUrl = $this->CFG['site']['article_url'].'viewArticle.php';

				$this->memberviewArticleUrl = getUrl('viewarticle',
													 '?article_id='.$this->getFormfield('article_id').'&title='.$this->changeTitle($this->getFormfield('article_title')),
													 $this->getFormfield('article_id').'/'.$this->changeTitle($this->getFormfield('article_title')).
													'/','members', 'article');

  				$displayArticle_arr['getTagsOfThisArticle_arr'] = $this->getTagsOfThisArticle();

				if($this->fields_arr['allow_ratings'] == 'Yes')
					{
						if(!isMember())
							{
								$displayArticle_arr['view_article_url'] = getUrl('viewarticle', '?mem_auth=true&article_id='.$this->fields_arr['article_id'].'&amp;title='.$this->changeTitle($this->fields_arr['article_title']), $this->fields_arr['article_id'].'/'.$this->changeTitle($this->fields_arr['article_title']).'/?mem_auth=true', 'members', 'article');
							}
						else
							{
								$displayArticle_arr['rankUsersRayzz'] = rankUsersRayzz($this->CFG['admin']['articles']['allow_self_ratings'], $this->fields_arr['user_id']);
								if($displayArticle_arr['rankUsersRayzz'])
									{
										$displayArticle_arr['rating'] = $this->getRating($this->CFG['user']['user_id']);
									}
							}
					}

				$displayArticle_arr['user_name']=$user_name = getUserDetail('user_id', $this->getFormField('user_id'), 'user_name');
				$displayArticle_arr['total_article'] = $this->getTotalArticlesFromUser($this->getFormField('user_id'));
				$displayArticle_arr['member_icon_url']= getMemberAvatarDetails($this->getFormField('user_id'));
				$displayArticle_arr['member_profile_url'] = getMemberProfileUrl($this->getFormField('user_id'), $user_name);
				$displayArticle_arr['getChannelOfThisArticle_arr'] = $this->getChannelOfThisArticle();

				if(!isMember())
					{
						$displayArticle_arr['flag_article_url'] = getUrl('viewarticle', '?mem_auth=true&article_id='.$this->fields_arr['article_id'].'&amp;title='.$this->changeTitle($this->fields_arr['article_title']), $this->fields_arr['article_id'].'/'.$this->changeTitle($this->fields_arr['article_title']).'/?mem_auth=true', '', 'article');
					}

				$displayArticle_arr['getFavoriteLink_arr'] = $this->getFavoriteLink();

				if(chkAllowedModule(array('groups', 'groups_article')) and 0)
					{
						if(!isMember())
							{
								$displayArticle_arr['addtogroups_url'] = getUrl('viewarticle', '?article_id='.$this->fields_arr['article_id'].'&amp;title='.$this->changeTitle($this->fields_arr['article_title']), $this->fields_arr['article_id'].'/'.$this->changeTitle($this->fields_arr['article_title']).'/', 'members', 'article');
							}
					}

				$this->favorite = $this->getFavorite();
	      		$displayArticle_arr['share_article_urlo'] = getUrl('sharearticle', '?article_id='.$this->fields_arr['article_id'], $this->fields_arr['article_id'].'/', '', 'article');
	      		$displayArticle_arr['share_article_url'] = getUrl('sharearticle', '?article_id='.$this->fields_arr['article_id'].'&amp;ajax_page=true&amp;page=sharearticle', $this->fields_arr['article_id'].'/?ajax_page=true&amp;page=sharearticle', '', 'article');
				$displayArticle_arr['blog_post_url'] = getUrl('viewarticle', '?article_id='.$this->fields_arr['article_id'].'&amp;title='.$this->changeTitle($this->fields_arr['article_title']), $this->fields_arr['article_id'].'/'.$this->changeTitle($this->fields_arr['article_title']).'/', 'root', 'article');

				$key = array_flip($this->enabled_edit_fields);
				$key = '\''.implode('\',\'', $key).'\'';

			 	$displayArticle_arr['key'] = $key;

				$displayArticle_arr['article_writing_url_ok'] = '';
				$this->memberviewArticleUrl = getUrl('viewarticle','?mem_auth=true&article_id='.$this->getFormfield('article_id').'&title='.
																		$this->changeTitle($this->getFormfield('article_title')),
																			$this->getFormfield('article_id').'/'.
																				$this->changeTitle($this->getFormfield('article_title')).
																					'/?mem_auth=true','members', 'article');
				if($this->fields_arr['user_id'] == $this->CFG['user']['user_id'])
					{
						$displayArticle_arr['article_writing_url_ok'] = getUrl('articlewriting', '?article_id='.$this->fields_arr['article_id'], $this->fields_arr['article_id'].'/', '', 'article');
					}

				$smartyObj->assign('displayArticle_arr', $displayArticle_arr);

			}



		public function getTotalArticlesFromUser($user_id)
			{

				$sql = 'SELECT COUNT(article_id) as tot FROM '.$this->CFG['db']['tbl']['article'].
						' WHERE user_id ='.$this->dbObj->Param('user_id');
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['user_id']));
				    if (!$rs)
					    trigger_db_error($this->dbObj);

				$row = $rs->FetchRow();
				return $row['tot'];

			}

		/**
		 * ViewArticle::chkAuthorizedUser()
		 *
		 * @return boolean
		 **/
		public function chkAuthorizedUser()
			{
				if(!$this->fields_arr['comment_id'])
					return false;

				$sql = 'SELECT count(1) as count FROM '.$this->CFG['db']['tbl']['article_comments'].
						' WHERE article_comment_id='.$this->dbObj->Param('article_comment_id').
						' AND comment_user_id='.$this->dbObj->Param('comment_user_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['comment_id'], $this->CFG['user']['user_id']));
				    if (!$rs)
					    trigger_db_error($this->dbObj);

				$row = $rs->FetchRow();
				if($row['count'])
					return true;
				return false;
			}

		/**
		 * ViewArticle::changeLastViewDateAndArticleViewed()
		 *
		 * @return void
		 **/
		public function changeLastViewDateAndArticleViewed()
			{
				//Added condition to increment total views if artilce status is set as OK
				if($this->fields_arr['article_status'] == 'Ok')
				{
					$sql = 	' SELECT article_viewed_id FROM '.$this->CFG['db']['tbl']['article_viewed'].
							' WHERE article_id='.$this->dbObj->Param('article_id').' AND user_id='.$this->dbObj->Param('user_id').' AND'.
							' DATE_FORMAT(view_date, \'%Y-%m-%d\') = CURDATE()';
					$stmt = $this->dbObj->Prepare($sql);
					$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['article_id'], $this->CFG['user']['user_id']));

				    if (!$rs)
					    trigger_db_error($this->dbObj);
					if($rs->PO_RecordCount())
						{
							//$total_views_update .= ', total_views = total_views + 1 ';
							$row = $rs->FetchRow();//$rs->Free();
							$article_viewed_id = $row['article_viewed_id'];
							$sql =  ' UPDATE '.$this->CFG['db']['tbl']['article_viewed'].' SET'.
		 							' view_date=NOW() ,'.
		 							' total_views=total_views+1'.
									' WHERE article_viewed_id='.$this->dbObj->Param('article_viewed_id');

		 					$stmt = $this->dbObj->Prepare($sql);
		 					$rs = $this->dbObj->Execute($stmt, array($article_viewed_id));
	 					    if (!$rs)
	 						    trigger_db_error($this->dbObj);
						}
					else
						{
							$sql =  ' INSERT INTO '.$this->CFG['db']['tbl']['article_viewed'].' '.
		 							' (user_id, article_id, total_views, view_date)'.
		 							' VALUES('.$this->dbObj->Param('user_id').','.
									$this->dbObj->Param('article_id').', 1, '.
		 							' NOW())';

		 					$stmt = $this->dbObj->Prepare($sql);
		 					$rs = $this->dbObj->Execute($stmt, array($this->CFG['user']['user_id'], $this->fields_arr['article_id']));
	 					    if (!$rs)
	 						    trigger_db_error($this->dbObj);

						}

					$sql = 'UPDATE '.$this->CFG['db']['tbl']['article'].' SET'.
							' total_views=total_views+1, last_view_date=NOW()'.
							' WHERE article_id='.$this->dbObj->Param('article_id');

					$stmt = $this->dbObj->Prepare($sql);
					$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['article_id']));
					    if (!$rs)
						    trigger_db_error($this->dbObj);
				}

			}

		/**
		 * ViewArticle::getPreviousLink()
		 *
		 * @return void
		 **/
		public function getPreviousLink()
			{
				$sub = 'p.user_id=\''.$this->fields_arr['user_id'].'\'';

				$condition = 'p.article_status=\'Ok\' AND p.article_id<\''.addslashes($this->fields_arr['article_id']).'\''.
							' AND '.$sub.' AND'.
							' (p.user_id = '.$this->CFG['user']['user_id'].' OR p.article_access_type = \'Public\''.
							$this->getAdditionalQuery('p.').')';

				$sql = 'SELECT MAX(p.article_id) as article_id FROM '.$this->CFG['db']['tbl']['article'].' as p WHERE'.
						' '.$condition.' LIMIT 0,1';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				    if (!$rs)
					    trigger_db_error($this->dbObj);

				if($row = $rs->FetchRow() and $row['article_id'])
					{
						$row['article_title'] = $this->getArticleTitle($row['article_id']);
						$link = getUrl('viewarticle', '?article_id='.$row['article_id'].'&amp;title='.$this->changeTitle($row['article_title']).'&amp;vpkey='.$this->fields_arr['vpkey'], $row['article_id'].'/'.$this->changeTitle($row['article_title']).'/?vpkey='.$this->fields_arr['vpkey'], '', 'article');
?>
<li class="clsPrevLinkPage"><a href="<?php echo $link;?>"><?php echo $this->LANG['viewarticle_previous'];?></a></li>
<!--<span id="previous"><a href="#" onClick="return callAjaxPaging('<?php echo $this->CFG['site']['relative_url'].'viewArticle.php?ajax_page=true&amp;paging=true&amp;article_id='.$row['article_id'];?>&amp;vpkey=<?php echo $this->fields_arr['vpkey'];?>', 'selLeftNavigation')"><?php echo $this->LANG['viewarticle_previous'];?></a></span>-->

<?php
					}
				else
					{
?>
<li class="clsInactivePrevLinkPage"><?php echo $this->LANG['viewarticle_previous'];?></li>
<?php
					}
			}

		/**
		 * ViewArticle::getNextLink()
		 *
		 * @return void
		 */
		public function getNextLink()
			{
				$sub = 'p.user_id=\''.$this->fields_arr['user_id'].'\'';

				$condition = 'p.article_status=\'Ok\' AND p.article_id>\''.addslashes($this->fields_arr['article_id']).'\''.
							' AND '.$sub.' AND'.
							' (p.user_id = '.$this->CFG['user']['user_id'].' OR p.article_access_type = \'Public\''.
							$this->getAdditionalQuery('p.').')';

				$sql = 'SELECT MIN(p.article_id) as article_id FROM '.$this->CFG['db']['tbl']['article'].' as p'.
						' WHERE '.$condition.' LIMIT 0,1';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				    if (!$rs)
					    trigger_db_error($this->dbObj);

				if($row = $rs->FetchRow() and $row['article_id'])
					{
						$row['article_title'] = $this->getArticleTitle($row['article_id']);
						$link = getUrl('viewarticle', '?article_id='.$row['article_id'].'&amp;title='.$this->changeTitle($row['article_title']).'&amp;vpkey='.$this->fields_arr['vpkey'], $row['article_id'].'/'.$this->changeTitle($row['article_title']).'/?vpkey='.$this->fields_arr['vpkey'], '', 'article');
?>
<li class="clsNextPageLink"><a href="<?php echo $link;?>"><?php echo $this->LANG['viewarticle_next'];?></a></li>
<!--<span id="next"><a href="#" onClick="return callAjaxPaging('<?php echo $this->CFG['site']['relative_url'].'viewArticle.php?ajax_page=true&amp;paging=true&amp;article_id='.$row['article_id'];?>&amp;vpkey=<?php echo $this->fields_arr['vpkey'];?>', 'selLeftNavigation')"><?php echo $this->LANG['viewarticle_next'];?></a></span>-->
<?php
					}
				else
					{
?>
<li class="clsInactiveNextPageLink"><?php echo $this->LANG['viewarticle_next'];?></li>
<?php
					}
			}

		/**
		 * ViewArticle::replaceAdultText()
		 *
		 * @param string $text
		 * @return string
		 */
		public function replaceAdultText($text)
			{
				$text = str_replace('{age_limit}', $this->CFG['admin']['articles']['adult_minimum_age'], $text);
				$text = str_replace('{site_name}', $this->CFG['site']['name'], $text);
				return nl2br($text);
			}

		/**
		 * ViewArticle::getAttachment()
		 *
		 * @return void
		 */
		public function getAttachment()
			{
				$sql = 'SELECT file_name, file_ext, file_type, server_url, '.
						' DATE_FORMAT(date_added,\''.$this->CFG['format']['date'].'\') as date_added'.
						' FROM '.$this->CFG['db']['tbl']['article_attachments'].''.
						' WHERE article_id='.$this->dbObj->Param('attahcment_article_id').' AND attachment_id='.$this->dbObj->Param('attahcment_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['article_id'], $this->fields_arr['attachment_id']));
				    if (!$rs)
					    trigger_db_error($this->dbObj);

				if($row = $rs->FetchRow())
					{
						$this->downloadAttachment($row['file_name'], $row['file_type'], $row['server_url']);
					}
			}

		/**
		 * ViewArticle::updateDownloadCount()
		 *
		 * @return void
		 */
		public function updateDownloadCount()
			{
				$this->fields_arr['total_downloads'] = $this->fields_arr['total_downloads'] + 1;
				$sql = 'UPDATE '.$this->CFG['db']['tbl']['article'].' SET '.
						'total_downloads='.$this->fields_arr['total_downloads'].' '.
						'WHERE article_id='.$this->dbObj->Param('article_id');

				$stmt = $this->dbObj->Prepare($sql);

				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['article_id']));
			    if (!$rs)
				    trigger_db_error($this->dbObj);

			}

		/**
		 * ViewArticle::downloadAttachment()
		 *
		 * @param string $file_name
		 * @param string $file_type
		 * @return void
		 */
		public function downloadAttachment($file_name, $file_type, $server_url)
			{
				$file_name = $this->file_root_path.$this->CFG['media']['folder'].'/'.$this->CFG['admin']['articles']['folder'].'/'.$this->fields_arr['article_id'].'/'.$file_name;
				$this->updateDownloadCount();

				ob_start();
				header("Pragma: public");
				header("Expires: 0");
				header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
				header("Cache-Control: private",false);
				header("Content-Description: File Transfer");
				header("Content-Type: ".$file_type);
				header("Content-Disposition: attachment; filename=\"".basename($file_name)."\";");
				header("Content-Transfer-Encoding: binary");
				ob_clean();
    			flush();
				readfile($file_name);
				exit;
			}

		/**
		 * ViewArticle::getEditCommentBlock()
		 *
		 * @return
		 */
		public function getEditCommentBlock()
			{
				global $smartyObj;
				$replyBlock['comment_id']=$this->fields_arr['comment_id'];
				$replyBlock['name']='addEdit_';
				$replyBlock['sumbitFunction']='addToEdit';
				$replyBlock['cancelFunction']='discardEdit';
				$replyBlock['editReplyUrl']=$this->CFG['site']['article_url'].'viewArticle.php?ajax_page=true&amp;article_id='.$this->fields_arr['article_id'].'&vpkey='.$this->fields_arr['vpkey'].'&show='.$this->fields_arr['show'];
				$smartyObj->assign('commentEditReply', $replyBlock);
				setTemplateFolder('general/','article');
				$smartyObj->display('commentEditReplyBlock.tpl');
			}

		/**
		 * ViewArticle::chkIsCaptchaNotEmpty()
		 *
		 * @param mixed $field_name
		 * @param string $err_tip
		 * @return
		 */
		public function chkIsCaptchaNotEmpty($field_name, $err_tip='')
			{
				$is_ok = (is_string($this->fields_arr[$field_name])) ?
								($this->fields_arr[$field_name]!='') : (!empty($this->fields_arr[$field_name]));
				if (!$is_ok)
					{
						echo 'ERR~'.$err_tip;
						exit;
					}
				return $is_ok;
			}
		/**
		 * viewArticle::chkCaptcha()
		 *
		 * @param string $field_name
		 * @param string $err_tip
		 * @return boolean
		 */
		public function chkCaptcha($field_name, $err_tip='')
			{
				if ($this->fields_arr["recaptcha_response_field"])
					{
		        		$resp = recaptcha_check_answer ($this->CFG['captcha']['private_key'],
					 					$_SERVER["REMOTE_ADDR"],
					 					$this->fields_arr["recaptcha_challenge_field"],
										$this->fields_arr["recaptcha_response_field"]);

			        	if ($resp->is_valid)
						 	{
	                			return true;
			                }
						else
							{
							    echo 'ERR~'.$err_tip;
								exit;
							}
					}

			}

		/**
		 * viewArticle::chkisArticleOwner()
		 *
		 * @return
		 */
		public function chkisArticleOwner()
		{
			$sql = 'SELECT article_id FROM '.$this->CFG['db']['tbl']['article'].' AS a'.
					' WHERE a.article_id = '.$this->dbObj->Param('article_id').' AND a.user_id = '.$this->dbObj->Param('article_id');

			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['article_id'], $this->CFG['user']['user_id']));
			if (!$rs)
				trigger_db_error($this->dbObj);

			$row = $rs->FetchRow();

			if($row['article_id'] != '')
				return true;
			return false;
		}

		/**
	 * viewPArticle::checkSameUserInComment()
	 *
	 * @return
	 */
	public function checkSameUserInComment($err_msg, $chk_article_owner = false)
	{

		if($chk_article_owner)
		{
			$article_owner_status = $this->chkisArticleOwner();
			if($article_owner_status)
			{
				return $article_owner_status;
			}
		}

		$sql = 'SELECT article_comment_id FROM '.$this->CFG['db']['tbl']['article_comments'].' AS a'.
				' WHERE a.article_id = '.$this->dbObj->Param('article_id').
				' AND a.comment_user_id = '.$this->dbObj->Param('comment_user_id').
				' AND a.article_comment_id = '.$this->dbObj->Param('article_comment_id');

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['article_id'], $this->CFG['user']['user_id'], $this->fields_arr['comment_id']));
		if (!$rs)
			trigger_db_error($this->dbObj);

		$row = $rs->FetchRow();

		if($row['article_comment_id'] != '')
		{
			return true;
		}
		else
		{
			echo $err_msg;
			echo 'ERR~';
			exit;
		}
	}
	}
//<<<<<-------------- Class ViewArticle begins ---------------//
//-------------------- Code begins -------------->>>>>//
$ViewArticle = new ViewArticle();
$ViewArticle->setDBObject($db);

$CFG['admin']['articles']['captcha_method'] = "honeypot"; // For test ing purpose added
$ViewArticle->makeGlobalize($CFG,$LANG);
if(!chkAllowedModule(array('article')))
	Redirect2URL($CFG['redirect']['dsabled_module_url']);

$ViewArticle->setPageBlockNames(array('msg_form_error', 'msg_form_success','articles_form', 'delete_confirm_form', 'get_code_form',
									'confirmation_flagged_form', 'add_comments', 'add_reply', 'edit_comment',
									'update_comment', 'rating_image_form', 'add_flag_list', 'add_fovorite_list',
									'confirmation_adult_form', 'articleMainBlock', 'populate_related_article',
									'block_add_comments','block_image_display'));

//default form fields and values...
$ViewArticle->setFormField('article_id', '');
$ViewArticle->setFormField('vpkey', '');
$ViewArticle->setFormField('action', '');
$ViewArticle->setFormField('comment_id', '');
$ViewArticle->setFormField('action', '');
$ViewArticle->setFormField('article_code', '');
$ViewArticle->setFormField('article_title', '');
$ViewArticle->setFormField('user_name', '');
$ViewArticle->setFormField('user_id', '');
$ViewArticle->setFormField('album_id', '');
$ViewArticle->setFormField('showall', '');
$ViewArticle->setFormField('type', '');
$ViewArticle->setFormField('flagged_content', '');
//for ajax
$ViewArticle->setFormField('f',0);
$ViewArticle->setFormField('show','1');
$ViewArticle->setFormField('comment_id',0);
$ViewArticle->setFormField('maincomment_id',0);
$ViewArticle->setFormField('allow_response', '');
$ViewArticle->setFormField('type','');
$ViewArticle->setFormField('ajax_page','');
$ViewArticle->setFormField('paging','');
$ViewArticle->setFormField('rate', '');
$ViewArticle->setFormField('flag', '');
$ViewArticle->setFormField('flag_comment', '');
$ViewArticle->setFormField('page', '');
$ViewArticle->setFormField('favorite', '');
$ViewArticle->setFormField('favorite_id', '');
$ViewArticle->setFormField('attachment_id', '');
$ViewArticle->setFormField('article_tags', '');
$ViewArticle->setFormField('start_break','');
$ViewArticle->setFormField('view','');
$ViewArticle->setFormField('more_articles', '');
$ViewArticle->setFormField('msg', '');
$ViewArticle->setFormField('order', '');
$ViewArticle->setFormField('flagged_content', '');

$ViewArticle->setFormField('recaptcha_challenge_field', '');
$ViewArticle->setFormField('recaptcha_response_field', '');
$ViewArticle->setFormField('show_complete_quick_list', '');

// ********** Page Navigation Start ********
$ViewArticle->setFormField('start', '0');
$ViewArticle->setFormField('numpg', 3);

$ViewArticle->flag_type_arr = $LANG_LIST_ARR['flag']['article'];

$ViewArticle->setMinRecordSelectLimit($CFG['data_tbl']['min_record_select_limit']);
$ViewArticle->setMaxRecordSelectLimit($CFG['data_tbl']['max_record_select_limit']);
$ViewArticle->setNumPerPageListArr($CFG['data_tbl']['numperpage_list_arr']);

$ViewArticle->setTableNames(array());
$ViewArticle->setReturnColumns(array());

$ViewArticle->sanitizeFormInputs($_REQUEST);
$ViewArticle->validate = $ViewArticle->chkValidArticleId();

//Condition to redirect to article list page if given article id is not valid
if(!$ViewArticle->chkValidArticleId())
{
	Redirect2URL(getUrl('articlelist', '?pg=invalid_article_id', 'invalid_article_id/', '', 'article'));
}

$ViewArticle->memberLoginArticleUrl = getUrl('viewarticle','?mem_auth=true&article_id='.$ViewArticle->getFormfield('article_id').'&title='.
																		$ViewArticle->changeTitle($ViewArticle->getFormfield('article_title')),
																			$ViewArticle->getFormfield('article_id').'/'.
																				$ViewArticle->changeTitle($ViewArticle->getFormfield('article_title')).
																					'/?mem_auth=true','members', 'article');
// http://192.168.1.79/ravi/rayzz/branches/rayzz_3/article/viewarticle/5/asdsad.html

if(isAjaxpage())
	{
		$ViewArticle->includeAjaxHeaderSessionCheck();
		$ViewArticle->validate = $ViewArticle->chkValidArticleId();

		if($ViewArticle->isFormGETed($_GET, 'more_articles'))
			{
				$ViewArticle->setAllPageBlocksHide();
				$ViewArticle->validate = $ViewArticle->chkValidArticleId();
				$ViewArticle->setPageBlockShow('populate_related_article');
			}

		if($ViewArticle->isFormGETed($_GET, 'favorite'))
			{
				$ViewArticle->setAllPageBlocksHide();
				$ViewArticle->checkLoginStatusInAjax($ViewArticle->memberLoginArticleUrl);
				if($ViewArticle->getFormField('favorite'))
					{
						$ViewArticle->insertFavoriteArticle();
					}
				else
					{
						$ViewArticle->deleteFavoriteArticle($ViewArticle->getFormField('article_id'),$CFG['user']['user_id']);
						echo $ViewArticle->LANG['viewarticle_favorite_deleted_successfully'];
					}
			}

		if($ViewArticle->getFormField('type')=='edit')
			{
				$ViewArticle->setPageBlockShow('edit_comment');
			}
		else if($ViewArticle->isFormGETed($_GET, 'comment_id'))
			{
				$ViewArticle->setPageBlockShow('add_reply');
			}
		else if(!$ViewArticle->getFormField('paging'))
			{
				$ViewArticle->setPageBlockShow('add_comments');
			}

		if ($ViewArticle->isPageGETed($_POST, 'ajaxpaging'))
		    {
				$ViewArticle->populateCommentOfThisArticle();
				ob_end_flush();
				die();
		    }

		if($ViewArticle->isFormGETed($_REQUEST, 'f') and $ViewArticle->getFormField('type')=='edit')
			{
				$ViewArticle->setAllPageBlocksHide();
				$htmlstring = trim(urldecode($ViewArticle->getFormField('f')));
				$htmlstring = strip_tags(html_entity_decode($htmlstring), '<br><br />');
				$ViewArticle->setFormField('f',$htmlstring);
				$ViewArticle->checkLoginStatusInAjax($ViewArticle->memberLoginArticleUrl);
				$ViewArticle->checkSameUserInComment($LANG['common_login_other_user_comment_edit_err_msg']);
				$ViewArticle->updateCommentAndArticleTable();
			}

		else if($ViewArticle->isFormGETed($_REQUEST, 'f'))
			{
				$ViewArticle->checkLoginStatusInAjax($ViewArticle->memberLoginArticleUrl);
				if($CFG['admin']['articles']['captcha']
						AND $CFG['admin']['articles']['captcha_method'] == 'recaptcha'
							AND $CFG['captcha']['public_key'] AND $CFG['captcha']['private_key'])
						{
							$ViewArticle->chkIsCaptchaNotEmpty('recaptcha_response_field', $LANG['common_err_tip_compulsory']) AND
								$ViewArticle->chkCaptcha('recaptcha_response_field', $LANG['common_err_tip_invalid_captcha']);
						}
				$ViewArticle->setAllPageBlocksHide();
				$htmlstring = trim(urldecode($ViewArticle->getFormField('f')));
				$htmlstring = strip_tags(html_entity_decode($htmlstring), '<br><br />');
				$ViewArticle->setFormField('f',$htmlstring);
				$ViewArticle->insertCommentAndArticleTable();
				die();
			}

		else if($ViewArticle->isFormGETed($_GET, 'rate'))
			{
				$ViewArticle->includeAjaxHeaderSessionCheck();
				if($ViewArticle->chkAllowRating())// AND !$ViewArticle->chkAlreadyRated() 2097
					{
						$ViewArticle->setAllPageBlocksHide();
						$ViewArticle->checkLoginStatusInAjax($ViewArticle->memberLoginArticleUrl);
						$ViewArticle->insertRating();
						$ViewArticle->getTotalRatingImage();
						die();
						//$ViewArticle->setPageBlockShow('rating_image_form');
					}
			}
		else if($ViewArticle->isFormGETed($_GET, 'flag') or $ViewArticle->isFormGETed($_GET, 'flag_comment'))
		{
			$ViewArticle->setAllPageBlocksHide();
			if(!$ViewArticle->chkIsNotEmpty('flag_comment', $LANG['viewarticle_flag_comment_invalid']))
			{
				$ViewArticle->getFormFieldErrorTip('flag_comment');
				$ViewArticle->setPageBlockShow('add_flag_list');
				exit;
			}
			$ViewArticle->setFormField('flag_comment',trim(urldecode($ViewArticle->getFormField('flag_comment'))));
			$ViewArticle->checkLoginStatusInAjax($ViewArticle->memberLoginArticleUrl);
			$ViewArticle->insertFlagArticleTable();
		}
		/*else if($ViewArticle->isFormGETed($_GET, 'flag'))
			{
				$ViewArticle->setAllPageBlocksHide();
				$ViewArticle->insertFlagArticleTable();
			}*/
		else if($ViewArticle->getFormField('page')=='flag' and !$ViewArticle->isFormGETed($_GET, 'flag'))
			{
				$ViewArticle->setAllPageBlocksHide();
				$ViewArticle->setPageBlockShow('add_flag_list');
			}
		else if($ViewArticle->getFormField('page')=='favorite' and $ViewArticle->isFormGETed($_GET, 'favorite_id'))
			{
				$ViewArticle->setAllPageBlocksHide();
				$ViewArticle->checkLoginStatusInAjax($ViewArticle->memberLoginArticleUrl);
				$ViewArticle->insertFavoriteArticleTable();
			}
		else if($ViewArticle->getFormField('page')=='removefavorite' and $ViewArticle->isFormGETed($_GET, 'favorite_id'))
			{
				$ViewArticle->setAllPageBlocksHide();
				$ViewArticle->checkLoginStatusInAjax($ViewArticle->memberLoginArticleUrl);
				$ViewArticle->deleteFavoriteArticleTable();
			}
		else if($ViewArticle->getFormField('page')=='favorite')
			{
				$ViewArticle->setAllPageBlocksHide();
				$ViewArticle->setPageBlockShow('add_fovorite_list');
			}
		else if($ViewArticle->getFormField('page')=='getcode')
			{
				$ViewArticle->setAllPageBlocksHide();
				$ViewArticle->setPageBlockShow('get_code_form');
				$ViewArticle->setFormField('image_width', $CFG['admin']['articles']['thumb_width']);
			}
		else if($ViewArticle->getFormField('page')=='deletecomment')
			{
				$ViewArticle->setAllPageBlocksHide();
				$ViewArticle->validate = $ViewArticle->chkValidArticleId();
				$ViewArticle->checkSameUserInComment($LANG['common_login_other_user_comment_delete_err_msg'], true);
				$ViewArticle->checkLoginStatusInAjax($ViewArticle->memberLoginArticleUrl);
				$ViewArticle->deleteComment();
				$ViewArticle->populateCommentOfThisArticle();
			}
		else if($ViewArticle->getFormField('page')=='deletecommentreply')
			{
				$ViewArticle->setAllPageBlocksHide();
				$ViewArticle->checkLoginStatusInAjax($ViewArticle->memberLoginArticleUrl);
				$ViewArticle->checkSameUserInComment($LANG['common_login_other_user_comment_delete_err_msg'], true);
				$ViewArticle->deleteComment();
				$ViewArticle->populateReplyCommentOfThisArticle();
			}
		elseif($ViewArticle->isFormGETed($_GET, 'more_articles'))
			{
				$ViewArticle->setAllPageBlocksHide();
				$ViewArticle->validate = $ViewArticle->chkValidArticleId();
				$ViewArticle->setPageBlockShow('populate_related_article');
			}
		elseif($ViewArticle->isFormGETed($_GET, 'showall') or $ViewArticle->isFormGETed($_GET, 'start_break'))
		{
			$ViewArticle->includeAjaxHeader();
			$ViewArticle->validate = $ViewArticle->chkValidArticleId();
			$ViewArticle->displayArticle();
			setTemplateFolder('general/', 'article');
			$smartyObj->display('viewArticleContent.tpl');
			die();
		}
		if ($ViewArticle->isShowPageBlock('populate_related_article'))
			{
				$ViewArticle->populateRelatedArticle($ViewArticle->getFormField('more_articles'));
			}
		if($ViewArticle->isShowPageBlock('add_reply'))
			{
				echo $ViewArticle->getFormField('comment_id');
				echo '***--***!!!';
				$ViewArticle->getReplyBlock();
			}
		if($ViewArticle->isShowPageBlock('edit_comment'))
			{
				echo $ViewArticle->getFormField('comment_id');
				echo '***--***!!!';
				$ViewArticle->checkLoginStatusInAjax($ViewArticle->memberLoginArticleUrl);
				$ViewArticle->checkSameUserInComment($LANG['common_login_other_user_comment_edit_err_msg']);
				$ViewArticle->getEditCommentBlock();
			}

		if($ViewArticle->isShowPageBlock('update_comment'))
			{
				echo $ViewArticle->getFormField('comment_id');
				echo '***--***!!!';
				echo $ViewArticle->getFormField('f');
			}
		$ViewArticle->includeAjaxFooter();
	}

$_SESSION['vUserStart'] = 0;
$_SESSION['vTagStart'] = 0;
$_SESSION['vTopStart'] = 0;
$_SESSION['vRespStart'] = 0;

if(!isAjaxpage() or $ViewArticle->getFormField('paging'))
	{
		$ViewArticle->validate = false;
		$ViewArticle->IS_USE_AJAX = true;
		$ViewArticle->setPageBlockShow('block_add_comments');


		if($ViewArticle->isFormGETed($_GET, 'action'))
			{
				$ViewArticle->validate = $ViewArticle->chkValidArticleId();

				$display = 'error';
				if(($ViewArticle->getFormField('action')=='view' and $ViewArticle->validate))
					{
						$ViewArticle->changeLastViewDateAndArticleViewed();
						$ViewArticle->setPageBlockShow('articles_form');
						$ViewArticle->setPageBlockShow('populate_related_article');
					}
				elseif($ViewArticle->getFormField('flagged_content')=='show')
					{
						$display = 'article';
					}
				else
					{
						$ViewArticle->setAllPageBlocksHide();
						$ViewArticle->setCommonErrorMsg($LANG['common_msg_error_sorry']);
						$ViewArticle->setPageBlockShow('block_msg_form_error');
					}
			}
		else if($ViewArticle->isFormPOSTed($_REQUEST, 'article_id'))
			{
				$ViewArticle->validate = $ViewArticle->chkValidArticleId();
				if(!$ViewArticle->validate)
					{
						$ViewArticle->setAllPageBlocksHide();
						$ViewArticle->setCommonErrorMsg($LANG['viewarticle_msg_error_sorry_access_denied']);
						$ViewArticle->setPageBlockShow('block_msg_form_error');
					}
				else
					{
						$display = 'article';

						if($ViewArticle->getFormField('flagged_status')=='Yes' and ($ViewArticle->getFormField('flagged_content')!='show'))
							$display = 'flag';

						if($ViewArticle->getFormField('attachment_id'))
							$display = 'attachment';

						switch($display)
							{
								case 'error':
									$ViewArticle->setAllPageBlocksHide();
									$ViewArticle->setCommonErrorMsg($ViewArticle->replaceAdultText($LANG['viewarticle_msg_error_not_allowed']));
									$ViewArticle->setPageBlockShow('block_msg_form_error');
									break;

								case 'adult':
									$ViewArticle->setAllPageBlocksHide();
									$ViewArticle->setPageBlockShow('confirmation_adult_form');
									break;

								case 'flag':
									$ViewArticle->setAllPageBlocksHide();
									$ViewArticle->setPageBlockShow('confirmation_flagged_form');
									break;

								case 'article':
									$ViewArticle->changeLastViewDateAndArticleViewed();
									$ViewArticle->setPageBlockShow('articles_form');
									$ViewArticle->setPageBlockShow('populate_related_article');
									break;

								case 'attachment':
									$ViewArticle->getAttachment();
									exit;
									break;

							}
					}
			}
		else
			{
				$ViewArticle->setAllPageBlocksHide();
				$ViewArticle->setCommonErrorMsg($LANG['common_msg_error_sorry']);
				$ViewArticle->setPageBlockShow('block_msg_form_error');
			}
		$ViewArticle->setPageBlockShow('articleMainBlock');

	}



//<<<<<-------------------- Code ends----------------------//

/*
if(!isAjax())
	{
		if($ViewArticle->isShowPageBlock('add_reply'))
			{
				$ViewArticle->includeHeader();
				setTemplateFolder('general/', 'video');
				$smartyObj->display('videoAjax.tpl');
			}
	}
*/

if($ViewArticle->isShowPageBlock('articleMainBlock') OR !$ViewArticle->validate )
	{
		if($ViewArticle->getFormField('msg')=='updated')
		{
			$ViewArticle->setCommonSuccessMsg($LANG['articleupload_msg_update_success']);
			$ViewArticle->setPageBlockShow('block_msg_form_success');
		}

		if ($ViewArticle->isShowPageBlock('confirmation_flagged_form'))
			{
				$ViewArticle->confirmation_flagged_form['viewarticle_url'] = getUrl('viewarticle', '?article_id='.$ViewArticle->getFormfield('article_id').'&amp;title='.$ViewArticle->changeTitle($ViewArticle->getFormfield('article_title')).'&amp;flagged_content=show&amp;vpkey='.$ViewArticle->getFormfield('vpkey'), $ViewArticle->getFormfield('article_id').'/'.$ViewArticle->changeTitle($ViewArticle->getFormfield('article_title')).'/?flagged_content=show&amp;vpkey='.$ViewArticle->getFormfield('vpkey'), 'members', 'article');
			}
		if ($ViewArticle->isShowPageBlock('confirmation_adult_form'))
			{
				$confirmation_adult_form_arr = array();
				$confirmation_adult_form_arr['view_article_accept_url'] = getUrl('viewarticle', '?article_id='.$ViewArticle->getFormfield('article_id').'&amp;title='.$ViewArticle->changeTitle($ViewArticle->getFormfield('article_title')).'&amp;action=accept&amp;vpkey='.$ViewArticle->getFormfield('vpkey'), $ViewArticle->getFormfield('article_id').'/'.$ViewArticle->changeTitle($ViewArticle->getFormfield('article_title')).'/?action=accept&amp;vpkey='.$ViewArticle->getFormfield('vpkey'), 'members', 'article');
				$confirmation_adult_form_arr['view_article_view_url'] = getUrl('viewarticle', '?article_id='.$ViewArticle->getFormfield('article_id').'&amp;title='.$ViewArticle->changeTitle($ViewArticle->getFormfield('article_title')).'&amp;action=view&amp;vpkey='.$ViewArticle->getFormfield('vpkey'), $ViewArticle->getFormfield('article_id').'/'.$ViewArticle->changeTitle($ViewArticle->getFormfield('article_title')).'/?action=view&amp;vpkey='.$ViewArticle->getFormfield('vpkey'), '', 'article');
				$confirmation_adult_form_arr['view_article_reject_url'] = getUrl('viewarticle', '?article_id='.$ViewArticle->getFormfield('article_id').'&amp;title='.$ViewArticle->changeTitle($ViewArticle->getFormfield('article_title')).'&amp;action=reject&amp;vpkey='.$ViewArticle->getFormfield('vpkey'), $ViewArticle->getFormfield('article_id').'/'.$ViewArticle->changeTitle($ViewArticle->getFormfield('article_title')).'/?action=reject&amp;vpkey='.$ViewArticle->getFormfield('vpkey'), 'members', 'article');
				$smartyObj->assign('confirmation_adult_form_arr', $confirmation_adult_form_arr);
			}
		if ($ViewArticle->isShowPageBlock('articles_form') and $ViewArticle->validate)
		    {
				$ViewArticle->displayArticle();
			}
	}
//-------------------- Page block templates begins -------------------->>>>>//


if(!isAjaxpage())
	{

		$LANG['meta_viewarticle_keywords'] = str_replace('{default_tags}', $CFG['html']['meta']['keywords'], $LANG['meta_viewarticle_keywords']);
		$LANG['meta_viewarticle_keywords'] = str_replace('{tags}', $ViewArticle->getFormField('article_tags'), $LANG['meta_viewarticle_keywords']);

		$LANG['meta_viewarticle_description'] = str_replace('{default_tags}', $CFG['html']['meta']['description'], $LANG['meta_viewarticle_description']);
		$LANG['meta_viewarticle_description'] = str_replace('{tags}', strip_tags($ViewArticle->getFormField('article_summary')), $LANG['meta_viewarticle_description']);

		$LANG['meta_viewarticle_title'] = str_replace('{site_title}', $CFG['site']['title'], $LANG['meta_viewarticle_title']);
		$LANG['meta_viewarticle_title'] = str_replace('{module}', $LANG['window_title_article'], $LANG['meta_viewarticle_title']);
		$LANG['meta_viewarticle_title'] = str_replace('{title}', $ViewArticle->getFormField('article_title'), $LANG['meta_viewarticle_title']);

		setPageTitle($LANG['meta_viewarticle_title']);
		setMetaKeywords($LANG['meta_viewarticle_keywords']);
		setMetaDescription($LANG['meta_viewarticle_description']);

		//include the header file
		$ViewArticle->includeHeader();

	if($ViewArticle->isShowPageBlock('add_reply') OR $ViewArticle->isShowPageBlock('block_add_comments'))
		{

			$ViewArticle->replyCommentId=$ViewArticle->getFormField('comment_id');
			$ViewArticle->replyUrl=$CFG['site']['article_url'].'viewArticle.php?ajax_page=true&article_id='.$ViewArticle->getFormField('article_id').'&vpkey='.$ViewArticle->getFormField('vpkey').'&show='.$ViewArticle->getFormField('show');
/*
			getUrl('viewarticle','?mem_auth=true&article_id='.$ViewArticle->getFormfield('article_id').'&title='.
																		$ViewArticle->changeTitle($ViewArticle->getFormfield('article_title')),
																			$ViewArticle->getFormfield('article_id').'/'.
																				$ViewArticle->changeTitle($ViewArticle->getFormfield('article_title')).
																					'/?mem_auth=true','members', 'article');
																					*/
			$ViewArticle->notLoginArticleUrl = getUrl('viewarticle','?mem_auth=true&article_id='.$ViewArticle->getFormfield('article_id').'&title='.$ViewArticle->changeTitle($ViewArticle->getFormfield('article_title')), $ViewArticle->getFormfield('article_id').'/'.$ViewArticle->changeTitle($ViewArticle->getFormfield('article_title')).'/?mem_auth=true', '','article');
			?>

			<script language="javascript" type="text/javascript">

			<?php if($CFG['admin']['articles']['captcha']
						AND $CFG['admin']['articles']['captcha_method'] == 'recaptcha'
							AND $CFG['captcha']['public_key'] AND $CFG['captcha']['private_key'])
					{
			?>
			var captcha_recaptcha = true;
			<?php
					}
			?>
			</script>
			<script language="javascript" type="text/javascript" src="<?php echo $CFG['site']['article_url'];?>js/light_comment.js"></script>
			<script language="javascript" type="text/javascript">
				var no_comment_error_msg = "<?php echo $LANG['common_noComment_errorMsg'];?>";
				var dontUse = 0;
				var replyUrl="<?php echo $ViewArticle->replyUrl;?>";
				var reply_comment_id="<?php echo $ViewArticle->replyCommentId;?>";;
				var reply_user_id="<?php echo $CFG['user']['user_id'];?>";
				var owner="<?php echo $CFG['user']['user_id'];?>";

			</script>
			<?php
		}

	if($ViewArticle->validate)
		{
?>
	<script type="text/javascript" src="<?php echo $CFG['site']['article_url'];?>js/viewArticle.js"></script>
	<script type="text/javascript" src="<?php echo $CFG['site']['url'];?>js/AG_ajax_html.js"></script>
	<script type="text/javascript" src="<?php echo $CFG['site']['url'];?>js/swfobject.js"></script>
	<script type="text/javascript" src="<?php echo $CFG['site']['url'];?>js/lib/tooltip.js"></script>
	<script type="text/javascript" src="<?php echo $CFG['site']['article_url'];?>js/functions.js"></script>
	<script type="text/javascript" src="<?php echo $CFG['site']['article_url'];?>js/articleComment.js"></script>
	<script type="text/javascript" src="<?php echo $CFG['site']['article_url'];?>js/shareArticle.js"></script>
<script type="text/javascript">
	var site_url = '<?php echo $CFG['site']['url'];?>';
	var template_default = '<?php echo $CFG['html']['template']['default']; ?>';
	var common_delete_login_err_message = "<?php echo $LANG['common_delete_login_err_message'];?>";
	var member_login_url = '<?php echo $ViewArticle->memberLoginArticleUrl; ?>';
	var stylesheet_default = '<?php echo $CFG['html']['stylesheet']['screen']['default']; ?>';
	var block_arr = new Array('selEditArtcileComments');
	var viewarticle_codes_to_display = "<?php echo $LANG['viewarticle_codes_to_display'];?>";
	var viewarticle_session_expired = "<?php echo $LANG['viewarticle_session_expired'];?>";
	var viewarticle_close_code = "<?php echo $LANG['viewarticle_close_code'];?>";
	var total_rating_images = '<?php echo $CFG['admin']['total_rating']; ?>';
	var replace_url = '<?php echo getUrl('login', '', '', 'root');?>';
	var minimum_counts = <?php echo $CFG['admin']['articles']['total_comments'];?>;
	var deleteConfirmation = "<?php echo $LANG['viewarticle_delete_confirmation'];?>";
	var no_comment_error_msg = "<?php echo $LANG['common_noComment_errorMsg'];?>";
	var view_article_ajax_page_loading = '<img alt="<?php echo $LANG['common_article_loading']; ?>" src="<?php echo $CFG['site']['url'].'article/design/templates/'.$CFG['html']['template']['default'].'/root/images/'.$CFG['html']['stylesheet']['screen']['default'].'/loading-viewarticle.gif' ?>" \/>';
	var view_article_scroll_loading='<span class="clsLoader">'+view_article_ajax_page_loading+'<\/span>';
	var viewarticle_flag_comment_invalid = "<?php echo $LANG['viewarticle_flag_comment_invalid']; ?>";
	var kinda_comment_msg = "<?php echo $LANG['comment_approval']; ?>";
	var articlelink_Favorites="<?php echo $LANG['viewarticle_favorited'];?>";
	function popupWindow(url){
		 window.open (url, "","status=0,toolbar=0,resizable=0,scrollbars=1");
		 return false;
	}
	function setClass(li_id, li_class){
		$Jq('#'+li_id).attr('className',li_class);
		$Jq('#'+li_id).attr('class',li_class);
	}
	function showDiv(element){
		if(obj = document.getElementById(element))
			obj.style.display = '';
	}
	function hideDiv(element){
		if(obj = document.getElementById(element))
			obj.style.display = 'none';
	}
</script>
<?php
		}
	}
else
	{
		//include the header file
		$ViewArticle->includeAjaxHeaderSessionCheck();
	}

//include the content of the page
setTemplateFolder('general/', 'article');
$smartyObj->display('viewArticle.tpl');

//Footer
if(!isAjaxpage())
	{
		if($ViewArticle->validate)
			{
?>
		<script language="javascript" type="text/javascript">
			var current_active_tab_class = 'clsActive';
			var current_first_active_tab_class = 'clsFirstActive';
			var current_last_active_tab_class = 'clsLastActive';
			var show_div_first_active = 'selSlidelistContent';
			var show_div = 'sel<?php echo $CFG['admin']['articles']['more_articles_default_content']; ?>Content';
			var more_tabs_div = new Array('selUserContent', 'selRelatedContent', 'selTopContent', 'selFavoritesContent');
			var more_tabs_class = new Array('selHeaderArticleUser', 'selHeaderArticleRel', 'selHeaderArticleTop', 'selHeaderFavorites');
			//var more_tabs_div = new Array('selFavoritesContent');
			//var more_tabs_class = new Array('selHeaderFavorites');
			var show_div_last_active = 'selFeaturedContent';
			var hide_ajax_tabs = new Array('flag_content_tab', 'favorite_content_tab', 'email_content_tab', 'selSlideContainer');
			var view_article_ajax_page_loading = '<img alt="<?php echo $LANG['common_article_loading']; ?>" src="<?php echo $CFG['site']['url'].'article/design/templates/'.$CFG['html']['template']['default'].'/root/images/'.$CFG['html']['stylesheet']['screen']['default'].'/loading-viewarticle.gif' ?>" \/>';
			var view_article_scroll_loading='<div class="clsLoader">'+view_article_ajax_page_loading+'<\/div>';
			var viewarticle_flag_comment_invalid = "<?php echo $LANG['viewarticle_flag_comment_invalid']; ?>";
			var FLAG_SUCCESS_MSG = '<?php echo $LANG['viewarticle_your_request']; ?>';
			var favorite_added = '<?php if($ViewArticle->favorite['added']=='') echo '1'; else echo ''; ?>';
			var favorite_url = '<?php echo $ViewArticle->favorite['url'];?>';
			var article_id = '<?php echo $ViewArticle->getFormField('article_id'); ?>';
			var deleteConfirmation = "<?php echo $LANG['viewarticle_delete_confirmation'];?>";
			var no_comment_error_msg = "<?php echo $LANG['common_noComment_errorMsg'];?>";
			var kinda_comment_msg = "<?php echo $LANG['comment_approval']; ?>";

			$Jq(document).ready(function(){
				//To Show the default div and hide the other divs
				hideMoreTabsDivs(show_div); //To hide the more tabs div and set the class to empty
				showMoreTabsDivs(show_div); //To show the more tabs div and set the class to selected
			});

			var closeShareSlider = function()
			{
			  $Jq("#selSlideContainer").hide();
			}

			function getArticleContent(url, pars)
			{
				//Code to display page title and highlight selected menu if page break exist
				query_string = url.split("?");
				page_title_array = query_string[1].split("&");
				page_title = page_title_array[1].split("=");
				highlightMenuArray = page_title_array[0].split("=");
				if(highlightMenuArray[0] == 'showall')
					result_div = 'show_all';
				else
					result_div = 'show_'+highlightMenuArray[1];

				var myAjax = new jquery_ajax(url, pars, 'displayArticleContent');
			}
			function displayArticleContent(request)
			{
				//need to add code to validate the response
				data = unescape(request);
				$Jq('#articlePageContent').html(data);
				//Code to remove the highlighted class for home link in article index while clicking remaining page links
				$Jq('#show_1').removeClass('clsAticleIndexActive');
				//remove the active class for all the pages
				$Jq('.clsArticleIndex li').each(function(index) {
					$Jq(this).removeClass('clsAticleIndexActive');
				});

				if(result_div != '')
					$Jq('#'+result_div).addClass('clsAticleIndexActive');
				//alert(page_title[1]);
				if(page_title[1] != 0)
					$Jq('#displayPageTitle').html(page_title[1]);
			}

			var getViewArticleMoreContent = function()
			{
				var content_id = arguments[0];
				var view_article_more_path;
				var call_viewarticle_ajax = false;
				view_article_content_id = content_id;
				var div_id = 'sel'+content_id+'Content';
				var more_li_id = 'selHeader'+content_id;
				//var more_li_id = 'selHeader'+content_id;
				//alert(content_id);
				var div_value = $Jq('#'+div_id).html();
				div_value = $Jq.trim(div_value);

				if(content_id == 'Favorites')
				{
					call_viewmusic_ajax = true;
					if(arguments[1] == 'remove')
					{
						$Jq('#unfavorite').css('display','none');
						$Jq('#favorite_saving').css('display','block');
						var favorite_pars = '&favorite=&article_id='+article_id;
						favorite_added = 1;
					}
					else
					{
						$Jq('#favorite').css('display','none');
						$Jq('#favorite_saving').css('display','block');
						var favorite_pars = '&favorite='+favorite_added+'&article_id='+article_id;
						favorite_added = 0;
					}

					view_article_more_path = favorite_url+favorite_pars;
				}
				if(call_viewmusic_ajax)
					{
						new jquery_ajax(view_article_more_path, '', 'insertViewArticleMoreContent');
					}
			}

			function insertViewArticleMoreContent(data)
			{
				data = data;
				if(data.indexOf('ERR~')>=1)
				{
					if(view_article_content_id == 'Favorites')
					{
						$Jq('#favorite_saving').css('display','none');
						if(favorite_added)
						{
							$Jq('#unfavorite').css('display','block');
						}
						else
						{
							$Jq('#favorite').css('display','block');
						}
						msg = '<?php echo $LANG['sidebar_login_favorite_err_msg'] ?>';
					}
					memberBlockLoginConfirmation(msg,'<?php echo $ViewArticle->memberviewArticleUrl ?>');
					return false;

				}
				if(view_article_content_id == 'Favorites')
				{
					if(favorite_added)
					{
						$Jq('#favorite_saving').css('display','none');
						$Jq('#favorite').css('display','block');
					}
					else
					{
						$Jq('#favorite_saving').css('display','none');
						$Jq('#unfavorite').css('display','block');
					}
				}

				return false;
			}

			function hideViewArticleMoreTabsDivs(current_div)
				{
					for(var i=0; i<more_tabs_div.length; i++)
						{
							if(more_tabs_div[i] != current_div)
								{
									//Effect.Fade(more_tabs_div[i], { duration: 3.0 });
									$Jq('#'+more_tabs_div[i]).hide();
									$Jq('#'+more_tabs_class[i]).removeClass(current_active_tab_class);
									$Jq('#'+more_tabs_class[i]).removeClass(current_first_active_tab_class);
									$Jq('#'+more_tabs_class[i]).removeClass(current_last_active_tab_class);
								}
						}
				}

			function showViewArticleMoreTabsDivs(current_div)
				{
					for(var i=0; i<more_tabs_div.length; i++)
						{
							if(more_tabs_div[i] == current_div)
								{
									//$(current_div).show();
									if($Jq('#'+current_div).is(':hidden'))
											$Jq('#'+current_div).toggle("slow");
										//Effect.toggle(current_div, 'appear');
									//new Effect.Opacity(current_div, { from: 0.0, to: 1.0, duration: 1.5 });
									$Jq('#'+more_tabs_class[i]).addClass(current_active_tab_class);
									if(show_div_first_active == current_div)
										$Jq('#'+more_tabs_class[i]).addClass(current_first_active_tab_class);
									/*if(show_div_last_active == current_div)
										$(more_tabs_class[i]).addClassName(current_last_active_tab_class);*/
									break;
								}
						}
				}

			var max_timer = <?php echo $CFG['admin']['articles']['comment_edit_allowed_time'];?>;
			changeTimer();
			var dontUse = 0;
			<?php
			if($CFG['admin']['articles']['more_articles_expand_collapse'])
				{
			?>

			var SITE_URL = '<?php echo $CFG['site']['url'];?>';
			var src_rightImage = SITE_URL + 'design/templates/default/images/arrow_right.gif';
			var src_downImage = SITE_URL + 'design/templates/default/images/arrow_down.gif';

			function id_toggle (targetId, div_id)
				{
					if ($Jq('#'+targetId).is(":visible"))
						{
							$Jq('#'+targetId).hide();
							document.getElementById(div_id).setAttribute("class", "clsArticleExpand");
							document.getElementById("expand_collapse").src=src_rightImage;
						}
					else
						{
							$Jq('#'+targetId).show();
							document.getElementById(div_id).setAttribute("class", "clsArticleCollapse");
							document.getElementById("expand_collapse").src=src_downImage;
						}
				}

			//id_toggle('more_article_<?php echo $ViewArticle->getFormField('article_id'); ?>');

			<?php
				}
			?>
		</script>
<?php
			}
		//includ the footer of the page
		//<<<<<<--------------------Page block templates Ends--------------------//


		$ViewArticle->includeFooter();
	}
else
	{
		if ($ViewArticle->isShowPageBlock('add_flag_list'))
			{
				setTemplateFolder('general/', 'article');
				$smartyObj->display('articleFlag.tpl');
				$ViewArticle->includeAjaxFooter();
				exit;
			}



		if ($ViewArticle->isShowPageBlock('add_comments'))
		    {
				setTemplateFolder('general/', 'article');
				$smartyObj->display('viewArticleAjax.tpl');
				$ViewArticle->includeAjaxFooter();
				exit;
			}
		if ($ViewArticle->isShowPageBlock('add_fovorite_list'))
		    {
				$ViewArticle->getFavoriteBlock();
			}
		if ($ViewArticle->isShowPageBlock('get_code_form') and 1)
		    {
		    	$ViewArticle->get_code_form_arr = array();
				$ViewArticle->get_code_form_arr['articles_folder'] = $CFG['media']['folder'].'/'.$CFG['admin']['articles']['folder'].'/';
				$ViewArticle->get_code_form_arr['flv_player_url'] = $CFG['site']['url'].'flvplayer.swf';
				$ViewArticle->get_code_form_arr['configXmlcode_url'] = getUrl('articleconfigxmlcode', '?pg=article_'.$ViewArticle->getFormField('article_id').'_0', '?pg=article_'.$ViewArticle->getFormField('article_id').'_0', 'root');
			}

		//include the content of the page
		setTemplateFolder('general/', 'article');
		$smartyObj->display('viewArticleAjax.tpl');
		//includ the footer of the page


?>

<script language="javascript" type="text/javascript">
	var max_timer = <?php echo $CFG['admin']['articles']['comment_edit_allowed_time'];?>;
	var dontUse = 0;
</script>


<?php
$ViewArticle->includeFooter();
}
?>