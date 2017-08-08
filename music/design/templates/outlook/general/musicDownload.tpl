{$myobj->setTemplateFolder('general/','music')}
{include file=information.tpl}
{if !$CFG.admin.musics.download_previlages=='ALL'}
{*TRIMMED MUSIC MESSAGE BLOCK STARTS*}
{if $myobj->isPaidMemeberAlert()}
      <div class="clsTrimmedMusic">
            <h4>{$myobj->alertMessage}</h4>
      </div>
{/if}
{*TRIMMED MUSIC MESSAGE BLOCK ENDS*}
{/if}