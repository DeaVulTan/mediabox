{if $myobj->isShowPageBlock('photolist_block')}
	{if $displayPhotoList_arr.record_count}
        <div class="clsDataTable clsPopupContent"><table >
             <tr>
                <th class="clsSerialNo">{$LANG.photoalbumList_admin_photolist_id}</th>&nbsp;
                <th>{$LANG.photoalbumList_admin_photolist_phototitle}</th>
            </tr>
                {foreach key=photoListKey item=photoListValue from=$displayPhotoList_arr.row}
                    <tr>
                        <td>{$photoListKey}</td>
                        {if $photoListValue.photo_status}
                            <td><p><strong>{$photoListValue.wordWrap_mb_ManualWithSpace_photo_title}</strong>&nbsp;(<span>{$photoListValue.wordWrap_mb_ManualWithSpace_album_title}</span>)</p></td>
                        {else}    
                            <td>{$LANG.photoalbumList_private}</td>
                        {/if}
                    </tr>
                {/foreach}   
        </table></div> 
    {else} 
     	<div class="clsNoRecordsFound">{$LANG.photoalbumList_admin_photolist_norecords_found}</div>
    {/if}  
{else}   
	{if $displayPhotoList_arr.record_count}
                {$myobj->setTemplateFolder('general/','photo')}
                {include file='box.tpl' opt='details_top'}
                {assign var='count' value='1'} 
                  <div class="clsPhotoListDetails"> 
            		{foreach key=photoListKey item=photoListValue from=$displayPhotoList_arr.row}
                    	{counter  assign=count}
                    	<p{if $lastDiv == $count}{counter start=0} class="clsNoBorder"{/if}><strong><a href="{$photoListValue.getUrl_viewPhoto_url}">{$photoListValue.wordWrap_mb_ManualWithSpace_photo_title}</a></strong></p>
                    {/foreach}   
                  </div>
                {$myobj->setTemplateFolder('general/','photo')}
                {include file='box.tpl' opt='details_bottom'}
     {/if} 
{/if}