<?php
//-------------- Class WidgetFormHandler begins --------------->>>>>//
/**
 * To generate widgets
 *
 * PHP version 5.0
 *
 * @category	Discuzz
 * @package		WidgetFormHandler
 * @author 		shankar_76ag08
 * @copyright	Copyright (c) 2009 - 2010 {@link http://www.mediabox.uz Uzdc Infoway}
 * @license		http://www.mediabox.uz Uzdc Infoway Licence
 * @version		SVN: $Id:  $
 * @since 		2008-12-19
 */
class WidgetFormHandler extends ListRecordsHandler
	{

		protected $widget_type_array;

		protected $widget_board_array;

		public $paging_arr;

		/**
		 * WidgetFormHandler::setTableAndColumns()
		 *
		 * @return
		 */
		public function setTableAndColumns()
			{

				 $this->setTableNames(array($this->CFG['db']['tbl']['boards']. ' As q' , $this->CFG['db']['tbl']['users']. ' As u'));
				 $this->setReturnColumns(array( 'board','seo_title', 'status', 'u.'.getUserTableField('user_id').' AS user_id', 'u.'.getUserTableField('user_status').' AS user_status', 'q.user_id' ));
 		    }

		/**
		 * WidgetFormHandler::buildConditionQuery()
		 *
		 * @return
		 */
		public function buildConditionQuery()
			{
				// Based on folder name filtering the records for board Views.
				//condition for recent to be done
				$this->sql_condition = ' u.'.getUserTableField('user_id').' = q.user_id AND u.'.getUserTableField('user_status').' = \'Ok\' AND status = \'Active\'';
				if($this->getFormField('folder') == 'Popular' )
					$this->sql_condition .='';
				elseif($this->getFormField('folder') == 'my')
					{
						$this->sql_condition .=' AND q.user_id = '.$this->getFormField('uid');
					}
			}

		/**
		 * WidgetFormHandler::buildSortQuery()
		 *
		 * @return
		 */
		public function buildSortQuery()
			{
				if($this->getFormField('folder') == 'Popular' )
					$this->sql_sort = 'total_views DESC';
				elseif($this->getFormField('folder') == 'Recent')
					$this->sql_sort = ' board_added DESC';
				else
					$this->sql_sort = 'board_id DESC';
			}

		/**
		 * WidgetFormHandler::widget_type_array()
		 *
		 * @param mixed $widget_type_array
		 * @param array $first_option_arr
		 * @return
		 */
		public function widget_type_array($widget_type_array, $first_option_arr=array())
			{
				$this->widget_type_array = $first_option_arr + $widget_type_array;
			}

		/**
		 * WidgetFormHandler::widget_board_array()
		 *
		 * @param mixed $widget_board_array
		 * @param array $first_option_arr
		 * @return
		 */
		public function widget_board_array($widget_board_array, $first_option_arr=array())
			{
				$this->widget_board_array = $first_option_arr + $widget_board_array;
			}

		/**
		 * WidgetFormHandler::includeAjaxHeader()
		 *
		 * @param mixed $assign_var
		 * @return
		 */
		public function includeAjaxHeader($assign_var = true)
			{
				global $CFG, $smartyObj;
				if($assign_var)
					{
						$this->assignSmartyVariables();
					}
			}
	}
//-------------------- Code begins -------------->>>>>//
$widget = new WidgetFormHandler();
$widget->setPageBlockNames(array('form_widget', 'form_widget_preview', 'form_widget_code'));
//default form fields and values...

$widget->setFormField('type','ask_solution');
$widget->setFormField('board','recent');
$widget->setFormField('board_count',4);
$widget->setFormField('folder','Recent');
$widget->setFormField('ask_board','');
$widget->setFormField('category','');
$widget->setFormField('sub_category','');
$widget->setFormField('uid', $CFG['user']['user_id']);
//Board type array
if(isMember())
	{
		$widget->LANG_LIST_ARR['board_type'] = array(
							'recent' => $LANG['recent'],
							'popular' => $LANG['popular'],
							'my' => $LANG['my_board_only']
							);
	}
else
	{
		$widget->LANG_LIST_ARR['board_type'] = array(
							'recent' => $LANG['recent'],
							'popular' => $LANG['popular']
							);
	}
//Widget type array
$widget->LANG_LIST_ARR['widget_type'] = array(
							'ask_solution' => $LANG['ask_solution'],
							'ask_only' => $LANG['ask_only'],
							'board_only' => $LANG['board_only']);

$widget->populateCategories_arr = $widget->populateCategories();
$widget->populateSubCategories_arr = '';
/*************Start navigation******/
$widget->numpg = $CFG['data_tbl']['numpg'];
$widget->setFormField('start', 0);
$widget->setFormField('numpg', $CFG['data_tbl']['numpg']);//$this->CFG['data_tbl']['numpg']
$widget->setMinRecordSelectLimit($CFG['data_tbl']['min_record_select_limit']);
$widget->setMaxRecordSelectLimit($CFG['data_tbl']['max_record_select_limit']);
$widget->setNumPerPageListArr($CFG['data_tbl']['numperpage_list_arr']);
//Set tables and fields to return
$widget->setTableNames(array());
$widget->setReturnColumns(array());
//orderby field and orderby
$widget->setFormField('orderby_field', '');
$widget->setFormField('orderby', '');
$widget->setFormField('block', 'show');
$widget->setFormField('embed', '');

