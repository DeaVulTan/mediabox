<?php /* Smarty version 2.6.18, created on 2011-10-25 15:09:53
         compiled from populateFeaturedVideoPlayers.tpl */ ?>
<div id="video_random_player">
    	<?php if ($this->_tpl_vars['videoIndexObj']->checkEmbedPlayer($this->_tpl_vars['videoIndexObj']->getFormField('video_id'))): ?>
	<div id="flashcontent3" class="clsVideoPlayerBorder">
    	<?php echo $this->_tpl_vars['videoIndexObj']->displayEmbededVideo($this->_tpl_vars['videoIndexObj']->video_external_embed_code); ?>

	</div>
	<?php else: ?>
    <div id="flashcontent2" class="clsVideoPlayerBorder"></div>
		<?php echo $this->_tpl_vars['videoIndexObj']->getPlayer($this->_tpl_vars['videoIndexObj']->getFormField('video_id')); ?>

    <?php endif; ?>
    </div>