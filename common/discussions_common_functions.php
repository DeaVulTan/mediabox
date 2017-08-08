<?php
function htmlwrap($str, $width = 60, $break = "\n", $nobreak = "")
	{
	  	//Split HTML content into an array delimited by < and >
  	  	//The flags save the delimeters and remove empty variables
  		$content = preg_split("/([<>])/", $str, -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);

  	  	//Transform protected element lists into arrays
  	    $nobreak = explode(" ", strtolower($nobreak));

  		// Variable setup
  		$intag = false;
  		$innbk = array();
  		$drain = "";
		// List of characters it is "safe" to insert line-breaks at
  		// It is not necessary to add < and > as they are automatically implied
  		$lbrks = "/?!%)-}]\\\"':;&";

  		// Is $str a UTF8 string?
  		$utf8 = (preg_match("/^([\x09\x0A\x0D\x20-\x7E]|[\xC2-\xDF][\x80-\xBF]|\xE0[\xA0-\xBF][\x80-\xBF]|[\xE1-\xEC\xEE\xEF][\x80-\xBF]{2}|\xED[\x80-\x9F][\x80-\xBF]|\xF0[\x90-\xBF][\x80-\xBF]{2}|[\xF1-\xF3][\x80-\xBF]{3}|\xF4[\x80-\x8F][\x80-\xBF]{2})*$/", $str)) ? "u" : "";

		while (list(, $value) = each($content))
			{
    			switch ($value)
					{
						// If a < is encountered, set the "in-tag" flag
      					case "<": $intag = true; break;
						// If a > is encountered, remove the flag
      					case ">": $intag = false; break;
						default:
						// If we are currently within a tag...
        				if ($intag)
							{
								// Create a lowercase copy of this tag's contents
								$lvalue = strtolower($value);
								// If the first character is not a / then this is an opening tag
								if ($lvalue{0} != "/")
									{
										// Collect the tag name
            							preg_match("/^(\w*?)(\s|$)/", $lvalue, $t);
            							// If this is a protected element, activate the associated protection flag
            							if (isset($t[1]) AND in_array($t[1], $nobreak)) array_unshift($innbk, $t[1]);
										// Otherwise this is a closing tag
          							}
								else
									{
										// If this is a closing tag for a protected element, unset the flag
            							if (in_array(substr($lvalue, 1), $nobreak))
											{
              									reset($innbk);
              									while (list($key, $tag) = each($innbk))
												  	{
                										if (substr($lvalue, 1) == $tag)
															{
                  												unset($innbk[$key]);
                  												break;
                  											}
                  									}
                  								$innbk = array_values($innbk);
                  							}
                  					}// Else if we're outside any tags...
        					}
						else if ($value)
								{
									// If unprotected...
          							if (!count($innbk))
									  	{
									  		// Use the ACK (006) ASCII symbol to replace all HTML entities temporarily
            								$value = str_replace("\x06", "", $value);
            								preg_match_all("/&([a-z\d]{2,7}|#\d{2,5});/i", $value, $ents);
            								$value = preg_replace("/&([a-z\d]{2,7}|#\d{2,5});/i", "\x06", $value);
								            // Enter the line-break loop
            								do
												{
              										$store = $value;
              										// Find the first stretch of characters over the $width limit
              										if (preg_match("/^(.*?\s)?([^\s]{".$width."})(?!(".preg_quote($break, "/")."|\s))(.*)$/s{$utf8}", $value, $match))
													  	{
															if (strlen($match[2]))
																{
                  													// Determine the last "safe line-break" character within this match
                  													for ($x = 0, $ledge = 0; $x < strlen($lbrks); $x++) $ledge = max($ledge, strrpos($match[2], $lbrks{$x}));
                  													if (!$ledge) $ledge = strlen($match[2]) - 1;

												                  	// Insert the modified string
												                  	$value = $match[1].substr($match[2], 0, $ledge + 1).$break.substr($match[2], $ledge + 1).$match[4];
                												}
														}

            									// Loop while overlimit strings are still being found
            									}
											while ($store != $value);

            								// Put captured HTML entities back into the string
            								foreach ($ents[0] as $ent) $value = preg_replace("/\x06/", $ent, $value, 1);
          								}
        						}
    				}
    			// Send the modified segment down the drain
    			$drain .= $value;
    		}
    	//remove repeated & and #173;
    	//$drain = ereg_replace('([&]+)', '&', $drain);
    	//$drain = ereg_replace('([#173;]+)', '#173;', $drain);
		// Return contents of the drain
  		return $drain;
	}

