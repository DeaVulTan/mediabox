<div class="clsViewVideoDetailsContent">
      {if $myobj->total_records}
            <div id="selVideoDisp" class="clsOverflow clsPaddingLeft10">
             <table cellpadding="0" cellspacing="0">
          {foreach from=$relatedVideo item=result}
                  {if $result.open_tr}
                        <tr>
                  {/if}
                  <td class="clsQuickLinkImageWidth">
                        <ul class="clsRelatedVideos">
                  <li>
                   {if $result.playing_time}
                        <div class="clsRunTime">{$result.playing_time}</div>
                   {/if}

                      {if $result.allow_quick_links and $result.record.is_external_embed_video !='Yes'}
                          <div id="{$result.quickLinkId}" class="clsTopQuickLinks">
                              {if rayzzMvInKL($result.record.video_id)}
					    <a id="{$result.quickLinkId}_added" title="{$LANG.add_to_quick_links_added}" class="clsPhotoVideoEditLinks"><img src="{$CFG.site.video_url}design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/icon-addvideo.gif" /></a>
                                  <a id="{$result.quickLinkId}_add" class="clsPhotoVideoEditLinks" onclick="updateVideosQuickLinksCount('{$result.record.video_id}','{$myobj->pg}')" title="{$LANG.add_to_quick_links}" style="display:none;">
                                  	<img src="{$CFG.site.video_url}design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/icon-addvideo_added.gif"/>
                                  </a>
                              {else}
                                  <a id="{$result.quickLinkId}_add" class="clsPhotoVideoEditLinks" onclick="updateVideosQuickLinksCount('{$result.record.video_id}','{$myobj->pg}')" title="{$LANG.add_to_quick_links}">
                                  	<img src="{$CFG.site.video_url}design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/icon-addvideo_added.gif"/>
                                  </a>
                                  <a id="{$result.quickLinkId}_added" class="clsPhotoVideoEditLinks" title="{$LANG.add_to_quick_links_added}" style="display:none;">
                                      <img src="{$CFG.site.video_url}design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/icon-addvideo.gif"/>
                                  </a>
                              {/if}
                          </div>
                      {/if}
                        <div class="clsOverFlow">
                           <a href="{$result.videoLink}" class="Cls144x110 ClsImageContainer ClsImageBorder1">
                              <img src="{$result.imageSrc}" alt="{$result.video_title|truncate:15}" {$result.imageDisp} />
                           </a>
                      </div>
                      <div class="clsClearLeft">
                          <p id="selMemberName">
                              <a href="{$result.videoLink}" title="{$result.video_title}">{$result.video_title}</a>
                          </p>
                          <!-- <p>{$LANG.common_from}: {$result.name}</p>
                          <p>{$LANG.views}:<span class="clsBold"> {$result.record.total_views}</span></p>-->
                      </div>
                  </li>
                 </ul>
                 </td>
                 {if $result.end_tr}
                        </tr>
                  {/if}
          {/foreach}
             </table>
          </div>
      {else}
            <div class="clsNoVideo">
          <p>{$LANG.no_related_videos_found}</p>
          </div>
      {/if}
      <div id="selNextPrev" class="clsRelatedPreviousNext clsDisplayNone">
            <input type="button" {if $myobj->leftButtonExist} onclick="moveVideoSetToLeft(this, '{$myobj->pg}')" {/if} value="" id="videoPrevButton_{$myobj->pg}" class="{$myobj->leftButtonClass}"/>
            <input type="button" {if $myobj->rightButtonExists} onclick="moveVideoSetToRight(this, '{$myobj->pg}')"{/if} value="" id="videoNextButton_{$myobj->pg}" class="{$myobj->rightButtonClass}" />
      </div>
</div>