/**
 * @license Copyright (c) 2003-2018, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see https://ckeditor.com/legal/ckeditor-oss-license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';

    config.language = 'vi';
    config.filebrowserBrowseUrl =  '/public/plugins/ckfinder/ckfinder.html';
    config.filebrowserImageBrowseUrl =  '/public/plugins/ckfinder/ckfinder.html?type=Images';
    config.filebrowserFlashBrowseUrl =  '/public/plugins/ckfinder/ckfinder.html?type=Flash';
    config.filebrowserUploadUrl =  '/public/plugins/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files';
    config.filebrowserImageUploadUrl =  '/public/plugins/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images';
    config.filebrowserFlashUploadUrl =  '/public/plugins/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash';

};


