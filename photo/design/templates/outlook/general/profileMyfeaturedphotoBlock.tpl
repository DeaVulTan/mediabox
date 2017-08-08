{if chkAllowedModule(array('photo'))}
{if $myobjFeaturedPhoto->isFeaturedphoto}
<script src="{$CFG.site.photo_url}js/jquery.cycle.js" type="text/javascript"></script>
<div class="clsPhotoFeaturedShelfTable">
	 <div class="slideshow">
		{assign var='increment' value=0}
		{foreach key=genresKey item=photoValue from=$featured_photo_list_arr}
		  <a href="{$photoValue.view_photo_link}" class="Cls470x392 clsPhotoImageHolder clsPhotoImageBorder" alt="{$photoValue.photo_title}" title="{$photoValue.photo_title}">
			 <img src="{$photoValue.medium_img_src}" alt="{$photoValue.photo_title}" {$myobj->DISP_IMAGE(470, 392, $photoValue.l_width, $photoValue.l_height)}/>
		  </a>  
		{/foreach}
	</div>
</div>
{literal}
<script type="text/javascript">
$Jq(document).ready(function() {
    $Jq('.slideshow').cycle({
		fx: 'all' // choose your transition type, ex: fade, scrollUp, shuffle, etc...
	});
});
</script>
{/literal}
{else}
		<div class="clsOverflow">
		<div class="clsNoRecordsFound">{$LANG.myprofile_featuredphoto_no_records}</div>
	  </div>
{/if}
{/if}