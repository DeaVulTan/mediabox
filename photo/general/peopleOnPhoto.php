<?php
class peopleOnPhoto extends photoHandler
{
	public $advanceSearch;

	public function setTableAndColumns()
    {
      //$this->results_num_per_page=2;
      switch ($this->fields_arr['tag_type'])
	   {
	     case 'tag_name':
	     		$this->setTableNames(array($this->CFG['db']['tbl']['photo_people_tag'].' AS ppt JOIN ' . $this->CFG['db']['tbl']['photo'] . ' AS p ON ppt.photo_id = p.photo_id'. ' JOIN  '.$this->CFG['db']['tbl']['users'].' AS u ON ppt.tagged_by_user_id = u.user_id '));

				$this->setReturnColumns(array('ppt.photo_id','ppt.tagged_by_user_id','u.user_name', 'p.photo_ext', 'p.photo_title', 'p.photo_server_url', 'p.t_width', 'p.t_height'));

				$this->sql_sort = 'p.date_added DESC';

				$this->sql_condition = 'tag_name LIKE \'%' .$this->fields_arr['tag_name']. '%\'  AND p.photo_status=\'Ok\'' . $this->getAdultQuery('p.', 'photo') . ' AND u.usr_status=\'Ok\' ';
	      break;
	      case 'people':
				$this->setTableNames(array($this->CFG['db']['tbl']['photo_people_tag'].' AS ppt JOIN ' . $this->CFG['db']['tbl']['photo'] . ' AS p ON ppt.photo_id = p.photo_id'. '  JOIN  '.$this->CFG['db']['tbl']['users'].' AS u ON ppt.tagged_by_user_id =u.user_id '));

				$this->setReturnColumns(array('ppt.photo_id','ppt.tagged_by_user_id','u.user_name', 'p.photo_ext', 'p.photo_title', 'p.photo_server_url', 'p.t_width', 'p.t_height'));

				$this->sql_sort = 'p.date_added DESC';

				$this->sql_condition = 'ppt.associate_user_id ='.$this->fields_arr['user_id'].' AND ppt.associate_user_id!=0  AND p.photo_status=\'Ok\'' . $this->getAdultQuery('p.', 'photo') . ' AND u.usr_status=\'Ok\' ';
	      break;
	      case 'tagged_by':
				$this->setTableNames(array($this->CFG['db']['tbl']['photo_people_tag'].' AS ppt JOIN ' . $this->CFG['db']['tbl']['photo'] . ' AS p ON ppt.photo_id = p.photo_id'. '  JOIN  '.$this->CFG['db']['tbl']['users'].' AS u ON ppt.tagged_by_user_id =u.user_id '));

			/*	$this->setReturnColumns(array('ppt.photo_id','ppt.tagged_by_user_id','u.user_name', 'p.photo_ext', 'p.photo_title', 'p.photo_server_url', '(SELECT GROUP_CONCAT( CONCAT_WS(\'~\', tbppt.associate_user_id, tbppt.tag_name )) FROM photo_people_tag AS tbppt JOIN users AS tbu ON tbppt.tagged_by_user_id = tbu.user_id WHERE tbppt.photo_id = ppt.photo_id AND tbu.usr_status = \'Ok\' ) AS tag_by_people', '(SELECT GROUP_CONCAT(DISTINCT CONCAT_WS(\'~\', tbu.user_id, tbu.user_name )) FROM photo_people_tag AS tbppt JOIN users AS tbu ON tbppt.tagged_by_user_id = tbu.user_id WHERE tbppt.photo_id = ppt.photo_id AND tbu.usr_status = \'Ok\' AND ( tbppt.tagged_by_user_id != '.$this->fields_arr['user_id'].' OR tbppt.tag_name = \''.$this->CFG['user']['user_name'].'\')) AS tag_by_users
'));*/
				$this->setReturnColumns(array('ppt.photo_id','ppt.tagged_by_user_id','u.user_name', 'p.photo_ext', 'p.photo_title', 'p.photo_server_url', 'p.t_width', 'p.t_height', '(SELECT GROUP_CONCAT( CONCAT_WS(\'~\', tbppt.associate_user_id, tbppt.tag_name )) FROM photo_people_tag AS tbppt WHERE tbppt.photo_id = ppt.photo_id ) AS tag_by_people', '(SELECT GROUP_CONCAT(DISTINCT CONCAT_WS(\'~\', tbu.user_id, tbu.user_name )) FROM photo_people_tag AS tbppt JOIN users AS tbu ON tbppt.tagged_by_user_id = tbu.user_id WHERE tbppt.photo_id = ppt.photo_id AND tbu.usr_status = \'Ok\' AND ( tbppt.tagged_by_user_id != '.$this->fields_arr['user_id'].' OR tbppt.tag_name = \''.$this->CFG['user']['user_name'].'\')) AS tag_by_users
'));
				$this->sql_sort = 'p.date_added DESC';

				if($this->fields_arr['tag_name'] || $this->fields_arr['people'])
				{
					$this->sql_condition = 'ppt.photo_id IN ( SELECT photo_id FROM photo_people_tag WHERE tagged_by_user_id = '.$this->fields_arr['user_id'].') AND p.photo_status=\'Ok\'' . $this->getAdultQuery('p.', 'photo') . ' AND u.usr_status=\'Ok\' '.$this->advancedFilters().' GROUP BY p.photo_id ';
					//$this->sql_condition = 'ppt.tagged_by_user_id ='.$this->fields_arr['user_id'].' AND p.photo_status=\'Ok\'' . $this->getAdultQuery('p.', 'photo') . ' AND u.usr_status=\'Ok\' '.$this->advancedFilters();
				}
				else
				{
					$this->sql_condition = 'ppt.tagged_by_user_id ='.$this->fields_arr['user_id'].' AND p.photo_status=\'Ok\'' . $this->getAdultQuery('p.', 'photo') . ' AND u.usr_status=\'Ok\' GROUP BY p.photo_id ';
					//$this->sql_condition = 'ppt.tagged_by_user_id ='.$this->fields_arr['user_id'].' AND ppt.tag_name=\''.$this->CFG['user']['user_name'].'\' AND p.photo_status=\'Ok\'' . $this->getAdultQuery('p.', 'photo') . ' AND u.usr_status=\'Ok\' '.$this->advancedFilters();
				}

	      break;

	      case 'tag':
				$this->setTableNames(array($this->CFG['db']['tbl']['photo_people_tag'].' AS ppt LEFT JOIN ' . $this->CFG['db']['tbl']['photo'] . ' AS p ON ppt.photo_id = p.photo_id'. ' LEFT JOIN  '.$this->CFG['db']['tbl']['users'].' AS u ON ppt.tagged_by_user_id =u.user_id '));

				$this->setReturnColumns(array('ppt.photo_id','ppt.tagged_by_user_id', 'u.user_id', 'u.user_name', 'p.photo_ext', 'p.photo_title', 'p.photo_server_url', 'p.t_width', 'p.t_height', '(SELECT GROUP_CONCAT( CONCAT_WS(\'~\', tppt.associate_user_id, tppt.tag_name )) FROM photo_people_tag AS tppt LEFT JOIN ' . $this->CFG['db']['tbl']['photo'] . ' AS tp ON tppt.photo_id = tp.photo_id'. ' LEFT JOIN '.$this->CFG['db']['tbl']['users'].' AS tu ON tppt.tagged_by_user_id =tu.user_id WHERE tp.photo_status=\'Ok\'' . $this->getAdultQuery('tp.', 'photo') . ' AND tu.usr_status=\'Ok\' AND tppt.photo_id = p.photo_id) AS all_tags', '(SELECT GROUP_CONCAT( DISTINCT CONCAT_WS(\'~\', tu.user_id, tu.user_name )) FROM photo_people_tag AS tppt LEFT JOIN ' . $this->CFG['db']['tbl']['photo'] . ' AS tp ON tppt.photo_id = tp.photo_id'. ' LEFT JOIN '.$this->CFG['db']['tbl']['users'].' AS tu ON tppt.tagged_by_user_id =tu.user_id WHERE tp.photo_status=\'Ok\'' . $this->getAdultQuery('tp.', 'photo') . ' AND tu.usr_status=\'Ok\' AND tppt.photo_id = p.photo_id)  AS photo_tagged_users'));

				$this->sql_sort = 'p.date_added DESC';

				$this->sql_condition = 'p.photo_status=\'Ok\'' . $this->getAdultQuery('p.', 'photo') . ' AND u.usr_status=\'Ok\''.$this->advancedFilters().' GROUP BY ppt.photo_id ';

	      break;
	      case 'tagged_of':
				$this->setTableNames(array($this->CFG['db']['tbl']['photo_people_tag'].' AS ppt JOIN ' . $this->CFG['db']['tbl']['photo'] . ' AS p ON ppt.photo_id = p.photo_id'. '  JOIN  '.$this->CFG['db']['tbl']['users'].' AS u ON ppt.tagged_by_user_id =u.user_id '));

				/*$this->setReturnColumns(array('ppt.photo_id','ppt.tagged_by_user_id','u.user_name', 'p.photo_ext', 'p.photo_title', 'p.photo_server_url', '(SELECT GROUP_CONCAT( CONCAT_WS(\'~\', associate_user_id, tag_name )) FROM photo_people_tag WHERE tagged_by_user_id ='.$this->fields_arr['user_id'].' AND photo_id = ppt.photo_id GROUP BY tagged_by_user_id ) AS tag_of_people', '(SELECT GROUP_CONCAT(DISTINCT CONCAT_WS(\'~\', tou.user_id, tou.user_name )) FROM photo_people_tag AS toppt JOIN users AS tou ON toppt.tagged_by_user_id = tou.user_id WHERE toppt.photo_id = ppt.photo_id AND tou.usr_status = \'Ok\' AND ( toppt.tagged_by_user_id != '.$this->fields_arr['user_id'].' OR toppt.tag_name = \''.$this->CFG['user']['user_name'].'\')) AS tag_of_users
'));*/
				$this->setReturnColumns(array('ppt.photo_id','ppt.tagged_by_user_id','u.user_name', 'p.photo_ext', 'p.photo_title', 'p.photo_server_url', 'p.t_width', 'p.t_height', '(SELECT GROUP_CONCAT( CONCAT_WS(\'~\', toppt.associate_user_id, toppt.tag_name )) FROM photo_people_tag AS toppt WHERE toppt.photo_id = ppt.photo_id ) AS tag_of_people', '(SELECT GROUP_CONCAT(DISTINCT CONCAT_WS(\'~\', tou.user_id, tou.user_name )) FROM photo_people_tag AS toppt JOIN users AS tou ON toppt.tagged_by_user_id = tou.user_id WHERE toppt.photo_id = ppt.photo_id AND tou.usr_status = \'Ok\' AND ( toppt.tagged_by_user_id != '.$this->fields_arr['user_id'].' OR toppt.tag_name = \''.$this->CFG['user']['user_name'].'\')) AS tag_of_users
'));

				$this->sql_sort = 'p.date_added DESC';

				if($this->fields_arr['tag_name'] || $this->fields_arr['people'])
				{
					$this->sql_condition = 'ppt.photo_id IN ( SELECT photo_id FROM photo_people_tag WHERE associate_user_id = '.$this->fields_arr['user_id'].') AND p.photo_status=\'Ok\'' . $this->getAdultQuery('p.', 'photo') . ' AND u.usr_status=\'Ok\' '.$this->advancedFilters().' GROUP BY p.photo_id ';
				}
				else
				{
					$this->sql_condition = 'ppt.associate_user_id ='.$this->fields_arr['user_id'].' AND p.photo_status=\'Ok\'' . $this->getAdultQuery('p.', 'photo') . ' AND u.usr_status=\'Ok\' GROUP BY p.photo_id ';
				}

	      break;


	   }
    }

	public function chkValidUserName($tag_type)
    {
		$sql = 'SELECT user_id ' . 'FROM ' . $this->CFG['db']['tbl']['users'].' ' .
				'WHERE user_name = '.$this->dbObj->Param('user_name').' AND usr_status=\'Ok\'';

        $stmt = $this->dbObj->Prepare($sql);
        $rs = $this->dbObj->Execute($stmt,array($this->fields_arr[$tag_type]));
        if (!$rs)
        	trigger_db_error($this->dbObj);
        if($row = $rs->FetchRow())
           return $row['user_id'];
        return false;
	}

	public function chkValidUser($user_name)
    {
		$sql = 'SELECT user_id ' . 'FROM ' . $this->CFG['db']['tbl']['users'].' ' .
				'WHERE user_name = '.$this->dbObj->Param('user_name').' AND usr_status=\'Ok\'';
        $stmt = $this->dbObj->Prepare($sql);
        $rs = $this->dbObj->Execute($stmt,array($user_name));
        if (!$rs)
        	trigger_db_error($this->dbObj);

        if ($rs->PO_RecordCount())
			return true;
		else
			return false;
	}

	public function chkAdvanceResultFound()
	{
		if($this->advanceSearch)
		{
			return true;
		}
		return false;
	}

	public function advancedFilters()
    {
        // Advanced Filters (adv_people_name, adv_tag_by_user):
        $advanced_filters = '';
        $this->advanceSearch = false;
        if ($this->isFormPOSTed($_REQUEST, 'advanceFromSubmission') or $this->getFormField('advanceFromSubmission')==1 or $this->getFormField('people') or $this->getFormField('tag_name'))
		{
			$advanced_filters = '';
			if($this->isFormPOSTed($_REQUEST, 'advanceFromSubmission'))
			{
				if ($this->getFormField('people') != $this->LANG['peopleonphoto_search_people_name'] AND $this->getFormField('people') AND  !$this->getFormField('tagged_of'))
				{
					$advanced_filters .= ' AND ppt.tag_name = \''.validFieldSpecialChr($this->getFormField('people')).'\'';
					$this->advanceSearch = true;
				}
				if ($this->getFormField('tag_name') != $this->LANG['peopleonphoto_search_tagged_by'] AND $this->getFormField('tag_name') AND  !$this->getFormField('tagged_by'))
				{
					if(($this->getFormField('adv_user_id')))
					{
						if($this->getFormField('tag') && $advanced_filters != '')
							$advanced_filters .= ' OR ppt.tagged_by_user_id ='.$this->getFormField('adv_user_id');
						else
							$advanced_filters .= ' AND ppt.tagged_by_user_id ='.$this->getFormField('adv_user_id');
					}
					else
					{
						$advanced_filters .= ' AND ppt.tag_name =\''.validFieldSpecialChr($this->getFormField('tag_name')).'\'';
					}

					$this->advanceSearch = true;
				}

			}
			else
			{
				$advanced_filters ='';
				if ($this->getFormField('people') != $this->LANG['peopleonphoto_search_people_name'] AND $this->getFormField('people'))
				{
					$advanced_filters .= ' AND ppt.tag_name = \'' .validFieldSpecialChr($this->getFormField('people')). '\' ';
					$this->advanceSearch = true;
				}

				if ($this->getFormField('tag_name') != $this->LANG['peopleonphoto_search_tagged_by'] AND $this->getFormField('tag_name'))
				{
					if($this->getFormField('tag') && $advanced_filters != '' && $this->getFormField('adv_user_id'))
						$advanced_filters .= ' OR ppt.tagged_by_user_id = \'' .validFieldSpecialChr($this->getFormField('adv_user_id')). '\' ';
					elseif(($this->getFormField('adv_user_id')))
						$advanced_filters .= ' AND ppt.tagged_by_user_id = \'' .validFieldSpecialChr($this->getFormField('adv_user_id')). '\' ';
					else
						$advanced_filters .= ' AND ppt.tag_name = \'' .validFieldSpecialChr($this->getFormField('tag_name')). '\' ';
					$this->advanceSearch = true;
				}
			}

			return $advanced_filters;
		}
    }

	public function showPhotoList()
    {
        global $smartyObj;

        $inc = 0;
        $photos_folder = 'files/'.$this->CFG['admin']['photos']['folder'].'/'.$this->CFG['admin']['photos']['photo_folder'].'/';
        $this->isResultsFound=false;
        $result_arr=array();
        while ($row = $this->fetchResultRecord())
	    {
        	$result_arr[$inc]['record']=$row;
        	$result_arr[$inc]['photo_id'] = $row['photo_id'];
        	$photo_name = getphotoName($row['photo_id']);
	        $result_arr[$inc]['img_src'] = $row['photo_server_url'] . $photos_folder .$photo_name.'T.'.$row['photo_ext'];
	        $result_arr[$inc]['t_width'] = $row['t_width'];
	        $result_arr[$inc]['t_height'] = $row['t_height'];
	        $result_arr[$inc]['zoom_img_src'] = $row['photo_server_url'] . $photos_folder .$photo_name.'L.'.$row['photo_ext'];
	        $result_arr[$inc]['photo_title_word_wrap'] = $row['photo_title'];
	        $result_arr[$inc]['photo_title_word_wrap_js'] = addslashes($result_arr[$inc]['photo_title_word_wrap']);
	        $result_arr[$inc]['viewphoto_url'] = getUrl('viewphoto', '?photo_id='.$row['photo_id'].'&title='.$this->changeTitle($row['photo_title']), $row['photo_id'].'/'.$this->changeTitle($row['photo_title']).'/', '', 'photo');
	        $result_arr[$inc]['tagged_user_name'] = $row['user_name'];
	        $result_arr[$inc]['memberProfileUrl'] = getMemberProfileUrl($row['tagged_by_user_id'], $row['user_name']);
			//Code to check whether values in other_tag_users is user name or tag name and redirect to corresponding page based on tag type
	        if(!empty($row['tag_by_people']))
	        {
	        	$tagged_by_href = array();
	        	$tag_users = explode(',', $row['tag_by_people']);
	        	foreach($tag_users as $tag_key => $tag_value)
				{
					$tag = explode('~', $tag_value);
					if($tag[0] != 0)
					{
						if($this->chkValidUser($tag[1]))
						{
							$tagged_by_href[$tag_key]['viewlink'] = getUrl('peopleonphoto','?tagged_by='.$this->CFG['user']['user_name'].'&block=me&people='.$tag[1], '?tagged_by='.$this->CFG['user']['user_name'].'&block=me&people='.$tag[1],'','photo');
							$tagged_by_href[$tag_key]['tagname'] = $tag[1];
						}
						else
						{
							$tagged_by_href[$tag_key]['viewlink'] = getUrl('peopleonphoto','?tagged_by='.$this->CFG['user']['user_name'].'&block=me&tag_name='.$tag[1], '?tagged_by='.$this->CFG['user']['user_name'].'&block=me&tag_name='.$tag[1],'','photo');
							$tagged_by_href[$tag_key]['tagname'] = $tag[1];
						}
					}
					else
					{
						$tagged_by_href[$tag_key]['viewlink'] = getUrl('peopleonphoto','?tagged_by='.$this->CFG['user']['user_name'].'&block=me&tag_name='.$tag[1], '?tagged_by='.$this->CFG['user']['user_name'].'&block=me&tag_name='.$tag[1],'','photo');
						$tagged_by_href[$tag_key]['tagname'] = $tag[1];
					}

					//Condition to highlight the searching tags
					if($tag[1] == $this->getFormField('people') || $tag[1] == $this->getFormField('tag_name'))
					{
						$search_word = $tag[1];
						$tagged_by_href[$tag_key]['tagname'] = highlightWords($tagged_by_href[$tag_key]['tagname'], $search_word);
					}
					//Condition to add comma separtor next each tag names
					if($tag_key < count($tag_users)-1)
						$tagged_by_href[$tag_key]['tagname'].= ',';

				}
				$result_arr[$inc]['tagged_by_href'] = $tagged_by_href;
			}

			//Condition to split the tagged users and assign link to each user to redirect to corresponding profile page
			if(!empty($row['tag_by_users']))
			{
				$tag_by_profile_url = array();
				$search_word = '';
				$tag_by_users = explode(',', $row['tag_by_users']);
				foreach($tag_by_users as $tag_key => $tag_value)
				{
					$tag_user = explode('~', $tag_value);
					$tag_by_profile_url[$tag_key]['viewlink'] = getMemberProfileUrl($tag_user[0], $tag_user[1]);
					$tag_by_profile_url[$tag_key]['tagname'] = $tag_user[1];

					if($tag_user[1] == $this->getFormField('tag_name'))
					{
						$search_word = $tag_user[1];
						$tag_by_profile_url[$tag_key]['tagname'] = highlightWords($tag_by_profile_url[$tag_key]['tagname'], $search_word);
					}

					//Condition to highlight the searching tags
					if($tag_user[1] == $this->getFormField('people') || $tag_user[1] == $this->getFormField('tag_name'))
					{
						$search_word = $tag_user[1];
						$tag_by_profile_url[$tag_key]['tagname'] = highlightWords($tag_by_profile_url[$tag_key]['tagname'], $search_word);
					}


					//Condition to add comma separtor next each tagged by names
					if($tag_key < count($tag_by_users)-1)
						$tag_by_profile_url[$tag_key]['tagname'].= ',';
				}
				$result_arr[$inc]['tag_by_profile_url'] = $tag_by_profile_url;
			}

			//Code to check whether each tag value is user name or tag name and redirect to corresponding page based on tag type
	        if(!empty($row['all_tags']))
	        {
	        	$all_tag_href = array();
	        	$all_tags = explode(',', $row['all_tags']);
	        	foreach($all_tags as $all_tag_key => $all_tag_value)
				{
					$tag = explode('~', $all_tag_value);
					if($tag[0] != 0)
					{
						if($this->chkValidUser($tag[1]))
						{
							$all_tag_href[$all_tag_key]['viewlink'] = getUrl('peopleonphoto','?tag=all&block=all&people='.$tag[1], '?tag=all&block=all&people='.$tag[1],'','photo');
							$all_tag_href[$all_tag_key]['tagname'] = $tag[1];
						}
						else
						{
							$all_tag_href[$all_tag_key]['viewlink'] = getUrl('peopleonphoto','?tag=all&block=all&tag_name='.$tag[1], '?tag=all&block=all&tag_name='.$tag[1],'','photo');
							$all_tag_href[$all_tag_key]['tagname'] = $tag[1];
						}
					}
					else
					{
						$all_tag_href[$all_tag_key]['viewlink'] = getUrl('peopleonphoto','?tag=all&block=all&tag_name='.$tag[1], '?tag=all&block=all&tag_name='.$tag[1],'','photo');
						$all_tag_href[$all_tag_key]['tagname'] = $tag[1];
					}

					//Condition to highlight the searching tags
					if($tag[1] == $this->getFormField('people') || $tag[1] == $this->getFormField('tag_name'))
					{
						$search_word = $tag[1];
						$all_tag_href[$all_tag_key]['tagname'] = highlightWords($all_tag_href[$all_tag_key]['tagname'], $search_word);
					}

					//Condition to add comma separtor next each tag names
					if($all_tag_key < count($all_tags)-1)
						$all_tag_href[$all_tag_key]['tagname'].= ',';


				}

				$result_arr[$inc]['all_tag_href'] = $all_tag_href;
			}

			//Condition to split the tagged users and assign link to each user to redirect to corresponding profile page
			if(!empty($row['photo_tagged_users']))
			{
				$tag_user_profile_url = array();
				$search_word = '';
				$tagged_users = explode(',', $row['photo_tagged_users']);
				foreach($tagged_users as $tagged_key => $tagged_value)
				{
					$tag_user = explode('~', $tagged_value);
					$tag_user_profile_url[$tagged_key]['viewlink'] = getMemberProfileUrl($tag_user[0], $tag_user[1]);
					$tag_user_profile_url[$tagged_key]['tagname'] = $tag_user[1];

					//Condition to highlight the searching tags
					if($tag_user[1] == $this->getFormField('tag_name') || $tag_user[1] == $this->getFormField('people'))
					{
						$search_word = $tag_user[1];
						$tag_user_profile_url[$tagged_key]['tagname'] = highlightWords($tag_user_profile_url[$tagged_key]['tagname'], $search_word);
					}

					//Condition to add comma separtor next each tagged by names
					if($tagged_key < count($tagged_users)-1)
						$tag_user_profile_url[$tagged_key]['tagname'].= ',';
				}
				$result_arr[$inc]['tag_user_profile_url'] = $tag_user_profile_url;
			}

			//Code to check whether each tag value is user name or tag name and redirect to corresponding page based on tag type
	         if(!empty($row['tag_of_people']))
	        {
	        	$search_word= '';
	        	$tagged_of_href = array();
	        	$tag_users = explode(',', $row['tag_of_people']);
	        	foreach($tag_users as $tag_key => $tag_value)
				{
					$tag = explode('~', $tag_value);
					if($tag[0] != 0)
					{
						if($this->chkValidUser($tag[1]))
						{
							$tagged_of_href[$tag_key]['viewlink'] = getUrl('peopleonphoto','?tagged_of='.$this->CFG['user']['user_name'].'&block=of&people='.$tag[1], '?tagged_of='.$this->CFG['user']['user_name'].'&block=of&people='.$tag[1],'','photo');
							$tagged_of_href[$tag_key]['tagname'] = $tag[1];
						}
						else
						{
							$tagged_of_href[$tag_key]['viewlink'] = getUrl('peopleonphoto','?tagged_of='.$this->CFG['user']['user_name'].'&block=of&tag_name='.$tag[1], '?tagged_of='.$this->CFG['user']['user_name'].'&block=of&tag_name='.$tag[1],'','photo');
							$tagged_of_href[$tag_key]['tagname'] = $tag[1];
						}
					}
					else
					{
						$tagged_of_href[$tag_key]['viewlink'] = getUrl('peopleonphoto','?tagged_of='.$this->CFG['user']['user_name'].'&block=of&tag_name='.$tag[1], '?tagged_of='.$this->CFG['user']['user_name'].'&block=of&tag_name='.$tag[1],'','photo');
						$tagged_of_href[$tag_key]['tagname'] = $tag[1];
					}

					//Condition to highlight the searching tags
					if($tag[1] == $this->getFormField('people') || $tag[1] == $this->getFormField('tag_name'))
					{
						$search_word = $tag[1];
						$tagged_of_href[$tag_key]['tagname'] = highlightWords($tagged_of_href[$tag_key]['tagname'], $search_word);
					}

					//Condition to add comma separtor next each tag names
					if($tag_key < count($tag_users)-1)
						$tagged_of_href[$tag_key]['tagname'].= ',';

				}
				$result_arr[$inc]['tagged_of_href'] = $tagged_of_href;
			}

			//Condition to split the tagged users and assign link to each user to redirect to corresponding profile page
			if(!empty($row['tag_of_users']))
			{
				$tag_of_profile_url = array();
				$tag_of_users = explode(',', $row['tag_of_users']);
				foreach($tag_of_users as $tag_key => $tag_value)
				{
					$tag_user = explode('~', $tag_value);
					$tag_of_profile_url[$tag_key]['viewlink'] = getMemberProfileUrl($tag_user[0], $tag_user[1]);
					$tag_of_profile_url[$tag_key]['tagname'] = $tag_user[1];

					//Condition to highlight the searching tags
					if($tag_user[1] == $this->getFormField('tag_name') || $tag_user[1] == $this->getFormField('people'))
					{
						$search_word = $tag_user[1];
						$tag_of_profile_url[$tag_key]['tagname'] = highlightWords($tag_of_profile_url[$tag_key]['tagname'], $search_word);
					}

					//Condition to add comma separtor next each tagged by names
					if($tag_key < count($tag_of_users)-1)
						$tag_of_profile_url[$tag_key]['tagname'].= ',';
				}
				$result_arr[$inc]['tag_of_profile_url'] = $tag_of_profile_url;
			}

	        $this->isResultsFound=true;
	        $inc++;
        }
        $smartyObj->assign('photo_list_result', $result_arr);
    }
}
$peopleonphoto=new peopleOnPhoto();
if (!chkAllowedModule(array('photo')))
    Redirect2URL($CFG['redirect']['dsabled_module_url']);

$peopleonphoto->setPageBlockNames(array('block_photo_list','block_no_photos_msg','block_error_msg'));
$peopleonphoto->setAllPageBlocksHide();
$peopleonphoto->setFormField('start', 0);
$peopleonphoto->setFormField('numpg', $CFG['photo_tbl']['numpg']);
$peopleonphoto->setFormField('slno', '1');
$peopleonphoto->setFormField('people', '');
$peopleonphoto->setFormField('tag_name', '');
$peopleonphoto->setFormField('tagged_by', '');
$peopleonphoto->setFormField('tagged_of', '');
$peopleonphoto->setFormField('tag_type', '');
$peopleonphoto->setFormField('tag', '');
$peopleonphoto->setFormField('user_id', '');
$peopleonphoto->setFormField('adv_user_id', '');
$peopleonphoto->setFormField('advanced_people_name', '');
$peopleonphoto->setFormField('advanced_tag_by_user', '');
$peopleonphoto->setFormField('adv_people_name', '');
$peopleonphoto->setFormField('adv_tag_by_user', '');
$peopleonphoto->setFormField('advanceFromSubmission', '');
$peopleonphoto->recordsFound = false;
$peopleonphoto->setMinRecordSelectLimit($CFG['data_tbl']['min_record_select_limit']);
$peopleonphoto->setMaxRecordSelectLimit($CFG['data_tbl']['max_record_select_limit']);
$peopleonphoto->setNumPerPageListArr($CFG['data_tbl']['numperpage_list_arr']);
$peopleonphoto->setTableNames(array());
$peopleonphoto->setReturnColumns(array());
$peopleonphoto->sanitizeFormInputs($_REQUEST);
$peopleonphoto->pageTitle=$LANG['peopleonphoto_title'];

$peopleonphoto->isValidPage=false;

//Condition to reset the fields exist in both query string and search fields and redirect to corresponding page
if($peopleonphoto->getFormField('tagged_of'))
	$photoTagsRedirectUrl = getUrl('peopleonphoto','?tagged_of='.$CFG['user']['user_name'].'&block=of', '?tagged_of='.$CFG['user']['user_name'].'&block=of','','photo');
elseif($peopleonphoto->getFormField('tagged_by'))
	$photoTagsRedirectUrl = getUrl('peopleonphoto','?tagged_by='.$CFG['user']['user_name'].'&block=me', '?tagged_by='.$CFG['user']['user_name'].'&block=me','','photo');
else
	$photoTagsRedirectUrl = getUrl('peopleonphoto','?tag=all&block=all', '?tag=all&block=all','','photo');
$smartyObj->assign('photoTagsRedirectUrl', $photoTagsRedirectUrl);

/* Commented condition used to display photo tags based on people name and tagname and redirected to below tag type condition
if($peopleonphoto->getFormField('people'))
{
  $peopleonphoto->setFormField('tag_type', 'people');
  if($user_id=$peopleonphoto->chkValidUserName($peopleonphoto->getFormField('tag_type')))
    {
    $peopleonphoto->setFormField('user_id', $user_id);
    $peopleonphoto->setTableAndColumns();
	$peopleonphoto->buildSelectQuery();
	$peopleonphoto->buildQuery();
	//$peopleonphoto->printQuery();
	$peopleonphoto->executeQuery();
	$peopleonphoto->isValidPage=true;
    }
   $peopleonphoto->pageTitle= str_replace('{user}','"'.$peopleonphoto->getFormField('people').'"',$LANG['peopleonphoto_user_on_photos']);
    $paging_arr = array('start','people');
    $smartyObj->assign('paging_arr',$paging_arr);
    $smartyObj->assign('smarty_paging_list', $peopleonphoto->populatePageLinksPOST($peopleonphoto->getFormField('start'),'peopleOnPhotoForm'));

}
elseif($peopleonphoto->getFormField('tag_name'))
{
    $peopleonphoto->setFormField('tag_type', 'tag_name');
    $peopleonphoto->setTableAndColumns();
	$peopleonphoto->buildSelectQuery();
	$peopleonphoto->buildQuery();
	//$peopleonphoto->printQuery();
	$peopleonphoto->executeQuery();
	$peopleonphoto->isValidPage=true;
    $peopleonphoto->pageTitle= str_replace('{tags}','"'.$peopleonphoto->getFormField('tag_name').'"',$LANG['peopleonphoto_tags_on_photos']);
    $paging_arr = array('start','tag_name');
    $smartyObj->assign('paging_arr',$paging_arr);
    $smartyObj->assign('smarty_paging_list', $peopleonphoto->populatePageLinksPOST($peopleonphoto->getFormField('start'),'peopleOnPhotoForm'));
}
*/
if($peopleonphoto->getFormField('tagged_by'))
{
    $peopleonphoto->setFormField('tag_type', 'tagged_by');

    if($peopleonphoto->isFormPOSTed($_POST, 'avd_search'))
	{
		$peopleonphoto->setFormField('advan_people_name', $peopleonphoto->getFormField('advanced_people_name'));
		$peopleonphoto->setFormField('people', $peopleonphoto->getFormField('advan_people_name'));

	}

    if($user_id=$peopleonphoto->chkValidUserName($peopleonphoto->getFormField('tag_type')))
    {
    	$peopleonphoto->setFormField('user_id', $user_id);
	    $peopleonphoto->setTableAndColumns();
		$peopleonphoto->buildSelectQuery();
		$peopleonphoto->buildQuery();
		//$peopleonphoto->printQuery();
		$peopleonphoto->homeExecuteQuery();
		$peopleonphoto->isValidPage=true;
	}
	if($peopleonphoto->getFormField('people') && $peopleonphoto->getFormField('people') != $LANG['peopleonphoto_search_people_name'])
		$peopleonphoto->pageTitle= str_replace('{tagname}','"'.$peopleonphoto->getFormField('people').'"',$LANG['peopleonphoto_photos_tagged_with_tagname']);
	elseif($peopleonphoto->getFormField('tag_name') && $peopleonphoto->getFormField('tag_name') != $LANG['peopleonphoto_search_tagged_by'])
		$peopleonphoto->pageTitle= str_replace('{tagname}','"'.$peopleonphoto->getFormField('tag_name').'"',$LANG['peopleonphoto_photos_tagged_with_tagname']);
	else
    	$peopleonphoto->pageTitle= str_replace('{user}','"'.$peopleonphoto->getFormField('tagged_by').'"',$LANG['peopleonphoto_tagged_by_user_on_photos']);
    $paging_arr = array('start','tagged_by', 'people');
    $smartyObj->assign('paging_arr',$paging_arr);
    $smartyObj->assign('smarty_paging_list', $peopleonphoto->populatePageLinksPOST($peopleonphoto->getFormField('start'),'peopleOnPhotoForm'));
}
elseif($peopleonphoto->getFormField('tag'))
{
	if($peopleonphoto->getFormField('people'))
	{
		$peopleonphoto->setFormField('tag_type', 'people');
		if($user_id=$peopleonphoto->chkValidUserName($peopleonphoto->getFormField('tag_type')))
    		$peopleonphoto->setFormField('adv_user_id', $user_id);
	}
	if($peopleonphoto->isFormPOSTed($_POST, 'avd_search'))
	{
		$peopleonphoto->setFormField('advan_people_name', $peopleonphoto->getFormField('advanced_people_name'));
		$peopleonphoto->setFormField('people', $peopleonphoto->getFormField('advan_people_name'));
		$peopleonphoto->setFormField('advan_tag_by_user', $peopleonphoto->getFormField('advanced_tag_by_user'));
		$peopleonphoto->setFormField('tag_name', $peopleonphoto->getFormField('advan_tag_by_user'));
		$peopleonphoto->setFormField('tag_type', 'advan_tag_by_user');
		if($user_id=$peopleonphoto->chkValidUserName($peopleonphoto->getFormField('tag_type')))
    		$peopleonphoto->setFormField('adv_user_id', $user_id);
	}
    $peopleonphoto->setFormField('tag_type', 'tag');
    $peopleonphoto->setTableAndColumns();
	$peopleonphoto->buildSelectQuery();
	$peopleonphoto->buildQuery();
	//$peopleonphoto->printQuery();
	$peopleonphoto->homeExecuteQuery();
	$peopleonphoto->isValidPage=true;

	if($peopleonphoto->getFormField('people') && $peopleonphoto->getFormField('people') != $LANG['peopleonphoto_search_people_name'])
		$peopleonphoto->pageTitle= str_replace('{tagname}','"'.$peopleonphoto->getFormField('people').'"',$LANG['peopleonphoto_photos_tagged_with_tagname']);
	elseif($peopleonphoto->getFormField('tag_name') && $peopleonphoto->getFormField('tag_name') != $LANG['peopleonphoto_search_tagged_by'])
		$peopleonphoto->pageTitle= str_replace('{tagname}','"'.$peopleonphoto->getFormField('tag_name').'"',$LANG['peopleonphoto_photos_tagged_with_tagname']);
	else
    	$peopleonphoto->pageTitle= $LANG['peopleonphoto_all_tags'];

    $paging_arr = array('start','tag', 'people', 'tag_name', 'adv_user_id');
    $smartyObj->assign('paging_arr',$paging_arr);
    $smartyObj->assign('smarty_paging_list', $peopleonphoto->populatePageLinksPOST($peopleonphoto->getFormField('start'),'peopleOnPhotoForm'));
}
elseif($peopleonphoto->getFormField('tagged_of'))
{

    if($peopleonphoto->isFormPOSTed($_POST, 'avd_search'))
	{
		$peopleonphoto->setFormField('advan_tag_by_user', $peopleonphoto->getFormField('advanced_tag_by_user'));
		$peopleonphoto->setFormField('tag_name', $peopleonphoto->getFormField('advan_tag_by_user'));
		$peopleonphoto->setFormField('tag_type', 'advan_tag_by_user');
		if($user_id=$peopleonphoto->chkValidUserName($peopleonphoto->getFormField('tag_type')))
    		$peopleonphoto->setFormField('adv_user_id', $user_id);
	}

	$peopleonphoto->setFormField('tag_type', 'tagged_of');
    if($user_id=$peopleonphoto->chkValidUserName($peopleonphoto->getFormField('tag_type')))
    {
    	$peopleonphoto->setFormField('user_id', $user_id);
	    $peopleonphoto->setTableAndColumns();
		$peopleonphoto->buildSelectQuery();
		$peopleonphoto->buildQuery();
		//$peopleonphoto->printQuery();
		$peopleonphoto->homeExecuteQuery();
		$peopleonphoto->isValidPage=true;
	}

	if($peopleonphoto->getFormField('people') && $peopleonphoto->getFormField('people') != $LANG['peopleonphoto_search_people_name'])
		$peopleonphoto->pageTitle= str_replace('{tagname}','"'.$peopleonphoto->getFormField('people').'"',$LANG['peopleonphoto_photos_tagged_with_tagname']);
	elseif($peopleonphoto->getFormField('tag_name') && $peopleonphoto->getFormField('tag_name') != $LANG['peopleonphoto_search_tagged_by'])
		$peopleonphoto->pageTitle= str_replace('{tagname}','"'.$peopleonphoto->getFormField('tag_name').'"',$LANG['peopleonphoto_photos_tagged_with_tagname']);
	else

    $peopleonphoto->pageTitle= str_replace('{user}','"'.$peopleonphoto->getFormField('tagged_of').'"',$LANG['peopleonphoto_tagged_of_user_on_photos']);
    $paging_arr = array('start','tagged_of', 'tag_name');
    $smartyObj->assign('paging_arr',$paging_arr);
    $smartyObj->assign('smarty_paging_list', $peopleonphoto->populatePageLinksPOST($peopleonphoto->getFormField('start'),'peopleOnPhotoForm'));
}


if($peopleonphoto->isValidPage)
{
	if($peopleonphoto->isResultsFound())
	  {
	    $peopleonphoto->showPhotoList();
		$peopleonphoto->setPageBlockShow('block_photo_list');
	  }
	else
	   $peopleonphoto->setPageBlockShow('block_no_photos_msg');
}
else
{
  $peopleonphoto->pageTitle=$LANG['peopleonphoto_title'];
  $peopleonphoto->setPageBlockShow('block_error_msg');
}
 $peopleonphoto->pageTitle = html_entity_decode($peopleonphoto->pageTitle);
$peopleonphoto->includeHeader();
setTemplateFolder('general/', 'photo');
$smartyObj->display('peopleOnPhoto.tpl');
?>
<script type="text/javascript" language="javascript">
var form_name_array = new Array('searchAdvancedFilter');

function clearValue(id)
{
	$Jq('#'+id).val('');
}
function setOldValue(id)
{
	if (($Jq('#'+id).val()=="") && (id == 'advanced_people_name') )
		$Jq('#'+id).val('<?php echo $LANG['peopleonphoto_search_people_name']?>');
	if (($Jq('#'+id).val()=="") && (id == 'advanced_tag_by_user') )
		$Jq('#'+id).val('<?php echo $LANG['peopleonphoto_search_tagged_by']?>');
}
</script>
<?php
$peopleonphoto->includeFooter();
?>