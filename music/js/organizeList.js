(function() {

var Dom = YAHOO.util.Dom;
var Event = YAHOO.util.Event;
var DDM = YAHOO.util.DragDropMgr;

//////////////////////////////////////////////////////////////////////////////
// example app
//////////////////////////////////////////////////////////////////////////////
YAHOO.example.DDApp = {
    init: function() {

        var rows=3,cols=2,i,j;
        for (i=1;i<cols+1;i=i+1) {
            new YAHOO.util.DDTarget("ul"+i);
        }
		var dragDropTopContainer = document.getElementById('dhtmlgoodies_dragDropContainer');
		var modules_arr = dragDropTopContainer.getElementsByTagName('li');
		for(var i = 0; i < modules_arr.length; i++)
		{
			new YAHOO.example.DDList(modules_arr[i]);
		}
        Event.on("showButton", "click", this.showOrder);
        Event.on("switchButton", "click", this.switchStyles);
    },
    showOrder: function() {
        var parseList = function(ul) {
            var items = ul.getElementsByTagName("li");
            var out='' ;
            for (i=0;i<items.length;i=i+1) {

                out += items[i].id + ",";

            }
            return out;
        };

    },

    switchStyles: function() {
        Dom.get("li").className = "draglist_alt";
    }
};

//////////////////////////////////////////////////////////////////////////////
// custom drag and drop implementation
//////////////////////////////////////////////////////////////////////////////

YAHOO.example.DDList = function(id, sGroup, config) {

    YAHOO.example.DDList.superclass.constructor.call(this, id, sGroup, config);

    this.logger = this.logger || YAHOO;
    var el = this.getDragEl();
    Dom.setStyle(el, "opacity", 0.67); // The proxy is slightly transparent

    this.goingUp = false;
    this.lastY = 0;
};

YAHOO.example.DDList = function(id, sGroup, config) {

    YAHOO.example.DDList.superclass.constructor.call(this, id, sGroup, config);

    this.logger = this.logger || YAHOO;
    var el = this.getDragEl();
    Dom.setStyle(el, "opacity", 0.85); // The proxy is slightly transparent
	Dom.setStyle(el, "padding", "0 0 0 7px");
    this.goingUp = false;
    this.lastY = 0;
};

YAHOO.extend(YAHOO.example.DDList, YAHOO.util.DDProxy, {

    startDrag: function(x, y) {
        this.logger.log(this.id + " startDrag");
        // make the proxy look like the source element
        var dragEl = this.getDragEl();
        var clickEl = this.getEl();
        Dom.setStyle(clickEl, "visibility", "hidden");
       	dragEl.innerHTML =clickEl.innerHTML;
        Dom.setStyle(dragEl, "color", Dom.getStyle(clickEl, "color"));
        Dom.setStyle(dragEl, "backgroundColor", "#eee");
        Dom.setStyle(dragEl, "border", "1px dashed #ccc");
		Dom.setStyle(dragEl, "color", "#6C2E43");
		Dom.setStyle(dragEl, "text-align", "center");
		Dom.setStyle(dragEl, "font-weight", "bold");

    },


    endDrag: function(e) {

        var srcEl = this.getEl();
        var proxy = this.getDragEl();

        // Show the proxy element and animate it to the src element's location
        Dom.setStyle(proxy, "visibility", "");
        var a = new YAHOO.util.Motion(
            proxy, {
                points: {
                    to: Dom.getXY(srcEl)
                }
            },
            0.2,
            YAHOO.util.Easing.easeOut
        )
        var proxyid = proxy.id;
        var thisid = this.id;

        // Hide the proxy and show the source element when finished with the animation
        a.onComplete.subscribe(function() {
                Dom.setStyle(proxyid, "visibility", "hidden");
                Dom.setStyle(thisid, "visibility", "");
            });
        a.animate();
    },

    onDragDrop: function(e, id) {

        // If there is one drop interaction, the li was dropped either on the list,
        // or it was dropped on the current location of the source element.
        if (DDM.interactionInfo.drop.length === 1) {

            // The position of the cursor at the time of the drop (YAHOO.util.Point)
            var pt = DDM.interactionInfo.point;

            // The region occupied by the source element at the time of the drop
            var region = DDM.interactionInfo.sourceRegion;

            // Check to see if we are over the source element's location.  We will
            // append to the bottom of the list once we are sure it was a drop in
            // the negative space (the area of the list without any list items)
            if (!region.intersect(pt)) {
                var destEl = Dom.get(id);
                var destDD = DDM.getDDById(id);
                destEl.appendChild(this.getEl());
                destDD.isEmpty = false;
                DDM.refreshCache();
            }

        }
    },

    onDrag: function(e) {

        // Keep track of the direction of the drag for use during onDragOver
        var y = Event.getPageY(e);

        if (y < this.lastY) {
            this.goingUp = true;
        } else if (y > this.lastY) {
            this.goingUp = false;
        }

        this.lastY = y;
    },

    onDragOver: function(e, id) {

        var srcEl = this.getEl();
        var destEl = Dom.get(id);

        // We are only concerned with list items, we ignore the dragover
        // notifications for the list.
        if (destEl.nodeName.toLowerCase() == "li") {
            var orig_p = srcEl.parentNode;
            var p = destEl.parentNode;

            if (this.goingUp) {
                p.insertBefore(srcEl, destEl); // insert above
            } else {
                p.insertBefore(srcEl, destEl.nextSibling); // insert below
            }

            DDM.refreshCache();
        }
    }
});

Event.onDOMReady(YAHOO.example.DDApp.init, YAHOO.example.DDApp, true);

})(jQuery);

