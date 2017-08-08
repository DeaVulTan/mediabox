<!-- START AnythingSlider -->
{include file="box.tpl" opt="slider_top"}
<div class="anythingSlider clsIndexSingleSlide">
	<h2>{$promotional_content.glider_title}</h2>
	<div class="clsLatestFeatureContent">
		<div class="clsImage">
	    	<div class="clsImageContainer clsImageBorder4 cls368x277">
	    		{$promotional_content.main_content}
	        </div>
	    </div>
	    <div class="clsDetails">
	        {$myobj->setTemplateFolder('general/')}
	        {include file='box.tpl' opt='featuredetails_top'}
	        	<div class="clsFeatureDetailsContainer">
	            	<div class="clsFeatureDetailsContent">
	            		{$promotional_content.sidebar_content}
	                </div>
	            </div>
	        {include file='box.tpl' opt='featuredetails_bottom'}
	    </div>
	</div>
</div> <!-- END AnythingSlider -->
{include file="box.tpl" opt="slider_bottom"}