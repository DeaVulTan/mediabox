var playlistPopupWindow = null;
var playlistPopupWindow2 = null;
var quickMixPopupWindow = null;
var viewCartWindow = null;
var managePlaylistPopupWindow=null;
//Used to update quickMIX in session function
var curr_quick_mix_music_id;
//Used to get music details
var quick_mix_music_id;
//Used to get music details
var quick_mix_music_id_arr = new Array();
var total_musics_ids_play_arr = new Array();
var playlist_music_id_arr = new Array();
var playlist_music_id;

var total_musics_to_play;
var view_music_content_id;
var index_current_play_block = '';
var index_play_music_id = '';
//For maintaining hidden player music id when called before player is loaded
var hidden_player_music_id = '';
//For maintaining hidden player second argument (arguments[1]) when called before player is loaded
var hidden_player_argument1 = '';
var playlist_player_volume;
var playlist_player_volume_mute_prev = 0;
var playlist_player_volume_mute_cur;
//var view_cart_url = cfg_site_url+'music/viewMusicCart.php';
//var play_quickMix_url = cfg_site_url+'music/playQuickMix.php';
function moreInformation(div_id)
	{
		var ahref_id = div_id.split('_');
		var temp_id = ahref_id[0]+'_ahref_'+ahref_id[1];
		if($Jq('#'+div_id).css('display', 'none'))
			{
				$Jq('#'+temp_id).addClass('clsActive');
				$Jq('#'+div_id).show();
			}
		else
			{
				$Jq('#'+temp_id).removeClass('clsActive');
				$Jq('#'+div_id).hide();
			}
	}
function hideMusicSection(id)
	{
		$Jq('#'+id).hide();
	}
//AJAX PAGING//
function musicPlaylistAjaxPaging(query_string, action)
	{
		if(action == "")
			{
				start = 0;
			}
		else
			{
				startvalue = $Jq('#start').val();
				if(action == 'perv')
					start = parseInt(startvalue) - parseInt(pageing_limit);
				else
					 start = parseInt(startvalue) + parseInt(pageing_limit);
				$Jq('#start').val(start);
			}
		$Jq('#playlistInSongList').html($Jq('#loaderMusics').html());
		var pars = query_string+'&start='+start;
		ajaxpageing_url = relatedUrl+pars;
		new jquery_ajax(ajaxpageing_url, '', 'playlistSonglistBlock');
		return false;
	}

function playlistSonglistBlock(request)
	{
		data = request;
		/*if(data.indexOf(session_check)>=1)
			data = data.replace(session_check_replace,'');*/
		$Jq('#playlistInSongList').html(data);
		//$Jq('playlistSongs_Head').html() = $Jq('playlistSongs_Paging').html();
		//listenBaloon_divAgain();
	}

function showHideMenu(anchor_div_name, open_div_name, open_div_id, total_div_count, current_menu_id)
	{
		/*var total = $Jq(total_div_count).value-1;
		for(i=1;i<= parseInt(total);i++)
			{
				if(open_div_id != i)
					{
						$Jq(anchor_div_name+i).removeClass('clsActiveLink');
						$Jq(open_div_name+i).hide();
					}
			}*/
		if($Jq('#'+open_div_name+open_div_id).css('display') == 'none')
			{
				//$Jq(anchor_div_name+open_div_id).addClass('clsActiveLink');
				$Jq('#'+open_div_name+open_div_id).show();
				$Jq('#'+current_menu_id+open_div_id).removeClass('clsShowSubmenuLinks');
				$Jq('#'+current_menu_id+open_div_id).addClass('clsHideSubmenuLinks');
			}
		else
			{
				//$Jq(anchor_div_name+open_div_id).removeClass('clsActiveLink');
				$Jq('#'+open_div_name+open_div_id).hide();
				$Jq('#'+current_menu_id+open_div_id).removeClass('clsHideSubmenuLinks');
				$Jq('#'+current_menu_id+open_div_id).addClass('clsShowSubmenuLinks');
			}
	}
//CAROSEL JS START//
var populatedTabs = new Array();
var populatedData = new Array();
function showHideMusicTabs(div_id,tabs)
{
	if(tabs == 'audioCarosel')
	{
		div_class = 'clsActive';
		div_array = audio_tabs_divid_array;
	}
	else if(tabs == 'topChartCarosel')
	{
		div_class = 'clsActiveAudioContentLink';
		div_array = topChart_array;
	}

	if($Jq('#'+div_id+'_Head').hasClass(div_class) )
	{
		return true;
	}

	for(inc=0;inc<div_array.length;inc++)
	{
		if(div_array[inc] == div_id)
			continue;
		$Jq('#'+div_array[inc]+'_Content').html(music_ajax_page_loading);
		$Jq('#'+div_array[inc]).hide();
		$Jq('#'+div_array[inc]+'_Head').removeClass(div_class);
		$Jq('#'+div_array[inc]+'_Content').hide();
	}
	$Jq('#'+div_id).show();
    $Jq('#'+div_id+'_Head').addClass(div_class);
    $Jq('#'+div_id+'_Content').show();
    $Jq('#sel'+div_id+'Process').html(music_ajax_page_loading);

    if(tabs == 'audioCarosel')
	{
		sel_carousel_div_content_name = div_id+'_Content';
		populateTabIndex = jQuery.inArray(sel_carousel_div_content_name, populatedTabs);
		if (populateTabIndex == -1)
		{
			new jquery_ajax(music_index_ajax_url, 'block='+div_id ,'displayMusicContent');
		}
		else
		{
			$Jq('#'+sel_carousel_div_content_name).html(populatedData[populateTabIndex]);
		}
	}
	else if(tabs == 'topChartCarosel')
	{
		sel_carousel_top_chart_div_content_name = div_id+'_Content';
		populateTabIndex = jQuery.inArray(sel_carousel_top_chart_div_content_name, populatedTabs);
		if (populateTabIndex == -1)
		{
			new jquery_ajax(music_index_ajax_url, 'topChart='+div_id ,'displayMusicTopChartContent');
		}
		else
		{
			$Jq('#'+sel_carousel_top_chart_div_content_name).html(populatedData[populateTabIndex]);
		}
	}
	return true;
}
function displayMusicContent(data)
{
	data = unescape(data);
	$Jq('#'+sel_carousel_div_content_name).html(data);
	populatedTabs[populatedTabs.length] = sel_carousel_div_content_name;
	populatedData[populatedData.length] = data;
}
function displayMusicTopChartContent(data)
{
	data = unescape(data);
	$Jq('#'+sel_carousel_top_chart_div_content_name).html(data);
	populatedTabs[populatedTabs.length] = sel_carousel_top_chart_div_content_name;
	populatedData[populatedData.length] = data;
}
//CAUROSEL JS END//
// MUSIC ACTIVITY RELATED FUNTION //
var display_activity_div = '';
function loadActivitySetting(divName)
	{
		var temp = '';
		for(knc=0;knc<music_activity_array.length;knc++)
			{
				head_div_id = 'sel'+music_activity_array[knc]+'Activity_Head';
				content_div_id = 'sel'+music_activity_array[knc]+'Activity_Content';
				if(music_activity_array[knc] == divName)
					{
						$Jq('#'+head_div_id).addClass('clsActiveAudioContentLink');
						$Jq('#'+content_div_id).show();
						var pars = '?ajax_page=true&activity_type='+music_activity_array[knc];
						var temp = content_div_id;
					}
				else
					{
						$Jq('#'+head_div_id).removeClass('clsActiveAudioContentLink');
						$Jq('#'+content_div_id).hide();
					}
			}
		// DISPLAY CONTENT //
		var div_content =  $Jq('#'+temp).html();
		if(div_content == '')
			getActivityContent(music_index_ajax_url, pars, temp);
		else
			return false;
	}

function getActivityContent(url, pars, divname)
	{
		display_activity_div = divname;
		$Jq.ajax({
					type: "POST",
					url: url,
					data: pars,
					//beforeSend:displayLoadingImage(),
					success: displayMusicIndexActivity
		 		});
		return false;
	}

function displayMusicIndexActivity(request)
	{
		data = unescape(request);
		$Jq('#'+display_activity_div).html(data);
	}
// END //

var img_src = new Array();
function ratingMusicMouseOver(count, type)
	{
		if(type == 'playlist')
			{
				var hoverimage_name = 'icon-playlistratehover.gif';
				var image_name = 'icon-playlistrate.gif'
			}
		else if(type == 'audio')
			{
				var hoverimage_name = 'icon-audioratehover.gif';
				var image_name = 'icon-audiorate.gif'
			}
		else if(type == 'player')
			{
				var hoverimage_name = 'icon-audioratehover1.gif';
				var image_name = 'icon-audiorate1.gif'
			}
		for(var i=1; i<=count; i++)
			{
				var obj = document.getElementById('img'+i);
				img_src[i] = obj.src;
				obj.src = music_site_url+'design/templates/'+template_default+'/root/images/'+stylesheet_screen_default+'/'+hoverimage_name;
			}
		for(; i<=total_rating_images; i++)
			{
				var obj = document.getElementById('img'+i);
				img_src[i] = obj.src;
				obj.src = music_site_url+'design/templates/'+template_default+'/root/images/'+stylesheet_screen_default+'/'+image_name;
			}
	}

