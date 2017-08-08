<?php /* Smarty version 2.6.18, created on 2012-02-02 22:34:32
         compiled from addPhotoLocation.tpl */ ?>
<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('block_add_location')): ?>
<div id="selResult" class="clsLocationResult" style="display:none;"><!-- --></div>
 <div id="map_canvas" class="clsGoogleLocationMap"><!-- --></div>
   <div class="clsOverflow clsPhotoMapOptions">
  <div id="selSeletedArea" class="clsGoogleSelectedArea"><!-- --></div>
  <div id="selInitialStep" class="clsInitialStep"><a href="javascript:;" onclick="setSearch();" title="" ><?php echo $this->_tpl_vars['LANG']['photo_location_set_location']; ?>
</a></div>

	<div id="selSearchNote" class="clsSearchNote" style="display:none;"><?php echo $this->_tpl_vars['LANG']['photo_location_search_note']; ?>
</div>
	<div id="selSearchNote2" class="clsSearchNote2" style="display:none;"><?php echo $this->_tpl_vars['LANG']['photo_location_search_note2']; ?>
</div>
	<div id="selHelpNote" class="clsHelpNote" style="display:none;"><?php echo $this->_tpl_vars['LANG']['photo_location_help']; ?>
</div>
    <div class="clsOverflow">
     <div class="clsSetLocationLeft">
	  <div id="selPin" class="clsPin" style="display:none;"><a href="javascript:;" onclick="setMarkerOnMap();" title="<?php echo $this->_tpl_vars['LANG']['photo_location_click_me_to_add_pin']; ?>
"><img src="<?php echo $this->_tpl_vars['CFG']['site']['photo_url']; ?>
design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/root/images/<?php echo $this->_tpl_vars['CFG']['html']['stylesheet']['screen']['default']; ?>
/icon-googlelocation.gif" alt="<?php echo $this->_tpl_vars['LANG']['photo_location_click_me_to_add_pin']; ?>
"/></a></div>
     </div>
     <div class="clsSetLocationRight">
	  <form name="addLocation" method="post" action="" autocomplete="off">
		<div  id="selLocationTextBox" class="clsLocationTextBox" style="display:none;">
			<input type="text" name="location" id="location" onfocus="emptyTextBox()" onblur="refileValue('<?php echo $this->_tpl_vars['LANG']['photo_location_city_name']; ?>
')" onkeypress="sendcode()" value="<?php echo $this->_tpl_vars['LANG']['photo_location_city_name']; ?>
"/>
		</div>
		<div id="results" class="clsGoogleAreaResult clsPointer" style="display:none;"><!-- --></div>
		<input type="hidden" name="latitude" id="latitude" value='' />
		<input type="hidden" name="longitude" id="longitude" value='' />
		<input type="hidden" name="address" id="address" value='' />
        <input type="hidden" name="photo_id_location" id="photo_id_location" value="<?php echo $this->_tpl_vars['myobj']->getFormField('photo_id'); ?>
" />

	</form>
     </div>
    </div>
	<div id="selUpdateButton" class="clsLocationChange" style="display:none;"> <a onclick="updateLocation('<?php echo $this->_tpl_vars['CFG']['site']['photo_url']; ?>
photoList.php?type=update_location&photo_id=<?php echo $this->_tpl_vars['myobj']->getFormField('photo_id'); ?>
','selResult');" /><?php echo $this->_tpl_vars['LANG']['common_update']; ?>
</a></div>
	<div id="selChange" class="clsLocationCancel" style="display:none"><a href="javascript:void(0);" onClick="changeLocation();" title="<?php echo $this->_tpl_vars['LANG']['common_change']; ?>
"><?php echo $this->_tpl_vars['LANG']['common_change']; ?>
</a></div>
	 <div id="selCancel" class="clsLocationCancel" style="display:none"><a href="javascript:void(0);" onClick="cancelChange();" title="<?php echo $this->_tpl_vars['LANG']['common_change']; ?>
"><?php echo $this->_tpl_vars['LANG']['common_cancel']; ?>
</a></div>
	 <div id="selRemove" class="clsLocationChange" style="display:none"><a href="javascript:void(0);" onClick="removeLocation('<?php echo $this->_tpl_vars['CFG']['site']['photo_url']; ?>
photoList.php?type=remove_location&photo_id=<?php echo $this->_tpl_vars['myobj']->getFormField('photo_id'); ?>
','selResult');" title="<?php echo $this->_tpl_vars['LANG']['common_remove']; ?>
"><?php echo $this->_tpl_vars['LANG']['common_remove']; ?>
</a></div>

    </div>
	<?php echo '
	<script language="javascript">
		$Jq(document).ready(function(){
		  initializegoogleMap();
		});
	</script>
	'; ?>

<?php endif; ?>