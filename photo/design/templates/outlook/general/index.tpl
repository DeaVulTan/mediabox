<div class="clsOverflow">
    <div class="clsIndexPhotoMainBar">
      {* Featured photo SECTION STARTS *}
      {if $myobj->isShowPageBlock('block_feartured_photolist')}
      {$myobj->populateFeaturedPhotolist()}
      {/if}
      {* Featured photo SECTION ENDS *}


      {* ----------------------photo carosel section Starts ---------------------- *}
      {if $myobj->isShowPageBlock('sidebar_photo_block')}
      {$myobj->setTemplateFolder('general/', 'photo')}
      {include file="indexPhotoBlockHead.tpl"}
      {/if}
      {* ----------------------photo carosel section ends ---------------------- *}

      {*  ---------------------photo carosel chaneel section  starts here -------------------*}
      {if $myobj->isShowPageBlock('sidebar_photo_channel_block')}
      {$myobj->setTemplateFolder('general/', 'photo')}
      <div class="clsIndexMainContainer">{include file="indexPhotoChannelBlockHead.tpl"}</div>
      {/if}
      {*  ---------------------photo carosel chaneel section  end here -------------------*}

      {*  ---------------------photo carosel slidelist  section  starts here -------------------*}
      {if $myobj->isShowPageBlock('sidebar_photo_slidelist_block')}
      {$myobj->setTemplateFolder('general/', 'photo')}
      <div class="clsIndexMainContainer">{include file="indexPhotoSlidelistBlockHead.tpl"}</div>
      {/if}
      {*  ---------------------photo carosel slidelist section  end here -------------------*}

		{* BANNER SECTION STARTS *}
        <div class="cls468pxBanner">
            <div>{php}global $CFG; getAdvertisement('bottom_banner_468x60'){/php}</div>
        </div>
        {* BANNER SECTION ENDS *}	
		

      {* ----------------------Activities Content Starts ---------------------- *}
      {* {if $myobj->isShowPageBlock('sidebar_activity_block')}
      {$myobj->setTemplateFolder('general/', 'photo')}
      <div class="clsIndexMainContainer">{include file="indexActivityHead.tpl"}</div>
      {/if}*}
      {* ----------------------Activities Content ends ---------------------- *}

      {* ---------------------- Top Photos section starts ---------------------- *}
      {* TOP PHOTOS SECTION START HERE *}
      {* commented top photos block as per new photo index page design *}
      {*{if $myobj->isShowPageBlock('sidebar_topphoto_block')}
      {$myobj->topPhotos()}
      {/if}*}
      {* TOP PHOTOS SECTION END HERE*}
      {* ---------------------- Top Photos section ends ---------------------- *}

      {*----------------------------Index Page Footer banner starts------------------*}
      {*----------------------------Index Page Footer banner ends------------------*}
      </div>

	<div class="clsIndexPhotoSideBar"> {$header->displayLoginFormRightNavigation()}

   {* ----------------------Activities Content Starts ---------------------- *}
      {if $myobj->isShowPageBlock('sidebar_activity_block')}
      {$myobj->setTemplateFolder('general/', 'photo')}
      <div class="clsWhatsGoingOnContainer">{include file="indexActivityHead.tpl"}</div>
      {/if}
  {* ----------------------Activities Content Ends ---------------------- *}

  {* MY photo SECTION STARTS *}
  {if ismember()}
  {$myobj->populateMemberDetail('photo')}
  {/if}
  {* MY photo SECTION ENDS *}

  {* MY photo SECTION STARTS *}
  {$myobj->populateMemberDetail('slidelist')}
  {* MY photo SECTION ENDS *}

  {* TOP CONTRIBUTORS SECTION STARTS *}
  {if $myobj->isShowPageBlock('sidebar_topcontributors_block')}
  {$myobj->topContributors()}
  {/if}
  {* TOP CONTRIBUTORS SECTION ENDS *}

  {* FEATURED MEMBER SECTION ENDS *}

  {* photo CATEGORY AND TAGS SECTION STARTS *}
    <div class="clsSideBarContent clsCategoryHd">
      {$myobj->setTemplateFolder('general/','photo')}
      {include file="box.tpl" opt="sidebar_top"}
         <div class="clsOverflow">
            <h3 id="photoCategoryHeader" class="clsSideBarLeftTitle clsPaddingLeft5">
                <!--<a onClick="showPhotoSidebarTab('photoCategory','photoTags');">-->{$LANG.sidebar_genres_heading_label}<!--</a>-->
            </h3>
        </div>
       <div  id="photoCategoryContent"> {$myobj->populateGenres()} </div>
    {$myobj->setTemplateFolder('general/','photo')}
    {include file="box.tpl" opt="sidebar_bottom"}
   </div>
  {* photo CATEGORY SECTION ENDS *}

  {* BANNER SECTION STARTS *}
   <div class="cls336pxBanner">
       <div>{php}getAdvertisement('sidebanner1_336x280'){/php}</div>
   </div>
  {* BANNER SECTION ENDS *}

  {* photo TAGS SECTION STARTS *}
   <div class="clsSideBarContent clsCategoryHd">
        <div class="clsOverflow clsTagsHeading">
            <h3 id="photoTagsHeader" class="clsSideBarLeftTitle clsPaddingLeft5">
                <!--<a onClick="showPhotoSidebarTab('photoTags','photoCategory');">-->{$LANG.sidebar_photo_tags_heading_label}<!--</a> -->
            </h3>
         </div>

       {$myobj->setTemplateFolder('general/','photo')}
       {include file="box.tpl" opt="phototags_top"}
             <div  id="photoTagsContent"> {$myobj->populateSidebarClouds('photo', 'photo_tags',20)} </div>
        {$myobj->setTemplateFolder('general/','photo')}
        {include file="box.tpl" opt="phototags_bottom"}
     </div>

   <!-- <div class="clsSideCaroselContainer">
    </div>-->
   {* photo TAGS SECTION ENDS *}


  {* FEATURED MEMBER SECTION STARTS *}
  {*{if $myobj->isShowPageBlock('sidebar_featuredmember_block')}
  {$myobj->featuredMember()}
  {/if}*}
</div>
</div>