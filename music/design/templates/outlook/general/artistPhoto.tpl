
    {$myobj->setTemplateFolder('general/','music')}
    {include file="box.tpl" opt="audioindex_top"}
<div id="selMusicPlaylistManage" class="clsMainContainer">
  <h3 class="clsH3Heading">
  		{if $myobj->page_title != ''}
        	{$myobj->page_title}
        {else}
             {$LANG.viewartist_artistphoto_label}
        {/if}
  </h3>
    {$myobj->setTemplateFolder('general/','music')}
    {include file='information.tpl'}
    <!-- information div -->
    <!-- Upload photo block Start-->
    {if $myobj->isShowPageBlock('upload_photo_block') && isMember()}
    <div class="clsAdvancedFilterSearch clsshowhidefiltersblock clsOverflow clsMargintop10">
    	<a onclick="divShowHide('upload_photo_block', 'show_link', 'hide_link')" class="clsShow"  id="show_link" href="javascript:void(0)" title="{$LANG.viewartist_upload_artist_photo}"><span>{$LANG.viewartist_upload_artist_photo}</span></a>
        <a onclick="divShowHide('upload_photo_block', 'show_link', 'hide_link')" class="clsHide"  style="display:none" id="hide_link" href="javascript:void(0)"><span>{$LANG.viewartist_upload_artist_photo}</span></a>
    </div>
        <div id="upload_photo_block"  class="clsAdvancedFilterTable clsOverflow" {if !$myobj->flag} style="display:none" {/if}>
            <form action="{$myobj->getCurrentUrl()}" method="post"   enctype="multipart/form-data" name="musicPlayListManage" >

                <table class="">
                    <tr>
                        <td align="left" valign="top">
                            &nbsp; <label for="artist_photo">
                            {$LANG.viewartist_upload_photo} {$myobj->photosize_detail}
                            </label>
                        </td>
                        <td align="left" valign="top">
                            <input type="file" class="clsFile" name="artist_photo" id="artist_photo" tabindex="{smartyTabIndex}" />
                             {$myobj->getFormFieldErrorTip('artist_photo')}
                            {$myobj->ShowHelpTip('artist_photo', 'artist_photo')}
                        </td>
                    </tr>
                   <!-- <tr>
                        <td align="left" valign="top">
                            <label for="image_caption">
                            {$LANG.viewartist_photo_caption}
                            </label>
                        </td>
                        <td align="left" valign="top">
                            <textarea name="image_caption" id="image_caption" cols="45" rows="5" tabindex="{smartyTabIndex}">{$myobj->getFormField('image_caption')}</textarea>
                            {$myobj->getFormFieldErrorTip('image_caption')}
                            {$myobj->ShowHelpTip('image_caption', 'image_caption')}
                        </td>
                    </tr>-->
                    <tr>
                        <td>&nbsp;

                        </td>
                        <td><div class="clsSubmitButton-l">
								<span class="clsSubmitButton-r"><input type="submit" name="upload" id="upload" value="{$LANG.viewartist_upload}"/></span>
                             </div>
                       </td>
                    </tr>
                </table>

            </form>
        </div>
    {/if}
    {if !isMember()}
    <div>
    <p class="clsArtistLoginlink"><a href="{$myobj->getUrl('login')}" title="{$LANG.viewartist_login_msg}">{$LANG.viewartist_login_msg}</a></p>
    </div>
    {/if}
    <!-- Upload photo block End-->
     <!-- Single confirmation box -->
    <div id="selMsgConfirmSingle" style="display:none;" class="clsMsgConfirm">
		<p id="confirmMessageSingle"></p>
		<form name="msgConfirmformSingle" id="msgConfirmformSingle" method="post" action="{$myobj->getCurrentUrl(true)}" autocomplete="off">
			<table summary="{$LANG.viewartist_confirm_tbl_summary}">
				<tr>
					<td>
                    	<img id="artistImg" border="0" src="" />
						<input type="submit" class="clsSubmitButton" name="confirm_action" id="confirm_action" tabindex="{smartyTabIndex}" value="{$LANG.common_confirm}" />
						&nbsp;
						<input type="button" class="clsCancelButton" name="cancel" id="cancel" tabindex="{smartyTabIndex}" value="{$LANG.common_cancel}"  onclick="return hideAllBlocks('selMsgConfirmSingle');" />
						<input type="hidden" name="music_artist_image" id="music_artist_image" />
						<input type="hidden" name="action" id="action" />
						{$myobj->populateHidden($myobj->hidden_arr)}
					</td>
				</tr>
			</table>
		</form>
	</div>
    <!-- confirmation box-->
    <!-- Photo list block start-->
    {if $myobj->isShowPageBlock('list_photo_block')}
       	{if $myobj->isResultsFound()}
            {if $CFG.admin.navigation.top}
                    <div class="clsAudioPaging">
					{$myobj->setTemplateFolder('general/','music')}
					{include file=pagination.tpl}
					</div>
            {/if}
            {assign var='count' value='0'}
             <table class="cls5TdTable clsArtistProfileTable">
            {foreach key=asKey item=saValue from=$myobj->list_photo_block.showArtistImageList}
                 {if $count == 0}
                    <tr>
                    {/if}
                        <td>

                                    <div class="clsNoLink">
                                      <div class="ClsImageContainer ClsImageBorder1 Cls90x90">
										  <img src="{$saValue.artist_image}" title="{$saValue.record.image_caption}"/>
                                        </div>
                                    </div>
                            {if $saValue.record.user_id eq $CFG.user.user_id }
                                <p class="clsDeleteThis"><!--<a href="#">{$LANG.viewartist_edit}</a>-->
                                    <a href="javascript:void(0);" onclick="return Confirmation('selMsgConfirmSingle', 'msgConfirmformSingle',Array('action', 'music_artist_image', 'artistImg', 'confirmMessageSingle'), Array('delete', '{$saValue.music_artist_image}', '{$saValue.artist_image}', '{$LANG.viewartist_delete_confirmation}'), Array('value', 'value', 'src', 'innerHTML'), -100, -500);" title="{$LANG.viewartist_delete}">{$LANG.viewartist_delete}</a>
                                </p>
                            {/if}
                            <!-- <p title="{$saValue.record.image_caption}">{$saValue.record.image_caption}</p> -->
                        </td>
                   {counter  assign=count}
                   {if $count%$CFG.admin.musics.artist_image_cols eq 0}
                        {counter start=0}
                        </tr>
                    {/if}
            {/foreach}
            {assign var=cols  value=$CFG.admin.musics.artist_image_cols-$count}
            {if $count}
                {section name=foo start=0 loop=$cols step=1}
                    <td>&nbsp;</td>
                {/section}
                <tr>
            {/if}
            </table>

            {if $CFG.admin.navigation.bottom}
            	<div id="bottomLinks" class="clsAudioPaging">
					{$myobj->setTemplateFolder('general/','music')}
                	{include file='pagination.tpl'}
              	</div>
            {/if}
         {else}
            <div id="selMsgAlert">
                <p>{$LANG.viewartist_no_records_found}</p>
            </div>
        {/if}
    {/if}
     <!-- Photo list block end-->
</div>

{$myobj->setTemplateFolder('general/','music')}
{include file="box.tpl" opt="audioindex_bottom"}