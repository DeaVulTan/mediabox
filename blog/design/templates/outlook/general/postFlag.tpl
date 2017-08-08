		<div id="flagDiv" class="clsPopupConfirmation clsTextAlignLeft" style="display:none;">

			<form name="flagfrm" id="flagfrm" action="{$myobj->getCurrentUrl()}" method="post" autocomplete="off" onsubmit="return false">
        		<div class="clsCreatePlaylist clsOverflow">
                  <div class="clsUserActionMessage">
                     {$LANG.viewpost_report_media}
                    </div>
                    <p id="clsMsgDisplay_flag" class="clsDisplayNone"></p>
			<div class="clsRow">
                		<div class="clsTDLabel">{$LANG.viewpost_choose_reasons}</div>
                    	<div class="clsTDText">
                        <select name="flag" id="flag" tabindex="{smartyTabIndex}">
                        <option value="">{$LANG.common_select_option}</option>
                        {foreach key=ftKey item=ftValue from=$myobj->flag_type_arr}
                        <option value="{$ftKey}">{$ftValue}</option>
                        {/foreach}
                    	</select>
       			</div>
                   </div>
			<div class="clsRow">
			 	<div class="clsTDLabel">{$LANG.viewpost_flag_comment}&nbsp;<span class="clsMandatoryFieldIcon">{$LANG.common_blog_mandatory}</span>&nbsp;</div>
				<div class="clsTDText"><textarea name="flag_comment" id="flag_comment" tabindex="{smartyTabIndex}" rows="5" cols="30" style="width:95%;" maxlength="5"></textarea>
				</div>
			 </div>
			<div class="clsRow" style="display:none" id="flag_loader_row">
                  	<div class="clsTDLabel"><!----></div>
                        <div class="clsTDText"><div id="flag_submitted"></div></div>
                  </div>
			 <div class="clsRow">
                   	<div class="clsTDLabel"><!----></div>
			 	<div class="clsTDText">
					<p class="clsButton"><span><input type="button" name="add_to_flag" id="add_to_flag" value="{$LANG.viewpost_set_flag}" onClick="return addFlagContent('{$CFG.site.blog_url}viewPost.php?ajax_page=true&amp;page=flag&amp;blog_post_id={$myobj->getFormField('blog_post_id')}&amp;show={$myobj->getFormField('show')}')" /></span></p>
				</div>
 			</div>
			</div>
			</form>
    </div>