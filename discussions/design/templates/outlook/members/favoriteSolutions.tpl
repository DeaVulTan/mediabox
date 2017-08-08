{if $myobj->isShowPageBlock('favorite_content')}
    <a class="clsFavourite" href="javascript:void(0)" onClick="toggleFavorites('{$myobj->favorite_solutions_url}', 'cid={$myobj->getFormField('cid')}&ctype={$myobj->getFormField('ctype')}', 'selShowFavoriteText_{$myobj->getFormField('ctype')}_{$myobj->getFormField('cid')}'); return false;">{$myobj->favorite_content_arr.favorite_solutions.title}</a>
{/if}

{if $myobj->isShowPageBlock('ignore_user')}
    <a class="{$myobj->ignore_user_arr.favorite_solutions.class}" href="javascript:void(0)" onClick="toggleFavorites('{$myobj->favorite_solutions_url}', 'block_id={$myobj->getFormField('block_id')}', 'selShowIgnoreUser'); return false;">{$myobj->ignore_user_arr.favorite_solutions.title}</a>
{/if}