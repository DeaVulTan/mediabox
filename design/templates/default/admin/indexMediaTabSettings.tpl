{if !isAjaxPage()}
	<div id="tabsview">
		<ul>
			{foreach key=cakey item=cavalue from=$myobj->cname_array}
				{assign var="label_name" value="media_type_$cakey"}
				{if $CFG.user.usr_access == 'Admin' OR $myobj->checkUserPermission($CFG.user.user_actions, 'settings', $LANG.$label_name)}
                	{if chkAllowedModule(array($cakey))}
					<li><a href="{$myobj->getCurrentUrl(false)}?cname={$cakey}">{$LANG.$label_name}</a></li>
                 	{/if}
				{/if}
			{/foreach}
		</ul>
	</div>
{else}
	<div id="seldevManageConfig">
		<div>
	  		<h2>{$LANG.index_mediatabsetting_title}</h2>
            <p>{$LANG.index_mediatabsetting_heading_note}</p>
			{$myobj->setTemplateFolder('admin/')}
			{include file="information.tpl"}
			{if $myobj->isShowPageBlock('block_config_edit')}
				<div class="clsDataTable">
					{assign var="c_name" value=$myobj->getFormField('cname')}
					<form name="form_editconfig_{$myobj->getFormField('cname')}" id="form_editconfig_{$myobj->getFormField('cname')}" method="post" action="{$myobj->getCurrentUrl(false)}" onsubmit="" autocomplete="off">
				        <table>
				        	{foreach key=cvkey item=cvvalue from=$myobj->block_config_edit.populateMediaTab}
                            {assign var="c_media_tab_type" value=$cvvalue.media_tab_type}
                            {assign var="c_media_tab_id" value=$cvvalue.index_media_tab_id}
				        		{if $cvvalue.media_tab_type}
                                    <tr>
                                        <td class="clsWidthSmall">
                                            {$myobj->displayCompulsoryIcon()}<label for="media_type">{$myobj->media_tab_array.$c_name}</label>
                                        </td>
                                        <td>
                                        <input type="hidden" name="index_media_tab_id" value="{$cvvalue.index_media_tab_id}" />
                                        	
                                            <select name="media_tab_type" id="media_tab_type" onchange="funFeatureReorderAction(this.value,{$cvvalue.index_media_tab_id})"> tabindex="{smartyTabIndex}">
                                    		{foreach key=mdkey item=mdvalue from=$myobj->media_tab_type_array}
                                            	{if $mdkey eq $c_name}
                                                    {foreach key=mtabkey item=mtabvalue from=$mdvalue}
                                                 <option value='{$mtabkey}' {if $cvvalue.media_tab_type == $mtabkey} selected {/if}>{$mtabvalue}</option>
                                                    {/foreach}
                                                {/if}
                                            {/foreach}
                                            
                                    </select>
                                        </td>
                                    </tr>
                                    </table>
                                    <table id="dvFeatureReorder_{$c_media_tab_id}"  style="{if $c_media_tab_type == 'recommendedphoto' || $c_media_tab_type == 'recommendedmusic' || $c_media_tab_type == 'recommendedvideo'}display:block;{else}display:none{/if}">
                                    <tr>
                                    	<td colspan="2"><div>                       
                            <a id ="featureReorder_{$c_media_tab_id}" href="{$CFG.site.url}{$myobj->media_tab_reorder.$c_name}">{$LANG.index_mediatabsetting_feature_reorder}</a>
                            {if $c_name eq 'photo'}  
                            	{$LANG.index_mediatabsetting_photo_feature_note1}
                                <a href="#"  onclick="callPhotoHome();">{$LANG.index_mediatabsetting_photo_feature_note2}</a>{$LANG.index_mediatabsetting_photo_feature_note3}
                            {elseif $c_name eq 'video'} 
                            	{$LANG.index_mediatabsetting_video_feature_note1}
                                <a href="#"  onclick="callVideoHome();">{$LANG.index_mediatabsetting_video_feature_note2}</a>{$LANG.index_mediatabsetting_video_feature_note3}
                            {elseif $c_name eq 'music'} 
                            	{$LANG.index_mediatabsetting_music_feature_note1}
                                <a href="#"  onclick="callMusicHome();">{$LANG.index_mediatabsetting_music_feature_note2}</a>{$LANG.index_mediatabsetting_music_feature_note3}
                            {else}
                            {$LANG.index_mediatabsetting_feature_note}
                            {/if}
                            </div>
                                        </td>
                                    </tr>
                                    
    								</table>
				        		{/if}
						   	{/foreach}
                            <table>
						   	<tr>
								<td class="{$myobj->getCSSFormFieldCellClass('submit')}" colspan="2">
									<input type="submit" class="clsSubmitButton" name="add_submit" id="add_submit" tabindex="{smartyTabIndex}" value="{$LANG.common_update}" onClick="$Jq('#act_{$myobj->getFormField('cname')}').val('add_submit'); return postAjaxForm('form_editconfig_{$myobj->getFormField('cname')}', 'ui-tabs-{$myobj->cname_array.$c_name}')" />
								</td>
							</tr>
						</table>
						<input type="hidden" name="cname" value="{$myobj->getFormField('cname')}" />
						<input type="hidden" name="act" id="act_{$myobj->getFormField('cname')}" value="" />
 							
                                        <script>
											{literal}
											$Jq(document).ready(function() {
										 
															$Jq('#featureReorder_'+{/literal}{$c_media_tab_id}{literal}).fancybox({
																'width'				: 900,
																'height'			: 500,
																'padding'			:  0,
																'autoScale'     	: false,
																'transitionIn'		: 'none',
																'transitionOut'		: 'none',
																'type'				: 'iframe'
															});
											 });
											{/literal}
										</script> 
                                        
					</form>
			   	</div>
			{/if}
		</div>
	</div>

{/if}


{literal}
<script language="javascript">

function callVideoHome()
	{
		parent.location ='{/literal}{$CFG.site.url}admin/video/videoManage.php{literal}';
	}
function callPhotoHome()
	{
		parent.location ='{/literal}{$CFG.site.url}admin/photo/photoManage.php{literal}';
	}
function callMusicHome()
	{
		parent.location ='{/literal}{$CFG.site.url}admin/music/musicManage.php{literal}';
	}	
</script>
{/literal}
