/* CMSMS TinyMCE external plugin: cmsms_markdown */
(function() {
  'use strict';

  tinymce.PluginManager.add('cmsms_markdown', function(editor) {
    var htmlToMarkdown = function(html) {
      if (!html) return '';
      return html
        .replace(/<h1[^>]*>([\s\S]*?)<\/h1>/ig, '# $1\n\n')
        .replace(/<h2[^>]*>([\s\S]*?)<\/h2>/ig, '## $1\n\n')
        .replace(/<h3[^>]*>([\s\S]*?)<\/h3>/ig, '### $1\n\n')
        .replace(/<strong[^>]*>([\s\S]*?)<\/strong>/ig, '**$1**')
        .replace(/<b[^>]*>([\s\S]*?)<\/b>/ig, '**$1**')
        .replace(/<em[^>]*>([\s\S]*?)<\/em>/ig, '*$1*')
        .replace(/<i[^>]*>([\s\S]*?)<\/i>/ig, '*$1*')
        .replace(/<a[^>]*href=["']([^"']+)["'][^>]*>([\s\S]*?)<\/a>/ig, '[$2]($1)')
        .replace(/<li[^>]*>([\s\S]*?)<\/li>/ig, '- $1\n')
        .replace(/<br\s*\/?>/ig, '\n')
        .replace(/<\/p>/ig, '\n\n')
        .replace(/<[^>]+>/g, '')
        .replace(/\n{3,}/g, '\n\n')
        .trim();
    };

    var markdownToHtml = function(md) {
      if (!md) return '';
      var html = md
        .replace(/^###\s+(.+)$/gm, '<h3>$1</h3>')
        .replace(/^##\s+(.+)$/gm, '<h2>$1</h2>')
        .replace(/^#\s+(.+)$/gm, '<h1>$1</h1>')
        .replace(/\*\*(.+?)\*\*/g, '<strong>$1</strong>')
        .replace(/\*(.+?)\*/g, '<em>$1</em>')
        .replace(/\[([^\]]+)\]\(([^)]+)\)/g, '<a href="$2">$1</a>');

      html = html.replace(/(?:^|\n)-\s+(.+)(?=\n|$)/g, '<li>$1</li>');
      html = html.replace(/(<li>[\s\S]*?<\/li>)/g, '<ul>$1</ul>');
      html = html.replace(/<\/ul>\s*<ul>/g, '');
      html = html.replace(/\n{2,}/g, '</p><p>');
      html = '<p>' + html.replace(/\n/g, '<br>') + '</p>';
      html = html.replace(/<p>\s*<\/p>/g, '');
      return html;
    };

    var openMarkdownWorkspace = function(title, initialMd) {
      var previewId = 'cmsms-markdown-preview-' + Math.floor(Math.random() * 10000000);

      var renderPreview = function(api) {
        var data = api.getData() || {};
        var md = data.md || '';
        var html = markdownToHtml(md);
        var root = api.getEl();
        if (!root) return;
        var preview = root.querySelector('#' + previewId);
        if (preview) {
          preview.innerHTML = html || '<p><em>(Preview is empty)</em></p>';
        }
      };

      editor.windowManager.open({
        title: title,
        size: 'large',
        body: {
          type: 'panel',
          items: [
            { type: 'textarea', name: 'md', label: 'Markdown', maximized: true },
            {
              type: 'htmlpanel',
              html:
                '<div style="margin-top:8px;">' +
                '<strong>Preview</strong>' +
                '<div id="' + previewId + '" style="margin-top:6px;border:1px solid #d8d8d8;border-radius:4px;padding:10px;max-height:280px;overflow:auto;background:#fff;">' +
                '<p><em>(Preview is empty)</em></p>' +
                '</div>' +
                '</div>'
            }
          ]
        },
        initialData: { md: initialMd || '' },
        buttons: [
          { type: 'cancel', text: 'Close' },
          { type: 'submit', text: 'Insert HTML', primary: true }
        ],
        onChange: function(api) {
          renderPreview(api);
        },
        onSubmit: function(api) {
          var data = api.getData();
          var html = markdownToHtml((data && data.md) || '');
          if (html) editor.insertContent(html);
          api.close();
        },
        onAction: function(api) {
          renderPreview(api);
        }
      });
    };

    var convertSelectionToMarkdown = function() {
      var selected = editor.selection.getContent({ format: 'html' });
      if (!selected) {
        editor.windowManager.alert('Select content to convert first.');
        return;
      }
      openMarkdownWorkspace('Markdown workspace', htmlToMarkdown(selected));
    };

    var insertMarkdownAsHtml = function() {
      openMarkdownWorkspace('Markdown workspace', '');
    };

    editor.ui.registry.addMenuButton('cmsms_markdown', {
      icon: 'sourcecode',
      tooltip: 'Markdown tools',
      fetch: function(callback) {
        callback([
          { type: 'menuitem', text: 'Selection to Markdown', onAction: convertSelectionToMarkdown },
          { type: 'menuitem', text: 'Insert Markdown as HTML', onAction: insertMarkdownAsHtml }
        ]);
      }
    });

    editor.ui.registry.addButton('cmsms_markdown', {
      icon: 'sourcecode',
      tooltip: 'Markdown tools',
      onAction: convertSelectionToMarkdown
    });

    editor.ui.registry.addMenuItem('cmsms_markdown', {
      text: 'Markdown tools',
      icon: 'sourcecode',
      onAction: convertSelectionToMarkdown
    });

    return {
      getMetadata: function() {
        return {
          name: 'CMSMS Markdown',
          url: 'https://newstargeted.com'
        };
      }
    };
  });
})();
