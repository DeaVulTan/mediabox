{literal}
<style type="text/css">
 .clsPhotoBalloon{
	margin-left:-110px !important;
	width:97px !important;
}
</style>
{/literal}
<div id="selViewPhoto">
{$myobj->setTemplateFolder('general/', 'photo')}
{include file='information.tpl'}
{*------ FLAGGED PHOTO CONFIRMATION FORM START ---------*}
    {if $myobj->isShowPageBlock('confirmation_flagged_form')}
    {$myobj->setTemplateFolder('general/', 'photo')}
     {include file='box.tpl' opt='listimage_top'}
        <div id="flaggedForm" class="clsFlaggedForm">
            <p class="clsFlaggedForm">{$LANG.viewphoto_flagged_msg}</p>
           <div class="clsOverflow">
            <div class="clsSubmitButton-l"><div class="clsSubmitButton-r"><a href="{$myobj->flaggedPhotoUrl}" title="{$LANG.viewphoto_flagged}">{$LANG.viewphoto_flagged}</a></div></div>
           </div>
        </div>
	  {$myobj->setTemplateFolder('general/', 'photo')}
      {include file='box.tpl' opt='listimage_bottom'}
    {/if}
{*------ FLAGGED PHOTO CONFIRMATION FORM END ---------*}

