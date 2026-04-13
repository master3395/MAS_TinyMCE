<?php
// A
$lang['admindescription'] = 'A full featured WYSIWYG-editor providing file management and image management functionality';
$lang['adminsection'] = 'Submenu for TinyMCE';
$lang['adminsectionhelp'] = 'Select which admin section the TinyMCE module should appear in. This allows you to organize modules according to your preferences.';
$lang['admin_section_invalid'] = 'Invalid admin section selected.';
$lang['admin_section_save'] = 'Save';
$lang['admin_section_saved'] = 'Admin submenu preference saved.';
$lang['adminsub_content'] = 'Content';
$lang['adminsub_ecommerce'] = 'E-Commerce';
$lang['adminsub_extensions'] = 'Extensions';
$lang['adminsub_layout'] = 'Layout';
$lang['adminsub_siteadmin'] = 'Site admin';
$lang['adminsub_usersgroups'] = 'User Management';
$lang['advanced_menu'] = 'Advanced menu';
$lang['apply'] = 'Apply';
$lang['autoresize'] = 'Auto resize';

// B
$lang['block_formats'] = 'Available formats';
$lang['button_name'] = 'Button name';

// C
$lang['cancel'] = 'Cancel';
$lang['cmsms_linker'] = 'Link to content page';
$lang['contextmenu'] = 'Context menu';
$lang['contextmenu_content'] = 'Context menu content';
$lang['copy'] = 'copy';
$lang['copy_profile'] = 'Copy profile';
$lang['css_classes'] = 'CSS classes';
$lang['css_editor_render'] = 'CSS editor render';
$lang['css_files'] = '... or CSS files';
$lang['css_files_info'] = 'One file per line, relative to the CMSMS website root path. Ex: <em>assets/css/styles.css</em>';
$lang['custom_dropdown'] = 'Custom dropdown';
$lang['custom_dropdown_title'] = 'Custom dropdown title';

// D
$lang['database_version_newer_help'] = 'The database has a newer module version than the files. To clear the "Database Version Newer" message in Extensions, sync the stored version to the current files: ';
$lang['default'] = 'Default';
$lang['default_designmanager_template'] = 'Default template from the DesignManager';
$lang['default_profile_set'] = 'Default profile successfully changed';
$lang['delete_profile'] = 'Delete profile';
$lang['delete_profile_confirm']='Are you sure this profile should be deleted?';
$lang['design_css'] = 'Design to use for CSS stylesheets';
$lang['documentation'] = 'Documentation';

// E
$lang['edit_profile'] = 'Edit profile';
$lang['enable_custom_dropdown'] = 'Enable custom dropdown';
$lang['enable_imageedit'] = 'Enable image editing plugin';
$lang['enable_linker'] = 'Load the CMSMS linker plugin (links to content pages)';
$lang['enable_markdown'] = 'Enable markdown plugin';
$lang['enable_user_templates'] = 'Enable user templates';
$lang['error_delete_profile'] = 'An error occurred during the delete process';
$lang['error_cannot_delete_default_profile'] = 'Error: the default profile cannot be deleted';
$lang['error_saving_profile'] = 'An error occurred during the save process';
$lang['external_modules'] = 'External modules';
$lang['external_modules_show_menutext'] = 'Show the button text on the toolbar - unchecked = icon only';
$lang['extra_js'] = 'Extra JavaScript options for the init script';

// F
$lang['filepickertitle'] = 'File picker';
$lang['filemanager'] = 'File manager';
$lang['filemanager_use'] = 'Enable the file manager';
$lang['filemanager_id_profile'] = 'File picker profile';
$lang['filemanager_image_resizing'] = 'Automatically resize images after upload';
$lang['filemanager_image_resizing_title'] = 'Automatic image resizing';
$lang['filemanager_image_resizing_width'] = 'Max image width after resizing';
$lang['filemanager_image_resizing_height'] = 'Max image height after resizing';
$lang['automatic_image_resizing'] = 'Automatically resize images after upload';
$lang['friendlyname'] = 'TinyMCE WYSIWYG editor';
$lang['forced_root_block'] = 'New block type/tag on line break. Default: "p"';

