	function playlistSelectBoxAction(selectValue, div_id)
	{
		$Jq('#errorTips').hide();
		if($Jq('#playlist_name_select').val()==0)
			$Jq('#mode').val('insert');
		else
			$Jq('#mode').val('edit');
		if(selectValue=='0')
			$Jq('#'+div_id).show();
		else
			$Jq('#'+div_id).hide();

		$Jq('#photo_playlist_id').val(selectValue);
		if(typeof(recalculate_scroll_view_photo) != 'undefined')
		{
			if(recalculate_scroll_view_photo)
				$Jq('#scrollbar_content').jScrollPane({showArrows:true, scrollbarWidth:15});
		}
	}

	function createPlaylist(url)
	{
		//SELECT PLAYLIST//
		if($Jq('#playlist_name_select').val() == '')
		{
			$Jq('#errorTips').show();
			$Jq('#errorTips').html(playlist_name_error_msg);
			//FOR VIEW photo PAGE
			if(typeof(recalculate_scroll_view_photo) != 'undefined')
			{
				if(recalculate_scroll_view_photo)
				{
					$Jq('#scrollbar_content').jScrollPane({showArrows:true, scrollbarWidth:15});
					//scrollDiv();
					//scrollbar.scrollTo('top');
				}
			}
			return true;
		}
		if(document.getElementById('playlistContent').style.display != 'none')
		{
			//CHECK COMPULSORY FIELDS//
			if($Jq('#playlist_name').val() == '')
			{
				$Jq('#errorTips').show();
				$Jq('#errorTips').html(playlist_tag_error_msg);
				//FOR VIEW photo PAGE
				if(typeof(recalculate_scroll_view_photo) != 'undefined')
				{
					if(recalculate_scroll_view_photo)
							$Jq('#scrollbar_content').jScrollPane({showArrows:true, scrollbarWidth:15});
					//	scrollDiv();
					//scrollbar.scrollTo('top');
				}
				return true;
			}
		}
		//CREATE NEW PLAYLIST//
		if($Jq('#photo_playlist_id').val() == 0)
			$Jq('#photo_playlist_id').val('');
		//INSERT OR UPDATE PLAYLIST//
		if($Jq('#photo_playlist_id').val()=='')
		{
			pars = '&photo_playlist_id='+$Jq('#photo_playlist_id').val()+'&playlist_name='+encodeURIComponent($Jq('#playlist_name').val())
					+'&playlist_description='+encodeURIComponent($Jq('#playlist_description').val())
					+'&photo_id='+document.getElementById('photo_id').value
					+'&mode='+$Jq('#mode').val();

		}
		else
		{
			pars = '&photo_playlist_id='+$Jq('#photo_playlist_id').val() + '&photo_id='+$Jq('#photo_id').val()+'&mode='+$Jq('#mode').val();
		}
		//For View photo
		if(typeof(view_photo_photo_ajax_page_loading) != 'undefined')
		{
			if(view_photo_photo_ajax_page_loading)
			{
				$Jq('#playlist_submitted').html(view_photo_photo_ajax_page_loading);
				$Jq('#playlist_loader_row').show();
				if(typeof(recalculate_scroll_view_photo) != 'undefined')
				{
					if(recalculate_scroll_view_photo)
					{
						//scrollDiv();
						//scrollbar.scrollTo('bottom');
						$Jq('#scrollbar_content').jScrollPane({showArrows:true, scrollbarWidth:15});
					}
				}
			}
		}
		new jquery_ajax(url, pars, 'ajaxPlaylistCreateResult');
	}

	function ajaxPlaylistCreateResult(request)
	{
		data = request;
		//if(data.indexOf(session_check)>=1)
			//data = data.replace(session_check_replace,'');
		var message = '';

		if(data.indexOf('***--***!!!') == -1)// DISPLAY ERROR CHECKING //
		{
			$Jq('#createPlaylist').hide();
			message = data;
			$Jq('#photo_playlist_id').val('');
			$Jq('#playlist_name').val('');
			$Jq('#playlist_description').val('');
		}
		else
		{
			data = data.split('***--***!!!');
			message = data[1];
		}
		$Jq('#errorTips').removeClass('clsErrorMessage');
		$Jq('#errorTips').show();
		$Jq('#errorTips').html(message);
		//For View photo
		if($Jq('#playlist_loader_row'))
			$Jq('#playlist_loader_row').hide();
		if(typeof(recalculate_scroll_view_photo) != 'undefined')
		{
			if(recalculate_scroll_view_photo)
			{
				//scrollDiv();
				//scrollbar.scrollTo('top');
				$Jq('#scrollbar_content').jScrollPane({showArrows:true, scrollbarWidth:15});
			}
		}
		return false;
	}
	/**
	 *
	 * @access public
	 * @return void
	 **/
	function displaySlideList()
	{
		$Jq('#selSlideDiv').css('display', 'block');
		$Jq('#playlist').jScrollPane({scrollbarWidth:10, scrollbarMargin:10});
	}
	function displayCreateSlideList()
	{
		$Jq('#playlistContent').css('display', 'block');
		$Jq('#playlist_name_select').val(0);
		$Jq('#mode').val('insert');
		$Jq('#playlist_name_select_duplicate').val($Jq('#sel0').html());
		$Jq('#selSlideDiv').css('display', 'none');

	}
	function displaySlideListValue(idval)
	{
		$Jq('#selSlideDiv').css('display', 'none');
		$Jq('#playlistContent').css('display', 'none');
		$Jq('#playlist_name_select').val(idval);
		$Jq('#photo_playlist_id').val(idval);
		$Jq('#playlist_name_select_duplicate').val($Jq('#'+idval).html());
		$Jq('#mode').val('edit');
	}
