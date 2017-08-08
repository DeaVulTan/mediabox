									<div id="articlePageContent">

                                     {* ****** Showing Previous and Next arrows  ******** *}
                                       {if $displayArticle_arr.page_break}
                                        <div class="clsOverflow clsArticleInnerHeader">
                                            <div class="clsViewHeader" id="displayPageTitle">
                                                <h3></h3>
                                            </div>
                                            <p class="clsViewArticlePrevNext">
                                            {if $displayArticle_arr.disable_prev_link}
                                               <a href="javascript:void(0)" onClick="return getArticleContent('{$displayArticle_arr.previous_link}&ajax_page=true', '')" class="clsPrev" title="{$LANG.viewarticle_previous}">
                                                 {$LANG.viewarticle_prev}
                                               </a>
                                            {/if}
                                            {if $displayArticle_arr.disable_next_link}
                                                <a href="javascript:void(0)" onClick="return getArticleContent('{$displayArticle_arr.next_link}&ajax_page=true', '')" class="clsNext" title="{$LANG.viewarticle_next}">
                                                    {$LANG.viewarticle_next}
                                                </a>
                                            {/if}
                                            </p>
                                        </div>
                                       {/if}
                                    {* ****** End of Showing Previous and Next arrows  ******** *}

                                    {* ****** Page tile if page break exist ****** *}
                                      {if $displayArticle_arr.page_break}
                                        <h4 id="displayPageTitle"></h4><br/>
                                      {/if}
                                     {* ****** End of Page tile if page break exist ****** *}

                                    {* ****** Article content starts ******** *}
                                    <div class="clsViewArticleImage clsOverflow">
                                    {* ****** Showing the content ******** *}
                                    <p>{$displayArticle_arr.article_caption}</p>
                                    </div>

                                    </div>
