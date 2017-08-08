<?php /* Smarty version 2.6.18, created on 2012-05-18 15:50:03
         compiled from commentEditReplyBlock.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'smartyTabIndex', 'commentEditReplyBlock.tpl', 12, false),)), $this); ?>
<div class="clsEditCommentTextAreaComment">
<form name="<?php echo $this->_tpl_vars['commentEditReply']['name']; ?>
<?php echo $this->_tpl_vars['commentEditReply']['comment_id']; ?>
" id="<?php echo $this->_tpl_vars['commentEditReply']['name']; ?>
_<?php echo $this->_tpl_vars['commentEditReply']['comment_id']; ?>
" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(); ?>
" autocomplete="off">
<table class="clsTable100">
    <tr>
        <td>
            <textarea class="clsWidth99" name="comment_<?php echo $this->_tpl_vars['commentEditReply']['comment_id']; ?>
" id="comment_<?php echo $this->_tpl_vars['commentEditReply']['comment_id']; ?>
" rows="5" cols="80"><?php echo $this->_tpl_vars['myobj']->getComment(); ?>
</textarea>
        </td>
    </tr>
    <tr>
        <td colspan="2">
			<div class="clsButtonHolder">
            <p class="clsCommentsSectionReply"><input class="clsCommentDiscard" type="button" onClick="return <?php echo $this->_tpl_vars['commentEditReply']['sumbitFunction']; ?>
(<?php echo $this->_tpl_vars['commentEditReply']['comment_id']; ?>
, '<?php echo $this->_tpl_vars['commentEditReply']['editReplyUrl']; ?>
')" name="post_comment" id="post_comment" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['postcomment_post_comment']; ?>
" /></p>
			<p>
            <input class="clsCommentDiscard" type="button" onClick="return <?php echo $this->_tpl_vars['commentEditReply']['cancelFunction']; ?>
(<?php echo $this->_tpl_vars['commentEditReply']['comment_id']; ?>
)" name="cancel" id="cancel" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['postcomment_cancel']; ?>
" /></p>
			</div>
        </td>
    </tr>
</table>
</form>
</div>