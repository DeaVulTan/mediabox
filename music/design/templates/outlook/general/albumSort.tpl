{$myobj->setTemplateFolder('general/','music')}
{include file="box.tpl" opt="audioindex_top"}
<div class="clsAudioListContainer clsAudioPlayListContainer">
    {if $myobj->isShowPageBlock('search_albumlist_block')}
            <div class="clsOverflow">
                    <div class="clsHeadingLeft">
                        <h2>
                            {if $myobj->page_heading != ''}
                                {$myobj->page_heading}
                            {else}
                                {$LANG.albumsort_title}
                            {/if}
                        </h2>
                    </div>
                    <div class="clsHeadingRight clsVideoListHeadingRightLink clsAlphaShortListing">
                    	<h2><a href="{$myobj->getUrl('albumlist', '?pg=albumlistnew', 'albumlistnew/','','music')}">{$LANG.albumsort_album_normal_list_link}</a></h2>
                    </div>
                    </div>
    {/if}

<div id="advancedAlbumlistSearch" class="clsAdvancedFilterContainer clsAdvancedFilterAlbumSortList">

		<form id="seachAdvancedFilter" name="seachAdvancedFilter" method="post" action="{$myobj->getCurrentUrl()}">
            <table class="clsAdvancedFilterTable">
                <tr>
                    <td class="clsAlphaListing">
                        <input class="clsTextBox" type="text" name="album_chr" id="album_chr" onfocus="clearValue('album_chr')"  onblur="setOldValue('album_chr')" value="{if $myobj->getFormField('album_chr') == ''}{$LANG.albumsort_no_of_title}{else}{$myobj->getFormField('album_chr')}{/if}"/>
                        {$myobj->getFormFieldErrorTip('album_chr')}
                        {$myobj->ShowHelpTip('album_chr')}
                    </td>
                    <td>
                        <div class="clsSubmitButton-l"><span class="clsSubmitButton-r"><input type="submit" name="search" id="search" value="{$LANG.albumsort_search}" onclick="albumViewListRedirect({$myobj->getFormField('album_chr')})" /></span></div>
                       <div class="clsCancelButton1-l"><span class="clsCancelButton1-r"><input type="submit" value="Reset" id="avd_reset" name="avd_reset"/></span></div>
                    </td>
                </tr>
            </table>
        </form>

 </div>
	{if  $myobj->isShowPageBlock('list_albumlist_block')}
		<div id="selMusicPlaylistManageDisplay" class="clsLeftSideDisplayTable">
		  <form name="selFormAlbumList" id="selFormAlbumList" method="post" action="{$myobj->getCurrentUrl()}">
		  {if $myobj->isResultsFound() && $showAlbumlists_arr.row!=''}
			   {if $CFG.admin.navigation.top}
				<div class="clsOverflow clsSortByLinksContainer">
					<div class="clsAudioPaging">
					{$myobj->setTemplateFolder('general/','music')}
					{include file=pagination.tpl}</div>
				</div>
				{/if}

					{foreach key=musicAlbumlistKey item=musicalbumlist from=$showAlbumlists_arr.row}
						{if $musicalbumlist.album_chr!=''}<div class="clsListContents clsAlbumSortlistContent"><div class="clsAlbumSortListTitle">
							<h4>{$musicalbumlist.album_chr}</h4>
                            <span><a href="{$musicalbumlist.album_chr_url}" title="{$LANG.albumsort_view_all_title}">{$LANG.albumsort_view_all_title}</a></span></div>
						   {$myobj->populateAlbumSortTitle($musicalbumlist.album_chr)}
						   {$myobj->setTemplateFolder('general/', 'music')}
						   {include file=albumSortList.tpl}{/if}
						</div>
					{/foreach}

					{if $CFG.admin.navigation.bottom}
					<div id="bottomLinks" class="clsAudioPaging">
						{$myobj->setTemplateFolder('general/','music')}
						{include file='pagination.tpl'}
					</div>
					{/if}
			{else}
			<div id="selMsgAlert">
				<p>{$LANG.albumsort_no_records_found}</p>
			</div>
		{/if}
        <input type="hidden" name="start" value="{$myobj->getFormField('start')}" />
		</form>
			</div>
		{/if}
    </div>
{$myobj->setTemplateFolder('general/','music')}
{include file="box.tpl" opt="audioindex_bottom"}
