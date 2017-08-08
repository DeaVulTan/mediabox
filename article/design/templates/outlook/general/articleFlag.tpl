    <div id="flagDiv" class="clsPopupConfirmation clsTextAlignLeft" style="display:none;">
        <div class="clsOverflow clsFlagTitle">
            <h2>{$LANG.viewarticle_flag_title}</h2>
        </div>
        <div class="clsFlagInfo">
        	<p id="clsMsgDisplay_flag" class="clsDisplayNone"></p>
            <p>{$LANG.viewarticle_report_media}</p>
            <p class="clsReason">{$LANG.viewarticle_choose_reasons}</p><br />
            <form name="flagFrm" id="flagFrm" method="post" action="{$myobj->getCurrentUrl()}" autocomplete="off">
                <p><select name="flag" id="flag" tabindex="{smartyTabIndex}">
                <option value="">{$LANG.common_select_option}</option>
                {foreach key=ftKey item=ftValue from=$myobj->flag_type_arr}
                    <option value="{$ftKey}">{$ftValue}</option>
                {/foreach}
                </select></p>
                <p>{$LANG.viewarticle_flag_comment}&nbsp;<span class="clsMandatoryFieldIcon">{$LANG.common_mandatory}</span>&nbsp;</p>
                <p class="clsComments"><textarea name="flag_comment" id="flag_comment" tabindex="{smartyTabIndex}" rows="5" cols="50" maxlength="5"></textarea></span></p>
                <div class="clsOverflow">
                    <div class="clsCommentsLeft">
                        <div class="clsCommentsRight">
                    <input type="button" name="add_to_flag" id="add_to_flag" value="{$LANG.viewarticle_set_flag}" onClick="return addToFlag(1, '{$CFG.site.article_url}viewArticle.php?ajax_page=true&amp;page=flag&amp;article_id={$myobj->getFormField('article_id')}&amp;show={$myobj->getFormField('show')}')" />
                 	   </div>
                    </div>
                </div>
                <div class="clsRow" style="display:none" id="flag_loader_row">
                  	<div class="clsTDLabel"><!----></div>
                        <div class="clsTDText"><div id="flag_submitted"></div></div>
                </div>
            </form>
        </div>
    </div>
