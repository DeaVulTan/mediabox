<div id="selMusicCategory">
{$myobj->setTemplateFolder('general/','music')}
{include file='box.tpl' opt='audioindex_top'}

    <div class="clsOverflow">
    {*MUSIC LIST TITLE STARTS*}
        <div class="clsHeadingLeft">                        
            <h2><span>{$LANG.musiccategory_page_title}</span></h2>
        </div>
        <div class="clsHeadingRight">
            	<div class="clsBackToCategory"> 
            {if $myobj->getFormField('category_id') != ''}
            <a href="{$myobj->getUrl('musiccategory', '', '', 'members', 'music')}">{$LANG.musiccategory_back_to_category}</a>
           {/if}
     </div>
        </div>
    </div>

    <div id="topLinks">
    {if $CFG.admin.navigation.top}
        <div class="clsAudioPaging">
		{$myobj->setTemplateFolder('general/','music')}
		{include file=pagination.tpl}
		</div>
    {/if}
    </div>
    <div class="clsLeftNavigation" id="selLeftNavigation">
	{if $myobj->isShowPageBlock('form_show_category')}
		<div id="selShowAllShoutouts" class="clsDataTable clsCategoryTable">
			<div id="">
            <table summary="{$LANG.musiccategory_tbl_summary}" id="selCategoryTable" class="cls5TdTable">
	        {if !$myobj->isResultsFound()}
    	    <tr>
				<td>{$LANG.musiccategory_no_category}</td>
			</tr>
            {else}
				{assign var=inc value=0}
				{assign var='count' value='0'} 
				{foreach from=$myobj->form_show_category item=result key=count name=categorylist}
				{$result.open_tr}
					<td id="selMusicGallery" class="clsMusicCategoryCell">
								<div class="clsChannelLeftContent">
								<div class="clsLargeThumbImageBackground">
								  <a href="{$result.music_link}" class="ClsImageContainer ClsImageBorder1 Cls132x88">
										<img src="{$result.category_image}" alt="{$result.record.music_category_name|truncate:5}" {$myobj->DISP_IMAGE(132, 88, $CFG.admin.musics.category_width, $CFG.admin.musics.category_height)} />
								  </a>
								</div>
								</div>
						<div id="selImageDet" class="clsChannelRightContent">
							<h3>
								<a href="{$result.music_link}" title="{$result.record.music_category_name}">
									{$result.record.music_category_name}
								</a>
							</h3>
							<p>
								<span class="clsBold">{$LANG.search_option_today}: </span>
								{$result.today_category_count}
								&nbsp;|&nbsp;
								<span class="clsBold">{$LANG.musiccategory_total}</span>
								{$result.record.music_category_count}
							</p>
						{if $result.content_filter}
						  <div class="clsOverflow">
							<div class="clsSubCategory">
							  <ul>
								<li>{if $myobj->getFormField('category_id')==''}<a href="{$result.record.music_sub_url}"  class="clsSubCategoryIcon clsPhotoVideoEditLinks" title="{$LANG.musiccategory_music_subcategory}">{$LANG.musiccategory_music_subcategory}</a></li>
								<li class="clsGenereType">|</li>{/if}
								<li class="clsGenereType">{$LANG.genre_type}:</li>
								<li class="clsCategoryType">{$result.record.music_category_type}</li>
							  </ul>
							 </div>
								{*SUBSCRIPTION LINK STARTS HERE*}
												  {*SUBSCRIPTION LINK ENDS HERE*}
							</div>
						{/if}
						</div>
						  <!-- <p><span class="clsBold">{$LANG.genre_description}</span>:</p>
						   <p class="clsDesc">{$result.record.music_category_description}</p>-->
						</div>						
					</td>
							   
				{$result.end_tr}
				{counter  assign=count}
				{if $count%$CFG.admin.musics.catergory_list_per_row eq 0}
					{counter start=0}
				{/if}
            {/foreach}
            {assign var=cols  value=$CFG.admin.musics.catergory_list_per_row-$count}
           {if $count}
                {section name=foo start=0 loop=$cols step=1}
                    <td>&nbsp;</td>
                {/section}
            {/if}
            {/if}
			</table>
			</div>
                <div id="bottomLinks">
    {if $CFG.admin.navigation.bottom}
        <div class="clsAudioPaging">
		{$myobj->setTemplateFolder('general/','music')}
		{include file='pagination.tpl'}
		</div>
    {/if}
    </div>

		</div>
    {/if}
	</div>

{$myobj->setTemplateFolder('general/','music')}
{include file='box.tpl' opt='audioindex_bottom'}    
</div>