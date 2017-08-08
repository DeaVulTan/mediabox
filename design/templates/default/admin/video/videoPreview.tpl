<div id="selVideoPreview"> 
	<!-- heading start -->
	<h2>
			{$myobj->getFormField('user_name')} {$LANG.preview_title}
	</h2> 
	<!-- Information div -->
	
	{$myobj->setTemplateFolder('admin/')} {include file='information.tpl'}
	<!-- view_video_form start -->
	{if  $myobj->isShowPageBlock('view_video_form')}
 		<div id="selVideoPreviewFrm">
        	{if $myobj->checkIsExternalEmebedCode()}
            	{$myobj->displayEmbededVideo()}
       		{/if}
        	{if !$myobj->checkIsExternalEmebedCode()}
                {literal} 
                <script type="text/javascript" src="{/literal}{$CFG.site.url}{literal}js/swfobject.js"></script>{/literal}
                <div id="flashcontent2">
                </div>
                {literal}
                <script type="text/javascript">
                    var so1 = new SWFObject("{/literal}{$myobj->view_video_form.flv_player_url}{literal}", "flvplayer", "450", "370", "7",  null, true);
                    so1.addParam("allowFullScreen", "true");
                    so1.addParam("allowSciptAccess", "always");
                    so1.addVariable("config", "{/literal}{$myobj->view_video_form.configXmlcode_url}{literal}");
                    so1.write("flashcontent2");
                </script>	
                {/literal}	  
           {/if}	
		</div> 
	{/if}
	<!-- view_video_form end --->
</div> 