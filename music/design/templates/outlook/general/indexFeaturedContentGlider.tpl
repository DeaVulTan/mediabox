<link rel="stylesheet" type="text/css" href="{$CFG.site.url}music/design/templates/{$CFG.html.template.default}/root/css/{$CFG.html.stylesheet.screen.default}/featured_content_music.css" media="screen" title="{$CFG.html.stylesheet.screen.default}" />
<script language="javascript" type="text/javascript" src="{$CFG.site.url}js/lib/jquery.anythingslider.js"></script>
<script language="javascript" type="text/javascript" src="{$CFG.site.url}js/lib/jquery.easing.js"></script>
<script type="text/javascript" src="{$CFG.site.url}music/js/anythingslider_config.js"></script>
{ if $CFG.admin.light_window_page }
<script type="text/javascript" src="{$CFG.site.url}js/lib/lightwindow/lightwindow.js"></script>
{/if}

{if $featuredContentTotal>0}
<!-- START AnythingSlider -->
{$myobj->setTemplateFolder('general/','music')}
{include file="box.tpl" opt="slider_top"}
<div class="anythingSlider">
  <div class="wrapper">
        <ul>
            <!--<li><img src="http://localhost/volume/rayzz_audiosharing/branches/volume/design/templates/bluetheme/root/images/screen_blue/images/slide-civil-1.jpg" alt="" /></li>-->
            {foreach key=inc item=value from=$musicFeaturedContent}
                    <li>
                        <div id="textSlide" class="clsSliderHeading">
                          <div class="clsSliderHead">  <h3>{$musicFeaturedContent.$inc.title} <!-- <span>On <span>Rocketship</span></span><span>&nbsp; | &nbsp;</span><span>by <a href="#">Webmaster</a></span>--></h3></div>
                            <div class="clsOverflow clsSlilderDetails">
                            		{if $musicFeaturedContent.$inc.image_path !=''}
                                    <img src="{$musicFeaturedContent.$inc.image_path}" />
                                    {/if}
                                <div class="clsSliderContent {if $musicFeaturedContent.$inc.image_path ==''}clsSliderContentOnly{/if}">
                                    <ul>
                                        <li>{$musicFeaturedContent.$inc.description}</li>
                                        <li class="clsReadMore">
                                			<a href="javascript:void(0);" onclick="javascript: myLightWindow.activateWindow( {literal} { {/literal} type:'external',href:'{$musicFeaturedContent.$inc.musicFeaturedCcontentViewUrl}',title:'{$musicFeaturedContent.$inc.title|truncate:10:"..."}',width:650,height:400 {literal} } {/literal} );" title="{$musicFeaturedContent.$inc.title}" id="add_comment">Read More</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </li>
            {/foreach}
        </ul>
  </div>
</div> <!-- END AnythingSlider -->
{$myobj->setTemplateFolder('general/','music')}
{include file="box.tpl" opt="slider_bottom"}
{/if}