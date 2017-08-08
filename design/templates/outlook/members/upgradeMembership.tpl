{$myobj->setTemplateFolder('general/')}
{include file='box.tpl' opt='display_top'}
<div>
	<div class="clsPageHeading"><h2>{$LANG.membership_upgrade_title}</h2></div>
	{$myobj->setTemplateFolder('general/')}
    {include file="information.tpl"}
{if $myobj->isShowPageBlock('block_upgrade_form')}
    <div class="clsOverflow clsPadding10">
    	<p class="clsMarginBottom5">{$myobj->contentText}</p>
	    <div class="clsSubmitLeft"> <div class="clsSubmitRight">
            {$myobj->setTemplateFolder('members/')}
        	{include file="paypal_form.tpl"}
        </div></div>
	</div>    
{/if}
</div>
{$myobj->setTemplateFolder('general/')}
{include file='box.tpl' opt='display_bottom'}