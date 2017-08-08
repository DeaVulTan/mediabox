<div class="clsPhotoListContainer clsOverflow">
{$myobj->setTemplateFolder('general/','photo')}
{include file="box.tpl" opt="photomain_top"}
<div id="photoPlaylist" class="clsOverflow">
        <form id="seachAdvancedFilter" name="seachAdvancedFilter" method="post" action="{$myobj->getCurrentUrl()}">
            {$myobj->populatePhotoListHidden($paging_arr)}
            <div class="clsOverflow">
              <div class="clsHeadingLeft">
                <h2><span>
                    {if $myobj->page_heading != ''}
                        {$myobj->page_heading}
                    {else}
                        {$LANG.photoslidelist_title}
                    {/if}</span>
                </h2>
              </div>
             </div>
            {if $myobj->getFormField('pg') == 'playlistmostviewed' or $myobj->getFormField('pg') == 'playlistmostdiscussed' or $myobj->getFormField('pg') == 'playlistmostfavorite' or $myobj->getFormField('pg') == 'playlistmostlistened'}
                <div class="clsPhotoListMenu">
             		<ul>
                        <li {$photoActionNavigation_arr.cssli_0}>
                        	<a href="javascript:void(0);" onclick="jumpAndSubmitForm('{$photoActionNavigation_arr.photo_list_url_0}')"><span>{$LANG.header_nav_this_all_time}</span></a>
                        </li>
                        <li {$photoActionNavigation_arr.cssli_1}>
							<a href="javascript:void(0);" onclick="jumpAndSubmitForm('{$photoActionNavigation_arr.photo_list_url_1}');"><span>{$LANG.header_nav_members_today}</span></a>
                        </li>
                        <li {$photoActionNavigation_arr.cssli_2}>
                        	<a href="javascript:void(0);" onclick="jumpAndSubmitForm('{$photoActionNavigation_arr.photo_list_url_2}');"><span>{$LANG.header_nav_members_yesterday}</span></a>
                        </li>
                        <li {$photoActionNavigation_arr.cssli_3}>
                       		<a href="javascript:void(0);" onclick="jumpAndSubmitForm('{$photoActionNavigation_arr.photo_list_url_3}');"><span>{$LANG.header_nav_members_this_week}</span></a>
                        </li>
                        <li {$photoActionNavigation_arr.cssli_4}>
                        	<a href="javascript:void(0);" onclick="jumpAndSubmitForm('{$photoActionNavigation_arr.photo_list_url_4}');"><span>{$LANG.header_nav_members_this_month}</span></a>
                        </li>
                        <li {$photoActionNavigation_arr.cssli_5}>
                        	<a href="javascript:void(0);" onclick="jumpAndSubmitForm('{$photoActionNavigation_arr.photo_list_url_5}');"><span>{$LANG.header_nav_members_this_year}</span></a>
                        </li>
                    </ul>
                </div>
                {literal}
					<script type="text/javascript">
						function jumpAndSubmitForm(url)
							{
								document.seachAdvancedFilter.start.value = '0';
								document.seachAdvancedFilter.action=url;
								document.seachAdvancedFilter.submit();
							}
						var subMenuClassName1='clsActiveTabNavigation';
						var hoverElement1  = '.clsTabNavigation li';
						loadChangeClass(hoverElement1,subMenuClassName1);
					</script>
                 {/literal}
            {/if}

           	<div class="clsOverflow clsAddPhotoPlayListLinkHd">
        		<div class="clsAdvancedFilterSearch clsAdvancedFilterSearchAlignment">
                	<a {if $myobj->chkAdvanceResultFound()}  style="display:none" {/if} onclick="divShowHide('advancedPlaylistSearch', 'show_link', 'hide_link')" class="clsShow"   id="show_link" href="javascript:void(0)"><span>{$LANG.photoslidelist_show_advanced_filters}</span></a>
                	<a onclick="divShowHide('advancedPlaylistSearch', 'show_link', 'hide_link')" class="clsHide" {if !$myobj->chkAdvanceResultFound()}  style="display:none" {/if} id="hide_link" href="javascript:void(0)"><span>{$LANG.photoslidelist_hide_advanced_filters}</span></a>
                	<a href="{php} echo getUrl('photoslidelist','?pg=slidelistnew','slidelistnew/','','photo'){/php}" id="show_link" class="clsResetFilter">({$LANG.photoslidelist_reset_search})</a>
            	</div>

            </div>


            <div id="advancedPlaylistSearch" class="clsAdvancedFilterContainer" {if $myobj->chkAdvanceResultFound()}  style="display:block {else} style="display:none;  {/if}margin:0 0 10px 0;">
                {$myobj->setTemplateFolder('general/','photo')}
                {include file='box.tpl' opt='form_top'}
    			  <div class="clsOverflow">
                       <div class="clsAdvancedSearchBg">
                        <table class="clsAdvancedFilterTable">
                        <tr>
                            <td>
                                <input type="text" class="clsTextBox" name="playlist_title" id="playlist_title"   value="{if $myobj->getFormField('playlist_title') == ''}{$LANG.photoslidelist_slidelist_title}{else}{$myobj->getFormField('playlist_title')}{/if}" onblur="setOldValue('playlist_title')"  onfocus="clearValue('playlist_title')"/>
                          </td>
                          <td>
                                <input type="text" class="clsTextBox" name="createby" id="createby" onfocus="clearValue('createby')"  onblur="setOldValue('createby')" value="{if $myobj->getFormField('createby') == ''}{$LANG.photoslidelist_createby}{else}{$myobj->getFormField('createby')}{/if}" />
                          </td>
                        </tr>
                        <tr>
                            <td>
                                <select name="photos" id="photos">
                                  <option value="">{$LANG.photoslidelist_no_of_photos}</option>
                                  {$myobj->generalPopulateArray($myobj->LANG_SEARCH_PHOTO_ARR, $myobj->getFormField('photos'))}
                                </select>

                            </td>
                            <td>
                                <select name="views" id="views">
                                  <option value="">{$LANG.photoslidelist_no_of_views}</option>
                                  {$myobj->generalPopulateArray($myobj->LANG_SEARCH_VIEW_ARR, $myobj->getFormField('views'))}
                                </select>

                            </td>
                        </tr>
                        <tr>
                          <td colspan="2">
                          <div class="clsSearchButton-l"><span class="clsSearchButton-r"><input type="submit" name="search" id="search" value="{$LANG.photoslidelist_search}" /></span></div>
                          <div class="clsResetButton-l"><span class="clsResetButton-r"><input type="submit" value="Reset" id="avd_reset" name="avd_reset"/></span></div>
                          </td>
                        </tr>
                        </table>
                       </div>
                    </div>
                {$myobj->setTemplateFolder('general/','photo')}
                {include file='box.tpl' opt='form_bottom'}
            </div>

        </form>


	{if $myobj->isShowPageBlock('list_playlist_block')}
    	<div id="selPhotoPlaylistManageDisplay">
        {if $myobj->isResultsFound()}
            <div id="" class="clsOverflow clsSlideBorder">

                        <div class="clsSortByPagination">
                            <div class="clsPhotoPaging">
                    		 {if $CFG.admin.navigation.top}
                                {$myobj->setTemplateFolder('general/', 'photo')}
                                {include file=pagination.tpl}
                             {/if}
                            </div>
                        </div>
            </div>
            	<script language="javascript" type="text/javascript">
					original_height = new Array();
					original_width = new Array();
				</script>
                {assign var=count value=1}
				{assign var='array_count' value='1'}
                {foreach key=photoPlaylistKey item=photoplaylist from=$myobj->list_playlist_block.showSlidelists.row}
                 <div class="clsListContents">
                     <div class="clsNewAlbumList {if $count % 3 == 0} clsThumbPhotoFinalRecord{/if}">

                        {$myobj->setTemplateFolder('general/','photo')}
        				{include file="box.tpl" opt="listimage_top"}
                        <div>
                            {*DISPLAY PHOTOS IN PLAYLIST STARTS HERE*}
                                  {$myobj->displayPhotoList($photoplaylist.record.photo_playlist_id, true, 4)}
                                  {$myobj->setTemplateFolder('general/', 'photo')}
	                            {include file=photosInSlideList.tpl}
                            {*DISPLAY PHOTOS IN PLAYLIST ENDS HERE*}
                            <div class="clsAlbumContentDetails">
                            <p class="clsHeading">

								<a href="{if ($photoplaylist.record.total_photos - $photoplaylist.private_photo) > 0}{$photoplaylist.view_playlisturl} {else} # {/if}"  title="{$photoplaylist.record.photo_playlist_name}">
								{$photoplaylist.wordWrap_mb_ManualWithSpace_playlist_title}</a>
                            </p>
                            <p class="clsAlbumContent">
                            	{if $photoplaylist.record.total_photos<=1}
                                	{$LANG.photoslidelist_photo}
                                {else}
                                	{$LANG.photoslidelist_photos}
                                {/if}:&nbsp;<span>{$photoplaylist.record.total_photos}</span>
                            </p>
                             <p class="clsAlbumContent">
                                {if $photoplaylist.private_photo gt 0}{$LANG.photoslidelist_private_label}:&nbsp;<span>{$photoplaylist.private_photo}</span>&nbsp;|&nbsp;{/if}
                                	{$LANG.photoslidelist_total_views}:&nbsp;<span>{$photoplaylist.record.total_views}</span>
                            </p>
							<p class="clsUserLink">
							{$LANG.photoslidelist_createby}:&nbsp;<span><a href="{$photoplaylist.memberProfileUrl}" alt="{$photoplaylist.record.alt_user_name}" title="{$photoplaylist.record.alt_user_name}">{$photoplaylist.record.user_name}</a></span>
							</p>

                            <p class="clsAlbumContent">

								<a href="{if ($photoplaylist.record.total_photos - $photoplaylist.private_photo) > 0}{$photoplaylist.view_playlisturl} {else} # {/if}"  title="{$photoplaylist.record.photo_playlist_name}">
                                {$LANG.photoslidelist_view}
                                </a>
                            </p>

                            </div>
                         </div>
                         {$myobj->setTemplateFolder('general/','photo')}
        				{include file="box.tpl" opt="listimage_bottom"}

                 </div>
				 </div>
				{assign var=count value=$count+1}
                {/foreach}  </div></div>
                  <div id="bottomLinks" class="clsPhotoPaging">
              		 {if $CFG.admin.navigation.bottom}
                    	{$myobj->setTemplateFolder('general/', 'photo')}
                        {include file='pagination.tpl'}
                    {/if}
                  </div>
             {else}
             	<div id="selMsgAlert">
             		<p>{$LANG.photoslidelist_no_records_found}</p>
                </div>
            {/if}

    {/if}

{$myobj->setTemplateFolder('general/', 'photo')}
{include file="box.tpl" opt="photomain_bottom"}
</div>