<?php
/**
 * This file is to order Right bar
 *
 * PHP version 5.0
 *
 * @category	Discuzz
 * @package		orderSideBar
 * @author 		karthiselvam_75ag08
 * @copyright	Copyright (c) 2009 - 2010 {@link http://www.mediabox.uz Uzdc Infoway}
 * @license		http://www.mediabox.uz Uzdc Infoway Licence
 * @version		SVN: $Id: $
 * @since 		2008-12-23
 */
/**
 * To include config file
 */
require_once('../../common/configs/config.inc.php');
$CFG['lang']['include_files'][] = 'languages/%s/'.$CFG['admin']['index']['home_module'].'/admin/orderSideBar.php';
$CFG['html']['header'] = 'admin/html_header.php';
$CFG['html']['footer'] = 'admin/html_footer.php';
//compulsory
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;

$CFG['mods']['include_files'][] = 'common/classes/class_ListRecordsHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/swiftmailer/lib/EasySwift.php';
/**
 * To include application top file
 */
require($CFG['site']['project_path'].'common/application_top.inc.php');

class orderRightBar extends FormHandler
	{
	      /**
	       * orderRightBar::getRightBarSttings()
	       *
	       * @return
	       */
	      public function getRightBarSttings()
		  	{
				$sql = 'SELECT * from '.$this->CFG['db']['tbl']['rightbar_settings'];
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				if (!$rs)
				        trigger_db_error($this->dbObj);
				if ($rs->PO_RecordCount())
					{
						while($row = $rs->FetchRow()) {
							$this->setFormField($row['title'],$row['order_value']);
						}
					}
			}

		 /**
		  * orderRightBar::updateRightBarSttings()
		  *
		  * @return
		  */
		 public function updateRightBarSttings()
		  	{
				$sql = 'SELECT * from '.$this->CFG['db']['tbl']['rightbar_settings'].' ORDER BY sno ASC';
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				if (!$rs)
				        trigger_db_error($this->dbObj);
				if ($rs->PO_RecordCount())
					{
						while($row = $rs->FetchRow()) {
						 $sql1 = 'UPDATE '.$this->CFG['db']['tbl']['rightbar_settings'].
				  			     ' SET  order_value = '.$this->dbObj->Param($this->fields_arr[$row['title']]).
								 ' WHERE title = \''.$row['title'].'\'';

						 $stmt1 = $this->dbObj->Prepare($sql1);
						 $rs1 = $this->dbObj->Execute($stmt1,array($this->fields_arr[$row['title']]));
						 if (!$rs1)
			        		trigger_db_error($this->dbObj);
						}
					}
			}
	}
//--------------------Code begins-------------->>>>>//
$orderrightbar = new orderRightBar();
$orderrightbar->setPageBlockNames(array('form_order_rightbar'));
$orderrightbar->setAllPageBlocksHide();
$orderrightbar->setPageBlockShow('form_order_rightbar');
$orderrightbar->getRightBarSttings();
if($orderrightbar->isFormPOSTed($_POST, 'orderrightbar'))
	{
		$orderrightbar->sanitizeFormInputs($_POST);
	    $orderrightbar->chkIsNotEmpty('user_status', $LANG['err_tip_compulsory'])and
			$orderrightbar->chkIsNumeric('user_status', $LANG['rightbar_err_tip_enter_numbers']);
	    $orderrightbar->chkIsNotEmpty('top_contributors', $LANG['err_tip_compulsory']) and
			$orderrightbar->chkIsNumeric('top_contributors', $LANG['rightbar_err_tip_enter_numbers']);
	    $orderrightbar->chkIsNotEmpty('featured_contributors', $LANG['err_tip_compulsory']) and
			$orderrightbar->chkIsNumeric('featured_contributors', $LANG['rightbar_err_tip_enter_numbers']);
		$orderrightbar->chkIsNotEmpty('featured_board', $LANG['err_tip_compulsory']) and
			$orderrightbar->chkIsNumeric('featured_board', $LANG['rightbar_err_tip_enter_numbers']);

	    if($orderrightbar->isValidFormInputs())
			{
				$orderrightbar->updateRightBarSttings();
				$orderrightbar->setPageBlockShow('block_msg_form_success');
				$orderrightbar->setCommonSuccessMsg($LANG['rightbar_success']);
			}
		else
			{
				$orderrightbar->setAllPageBlocksHide();
				$orderrightbar->setPageBlockShow('block_msg_form_error');
				$orderrightbar->setCommonErrorMsg($LANG['discuzz_common_err_tip_error']);
				$orderrightbar->setPageBlockShow('form_order_rightbar');
			}
	}
//<<<<--------------------Code Ends----------------------//
//--------------------Page block templates begins-------------------->>>>>//
//include the header file
$orderrightbar->includeHeader();
//include the content of the page
setTemplateFolder('admin/', $CFG['admin']['index']['home_module']);
$smartyObj->display('orderSideBar.tpl');
//includ the footer of the page
if($CFG['feature']['jquery_validation']){
?>
<script type="text/javascript">
	$Jq("#form_order_rightbar").validate({
		rules: {
			user_status: {
				required: true,
      			number: true
		    },
		    top_contributors: {
		    	required: true,
      			number: true
		    },
		    featured_contributors: {
		    	required: true,
      			number: true
		    },
		    featured_board: {
		    	required: true,
      			number: true
		    }
		},
		messages: {
			user_status: {
				required: "<?php echo $LANG['common_err_tip_compulsory'];?>",
      			number: "<?php echo $LANG['discuzz_common_err_tip_numeric'];?>"
			},
			top_contributors: {
				required: "<?php echo $LANG['common_err_tip_compulsory'];?>",
      			number: "<?php echo $LANG['discuzz_common_err_tip_numeric'];?>"
			},
			featured_contributors: {
				required: "<?php echo $LANG['common_err_tip_compulsory'];?>",
      			number: "<?php echo $LANG['discuzz_common_err_tip_numeric'];?>"
			},
			featured_board: {
				required: "<?php echo $LANG['common_err_tip_compulsory'];?>",
      			number: "<?php echo $LANG['discuzz_common_err_tip_numeric'];?>"
			}
		}
	});
</script>
<?php
}
//<<<<<<--------------------Page block templates Ends--------------------//
$orderrightbar->includeFooter();
?>