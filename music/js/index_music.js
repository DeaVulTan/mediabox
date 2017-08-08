//Show Hide related
function showIndexMusicTabs(id_to_fetch)
	{
	   	$('nav_recentlyviewedmusic').style.display='none';
	   	$('nav_recommendedmusic').style.display='none';
	   	$('nav_newmusic').style.display='none';
	   	$('nav_topratedmusic').style.display='none';
	   	$('nav_'+id_to_fetch).style.display='block';

		var musicBaseIndex='selIndex_';
		var liBase='li_';
		var spBase='sp_';

		var liActiveClass='clsActiveIndexLink';
		var thisparent=$(musicBaseIndex+id_to_fetch).parentNode;
		var nodes = $$('.musicBlockMenu li');
		nodes.each(function(node)
			{
				setClassName(node.id,'');

			});

		var someNodeList = thisparent.getElementsByTagName('DIV');
		var nodes = $A(someNodeList);
		nodes.each(function(node)
			{
				if(node.id.substring(0,9)==musicBaseIndex)
					hide(node.id);
			});
		setClassName(liBase+id_to_fetch,'clsActiveIndexLink');
		show(musicBaseIndex+id_to_fetch);
	}