// G
$lang['general'] = 'General';
$lang['global_settings'] = 'Global settings';
$lang['group_frontend'] = 'Frontend users';

// H
$lang['help_advanced_menu'] = 'If you are looking for an advanced menu customization, your can turn this option on. Edit the menu entries in the field below. Using that option will disable the standard menu.';
$lang['help_autoresize'] = 'Enable the <em>autoresize</em> plugin to automatically resize the editor height according to the content size';
$lang['help_cmsms_linker'] = 'Enable the <em>cmsms_linker</em> plugin to easily insert links to other content pages. If you need this tool in your Menu, you must use the <em>Advanced menu</em> in the <em>Menubar</em> tab, and add <em>cmsms_linker</em> in the right section';
$lang['help_tui_editor'] = 'TUI image editor is a full-featured image editor that comes with crop, resize, text, shape tools, and some filters. More about it: <a href="https://ui.toast.com/tui-image-editor/" target="_blank">https://ui.toast.com/tui-image-editor/</a>';
$lang['help_css_files'] = 'Here you can give a list of CSS files to be included in TinyMCE. This option will only work if the {content} tag has not a <em>cssname</em> parameter, and if there is no <em>Design</em> selected.<br>Please write one css file per line, with a path relative to the CMSMS root directory.';
$lang['help_design_css'] = 'TinyMCE can load a set of stylesheets from a design defined in the Design Manager in order to improve the visual experience. Note that if the {content} tag has a <em>cssname</em> parameter, this preference will be ignored in the default JS template (but you can create a new JS template to change that behavior).<br><br><strong>Important:</strong> if you\'re using that feature, you must clear the CMS cache after every stylesheet change in order to see it in TinyMCE.';
$lang['help_enable_custom_dropdown'] = 'Adds a special button so the editors can add some snippets (Smarty tags or not) to their content. Don\'t forget to add the <em><strong>customdropdown</strong></em> button to your toolbar and your custom menubar.';
$lang['help_enable_imageedit'] = 'Loads the <em>cmsms_imageedit</em> plugin, which provides safe in-editor image tools for selected images (quick properties, class/style helpers) without server-side binary edits.';
$lang['help_enable_markdown'] = 'Loads the <em>cmsms_markdown</em> plugin, which adds markdown conversion helpers (selection HTML to markdown, markdown to HTML insertion).';
$lang['help_external_modules'] = 'Some third-party modules can give to TinyMCE a menu to include items. Please select which module should be loaded. Don\'t forget to add the module button to the toolbar if you want it here. The <em>Insert</em> menu will show it too.';
$lang['help_extra_js'] = 'Some JavaScript code you can add to the initialization script to add custom options or behavior. Please separate every option with a comma. Check the TinyMCE configurations options to see what you can use.';
$lang['help_filemanager_image_resizing'] = 'When enabled, images uploaded through the FilePicker from this TinyMCE profile are scaled down on the server after upload (GD), using the max width and height below. At least one dimension must be greater than zero. Does not apply to pasted external image URLs. Requires PHP GD (and WebP support for WebP files).';
$lang['filemanager_image_resizing_scope'] = 'Applies to uploads via the CMS FilePicker opened from TinyMCE while this profile is active (same browser session).';
$lang['subhelp_filemanager_image_resizing'] = 'Applies only to uploads via FilePicker from the TinyMCE editor for this profile. Set max width and/or height to a value greater than 0. Animated GIFs are saved as a single resized frame.';
$lang['filemanager_image_resizing_cleared_no_max'] = 'Automatic image resizing was turned off because both max width and max height were 0. Set at least one dimension (e.g. 1280 px wide) to enable resizing after upload.';
$lang['help_filemanager_use'] = 'Enable the file manager for the admin editor. For security reasons it is never loaded on the frontend.<br><br>When enabled, the CMS Made Simple FilePicker and the <em>cmsms_filepicker</em> plugin supply Browse in the <em>add link</em> and <em>insert image</em> dialogs. Requires the FilePicker module and <em>Modify Files</em> permission.';
$lang['filemanager_use_responsive_fm'] = '(removed) Responsive File Manager';
$lang['help_filemanager_use_responsive_fm'] = 'The bundled Responsive File Manager was removed in module 4.0.6. This module uses the CMS FilePicker only. The option is no longer shown on the profile screen; values are stored as off.';
$lang['help_forced_root_block'] = 'This option defines which type of block/tag will wrap text at the root level of the code.<br><br>You may want to use "p" (paragraph) or "div" (generic container).<br><br>Check the <em>New line behavior</em>setting to define if the <em>Enter</em> key creates a new block or a simple line break "br"';
$lang['help_image_classes'] = 'Here you can tell TinyMCE which classes can be applied to an image. The user will be able to choose it from the add/edit image window. This choice will not be mandatory for the user.';
$lang['help_link_classes'] = 'Here you can tell TinyMCE which classes can be applied to a link. The user will be able to choose it from the add/edit link window. This choice will not be mandatory for the user.';
$lang['help_js_template'] = 'The TinyMCE module can use a specific JavaScript template. This is useful if you want to completely customize the JavaScript that configures TinyMCE.<br><br>If you want to follow the latest JS configuration template shipped with the module, select the <em>Original template shipped with the module</em>.<br><br>If you are a developer, your can change this parameter to use a template from the DesignManager and customize it. Be aware that you may have to edit your custom JS configuration on a new module release to use new features.';
$lang['help_menubar'] = 'Set which menus are displayed to the editor, and in which position. Take a look at the documentation to see which options you can use.';
$lang['help_plugins'] = 'TinyMCE can include external plugins to extend its functions. Before adding any button to the menu or toolbar, you may have to include it here. Note that the <em>cmsms_linker</em>, <em>cmsms_template</em>, <em>contextmenu</em> and <em>cmsms_filepicker</em> plugins are automatically included.<br>Read the documentation to get a complete list of available plugins.';
$lang['help_priority'] = 'This parameter is used to choose which profile has the priority when a user is in multiple user groups that have various TinyMCE profiles. Lower is better.<br><br>For instance: user 1 is linked to  groups A and C. Group A has the TinyMCE profile Y, group C the Z. The profile the user will get when using TinyMCE is the one that has the lower priority number between Y and Z.';
$lang['help_relative_urls'] = 'If checked, all the images/files urls will be defined relative to the root url (example: <em>/uploads/images/myimage.jpg</em>).<br><br>If unchecked, the root url will always be included in the source code (example: <em>http://www.my-website.com/uploads/images/myimage.jpg</em>).';
$lang['help_show_statusbar'] = 'Show or hide the editor statusbar. Please note that enabling the resize function will force the statusbar to be shown.';
$lang['help_style_formats'] = 'The editor users can insert formatted tags to content with the <em>Formats</em> dropdown menu. Here you can define which style will be available in the dropdown. Note that this will not define any visual styles for CSS classes, only give the class name the tag. You must add the proper CSS rules in your CSS file(s) to get a visual render. Take a look at the TinyMCE documentation to configure that option.<br><br>Don\'t forget to add the <em><strong>styles</strong></em> button to your toolbar if you want it here';

