<script src="{$CFG.site.photo_url}js/AC_RunActiveContent.js" type="text/javascript"></script>
  {if $myobj->isShowPageBlock('block_photo_slide_show')}
  {literal}
 <script language="javascript">
	if (AC_FL_RunContent == 0) {
		alert("This page requires AC_RunActiveContent.js.");
	} else {
		AC_FL_RunContent(
			'codebase', 'http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,0,0',
			'FlashVars',
			'configPath={/literal}{$myobj->configxmlPath}{literal}',
			'width', '100%',
			'height', '100%',
			'src', '{/literal}{$myobj->configPath}{$myobj->default_template}slideshow{literal}',
			'quality', 'high',
			'pluginspage', 'http://www.macromedia.com/go/getflashplayer',
			'align', 'middle',
			'play', 'true',
			'loop', 'true',
			'scale', 'noscale',
			'wmode', 'window',
			'devicefont', 'false',
			'id', 'slideshow',
			'bgcolor', '#000000',
			'name', 'slideshow',
			'menu', 'true',
			'allowFullScreen', 'true',
			'allowScriptAccess','always',
			'movie', '{/literal}{$myobj->configPath}{$myobj->default_template}slideshow{literal}',
			'salign', 'lt'
			); //end AC code
	}
	
</script>
{/literal}
  {/if}{* end of showPageBlock block_photo_slide_show if condition*}
