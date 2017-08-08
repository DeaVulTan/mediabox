<?php /* Smarty version 2.6.18, created on 2012-04-16 17:11:57
         compiled from createAlbum.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'smartyTabIndex', 'createAlbum.tpl', 19, false),)), $this); ?>
<div id="selCreateAlbum">
<script type="text/javascript" language="javascript">
	var block_arr= new Array('selCreateAlbum', 'selMsgConfirm')
</script>

<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','music'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'information.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<div id="errorTips" style="display:none" class="clsErrorMessage">
        </div>
<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('form_create_album')): ?>
<form name="selFormCreateAlbum" id="selFormCreateAlbum"  method="post" action="" autocomplete="off">
<input type="hidden" name="album_access_type" id="album_access_type" value="Private" />
    <table class="clsCreateAlbumPopup clsStepsTable">
    	<tr>
        	<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('album_title'); ?>
">
            <label for="album_title"><?php echo $this->_tpl_vars['LANG']['createalbum_music_album']; ?>
</label>
            </td>
            <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('album_title'); ?>
">
            <input type="text" class="clsTextBox" name="album_title" id="album_title" value="<?php echo $this->_tpl_vars['myobj']->getFormField('album_title'); ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" />   
            <?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('album_title'); ?>
          
            </td>
        </tr>
        <?php if ($this->_tpl_vars['CFG']['admin']['musics']['allowed_usertypes_to_upload_for_sale'] != 'None'): ?>
        <tr>
        	<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('album_for_sale'); ?>
">
            <label for="album_for_sale"><?php echo $this->_tpl_vars['LANG']['createalbum_album_for_sale']; ?>
</label>
            </td>
            <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('album_for_sale'); ?>
">
            <input type="radio" class="clsCheckRadio" name="album_for_sale" onclick="enabledFormFields(Array('album_price'))" id="album_for_sale_1" value="Yes" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" 
                        <?php echo $this->_tpl_vars['myobj']->isCheckedRadio('album_for_sale','Yes'); ?>
 />&nbsp;<label for="for_sale1"><?php echo $this->_tpl_vars['LANG']['createalbum_yes']; ?>

                        </label>
                        <input type="radio" class="clsCheckRadio" name="album_for_sale" id="album_for_sale_2" value="No" onclick="disabledFormFields(Array('album_price'))" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" 
                        <?php echo $this->_tpl_vars['myobj']->isCheckedRadio('album_for_sale','No'); ?>
 />&nbsp;<label for="for_sale2"><?php echo $this->_tpl_vars['LANG']['createalbum_no']; ?>
</label>
            </td>
        </tr>
       	<tr>
        	<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('album_price'); ?>
">
            <label for="album_title"><?php echo $this->_tpl_vars['LANG']['createalbum_music_album_price']; ?>
</label>(<?php echo $this->_tpl_vars['CFG']['currency']; ?>
)
            </td>
            <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('album_price'); ?>
">
            <input type="text" class="clsTextBox" name="album_price" id="album_price" value="<?php echo $this->_tpl_vars['myobj']->getFormField('album_price'); ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" />
            <?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('album_price'); ?>
    
            </td>
        </tr>
        <?php endif; ?>
        <tr>
        	<td colspan="2" style="text-align:center;">
            	<input type="button" class="clsSubmitButton" name="send" id="send" value="<?php echo $this->_tpl_vars['LANG']['createalbum_save']; ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" <?php if (isAjaxPage ( )): ?> onclick="if(valid.form())return saveAjaxAlbum('<?php echo $this->_tpl_vars['myobj']->getUrl('createalbum','?ajax_page=true&page=save','?ajax_page=true&page=save','members','music'); ?>
')" <?php endif; ?>/>
            </td>
        </tr>
    </table>
</form>
<?php echo '
<script type="text/javascript">
var valid = $Jq(\'#selFormCreateAlbum\').validate({
	rules: {
		album_title: {
			required: true
		}
	}
});
</script>
'; ?>

<?php endif; ?> 
</div>