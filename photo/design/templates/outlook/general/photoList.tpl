{literal}
<script type="text/javascript">
	function resetFormField(url, viewType)
	{
		document.seachAdvancedFilter.thumb.value = viewType;
		document.seachAdvancedFilter.action = url;
		document.seachAdvancedFilter.submit();
	}
</script>
{/literal}

<div class="clsPhotoListContainer clsOverflow">
  <script type="text/javascript" language="javascript" src="{$CFG.site.project_path_relative}js/AG_ajax_html.js"></script>
  <script type="text/javascript" language="javascript">
	var block_arr= new Array('selMsgConfirm', 'selMsgConfirmMulti', 'selEditPhotoComments');
	var delLink_value;
</script>
  {$myobj->setTemplateFolder('general/','photo')}
  {include file="box.tpl" opt="photomain_top"}
  <form id="seachAdvancedFilter" name="seachAdvancedFilter" method="post" action="{$myobj->getCurrentUrl()}" autocomplete="off">
    <input type="hidden" name="advanceFromSubmission" value="1"/>
    {$myobj->populatePhotoListHidden($paging_arr)}
    <div class="clsOverflow">
      <div class="clsHeadingLeft">
        <h2><span> {if $myobj->getFormField('pg')=='userphotolist'}
          {$LANG.photolist_title}
          {else}
          {$LANG.photolist_title}
          {/if} </span></h2>
      </div>
      <div class="clsHeadingRight">
        <input type="hidden" name="default" id="default" value="{$myobj->getFormField('default')}" />
        <select name="select" id="photoselect" onChange="loadUrl(this)">
          <option value="{php} echo getUrl('photolist','?pg=photonew','photonew/','','photo'){/php}" {if $myobj->getFormField('pg')==''} selected {/if} >{$LANG.header_nav_photo_photo_all}</option>
          <option value="{php} echo getUrl('photolist','?pg=photorecent','photorecent/','','photo'){/php}"
                    {if $myobj->getFormField('pg')=='photorecent'} selected {/if} >
          {$LANG.header_nav_photo_photo_new} </option>
          <option value="{php} echo getUrl('photolist','?pg=phototoprated','phototoprated/','','photo'){/php}"
                    {if $myobj->getFormField('pg')=='phototoprated'} selected {/if} >
          {$LANG.header_nav_photo_top_rated}</option>
          <option value="{php} echo getUrl('photolist','?pg=photomostviewed','photomostviewed/','','photo'){/php}"
                    {if $myobj->getFormField('pg')=='photomostviewed'} selected {/if} >
          {$LANG.header_nav_photo_most_viewed}</option>
          <option value="{php} echo getUrl('photolist','?pg=photomostdiscussed','photomostdiscussed/','','photo'){/php}"
                    {if $myobj->getFormField('pg')=='photomostdiscussed'} selected {/if} >
          {$LANG.header_nav_photo_most_discussed}</option>
          <option value="{php} echo getUrl('photolist','?pg=photomostfavorite','photomostfavorite/','','photo'){/php}"
                    {if $myobj->getFormField('pg')=='photomostfavorite'} selected {/if} >
          {$LANG.header_nav_photo_most_favorite}</option>
          <option value="{php} echo getUrl('photolist','?pg=featuredphotolist','featuredphotolist/','','photo'){/php}"
                    {if $myobj->getFormField('pg')=='featuredphotolist'} selected {/if} >
          {$LANG.header_nav_photo_most_featuredphotolist}</option>
		  {if isMember() and chkIsSubscriptionEnabled() and chkIsSubscriptionEnabledForModule()}
		   <option value="{php} echo getUrl('photolist','?pg=subscribedphotolist','subscribedphotolist/','','photo'){/php}"
                    {if $myobj->getFormField('pg')=='subscribedphotolist'} selected {/if} >
          {$LANG.common_subscribed_photo}</option>
		  {/if}
        </select>
      </div>
    </div>
    {$myobj->setTemplateFolder('general/', 'photo')}
    {include file='information.tpl'}
    {if $myobj->getFormField('pg') == 'photomostviewed'
    OR $myobj->getFormField('pg') == 'photomostdiscussed'
    OR $myobj->getFormField('pg') == 'photomostfavorite'}
    <div class="clsPhotoListMenu">
      <ul>
        <li {$photoActionNavigation_arr.photoMostViewed_0}><a href="javascript:void(0)" onClick="jumpAndSubmitForm('{$photoActionNavigation_arr.photo_list_url_0}');" title="{$LANG.header_nav_members_all_time}"><span >{$LANG.header_nav_members_all_time}</span></a></li>
        <li {$photoActionNavigation_arr.photoMostViewed_1}><a  href="javascript:void(0)" onClick="jumpAndSubmitForm('{$photoActionNavigation_arr.photo_list_url_1}');" title="{$LANG.header_nav_members_today}"><span>{$LANG.header_nav_members_today}</span></a></li>
        <li {$photoActionNavigation_arr.photoMostViewed_2}><a  href="javascript:void(0)" onClick="jumpAndSubmitForm('{$photoActionNavigation_arr.photo_list_url_2}');" title="{$LANG.header_nav_members_yesterday}"><span>{$LANG.header_nav_members_yesterday}</span></a></li>
        <li {$photoActionNavigation_arr.photoMostViewed_3}><a  href="javascript:void(0)" onClick="jumpAndSubmitForm('{$photoActionNavigation_arr.photo_list_url_3}');" title="{$LANG.header_nav_members_this_week}"><span>{$LANG.header_nav_members_this_week}</span></a></li>
        <li {$photoActionNavigation_arr.photoMostViewed_4}><a  href="javascript:void(0)" onClick="jumpAndSubmitForm('{$photoActionNavigation_arr.photo_list_url_4}');" title="{$LANG.header_nav_members_this_month}"><span>{$LANG.header_nav_members_this_month}</span></a></li>
        <li {$photoActionNavigation_arr.photoMostViewed_5}><a  href="javascript:void(0)" onClick="jumpAndSubmitForm('{$photoActionNavigation_arr.photo_list_url_5}');" title="{$LANG.header_nav_members_this_year}"><span>{$LANG.header_nav_members_this_year}</span></a></li>
        <li {$photoActionNavigation_arr.photoMostViewed_6}><a  href="javascript:void(0)" onClick="jumpAndSubmitForm('{$photoActionNavigation_arr.photo_list_url_6}');" title="{$LANG.header_nav_members_befor_one_year}"><span>{$LANG.header_nav_members_befor_one_year}</span></a></li>
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
                    var subMenuClassName1='clsPhotoListMenu';
                    var hoverElement1  = '.clsPhotoListMenu li';
                    loadChangeClass(hoverElement1,subMenuClassName1);
                  </script>
    {/literal}
    {/if}

    {if $myobj->isShowPageBlock('form_show_sub_category')}
    {if $populateSubCategories_arr.row}
    <div id='selShowSubcategory' class="clsShowCategory" style="display:none;">{$LANG.photo_list_showphoto_subcategory}</div>
    <div id='selHideSubcategory' class="clsHideCategory">{$LANG.photo_list_hidephoto_subcategory}</div>
    <div id="selShowAllShoutouts" class="clsDataTable">
      <table id="selCategoryTable" class="clsSubCategoryTable">
        {foreach key=subCategoryItem item=subCategoryValue from=$populateSubCategories_arr.row}
        {$subCategoryValue.open_tr}
        <td id="selPhotoGallery_{$subCategoryItem}" class="clsPhotoCategoryCell"><div id="selImageDet">
              <h3>
                <div class="clsOverflow"><span class="clsViewThumbImage"> <a href="{$subCategoryValue.photo_list_url}"> <img src="{$subCategoryValue.imageSrc}"  alt="{$subCategoryValue.photo_category_name_manual}" title="{$subCategoryValue.photo_category_name_manual}"/></a> </span></div>
                <a href="{$subCategoryValue.photo_list_url}" title="{$subCategoryValue.photo_category_name_manual}"> {$subCategoryValue.photo_category_name_manual} </a> </h3>
            </div></td>
          {$subCategoryValue.end_tr}
          {foreachelse}
          {/foreach}
      </table>
    </div>
    {/if}
    {/if}
    {if $myobj->getFormField('pg')!='albumlist' }
    <div class="clsAdvancedFilterSearch" id=""> <a href="javascript:void(0)" id="show_link" class="clsShow"  {if $myobj->chkAdvanceResultFound()}  style="display:none" {/if} onclick="divShowHide('advanced_search', 'show_link', 'hide_link')" title="{$LANG.photolist_show_adv_search}"><span>{$LANG.photolist_show_adv_search}</span></a> <a href="javascript:void(0)" id="hide_link" {if !$myobj->chkAdvanceResultFound()}  style="display:none" {/if} class="clsHide"  onclick="divShowHide('advanced_search', 'show_link', 'hide_link')" title="{$LANG.photolist_hide_adv_search}"><span>{$LANG.photolist_hide_adv_search}</span></a> <a href="{php} echo getUrl('photolist','?pg=photonew','photonew/','','photo'){/php}" id="show_link" class="clsResetFilter" title="{$LANG.photolist_reset_search}">&nbsp;( {$LANG.photolist_reset_search} )</a> </div>
    <div id="advanced_search" {if $myobj->chkAdvanceResultFound()} style="display:block;" {else} style="display:none;"  {/if}>
      {$myobj->setTemplateFolder('general/','photo')}
      {include file='box.tpl' opt='form_top'}
      <div class="clsOverflow">
    	  <div class="clsAdvancedSearchBg">
              <table class="clsAdvancedFilterTable">
                 <tr>
                    <td><input class="clsTextBox" type="text" name="advance_keyword" id="advance_keyword" value="{if $myobj->getFormField('photo_keyword') != ''}{$myobj->getFormField('photo_keyword')}{else}{$LANG.photolist_keyword_field}{/if}" onBlur="setOldValue('advance_keyword')"  onfocus="clearValue('advance_keyword')"/>
                    </td>
                    <td><input class="clsTextBox" type="text" name="advantage_photo_album_name" id="advantage_photo_album_name" value="{if $myobj->getFormField('photo_album_name') == ''} {$LANG.photo_list_album}{else}{$myobj->getFormField('photo_album_name')}{/if}" onBlur="setOldValue('advantage_photo_album_name')"  onfocus="clearValue('advantage_photo_album_name')" />
                    </td>
                </tr>
                <tr>
                   <td><input class="clsTextBox" type="text" name="advantage_photo_owner" id="advantage_photo_owner" value="{if $myobj->getFormField('photo_owner') != ''}{$myobj->getFormField('photo_owner')}{else}{$LANG.photolist_photo_created_by}{/if}" onBlur="setOldValue('advantage_photo_owner')"  onfocus="clearValue('advantage_photo_owner')"/>
                  </td>
                  <td><div id="map_canvas" ></div>
                    <div  id="selLocationTextBox">
                      <input class="clsTextBox" type="text" name="advantage_location" id="advantage_location" value="{if $myobj->getFormField('location') != ''}{$myobj->getFormField('location')}{else}{$LANG.photolist_photo_location}{/if}"  onBlur="setOldValue('advantage_location')"  onfocus="clearValue('advantage_location')"/>
                    </div>
                    <div id="selResult"></div>
                  </td>
                </tr>
              </table>
      </div>
          <div class="clsAdvancedSearchBtn">
              <table>
                <tr>
                  <td colspan="2" align="right" valign="middle"><div class="clsSearchButton-l"><span class="clsSearchButton-r">
                      <input type="submit" name="avd_search" id="avd_search"  onclick="document.seachAdvancedFilter.start.value = '0';" value="{$LANG.photolist_search_categories_photos_submit}" />
                      </span></div>
                   </td>
                </tr>
                <tr>
                   <td>
                    <div class="clsResetButton-l"><span class="clsResetButton-r">
                      <input type="submit" name="avd_reset" id="avd_reset" onclick="document.seachAdvancedFilter.start.value = '0';" value="{$LANG.photolist_reset_submit}" />
                      </span></div>
                    </td>
                </tr>
              </table>
          </div>
      </div>
	  {$myobj->setTemplateFolder('general/','photo')}
      {include file='box.tpl' opt='form_bottom'} </div>
    {/if}
  </form>
  <!--FORM End-->
  <div id="selLeftNavigation">
    <div id="selMsgConfirm" class="clsPopupConfirmation" style="display:none;">
     <div class="clsOverflow">
      <p id="msgConfirmText"></p>
      <form name="msgConfirmform" id="msgConfirmform" method="post" action="{$myobj->getCurrentUrl()}" autocomplete="off">
        <div id="selImageBorder" class="clsPlainImageBorder">
            <div id="delete_photo_msg_id" class="clsPopUpInnerContent"> </div>
            <div id="selPlainCenterImage"> <img id="selPhotoId" border="0" src="" alt=""/> </div>
        </div>
        <div>
        <input type="submit" class="clsPopUpButtonSubmit" name="yes" value="{$LANG.common_yes_option}"
                  tabindex="{smartyTabIndex}" />
        &nbsp;
        <input type="button" class="clsPopUpButtonReset" name="no" value="{$LANG.common_no_option}"
                  tabindex="{smartyTabIndex}" onClick="return hideAllBlocks()" />
        <input type="hidden" name="act" id="act" />
        <input type="hidden" name="photo_id" id="photo_id" />
        </div>
      </form>
     </div>
    </div>

    <div id="selMsgConfirmMulti" class="clsPopupConfirmation" style="display:none;">
	{$myobj->setTemplateFolder('general/','photo')}
    {include file='box.tpl' opt='popupbox_top'}
      &nbsp;
      <p id="msgConfirmTextMulti">{$LANG.photolist_multi_delete_confirmation}</p>
      &nbsp;
      <form name="msgConfirmformMulti" id="msgConfirmformMulti" method="post" action="{$myobj->getCurrentUrl()}" autocomplete="off">
        <input type="submit" class="clsPopUpButtonSubmit" name="yes" value="{$LANG.common_yes_option}"
                tabindex="{smartyTabIndex}" />
        &nbsp;
        <input type="button" class="clsPopUpButtonReset" name="no" value="{$LANG.common_no_option}"
                tabindex="{smartyTabIndex}" onClick="return hideAllBlocks()" />
        <input type="hidden" name="photo_id" id="photo_id" />
        <input type="hidden" name="act" id="act" />
      </form>
	  {$myobj->setTemplateFolder('general/','photo')}
     {include file='box.tpl' opt='popupbox_bottom'}
    </div>
    <div id="selEditPhotoComments" class="clsPopupConfirmation" style="display:none;"></div>
    <form name="photoListForm" id="photoListForm" method="post" action="{$myobj->getCurrentUrl()}" autocomplete="off">
      {*<input type="hidden" name="checkbox" id="selCheckBox"  value="{$smarty.session.user.quick_mixs}"/>
			<input type="hidden" name="checkboxslidelist" id="selCheckBoxForSlideList"  value=""/>*}
      {if isMember()}
      <div class="clsOverflow clsBorderBottom">
        <p class="clsListCheckBox clsListBoxPosition">
          <input type="checkbox" class="clsCheckRadio clsRadioButtonBorder" name="check_all" id="check_all" tabindex="{smartyTabIndex}" onClick="CheckAll(document.photoListForm.name, document.photoListForm.check_all.name)"/>
        </p>
		{if $CFG.admin.photos.allow_quick_mixs}
        <p class="clsSubmitButton-l"><span class="clsSubmitButton-r" id="quick_mix">
          <input type="button" value="{$LANG.common_photo_add_to_quick_view}" onClick="getMultiCheckBoxValueForQuickMix('photoListForm', 'check_all', '{$LANG.photolist_select_titles}');if(quickMixmultiCheckValue!='') updatePhotosQuickMixCount(quickMixmultiCheckValue);"/>
          </span></p>
		 {/if}
        <p class="clsSubmitButton-l"><span class="clsSubmitButton-r">
          	<input type="button"  value="{$LANG.common_photo_add_to_slidelist}" onclick="getMultiCheckBoxValue('photoListForm', 'check_all', '{$LANG.photolist_select_titles}');if(multiCheckValue!='') return populateMyPlayList('{$myobj->getCurrentUrl(true)}', 'select', multiCheckValue);" />
          </span></p>
          {$myobj->populatePlaylist()}
          {if $CFG.admin.photos.movie_maker}
        <p class="clsSubmitButton-l"><span class="clsSubmitButton-r" id="movie_photo_queue">
          <input type="button" value="{$LANG.common_photo_add_to_movie_queue}" onClick="getMultiCheckBoxValueForMovieQueue('photoListForm', 'check_all', '{$LANG.photolist_select_titles}');if(movieQueueMultiCheckValue!='') updatePhotosMovieQueueCount(movieQueueMultiCheckValue);"/>
          </span></p>
		 {/if}
        {if $myobj->getFormField('pg')=="myphotos" || $myobj->getFormField('pg')=="myfavoritephotos" || $myobj->getFormField('pg')=="myplaylist" || $myobj->getFormField('pg')=="pending" }
        {if $myobj->getFormField('pg')=='myphotos' || $myobj->getFormField('pg')=="pending"} <a href="javascript:void(0)" id="dAltMulti"></a>
        <p class="clsDeleteButton-l"><span class="clsDeleteButton-r">
          <input type="button" class="clsSubmitButton" name="delete_submit" id="delete_submit" tabindex="{smartyTabIndex}" value="{$LANG.common_delete_option}" onClick="deleteMultiCheck('{$LANG.photolist_select_titles}','{$myobj->my_photos_form.anchor}','{$LANG.photolist_delete_confirmation}','photoListForm','photo_id','myphotodelete');"/>
          </span></p>
        {/if}
        {if $myobj->getFormField('pg')=='myplaylist'}
        <p class="clsDeleteButton-l"><span class="clsDeleteButton-r">
          <input type="button" class="clsSubmitButton" name="delete_submit" id="delete_submit"
                    tabindex="{smartyTabIndex}" value="{$LANG.common_delete_option}" onClick="deleteMultiCheck('{$LANG.photolist_select_titles}','{$myobj->my_photos_form.anchor}','{$LANG.photolist_delete_confirmation}','photoListForm','photo_id','myPlaylistPhotoDelete');" />
          </span></p>
        {/if}
        {if $myobj->getFormField('pg')=='myfavoritephotos'}
        <p class="clsDeleteButton-l"><span class="clsDeleteButton-r">
          <input type="button" class="clsSubmitButton" name="delete_submit" id="delete_submit"
                  tabindex="{smartyTabIndex}" value="{$LANG.common_delete_option}" onClick="deleteMultiCheck('{$LANG.photolist_select_titles}','{$myobj->my_photos_form.anchor}','{$LANG.photolist_favorite_delete_confirmation}','photoListForm','photo_id','favorite_delete');" />
          </span></p>
        {/if}
        {/if} </div>
        <div id="clsMsgDisplay_playlist_success" class="clsDisplayNone clsPlaylistSuccess"></div>
      {/if}
      <div class="clsViewBorder clsOverflow">
        <div class="clsThumbViewLeft"> { if $myobj->getFormField('thumb')=='yes' }
          <p class="clsDetailView"> <a class="{ if $myobj->getFormField('thumb')=='yes' } 'clsSearchActive' {else} '' {/if}" onclick="resetFormField('{ $myobj->showThumbDetailsLinks_arr.url }?thumb=no{$myobj->showThumbDetailsLinks_arr.query_string}', 'no');" title="{$LANG.common_photo_detail_view}">{$LANG.common_photo_detail_view}</a> </p>
          {elseif $myobj->getFormField('thumb')=='no'}
          <p class="clsThumbView"> <a class="{ if $myobj->getFormField('thumb')!='yes' } 'clsSearchActive' {else } '' {/if}" onclick="resetFormField('{ $myobj->showThumbDetailsLinks_arr.url}?thumb=yes{$myobj->showThumbDetailsLinks_arr.query_string}', 'yes');" title="{$LANG.common_photo_thumb_view}">{$LANG.common_photo_thumb_view}</a> </p>
          {/if} </div>
        <div class="clsSortByLinksContainer"> {if $myobj->isShowPageBlock("my_photos_form")}
          <div class="clsSortByPagination clsPhotoPaginationRight">
            <div class="clsPhotoPaging">
              <div class="clsPagingList"> {if $CFG.admin.navigation.top}
                {$myobj->setTemplateFolder('general/', 'photo')}
                {include file=pagination.tpl}
                {/if} </div>
            </div>
          </div>
        </div>
      </div>
      <a href="javascript:void(0)" id="{$myobj->my_photos_form.anchor}"></a> {if $myobj->isResultsFound}
      {assign var=count value=1}
      {assign var=song_id value=1}
      {if $myobj->getFormField('thumb')=='no'}
      <div id="selDetailViewId">
      {/if}
      {if $myobj->getFormField('thumb')=='yes'}
      <div id="selThumbViewId"> {/if}
        {foreach from=$photo_list_result item=result key=inc name=photo}
        {cycle values='clsOddListContents , clsEvenListContents ' assign=CellCSS}
        <div class="{$CellCSS} clsListContents {if $myobj->getFormField('thumb')=='yes'}{if $count % 3 == 0} clsThumbPhotoFinalRecord{/if} {/if}">
        {$myobj->setTemplateFolder('general/','photo')}
        {include file="box.tpl" opt="listimage_top"}
          <div class="clsOverflow">
		  {if $myobj->getFormField('thumb')=='no' && isMember() && $result.photo_status == 'Ok'}
            <p class="clsListCheckBox">
              <input type="checkbox" name="checkbox[]" id="view_photo_checkbox_{$result.record.photo_id}" class="clsRadioButtonBorder" value="{$result.record.photo_id}" onClick="disableHeading('photoListForm');"/>
            </p>
            {/if}


            {if $myobj->getFormField('thumb')=='no'}
            <div class="clsThumb">
              <div class="clsLargeThumbImageBackground clsNoLink" {if isMember()} onmouseover="showCaption('hideMenu_{$result.record.photo_id}');" onmouseout="hideCaption('hideMenu_{$result.record.photo_id}')" {/if} >
                <div class="clsPhotoThumbImageOuter">
                  {if $result.img_src}{if $result.photo_status == 'Ok'} <a href="{$result.view_photo_link}" class="cls146x112 clsImageHolder clsImageBorderBg">{/if}<img src="{$result.img_src}" alt="{$result.photo_title_word_wrap_not_highlight|truncate:25}" title="{$result.photo_title_word_wrap_not_highlight}" id="image_img_{$result.record.photo_id}" {$myobj->DISP_IMAGE(142, 108, $result.record.t_width, $result.record.t_height)}/>{if $result.photo_status == 'Ok'}</a> {/if}{else if $myobj->getFormField('pg')=="albumlist"} <img src="{$album_photo_count_list[$result.photo_album_id].img_src}"  {$album_photo_count_list[$result.photo_album_id].img_disp_image} alt="{$result.photo_title_word_wrap}"   title="{$result.photo_title_word_wrap}" /> {/if}
				  </div>
              </div>
			  {if $result.img_src}
              <div class="clsSlideTip">  <a href="javascript:;"  title="{$LANG.common_zoom}" id="img_{$result.record.photo_id}" onclick="zoom('img_{$result.record.photo_id}','{$result.slideshow_img_src}','{$result.photo_description_word_wrap_js|truncate:50}')" class="clsPhotoVideoEditLinks clsIndexZoomImg">{$LANG.photo_list_photo_view}</a>  </div>{/if}
         {if isMember()}
			  {if $result.add_quickmix || (($myobj->getFormField('pg')=="myphotos" || $myobj->getFormField('pg')=="pending" || $result.user_id == $CFG.user.user_id || isAdmin()) && $myobj->getFormField('myfavoritephoto') != "Yes") || $myobj->getFormField('myfavoritephoto')=="Yes" || ($CFG.admin.photos.add_photo_location && $result.photo_status == 'Ok' && ($result.user_id == $CFG.user.user_id || isAdmin()))}
              <div class="clsGetEditDel"  style="display:none" id="hideMenu_{$result.record.photo_id}" onmouseover="showCaption('hideMenu_{$result.record.photo_id}');" onmouseout="hideCaption('hideMenu_{$result.record.photo_id}')">
                <div> {if $result.add_quickmix}
                  {if $result.is_quickmix_added && $result.photo_status == 'Ok'}
                  <p class="clsQuickMix" id="quick_mix_added_{$result.photo_id}"><a href="javascript:void(0)" onClick="removePhotosQuickMixCount('{$result.photo_id}')"  class="clsQuickMix-on clsPhotoVideoEditLinks" title="{$LANG.photo_list_remove_from_quickmix}" >{$LANG.common_photo_quick_mix}</a></p>
                  <p class="clsQuickMix" id="quick_mix_{$result.photo_id}" style="display:none"><a href="javascript:void(0)" onClick="updatePhotosQuickMixCount('{$result.photo_id}')" class="clsQuickMix-off clsPhotoVideoEditLinks" title="{$LANG.photo_list_add_to_quickmix}">{$LANG.common_photo_quick_mix}</a></p>
                  {elseif $result.photo_status == 'Ok'}
                  <p class="clsQuickMix" id="quick_mix_added_{$result.photo_id}" style="display:none"><a href="javascript:void(0)" onClick="removePhotosQuickMixCount('{$result.photo_id}')"  class="clsQuickMix-on clsPhotoVideoEditLinks" title="{$LANG.photo_list_remove_from_quickmix}">{$LANG.common_photo_quick_mix}</a></p>
                  <p class="clsQuickMix" id="quick_mix_{$result.photo_id}"><a href="javascript:void(0)" onClick="updatePhotosQuickMixCount('{$result.photo_id}')" class="clsQuickMix-off clsPhotoVideoEditLinks" title="{$LANG.photo_list_add_to_quickmix}">{$LANG.common_photo_quick_mix}</a></p>
                  {/if}
                  {/if} </div>

                <!-- movie maker queue start -->
                <div> {if $result.add_photo_movie_queue}
                {if $result.is_moviequeue_added && $result.photo_status == 'Ok'}
                <p class="clsMovieQueue" id="movie_queue_added_{$result.photo_id}"><a href="javascript:void(0)" onClick="removePhotosMovieQueueCount('{$result.photo_id}')"  class="clsMovieQueue-on clsPhotoVideoEditLinks" title="{$LANG.common_photo_remove_from_movie_queue}" >{$LANG.common_photo_movie_queue}</a></p>
                <p class="clsMovieQueue" id="movie_queue_{$result.photo_id}" style="display:none"><a href="javascript:void(0)" onClick="updatePhotosMovieQueueCount('{$result.photo_id}')" class="clsMovieQueue-off clsPhotoVideoEditLinks" title="{$LANG.common_photo_add_to_movie_queue}">{$LANG.common_photo_movie_queue}</a></p>
                {elseif $result.photo_status == 'Ok'}
                <p class="clsMovieQueue" id="movie_queue_added_{$result.photo_id}" style="display:none"><a href="javascript:void(0)" onClick="removePhotosMovieQueueCount('{$result.photo_id}')"  class="clsMovieQueue-on clsPhotoVideoEditLinks" title="{$LANG.common_photo_remove_from_movie_queue}">{$LANG.common_photo_movie_queue}</a></p>
                <p class="clsMovieQueue" id="movie_queue_{$result.photo_id}"><a href="javascript:void(0)" onClick="updatePhotosMovieQueueCount('{$result.photo_id}')" class="clsMovieQueue-off clsPhotoVideoEditLinks" title="{$LANG.common_photo_add_to_movie_queue}">{$LANG.common_photo_movie_queue}</a></p>
                {/if}
                {/if} </div>
                  <!-- movie maker queue end -->

                <div> {if ($myobj->getFormField('pg')=="myphotos" || $myobj->getFormField('pg')=="pending" || $result.user_id == $CFG.user.user_id || isAdmin()) && $myobj->getFormField('myfavoritephoto') != "Yes"}
                  <ul id="selPhotoLinks" class="clsContentEditLinks">
				    {if $result.photo_status == 'Ok'}
                    <li class="clsEdit"> <a href="{$result.photoupload_url}" class="clsPhotoVideoEditLinks" title="{$LANG.photolist_edit_photo}"> </a> </li>
					{/if}
                    <li class="clsDelete" id="anchor_myvid_{$result.photo_id}"> <a href="javascript:void(0)" class="clsVideoVideoEditLinks clsPhotoVideoEditLinks" title="{$LANG.photolist_delete_photo}"  onClick="return Confirmation('selMsgConfirm', 'msgConfirmform', Array('act','photo_id', 'selPhotoId', 'delete_photo_msg_id'), Array('delete','{$result.photo_id}', '{$result.img_src}', '{$result.delete_photo_title|escape:"javascript"}'), Array('value','value', 'src', 'innerHTML'), -100, -300,'anchor_myvid_{$result.photo_id}');"> </a> </li>
                    {if $CFG.admin.photos.add_photo_location && $result.photo_status == 'Ok'}
                    	<li class="clsGetCode">
							<a href="{$result.location_url}" title="{$LANG.photo_list_location_title}" id="show_photo_location_{$result.photo_id}" class="clsPhotoVideoEditLinks">{$LANG.photo_list_location}</a>
						</li>
                    {/if}
                  </ul>
                  {/if} </div>
                <div> {if $myobj->getFormField('myfavoritephoto')=="Yes"}
                  <ul id="selPhotoLinks" class="clsContentEditLinks">
                    <li class="clsDelete" id="anchor_myfav_{$result.photo_id}"> <a href="javascript:void(0)" class="clsPhotoVideoEditLinks" title="{$LANG.photolist_delete_photo}" onClick="return Confirmation('selMsgConfirm', 'msgConfirmform',                        Array('act','photo_id', 'selPhotoId', 'delete_photo_msg_id'),                                           Array('favorite_delete','{$result.photo_id}', '{$result.img_src}', '{$result.delete_photo_title}'),                       Array('value','value', 'src', 'innerHTML'), -100, -300,'anchor_myfav_{$result.photo_id}');"></a> </li>
                  </ul>
                  {/if} </div>
              </div>
              {/if}
	     {/if}
			  </div>
            <div class="clsContentDetails clsOverflow">
              <div class="clsMoreInfoContent">
                <div class="clsMoreInfoContent-l">
                  <div>
                    <p class="clsHeading"><a  href="{$result.view_photo_link}" title="{$result.photo_title_word_wrap_not_highlight}">{$result.photo_title_word_wrap}</a></p>
                  </div>
                  <div class="clsAddedUserDet">
                    <p class="clsLeft">{$LANG.photo_list_addedby}</p>
                    <p class="clsRight clsUserLink"><a href="{$myobj->memberProfileUrl[$result.record.user_id]}" title="{$result.record.user_name}">{$result.record.user_name}</a>
                    <span class="clsLinkSeperator">|</span>
                    <span>{$result.date_added}</span></p>
                  </div>
                 <!-- <div>
                    	<p class="clsLeft">{$LANG.photo_list_added_date}</p>
                      					<p class="clsRight"></p>
                  </div>-->
                  {if $result.location_recorded_word_wrap!=''}
                  <div id="photoLocation_{$result.record.photo_id}">
                    <p class="clsLeft">{$LANG.photo_list_location}</p>
                    <p class="clsRight clsLocationLink">
					{if $result.photo_location_lat !=0 && $result.photo_location_lan !=0}
						<a href="javascript:void(0)" id="list_photo_location_{$result.photo_id}" title="{$result.location_recorded_word_wrap_not_highlight}" onclick="showPhotosInLocation('{$result.photo_id}', '{$result.location_recorded_url}');">{$result.location_recorded_word_wrap}</a>
					{else}
						{$result.location_recorded_word_wrap}
					{/if}
					</p>
                  </div>
				  {else}
				  <div id="photoLocation_{$result.record.photo_id}"></div>
                  {/if}
				  <div>
                    <p class="clsDescription"><span class="clsLabel">{$LANG.photo_list_description}:</span><span class='toolTipSpanClass clsDesFull' title="{$result.photo_description_word_wrap_not_highlight}">&nbsp;{$result.photo_description_word_wrap}</span></p>
                  </div>
				  </div>
                <div class="clsMoreInfoContent-r">
                  <div class="clsPhotoRating">
				  	{if $result.record.allow_ratings == 'Yes'}
                    	{if $myobj->populateRatingDetails($result.rating)}
                    		{$myobj->populatePhotoRatingImages($result.rating,'photo')}
                    	{else}
                    		{$myobj->populatePhotoRatingImages(0,'photo')}
                    	{/if}
                    {/if}
                    {if $result.record.allow_ratings != 'Yes'}
						<span class="clsRatingDisabled"><span>{$LANG.photolist_rating_disabled}</span></span>
					{else}
                    	&nbsp;( <span><span>{$result.record.rating_count}</span></span> )
                    {/if}
				  </div>
                  <div>
                    <p class="clsLeft">{$LANG.photolist_views}</p>
                    <p class="clsRight">: <span>{if $myobj->getFormField('pg')=='photomostviewed' && $myobj->getFormField('action')!='' && $myobj->getFormField('action')!=0}{$result.sum_total_views}/{/if}{$result.record.total_views}</span></p>
                  </div>
                  {if $myobj->getFormField('pg')=='featuredphotolist'}
                  <div>
                    <p class="clsLeft">{$LANG.photo_featured}</p>
                    <p class="clsRight">: <span>{$result.record.total_featured}</span></p>
                  </div>
                  {/if}
                  {if $myobj->getFormField('pg')!='featuredphotolist'}
                  <div>
                    <p class="clsLeft">{$LANG.photo_list_commented}</p>
                    <p class="clsRight">: <span>{if $myobj->getFormField('pg')=='photomostdiscussed' && $myobj->getFormField('action')!='' && $myobj->getFormField('action')!=0}{$result.sum_total_comments}/{/if}{$result.record.total_comments}</span></p>
                  </div>
                  {/if}
                  <div>
                    <p class="clsLeft">{$LANG.photo_list_favorite}</p>
                    <p class="clsRight">: <span>{if $myobj->getFormField('pg')=='photomostfavorite' && $myobj->getFormField('action')!='' && $myobj->getFormField('action')!=0}{$result.sum_total_favorite}/{/if}{$result.record.total_favorites}</span></p>
                  </div>
                </div>
              </div>
            </div>
            <div class="clsContentDetails clsOverflow">
              <div class="clsContentPhotoTags"> {if $myobj->getFormField('photo_tags') != ''}
                {assign var=photo_tag value=$myobj->getFormField('photo_tags')}
                {elseif $myobj->getFormField('tags') != '' }
                {assign var=photo_tag value=$myobj->getFormField('tags')}
                {else}
                {assign var=photo_tag value=''}
                {/if}
                <p>{$LANG.photo_list_tags}:{if $result.record.photo_tags!=''} {$myobj->getPhotoTagsLinks($result.record.photo_tags,5, $photo_tag)}{/if}</p>
              </div>

            </div>
            {elseif $myobj->getFormField('thumb')=='yes'}
                <div class="clsLargeThumbImageBackground clsNoLink" {if isMember()}onmouseover="showCaption('hideMenu_{$result.record.photo_id}');" onmouseout="hideCaption('hideMenu_{$result.record.photo_id}')"{/if} >
                      <div ><a id="{$result.anchor}"></a> {if $result.img_src} {if $result.photo_status == 'Ok'}<a href="{$result.view_photo_link}" class="cls146x112 clsImageHolder clsImageBorderBg">{/if}<img src="{$result.img_src}" alt="{$result.photo_title_word_wrap_not_highlight|truncate:25}"  title="{$result.photo_title_word_wrap_not_highlight}" id="image_img_{$result.record.photo_id}" {$myobj->DISP_IMAGE(142, 108, $result.record.t_width, $result.record.t_height)}/>{if $result.photo_status == 'Ok'}</a>{/if} {else if $myobj->getFormField('pg')=="albumlist"} <img src="{$album_photo_count_list[$result.photo_album_id].img_src}"  {$album_photo_count_list[$result.photo_album_id].img_disp_image} alt="{$result.photo_title_word_wrap_not_highlight|truncate:25}"  title="{$result.photo_title_word_wrap_not_highlight}"/> {/if} </div>
                </div>
               {if $result.img_src}<div class="clsSlideTip">  <a href="javascript:;"  title="{$LANG.common_zoom}" id="img_{$result.record.photo_id}" onclick="zoom('img_{$result.record.photo_id}','{$result.slideshow_img_src}','{$result.photo_description_word_wrap_js}')" class="clsPhotoVideoEditLinks clsIndexZoomImg">{$LANG.photo_list_photo_view}</a></div> {/if}
                {if isMember()}
					 {if $result.add_quickmix || (($myobj->getFormField('pg')=="myphotos" || $myobj->getFormField('pg')=="pending" || $result.user_id == $CFG.user.user_id || isAdmin()) && $myobj->getFormField('myfavoritephoto') != "Yes") || $myobj->getFormField('myfavoritephoto')=="Yes" || ($CFG.admin.photos.add_photo_location && $result.photo_status == 'Ok' && ($result.user_id == $CFG.user.user_id || isAdmin()))}
		                <div class="clsGetEditDel"  style="display:none" id="hideMenu_{$result.record.photo_id}" onmouseover="showCaption('hideMenu_{$result.record.photo_id}');" onmouseout="hideCaption('hideMenu_{$result.record.photo_id}')">
                  <div> {if $result.add_quickmix}
                    {if $result.is_quickmix_added && $result.photo_status == 'Ok'}
                    <p class="clsQuickMix" id="quick_mix_added_{$result.photo_id}"><a href="javascript:void(0)" onClick="removePhotosQuickMixCount('{$result.photo_id}')"  class="clsQuickMix-on clsPhotoVideoEditLinks" title="{$LANG.photo_list_remove_from_quickmix}" >{$LANG.common_photo_quick_mix}</a></p>
                    <p class="clsQuickMix" id="quick_mix_{$result.photo_id}" style="display:none"><a href="javascript:void(0)" onClick="updatePhotosQuickMixCount('{$result.photo_id}')" class="clsQuickMix-off clsPhotoVideoEditLinks" title="{$LANG.photo_list_add_to_quickmix}">{$LANG.common_photo_quick_mix}</a></p>
                    {elseif $result.photo_status == 'Ok'}
                    <p class="clsQuickMix" id="quick_mix_added_{$result.photo_id}" style="display:none"><a href="javascript:void(0)" onClick="removePhotosQuickMixCount('{$result.photo_id}')"  class="clsQuickMix-on clsPhotoVideoEditLinks" title="{$LANG.photo_list_remove_from_quickmix}">{$LANG.common_photo_quick_mix}</a></p>
                    <p class="clsQuickMix" id="quick_mix_{$result.photo_id}"><a href="javascript:void(0)" onClick="updatePhotosQuickMixCount('{$result.photo_id}')" class="clsQuickMix-off clsPhotoVideoEditLinks" title="{$LANG.photo_list_add_to_quickmix}">{$LANG.common_photo_quick_mix}</a></p>
                    {/if}
                    {/if} </div>

                    <!-- movie maker queue start -->
                    <div> {if $result.add_photo_movie_queue}
                    {if $result.is_moviequeue_added && $result.photo_status == 'Ok'}
                    <p class="clsMovieQueue" id="movie_queue_added_{$result.photo_id}"><a href="javascript:void(0)" onClick="removePhotosMovieQueueCount('{$result.photo_id}')"  class="clsMovieQueue-on clsPhotoVideoEditLinks" title="{$LANG.common_photo_remove_from_movie_queue}" >{$LANG.common_photo_movie_queue}</a></p>
                    <p class="clsMovieQueue" id="movie_queue_{$result.photo_id}" style="display:none"><a href="javascript:void(0)" onClick="updatePhotosMovieQueueCount('{$result.photo_id}')" class="clsMovieQueue-off clsPhotoVideoEditLinks" title="{$LANG.common_photo_add_to_movie_queue}">{$LANG.common_photo_movie_queue}</a></p>
                    {elseif $result.photo_status == 'Ok'}
                    <p class="clsMovieQueue" id="movie_queue_added_{$result.photo_id}" style="display:none"><a href="javascript:void(0)" onClick="removePhotosMovieQueueCount('{$result.photo_id}')"  class="clsMovieQueue-on clsPhotoVideoEditLinks" title="{$LANG.common_photo_remove_from_movie_queue}">{$LANG.common_photo_movie_queue}</a></p>
                    <p class="clsMovieQueue" id="movie_queue_{$result.photo_id}"><a href="javascript:void(0)" onClick="updatePhotosMovieQueueCount('{$result.photo_id}')" class="clsMovieQueue-off clsPhotoVideoEditLinks" title="{$LANG.common_photo_add_to_movie_queue}">{$LANG.common_photo_movie_queue}</a></p>
                    {/if}
                    {/if} </div>
                      <!-- movie maker queue end -->

                  <div> {if ($myobj->getFormField('pg')=="myphotos" || $myobj->getFormField('pg')=="pending" || $result.user_id == $CFG.user.user_id || isAdmin()) && $myobj->getFormField('myfavoritephoto') != "Yes"}
                    <ul id="selPhotoLinks" class="clsContentEditLinks">
					{if $result.photo_status == 'Ok'}
                      <li class="clsEdit"> <a href="{$result.photoupload_url}" class="clsPhotoVideoEditLinks" title="{$LANG.photolist_edit_photo}"> </a> </li>
					 {/if}
                      <li class="clsDelete" id="anchor_myvid_{$result.photo_id}"> <a href="javascript:void(0)" class="clsVideoVideoEditLinks clsPhotoVideoEditLinks" title="{$LANG.photolist_delete_photo}" onClick="return Confirmation('selMsgConfirm', 'msgConfirmform', Array('act','photo_id', 'selPhotoId', 'delete_photo_msg_id'), Array('delete','{$result.photo_id}', '{$result.img_src}', '{$result.delete_photo_title}'), Array('value','value', 'src', 'innerHTML'), -100, -300,'anchor_myvid_{$result.photo_id}');"> </a> </li>
                      {if $CFG.admin.photos.add_photo_location && $result.photo_status == 'Ok'}
                      <li class="clsGetCode"> <a href="javascript:void(0);" title="{$LANG.photo_list_location_title}" onclick="javascript:myLightWindow.activateWindow( {literal}{{/literal}type:'external',href:'{$result.location_url}',title:'{$LANG.photolist_addlocation_title}',width:525,height:420 {literal}}{/literal});" class="clsPhotoVideoEditLinks">{$LANG.photo_list_location}</a></li>
                      {/if}
                    </ul>
                    {/if} </div>
                  <div> {if $myobj->getFormField('myfavoritephoto')=="Yes"}
                    <ul id="selPhotoLinks" class="clsContentEditLinks">
                      <li class="clsGetCode" id="anchor_getcode_{$result.photo_id}"> <a href="javascript:void(0)" class="clsPhotoVideoEditLinks" title="{$LANG.photolist_get_code}"  onClick="return getAjaxGetCode('{$result.callAjaxGetCode_url}', '{$result.anchor}','selEditPhotoComments','anchor_getcode_{$result.photo_id}')" ></a> </li>
                      <li class="clsDelete" id="anchor_myfav_{$result.photo_id}"> <a href="javascript:void(0)" class="clsPhotoVideoEditLinks" title="{$LANG.photolist_delete_photo}" onClick="return Confirmation('selMsgConfirm', 'msgConfirmform',                        Array('act','photo_id', 'selPhotoId', 'delete_photo_msg_id'),                                           Array('favorite_delete','{$result.photo_id}', '{$result.img_src}', '{$result.delete_photo_title}'),                       Array('value','value', 'src', 'innerHTML'), -100, -300,'anchor_myfav_{$result.photo_id}');"></a> </li>
                    </ul>
                    {/if} </div>
                </div>
					{/if}
                {/if}
              <div class="clsContentThumbDetails">
              <div class="clsThumbTitles">
              {if isMember() && $result.photo_status == 'Ok'}
                <p class="clsListCheckBox">
                  <input type="checkbox" name="checkbox[]" id="view_photo_checkbox_{$result.record.photo_id}" class="clsRadioButtonBorder" value="{$result.record.photo_id}" onClick="disableHeading('photoListForm');"/>
                </p>
                {/if}
                <p class="clsHeading"><a class="clsNoPhotoLink" href="{$result.view_photo_link}" title="{$result.photo_title_word_wrap}">{$result.photo_title_word_wrap}</a></p>
                </div>
                <div class="clsThumbViewDetail clsOverflow">
                  <div class="clsThumbUserDet">
                    <p class="clsLeft clsUserLink">{$LANG.photo_list_by} <a href="{$myobj->memberProfileUrl[$result.record.user_id]}" title="{$result.record.user_name}">{$result.record.user_name}</a></p>
                    <p class="clsRight"><span class="clsLinkSeperator">|</span><span>{$result.date_added}</span></p>
                  </div>
                  {if $myobj->getFormField('pg')!='phototoprated'}
                  <div>
                  	<p class="clsLeft clsThumbViewValue">{$LANG.photolist_views}:
                    <span>{if $myobj->getFormField('pg')=='photomostviewed' && $myobj->getFormField('action')!='' && $myobj->getFormField('action')!=0}{$result.sum_total_views}/{/if}{$result.record.total_views}</span>
                    </p>
                    {if $myobj->getFormField('pg')=='featuredphotolist'}
                    <p class="clsRight clsThumbViewValue"><span class="clsLinkSeperator">|</span>{$LANG.photo_featured} <span>{$result.record.total_featured}</span></p>
                    {/if}
                    {if $myobj->getFormField('pg')=='photomostdiscussed' || ($myobj->getFormField('pg')!='featuredphotolist' && $myobj->getFormField('pg')!='photomostfavorite')}
                    <p class="clsRight clsThumbViewValue"><span class="clsLinkSeperator">|</span>{$LANG.photo_list_commented}: <span>{if $myobj->getFormField('pg')=='photomostdiscussed' && $myobj->getFormField('action')!='' && $myobj->getFormField('action')!=0}{$result.sum_total_comments}/{/if}{$result.record.total_comments}</span></p>
                    {/if}
                    {if $myobj->getFormField('pg')=='photomostfavorite'}
                    <p class="clsRight clsThumbViewValue">&nbsp;|&nbsp;{$LANG.photo_list_favorite} <span>{$result.record.total_favorites}</span></p>
                    {/if}

                  </div>
                  {else}
                  <div class="clsPhotoRating"> {if $result.record.allow_ratings == 'Yes'}
                    <p class="clsLeft clsThumbViewValue clsTopRatedIcon">
                        {if $myobj->populateRatingDetails($result.rating)}
                        {$myobj->populatePhotoRatingImages($result.rating,'photo')}
                        {else}
                        {$myobj->populatePhotoRatingImages(0,'photo')}
                        {/if}
                   {/if}
                    </p>
                    <p class="clsRight clsThumbViewValue">&nbsp;(<span> <span>{$result.record.rating_count}</span>{* {$LANG.photolist_ratted}*} </span>)</p>
                  </div>
                  {/if}
                </div>
              </div>
            {/if} </div>
        {$myobj->setTemplateFolder('general/','photo')}
        {include file="box.tpl" opt="listimage_bottom"}
        </div>
        {assign var=count value=$count+1}
        {/foreach} </div>
      {else}
      <div id="selMsgAlert">
        <p>{$LANG.common_photo_no_records_found}</p>
      </div>
      {/if}
      {/if}
      <div class="clsPhotoPaging">
        <div class="clsPagingList">
          <ul>
            {if $CFG.admin.navigation.bottom}
            {$myobj->setTemplateFolder('general/', 'photo')}
            {include file=pagination.tpl}
            {/if}
          </ul>
        </div>
      </div>
    </form>
  </div>
</div>
<!--<script src="{$CFG.site.photo_url}js/visuallightbox.js" type="text/javascript"></script>-->
{$myobj->setTemplateFolder('general/','photo')}
{include file='box.tpl' opt='photomain_bottom'}
{* Added code to display photo on selected location and add photo location fancy box while clicking on location link/image on each photo *}
{literal}
<script>
$Jq(document).ready(function() {

	for(var i=0;i<photo_location_ids.length;i++)
	{
		$Jq('#show_photo_location_'+photo_location_ids[i]).fancybox({
			'width'				: 539,
			'height'			: 430,
			'padding'			:  0,
			'autoScale'     	: false,
			'transitionIn'		: 'none',
			'transitionOut'		: 'none',
			'type'				: 'iframe'
		});
	}

});
function showPhotosInLocation(divid,callurl)
{
	var did = '#list_photo_location_'+divid;
	$Jq.fancybox({
		'orig' : $Jq(did),
		'href'              : callurl,
		'width'				: 539,
		'height'			: 430,
		'autoScale'     	: false,
		'transitionIn'		: 'none',
		'transitionOut'		: 'none',
		'type'				: 'iframe'
	});
}
</script>
{/literal}
