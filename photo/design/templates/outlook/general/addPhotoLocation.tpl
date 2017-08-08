{if $myobj->isShowPageBlock('block_add_location')}
<div id="selResult" class="clsLocationResult" style="display:none;"><!-- --></div>
 <div id="map_canvas" class="clsGoogleLocationMap"><!-- --></div>
   <div class="clsOverflow clsPhotoMapOptions">
  <div id="selSeletedArea" class="clsGoogleSelectedArea"><!-- --></div>
  <div id="selInitialStep" class="clsInitialStep"><a href="javascript:;" onclick="setSearch();" title="" >{$LANG.photo_location_set_location}</a></div>

	<div id="selSearchNote" class="clsSearchNote" style="display:none;">{$LANG.photo_location_search_note}</div>
	<div id="selSearchNote2" class="clsSearchNote2" style="display:none;">{$LANG.photo_location_search_note2}</div>
	<div id="selHelpNote" class="clsHelpNote" style="display:none;">{$LANG.photo_location_help}</div>
    <div class="clsOverflow">
     <div class="clsSetLocationLeft">
	  <div id="selPin" class="clsPin" style="display:none;"><a href="javascript:;" onclick="setMarkerOnMap();" title="{$LANG.photo_location_click_me_to_add_pin}"><img src="{$CFG.site.photo_url}design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/icon-googlelocation.gif" alt="{$LANG.photo_location_click_me_to_add_pin}"/></a></div>
     </div>
     <div class="clsSetLocationRight">
	  <form name="addLocation" method="post" action="" autocomplete="off">
		<div  id="selLocationTextBox" class="clsLocationTextBox" style="display:none;">
			<input type="text" name="location" id="location" onfocus="emptyTextBox()" onblur="refileValue('{$LANG.photo_location_city_name}')" onkeypress="sendcode()" value="{$LANG.photo_location_city_name}"/>
		</div>
		<div id="results" class="clsGoogleAreaResult clsPointer" style="display:none;"><!-- --></div>
		<input type="hidden" name="latitude" id="latitude" value='' />
		<input type="hidden" name="longitude" id="longitude" value='' />
		<input type="hidden" name="address" id="address" value='' />
        <input type="hidden" name="photo_id_location" id="photo_id_location" value="{$myobj->getFormField('photo_id')}" />

	</form>
     </div>
    </div>
	<div id="selUpdateButton" class="clsLocationChange" style="display:none;"> <a onclick="updateLocation('{$CFG.site.photo_url}photoList.php?type=update_location&photo_id={$myobj->getFormField('photo_id')}','selResult');" />{$LANG.common_update}</a></div>
	<div id="selChange" class="clsLocationCancel" style="display:none"><a href="javascript:void(0);" onClick="changeLocation();" title="{$LANG.common_change}">{$LANG.common_change}</a></div>
	 <div id="selCancel" class="clsLocationCancel" style="display:none"><a href="javascript:void(0);" onClick="cancelChange();" title="{$LANG.common_change}">{$LANG.common_cancel}</a></div>
	 <div id="selRemove" class="clsLocationChange" style="display:none"><a href="javascript:void(0);" onClick="removeLocation('{$CFG.site.photo_url}photoList.php?type=remove_location&photo_id={$myobj->getFormField('photo_id')}','selResult');" title="{$LANG.common_remove}">{$LANG.common_remove}</a></div>

    </div>
	{literal}
	<script language="javascript">
		$Jq(document).ready(function(){
		  initializegoogleMap();
		});
	</script>
	{/literal}
{/if}