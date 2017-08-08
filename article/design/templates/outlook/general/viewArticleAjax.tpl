{*{if $myobj->isShowPageBlock('rating_image_form')}
    {$myobj->getTotalRatingImage()}
	<span class="clsRatingTitle">{$LANG.viewarticle_rate_yourrank}</span>
    {$myobj->populateRatingImagesForAjax($myobj->getFormField('rate'))}
{/if}*}
{if $myobj->isShowPageBlock('add_reply')}
    {$myobj->getFormField('comment_id')}***--***!!!
    <form name="addReply_{$myobj->getFormField('comment_id')}" id="addReply_{$myobj->getFormField('comment_id')}" method="post" action="{$myobj->getCurrentUrl()}" autocomplete="off">
        <table>
            <tr>
                <td>
                    <textarea class="clsEmbedTextFields" name="comment" id="comment" rows="5" cols="80"></textarea>
                </td>
            </tr>
            <tr>
                <td colspan="2"  class="clsEditComment">
                    <input type="button" onClick="return addToReply({$myobj->getFormField('comment_id')}, '{$CFG.site.url}article/viewArticle.php?ajax_page=true&amp;article_id={$myobj->getFormField('article_id')}&amp;vpkey={$myobj->getFormField('vpkey')}&amp;show={$myobj->getFormField('show')}')" name="post_comment" id="post_comment" tabindex="{smartyTabIndex}" value="{$LANG.viewarticle_postcomment_post_comment}" />&nbsp;&nbsp;
                    <input type="button" onClick="return discardReply({$myobj->getFormField('comment_id')})" name="cancel" id="cancel" tabindex="{smartyTabIndex}" value="{$LANG.viewarticle_postcomment_cancel}" />
                </td>
            </tr>
        </table>
    </form>
{/if}
{if $myobj->isShowPageBlock('edit_comment')}
{$myobj->getFormField('comment_id')}***--***!!!
        <form name="addEdit_{$myobj->getFormField('comment_id')}" id="addEdit_{$myobj->getFormField('comment_id')}" method="post" action="{$myobj->getCurrentUrl()}" autocomplete="off">
            <table>
                <tr>
                    <td>
                        <textarea class="clsEmbedTextFields" name="comment" id="comment" rows="5" cols="80">{$myobj->getComment()}</textarea>
                    </td>
                </tr>
                <tr>
                    <td colspan="2"  class="clsEditComment">
                        <input type="button" onClick="return addToEdit({$myobj->getFormField('comment_id')}, '{$CFG.site.url}article/viewArticle.php?ajax_page=true&amp;article_id={$myobj->getFormField('article_id')}&amp;vpkey={$myobj->getFormField('vpkey')}&amp;show={$myobj->getFormField('show')}')" name="post_comment" id="post_comment" tabindex="{smartyTabIndex}" value="{$LANG.viewarticle_postcomment_edit_comment}" />&nbsp;&nbsp;
                        <input type="button" onClick="return discardEdit({$myobj->getFormField('comment_id')})" name="cancel" id="cancel" tabindex="{smartyTabIndex}" value="{$LANG.viewarticle_postcomment_cancel}" />
                    </td>
                </tr>
            </table>
        </form>
{/if}
{if $myobj->isShowPageBlock('update_comment')}
    {$myobj->getFormField('comment_id')}
    ***--***!!!
    {$myobj->getFormField('f')}
{/if}

{if $myobj->isShowPageBlock('add_comments')}
    {$myobj->getCommentsBlock()}
    ***--***!!!
    {$myobj->captchaText}
{/if}

{*{if $myobj->isShowPageBlock('add_fovorite_list')}
    <div id="groupAdd" class="clsFlagDetails">
        <div class="clsOverflow clsFlagTitle">
        <h2>{$LANG.viewarticle_title_add_favorite}</h2>
        <div id="cancel"><a href="javascript:void(0);" onClick="return close_ajax_div('favorite_content_tab');">{$LANG.viewarticle_cancel}</a></div>
        </div>
        <div class="clsFlagInfo"><form name="addFavorites" id="addFavorites" method="post" action="{$myobj->getCurrentUrl()}" autocomplete="off">
            <p><input type="checkbox" class="clsCheckRadio" name="favorite" id="favorite" value="1" tabindex="{smartyTabIndex}" checked onclick="return checkFavorite()"/>&nbsp;<label for="favorite">{$LANG.viewarticle_favorites}</label>&nbsp;({$getFavoriteBlock_arr.row.total_favorites}&nbsp;{$LANG.viewarticle_articles})
            <div class="clsOverflow">
                <div class="clsCommentsLeft">
                    <div class="clsCommentsRight">
               			 <input type="button" name="add_to_favorite" id="add_to_favorite" value="{$LANG.viewarticle_ok}" onClick="return addToFavorite(1, '{$CFG.site.url}article/viewArticle.php?article_id={$myobj->getFormField('article_id')}&amp;ajax_page=true&amp;page=favorite', 'favorite_content_tab')" />
                    </div>
                </div>
            </div>
        </form>    </div>
    </div>
{/if}*}
{if $myobj->isShowPageBlock('get_code_form') and 1}
    <div id="groupAdd">
        <h2><span>{$LANG.viewarticle_codes_to_display}</span></h2>
        <span id="cancel"><a href="#" onClick="return hideAllBlocks();">{$LANG.viewarticle_cancel}</a></span>
        <form name="formGetCode" id="formInvite" method="post" action="{$myobj->getCurrentUrl()}">
            <p><textarea class="clsEmbedTextFields" rows="5" cols="75" name="image_code" id="image_code" READONLY tabindex="{smartyTabIndex}" onFocus="this.select()" onClick="this.select()" ><embed src="{$myobj->get_code_form_arr.flv_player_url}" FlashVars="config={$myobj->get_code_form_arr.configXmlcode_url}" quality="high" bgcolor="#000000" width="450" height="370" name="flvplayer" align="middle" allowScriptAccess="always" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" {$CFG.admin.embed_code.additional_fields} /></textarea></p>
        </form>
    </div>
{/if}
