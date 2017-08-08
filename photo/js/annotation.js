var tag={};tag.photo={};
tag.photo.editingContactAnnotation=false;tag.photo.contactAnnotations=new Array();
tag.photo.addIdentityTag=function(){if(tag.photo.editingContactAnnotation){return;}
tag.photo.editingContactAnnotation=true;tag.photo.latestContactAnnotation=new ContactAnnotation('photo-area',{width:canvas_tag_width,height:canvas_tag_height,top:50,left:50},{editable:true,showEdit:true,photoId:tag.photo.id,shareOnTag:tag.photo.shareOnIdentityTags});}

tag.photo.removeIdentityTag=function(tagId,taggedUserId,mCookie){
	var params={action:'remove_identity_tag',tag_id:tagId,magic_cookie:mCookie};
	new Ajax.Request(ajax_photo_tagging_url,{
		method:'post',
		onCreate:function(){$('idt-tag-id_'+tagId).update('<div><div style="float:left;">'+$('idt-tag-id_'+tagId).innerHTML+'</div><div id="idt-indicator_'+tagId+'" style="padding: 5px 0 0 10px;float:left;"><img src="'+search_loader_icon+'"/></div></div>');},
		onSuccess:function(transport){
			if(transport.responseText=='1'){
				$('idt-tag-id_'+tagId).remove();
				//$('balloon').style.display='none';
				var taggedUsers=$('idt-tagged-users').value.split(',');
				if(taggedUsers.indexOf(taggedUserId)>-1){
					taggedUsers.splice(taggedUsers.indexOf(taggedUserId),1);
					$('idt-tagged-users').value=taggedUsers.join(',');
				}
				tag.photo.removeContactAnnotation(tagId);
			}else{
				$('idt-indicator_'+tagId).remove();
				$('idt-tag-id_'+tagId).insert(new Element('span',{className:'error-background'}).update(annotation_lang_error_occured));
			}
		},
		parameters:params
	});
}

tag.photo.removeAssociate=function(tagId,taggedUserId,mCookie){
	var params={action:'remove_associate',tag_id:tagId,magic_cookie:mCookie};
	new Ajax.Request(ajax_photo_tagging_url,{
		method:'post',
		onCreate:function(){$('idt-tag-id_'+tagId).update('<div class="relative"></div>');},
		onSuccess:function(transport){
			var result;
			try{result=transport.responseText.evalJSON(true);}catch(ex){}
			if(typeof(result)!='object'){return;}
			var deleteLink=new Element('a',{className:'clsPhotoVideoEditLinks',title:annotation_lang_canvas_delete}).insert(new Element('img',{src:delete_photo_tag_icon}));
			if(result.photo_url== no_people_photo_icon &&!Prototype.Browser.IE){
				var profileImg=new Element('canvas',{width:canvas_tag_width+'px',height:canvas_tag_height+'px',className:'idt-photo'});
				var ctx=profileImg.getContext("2d");
				var img =  $('photo_'+tag.photo.id);
				ctx.drawImage(img,parseInt(result.coord_x),parseInt(result.coord_y),parseInt(result.width),parseInt(result.height),0,0,parseInt(canvas_tag_width),parseInt(canvas_tag_height));
				img.src=$('photo_'+tag.photo.id).src;
			}else{
				var profileImg=new Element('img',{src:result.photo_url,alt:result.identity_text,className:'idt-photo',width:canvas_tag_width,height:canvas_tag_height})
			}
			//var li_div= new Element('div',{className:'relative'}).insert(new Element('a',{href:people_photo_tagged_url+'?'+(result.tagged_username!=''?'people='+result.tagged_username+'&tag=all&block=all':'tag_name='+result.identity_text+'&tag=all&block=all')}).insert(profileImg)).insert(new Element('div',{className:'idt-quick-link-del'}).insert(deleteLink));
  			var li_div= new Element('div',{className:'relative'}).insert(new Element('a',{href:people_photo_tagged_url+'?'+(result.tagged_username!=''?'people='+result.tagged_username+'&tag=all&block=all':'tag_name='+result.identity_text+'&tag=all&block=all')}).insert(profileImg)).insert(new Element('div',{className:'clsPeoplePhoto',id:'delete_canvas_link_'+tagId, style:'display:none'}).insert(new Element('div',{className:'idt-quick-link-del'}).insert(deleteLink)));
			var li=$('idt-tag-id_'+tagId).update(li_div);
			if(!$('idt-highlight-link')){
				var hLink=new Element('a',{id:'idt-highlight-link',href:'javascript:;'}).update(annotation_lang_highlight_all);
				Event.observe(hLink,'click',tag.photo.toggleAllTaggedIdentities);
				$('idt-tag-list').next(0).insert(hLink);
			}
			//Event.observe(deleteLink,'mouseover',ShowPhotoLinkBalloonHolder);Event.observe(deleteLink,'mouseout',HideBalloonHolder);
			Event.observe(deleteLink,'click',function(){tag.photo.removeIdentityTag(tagId,tagId,result.mcookie);});
			Event.observe(li,'mouseover',function(){tag.photo.highlightIdentityTag(tagId);});
			Event.observe(li,'mouseout',function(){tag.photo.unhighlightIdentityTag(tagId);});
		},
		parameters:params});
}

