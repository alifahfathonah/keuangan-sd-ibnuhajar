/*
Copyright (c) 2003-2011, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/

CKEDITOR.editorConfig = function( config )
{
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';

	config.height = 100;

	config.toolbar_Standard = [
		[
			'Font', 'FontSize',
			'-',
			'TextColor', 'BGColor',
			'-',
			'Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript',
			'-',
			'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock',
			'-',
			'NumberedList', 'BulletedList', 'Outdent', 'Indent', 'Blockquote',
			'-',
			'Link', 'Unlink', 'Image', 'Table', 'SpecialChar'
		]
	]
};
