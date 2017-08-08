<?php /* Smarty version 2.6.18, created on 2012-02-04 15:15:54
         compiled from viewLocationPhotos.tpl */ ?>
<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('block_view_location_photos')): ?>
<?php echo '
'; ?>

<div id="map_canvas" class="clsGoogleMapCanvas"><!-- --></div>
<?php echo '
<script type="text/javascript" >
//$Jq(function(){$Jq(\'#loopedSlider\').loopedSlider();});


//$Jq(document).ready( function(){ rotate.init() });
$Jq(document).ready( function(){
  initializeViewPhoto();
  var t;
  t= setTimeout(\'callslide()\',1000);
});
function callslide()
{
	$Jq(function(){
		// Option set as a global variable
		$Jq.fn.loopedSlider.defaults.addPagination = false;
		$Jq(\'#loopedSlider\').loopedSlider();
	});

}
</script>
'; ?>


<?php endif; ?>