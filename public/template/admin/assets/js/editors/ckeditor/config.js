/**
 * @license Copyright (c) 2003-2015, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function (config) {
    // Define changes to default configuration here. For example:
    config.extraPlugins = 'imagebrowse,autogrow';
    config.allowedContent = true;
    config.language = 'vi';
    config.toolbar = 'Standard';
    config.skin = 'bootstrapck';

    config.toolbar_Standard = [
        { name: 'document', items: ['Source'] },
        { name: 'basicstyles', items: ['Font', 'Format', 'FontSize', 'TextColor', 'BGColor'] },
        '/',
        { name: 'paragraph', groups: ['list', 'indent', 'blocks', 'align', 'bidi'], items: ['Bold', 'Italic', 'Underline', '-', 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock'] },
        { name: 'plugins', items: ['Table', 'ImageBrowse'] },
        { name: 'links', items: ['Link', 'Unlink'] }
    ];

    config.toolbar_Simple = [
        { name: 'basicstyles', items: ['Font', 'Format', 'FontSize', 'TextColor', 'BGColor'] },
        { name: 'paragraph', groups: ['list', 'indent', 'blocks', 'align', 'bidi'], items: ['Bold', 'Italic', 'Underline', '-', 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock'] },
        { name: 'links', items: ['Link', 'Unlink'] }
    //{ name: 'insert', items: ['ImageBrowse'] }
    ];

    // Remove some buttons provided by the standard plugins, which are
    // not needed in the Standard(s) toolbar.
    // config.removeButtons = 'Underline,Subscript,Superscript';

    // Set the most common block elements.
    // config.format_tags = 'p;h1;h2;h3;pre';

    // Simplify the dialog windows.
    config.removeDialogTabs = 'image:advanced;link:advanced';
    config.htmlEncodeOutput = false;
    config.entities = false;
    config.autoGrow_minHeight = 200;
    config.autoGrow_maxHeight = 600;
    config.autoGrow_bottomSpace = 50;
};
