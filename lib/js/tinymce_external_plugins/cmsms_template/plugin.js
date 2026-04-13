tinymce.PluginManager.add('cmsms_template', function(editor, url) {

    function cmsms_handleTemplateSelectorChange() {
        data = winAPI.getData()
        winAPI.setData({
            cmsms_template_preview: cssLinkTag + cmsmsTemplatesByName[data.template_name].content
        })
        document.getElementById('cmsmsTemplateDescription').innerHTML = cmsmsTemplatesByName[data.template_name].description

    }

    function cmsms_showDialog() {

        cssLinkTag = ''
        if (editor.options.get('content_css')) {
            cssLinkTag = '<link rel="stylesheet" href="' + editor.options.get('content_css') + '">'
        }

        // Templates by name for further access
        cmsmsTemplatesByName = []
        // Templates in an array for the TinyMCE selectbox dialog
        templatesItemsSelector = []
        cmsms_templates.forEach((element) => {
            cmsmsTemplatesByName[element.title] = element
            templatesItemsSelector.push({
                text: element.title,
                value: element.title
            })
        })

        winAPI = editor.windowManager.open({
            title: cmsms_tiny.template_title,
            size: 'large',
            body: {
                type: 'panel',
                items: [
                    {
                        type: 'selectbox',
                        name: 'template_name',
                        label: cmsms_tiny.template_select,
                        enabled: true,
                        items: templatesItemsSelector
                    },
                    {
                        type: 'htmlpanel',
                        html: '<p>&nbsp;</p>'
                    },
                    {
                        type: 'label',
                        label: editor.translate('Description'),
                        for: '#foo',
                        items: [
                            {
                                type: 'htmlpanel',
                                html: '<p id="cmsmsTemplateDescription"></p>'
                            }
                        ]
                    },
                    {
                        type: 'htmlpanel',
                        html: '<p>&nbsp;</p>'
                    },
                    {
                        type: 'label',
                        label: editor.translate('Preview'),
                        for: '#cmsms_template_preview',
                        items: [
                            {
                                type: 'iframe',
                                name: 'cmsms_template_preview',
                                sandboxed: false
                            }
                        ]
                    },
                ],
            },
            buttons: [
                {
                    text: editor.translate('Cancel'),
                    type: 'cancel'
                },
                {
                    text: editor.translate('Insert template'),
                    type: 'submit',
                    buttonType: 'primary'
                },
            ],
            onChange: cmsms_handleTemplateSelectorChange,
            onSubmit: function(dialogApi) {
                template_name = dialogApi.getData().template_name
                html = cmsmsTemplatesByName[template_name].content
                editor.insertContent(html)
                dialogApi.close()
            }
        })
        cmsms_handleTemplateSelectorChange()
    }

    editor.ui.registry.addMenuItem('cmsms_template', {
        text: cmsms_tiny.template_title,
        icon: 'template',
        onAction: cmsms_showDialog
    })
    editor.ui.registry.addToggleButton('cmsms_template', {
        tooltip: cmsms_tiny.template_title,
        icon: 'template',
        onAction: cmsms_showDialog
    })
});
