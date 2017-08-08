<div class="clsViewAudioPage">

{* VIEW AUDIO PAGE LEFT SIDE SECTION STARTS *}
<div class="clsViewAudioLeft">

    {* AUDIO DETAILS SECTION STARTS *}
		{$myobj->setTemplateFolder('general/', 'music')}
        {include file="box.tpl" opt="audioindex_top"}
        	<div class="clsAudioDetailsSection">
            	<h3 class="clsH3Heading">Audio Details</h3>
           		<div class="clsAudioDetailsSection-left">
                    <div class="cls90PXthumbImage clsThumbImageOuter clsAudioDetailsSectionImage">
                        <div class="clsrThumbImageMiddle">
                            <div class="clsThumbImageInner">
                                <img src="{$CFG.site.url}music/design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/dummy-images/img12.jpg" />
                            </div>
                        </div>
                    </div>
                	<p><span>Added by</span><br />
                	<span class="clsNameLink"><a href="#">Margie Jones</a></span></p>
                	<p class="clsEditThisAudio"><a href="#">Edit this Audio</a></p>                
                </div>
                <div class="clsAudioDetailsSection-right">
                	<div class="clsShareThis">
                    	<a href="#"><img src="{$CFG.site.url}music/design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/icon-share.jpg" /></a>
                    </div>
                	<p><span>Date - </span>3rd July</p>
                	<p><span>Playing time - </span>00:02:00</p>
                    <p class="clsType"><span>Genre - </span><a href="#">Rock</a> / <a href="">PowerPop</a> / <a href="#">Poppunk</a></p>
                	<p><span>Audios by this user - </span>142</p>
                    <div class="clsUrlTextBox">Audio Url <input name="" type="text" /></div>
                    <div class="clsUrlTextBox">Embedded Player <input name="" type="text" /></div>
                </div>	
            </div>
		{$myobj->setTemplateFolder('general/', 'music')}
        {include file="box.tpl" opt="audioindex_bottom"}
    {* AUDIO DETAILS SECTION ENDS *}

    {* STATISTICS SECTION STARTS *}
		{$myobj->setTemplateFolder('general/', 'music')}
        {include file="box.tpl" opt="audioindex_top"}
        	<div class="clsStatisticsContent">
            	<h3 class="clsH3Heading">Statistics</h3>
                <div class="clsTwoColumnTable">
                	<table>
                    	<tr>
                        	<td class="clsLabel">Title</td>
                            <td class="clsHeading">- The Best of Micheal Jackson</td>
                        </tr>
                    	<tr>
                        	<td class="clsLabel">Album</td>
                            <td class="clsBold">- Breaking and Entering</td>
                        </tr>
                    	<tr>
                        	<td class="clsLabel">Artist</td>
                            <td>- Anthony marton, devin ingelido, jerry pierce</td>
                        </tr>
                    	<tr>
                        	<td class="clsLabel">Genres</td>
                            <td class="clsType">- <a href="#">Rock</a> / <a href="">PowerPop</a> / <a href="#">Poppunk</a></td>
                        </tr>
                    	<tr>
                        	<td class="clsLabel">Rated</td>
                            <td>- 20</td>
                        </tr>
                    	<tr>
                        	<td class="clsLabel">Favourited</td>
                            <td>- 5</td>
                        </tr>
                    	<tr>
                        	<td class="clsLabel">Commented</td>
                            <td>- 56</td>
                        </tr>
                    </table>
                </div>
            </div>
		{$myobj->setTemplateFolder('general/', 'music')}
        {include file="box.tpl" opt="audioindex_bottom"}
    {* STATISTICS SECTION ENDS *}
    
    {* ----------------------Audio section Starts ---------------------- *}        
		{include file="box.tpl" opt="audioindex_top"}
        	<div class="clsIndexAudioContainer">
            
            	<div class="clsIndexAudioHeading">
                	<h3>More Audios</h3>
                    <div class="clsAudioCarouselPaging">
                      <ul>
                        <li><a class="clsPreviousDisable" href="#">Previous</a></li>
                        <li><a class="clsNext" href="#">Next</a></li>
                      </ul>
                    </div>
                </div>
                
                <div class="clsAudioListMenu">
                	<ul>
                    	<li class="clsActive"><a href="#"><span>User</span></a></li>
                    	<li><a href="#"><span>Related</span></a></li>
                    	<li><a href="#"><span>Top</span></a></li>
                    	<li><a href="#"><span>Artist</span></a></li>
                    </ul>
                </div>
                
                <div class="clsSideCaroselContainer">
                
                	{* ------content starts----- *}
                    <div class="clsViewPageSideContainer">
                        <div class="clsViewPageSideImage">
                            <div class="clsThumbImageLink clsThumbImageBackground">
                                <div onclick="" class="cls76PXthumbImage clsThumbImageOuter">
                                    <div class="clsrThumbImageMiddle">
                                        <div class="clsThumbImageInner">
                                            <img src="{$CFG.site.url}music/design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/dummy-images/img1.jpg"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="clsViewPageSideContent">
                            <p class="clsName"><a href="#">Danger is my name</a></p>
                            <p>From : <span><a href="#">Webmaster</a></span></p>
                            <p>Plays : 1200</p>
                        </div>
                    </div>
                	{* ------content ends----- *}
                    
                	{* ------content starts----- *}
                    <div class="clsViewPageSideContainer">
                        <div class="clsViewPageSideImage">
                            <div class="clsThumbImageLink clsThumbImageBackground">
                                <div onclick="" class="cls76PXthumbImage clsThumbImageOuter">
                                    <div class="clsrThumbImageMiddle">
                                        <div class="clsThumbImageInner">
                                            <img src="{$CFG.site.url}music/design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/dummy-images/img1.jpg"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="clsViewPageSideContent">
                            <p class="clsName"><a href="#">Danger is my name</a></p>
                            <p>From : <span><a href="#">Webmaster</a></span></p>
                            <p>Plays : 1200</p>
                        </div>
                    </div>
                	{* ------content ends----- *}
                    
                	{* ------content starts----- *}
                    <div class="clsViewPageSideContainer">
                        <div class="clsViewPageSideImage">
                            <div class="clsThumbImageLink clsThumbImageBackground">
                                <div onclick="" class="cls76PXthumbImage clsThumbImageOuter">
                                    <div class="clsrThumbImageMiddle">
                                        <div class="clsThumbImageInner">
                                            <img src="{$CFG.site.url}music/design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/dummy-images/img1.jpg"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="clsViewPageSideContent">
                            <p class="clsName"><a href="#">Danger is my name</a></p>
                            <p>From : <span><a href="#">Webmaster</a></span></p>
                            <p>Plays : 1200</p>
                        </div>
                    </div>
                	{* ------content ends----- *}
                    
                	{* ------content starts----- *}
                    <div class="clsViewPageSideContainer clsViewPageSideFinalContainer">
                        <div class="clsViewPageSideImage">
                            <div class="clsThumbImageLink clsThumbImageBackground">
                                <div onclick="" class="cls76PXthumbImage clsThumbImageOuter">
                                    <div class="clsrThumbImageMiddle">
                                        <div class="clsThumbImageInner">
                                            <img src="{$CFG.site.url}music/design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/dummy-images/img1.jpg"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="clsViewPageSideContent">
                            <p class="clsName"><a href="#">Danger is my name</a></p>
                            <p>From : <span><a href="#">Webmaster</a></span></p>
                            <p>Plays : 1200</p>
                        </div>
                    </div>
                	{* ------content ends----- *}
                    
                </div>
                
            </div>  
		{$myobj->setTemplateFolder('general/', 'music')}
		{include file="box.tpl" opt="audioindex_bottom"}
    {* ----------------------Audio section ends ---------------------- *}   
    
    {* ----------------------People listened this song section Starts ---------------------- *} 
		{$myobj->setTemplateFolder('general/', 'music')}       
		{include file="box.tpl" opt="audioindex_top"}
        	<div class="clsIndexAudioContainer">
            
            	<div class="clsIndexAudioHeading">
                	<h3>People Listened This Song</h3>
                    <div class="clsAudioCarouselPaging">
                      <ul>
                        <li><a class="clsPreviousDisable" href="#">Previous</a></li>
                        <li><a class="clsNext" href="#">Next</a></li>
                      </ul>
                    </div>
                </div>
                
                <div class="clsSideCaroselContainer">
                
                	{* ------content starts----- *}
                    <div class="clsViewPageSideContainer">
                        <div class="clsViewPageSideImage">
                            <div class="clsThumbImageLink clsThumbImageBackground">
                                <div onclick="" class="cls76PXthumbImage clsThumbImageOuter">
                                    <div class="clsrThumbImageMiddle">
                                        <div class="clsThumbImageInner">
                                            <img src="{$CFG.site.url}music/design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/dummy-images/img1.jpg"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="clsViewPageSideContent">
                            <p class="clsName"><a href="#">Danger is my name</a></p>
                            <p>Dear Mariea count me in</p>
                            <p>Plays : 1200</p>
                        </div>
                    </div>
                	{* ------content ends----- *}
                    
                	{* ------content starts----- *}
                    <div class="clsViewPageSideContainer">
                        <div class="clsViewPageSideImage">
                            <div class="clsThumbImageLink clsThumbImageBackground">
                                <div onclick="" class="cls76PXthumbImage clsThumbImageOuter">
                                    <div class="clsrThumbImageMiddle">
                                        <div class="clsThumbImageInner">
                                            <img src="{$CFG.site.url}music/design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/dummy-images/img1.jpg"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="clsViewPageSideContent">
                            <p class="clsName"><a href="#">Danger is my name</a></p>
                            <p>Dear Mariea count me in</p>
                            <p>Plays : 1200</p>
                        </div>
                    </div>
                	{* ------content ends----- *}
                    
                	{* ------content starts----- *}
                    <div class="clsViewPageSideContainer">
                        <div class="clsViewPageSideImage">
                            <div class="clsThumbImageLink clsThumbImageBackground">
                                <div onclick="" class="cls76PXthumbImage clsThumbImageOuter">
                                    <div class="clsrThumbImageMiddle">
                                        <div class="clsThumbImageInner">
                                            <img src="{$CFG.site.url}music/design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/dummy-images/img1.jpg"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="clsViewPageSideContent">
                            <p class="clsName"><a href="#">Danger is my name</a></p>
                            <p>Dear Mariea count me in</p>
                            <p>Plays : 1200</p>
                        </div>
                    </div>
                	{* ------content ends----- *}
                    
                	{* ------content starts----- *}
                    <div class="clsViewPageSideContainer clsViewPageSideFinalContainer">
                        <div class="clsViewPageSideImage">
                            <div class="clsThumbImageLink clsThumbImageBackground">
                                <div onclick="" class="cls76PXthumbImage clsThumbImageOuter">
                                    <div class="clsrThumbImageMiddle">
                                        <div class="clsThumbImageInner">
                                            <img src="{$CFG.site.url}music/design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/dummy-images/img1.jpg"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="clsViewPageSideContent">
                            <p class="clsName"><a href="#">Danger is my name</a></p>
                            <p>From : <span><a href="#">Webmaster</a></span></p>
                            <p>Plays : 1200</p>
                        </div>
                    </div>
                	{* ------content ends----- *}
                    
                </div>
                
            </div>  
		{$myobj->setTemplateFolder('general/', 'music')}
		{include file="box.tpl" opt="audioindex_bottom"}
    {* ----------------------People listened this song section ends ---------------------- *}
    

    <div class="clsViewAudioSideBanner">
        <img src="{$CFG.site.url}music/design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/dummy-images/sidebanner.gif" />
    </div>
    
