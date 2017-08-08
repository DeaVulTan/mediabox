 {if chkAllowedModule(array('music')) || chkAllowedModule(array('video')) || chkAllowedModule(array('photo')) }
	{* ARTIST CLOUDS SECTION STARTS *}
    

        <div class="clsTagsRightTab" id="cloudTabs">
            <div class="clsTagsHeading clsOverflow">
				<div class="clsTagsLeftHead">
					<h3>Tags</h3>
				</div>        
   	  		 </div>
            <ul class="clsOverflow">
            {if chkAllowedModule(array('music'))}
                <li><a href="index.php?cloud_tab=music">{$LANG.myhome_cloud_music}</a></li>
            {/if}
            {if chkAllowedModule(array('photo'))}    
                <li><a href="index.php?cloud_tab=photo">{$LANG.myhome_cloud_photo}</a></li>
            {/if}
            {if chkAllowedModule(array('video'))}
                <li><a href="index.php?cloud_tab=video">{$LANG.myhome_cloud_video}</a></li>
            {/if}   
            </ul>
       </div>
        <script type="text/javascript">
			{literal}
			 	$Jq(window).load(function(){
					attachJqueryTabs('cloudTabs');
				});
			{/literal}
        </script>
    {* ARTIST CLOUDS SECTION ENDS *}
    {/if}