/**
 * @license Copyright (c) 2003-2013, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.html or http://ckeditor.com/license
 */

CKEDITOR.stylesSet.add( 'trescal_styles', [
    // Block-level styles.
    { name: '2nd level title', element: 'h2' },
    { name: 'emphasis paragraph', element: 'div', attributes: { 'class': 'page-intro' }}
]);

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here.
	// For complete reference see:
	// http://docs.ckeditor.com/#!/api/CKEDITOR.config

	// The toolbar groups arrangement, optimized for two toolbar rows.
	config.toolbarGroups = [
		{ name: 'clipboard',   groups: [ 'clipboard', 'undo' ] },
		{ name: 'editing',     groups: [ 'find', 'selection', 'spellchecker' ] },
		{ name: 'links' },
		{ name: 'insert' },
		{ name: 'forms' },
		{ name: 'tools' },
		{ name: 'document',	   groups: [ 'mode', 'document', 'doctools' ] },
		{ name: 'others' },
		'/',
		{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
		{ name: 'paragraph',   groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ] },
		{ name: 'styles' },
		{ name: 'colors' }
	];

	// Remove some buttons provided by the standard plugins, which are
	// not needed in the Standard(s) toolbar.
	config.removeButtons = 'Format,Font';

	// Set the most common block elements.
	config.format_tags = 'p;h1;h2;h3;pre';

	// Simplify the dialog windows.
	config.removeDialogTabs = 'image:advanced;link:advanced';

	config.stylesSet = 'trescal_styles';
	config.contentsCss = [];

	config.filebrowserBrowseUrl = '/web/js/kcfinder/browse.php?opener=ckeditor&type=files';
  config.filebrowserImageBrowseUrl = '/web/js/kcfinder/browse.php?opener=ckeditor&type=images';
  config.filebrowserFlashBrowseUrl = '/web/js/kcfinder/browse.php?opener=ckeditor&type=flash';
  config.filebrowserUploadUrl = '/web/js/kcfinder/upload.php?opener=ckeditor&type=files';
  config.filebrowserImageUploadUrl = '/web/js/kcfinder/upload.php?opener=ckeditor&type=images';
  config.filebrowserFlashUploadUrl = '/web/js/kcfinder/upload.php?opener=ckeditor&type=flash';
};
