{literal}
	<script type="text/javascript">
		// REQUIRED GLOBAL VARS
		var t;
		var counter = 0;
		var timer   = 1000;

		function switchImages(albumImages, img_id)
		{
			var images = albumImages.split(',');
			var numImages = images.length;
			if (document.getElementById(img_id)){
				document.getElementById(img_id).src   = images[counter];
				counter++;
				if(counter >= numImages){
					counter = 0;
				}
			}
			t = setTimeout('switchImages(\''+albumImages+'\',\''+img_id+'\')', timer);
		}

		function setDefaultAlbumImage(defaultImage, img_id)
		{
			clearTimeout(t);
			c=0;
			counter=0;
			if (document.getElementById(img_id))
				document.getElementById(img_id).src = defaultImage;
		}
   </script>
{/literal}

<div class="clsPhotoListContainer clsOverflow">
{$myobj->setTemplateFolder('general/','photo')}
{include file="box.tpl" opt="photomain_top"}
    {if $myobj->isShowPageBlock('search_albumlist_block')}
        <form id="seachAdvancedFilter" name="seachAdvancedFilter" method="post" action="{$myobj->getCurrentUrl()}">
            <input type="hidden" name="advanceFromSubmission" value="1"/>
            <input type="hidden" name="start" value="{$myobj->getFormField('start')}"/>
            <div class="clsOverflow">
                    <div class="clsHeadingLeft">
                        <h2><span>
                            {if $myobj->page_heading != ''}
                                {$myobj->page_heading}
                            {else}
                                {$LANG.photoalbumList_title}
                            {/if}</span>
                        </h2>
                    </div>
                    <div class="clsHeadingRight">
                        {*	<div class="clsPhotoListMenu">
                                <select onchange="loadUrl(this)">
                                <option value="{$myobj->getUrl('albumlist', '?pg=albumlistnew', 'albumlistnew/','','photo')}"
                                {if $myobj->getFormField('pg')=='albumlistnew'} selected {/if} >
                                {$LANG.header_nav_photo_new}
                                </option>
                                <option value="{$myobj->getUrl('albumlist', '?pg=albummostlistened', 'albummostlistened/', '', 'photo')}"
                                {if $myobj->getFormField('pg')=='albummostlistened'} selected {/if} >
                                {$LANG.header_nav_most_listened}
                                </option>
                                <option value="{$myobj->getUrl('albumlist', '?pg=albummostviewed', 'albummostviewed/', '', 'photo')}"
                                {if $myobj->getFormField('pg')=='albummostviewed'} selected {/if} >
                                {$LANG.header_nav_most_viewed}
                                </option>
                                <option value="{$myobj->getUrl('albumlist', '?pg=albummostrecentlyviewed', 'albummostrecentlyviewed/', '', 'photo')}"
                                {if $myobj->getFormField('pg')=='albummostrecentlyviewed'} selected {/if} >
                                {$LANG.header_nav_photo_recently_viewed}
                                </option>
                                </select>
                            </div> *}
                    </div>
                </div>
            {*	{if $myobj->getFormField('pg') == 'albummostlistened' or $myobj->getFormField('pg') == 'albummostviewed'}
                    <div class="clsTabNavigation">
                        <ul>
                            <li{$photoActionNavigation_arr.cssli_0}>
                                <span><a href="javascript:void(0);" onclick="jumpAndSubmitForm('{$photoActionNavigation_arr.photo_list_url_0}')">{$LANG.header_nav_members_all_time}</a></span>
                            </li>
                            <li{$photoActionNavigation_arr.cssli_1}>
                                <span><a href="javascript:void(0);" onclick="jumpAndSubmitForm('{$photoActionNavigation_arr.photo_list_url_1}');">{$LANG.header_nav_members_today}</a></span>
                            </li>
                            <li{$photoActionNavigation_arr.cssli_2}>
                                <span><a href="javascript:void(0);" onclick="jumpAndSubmitForm('{$photoActionNavigation_arr.photo_list_url_2}');">{$LANG.header_nav_members_yesterday}</a></span>
                            </li>
                            <li{$photoActionNavigation_arr.cssli_3}>
                                <span><a href="javascript:void(0);" onclick="jumpAndSubmitForm('{$photoActionNavigation_arr.photo_list_url_3}');">{$LANG.header_nav_members_this_week}</a></span>
                            </li>
                            <li{$photoActionNavigation_arr.cssli_4}>
                                <span><a href="javascript:void(0);" onclick="jumpAndSubmitForm('{$photoActionNavigation_arr.photo_list_url_4}');">{$LANG.header_nav_members_this_month}</a></span>
                            </li>
                            <li{$photoActionNavigation_arr.cssli_5}>
                                <span><a href="javascript:void(0);" onclick="jumpAndSubmitForm('{$photoActionNavigation_arr.photo_list_url_5}');">{$LANG.header_nav_members_this_year}</a></span>
                            </li>
                        </ul>
                    </div>
                {literal}
					<script type="text/javascript">
                    function jumpAndSubmitForm(url)
                        {
                            document.seachAdvancedFilter.action=url;
                            document.seachAdvancedFilter.submit();
                        }
                    var subMenuClassName1='clsActiveTabNavigation';
                    var hoverElement1  = '.clsTabNavigation li';
                    loadChangeClass(hoverElement1,subMenuClassName1);
                    </script>
                    {/literal}
                    {/if}   *}
                    <div class="clsAdvancedFilterSearch clsAdvancedFilterSearchAlignment">
                      <div style="float:left">
                        <a onclick="divShowHide('advancedAlbumlistSearch', 'show_link', 'hide_link')" class="clsShow"  id="show_link" href="javascript:void(0)" title="{$LANG.photoalbumList_show_advanced_filters}"><span>{$LANG.photoalbumList_show_advanced_filters}</span></a>
                        <a onclick="divShowHide('advancedAlbumlistSearch', 'show_link', 'hide_link')" class="clsHide"  style="display:none" id="hide_link" href="javascript:void(0)" title="{$LANG.photoalbumList_hide_advanced_filters}"><span>{$LANG.photoalbumList_hide_advanced_filters}</span></a>
                      </div>
                      {if $CFG.admin.photos.album_image_swap}
                      <div class="clsGlimpse">
                      	{$LANG.photoalbumList_mouseover_message}
	                  </div>
                      {/if}
                    </div>
                <div id="advancedAlbumlistSearch" class="clsAdvancedFilterContainer" {if $myobj->chkAdvanceResultFound()}  style="display:block {else} style="display:none;  {/if}margin:0 0 10px 0;"  >
                        {$myobj->setTemplateFolder('general/','photo')}
                        {include file='box.tpl' opt='form_top'}
      				<div class="clsOverflow">
                       <div class="clsAdvancedSearchBg">
                        <table class="clsAdvancedFilterTable">
                            <tr>
                                <td>
                                    <input class="clsTextBox" type="text" name="albumlist_title" id="albumlist_title"   value="{if $myobj->getFormField('albumlist_title') == ''}{$LANG.photoalbumList_albumList_title}{else}{$myobj->getFormField('albumlist_title')}{/if}" onblur="setOldValue('albumlist_title')"  onfocus="clearValue('albumlist_title')"/>
                                </td>
                                <td>
                                    <input class="clsTextBox" type="text" name="photo_title" id="photo_title" onfocus="clearValue('photo_title')"  onblur="setOldValue('photo_title')" value="{if $myobj->getFormField('photo_title') == ''}{$LANG.photoalbumList_no_of_photo_title}{else}{$myobj->getFormField('photo_title')}{/if}" />
                                </td>
                            </tr>
	                        <tr>
    	                        <td colspan="2">
        	                        <div class="clsSearchButton-l"><span class="clsSearchButton-r"><input type="submit" name="search" id="search" value="{$LANG.photoalbumList_search}" onclick="document.seachAdvancedFilter.start.value = '0';" /></span></div>
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

                {/if}
                {if  $myobj->isShowPageBlock('list_albumlist_block')}
                    <div id="selphotoPlaylistManageDisplay" class="clsLeftSideDisplayTable">
                        {if $myobj->isResultsFound()}
                                      <div class="clsPhotoPaging clsSlideBorder">
                                      {if $CFG.admin.navigation.top}
                                         {$myobj->setTemplateFolder('general/', 'photo')}
                                          {include file=pagination.tpl}
                                       {/if}
                                      </div>
                        <!-- top pagination end-->
                        <div class="clsOverflow">
                            <form name="photoListForm" id="photoListForm" action="{$_SERVER.PHP_SELF}" method="post">
                            {assign var=count value=1}
                            {assign var=i value=0}
                            {foreach key=photoAlbumlistKey item=photoalbumlist from=$myobj->list_albumlist_block.showAlbumlists.row}
                                    <div class="clsNewAlbumList {if $count % 3 == 0} clsThumbPhotoFinalRecord{/if}">
                                    	{$myobj->setTemplateFolder('general/','photo')}
        								{include file="box.tpl" opt="listimage_top"}
                                            <div class="clsThumb">
                                                    <input type="hidden" name="photo_album_id" id="photo_album_id" value="{$photoalbumlist.record.photo_album_id}" />
                                                    <div {if $photoalbumlist.total_photo > 0  && $photoalbumlist.photo_image_src !=''}class="clsLargeThumbImageBackground clsNoLink"{/if}>
                                                      <div class="clsPhotoThumbImageOuter" {if $photoalbumlist.total_photo > 0  && $photoalbumlist.photo_image_src !=''}onclick="Redirect2URL('{$photoalbumlist.getUrl_viewAlbum_url}')"{/if}>
                                                        <div class="cls146x112 clsImageHolder clsImageBorderBg">
                                                                {if $photoalbumlist.photo_image_src !=''}
                                                                    <img id="img_{$i}" src="{$photoalbumlist.photo_image_src}" {$photoalbumlist.photo_disp} title="{$photoalbumlist.photo_title}" alt="{$photoalbumlist.photo_title|truncate:25}" {if $CFG.admin.photos.album_image_swap} onmouseover="switchImages('{$photoalbumlist.album_image}','img_{$i}');" onmouseout="setDefaultAlbumImage('{$photoalbumlist.photo_image_src}','img_{$i}');"{/if}/>
                                                                {else}
                                                                    <img   src="{$CFG.site.url}photo/design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/no_image/noAlbumImage.jpg" title="{$photoalbumlist.photo_title}" alt="{$LANG.common_no_images}"/>
                                                                {/if}
                                                            </div>
                                                       </div>
                                                      </div>
                                                </div>
                                                <!--div class="clsPlayerImage">
                                                    <p class="clsPhotoListLink"><a href="javascript:void(0)" onclick="javascript: myLightWindow.activateWindow({literal}{{/literal}type:'external',href:'{$photoalbumlist.light_window_url}',title:'{$LANG.photoalbumList_photo_list}',width:550,height:350{literal}}{/literal});" title="{$LANG.photoalbumList_allphotodetail_helptips}">{$LANG.photoalbumList_photo_list}</a></p>
                                                </div-->
                                            <div class="clsAlbumContentDetails">
                                                    <p class="clsHeading clsTitleWrap">
                                                        {if $photoalbumlist.total_photo > 0 && $photoalbumlist.photo_image_src !=''}
                                                        	<a  href="{$photoalbumlist.getUrl_viewAlbum_url}" title="{$photoalbumlist.word_wrap_album_title}">{$photoalbumlist.word_wrap_album_title|truncate:30}</a>
                                                        {else}
                                                        	<span class="clsNoPhotoLink" title="{$photoalbumlist.word_wrap_album_title}">{$photoalbumlist.word_wrap_album_title}</span>
                                                        {/if}
                                                    </p>
                                                    <p>
                                                    	{if $photoalbumlist.total_photo <= 1}
                                                        	{$LANG.photoalbumList_photo}:&nbsp;
                                                            <span>{$photoalbumlist.total_photo}</span>
                                                        {else}
                                                        	{$LANG.photoalbumList_photos}:&nbsp;<span>{$photoalbumlist.total_photo}</span>
                                                        {/if}
                                                        {if $photoalbumlist.private_photo gt 0}&nbsp;|&nbsp;{$LANG.photoalbumList_private}:&nbsp;
                                                        	<span>{$photoalbumlist.private_photo}</span>
                                                        {/if}
                                                     </p>

                                                    {*if $myobj->isShowPageBlock('displayphotolist_block')}
                                                        {$myobj->displayAlbumPhotoList($photoalbumlist.record.photo_album_id)}
                                                    {else}
                                                        {$myobj->displayAlbumPhotoList($photoalbumlist.record.photo_album_id, true, 3)}
                                                    {/if*}

                                                    {*$myobj->setTemplateFolder('general/', 'photo')}
                                                    {include file=albumPhotoList.tpl*}
                                             <div class="clsAlbumContent">
                                                 <p>
                                                 	{if $photoalbumlist.total_photo > 0 && $photoalbumlist.photo_image_src !=''}
	                                                    <a  href="{$photoalbumlist.getUrl_viewAlbum_url}" title="{$LANG.photoalbumList_view_album}">{$LANG.photoalbumList_view_album}</a>
                                                    {else}
                                                       	{$LANG.photoalbumList_view_album}
                                                    {/if}
                                                    &nbsp;|

                                                  	{if $photoalbumlist.total_photo > 0 && $photoalbumlist.photo_image_src !=''}
                                                      	<!--a href="javascript:void(0);" onclick="openSlodeListShow('{$photoalbumlist.view_albumplaylisturl}')"-->
														<a href="{$photoalbumlist.view_albumplaylisturl}"  title="{$LANG.photoalbumList_slideshow_album}">
                                                          	{$LANG.photoalbumList_slideshow_album}
                                                        </a>
                                                    {else}
                                                      	{$LANG.photoalbumList_slideshow_album}
		                                            {/if}
                                                 </p>
                                             </div>
                                                    <!--p>{$LANG.photoalbumList_view}:&nbsp;{$photoalbumlist.record.total_views}</p-->
                                                </div>
                                     	  {$myobj->setTemplateFolder('general/','photo')}
        								  {include file="box.tpl" opt="listimage_bottom"}
                                     </div>
                             {assign var=count value=$count+1}
                            {assign var=i value=$i+1}
                            {/foreach}
                              </form>
                              </div>
                                <div id="bottomLinks" class="clsPhotoPaging">
                                {if $CFG.admin.navigation.bottom}
                                    {$myobj->setTemplateFolder('general/', 'photo')}
                                    {include file='pagination.tpl'}
                                {/if}
                                </div>
                                </form>
                        {else}
                        <div id="selMsgAlert">
                            <p>{$LANG.photoalbumList_no_records_found}</p>
                        </div>
                    {/if}
                    </div>
                    {/if}

{$myobj->setTemplateFolder('general/', 'photo')}
{include file="box.tpl" opt="photomain_bottom"}
</div>