/*
function wordWrapManual($text, $length, $total_length=0)
	{
		global $CFG;

		if (!$CFG['feature']['wrap_content']) return $text;

		if($total_length)
			{
				$text = strip_tags($text);
				if(utf8_strlen($text)>$total_length)
					$text = utf8_substr($text, 0, $total_length-3).'...';
				return htmlwrap($text, $length, ' ', true);
			}
		return htmlwrap($text, $length, ' ', true);
		$str_length = strlen($text);

		$skip = 0;
		$returnvar = '';
		$wrap = 0;
		for ($i=0; $i<=$str_length; $i=$i+1)
			{
				$skip = 0;
				$char = substr($text, $i, 1);

				if ($char == '<' || $char == '&' )
					$skip=1;
				elseif ($char == '>' || $char == ';')
					$skip=0;
				elseif ($char == ' ')
					$wrap=0;
				else if ($skip==0)
					$wrap=$wrap+1;

				$returnvar = $returnvar . $char;

				if ($wrap>$length) // alter this number to set the maximum word length
					{
						$returnvar = $returnvar.' ';
						$wrap=0;
					}
			}
		return $returnvar;
	}
*/
/**
 * to get search qurey like full text search query.
 *
 * @access	public
 * @param	string	tags to search
 * @param	string	search field
 * @param	string	additional string to add (AND, OR)
 * @return	string
 */
function getSearchBoardExpressionQuery($tags, $field_name, $extra = '')
	{
		global $CFG;
		$not_allowed_search_array = $CFG['admin']['not_allowed_chars'];
		$tags = replaceCharacter($not_allowed_search_array, '-', $tags);
		$tags = addslashes($tags);

		$additional_query = ' ( '.$field_name.' LIKE \'% '.$tags.' %\') ';
		if ($extra)
			$additional_query .= $extra.' ';
		return $additional_query;
	}

