{if $index_block_settings_arr.RandomVideo == 'sidebar'}
<div class="clsMainBlockCNContainer">
{/if}


{*if $newPeopleIndexObj->peopleList_arr!=0}
<div class="clsMainBlockCoolNewPeople">
{literal}
<script type="text/javascript">
{/literal}
{$carousel_items_list}
{literal}

function mycarousel_initCallback(carousel)
	{
		  carousel.clip.hover(function() {
			    carousel.stopAuto();
		  }, function() {
			    carousel.startAuto();
		  });
	};

function mycarousel_itemVisibleInCallback(carousel, item, i, state, evt)
	{
		mycarousel_initCallback(carousel);
		// The index() method calculates the index from a
		// given index who is out of the actual item range.
		var idx = carousel.index(i, mycarousel_itemList.length);
		carousel.add(i, mycarousel_getItemHTML(mycarousel_itemList[idx - 1]));
	};

function mycarousel_itemVisibleOutCallback(carousel, item, i, state, evt)
	{
		carousel.remove(i);
	};

/**
 * Item html creation helper.
 */
function mycarousel_getItemHTML(item)
	{
		return '<div class="clsCoolMemberThumbImageContainer"><div class="clsThumbImageLink clsPointer" onclick="Redirect2URL(\'' + item.memUrl + '\')"><div class="cls90PXthumbImage clsThumbImageOuter"><div class="clsrThumbImageMiddle"><div class="clsThumbImageInner"><img src="' + item.url + '" alt="' + item.title + '" /></div></div></div></div><div class="clsCoolMemberThumbImageTitle"><p><a href="' + item.memUrl + '" title="' + item.title + '">' + item.wrap_name + '</a></p></div>';
	};

{/literal}
{if $newPeopleIndexObj->peopleList_arr|@count <6}
{literal}
$Jq(document).ready(function() {
    $Jq('#cool_new_peoples').jcarousel({
	  easing: 'linear',
        animation: 1000,
	 size: {/literal}{$newPeopleIndexObj->peopleList_arr|@count}{literal},
	itemVisibleInCallback: {onBeforeAnimation: mycarousel_itemVisibleInCallback},
	itemVisibleOutCallback: {onAfterAnimation: mycarousel_itemVisibleOutCallback}
    });
});
{/literal}
{else}
{literal}

  $Jq(document).ready(function() {
     $Jq('#cool_new_peoples').jcarousel({
        wrap: 'circular',
	  easing: 'linear',
	  auto: 3,
        animation: 1000,
	itemVisibleInCallback: {onBeforeAnimation: mycarousel_itemVisibleInCallback},
	itemVisibleOutCallback: {onAfterAnimation: mycarousel_itemVisibleOutCallback}
    });
 });

{/literal}

{/if}
{literal}

</script>
{/literal}

<div style="display:block;">{include file='box.tpl' opt='coolnewpeople_top'}
<h2 class="clsSideHeading clsTitleCoolNewPeople">{$LANG.index_title_cool_new_people}{$LANG.index_title_cool_new_people_title}</h2>
<div class="clsCoolNewPeople">
    <div class="">
    {if $newPeopleIndexObj->peopleList_arr!=0}
      <ul id="cool_new_peoples" class="jcarousel-skin-coolnewpeople">
      </ul>
    {/if} {* $newPeopleIndexObj->peopleList_arr condition end *}
    </div>
</div>
{include file='box.tpl' opt='coolnewpeople_bottom'} 
</div>
</div>

{if $index_block_settings_arr.RandomVideo == 'sidebar'}
<div class="clsMainBlockTopContributor">
      {$header->populateTopContributorsRightNavigation()}
</div>
{/if}

{if $index_block_settings_arr.RandomVideo == 'sidebar'}
</div>
 <div class="clsIndexCenterBanner">
    </div>
{/if}
{*/if*}