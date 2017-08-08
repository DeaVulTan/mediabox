{if (chkAllowedModule(array('discussions'))) || (chkAllowedModule(array('blog'))) || (chkAllowedModule(array('article'))) }
<div class="clsSubscribersInformation clsRecentblogarticleforumTable">
	<div class="clsIndexOtherBlocksContainer">
    	<div class="clsJQCarousel" id="recentListTabs">
		  <table {$myobj->defaultTableBgColor}>
			<tr>
			  <th {$myobj->defaultBlockTitle}> 
				 <ul class="clsJQCarouselInfoTabs clsOverflow clsOtherTabs">
					  {if chkAllowedModule(array('discussions'))}
					  <li><a href="#idDiscussionContent">{$LANG.common_boards}</a></li>
					  {/if}
					  {if chkAllowedModule(array('blog'))}
					  <li><a href="#idBlogContent">{$LANG.common_blogs}</a></li>
					  {/if}
					  {if chkAllowedModule(array('article'))}              
					  <li><a href="#idArticleContent">{$LANG.common_article}</a></li>
					  {/if}
					</ul>
			  </th>
		   </tr>
	       <tr>  
              <td>            
				  <div id="idDiscussionContent">
						{$myobj->populateRecent('recentboard')}    
				  </div> 
				  <div id="idBlogContent">
					{$myobj->populateRecent('recentblog')}    
				  </div>
				  <div id="idArticleContent">
					{$myobj->populateRecent('recentarticle')}           
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
		attachJqueryTabs('recentListTabs');
	});
	{/literal}
</script>
{/if}