tag.photo.removeContactAnnotation=function(id){
	for(var i=0;i<tag.photo.contactAnnotations.length;i++){
		if(tag.photo.contactAnnotations[i].id==id){
			tag.photo.contactAnnotations[i].destroy();
			tag.photo.contactAnnotations.splice(i,1);
		}
	}
}

tag.photo.unhighlightIdentityTag=function(id){
	for(var i=0;i<tag.photo.contactAnnotations.length;i++){
		if(!id||tag.photo.contactAnnotations[i].id==id){
			if($('delete_canvas_link_'+id))$('delete_canvas_link_'+id).style.display='none';
			tag.photo.contactAnnotations[i].hideNote();
		}
	}
}

tag.photo.highlightIdentityTag=function(id){
	for(var i=0;i<tag.photo.contactAnnotations.length;i++){
		if(!id||tag.photo.contactAnnotations[i].id==id){
			if($('delete_canvas_link_'+id))$('delete_canvas_link_'+id).style.display='block';
			tag.photo.contactAnnotations[i].showNote();
		}
	}
}

tag.photo.toggleAllTaggedIdentities=function(evt){
	var element=Event.element(evt);
	if(element.innerHTML==annotation_lang_highlight_all){
		element.update(annotation_lang_unhighlight_all);
	}else{
		element.update(annotation_lang_highlight_all);
	}
	tag.photo.toggleTaggedIdentities();
}

tag.photo.toggleTaggedIdentities=function(requestingElement){
	var lockIt=tag.photo.contactAnnotations[0].isLockedState()?false:true;
	for(var i=0;i<tag.photo.contactAnnotations.length;i++){
		if(lockIt){
			tag.photo.contactAnnotations[i].toggleNote();
			tag.photo.contactAnnotations[i].setLockedState(lockIt);
		}else{
			tag.photo.contactAnnotations[i].setLockedState(lockIt);
			tag.photo.contactAnnotations[i].toggleNote();
		}
	}
}

function hoverElement(obj,event,element,options){
	options=options||{};
	var container=new Element('div',{className:'hover-container'}).setStyle({position:'absolute',zIndex:'99999'});
	container.insert(new Element('div',{className:'drop-shadow'}).setStyle({top:'2px',left:'2px',zIndex:'-1'}));
	container.insert(element);
	container.clonePosition(obj,{setWidth:false,setHeight:false,offsetTop:obj.getDimensions().height+5});
	obj.currentTimeout=setTimeout(function(){
		document.body.insert(container);
		obj.currentTimeout=false;
		if(options.onVisible){options.onVisible();}
	},200);
	if(obj.hoverElementMouseMove){
		obj.stopObserving('mousemove',obj.hoverElementMouseMove);
	}
	obj.hoverElementMouseMove=function(event){
		container.setStyle({left:(event.pointerX()+10)+'px',top:(event.pointerY()+10)+'px'});
	};
	obj.observe('mousemove',obj.hoverElementMouseMove);
	if(obj.hoverElementMouseOut){obj.stopObserving('mouseout',obj.hoverElementMouseOut);}
	obj.hoverElementMouseOut=function(obj,container){
		if(obj.currentTimeout){clearTimeout(obj.currentTimeout);return;}
		container.remove();
	}.bind(this,obj,container);
	obj.observe('mouseout',obj.hoverElementMouseOut);
}

