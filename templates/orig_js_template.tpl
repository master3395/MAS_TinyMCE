{* Orig JS Template *}
tinymce.init({
	selector: '{if isset($selector) && $selector != ''}{$selector}{else}textarea.TinyMCE{/if}',

	language: '{$language}',

	license_key: '{$profile->license_key|default:'gpl'}',
	promotion: false,
	onboarding: false,

	cmsms_tiny: cmsms_tiny = {
		{if $enable_linker}
			linker_text : '{$TinyMCE->Lang('cmsms_linker')|escape:'quotes'}',
			linker_title : '{$TinyMCE->Lang('title_cmsms_linker')|escape:'quotes'}',
			linker_image : '{$TinyMCE->GetModuleURLPath()}/lib/images/cmsmslink.gif',
			linker_url : '{$linker_url}',
			linker_autocomplete_url : '{$getpages_url}',
			linker_href : '{$TinyMCE->Lang('prompt_href')|escape:'quotes'}',
			prompt_page : '{$TinyMCE->Lang('prompt_linker')|escape:'quotes'}',
			prompt_page_info : '{$TinyMCE->Lang('info_linker_autocomplete')|escape:'quotes'}',
			prompt_alias : '{$TinyMCE->Lang('prompt_selectedalias')|escape:'quotes'}',
			prompt_alias_info : '{$TinyMCE->Lang('tooltip_selectedalias')|escape:'quotes'}',
			prompt_text : '{$TinyMCE->Lang('prompt_texttodisplay')|escape:'quotes'}',
			prompt_class : '{$TinyMCE->Lang('prompt_class')|escape:'quotes'}',
			prompt_rel : '{$TinyMCE->Lang('prompt_rel')|escape:'quotes'}',
			prompt_target : '{$TinyMCE->Lang('prompt_target')|escape:'quotes'}',
			tab_general : '{$TinyMCE->Lang('tab_general_title')|escape:'quotes'}',
			tab_advanced : '{$TinyMCE->Lang('tab_advanced_title')|escape:'quotes'}',
			target_none : '{$TinyMCE->Lang('none')|escape:'quotes'}',
			target_new_window : '{$TinyMCE->Lang('newwindow')|escape:'quotes'}',
			loading_info : '{$TinyMCE->Lang('loading_info')|escape:'quotes'}',
		{/if}

		filepicker_title: '{$TinyMCE->Lang('filepickertitle')|escape:javascript}',
        filebrowser_title: '{$TinyMCE->Lang('title_cmsms_filebrowser')|escape:javascript}',

        {if $profile->enable_user_templates}
        	template_title: '{$TinyMCE->lang('template_insert')}',
        	template_select: '{$TinyMCE->lang('template_select')}',
        {/if}
	},
	{if $profile->relative_urls}
		relative_urls: true,
	{else}
		relative_urls: false,
		remove_script_host: false,
	{/if}
	document_base_url: '{root_url}/',
	browser_spellcheck: true,
	// TinyMCE 8.4+: keep noneditable feature enabled by default (legacy behavior).
	allow_noneditable: true,

	forced_root_block: '{$profile->forced_root_block|default:'p'}',
	newline_behavior: '{$profile->newline_behavior|default:'default'}',

	{* PLUGINS *}
	plugins: '{$profile->plugins} {if $enable_linker and $profile->plugins|strpos:'cmsms_linker' === false}cmsms_linker{/if } {if isset($can_use_filemanager) and $can_use_filemanager and $profile->filemanager_use and $profile->plugins|strpos:'cmsms_filepicker' === false}cmsms_filepicker {/if}{if $profile->enable_user_templates}cmsms_template {/if}{if $profile->enable_imageedit}cmsms_imageedit {/if}{if $profile->enable_markdown}cmsms_markdown {/if}{if $profile->autoresize}autoresize{/if}',

	{*PLUGINS OPTIONS*}
	{if $profile->image_advtab}
		image_advtab: true,
	{/if}

	contextmenu: "{if $enable_linker and $profile->contextmenu|strpos:'cmsms_linker' === false}cmsms_linker{/if} {$profile->contextmenu}",

	{* MENU BAR *}
	{if !$profile->show_menubar}
		menubar: false,
	{else}
		{if $profile->use_advanced_menu && !empty($profile->advanced_menu)}
			menu: {$profile->advanced_menu},
		{else}
			menubar: '{$profile->menubar}',
		{/if}
	{/if}

	{* TOOLBAR *}
	{if !$profile->show_toolbar}
		toolbar: false,
	{else}
		toolbar1: '{$profile->toolbar1}',
		{if !empty($profile->toolbar2)}
			toolbar2: '{$profile->toolbar2}',
		{/if}
	{/if}

	{* STATUSBAR *}
	{if !$profile->show_statusbar && $profile->resize == false}
		statusbar: false,
	{/if}

	{* RESIZE *}
	{if $profile->resize == false}
		resize: false,
	{elseif $profile->resize == 'both'}
		resize: 'both',
	{else}
		resize: true,
	{/if}

	height: 20,
	autoresize_min_height: 10,
	autoresize_max_height: 600,
	autoresize_bottom_margin: 10,

	{* CSS *}
	{if isset($content_css) && $content_css != ''}
		content_css: '{$content_css}',
	{/if}


	{* GENERAL CSS CLASSES *}
	{if isset($style_formats) and !empty($style_formats)}
		style_formats: [
			{foreach $style_formats as $style_format}
				{ldelim}{$style_format}{rdelim},
			{/foreach}
		],
	{/if}

	{* LINK CSS CLASSES *}
	{if isset($link_classes)}
		link_class_list: [
			{foreach $link_classes as $name => $classes}
				{ldelim}title: '{$name}', value: '{$classes|escape:javascript}'{rdelim},
			{/foreach}
		],
	{/if}

	{* IMAGES CSS CLASSES *}
	{if isset($image_classes)}
		image_class_list: [
			{foreach $image_classes as $name => $classes}
				{ldelim}title: '{$name}', value: '{$classes|escape:javascript}'{rdelim},
			{/foreach}
		],
	{/if}

	{* FORMAT FOR DROPDOWN IN TOOLBAR (button formatselect) *}
	{if $profile->use_custom_block_formats and $profile->block_formats neq ''}
		block_formats: "{$profile->block_formats}",
	{/if}

	{* USER TEMPLATES *}
	{if $profile->enable_user_templates}
		cmsms_templates: cmsms_templates = [
			{if isset($user_templates)}
				{foreach $user_templates as $user_template}
					{ldelim}title: "{$user_template->get_name()|escape:'quotes'}", description: "{$user_template->get_description()|replace:"\r\n":'<br>'|escape:'quotes'}", content: "{$user_template->get_content()|strip|replace:'"':'\"'}"{rdelim},
				{/foreach}
			{/if}
			{if isset($user_templates_files)}
				{foreach $user_templates_files as $title => $content}
					{ldelim}title: "{$title|escape:'quotes'}", description: "", content: "{$content|strip|replace:'"':'\"'}"{rdelim},
				{/foreach}
			{/if}
		],
	{/if}


	{* EXTERNAL PLUGINS *}
	external_plugins: {
		{if $enable_linker}
			"cmsms_linker" : "{$TinyMCE->getModuleURLPath()}/lib/js/tinymce_external_plugins/cmsms_linker/plugin.js",
		{/if}
		{* CMS FilePicker: load whenever file manager is allowed. *}
		{if isset($can_use_filemanager) and $can_use_filemanager and $profile->filemanager_use}
			"cmsms_filepicker" : "{$TinyMCE->getModuleURLPath()}/lib/js/tinymce_external_plugins/cmsms_filepicker/plugin.js",
		{/if}
		{if $profile->enable_user_templates}
			"cmsms_template" : "{$TinyMCE->getModuleURLPath()}/lib/js/tinymce_external_plugins/cmsms_template/plugin.js",
		{/if}
		{if $profile->enable_imageedit}
			"cmsms_imageedit" : "{$TinyMCE->getModuleURLPath()}/lib/js/tinymce_external_plugins/cmsms_imageedit/plugin.js",
		{/if}
		{if $profile->enable_markdown}
			"cmsms_markdown" : "{$TinyMCE->getModuleURLPath()}/lib/js/tinymce_external_plugins/cmsms_markdown/plugin.js",
		{/if}
	},

	{* FILE MANAGER / FILEPICKER - cmsms_filepicker registers file_picker_callback for image/link/media dialogs *}
	{if isset($can_use_filemanager) and $can_use_filemanager and $profile->filemanager_use}
		file_picker_types: 'file image media',
		{* file_picker_callback: _callback, *}
	{/if}

	{* callback functions *}
	urlconverter_callback: function(url, elm, onsave, name) {
		var self = this;
		{* var settings = self.settings; *}
		var convertUrls = tinymce.activeEditor.options.get('convert_urls')
		var relativeUrls = tinymce.activeEditor.options.get('convert_urls')
		var removeScriptHost = tinymce.activeEditor.options.get('remove_script_host')

		if (!convertUrls || ( elm && elm.nodeName == 'LINK' ) || url.indexOf('file:') === 0 || url.length === 0) {
			return url;
		}

		// fix entities in cms_selflink urls.
		if (url.indexOf('cms_selflink') != -1) {
			decodeURI(url);
			url = url.replace('%20', ' ');
			return url;
		}
		// Convert to relative
		if (relativeUrls) {
			return self.documentBaseURI.toRelative(url);
		}

		// Convert to absolute
		url = self.documentBaseURI.toAbsolute(url, removeScriptHost);
		return url;
	},


	setup: function(editor) {
		editor.on('change', function(e) {
			$(document).trigger('cmsms_formchange');
		});

		{* CUSTOM DROPDOWN *}
		{if isset($custom_dropdown)}
			editor.ui.registry.addMenuButton('customdropdown',
				{
					{if !empty($profile->custom_dropdown_title)}
						text: ' {$profile->custom_dropdown_title}',
					{/if}
					tooltip: '{$profile->custom_dropdown_title}',
					icon: 'code-sample',
					fetch: function(callback) {
						var items = [
							{foreach $custom_dropdown as $entry}
								{
									type: 'menuitem',
									text: '{$entry.title}',
									onAction: function(){
										{if !isset($entry.value2)}
											editor.insertContent('{$entry.value1|strip}');
										{else}
											sel = editor.selection.getContent();
											editor.insertContent('{$entry.value1|strip}'+sel+'{$entry.value2|strip}');
										{/if}
									}
								},
							{/foreach}
						];
						callback(items);
					}
				}
			);
			editor.ui.registry.addMenuItem('customdropdown', {
				context: 'insert',
				{if !empty($profile->custom_dropdown_title)}
					text: ' {$profile->custom_dropdown_title}',
				{/if}
				icon: 'code-sample',
				getSubmenuItems: () => {
					return [
						{foreach $custom_dropdown as $entry}
							{
								type: 'menuitem',
								text: '{$entry.title}',
								onAction: function(){
									{if !isset($entry.value2)}
										editor.insertContent('{$entry.value1|strip}');
									{else}
										sel = editor.selection.getContent();
										editor.insertContent('{$entry.value1|strip}'+sel+'{$entry.value2|strip}');
									{/if}
								}
							},
						{/foreach}
					];
				}
			});
		{/if}


		{* EXTERNAL MODULES OR DROPDOWNS *************** *}
		{function name='dropdown_menu'}
			{* The parent link (as in Tiny5 we cannot click on the parent anymore, better for touch devices) *}
			{if isset($parent) and isset($parent.content) and $parent.content neq ''}
				{
					type: 'menuitem',
					text: '{$parent.menu_text|escape:quotes}',
					icon: 'chevron-left',
					onAction: function() {
						editor.insertContent('{$parent.content|escape:quotes|strip}');
					},
				},
			{/if}
			{if !empty($menu)}
				{foreach $menu as $entry}
					{
						type: '{if isset($entry.children)}nestedmenuitem{else}menuitem{/if}',
						text: '{$entry.menu_text|escape:quotes}',
						{if !isset($entry.children)}
							onAction: function() {
								editor.insertContent('{$entry.content|escape:quotes|strip}');
							},
						{else}{strip}
							getSubmenuItems: function() {
								return [
									{dropdown_menu menu=$entry.children parent=$entry}
								];
							}
						{/strip}{/if}
					},
				{/foreach}
			{/if}
		{/function}

		{if $external_modules}
			{foreach $external_modules as $external_module}{strip}
				{if !empty($external_module->menu_entries)}
					editor.ui.registry.addMenuButton('{$external_module->button_name}',
						{
							{if $profile->external_modules_show_menutext}
								text: '{if !empty($external_module->image)} {/if}{$external_module->title|escape:quotes}',
							{/if}
							{if $external_module->tooltip neq ''}
								tooltip: '{$external_module->tooltip|escape:quotes}',
							{/if}
							icon: '{$external_module->icon}',
							fetch: function(callback) {
								var items = [
									{dropdown_menu|strip menu=$external_module->menu_entries}
								];
								callback(items);
							}
						}
					);

					editor.ui.registry.addNestedMenuItem('{$external_module->button_name}',	{
							icon: '{$external_module->icon}',
							text: '{$external_module->title|escape:quotes}',
							getSubmenuItems: function() {
								return [
									{dropdown_menu menu=$external_module->menu_entries}
								];
							}
						}
					);
				{/if}
			{/strip}{/foreach}
		{/if}
		{* END EXTERNAL MODULES *}

	},

	{* Extra JS *}
	{if !empty($profile->extra_js)}
		{$profile->extra_js}
	{/if}


});
