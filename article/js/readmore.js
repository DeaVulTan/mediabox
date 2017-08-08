function insertReadmore(editor)
	{
		//var content = tinyMCE.get('mce_editor_0').getBody().innerHTML;
		var content = tinyMCE.activeEditor.getBody().innerHTML;
		if(content.match(/<hr\s+id=(\"|')system-readmore(\"|')\s*\/*>/i))
			{
				alert('There is already a Read more... link that has been inserted.');
				return false;
			}
		else
			{
				jInsertEditorText('<hr id=\"system-readmore\" />', editor);
			}
	}
function jInsertEditorText( text, editor )
	{
		insertAtCursor( document.getElementById(editor), text );
	}

function insertAtCursor(myField, myValue)
	{
		if (document.selection)
			{
				tinyMCE.activeEditor.selection.setContent(myValue);

			}
		else
			{
				tinyMCE.activeEditor.selection.setContent(myValue);
			}
	}