<?php
/**
 * IndexPageNewPeopleHandler
 *
 * @package
 * @author edwin_90ag08
 * @copyright Copyright (c) 2008 {@link http://www.mediabox.uz Uzdc Infoway}
 * @version $Id$
 * @access public
 */
class IndexPageNewPeopleHandler extends MediaHandler
	{
		/**
		 * IndexPageNewPeopleHandler::getProfileHits()
		 *
		 * @param string $user_id
		 * @return
		 */
		public function getProfileHits($user_id='')
			{
				$sql ='SELECT SUM(total_views) count FROM '.$this->CFG['db']['tbl']['users_views'].
						' WHERE user_id='.$this->dbObj->Param($user_id);
            	$stmt = $this->dbObj->Prepare($sql);
            	$rs = $this->dbObj->Execute($stmt, array($user_id));
                if (!$rs)
            	    trigger_db_error($this->dbObj);

				$row = $rs->FetchRow();
				return ($row['count'])?$row['count']:'0';
			}

	  	/**
	  	 * IndexPageNewPeopleHandler::displayNewMembers()
	  	 *
	  	 * @return
	  	 */
	  	public function displayNewMembers()
			{
				$total_people = $this->CFG['admin']['member']['cool_new_people_total_record'];

				$sql = 'SELECT user_id, user_name, first_name,last_name,profile_hits, total_videos,  icon_id, icon_type, image_ext,  sex, age, country, city'.
						' FROM '.$this->CFG['db']['tbl']['users'].
						' WHERE usr_status=\'Ok\''.
						' ORDER BY doj DESC LIMIT '.$total_people;

	            $stmt = $this->dbObj->Prepare($sql);
    	        $rs = $this->dbObj->Execute($stmt);
                if (!$rs)
            	    trigger_db_error($this->dbObj);

				$member_list_arr = array();
				$inc = 0;
				if ($rs->PO_RecordCount()>0)
			    	{
						//$rayzzObj = new RayzzHandler($this->dbObj, $this->CFG);
			        	$count = $baloon = 0;
						while($row = $rs->FetchRow())
				            {
								$count++;
								$name = getUserDisplayName($row);
								$icon = getMemberAvatarDetails($row['icon_id']);

								$member_list_arr[$inc]['record']=$row;
								$member_list_arr[$inc]['icon']=$icon;
								if(chkAllowedModule(array('video')))
									{
										$member_list_arr[$inc]['videoListUrl']= getUrl('videolist','?pg=uservideolist&user_id='.$row['user_id'], 'uservideolist/?user_id='.$row['user_id']);
									}
								$member_list_arr[$inc]['memberslistUrl']=getUrl('memberslist','?browse=viewedusers&user_id='.$row['user_id'],'?browse=viewedusers&user_id='.$row['user_id']);
								$member_list_arr[$inc]['ProfileHits']=$this->getProfileHits($row['user_id']);
								$member_list_arr[$inc]['MemberProfileUrl']=getMemberProfileUrl($row['user_id'], $row['user_name']);
								$member_list_arr[$inc]['baloon']=$baloon;
								$member_list_arr[$inc]['name']=$name;
								$member_list_arr[$inc]['wrap_name']=wordWrap_mb_Manual($name, $this->CFG['admin']['index_page_user_name_length']);
								$baloon++;
								$inc++;
			            	} // while
				    	$this->count_value=$count;
				        $this->baloon_value=$baloon;
				        $this->userdetailUrl=getUrl('userdetail');
				        $this->membersAllUrl=getUrl('memberslist');
				        if($count)
					 		{
						  		$this->baloon_value=$this->baloon_value-1;
						 	}
						return $member_list_arr;
			    	}
			    return 0;
			}
	}
//-------------------- Code begins -------------->>>>>//
$newPeopleIndex = new IndexPageNewPeopleHandler();
$newPeopleIndex->peopleList_arr=$newPeopleIndex->displayNewMembers();
//<<<<--------------------Code Ends----------------------//

//--------------------Page block templates begins-------------------->>>>>//
//Assigning Carousel values to variable
if($newPeopleIndex->peopleList_arr)
	{
		$carousel_list = 'var mycarousel_itemList = [';
		foreach($newPeopleIndex->peopleList_arr as $key=>$value)
			{
				$carousel_list .= '{memUrl:\''.$value['MemberProfileUrl'].'\', wrap_name:\''.$value['wrap_name'].'\', url:\''.$value['icon']['t_url'].'\', alt:\''.$value['record']['user_name'].'\', title: \''.$value['name'].'\'}';
				if((count($newPeopleIndex->peopleList_arr)-1) != $key)
					$carousel_list .= ',';
			}
		$carousel_list .= '];';
	}
//<<<<--------------------Code Ends----------------------//

//--------------------Page block templates begins-------------------->>>>>//

//assign smarty object
$smartyObj->assign('carousel_items_list',$carousel_list);
//assign smarty object
$smartyObj->assign('LANG',$LANG);
$smartyObj->assign('newPeopleIndexObj',$newPeopleIndex);
?>