$lang['help_toolbar'] = 'Define all the buttons you want to be displayed on the toolbar (the icons bar). Note that you will need to load the appropriate plugins for some buttons.';
$lang['help_use_custom_block_formats'] = 'Customize the formats dropdown to give your users only the formats you want them to use. This will only work with the <em>formatselect</em> button, and with block-level tag types (h1..6, div, pre, ...)';
$lang['help_user_templates'] = 'User templates are HTML templates/blocks that TinyMCE users can easily include in the content using the <em>template</em> plugin. You can create as many user templates as you want in the CMSMS Design Manager (template type: <em>TinyMCE user template</em>) and/or as files in a specific directory (see below).<br><br>Once enabled, don\'t forget to add the <em>template</em> button to you toolbar, if needed. It will be automatically added to the menubar.';
$lang['help_user_templates_files_dir'] = 'If you want to use file templates, fill that field with the path of the directory containing those templates (extension .tpl). Relative to the CMSMS root dir.<br>Ex: <em>assets/tinymce_templates</em>';
$lang['help_usergroups'] = 'Select which user groups will use the current TinyMCE profile. Note that selecting a user group that is currently linked to another profile will remove the current association. If no profile is found for a user group, the default profile will be used.';

// I
$lang['id'] = 'ID';
$lang['image_advtab'] = 'Enable the advanced tab for images (style, spacing, border)';
$lang['image_classes'] = 'CSS classes that can be used for images';
$lang['image_classes_info'] = 'One class per line, example: <code><em>Bordered image=bordered border-round</em></code>';
$lang['image_plugin'] = 'Image plugin options';
$lang['info_linker_autocomplete'] = 'This is an auto complete field. Begin by typing a few characters of the desired page alias, menu text, or title. Any matching items will be displayed in a list.';
$lang['install_profile_admin'] = 'Administrators';
$lang['install_profile_advanced'] = 'Advanced';
$lang['install_profile_frontend'] = 'Frontend';
$lang['install_profile_minimal'] = 'Minimal';
$lang['install_profile_standard'] = 'Standard';