/*************End navigation******/
$widget->sanitizeFormInputs($_REQUEST);

if($widget->getFormField('category'))
	{
		$widget->populateSubCategories_arr = $widget->populateSubCategories($widget->getFormField('category'));
	}

if($widget->getFormField('block') == 'show')
	{
		$widget->setPageBlockShow('form_widget');
		$widget->setPageBlockShow('form_widget_preview');
		$widget->setPageBlockShow('form_widget_code');
	}
else
	{
		$widget->setPageBlockShow('form_widget_preview');
	}
if ($widget->isFormGETed($_GET, 'embed'))
	{
		$boards = $widget->getFormField('board_count');
		$widget->setFormField('numpg', $boards);//$this->CFG['data_tbl']['numpg']
		if($widget->getFormField('board') == 'recent')
			$widget->setFormField('folder','Recent');
		elseif($widget->getFormField('board') == 'popular')
			$widget->setFormField('folder','Popular');
		elseif($widget->getFormField('board') == 'my')
			$widget->setFormField('folder','my');
		$widget->setPageBlockShow('form_widget_preview');
		$widget->setPageBlockShow('form_widget_code');
		$widget->setTableAndColumns();
		$widget->buildSelectQuery();
		$widget->buildConditionQuery();
		$widget->buildSortQuery();
		$widget->buildQuery();
		$widget->executeQuery();
		ob_start();
?>
		<style type="text/css">
		.clsCommonPreviewWidgetSection h3{
			width:280px;
			background:#7F7F7F;
			color:#FFF;
			padding:0.2em 0 0.2em 0.8em;
			margin:0;
		}
		.clsWidgetCode{
			margin:0 0 1em 0;
			border:1px solid #7F7F7F;
			padding:0.5em;
		}
		.clsWidgetCodeTextarea{
			width:98%;
			margin:1em 0 0 0;
		}
		.clsSubmitButton{
			background:#B9F766;
			font-weight:bold;
			color:#444;
			font-size:14px;
			border:0;
			cursor:pointer;
			padding:2px 5px;
			margin:1em 2em 1em 0;
			float:right;
		}
		* html .clsSubmitButton{
			padding:2px 5px 1px 5px;
		}
		#submitsearch{
			overflow:auto;
			zoom:1;
		}
		* html #submitsearch{
			height:1%;
			overflow:visible;
		}
		.clsOddBoard{
			background:#E7E7E7 url(images/white_theme/bg-oddboard.jpg) repeat-y;
			padding:8px 5px;
			margin:3px 0 0 0;
		}
		.clsEvenBoard{
			background:#FCFCFC url(images/white_theme/bg-evenboard.jpg) repeat-y;
			padding:8px 5px;
			margin:3px 0 0 0;
		}
		</style>
<?php

		$widget->includeAjaxHeader();
		$widget->showBoardList();
		$str = ob_get_clean();
		$str = trim($str);
		$str = str_replace(array("\n", "\t", "\r", "'"), array('', '', '', "&rsquo;"), $str);
		$documentWrite = true;
		if ($documentWrite)
			{
				print 'document.writeln(\''.$str.'\');';
				exit;
			}
		else
			{
				print $str;
			}
	}
$boards = 0;
if($widget->isFormPOSTed($_POST, 'ask'))
	{
		Redirect2URL(getUrl('boards', '?view=ask&board='.$widget->getFormField('ask_board'), 'ask/?board='.$widget->getFormField('ask_board'), 'members', $CFG['admin']['index']['home_module']));
	}
if($widget->isFormGETed($_POST, 'submit1'))
	{
		$boards = $widget->getFormField('board_count');
		$widget->setFormField('numpg', $boards);//$this->CFG['data_tbl']['numpg']
		if($widget->getFormField('board') == 'recent')
			$widget->setFormField('folder','Recent');
		elseif($widget->getFormField('board') == 'popular')
			$widget->setFormField('folder','Popular');
		elseif($widget->getFormField('board') == 'my')
			$widget->setFormField('folder','my');
		$widget->setPageBlockShow('form_widget_preview');
		$widget->setPageBlockShow('form_widget_code');
   }
//-------------------- Code endok comes -------------->>>>>//
//--------------------Page block templates begins-------------------->>>>>//
if ($widget->isShowPageBlock('form_widget_preview'))
	{
		$boards = $widget->getFormField('board_count');
		$widget->setFormField('numpg', $boards);//$this->CFG['data_tbl']['numpg']
		$widget->setTableAndColumns();
		$widget->buildSelectQuery();
		$widget->buildConditionQuery();
		$widget->buildSortQuery();
		$widget->buildQuery();
		$widget->executeQuery();
   	}
//--------------------Page block templates begins-------------------->>>>>//
//include the header file
$widget->includeHeader();
//include the content of the page
setTemplateFolder('general/', $CFG['admin']['index']['home_module']);
$smartyObj->display('widgetGenerate.tpl');
//include the footer of the page
//<<<<<<--------------------Page block templates Ends--------------------//
$widget->includeFooter();
?>