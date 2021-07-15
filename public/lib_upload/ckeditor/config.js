/*
Copyright (c) 2003-2010, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/

CKEDITOR.editorConfig = function( config )
{
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
	

        config.toolbar_MyToolbar =
        [
            ['Source','-','Templates'],
            [ 'Cut','Copy','Paste','PasteText','PasteFromWord','RemoveFormat','-','Undo','Redo' ] ,
            [ 'Find','Replace','-','SelectAll','-','SpellChecker', 'Scayt' ],
			['Outdent','Indent','-','Blockquote','CreateDiv','-', 'TextColor','BGColor'],
			['Link','Unlink','Anchor'],
            
            '/',
            
			['Format','Font','FontSize'],
  	        ['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock' ],
            [ 'Bold','Italic','Underline','Strike','Subscript','Superscript' ] ,
            ['NumberedList', 'BulletedList'],
			[ 'Image','Flash','Table','HorizontalRule','Smiley','SpecialChar'],
			['Maximize','PageBreak' ]
        ];

        config.toolbar = 'MyToolbar';
        config.height = '200px';
};
