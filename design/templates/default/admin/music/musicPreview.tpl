<div id="selMusicPreview">
	<!-- heading start -->
	<h2>
			{$myobj->getFormField('user_name')} {$LANG.preview_title}
	</h2>
	<!-- Information div -->
	{$myobj->setTemplateFolder('admin')}
	{include file='information.tpl'}
 		<div id="selMusicPreviewFrm">
        	 {* Music Player Begins *}
                              <script type="text/javascript" src="{$CFG.site.url}js/swfobject.js"></script>
                              {*GENERATE SINGLE PLAYER*}
                                    {$myobj->populateSinglePlayer($music_fields)}
                              {*GENERATE SINGLE PLAYER*}
           {* Music Player ends *}

		</div>
</div>