function hoverImage(obj,event,path){var element=new Element('img',{src:path}).setStyle({border:'1px solid black'});hoverElement(obj,event,element);}

TAG_Autocompleter=Class.create(Autocompleter.Base,{initialize:function(element,update,arrayOrUrl,options){this.baseInitialize(element,update,options);this.options.dataSource=arrayOrUrl;if(Object.isArray(arrayOrUrl))this.options.array=arrayOrUrl;this.originalUpdateElement=this.updateElement;this.updateElement=this.beforeUpdateElement;},beforeUpdateElement:function(selectedElement){this.originalUpdateElement(selectedElement);this.lastEntry=this.element.value;},getUpdatedChoices:function(){this.startIndicator();if(this.ajaxRequestIsRunning)return;if(typeof this.options.array=='undefined'&&Object.isString(this.options.dataSource)){this.ajaxRequestIsRunning=true;this.options.array=this.fetchData(this.options.dataSource,this.options.ajaxOptions);}else{this.updateChoices(this.options.selector(this));}},fetchData:function(url,options){options=Object.extend({onComplete:this.onComplete.bind(this)},options||{});new Ajax.Request(url,options);},onComplete:function(transport){this.ajaxRequestIsRunning=false;this.options.array=transport.responseText.evalJSON(true);this.updateChoices(this.options.selector(this));},setOptions:function(options){this.options=Object.extend({choices:10,partialSearch:true,partialChars:2,ignoreCase:true,fullSearch:false,onNoResultsFound:options.onNoResultsFound||Prototype.emptyFunction,selector:function(instance){var ret=[];var partial=[];var entry=instance.getToken();var count=0;for(var i=0;i<instance.options.array.length&&ret.length<instance.options.choices;i++){var elem=instance.options.array[i].text;if(Object.isArray(instance.options.excludeList)){if(instance.options.excludeList.indexOf(instance.options.array[i].id)>=0)continue;}
var foundPos=instance.options.ignoreCase?elem.toLowerCase().indexOf(entry.toLowerCase()):elem.indexOf(entry);while(foundPos!=-1){if(foundPos==0&&elem.length!=entry.length){if(Object.isFunction(instance.options.formatItem))
ret.push(instance.options.formatItem(instance.options.array[i],i,foundPos,entry.length));else
ret.push("<li><strong>"+elem.substr(0,entry.length)+"</strong>"+
elem.substr(entry.length)+"</li>");break;}else if(foundPos==0&&entry.length==elem.length){if(Object.isFunction(instance.options.formatItem))
ret.push(instance.options.formatItem(instance.options.array[i],i,foundPos,entry.length));else
ret.push("<li><strong>"+elem+"</strong></li>");}else if(entry.length>=instance.options.partialChars&&instance.options.partialSearch&&foundPos!=-1){if(instance.options.fullSearch||/\s/.test(elem.substr(foundPos-1,1))){if(Object.isFunction(instance.options.formatItem))
partial.push(instance.options.formatItem(instance.options.array[i],i,foundPos,entry.length));else
partial.push("<li>"+elem.substr(0,foundPos)+"<strong>"+
elem.substr(foundPos,entry.length)+"</strong>"+elem.substr(foundPos+entry.length)+"</li>");break;}}
foundPos=instance.options.ignoreCase?elem.toLowerCase().indexOf(entry.toLowerCase(),foundPos+1):elem.indexOf(entry,foundPos+1);}}
if(instance.lastEntry!=entry){instance.lastEntry=entry;if(ret.length==0&&!partial.length)instance.options.onNoResultsFound();}
if(partial.length)
ret=ret.concat(partial.slice(0,instance.options.choices-ret.length))
return"<ul>"+ret.join('')+"</ul>";}},options||{});}});

