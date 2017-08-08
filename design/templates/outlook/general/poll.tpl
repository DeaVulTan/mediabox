
<div id="selPoll"> { if $header->isShowPageBlock('pollFormBlock') || $header->isShowPageBlock('pollResultBlock')}
  { if $header->isShowPageBlock('headerBlock')}
  <h3>{$smarty_data_poll_question}</h3>
  <div id="selPollDyn"> { if $header->isShowPageBlock('pollFormBlock')}
    <form name="frmpollsubmit" id="frmpollsubmit" method="post" action="">
          <!-- clsFormSection - starts here -->
    {include file='../general/box.tpl' opt='form_top'}
    <div class="clsFormSection">
{foreach key=inc item=value from=$smarty_data_poll_option}
        <div class="clsFormRow clsFormCheckBoxRow">
          <div class="clsFormFieldCellDefault">
            <input type="radio" name="answer_dummy" id="answer_dummy{$inc}" value="{$smarty_data_poll_option.$inc.poll_option_id}" />
          </div>
          <div class="clsFormLabelCellDefault">
            <label for="answer_dummy{$inc}">{$smarty_data_poll_option.$inc.poll_option}</label>
          </div>
        </div>
        {/foreach}
        <input type="submit" class="clsSubmitButton" name="vote" id="vote" value="vote" onclick="return voteSubmitted()" />
      </div>
     {include file='../general/box.tpl' opt='form_bottom'}
    <!-- clsFormSection - ends here -->
   </form>
    {/if} </div>
  {/if}
  { if $header->isShowPageBlock('pollResultBlock')}
  {include file='../general/box.tpl' opt='data_top'}
  <div class="clsDataDisplaySection clsPollDataDisplaySection">
    <div class="clsDataContentSection"> {foreach key=inc item=value from=$smarty_data_poll_result}
      <div class="clsDataRow">
        <ul>
          <li><h4>{$smarty_data_poll_result.$inc.poll_option}</h4>
            <p><img src="{$CFG.site.url}design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/bg-poll.jpg" height="10" width="{$smarty_data_poll_result.$inc.figure_width}" /> {$smarty_data_poll_result.$inc.percentage}%</p>
          </li>
        </ul>
      </div>
      {/foreach} </div>
  </div>
  {include file='../general/box.tpl' opt='data_bottom'}
  {/if}
  
  {/if} </div>
