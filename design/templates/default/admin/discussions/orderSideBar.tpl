<div id="selAddNewsLetter">
	<h2 class="clsNewsLetterTitle">{$LANG.rightbar}</h2>
	<p>{$LANG.rightbar_info}</p>
	{include file='information.tpl'}
	{if $myobj->isShowPageBlock('form_order_rightbar')}
		<form name="form_order_rightbar" id="form_order_rightbar" method="post" action="{$myobj->getCurrentUrl()}" autocomplete="off">
			<table summary="{$LANG.rightbar_tbl_summary}">
				<tr>
					<td class="{$myobj->getCSSFormLabelCellClass('user_status')}">
						<label for="user_status">
							{$LANG.user_status}
						</label>
					</td>
					<td class="{$myobj->getCSSFormFieldCellClass('user_status')}">
							<input type="text" class="clsTextBox clsSmallTextBox {$myobj->getCSSFormFieldElementClass('user_status')}" name="user_status" id="user_status" maxlength="1" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('user_status')}" />
				    			{$myobj->getFormFieldElementErrorTip('user_status')}
					</td>
			    </tr>
				<tr>
					<td class="{$myobj->getCSSFormLabelCellClass('top_contributors')}">
						<label for="top_contributors">
							{$LANG.top_contributors}
						</label>
					</td>
					<td class="{$myobj->getCSSFormFieldCellClass('top_contributors')}">
							<input type="text" class="clsTextBox clsSmallTextBox {$myobj->getCSSFormFieldElementClass('top_contributors')}" name="top_contributors" id="top_contributors" maxlength="1" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('top_contributors')}" />
							{$myobj->getFormFieldElementErrorTip('top_contributors')}
				    </td>
			    </tr>
				<tr>
					<td class="{$myobj->getCSSFormLabelCellClass('featured_contributors')}">
						<label for="featured_contributors">
							{$LANG.featured_contributors}
						</label>
					</td>
					<td class="{$myobj->getCSSFormFieldCellClass('featured_contributors')}">
							<input type="text" class="clsTextBox clsSmallTextBox {$myobj->getCSSFormFieldElementClass('featured_contributors')}" name="featured_contributors" id="featured_contributors" maxlength="1" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('featured_contributors')}" />
							{$myobj->getFormFieldElementErrorTip('featured_contributors')}
				    </td>
			    </tr>
				<tr>
					<td class="{$myobj->getCSSFormLabelCellClass('featured_board')}">
						<label for="featured_board">
							{$LANG.featured_board}
						</label>
					</td>
					<td class="{$myobj->getCSSFormFieldCellClass('featured_board')}">
							<input type="text" class="clsTextBox clsSmallTextBox {$myobj->getCSSFormFieldElementClass('featured_board')}" name="featured_board" id="featured_board" maxlength="1" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('featured_board')}" />
							{$myobj->getFormFieldElementErrorTip('featured_board')}
				    </td>
			    </tr>
				<tr>
		   			<td></td>
		   			<td>
						<input type="submit" class="clsSubmitButton" name="orderrightbar" id="orderrightbar" tabindex="{smartyTabIndex}" value="{$LANG.common_update}"  />&nbsp;
						<input type="reset" class="clsCancelButton cancel" name="reset" id="reset" tabindex="{smartyTabIndex}" value="{$LANG.discuzz_common_reset}" />
					</td>
				</tr>
			</table>
		</form>
	{/if}
</div>