///*
//Preparing data to be saved
//*/
function saveDragDropNodes(playlist_id)
{

	var saveString = "";
	var dragDropTopContainer = document.getElementById('dhtmlgoodies_dragDropContainer');
	var uls = dragDropTopContainer.getElementsByTagName('UL');
	for(var no=0;no<uls.length;no++)
	{
		var lis = uls[no].getElementsByTagName('LI');
		var inc=1;
		for(var no2=0;no2<lis.length;no2++)
			{
				if(saveString.length>0)saveString = saveString + ",";
				saveString = saveString+ lis[no2].id+'_'+inc;
				inc++;
			}
	}
	var url = cfg_site_url+'music/organizePlaylist.php';
	var pars = '?order_id='+saveString+'&playlist_id='+playlist_id;
	var path = url+pars;
	$Jq.ajax({
				type: "GET",
				url: path,
				beforeSend: playlistLoadedFunc,
				success: playlistSuccessFunc
			});
}
function playlistSuccessFunc(response)
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
		$Jq('#organize_playlist').html(response);
		$Jq('#organize_playlist').addClass(clsSuccessMessage);
		$Jq('#organize_playlist').show();
		hideAnimateBlock('organize_playlist');
	}
}
function playlistLoadedFunc(response)
{
	$Jq('#organize_playlist').removeClass(clsSuccessMessage);
	$Jq('#organize_playlist').removeClass(clsErrorMessage);
	if($Jq('#selLoading').length > 0)
		$Jq('#organize_playlist').html($Jq('#selLoading').html());
	else
		$Jq('#organize_playlist').html(organize_playlist_ajax_page_loading);
	$Jq('#organize_playlist').show();
}
function saveFeaturedMusicDragDropNodes()
{

	var saveString = "";
	var dragDropTopContainer = document.getElementById('dhtmlgoodies_dragDropContainer');
	var uls = dragDropTopContainer.getElementsByTagName('UL');
	for(var no=0;no<uls.length;no++)
	{
		var lis = uls[no].getElementsByTagName('LI');
		var inc=1;
		for(var no2=0;no2<lis.length;no2++)
			{
				if(saveString.length>0)saveString = saveString + ",";
				saveString = saveString+ lis[no2].id+'_'+inc;
				inc++;
			}
	}
	var url = cfg_site_url+'admin/music/musicFeaturedReorder.php';
	var pars = '?order_id='+saveString;
	var path = url+pars;
	$Jq.ajax({
				type: "GET",
				url: path,
				beforeSend: playlistLoadedFunc,
				success: playlistSuccessFunc
			});
}