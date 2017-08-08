{$myobj->setTemplateFolder('general/', 'music')}
{include file="box.tpl" opt="audioindex_top"}
<div class="clsAudioListContainer">
<script type="text/javascript" language="javascript" src="{$CFG.site.project_path_relative}js/AG_ajax_html.js"></script>
<script type="text/javascript" language="javascript">
	var block_arr= new Array('selMsgConfirm', 'selMsgConfirmMulti', 'selEditMusicComments','selMsgCartSuccess');
	var max_width_value = "{$CFG.admin.musics.get_code_max_size}";
	var delLink_value;
</script>
{if $myobj->isResultsFound}
{* TO GENERATE PLAYLIST PLAYER *}
			{** @param string $div_id
			 * @param string $music_player_id
			 * @param integer $width
			 * @param integer $height
			 * @param string $auto_play
			 * @param boolean $hidden
			 * @param boolean $playlist_auto_play
 		     	 * @param boolean $javascript_enabled
                   * @param boolean $player_ready_enabled *}
	{$myobj->populatePlayerWithPlaylist($music_fields)}
	<input type="hidden" name="hidden_player_status" id="hidden_player_status" value="" />
    {/if}
    <form id="seachAdvancedFilter" name="seachAdvancedFilter" method="post" action="{$myobj->getCurrentUrl()}">
        <div class="clsOverflow">
	        <input type="hidden" name="advanceFromSubmission" value="1"/>
			{$myobj->populateMusicListHidden($paging_arr)}

              <div class="clsHeadingLeft">
                <h2>
                {if $myobj->getFormField('pg')=='usermusiclist'}
                  {$LANG.musiclist_title}
                {else}
                  {$LANG.musiclist_title}
                {/if}
               </h2>
              </div>
              <div class="clsHeadingRight">
                <input type="hidden" name="default" id="default" value="{$myobj->getFormField('default')}" />
                <select name="select" onchange="loadUrl(this)" id="musicselect">
					<option value="{php} echo getUrl('musiclist','?pg=musicnew','musicnew/','','music'){/php}" {if $myobj->getFormField('pg')==''} selected="selected" {/if} >{$LANG.header_nav_music_music_all}</option>
                    <option value="{php} echo getUrl('musiclist','?pg=musicrecent','musicrecent/','','music'){/php}"
                    {if $myobj->getFormField('pg')=='musicrecent'} selected {/if} >
                    {$LANG.header_nav_music_music_new} </option>
                    <!--<option value="{php} echo getUrl('musiclist','?pg=randommusic','randommusic/','','music'){/php}"
                    {if $myobj->getFormField('pg')=='randommusic'} selected {/if} >
                    {$LANG.header_nav_music_music_random} </option>-->
                    <option value="{php} echo getUrl('musiclist','?pg=musictoprated','musictoprated/','','music'){/php}"
                    {if $myobj->getFormField('pg')=='musictoprated'} selected {/if} >
                    {$LANG.header_nav_music_top_rated}</option>
                    <option value="{php} echo getUrl('musiclist','?pg=musicrecommended','musicrecommended/','','music'){/php}"
                    {if $myobj->getFormField('pg')=='musicrecommended'} selected {/if} >
                    {$LANG.header_nav_music_most_recommended}</option>
                    <option value="{php} echo getUrl('musiclist','?pg=musicmostviewed','musicmostviewed/','','music'){/php}"
                    {if $myobj->getFormField('pg')=='musicmostviewed'} selected {/if} >
                    {$LANG.header_nav_music_most_viewed}</option>
                    <option value="{php} echo getUrl('musiclist','?pg=musicmostdiscussed','musicmostdiscussed/','','music'){/php}"
                    {if $myobj->getFormField('pg')=='musicmostdiscussed'} selected {/if} >
                    {$LANG.header_nav_music_most_discussed}</option>
                    <option value="{php} echo getUrl('musiclist','?pg=musicmostfavorite','musicmostfavorite/','','music'){/php}"
                    {if $myobj->getFormField('pg')=='musicmostfavorite'} selected {/if} >
                    {$LANG.header_nav_music_most_favorite}</option>
                    <option value="{php} echo getUrl('musiclist','?pg=musicmostrecentlyviewed','musicmostrecentlyviewed/','','music'){/php}"
                    {if $myobj->getFormField('pg')=='musicmostrecentlyviewed'} selected {/if} >
                    {$LANG.header_nav_music_recently_viewed}</option>
                    <option value="{php} echo getUrl('musiclist','?pg=featuredmusiclist','featuredmusiclist/','','music'){/php}"
                    {if $myobj->getFormField('pg')=='featuredmusiclist'} selected {/if} >
                    {$LANG.header_nav_music_most_featuredmusiclist}</option>
                    <!--<option value="{php} echo getUrl('musiclist','?pg=musicmostlinked','musicmostlinked/','','music'){/php}"
                    {if $myobj->getFormField('pg')=='musicmostlinked'} selected {/if} >
                    {$LANG.header_most_linked}</option>
                    <option value="{php} echo getUrl('musiclist','?pg=musicmostresponded','musicmostresponded/','','music'){/php}"
                    {if $myobj->getFormField('pg')=='musicmostresponded'} selected {/if} >
                    {$LANG.header_most_responded}</option>-->
                  <!--<option value="{php} echo getUrl('albumlist','?pg=albumlistnew','albumlistnew/','','music'){/php}"
                    {if $myobj->getFormField('pg')=='albummusiclist'} selected {/if} >
                    {$LANG.header_nav_music_album_list} </option>-->
                    <!--<option value="{php} echo getUrl('musiccategory','','','','music'){/php}"
                    {if $myobj->getFormField('pg')=='musiccategory'} selected {/if} >
                    {$LANG.header_nav_music_music_category} </option>-->
                </select>
              </div>
          </div>
          {if $myobj->getFormField('pg') == 'musicmostviewed'
              OR $myobj->getFormField('pg') == 'musicmostdiscussed'
              OR $myobj->getFormField('pg') == 'musicmostfavorite'}
              <div class="clsMostDiscusTab">
			  <div class="clsAudioListMenu">
                <ul>
                  <li {$musicActionNavigation_arr.musicMostViewed_0}><a href="javascript:void(0)" onclick="jumpAndSubmitForm('{$musicActionNavigation_arr.music_list_url_0}');"><span >{$LANG.header_nav_members_all_time}</span></a></li>
                  <li {$musicActionNavigation_arr.musicMostViewed_1}><a  href="javascript:void(0)" onclick="jumpAndSubmitForm('{$musicActionNavigation_arr.music_list_url_1}');"><span>{$LANG.header_nav_members_today}</span></a></li>
                  <li {$musicActionNavigation_arr.musicMostViewed_2}><a  href="javascript:void(0)" onclick="jumpAndSubmitForm('{$musicActionNavigation_arr.music_list_url_2}');"><span>{$LANG.header_nav_members_yesterday}</span></a></li>
                  <li {$musicActionNavigation_arr.musicMostViewed_3}><a  href="javascript:void(0)" onclick="jumpAndSubmitForm('{$musicActionNavigation_arr.music_list_url_3}');"><span>{$LANG.header_nav_members_this_week}</span></a></li>
                  <li {$musicActionNavigation_arr.musicMostViewed_4}><a  href="javascript:void(0)" onclick="jumpAndSubmitForm('{$musicActionNavigation_arr.music_list_url_4}');"><span>{$LANG.header_nav_members_this_month}</span></a></li>
                  <li {$musicActionNavigation_arr.musicMostViewed_5}><a  href="javascript:void(0)" onclick="jumpAndSubmitForm('{$musicActionNavigation_arr.music_list_url_5}');"><span>{$LANG.header_nav_members_this_year}</span></a></li>
                </ul>
              </div>
			  </div>
              {literal}
                  <script type="text/javascript">
                    function jumpAndSubmitForm(url)
                      {
                        document.seachAdvancedFilter.start.value = '0';
						document.seachAdvancedFilter.action=url;
                        document.seachAdvancedFilter.submit();
                      }
                    var subMenuClassName1='clsAudioListMenu';
                    var hoverElement1  = '.clsAudioListMenu li';
                    loadChangeClass(hoverElement1,subMenuClassName1);
                  </script>
              {/literal}
          {/if}
            {$myobj->setTemplateFolder('general/','music')}
			{include file='information.tpl'}

			{if $myobj->isShowPageBlock('form_show_sub_category')}
                {if $populateSubCategories_arr.row}
                {/if}
                <div id="selShowAllShoutouts" class="clsDataTable">
               		<table id="selCategoryTable" class="clsSubCategoryTable">
                {foreach key=subCategoryItem item=subCategoryValue from=$populateSubCategories_arr.row}
                {$subCategoryValue.open_tr}
                <td id="selVideoGallery_{$subCategoryItem}" class="clsVideoCategoryCell">
                    <div id="selImageDet">
                    <h3>
                        <div class="clsOverflow"><span class="clsViewThumbImage">
                        <a href="{$subCategoryValue.music_list_url}">
                        <img src="{$subCategoryValue.imageSrc}" /></a>
                        </span></div>
                        <a href="{$subCategoryValue.music_list_url}">
                        {$subCategoryValue.music_category_name_manual}
                        </a>
                    </h3>
                    </div>
                </td>
                {$subCategoryValue.end_tr}
                {foreachelse}
                {/foreach}
                </table>
                </div>
			{/if}
         {if $myobj->getFormField('pg')!='albumlist' }
		 <div class="clsOverflow clsshowhidefiltersblock">
        	<div class="clsAdvancedFilterSearch clsOverflow clsFloatLeft">
                <a href="javascript:void(0)" id="show_link" class="clsShow"  {if $myobj->chkAdvanceResultFound()}  style="display:none" {/if} onclick="divShowHide('advanced_search', 'show_link', 'hide_link')"><span>{$LANG.musiclist_show_adv_search}</span></a>
                <a href="javascript:void(0)" id="hide_link" {if !$myobj->chkAdvanceResultFound()}  style="display:none" {/if} class="clsHide"  onclick="divShowHide('advanced_search', 'show_link', 'hide_link')"><span>{$LANG.musiclist_hide_adv_search}</span></a>
             </div>
			 <div class="clsAdvancedFilterSearch clsOverflow clsFloatLeft">
                <a href="javascript:void(0)" id="show_alpha_link" class="clsShow"  {if $myobj->chkAlphabeticalResultFound()}  style="display:none" {/if} onclick="divShowHide('alpha_search', 'show_alpha_link', 'hide_alpha_link')"><span>{$LANG.musiclist_show_alpha_search}</span></a>
                <a href="javascript:void(0)" id="hide_alpha_link" {if !$myobj->chkAlphabeticalResultFound()}  style="display:none" {/if} class="clsHide"  onclick="divShowHide('alpha_search', 'show_alpha_link', 'hide_alpha_link')"><span>{$LANG.musiclist_hide_alpha_search}</span></a>
             </div>
			</div>
            <div id="advanced_search" class="clsAdvancedFilterTable clsOverflow" {if $myobj->chkAdvanceResultFound()}  style="display:block {else} style="display:none;  {/if}margin:1px 0 10px;" >
				<div class="clsAdvanceSearchIcon">
              	  <table class="">
                <tr>
	             {if $CFG.admin.musics.music_artist_feature}
	                   <td>
	                    <input class="clsTextBox" type="text" name="advan_music_artist" id="advan_music_artist" value="{if $myobj->getFormField('advan_music_artist') == ''}{$LANG.musiclist_artist_cast}{else}{$myobj->getFormField('advan_music_artist')}{/if}" onblur="setOldValue('advan_music_artist')"  onfocus="clearValue('advan_music_artist', '{$LANG.musiclist_artist_cast}')"/>
	                  </td>
	                  {else}
                     <td>
	                    <input class="clsTextBox" type="text" name="advan_music_user_name" id="advan_music_user_name" value="{if $myobj->getFormField('advan_music_user_name') == ''}{$LANG.musiclist_user_name}{else}{$myobj->getFormField('advan_music_user_name')}{/if}" onblur="setOldValue('advan_music_user_name')"  onfocus="clearValue('advan_music_user_name', '{$LANG.musiclist_user_name}')"/>
	                  </td>
	              {/if}
                  <td>
                    <input class="clsTextBox" type="text" name="advan_music_album_name" id="advan_music_album_name" value="{if $myobj->getFormField('music_album_name') == ''} {$LANG.musiclist_album_name}{else}{$myobj->getFormField('music_album_name')}{/if}" onblur="setOldValue('advan_music_album_name')"  onfocus="clearValue('advan_music_album_name', '{$LANG.musiclist_album_name}')" />
                  </td>
                </tr>
                <tr>
                  <td>
                    <input class="clsTextBox" type="text" name="music_tags" id="music_tags" value="{if $myobj->getFormField('music_tags') != ''}{$myobj->getFormField('music_tags')}{elseif $myobj->getFormField('tags') != ''}{$myobj->getFormField('tags')}{else}{$LANG.musiclist_tags}{/if}" onblur="setOldValue('music_tags')"  onfocus="clearValue('music_tags', '{$LANG.musiclist_tags}')"/>
                  </td>
                <td>
                  <select name="run_length" id="run_length">
                  <option value="">{$LANG.musiclist_run_length}</option>
                  {$myobj->generalPopulateArray($myobj->MUSICRUN_LENGTH_ARR, $myobj->getFormField('run_length'))}
                  </select>
				</td>

                </tr>
                <tr>
                  <td>
                  <select name="added_within" id="added_within">
                  <option value="">{$LANG.musiclist_added_within}</option>
                  {$myobj->generalPopulateArray($myobj->ADDED_WITHIN_ARR, $myobj->getFormField('added_within'))}
                  </select>
                  </td>
                  <td>
    	          	  <select name="music_language" id="music_language">
	                    <option value="">{$LANG.musiclist_language_list}</option>
                        {$myobj->generalPopulateArray($myobj->LANG_LANGUAGE_ARR, $myobj->getFormField('music_language'))}
                      </select>
                  </td>
                </tr>
                </table>
				</div>
				<div class="clsAdvancedSearchBtn">
					<table>
						<tr>
                  <td valign="middle">
                  <div class="clsSubmitButton-l"><span class="clsSubmitButton-r"><input type="submit" name="avd_search" id="avd_search"  onclick="document.seachAdvancedFilter.start.value = '0';" value="{$LANG.musiclist_search_categories_musics_submit}" /></span></div>
				  </td></tr>
				  <tr>
				  <td>
                  <div class="clsCancelButton1-l"><span class="clsCancelButton1-r"><input type="submit" name="avd_reset" id="avd_reset" value="{$LANG.musiclist_reset_submit}" /></span></div>                  </td>
                </tr>
					</table>
				</div>
              </div>

                <div id="alpha_search" {if $myobj->chkAlphabeticalResultFound()}  style="display:block {else} style="display:none;  {/if}margin:1px 0 10px;" >
			  		{if $CFG.admin.navigation.top}
					<div class="clsAlpahbetPaging">
			  			{$myobj->setTemplateFolder('general/', 'music')}
                		{include file='box.tpl' opt='form_top'}

                        {$myobj->setTemplateFolder('general/','music')}
              			{include file= alphabetPagination.tpl}

			  			{$myobj->setTemplateFolder('general/', 'music')}
                		{include file='box.tpl' opt='form_bottom'}
			  		</div>
            		{/if}
                </div>

          {/if}
     </form>

          <!--FORM End-->
          <div id="selLeftNavigation">
            <div id="selMsgConfirm" class="clsPopupConfirmation" style="display:none;">
              <p id="msgConfirmText"></p>
              <form name="msgConfirmform" id="msgConfirmform" method="post" action="{$myobj->getCurrentUrl()}" autocomplete="off">
                      <div><p id="selImageBorder" class="clsPlainImageBorder">
                       <span id="delete_music_msg_id"> </span>
					    <p id="selPlainCenterImage">
                          <img id="selVideoId" border="0" src="" alt=""/>
                        </p>
                      </p>
                    </div>
                  <input type="submit" class="clsSubmitButton" name="yes" value="{$LANG.common_yes_option}"
                  tabindex="{smartyTabIndex}" /> &nbsp;
                  <input type="button" class="clsCancelButton" name="no" value="{$LANG.common_no_option}"
                  tabindex="{smartyTabIndex}" onclick="return hideAllBlocks()" />
                  <input type="hidden" name="act" id="act" />
                  <input type="hidden" name="music_id" id="music_id" />
              </form>
            </div>
            <div id="selMsgConfirmMulti" class="clsPopupConfirmation" style="display:none;">
              <p id="msgConfirmTextMulti">{$LANG.musiclist_multi_delete_confirmation}</p>
              <form name="msgConfirmformMulti" id="msgConfirmformMulti" method="post" action="{$myobj->getCurrentUrl()}" autocomplete="off">
                <input type="submit" class="clsSubmitButton" name="yes" value="{$LANG.common_yes_option}"
                tabindex="{smartyTabIndex}" /> &nbsp;
                <input type="button" class="clsSubmitButton" name="no" value="{$LANG.common_no_option}"
                tabindex="{smartyTabIndex}" onclick="return hideAllBlocks()" />
                <input type="hidden" name="music_id" id="music_id" />
                <input type="hidden" name="act" id="act" />
              </form>
            </div>
            <div id="selMsgCartSuccess" class="clsPopupConfirmation" style="display:none;">
              <p id="selCartAlertSuccess"></p>
              <form name="msgCartFormSuccess" id="msgConfirmformMulti" method="post" action="{$myobj->getCurrentUrl()}" autocomplete="off">
                <input type="button" class="clsSubmitButton" name="no" value="{$LANG.common_option_ok}"
                tabindex="{smartyTabIndex}" onclick="return hideAllBlocks()" />
              </form>
            </div>
            <div id="selEditMusicComments" class="clsPopupConfirmation" style="display:none;"></div>
            <form name="musicListForm" id="musicListForm" method="post" action="{$myobj->getCurrentUrl()}" autocomplete="off">
            {if $myobj->isResultsFound}
            <div class="clsSelectAllLinks clsOverflow">
              <p class="clsListCheckBox"><input type="checkbox" class="clsCheckRadio" name="check_all" id="check_all" tabindex="{smartyTabIndex}" onclick="CheckAll(document.musicListForm.name, document.musicListForm.check_all.name)"/></p>
              <p class="clsSubmitButton-l"><span class="clsSubmitButton-r"><input type="button" value="{$LANG.music_list_play}" onClick="getMultiCheckBoxValue('musicListForm', 'check_all', '{$LANG.musicManage_err_tip_select_musics}');if(multiCheckValue!='') playInPlayListPlayer(multiCheckValue);"/></span></p>
              {if isMember()}
              	{if $myobj->allow_quick_mixs}
                      <p class="clsCancelButton-l"><span class="clsCancelButton-r" id="quick_mix"><input type="button" value="{$LANG.common_music_add_to_quick_mix}" onclick="getMultiCheckBoxValueForQuickMix('musicListForm', 'check_all', '{$LANG.musicManage_err_tip_select_musics}');if(quickMixmultiCheckValue!='') updateMusicsQuickMixCount(quickMixmultiCheckValue);"/></span></p>
                 {/if}
					<p class="clsCancelButton-l"><span class="clsCancelButton-r"><input type="button" value="{$LANG.common_music_add_to_playlist}" onclick="getMultiCheckBoxValue('musicListForm', 'check_all', '{$LANG.musiclist_select_titles}');if(multiCheckValue!='') return populateMyPlayList('{$myobj->getCurrentUrl(true)}', 'select', multiCheckValue);" /></span></p>
                 {$myobj->populatePlaylist()}
              {/if}

              {if $myobj->getFormField('pg')=="mymusics" || $myobj->getFormField('pg')=="myfavoritemusics" || $myobj->getFormField('pg')=="myplaylist" || $myobj->getFormField('pg')=="pending" }
                {if $myobj->getFormField('pg')=='mymusics' || $myobj->getFormField('pg')=="pending"}
                  <a href="javascript:void(0)" id="dAltMulti"></a>
                  <p class="clsCancelButton-l"><span class="clsCancelButton-r">
                  <input type="button" class="clsSubmitButton" name="delete_submit" id="delete_submit" tabindex="{smartyTabIndex}" value="{$LANG.common_delete_option}" onclick="deleteMultiCheck('{$LANG.musiclist_select_titles}','{$myobj->my_musics_form.anchor}','{$LANG.musiclist_delete_confirmation}','musicListForm','music_id','mymusicdelete');"/></span></p>
                {/if}
                {if $myobj->getFormField('pg')=='myplaylist'}
                 <p class="clsCancelButton-l"><span class="clsCancelButton-r">
                    <input type="button" class="clsSubmitButton" name="delete_submit" id="delete_submit"
                    tabindex="{smartyTabIndex}" value="{$LANG.common_delete_option}" onclick="deleteMultiCheck('{$LANG.musiclist_select_titles}','{$myobj->my_musics_form.anchor}','{$LANG.musiclist_delete_confirmation}','musicListForm','music_id','myPlaylistMusicDelete');" /></span></p>
                {/if}
                {if $myobj->getFormField('pg')=='myfavoritemusics'}
                   <p class="clsCancelButton-l"><span class="clsCancelButton-r">
                  <input type="button" class="clsSubmitButton" name="delete_submit" id="delete_submit"
                  tabindex="{smartyTabIndex}" value="{$LANG.common_delete_option}" onclick="deleteMultiCheck('{$LANG.musiclist_select_titles}','{$myobj->my_musics_form.anchor}','{$LANG.musiclist_favorite_delete_confirmation}','musicListForm','music_id','myFavoriteMusicsDelete');" /></span></p>
                {/if}
              {/if}
              </div>
              <div id="clsMsgDisplay_playlist_success" class="clsDisplayNone clsPlaylistSuccess"></div>
              {/if}
            <div class="clsOverflow clsSortByLinksContainer">
              <div class="clsSortByLinks">

				 <!-- class="clsActive" -->
				 <ul class="clsOverflow">
				 	<li> {$LANG.music_list_sort_by} </li>
                    <li><a class="{$musicViewNavigation_arr1}" href="javascript:void(0);" onclick="jumpAndFormsubmit('{$LANG.music_list_title}');return false;" title="{$LANG.music_list_title}">{$LANG.music_list_title}</a></li>
                  <li>|</li>
				   <li><a class="{$musicViewNavigation_arr2}" href="javascript:void(0);" onclick="jumpAndFormsubmit('{$LANG.music_list_album}');return false;" title="{$LANG.music_list_album}">{$LANG.music_list_album}</a></li>
				  </ul>
                 <!-- | <a  class="{$musicViewNavigation_arr3}" href="#" onclick="jumpAndFormsubmit('{$LANG.music_list_artist}');">{$LANG.music_list_artist}</a>-->
              </div>
              {if $myobj->isShowPageBlock("my_musics_form")}
                <div class="clsSortByPagination">
                      <div class="clsAudioPaging">
                          {if $CFG.admin.navigation.top}
								{$myobj->setTemplateFolder('general/','music')}
                                {include file=pagination.tpl}
                          {/if}
                      </div>
                </div>
            </div>
            <a href="javascript:void(0)" id="{$myobj->my_musics_form.anchor}"></a>
			<div class="clsMusicListingMainBlock">
              {if $myobj->isResultsFound}
                      {assign var=count value=0}
                      {assign var=song_id value=1}
                      {foreach from=$music_list_result item=result key=inc name=music}
                      {if $smarty.foreach.music.iteration%$myobj->my_musics_form.showMusicList.musicsPerRow==1}
                      {/if}
                            <div class="clsListContents">
                                    <div class="clsOverflow">
                                      <p class="clsListCheckBox">
                                              <input type="checkbox" name="checkbox[]" id="view_music_checkbox_{$result.record.music_id}" value="{$result.record.music_id}" onclick="disableHeading('musicListForm');"/></p>
                                      <div class="clsThumb">
                                                <div class="clsLargeThumbImageBackground clsNoLink">
													  <a id="{$result.anchor}"></a>
                                                      {if $result.img_src}
                                                      <a  href="{$result.view_music_link}" class="ClsImageContainer ClsImageBorder1 Cls144x110"><img src="{$result.img_src}" title="{$result.music_title}" alt="{$result.music_title|truncate:5}" {$myobj->DISP_IMAGE(142, 108, $result.record.thumb_width, $result.record.thumb_height)}/></a>
                                                      {else if $myobj->getFormField('pg')=="albumlist"}
                                                      <p class="ClsImageContainer ClsImageBorder1 Cls144x110"><img src="{$album_music_count_list[$result.music_album_id].img_src}"  title="{$result.music_title}" alt="{$result.music_title|truncate:5}" {$myobj->DISP_IMAGE(142, 108, $album_music_count_list[$result.music_album_id].thumb_width, $album_music_count_list[$result.music_album_id].thumb_height)}/></p>
                                              {/if}
                                        </div>
                                      <div class="clsTime"><!---->{$result.playing_time}</div>

                                      </div>
                                      <div class="clsPlayerImage">
									  		 {if $result.record.allow_ratings == 'Yes'}
											 <p>
                                        	{if $myobj->populateRatingDetails($result.rating)}
                                                {$myobj->populateMusicRatingImages($result.rating,'music')}
                                            {else}
                                               	{$myobj->populateMusicRatingImages(0,'music')}
                                            {/if}	<span>&nbsp; ( {$result.record.rating_count} )</span>
											</p>
                                         {/if}
										 <div class="clsOverflow clsFloatRight clsPlayQuickmix">

                                        {if $result.add_quickmix}
											<div class="clsFloatRight">
                                                {if $result.is_quickmix_added}
                                                      <p class="clsQuickMix" id="quick_mix_added_{$result.music_id}"><a href="javascript:void(0)" class="clsQuickMix-on clsPhotoVideoEditLinks" title="{$LANG.music_list_added_to_quickmix}" >{$LANG.common_music_quick_mix}</a></p>
                                                {else}
                                                      <p class="clsQuickMix" id="quick_mix_added_{$result.music_id}" style="display:none"><a href="javascript:void(0)" class="clsQuickMix-on clsPhotoVideoEditLinks" title="{$LANG.music_list_added_to_quickmix}">{$LANG.common_music_quick_mix}</a></p>

                                                      <p class="clsQuickMix" id="quick_mix_{$result.music_id}"><a href="javascript:void(0)" onclick="updateMusicsQuickMixCount('{$result.music_id}')" class="clsQuickMix-off clsPhotoVideoEditLinks" title="{$LANG.music_list_add_to_quickmix}">{$LANG.common_music_quick_mix}</a></p>
                                               {/if}
											   </div>
                                         {/if}
										  <div class="clsPlayerIcon clsFloatRight">
                                          	<a class="clsPlaySong" id="play_music_icon_{$result.music_id}" onclick="playSelectedSong({$result.music_id})" href="javascript:void(0)"></a>
                                          	<a class="clsStopSong" id="play_playing_music_icon_{$result.music_id}" onclick="stopSong({$result.music_id})" style="display:none" href="javascript:void(0)"></a>                 </div>
                                      	</div>
						  </div>
									  <div class="clsContentDetails">
											<p class="clsHeading"><a  href="{$result.view_music_link}" title="{$result.music_title}">{$result.music_title_word_wrap}</a></p>
											<p class="clsAlbumLink">{$LANG.album_title}: <a  href="{$result.view_album_link}" title="{$result.album_title}">{$result.album_title_word_wrap}</a></p>
											<p>	{if $result.record.music_artist}
															{$LANG.music_list_added_by_artist}
															{if $CFG.admin.musics.music_artist_feature}
																<a href="{$myobj->memberProfileUrl[$result.record.user_id]}">{$result.record.user_name}</a>
															{else}
												{$myobj->getArtistLink($result.record.music_artist, true, 0, $myobj->getFormField('artist'))}
											{/if}
													  {/if}
													</p>
											<p class="clsGeneres">{$LANG.music_genre_in} <a href="{$result.music_category_link}">{$result.music_category_name_word_wrap}</a></p>
											{if ($myobj->getFormField('pg')=="mymusics" || $myobj->getFormField('pg')=="pending" || $result.user_id == $CFG.user.user_id) && $myobj->getFormField('myfavoritemusic') != "Yes"}
										  <ul class="selMusicLinks clsContentEditLinks">
										   {* ADDED THE MANAGE LYRIC LINK *}
											 <li class="clsEdit">
												  <a href="{$result.musicupload_url}" class="clsPhotoVideoEditLinks" title="{$LANG.musiclist_edit_music}">
												  </a>
											  </li>
											  <li class="clsGetCode" id="anchor_getcode_{$result.music_id}">
												  <a href="javascript:void(0)" class="clsPhotoVideoEditLinks" title="{$LANG.musiclist_get_code}"
												  onclick="return getAjaxGetCode('{$result.callAjaxGetCode_url}', '{$result.anchor}','selEditMusicComments','anchor_getcode_{$result.music_id}')">
												  </a>
											  </li>
											  <li class="clsDelete" id="anchor_myvid_{$result.music_id}">
												 <a href="javascript:void(0)" class="clsVideoVideoEditLinks clsPhotoVideoEditLinks" title="{$LANG.musiclist_delete_music}"
												 onclick="return Confirmation('selMsgConfirm', 'msgConfirmform',
												 Array('act','music_id', 'selVideoId', 'delete_music_msg_id'), Array('delete','{$result.music_id}', '{$result.img_src}',
												 '{$result.delete_music_title}'), Array('value','value', 'src', 'innerHTML'), -100, -500,'anchor_myvid_{$result.music_id}');">
												 </a>
											  </li>
										   {if $myobj->getTotalManageLyricCount($result.music_id)>0}
												<li class="clsManageLyrics">
												   <a href="{$result.manage_lyrics_url}" title="{$LANG.musiclist_manage_lyrics}"></a>
												</li>
											{/if}
										  </ul>
										  {/if}
										  {if $myobj->getFormField('myfavoritemusic')=="Yes"}
										  <ul id="selVideoLinks" class="clsContentEditLinks">
											  <li class="clsDelete" id="anchor_myfav_{$result.music_id}">
												<a href="javascript:void(0)" class="clsPhotoVideoEditLinks" title="{$LANG.musiclist_delete_music}"
												onclick="return Confirmation('selMsgConfirm', 'msgConfirmform',
												Array('act','music_id', 'selVideoId', 'delete_music_msg_id'),
												Array('favorite_delete','{$result.music_id}', '{$result.img_src}', '{$result.delete_music_title}'),
												Array('value','value', 'src', 'innerHTML'), -100, -500,'anchor_myfav_{$result.music_id}');">
												</a>
											  </li>
											  <li class="clsGetCode" id="anchor_getcode_{$result.music_id}">
												<a href="javascript:void(0)" class="clsPhotoVideoEditLinks" title="{$LANG.musiclist_get_code}"
												onclick="return getAjaxGetCode('{$result.callAjaxGetCode_url}', '{$result.anchor}','selEditMusicComments','anchor_getcode_{$result.music_id}')">
												</a>
											  </li>
										  </ul>
										  {/if}
									  </div>
                                    </div>
									<div>
									 {literal}
                                    <script type="text/javascript">
										$Jq(window).load(function(){
											$Jq("#trigger_{/literal}{$result.music_id}{literal}").click(function(){
												displayMusicMoreInfo('{/literal}{$result.music_id}{literal}');
												return false;
											});
										});
									</script>
                                    {/literal}
										<div class="clsMoreInfoContainer clsOverflow">
									  <a class="clsMoreInformation" id="trigger_{$result.music_id}">
										  <span>{$LANG.header_nav_more_info}</span>
									  </a>
									  </div>
										<div class="clsMoreInfoBlock" id="panel_{$result.music_id}" style="display:none;" >
										<div class="clsMoreInfoContent clsOverflow">
											<div class="clsOverflow">
												<table>
													<tr>
														<td>
															<span>{if $CFG.admin.musics.music_artist_feature} {$LANG.music_list_more_cast} {else} {$LANG.music_list_added_by} {/if}</span>
															<span class="clsMoreInfodata">
															   {if $CFG.admin.musics.music_artist_feature}{$myobj->getArtistLink($result.record.music_artist, true, 0, $myobj->getFormField('artist'))}
																	  {else}
																 <a href="{$myobj->memberProfileUrl[$result.record.user_id]}" title="{$result.record.user_name}">{$result.record.user_name}</a>
															 {/if}
															</span>
														</td>
														 <td>
															  <span>{$LANG.music_list_added_date}</span>
															 <span class="clsMoreInfodata">{$result.date_added}</span>
														</td>
													  </tr>
													<tr>
														<td>
															<span>{$LANG.music_list_plays}</span>
															<span class="clsMoreInfodata">{$result.record.total_plays}</span>
														</td>
														<td>
															 <span>{$LANG.music_list_commented}</span>
															  <span class="clsMoreInfodata">{$result.record.total_comments}</span>
														</td>
													</tr>
													<tr>
														 <td>
															<span>{$LANG.music_list_favorite}</span>
															<span class="clsMoreInfodata">{$result.record.total_favorites}</span>
														</td>

														<td> {if $result.record.allow_ratings == 'Yes'}
																 <span>{$LANG.music_list_ratted}</span>
																  <span class="clsMoreInfodata">{$result.rating} ({$result.total_rating} {$LANG.musiclist_ratted})</span>
															  {/if}
														</td>
													</tr>
													 <tr>
														 <td>
															<span>{$LANG.music_list_year_released}</span>
															<span class="clsMoreInfodata">{if $result.record.music_year_released}{$result.record.music_year_released}{else}{$LANG.common_not_available}{/if}</span>
														</td>
														 <td>
															 <span>{$LANG.musiclist_language_list}: </span>
															 <span class="clsMoreInfodata">{if $result.music_language_val}{$result.music_language_val}{else}{$LANG.common_not_available}{/if}</span>
														</td>
													 </tr>
											   </table>
											</div>
											{if $myobj->getFormField('music_tags') != ''}
												{assign var=music_tag value=$myobj->getFormField('music_tags')}
											{elseif $myobj->getFormField('tags') != '' }
												{assign var=music_tag value=$myobj->getFormField('tags')}
											{else}
												{assign var=music_tag value=''}
											{/if}
										   <p class="clsMoreinfoTags">{$LANG.music_list_tags}: {if $result.record.music_tags!=''}{$myobj->getMusicTagsLinks($result.record.music_tags,5, $music_tag)}{else}{$LANG.common_not_available}{/if}</p>
										   <p class="clsDescription"><span class="clsLabel">{$LANG.music_list_description}</span>: {if $myobj->getDescriptionForMusicList($result.record.music_caption)}{$myobj->getDescriptionForMusicList($result.record.music_caption)}{else}{$LANG.common_not_available}{/if}
											{foreach from=$getDescriptionLink_arr item=descriptionsValue}
											{$descriptionsValue.wordWrap_mb_ManualWithSpace_description_name}
											{/foreach}
                                           </p>

										</div>
					  </div>
									</div>

              			 </div>
					{if $smarty.foreach.music.iteration%$myobj->my_musics_form.showMusicList.musicsPerRow==0}
					{/if}
						{assign var=song_id value=$song_id+1}
					{/foreach}
					{else}
					<div id="selMsgAlert">
					  <p>{$LANG.common_music_no_records_found}</p>
					</div>
					{/if}
            {/if}
			</div>
            <div class="clsAudioPaging">
                {if $CFG.admin.navigation.bottom}
				{$myobj->setTemplateFolder('general/','music')}
                {include file=pagination.tpl}
                {/if}
            </div>
                {*{if $CFG.admin.navigation.bottom}
				{$myobj->setTemplateFolder('general/','music')}
                {include file= alphabetPagination.tpl}
                {/if}*}
                </form>
          </div>
</div>
{$myobj->setTemplateFolder('general/','music')}
{include file='box.tpl' opt='audioindex_bottom'}
