/**
 * @license Copyright (c) 2003-2021, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see https://ckeditor.com/legal/ckeditor-oss-license
 */

CKEDITOR.editorConfig = function( config ) {
	config.pasteFromWordRemoveFontStyles = false;
    config.pasteFromWordRemoveStyles = false;
	config.font_names = "新細明體;標楷體;微軟正黑體;" +config.font_names ;
	config.enterMode = CKEDITOR.ENTER_BR;
	config.shiftEnterMode = CKEDITOR.ENTER_P;
	config.allowedContent=true;

    // 過濾掉i標籤的空值
    config.protectedSource.push(/<i[^>]><\/i>/g);
    CKEDITOR.dtd.$removeEmpty['i'] = false;
};
// 把圖片預設style取代掉
CKEDITOR.on( 'instanceReady', function( event )
{
	var editor = event.editor,
	dataProcessor = editor.dataProcessor,
	htmlFilter = dataProcessor && dataProcessor.htmlFilter;
	// Output properties as attributes, not styles.
	htmlFilter.addRules(
	{
		elements :
		{
		$ : function( element )
		{
			// Output dimensions of images as width and height
			if ( element.name == 'img' )
			{
			var style = element.attributes.style;

			if ( style )
			{
				// Get the width from the style.
				var match = /(?:^|\s)width\s*:\s*(\d+)px/i.exec( style ),
				width = match && match[1];

				// Get the height from the style.
				match = /(?:^|\s)height\s*:\s*(\d+)px/i.exec( style );
				var height = match && match[1];

				if ( width )
				{
				element.attributes.style = element.attributes.style.replace( /(?:^|\s)width\s*:\s*(\d+)px;?/i , '' );
				// element.attributes.width = width;
				}

				if ( height )
				{
				element.attributes.style = element.attributes.style.replace( /(?:^|\s)height\s*:\s*(\d+)px;?/i , '' );
				// element.attributes.height = height;
				}
			}
			}

			if ( !element.attributes.style )
			delete element.attributes.style;

			return element;
		}
		}
	});
	event.editor.on("beforeCommandExec", function(event) {
		// Show the paste dialog for the paste buttons and right-click paste
		if (event.data.name == "paste") {
			event.editor._.forcePasteDialog = true;
		}
		// Don't show the paste dialog for Ctrl+Shift+V
		else if (event.data.name == "pastetext" && event.data.commandData.from == "keystrokeHandler") {
			event.cancel();
		}
	})
});
