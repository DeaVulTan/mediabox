{$myobj->setTemplateFolder('general/', 'music')}
{include file="box.tpl" opt="audioindex_top"}
<div class="clsAudioListContainer">
    <div class="clsAudioIndex">
      <h3>My Music</h3>
    </div>
    <div class="clsAudioListMenu">
      <ul>
        <li class="clsActive"><a href="#"><span>All Time</span></a></li>
        <li><a href="#"><span>Today</span></a></li>
        <li><a href="#"><span>Yesterday</span></a></li>
        <li><a href="#"><span>This Week</span></a></li>
        <li><a href="#"><span>This Month</span></a></li>
        <li><a href="#"><span>This Year</span></a></li>
      </ul>
    </div>
    <div class="clsAlphabeticPagination">
      <ul>
        <li class="clsActive"><a href="#">A</a></li>
        <li><a href="#">B</a></li>
        <li><a href="#">C</a></li>
        <li><a href="#">D</a></li>
        <li><a href="#">E</a></li>
        <li><a href="#">F</a></li>
        <li><a href="#">G</a></li>
        <li><a href="#">H</a></li>
        <li><a href="#">I</a></li>
        <li><a href="#">J</a></li>
        <li><a href="#">K</a></li>
        <li><a href="#">L</a></li>
        <li><a href="#">M</a></li>
        <li><a href="#">N</a></li>
        <li><a href="#">O</a></li>
        <li><a href="#">P</a></li>
        <li><a href="#">Q</a></li>
        <li><a href="#">R</a></li>
        <li><a href="#">S</a></li>
        <li><a href="#">T</a></li>
        <li><a href="#">U</a></li>
        <li><a href="#">V</a></li>
        <li><a href="#">W</a></li>
        <li><a href="#">X</a></li>
        <li><a href="#">Y</a></li>
        <li class="clsLastData"><a href="#">Z</a></li>
      </ul>
    </div>
    <div class="clsAdvancedFilterSearch" id=""> 
        <a class="clsShow" href="#" style="">Show Advanced Filters</a> 
        <a class="clsHide" style="display:none;" href="#">Hide Advanced Filters</a>
    </div>
    <div class="clsSelectAllLinks clsOverflow">
    	<p class="clsListCheckBox"><input name="" type="checkbox" value="" /></p>
        <p class="clsSubmitButton-l"><span class="clsSubmitButton-r"><input type="submit" value="Play" /></span></p>
        <p class="clsCancelButton-l"><span class="clsCancelButton-r"><input type="submit" value="Add to Quickmix" /></span></p>
        <p class="clsCancelButton-l"><span class="clsCancelButton-r"><input type="submit" value="Add to Play" /></span></p>
    </div>
    <div class="clsOverflow clsSortByLinksContainer">
        <div class="clsSortByLinks">
        	Sort By: <a class="clsActive" href="#">Title</a> | <a href="#">Album</a> | <a href="#">Artist</a>
        </div>
        <div class="clsSortByPagination">
            <div class="clsAudioPaging">
                <div class="clsPagingList">
                  <ul>
                    <!-- Previous link -->
                    <li class="clsInactivePrevLinkPage clsInActivePageLink">First</li>
                    <!-- First link -->
                    <li class="clsFirstPageLink clsInActivePageLink">Previous</li>
                    <!-- paging list start -->
                    <li class="clsCurrPageLink clsInActivePageLink">1</li>
                    <li class="clsPagingLink"><a href="#">2</a></li>
                    <li class="clsPagingLink"><a href="#">3</a></li>
                    <!-- pagin list end -->
                    <!-- Last Link -->
                    <li class="clsLastPageLink"><a href="#">Next</a></li>
                    <!-- Next link -->
                    <li class="clsNextPageLink"><a href="#">Last</a></li>
                  </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="clsHorizontalLine"><!– –></div>
    <div class="clsListContents">
        <div class="clsOverflow">
            <p class="clsListCheckBox"><input name="" type="checkbox" value="" /></p>
            <div class="clsThumb">
                <div class="clsLargeThumbImageBackground">
                   <p class="ClsImageContainer ClsImageBorder1 Cls132x88" onclick="">
                        <img src="{$CFG.site.url}music/design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/dummy-images/img1.jpg" />
                    </p>
                </div>
                <div class="clsTime">00:15</div>
            </div>
            <div class="clsContentDetails">
                <p class="clsHeading"><a href="#">Lil - Mama lip gloss</a></p>
                <p class="clsBold">Various songs vol 1</p>
                <p>Sierra Kusterbeck, Blake Harnage, Anthony Martone, Devin Ingelido, Jerry Pierce</p>
                <p class="clsType"><a href="#">Dance,</a> <a href="#">Rock,</a> <a href="#">Mash up</a></p>
                <div><img src="{$CFG.site.url}music/design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/icon-activerate.gif" />
                <img src="{$CFG.site.url}music/design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/icon-activerate.gif" />
                <img src="{$CFG.site.url}music/design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/icon-activerate.gif" />
                <img src="{$CFG.site.url}music/design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/icon-inactiverate.gif" />
                <img src="{$CFG.site.url}music/design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/icon-inactiverate.gif" /></div>
            </div>
            <div class="clsPlayerImage">
                <img src="http://atche-s032.ahsan.in/murugesan/svn/rayzz_3/branches/videos/music/design/templates/default/root/images/screen_grey/icon-audio.gif"/>   
                <p class="clsQuickMix"><a href="#" class="clsQuickMix-off">QuickMIX</a></p>     
            </div>
        </div>
    </div>
    <div class="clsListContents">
        <div class="clsOverflow">
            <p class="clsListCheckBox"><input name="" type="checkbox" value="" /></p>
            <div class="clsThumb">
                <div class="clsLargeThumbImageBackground">
                   <p class="ClsImageContainer ClsImageBorder1 Cls132x88" onclick="">
						<img src="{$CFG.site.url}music/design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/dummy-images/img1.jpg" />
					</p>
                </div>
                <div class="clsTime">00:15</div>
            </div>
            <div class="clsContentDetails">
                <p class="clsHeading"><a href="#">Lil - Mama lip gloss</a></p>
                <p class="clsBold">Various songs vol 1</p>
                <p>Sierra Kusterbeck, Blake Harnage, Anthony Martone, Devin Ingelido, Jerry Pierce</p>
                <p class="clsType"><a href="#">Dance,</a> <a href="#">Rock,</a> <a href="#">Mash up</a></p>
                <div><img src="{$CFG.site.url}music/design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/icon-activerate.gif" />
                <img src="{$CFG.site.url}music/design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/icon-activerate.gif" />
                <img src="{$CFG.site.url}music/design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/icon-activerate.gif" />
                <img src="{$CFG.site.url}music/design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/icon-inactiverate.gif" />
                <img src="{$CFG.site.url}music/design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/icon-inactiverate.gif" /></div>
            </div>
            <div class="clsPlayerImage">
                <img src="http://atche-s032.ahsan.in/murugesan/svn/rayzz_3/branches/videos/music/design/templates/default/root/images/screen_grey/icon-audio.gif"/>   
                <p class="clsQuickMix"><a href="#" class="clsQuickMix-off">QuickMIX</a></p>     
            </div>
        </div>
        <div class="clsMoreInfoContainer clsOverflow">
        	<div class="clsMoreInformation"><p><a href="#"><span>More Info</span></a></p></div>
        </div>
    </div>
    <div class="clsListContents">
        <div class="clsOverflow">
            <p class="clsListCheckBox"><input name="" type="checkbox" value="" /></p>
            <div class="clsThumb">
                <div class="clsLargeThumbImageBackground">
                   <div class="ClsImageContainer ClsImageBorder1 Cls132x88" onclick="">
                       <img src="{$CFG.site.url}music/design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/dummy-images/img1.jpg" />
                    </div>
                </div>
                <div class="clsTime">00:15</div>
            </div>
            <div class="clsContentDetails">
                <p class="clsHeading"><a href="#">Lil - Mama lip gloss</a></p>
                <p class="clsBold">Various songs vol 1</p>
                <p>Sierra Kusterbeck, Blake Harnage, Anthony Martone, Devin Ingelido, Jerry Pierce</p>
                <p class="clsType"><a href="#">Dance,</a> <a href="#">Rock,</a> <a href="#">Mash up</a></p>
                <div><img src="{$CFG.site.url}music/design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/icon-activerate.gif" />
                <img src="{$CFG.site.url}music/design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/icon-activerate.gif" />
                <img src="{$CFG.site.url}music/design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/icon-activerate.gif" />
                <img src="{$CFG.site.url}music/design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/icon-inactiverate.gif" />
                <img src="{$CFG.site.url}music/design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/icon-inactiverate.gif" /></div>
            </div>
            <div class="clsPlayerImage">
                <img src="http://atche-s032.ahsan.in/murugesan/svn/rayzz_3/branches/videos/music/design/templates/default/root/images/screen_grey/icon-audio.gif"/>   
                <p class="clsQuickMix"><a href="#" class="clsQuickMix-off">QuickMIX</a></p>     
            </div>
        </div>
        <div class="clsMoreInfoContainer clsOverflow">
        	<div class="clsMoreInformation"><p><a class="clsActive" href="#"><span>More Info</span></a></p></div>
            <div class="clsMoreInfoContent clsOverflow">
            	<div class="clsMoreInfoContent-l">
                	<div>
                    	<p class="clsLeft">By</p>
                        <p class="clsRight">Webmaster</p>
                    </div>
                	<div>
                    	<p class="clsLeft">Plays</p>
                        <p class="clsRight">1252</p>
                    </div>
                	<div>
                    	<p class="clsLeft">Favorited</p>
                        <p class="clsRight">200</p>
                    </div>
                </div>
                <div class="clsMoreInfoContent-r">
                	<div>
                    	<p class="clsLeft">Added</p>
                        <p class="clsRight">30 days ago</p>
                    </div>
                	<div>
                    	<p class="clsLeft">Commented</p>
                        <p class="clsRight">23</p>
                    </div>
                	<div>
                    	<p class="clsLeft">Ratted</p>
                        <p class="clsRight"><a href="#">200</a></p>
                    </div>
                </div>
            	<p class="clsTags" style="clear:both;">Tags: <a href="#">rock</a> <a href="#" class="clsAlternate">rocknroll</a> <a href="#">soulfusion</a> <a href="#" class="clsAlternate">techno</a> <a href="#">trance</a></p>
            </div>
        </div>
    </div>
    <div class="clsAudioPaging">
        <div class="clsPagingList">
          <ul>
            <!-- Previous link -->
            <li class="clsInactivePrevLinkPage clsInActivePageLink">First</li>
            <!-- First link -->
            <li class="clsFirstPageLink clsInActivePageLink">Previous</li>
            <!-- paging list start -->
            <li class="clsCurrPageLink clsInActivePageLink">1</li>
            <li class="clsPagingLink"><a href="#">2</a></li>
            <li class="clsPagingLink"><a href="#">3</a></li>
            <!-- pagin list end -->
            <!-- Last Link -->
            <li class="clsLastPageLink"><a href="#">Next</a></li>
            <!-- Next link -->
            <li class="clsNextPageLink"><a href="#">Last</a></li>
          </ul>
        </div>
    </div>
    <div class="clsAlphabeticPagination">
      <ul>
        <li class="clsActive"><a href="#">A</a></li>
        <li><a href="#">B</a></li>
        <li><a href="#">C</a></li>
        <li><a href="#">D</a></li>
        <li><a href="#">E</a></li>
        <li><a href="#">F</a></li>
        <li><a href="#">G</a></li>
        <li><a href="#">H</a></li>
        <li><a href="#">I</a></li>
        <li><a href="#">J</a></li>
        <li><a href="#">K</a></li>
        <li><a href="#">L</a></li>
        <li><a href="#">M</a></li>
        <li><a href="#">N</a></li>
        <li><a href="#">O</a></li>
        <li><a href="#">P</a></li>
        <li><a href="#">Q</a></li>
        <li><a href="#">R</a></li>
        <li><a href="#">S</a></li>
        <li><a href="#">T</a></li>
        <li><a href="#">U</a></li>
        <li><a href="#">V</a></li>
        <li><a href="#">W</a></li>
        <li><a href="#">X</a></li>
        <li><a href="#">Y</a></li>
        <li class="clsLastData"><a href="#">Z</a></li>
      </ul>
    </div>
</div>
{$myobj->setTemplateFolder('general/', 'music')}
{include file="box.tpl" opt="audioindex_bottom"} 