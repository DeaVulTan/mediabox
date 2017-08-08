<link rel="stylesheet" type="text/css" href="{$CFG.site.url}music/design/templates/{$CFG.html.template.default}/root/css/{$CFG.html.stylesheet.screen.default}/featured_content_music.css" media="screen" title="{$CFG.html.stylesheet.screen.default}" />
<div class="clsSliderPopup">
{$myobj->setTemplateFolder('general/', 'music')}
{include file="box.tpl" opt="slider_top"}
<div class="anythingSlider">
  <div class="wrapper">
        <ul>
            <li>
                <div id="textSlide" class="clsSliderHeading">
                	<h3>{$featuredContentTitle}</h3>
                    <div class="clsOverflow clsSlilderDetails">
                            {if $imagePath !=''}
                                <img src="{$imagePath}" />
                            {/if}
                        <div>
                            <ul>
                                <li>{$featuredContentDescription}</li>
                            </ul>
                        </div>
                    </div>
                </div>
           </li>
        </ul>
  </div>
</div> <!-- END AnythingSlider -->
 {$myobj->setTemplateFolder('general/', 'music')}
{include file="box.tpl" opt="slider_bottom"}</div>