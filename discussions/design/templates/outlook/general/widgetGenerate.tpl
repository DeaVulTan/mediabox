<div id="selWidgetGenerate">
<div class="clsCommonTopContributorRoundedCorner">
  <!--rounded corners-->
  <div class="lbtopcontributor">
    <div class="rbtopcontributor">
      <div class="bbtopcontributor">
        <div class="blctopcontributor">
          <div class="brctopcontributor">
            <div class="tbtopcontributor">
              <div class="tlctopcontributor">
                <div class="trctopcontributor">
	 <h2 class="clsInboxReadHeading"><span>{$LANG.page_title}</span></h2>

{include file='../general/information.tpl'}
 <div class="clsInboxReadTbl">
	{if $myobj->isShowPageBlock('form_widget')}
        <div id="selWidget" class="clsCommonWidgetSection">
            <h3>{$LANG.build_widget}</h3>
            <form name="selFormAskBoard" method="post" id="selFormAskBoard" action="{$myobj->getCurrentUrl()}" autocomplete="off">
            <table summary="{$LANG.widget_generation}" class="clsWidgetTable">
                    <tr>
                        <td class="{$myobj->getCSSFormLabelCellClass('type')}"><label for="type">{$LANG.board_type}</label></td>
                        <td class="{$myobj->getCSSFormLabelCellClass('type')}">
                        <select name="type" id="type" onchange="this.form.submit()" tabindex="{smartyTabIndex}">
                            {$myobj->generalPopulateArray($myobj->LANG_LIST_ARR.widget_type, $myobj->getFormField('type'))}
                        </select>
                    </td>
                    </tr>
            {if $myobj->getFormField('type') != 'ask_only'}
                    <tr>
                        <td class="{$myobj->getCSSFormLabelCellClass('type')}"><label for="board">{$LANG.show_boards}</label></td>
                        <td class="{$myobj->getCSSFormLabelCellClass('type')}">
                        <select name="board" id="board" onchange="this.form.submit()" tabindex="{smartyTabIndex}">
                            {$myobj->generalPopulateArray($myobj->LANG_LIST_ARR.board_type, $myobj->getFormField('board'))}
                        </select>
                     </td>
                    </tr>
                    <tr>
                             <td class="{$myobj->getCSSFormLabelCellClass('type')}"><label for="board_count">{$LANG.board_count}</label></td>
                         <td class="{$myobj->getCSSFormLabelCellClass('type')}">
                        <select name="board_count" id="board_count" onchange="this.form.submit()" tabindex="{smartyTabIndex}">
                           {$myobj->populateBWNumbers(1, 10, $myobj->getFormField('board_count'))}
                        </select>
                        <input type="hidden" name="submit1" id="submit1" />
                    </td>
                    </tr>
            {/if}
            </table>
            </form>
        </div>

    {/if}

	{if $myobj->isShowPageBlock('form_widget_preview')}
			{if $myobj->isResultsFound()}
                <div class="clsCommonPreviewWidgetSection">
                    <h3><span>{$LANG.preview_widget}</span></h3>
					{$myobj->showBoardList()}
				</div>
			{else}
                <div id="selMsgAlert">
                    <p>{$LANG.discuzz_common_no_records_found}</p>
                </div>
			{/if}
	 {/if}

       <div class="clsCommonPreviewWidgetSection">
		<h3>{$LANG.code_widget}</h3>

       {if $myobj->isShowPageBlock('form_widget_code')}
			<div id="selGeneratedCode">
                <table class="clsWidgetGenerateTable">
                    <tr>
                        <td>
                            <p>{$LANG.widget_embed_hint}</p>
                            <input type="text" size="70"  onClick="this.select()"   name ="code" id="code" class="clsGeneratedCode" readonly="readonly"value="<script language='JavaScript' type='text/javascript' src='{$CFG.site.url}widgetGenerate.php?embed=1&amp;board_count={$myobj->getFormField('board_count')}&amp;type={$myobj->getFormField('type')}&amp;category={$myobj->getFormField('category')}&amp;sub_category={$myobj->getFormField('sub_category')}&amp;board={$myobj->getFormField('board')}&amp;uid={$myobj->getFormField('uid')}'></script>" />
                        </td>
                    </tr>
                </table>
              </div>
	   {/if}
	</div>
    </div></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!--end of rounded corners-->
</div>
</div>