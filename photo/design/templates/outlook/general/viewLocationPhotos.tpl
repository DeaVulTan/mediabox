{if $myobj->isShowPageBlock('block_view_location_photos')}
{literal}
{/literal}
<div id="map_canvas" class="clsGoogleMapCanvas"><!-- --></div>
{literal}
<script type="text/javascript" >
//$Jq(function(){$Jq('#loopedSlider').loopedSlider();});


//$Jq(document).ready( function(){ rotate.init() });
$Jq(document).ready( function(){
  initializeViewPhoto();
  var t;
  t= setTimeout('callslide()',1000);
});
function callslide()
{
	$Jq(function(){
		// Option set as a global variable
		$Jq.fn.loopedSlider.defaults.addPagination = false;
		$Jq('#loopedSlider').loopedSlider();
	});

}
</script>
{/literal}

{/if}