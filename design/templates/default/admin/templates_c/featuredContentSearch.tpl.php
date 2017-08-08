<?php /* Smarty version 2.6.18, created on 2011-10-25 11:43:23
         compiled from featuredContentSearch.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'smartyTabIndex', 'featuredContentSearch.tpl', 15, false),)), $this); ?>
<div class="clsManageFeatuedSearch">
	<div class="clsManageTitle">
    	<h2><?php echo $this->_tpl_vars['LANG']['index_glidersetting_featured_content_popup_search']; ?>
</h2>
	</div>
</div>
<div class="clsManageFeatuedMainSearch">
	<form name="searchForm" id="searchForm" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(); ?>
">
		<table>
			<tr>
				<td><?php echo $this->_tpl_vars['LANG']['index_glidersetting_featured_content_selected_media_type']; ?>
</td>
				<td><div id="search_media_type">Music</div>
                <input type="hidden" class="clsTextBox" name="search_media_type" id="hidden_search_media_type" value="" readonly="readonly"></td>
			</tr>
			<tr>
				<td><input type="text" class="clsTextBox" name="search_input" id="search_input" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['index_glidersetting_featured_content_enter_search_keyword']; ?>
" onClick="this.value='';" onBlur="if(this.value=='') this.value='<?php echo $this->_tpl_vars['LANG']['index_glidersetting_featured_content_enter_search_keyword']; ?>
';" /></td>
				<td><input type="submit" class="clsSubmitButton" name="search_submit" id="search_submit" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['index_glidersetting_featured_content_search']; ?>
"/></td>
			</tr>
		</table>
	</form>
<?php if ($this->_tpl_vars['searchResultCount'] > 0): ?>
	<div>
		<h3><?php echo $this->_tpl_vars['LANG']['index_glidersetting_featured_content_search_result_for']; ?>
 '<?php echo $this->_tpl_vars['searchKeyword']; ?>
'</h3>
	</div>
	<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('admin'); ?>

	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'information.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
    <form name="featured_content_search_form" id="featured_content_search_form" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(); ?>
">
    	<input type="hidden" name="seachKeyword" id="searchKeyword" value="<?php echo $this->_tpl_vars['searchKeyword']; ?>
" />
    	<table>
    		<?php if ($this->_tpl_vars['searchSelectTemplate'] != ''): ?>
    			<tr>
        			<td colspan="3" align="right" class="clsSelectPage">
            			<?php echo $this->_tpl_vars['LANG']['index_glidersetting_featured_content_search_select_page']; ?>
<?php echo $this->_tpl_vars['searchSelectTemplate']; ?>

          			</td>
        		</tr>
        	<?php endif; ?>
        	<tr>
        		<th><?php echo $this->_tpl_vars['LANG']['index_glidersetting_featured_content_search_media_id']; ?>
</th>
				<th><?php echo $this->_tpl_vars['LANG']['index_glidersetting_featured_content_search_media_title']; ?>
</th>
				<th>&nbsp;</th>
        	</tr>
         	<?php $_from = $this->_tpl_vars['searchResult']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['inc'] => $this->_tpl_vars['value']):
?>
        	<tr>
        		<td><?php echo $this->_tpl_vars['searchResult'][$this->_tpl_vars['inc']]['media_id']; ?>
</td>
            	<td><?php echo $this->_tpl_vars['searchResult'][$this->_tpl_vars['inc']]['media_title']; ?>
</td>
            	<td><a href="javascript: void(0);" onclick="selectMediaId(<?php echo $this->_tpl_vars['searchResult'][$this->_tpl_vars['inc']]['media_id']; ?>
);"><?php echo $this->_tpl_vars['LANG']['index_glidersetting_featured_content_select_media']; ?>
</a></td>
        	</tr>
        	<?php endforeach; endif; unset($_from); ?>
    	</table>
    </form>
<?php endif; ?>
</div>
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('admin'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'information.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php echo '
<script type="text/javascript">
function selectMediaId(mediaId)
{
	window.parent.document.frmAddContentGlider.media_id.value = mediaId;
	parent.$Jq.fancybox.close();
}
document.getElementById(\'search_media_type\').innerHTML = window.parent.document.frmAddContentGlider.media_type.value;
document.getElementById(\'hidden_search_media_type\').value = window.parent.document.frmAddContentGlider.media_type.value;
</script>
'; ?>
