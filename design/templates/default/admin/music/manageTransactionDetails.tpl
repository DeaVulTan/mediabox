<div id="selMusicList">
	<!-- heading start-->
	<h2>
    	<span>
        	{$LANG.search_title}
        </span>
    </h2>
    <!-- heading end-->
    <!-- Confirmation message block start-->
    <div id="selMsgConfirm" class="clsPopupConfirmation" style="display:none;">
        <p id="confirmMessage"></p>
        <form name="msgConfirmform" id="msgConfirmform" method="post" action="{$myobj->getCurrentUrl()}">
            <table summary="">
                <tr>
                    <td>
                        <input type="submit" class="clsSubmitButton" name="confirm_action" id="confirm_action" tabindex="{smartyTabIndex}" value="{$LANG.common_confirm}" />
                        &nbsp;
                        <input type="button" class="clsCancelButton" name="cancel" id="cancel" tabindex="{smartyTabIndex}" value="{$LANG.common_cancel}"  onClick="return hideAllBlocks('selFormForums');" />
                        <input type="hidden" name="ch_status" id="ch_status" />
                        <input type="hidden" name="act" id="act" />
                         <input type="hidden" name="uid" id="uid" />
                        {$myobj->populateHidden($myobj->form_list_members.populateHidden_arr)}
                    </td>
                </tr>
            </table>
        </form>
    </div>
    <!-- Confirmation message block end-->
     <!-- information div -->
    {$myobj->setTemplateFolder('admin/')}
    {include file='information.tpl'}
    {if $myobj->isShowPageBlock('form_search')}
        <form name="formSearch" id="formSearch" method="post" action="{$myobj->getCurrentUrl()}">
        <table class="clsNoBorder clsTextBoxTable">
            <tr>
              <td class="{$myobj->getCSSFormLabelCellClass('uname')}"><label for="uname">{$LANG.search_user_name}</label></td>
              <td class="{$myobj->getCSSFormFieldCellClass('uname')}">{$myobj->getFormFieldErrorTip('uname')}<input type="text" class="clsTextBox" name="uname" id="uname" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('uname')}" /></td>
              <td class="{$myobj->getCSSFormLabelCellClass('paypal_id')}"><label for="email">{$LANG.search_paypal_id}</label></td>
              <td class="{$myobj->getCSSFormFieldCellClass('paypal_id')}">{$myobj->getFormFieldErrorTip('paypal_id')}<input type="text" class="clsTextBox" name="paypal_id" id="paypal_id" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('paypal_id')}" /></td>
            </tr>
           <tr>
             <td class="clsWidthSmall {$myobj->getCSSFormLabelCellClass('fname')}"><label for="fname">{$LANG.search_first_name}</label></td>
             <td class="clsWidthSmall {$myobj->getCSSFormFieldCellClass('fname')}">{$myobj->getFormFieldErrorTip('fname')}<input type="text" class="clsTextBox" name="fname" id="fname" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('fname')}" /></td>
              <td class="clsWidthSmall {$myobj->getCSSFormLabelCellClass('tagz')}"><label for="tagz">{$LANG.search_profile_tag}</label></td>
              <td class="clsWidthSmall {$myobj->getCSSFormFieldCellClass('tagz')}">{$myobj->getFormFieldErrorTip('tagz')}<input type="text" class="clsTextBox" name="tagz" id="tagz" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('tagz')}" /></td>
          </tr>
          <tr>
          	<td class="{$myobj->getCSSFormLabelCellClass('srch_threshold')}"><label for="srch_threshold">Threshold Reached</label></td>
          	<td>
				<select name="srch_threshold" id="srch_threshold" tabindex="{smartyTabIndex}">
                  <option value="">{$LANG.action_select}</option>
                  <option value="Yes" {if $myobj->getFormField('srch_threshold') == 'Yes'} SELECTED {/if}>{$LANG.managetransactiondetails_threshold_yes}</option>
                  <option value="No" {if $myobj->getFormField('srch_threshold') == 'No'} SELECTED {/if}>{$LANG.managetransactiondetails_threshold_no}</option>
                </select>
          	</td>
          </tr>
            <tr>

                <td class="{$myobj->getCSSFormFieldCellClass('submit')}">
                    <input type="submit" class="clsSubmitButton" name="search_submit" id="search_submit" tabindex="{smartyTabIndex}" value="{$LANG.search_submit}" />
                    &nbsp;&nbsp;
                    <input type="submit" class="clsSubmitButton" name="search_submit_reset" id="search_submit_reset" tabindex="{smartyTabIndex}" value="{$LANG.search_submit_reset}" onclick=""/>                </td>
            </tr>
            <tr>
                <td colspan="4" align="center" id="searchErrorMsg">&nbsp;</td><!--for php coders -->
            </tr>
        </table>
  </form>
    {/if}
    {if  $myobj->isShowPageBlock('form_no_records_found')}
        <div id="selMsgAlert">
            <p>{$LANG.search_msg_no_records}</p>
        </div>
	{/if}
    {if $myobj->isShowPageBlock('msg_form_user_details_updated') && $myobj->getCommonErrorMsg()}
		<div id="selMsgSuccess">{$myobj->getCommonErrorMsg()}</div>
    {/if }
	{if $myobj->isShowPageBlock('form_list_members')}
    	<div id="selMsgChangeStatus" class="clsPopupConfirmation" style="display:none;">
    		<p id="msgConfirmText"></p>
	      	<form name="formChangeStatus" id="formChangeStatus" method="post" action="{$_SERVER.PHP_SELF}">
	        	<table class="clsNoBorder">
		          	<tr>
				  		<td id="selPhotoGallery">
							<p id="profileIcon"></p>
						</td>
				  	</tr>
				  	<!--<tr>
		            	<td>
							<p><textarea name="featured_description" id="featured_description"></textarea></p>

						</td>
		          	</tr>-->
				  	<tr>
		            	<td>
						  	<input type="submit" class="clsSubmitButton" name="submit_yes" id="submit_yes" value="Activate" tabindex="{smartyTabIndex}" /> &nbsp;
			              	<input type="button" class="clsSubmitButton" name="submit_no" id="submit_no" value="Cancel" tabindex="{smartyTabIndex}" onClick="return hideAllBlocks()" />
							<input type="hidden" name="action" id="action" />
			              	<input type="hidden" name="uid" id="uid" />
							{$myobj->populateHidden($myobj->form_list_members.populateHidden_arr)}
						</td>
		          	</tr>
	        	</table>
	      	</form>
	    </div>
        <!-- top pagination start-->
        {if $CFG.admin.navigation.top}
            {include file='pagination.tpl'}
        {/if}

        <table summary="{$LANG.member_list_tbl_summary}" class="clsTransactionTable">
		<form name="selTransantionForm" id="selTransantionForm" method="post">
			<tr>

                <th class="{$myobj->getOrderCss('user_name')}" title="{$myobj->getTitleHelpTip('user_name')}"><a href="#" onclick="return changeOrderbyElements('selTransantionForm','user_name')">{$LANG.search_results_title_user_name}</th>
                <th >{$LANG.search_results_title_paypal_id}</th>
                <th class="{$myobj->getOrderCss('total_revenue')}" title="{$myobj->getTitleHelpTip('total_revenue')}"><a href="#" onclick="return changeOrderbyElements('selTransantionForm','total_revenue')">{$LANG.search_results_title_total_revenue}</a></th>
                <th class="{$myobj->getOrderCss('withdrawl_amount')}" title="{$myobj->getTitleHelpTip('withdrawl_amount')}"><a href="#" onclick="return changeOrderbyElements('selTransantionForm','withdrawl_amount')">{$LANG.search_results_title_withdrawl_amount}</a></th>
                <th class="{$myobj->getOrderCss('commission_amount')}" title="{$myobj->getTitleHelpTip('commission_amount')}"><a href="#" onclick="return changeOrderbyElements('selTransantionForm','commission_amount')">{$LANG.search_results_title_commission_amount}</a></th>
                <th class="{$myobj->getOrderCss('pending_amount')}" title="{$myobj->getTitleHelpTip('pending_amount')}"><a href="#" onclick="return changeOrderbyElements('selTransantionForm','pending_amount')">{$LANG.search_results_title_pending_amount}</a></th>
                <th class="{$myobj->getOrderCss('threshold_amount')}" title="{$myobj->getTitleHelpTip('threshold_amount')}"><a href="#" onclick="return changeOrderbyElements('selTransantionForm','threshold_amount')">{$LANG.search_results_title_threshold_amount}</a></th>
				<th>
				<!-- empty-->
				</th>
			</tr>
			{$myobj->populateHidden($myobj->selTransantionForm_hidden_arr)}
		</form>
			{foreach key=dmKey  item=dmValue from=$myobj->form_list_members.displayMembers.row}
			{*ASSIGNED THE DEFAULT THRESHOLD AMOUNT IF USER THRESHOLD AMOUNT LESSER THAN DEFAULT*}
			{assign var =threshold_amount value=$dmValue.record.threshold_amount}
			{if $dmValue.record.threshold_amount < $CFG.admin.musics.minimum_threshold_amount}
				{assign var =threshold_amount value=$CFG.admin.musics.minimum_threshold_amount }
			{/if}

                <tr class="{$dmValue.cssRowClass} {$dmValue.userClass}">

					<td><span class="clsProfileThumbImg"><a href="{$dmValue.memberProfileUrl}" id="{$dmValue.anchor}">{$dmValue.record.user_name}</a></span>
					</td>
                    <td class="editable">{$dmValue.record.paypal_id}</td>
                    <td class="editable">{$CFG.currency}{$dmValue.record.total_revenue}</td>
                    <td class="editable">{$CFG.currency}{$dmValue.record.withdrawl_amount}</td>
                    <td class="editable">{$CFG.currency}{$dmValue.record.commission_amount}</td>
                    <td class="editable">{$CFG.currency}{$dmValue.record.pending_amount}</td>
                    <td class="editable">{$CFG.currency}{$threshold_amount}</td>
                    <td>
					{if $dmValue.record.pending_amount > $threshold_amount}
					<form name="selFormSetPaid" id="selFormSetPaid" method="post">
					<input type="hidden" name="pending_amount" value="{$dmValue.record.pending_amount}">
					<input type="hidden" name="user_id" value="{$dmValue.record.user_id}">
					<input type="submit" name="set_paid" id="set_paid" value="Set as Paid"  class="clsSubmitButton">
					</form>
						{if $dmValue.record.paypal_id!=''}
						<form name="selFormTransaction" id="selFormTransaction" method="post" target="_blank" action="{if $CFG.payment.paypal.test_mode}{$CFG.payment.paypal.test_url}{else}{$CFG.payment.paypal.url}{/if}">
						<input type="hidden" name="cmd" value="_xclick" />
							<input type="hidden" name="business" value="{$dmValue.record.paypal_id}" />
							<input type="hidden" name="item_name" value="User Payment" />
							<input type="hidden" name="currency_code" value="{$CFG.payment.paypal.currency_code}" />
							<input type="hidden" name="return" value="{$CFG.site.url}admin/music/manageTransactionDetails.php?status=success" />
							<input type="hidden" name="cancel_return" value="{$CFG.site.url}admin/music/manageTransactionDetails.php?status=failed" />
							<input type="hidden" name="notify_url" value="{$CFG.site.url}music/processPaypalPost.php" />

							<input type="hidden" name="amount" value="{$dmValue.record.pending_amount}" />
							<input type="hidden" name="undefined_quantity" value="0" />
							<input type="hidden" name="no_shipping" value="1" />
							<input type="hidden" name="no_note" value="0" />

							<input type="hidden" name="on1" value="user_id" />
							<input type="hidden" name="os1" value="{$dmValue.record.user_id}" />
							<input type="submit" value="Send Payment" class="clsSubmitButton">
						</form>
						{/if}
					{/if}
						<p><a href="transactionList.php?user_id={$dmValue.record.user_id}">{$LANG.transactionlist_view_details}</a></p>
					</td>
                </tr>


		{/foreach}

		</table>


        <!-- top pagination start-->
        {if $CFG.admin.navigation.bottom}
         {include file='pagination.tpl'}
        {/if}
        <!-- top pagination end-->
    {/if}
 </div>