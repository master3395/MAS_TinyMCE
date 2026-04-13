tinymce.PluginManager.add('cmsms_linker', function(editor, url) {
    function cmsms_showDialog() {
        
        var data = {}, 
            selection = editor.selection, 
            dom = editor.dom,
            selectedElm, 
            anchorElm, 
            initialText,
            win,
            pageField,
            aliasField,
            textField,
            classnameField,
            relField,
            r;
        
        function buildClassNameInput() {
            returnObj = {
                name: 'classname',
                label: cmsms_tiny.prompt_class
            }
            if (classList = editor.options.get('link_class_list')) {
                items = []
                classList.forEach(function(item) {
                    items.push({
                        text: item.title,
                        value: item.value
                    })
                })
                returnObj.type = 'selectbox'
                returnObj.items = items
            } else {
                returnObj.type = 'input'
                returnObj.size = 40
            }
            return returnObj
        }

        // run jQueryUI autocomplete and set values
        function initAutoComplete(dialogApi) {
            $('.ui-autocomplete').css('z-index', 70000);
            $('.ui-helper-hidden-accessible').hide();
            
            var el = document.activeElement;
            $(el).autocomplete({
                minLength: 2,
                source: function(request, response) {
                    $.ajax({
                        url: cmsms_tiny.linker_autocomplete_url,
                        dataType: 'json',
                        data: {
                            term: request.term
                        },
                        success: function(data) {
                            response(data);
                        }
                    });
                },
                focus: function(event, ui) {
                    event.preventDefault();
                },
                select: function(event, ui) {
                    if( typeof ui.item != 'undefined' ) {
                        dialogApi.setData({
                            page: ui.item.label,
                            alias: ui.item.value,
                            href: "{cms_selflink href='" + ui.item.value + "'}"
                        });
                        if (dialogApi.getData().text == '') {
                            dialogApi.setData({
                                text: ui.item.title
                            });
                        }
                    }
                    event.preventDefault();
                }
            });
        }
        
        // insert all selected values to submitted form
        function onSubmitForm(dialogApi) {

            var data = dialogApi.getData(),
                href = data.href,
                page = data.page;

                function insertLink() {
                    if (data.text !== initialText) {
                        if (anchorElm) {
                            tinymce.activeEditor.focus();
                            anchorElm.innerHTML = data.text;
                            
                            dom.setAttribs(anchorElm, {
                                href: href,
                                target: data.target ? data.target : null,
                                rel: data.rel ? data.rel : null,
                                class: data.classname ? data.classname : null
                            });
                            
                            selection.select(anchorElm);
                        } else {
                            tinymce.activeEditor.insertContent(dom.createHTML('a', {
                                href: href,
                                target: data.target ? data.target : null,
                                rel: data.rel ? data.rel : null,
                                class: data.classname ? data.classname : null
                            }, data.text));
                        }
                    } else {
                        tinymce.activeEditor.execCommand('mceInsertLink', false, {
                            href: href,
                            target: data.target,
                            rel: data.rel ? data.rel : null,
                            class: data.classname ? data.classname : null
                        });
                    }
                }
                
                if (!href || !page) {
                    tinymce.activeEditor.execCommand('unlink');
                    return;
                }
                
                insertLink();
                dialogApi.close();
        }
        
        // set default values for fields
        selectedElm    = selection.getNode();
        anchorElm      = dom.getParent(selectedElm, 'a[href]');
        
        data.page      = '';
        data.alias     = '';
        data.text      = initialText = anchorElm ? (anchorElm.innerText || anchorElm.textContent) : selection.getContent({format: 'text'});
        data.href      = anchorElm ? dom.getAttrib(anchorElm, 'href') : '';
        data.target    = anchorElm ? dom.getAttrib(anchorElm, 'target') : '';
        data.classname = anchorElm ? dom.getAttrib(anchorElm, 'class') : '';
        data.rel       = anchorElm ? dom.getAttrib(anchorElm, 'rel') : '';

        // reset text field if it's image'
        if (selectedElm.nodeName === 'IMG') {
            data.text = initialText = ' ';
        }
        
        // run tinymce window and build form
        // https://www.tiny.cloud/docs/ui-components/dialog/
        winAPI = editor.windowManager.open({
            title: cmsms_tiny.linker_text,
            initialData: data,
            body: {
                type: 'tabpanel',
                tabs: [
                    {
                        name: 'tab_general',
                        title: cmsms_tiny.tab_general,
                        items: [
                            {
                                name: 'page',
                                type: 'input',
                                size: 40,
                                label: cmsms_tiny.prompt_page,
                                tooltip: cmsms_tiny.prompt_page_info,
                            },
                            {
                                name: 'alias', 
                                type: 'input', 
                                size: 40, 
                                label: cmsms_tiny.prompt_alias,
                                tooltip: cmsms_tiny.prompt_alias_info,
                                disabled: true,
                            },
                            {
                                name: 'text', 
                                type: 'input', 
                                size: 40, 
                                label: cmsms_tiny.prompt_text, 
                            },
                            {
                                name: 'href', 
                                type: 'input', 
                                size: 40, 
                                label: cmsms_tiny.linker_href,
                                disabled: true,
                            },
                        ]
                    },
                    {
                        name: 'tab_advanced',
                        title: cmsms_tiny.tab_advanced,
                        items: [
                            {
                                name: 'target',
                                type: 'selectbox',
                                label: cmsms_tiny.prompt_target,
                                items: [
                                    {
                                        text: cmsms_tiny.target_none,
                                        value: ''
                                    },
                                    {
                                        text: cmsms_tiny.target_new_window,
                                        value: '_blank'
                                    }
                                ]
                            },
                            buildClassNameInput(),
                            {
                                name: 'rel', 
                                type: 'input', 
                                size: 40, 
                                label: cmsms_tiny.prompt_rel,
                            },
                        ]
                    },
                ]
            },
            onChange: function(dialogApi, details) {
                if (details.name == 'page') {
                    initAutoComplete(dialogApi);
                }
            },
            onSubmit: onSubmitForm,
            buttons: [
                {
                    type: 'cancel',
                    text: 'Cancel',
                },
                {
                    type: 'submit',
                    text: 'Save',
                    primary: true,
                },
            ]
        });

        winAPI.focus('page');

        // We have now the window API, we can interact with the form data
        // grab page information if href is cms_selflink
        if(data.href.indexOf('cms_selflink') !== -1 ) {
            r = data.href.match(/href=(.*)[\s\}]/);
            
            if(r.length >= 2) {
                winAPI.block(cmsms_tiny.loading_info);
                // parsed the cms_selflink for the page alias
                // fill in the alias field.
                data.alias = r[1].replace (/'/g, '');
                // default value for page field
                data.page = cmsms_tiny.loading_info;
                $.ajax({
                    url: cmsms_tiny.linker_autocomplete_url,
                    dataType: 'json',
                    data: {
                        alias: data.alias
                    },
                    success: function(res) {
                        // update values for alias and page.
                        data.page = data.href = '';
                        if( res && res.label ) {
                            data.page = res.label;
                            data.href= "{cms_selflink href='" + data.alias + "'}";
                            winAPI.setData({
                                page: data.page,
                                alias: data.alias,
                                href: data.href
                            });
                            winAPI.unblock();
                        }
                    }
                });
            }
        }
    }


    // From the "link" plugin : active or not the button on tag change
    var getAnchorElement = function (editor, selectedElm) {
        selectedElm = selectedElm || editor.selection.getNode();
        if (selectedElm && selectedElm.nodeName === 'FIGURE' && /\bimage\b/i.test(selectedElm.className)) {
            return editor.dom.select('a[href*=cms_selflink]', selectedElm)[0];
        } else {
            return editor.dom.getParent(selectedElm, 'a[href*=cms_selflink]');
        }
    };
    var toggleActiveState = function (editor) {
        return function (api) {
            var nodeChangeHandler = function (e) {
                var active = !editor.readonly && !!getAnchorElement(editor, e.element);
                // TinyMCE 8+ button api may not expose `setActive()` depending on build/version.
                // Avoid throwing here because it can break other editor/image dialogs.
                if (api && typeof api.setActive === 'function') {
                    return api.setActive(active);
                }
                return undefined;
            };
            editor.on('NodeChange', nodeChangeHandler);
            return function () {
                return editor.off('NodeChange', nodeChangeHandler);
            };
        };
    }

    // add a button
    // editor.addButton('cmsms_linker', {
    var icon = '<svg height="24" width="24"><path d="M 7 3 C 5.8954305 3 5 3.8954305 5 5 L 5 12.722656 C 5.688874 11.922147 6.1209299 11.405692 7 11.244141 L 7 5 L 12.339844 5 L 14.400391 3 L 7 3 z M 16.902344 3.0566406 A 3.9 3.9 0 0 0 14.400391 4 L 9.5996094 9 A 2.9 2.9 0 0 0 9.5996094 13 A 1 1 0 1 0 11 11.699219 A 1 1 0 0 1 11 10.300781 L 15.800781 5.5 A 2 2 0 1 1 18.400391 8.3007812 L 16.400391 10.300781 A 1 1 0 0 0 17.800781 11.699219 L 17.900391 11.5 L 19.900391 9.5 A 3.9 3.9 0 0 0 16.902344 3.0566406 z M 13.478516 10.433594 A 1 1 0 0 0 13 12.300781 A 1 1 0 0 1 13 13.699219 L 8.1992188 18.5 A 2 2 0 1 1 5.5 15.699219 L 7.5996094 13.699219 A 1 1 0 0 0 6.1992188 12.300781 L 6.0996094 12.5 L 4.0996094 14.5 A 3.9 3.9 0 0 0 9.5996094 20 L 14.400391 15 A 2.9 2.9 0 0 0 14.400391 11 A 1 1 0 0 0 13.478516 10.433594 z M 19 11.308594 L 17 13.277344 L 17 19 L 11.640625 19 L 9.6738281 21 L 17 21 C 18.104569 21 19 20.104569 19 19 L 19 11.308594 z " /></svg>';
    editor.ui.registry.addIcon('cmsms_linker', icon);
    editor.ui.registry.addToggleButton('cmsms_linker', {
        icon: 'cmsms_linker',
        tooltip: cmsms_tiny.linker_title,
        image: cmsms_tiny.linker_image,
        onAction: cmsms_showDialog,
        onSetup: toggleActiveState(editor),
    });
    
    // and a menu item
    editor.ui.registry.addMenuItem('cmsms_linker', {
        text: cmsms_tiny.linker_text,
        icon: 'link',
        onAction: cmsms_showDialog,
        onSetup: toggleActiveState(editor),
    });
});
