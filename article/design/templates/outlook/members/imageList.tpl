<div class="manager clsOverflow">
	{foreach key=inc item=value from=$file_array}
    <div class="clsUploadArticleIframe" style="float:left; background:#FFF; width:70px; margin:0 10px 10px 0; padding:5px; border:1px solid #eeeff1">
    	<div class="item clsUploadImage">
         	<a href="javascript: ImageManager.populateFields('{$file_array.$inc.image_path}')">
            	<img src="{$file_array.$inc.image_path}" width="60" height="45" alt="{$file_array.$inc.image_name}" style="border:1px solid #eeeff1" />
                <span style="width:65px;height:15px;overflow:hidden;display:block;">{$file_array.$inc.image_name}</span>
            </a>
		</div>
		<div class="clsUploadImageTitle"></div>
    </div>
    {/foreach}
</div>