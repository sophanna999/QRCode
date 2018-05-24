/**
 * @license Copyright (c) 2003-2017, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	config.filebrowserImageBrowseUrl =  '/admin/filemanager?type=Images';
	config.filebrowserImageUploadUrl = '/admin/filemanager/upload?type=Images&_token=';
	config.filebrowserBrowseUrl      = '/admin/filemanager?type=Files';
	config.filebrowserUploadUrl      = '/admin/filemanager/upload?type=Files&_token=';
};