function ratingMusicMouseOut(count)
	{
		for(var i=1; i<=total_rating_images; i++)
			{
				var obj = document.getElementById('img'+i);
				obj.src = img_src[i];
			}
	}
// PLAYLIST FUNCTIONALITY START //
function  managePlaylist(multiCheckValue, url, litle_window_title)// managePlaylist(music_id, url, litle_window_title)
	{
		url = url+'&music_id='+multiCheckValue;

		$Jq.fancybox({
                        'width'				: 880,
                        'height'			: 360,
                        'autoScale'     	: false,
                        'href'              : url,
                        'transitionIn'		: 'none',
                        'transitionOut'		: 'none',
                        'type'				: 'iframe',
                        'title'				: litle_window_title,
                        'centerOnScroll'	: true,
						'titleShow'			: false
                    });

	}

// PLAYLIST FUNCTIONALITY END //

/**
   this function return to Flash ActiveX Object or Plugin depending upon browser
   it takes care for browser type and returns the proper reference.
  Accepts the id or name of <OBJECT> or <EMBED> tag respectively
  Taken from Colin Moock (http://www.moock.org) code base.
**/
function thisMovie(movieName)
	{
	  // IE and Netscape refer to the movie object differently.
	  // This function returns the appropriate syntax depending on the browser.
		if (navigator.appName.indexOf ("Microsoft") !=-1)
			{
				return window[movieName];
			}
		else
			{
				return window.document[movieName];
			}
	}

/** PLAYER RELATED FUNCTIONS STARTS HERE **/

/**
 create an instance of JSFCommunicator, pass the flashMovie's reference
 make sure flash object is loaded when you create this object with parameter otherwise
 you can JSFCommunicator.setMovie(flashMovie) once flash object is loaded
**/
function createJSFCommunicatorObject(playerObj)
	{
		fc = new JSFCommunicator(playerObj);
	}

//Play Song
function playSong(music_id)
	{
		fc.callFunction("_root","js_playSong",[music_id]);
		if(typeof(playlist_player_volume) == 'number')
			setVolume(playlist_player_volume);
	}

//To resume play after song is being paused
var resmueSongPlaying = function()
	{
		if(arguments[0])
	  		{
	  			var music_id = arguments[0];
				$Jq('resume_play_music_icon_'+music_id).hide();
				$Jq('play_playing_music_icon_'+music_id).show();
			}
		fc.callFunction("_root","js_play");
	}

//Add Song
function addSong(music_details)
	{
		fc.callFunction("_root","js_playSelectedSong",[music_details]);
	}

//Pause Song
var pauseSong = function()
	{
	  	if(arguments[0])
	  		{
	  			var music_id = arguments[0];
				$Jq('#'+'play_playing_music_icon_'+music_id).hide();
				$Jq('#'+'resume_play_music_icon_'+music_id).show();
			}
		//fc.callFunction("_root","js_pauseSong");
		fc.callFunction("_root","js_pause")
	}

//Stop Song
var stopSong = function()
	{
	  	if(arguments[0])
	  		{
				if(typeof(volume_slider) != 'undefined' && volume_slider)
					{
						volume_slider.slider("option", "disabled", false);
						$Jq('#'+'volume_container').addClass('clsVolumeDisabled');
						$Jq('#'+'volume_speaker').title = '';
					}
	  			var music_id = arguments[0];
	  			//Clearing Index music id when stop is called
				index_play_music_id = '';
			  	if(arguments[1])
			  		{
						$Jq('#'+arguments[1]+'_play_playing_music_icon_'+music_id).hide();
						$Jq('#'+arguments[1]+'_play_music_icon_'+music_id).show();
						index_play_music_id = '';
					}
				else
					{
						$Jq('#'+'play_playing_music_icon_'+music_id).hide();
						$Jq('#'+'play_music_icon_'+music_id).show();
					}
			}

	  	fc.callFunction("_root","js_stopSong");
	}

//Call playSong and change Play image icons
var playSelectedSong = function()
	{

		music_id = arguments[0];
		//TO PREVENT CHANGING PLAY STATUS BEFORE PLAYER IS LOADED (WHEN PLAY BUTTON IS CLICKED BY THE USER)
		if($Jq('#'+'hidden_player_status').val() == 'no')
			{
				hidden_player_music_id = music_id;
				if(arguments[1])
					hidden_player_argument1 = arguments[1];
				alert_manual(hidden_player_not_loaded);
				return false;
			}
		if(arguments[1])
			{
				if(typeof(volume_slider) != 'undefined' && volume_slider)
					{
						volume_slider.slider("option", "disabled", false);
						$Jq('#'+'volume_container').removeClass('clsVolumeDisabled');
						if(playlist_player_volume == 0)
							{
								$Jq('#'+'volume_speaker').title = LANG_VOLUME_UNMUTE;
							}
						else
							{
								$Jq('#'+'volume_speaker').title = LANG_VOLUME_MUTE;
							}
					}

				index_current_play_block = arguments[1];
				index_play_music_id = music_id;
				changePlayStatusForIndex(music_id, arguments[1]);
				$Jq('#'+arguments[1]+'_play_music_icon_'+music_id).hide();
				$Jq('#'+arguments[1]+'_play_playing_music_icon_'+music_id).show();
				$Jq('#'+arguments[1]+'_play_playing_music_icon_'+music_id).css('display','block');
				playSong(music_id);
			}
		else
			{
				if(typeof(volume_slider) != 'undefined' && volume_slider)
					{
						volume_slider.slider("option", "disabled", false);
						$Jq('#'+'volume_container').removeClass('clsVolumeDisabled');
						if(playlist_player_volume == 0)
							{
								$Jq('#'+'volume_speaker').title = LANG_VOLUME_UNMUTE;
							}
						else
							{
								$Jq('#'+'volume_speaker').title = LANG_VOLUME_MUTE;
							}
					}
				changePlayStatus(music_id);
				$Jq('#'+'play_music_icon_'+music_id).hide();
				$Jq('#'+'play_playing_music_icon_'+music_id).show();
				playSong(parseInt(music_id));
			}
	}

//To change the play status of currently playing songs
function changePlayStatus(music_id)
	{
		//stopSong();  //--No need to call stopSong since song previously playing will be stopped automatically
		for(var i=0; i<total_musics_ids_play_arr.length; i++)
			{
				if(total_musics_ids_play_arr[i] != music_id)
					{
						if($Jq('#'+'play_playing_music_icon_'+total_musics_ids_play_arr[i]) && $Jq('#'+'play_music_icon_'+total_musics_ids_play_arr[i]))
							{
								$Jq('#'+'play_playing_music_icon_'+total_musics_ids_play_arr[i]).hide();
								$Jq('#'+'play_music_icon_'+total_musics_ids_play_arr[i]).show();
							}
					}
			}
 	}

//To change the play status of currently playing songs for MUSIC INDEX PAGE
var changePlayStatusForIndex = function()
	{
		music_id = arguments[0];
		var block_element = arguments[1];
		//stopSong();  //--No need to call stopSong since song previously playing will be stopped automatically
		for(var j=0; j<play_functionalities_arr.length; j++)
			{
				for(var i=0; i<total_musics_ids_play_arr.length; i++)
					{
						//if(total_musics_ids_play_arr[i] != music_id && play_functionalities_arr[j] != block_element)
							{
								//alert(play_functionalities_arr[j]+'_play_playing_music_icon_'+total_musics_ids_play_arr[i]);
								if($Jq('#'+play_functionalities_arr[j]+'_play_playing_music_icon_'+total_musics_ids_play_arr[i])
										&& $Jq('#'+play_functionalities_arr[j]+'_play_music_icon_'+total_musics_ids_play_arr[i]))
									{
										$Jq('#'+play_functionalities_arr[j]+'_play_playing_music_icon_'+total_musics_ids_play_arr[i]).hide();
										$Jq('#'+play_functionalities_arr[j]+'_play_music_icon_'+total_musics_ids_play_arr[i]).show();
									}
							}
					}
			}
 	}

function highlightIndexCurrentMusic()
	{
		if($Jq('#'+index_current_play_block+'_play_playing_music_icon_'+index_play_music_id)
				&& $Jq('#'+index_current_play_block+'_play_music_icon_'+index_play_music_id))
			{
				$Jq('#'+index_current_play_block+'_play_playing_music_icon_'+index_play_music_id).show();
				$Jq('#'+index_current_play_block+'_play_music_icon_'+index_play_music_id).hide();
			}
	}

