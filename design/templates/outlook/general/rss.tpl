<div id="selRss">
{$myobj->setTemplateFolder('general/')}
{include file='box.tpl' opt='display_top'}
  	<div class="clsPageHeading">
    	<h2>{$LANG.page_title}</h2>
    </div>
	{include file='../general/information.tpl'}
	{if $myobj->isShowPageBlock('rssListBlock') }		
		<div class="clsDataTable clsHeadingLeft"><table summary="{$LANG.tbl_summary}">
			<tr>
				<th colspan="4">{$LANG.video}</th>
			</tr>
			<tr>
				<td class="clsWidth150">{$LANG.recently_added}</td>
				<td><a href="{$myobj->getRssUrl('recentlyAdded')}"><img src="{$CFG.site.url}design/templates/{$CFG.html.template.default}/images/rss.gif" /></a></td>
				{if $CFG.rss_display.yahoo}
					<td><a href="{$myobj->getYahooLink('recentlyAdded')}"><img src="{$CFG.site.url}design/templates/{$CFG.html.template.default}/images/yahoo.gif" /></a></td>
				{/if}
				{if $CFG.rss_display.gmail}
					<td><a href="{$myobj->getGoogleLink('recentlyAdded')}"><img src="{$CFG.site.url}design/templates/{$CFG.html.template.default}/images/google.gif" /></a></td>
				{/if}
                {if $CFG.rss_display.itunes}
					<td><a href="{$myobj->getItunesLink('recentlyAdded')}"><img src="{$CFG.site.url}design/templates/{$CFG.html.template.default}/images/button_itunes.gif" /></a></td>
				{/if}
			</tr>
			<tr>
				<td>{$LANG.top_favorites}</td>
				<td><a href="{$myobj->getRssUrl('topFavorites')}"><img src="{$CFG.site.url}design/templates/{$CFG.html.template.default}/images/rss.gif" /></a></td>
				{if $CFG.rss_display.yahoo}
					<td><a href="{$myobj->getYahooLink('topFavorites')}"><img src="{$CFG.site.url}design/templates/{$CFG.html.template.default}/images/yahoo.gif" /></a></td>
				{/if}
				{if $CFG.rss_display.gmail}
					<td><a href="{$myobj->getGoogleLink('topFavorites')}"><img src="{$CFG.site.url}design/templates/{$CFG.html.template.default}/images/google.gif" /></a></td>
				{/if}
                {if $CFG.rss_display.itunes}
					<td><a href="{$myobj->getItunesLink('topFavorites')}"><img src="{$CFG.site.url}design/templates/{$CFG.html.template.default}/images/button_itunes.gif" /></a></td>
				{/if}
			</tr>
			<tr>
				<td>{$LANG.top_rated}</td>
				<td><a href="{$myobj->getRssUrl('topRated')}"><img src="{$CFG.site.url}design/templates/{$CFG.html.template.default}/images/rss.gif" /></a></td>
				{if $CFG.rss_display.yahoo}
					<td><a href="{$myobj->getYahooLink('topRated')}"><img src="{$CFG.site.url}design/templates/{$CFG.html.template.default}/images/yahoo.gif" /></a></td>
				{/if}
				{if $CFG.rss_display.gmail}
					<td><a href="{$myobj->getGoogleLink('topRated')}"><img src="{$CFG.site.url}design/templates/{$CFG.html.template.default}/images/google.gif" /></a></td>
				{/if}
                {if $CFG.rss_display.itunes}
					<td><a href="{$myobj->getItunesLink('topRated')}"><img src="{$CFG.site.url}design/templates/{$CFG.html.template.default}/images/button_itunes.gif" /></a></td>
				{/if}
			</tr>
		</table></div>
		<div class="clsDataTable clsHeadingLeft"><table summary="{$LANG.tbl_summary}">
			<tr>
				<th colspan="4">{$LANG.most_viewed_videos}</th>
			</tr>
			<tr>
				<td class="clsWidth150">{$LANG.today}</td>
				<td><a href="{$myobj->getRssUrl('todayMostViewed')}"><img src="{$CFG.site.url}design/templates/{$CFG.html.template.default}/images/rss.gif" /></a></td>
				{if $CFG.rss_display.yahoo}
					<td><a href="{$myobj->getYahooLink('todayMostViewed')}"><img src="{$CFG.site.url}design/templates/{$CFG.html.template.default}/images/yahoo.gif" /></a></td>
				{/if}
				{if $CFG.rss_display.gmail}
					<td><a href="{$myobj->getGoogleLink('todayMostViewed')}"><img src="{$CFG.site.url}design/templates/{$CFG.html.template.default}/images/google.gif" /></a></td>
				{/if}			
                {if $CFG.rss_display.itunes}
					<td><a href="{$myobj->getItunesLink('todayMostViewed')}"><img src="{$CFG.site.url}design/templates/{$CFG.html.template.default}/images/button_itunes.gif" /></a></td>
				{/if}
                
                </tr>
			<tr>
			  <td>{$LANG.yesterday}</td>
              
			  <td><a href="{$myobj->getRssUrl('yesterdayMostViewed')}"><img src="{$CFG.site.url}design/templates/{$CFG.html.template.default}/images/rss.gif" /></a></td>
              {if $CFG.rss_display.yahoo}
			  <td><a href="{$myobj->getYahooLink('yesterdayMostViewed')}"><img src="{$CFG.site.url}design/templates/{$CFG.html.template.default}/images/yahoo.gif" /></a></td>
              {/if}
              {if $CFG.rss_display.gmail}
			 <td><a href="{$myobj->getGoogleLink('yesterdayMostViewed')}"><img src="{$CFG.site.url}design/templates/{$CFG.html.template.default}/images/google.gif" /></a></td>
              {/if}
              {if $CFG.rss_display.itunes}
					<td><a href="{$myobj->getItunesLink('yesterdayMostViewed')}"><img src="{$CFG.site.url}design/templates/{$CFG.html.template.default}/images/button_itunes.gif" /></a></td>
				{/if}
		  </tr>
			<tr>
				<td>{$LANG.this_week}</td>
				<td><a href="{$myobj->getRssUrl('thisWeekMostViewed')}"><img src="{$CFG.site.url}design/templates/{$CFG.html.template.default}/images/rss.gif" /></a></td>
				{if $CFG.rss_display.yahoo}
					<td><a href="{$myobj->getYahooLink('thisWeekMostViewed')}"><img src="{$CFG.site.url}design/templates/{$CFG.html.template.default}/images/yahoo.gif" /></a></td>
				{/if}
				{if $CFG.rss_display.gmail}
					<td><a href="{$myobj->getGoogleLink('thisWeekMostViewed')}"><img src="{$CFG.site.url}design/templates/{$CFG.html.template.default}/images/google.gif" /></a></td>
				{/if}			
                {if $CFG.rss_display.itunes}
					<td><a href="{$myobj->getItunesLink('thisWeekMostViewed')}"><img src="{$CFG.site.url}design/templates/{$CFG.html.template.default}/images/button_itunes.gif" /></a></td>
				{/if}
                
                </tr>
			<tr>
				<td>{$LANG.this_month}</td>
				<td><a href="{$myobj->getRssUrl('thisMonthMostViewed')}"><img src="{$CFG.site.url}design/templates/{$CFG.html.template.default}/images/rss.gif" /></a></td>
				{if $CFG.rss_display.yahoo}
					<td><a href="{$myobj->getYahooLink('thisMonthMostViewed')}"><img src="{$CFG.site.url}design/templates/{$CFG.html.template.default}/images/yahoo.gif" /></a></td>
				{/if}
				{if $CFG.rss_display.gmail}
					<td><a href="{$myobj->getGoogleLink('thisMonthMostViewed')}"><img src="{$CFG.site.url}design/templates/{$CFG.html.template.default}/images/google.gif" /></a></td>
				{/if}			
                {if $CFG.rss_display.itunes}
					<td><a href="{$myobj->getItunesLink('thisMonthMostViewed')}"><img src="{$CFG.site.url}design/templates/{$CFG.html.template.default}/images/button_itunes.gif" /></a></td>
				{/if}
                </tr>
			<tr>
				<td>{$LANG.this_year}</td>
				<td><a href="{$myobj->getRssUrl('thisYearMostViewed')}"><img src="{$CFG.site.url}design/templates/{$CFG.html.template.default}/images/rss.gif" /></a></td>
				{if $CFG.rss_display.yahoo}
					<td><a href="{$myobj->getYahooLink('thisYearMostViewed')}"><img src="{$CFG.site.url}design/templates/{$CFG.html.template.default}/images/yahoo.gif" /></a></td>
				{/if}
				{if $CFG.rss_display.gmail}
					<td><a href="{$myobj->getGoogleLink('thisYearMostViewed')}"><img src="{$CFG.site.url}design/templates/{$CFG.html.template.default}/images/google.gif" /></a></td>
				{/if}			
                {if $CFG.rss_display.itunes}
					<td><a href="{$myobj->getItunesLink('thisYearMostViewed')}"><img src="{$CFG.site.url}design/templates/{$CFG.html.template.default}/images/button_itunes.gif" /></a></td>
				{/if}
                </tr>
			<tr>
				<td>{$LANG.all_time}</td>
				<td><a href="{$myobj->getRssUrl('mostViewed')}"><img src="{$CFG.site.url}design/templates/{$CFG.html.template.default}/images/rss.gif" /></a></td>
				{if $CFG.rss_display.yahoo}
					<td><a href="{$myobj->getYahooLink('mostViewed')}"><img src="{$CFG.site.url}design/templates/{$CFG.html.template.default}/images/yahoo.gif" /></a></td>
				{/if}
				{if $CFG.rss_display.gmail}
					<td><a href="{$myobj->getGoogleLink('mostViewed')}"><img src="{$CFG.site.url}design/templates/{$CFG.html.template.default}/images/google.gif" /></a></td>
				{/if}	
                {if $CFG.rss_display.itunes}
					<td><a href="{$myobj->getItunesLink('mostViewed')}"><img src="{$CFG.site.url}design/templates/{$CFG.html.template.default}/images/button_itunes.gif" /></a></td>
				{/if}
                		</tr>
		</table>
  </div>
		<div class="clsDataTable clsHeadingLeft"><table summary="{$LANG.tbl_summary}">
			<tr>
				<th colspan="4">{$LANG.most_discussed_videos}</th>
			</tr>
			<tr>
				<td class="clsWidth150">{$LANG.today}</td>
				<td><a href="{$myobj->getRssUrl('todayMostDiscussed')}"><img src="{$CFG.site.url}design/templates/{$CFG.html.template.default}/images/rss.gif" /></a></td>
				{if $CFG.rss_display.yahoo}
					<td><a href="{$myobj->getYahooLink('todayMostDiscussed')}"><img src="{$CFG.site.url}design/templates/{$CFG.html.template.default}/images/yahoo.gif" /></a></td>
				{/if}
				{if $CFG.rss_display.gmail}
					<td><a href="{$myobj->getGoogleLink('todayMostDiscussed')}"><img src="{$CFG.site.url}design/templates/{$CFG.html.template.default}/images/google.gif" /></a></td>
				{/if}	
                
                {if $CFG.rss_display.itunes}
					<td><a href="{$myobj->getItunesLink('todayMostDiscussed')}"><img src="{$CFG.site.url}design/templates/{$CFG.html.template.default}/images/button_itunes.gif" /></a></td>
				{/if}
                		</tr>
			<tr>
			  <td>{$LANG.yesterday}</td>
			 <td><a href="{$myobj->getRssUrl('yesterdayMostDiscussed')}"><img src="{$CFG.site.url}design/templates/{$CFG.html.template.default}/images/rss.gif" /></a></td>
			 {if $CFG.rss_display.yahoo}
					<td><a href="{$myobj->getYahooLink('yesterdayMostDiscussed')}"><img src="{$CFG.site.url}design/templates/{$CFG.html.template.default}/images/yahoo.gif" /></a></td>
			 {/if}
             {if $CFG.rss_display.gmail}
				 <td><a href="{$myobj->getGoogleLink('yesterdayMostDiscussed')}"><img src="{$CFG.site.url}design/templates/{$CFG.html.template.default}/images/google.gif" /></a></td>
             {/if}
               {if $CFG.rss_display.itunes}
					<td><a href="{$myobj->getItunesLink('yesterdayMostDiscussed')}"><img src="{$CFG.site.url}design/templates/{$CFG.html.template.default}/images/button_itunes.gif" /></a></td>
				{/if}
		  </tr>
			<tr>
				<td>{$LANG.this_week}</td>
				<td><a href="{$myobj->getRssUrl('thisWeekMostDiscussed')}"><img src="{$CFG.site.url}design/templates/{$CFG.html.template.default}/images/rss.gif" /></a></td>
				{if $CFG.rss_display.yahoo}
					<td><a href="{$myobj->getYahooLink('thisWeekMostDiscussed')}"><img src="{$CFG.site.url}design/templates/{$CFG.html.template.default}/images/yahoo.gif" /></a></td>
				{/if}
				{if $CFG.rss_display.gmail}
					<td><a href="{$myobj->getGoogleLink('thisWeekMostDiscussed')}"><img src="{$CFG.site.url}design/templates/{$CFG.html.template.default}/images/google.gif" /></a></td>
				{/if}		
                {if $CFG.rss_display.itunes}
					<td><a href="{$myobj->getItunesLink('thisWeekMostDiscussed')}"><img src="{$CFG.site.url}design/templates/{$CFG.html.template.default}/images/button_itunes.gif" /></a></td>
				{/if}
                	</tr>
			<tr>
				<td>{$LANG.this_month}</td>
				<td><a href="{$myobj->getRssUrl('thisMonthMostDiscussed')}"><img src="{$CFG.site.url}design/templates/{$CFG.html.template.default}/images/rss.gif" /></a></td>
				{if $CFG.rss_display.yahoo}
					<td><a href="{$myobj->getYahooLink('thisMonthMostDiscussed')}"><img src="{$CFG.site.url}design/templates/{$CFG.html.template.default}/images/yahoo.gif" /></a></td>
				{/if}
				{if $CFG.rss_display.gmail}
					<td><a href="{$myobj->getGoogleLink('thisMonthMostDiscussed')}"><img src="{$CFG.site.url}design/templates/{$CFG.html.template.default}/images/google.gif" /></a></td>
				{/if}	
                {if $CFG.rss_display.itunes}
					<td><a href="{$myobj->getItunesLink('thisMonthMostDiscussed')}"><img src="{$CFG.site.url}design/templates/{$CFG.html.template.default}/images/button_itunes.gif" /></a></td>
				{/if}		</tr>
			<tr>
				<td>{$LANG.this_year}</td>
				<td><a href="{$myobj->getRssUrl('thisYearMostDiscussed')}"><img src="{$CFG.site.url}design/templates/{$CFG.html.template.default}/images/rss.gif" /></a></td>
				{if $CFG.rss_display.yahoo}
					<td><a href="{$myobj->getYahooLink('thisYearMostDiscussed')}"><img src="{$CFG.site.url}design/templates/{$CFG.html.template.default}/images/yahoo.gif" /></a></td>
				{/if}
				{if $CFG.rss_display.gmail}
					<td><a href="{$myobj->getGoogleLink('thisYearMostDiscussed')}"><img src="{$CFG.site.url}design/templates/{$CFG.html.template.default}/images/google.gif" /></a></td>
				{/if}	
                {if $CFG.rss_display.itunes}
					<td><a href="{$myobj->getItunesLink('thisYearMostDiscussed')}"><img src="{$CFG.site.url}design/templates/{$CFG.html.template.default}/images/button_itunes.gif" /></a></td>
				{/if}
                		</tr>
			<tr>
				<td>{$LANG.all_time}</td>
				<td><a href="{$myobj->getRssUrl('mostDiscussed')}"><img src="{$CFG.site.url}design/templates/{$CFG.html.template.default}/images/rss.gif" /></a></td>
				{if $CFG.rss_display.yahoo}
					<td><a href="{$myobj->getYahooLink('mostDiscussed')}"><img src="{$CFG.site.url}design/templates/{$CFG.html.template.default}/images/yahoo.gif" /></a></td>
				{/if}
				{if $CFG.rss_display.gmail}
					<td><a href="{$myobj->getGoogleLink('mostDiscussed')}"><img src="{$CFG.site.url}design/templates/{$CFG.html.template.default}/images/google.gif" /></a></td>
				{/if}	
                {if $CFG.rss_display.itunes}
					<td><a href="{$myobj->getItunesLink('mostDiscussed')}"><img src="{$CFG.site.url}design/templates/{$CFG.html.template.default}/images/button_itunes.gif" /></a></td>
				{/if}
                		</tr>
		</table>
  </div>
	{/if}
{include file='box.tpl' opt='display_bottom'}    
</div>	