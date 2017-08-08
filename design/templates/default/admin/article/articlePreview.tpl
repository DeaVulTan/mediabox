 <div id="selArticlePreview">
  <h2><span>{$myobj->getFormField('user_name')}{$LANG.preview_title}</span></h2>

  {$myobj->setTemplateFolder('admin/')}
  {include file='information.tpl'}

{if $myobj->isShowPageBlock('view_article_form')}
  <div id="selArticlePreviewFrm">
    <h3>{$myobj->getFormField('article_title')}</h3>
    <p>{$myobj->getFormField('article_caption')}</p>
   </div>
{/if}

</div>