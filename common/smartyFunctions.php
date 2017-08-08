<?php
if(class_exists('Smarty'))
	{
		$smartyObj = new Smarty();
		$smartyObj->Smarty();
        $smartyObj->cache_dir    = 'cache/';
        $smartyObj->caching = $CFG['feature']['smarty_caching'];
		$smartyObj->cache_lifetime = $CFG['feature']['smarty_caching_life_time'];
        $smartyObj->assign('tabindex', 995);
		$smartyObj->register_function('smartyTabIndex', 'smartyTabIndex');
		$smartyObj->register_function('getCurrentUrl', 'getCurrentUrl');
		$smartyObj->register_function('hpSolutionsRayzz', 'hpSolutionsRayzz');
		$smartyObj->register_function('isAjax', 'isAjax');
		$smartyObj->assign('_SERVER', $_SERVER);
		$smartyObj->error_reporting = $CFG['smarty']['error_reporting'];
		$smartyObj->assign('true', '1');
		$smartyObj->assign('false', '0');
	}

function smartyTabIndex($params)
	{
		global $smartyObj;
		return $smartyObj->_tpl_vars['tabindex'] += 5;
	}

function getTplFolder()
    {
         global $CFG;
		 if(strstr($CFG['site']['relative_url'], 'admin') and isAdmin())
		 	{
				return 'admin/';
			}
		 if(strstr($CFG['site']['relative_url'], 'members') and isMember())
		 	{
				return 'members/';
			}
		return 'root/';
	}

function getMultiTimensionalArrayBasedKeyAndValue($array)
	{
		$ret_array = array();
		$i = 0;
		foreach($array as $key=>$value)
			{
				$ret_array[$i]['key'] = $key;
				$ret_array[$i]['value'] = $value;
				$i++;
			}
		return $ret_array;
	}
?>