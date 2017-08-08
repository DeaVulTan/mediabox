{$myobj->setTemplateFolder('general/','music')}
{include file="box.tpl" opt="audioindex_top"}
<div class="clsAudioListContainer clsAudioPlayListContainer">
    {if $myobj->isShowPageBlock('search_albumlist_block')}
        <form id="seachAdvancedFilter" name="seachAdvancedFilter" method="post" action="{$myobj->getCurrentUrl()}">
            <input type="hidden" name="advanceFromSubmission" value="1"/>
            <input type="hidden" name="start" value="{$myobj->getFormField('start')}" />
            <div class="clsOverflow">
                    <div class="clsHeadingLeft">
                        <h2>
                            {if $myobj->page_heading != ''}
                                {$myobj->page_heading}
                            {else}
                                {$LANG.albumviewsort_title}
                            {/if}
                        </h2>
                    </div>
                      <div class="clsHeadingRight clsVideoListHeadingRightLink clsAlphaShortListing">
                    	<h2>
						    <a href="{$myobj->getUrl('albumlist', '?pg=albumlistnew', 'albumlistnew/','','music')}" title="{$LANG.albumviewsort_album_normal_list_link}">{$LANG.albumviewsort_album_normal_list_link}</a>
						</h2>
                    </div>
                    </div>
         </form>
    {/if}
</div>
<div id="advancedAlbumlistSearch" class="clsAdvancedFilterContainer clsAdvancedFilterAlbumSortList">
		<form id="seachAdvancedFilter" name="seachAdvancedFilter" method="post" action="{$myobj->getCurrentUrl()}">
            <table class="clsAdvancedFilterTable">
                <tr>
                    <td class="clsAlphaListing">
                        <input class="clsTextBox" type="text" name="album_src_chr" id="album_src_chr" onfocus="clearValue('album_src_chr')"  onblur="setOldValue('album_src_chr')"
						 value="{if $myobj->getFormField('album_src_chr') == '' && $myobj->getFormField('album_chr') == ''}{$LANG.albumviewsort_no_of_title}{else}{if $myobj->getFormField('album_src_chr') == ''}{$myobj->getFormField('album_chr')}{else}{$myobj->getFormField('album_src_chr')}{/if}{/if}"/>
					    {$myobj->getFormFieldErrorTip('album_src_chr')}
						{$myobj->ShowHelpTip('album_src_chr')}
                    </td>
                    <td>
                        <div class="clsSubmitButton-l"><span class="clsSubmitButton-r"><input type="submit" name="search" id="search" value="{$LANG.albumviewsort_search}" onclick="albumViewListRedirect({$myobj->getFormField('album_src_chr')})" /></span></div>
                       <div class="clsCancelButton1-l"><span class="clsCancelButton1-r"><input type="submit" value="Reset" id="avd_reset" name="avd_reset"/></span></div>
                    </td>
                </tr>
            </table>
        </form>

 </div>
{if  $myobj->isShowPageBlock('list_albumlist_block')}
    <div id="selMusicPlaylistManageDisplay" class="clsLeftSideDisplayTable">
          {if $myobj->isResultsFound() && $showAlbumlists_arr.row!=''}
               {if $CFG.admin.navigation.top}
                <div class="clsOverflow clsSortByLinksContainer">
                    <div class="clsAudioPaging">
						{$myobj->setTemplateFolder('general/','music')}
						{include file=pagination.tpl}
					</div>
                </div>
                {/if}
                <div class="clsAlbumSortlistContent">
                    <div class="clsAlbumSortListTitle">
                        <h4 class="">{$myobj->getFormField('album_chr')}</h4>
                    </div>
                    <div class="clsAlbumShotListDetails">
                        <table width="100%" class="">
                            {foreach key=musicAlbumlistKey item=musicalbumlist from=$showAlbumlists_arr.row}
                            <tr>
								<td>{$musicalbumlist.album_title}{$musicalbumlist.song_count}{$musicalbumlist.album_title_end}</td>
							</tr>
                            {/foreach}
                         </table>
                     </div>
                     <p class="clsBack">
                        <a href="{$myobj->getUrl('albumsortlist', '', '','','music')}" title="{$LANG.albumviewsort_back}">{$LANG.albumviewsort_back} </a>
                     </p>
                 </div>
                {if $CFG.admin.navigation.bottom}
                    <div id="bottomLinks" class="clsAudioPaging">
						{$myobj->setTemplateFolder('general/','music')}
                        {include file='pagination.tpl'}
                    </div>
                    <input type="hidden" name="start" value="{$myobj->getFormField('start')}" />
                {/if}
                {else}
                <div id="selMsgAlert">
                    <p>{$LANG.albumviewsort_no_records_found}</p>
                </div>
                 <p class="clsBack">
                    <a href="{$myobj->getUrl('albumsortlist', '', '','','music')}" title="{$LANG.albumviewsort_back}">{$LANG.albumviewsort_back} </a>
                 </p>
        {/if}
    </div>
{/if}
{$myobj->setTemplateFolder('general/', 'music')}
{include file="box.tpl" opt="audioindex_bottom"}