function displayProfileImage($img_arr, $img_type, $showPopup = true, $contentDisplay = false, $changePosition = false)
    {
		global $CFG, $smartyObj;
		$displayProfileImage_arr = array();
		if (isUserImageAllowed())
			{
				$img_src = $width = $attr = $class = $ext_class = '';
				switch($img_type)
					{
						case 'thumb':
							$class = 'cls90x90thumbImage';
							$ext_class = 'clsUserPopUp90';
							break;
						case 'medium':
							$class = 'cls65x65thumbImage';
							$ext_class = 'clsUserPopUp65';
							break;
						case 'small':
							$class = 'cls45x45thumbImage';
							$ext_class = 'clsUserPopUp45';
							break;
						case 'tiny':
							$class = 'cls30x30thumbImage';
							$ext_class = 'clsUserPopUp30';
							break;
						default:
							$class = 'cls90x90thumbImage';
							$ext_class = 'clsUserPopUp90';
							break;
					}
				$img_type_lc = strtolower($CFG['admin']['ans_photos'][$img_type.'_name']);
				if (isset($img_arr['img_path']) AND !empty($img_arr['img_path']))
					{
						$img_src = $img_arr['img_path'];
						$attr = ' width="'.$CFG['admin']['ans_photos'][$img_type.'_width'].'"';
					}
				else if (isset($img_arr['photo_ext']) AND (!empty($img_arr['photo_ext'])))
					{
						if($img_arr['photo_server_url']=='')
							$img_arr['photo_server_url'] = $CFG['site']['url'];
						$img_src = $img_arr['photo_server_url'].$CFG['admin']['ans_photos']['folder'].getImageName($img_arr['img_user_id']).$CFG['admin']['ans_photos'][$img_type.'_name'].'.'.$img_arr['photo_ext'];
						$attr = GET_IMAGE_ATTRIBUTES($CFG['admin']['ans_photos'][$img_type.'_width'], $CFG['admin']['ans_photos'][$img_type.'_height'], $img_arr[$img_type_lc.'_width'], $img_arr[$img_type_lc.'_height']);
					}
				elseif(isset($img_arr['gender']) AND !empty($img_arr['gender']))
					{
						$gender = strtoupper($img_arr['gender']);
						$url = $CFG['site']['url']."design/templates/".$CFG['html']['template']['default']."/root/images/".$CFG['html']['stylesheet']['screen']['default']."/no_image";
						if ($gender == 'M' || $gender == 'MALE')
						{
							switch($img_type){
								case 'small':
									$img_src =$url.'/no-maleprofile_S.jpg';
									break;
								case 'large':
									$img_src =$url.'/no-maleprofile_L.jpg';
									break;
								case 'thumb':
									$img_src =$url.'/no-maleprofile_T.jpg';
									break;
								case 'medium':
									$img_src =$url.'/no-maleprofile_M.jpg';
									break;
								default:
									;
							} // switch
						}
						elseif ($gender == 'F' || $gender == 'FEMALE')
						{
							switch($img_type){
									case 'small':
										$img_src =$url.'/no-femaleprofile_S.jpg';
										break;
									case 'large':
										$img_src =$url.'/no-femaleprofile_L.jpg';
										break;
									case 'thumb':
										$img_src =$url.'/no-femaleprofile_T.jpg';
										break;
									case 'medium':
										$img_src =$url.'/no-femaleprofile_M.jpg';
										break;
									default:
										;
								} // switch

						}

						else
						{
							switch($img_type){
									case 'small':
										$img_src =$url.'/no-maleprofile_S.jpg';
										break;
									case 'large':
										$img_src =$url.'/no-maleprofile_L.jpg';
										break;
									case 'thumb':
										$img_src =$url.'/no-maleprofile_T.jpg';
										break;
									case 'medium':
										$img_src =$url.'/no-maleprofile_M.jpg';
										break;
									default:
										;
								} // switch
						}
					}

				$displayProfileImage_arr['img_src'] = $img_src.'?r='.rand();
				$displayProfileImage_arr['div_class'] = $class;
				$displayProfileImage_arr['ext_class'] = $ext_class;
				$displayProfileImage_arr['additional_class'] = '';
				if ($changePosition)
					$displayProfileImage_arr['additional_class'] = ' clsLeftSideUserPopup';

				if ($img_src)
					{
						$altName = (isset($img_arr['asked_by']))? $img_arr['asked_by'] : ((isset($img_arr['solutioned_by']))? $img_arr['solutioned_by']:((isset($img_arr['display_name']))? $img_arr['display_name']:''));
						$altName = stripString($altName, $CFG['username']['short_length']);

						$user_url = getMemberUrl($img_arr['user_id'], $img_arr['name']);
						if (strpos($CFG['site']['relative_url'], 'admin/'))
							$user_url = $CFG['site']['url'].'admin/viewMembers.php?uid='.$img_arr['user_id'];

						$displayProfileImage_arr['showPopup'] = $showPopup;
						if ($showPopup)
							{
								$url = getUrl('userdetails', '', '', '', $CFG['admin']['index']['home_module']);
								$pars = 'uid='.$img_arr['user_id'];
								$popupDivId = 'popup_'.getPopupDivId();
								if (isset($img_arr['image_id']))
									$popupDivId .= $img_arr['image_id'].'_'.$popupDivId;

								$onmouseover = 'showUserInfoPopup(\''.$url.'\', \''.$pars.'\', \''.$popupDivId.'\');';
								if ($contentDisplay)
									{
										$onmouseover .= 'changePopupDivPosition(\''.$popupDivId.'\');';
							 		}
							 	$onmouseover = 'onmouseover="'.$onmouseover.'"';
								$displayProfileImage_arr['onmouseover'] = $onmouseover;
								$displayProfileImage_arr['user_url'] = $user_url;
								$displayProfileImage_arr['popupDivId'] = $popupDivId;
								$displayProfileImage_arr['attr'] = $attr;
								$displayProfileImage_arr['altName'] = $altName;
								$displayProfileImage_arr['url'] = $url;
								$displayProfileImage_arr['pars'] = $pars;
							}
						else
							{
								$displayProfileImage_arr['user_url'] = $user_url;
								$displayProfileImage_arr['attr'] = $attr;
								$displayProfileImage_arr['altName'] = $altName;
							}
					}
			}
		$smartyObj->assign('displayProfileImage_arr', $displayProfileImage_arr);
		setTemplateFolder('general/', $CFG['admin']['index']['home_module']);
		$smartyObj->display('displayProfileImage.tpl');
	}
function getPopupDivId()
	{
		global $popup_id;

		return $popup_id += 1;
	}

