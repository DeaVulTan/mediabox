 <div id="selPostPreview">
  <h2><span>{$myobj->getFormField('user_name')}{$LANG.common_post_preview_title}</span></h2>

  {$myobj->setTemplateFolder('admin/')}
  {include file='information.tpl'}

{if $myobj->isShowPageBlock('view_post_form')}
  <div id="selPostPreviewFrm">
    <h3>{$myobj->getFormField('blog_post_name')}</h3>
    <p>{$myobj->getFormField('message')}</p>
   </div>
{/if}

</div>