</div>
{* VIEW AUDIO PAGE LEFT SIDE SECTION ENDS *}

{* VIEW AUDIO PAGE RIGHT SIDE SECTION STARTS *}
<div class="clsViewAudioRight">

    {* AUDIO DETAILS SECTION STARTS *}
	{$myobj->setTemplateFolder('general/', 'music')}
    {include file="box.tpl" opt="playlist_top"}
            <div class="clsFeaturedPlaylistContainer clsPlaylistPlayerContainer">
            	<h3>Currently Playing</h3>
                <div class="clsPlayerContainer">
                	<img src="{$CFG.site.url}music/design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/dummy-images/playlist.jpg" />
                </div>
            </div>
		{$myobj->setTemplateFolder('general/', 'music')}
        {include file="box.tpl" opt="playlist_bottom"}
    {* AUDIO DETAILS SECTION ENDS *}

    {* Playlist, Share, favourites, flag.. section starts *}
	{$myobj->setTemplateFolder('general/', 'music')}
    {include file="box.tpl" opt="viewaudio_top"}
            <div class="clsAudioLinksContainer">
            	<div class="clsViewAudioLinks">
                	<ul>
                    	<li class="clsFirstLink"><a class="playlist" href="#"><span>Playlist</span></a></li>
                    	<li><a class="shareaudio" href="#"><span>Share Audio</span></a></li>
                    	<li><a class="favorites" href="#"><span>Favorites</span></a></li>
                    	<li><a class="flag" href="#"><span>Flag</span></a></li>
                    	<li><a class="feature" href="#"><span>Feature</span></a></li>
                    	<li><a class="addtoblog" href="#"><span>Add to Blog</span></a></li>
                    	<li class="clsLastLink"><a class="lyrics" href="#"><span>Lyrics</span></a></li>
                    </ul>
                </div>
                <div class="clsViewAudioLinksContent" style="height:220px;">  
                </div>
            </div>
		{$myobj->setTemplateFolder('general/', 'music')}
        {include file="box.tpl" opt="viewaudio_bottom"}
    {* Playlist, Share, favourites, flag.. section ends *}

    {* COMMENTS SECTION STARTS *}
		{$myobj->setTemplateFolder('general/', 'music')}
        {include file="box.tpl" opt="audioindex_top"}
        	<div class="clsAudioCommentsContainer">
            	<div class="clsCommentsHeadingContainer">
   	            	<h3 class="clsH3Heading">Comments</h3>
                    <div class="clsComments"><a href="#">Post Commment</a></div>
                </div>
                
                <div class="clsListContents">
                	<p><span class="clsBold">4 Comments</span> on this audio</p>
                </div>
                
                {* COMMENTS STARTS *}
               		<div class="clsListContents">
                	<div class="clsOverflow">
                        <div class="clsCommentThumb">
                            <div class="clsThumbImageLink">
                                <div class="cls45PXthumbImage clsThumbImageOuter" onclick="">
                                    <div class="clsrThumbImageMiddle">
                                        <div class="clsThumbImageInner">
                                            <img src="{$CFG.site.url}music/design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/dummy-images/img15.gif" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="clsCommentDetails">
                            <p class="clsCommentedBy"><span>Shankar</span> commented</p>
                            <p>What the hell how am i suppose to enjoy now</p>
                            <p class="clsAddedTime">5 hrs ago</p>
                        </div>
                    </div>
                    
                    <div class="clsButtonHolder">
                    	<p class="clsReplyButton"><span>Reply</span></p>
                    </div>
                        {* Reply section starts *}
                        <div class="clsMoreInfoContent clsOverflow">
                            <div class="clsMoreInfoComment">
             					<div class="clsOverflow">
                                    <div class="clsCommentThumb">
                                        <div class="clsThumbImageLink">
                                            <div class="cls45PXthumbImage clsThumbImageOuter" onclick="">
                                                <div class="clsrThumbImageMiddle">
                                                    <div class="clsThumbImageInner">
                                                        <img src="{$CFG.site.url}music/design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/dummy-images/img14.gif" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="clsCommentDetails">
                                        <p class="clsCommentedBy"><span>Karthickselvam</span> replied</p>
                                        <p>shall i teach now</p>
                                        <p class="clsAddedTime">4:55 hrs ago</p>
                                    </div>
                                </div>
                            </div>
                       		<div class="clsButtonHolder">
                            	<p class="clsEditButton"><span>Edit</span></p>
                            	<p class="clsDeleteButton"><span>Delete</span></p>
                            </div>
                        </div>
                        {* Reply section ends *}
                        
                        {* Reply section starts *}
                        <div class="clsMoreInfoContent clsOverflow">
                            <div class="clsMoreInfoComment">
             					<div class="clsOverflow">
                                    <div class="clsCommentThumb">
                                        <div class="clsThumbImageLink">
                                            <div class="cls45PXthumbImage clsThumbImageOuter" onclick="">
                                                <div class="clsrThumbImageMiddle">
                                                    <div class="clsThumbImageInner">
                                                        <img src="{$CFG.site.url}music/design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/dummy-images/img14.gif" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="clsCommentDetails">
                                        <p class="clsCommentedBy"><span>Karthickselvam</span> replied</p>
                                        <p>shall i teach now</p>
                                        <p class="clsAddedTime">4:55 hrs ago</p>
                                    </div>
                                </div>
                            </div>
                       		<div class="clsButtonHolder">
                            	<p class="clsEditButton"><span><a href="#">Edit</a></span></p>
                            	<p class="clsDeleteButton"><span>Delete</span></p>
                            </div>
                        </div>
                        {* Reply section ends *}
                        
                    </div>
                {* COMMENTS ENDS *}
                
            	{* COMMENTS STARTS *}
                	<div class="clsListContents">
                	<div class="clsOverflow">
                        <div class="clsCommentThumb">
                            <div class="clsThumbImageLink">
                                <div class="cls45PXthumbImage clsThumbImageOuter" onclick="">
                                    <div class="clsrThumbImageMiddle">
                                        <div class="clsThumbImageInner">
                                            <img src="{$CFG.site.url}music/design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/dummy-images/img15.gif" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="clsCommentDetails">
                            <p class="clsCommentedBy"><span>Shankar</span> commented</p>
                            <p>What the hell how am i suppose to enjoy now</p>
                            <p class="clsAddedTime">5 hrs ago</p>
                        </div>
                    </div>
                    
                    <div class="clsButtonHolder">
                    	<p class="clsReplyButton"><span>Reply</span></p>
                    </div>                        
                    </div>
                {* COMMENTS ENDS *}
                
            	{* COMMENTS STARTS *}
            		<div class="clsListContents">
                	<div class="clsOverflow">
                        <div class="clsCommentThumb">
                            <div class="clsThumbImageLink">
                                <div class="cls45PXthumbImage clsThumbImageOuter" onclick="">
                                    <div class="clsrThumbImageMiddle">
                                        <div class="clsThumbImageInner">
                                            <img src="{$CFG.site.url}music/design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/dummy-images/img15.gif" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="clsCommentDetails">
                            <p class="clsCommentedBy"><span>Shankar</span> commented</p>
                            <p>What the hell how am i suppose to enjoy now</p>
                            <p class="clsAddedTime">5 hrs ago</p>
                        </div>
                    </div>
                    
                    <div class="clsButtonHolder">
                    	<p class="clsReplyButton"><span>Reply</span></p>
                    </div>                        
                    </div>
                {* COMMENTS ENDS *}
                
            	{* COMMENTS STARTS *}
            		<div class="clsListContents">
                	<div class="clsOverflow">
                        <div class="clsCommentThumb">
                            <div class="clsThumbImageLink">
                                <div class="cls45PXthumbImage clsThumbImageOuter" onclick="">
                                    <div class="clsrThumbImageMiddle">
                                        <div class="clsThumbImageInner">
                                            <img src="{$CFG.site.url}music/design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/dummy-images/img15.gif" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="clsCommentDetails">
                            <p class="clsCommentedBy"><span>Shankar</span> commented</p>
                            <p>What the hell how am i suppose to enjoy now</p>
                            <p class="clsAddedTime">5 hrs ago</p>
                        </div>
                    </div>
                    
                    <div class="clsButtonHolder">
                    	<p class="clsReplyButton"><span>Reply</span></p>
                    </div>                        
                    </div>
                {* COMMENTS ENDS *}
                              
           </div>
		{$myobj->setTemplateFolder('general/', 'music')}
        {include file="box.tpl" opt="audioindex_bottom"}
    {* COMMENTS SECTION STARTS *}
    
    {* BOTTOM BANNER STARTS *}
    	<div class="clsViewAudioBottomBanner">
        	<img src="{$CFG.site.url}music/design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/dummy-images/banner.gif" />
        </div>
    {* BOTTOM BANNER ENDS *}
    
</div>
{* VIEW AUDIO PAGE RIGHT SIDE SECTION ENDS *}

</div>