function chkIsAllowedModule($module_arr = array())
	{
		global $CFG;
		foreach($module_arr as $key=>$value)
			{
				if(!isset($CFG['admin']['module'][$value]) or !$CFG['admin']['module'][$value])
					return false;
			}
		return true;
	}

function isUserImageAllowed()
	{
		global $CFG;
		if(!isset($CFG['admin']['profile_image']['allowed']) or !$CFG['admin']['profile_image']['allowed'])
			return false;
		return true;
	}

function array_trim($ar)
	{
		$new_ar = array();
  		foreach($ar as $key=>$value){
  			$value = trim($value);
    		if ($value)
    			$new_ar[] = $value;
      	}
  		return $new_ar;
	}

function displaySolutionsTopLinks()
	{
		displaySolutionsTopLinks();
		return ;
	}

function getBoardBadgeUrl($qid = '', $append_script = true)
	{
		global $CFG;
		$badgeUrl = getUrl('embedcontent', '?embed=board&amp;qid='.$qid, 'board/'.$qid.'/', 'root');

		if ($append_script)
			{
				$badgeUrl = '<script src="'.$badgeUrl.'"></script>';
			}
		return $badgeUrl;
	}
function populateDiscuzzJsVariables()
	{
	 global $CFG, $LANG;
	 $popupPosition = 330;
	?>
	<script language="javascript" type="text/javascript">
		var SITE_URL = '<?php echo $CFG['site']['url'];?>';
		var siteUrl = '<?php echo $CFG['site']['url'];?>';
		var SITE_USERID = '<?php echo $CFG['user']['user_id'];?>';
		var siteUserId = '<?php echo $CFG['user']['user_id'];?>';
		var SITE_TEMPLATE = '<?php echo $CFG['html']['template']['default'];?>'
		var SITE_SCREEN = '<?php echo $CFG['html']['stylesheet']['screen']['default'];?>'
		var SITE_SUGGEST_URL = '<?php echo getUrl('boards', '?view=open&amp;al=all&related_board=', 'search/?related_board=');?>';
		var LOGIN_URL = '<?php echo getUrl('login', '', '', 'root');?>';
		var loadingSrc = '<img src="<?php echo $CFG['site']['url'].'discussions/design/templates/'.$CFG['html']['template']['default'].'/images/loader.gif';?>" alt="<?php echo $LANG['header_loading'];?>"/>';
		var processingSrc = '<img src="<?php echo $CFG['site']['url'].'discussions/design/templates/'.$CFG['html']['template']['default'].'/images/processing.gif';?>" alt="<?php echo $LANG['header_loading'];?>"/>';
		var popupPosition = '<?php echo $popupPosition;?>';
		var LANG_CLOSE = '<?php echo $LANG['header_close'];?>';
		var LANG_LOADING = '<?php echo $LANG['header_loading'];?>';
		var LANG_OR = '<?php echo $LANG['header_or'];?>';
		var LANG_CANCEL = '<?php echo $LANG['common_cancel'];?>';
		var LANG_limit = '<?php echo $LANG['header_limit'];?>';
		var LANG_limit_exceeds = '<?php echo $LANG['header_limit_exceeds'];?>';
		var LANG_valid_reason_for_abusing = '<?php echo $LANG['header_valid_reason_for_abusing'];?>';
		var LANG_compulsory = '<?php echo $LANG['err_tip_compulsory'];?>';
		var LANG_invalid_email = '<?php echo $LANG['header_err_tip_invalid_email'];?>';
		var LANG_invalid = '<?php echo $LANG['header_err_tip_invalid_number'];?>';
		var LANG_sending_email = '<?php echo $LANG['header_sending_email_msg'];?>';
		var LANG_updating_msg = '<?php echo $LANG['header_updating_msg'];?>';
		var LANG_remaining_again = '<?php echo $LANG['header_remainig_again'];?>';
		var LANG_exceed_limit = '<?php echo $LANG['header_exceed_limit'];?>';
		var LANG_remaining = '<?php echo $LANG['header_remainig'];?>';
		var LANG_header_remove = '<?php echo $LANG['header_remove'];?>';
		var LANG_not_match = '<?php echo $LANG['discuzz_common_err_tip_same_password'];?>';
		var LANG_mustbe = '<?php echo $LANG['live_validate_mustbe'];?>';
		var LANG_mustbe_integer = '<?php echo $LANG['live_validate_mustbe_integer'];?>';
	    var LANG_mustnotbe_less = '<?php echo $LANG['live_validate_mustnotbe_less'];?>';
		var LANG_mustnotbe_more = '<?php echo $LANG['live_validate_mustnotbe_more'];?>';
		var LANG_chars = '<?php echo $LANG['live_validate_characters'];?>';
		var ques_des_max_len = '<?php echo $CFG['admin']['description']['limit'];?>';
		var ans_des_max_length = '<?php echo $CFG['admin']['solutions']['limit'];?>';
		var quick_solutions_max_length = '<?php echo $CFG['admin']['quick_solutions']['limit'];?>';
		var bio_count ='<?php echo $CFG['admin']['bio_count'];?>';
		var file_upload_limit = '<?php echo $CFG['admin']['attachments_allowed']['count'];?>';
		var file_upload_limit_exceeds = '<?php echo $LANG['file_size_exceeds'];?>';
		var ImageFolderName = '<?php echo $CFG['admin']['index']['home_module'];?>';
	</script>
<?php
	}
