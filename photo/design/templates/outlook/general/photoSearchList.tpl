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
  <!--FORM End-->
  <div id="selLeftNavigation">
    <div id="selMsgConfirm" class="clsPopupConfirmation" style="display:none;">
     <div class="clsOverflow">
      <p id="msgConfirmText"></p>
      <form name="msgConfirmform" id="msgConfirmform" method="post" action="{$myobj->getCurrentUrl()}" autocomplete="off">
        <div id="selImageBorder" class="clsPlainImageBorder">
            <div id="delete_photo_msg_id" class="clsPopUpInnerContent"> </div>
            <div id="selPlainCenterImage"> <img id="selPhotoId" border="0" src=""/> </div>
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
      <p id="msgConfirmTextMulti">{$LANG.photolist_multi_delete_confirmation}</p>
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

      {if isMember()}
      <div class="clsOverflow clsBorderBottom">
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
      {/if}
      <div class="clsViewBorder clsOverflow">
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
            {if $myobj->getFormField('thumb')=='no'}
            <div class="clsThumb">
              <div class="clsLargeThumbImageBackground clsNoLink" {if isMember()} onmouseover="showCaption('hideMenu_{$result.record.photo_id}');" onmouseout="hideCaption('hideMenu_{$result.record.photo_id}')" {/if} {if $result.photo_status == 'Ok'} onclick="Redirect2URL('{$result.view_photo_link}');" {/if}>
                <div class="clsPhotoThumbImageOuter">
                  {if $result.img_src}{if $result.photo_status == 'Ok'} <a  class="cls146x112 clsImageHolder clsImageBorderBg" href="{$result.view_photo_link}">{/if}<img src="{$result.img_src}" alt="{$result.photo_title_word_wrap_not_highlight}" title="{$result.photo_title_word_wrap_not_highlight}" id="image_img_{$result.record.photo_id}"/>{if $result.photo_status == 'Ok'}</a> {/if}{else if $myobj->getFormField('pg')=="albumlist"} <img src="{$album_photo_count_list[$result.photo_album_id].img_src}"  {$album_photo_count_list[$result.photo_album_id].img_disp_image}  title="{$result.photo_title_word_wrap}" alt="{$result.photo_title_word_wrap}"/> {/if}
				  </div>
              </div>
			  {if $result.img_src}
              <div class="clsSlideTip">  <a href="javascript:;"  title="{$LANG.common_zoom}" id="img_{$result.record.photo_id}" onclick="zoom('img_{$result.record.photo_id}','{$result.slideshow_img_src}','{$result.photo_description_word_wrap_js}')" class="clsPhotoVideoEditLinks clsIndexZoomImg">{$LANG.photo_list_photo_view}</a>  </div>{/if}
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
                    <li class="clsDelete" id="anchor_myvid_{$result.photo_id}"> <a href="javascript:void(0)" class="clsVideoVideoEditLinks clsPhotoVideoEditLinks" title="{$LANG.photolist_delete_photo}"  onClick="return Confirmation('selMsgConfirm', 'msgConfirmform', Array('act','photo_id', 'selPhotoId', 'delete_photo_msg_id'), Array('delete','{$result.photo_id}', '{$result.img_src}', '{$result.delete_photo_title}'), Array('value','value', 'src', 'innerHTML'), -100, -300,'anchor_myvid_{$result.photo_id}');"> </a> </li>
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
                    <p class="clsHeading"><a  href="{$result.view_photo_link}" title="{$result.photo_title_word_wrap}">{$result.photo_title_word_wrap}</a></p>
                  </div>
                  <div>
                    <p class="clsLeft">{$LANG.photo_list_addedby}</p>
                    <p class="clsRight clsUserLink"><a href="{$myobj->memberProfileUrl[$result.record.user_id]}" title="{$result.record.user_name}">{$result.record.user_name}</a><span>&nbsp;|&nbsp;{$result.date_added}</span></p>
                  </div>
                  <div>
                    <!--	<p class="clsLeft">{$LANG.photo_list_added_date}</p>
                      					<p class="clsRight"></p>-->
                  </div>
                  {if $result.location_recorded_word_wrap!=''}
                  <div id="photoLocation_{$result.record.photo_id}">
                    <p class="clsLeft">{$LANG.photo_list_location}</p>
                    <p class="clsRight clsLocationLink">
					{if $result.photo_location_lat !=0 && $result.photo_location_lan !=0}
						<a href="{$result.location_recorded_url}" id="list_photo_location_{$result.photo_id}" title="{$result.location_recorded_word_wrap}">{$result.location_recorded_word_wrap}</a>
					{else}
						{$result.location_recorded_word_wrap}
					{/if}
					</p>
                  </div>
				  {else}
				  <div id="photoLocation_{$result.record.photo_id}"></div>
                  {/if}

				  </div>
                <div class="clsMoreInfoContent-r">
                  <div class="clsPhotoRating"> {if $result.record.allow_ratings == 'Yes'}
                    {if $myobj->populateRatingDetails($result.rating)}
                    {$myobj->populatePhotoRatingImages($result.rating,'photo')}
                    {else}
                    {$myobj->populatePhotoRatingImages(0,'photo')}
                    {/if}
                    {/if}
                    &nbsp;(<span> <span>{$result.record.rating_count}</span> {$LANG.photolist_ratted} </span>) </div>
                  <div>
                    <p class="clsLeft">{$LANG.photolist_views}:</p>
                    <p class="clsRight">{if $myobj->getFormField('pg')=='photomostviewed' && $myobj->getFormField('action')!='' && $myobj->getFormField('action')!=0}{$result.sum_total_views}/{/if}{$result.record.total_views}</p>
                  </div>
                  {if $myobj->getFormField('pg')=='featuredphotolist'}
                  <div>
                    <p class="clsLeft">{$LANG.photo_featured}</p>
                    <p class="clsRight">{$result.record.total_featured}</p>
                  </div>
                  {/if}
                  {if $myobj->getFormField('pg')!='featuredphotolist'}
                  <div>
                    <p class="clsLeft">{$LANG.photo_list_commented}</p>
                    <p class="clsRight">{if $myobj->getFormField('pg')=='photomostdiscussed' && $myobj->getFormField('action')!='' && $myobj->getFormField('action')!=0}{$result.sum_total_comments}/{/if}{$result.record.total_comments}</p>
                  </div>
                  {/if}
                  <div>
                    <p class="clsLeft">{$LANG.photo_list_favorite}</p>
                    <p class="clsRight">{if $myobj->getFormField('pg')=='photomostfavorite' && $myobj->getFormField('action')!='' && $myobj->getFormField('action')!=0}{$result.sum_total_favorite}/{/if}{$result.record.total_favorites}</p>
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
              <div>
                <p class="clsDescription"><span class="clsLabel">{$LANG.photo_list_description}:</span>&nbsp;{$result.photo_description_word_wrap} </p>
              </div>
            </div>
            {elseif $myobj->getFormField('thumb')=='yes'}
                <div class="clsLargeThumbImageBackground clsNoLink" {if isMember()}onmouseover="showCaption('hideMenu_{$result.record.photo_id}');" onmouseout="hideCaption('hideMenu_{$result.record.photo_id}')"{/if} {if $result.photo_status == 'Ok'} onclick="Redirect2URL('{$result.view_photo_link}');" {/if}>
                  <div class="cls132x88PXthumbImage clsPhotoThumbImageOuter">
                    <div class="clsPhotoThumbImageMiddle">
                      <div class="clsPhotoThumbImageInner"><a id="{$result.anchor}"></a> {if $result.img_src} {if $result.photo_status == 'Ok'}<a  href="{$result.view_photo_link}">{/if}<img src="{$result.img_src}" alt="{$result.photo_title_word_wrap_not_highlight}" title="{$result.photo_title_word_wrap_not_highlight}" id="image_img_{$result.record.photo_id}"/>{if $result.photo_status == 'Ok'}</a>{/if} {else if $myobj->getFormField('pg')=="albumlist"} <img src="{$album_photo_count_list[$result.photo_album_id].img_src}"  {$album_photo_count_list[$result.photo_album_id].img_disp_image} alt="{$result.photo_title_word_wrap_not_highlight}" title="{$result.photo_title_word_wrap_not_highlight}"/> {/if} </div>
                    </div>
                  </div>
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
              {if isMember() && $result.photo_status == 'Ok'}
                <p class="clsListCheckBox">
                  <input type="checkbox" name="checkbox[]" id="view_photo_checkbox_{$result.record.photo_id}" class="clsRadioButtonBorder" value="{$result.record.photo_id}" onClick="disableHeading('photoListForm');"/>
                </p>
                {/if}
                <p class="clsHeading"><a class="clsNoPhotoLink" href="{$result.view_photo_link}" title="{$result.photo_title_word_wrap}">{$result.photo_title_word_wrap}</a></p>
                <div class="clsThumbViewDetail clsOverflow">
                  <div>
                    <p class="clsLeft clsUserLink">{$LANG.photo_list_by} <a href="{$myobj->memberProfileUrl[$result.record.user_id]}" title="{$result.record.user_name}">{$result.record.user_name}</a></p>
                    <p class="clsRight"><span>&nbsp;|&nbsp;{$result.date_added}</span></p>
                  </div>
                  {if $myobj->getFormField('pg')!='phototoprated'}
                  <div>
                  	<p class="clsLeft clsThumbViewValue">{$LANG.photolist_views}
                    <span>{if $myobj->getFormField('pg')=='photomostviewed' && $myobj->getFormField('action')!='' && $myobj->getFormField('action')!=0}{$result.sum_total_views}/{/if}{$result.record.total_views}</span>
                    </p>
                    {if $myobj->getFormField('pg')=='featuredphotolist'}
                    <p class="clsRight clsThumbViewValue">&nbsp;|&nbsp;{$LANG.photo_featured} <span>{$result.record.total_featured}</span></p>
                    {/if}
                    {if $myobj->getFormField('pg')=='photomostdiscussed' || ($myobj->getFormField('pg')!='featuredphotolist' && $myobj->getFormField('pg')!='photomostfavorite')}
                    <p class="clsRight clsThumbViewValue">&nbsp;|&nbsp;{$LANG.photo_list_commented} <span>{if $myobj->getFormField('pg')=='photomostdiscussed' && $myobj->getFormField('action')!='' && $myobj->getFormField('action')!=0}{$result.sum_total_comments}/{/if}{$result.record.total_comments}</span></p>
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
                    <p class="clsRight clsThumbViewValue">&nbsp;(<span> <span>{$result.record.rating_count}</span> {$LANG.photolist_ratted} </span>)</p>
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

{* Added code to display photo on selected location and add photo location fancy box while clicking on location link/image on each photo *}
<script>
{literal}
$Jq(document).ready(function() {
	for(var i=0;i<photo_location_ids.length;i++)
	{
		$Jq('#list_photo_location_'+photo_location_ids[i]).fancybox({
			'width'				: 539,
			'height'			: 430,
			'padding'			:  0,
			'autoScale'     	: false,
			'transitionIn'		: 'none',
			'transitionOut'		: 'none',
			'type'				: 'iframe'
		});
	}

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
{/literal}
</script>