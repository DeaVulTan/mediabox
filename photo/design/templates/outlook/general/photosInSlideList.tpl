{if $myobj->isShowPageBlock('photolist_block')}
	{if $displayPhotoList_arr.record_count}
    <div class="clsDataTable clsPopupContent">
    <table >
        <tr>
            <th class="clsSerialNo">{$LANG.photo_playlist_id}</th>
            <th>{$LANG.photo_playlist_phototitle}</th>
        </tr>
        {foreach key=photoListKey item=photoListValue from=$displayPhotoList_arr.row}
         <tr>
            <td>{$photoListKey}</td>
            <td>

                <p>
                	<img src="{$photoListValue.photo_img_src}"/>
                </p>
            </td>
         </tr>
        {/foreach}
    </table></div>
    {else}
           <div class="clsNoRecordsFound">{$LANG.photoplaylist_admin_photolist_norecords_found}</div>
    {/if}
{else}
	{if $displayPhotoList_arr.record_count}
                {assign var='count' value='1'}
                  <div class="clsPhotoListDetails">
	                  <div class="clsMultipleImage clsPointer">
                      	{if $displayPhotoList_arr.total_record gt 0}
                        {foreach key=photoListKey item=photoListValue from=$displayPhotoList_arr.row}
                            {counter  assign=count}
                                <table {if $photoListKey % 2 == 0}class="clsSlidelistFinalRecord"{/if}>
                                	<tr>
                                    	<td>
                                          <div>
											<a href="{$photoplaylist.view_playlisturl}"  title="{$photoListValue.wordWrap_mb_ManualWithSpace_photo_title}">
                                            	<img src="{$photoListValue.photo_img_src}" alt="{$photoListValue.wordWrap_mb_ManualWithSpace_photo_title}" alt="{$photoListValue.wordWrap_mb_ManualWithSpace_photo_title}" title="{$photoListValue.wordWrap_mb_ManualWithSpace_photo_title}"/>
                                            </a>
                                          </div>
                                        </td>
                                    </tr>
                                 </table>

                        {/foreach}
                        {if $displayPhotoList_arr.total_record lt 4}
                            {section name=foo start=0 loop=$displayPhotoList_arr.noimageCount step=1}
                            {assign var =countNoImage value=$smarty.section.foo.index}
                            {* Condition added to apply class to second column no images to fix browser issue *}
                                <table {if $displayPhotoList_arr.noimageCount eq 4}
											{if $countNoImage % 2 == 0}class="clsSlidelistFinalRecord"{/if}
										{elseif $displayPhotoList_arr.noimageCount eq 3}
											{if $countNoImage eq 0 || $countNoImage eq 2}class="clsSlidelistFinalRecord"{/if}
										{elseif $displayPhotoList_arr.noimageCount eq 2}
											{if $countNoImage eq 1}class="clsSlidelistFinalRecord"{/if}
										{elseif $displayPhotoList_arr.noimageCount eq 1}
											class="clsSlidelistFinalRecord"
										{/if}>
                                	<tr>
                                    	<td>
                                        	<img  src="{$CFG.site.url}photo/design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/no_image/noImageSlieList.jpg" />
                                        </td>
                                    </tr>
                                </table>
                            {/section}
                        {/if}
                        {/if}
                      </div>
                  </div>

    {else}

    	    <div class="clsPhotoListDetails">
	    	    <div class="clsPhotoSlideListNoImage">
           			<img src="{$CFG.site.url}photo/design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/no_image/icon-noImageSlieList.jpg" />
                </div>
            </div>

     {/if}
{/if}