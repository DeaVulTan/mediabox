var photo_stack;
toggleQLStackBtn=function(successOrCall,photo_ids)
	{
		if(jQuery.isFunction(successOrCall)&&jQuery.isArray(photo_ids))
			{
				successOrCall(photo_ids,toggleQLStackBtn);
			}
		else if(successOrCall)
			{}
	}

addToStack=function(photo_ids,callback){
	if(photo_ids.length==0)
		return;
	$Jq.ajax({
			type: "POST",
			url: photo_stack_ajax_url,
			data: { action:'add',
					photo_ids:jQuery.toJSON(photo_ids)
				  },
			//beforeSend:displayLoadingImage(),
			success: function(transport)
				{
					if(transport.indexOf('ERR~')>=1)
						{
							transport = transport.replace('ERR~','');
							alert_manual(transport);
						}
					else
						{
							var success=false;
							var result=eval('('+transport+')');
							if(typeof(result)=='object')
							{
								photo_stack=result;
								updatePhotoStack();
								if(result.message)
									notify(result.message);
								success=true;
								document.body.fire('stack:added',
													{
														photoIds:photo_ids
													});
							}
							if(jQuery.isFunction(callback))
								callback(success,photo_ids);
						}
				}
		 });
	return false;
}


updatePhotoStack=function(noEffect){
	if(photo_stack.photo_ids.length==0)
		{
			$Jq('#photo_stack').css('display','none');
			$Jq('#photo_stack_info').css('display','none');
			return;
		};
	$Jq('#photo_stack').css('display','block');
	$Jq('#photo_stack_info').css('display','block');
	var strPhoto;
	if(photo_stack.photo_ids.length==1)
	{
		strPhoto=photo_stack.photo_ids.length;
	}
	else
	{
		strPhoto=photo_stack.photo_ids.length;
	};
	$Jq('#stack_count').html(strPhoto);
	$Jq('#stack_img').html('<img src="'+photo_stack.url+'"/>');
	if(!noEffect)
		 $Jq('#stack_img').effect('shake', {times:3}, 55);
	if(!photo_stack.hide_tip)
		{

			$Jq('#photo_stack_info').show();
		}
}

removeFromStack=function(photo_ids,callback)
	{

		$Jq.ajax({
			type: "POST",
			url: photo_stack_ajax_url,
			data: {
					action:'remove',
					photo_ids:jQuery.toJSON(photo_ids)
				  },
			success: function(transport)
					{
						if(transport.indexOf('ERR~')>=1)
						{
							transport = transport.replace('ERR~','');
							alert_manual(transport);
						}
						else
						{
							var success=false;
							var result=eval('('+transport+')');
							if(typeof(result)=='object')
							{
								photo_stack=result;
								updatePhotoStack();
								success=true;
								document.body.fire('stack:removed',
													{photoIds:photo_ids}
												  );
							}
							if(jQuery.isFunction(callback))
								callback(success,photo_ids);
						}
					}
		 });
		return false;
	}

hideStack=function()
{
	$Jq('#photo_stack').css('display','none');
	$Jq('#photo_stack_info').css('display', 'none');
}