// J
$lang['js_template'] = 'JavaScript template';

// L
$lang['license'] = 'License';
$lang['license_key'] = 'License key';
$lang['link_classes'] = 'CSS classes that can be used for links';
$lang['link_classes_info'] = 'One class per line, example: <code><em>Blue button=btn btn-blue</em></code>';
$lang['loading_info'] = 'Loading...';

// M
$lang['menubar'] = 'Menubar';

// N
$lang['name'] = 'Name';
$lang['newline_behavior'] = 'New line behavior';
$lang['newline_behavior_default'] = 'Default: inserts a block (defined by the <em>New block type/tag on line break</em> setting) on Enter, and a <strong><code>br</code></strong> tag on Shift+Enter.';
$lang['newline_behavior_block'] = 'Block: Enter or Shift+Enter inserts a block in all cases';
$lang['newline_behavior_linebreak'] = 'Linebreak: Enter or Shift+Enter inserts a <strong><code>br</code></strong> tag.';
$lang['newline_behavior_invert'] = 'Invert: swaps Enter and Shift+Enter behaviors.';

$lang['new_profile'] = 'Create a new profile';
$lang['newwindow'] = 'New window';
$lang['no_design_linked'] = 'No design';
$lang['none'] = 'None';

// O
$lang['orig_js_template_file'] = 'Original template shipped with the module';

// P
$lang['plugins'] = 'Plugins';
$lang['postinstall'] = 'The TinyMCE editor has been successfully installed.';
$lang['priority'] = 'Priority';
$lang['profile_copied'] = 'The profile has been successfully duplicated';
$lang['profile_deleted'] = 'The profile has been successfully deleted';
$lang['profile_name'] = 'Profile name';
$lang['profile_saved'] = 'Profile successfully saved';
$lang['profiles'] = 'Profiles';
$lang['prompt_href'] = 'Generated URL';
$lang['prompt_linker'] = 'Enter Page title';
$lang['prompt_profiles'] = 'Profiles';
$lang['prompt_selectedalias'] = 'Selected Page alias';
$lang['prompt_name'] = 'Name';
$lang['prompt_target'] = 'Target';
$lang['prompt_class'] = 'Class attribute';
$lang['prompt_rel'] = 'Rel attribute';
$lang['prompt_texttodisplay'] = 'Text to display';

// R
$lang['relative_urls'] = 'Use relative URLs';
$lang['resize'] =' Resize';
$lang['resize_no'] = 'Do not allow to resize';
$lang['resize_vertical'] = 'Allow vertical resizing';
$lang['resize_both'] = 'Allow vertical and horizontal resizing';

