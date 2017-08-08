<div id="selblogCategory">
{$myobj->setTemplateFolder('general/','blog')}
{include file='box.tpl' opt='blogmain_top'}

    <div class="clsOverflow">
    {*photo LIST TITLE STARTS*}
        <div class="clsListHeadingLeft">
            <h2>{$LANG.blogcategory_page_title}</h2>
        </div>
    </div>
    <div id="topLinks">
      <div class="clsAudioPaging">
       {if $CFG.admin.navigation.top}
        {$myobj->setTemplateFolder('general/','blog')}
        {include file=pagination.tpl}
       {/if}
      </div>
    </div>
    <div class="clsLeftNavigation" id="selLeftNavigation">
	{if $myobj->isShowPageBlock('form_show_category')}
       <div class="clsOverflow">
     	  <div id="selShowAllShoutouts" class="clsDataTable clsCategoryNoPadding clsCategoryTable">
             <div summary="{$LANG.blogcategory_tbl_summary}" id="selCategoryTable" class="cls5TdTable">
	        {if !$myobj->isResultsFound()}
    	    <div><p>{$LANG.blogcategory_no_category}</p></div>
            {/if}
            {assign var=countt value=1}
            {assign var=inc value=0}
            {assign var='count' value='0'}
            {foreach from=$myobj->form_show_category item=result key=count name=categorylist}
           	{$result.open_tr}
            	<div id="selblogGallery" class="clsBlogCategoryCell">
                  <div class="clsNewAlbumList {if $countt % 3 == 0} clsThumbBlogFinalRecord{/if}">
                	  <div class="clsChannelLeftContent">
                            <div class="clsLargeThumbImageBackground">
                              <a class="ClsImageContainer ClsImageBorder1 cls132px101px" href="{$result.blogpost_link}">
                                     <img border="0" src="{$result.category_image}" title="{$result.record.blog_category_name}" />
                              </a>
                            </div>
                            </div>
					  <div id="selImageDet" class="clsBlogViewDetails">
						<p>
							<a href="{$result.blogpost_link}">
								{$result.record.blog_category_name}
							</a>
						</p>
					<p class="clsPaddingTop5">{$LANG.blogcategory_today} <span class="clsBoldFont">{$result.today_category_count}</span>
                    &nbsp;|&nbsp;{$LANG.blogcategory_total}<span class="clsBoldFont">{$result.record.blog_category_count}</span></p>
					{if $result.content_filter}<p class="clsPaddingTop5"><span class="clsBoldFont">{$LANG.genre_type}:</span><span class="clsBlogValues"> {$result.record.blog_category_type}</span></p>{/if}
					   <p class="clsBlogCategoryDesc clsPaddingTop5"><span class="clsBoldFont">{$LANG.genre_description}:</span> <span>{$result.record.blog_category_description}</span></p>
					</div>
                  </div>
				</div>

			{$result.end_tr}
            {counter  assign=count}
            {if $count%$CFG.admin.blog.catergory_list_per_row eq 0}
            	{counter start=0}
            {/if}
            {assign var=countt value=$countt+1}
            {/foreach}
            {assign var=cols  value=$CFG.admin.blog.catergory_list_per_row-$count}
           {if $count}
                {section name=foo start=0 loop=$cols step=1}
                    <p>&nbsp;</p>
                {/section}
            {/if}
         	</div>
          </div>
       </div>
                <div class="clsOverflow clsSlideBorder">
                  <div id="bottomLinks"><div class="clsAudioPaging">
                   {if $CFG.admin.navigation.bottom}
                    {$myobj->setTemplateFolder('general/','blog')}
                    {include file='pagination.tpl'}
                  {/if}
                  </div>
                </div>
           </div>
    {/if}
	</div>

{$myobj->setTemplateFolder('general/','blog')}
{include file='box.tpl' opt='blogmain_bottom'}
</div>