// To Change the image status after song completed
function playmovie(music_id)
	{
		//Clearing Index music id when stop is called
		index_play_music_id = '';
		if(index_current_play_block != '')
			{
				if($Jq('#'+index_current_play_block+'_play_playing_music_icon_'+music_id) && $Jq('#'+index_current_play_block+'_play_music_icon_'+music_id))
				$Jq('#'+index_current_play_block+'_play_playing_music_icon_'+music_id).hide()
				$Jq('#'+index_current_play_block+'_play_music_icon_'+music_id).show();
			}

		if($Jq('#'+'play_playing_music_icon_'+music_id) && $Jq('play_music_icon_'+music_id))
			{
				$Jq('#'+'play_playing_music_icon_'+music_id).hide()
				$Jq('#'+'play_music_icon_'+music_id).show();
			}
		//For View Profile
		if($Jq('#resume_play_music_icon_'+music_id))
			$Jq('#resume_play_music_icon_'+music_id).hide();
 	}

//FUNCTION WILL BE CALLED AFTER PLAYER GETS LOADED
function playerReady()
	{
		$Jq('#hidden_player_status').val('yes');
		if(hidden_player_music_id != '')
			{
				hideAllBlocks();
				if(hidden_player_argument1 != '')
					setTimeout('playSelectedSong(hidden_player_music_id, hidden_player_argument1)',500);
				else
					setTimeout('playSelectedSong(hidden_player_music_id)', 500);
			}

	}

//FUNCTION TO CHANGE VOLUME
function setVolume(player_volume)
	{
		fc.callFunction("_root","js_setVolume",[player_volume])
	}


/** PLAYER RELATED FUNCTIONS ENDS HERE **/

/** VOLUME CONTROL RELATED FUNCTIONS STARTS HERE **/
function mute_volume()
	{
		if(typeof(volume_slider) != 'undefined' && volume_slider && !$Jq('volume_container').hasClass('clsVolumeDisabled'))
			{
				if(playlist_player_volume_mute_prev == 0)
					{
						$Jq('#volume_speaker').title = LANG_VOLUME_UNMUTE;
					}
				else
					{
						if(playlist_player_volume_mute_prev != 0 && playlist_player_volume_mute_cur != 0)
							playlist_player_volume_mute_prev = 0;
						$Jq('#volume_speaker').title = LANG_VOLUME_MUTE;
					}
				//alert(playlist_player_volume_mute_prev + 'playlist_player_volume_mute_prev');
				//volume_slider.setValue(playlist_player_volume_mute_prev);
				volume_slider.slider("option", "value", playlist_player_volume_mute_prev);
				$Jq('#volume_slider_bg').css('width', $Jq('#volume_slider_handle').css('left'));
			}
	}

function show_volume_help_tip()
	{
		if($Jq('#volume_what_is_this').css('visibility') == 'visible')
			{
				var volume_help_tip = $Jq('#volume_help_tip').get(0);
				var volume_speaker_ele = $Jq('#volume_speaker').get(0);
				var volume_what_is_this_ele = $Jq('#volume_what_is_this').get(0);
				var bg_iframe = $Jq('#selBackgroundIframe').get(0);

				volume_help_tip.css('top',  (getAbsoluteOffsetTop(volume_what_is_this_ele) + volume_help_tip_top_pos + "px"));
				volume_help_tip.css('left', (getAbsoluteOffsetLeft(volume_what_is_this_ele) + volume_help_tip_left_pos + "px"));
				bg_iframe.css('top', (getAbsoluteOffsetTop(volume_what_is_this_ele) + volume_iframe_help_tip_top_pos + "px"));
				bg_iframe.css('left',( getAbsoluteOffsetLeft(volume_what_is_this_ele) + volume_iframe_help_tip_left_pos + "px"));
				//bg_iframe.show();
				volume_help_tip.show();
				bg_iframe.css('width', 215 + "px");
				bg_iframe.css('height', ((volume_help_tip.offsetHeight - 16) + "px"));
				if($Jq('#volume_container').hasClass('clsVolumeDisabled'))
					{
						$Jq('#volume_help_message').html(volume_control_disabled_help_tip);
					}
				else
					{
						$Jq('#volume_help_message').html(volume_control_enabled_help_tip);
					}
				bg_iframe.show();
				volume_help_tip.show();
			}
	}

function hide_volume_help_tip()
	{
		var volume_help_tip = $Jq('#volume_help_tip').get(0);
		var bg_iframe = $Jq('selBackgroundIframe').get(0);
		bg_iframe.hide();
		volume_help_tip.hide();
		hide_what_is_this();
	}
//TO CHANGE MUTE CONTROL AND VOLUME CONTROL BACKGROUND
function toggle_volume_control(value)
	{
		$Jq('#volume_slider_bg').css('width', ($Jq('#volume_slider_handle').css('left')));
		if(value == 0)
			{
				$Jq('#volume_speaker').attr('title', LANG_VOLUME_UNMUTE);
				$Jq('#volume_speaker').removeClass('clsSpeakerOn');
				$Jq('#volume_speaker').addClass('clsSpeakerOff');
			}
		else
			{
				$Jq('#volume_speaker').attr('title', LANG_VOLUME_MUTE);
				playlist_player_volume_mute = value;
				$Jq('#volume_speaker').removeClass('clsSpeakerOff');
				$Jq('#volume_speaker').addClass('clsSpeakerOn');
			}
		if($Jq('volume_container').hasClass('clsVolumeDisabled'))
			{
				$Jq('volume_speaker').attr('title', '');
			}
	}


function show_what_is_this()
	{
		$Jq('volume_what_is_this').css('visibility', 'visible');
	}

function hide_what_is_this()
	{
		$Jq('volume_what_is_this').css('visibility', 'hidden');
	}
/** VOLUME CONTROL RELATED FUNCTIONS ENDS HERE **/

