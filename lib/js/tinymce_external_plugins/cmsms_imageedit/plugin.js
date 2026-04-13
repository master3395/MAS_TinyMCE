/* CMSMS TinyMCE external plugin: cmsms_imageedit */
(function() {
  'use strict';

  tinymce.PluginManager.add('cmsms_imageedit', function(editor) {
    var getSelectedImage = function() {
      var node = editor.selection ? editor.selection.getNode() : null;
      if (!node || !node.nodeName) return null;
      return node.nodeName.toLowerCase() === 'img' ? node : null;
    };

    var requireImage = function(onOk) {
      var img = getSelectedImage();
      if (!img) {
        editor.windowManager.alert('Select an image in the editor first.');
        return;
      }
      onOk(img);
    };

    var openImageDialog = function() {
      requireImage(function(img) {
        var width = img.getAttribute('width') || '';
        var height = img.getAttribute('height') || '';
        var cssClass = img.getAttribute('class') || '';
        var style = img.getAttribute('style') || '';

        editor.windowManager.open({
          title: 'Image edit',
          body: {
            type: 'panel',
            items: [
              { type: 'input', name: 'width', label: 'Width' },
              { type: 'input', name: 'height', label: 'Height' },
              { type: 'input', name: 'cssClass', label: 'Class' },
              { type: 'textarea', name: 'style', label: 'Style' }
            ]
          },
          initialData: {
            width: width,
            height: height,
            cssClass: cssClass,
            style: style
          },
          buttons: [
            { type: 'cancel', text: 'Cancel' },
            { type: 'submit', text: 'Apply', primary: true }
          ],
          onSubmit: function(api) {
            var data = api.getData();
            editor.undoManager.transact(function() {
              if (data.width) img.setAttribute('width', data.width); else img.removeAttribute('width');
              if (data.height) img.setAttribute('height', data.height); else img.removeAttribute('height');
              if (data.cssClass) img.setAttribute('class', data.cssClass); else img.removeAttribute('class');
              if (data.style) img.setAttribute('style', data.style); else img.removeAttribute('style');
            });
            api.close();
          }
        });
      });
    };

    var resetDimensions = function() {
      requireImage(function(img) {
        editor.undoManager.transact(function() {
          img.removeAttribute('width');
          img.removeAttribute('height');
          var style = img.getAttribute('style') || '';
          style = style
            .replace(/(?:^|;)\s*width\s*:[^;]*/ig, '')
            .replace(/(?:^|;)\s*height\s*:[^;]*/ig, '')
            .replace(/^;+|;+$/g, '');
          if (style) img.setAttribute('style', style);
          else img.removeAttribute('style');
        });
      });
    };

    editor.ui.registry.addButton('cmsms_imageedit', {
      tooltip: 'Image edit',
      icon: 'edit-image',
      onAction: openImageDialog
    });

    editor.ui.registry.addMenuItem('cmsms_imageedit', {
      text: 'Image edit',
      icon: 'edit-image',
      onAction: openImageDialog
    });

    editor.ui.registry.addMenuItem('cmsms_imageedit_reset', {
      text: 'Image reset size',
      icon: 'image',
      onAction: resetDimensions
    });

    return {
      getMetadata: function() {
        return {
          name: 'CMSMS Image Edit',
          url: 'https://newstargeted.com'
        };
      }
    };
  });
})();