var Annotation=Class.create({initialize:function(container,rect,options){this.rect=rect;this.options=options;this.editable=options.editable||false;this.editMode=false;this.container=$(container);this.id=this.options.id||new Date().getTime();this.idSuffix=this.id;this.dragHandle='an-handle_'+this.idSuffix;this.annotationAreaId='an-area_'+this.idSuffix;this.outerBorderId='annotation-outer-border_'+this.idSuffix;this.middleBorderId=this.dragHandle;this.innerBorderId='annotation-inner-border_'+this.idSuffix;this.outerBorderHighlight='annotation-outer-border';this.initElements();this.initEvents();},initElements:function(){var innerBorder=new Element('div',{id:this.innerBorderId,className:'annotation-inner-border'});if(Prototype.Browser.IE){innerBorder.insert(new Element('div').setStyle({height:'100%',backgroundColor:'white',opacity:'0'}));}
this.annotationArea=new Element('div',{id:this.annotationAreaId,className:'annotation-area'});this.annotationArea.insert(new Element('div',{id:this.outerBorderId,className:'annotation-outer-table'}).insert(new Element('div',{id:this.dragHandle,className:'annotation-middle-border'}).insert(new Element('div',{className:'table-div'}).insert(innerBorder))));this.annotationArea.insert(new Element('div',{className:'resize-box resize-tl'}).setStyle({display:'none'}));this.annotationArea.insert(new Element('div',{className:'resize-box resize-tm'}).setStyle({display:'none'}));this.annotationArea.insert(new Element('div',{className:'resize-box resize-tr'}).setStyle({display:'none'}));this.annotationArea.insert(new Element('div',{className:'resize-box resize-ml'}).setStyle({display:'none'}));this.annotationArea.insert(new Element('div',{className:'resize-box resize-mr'}).setStyle({display:'none'}));this.annotationArea.insert(new Element('div',{className:'resize-box resize-bl'}).setStyle({display:'none'}));this.annotationArea.insert(new Element('div',{className:'resize-box resize-bm'}).setStyle({display:'none'}));this.annotationArea.insert(new Element('div',{className:'resize-box resize-br'}).setStyle({display:'none'}));this.annotationArea.setStyle({top:this.rect.top+'px',left:this.rect.left+'px',width:this.rect.width+'px',height:this.rect.height+'px'});this.container.insert(this.annotationArea);},initEvents:function(){this.boundMouseOverOuterBorder=this.options.onMouseOver||this.mouseOverOuterBorder.bind(this);this.boundMouseOutOuterBorder=this.options.onMouseOut||this.mouseOutOuterBorder.bind(this);this.boundOnClick=this.onClick.bind(this);Event.observe(this.annotationArea,'mouseover',this.boundMouseOverOuterBorder);Event.observe(this.annotationArea,'mouseout',this.boundMouseOutOuterBorder);Event.observe(this.annotationArea,'click',this.boundOnClick);},mouseOverOuterBorder:function(){this.highlight();},mouseOutOuterBorder:function(){this.unhighlight();},onClick:function(){if(this.options.editOnClick){this.setEditable(true);}},highlight:function(){$(this.outerBorderId).addClassName(this.outerBorderHighlight);},unhighlight:function(){$(this.outerBorderId).removeClassName(this.outerBorderHighlight);},hide:function(){this.annotationArea.hide();},show:function(){this.annotationArea.show();},setEditable:function(editable){if(!this.editable){return;}
if(editable&&this.editMode){return;}
if(editable){Event.stopObserving(this.annotationArea,'mouseover',this.boundMouseOverOuterBorder);Event.stopObserving(this.annotationArea,'mouseout',this.boundMouseOutOuterBorder);this.editMode=true;if(this.options.draggableOptions.change){this.suppliedDraggableOnChange=this.options.draggableOptions.change;this.options.draggableOptions.change=this.onRectChange.bind(this);}
if(this.options.resizableOptions.onResize){this.suppliedResizableOnResize=this.options.resizableOptions.onResize;this.options.resizableOptions.onResize=this.onRectChange.bind(this);}
this.draggable=new Draggable(this.annotationAreaId,Object.extend(this.options.draggableOptions||{},{handle:this.dragHandle}));this.resizable=new Resizable(this.annotationAreaId,this.options.resizableOptions||{});this.highlight();this.annotationArea.addClassName('annotation-movable');this.annotationArea.select('div.resize-box').each(function(elem){elem.show();});if(this.options.onEditBegin){this.options.onEditBegin();}}else{this.editMode=false;this.annotationArea.removeClassName('annotation-movable');this.unhighlight();Event.observe(this.annotationArea,'mouseover',this.boundMouseOverOuterBorder);Event.observe(this.annotationArea,'mouseout',this.boundMouseOutOuterBorder);this.draggable.destroy();this.resizable.destroy();this.annotationArea.select('div.resize-box').each(function(elem){elem.hide();});if(this.options.onEditEnd){this.options.onEditEnd();}}},onRectChange:function(obj){var elem=obj.element;this.rect={height:elem.getHeight(),width:elem.getWidth(),top:parseInt(elem.getStyle('top')),left:parseInt(elem.getStyle('left'))};this.suppliedDraggableOnChange(obj);this.suppliedResizableOnResize(obj);},destroy:function(){if(this.editMode){this.draggable.destroy();this.resizable.destroy();}
this.annotationArea.remove();},getRect:function(){return this.rect;}});

