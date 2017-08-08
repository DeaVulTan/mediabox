<div class="clsSideBarLinks" id="selExtURL">
<div class="clsSideBar"><div class="clsSideBarLeft">
<span class="clsSideBarLeftClose"></span><p class="clsSideBarLeftTitle">{$LANG.header_index_title_urls}</p>
</div>

<div class="clsSideBarRight">
<div class="clsSideBarContent">
{if $exturl_link_arr!=0}
	<ul>
{foreach key=inc item=value from=$$exturl_link_arr}  					
		 <li>
		 	<div id="selExtURLDetail">
				<p class="clsExtURLSpec">{$value.exturl_link}</p>
			</div>
		</li>
{/foreach}
	</ul>
			  <p class="clsMoreTags"><a href="{$myobj->getUrl('exturl')}">{$LANG.header_nav_urls_more_urls}</a></p>
{else}				
       {$LANG.header_exturl_no_exturl}
{/if}
</div></div></div></div>