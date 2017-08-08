<?php /* Smarty version 2.6.18, created on 2012-01-31 23:18:31
         compiled from populateCommentOfThisPlaylist.tpl */ ?>
<form name="frmMusicComments" id="frmMusicComments" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(); ?>
">
	<?php if (isset ( $this->_tpl_vars['populateCommentOfThisPlaylist_arr']['hidden_arr'] ) && $this->_tpl_vars['populateCommentOfThisPlaylist_arr']['hidden_arr']): ?>
		<?php echo $this->_tpl_vars['myobj']->populateHidden($this->_tpl_vars['populateCommentOfThisPlaylist_arr']['hidden_arr']); ?>

	<?php endif; ?>
	<?php if (isset ( $this->_tpl_vars['populateCommentOfThisPlaylist_arr']['row'] ) && $this->_tpl_vars['populateCommentOfThisPlaylist_arr']['row']): ?>
    
	<?php if ($this->_tpl_vars['CFG']['admin']['navigation']['top']): ?>
	<div class="clsCommentsViewVideopaging">
		<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','music'); ?>

	    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'pagination.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	</div>
	<?php endif; ?>
    
    
	<?php $_from = $this->_tpl_vars['populateCommentOfThisPlaylist_arr']['row']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['cmKey'] => $this->_tpl_vars['cmValue']):
?>
	<div class="clsListContents" id="cmd<?php echo $this->_tpl_vars['cmValue']['record']['playlist_comment_id']; ?>
">
        <div class="clsOverflow">
            <div class="clsCommentThumb">
                <div class="clsThumbImageLink">
                    <a href="<?php echo $this->_tpl_vars['cmValue']['memberProfileUrl']; ?>
" class="ClsImageContainer ClsImageBorder1 Cls45x45">
                       <img src="<?php echo $this->_tpl_vars['cmValue']['icon']['s_url']; ?>
" title="<?php echo $this->_tpl_vars['cmValue']['name']; ?>
" <?php echo $this->_tpl_vars['myobj']->DISP_IMAGE(45,45,$this->_tpl_vars['cmValue']['icon']['s_width'],$this->_tpl_vars['cmValue']['icon']['s_height']); ?>
/>            
                    </a>
                </div>
            </div>
            <div class="clsCommentDetails">
                <p class="clsCommentedBy"><a href="<?php echo $this->_tpl_vars['cmValue']['memberProfileUrl']; ?>
" title="<?php echo $this->_tpl_vars['cmValue']['name']; ?>
"><?php echo $this->_tpl_vars['cmValue']['name']; ?>
</a><span class="clsLinkSeperator">|</span> <span> <?php echo $this->_tpl_vars['cmValue']['record']['pc_date_added']; ?>
</span> </p>
                <p id="selEditCommentTxt_<?php echo $this->_tpl_vars['cmValue']['record']['playlist_comment_id']; ?>
" class="clsPlaylistCommentdisplay"><?php echo $this->_tpl_vars['cmValue']['makeClickableLinks']; ?>
</p>
        		<div class="" id="selEditComments_<?php echo $this->_tpl_vars['cmValue']['record']['playlist_comment_id']; ?>
"></div>
            </div>
         </div>    
        <div class="clsButtonHolder">
        	<?php if (isMember ( ) && $this->_tpl_vars['cmValue']['record']['comment_user_id'] == $this->_tpl_vars['CFG']['user']['user_id']): ?>            
            <p class="clsEditButton" id="selViewEditComment_<?php echo $this->_tpl_vars['cmValue']['record']['playlist_comment_id']; ?>
