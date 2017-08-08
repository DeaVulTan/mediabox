 <div id="selPostPreview">
  {$myobj->setTemplateFolder('admin/')}
  {include file='information.tpl'}

{if $myobj->isShowPageBlock('view_photo_form')}
  <div id="selPostPreviewFrm">
      <p>      
      		<img src="{$myobj->getFormField('image')}" width="{$myobj->getFormField('l_width')}" height="{$myobj->getFormField('l_height')}" />

      </p>
   </div>
{/if}

</div>