// S
$lang['show_menubar'] = 'Show menubar';
$lang['show_statusbar'] = 'Show statusbar';
$lang['show_toolbar'] = 'Show toolbar';
$lang['style_formats'] = 'Style formats';
$lang['sync_version_to_files'] = 'Sync version to current files';
$lang['style_formats_info'] = 'One rule per line, example: <code><em>title: \'Red title\', block: \'h2\', classes: \'text-red\'</em></code>';
$lang['subhelp_contextmenu_content'] = 'Syntax: <em> link image | table inserttable cell row column deletetable | bold italic</em><br><br><em>Note: the browsers native context menu can still be accessed by holding the Ctrl key while right clicking with the mouse.</em>';
$lang['subhelp_custom_block_formats'] = 'Syntax: <em>Paragraph=p;Header 1=h1;Header 2=h2</em>';
$lang['subhelp_toolbar'] = 'Syntax: <em>undo redo | cut copy paste | bold italic</em><br>Special CMSMS buttons: <em>customdropdown</em>, <em>cmsms_linker</em>, <em>cmsms_template</em>';
$lang['subhelp_custom_dropdown'] = 'Syntax: <em>Item title|content to add</em> or <em>Item title|opening content|end content</em> to add <em>opening content</em> before selection, and <em>end content</em> after it.<br>Don\'t forget to add <em><strong>customdropdown</strong></em> to your toolbar buttons and your custom menubar';
$lang['subhelp_license_key'] = 'Leave free or enter <em>gpl</em> to use the free GPL2 license.<br>Type your commercial license key if you want to use it';
$lang['submit'] = 'Submit';

// T
$lang['tab_general_title'] = 'General';
$lang['tab_advanced_title'] = 'Advanced';
$lang['template'] = 'Template';
$lang['templates'] = 'Templates';
$lang['template_insert'] = 'Insert template';
$lang['template_select'] = 'Select template';
$lang['title_cmsms_filebrowser'] = 'Select a file';
$lang['title_cmsms_linker'] = 'Create a link to a content page';
$lang['toolbar'] = 'Toolbar';
$lang['toolbar1'] = 'Toolbar - 1st line';
$lang['toolbar2'] = 'Toolbar - 2nd line';
$lang['tooltip_selectedalias'] = 'This field is read only';
$lang['type_TinyMCE'] = 'TinyMCE';
$lang['type_js'] = 'JavaScript';
$lang['type_js_description'] = 'JavaScript script that runs TinyMCE - Using a template gives you full control to completely customize TinyMCE for each profile. Please take a look at the TinyMCE documentation (https://www.tinymce.com/docs/) to see how to edit that script.';
$lang['type_usertemplate'] = 'TinyMCE user template';
$lang['type_usertemplate_description'] = 'You can use that type of template to create many HTML blocks the TinyMCE users can include in their content through the <em>templates</em> TinyMCE plugin';

// U
$lang['use_advanced_menu'] = 'Use advanced menu';
$lang['use_custom_block_formats'] = 'Use a custom formats dropdown';
$lang['usergroups'] = 'Users groups';
$lang['user_templates_files_dir'] = 'Directory containing the user templates';



$lang['help'] =  <<<EOT

<h3>What Does This Do?</h3>
<p>
	This module embeds the full TinyMCE WYSIWYG editor version in CMS Made Simple. It works with content blocks in CMSMS content pages (when a WYSIWYG has been allowed), in module Admin forms where WYSIWYG editors are allowed, and allows restricted capabilities for editing html blocks on frontend pages.
</p>
<p>In order for TinyMCE to be used as the WYSIWYG editor in the Admin console the TinyMCE WYSIWYG Editor needs to be selected in the users preferences.  Please select &quot;TinyMCE&quot; in the &quot;Select WYSIWYG to Use&quot; option under &quot;My Preferences &gt;&gt; User Preferences&quot; in the CMSMS Admin panel.  Additional options in various modules or in content page templates, and content pages themselves can control whether a text area or a WYSIWYG field is provided in various edit forms.</p>
<p>For Frontend editing capabilities TinyMCE must be selected as the &quot;Frontend WYSIWYG&quot; in the global settings page of the CMSMS admin console.</p>

<h3>Features:</h3>
<ul>
	<li>Full native <a href="http://www.tinymce.com" target="_blank">TinyMCE editor</a> is available.</li>
	<li>Configuration profiles and backend groups attribution.</li>
	<li>Lots of customization options: toolbar, menubar, external modules, custom styles, ...</li>
	<li>Uses the internal page linker from the MicroTiny module.</li>
	<li>Embeds the CMS Made Simple <strong>FilePicker</strong> for browsing and uploads in the admin (choose the FilePicker profile per TinyMCE profile). The <em>cmsms_filepicker</em> plugin wires <strong>Browse</strong> into the <em>Insert/Edit image</em> and <em>Insert/Edit link</em> dialogs when the file manager is enabled.
		<br>Note: for security reasons, the file manager is not loaded for frontend users.</li>
	<li>Template inclusion plugin to easily preview and include HTML blocks from DesignManager in your content</li>
	<li>Ability to use an external javascript template file from the DesignManager instead of the stock JS file - This permits a complete customization of the init script.</li>
	<li>Customizable appearance by specifying a design to use for the editor.</li>
