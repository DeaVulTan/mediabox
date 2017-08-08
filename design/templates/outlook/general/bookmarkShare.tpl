{if isset($CFG.site.bookmark.addthis_enabled) && $CFG.site.bookmark.addthis_enabled}
<!-- ADDTHIS BUTTON BEGIN -->
<script type="text/javascript">
var addthis_pub             = "{$CFG.site.bookmark.addthis_account}";
var addthis_logo            = "{$CFG.site.url}design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/logo.jpg";
var addthis_logo_background = 'EFEFFF';
var addthis_logo_color      = '666699';
var addthis_brand           = "{$CFG.site.name}";
var addthis_options         = "{$blogPost.site_arr_str}";
</script>
<a href="http://www.addthis.com/bookmark.php" onmouseover="return addthis_open(this, '', '{$blogPost.url}', '{$blogPost.title}')" onmouseout="addthis_close()" onclick="return addthis_sendto()">
{if $blogPost.title_link}
<img src="{$blogPost.buttom_image}" width="125" height="16" border="0" title="Share" /></a>
{else}
	<img src="{$blogPost.buttom_image}" width="125" height="16" border="0" alt="" /></a>
{/if}
<script type="text/javascript" src="http://s7.addthis.com/js/152/addthis_widget.js"></script>
<!-- ADDTHIS BUTTON END -->
{/if}
