/**
 * JImageManager behavior for media component
 *
 * @package		Rayzz
 * @subpackage	Media
 * @since		1.5
 */
var ImageManager = {
	initialize: function()
	{

		// Setup image manager fields object
		this.fields			= new Object();
		this.fields.url		= $Jq("#f_url").get(0);
		this.fields.alt		= $Jq("#f_alt").get(0);
		this.fields.align	= $Jq("#f_align").get(0);
		this.fields.title	= $Jq("#f_title").get(0);
		this.fields.caption	= $Jq("#f_caption").get(0);


		// Setup image listing objects
		this.folderlist = $Jq('#folderlist').get(0);


		this.frame = $Jq('#imageframe').get(0);//window.frames['imageframe'];
		this.frameurl = this.frame.src;//this.frame.location.href;

		// Setup imave listing frame
		this.imageframe = $Jq('#imageframe').get(0);
		this.imageframe.manager = this;
		//this.imageframe.observe('load', function(){ ImageManager.onloadimageview(); });
	},

	onok: function()
	{
		//parent.tinyMCE.execInstanceCommand("mce_editor_0", "mceFocus");
		//parent.tinyMCE.execCommand("mceFocus", false, "mce_editor_0");
		extra = '';
		// Get the image tag field information
		var url		= $Jq("#f_url").val();
		var alt		= $Jq("#f_alt").val();
		var align	= $Jq("#f_align").val();
		var title	= $Jq("#f_title").val();
		var caption	= $Jq("#f_caption").val();
		var tag='';
		
		
		if (url != '') {
			// Set alt attribute
			if (alt != '') {
				extra = extra + 'alt="'+alt+'" ';
			} else {
				extra = extra + 'alt="" ';
			}
			// Set align attribute
			if (align != '') {
				extra = extra + 'align="'+align+'" ';
			}
			// Set align attribute
			if (title != '') {
				extra = extra + 'title="'+title+'" ';
			}
			// Set align attribute
			if (caption != '') {
				extra = extra + 'class="caption" ';
			}

			 tag = "<img src=\""+url+"\" "+extra+"/>";
		}


		//mce_editor_0
		//window.opener.tinyMCE.activeEditor.selection.setContent(tag);

		//parent.tinyMCE.execInstanceCommand("mce_editor_0", "mceFocus");
		//window.setTimeout("tinyMCE.execCommand('mceFocus', false, 'textareaId')", 0);
		//parent.tinyMCE.activeEditor.selection.getContent();
		//parent.tinyMCE.activeEditor.focus();
		//alert(parent.tinyMCE.activeEditor);

		//parent.tinyMCE.execInstanceCommand("mce_editor_0", "mceFocus");
		//parent.tinyMCE.execCommand('mceInsertContent',false,tag);
		//parent.tinyMCE.activeEditor.focus();
		//parent.tinyMCE.execInstanceCommand('article_caption','mceInsertContent',false,tag);
		//parent.tinyMCE.activeEditor.selection.getContent();
		//parent.tinyMCE.activeEditor.setContent(parent.tinyMCE.activeEditor.getContent() + tag);

		//commented this since it was throwing error as ed not defined
	//	parent.tinyMCE.execCommand("mceFocus", false, "article_caption");
		var bm = parent.tinyMCE.activeEditor.selection.getBookmark();
		parent.tinyMCE.activeEditor.selection.moveToBookmark(bm);
		
		parent.tinyMCE.activeEditor.selection.setContent(tag);
		
/*		If the above code not works in IE then use below script

		if (parent.tinymce.isIE){
			parent.tinyMCE.editors.article_caption.selection.setContent(tag); // For IE
		}
	
*/	
		//alert(parent.tinyMCE.activeEditor.selection.getContent());
		//alert(parent.tinyMCE.activeEditor.selection.getContent());
		//parent.tinyMCE.activeEditor.selection.getContent();
		//parent.tinyMCE.activeEditor.selection.setContent(tag);
		//parent.tinyMCE.execCommand("mceFocus", false, "mce_editor_0");

		//parent.myLightWindow.deactivate();
		parent.$Jq.fancybox.close();

		return false;
	},

	populateFields: function(file)
	{
		//alert(image_base_path+file);
		//$("f_url").value = image_base_path+file;
		$Jq("#f_url").val(file);

	}

};

$Jq(document).ready(function(){
 ImageManager.initialize();
});