<?php /* Smarty version 2.6.18, created on 2011-10-18 15:28:01
         compiled from profileFeaturedmusicBlock.tpl */ ?>
<?php if ($this->_tpl_vars['isFeaturedmusic']): ?>
<?php echo $this->_tpl_vars['myobj']->chkTemplateImagePathForModuleAndSwitch('music',$this->_tpl_vars['CFG']['html']['template']['default'],$this->_tpl_vars['CFG']['html']['stylesheet']['screen']['default']); ?>

<script type="text/javascript" src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
music/js/functions.js"></script>
<div class="clsFeaturedMusicBlockTable">
  <?php if ($this->_tpl_vars['featured_music_list_arr']['music_id']): ?>
	  <div class="clsProfileBlockContainer">
		<h3><a href="<?php echo $this->_tpl_vars['featured_music_list_arr']['musicUrl']; ?>
" title="<?php echo $this->_tpl_vars['featured_music_list_arr']['music_title']; ?>
"><?php echo $this->_tpl_vars['featured_music_list_arr']['music_title']; ?>
</a></h3>
		  <div class="clsSongDetailContainer" >
									  <script type="text/javascript" src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
js/JSFCommunicator.js"></script>
					  <script type="text/javascript" src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
js/swfobject.js"></script>
					  								  							<?php echo $this->_tpl_vars['myobjFeaturedMusic']->populatePlayerWithPlaylist($this->_tpl_vars['music_fields']); ?>

							<input type="hidden" name="hidden_player_status" id="hidden_player_status" value="" />
					  						  </div>
	  </div>
 <?php endif; ?>
</div>
 <?php else: ?>
		<div class="clsOverflow">
			<div class="clsNoRecordsFound"><?php echo $this->_tpl_vars['LANG']['myprofile_featuredmusic_no_records']; ?>
</div>
	  </div>	
 <?php endif; ?>