{*------ ADULT PHOTO CONFIRMATION FORM START ---------*}
    {if $myobj->isShowPageBlock('confirmation_adult_form')}
     {$myobj->setTemplateFolder('general/', 'photo')}
       {include file='box.tpl' opt='listimage_top'}
        <div id="selAdultUserForm">
            <p class="clsFlaggedForm">{$myobj->replaceAdultText($LANG.confirmation_alert_text)}</p>
         <div class="clsOverflow">
            <div class="clsSubmitButton-l"><div class="clsSubmitButton-r"><a href="{$myobj->acceptAdultPhotoUrl}" title="{$LANG.viewphoto_accept}">{$LANG.viewphoto_accept}</a></div></div>
            <div class="clsSubmitButton-l"><div class="clsSubmitButton-r"><a href="{$myobj->acceptThisAdultPhotoUrl}" title="{$LANG.viewphoto_accept_this_page_only}">{$LANG.viewphoto_accept_this_page_only}</a></div></div>
            <div class="clsDeleteButton-l"><div class="clsDeleteButton-r"><a href="{$myobj->rejectAdultPhotoUrl}" title="{$LANG.viewphoto_reject}">{$LANG.viewphoto_reject}</a></div></div>
         </div>
        </div>
		{$myobj->setTemplateFolder('general/', 'photo')}
      {include file='box.tpl' opt='listimage_bottom'}
    {/if}
{*------ ADULT PHOTO CONFIRMATION FORM END ---------*}
  <div class="clsOverflow">
	<div class="clsViewPhotoLeft">
    {if $CFG.admin.photos.photo_next_prev}
      <div class="clsViewPhotoPrevNext">
		 <div class="clsViewPhotoPrevTab"><a class="{if $myobj->previous_photo_link != ''}clsViewPreviousPhoto{else}clsInactivePreviousPhoto{/if}" href="{if $myobj->previous_photo_link != ''}{$myobj->previous_photo_link}{else}javascript:;{/if}" title="{$myobj->prev_photo_title}">{$LANG.viewphoto_prev}</a></div>
         <div class="clsViewPhotoNextTab"><a class="{if $myobj->next_photo_link != ''}clsViewNextPhoto{else}clsInactiveNextPhoto{/if}" href="{if $myobj->next_photo_link != ''}{$myobj->next_photo_link}{else}javascript:;{/if}" title="{$myobj->next_photo_title}">{$LANG.viewphoto_next}</a></div>
      </div>
		 {/if}
         {if $myobj->isShowPageBlock('block_view_photo')}
         {$myobj->setTemplateFolder('general/', 'photo')}
         {include file='box.tpl' opt='sharephoto_top'}
         	<div class="clsOverflow">
            	<h2 class="clsSharePhotoHeadingLeft"><span>{$myobj->statistics_photo_title}</span></h2>


              {* ---------------DISPLAYING RATING FORM BEGINS--------------------------*}
              <div class="clsSharePhotoHeadingRight">
                {if $myobj->chkAllowRating()}
                          <div id="ratingForm">
                        <!-- <p class="clsRateThisHd"> {$LANG.viewphoto_rate_this_label}:</p>-->
                           {assign var=tooltip value=""}
                          {if !isLoggedIn()}
                                 {$myobj->populateRatingImages($myobj->photo_rating, 'photo',$LANG.viewphoto_login_message, $myobj->memberviewPhotoUrl, 'photo')}
                                 {assign var=tooltip value=$LANG.viewphoto_login_message}
                          {else}
                              <div id="selRatingPhoto" class="clsPhotoRating clsViewPhotoRating clsOverflow">
                                  {if isMember() and $myobj->rankUsersRayzz}
                                          {$myobj->populateRatingImagesForAjax($myobj->photo_rating, 'photo')}
                                  {else}
                                      {$myobj->populateRatingImages($myobj->photo_rating, 'photo', $LANG.viewphoto_rate_yourself, '#', 'photo')}
                                      {assign var=tooltip value=$LANG.viewphoto_rate_yourself}
                                  {/if}
                                &nbsp;(<span><span>{$myobj->getFormField('rating_count')}</span></span>)
                               </div>
                          {/if}
                          <script type="text/javascript">
							  {literal}
							  $Jq(document).ready(function(){
							    $Jq('#ratingLink').attr('title','{/literal}{$tooltip}{literal}');
							  	$Jq('#ratingLink').tooltip({
														track: true,
														delay: 0,
														showURL: false,
														showBody: " - ",
														extraClass: "clsToolTip",
														top: -10
													});
									});
								{/literal}
                          </script>
                         </div>
                  {/if}
              </div>
             </div>
                {* -------------- DISPLAYING RATING FORM ENDS------------------------*}

            {* view larg photo start here *}
            {* controll the image container width and height for image anotations....*}

            <div class="clsOverflow clsEmbedCountOrgSize">
                <div class="clsPhotoStatRight">
                          <div class="clsStatisticsMiddle">
                             <div class="clsStatisticsLeft">
                                <div class="clsStatisticsRight clsOverflow">
                                	<ul>

                                     <li><span>{$LANG.viewphoto_total_views}:</span><span class="clsEmberRatingLeft"> <span class="clsEmberRatingRight">{$myobj->getFormField('total_views')}</span></span></li>
                                     <li><span>{$LANG.viewphoto_total_comments}:</span><span class="clsEmberRatingLeft"> <span class="clsEmberRatingRight">{$myobj->getFormField('total_comments')}</span></span></li>

                                     <li><span>{$LANG.viewphoto_total_favourites}:</span><span class="clsEmberRatingLeft"> <span class="clsEmberRatingRight">{$myobj->getFormField('total_favorites')}</span></span></li>

                                     {*-------
                                     <p>{if $myobj->photo_rating > 1}
                                            {$LANG.viewphoto_total_ratings}:
                                        {else}
                                         {$LANG.viewphoto_total_rating}:
                                         {/if}<span id="photoRating"> {$myobj->photo_rating}</span>
                                     </p>
                                     ----------*}
                                     </ul>
                                </div>
                             </div>
                          </div>
                       </div>

                {assign var='photoContainerMaxWidth' value=591}
                {assign var='photoContainerHight' value=$myobj->large_height}
                {assign var='photoContainerWidth' value=$photoContainerMaxWidth-$myobj->large_width}
                {assign var='photoContainerWidth' value=$photoContainerWidth/2}
                {if $myobj->show_original_photo}
                <div class="clsViewOriginalImageSize">
                    <div class="clsViewOriginalSize">
                        <a class="clsViewOriginalSizeIcon" href="{$myobj->original_photo_path}" id="img_{$myobj->getFormField('photo_id')}">
                        	<span>{$LANG.viewphoto_view_original_photo}</span>
                        </a>
                    </div>
                </div>
                {/if}
            </div>
            <div class="clsViewPhotoImg">
                <div class="cls591x444 clsViewPhotoThumbImageOuter clsViewUserThumbImageOuter">
                    <div class="clsPhotoThumbImageMiddle">
                        <div class="clsPhotoThumbImageInner">
                        {if $photoContainerMaxWidth > $myobj->large_width}
                            <div style="width:{$photoContainerWidth}px;height:{$photoContainerHight}px;float:left;"></div>
                        {/if}
                            <div id="photo-area" style="float:left;">
                            <img src="{$myobj->photo_path}" {$myobj->photo_disp} title="{$myobj->statistics_photo_title}" alt="{$myobj->statistics_photo_title}" id="photo_{$myobj->getFormField('photo_id')}" >
                            </div>
                            {if $photoContainerMaxWidth > $myobj->large_width}
                            <div style="width:{$photoContainerWidth}px;height:{$photoContainerHight}px;float:left;"></div>
                        {/if}
                        </div>
                    </div>
                </div>
            </div>

            {* view larg photo ends here *}
            <div class="clsPhotoBookmarkIcons">
	         <div class="clsOverflow">
                         <div class="clsOverflow clsPhotoUrlLeft">
                          {*-----------  <div class="clsEmbedUrl">{$LANG.viewphoto_photo_url}</div> ---------------*}
                         <div class="clsPhotoUrlInputBg">
                            <input type="text" name="photo_url" id="photo_url"
                        value="{$myobj->viewPhotoEmbedUrl}" size="52" tabindex="{smartyTabIndex}" class="clsPhotoUrlTextBox" onFocus="this.select()" onClick="this.select()" READONLY  />
                        </div>
					   </div>
                        {* -----------------PHOTO EMBEDED BEGINS---------------------------- *}
                        {if $myobj->allow_embed =='Yes' and $CFG.admin.photos.embedable}
                         <div class="clsOverflow clsEmbedUrlLeft">
                         {* ---------------- <p class="clsEmbedUrl">{$LANG.viewphoto_embeddable_player}</p> ---------------*}
                          <p class="clsEmbedUrlInputBg">
                                    <input type="text" size="52" class="clsEmbedUrlTextBox" name="image_code" id="image_code" READONLY onFocus="this.select()" onClick="this.select()" value="{$myobj->embeded_code}" /></p><p class="clsEmbedUrlIcon"><a id="embed_options_key" href="javascript:void(0)" title="{$LANG.viewphoto_customize_tooltip}"><img src="{$CFG.site.url}photo/design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/icon-embedurl.gif" alt="{$LANG.viewphoto_embed_label}" title="{$LANG.viewphoto_embed_label}"></a></p>
                         </div>
                        {/if}

            {* -------------------PHOTO CUSTOMISE EMBEDED ENDS----------------------------- *}
                {if $myobj->allow_embed =='Yes' and $CFG.admin.photos.embedable}
                 <div id="customize_embed_size" class="clsCustomizeEmbedDrop" style="display:none;">
                       <div class="clsEmbededDropDown">
                            <div  class="clsEmbededDropDownArrow">
                               <p><span>{$LANG.viewphoto_customize_note}:</span>&nbsp;&nbsp;{$LANG.viewphoto_customize_embed}</p>
                             </div>
                             <div>
                                <div id="embed_error_msg" class="clsEmbededError" style="display:none"></div>
                                <form name="form_customize_embed" id="form_customize_embed" autocomplete="off">
                                <div class="clsOverflow">
                                    <div class="clsEmedWidthLeft"><span>&nbsp;<label for="embed_width">{$LANG.viewphoto_customize_width}</label>:</span>
                                        <input type="text" name="embed_width" id="embed_width" class="validate-embed validate-embed-num" tabindex="{smartyTabIndex}" maxlength="4" />
                                    </div>
                                    <div class="clsEmedHeightRight"><span><label for="embed_height">{$LANG.viewphoto_customize_height}</label>:</span>&nbsp;
                                        <input type="text" name="embed_height" id="embed_height" class="validate-embed validate-embed-num" tabindex="{smartyTabIndex}" maxlength="4" />
                                    </div>
                                </div>
                              <div class="clsOverflow clsEmbedBtns">
                                <div class="clsEmbdButtonLeft"><div class="clsEmbdButtonRight">
                                 <a href="javascript:;" name="change_embed_code" id="change_embed_code" onclick="customizeEmbedOptions();" title="{$LANG.viewphoto_customize_apply}"/>{$LANG.viewphoto_customize_apply}</a>
                                </div></div>
                              <div class="clsEmbdButtonLeftdefault"><div class="clsEmbdButtonRightdefault">
                                    <a href="javascript:void(0)" onclick="customizeEmbedOptions('default')" title="{$LANG.viewphoto_customize_default_size}">{$LANG.viewphoto_customize_default_size}</a>
                               </div></div>
                                <a class="clsEmbdClose" href="javascript:void(0)" id="close_embed_options" title="{$LANG.viewphoto_customize_close}">{$LANG.viewphoto_customize_close}</a>
                              </div>
                            </form>
                          </div>
                        </div>
                    </div>
                 {/if}
            {* -------------------PHOTO CUSTOMISE EMBEDED ENDS----------------------------- *}


           {* -------------------PHOTO EMBEDED ENDS----------------------------- *}
                   </div>
            </div>

			{$myobj->setTemplateFolder('general/', 'photo')}
		 {include file='box.tpl' opt='sharephoto_bottom'}
        {/if}{* block_view_photo ends *}

      </div>

	 <div class="clsViewPhotoRight">
     {*------------------------------ PHOTO DETAILS SECTION START HERE----------------------------------------*}
       {$myobj->setTemplateFolder('general/', 'photo')}
       {if $myobj->isShowPageBlock('block_viewphoto_photodetails')}
       {include file='box.tpl' opt='userurl_top'}
       <div id=" " class="clsViewPhotoUserDetailsContent">
       		{if !empty($myobj->statistics_photo_caption)}
	        	<div class="clsPhotoDescription" >
	            	<h3>{$LANG.viewphoto_photo_desc}</h3>
	                <p id="photoCaptionContent" class="clsPhotoDes">{$myobj->statistics_photo_caption}</p>
	           	</div>
	         {else}
			   	<div class="clsPhotoDescription" >
	           		<h3>{$LANG.viewphoto_no_description}</h3>
	           	</div>
	         {/if}
             <div class="clsOverflow clsLocations" id="selLocationDiv" style="display:{if $myobj->getFormField('location')!=''} block {else} none {/if}">
                 <p>{$LANG.viewphoto_location} :
                	 <span class="" id="selLocationValue">{$myobj->getFormField('location')}</span>
                 </p>
             </div>
           <div class="clsTags">
		   	<p>{$LANG.viewphoto_photo_tags}:
		   		{foreach from=$subscription_tag_list.item item=tag}
		   			<a id="photo_tag_{$tag.name}" href="{$tag.url}" title="{$tag.name}">{$tag.name}</a>
		   		{/foreach}
		   	</p>
		   </div>
           <div class="clsViewPhotoDetails">
             <div class="clsOverflow">
               <div class="clsUserIcon">
                        <a href="{$myobj->memberProfileUrl}" class="Cls45x45 clsImageHolder clsUserThumbImageOuter">
                            <img src="{$myobj->memberProfileImgSrc.s_url}" alt="{$myobj->getFormField('user_name')|truncate:5}" title="{$myobj->getFormField('user_name')}" {$myobj->DISP_IMAGE(45,45,$myobj->getFormField('small_width'),$myobj->getFormField('small_height')) }>
                        </a>
                    </div>
                <div class="clsOverflow clsFloatRight clsPhotoUserDetails">
                	  <div class="clsOverflow">
                          <div class="clsUserDetails">
                              <div class="clsOverflow">
                                 <p class="clsAddedBy">{$LANG.viewphoto_added_by} <span><a href="{$myobj->memberProfileUrl}" title="{$myobj->getFormField('photo_added_by')}">{$myobj->getFormField('photo_added_by')}</a></span></p>
                                 <p class="clsAddedDate">{$LANG.viewphoto_date} <span>{$myobj->getFormField('date_added')}</span></p>
                              </div>
                          </div>
                      </div>
                      <p class="clsAlbum">{$LANG.viewphoto_album_title}: <span>{$myobj->statistics_album_title}</span></p>
                      <div class="clsOverflow">
					{*----------- DISPLAYING BOOKMARK LINK BEGIN------------- *}
						   	{*SUBSCRIPTION LINK FOR USER STARTS HERE*}
                           {if chkIsSubscriptionEnabled() and chkIsSubscriptionEnabledForModule()}
					{if isMember()}
                              	{if $myobj->getFormField('user_id') != $CFG.user.user_id}
                                     <p class="clsSubscriptionBtn">
                                          <a href="javascript:void(0);" id="anchor_subscribe" onclick="get_subscription_options({$myobj->getFormField('user_id')}, 50, -300, 'anchor_subscribe');"  title="{$LANG.common_click_subscribe}">{$LANG.common_subscriptions}</a>
                                     </p>
                                    {/if}
                              {else}
                                     <p class="clsSubscriptionBtn">
                                 		   <a href="javascript:void(0)" onclick="memberBlockLoginConfirmation('{$LANG.common_photo_subscribe_subscribe_msg}', '{$myobj->memberviewPhotoUrl}')" title="{$LANG.common_subscriptions}">{$LANG.common_subscriptions}</a>
 	                                </p>
                              {/if}
                           {/if}
				   {*SUBSCRIPTION LINK FOR USER ENDS HERE*}
                    {*------------ DISPLAYING EDIT PHOTO LINK BEGIN--------------*}
						 	{if $myobj->photoOwner}
                            <div class="clsPhotoViewCustomize">
                        		<p class="clsEmbededDropContainer clsViewCustomize">
                                	<a class="clsEmbededDrop" href="{$myobj->managephoto_url}" title="{$LANG.viewphoto_edit_photo_link}">
                                    	<span>{$LANG.viewphoto_edit_photo_link}</span>
                                    </a>
                                </p>
                        	</div>
                            {/if}
                          {*------------ DISPLAYING EDIT PHOTO LINK ENDS--------------*}
                          {*
                      	   <div class="clsOverflow clsShareQuickEdit">
                             <p class="clsPostPhoto">{ $myobj->populateBlogPost($myobj->blogPostViewphotoUrl, $myobj->getFormField('photo_title'),$LANG.viewphoto_post_photo) }</p>
                           </div>
                           *}
                        {*------------ DISPLAYING BOOKMARK LINK ENDS--------------*}
              		  </div>
                  </div>
            	</div>
           </div>
       </div>
       {$myobj->setTemplateFolder('general/', 'photo')}
       {include file='box.tpl' opt='userurl_bottom'}
       {/if}{* block_viewphoto_photodetails end *}
        {*------------------------------ PHOTO DETAILS SECTION END HERE----------------------------------------*}


    	{* ---------------------------- PEOPLE ON PHOTO DETAILS SECTION STARTS------------------------------ *}
    {if $myobj->isShowPageBlock('block_people_on_photos') && $myobj->is_peole_photo_tag}
     <div class="clsStatisticsContent">
        {$myobj->setTemplateFolder('general/', 'photo')}
        {include file="box.tpl" opt="peopleinthisphoto_top"}
        	{if $myobj->large_width >= $CFG.admin.photos.canvas_add_tag_allowed_width}
	    		<div class="clsOverflow">
	        		<h3 class="clsViewPhotoHeading clsFloatLeft">{$LANG.viewphoto_people_on_photo_label}</h3>
	        		<p class="clsFloatRight clsHighlightall" id="selHighlightLink" {if !$myobj->populatePeopleOnPhoto_arr}style="display:none"{/if}>
						<a id="idt-highlight-link" href="javascript:;" onclick="tag.photo.toggleAllTaggedIdentities(event);" title="{$LANG.viewphoto_people_on_photo_highlight_all}">{$LANG.viewphoto_people_on_photo_highlight_all}</a>
					</p>
	        	</div>
            {/if}

            <div id="photo_response_text"></div>
            {if $myobj->large_width >= $CFG.admin.photos.canvas_add_tag_allowed_width}
            <ul id="idt-tag-list">
                    {assign var=highlight value=0}
                    {foreach key=tagKey item=tagValue from=$myobj->populatePeopleOnPhoto_arr}
                   <li  id="idt-tag-id_{$tagValue.photo_people_tag_id}" onmouseover="tag.photo.highlightIdentityTag({$tagValue.photo_people_tag_id});" onmouseout="tag.photo.unhighlightIdentityTag({$tagValue.photo_people_tag_id});">
                        <div class="relative">
                            <a title="{$tagValue.tag_name}" id="tag_canvas_img_{$tagValue.photo_people_tag_id}" href="{$tagValue.tagging_href}">
                            {if $tagValue.default_icon}
                              <canvas id="canvas_{$tagValue.photo_people_tag_id}" class="idt-photo" width="{$CFG.admin.photos.canvas_tag_width}" height="{$CFG.admin.photos.canvas_tag_height}" {$myobj->DISP_IMAGE(43, 43, $CFG.admin.photos.canvas_tag_width, $CFG.admin.photos.canvas_tag_height)}></canvas>
                            {else}
                             <img src="{$tagValue.tagged_icon.s_url}" class="idt-photo" width="{$CFG.admin.photos.canvas_tag_width}" height="{$CFG.admin.photos.canvas_tag_height}" alt="{$tagValue.tag_name}" title="{$tagValue.tag_name}" {$myobj->DISP_IMAGE(43, 43, $tagValue.width, $tagValue.height)}/>
                            {/if}
                            </a>
                            {if isMember() && ($tagValue.user_name|| $tagValue.tagged_by_user_id==$CFG.user.user_id)}
                            <div class="clsPeoplePhoto" style="display:none" id="delete_canvas_link_{$tagValue.photo_people_tag_id}">
                                {if $tagValue.user_name}
                                <div class="idt-associate-remove-link">
                                <a href="javascript:;" class="clsPhotoVideoEditLinks" onclick="tag.photo.removeAssociate({$tagValue.photo_people_tag_id}, {$tagValue.tagged_by_user_id}, '{php}echo time();{/php}')" title="{$LANG.viewphoto_annotation_remove_associate}">
                                <img src="{$CFG.site.url}photo/design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/canvas/trash.gif">
                                </a>
                                </div>
                                {/if}
                                <div class="idt-quick-link-del">
                                <a href="javascript:;" class="clsPhotoVideoEditLinks" onclick="tag.photo.removeIdentityTag({$tagValue.photo_people_tag_id}, {$tagValue.tagged_by_user_id}, '{php}echo time();{/php}')" title="{$LANG.viewphoto_annotation_delete}">
                                <img src="{$CFG.site.url}photo/design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/canvas/delete.gif">
                                </a>
                                </div>
                           </div>
                        {/if}
                        </div>
					</li>
                    {assign var=highlight value=1}
                   {/foreach}
                   {if isMember() && ($myobj->getFormField('allow_tags')=='Yes' || $myobj->getFormField('user_id')==$CFG.user.user_id)}
	                    <li id="add-identity-tag">
	                        <div class="relative">
	                            <img src="{$CFG.site.url}photo/design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/canvas/add_identity.gif" style="width:{$CFG.admin.photos.canvas_tag_width}px;height:{$CFG.admin.photos.canvas_tag_height}px;" alt="{$LANG.viewphoto_add_people}" title="{$LANG.viewphoto_add_people}">
	                            <div class="idt-quick-link">
	                               <img src="{$CFG.site.url}photo/design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/canvas/add.gif" alt="{$LANG.viewphoto_annotation_add}" title="{$LANG.viewphoto_annotation_add}">
	                            </div>
	                        </div>
	                    </li>
                   {/if}
               </ul>
			<input type="hidden" id="idt-tagged-users" value="{$myobj->photo_tag_ids}"/>
            {else}
            	<div class="clsOverflow">
	        		<h3 class="clsViewPhotoHeading clsFloatLeft">{$LANG.viewphoto_people_on_photo_label}</h3>
				</div>
             	<div class="clsNoRecordsFound">
            		{$myobj->viewphoto_canvas_error_message}
              	</div>
            {/if}
        {$myobj->setTemplateFolder('general/', 'photo')}
        {include file="box.tpl" opt="peopleinthisphoto_bottom"}
      </div>
      {elseif $myobj->getFormField('allow_tags') !='Yes' && !$myobj->isShowPageBlock('confirmation_flagged_form')}
      	<div class="clsStatisticsContent">
	        {$myobj->setTemplateFolder('general/', 'photo')}
	        {include file="box.tpl" opt="peopleinthisphoto_top"}
	        <div class="clsOverflow">
		    	<h3 class="clsViewPhotoHeading">{$LANG.viewphoto_people_on_photo_label}</h3>
			  	<p class="clsAddErrorMsg">{$LANG.viewphoto_people_on_photo_tagging_disabled}</p>
			</div>
			{$myobj->setTemplateFolder('general/', 'photo')}
	        {include file="box.tpl" opt="peopleinthisphoto_bottom"}
	    </div>
	  {elseif !$myobj->isShowPageBlock('confirmation_flagged_form')}
	  	<div class="clsStatisticsContent">
	        {$myobj->setTemplateFolder('general/', 'photo')}
	        {include file="box.tpl" opt="peopleinthisphoto_top"}
	        <div class="clsOverflow">
		    	<h3 class="clsViewPhotoHeading">{$LANG.viewphoto_people_on_photo_label}</h3>
			  	<p class="clsNoRecordsFound">{$LANG.viewphoto_people_on_photo_no_people_found}</p>
			</div>
			{$myobj->setTemplateFolder('general/', 'photo')}
	        {include file="box.tpl" opt="peopleinthisphoto_bottom"}
	    </div>
      {/if}

    {* -----------------------------PEOPLE ON PHOTO DETAILS SECTION END ---------------------------*}



     {* -----------------------------GOOGLE MAP DETAILS SECTION STARTS ---------------------------*}
     {if $myobj->isShowPageBlock('block_add_location')  && $CFG.admin.photos.add_photo_location}
        <div class="clsViewPhotoGoogle">
            <div class="clsOverflow clsLocationHeader">
            <div class="clsUpdateLocationLeft">{$LANG.viewphoto_location_title}</div>
            {if isMember() &&  ($myobj->getFormField('user_id')==$CFG.user.user_id || isAdmin())}
               <div class="clsUpdateLocation">
               		<a id="updatePhotoLocation" class="clsVideoVideoEditLinks clsPhotoVideoEditLinks" href="javascript:;" title="{$LANG.viewphoto_update_location}"></a>
               </div>
            {/if}
           </div>
            <div id="map_canvas" class="clsViewPhotoGoogleMap"></div>
            <div class="clsViewPhotoSelectedArea">
              <div id="selSeletedArea" class="clsSelectedArea">{$myobj->getFormField('location')}</div>
            </div>
        {literal}
          <script language="javascript">
           $Jq(document).ready(function() {
            initialize();
           });
          </script>
        {/literal}
     </div>
  	{elseif !$myobj->isShowPageBlock('confirmation_flagged_form')}
	   <div>{php}getAdvertisement('sidebanner2_234x60'){/php}</div>
  	{/if}
    {* -----------------------------GOOGLE MAP DETAILS SECTION END ---------------------------*}



	{if $myobj->isShowPageBlock('block_viewphoto_action_tabs')}
	<!-- quick slide, flag, add to slide list stats -->
    <div class="clsViewPhotoPageListMenu clsViewPhotoMenuBorder clsOverflow">
        {$myobj->setTemplateFolder('general/', 'photo')}
        {include file="box.tpl" opt="viewshare_top"}
        <div id="viewPhotoTabs">
            <ul class="clsOverflow">
                {if $myobj->allow_quickmixs}
                <li id="selHeaderQuickslide" onmouseover="tabChange('selHeaderQuickslide', 'over')" onmouseout="tabChange('selHeaderQuickslide', 'out')"><span><a href="#viewPhotoQuickSlide" title="{$LANG.viewphoto_quickslide}">{$LANG.viewphoto_quickslide}</a></span></li>
                {/if}
                <li id="selHeaderFlag" onmouseover="tabChange('selHeaderFlag', 'over')" onmouseout="tabChange('selHeaderFlag', 'out')"><span><a href="#viewPhotoFlag" title="{$LANG.viewphoto_flag}">{$LANG.viewphoto_flag}</a></span></li>
                <li id="selHeaderSlidelist" onmouseover="tabChange('selHeaderSlidelist', 'over')" onmouseout="tabChange('selHeaderSlidelist', 'out')"><span><a href="#viewPhotoSlidelist" title="{$LANG.viewphoto_slidelist}">{$LANG.viewphoto_slidelist}</a></span></li>
            </ul>
            <div id="viewPhotoQuickSlide">
            	{if $myobj->allow_quickmixs}
            	{if !isMember()}
            	<div id="quick_mix_{$myobj->getFormField('photo_id')}">
                    <span><a class="quickslide" href="javascript:void(0);" onclick="memberBlockLoginConfirmation('{$LANG.sidebar_login_quickslide_err_msg}','{$myobj->memberviewPhotoUrl}'); return false;" title="{$LANG.viewphoto_quickslide}"><span class="clsQuickslideAdd">{$LANG.viewphoto_quickslide}</span></a></span>
                </div>
                {else}
            	<div id="quick_mix_{$myobj->getFormField('photo_id')}"{if $myobj->is_quickmix_added} style="display:none"{/if}>
                    <span><a class="quickslide" href="javascript:void(0);" onclick="getViewPhotoMoreContent('Quickslide');" title="{$LANG.viewphoto_add_to_quickslide}"><span class="clsQuickslideAdd">{$LANG.viewphoto_add_to_quickslide}</span></a></span>
                </div>
                <div id="quick_mix_added_{$myobj->getFormField('photo_id')}"{if !$myobj->is_quickmix_added} style="display:none"{/if}>
                    <span><a class="quickslide" href="javascript:void(0);" onclick="getViewPhotoMoreContent('Quickslide', 'remove');" title="{$LANG.viewphoto_remove_from_quickslide}"><span class="clsQuickslideRemove">{$LANG.viewphoto_remove_from_quickslide}</span></a></span>
                </div>
                <div id="quick_mix_saving_{$myobj->getFormField('photo_id')}" style="display:none">
                	<span><a class="quickslide"><span class="clsQuickslideSaving" title="{$LANG.viewphoto_saving}">{$LANG.viewphoto_saving}</span></a></span>
                </div>
                {/if}
                {/if}
            </div>
            {$myobj->populateFlagContent()}
            <div id="viewPhotoSlidelist">
            {$myobj->populateSlideListContent()}
            </div>
        </div>
        <script type="text/javascript">$Jq("#viewPhotoTabs").tabs();</script>
    	{$myobj->setTemplateFolder('general/', 'photo')}
    	{include file="box.tpl" opt="viewshare_bottom"}
	</div>
    <!-- quick slide, flag, add to slide list ends -->

                            <div class="clsOverflow clsFeauredShare">
                            <ul>
                            {if isMember()}
                                <li id="selHeaderSharePhoto">
                                   <a class="sharephoto clsSharePhoto" onclick="showShareDiv('{$myobj->share_url}')" title="{$LANG.viewphoto_share_photo}"><span>{$LANG.viewphoto_share_photo}</span></a>
                                </li>
                                <li id="selHeaderFeatured" onmouseover="tabChange('selHeaderFeatured', 'over')" onmouseout="tabChange('selHeaderFeatured', 'out')">
                                        <div id="add_featured"{if $myobj->featured.added} style="display:none"{/if}>
                                              <a class="feature clsFeature" href="javascript:void(0);" onclick="getViewPhotoMoreContent('Featured');" title="{$LANG.viewphoto_feature}"><span>{$LANG.viewphoto_feature}</span></a>
                                         </div>
                                         <div id="added_featured"{if !$myobj->featured.added} style="display:none"{/if}>
                                            <a class="featured clsFeatured" href="javascript:void(0);" onclick="getViewPhotoMoreContent('Featured', 'remove');" title="{$LANG.viewphoto_featured}"><span>{$LANG.viewphoto_featured}</span></a>
                                         </div>
                                            <div id="featured_saving" style="display:none"><a class="featured clsFeatured" title="{$LANG.viewphoto_saving}"><span>{$LANG.viewphoto_saving}</span></a></div>

	                            </li>
                                <li id="selHeaderFavorites"  onmouseover="tabChange('selHeaderFavorites', 'over')" onmouseout="tabChange('selHeaderFavorites', 'out')">
                                        <div id="add_favorite"{if $myobj->favorite.added} style="display:none"{/if}>
                                             <span><a class="favorites clsFavourites" href="javascript:void(0);" onclick="getViewPhotoMoreContent('Favorites');" title="{$LANG.viewphoto_favorites}"><span>{$LANG.viewphoto_favorites}</span></a></span>
                                        </div>
                                         <div id="added_favorite"{if !$myobj->favorite.added} style="display:none"{/if}>
                                              <span><a class="favorited clsFavourited" href="javascript:void(0);" onclick="getViewPhotoMoreContent('Favorites','remove');" title="{$LANG.viewphoto_favorited}"><span>{$LANG.viewphoto_favorited}</span></a></span>
                                         </div>
                                         <div id="favorite_saving" style="display:none"><a class="favorited clsFavourited" title="{$LANG.viewphoto_saving}"><span>{$LANG.viewphoto_saving}</span></a></div>
                                </li>
                             {else}
                                 <li id="selHeaderSharePhoto">
                                    <a class="sharephoto clsSharePhoto" onclick="showShareDiv('{$myobj->share_url}')" title="{$LANG.viewphoto_share_photo}"><span>{$LANG.viewphoto_share_photo}</span></a>
                                </li>
                                 <li id="selHeaderFeatured" onmouseover="tabChange('selHeaderFeatured', 'over')" onmouseout="tabChange('selHeaderFeatured', 'out')">
                                       <a class="feature clsFeature" href="javascript:void(0);" onclick="memberBlockLoginConfirmation('{$LANG.sidebar_login_featured_err_msg}','{$myobj->memberviewPhotoUrl}'); return false;" title="{$LANG.viewphoto_feature}"><span>{$LANG.viewphoto_feature}</span></a>
                                  </li>
                                 <li id="selHeaderFavorites" onmouseover="tabChange('selHeaderFavorites', 'over')" onmouseout="tabChange('selHeaderFavorites', 'out')">
                                        <a class="favorites clsFavourites" href="javascript:void(0);" onclick="memberBlockLoginConfirmation('{$LANG.sidebar_login_favorite_err_msg}','{$myobj->memberviewPhotoUrl}'); return false;" title="{$LANG.viewphoto_favorites}"><span>{$LANG.viewphoto_favorites}</span></a>
                                 </li>
                            {/if}
                            </ul>
                            </div>
							<div id="selSharePhotoContent" style="display:none"></div>


    {* -----------------------------QUICKSLIDE AND DETAILS SECTION END ---------------------------*}
	{/if}
   </div>
  </div>

     {$myobj->setTemplateFolder('general/', 'photo')}
     {include file="box.tpl" opt="viewphotocomment_top"}
  <div class="clsOverflow">
     <div class="clsViewCommentLeft">
       {*------------------------------ PHOTO STATISTICS SECTION START HERE----------------------------------------*}
       {* Commented Photo statistics section starts here (commented code includes tag subscription also)
        {if $myobj->isShowPageBlock('block_viewphoto_statistics')}
          <div class="clsOverflow">
            <h3 class="clsViewPhotoHeading">{$LANG.viewphoto_statistics_label}</h3>
               {$myobj->setTemplateFolder('general/', 'photo')}
               {include file='box.tpl' opt='viewphoto_top'}
                     <div class="clsPhotoStatistics">
                         <div class="clsOverflow">
                          <div class="clsPhotoStatLeft">
                             <div><div class="clsPhotoStatLeftContent">{$LANG.viewphoto_photo_title}</div><div class="clsColon">:</div><div class="clsPhotoStatRightContent"><span>{$myobj->statistics_photo_title}</span></div></div>
                           </div>
                         </div>

                         <div class="clsPhotoStatDescription clsOverflow">
                            <div class="clsPhotoStatLeftContent">{$LANG.viewphoto_photo_tags}</div><div class="clsColon">:</div>
                            <div class="clsPhotoStatTagContent">
                                {foreach from=$subscription_tag_list.item item=tag}
                                   <div>
                                    <div class="clsViewPhotoTagContent"><a id="photo_tag_{$tag.name}" href="{$tag.url}" {if isMember() and chkIsSubscriptionEnabled() and chkIsSubscriptionEnabledForModule()} onmouseover="showSubscriptionDetail('{$tag.add_slash_name}');" {/if} title="{$tag.name}">{$tag.name}</a><span id="photoPopUp_"><!----></span></div>
                                   {if isMember() and chkIsSubscriptionEnabled() and chkIsSubscriptionEnabledForModule()}
                                    <div id="photoPopUp_{$tag.name}" style="visibility:hidden;" class="clsTagStyleIcon" {if isMember() and chkIsSubscriptionEnabled() and chkIsSubscriptionEnabledForModule()} onmouseover="showTagDetail('{$tag.add_slash_name}');" onmouseout="hideTagDetail('{$tag.add_slash_name}');" {/if}>
                                    <span class="clsSubscribeIcon"></span>

                                    <div style="display:none" id="taglist_{$tag.name}">
                                      <div class="clsPopSubcriptionPhotoTag">
                                        <div class="clsPopUpSubsDivContainer">
                                        {$myobj->setTemplateFolder('general/', 'photo')}
                                        {include file='box.tpl' opt='popinfotag_top'}
                                           <div class="clsPopUpPaddingContent clsOverflow" >
                                            <p class="clsPopUpSubsContent">
                                              <span>{$LANG.common_totalsubscriptions}: </span>
                                              <span id="total_tag_sub_{$tag.name}">({$myobj->getTagSubscriptionCount($tag.name, 'photo')})</span>
                                            </p>
                                            <p class="clsSubscriptionBtn" >
                                             <span id="subscribe_{$tag.name}" style="display:{if !$tag.subscription} block; {else} none; {/if}"><a href="javascript:void(0);" id="anchor_subscribe"  onclick="subscription_sep_action('{$tag.add_slash_name}', 'Yes', 'photo', 'Tag');"  title="{$LANG.common_subscribe}">{$LANG.common_subscribe}</a></span>
                                             <span id="unsubscribe_{$tag.name}" style="display:{if $tag.subscription} block; {else} none; {/if}"><a href="javascript:void(0);" id="anchor_subscribe"  onclick="subscription_sep_action('{$tag.add_slash_name}', 'No', 'photo', 'Tag');"  title="{$LANG.common_unsubscribe}">{$LANG.common_unsubscribe}</a></span>
                                            </p>
                                          </div>
                                        {$myobj->setTemplateFolder('general/', 'photo')}
                                        {include file='box.tpl' opt='popinfotag_bottom'}
                                       </div>
                                     </div>
                                    </div>

                                    </div>
                                    {/if}
                                   </div>
                              {/foreach}
                            </div>
                        </div>

                     </div>
               {$myobj->setTemplateFolder('general/', 'photo')}
               {include file='box.tpl' opt='viewphoto_bottom'}
         </div>
       {/if}
       Commented Photo statistics section ends here *}
       {*------------------------------ PHOTO STATISTICS SECTION END HERE----------------------------------------*}


       {*------------------------------ PHOTO COMMENT SECTION START HERE----------------------------------------*}
       {if $myobj->isShowPageBlock('photo_comments_block')}
       		<div class="clsOverflow">
            	<div class="clsViewPhotoCommentHeading">
                	<h3>{$LANG.viewphoto_comments_label}&nbsp;(<span id="total_comments">{$myobj->getFormField('total_comments')}</span>)</h3>
                    {*{if $myobj->getFormField('total_comments')==0}
                       <div class="clsNoRecordsFound">{$LANG.viewphoto_no_comments_found}</div>
                    {else}
                        <span class="clsListContents">
                        {if $myobj->getFormField('total_comments')=='1'}
                            ( <span id="total_comments">{$myobj->getFormField('total_comments')}</span> )
                        {else}
                            ( <span id="total_comments">{$myobj->getFormField('total_comments')}</span> )
                         {/if}
                        </span>
                    {/if}*}
                </div>
            </div>

	   {$myobj->setTemplateFolder('general/', 'photo')}
       {include file="box.tpl" opt="viewphoto_top"}
            {$myobj->populateCommentOptionsPhoto()}
            <div id="selMsgSuccess" style="display:none">
                <p id="kindaSelMsgSuccess"></p>
            </div>
			<div id="selMsgConfirmWindow" class="clsMsgConfirmWindow" style="display:none;">
				<p id="confirmationMsg"></p>
                &nbsp;
				<form name="msgConfirmform" id="msgConfirmform" method="post" action="{$myobj->getCurrentUrl()}">
			      	<input type="button" class="clsSubmitButton" name="confirm_action" id="confirm_action" onclick="deleteCommandOrReply();" value="{$LANG.common_yes_option}" tabindex="{smartyTabIndex}" />
			      	&nbsp;
			      	<input type="button" class="clsCancelButton" name="cancel" id="cancel" value="{$LANG.common_no_option}" tabindex="{smartyTabIndex}" onclick="return hideAllBlocks();" />
			      	<input type="hidden" name="comment_id" id="comment_id" />
			      	<input type="hidden" name="maincomment_id" id="maincomment_id" />
			      	<input type="hidden" name="commentorreply" id="commentorreply" />
				</form>
			</div>

        	<div class="clsOverflow">
                <div class="clsViewPhotoCommentHeadingRight">
                	{if $myobj->getFormField('allow_comments')=='Kinda' OR $myobj->getFormField('allow_comments')=='Yes'}
		                {if isMember()}
                        	<div class="clsOverflow">
                                <span id="selViewPostComment" class="clsViewPostComment">
                                    <a href="javascript:void(0);" class="clsCommentBgLeft" onclick="$Jq('#photo_comment_add_block').toggle('slow');"
                                            title="{$LANG.viewphoto_post_comment}" id="add_comment"><span>{$LANG.viewphoto_post_comment}</span> </a>

                                     <a href="javascript:void(0);" class="clsCommentBgLeft" onclick="showCancelPhotoComment()"
                                     id="cancel_comment" style="display:none;"><span>{$LANG.viewphoto_cancel_comments_label}</span> {if $myobj->getFormField('allow_comments')=='Kinda'}({$LANG.viewphoto_approval}){/if}</a>
                                </span>
                            </div>
                        {if $myobj->getFormField('allow_comments')=='Kinda'} <p class="clsApproval">({$LANG.viewphoto_approval})</p>{/if}
		                {else}
		                	<span id="selViewPostComment" class="clsViewPostComment">
		                        <a href="javascript:void(0);" class="clsCommentBgLeft" onclick="memberBlockLoginConfirmation('{$LANG.sidebar_login_comment_post_err_msg}','{$myobj->commentUrl}');return false;">
		                    	   <span>{$LANG.viewphoto_post_comment}</span> {if $myobj->getFormField('allow_comments')=='Kinda'}({$LANG.viewphoto_approval}){/if}
		                        </a>
		                    </span>
		                {/if}
                    {/if}
                </div>
            </div>
			{$myobj->setTemplateFolder('general/','photo')}
			{include file="addComments.tpl"}
            <div id="selCommentBlock" class="clsViewPhotoDetailsContent">
                {$myobj->populateCommentOfThisPhoto()}
            </div>
	   {$myobj->setTemplateFolder('general/', 'photo')}
       {include file="box.tpl" opt="viewphoto_bottom"}
       {/if}
       {*------------------------------ PHOTO COMMENT SECTION END HERE----------------------------------------*}
  </div>
     <div class="clsViewRelatedPhotosRight">
     		{*----------------------- DISPLAYING MORE RELATED PHOTO BEGIN ------------------------*}
      {if $myobj->isShowPageBlock('block_view_photo_more_photos')}
                    <div class="clsIndexphotoContainer">
                    	<div class="clsOverflow">
                        	<div class="clsMorePhotos">
                            	<h3>{$LANG.viewphoto_more_photos}</h3>
                            </div>
	                        <div class="clsViewPhotoListMenu">
                            <ul>
                                <li id="selHeaderPhotoRel">
                                        <a onClick="getRelatedPhoto('tag')" title="{$LANG.viewphoto_related_label}"><span>{$LANG.viewphoto_related_label}</span></a>
                                </li>
                                 <li id="selHeaderPhotoUser">
                                        <a onClick="getRelatedPhoto('user');" title="{$LANG.viewphoto_user_label}"><span>{$LANG.viewphoto_user_label}</span></a>
                                </li>
                            </ul>
                        </div>
                        </div>
                  <div class="clsViewPhotoCarosel">
	  				{$myobj->setTemplateFolder('general/', 'photo')}
                    {include file="box.tpl" opt="viewphoto_top"}
                        <div class="clsSideCaroselContainer">
                            <div id="relatedPhotoContent" class="clsMorePhotoContainer">
                            </div>
                            <!--<div class="clsDisplayNone" id="loaderPhotos" align="center">
	                            <img src="{$CFG.site.url}photo/design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/loader.gif" alt="{$LANG.viewphoto_loading}" title="{$LANG.viewphoto_loading}">{$LANG.viewphoto_loading}
                            </div>-->
                        </div>
                    </div>
                   <!--<div class="clsOverflow">
                    <div id="selNextPrev_top" class="clsPhotoCarouselPaging"> </div>
                   </div>-->
                   <script type="text/javascript">
                              var subMenuClassName1='clsActiveMorePhotos';
                              var hoverElement1  = '.clsMorePhotoNav li';
                              loadChangeClass(hoverElement1,subMenuClassName1);
                    </script>
					<script type="text/javascript">
                          var relatedUrl="{$myobj->relatedUrl}";
                          getRelatedPhoto('tag');
                    </script>
					{$myobj->setTemplateFolder('general/', 'photo')}
                    {include file="box.tpl" opt="viewphoto_bottom"}
                 </div>
	{/if}
    {* ----------------------DISPLAYING MORE RELATED PHOTO END---------------------- *}

    {*----------------------- DISPLAYING PHOTO META DETAIL BEGIN ------------------------*}
      {if $myobj->isShowPageBlock('block_view_photo_meta_details')}
        <div class="clsIndexphotoContainer clsPhotoMetaDetailsBg">
            <h3 class="clsViewPhotoHeading">{$LANG.viewphoto_meta_details_label}</h3>
              {$myobj->setTemplateFolder('general/', 'photo')}
              {include file="box.tpl" opt="viewphoto_top"}
                         <div id="photoMetaDataContent">
                            {foreach from=$myobj->meta_details_arr item=metadata}
                                <div class="clsPhotoMetaDetails clsOverflow">
                                    <div class="clsPhotoMetaResultleft">
                                    {$metadata.label}</div><div class="clsColon">:</div>
                                    <div class="clsPhotoMetaResultRight">{$metadata.value}</div>
                                </div>
                            {/foreach}
                         </div>
              {$myobj->setTemplateFolder('general/', 'photo')}
              {include file="box.tpl" opt="viewphoto_bottom"}
         </div>
	{/if}
    {* ----------------------DISPLAYING PHOTO META DETAIL END---------------------- *}

     </div>

  </div>
     {$myobj->setTemplateFolder('general/', 'photo')}
     {include file="box.tpl" opt="viewphotocomment_bottom"}

 </div>
{if $myobj->large_width >= $CFG.admin.photos.canvas_add_tag_allowed_width}
<script type="text/javascript">
	tag.photo.id = {$myobj->getFormField('photo_id')};
	{foreach key=tagKey item=tagValue from=$myobj->populatePeopleOnPhoto_arr}
		tag.photo.contactAnnotations.push(new ContactAnnotation('photo-area', {literal}{{/literal} "width":"{$tagValue.width}","height":"{$tagValue.height}","top":"{$tagValue.top}","left":"{$tagValue.left}"{literal}}{/literal}, {literal}{{/literal} "id":"{$tagValue.photo_people_tag_id}","hidden":true{literal}}{/literal}, {literal}{{/literal} "id":"{$tagValue.tagged_by_user_id}","name":"{$tagValue.tag_name}"{literal}}{/literal}));
	{/foreach}