</ul>

<h3>How do I use it</h3>
<ul>
	<li>Install the module</li>
	<li>Create and configure profiles from the TinyMCE module in the admin (default menu: <em>Extensions</em> &rarr; <em>TinyMCE WYSIWYG editor</em>). From module <strong>8.0.2</strong> onward you can move the module to another admin section (e.g. <em>Content</em>) using the <em>Admin submenu for TinyMCE</em> setting on that page.</li>
	<li>Don't forget to link profiles with backend user groups (or frontend) in the TinyMCE profile</li>
	<li>Set TinyMCE as your WYSIWYG editor of choice in &quot;My Preferences&quot;</li>
</ul>

<p>
	Note about profile edition: the backend user <strong>must have</strong> the <em>Manage TinyMCE profiles</em> permission to get the TinyMCE Admin page.
</p>

<br>
<p>
	<strong style="color: red">Important:</strong> if your root <code>.htaccess</code> still whitelists PHP under an old TinyMCE path, replace it with the current CMS Made Simple guidance for blocking PHP execution under <code>modules/</code> and upload trees.
</p>

<h3>Supported PHP versions</h3>
<p>This fork targets <strong>PHP 7.4</strong> through <strong>PHP 8.5</strong> with CMS Made Simple <strong>2.2.15+</strong>. After each server or container upgrade, re-test the editor (profiles, FilePicker, image upload) and the module entry in Site admin.</p>

<h3>Caching:</h3>
<p>In an effort to improve performance, TinyMCE will attempt to cache the generated JavaScript files unless something has changed. Saving a profile or clearing the CMS Made Simple cache will always reset the JS cache file.</p>

<h3>Recent maintenance (see changelog)</h3>
<p><strong>Version 8.0.3</strong> updates the bundled TinyMCE core to 8.4.0 (GPL core), including plugin/skin refresh and DOMPurify 3.3.2 in notices, while keeping CMSMS integrations (<em>cmsms_filepicker</em>, <em>cmsms_linker</em>, <em>cmsms_template</em>) and FilePicker post-upload resize behavior. Optional CMSMS external plugins <em>cmsms_imageedit</em> and <em>cmsms_markdown</em> are available per profile and disabled by default.</p>
<p>For <em>cmsms_linker</em>: add the button to the toolbar and/or include it in the <em>Advanced menu</em> JSON if you want it under a custom menubar; duplicate keys in JSON menus can hide items.</p>

<h3>Official releases and dates (CMSMS Forge)</h3>
<p>Module packages and release notes are published on the Forge file area (same project as upstream TinyMCE for CMSMS): <a href="https://dev.cmsmadesimple.org/project/files/12" target="_blank" rel="noopener noreferrer">https://dev.cmsmadesimple.org/project/files/12</a></p>
<ul>
	<li><strong>4.0.0-beta3</strong>: Forge release <strong>25.02.2026</strong></li>
	<li><strong>4.0.0-beta1</strong>: Forge release <strong>17.09.2025</strong></li>
</ul>
<p>Older 3.x lines on the Forge also list their own release dates on that page. Current site maintenance is listed in the module changelog (About), including <strong>Version 8.0.3</strong> and <strong>Version 8.0.2</strong>.</p>

<h3>Module developers: how to create a new button for your module in TinyMCE?</h3>
<p>
	You must add three functions to your main module class - Example for the Gallery module:
</p>