function populateDiscuzzJsVariables2()
	{
		global $CFG;
?>
	<script language="javascript" type="text/javascript" src="<?php echo $CFG['site']['url'].$CFG['admin']['index']['home_module'];?>/js/script.js"></script>
	<script language="javascript" type="text/javascript" src="<?php echo $CFG['site']['url'].$CFG['admin']['index']['home_module'];?>/js/functions.js"></script>
	<script language="javascript" type="text/javascript" src="<?php echo $CFG['site']['url'];?>js/SWFUpload/swfupload.js"></script>
	<script language="javascript" type="text/javascript" src="<?php echo $CFG['site']['url'];?>discussions/js/swfupload/handlers.js"></script>
	<script language="javascript" type="text/javascript" src="<?php echo $CFG['site']['url'];?>tools/bbcode/ed.js"></script>
<?php
	}
/**
 * getUserInfoDetails()
 *
 * @param mixed $req_arr
 * @param mixed $condtion_field
 * @param mixed $condition_val
 * @return
*/
function getUserInfoDetails($req_arr, $condtion_field, $condition_val)
	{
		global $CFG;
		global $db;

		$req_arr = $CFG['users_info'];

		$field_names_separated_by_comma = '';
		$user_info_fields = array();
		foreach($req_arr as $fields=>$values)
			{
				if($values != '')
					{
						$user_info_fields[] = $values.' As '.$fields;
					}
			}

		$field_names_separated_by_comma = implode(', ', $user_info_fields);

		$sql = 'SELECT '.$field_names_separated_by_comma.' FROM '.$CFG['db']['tbl']['users_info'].
				' WHERE '.$condtion_field.' = '.$db->Param('cond_value');

		$stmt = $db->Prepare($sql);
		$rs = $db->Execute($stmt, array($condition_val));
		if (!$rs)
			trigger_db_error($db);

		$ret_arr = array();
		$ret_arr = array('img_path'=>'', 'm_height'=>'', 'm_width'=>'', 't_height'=>'', 't_width'=>'', 's_height'=>'', 's_width'=>'', 'photo_server_url'=>'',
							'photo_ext'=>'', 'gender'=>'', 'bio'=>'', 'online_hours'=>'', 'featured'=>'', 'is_logged_in'=>'', 'last_logged'=>'',
							'last_active'=>'', 'last_updated'=>'', 'update_seconds'=>'', 'online_hours'=>'', 'num_visits'=>'', 'session'=>'', 'ip'=>'',
							'visible_to'=>'', 'time_zone'=>'');
		if ($rs->PO_RecordCount())
			{
				$ret_arr = $rs->FetchRow();
				return $ret_arr;
			}
		return $ret_arr;
	}
