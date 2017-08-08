function unhighlightMoreTabsDivs(current_div)
	{
		for(var i=0; i<more_tabs_div.length; i++)
			{
				if(more_tabs_div[i] != current_div)
					{
						$Jq('#'+more_tabs_class[i]).css('class', '');
						//setClass(more_tabs_class[i],'');
					}
			}
	}

function highlightMoreTabsDivs(current_div)
	{
		for(var i=0; i<more_tabs_div.length; i++)
			{
				if(more_tabs_div[i] == current_div)
					{
						$Jq('#'+more_tabs_class[i]).addClass(current_active_tab_class);
						break;
					}
			}
	}

function getMoreContent(path, div_id, current_li_id)
	{
		var div_value = document.getElementById(div_id).innerHTML;
		result_div = div_id;
		more_li_id = current_li_id;
		div_value = $Jq.trim(div_value);
		if(div_value == '')
			{
				hideMoreTabsDivs(div_id);
				showMoreTabsDivs(div_id);
				document.getElementById(div_id).innerHTML = '<div class="loader" align="center">&nbsp;</div>';
				$Jq.post(path, insertMoreTabsContent);

			}
		else
			{
				hideMoreTabsDivs(div_id);
				showMoreTabsDivs(div_id);
			}
	}

function insertMoreTabsContent(data)
	{
		data = unescape(data);
		$Jq('#'+result_div).html(data);
	}

/*** removeFriendSuggestion functions start ***/
var mycarousel_itemList_id_arr = new Array();
function getLiElementListAsArray(ul_id)
	{
		var mycarousel_itemList = $Jq('#'+ul_id).children('li');
		mycarousel_itemList_data_arr = new Array();
		mycarousel_itemList_id_arr = new Array();

		var inc= 0;
		mycarousel_itemList.each(function() {
			if(this.id){
				mycarousel_itemList_id_arr[inc] = this.id;
				mycarousel_itemList_data_arr[inc] = this.innerHTML;
				$Jq('#'+this.id).remove();
				inc++
			}
		});
		if(inc==0){
			mycarousel_itemList_id_arr[inc] = this.id;
			mycarousel_itemList_data_arr[inc] = no_friendSuggestions_msg;
		}
		return mycarousel_itemList_data_arr;
	}

var carouselFriendSuggestions_itemLoadCallback = function(){
	var carousel = arguments[0];
	var mycarousel_itemList = getLiElementListAsArray('carouselFriendSuggestions');
	carousel.reset();
	carousel.size(mycarousel_itemList.length);
	for ( var i=0; i< mycarousel_itemList.length;i++ ){
		if (carousel.has(i)) {
            continue;
        }
        if (i > mycarousel_itemList.length) {
            break;
        }
        var e = carousel.add(i, mycarousel_itemList[i]);
        e.attr('id', mycarousel_itemList_id_arr[i]);
	}
	return false;
}

var removeFriendSuggestion = function(path, suggestion_id){
	var path = callBackArguments[0];
	var suggestion_id = callBackArguments[1];

	$Jq('#suggestion_'+suggestion_id).remove();
	var carousel = jQuery('#carouselFriendSuggestions').data('jcarousel');
	carouselFriendSuggestions_itemLoadCallback(carousel);
	path = path + '&action=friend_suggestion&suggestion_id='+ suggestion_id;

	var pars = '';
	$Jq.ajax({
			type: "POST",
			url: path,
			data: pars
		 });
}
/*** removeFriendSuggestion functions End ***/