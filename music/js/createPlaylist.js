	function playlistSelectBoxAction(selectValue, div_id)
		{
			$Jq('#errorTips').hide();
			if($Jq('#playlist_name_select').val() == 0)
				$Jq('#mode').val('insert');
			else
				$Jq('#mode').val('edit');
			if(selectValue=='0')
				$Jq('#' + div_id).show();
			else
				$Jq('#' + div_id).hide();

			document.getElementById('playlist_id').value = selectValue;
			if(typeof(recalculate_scroll_view_music) != 'undefined')
				{
					if(recalculate_scroll_view_music)
					{
						$Jq('#scrollbar_content').jScrollPane({showArrows:true, scrollbarWidth:15});
					}
				}
		}

	function createPlaylist(url)
		{
			//SELECT PLAYLIST//
			if(document.getElementById('playlist_name_select').value == '')
				{
					$Jq('#errorTips').show();
					$Jq('#errorTips').html(playlist_name_error_msg);
					//FOR VIEW MUSIC PAGE
					if(typeof(recalculate_scroll_view_music) != 'undefined')
						{
							if(recalculate_scroll_view_music)
								{
									$Jq('#scrollbar_content').jScrollPane({showArrows:true, scrollbarWidth:15});
								}
						}
					return true;
				}
			if($Jq('#playlistContent').css('display') != 'none')
				{
					//CHECK COMPULSORY FIELDS//
					if(document.getElementById('playlist_name').value == '' || document.getElementById('playlist_tags').value == '')
						{
							$Jq('#errorTips').show();
							$Jq('#errorTips').html(playlist_tag_error_msg);
							//FOR VIEW MUSIC PAGE
							if(typeof(recalculate_scroll_view_music) != 'undefined')
								{
									if(recalculate_scroll_view_music)
									{
										$Jq('#scrollbar_content').jScrollPane({showArrows:true, scrollbarWidth:15});
									}
								}
							return true;
						}
				}
			//CREATE NEW PLAYLIST//
			if(document.getElementById('playlist_id').value == 0)
				document.getElementById('playlist_id').value = '';
			//INSERT OR UPDATE PLAYLIST//
			if(document.getElementById('playlist_id').value=='')
				{
					pars = '&playlist_id='+document.getElementById('playlist_id').value+'&playlist_name='+encodeURIComponent(document.getElementById('playlist_name').value)
							+'&playlist_tags='+encodeURIComponent(document.getElementById('playlist_tags').value)
							+'&playlist_description='+encodeURIComponent(document.getElementById('playlist_description').value)
							+'&music_id='+document.getElementById('music_id').value
							+'&mode='+document.getElementById('mode').value;

					var allow_comments = '';
					for (var i=0; i<document.createPlaylistForm.allow_comments.length; i++)
						{
							if (document.createPlaylistForm.allow_comments[i].checked == true)
								{
									allow_comments = '&allow_comments='+document.createPlaylistForm.allow_comments[i].value;
								}
						}
					var allow_ratings = '';
					for (var i=0; i<document.createPlaylistForm.allow_ratings.length; i++)
						{
							if (document.createPlaylistForm.allow_ratings[i].checked == true)
								{
									allow_ratings = '&allow_ratings='+document.createPlaylistForm.allow_ratings[i].value;
								}
						}
					var allow_embed = '';
					for (var i=0; i<document.createPlaylistForm.allow_embed.length; i++)
						{
							if (document.createPlaylistForm.allow_embed[i].checked == true)
								{
									allow_embed = '&allow_embed='+document.createPlaylistForm.allow_embed[i].value;
								}
						}
					pars =  pars + allow_comments+allow_ratings+allow_embed;
				}
			else
				{
					pars = '&playlist_id='+document.getElementById('playlist_id').value + '&music_id='+document.getElementById('music_id').value+'&mode='+document.getElementById('mode').value;
				}
			//For View music
			if(typeof(view_music_music_ajax_page_loading) != 'undefined')
				{
					if(view_music_music_ajax_page_loading)
						{
							$Jq('#playlist_submitted').html(view_music_music_ajax_page_loading);
							$Jq('#playlist_loader_row').show();
							if(typeof(recalculate_scroll_view_music) != 'undefined')
								{
									if(recalculate_scroll_view_music)
										{
											$Jq('#scrollbar_content').jScrollPane({showArrows:true, scrollbarWidth:15});
										}
								}
						}
				}
				$Jq.ajax({
							type: "POST",
							url: url,
							data: pars,
							success: eval('ajaxPlaylistCreateResult')
		 				});
				return false;
		}

	function ajaxPlaylistCreateResult(request)
		{
			data = request;
			/*if(data.indexOf(session_check)>=1)
				data = data.replace(session_check_replace,'');*/
			var message = '';

			if(data.indexOf('***--***!!!') == -1)// DISPLAY ERROR CHECKING //
				{
					$Jq('#createPlaylist').hide();
					message = data;
					document.getElementById('playlist_id').value = '';
					document.getElementById('playlist_tags').value = '';
					document.getElementById('playlist_name').value = '';
					document.getElementById('playlist_description').value = '';
					document.getElementById('allow_comments').value = '';
					document.getElementById('allow_ratings').value = '';
				}
			else
				{
					data = data.split('***--***!!!');
					message = data[1];
				}
			$Jq('#errorTips').removeClass('clsErrorMessage');
			$Jq('#errorTips').show();
			$Jq('#errorTips').html(message);
			//For View music
			if($Jq('#playlist_loader_row'))
				$Jq('#playlist_loader_row').hide();
			if(typeof(recalculate_scroll_view_music) != 'undefined')
				{
					if(recalculate_scroll_view_music)
						{
							$Jq('#scrollbar_content').jScrollPane({showArrows:true, scrollbarWidth:15});
						}
				}
			return false;
		}