function getUserDetailsFromUsersTable($user_table, $user_id)
	{
		global $CFG;
		global $db;

		$sql = 'SELECT '.getUserTableFields(array('user_id', 'name', 'display_name', 'email', 'user_status', 'user_access', 'doj')).
				', '.getUserTableField('user_id').' AS img_user_id'.
				' FROM '.$user_table.
				' WHERE '.getUserTableField('user_id').' = '.$db->Param($user_id);
		$stmt = $db->Prepare($sql);
		$rs = $db->Execute($stmt, array($user_id));
		if (!$rs)
			trigger_db_error($db);

		$row = array('name'=>'', 'display_name'=>'', 'email'=>'', 'bio'=>'', 'image_path'=>'', 'gender'=>'', 'user_status'=>'', 'user_access'=>'', 'img_user_id'=>'', 'm_height'=>'', 'm_width'=>'', 't_height'=>'', 't_width'=>'', 's_height'=>'', 's_width'=>'', 'photo_server_url'=>'', 'photo_ext'=>'');
		$req_arr = array('img_path', 'm_height', 'm_width', 't_height', 't_width', 's_height', 's_width', 'photo_server_url', 'photo_ext', 'gender', 'bio', 'online_hours', 'featured');
		if ($rs->PO_RecordCount())
			{
				$user_arr = $rs->FetchRow();
				//getting user info..
				$user_info_details_arr = getUserInfoDetails($req_arr, 'user_id', $user_arr['img_user_id']);
				$row = array_merge($user_arr, $user_info_details_arr);
			}
		return	$row;
	}
function getMemberUrl($uid, $uname, $page='')
	{
		//return getUrl('mysolutions', '?uid='.$uname, $uname.'/', $page);
		// FOR RAYZZ INTEGRATION
		return getUrl('viewprofile', '?user='.$uname, $uname.'/', $page);
	}
function getUserTableField($user_field)
    {
    	global $CFG;
		return $CFG['users'][$user_field];
    }
function getUserTableFields($user_fields, $trim=true)
    {
		global $CFG;

		$str = '';
		foreach($user_fields as $field){
			if (isset($CFG['users'][$field]) AND $CFG['users'][$field])
				$str .= $CFG['users'][$field].' AS '.$field.', ';
		}
		if ($trim)
			$str = substr($str, 0, strrpos($str, ', '));
		return $str;
    }
function getUsersDisplayName($name)
	{
		global $CFG;
		global $db;

		$sql = 'SELECT '.getUserTableField('display_name').' AS display_name'.
				' FROM '.$CFG['db']['tbl']['users'].
				' WHERE '.getUserTableField('name').' = '.$db->Param($name);
		$stmt = $db->Prepare($sql);
		$rs = $db->Execute($stmt, array($name));
		if (!$rs)
				trigger_db_error($db);
		$display_name = '';
		if ($rs->PO_RecordCount())
			{
				$row = $rs->FetchRow();
				$display_name = $row['display_name'];
			}
		return	$display_name;
	}
function strip_only($str, $tags) {
    if(!is_array($tags)) {
        $tags = (strpos($str, '>') !== false ? explode('>', str_replace('<', '', $tags)) : array($tags));
        if(end($tags) == '') array_pop($tags);
    }
    foreach($tags as $tag) $str = preg_replace('#</?'.$tag.'[^>]*>#is', '', $str);
    return $str;
}
function crossSiteScript($data)
	{
		$data = strip_only(trim($data), array('script', 'body', 'meta'));
		$XSS_arr = array('vulnerable=true;>', 'vulnerable=true;">', '<img src="javascript', 'javascript:');
		foreach($XSS_arr as $ky=>$val)
			{
				$to_check = htmlentities($val);
				$data_check = htmlentities($data);
				if(preg_match("/".$to_check."/i", $data_check))
					$data = '';
			}
		return $data;
	}
function Redirect2Page($url)
	{
		if (!headers_sent())
		    {
				echo '<meta http-equiv="refresh" content="0; URL='.URL($url).'" />'."\n";
		    }
		else
			{
				trigger_error('Headers already sent', E_USER_NOTICE);
				echo '<meta http-equiv="refresh" content="0; URL='.URL($url).'" />'."\n";
				echo '<p>Please click this <a href="'.URL($url).'">link</a> to continue...</p>'."\n";
			}
		exit(0);
	}
function removeDuplicateKeywords($keywords)
	{
		global $CFG;
		$not_allowed_search_array = $CFG['admin']['not_allowed_chars'];
		$keywords = replaceCharacter($not_allowed_search_array, '', $keywords);
		$keywords_arr = explode(' ', $keywords);
		$keywords_arr = array_unique($keywords_arr);
		foreach($keywords_arr as $key=>$value)
			{
				$len = strlen($value);
				if(!($len>=$CFG['admin']['tag_min_size'] and $len<=$CFG['admin']['tag_max_size']))
					unset($keywords_arr[$key]);
			}
		$keywords = implode(' ', $keywords_arr);
		return trim($keywords);
	}

