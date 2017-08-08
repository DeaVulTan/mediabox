function insertPagebreak()
	{
		// Get the pagebreak title
		var title = document.getElementById("title").value;
		if (title != '') {
			title = "title=\""+title+"\" ";
		}

		// Get the pagebreak toc alias -- not inserting for now
		// don't know which attribute to use...
		var alt = document.getElementById("alt").value;
		if (alt != '') {
			alt = "alt=\""+alt+"\" ";
		}

		var tag = "<hr class=\"system-pagebreak\" "+title+" "+alt+" />";
		jInsertEditorText(tag, 'article_caption');
		parent.$Jq.fancybox.close();
		//parent.myLightWindow.deactivate();
	}

function jInsertEditorText( text, editor )
	{
		insertAtCursor(parent.document.getElementById(editor), text );
	}

function insertAtCursor(myField, myValue)
	{
		if (document.selection)
			{
				//parent.tinyMCE.execCommand("mceFocus", false, "article_caption");
				pagebreak_bookmark = parent.tinyMCE.activeEditor.selection.getBookmark();
				parent.tinyMCE.activeEditor.setContent(parent.tinyMCE.activeEditor.getContent() + myValue);
				parent.tinyMCE.activeEditor.selection.moveToBookmark(pagebreak_bookmark);
				//parent.tinyMCE.activeEditor.focus();
				//parent.tinyMCE.activeEditor.selection.getContent();
				//alert(parent.tinyMCE.activeEditor.getContent());
				//parent.tinyMCE.activeEditor.setContent(myValue);
				//parent.tinyMCE.activeEditor.selection.setContent(myValue);
			}
		else{
				//parent.tinyMCE.execCommand("mceFocus", false, "article_caption");
				pagebreak_bookmark = parent.tinyMCE.activeEditor.selection.getBookmark();
				parent.tinyMCE.activeEditor.selection.setContent(myValue);
				parent.tinyMCE.activeEditor.selection.moveToBookmark(pagebreak_bookmark);
				//parent.tinyMCE.activeEditor.getContent();
				//parent.tinyMCE.activeEditor.focus();
				//parent.tinyMCE.activeEditor.setContent(parent.tinyMCE.activeEditor.getContent() + myValue);
				//alert(parent.tinyMCE.activeEditor.getContent());
			}
	}