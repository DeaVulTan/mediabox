{if (chkAllowedModule(array('photo'))) || (chkAllowedModule(array('music'))) || (chkAllowedModule(array('video'))) }
<div class="clsFeaturedInformation clsFeaturedmediaTable">
 	<div class="clsIndexOtherBlocksContainer">
   		<div class="clsJQCarousel" id="recentFeaturedTabs">
		  <table {$myobj->defaultTableBgColor}>
				<tr>
				  <th {$myobj->defaultBlockTitle}> 
					  <ul class="clsJQCarouselFeaturedTabs clsOverflow clsOtherTabs">
						  {if chkAllowedModule(array('photo'))}
							  <li><a href="#idFeaturedPhotoContent">{$LANG.myprofile_featured_photo}</a></li>
						   {/if}
						   {if chkAllowedModule(array('music'))}
							  <li><a href="#idFeaturedMusicContent">{$LANG.myprofile_featured_music}</a></li>
						   {/if}
						  {if chkAllowedModule(array('video'))}              
							  <li><a href="#idFeaturedVideoContent">{$LANG.myprofile_featured_video}</a></li>
						  {/if}
						</ul>
				   </th>
				</tr>
				<tr> 
				<td>						
					  <div id="idFeaturedPhotoContent">
							{$myobj->setTemplateFolder('general/','photo')}
							{include file=profileMyfeaturedphotoBlock.tpl}    
					  </div> 
					  <div id="idFeaturedMusicContent">
							{$myobj->setTemplateFolder('general/','music')}
							{include file=profileFeaturedmusicBlock.tpl}
					  </div>
					  <div id="idFeaturedVideoContent">
							{$myobj->setTemplateFolder('general/','video')}
							{include file=profileFeaturedvideoBlock.tpl}           
					  </div>
			    </td>
    		</tr>
  		</table>
      </div>
	</div>
</div>
<script type="text/javascript">
	{literal}
	$Jq(window).load(function(){
		attachJqueryTabs('recentFeaturedTabs');
	});
	{/literal}
</script>
{/if}