function populateAdminDiscussionsLeftNavigation()
	{
	   	 global $smartyObj;
	     setTemplateFolder('admin/','discussions');
	     //$smartyObj->assign('admin_main_menu_arrays', additionalDiscussionsAdminMenuLink());
		 $smartyObj->display('left_discussions_navigation_links.tpl');
		 ?>
		<script language="javascript" type="text/javascript">
			var inc = divArray.length;
			var temp_discussions_menu_array = new Array('discussionsMain', 'discussionsSetting', 'discussionsPlugin');
			for(jnc=0;jnc<temp_discussions_menu_array.length;jnc++)
				divArray[inc++] = temp_discussions_menu_array[jnc];
		</script>
	   	 <?php
	}
function displayTopContributorSmallImage($img_arr, $img_type='small', $showPopup = true, $contentDisplay = false)
    {
    	displayProfileImage($img_arr, $img_type, $showPopup, $contentDisplay);
		return ;
    }
function getSettingsUrl()
	{
		//return getUrl('managesettings', '', '', 'members');
		//FOR RAYZZ INTEGRATION
		return getUrl('profilebasic', '', '', 'members');
	}
/**
 * used to get the image with and height
 *
 * @access	public
 * @param	integer required width
 * @param	integer required height
 * @param	integer	image original width
 * @param	integer	image original height
 * @return	string
 */
function GET_IMAGE_ATTRIBUTES($cfg_width = 0, $cfg_height = 0, $img_width = 0, $img_height = 0)
	{
		if ($cfg_width > 0 AND $cfg_height > 0 AND ($cfg_width < $img_width) AND ($cfg_height < $img_height))
			$attr = ($img_width > $img_height)? " width=\"".$cfg_width."\"" : " height=\"".$cfg_height."\"";
			else if ($cfg_width > 0 AND $cfg_width < $img_width)
				$attr = " width=\"".$cfg_width."\"";
				else if ($cfg_height > 0 AND $cfg_height < $img_height)
					$attr = " height=\"".$cfg_height."\"";
					else
						$attr = "";
			return $attr;
	}
function adminDiscussionsStatistics()
	{
	    global $CFG;
		global $db;
		global $smartyObj;
        $discussionStatistics_arr = array();

        //Total Boards
		$sql = 'SELECT COUNT(board_id) AS cnt FROM '.$CFG['db']['tbl']['boards'].
				' WHERE status=\'Active\'';
		$stmt = $db->Prepare($sql);
		$rs = $db->Execute($stmt);
		if (!$rs)
			trigger_error($db->ErrorNo().' '.$db->ErrorMsg(), E_USER_ERROR);
		$row['cnt'] = 0;
		if ($rs->PO_RecordCount())
			$row = $rs->FetchRow();

		$discussionStatistics_arr['total_boards'] = $row['cnt'];

		$sql = 'SELECT COUNT(board_id) AS cnt FROM '.$CFG['db']['tbl']['boards'].
				' WHERE DATEDIFF(DATE_FORMAT(board_added, \'%Y-%m-%d\'), DATE_FORMAT(NOW(), \'%Y-%m-%d\')) = 0';
		$stmt = $db->Prepare($sql);
		$rs = $db->Execute($stmt);
		if (!$rs)
			trigger_error($db->ErrorNo().' '.$db->ErrorMsg(), E_USER_ERROR);
		$row['cnt'] = 0;
		if ($rs->PO_RecordCount())
			$row = $rs->FetchRow();

		$discussionStatistics_arr['todays_boards'] = $row['cnt'];

		$sql = 'SELECT COUNT(board_id) AS cnt FROM '.$CFG['db']['tbl']['boards'].
				' WHERE DATEDIFF(DATE_FORMAT(solution_added, \'%Y-%m-%d\'), DATE_FORMAT(NOW(), \'%Y-%m-%d\')) = 0';
		$stmt = $db->Prepare($sql);
		$rs = $db->Execute($stmt);
		if (!$rs)
			trigger_error($db->ErrorNo().' '.$db->ErrorMsg(), E_USER_ERROR);
		$row['cnt'] = 0;
		if ($rs->PO_RecordCount())
			$row = $rs->FetchRow();

		$discussionStatistics_arr['todays_solutions'] = $row['cnt'];

		$smartyObj->assign('discussionStatistics_arr', $discussionStatistics_arr);
	}
