{if $myobj->isShowPageBlock('block_add_comments')}
    {if $myobj->getFormField('allow_comments') == 'Kinda'}
        <div id="selEditMainComments" style="display: none;" class="clsPostcommentBlock">{$myobj->getCommentsBlock()}</div>
    {elseif $myobj->getFormField('allow_comments')=='Yes'}
        <div id="selEditMainComments" style="display: none;" class="clsPostcommentBlock">{$myobj->getCommentsBlock()}</div>
    {/if}
	{literal}
        <script language="javascript" type="text/javascript">
            var captcha = '{/literal}{$myobj->captchaText}{literal}';
            var comment_approval = {/literal}{if $myobj->getFormField('allow_comments')=='Kinda' && $myobj->getFormField('user_id')==$CFG.user.user_id}1{elseif $myobj->getFormField('allow_comments')=='Kinda'}0{elseif $myobj->getFormField('allow_comments')=='Yes'}1{/if}{literal};
        </script>
  	{/literal}
{/if}