//playInPlayListPlayer
var playInPlayListPlayer =  function()
	{
	   if(arguments[0])
	  		{
	  			var music_id = arguments[0];
				url = play_songs_playlist_player_url+'?music_id='+music_id;
			}

		//if(!playlistPopupWindow || playlistPopupWindow.closed)
			playlistPopupWindow = window.open(url, 'playlistWindow', 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, copyhistory=no, resizable=yes,height=405,width=650,minHeight=405,minWidth=475');
			playlistPopupWindow.focus();
		/*else
			{
				if (window.focus)
					{
						alert('Songs Added');
						playlistPopupWindow.focus();
					}
			}*/
	}

var playlistInPlayListPlayer =  function()
	{
		if(arguments[0])
			{
				var playlist_id = arguments[0];
				url = play_songs_playlist_player_url+'?playlist_id='+playlist_id;
			}

			//if(playlistPopupWindow2 == null || playlistPopupWindow2.closed || playlistPopupWindow2.location != url)
				{
					playlistPopupWindow2 = window.open(url, 'playlistWindow', 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, copyhistory=no, resizable=yes,height=405,width=650,minHeight=405,minWidth=475');
					playlistPopupWindow2.focus();
				}
			/*else
				{
					if (window.focus)
						{
							playlistPopupWindow2.focus();
						}
				}*/
	}

/** -------------------------------------------------------------------- **/
/** QUICKMIX RELATED FUNCTIONS STARTS HERE **/

//quickMixPlayer - To open quickMix player in popup window
var quickMixPlayer =  function()
	{
		if(arguments[0])
	  		{
	  			var music_id = arguments[0];
			}
		url = play_quickMix_url;
		if(quickMixPopupWindow && quick_mix_music_id_arr.length==1)
			quickMixPopupWindow.close();

		if(!quickMixPopupWindow || quickMixPopupWindow.closed)
			{
				quickMixPopupWindow = window.open(url, 'quickMixWindow', 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, copyhistory=no, resizable=yes,height=405,width=980,minHeight=405,minWidth=475');
			}
		else
			{
				if(!music_id)
					quickMixPopupWindow.focus();
				if(music_id.indexOf(',') != -1)
					{
						var multi_quick_mix_music_id_arr = music_id.split(',');
						for(var i=0;i<multi_quick_mix_music_id_arr.length;i++)
							{
								getQuickMIXmusicDetails(multi_quick_mix_music_id_arr[i]);
							}
					}
				else
					{
						getQuickMIXmusicDetails(music_id);
					}
			}
	}

//To update QuickMixs
function updateMusicsQuickMixCount(music_id)
	{
		quick_mix_music_id_arr.push(music_id);
		curr_quick_mix_music_id = music_id;
		var url = cfg_site_url+'music/musicUpdateQuickMix.php';
		var pars = '?music_id='+music_id;
		var path = url+pars;
		new jquery_ajax(path, '', 'getQuickMixCode');
	}

//After updating QuickMix
function getQuickMixCode(data)
	{
		if(curr_quick_mix_music_id.indexOf(',') != -1)
			{
				var multi_quick_mix_music_id_arr = curr_quick_mix_music_id.split(',');
				for(var i=0;i<multi_quick_mix_music_id_arr.length;i++)
					{
						if($Jq('#quick_mix_'+multi_quick_mix_music_id_arr[i]) && $Jq('#quick_mix_added_'+multi_quick_mix_music_id_arr[i]))
							{
								$Jq('#quick_mix_'+multi_quick_mix_music_id_arr[i]).hide();
								$Jq('#quick_mix_added_'+multi_quick_mix_music_id_arr[i]).show();
							}
					}
			}
		else
			{
				$Jq('#quick_mix_'+curr_quick_mix_music_id).hide();
				$Jq('#quick_mix_added_'+curr_quick_mix_music_id).show();
			}

		//listenBaloon_divAgain();
		quickMixPlayer(curr_quick_mix_music_id);
		return false;
	}

//To get QuickMIX song  - parameters - url, music_id
var getQuickMIXmusicDetails = function()
	{
		var music_id = arguments[0];
		quickMix_url += '&music_id='+music_id;
		/*if(quick_mix_music_id_arr.indexOf(music_id) != -1)
			{
				if(typeof(quickMixPopupWindow) != 'undefined' && quickMixPopupWindow != null || quickMixPopupWindow.closed)
					{
						quickMixPopupWindow.focus();
						return false;
					}
			}*/
		quick_mix_music_id_arr.push(music_id);
		if(quickMixPopupWindow == null || quickMixPopupWindow.closed)
			{
				quickMixPlayer(music_id);
				/*$Jq('quick_mix_'+music_id).hide();
				$Jq('quick_mix_added_'+music_id).show();*/
			}
		else
			{
				quick_mix_music_id = music_id;
				jquery_ajax(quickMix_url, '', 'appendQuickMixSong')
			}
	}

//To append QuickMIX song to player
function appendQuickMixSong(data)
	{
		data = unescape(data);
/*		if(data.indexOf(session_check)>=1)
			{
				data = data.split(session_check_replace);
				data = data[1].strip();
			}*/
		quickMixPopupWindow.addSong(data);
		//addSong(data);
		/*$Jq('quick_mix_'+quick_mix_music_id).hide();
		$Jq('quick_mix_added_'+quick_mix_music_id).show();*/
		quickMixPopupWindow.focus();
	}

/** QUICKMIX RELATED FUNCTIONS ENDS HERE **/
/** -------------------------------------------------------------------- **/


/**
 *
 * @access public
 * @return void
 **/
function getRelatedMusic(related)
	{
		var pars='type='+related+'&music_id='+music_id+'&ajax_page=true&relatedMusic=true';
		$Jq('#relatedMusicContent').html('');
		scrollMoreMusicDiv();
		$Jq('#loaderMusics').removeClass('clsDisplayNone');
		jquery_ajax(relatedUrl, pars, 'ajaxRelatedResult')
		$Jq('#selHeaderMusicUser').removeClass('clsActive');
		$Jq('#selHeaderMusicRel').removeClass('clsActive');
		$Jq('#selHeaderMusicTop').removeClass('clsActive');
		//Checked the condition to avoid the highlight issue if artist feature is on/off
		if(!artist_feature)
			$Jq('#selHeaderMusicArtist').removeClass('clsActive');
		loadChangeClass('.clsMoreMusicNav li','clsActive');

		if(related=='user')
			{
				$Jq('#selHeaderMusicUser').addClass('clsActive');
				$Jq('#selHeaderMusicUser').unbind('mouseout', '');
			}
		if(related=='tag')
			{
				$Jq('#selHeaderMusicRel').addClass('clsActive');
				$Jq('#selHeaderMusicRel').unbind('mouseout', '');
			}
		if(related=='top')
			{
				$Jq('#selHeaderMusicTop').addClass('clsActive');
				$Jq('#selHeaderMusicTop').unbind('mouseout', '');
			}
		if(related=='artist')
			{
				$Jq('#selHeaderMusicArtist').addClass('clsActive');
				$Jq('#selHeaderMusicArtist').unbind('mouseout', '');
			}
}

/**
 *
 * @access public
 * @return void
 **/
function ajaxRelatedResult(data)
{
	$Jq('#loaderMusics').addClass('clsDisplayNone');
	data = unescape(data);
	$Jq('#relatedMusicContent').html(data);
	$Jq('#selNextPrev_top').html($Jq('selNextPrev').html());
	scrollMoreMusicDiv();
}
function scrollMoreMusicDiv()
{
	var container=$Jq('#relatedMusicContent');
	container.jScrollPane({showArrows:true, scrollbarWidth:15});
}

// AJAX FUNCTION TO CALL SHARE PLAYLIST
function showShareMusicPlaylistDiv(url)
	{
		import_contacts_link = true;
		pars='';
		$Jq('#shareDiv').show();
		$Jq('#userActionTips').hide();
		$Jq('#shareDiv').html( view_playlist_scroll_loading);
		scrollDiv();
		jquery_ajax(url, pars, 'ajaxResultShareMusicPlaylist')
	}
// FUCNTION TO DISPLAY SHARE PLAYLIST AJAX OUTPUT
function ajaxResultShareMusicPlaylist(data)
	{
		data = unescape(data);
/*		if(data.indexOf(session_check)>=1)
			{
				data = data.replace(session_check_replace,'');
			}
		else
			{
				return;
			} */

		 $Jq('#userActionTips').hide();
		$Jq('#shareDiv').html(data);
		scrollDiv();
	}
function viewPlaylistActiveLink(div_id)
	{
		var viewplaylist_div_arr = new Array('shareplaylist_Head', 'favorite_Head', 'featured_Head');
		for(var inc=0;inc<viewplaylist_div_arr.length;inc++)
			{
				if(viewplaylist_div_arr[inc] == div_id)
					$Jq('#'+viewplaylist_div_arr[inc]).addClass('clsActive');
				else
					$Jq('#'+viewplaylist_div_arr[inc]).removeClass('clsActive');
			}
	}
//VIEW ALBUM PAGING START
function musicAlbumAjaxPaging(query_string, action)
	{
		if(action == "")
			{
				start = 0;
			}
		else
			{
				startvalue = $Jq('#start').val();
				if(action == 'perv')
					start = parseInt(startvalue) - parseInt(pageing_limit);
				else
					 start = parseInt(startvalue) + parseInt(pageing_limit);
				$Jq('#start').val(start);
			}
		$Jq('#albumInSongList').html($Jq('loaderMusics').html());
		var pars = query_string+'&start='+start;
		ajaxpageing_url = relatedUrl+pars;
		jquery_ajax(ajaxpageing_url, '','albumSonglistBlock');
		return false;
	}

function albumSonglistBlock(request)
	{
		data = request;
		/*if(data.indexOf(session_check)>=1)
			data = data.replace(session_check_replace,'');*/
		if(data.indexOf('~!###!~')>=1)
			data = data.split('~!###!~');

		if(data[2])
			{
				var album_music_id_arr = data[2].split(',');
				for(var i = 0;i<album_music_id_arr.length;i++)
					{
						total_musics_ids_play_arr.push(album_music_id_arr[i]);
					}
			}
		$Jq('#albumInSongList').html(data[3]);
		//total music count
		total_musics_to_play = data[1];
		//generate playlist player
		eval(data[0]);
		//$Jq('albumSongs_Head').html() = $Jq('albumSongs_Paging').html();
		//listenBaloon_divAgain();
	}
//VIEW ALBUM PAGING END//

function addFlagContent(url)
	{
		view_muisc_content_id = 'Flag';
		var flag=$Jq('#flag').val();
		var comment=encodeURIComponent($Jq('#flag_comment').val());
		if(comment)
			{
				$Jq('#clsMsgDisplay_flag').removeClass('clsDisplayNone');
				$Jq('#clsMsgDisplay_flag').removeClass('clsErrorMessage');
				$Jq('#clsMsgDisplay_flag').removeClass('clsSuccessMessage');
				$Jq('#flag_submitted').html(view_music_music_ajax_page_loading);
				$Jq('#flag_loader_row').show();
				pars = "&flag="+flag+"&flag_comment="+comment;
				url += pars;
				jquery_ajax(url, '', 'insertFlagContent');
			}
		else
			{
				$Jq('#clsMsgDisplay_flag').removeClass('clsDisplayNone');
				$Jq('#clsMsgDisplay_flag').addClass('clsErrorMessage');
				$Jq('#clsMsgDisplay_flag').html(viewmusic_mandatory_fields);
				scrollDiv();
			}
		return false;
	}


function insertFlagContent(resp)
	{
		data=resp;
		/*if(data.indexOf(session_check)>=1)
			{
					data = data.replace(session_check_replace,'');
			}
		else
			{
				return;
			}*/
		document.flagfrm.reset();
		//$Jq('flagFrm').addClass('clsDisplayNone');
		$Jq('#clsMsgDisplay_flag').removeClass('clsDisplayNone');
		$Jq('#clsMsgDisplay_flag').addClass('clsSuccessMessage');

		if($Jq('#flag_loader_row'))
			$Jq('#flag_loader_row').hide();

		$Jq('#clsMsgDisplay_flag').html( data );
		scrollDiv();
		return false;
	}

var addBlogSuccess ="<?php echo $LANG['viewvideo_posted_your_blog'];?>";
var addBlogFailure ="<?php echo $LANG['mandatory_fields_compulsory'];?>";
function postThisMusic()
	{
		var blog_text = $Jq('#blog_post_text').val();
		var blog_post_title = $Jq('#blog_post_title').val();
		var blog_title=$Jq('#blog_title').val();
		if($Jq.trim(blog_text) != '' && $Jq.trim(blog_title) != '')
			{
				blog_post_title=encodeURIComponent(blog_post_title);
				blog_title=encodeURIComponent(blog_title);
				blog_text = encodeURIComponent(blog_text);

				var pars = '&action=post_blog&blog_post_text='+blog_text+'&blog_post_title='+blog_post_title+'&blog_title='+blog_title;
				blog_url += pars;

				$Jq('#selAddNewBlogFailure').css('display',  'none');
				$Jq('#selAddNewBlogSuccess').removeClass('clsSuccessMessage');
				$Jq('#selAddNewBlogSuccess').html(view_music_music_ajax_page_loading);
				$Jq('#selAddNewBlogSuccess').show();
				openAjaxWindow('false', 'ajaxupdate', 'jquery_ajax', blog_url, '', 'addBlogResult');
				hideAllBlocks();
			}
		else
			{
				$Jq('#selAddNewBlogFailure').css('display',  '');
				$Jq('#selAddNewBlogFailure').html('<p>'+addBlogFailure+'<\/p>');
			}
	}

function addBlogResult(resp)
{
	data=resp;
	$Jq('#selAddNewBlogSuccess').addClass('clsSuccessMessage');
	$Jq('#selAddNewBlogSuccess').html('<p>'+addBlogSuccess+'<\/p>');
	return;
}
function light_addMusiclyrics(url)
	{
		var pars = '';
		lyric = Trim($Jq('#lyric').val());
		if(lyric == '')
			{
				$Jq('#selLyricsMsgError').show();
				$Jq('#selLyricsMsgError').html(managelyrics_compulsory);
				return false;
			}
		url = url+'&lyric='+encodeURIComponent(lyric);
		jquery_ajax(url, pars, 'light_addMusiclyricsResult')
		return false;
	}
function light_addMusiclyricsResult(data)
	{
		data = unescape(data);
		/*if(data.indexOf(session_check)>=1)
			{
				data = data.replace(session_check_replace,'');
			}
		else
			{
				return;
			}*/
		$Jq('#selMusicPlaylistManage').hide();
		$Jq('#selLyricsMsgError').hide();
		$Jq('#selLyricsMsgSuccess').show();
		$Jq('#selLyricsMsgSuccess').html(data);
	}
function playlistImageZoom(option_val, show_div, hide_div, array_count)
	{
		if(option_val == 'playlistZoomIn')
			{
				$Jq('#'+hide_div).setOpacity(0.0).hide();
				Effect.playlistZoomIn(show_div, hide_div, 'top-left', array_count);
			}
		if(option_val == 'Shrink')
			{
				Effect.playlistZoomOut(show_div, hide_div, array_count);
			}
		return false;
	}
//@todo - commented the effects need to check with the page and fix ..

/*Effect.playlistZoomIn = function(element, hide_div, dieection_coust, array_count) {
  start_height = $Jq(hide_div).hight;
  start_width = $Jq(hide_div).width;
  element = $Jq(element);
  var options = Object.extend({
    direction: dieection_coust,
    moveTransition: Effect.Transitions.sinoidal,
    scaleTransition: Effect.Transitions.sinoidal,
    opacityTransition: Effect.Transitions.full
  }, arguments[1] || { });
  var oldStyle = {
    top: element.style.top,
    left: element.style.left,
    height: element.style.height,
    width: element.style.width,
    opacity: element.getInlineOpacity() };
  var dims = element.getDimensions();
  var initialMoveX, initialMoveY;
  var moveX, moveY;
  switch (options.direction) {
    case 'top-left':
      initialMoveX = initialMoveY = moveX = moveY = 0;
      break;
    case 'top-right':
      initialMoveX = dims.width;
      initialMoveY = moveY = 0;
      moveX = -dims.width;
      break;
    case 'bottom-left':
      initialMoveX = moveX = 0;
      initialMoveY = dims.height;
      moveY = -dims.height;
      break;
    case 'bottom-right':
      initialMoveX = dims.width;
      initialMoveY = dims.height;
      moveX = -dims.width;
      moveY = -dims.height;
      break;
    case 'center':
      initialMoveX = dims.width / 2;
      initialMoveY = dims.height / 2;
      moveX = -dims.width / 2;
      moveY = -dims.height / 2;
      break;
  }
  return new Effect.Move(element, {
    x: initialMoveX,
    y: initialMoveY,
    duration: 0.23,
    beforeSetup: function(effect) {
      effect.element.hide().makeClipping().makePositioned();
    },
    afterFinishInternal: function(effect) {
      new Effect.Parallel(
        [ new Effect.Opacity(effect.element, { sync: true, to: 1.0, from: 0.0, transition: options.opacityTransition }),
          new Effect.Move(effect.element, { x: moveX, y: moveY, sync: true, transition: options.moveTransition }),
          new Effect.Scale(effect.element, 100, {
            scaleMode: { originalHeight: original_height[array_count], originalWidth: original_width[array_count]},
            sync: true, scaleFrom: window.opera ? 1 : 0, transition: options.scaleTransition, restoreAfterFinish: false})
        ], Object.extend({
             beforeSetup: function(effect) {
               effect.effects[0].element.setStyle({height: '0px'}).show();
             },
             afterFinishInternal: function(effect) {
               element.show();
             }
           }, options)
      );
    }
  });
};
Effect.playlistZoomOut = function(element, element2, array_count) {
  element = $Jq(element);
  element2 = $Jq(element2);
  var options = Object.extend({
    direction: 'top-left',
    moveTransition: Effect.Transitions.sinoidal,
    scaleTransition: Effect.Transitions.sinoidal,
    opacityTransition: Effect.Transitions.none
  }, arguments[1] || { });
  var oldStyle = {
    top: element.style.top,
    left: element.style.left,
    height: element.style.height,
    width: element.style.width,
    opacity: element.getInlineOpacity() };
  var dims = element2.getDimensions();
 switch (options.direction) {
    case 'top-left':
      moveX = moveY = 0;
      break;
    case 'top-right':
      moveX = dims.width;
      moveY = 0;
      break;
    case 'bottom-left':
      moveX = 0;
      moveY = dims.height;
      break;
    case 'bottom-right':
      moveX = dims.width;
      moveY = dims.height;
      break;
    case 'center':
      moveX = dims.width / 2;
      moveY = dims.height / 2;
      break;
  }
	$Jq(element).hide();
  return new Effect.Parallel(
    [ new Effect.Opacity(element2, { sync: true, to: 0.0, from: 1.0, transition: options.opacityTransition }),
      new Effect.Scale(element2, window.opera ? 1 : 0, { sync: true, transition: options.scaleTransition, restoreAfterFinish: false}),
      new Effect.Move(element2, { x: moveX, y: moveY, sync: true, transition: options.moveTransition })
    ], Object.extend({
         beforeStartInternal: function(effect) {
           effect.effects[0].element.makePositioned().makeClipping();
         },
         afterFinishInternal: function(effect) {
         	element2.hide();
         	element.setOpacity(100).show();
	       //effect.effects[0].element.show().undoClipping().undoPositioned().setStyle(oldStyle);
		 }
       }, options)
  );
};
*/
function getAjaxGetCode(path, delLink,formName,getCode)
	{

		getCodeFormName=formName;
		delLink_value = delLink;
		code=getCode;
		jquery_ajax(path, '', 'getdisplayCode');
		return false;
	}

function getdisplayCode(data)
	{
		data = unescape(data);
		var obj = document.getElementById(getCodeFormName);

		/*if(data.indexOf(session_check)>=1)
			data = data.replace(session_check_replace,'');
		else
			return;*/
		data = $Jq.trim(data);
		$Jq('#'+getCodeFormName).html('<div id="selDisplayWidth" width="900" >'+data+'</div>');
		Confirmation(getCodeFormName, 'msgConfirmform', Array(getCodeFormName), Array('<div id="selDisplayWidth">'+data+'</div>'), Array('html'), -100, -550,code);
		return false;
	}

/* To get music ids for quickMix
   form_name, check_all_name, alert_value, place
 */
var quickMixmultiCheckValue = '';
var getMultiCheckBoxValueForQuickMix = function()
	{
		var form_name = arguments[0];
		var check_all_name = arguments[1];
		if(arguments.length>2)
			{
				var alert_value = arguments[2];
			}
		var frm = eval('document.'+form_name);
		var ids = '';
		quickMixmultiCheckValue = '';
		var quick_mix_added = false;
		for(var i=0;i<frm.elements.length;i++)
			{
				var e=frm.elements[i];
				//extra condition added for quickmix cheking
				if ((e.name != check_all_name) && (e.type=='checkbox') && e.checked)
					{
						if($Jq('#quick_mix_added_'+e.value).css('display') == 'none')
							ids += e.value+',';
						else
							quick_mix_added = true;
					}
			}
		if(ids)
			{
				quickMixmultiCheckValue =ids.substring(0,ids.length-1);
				return true;
			}
		if(quick_mix_added)
			{
				alert_manual(qucikmix_added_already);
				return false;
			}
		if(arguments.length>2)
			{
				alert_manual(alert_value);
			}
		return false;
	}
// MID: 76005 highlight the tab in IE 6 issues
function tabChange(div_id, option)
	{
		if(option == 'over')
			$Jq('#'+div_id).addClass('clsAudioMenuOver');
		else if(option == 'out')
			$Jq('#'+div_id).removeClass('clsAudioMenuOver');
	}

function memberBlockLoginConfirmation(msg,url)
	{
		document.msgConfirmformMulti1.action = url;
		return Confirmation('selMsgLoginConfirmMulti', 'msgConfirmformMulti1', Array('selAlertLoginMessage'), Array(msg), Array('html'));
	}
//need to check this with implemenetation
function hidingBlocks()
	{
		if(obj = $Jq('#selMsgLoginConfirmMulti'))
		$Jq('#selMsgLoginConfirmMulti').css('display', 'none');
		if(obj = $Jq('#hideScreen'))
		$Jq('#hideScreen').css('display','none');
		if(obj = $Jq('#selAjaxWindow'))
		$Jq('#selAjaxWindow').css('display','none');
		if(obj = $Jq('#selAjaxWindowInnerDiv'))
		$Jq('#selAjaxWindowInnerDiv').html('');
		return false;
	}

//store volume to session
function store_volume_in_session(cur_volume)
	{
		var pars = '&volume='+cur_volume;
		var path = save_volume_url+pars;
		new jquery_ajax(path, '','volume_stored');
	}

//After updating volume to session
function volume_stored(data)
{

}
function addQuickMixRedirect(url)
{
	self.close();
}
function clearQuickMix()
{
	var url = cfg_site_url+'music/musicUpdateQuickMix.php';
	var pars = '?clear_list=1';
	var path = url+pars;
	new jquery_ajax(path, '','quickMixClearCode');
}
function quickMixClearCode(data)
{
	window.location.href= site_url+'playQuickMix.php?clearall=1';
	return false;
}
function quickMixClearAlert(msg)
{
	return Confirmation('selMsgQuickMixConfirmMulti', 'msgQuickMixConfirmformMulti1', Array('selQuickMixAlertLoginMessage'), Array(msg), Array('html'),-100,20,'anchor_id');
}
//need to check this with implemenetation
function hidingQuickMixBlocks()
{
	if(obj = $Jq('#selMsgQuickMixConfirmMulti'))
	$Jq('#selMsgQuickMixConfirmMulti').css('display', 'none');
	if(obj = $Jq('#hideScreen'))
	$Jq('#hideScreen').css('display', 'none');
	if(obj = $Jq('#selAjaxWindow'))
	$Jq('#selAjaxWindow').css('display','none');
	if(obj = $Jq('#selAjaxWindowInnerDiv'))
	$Jq('#selAjaxWindowInnerDiv').html('');
	return false;
}
function playlistReorderRedirect(playlist_id)
{
	window.location.href= site_url+'organizePlaylist.php?playlist_id='+playlist_id;
	return false;
}
function playListRedirectUrl(url)
{
	opener.location.href= url;
	return false;
}
function deletePlaylistSongsInPlayer(playlist_id,music_id,delete_id)
{
	playlist_music_id_arr.push(music_id);
	playlist_music_id = music_id;
	var url = site_url+'organizePlaylist.php';
	var pars = 'delete_playlist_id='+playlist_id+'&music_id='+music_id;
	$Jq.ajax({
			type: "GET",
			url: url,
			data: pars,
			beforeSend:playlistDeleteLoadedFunc,
			success: playlistDeleteSuccessFunc
		 });
}
function playlistDeleteSuccessFunc(response)
{
	if(response.indexOf('ERR~')>=1)
	{
		response = response.replace('ERR~','');
		$Jq('#organize_playlist').html(response);
		$Jq('#organize_playlist').addClass(clsErrorMessage);
		$Jq('#organize_playlist').show();
	}
	else
	{
		if(obj = $Jq('#delete_'+playlist_music_id))
		$Jq('#delete_'+playlist_music_id).css('display',  'none');
		$Jq('#organize_playlist').html(response);
		$Jq('#organize_playlist').addClass(clsSuccessMessage);
		$Jq('#organize_playlist').show();
		hideAnimateBlock('organize_playlist');
	}
}
function playlistDeleteLoadedFunc(response)
{
	$Jq('#organize_playlist').removeClass(clsSuccessMessage);
	$Jq('#organize_playlist').removeClass(clsErrorMessage);
	$Jq('#organize_playlist').html(organize_playlist_ajax_page_loading);
	$Jq('#organize_playlist').show();
}
function playlistPlayerDeleteAlert(msg,music_id,playlist_id)
{
	Confirmation('selMsgPlaylistConfirmMulti', 'msgPlaylistConfirmformMulti1', Array('selPlaylistAlertLoginMessage'), Array(msg), Array('html'),-100,20,'anchor_id');
}
function hidingPlayListBlocks()
{

	if(obj = $Jq('#selMsgPlaylistConfirmMulti'))
	$Jq('#selMsgPlaylistConfirmMulti').css('display', 'none');
	if(obj = $Jq('#hideScreen'))
	$Jq('#hideScreen').css('display', 'none');
	if(obj = $Jq('#selAjaxWindow'))
	$Jq('#selAjaxWindow').css('display','none');
	if(obj = $Jq('#selAjaxWindowInnerDiv'))
	$Jq('#selAjaxWindowInnerDiv').html('');
	return false;
}
function clearAllPlaylistId(id)
{
	var url = site_url+'organizePlaylist.php';
	var pars = '?delete_all='+id;
	var path = url+pars;
	var playlist_id = id;
	$Jq('#organize_playlist').removeClass(clsSuccessMessage);
	$Jq('#organize_playlist').removeClass(clsErrorMessage);
	$Jq('#organize_playlist').html(organize_playlist_ajax_page_loading);
	$Jq('#organize_playlist').show();
	new jquery_ajax(path, '','clearPlaylistAll');
}
function clearPlaylistAll(data)
{
	if(data.indexOf('ERR~')>=1)
	{
		data = response.replace('ERR~','');
		$Jq('#organize_playlist').html(data);
		$Jq('#organize_playlist').addClass(clsErrorMessage);
		$Jq('#organize_playlist').show();
	}
	else
	{
		window.location=site_url+'organizePlaylist.php?playlist_id='+playlist_id;
	}
	return false;
}
function playlistEditRedirect(playlist_id)
{
	window.location.href= site_url+'playSongsInPlaylist.php?playlist_id='+playlist_id;
	return false;
}
function managePlaylistReorder(playlist_id)
{
	playlist_url=site_url+'organizePlaylist.php?playlist_id='+playlist_id;
	managePlaylistPopupWindow = window.open(playlist_url, 'managePlaylistPopupWindow', 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, copyhistory=no, resizable=yes,height=405,width=475,minHeight=405,minWidth=475');
	managePlaylistPopupWindow.focus();
	return false;
}

//CART RELATED FUNCTION STARTS HERE
function updateMusicsCartCount(music_id)
{
	var url = cfg_site_url+'music/musicUpdateAddToCart.php';
	var pars = '?music_id='+music_id;
	var path = url+pars;
	new jquery_ajax(path, '','updateSuccess');
}
function updateAlbumCartCount(album_id)
{
	var url = cfg_site_url+'music/musicUpdateAddToCart.php';
	var pars = '?album_id='+album_id;
	var path = url+pars;
	new jquery_ajax(path,'updateSuccess');
}

function updateSuccess(data)
{
	var message = data;
	return Confirmation('selMsgCartSuccess', 'msgCartFormSuccess', Array('selCartAlertSuccess'), Array(message), Array('html'),-100,20,'anchor_id');
	return false;
}

function deleteMusicsCartCount()
{
	music_id = document.getElementById('music_id').value;
	var url = cfg_site_url+'music/musicUpdateAddToCart.php';
	var pars = '?music_id='+music_id+'&remove_it=1';
	if(music_id=='')
		var pars = '?clear_cart_all=1';
	var path = url+pars;
	new jquery_ajax(path, '','updateSuccess');
}
function removeCartAlert(msg,id)
{
	return Confirmation('selMsgCartConfirmMulti', 'msgCartConfirmformMulti1', Array('selCartAlertLoginMessage','music_id'), Array(msg,id), Array('html'),-200,20,'anchor_id');
}
function hidingCartBlocks()
{
	if(obj = $Jq('#selMsgCartConfirmMulti'))
	$Jq('#selMsgCartConfirmMulti').css('display', 'none');
	if(obj = $Jq('#hideScreen'))
	$Jq('#hideScreen').css('display' ,'none');
	if(obj = $Jq('#selAjaxWindow'))
	$Jq('#selAjaxWindow').css('display','none');
	if(obj = $Jq('#selAjaxWindowInnerDiv'))
	$Jq('#selAjaxWindowInnerDiv').html('');
	return false;
}

var viewCart = function()
{
	url = view_cart_url;
	if(viewCartWindow && !viewCartWindow.closed)
	{
		viewCartWindow.close();
	}
	if(!viewCartWindow || viewCartWindow.closed)
		viewCartWindow = window.open(url, 'viewCart', 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, copyhistory=no, resizable=yes,height=405,width=475,minHeight=405,minWidth=475');


}
//CART RELATED FUNCTION END HERE
var result_div = '';
var field_id = '';
var musics = '';
var newobj = '';
function callAjaxAlbum(path, div_id, id, total_musics)
{
	result_div = div_id;
	field_id = id;
	musics = total_musics;
	new jquery_ajax(path, '','ajaxResultAlbum');
	return false;
}

function ajaxResultAlbum(data)
{
//	Confirmation(result_div, 'msgConfirmform', Array(result_div), Array('<div id="selDisplayWidth">'+data+'</div>'), Array('html'), -100, -550);
	Confirmation(result_div, 'selFormCreateAlbum', Array(result_div), Array('<div id="selDisplayWidth">'+data+'</div>'), Array('html'), -100, -550);
}
var zIndexValue = 999999;
function showHideScreen(divElm){
	var fromObj = $Jq('#' + divElm);
	fromObj.css('zIndex', zIndexValue);
	fromObj.css('display', 'block');
	if(obj = $Jq('#hideScreen')){
		var ss = getPageSizeWithScroll();
		var ua = navigator.userAgent.toLowerCase();

		if(ua.indexOf("msie") != -1){
			obj.css('width',[0]+"px");
		}
		obj.css('height',ss[1]+"px");
		obj.css('display', 'block');
		return false;
	}
}
function getPageSizeWithScroll(){
	if (window.innerHeight && window.scrollMaxY) {// Firefox
		yWithScroll = window.innerHeight + window.scrollMaxY;
		xWithScroll = window.innerWidth + window.scrollMaxX;
	} else if (document.body.scrollHeight > document.body.offsetHeight){ // all but Explorer Mac
		yWithScroll = document.body.scrollHeight;
		xWithScroll = document.body.scrollWidth;
	} else { // works in Explorer 6 Strict, Mozilla (not FF) and Safari
		yWithScroll = document.body.offsetHeight;
		xWithScroll = document.body.offsetWidth;
  	}
	arrayPageSizeWithScroll = new Array(xWithScroll,yWithScroll);
	//alert( 'The height is ' + yWithScroll + ' and the width is ' + xWithScroll );
	return arrayPageSizeWithScroll;
}
function cartRedirectUrl(url)
{
	window.opener.focus();
	opener.location.href= url;
	return false;
}

function disabledFormFields(arr)
{
	var i, obj;
	for (i=0;i<arr.length;i++)
		{
			if($Jq('#'+arr[i]).length > 0 )
				$Jq('#'+arr[i]).attr('disabled', true);
		}
}
function enabledFormFields(arr)
{
	var i, obj;
	for (i=0;i<arr.length;i++)
		{
			if($Jq('#'+arr[i]).length > 0 )
				$Jq('#'+arr[i]).attr('disabled', false);
		}
}


var saveAjaxAlbum = function()
{
	path = arguments[0];
	var frm = document.selFormCreateAlbum;
	var pars = '';
		for (var i=0;i<frm.elements.length;i++)
		{
			var e = frm.elements[i];
			if (e.type!='button' && e.type!='radio')
			{
				pars += '&'+e.name+'='+encodeURIComponent(e.value);
			}
			if(e.type=='radio' && e.checked)
			{
				pars += '&'+e.name+'='+encodeURIComponent(e.value);
			}
		}
	var path = path+pars;
	new jquery_ajax(path, '', 'ajaxAlbumResult');
	return false;
}
var music_price_id = '';
var sale_id='';

//need to check and update with the functionality
function ajaxAlbumResult(data)
{
	var obj = document.getElementById(field_id);
	data = data;
	if(data.indexOf('<Error>')>=1)
	{
		data = data.replace('<<<Error>>>','');
		$Jq('#selCreateAlbum').html(data);
		return false;
	}
	path = create_album_url;
	pars = 'ajax_page=true&page=getdetails&id='+data;
	$Jq('#' + field_id).load(path, pars);
	splites = field_id.split("_");
	music_price_id = 'music_price_'+splites[splites.length-1];
	sale_id = 'for_sale_'+splites[splites.length-1];
	pars = 'ajax_page=true&page=getprice&id='+data;
	new jquery_ajax(path, pars, 'ajaxAlbumPriceResult');
	if(musics > 1)
	{
		pars = 'ajax_page=true&page=getdetails';

		var fields = '';
		for(i=0; i<splites.length-1;i++)
		{
			fields += splites[i]+'_';
		}

		var i=0;
		while(i<musics)
		{
			if(field_id != fields+i)
			{
				newobj = fields+i;
				id = document.getElementById(newobj).value;
				pars +='&id='+id;
				$Jq('#' + fields+i).load(path, pars);
			}
			i++;
		}
	}
	hideAllBlocks();
	return false;
}

function getAlbumPrice(album_id, id, sale)
{
	music_price_id = id;
	sale_id = sale;
	path = create_album_url;
	pars = '?ajax_page=true&page=getprice&id='+album_id;
	new jquery_ajax(path+pars, '', 'ajaxAlbumPriceResult');
}

function ajaxAlbumPriceResult(data)
{
	data = unescape(data);
	var obj = $Jq('#' + music_price_id);
	obj.val(data);
	if(data>0)
	{
		$Jq('#' + sale_id+'_1').attr('checked', true);
		disabledFormFields(Array(sale_id+'_1', sale_id+'_2', music_price_id))
		$Jq('#selPriceDetails').html( lang_album_price);
	}
	else
	{
		$Jq('#' + sale_id+'_2').attr('checked', true);
		enabledFormFields(Array(sale_id+'_1', sale_id+'_2', music_price_id))
		$Jq('#selPriceDetails').html(lang_music_price);
	}
	return false;
}


function addToFan(url)
{
	path = url;
	new jquery_ajax(path, '','ajaxFansResult');
}
function ajaxFansResult(data)
{
	data = unescape(data);
	$Jq('#becomefan').css('display','none');
	$Jq('#removefan').css('display', '');
}
function removeToFan(url)
{
	path = url;
	new jquery_ajax(path,'','ajaxFansRemoveResult');
}
function ajaxFansRemoveResult(data)
{
	data = unescape(data);
	$Jq('#becomefan').css('display','');
	$Jq('#removefan').css('display','none');
}
function scrollDiv(){
	var container=$Jq('#scrollbar_content');
	container.jScrollPane({showArrows:true, scrollbarWidth:15});
}
/* To check the Selection is th existing playlist Or to create new One. If the value of the selection is '#new#' then Playlist Creation form will be displayed */

function chkPlaylist(obj)
{
	if($Jq('#'+obj).val()=="#new#")
	{
		$Jq('#createNewPlaylist').show();
	}
	else
	{
		$Jq('#createNewPlaylist').hide();
	}
}

// AJAX FUNCTION TO SEND THE PLAYSIT DETAILS BOTH CREATION AND SELECTION

function createPlayList(url, music_id, playlist)
{
	$Jq('#clsMsgDisplay_playlist_success').addClass('clsDisplayNone');
	$Jq('#clsMsgDisplay_playlist_failure').addClass('clsDisplayNone');
	var pars='';
	if(playlist=="#new#"){
		title = $Jq('#playlist_name').val();
		var encode_title =encodeURIComponent($Jq('#playlist_name').val());
		var desc = encodeURIComponent($Jq('#playlist_description').val());
		var tags = encodeURIComponent($Jq('#playlist_tags').val());
		var allow_comments = $Jq('input[name=allow_comments]:checked').val();
		var allow_ratings = $Jq('input[name=allow_ratings]:checked').val();
		var allow_embed = $Jq('input[name=allow_embed]:checked').val();
		if($Jq.trim(title) == '' || $Jq.trim(tags) == '' ){
			$Jq('#clsMsgDisplay_playlist_failure').removeClass('clsDisplayNone');
			$Jq('#clsMsgDisplay_playlist_failure').html(invalidPlaylist);
			return false;
		}
		else{
			$Jq('#clsMsgDisplay_playlist_failure').addClass('clsDisplayNone');
			$Jq('#clsMsgDisplay_playlist_failure').html('');
		}
		playlistTitle=title;
		pars='playlist_name='+encode_title+'&playlist_description='+desc+'&playlist_tags='+tags+'&allow_comments='+allow_comments+'&allow_ratings='+allow_ratings+'&allow_embed='+allow_embed+'&music_id='+music_id;
	}
	if(playlist!="#new#" && playlist){
		pars='playlist='+playlist+'&music_id='+music_id;
		playlistId=playlist;
	}
	if(pars){
		$Jq('#clsMsgDisplay_playlist_success').css('display', 'block');
		$Jq('#clsMsgDisplay_playlist_success').removeClass('clsDisplayNone');
		$Jq('#clsMsgDisplay_playlist_success').removeClass('clsPlaylistSuccess');
		$Jq('#clsMsgDisplay_playlist_success').html(music_ajax_page_loading);
		return openAjaxWindow('false', 'ajaxupdate', 'jquery_ajax', url, pars, 'createPlayListResponse');
	}
	else{
		$Jq('#clsMsgDisplay_playlist_failure').removeClass('clsDisplayNone');
		$Jq('#clsMsgDisplay_playlist_failure').html(selectionError);
	}
}
function createPlayListResponse(data){
	playlistId='';

	if(data.indexOf('ERR~')>=1)
	{
		hideAllBlocks();
		data = data.replace('ERR~','');
		$Jq('#clsMsgDisplay_playlist_success').addClass('clsPlaylistSuccess');
		$Jq('#clsMsgDisplay_playlist_success').html(data);
		$Jq('#clsMsgDisplay_playlist_success').show();
		return false;
	}


	if(data.indexOf('#$#')>=1){
		var dataTemp=data.split('#$#');
		data = dataTemp[0];
		playlistId=dataTemp[1];
	}
	if(playlistId){
		hideAllBlocks();
		$Jq('#clsMsgDisplay_playlist_success').addClass('clsPlaylistSuccess');
		if($Jq('#musicListForm').length > 0)
		{
			document.musicListForm.reset();
		}
		else if($Jq('#albumManage').length > 0)
		{
			document.albumManage.reset();
		}
		else if($Jq('#playlistManage').length > 0)
		{
			document.playlistManage.reset();
		}
		$Jq('#clsMsgDisplay_playlist_failure').addClass('clsDisplayNone');
		$Jq('#clsMsgDisplay_playlist_success').removeClass('clsDisplayNone');
		$Jq('#clsMsgDisplay_playlist_success').html(data);
		hideAnimateBlock('clsMsgDisplay_playlist_success');
	}
	else{
		$Jq('#clsMsgDisplay_playlist_success').css('display', 'none');
		$Jq('#clsMsgDisplay_playlist_success').addClass('clsDisplayNone');
		$Jq('#clsMsgDisplay_playlist_failure').removeClass('clsDisplayNone');
		$Jq('#clsMsgDisplay_playlist_failure').html(data);
	}
}

// FUCNTION TO DISPLAY THE PLAYLIST & FLAG CONTENT AJAX OUTPUT.
function ajaxResultPlaylist(data)
{

	/*data = unescape(data.responseText);

	if(data.indexOf(session_check)>=1)
	{
		data = data.replace(session_check_replace,'');
	}
	else
	{
		return;
	}*/

	playlistId='';
	if(data.indexOf('#$#')>=1)
	{
		var dataTemp=data.split('#$#');
		data = dataTemp[0];
		playlistId=dataTemp[1];

	}
	if(playlistTitle && playlistId)
	{
		if($Jq.browser.msie){
	    var optn = document.createElement("OPTION");
	    var el= $Jq('#playlist');

    	optn.text = playlistTitle;
	    optn.value =playlistId;
    	el.options.add(optn);
		}
		else
		{
			//$Jq('#playlist').insert('<option value="'+playlistId+'">'+playlistTitle+'</option>');
			$Jq('#playlist').val(playlistId);

		}
	playObj=$Jq('#.createPlaylistSec');
	playObj.each(function(play)
	{
		play.addClass('clsCreatePlaylist');
	});

	document.playlistfrm.reset();
	}


	if(section['flagDiv']==true)
	{
		document.flagfrm.reset();

		//$('flagFrm').addClass('clsDisplayNone');
		$Jq('#clsMsgDisplay_flag').removeClass('clsDisplayNone');
		$Jq('#clsMsgDisplay_flag').html(data);
	}
	if(section['playlistDiv']==true)
	{
		if(playlistId)
		{
			$Jq('#playlistFrmDiv').addClass('clsDisplayNone');
		}
		else
		{
			$Jq('#clsMsgDisplay').addClass('clsDisplayNone');
			$Jq('#clsMsgDisplay').html(invalidPlaylist);
		}
		$Jq('#clsMsgDisplay_playlist').removeClass('clsDisplayNone');
		$Jq('#clsMsgDisplay_playlist').html(data);

	}
}
// AJAX FUNCTION TO CALL SHARE MUSIC
function showShareDiv(url){
	import_contacts_link = true;
	pars='';
	jquery_ajax(url, pars, 'ajaxResultShare');
}

// FUCNTION TO DISPLAY SHARE MUSIC AJAX OUTPUT
function ajaxResultShare(data){
	$Jq('#shareDiv').html(data);
	import_contacts_link = true;
	Confirmation('shareDiv', 'formEmailList', Array(), Array(), Array());
}

// AJAX FUCNTION TO STORE FLAG CONTENT
function addFlagContentAjax(url){
	var flag=$Jq('#flag').val();
	var comment=$Jq('#flag_comment').val();
	if($Jq.trim(comment) == '')
	{
		$Jq('#clsMsgDisplayFlagDiv').removeClass('clsDisplayNone');
		$Jq('#clsMsgDisplayFlagDiv').html(invalidPlaylist);
	}
	else
	{
		comment=encodeURIComponent($Jq('#flag_comment').val());
		$Jq('#clsMsgDisplayFlagDiv').addClass('clsDisplayNone');
		$Jq('#clsMsgDisplayFlagDiv').html('');
		$Jq('#clsMsgDisplay_flag').html(music_ajax_page_loading);
		$Jq('#clsMsgDisplay_flag').removeClass('clsMsgDisplay_flag');
		$Jq('#clsMsgDisplay_flag').css('display', 'block');
		$Jq('#clsMsgDisplay_flag').removeClass('clsDisplayNone');

		pars="flag="+flag+"&flag_comment="+comment;
		hideAllBlocks();
		openAjaxWindow('false', 'ajaxupdate', 'jquery_ajax', url, pars, 'addFlagContentresponse');
	}
	return false;
}

function addFlagContentresponse(html){
	$Jq('#clsMsgDisplay_flag').addClass('clsMsgDisplay_flag');
	if(html.indexOf('ERR~')>=1)
	{
		html = html.replace('ERR~','');
	}
	document.flagfrm.reset();
	$Jq('#clsMsgDisplay_flag').removeClass('clsDisplayNone');
	$Jq('#clsMsgDisplay_flag').html(html);
	hideAnimateBlock('clsMsgDisplay_flag');
}

function addLoadingBg(div_id)
{
	$Jq('#' + div_id).addClass("clsLoadingBackground");
}
function removeLoadingBg(div_id)
{
	$Jq('#' + div_id).removeClass("clsLoadingBackground");
}

/* ADDED TO DISPLAY MORE INFO BASED ON SELECTED ID CALLED IN MUSIC LIST */
var displayed_more_info_music_id = '';
function displayMusicMoreInfo(music_id)
{
	$Jq("#panel_" + music_id).toggle("fast");
	$Jq("#trigger_" + music_id).toggleClass("active");
	if($Jq("#trigger_" + music_id).is('.active')){
		if(displayed_more_info_music_id)
		{
			$Jq("#panel_" + displayed_more_info_music_id).toggle("fast");
			$Jq("#trigger_" + displayed_more_info_music_id).toggleClass("active");
		}
		displayed_more_info_music_id = music_id;
	}
	else
	{
		displayed_more_info_music_id = '';
	}

}