function getTotalDiscussionss($user_id='', $with_link=0)
	{
	   	global $CFG;
		global $db;
		global $LANG;

	    if($user_id=='')
			$user_id = $CFG['user']['user_id'];

		$user_sql = 'SELECT '.getUserTableField('name').' As name FROM '.$CFG['db']['tbl']['users'].' WHERE user_id='.$db->Param($user_id);
		$user_stmt = $db->Prepare($user_sql);
		$user_rs = $db->Execute($user_stmt, array($user_id));
	    if (!$user_rs)
		    trigger_error($db->ErrorNo().' '.$db->ErrorMsg(), E_USER_ERROR);
		if($user_row = $user_rs->FetchRow())
			{
				$user_name = $user_row['name'];
			}

		$sql ='SELECT count(board_id) As  total_boards FROM '.$CFG['db']['tbl']['boards'].' WHERE user_id='.$db->Param($user_id);
		$stmt = $db->Prepare($sql);
		$rs = $db->Execute($stmt, array($user_id));
	    if (!$rs)
		    trigger_error($db->ErrorNo().' '.$db->ErrorMsg(), E_USER_ERROR);
		if($row = $rs->FetchRow())
			{
	                    //echo $row['total_discussions'].'fhghfg';
				if($with_link)
					return $discussion_list_url = getUrl('boards', '?view=search&amp;opt=board&amp;uname='.$user_name, 'search/?opt=board&amp;uname='.$user_name, '', $CFG['admin']['index']['home_module']);
				else
		  	   		return $LANG['boards'].': <span>'.$row['total_boards'].'</span>';
			}
		return false;
	}

	function getTotalUsersDiscussionss($user_id='', $with_link=0)
	{
	   	global $CFG;
		global $db;
		global $LANG;

	    if($user_id=='')
			$user_id = $CFG['user']['user_id'];

		$user_sql = 'SELECT '.getUserTableField('name').' As name FROM '.$CFG['db']['tbl']['users'].' WHERE user_id='.$db->Param($user_id);
		$user_stmt = $db->Prepare($user_sql);
		$user_rs = $db->Execute($user_stmt, array($user_id));
	    if (!$user_rs)
		    trigger_error($db->ErrorNo().' '.$db->ErrorMsg(), E_USER_ERROR);
		if($user_row = $user_rs->FetchRow())
			{
				$user_name = $user_row['name'];
			}

		$sql ='SELECT count(board_id) As  total_boards FROM '.$CFG['db']['tbl']['boards'].' WHERE user_id='.$db->Param($user_id);
		$stmt = $db->Prepare($sql);
		$rs = $db->Execute($stmt, array($user_id));
	    if (!$rs)
		    trigger_error($db->ErrorNo().' '.$db->ErrorMsg(), E_USER_ERROR);
		if($row = $rs->FetchRow())
			{
	                    //echo $row['total_discussions'].'fhghfg';
				if ($row['total_boards']>0) {
					if($with_link)
						 return $discussion_list_url = $LANG['boards'].': <span><a href="'.getUrl('boards', '?view=search&amp;opt=board&amp;uname='.$user_name, 'search/?opt=board&amp;uname='.$user_name, '', $CFG['admin']['index']['home_module']).'">'.$row['total_boards'].'</a></span>';
					else
			  	   		return $LANG['boards'].': <span>'.$row['total_boards'].'</span>';
				}
				else
					return $LANG['boards'].': <span>'.$row['total_boards'].'</span>';

			}
		return false;
	}

	function getTotalDiscussionssViews($user_id='')
	{
		global $CFG;
		global $db;

		if($user_id == '')
			$user_id = $CFG['user']['user_id'];

		$sql = 'SELECT SUM(total_views) AS cnt FROM '.$CFG['db']['tbl']['boards'].' WHERE user_id=\''.$user_id.'\' ';

		$stmt = $db->Prepare($sql);
		$rs = $db->Execute($stmt);
		if (!$rs)
			trigger_db_error($db);
		$count = '';
		if ($rs->PO_RecordCount())
			{
				$row = $rs->FetchRow();
				$count = $row['cnt'];
			}
		$count = number_format($count);
		return $count;
	}

