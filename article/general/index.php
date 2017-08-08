<?php
//--------------class ArticleIndexPageHandler--------------->>>//
/**
 * This class is used to list article index page
 *
 * @category	Rayzz
 * @package		manage article imdex
 * @copyright 	Copyright (c) 2008 {@link http://www.mediabox.uz Uzdc Infoway}
 */
class ArticleIndexPageHandler extends ArticleHandler
{

		/**
		 * ArticleIndexPageHandler::topWritters()
		 *
		 * @return
		 */
		public function topWritters()
			{
				populateArticleTopWritters();
			}

		/**
		 * ArticleIndexPageHandler::myHomeActivity()
		 *
		 * @return void
		 */
		public function myHomeActivity()
			{
				global $smartyObj;
				setTemplateFolder('members/');
				$smartyObj->display('myHomeActivity.tpl');
			}

		/**
		 * ArticleIndexPageHandler::getPageTitle()
		 *
		 * @return string
		 */
		public function getPageTitle()
		{
			$pg_title = $this->LANG['index_articlelist_title'];

			switch($this->fields_arr['pg'])
			{

				case 'articlerecent':
					$pg_title = $this->LANG['index_articlerecent_title'];
					break;

				case 'articletoprated':
					$pg_title = $this->LANG['index_articletoprated_title'];
					break;

				case 'articlemostviewed':
					$pg_title = $this->LANG['index_articlemostviewed_title'];
					break;

				case 'articlemostdiscussed':
					$pg_title = $this->LANG['index_articlemostdiscussed_title'];
					break;

				case 'articlemostfavorite':
					$pg_title = $this->LANG['index_articlemostfavorite_title'];
					break;

			}

			return $pg_title;
		}

		public function populateRatingDetails($rating)
		{
			$rating = round($rating,0);
			return $rating;
		}





}
$articleindex = new ArticleIndexPageHandler();
if(!chkAllowedModule(array('article')))
	Redirect2URL($CFG['redirect']['dsabled_module_url']);

$articleindex->setPageBlockNames(array('sidebar_topcontributors_block', 'sidebar_activity_block'));

$articleindex->setAllPageBlocksHide();
//$articleindex->setMediaPath('../../');
$articleindex->setFormField('start', '0');
$articleindex->setFormField('block', '');
$articleindex->setFormField('activity_type', '');
$articleindex->setFormField('pg', '');
$articleindex->setPageBlockShow('sidebar_topcontributors_block');// TOP CONTRIBUTORS //
$articleindex->sanitizeFormInputs($_REQUEST);
$articleindex->LANG['index_articlelist_title'] = $articleindex->getPageTitle();

//Condition to display index article list
if($articleindex->getFormField('pg') && $articleindex->getFormField('pg')!= '')
	$articleindex->populateCarousalarticleBlock($articleindex->getFormField('pg'),$articleindex->getFormField('start'));
else
	$articleindex->populateCarousalarticleBlock('articlerecent',$articleindex->getFormField('start'));

if(!isAjaxPage())
{
	if(isMember())
	{
		$articleindex->setPageBlockShow('sidebar_activity_block');
	}
}
else
{
	$articleindex->sanitizeFormInputs($_REQUEST);
	$articleindex->includeAjaxHeaderSessionCheck();
	if($articleindex->getFormField('activity_type')!= '')
	{
		if($articleindex->getFormField('activity_type') == 'Friends' and !$articleindex->getTotalFriends($CFG['user']['user_id']))
		{
			echo '<div class="clsNoRecordsFound">'.$LANG['index_activities_no_friends'].'</div>';
			exit;
		}
		$activity_view_all_url = getUrl('activity', '?pg='.strtolower($articleindex->getFormField('activity_type')), strtolower($articleindex->getFormField('activity_type')).'/updates/', '');
		$smartyObj->assign('activity_view_all_url', $activity_view_all_url);
		$Activity = new ActivityHandler();
		$Activity->setActivityType(strtolower($articleindex->getFormField('activity_type')), 'article');
		$articleindex->myHomeActivity();
	}
	$articleindex->includeAjaxFooter();
	die();
}

$articleindex->includeHeader();
?>
<script type="text/javascript">
	var Image_Url = "<?php echo $CFG['site']['article_url'].'design/templates/'.$CFG['html']['template']['default'].'/root/images/'?>";
</script>
<?php
setTemplateFolder('general/',$CFG['site']['is_module_page']);
$smartyObj->display('index.tpl');
?>
<script type="text/javascript" src="<?php echo $CFG['site']['project_path_relative'];?>js/AG_ajax_html.js"></script>
<script type="text/javascript" >
//This is important for carosel//
var module_name_js = "article";
var article_activity_array = new Array('My', 'Friends', 'All');
var article_index_ajax_url = '<?php echo $CFG['site']['article_url'].'index.php';?>';
var form_name_array = new Array('articleListIndexForm');
var block_arr= new Array('selMsgConfirm', 'selMsgConfirmMulti', 'selEditarticleComments');
function loadUrl(element)
{
	document.articleListIndexForm.action=element.value;
	document.articleListIndexForm.submit();
}
// ARTICLE ACTIVITY DEFAULT SETTING //
<?php
if(isMember())
{
?>
	loadActivitySetting('<?php echo $CFG['admin']['articles']['article_activity_default_content'];?>');
<?php
}
?>
</script>
<?php
$articleindex->includeFooter();
?>