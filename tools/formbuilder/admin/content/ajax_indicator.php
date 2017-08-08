<?php
	$content->appendJs(URL_JS . 'jqModal.js');
	$content->appendJs('
	
		$(document).ready(
			function()
			{
				 $("#ajaxIndicator").jqm({modal:true});
			}
		);
	', false);
?>
<div class="jqmWindow" id="ajaxIndicator">
	<div id="ajaxProgress">
		<h1><?php echo CMM_AJAX_PRGRESS_HEADING; ?></h1>
		<p class="ajaxProgressBody"><?php echo CMM_AJAX_PROGRESS_DESC; ?></p>
	</div>
	<div id="ajaxError"  class="hidden" >
		<h1><?php echo CMM_AJAX_ERROR_HEADING; ?></h1>
		<p class="ajaxErrorBody"></p>
		<a href="javascript:void(0);" class="jqmClose"><?php echo L_ACTION_CLOSE; ?></a>
	</div>

</div>