var ContactAnnotation=Class.create({initialize:function(container,rect,options,contact){
	this.container=$(container);
	this.contact=contact;
	this.editable=options.editable||false;
	this.lockedState=false;
	this.options=options;
	if(this.editable){
		var annotationOptions={
			draggableOptions:{change:this.annotationRectChange.bind(this),snap:this.annotationSnap.bind(this)},
			resizableOptions:{onResize:this.annotationRectChange.bind(this),bind:true},
			onEditBegin:this.onEditBegin.bind(this),
			onEditEnd:this.onEditEnd.bind(this),
			editable:true,
			onMouseOver:this.showNote.bind(this),
			onMouseOut:this.hideNote.bind(this)
		};
	}else{
		var annotationOptions={
			editable:false,
			onMouseOver:this.showNote.bind(this),
			onMouseOut:this.hideNote.bind(this)
		};
	}
	this.id=options.id;
	this.annotation=new Annotation(container,rect,annotationOptions);
	this.initElements();
	if(options.showEdit){
		this.annotation.setEditable(true);
	}
},initElements:function(){
	if(this.editable){this.initSearchElements();}else{this.initNoteElements();}
},initNoteElements:function(){
	this.note=new Element('div',{className:'annotation-note'}).setStyle({display:'none'}).update(this.contact.name);
	if(this.options.hidden){
		this.note.setStyle({display:'none'});
		$(this.annotation.outerBorderId).removeClassName('annotation-outer-border');
		$(this.annotation.middleBorderId).removeClassName('annotation-middle-border');
		$(this.annotation.innerBorderId).removeClassName('annotation-inner-border');
	}
	Element.insert(this.annotation.annotationArea,{after:this.note});
	this.note.clonePosition(this.annotation.annotationArea,{setWidth:false,setHeight:false,offsetTop:this.annotation.annotationArea.getDimensions().height+5});
	this.boundShowNote=this.showNote.bind(this);
	this.boundHideNote=this.hideNote.bind(this);},initSearchElements:function(){this.searchContainer=new Element('div',{id:'contact-search-container',className:'contact-search-container'}).insert('<div style="width:200px;"><span style="float:left;">'+annotation_lang_contact_name+':</span><span style="float:right;font-size:9px;"><a href="javascript:;" onclick="tag.photo.latestContactAnnotation.toggleEmailMore();">'+annotation_lang_add_new+'</a></span></div>');
	this.searchField=new Element('input',{type:'text',id:'contact-search',name:'autocomplete_parameter',value:annotation_lang_find_contact,maxlength:annotation_tag__maxlength});
	this.searchField.observe('focus',function(e){e.element().select();});
	this.searchContainer.insert(this.searchField);
	this.searchContainer.insert(new Element('span',{id:'contact-search-indicator'}).setStyle({display:'none'}).insert(new Element('img',{src:search_loader_icon,alt:annotation_lang_contact_loading}))).insert('<br/>');
	this.searchContainer.insert(new Element('div',{id:'contact-search-results',className:'list-result-container'}).setStyle({display:'none'}));
	this.idtEmailContainer=new Element('div',{id:'add-identity-email'}).setStyle({display:'none'});
	this.idtEmailContainer.insert(annotation_lang_email+':<br/>');
	this.idtEmailContainer.insert(new Element('input',{id:'add-identity-email-field',type:'text'}));
	this.searchContainer.insert(this.idtEmailContainer);
	this.idtEmailContainer.insert('<br/>');
	var consolidateChkBox=new Element('input',{type:'checkbox',id:'idt-associate-check'}).setStyle({verticalAlign:'middle',border:'none'})
	if(this.options.shareOnTag)consolidateChkBox.setAttribute('checked','checked');
	this.idtEmailContainer.insert(consolidateChkBox);
	this.idtEmailContainer.insert('&nbsp;<label for="idt-consolidate-check">'+annotation_lang_associate_user+'</label><br/>');
	this.saveButton=new Element('input',{type:'button',value:annotation_lang_button_save,className:'clsPopUpButtonSubmit'});
	this.searchContainer.insert(this.saveButton).insert('&nbsp');
	this.cancelButton=new Element('input',{type:'button',value:annotation_lang_button_cancel,className:'clsPopUpButtonReset'});
	this.searchContainer.insert(this.cancelButton);
	this.searchContainer.setStyle({display:'none'});
	Element.insert(this.annotation.annotationArea,{after:this.searchContainer});
	this.autocompleter=new TAG_Autocompleter(
		'contact-search',
		'contact-search-results',
		ajax_photo_contact_url,
		{
			ajaxOptions:{
				parameters:{action:'get_user_identities_autocomplete',include_me:'true'}
			},
			indicator:'contact-search-indicator',
			formatItem:this.formatContactItem,updateElement:this.contactSelected.bind(this),
			onNoResultsFound:this.onNoResultsFound.bind(this),
			excludeList:$('idt-tagged-users').value.split(',')
		}
	);
	Event.observe('contact-search','keyup',function(evt){$$('.hover-container').each(function(e){e.remove();})});
	this.boundSave=this.save.bind(this);
	Event.observe(this.saveButton,'click',this.boundSave);
	Event.observe(this.cancelButton,'click',this.onCancel.bind(this));
	Event.observe(this.searchField,'keyup',this.onSearchFieldKeyDown.bind(this));
},onSearchFieldKeyDown:function(event){
	if(this.contact&&this.searchField.value!=this.contact.name){this.contact=null;}
	if(!$('contact-search-results').visible()&&event.which==Event.KEY_RETURN){this.save();}
},isLockedState:function(){
	return this.lockedState;
},setLockedState:function(lock){
	this.lockedState=lock;
},showNote:function(){
	if(this.isLockedState()){return;}
	this.note.getStyle('display');
	this.annotation.annotationArea.addClassName('tag_highlight');
	this.note.show();
	var tag=$('idt-tag-id_'+this.id);
	if(tag)tag.select('.idt-photo').each(function(e){e.addClassName('idt-photo-highlight');});
},hideNote:function(){
	if(this.isLockedState()){return;}
	this.note.getStyle('display');
	this.annotation.annotationArea.removeClassName('tag_highlight');
	this.note.hide();
	var tag=$('idt-tag-id_'+this.id);
	if(tag)tag.select('.idt-photo').each(function(e){e.removeClassName('idt-photo-highlight');});
},toggleNote:function(){
	if(this.note.visible()){this.hideNote();}else{this.showNote();}
},onEditBegin:function(){
	this.annotationRectChange({element:this.annotation.annotationArea});
	this.searchContainer.show();
	this.searchField.focus();
},onEditEnd:function(){
	if(this.searchContainer)this.searchContainer.hide();
},annotationSnap:function(x,y,draggable){
	var maxDim=this.container.getDimensions();
	var elemDim=draggable.element.getDimensions();
	var maxX=maxDim.width-elemDim.width;
	var maxY=maxDim.height-elemDim.height;
	var newX,newY;
	newX=x>0?x:0;
	newX=x>maxX?maxX:newX;
	newY=y>0?y:0;
	newY=y>maxY?maxY:newY;
	return[newX,newY];
},annotationRectChange:function(obj){
	var elem=obj.element;
	$('contact-search-container').clonePosition(elem,{setWidth:false,setHeight:false,offsetLeft:elem.getDimensions().width+20});
},contactSelected:function(liObj){
	$('contact-search').value=liObj.down('span').innerHTML;
	this.contact={id:liObj.id.split('_')[1],name:$('contact-search').value,email:$('add-identity-email-field').value};
},onSaveSuccess:function(transport){
	var result;
	try{result=transport.responseText.evalJSON(true);}catch(ex){}
	if(typeof(result)!='object'){this.onSaveFailure(transport);return;}
	$('selHighlightLink').style.display='block';
	var taggedUsers=$('idt-tagged-users').value.split(',');
	taggedUsers.push(this.contact.id);
	$('idt-tagged-users').value=taggedUsers.join(',');
	var assoLink=new Element('div',{className:'idt-associate-remove-link'});
	var assoLink2=new Element('a',{className:'clsPhotoVideoEditLinks',title:annotation_lang_assoc_delete}).insert(new Element('img',{src:associate_tag_icon}));
	var associateLink=assoLink.insert(assoLink2);
	var deleteLink=new Element('a',{className:'clsPhotoVideoEditLinks',title:annotation_lang_canvas_delete}).insert(new Element('img',{src:delete_photo_tag_icon}));
	if(result.photo_url== no_people_photo_icon && !Prototype.Browser.IE){
		var profileImg=new Element('canvas',{width:canvas_tag_width+'px',height:canvas_tag_height+'px',className:'idt-photo'});
		var ctx=profileImg.getContext("2d");
		var img =  $('photo_'+tag.photo.id);
		ctx.drawImage(img, parseInt(result.coord_x),parseInt(result.coord_y),parseInt(result.width),parseInt(result.height),0,0,parseInt(canvas_tag_width),parseInt(canvas_tag_height));
		img.src=$('photo_'+tag.photo.id).src;
	}else{
		var profileImg=new Element('img',{src:result.photo_url,alt:result.identity_text,className:'idt-photo',width:canvas_tag_width,height:canvas_tag_width})
	}
	if(result.tagged_username=='')
		var li=new Element('li',{id:'idt-tag-id_'+result.tag_id,className:'idt-tag'}).insert(new Element('div',{className:'relative'}).insert(new Element('a',{href:people_photo_tagged_url+'?'+(result.tagged_username!=''?'people='+result.tagged_username+'&tag=all&block=all':'tag_name='+result.identity_text+'&tag=all&block=all')}).insert(profileImg)).insert(new Element('div',{className:'clsPeoplePhoto',id:'delete_canvas_link_'+result.tag_id, style:'display:none'}).insert(new Element('div',{className:'idt-quick-link-del'}).insert(deleteLink))));
	else
		var li=new Element('li',{id:'idt-tag-id_'+result.tag_id,className:'idt-tag'}).insert(new Element('div',{className:'relative'}).insert(new Element('a',{href:people_photo_tagged_url+'?'+(result.tagged_username!=''?'people='+result.tagged_username+'&tag=all&block=all':'tag_name='+result.identity_text+'&tag=all&block=all')}).insert(profileImg)).insert(new Element('div',{className:'clsPeoplePhoto',id:'delete_canvas_link_'+result.tag_id, style:'display:none'}).insert(associateLink).insert(new Element('div',{className:'idt-quick-link-del'}).insert(deleteLink))));
	if(!$('idt-highlight-link')){
		var hLink=new Element('a',{id:'idt-highlight-link',href:'javascript:;'}).update(annotation_lang_highlight_all);
		Event.observe(hLink,'click',tag.photo.toggleAllTaggedIdentities);
		$('idt-tag-list').next(0).insert(hLink);
	}
	//Event.observe(assoLink2,'mouseover',ShowPhotoLinkBalloonHolder);
	//Event.observe(assoLink2,'mouseout',HideBalloonHolder);
	//Event.observe(deleteLink,'mouseover',ShowPhotoLinkBalloonHolder);
	//Event.observe(deleteLink,'mouseout',HideBalloonHolder);
	Event.observe(associateLink,'click',function(){tag.photo.removeAssociate(result.tag_id,result.tagged_identity_id,result.mcookie);});
	Event.observe(deleteLink,'click',function(){tag.photo.removeIdentityTag(result.tag_id,result.tagged_identity_id,result.mcookie);});
	Event.observe(li,'mouseover',function(){tag.photo.highlightIdentityTag(result.tag_id);});
	Event.observe(li,'mouseout',function(){tag.photo.unhighlightIdentityTag(result.tag_id);});
	Element.insert($('add-identity-tag'),{before:li});
	this.id=result.tag_id;
	tag.photo.contactAnnotations.push(this);
	tag.photo.editingContactAnnotation=false;
},onSaveFailure:function(transport){
	tag.photo.editingContactAnnotation=false;
	$('photo_response_text').update('<span class="feedback-background">'+transport.responseText+'</span>');
	this.destroy();
},save:function(){
	if(!$('contact-search').value)return false;
	if(!this.options.photoId){throw("Saving requires photoId option");}
	if(!this.contact){this.contact={id:0,name:$F('contact-search'),email:$('add-identity-email-field').value};}
	this.initNoteElements();
	var rect=this.annotation.getRect();
	var params={action:'save_identity_tag',coord_x:rect.left,coord_y:rect.top,width:rect.width,height:rect.height,photo_id:this.options.photoId,tagged_identity_id:this.contact.id,identity_text:this.contact.name,email:this.contact.email,	photo_owner_id:photo_owner_id};
	params.associate=$('idt-associate-check').checked?1:0;
	this.autocompleter.options.indicator=false;
	this.searchContainer.remove();
	this.searchContainer=null;
	this.annotation.setEditable(false);
	new Ajax.Request(ajax_photo_tagging_url,{method:'post',onSuccess:this.onSaveSuccess.bind(this),onFailure:this.onSaveFailure.bind(this),parameters:params});
},extractContactExcludeList:function(){
	return $F('idt-tagged-users');
},onCancel:function(){
	tag.photo.editingContactAnnotation=false;
	this.destroy();
},formatContactItem:function(object,objectIdx,foundPos,entryLength){
	var userOrSource=object.user_name||object.source||'';
	var name='<strong>'+object.text.substr(0,entryLength)+'</strong>'+object.text.substr(entryLength);object.source_icon='/favicon.ico';
	return'<li id="contact_'+object.id+'" onmouseover="hoverImage(this, event, \''+object.pic_url+'\');" class="contact-autocomplete" style="margin-bottom:2px;"><span style="display:none;">'+object.text+'</span><img src="'+object.pic_url+'"/><div><span class="name">'+name+'</span><span class="email">&nbsp;</span></div></li>';
},toggleEmailMore:function(){
	$('add-identity-email').toggle();
	$('add-identity-email-field').focus();
	this.contact=undefined;
},destroy:function(){
	if(this.note)this.note.remove();
	if(this.searchContainer){this.autocompleter.options.indicator=false;this.searchContainer.remove();}
	this.annotation.destroy();
},onNoResultsFound:function(){}});