" ><span><a href="javascript:void(0)" onclick="return callAjaxEdit('<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
music/viewPlaylist.php?ajax_page=true&amp;page=comment_edit&amp;playlist_id=<?php echo $this->_tpl_vars['myobj']->getFormField('playlist_id'); ?>
&amp;vpkey=<?php echo $this->_tpl_vars['myobj']->getFormField('vpkey'); ?>
&amp;show=<?php echo $this->_tpl_vars['myobj']->getFormField('show'); ?>
','<?php echo $this->_tpl_vars['cmValue']['record']['playlist_comment_id']; ?>
')"><?php echo $this->_tpl_vars['LANG']['viewplaylist_edit_label']; ?>
</a></span></p>  
            <p class="clsDeleteButton" id="selViewDeleteComment_<?php echo $this->_tpl_vars['cmValue']['record']['playlist_comment_id']; ?>
"><span><a href="javascript:void(0)" onclick="return deletePlaylistCommand('<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
music/viewPlaylist.php?playlist_id=<?php echo $this->_tpl_vars['myobj']->getFormField('playlist_id'); ?>
&amp;comment_id=<?php echo $this->_tpl_vars['cmValue']['record']['playlist_comment_id']; ?>
&amp;ajax_page=true&amp;page=deletecomment','cmd<?php echo $this->_tpl_vars['cmValue']['record']['playlist_comment_id']; ?>
', false)"><?php echo $this->_tpl_vars['LANG']['viewplaylist_deleted_label']; ?>
</a></span></p>
            <?php endif; ?>
            
            	
            <?php if (isMember ( ) && $this->_tpl_vars['cmValue']['record']['comment_user_id'] != $this->_tpl_vars['CFG']['user']['user_id']): ?>
            
        	<?php endif; ?>
            
            
        	<?php if (isMember ( ) && $this->_tpl_vars['cmValue']['record']['comment_user_id'] != $this->_tpl_vars['CFG']['user']['user_id']): ?>
            <?php if ($this->_tpl_vars['myobj']->getFormField('user_id') == $this->_tpl_vars['CFG']['user']['user_id']): ?>
                <p class="clsDeleteButton" id="selViewDeleteComment_<?php echo $this->_tpl_vars['cmValue']['record']['playlist_comment_id']; ?>
">
                <span>
                    <a href="javascript:void(0)" onclick="return deletePlaylistCommand('<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
music/viewPlaylist.php?playlist_id=<?php echo $this->_tpl_vars['myobj']->getFormField('playlist_id'); ?>
&amp;comment_id=<?php echo $this->_tpl_vars['cmValue']['record']['playlist_comment_id']; ?>
&amp;ajax_page=true&amp;page=deletecomment','cmd<?php echo $this->_tpl_vars['cmValue']['record']['playlist_comment_id']; ?>
', false)"><?php echo $this->_tpl_vars['LANG']['viewplaylist_deleted_label']; ?>
</a>
                </span>
               </p>
            <?php endif; ?>
        	<?php endif; ?>
            
        </div>
        
        <?php if ($this->_tpl_vars['cmValue']['populateReply_arr']): ?>
        
        <?php if ($this->_tpl_vars['cmValue']['populateReply_arr']['rs_PO_RecordCount']): ?>
        
        
        <?php $_from = $this->_tpl_vars['cmValue']['populateReply_arr']['row']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['prKey'] => $this->_tpl_vars['prValue']):
?>  
        <div class="clsMoreInfoContent clsOverflow" id="delcmd<?php echo $this->_tpl_vars['prValue']['record']['playlist_comment_id']; ?>
">
            <div class="clsMoreInfoComment">
                <div class="clsOverflow">
                    <div class="clsCommentThumb">
                        <div class="clsThumbImageLink">
                            <a class="ClsImageContainer ClsImageBorder1 Cls45x45" href="<?php echo $this->_tpl_vars['prValue']['memberProfileUrl']; ?>
">
                                <img src="<?php echo $this->_tpl_vars['prValue']['icon']['m_url']; ?>
" title="<?php echo $this->_tpl_vars['prValue']['name']; ?>
" <?php echo $this->_tpl_vars['myobj']->DISP_IMAGE(45,45,$this->_tpl_vars['prValue']['icon']['m_width'],$this->_tpl_vars['prValue']['icon']['m_height']); ?>
/>
                            </a>
                        </div>
                    </div>
                    <div class="clsCommentDetails">
                        <p class="clsCommentedBy"><span><?php echo $this->_tpl_vars['prValue']['name']; ?>
</span><span class="clsLinkSeperator">|</span><?php echo $this->_tpl_vars['LANG']['viewplaylist_replied_label']; ?>
</p>
                        <p id="selEditCommentTxt_<?php echo $this->_tpl_vars['prValue']['record']['playlist_comment_id']; ?>
"><?php echo $this->_tpl_vars['prValue']['comment_makeClickableLinks']; ?>
</p>
                        <div id="selEditComments_<?php echo $this->_tpl_vars['prValue']['record']['playlist_comment_id']; ?>
"></div>
                        <p class="clsAddedTime"><?php echo $this->_tpl_vars['prValue']['record']['pc_date_added']; ?>
</p>
                        <div id="selEditComments_<?php echo $this->_tpl_vars['prValue']['record']['playlist_comment_id']; ?>
"></div>
                    </div>
                </div>
            </div>
            <div class="clsButtonHolder">
                <?php if (( isMember ( ) && $this->_tpl_vars['prValue']['record']['comment_user_id'] == $this->_tpl_vars['CFG']['user']['user_id'] )): ?>                                
                        <p class="clsEditButton" id="selViewEditComment_<?php echo $this->_tpl_vars['prValue']['record']['playlist_comment_id']; ?>
">
                            <span>
                                <a href="javascript:void(0);" onclick="return callAjaxEdit('<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
music/viewPlaylist.php?ajax_page=true&amp;playlist_id=<?php echo $this->_tpl_vars['myobj']->getFormField('playlist_id'); ?>
&amp;vpkey=<?php echo $this->_tpl_vars['myobj']->getFormField('vpkey'); ?>
&amp;show=<?php echo $this->_tpl_vars['myobj']->getFormField('show'); ?>
','<?php echo $this->_tpl_vars['prValue']['record']['playlist_comment_id']; ?>
')"><?php echo $this->_tpl_vars['LANG']['viewplaylist_edit_label']; ?>
</a>
                            </span>
                        </p>
                <?php endif; ?>
                <?php if (( isMember ( ) || $this->_tpl_vars['prValue']['record']['comment_user_id'] != '' || $this->_tpl_vars['myobj']->getFormField('user_id') != '' )): ?>
                <?php if (( isMember ( ) )): ?>
                       <p class="clsDeleteButton" id="selViewDeleteComment_<?php echo $this->_tpl_vars['prValue']['record']['playlist_comment_id']; ?>
">
                            <span>
                                <a href="javascript:void(0);" onclick="return deleteCommandReply('<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
music/viewPlaylist.php?playlist_id=<?php echo $this->_tpl_vars['myobj']->getFormField('playlist_id'); ?>
&amp;comment_id=<?php echo $this->_tpl_vars['prValue']['record']['playlist_comment_id']; ?>
&amp;ajax_page=true&amp;page=deletecomment','cmd<?php echo $this->_tpl_vars['prValue']['record']['playlist_comment_id']; ?>
')"><?php echo $this->_tpl_vars['LANG']['viewplaylist_deleted_label']; ?>
</a>
                            </span>	
                        </p> 
                 <?php endif; ?>                             
                 <?php endif; ?>
             </div>                        	
        </div>
        <?php endforeach; endif; unset($_from); ?>
        
        
        <?php endif; ?>
        <?php endif; ?>
        
        
    </div>
	<?php endforeach; endif; unset($_from); ?>
	<?php if ($this->_tpl_vars['CFG']['admin']['navigation']['bottom']): ?>
		<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','music'); ?>

	    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'pagination.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	<?php endif; ?>
	<?php else: ?>
	<div class="clsNoRecordsFound">
		<p><?php echo $this->_tpl_vars['LANG']['viewplaylist_no_comments']; ?>
</p>
 	</div>
	<?php endif; ?>
</form>