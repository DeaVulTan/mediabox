<?php /* Smarty version 2.6.18, created on 2011-10-18 15:28:01
         compiled from profileAboutmeBlock.tpl */ ?>
<?php if ($this->_tpl_vars['about_me']): ?>
   <div class="clsAboutInfoTable">
      <table <?php echo $this->_tpl_vars['myobj']->defaultTableBgColor; ?>
 >
        <tr>
          <th class="text clsProfileTitle" <?php echo $this->_tpl_vars['myobj']->defaultBlockTitle; ?>
 ><span class="whitetext12"><?php echo $this->_tpl_vars['LANG']['myprofile_about_me_shelf']; ?>
</span></th>
        </tr>
        <tr><td>
			<table class="clsAboutInfo" id="<?php echo $this->_tpl_vars['CFG']['profile_box_id']['aboutme_list']; ?>
">
                <tr>
					<td>
					   		<div id="<?php echo $this->_tpl_vars['about_me_id']; ?>
" class="<?php echo $this->_tpl_vars['about_me_class']; ?>
"><?php echo $this->_tpl_vars['about_me']; ?>
</div>
					</td>
				</tr>
       		</table>
		</td></tr>
      </table>
   </div>
<?php endif; ?>