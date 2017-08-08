<?php /* Smarty version 2.6.18, created on 2011-10-26 15:35:01
         compiled from videoAdvertisement.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'smartyTabIndex', 'videoAdvertisement.tpl', 20, false),)), $this); ?>
<div id="seladvertisement">
	<h2><span><?php echo $this->_tpl_vars['LANG']['page_title']; ?>
</span></h2>
	<?php if ($this->_tpl_vars['myobj']->getFormField('act') != 'add'): ?>
  		<p class="clsPageLink"><a href="videoAdvertisement.php?act=add"><?php echo $this->_tpl_vars['LANG']['add_new_advertisement']; ?>
</a></p>
	<?php endif; ?>
    <div id="selLeftNavigation">

    <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('admin/'); ?>
 <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'information.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
  	<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('advertisement_upload_form')): ?>
    	<div id="selUpload">
            <form name="video_advertisement_upload_form" id="video_advertisement_upload_form" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(true); ?>
" autocomplete="off" enctype="multipart/form-data">
                <div id="selUploadBlock">
                    <table summary="<?php echo $this->_tpl_vars['LANG']['advertisement_tbl_summary']; ?>
" id="selUploadTbl" class=" clsNoBorder clsUploadBlock">
                        <tr>
                            <td class="clsWidthSmall <?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('advertisement_name'); ?>
">
                            	<label for="advertisement_name"><?php echo $this->_tpl_vars['LANG']['advertisement_name']; ?>
</label>
                            </td>
                            <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('advertisement_name'); ?>
">
                            	<?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('advertisement_name'); ?>

                           		<input type="text" class="clsTextBox" name="advertisement_name" id="advertisement_name" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['myobj']->getFormField('advertisement_name'); ?>
" />
                            </td>
                        </tr>
                        <tr>
                            <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('advertisement_description'); ?>
">
                            	<label for="advertisement_description"><?php echo $this->_tpl_vars['LANG']['advertisement_description']; ?>
</label>
                            </td>
                            <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('advertisement_description'); ?>
">
                            	<?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('advertisement_description'); ?>

                            	<textarea name="advertisement_description" id="advertisement_description" tabindex="<?php echo smartyTabIndex(array(), $this);?>
"><?php echo $this->_tpl_vars['myobj']->getFormField('advertisement_description'); ?>
</textarea>
                            </td>
                        </tr>
                        <tr>
                            <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('advertisement_url'); ?>
">
                            	<label for="advertisement_url"><?php echo $this->_tpl_vars['LANG']['advertisement_url']; ?>
</label>
                                <?php echo $this->_tpl_vars['LANG']['video_advertisement_ex_url']; ?>

                            </td>
                            <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('advertisement_url'); ?>
">
                            	<?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('advertisement_url'); ?>

                           		<input type="text" class="clsTextBox" name="advertisement_url" id="advertisement_url" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['myobj']->getFormField('advertisement_url'); ?>
" />
                            </td>
                        </tr>
                        <tr>
                            <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('advertisement_duration'); ?>
">
                            	<label for="advertisement_duration"><?php echo $this->_tpl_vars['LANG']['advertisement_duration']; ?>
</label>
                            </td>
                            <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('advertisement_duration'); ?>
">
                                <?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('advertisement_duration'); ?>

                                <input type="text" class="clsTextBox" name="advertisement_duration" id="advertisement_duration" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['myobj']->getFormField('advertisement_duration'); ?>
" />&nbsp;<?php echo $this->_tpl_vars['LANG']['seconds']; ?>

                            </td>
                        </tr>
                    <?php if ($this->_tpl_vars['CFG']['admin']['video_advertisement_impressions']): ?>
                        <tr>
                            <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('month'); ?>
">
                            	<label for="month"><?php echo $this->_tpl_vars['LANG']['advertisement_expiry_date']; ?>
</label>
                            </td>
                            <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('advertisement_expiry_date'); ?>
">
                                <?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('month'); ?>

                                <!--<input type="text" class="clsTextBox" name="advertisement_expiry_date" id="advertisement_expiry_date" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['myobj']->getFormField('advertisement_expiry_date'); ?>
" />&nbsp;(YYYY-MM-DD HH:MM:SS)-->
                                <select name="month" id="month" tabindex="<?php echo smartyTabIndex(array(), $this);?>
">
                                <option value=""><?php echo $this->_tpl_vars['LANG']['select_month']; ?>
</option>
                                <?php echo $this->_tpl_vars['myobj']->populateBWNumbers(1,12,$this->_tpl_vars['myobj']->getFormField('month')); ?>

                                </select>
                                <select name="day" id="day" tabindex="<?php echo smartyTabIndex(array(), $this);?>
">
                                <option value=""><?php echo $this->_tpl_vars['LANG']['select_day']; ?>
</option>
                                <?php echo $this->_tpl_vars['myobj']->populateBWNumbers(1,31,$this->_tpl_vars['myobj']->getFormField('day')); ?>

                                </select>
                                <select name="year" id="year" tabindex="<?php echo smartyTabIndex(array(), $this);?>
">
                                <option value=""><?php echo $this->_tpl_vars['LANG']['select_year']; ?>
</option>
                                <?php echo $this->_tpl_vars['myobj']->populateBWNumbers($this->_tpl_vars['myobj']->advertisement_upload_form['datem'],$this->_tpl_vars['myobj']->advertisement_upload_form['datep'],$this->_tpl_vars['myobj']->getFormField('year')); ?>

                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('advertisement_impressions'); ?>
">
                            	<label for="advertisement_impressions"><?php echo $this->_tpl_vars['LANG']['advertisement_impressions']; ?>
</label>
                            </td>
                            <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('advertisement_impressions'); ?>
">
                                <?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('advertisement_impressions'); ?>

                                <input type="text" class="clsTextBox" name="advertisement_impressions" id="advertisement_impressions" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['myobj']->getFormField('advertisement_impressions'); ?>
" />
                            </td>
                        </tr>
                    <?php endif; ?>
                        <tr>
                            <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('advertisement_channel'); ?>
">
                            	<label for="advertisement_channel"><?php echo $this->_tpl_vars['LANG']['advertisement_channel']; ?>
</label>
                            </td>
                            <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('advertisement_channel'); ?>
">
                                <?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('advertisement_channel'); ?>

                                <?php echo $this->_tpl_vars['myobj']->populateVideoCatagory(); ?>

                            </td>
                        </tr>
                        <tr>
                            <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('advertisement_show_at'); ?>
">
                           		<label for="advertisement_show_at"><?php echo $this->_tpl_vars['LANG']['advertisement_show_at']; ?>
</label>
                            </td>
                            <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('advertisement_show_at'); ?>
">
                                <?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('advertisement_show_at'); ?>

                                <input type="radio" class="clsCheckRadio" name="advertisement_show_at" id="advertisement_show_at1" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="Begining" <?php echo $this->_tpl_vars['myobj']->isCheckedRadio('advertisement_show_at','Begining'); ?>
 />&nbsp;<label for="advertisement_show_at1"><?php echo $this->_tpl_vars['LANG']['begining']; ?>
</label>
                                <input type="radio" class="clsCheckRadio" name="advertisement_show_at" id="advertisement_show_at2" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="Ending" <?php echo $this->_tpl_vars['myobj']->isCheckedRadio('advertisement_show_at','Ending'); ?>
 />&nbsp;<label for="advertisement_show_at2"><?php echo $this->_tpl_vars['LANG']['ending']; ?>
</label>
                                <input type="radio" class="clsCheckRadio" name="advertisement_show_at" id="advertisement_show_at3" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="Both" <?php echo $this->_tpl_vars['myobj']->isCheckedRadio('advertisement_show_at','Both'); ?>
 />&nbsp;<label for="advertisement_show_at3"><?php echo $this->_tpl_vars['LANG']['both']; ?>
</label>
                            </td>
                        </tr>
                        <tr>
                            <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('video_advertisement_file'); ?>
">
                            	<label for="video_advertisement_file"><?php echo $this->_tpl_vars['LANG']['advertisement_file']; ?>
 </label> <span class="clsMandatoryFieldIcon">*</span>
                            </td>
                            <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('video_advertisement_file'); ?>
">
                                <?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('video_advertisement_file'); ?>

                                <?php if ($this->_tpl_vars['myobj']->chkIsEditMode()): ?>
                                    <div id="selLeftPlainImage">
                                   		<p id="selImageBorder"><span id="selPlainCenterImage"><?php echo $this->_tpl_vars['myobj']->getadvertisementImage(); ?>
</span></p>
                                    </div>
                                <?php endif; ?>
                                <input type="file" class="clsFileBox" name="video_advertisement_file" id="video_advertisement_file" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" />
                                (<?php echo $this->_tpl_vars['CFG']['admin']['videos']['advertisement_max_size']; ?>
&nbsp;KB)
                            </td>
                        </tr>
                    <?php if (chkAllowedModule ( array ( 'affiliate' ) )): ?>
                        <tr>
                            <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('views_revenue'); ?>
">
                            	<label for="views_revenue"><?php echo $this->_tpl_vars['LANG']['views_revenue']; ?>
</label>
                            </td>
                            <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('views_revenue'); ?>
">
                                <?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('views_revenue'); ?>

                                <?php echo $this->_tpl_vars['CFG']['admin']['affiliate']['currency']; ?>
<input type="text" class="clsTextBox" name="views_revenue" id="views_revenue" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['myobj']->getFormField('views_revenue'); ?>
" />
                                </td>
                        </tr>
                        <tr>
                            <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('clicks_revenue'); ?>
">
                            	<label for="clicks_revenue"><?php echo $this->_tpl_vars['LANG']['clicks_revenue']; ?>
</label>
                        	</td>
                            <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('clicks_revenue'); ?>
">
                                <?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('clicks_revenue'); ?>

                                <?php echo $this->_tpl_vars['CFG']['admin']['affiliate']['currency']; ?>
<input type="text" class="clsTextBox" name="clicks_revenue" id="clicks_revenue" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['myobj']->getFormField('clicks_revenue'); ?>
" />
                            </td>
                        </tr>
                    <?php endif; ?>
                    <?php if (chkAllowedModule ( array ( 'content_filter' ) )): ?>
                        <tr>
                            <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('add_type'); ?>
">
                            	<label for="add_type1"><?php echo $this->_tpl_vars['LANG']['add_type']; ?>
</label>
                            </td>
                            <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('add_type'); ?>
">
                                <?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('add_type'); ?>

                                <input type="radio" class="clsCheckRadio" name="add_type" id="add_type1" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="General"<?php echo $this->_tpl_vars['myobj']->isCheckedRadio('add_type','General'); ?>
 />
                                <label for="add_type1"><?php echo $this->_tpl_vars['LANG']['add_type_general']; ?>
</label>
                                <input type="radio" class="clsCheckRadio" name="add_type" id="add_type2" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="Porn"<?php echo $this->_tpl_vars['myobj']->isCheckedRadio('add_type','Porn'); ?>
 />
                                <label for="add_type2"><?php echo $this->_tpl_vars['LANG']['add_type_porn']; ?>
</label>
                            </td>
                        </tr>
                    <?php endif; ?>
                        <tr>
                            <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('advertisement_status'); ?>
">
                            	<label for="advertisement_status"><?php echo $this->_tpl_vars['LANG']['advertisement_status']; ?>
</label>
                            </td>
                            <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('advertisement_status'); ?>
"><?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('advertisement_status'); ?>

                                <select name="advertisement_status" id="advertisement_status" tabindex="<?php echo smartyTabIndex(array(), $this);?>
">
                                <?php echo $this->_tpl_vars['myobj']->generalPopulateArray($this->_tpl_vars['myobj']->advertisement_upload_form['advertisement_status_array'],$this->_tpl_vars['myobj']->getFormField('advertisement_status')); ?>

                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" class="clsFormFieldCellDefault">
                            <?php if ($this->_tpl_vars['myobj']->chkIsEditMode()): ?>
                          		<?php echo $this->_tpl_vars['myobj']->populateHidden($this->_tpl_vars['myobj']->advertisement_upload_form['populateHidden']); ?>

                            	<input type="submit" class="clsSubmitButton" name="update" id="update" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['update']; ?>
" />
                            <?php else: ?>
                            	<input type="submit" class="clsSubmitButton" name="add" id="add" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['add']; ?>
" />
                            <?php endif; ?>
                            	<input type="submit" class="clsCancelButton" name="cancel" id="cancel" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['cancel']; ?>
" />
                            </td>
                        </tr>
                    </table>
                </div>
            </form>
    </div>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['myobj']->isShowPageBlock('advertisement_list')): ?>
    	<?php if ($this->_tpl_vars['myobj']->isResultsFound()): ?>
            <div id="selMsgConfirm" class="clsMsgConfirm" style="display:none;">
                <p id="selMsgText"></p>
                <form name="actionForm" id="actionForm" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(true); ?>
" autocomplete="off">

                                <input type="submit" class="clsSubmitButton" name="yes" id="yes" value="<?php echo $this->_tpl_vars['LANG']['common_yes_option']; ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" /> &nbsp;
                                <input type="button" class="clsSubmitButton" name="no" id="no" value="<?php echo $this->_tpl_vars['LANG']['common_no_option']; ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" onClick="return hideAllBlocks();" />
                                <input type="hidden" name="aid" id="aid" />
                                <input type="hidden" name="act" id="act" />
                                
                </form>
            </div>
            <div id="advertisementListBlock">
                <form name="listAddForm" id="listAddForm" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(true); ?>
" autocomplete="off">
                    <?php if ($this->_tpl_vars['CFG']['admin']['navigation']['top']): ?>

                        <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('admin/'); ?>
 <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'pagination.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                    <?php endif; ?>
                    <table summary="<?php echo $this->_tpl_vars['LANG']['advertisement_tbl_summary']; ?>
">
                        <tr>
                            <th class="clsSelectAllItems"><input type="checkbox" class="clsCheckRadio" name="check_all" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" onclick="CheckAll(document.listAddForm.name, document.listAddForm.check_all.name)" /></th>
                            <th class="<?php echo $this->_tpl_vars['myobj']->getOrderCss('advertisement_id'); ?>
"><p><?php echo $this->_tpl_vars['LANG']['advertisement_id']; ?>
</p></th>
                            <th class="<?php echo $this->_tpl_vars['myobj']->getOrderCss('advertisement_name'); ?>
"><p><?php echo $this->_tpl_vars['LANG']['advertisement_name']; ?>
</p></th>
                            <th class="<?php echo $this->_tpl_vars['myobj']->getOrderCss('user_id'); ?>
"><p><?php echo $this->_tpl_vars['LANG']['advertisement_user']; ?>
</p></th>
                            <th class="<?php echo $this->_tpl_vars['myobj']->getOrderCss('advertisement_show_at'); ?>
"><p><?php echo $this->_tpl_vars['LANG']['advertisement_show_at']; ?>
</p></th>
                            <th class="<?php echo $this->_tpl_vars['myobj']->getOrderCss('advertisement_duration'); ?>
"><p><?php echo $this->_tpl_vars['LANG']['advertisement_duration']; ?>
</p></th>
                        <?php if ($this->_tpl_vars['CFG']['admin']['video_advertisement_impressions']): ?>
                            <th class="<?php echo $this->_tpl_vars['myobj']->getOrderCss('advertisement_impressions'); ?>
"><p><?php echo $this->_tpl_vars['LANG']['advertisement_impressions']; ?>
</p></th>
                            <th class="<?php echo $this->_tpl_vars['myobj']->getOrderCss('advertisement_current_impressions'); ?>
"><p><?php echo $this->_tpl_vars['LANG']['advertisement_current_impressions']; ?>
</p></th>
                            <th class="<?php echo $this->_tpl_vars['myobj']->getOrderCss('advertisement_expiry_date'); ?>
"><p><?php echo $this->_tpl_vars['LANG']['advertisement_expiry_date']; ?>
</p></th>
                        <?php endif; ?>
                        <?php if (chkAllowedModule ( array ( 'affiliate' ) )): ?>
                            <th class="<?php echo $this->_tpl_vars['myobj']->getOrderCss('views_revenue'); ?>
"><p><?php echo $this->_tpl_vars['LANG']['views_revenue']; ?>
</p></th>
                            <th class="<?php echo $this->_tpl_vars['myobj']->getOrderCss('clicks_revenue'); ?>
"><p><?php echo $this->_tpl_vars['LANG']['clicks_revenue']; ?>
</p></th>
                            <th class="<?php echo $this->_tpl_vars['myobj']->getOrderCss('site_earnings'); ?>
"><p><?php echo $this->_tpl_vars['LANG']['site_earnings']; ?>
</p></th>
                            <th class="<?php echo $this->_tpl_vars['myobj']->getOrderCss('members_earnings'); ?>
"><p><?php echo $this->_tpl_vars['LANG']['members_earnings']; ?>
</p></th>
                        <?php endif; ?>
                            <th class="<?php echo $this->_tpl_vars['myobj']->getOrderCss('add_type'); ?>
"><p><?php echo $this->_tpl_vars['LANG']['add_type']; ?>
</p></th>
                            <th class="<?php echo $this->_tpl_vars['myobj']->getOrderCss('advertisement_status'); ?>
"><p><?php echo $this->_tpl_vars['LANG']['advertisement_status']; ?>
</p></th>
                            <th>&nbsp;</th>
                        </tr>
                       <?php $_from = $this->_tpl_vars['myobj']->advertisement_list['populateAdvertisementList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['palKey'] => $this->_tpl_vars['palValue']):
?>
                        <tr>
                            <td>
                                <input type="checkbox" class="clsCheckRadio" name="aid[]"  value="<?php echo $this->_tpl_vars['palValue']['record']['advertisement_id']; ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" onClick="disableHeading('listAddForm');"/>                            </td>
                            <td><?php echo $this->_tpl_vars['palValue']['record']['advertisement_id']; ?>
</td>
                            <td>
                                <?php echo $this->_tpl_vars['palValue']['record']['advertisement_name']; ?>
                            </td>
                            <td>
                                <?php echo $this->_tpl_vars['myobj']->getUserName($this->_tpl_vars['palValue']['record']['user_id']); ?>
                            </td>
                            <td>
                                <?php echo $this->_tpl_vars['palValue']['record']['advertisement_show_at']; ?>
                            </td>
                            <td>
                                <?php echo $this->_tpl_vars['palValue']['record']['advertisement_duration']; ?>
                            </td>
                        <?php if ($this->_tpl_vars['CFG']['admin']['video_advertisement_impressions']): ?>
                            <td>
                                <?php echo $this->_tpl_vars['palValue']['record']['advertisement_impressions']; ?>
                            </td>
                            <td>
                                <?php echo $this->_tpl_vars['palValue']['record']['advertisement_current_impressions']; ?>
                            </td>
                            <td>
                                <?php echo $this->_tpl_vars['palValue']['record']['advertisement_expiry_date']; ?>
                            </td>
                        <?php endif; ?>
                        <?php if (chkAllowedModule ( array ( 'affiliate' ) )): ?>
                            <td>
                                <?php echo $this->_tpl_vars['CFG']['admin']['affiliate']['currency'][$this->_tpl_vars['palValue']]['record']['views_revenue']; ?>
                            </td>
                            <td>
                                <?php echo $this->_tpl_vars['CFG']['admin']['affiliate']['currency'][$this->_tpl_vars['palValue']]['record']['clicks_revenue']; ?>
                            </td>
                            <td>
                                <?php echo $this->_tpl_vars['CFG']['admin']['affiliate']['currency'][$this->_tpl_vars['palValue']]['record']['site_earnings']; ?>
                            </td>
                            <td>
                                <?php echo $this->_tpl_vars['CFG']['admin']['affiliate']['currency'][$this->_tpl_vars['palValue']]['record']['members_earnings']; ?>
                            </td>
                       <?php endif; ?>
                            <td>
                                <?php echo $this->_tpl_vars['palValue']['record']['add_type']; ?>
                            </td>
                            <td>
                                <?php echo $this->_tpl_vars['palValue']['lang_status']; ?>
                            </td>
                            <td>
                                <a href="videoAdvertisement.php?act=edit&amp;aid=<?php echo $this->_tpl_vars['palValue']['record']['advertisement_id']; ?>
&amp;start=<?php echo $this->_tpl_vars['myobj']->getFormField('start'); ?>
">
                                    <?php echo $this->_tpl_vars['myobj']->LANG['edit']; ?>
                                </a>                            </td>
                        </tr>
                       <?php endforeach; endif; unset($_from); ?>
                        <tr>
                            <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('privacy_status'); ?>
" colspan="16">
                                <?php echo $this->_tpl_vars['myobj']->populateHidden($this->_tpl_vars['myobj']->advertisement_list['populateHidden']); ?>

                                <a href="#" id="<?php echo $this->_tpl_vars['myobj']->advertisement_list['anchor']; ?>
"></a>
                                <input type="button" class="clsSubmitButton" name="delete_submit" id="delete_submit" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['delete']; ?>
" onClick="<?php echo $this->_tpl_vars['myobj']->advertisement_list['onClick_Delete']; ?>
" />
                                <input type="button" class="clsSubmitButton" name="activate_submit" id="activate_submit" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['activate']; ?>
" onClick="<?php echo $this->_tpl_vars['myobj']->advertisement_list['onClick_Activate']; ?>
" />
                                <input type="button" class="clsSubmitButton" name="inactivate_submit" id="inactivate_submit" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['inactivate']; ?>
" onClick="<?php echo $this->_tpl_vars['myobj']->advertisement_list['onClick_Inactivate']; ?>
" />                            </td>
                        </tr>
                    </table>
                  <?php if ($this->_tpl_vars['CFG']['admin']['navigation']['bottom']): ?>
                        <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('admin/'); ?>
 <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'pagination.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                    <?php endif; ?>
                   </form>
                  </div>
            <?php else: ?>
                <div id="selMsgAlert">
                    <p><?php echo $this->_tpl_vars['LANG']['no_records_found']; ?>
</p>
                </div>
			<?php endif; ?>
      <?php endif; ?>
  </div>
</div>