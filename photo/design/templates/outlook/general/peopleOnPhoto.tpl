<div class="clsPhotoListContainer clsOverflow">
  {$myobj->setTemplateFolder('general/','photo')}
  {include file="box.tpl" opt="photomain_top"}
  <form id="searchAdvancedFilter" name="searchAdvancedFilter" method="post" action="{$myobj->getCurrentUrl()}" autocomplete="off">
  <input type="hidden" name="advanceFromSubmission" value="1"/>
  <div class="clsOverflow">
      <div class="clsMainBarHeading">
        <h3>{$myobj->pageTitle}</h3>
      </div>
  </div>
  <!-- Search Starts Here -->
  {*<div class="clsAdvancedFilterSearch" id=""> <a href="javascript:void(0)" id="show_link" class="clsShow"  {if $myobj->chkAdvanceResultFound()}  style="display:none" {/if} onclick="divShowHide('advanced_search', 'show_link', 'hide_link')">{$LANG.peopleonphoto_show_adv_search}</a> <a href="javascript:void(0)" id="hide_link" {if !$myobj->chkAdvanceResultFound()}  style="display:none" {/if} class="clsHide"  onclick="divShowHide('advanced_search', 'show_link', 'hide_link')">{$LANG.peopleonphoto_hide_adv_search}</a> <a href="{php} echo getUrl('peopleonphoto','?tag=all&block=all','?tag=all&block=all','','photo'){/php}" id="show_link" class="clsResetFilter" title="{$LANG.peopleonphoto_reset_search}">({$LANG.peopleonphoto_reset_search})</a> </div>*}
    <div id="advanced_search">
      {$myobj->setTemplateFolder('general/','photo')}
      {include file='box.tpl' opt='form_top'}
      <div class="clsOverflow">
          <div class="clsAdvancedSearchBg">
          <table class="clsAdvancedFilterTable">
          {if $myobj->getFormField('tagged_by')}
            <tr><td colspan="2"><input class="clsTextBox" type="text" name="advanced_people_name" id="advanced_people_name" value="{if $myobj->getFormField('people') != ''}{$myobj->getFormField('people')}{elseif $myobj->getFormField('advanced_people_name') != ''}{$myobj->getFormField('advanced_people_name')}{else}{$LANG.peopleonphoto_search_people_name}{/if}" onBlur="setOldValue('advanced_people_name')"  onfocus="clearValue('advanced_people_name')"/></td></tr>
          {elseif $myobj->getFormField('tagged_of')}
            <tr>
              <td colspan="2">
                <input class="clsTextBox" type="text" name="advanced_tag_by_user" id="advanced_tag_by_user" value="{if $myobj->getFormField('advanced_tag_by_user') != ''}{$myobj->getFormField('advanced_tag_by_user')}{else}{$LANG.peopleonphoto_search_tagged_by}{/if}" onBlur="setOldValue('advanced_tag_by_user')"  onfocus="clearValue('advanced_tag_by_user')"/>
              </td>
            </tr>
          {else}
            <tr>
              <td colspan="2"><input class="clsTextBox" type="text" name="advanced_people_name" id="advanced_people_name" value="{if $myobj->getFormField('people') != ''}{$myobj->getFormField('people')}{elseif $myobj->getFormField('tag_name') != ''}{$myobj->getFormField('tag_name')}{else}{$LANG.peopleonphoto_search_people_name}{/if}" onBlur="setOldValue('advanced_people_name')"  onfocus="clearValue('advanced_people_name')"/></td>
              {*<td><input class="clsTextBox" type="text" name="advanced_tag_by_user" id="advanced_tag_by_user" value="{if $myobj->getFormField('advanced_tag_by_user') != ''}{$myobj->getFormField('advanced_tag_by_user')}{else}{$LANG.peopleonphoto_search_tagged_by}{/if}" onBlur="setOldValue('advanced_tag_by_user')"  onfocus="clearValue('advanced_tag_by_user')"/></td>*}
            </tr>
           {/if}
            <tr>
              <td colspan="2" align="right" valign="middle"><div class="clsSearchButton-l"><span class="clsSearchButton-r">
                  <input type="submit" name="avd_search" id="avd_search"  onclick="document.searchAdvancedFilter.start.value = '0';" value="{$LANG.peopleonphoto_search_submit}" />
                  </span></div>
                <div class="clsResetButton-l"><span class="clsResetButton-r">
                  <input type="button" name="avd_reset" id="avd_reset"  value="{$LANG.peopleonphoto_reset_submit}" onclick="location.href='{$photoTagsRedirectUrl}'"/>
                  </span></div></td>
            </tr>
          </table>
          </div>
       </div>
	  {$myobj->setTemplateFolder('general/','photo')}
      {include file='box.tpl' opt='form_bottom'}
	</div>
  <!-- Search Ends Here -->
  </form>
  <div id="selLeftNavigation">
    <form name="peopleOnPhotoForm" id="peopleOnPhotoForm" method="post" action="{$myobj->getCurrentUrl()}" autocomplete="off">
     {$myobj->populatePhotoListHidden($paging_arr)}
	 {if $myobj->isShowPageBlock("block_photo_list")}
      <div class="clsViewBorder clsOverflow">
        <div class="clsThumbViewLeft">
          <p class="clsThumbView">&nbsp;</p>
        </div>

        <div class="clsSortByLinksContainer">
          <div class="clsSortByPagination clsPhotoPaginationRight">
            <div class="clsPhotoPaging">
              <div class="clsPagingList">
			  	{if $CFG.admin.navigation.top}
                	{$myobj->setTemplateFolder('general/', 'photo')}
                	{include file=pagination.tpl}
                {/if}
			  </div>
            </div>
          </div>
        </div>
      </div>
      <a href="javascript:void(0)" id="{$myobj->my_photos_form.anchor}"></a>
      {assign var=count value=1}
      <div id="selDetailViewId">
        {foreach from=$photo_list_result item=result key=inc name=photo}
        <input type="hidden" name="default" id="default" value="{$myobj->getFormField('default')}" />
        {cycle values='clsOddListContents , clsEvenListContents ' assign=CellCSS}
        <div class="{$CellCSS} clsListContents {if $count % 3 == 0} clsThumbPhotoFinalRecord{/if}">
         <div class="clsPeopleOnPhoto">
          {$myobj->setTemplateFolder('general/','photo')}
          {include file="box.tpl" opt="listimage_top"}
            <div class="clsOverflow">
            <div class="clsThumb">
              <div class="clsLargeThumbImageBackground clsNoLink" onmouseover="showCaption('hideMenu_{$result.record.photo_id}');" onmouseout="hideCaption('hideMenu_{$result.record.photo_id}')">
                <div class="clsPhotoThumbImageOuter" >
					<a  href="{$result.viewphoto_url}" class="cls146x112 clsImageHolder clsImageBorderBg clsPointer"><img src="{$result.img_src}" title="{$result.photo_title_word_wrap_js}" alt="{$result.photo_title_word_wrap_js|truncate:25}" id="image_img_{$result.record.photo_id}" {$myobj->DISP_IMAGE(142, 108, $result.t_width, $result.t_height)}/></a>
                </div>
              </div>
              <div class="clsSlideTip">  <a href="javascript:;"  title="{$LANG.common_zoom}" id="img_{$result.record.photo_id}" onclick="zoom('img_{$result.record.photo_id}','{$result.zoom_img_src}','{$result.photo_title_word_wrap_js}')" class="clsPhotoVideoEditLinks clsIndexZoomImg">{$LANG.peopleonphoto_photo_view}</a>  </div>
             </div>
            <div class="clsContentDetails clsOverflow">
              <div class="clsMoreInfoContent">
                <div class="clsOverflow">
                  <div>
                    <p class="clsHeading"><a  href="{$result.viewphoto_url}" title="{$result.photo_title_word_wrap}">{$result.photo_title_word_wrap}</a></p>
                  </div>
                  <div class="clsOverflow">
                 <div class="clsPeopleOnThisPhoto">
                  	{if isset($result.tagged_by_href)}
                      <div>
                    	<p class="clsPeoplePhotoLeft">{$LANG.peopleonphoto_people_in_this_photo}</p>
                      </div>
                      <div class="clsColon">:</div>
                      <div>
                    	<p class="clsPeoplePhotoRight clsUserLink">
                    		{foreach from=$result.tagged_by_href item=other_tags key=key}
						  		<a href="{$other_tags.viewlink}">{$other_tags.tagname}</a>
						  	{/foreach}
                    	</p>
                      </div>
                    {elseif isset($result.all_tag_href)}
                       <div>
                    	<p class="clsPeoplePhotoLeft">{$LANG.peopleonphoto_people_in_this_photo}</p>
                       </div>
                       <div class="clsColon">:</div>
                       <div>
                    	<p class="clsPeoplePhotoRight clsUserLink">
                    		{foreach from=$result.all_tag_href item=all_tags key=key}
						  		<a href="{$all_tags.viewlink}">{$all_tags.tagname}</a>
						  	{/foreach}
                    	</p>
                       </div>
                    {elseif isset($result.tagged_of_href)}
                      <div>
                    	<p class="clsPeoplePhotoLeft">{$LANG.peopleonphoto_people_in_this_photo}</p>
                      </div>
                      <div class="clsColon">:</div>
                      <div>
                    	<p class="clsPeoplePhotoRight clsUserLink">
                    		{foreach from=$result.tagged_of_href item=all_tags key=key}
						  		<a href="{$all_tags.viewlink}">{$all_tags.tagname}</a>
						  	{/foreach}
                    	</p>
                      </div>
                    {/if}
                    </div>
                  </div>
                  <div class="clsOverflow clsPeopleOnTags">
                    <p class="clsPeoplePhotoLeft">{$LANG.peopleonphoto_tagged_by}</p>
                    <div class="clsColon">:</div>
                    {if !isset($result.tag_by_profile_url) && !isset($result.tag_of_profile_url) && !isset($result.tag_user_profile_url)}
                    	<p class="clsPeoplePhotoRight clsUserLink"><a href="{$result.memberProfileUrl}">{$result.tagged_user_name}</a></p>
                    {elseif isset($result.tag_by_profile_url)}
                    	<p class="clsPeoplePhotoRight clsUserLink">
                    		{foreach from=$result.tag_by_profile_url item=tag_by_user_profile key=key}
				  				<a href="{$tag_by_user_profile.viewlink}" >{$tag_by_user_profile.tagname}</a>
					  		{/foreach}
						</p>
                    {elseif isset($result.tag_of_profile_url)}
                    	<p class="clsPeoplePhotoRight clsUserLink">
                    		{foreach from=$result.tag_of_profile_url item=tag_of_user_profile key=key}
				  				<a href="{$tag_of_user_profile.viewlink}">{$tag_of_user_profile.tagname}</a>
					  		{/foreach}
						</p>
                    {elseif isset($result.tag_user_profile_url)}
                    	<p class="clsPeoplePhotoRight clsUserLink">
							{foreach from=$result.tag_user_profile_url item=tag_user_profile key=key}
				  				<a href="{$tag_user_profile.viewlink}">{$tag_user_profile.tagname}</a>
					  		{/foreach}
					  	</p>
                    {/if}
                  </div>
                </div>
              </div>
            </div>
          </div>
          {$myobj->setTemplateFolder('general/','photo')}
 		  {include file="box.tpl" opt="listimage_bottom"}
         </div>
        </div>
        {assign var=count value=$count+1}
        {/foreach} </div>
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
      {else}
      <div id="selMsgAlert">
        <p>{$LANG.peopleonphoto_no_photos_found}</p>
      </div>
      {/if}
    </form>
  </div>
{$myobj->setTemplateFolder('general/','photo')}
{include file='box.tpl' opt='photomain_bottom'}
</div>