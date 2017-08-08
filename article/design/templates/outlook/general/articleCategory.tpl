{$myobj->setTemplateFolder('general/','article')}
{include file="box.tpl" opt="display_top"}
<div id="selmyobj">
	<div class="clsPageHeading">
    	<h2><span>{$LANG.articlecategory_page_title}</span></h2>
  	</div>
  	<div class="clsLeftNavigation" id="selLeftNavigation">
   		{if $myobj->isShowPageBlock('form_show_category')}
    		<div id="selShowAllShoutouts">
	 			{if $myobj->isResultsFound()}
	 				{if $CFG.admin.navigation.top}
    						{$myobj->setTemplateFolder('general/','article')}
          					{include file='pagination.tpl'}
          			{/if}
      				<div class="clsDataTable clsCategoryTable">
        				<table border="1" cellspacing="0" summary="{$LANG.articlecategory_tbl_summary}" id="selCategoryTable">
					    {assign var=countt value=1}
					    {assign var=inc value=0}
					    {assign var='count' value='0'}
          				{foreach from=$myobj->form_show_category item=result key=count name=categorylist}
           					{$result.open_tr}
                  				<td id="selArticleGallery" class="clsArticleCategoryCell">
                        			<div class="clsArticleListCont">
                          				<div class="clsOverflow" id="selPhotCategoryImageDisp">
                            				<div id="selImageBorder">
                              					<div class="clsThumbImageLink">
                                					<a href="Redirect2URL('{$result.article_link}')" class="ClsImageContainer ClsImageBorder1 Cls132x100 clsPointer">
                                    							<img src="{$result.category_image}" title="{$result.record.article_category_name}" alt="{$result.record.article_category_name}"/>
                              						</a>
                            					</div>
                          					</div>
                      						<div id="selImageDet" class="clsArticleNameHd">
                        						<h3><a href="{$result.article_link}" title="{$result.record.article_category_name}">{$result.record.article_category_name}</a></h3>
                        						<p><span class="">{$LANG.articlecategory_today}</span>{$result.today_category_count}&nbsp;|&nbsp;<span class="">{$LANG.articlecategory_total}</span>{$result.record.article_category_count}</p>
    						                </div>
                      						{if $result.content_filter}
												<p>{$LANG.genre_type}:<span> {$result.record.article_category_type}</span></p>
											{/if}
                      						{*<p class="clsDesc">{$LANG.genre_description}: <span>{$result.record.article_category_description}</span></p>*}
                      					</div>
                      				</div>
                				</td>
            				{$result.end_tr}
            				{counter  assign=count}
            				{if $count%$CFG.admin.articles.catergory_list_per_row eq 0}
            					{counter start=0}
            				{/if}
            				{assign var=countt value=$countt+1}
            			{/foreach}
            			{assign var=cols  value=$CFG.admin.articles.catergory_list_per_row-$count}
           				{if $count}
                			{section name=foo start=0 loop=$cols step=1}
                    			<td>&nbsp;</td>
                			{/section}
            			{/if}
        				</table>
      				</div>
      				{if $CFG.admin.navigation.bottom}
    					{$myobj->setTemplateFolder('general/','article')}
      					{include file='pagination.tpl'}
      				{/if}
      			{else}
      				<div id="selMsgError" class="clsNoArticlesFound">
        				<p>{$LANG.articlecategory_no_category}<p>
      				</div>
      			{/if}
			</div>
    	{/if}
	</div>
</div>
{$myobj->setTemplateFolder('general/','article')}
{include file="box.tpl" opt="display_bottom"}