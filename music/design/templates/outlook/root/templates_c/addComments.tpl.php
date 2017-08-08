<?php /* Smarty version 2.6.18, created on 2011-12-23 23:52:09
         compiled from addComments.tpl */ ?>
<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('block_add_comments')): ?>
    <?php if ($this->_tpl_vars['myobj']->getFormField('allow_comments') == 'Kinda'): ?>
        <div id="selEditMainComments" style="display: none;" class="clsPostcommentBlock"><?php echo $this->_tpl_vars['myobj']->getCommentsBlock(); ?>
</div>
    <?php elseif ($this->_tpl_vars['myobj']->getFormField('allow_comments') == 'Yes'): ?>
        <div id="selEditMainComments" style="display: none;" class="clsPostcommentBlock"><?php echo $this->_tpl_vars['myobj']->getCommentsBlock(); ?>
</div>
    <?php endif; ?>
	<?php echo '
        <script language="javascript" type="text/javascript">
            var captcha = \''; ?>
<?php echo $this->_tpl_vars['myobj']->captchaText; ?>
<?php echo '\';
            var comment_approval = '; ?>
<?php if ($this->_tpl_vars['myobj']->getFormField('allow_comments') == 'Kinda' && $this->_tpl_vars['myobj']->getFormField('user_id') == $this->_tpl_vars['CFG']['user']['user_id']): ?>1<?php elseif ($this->_tpl_vars['myobj']->getFormField('allow_comments') == 'Kinda'): ?>0<?php elseif ($this->_tpl_vars['myobj']->getFormField('allow_comments') == 'Yes'): ?>1<?php endif; ?><?php echo ';
        </script>
  	'; ?>

<?php endif; ?>