</script>
{/if}

{* Added code to display to display fancy box to update photo location *}
<script>
{literal}
	$Jq(document).ready(function() {
		$Jq('#img_{/literal}{$myobj->getFormField('photo_id')}{literal}').fancybox({
			'width'				: '90%',
			'height'			: '90%',
			'autoScale'     	: false,
			'transitionIn'		: 'none',
			'transitionOut'		: 'none',
			'type'				: 'iframe'
		});

		$Jq('#updatePhotoLocation').fancybox({
			'width'				: 539,
			'height'			: 430,
			'autoScale'     	: false,
			'href'              : '{/literal}{$myobj->location_url}{literal}',
			'transitionIn'		: 'none',
			'transitionOut'		: 'none',
			'type'				: 'iframe'
		});
	});
	if ($Jq('#add-identity-tag')) { $Jq('#add-identity-tag').bind('click', tag.photo.addIdentityTag); }
	if ($Jq('#embed_options_key')) { $Jq('#embed_options_key').bind('click', toggleEmbedCustomize); }
	if ($Jq('#close_embed_options')) { $Jq('#close_embed_options').bind('click', toggleEmbedCustomize); }
	{/literal}
	{if !empty($myobj->statistics_photo_caption)}
		{literal}$Jq('#photoCaptionContent').jScrollPane({scrollbarWidth:10, scrollbarMargin:10,showArrows:true}); {/literal}
	{/if}
	{literal}
	$Jq('#photoMetaDataContent').jScrollPane({scrollbarWidth:10, scrollbarMargin:10,showArrows:true});
{/literal}
</script>