<code><pre>
	function HasCapability(&#36;capability, &#36;params=array()) {
		if (&#36;capability=='WYSIWYGItems') return true;
		return false;
	}

	function GetWYSIWYGBtnName()
	{
		return 'module_gallery';
	}

	function GetWYSIWYGBtn(&#36;wysiwyg_module)
	{
		// TEST ARRAY EXAMPLE
		&#36;items = array(
			array(
				'menu_text' => 'Gallery 1',
				'content' => "{Gallery dir='dir1'}", // Empty = no action on click
				'children' => array(
					array(
						'menu_text' => 'SubGallery 1.1',
						'content' => "{Gallery dir='subdir11'}"
						'children' => array() // You can have as many sublevels as you need
					),
					array(
						'menu_text' => 'SubGallery 1.2',
						'content' => "{Gallery dir='subdir12'}"
					),
					array(
						'menu_text' => 'SubGallery 1.3',
						'content' => "{Gallery dir='subdir13'}"
					)
				)
			),
			array(
				'menu_text' => 'Gallery 2',
				'content' => "{Gallery dir='dir2'}", // Empty = no action on click
				'children' => array(
					array(
						'menu_text' => 'SubGallery 2.1',
						'content' => "{Gallery dir='subdir21'}"
					),
					array(
						'menu_text' => 'SubGallery 2.2',
						'content' => "{Gallery dir='subdir22'}"
					),
					array(
						'menu_text' => 'SubGallery 2.3',
						'content' => "{Gallery dir='subdir23'}"
					)
				)
			)
		);

		// BUILD THE BUTTON OBJECT USED BY THE TinyMCE MODULE
		if (&#36;wysiwyg_module == 'TinyMCE')
		{
			&#36;obj = new tinymce_modulemenu;
			&#36;obj->module_name = &#36;this->GetName();
			&#36;obj->button_name = &#36;this->GetWYSIWYGBtnName();
			&#36;obj->title = &#36;this->Lang('tinymce_button_picker');
			&#36;obj->tooltip = &#36;this->Lang('tinymce_description_picker');
			&#36;obj->icon = 'image';
			&#36;obj->image = &#36;this->GetModuleURLPath() . '/images/icon.gif';
			&#36;obj->menu_entries = &#36;items;
			&#36;obj->menu_section = 'insert';

			return &#36;obj;
		}
		return false;
	}
</pre></code>

<p>
	The <strong>GetWYSIWYGBtn()</strong> function must return a <strong>tinymce_modulemenu</strong> object with an array <em>menu_entries</em> property.
</p>
<br>

<h3>License informations</h3>
<p>This module is free software - you can use it under the terms of the GNU General Public License 2 or any later version.</p>
<p>
	TinyMCE has two licenses options: GPL v2 and Commercial. Check this page for documentation: <a href="https://www.tiny.cloud/docs/tinymce/latest/license-key/" target="_blank">https://www.tiny.cloud/docs/tinymce/latest/license-key/</a>
</p>

<h3>Help and support</h3>
<p>We tried to explain each configuration option on the profile edition Admin page. Please use the "?" buttons near each option to get more informations.</p>

<h3>Bug report or feature request</h3>
<p>
	Project tracker: <a href="https://dev.cmsmadesimple.org/projects/tinymce" target="_blank" rel="noopener noreferrer">https://dev.cmsmadesimple.org/projects/tinymce</a>
	<br>Downloads and dated releases: <a href="https://dev.cmsmadesimple.org/project/files/12" target="_blank" rel="noopener noreferrer">https://dev.cmsmadesimple.org/project/files/12</a>
</p>

<h3>Current authors/devs</h3>
<ul>
	<li>Mathieu Muths: <a href="mailto:contact@airelibre.net">contact@airelibre.net</a></li>
	<li>Chris Taylor: <a href="https://dev.cmsmadesimple.org/users/chrisbt" target="_blank">chrisbt</a></li>
	<li>Morten Poulsen: <a href="mailto:morten@poulsen.org">morten@poulsen.org</a></li>
</ul>
<p>
	Thanks to all the other devs that worked on this module for the past years.
</p>
<p>
	Special thanks to Alberto Peripolli for the original Responsive File Manager project, which this module shipped for many years before moving to FilePicker-only in 4.0.6. Website: <a href="https://www.responsivefilemanager.com" target="_blank" rel="noopener noreferrer">https://www.responsivefilemanager.com</a>
</p>
EOT;

?>
