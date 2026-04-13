<?php
#CMS - CMS Made Simple
#(c)2004 by Ted Kulp (ted@cmsmadesimple.org)
#Visit our homepage at: http://www.cmsmadesimple.org
#
#This program is free software; you can redistribute it and/or modify
#it under the terms of the GNU General Public License as published by
#the Free Software Foundation; either version 2 of the License, or
#(at your option) any later version.
#
#This program is distributed in the hope that it will be useful,
#but WITHOUT ANY WARRANTY; without even the implied warranty of
#MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
#GNU General Public License for more details.
#You should have received a copy of the GNU General Public License
#along with this program; if not, write to the Free Software
#Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
#
if( !isset($gCms) ) exit;

$db = $this->GetDb();


// Everything under 3.* series
if( version_compare($oldversion,'2.99') < 0 )
{
  // Remove old files
  $dirs_remove = array(
    'docs',
    'tinymce'
  );
  foreach ($dirs_remove as $dir_remove)
    recursive_delete($this->GetModulePath() . DIRECTORY_SEPARATOR . $dir_remove);


  $files_remove = array(
    'images/cmsmslink.gif',
    'images/delete.gif',
    'images/dir.gif',
    'images/fileicon.gif',
    'images/images.gif',
    'templates/advancedpanel.tpl',
    'templates/filepicker.tpl',
    'templates/pluginspanel.tpl',
    'templates/profilespanel.tpl',
    'templates/settingspanel.tpl',
    'templates/stylespanel.tpl',
    'templates/tinyconfig.tpl',
    'action.filepicker.php',
    'action.saveadvanced.php',
    'action.saveplugins.php',
    'action.saveprofiles.php',
    'action.savesettings.php',
    'action.savestyles.php',
    'action.stylesheet.php',
    'action.tinyconfig.php',
    'event.Core.ContentPostRender.php',
    'filepicker.css',
    'filepicker.php',
    'function.admin_advanced.php',
    'function.admin_plugins.php',
    'function.admin_profiles.php',
    'function.admin_settings.php',
    'function.admin_styles.php',
    'function.admin_testarea.php',
    'stylesheet.php',
    'tinyconfig_gz.php',
    'tinyconfig.php',
    'tinylogo.png',
    'todo.php'
  );
  foreach ($files_remove as $file_remove)
    unlink($this->GetModulePath() . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $file_remove));



  // Profiles *******************************
  $dict = NewDataDictionary($db);
  $flds = "
  	id_profile I KEY AUTO,
  	id_template I,
  	name C(255),
  	priority I,
  	resize C(20),
  	autoresize I,
  	plugins X,
    enable_linker I,
  	show_menubar I,
  	menubar C(255),
  	use_advanced_menu I,
  	advanced_menu X,
  	show_toolbar I,
  	toolbar1 X,
  	toolbar2 X,
  	enable_contextmenu I,
  	contextmenu X,
  	show_statusbar I,
  	id_design I,
  	link_classes X,
  	image_classes X,
    style_formats X,
  	use_custom_block_formats I,
  	block_formats C(255),
  	enable_user_templates I,
  	enable_custom_dropdown I,
  	custom_dropdown_title C(100),
  	custom_dropdown X,
  	extra_js X,
  	external_modules X,
  	external_modules_show_menutext I,
  	filemanager_use I,
  	filemanager_delete_files I,
  	filemanager_create_folders I,
  	filemanager_delete_folders I,
  	filemanager_upload_files I,
  	filemanager_rename_files I,
  	filemanager_rename_folders I,
  	filemanager_duplicate_files I,
  	filemanager_copy_cut_files I,
  	filemanager_copy_cut_dirs I,
  	filemanager_chmod_files I,
  	filemanager_chmod_dirs I,
  	filemanager_preview_text_files I,
  	filemanager_create_text_files I,
  	filemanager_edit_text_files I,
  	filemanager_image_resizing I,
  	filemanager_image_resizing_width I,
  	filemanager_image_resizing_height I,
  	filemanager_aviary_active I,
  	filemanager_aviary_apiKey C(60)
  ";
  $taboptarray = array('mysql' => 'TYPE=MyISAM');
  $sqlarray = $dict->CreateTableSQL(CMS_DB_PREFIX.TinyMCE::TINYMCE_PROFILES_TABLE, $flds, $taboptarray);
  $dict->ExecuteSQLArray($sqlarray);


  // Profile_group **************************
  $flds = "
  	id_profile I KEY,
  	id_group I KEY
  ";
  $taboptarray = array('mysql' => 'TYPE=MyISAM');
  $sqlarray = $dict->CreateTableSQL(CMS_DB_PREFIX.TinyMCE::TINYMCE_PROFILEGROUP_TABLE, $flds, $taboptarray);
  $dict->ExecuteSQLArray($sqlarray);







  // CREATE TEMPLATE TYPES

  // JS
  try {
  	$js_template_type = new CmsLayoutTemplateType();
  	$js_template_type->set_originator($this->GetName());
  	$js_template_type->set_dflt_flag(true);
  	$js_template_type->set_lang_callback('TinyMCE::page_type_lang_callback');
  	$js_template_type->set_content_callback('TinyMCE::reset_page_type_defaults');
  	$js_template_type->set_name('js');
  	$js_template_type->set_description($this->Lang('type_js_description'));
  	$js_template_type->reset_content_to_factory();
  	$js_template_type->save();
  }
  catch (CmsException $e) {
  	// log it
  	debug_to_log(__FILE__.':'.__LINE__.' '.$e->GetMessage());
  	audit('',$this->GetName(),'Installation Error: '.$e->GetMessage());
  }



  // TINYMCETEMPLATE ; for the template plugin
  try {
  	$tinytpl_template_type = new CmsLayoutTemplateType();
  	$tinytpl_template_type->set_originator($this->GetName());
  	$tinytpl_template_type->set_dflt_flag(true);
  	$tinytpl_template_type->set_lang_callback('TinyMCE::page_type_lang_callback');
  	$tinytpl_template_type->set_content_callback('TinyMCE::reset_page_type_defaults');
  	$tinytpl_template_type->set_name('usertemplate');
  	$tinytpl_template_type->set_description($this->Lang('type_usertemplate_description'));
  	$tinytpl_template_type->reset_content_to_factory();
  	$tinytpl_template_type->save();
  }
  catch (CmsException $e) {
  	// log it
  	debug_to_log(__FILE__.':'.__LINE__.' '.$e->GetMessage());
  	audit('',$this->GetName(),'Installation Error: '.$e->GetMessage());
  }


  // CREATE SAMPLE / DEFAULT TEMPLATES
  $uid = get_userid();
  try {
  	$fn = dirname(__FILE__).DIRECTORY_SEPARATOR.'templates'.DIRECTORY_SEPARATOR.'orig_js_template.tpl';
  	if( file_exists( $fn ) ) {
      $template = @file_get_contents($fn);
      $sample_tpl = new CmsLayoutTemplate();
      $sample_tpl->set_name('TinyMCE default Javascript');
      $sample_tpl->set_owner($uid);
      $sample_tpl->set_content($template);
      $sample_tpl->set_type($js_template_type);
      $sample_tpl->set_type_dflt(TRUE);
      $sample_tpl->save();
    }
  }
  catch( CmsException $e ) {
    // log it
    debug_to_log(__FILE__.':'.__LINE__.' '.$e->GetMessage());
    audit('',$this->GetName(),'Installation Error: '.$e->GetMessage());
  }



  // INITIAL PROFILES : UPGRADE FROM PREVIOUS "profiles"
  // Clear the old plugins string: removes plugins that are not in the new TinyMCE plugin dir
  function clear_plugins($old_plugins, $mod)
  {
  	if (empty($old_plugins)) return '';

  	// NEW names
  	$replace_map = array(
  		'advimage'=>'image',
  		'advlink'=>'link'
  	);
  	$to_replace = array_keys($replace_map);
  	$replace_with = array_values($replace_map);
  	$old_plugins = str_replace($to_replace, $replace_with, $old_plugins);

  	// FILTER
  	$old_plugins = explode(',', $old_plugins);
  	$plugins = '';
  	$plugins_dir = cms_join_path($mod->GetModulePath(), 'lib', 'js', 'tinymce', 'plugins');
  	$plugins_valid = array();

  	foreach (glob($plugins_dir . '/*') as $dir)
  	{
  		if (is_dir($dir))
  		{
  			$plugins_valid[] = basename($dir);
  		}
  	}

  	$plugins = array_intersect($old_plugins, $plugins_valid);
  	$plugins = implode(' ', $plugins);

  	return $plugins;
  }

  // Upgrade the toolbar
  function clear_toolbar($old_toolbar)
  {
    $replace_map = array(
      ',' => ' ',
      'separator' => '|',
      'justifyleft' => 'alignleft',
      'justifycenter'=>'aligncenter',
      'justifyright'=>'alignright',
      'justifyfull'=>'alignjustify',
      'cleanup'=>'',
      'help'=>'',
      'sub'=>'subscript',
      'sup'=>'superscript',
      'forecolorpicker'=>'',
      'backcolorpicker'=>'',
      'visualaid'=>'visualchars',
      'advhr'=>'hr',
      'emotions'=>'emoticons',
      'fullpage'=>'',
      'iespell'=>'spellchecker',
      'cmslinker'=>'cmsms_linker',
      'gallery_picker'=>'module_gallery'
    );
    $to_replace = array_keys($replace_map);
    $replace_with = array_values($replace_map);
    return str_replace($to_replace, $replace_with, $old_toolbar);
  }

  // Get the current preferences
  $prefs_to_get = array(
    'editor_height_auto',
    'allowscaling',
    'allowresizing',
    'scalingwidth',
    'scalingheight',
    'toolbar1',
    'toolbar2',
    'toolbar3',
    'allowupload',
    'advanced_toolbar1',
    'advanced_toolbar2',
    'advanced_toolbar3',
    'advanced_allowupload',
    'plugins',
    'customdropdown',
    'loadcmslinker',
    'allow_tables',
    'advanced_allow_tables',
    'front_allow_tables'
  );
  foreach ($prefs_to_get as $pref)
    $$pref = $this->GetPreference($pref, '');

  // And clear old preferences
  // $this->RemovePreference(); // TODO

  // Create profiles
  // Common data
  $profile = new tinymce_profile();
  switch($allowresizing) {
    case 'none':
      $profile->resize = '0';
      break;
    case 'both':
      $profile->resize = 'both';
      break;
    case 'height':
      $profile->resize = '1';
      break;
  }
  $profile->autoresize = $editor_height_auto;
  if ($allowscaling)
  {
    $profile->filemanager_image_resizing = 1;
    $profile->filemanager_image_resizing_width = $scalingwidth;
    $profile->filemanager_image_resizing_height = $scalingheight;
  }
  if (!empty($customdropdown))
  {
    $profile->enable_custom_dropdown = true;
    $profile->custom_dropdown = $customdropdown;
  }
  $profile->enable_linker = $loadcmslinker;


  // ADMIN **********************************
  $profile->name = $this->Lang('install_profile_admin');;
  $profile->toolbar1 = clear_toolbar($advanced_toolbar1);
  $profile->toolbar2 = clear_toolbar($advanced_toolbar2);
  if ($advanced_allowupload)
    $profile->filemanager_use = true;

  $profile->plugins = clear_plugins($plugins, $this);
  if ($advanced_allow_tables)
    $profile->plugins .= ' table';

  $profile->save();
  tinymce_utils::add_groups_to_profile($profile->id_profile, array(1)); // ID 1 is admin


  // STANDARD - other users **********************************
  $profile->id_profile = false;
  $profile->name = $this->Lang('install_profile_standard');;
  $profile->toolbar1 = clear_toolbar($toolbar1);
  $profile->toolbar2 = clear_toolbar($toolbar2);
  if ($allowupload)
    $profile->filemanager_use = true;

  $profile->plugins = clear_plugins($plugins, $this);
  if ($allow_tables)
    $profile->plugins .= ' table';

  $profile->save();
  $this->SetPreference('id_default_profile', $profile->id_profile);


  // FRONTEND **********************************
  $profile->id_profile = false;
  $profile->name = $this->Lang('install_profile_frontend');
  $profile->toolbar1 = 'bold italic underline | formatselect'; // Reset to minimal
  $profile->toolbar2 = ''; // Just in case the default profile from the tinymce_profile class changes
  $profile->show_menubar = false;
  $profile->enable_linker = false;
  $profile->filemanager_use = false;
  $profile->plugins = clear_plugins($plugins, $this);
  if ($front_allow_tables)
    $profile->plugins .= ' table';

  $profile->save();
  tinymce_utils::add_groups_to_profile($profile->id_profile, -1); // ID -1 is frontend




  // PERMISSIONS
  $this->CreatePermission('Manage TinyMCE profiles', 'Manage TinyMCE profiles');


  // SALT FOR ACCESS KEY FOR RESPONSIVE FILE MANAGER
  $this->SetPreference('filemanager_salt', substr(md5(rand()), 0, 10));



}


if( version_compare($oldversion,'3.0-beta2') < 0 )
{
  // Add the "force_p_rootblock" data to profile
  $dict = NewDataDictionary($db);
  $sqlarray = $dict->AddColumnSQL(CMS_DB_PREFIX.TinyMCE::TINYMCE_PROFILES_TABLE,'forced_root_block I');
  $dict->ExecuteSQLArray($sqlarray);

  $query = 'UPDATE '.CMS_DB_PREFIX.TinyMCE::TINYMCE_PROFILES_TABLE.' SET forced_root_block=1';
  $db->Execute($query);
}






if( version_compare($oldversion,'3.1') < 0 )
{
    // Add the relative_urls option
    $dict = NewDataDictionary($db);
    $sqlarray = $dict->AddColumnSQL(CMS_DB_PREFIX.TinyMCE::TINYMCE_PROFILES_TABLE,'relative_urls I');
    $dict->ExecuteSQLArray($sqlarray);
    $sqlarray = $dict->AddColumnSQL(CMS_DB_PREFIX.TinyMCE::TINYMCE_PROFILES_TABLE,'image_advtab I');
    $dict->ExecuteSQLArray($sqlarray);

    $query = 'UPDATE '.CMS_DB_PREFIX.TinyMCE::TINYMCE_PROFILES_TABLE.' SET relative_urls=1, image_advtab=0';
    $db->Execute($query);
}










if (version_compare($oldversion, '3.3') < 0) {
    // Replace Aviary
    $dict = newDataDictionary($db);
    $sqlarray = $dict->renameColumnSQL(CMS_DB_PREFIX . TinyMCE::TINYMCE_PROFILES_TABLE, 'filemanager_aviary_active', 'filemanager_tui_active', 'filemanager_tui_active I');
    $dict->executeSQLArray($sqlarray);

    $sqlarray = $dict->dropColumnSQL(CMS_DB_PREFIX . TinyMCE::TINYMCE_PROFILES_TABLE, 'filemanager_aviary_apiKey');
    $dict->executeSQLArray($sqlarray);

    $sqlarray = $dict->dropColumnSQL(CMS_DB_PREFIX . TinyMCE::TINYMCE_PROFILES_TABLE, 'enable_contextmenu');
    $dict->executeSQLArray($sqlarray);

    $sqlarray = $dict->AddColumnSQL(CMS_DB_PREFIX.TinyMCE::TINYMCE_PROFILES_TABLE,'css_files X');
    $dict->ExecuteSQLArray($sqlarray);

    $sqlarray = $dict->AddColumnSQL(CMS_DB_PREFIX.TinyMCE::TINYMCE_PROFILES_TABLE,'user_templates_files_dir C(250)');
    $dict->ExecuteSQLArray($sqlarray);
}










if (version_compare($oldversion, '4.0.0-beta1') < 0) {
    $dict = NewDataDictionary($db);

    // Remove responsive file manager
    recursive_delete($this->getModulePath() . DIRECTORY_SEPARATOR . 'responsive_filemanager');
    $columnsToDelete = [
      'filemanager_delete_files',
      'filemanager_create_folders',
      'filemanager_delete_folders',
      'filemanager_upload_files',
      'filemanager_rename_files',
      'filemanager_rename_folders',
      'filemanager_duplicate_files',
      'filemanager_copy_cut_files',
      'filemanager_copy_cut_dirs',
      'filemanager_chmod_files',
      'filemanager_chmod_dirs',
      'filemanager_preview_text_files',
      'filemanager_create_text_files',
      'filemanager_edit_text_files',
      'filemanager_image_resizing',
      'filemanager_image_resizing_width',
      'filemanager_image_resizing_height',
      'filemanager_tui_active',
    ];
    foreach ($columnsToDelete as $oneCol) {
      $sqlarray = $dict->dropColumnSQL(CMS_DB_PREFIX . TinyMCE::TINYMCE_PROFILES_TABLE, $oneCol);
      $dict->executeSQLArray($sqlarray);
    }
    // Remove RFM salt preference
    $this->removePreference('filemanager_salt');
    // Update toolbar
    $sql = 'UPDATE ' . CMS_DB_PREFIX . TinyMCE::TINYMCE_PROFILES_TABLE . '
            SET
                toolbar1 = REPLACE(toolbar1, "responsivefilemanager", ""),
                toolbar2 = REPLACE(toolbar2, "responsivefilemanager", "")
          ';
    $db->execute($sql);

    // Filemanager (filepicker) profile
    $sqlarray = $dict->addColumnSQL(CMS_DB_PREFIX.TinyMCE::TINYMCE_PROFILES_TABLE,'filemanager_id_profile I');
    $dict->ExecuteSQLArray($sqlarray);

    // Autoupdate the plugins list for "paste"
    $sql = 'UPDATE ' . CMS_DB_PREFIX . TinyMCE::TINYMCE_PROFILES_TABLE . ' SET plugins = REPLACE(plugins, "paste", "")';
    $db->execute($sql);

    // Remove "imagetools"
    $sql = 'UPDATE ' . CMS_DB_PREFIX . TinyMCE::TINYMCE_PROFILES_TABLE . ' SET plugins = REPLACE(plugins, "imagetools", "")';
    $db->execute($sql);
    $sql = 'UPDATE ' . CMS_DB_PREFIX . TinyMCE::TINYMCE_PROFILES_TABLE . ' SET contextmenu = REPLACE(contextmenu, "imagetools", "")';
    $db->execute($sql);

    // Replace formatselect with blocks
    $sql = 'UPDATE ' . CMS_DB_PREFIX . TinyMCE::TINYMCE_PROFILES_TABLE . '
            SET
                toolbar1 = REPLACE(toolbar1, "formatselect", "blocks"),
                toolbar2 = REPLACE(toolbar2, "formatselect", "blocks")
          ';
    $db->execute($sql);

    // Replace template with cmsms_template
    $sql = 'UPDATE ' . CMS_DB_PREFIX . TinyMCE::TINYMCE_PROFILES_TABLE . '
            SET
                toolbar1 = REPLACE(toolbar1, "template", "cmsms_template"),
                toolbar2 = REPLACE(toolbar2, "template", "cmsms_template")
          ';
    $db->execute($sql);

    // Migrate "forced_root_block" to "newline_behavior" and update "force_root_block"
    $sqlarray = $dict->addColumnSQL(CMS_DB_PREFIX.TinyMCE::TINYMCE_PROFILES_TABLE, 'newline_behavior C(10)');
    $dict->ExecuteSQLArray($sqlarray);
    // Update informations according to the previous forced_root_block value
    $query = 'UPDATE ' . CMS_DB_PREFIX . TinyMCE::TINYMCE_PROFILES_TABLE . ' SET newline_behavior="default" WHERE forced_root_block = 1';
    $db->Execute($query);
    $query = 'UPDATE ' . CMS_DB_PREFIX . TinyMCE::TINYMCE_PROFILES_TABLE . ' SET newline_behavior="linebreak" WHERE forced_root_block = 0';
    $db->Execute($query);

    // Change forced_root_block column type from int to varchar
    $sqlarray = $dict->alterColumnSQL(CMS_DB_PREFIX.TinyMCE::TINYMCE_PROFILES_TABLE, 'forced_root_block C(50)');
    $dict->ExecuteSQLArray($sqlarray);
    // Set to "P" tag force the forced_root_block
    $query = 'UPDATE ' . CMS_DB_PREFIX . TinyMCE::TINYMCE_PROFILES_TABLE . ' SET forced_root_block="p"';
    $db->Execute($query);

    // Add licence field
    $sqlarray = $dict->addColumnSQL(CMS_DB_PREFIX.TinyMCE::TINYMCE_PROFILES_TABLE, 'license_key C(200)');
    $dict->ExecuteSQLArray($sqlarray);

    // Files cleanup
    @unlink(cms_join_path($this->getModulePath(), 'lib', 'js', 'tinymce', 'changelog.txt'));
    @unlink(cms_join_path($this->getModulePath(), 'lib', 'js', 'tinymce', 'jquery.tinymce.min.js'));
    @unlink(cms_join_path($this->getModulePath(), 'lib', 'js', 'tinymce', 'license.txt'));

    @unlink(cms_join_path($this->getModulePath(), 'lib', 'js', 'tinymce_external_plugins', 'cmsms_linker', 'plugin.min.js'));

    recursive_delete(cms_join_path($this->getModulePath(), 'lib', 'js', 'tinymce', 'plugins', 'bbcode'));
    recursive_delete(cms_join_path($this->getModulePath(), 'lib', 'js', 'tinymce', 'plugins', 'colorpicker'));
    recursive_delete(cms_join_path($this->getModulePath(), 'lib', 'js', 'tinymce', 'plugins', 'contextmenu'));
    recursive_delete(cms_join_path($this->getModulePath(), 'lib', 'js', 'tinymce', 'plugins', 'example'));
    recursive_delete(cms_join_path($this->getModulePath(), 'lib', 'js', 'tinymce', 'plugins', 'example_dependency'));
    recursive_delete(cms_join_path($this->getModulePath(), 'lib', 'js', 'tinymce', 'plugins', 'fullpage'));
    recursive_delete(cms_join_path($this->getModulePath(), 'lib', 'js', 'tinymce', 'plugins', 'hr'));
    recursive_delete(cms_join_path($this->getModulePath(), 'lib', 'js', 'tinymce', 'plugins', 'imagetools'));
    recursive_delete(cms_join_path($this->getModulePath(), 'lib', 'js', 'tinymce', 'plugins', 'layer'));
    recursive_delete(cms_join_path($this->getModulePath(), 'lib', 'js', 'tinymce', 'plugins', 'legacyoutput'));
    recursive_delete(cms_join_path($this->getModulePath(), 'lib', 'js', 'tinymce', 'plugins', 'noneditable'));
    recursive_delete(cms_join_path($this->getModulePath(), 'lib', 'js', 'tinymce', 'plugins', 'paste'));
    recursive_delete(cms_join_path($this->getModulePath(), 'lib', 'js', 'tinymce', 'plugins', 'print'));
    recursive_delete(cms_join_path($this->getModulePath(), 'lib', 'js', 'tinymce', 'plugins', 'spellchecker'));
    recursive_delete(cms_join_path($this->getModulePath(), 'lib', 'js', 'tinymce', 'plugins', 'tabfocus'));
    recursive_delete(cms_join_path($this->getModulePath(), 'lib', 'js', 'tinymce', 'plugins', 'template'));
    recursive_delete(cms_join_path($this->getModulePath(), 'lib', 'js', 'tinymce', 'plugins', 'textcolor'));
    recursive_delete(cms_join_path($this->getModulePath(), 'lib', 'js', 'tinymce', 'plugins', 'textpattern'));
    recursive_delete(cms_join_path($this->getModulePath(), 'lib', 'js', 'tinymce', 'plugins', 'toc'));

    recursive_delete(cms_join_path($this->getModulePath(), 'lib', 'js', 'tinymce', 'plugins', 'emoticons', 'img'));
    recursive_delete(cms_join_path($this->getModulePath(), 'lib', 'js', 'tinymce', 'plugins', 'help', 'img'));
    @unlink(cms_join_path($this->getModulePath(), 'lib', 'js', 'tinymce', 'plugins', 'media', 'moxieplayer.swf'));
    recursive_delete(cms_join_path($this->getModulePath(), 'lib', 'js', 'tinymce', 'plugins', 'visualblocks', 'css'));
    recursive_delete(cms_join_path($this->getModulePath(), 'lib', 'js', 'tinymce', 'plugins', 'codesample', 'css'));

    recursive_delete(cms_join_path($this->getModulePath(), 'lib', 'js', 'tinymce', 'skins', 'lightgray'));
    recursive_delete(cms_join_path($this->getModulePath(), 'lib', 'js', 'tinymce', 'skins', 'ui', 'oxide', 'fonts'));
    @unlink(cms_join_path($this->getModulePath(), 'lib', 'js', 'tinymce', 'skins', 'ui', 'oxide', 'content.mobile.min.css'));
    @unlink(cms_join_path($this->getModulePath(), 'lib', 'js', 'tinymce', 'skins', 'ui', 'oxide', 'skin.mobile.min.css'));
    recursive_delete(cms_join_path($this->getModulePath(), 'lib', 'js', 'tinymce', 'skins', 'ui', 'oxide-dark', 'fonts'));
    @unlink(cms_join_path($this->getModulePath(), 'lib', 'js', 'tinymce', 'skins', 'ui', 'oxide-dark', 'content.mobile.min.css'));
    @unlink(cms_join_path($this->getModulePath(), 'lib', 'js', 'tinymce', 'skins', 'ui', 'oxide-dark', 'skin.mobile.min.css'));

    recursive_delete(cms_join_path($this->getModulePath(), 'lib', 'js', 'tinymce', 'themes', 'inlite'));
    recursive_delete(cms_join_path($this->getModulePath(), 'lib', 'js', 'tinymce', 'themes', 'mobile'));
    recursive_delete(cms_join_path($this->getModulePath(), 'lib', 'js', 'tinymce', 'themes', 'modern'));

}

// 4.0.0-beta4: Restore Responsive File Manager support (image resizing columns + filemanager_salt)
if (version_compare($oldversion, '4.0.0-beta4') < 0) {
    $dict = NewDataDictionary($db);
    $tablename = CMS_DB_PREFIX . TinyMCE::TINYMCE_PROFILES_TABLE;
    $cols = $dict->MetaColumns($tablename);
    $colNames = array();
    if (!empty($cols)) {
        foreach ($cols as $c) {
            $colNames[strtoupper($c->name)] = true;
        }
    }
    if (empty($colNames['FILEMANAGER_IMAGE_RESIZING'])) {
        $sqlarray = $dict->AddColumnSQL($tablename, 'filemanager_image_resizing I');
        $dict->ExecuteSQLArray($sqlarray);
    }
    if (empty($colNames['FILEMANAGER_IMAGE_RESIZING_WIDTH'])) {
        $sqlarray = $dict->AddColumnSQL($tablename, 'filemanager_image_resizing_width I');
        $dict->ExecuteSQLArray($sqlarray);
    }
    if (empty($colNames['FILEMANAGER_IMAGE_RESIZING_HEIGHT'])) {
        $sqlarray = $dict->AddColumnSQL($tablename, 'filemanager_image_resizing_height I');
        $dict->ExecuteSQLArray($sqlarray);
    }
    $salt = $this->GetPreference('filemanager_salt');
    if ($salt === false || $salt === null || $salt === '') {
        $this->SetPreference('filemanager_salt', substr(md5(rand()), 0, 10));
    }
}

// 4.0.1: Ensure RFM access key salt exists (prevents missing access_key for responsive_filemanager)
if (version_compare($oldversion, '4.0.1') < 0) {
    $salt = $this->GetPreference('filemanager_salt', '');
    if ($salt === false || $salt === null || $salt === '') {
        $this->SetPreference('filemanager_salt', substr(md5(rand()), 0, 10));
    }
}

// 4.0.2: Optional CMS FilePicker instead of forced Responsive File Manager (restores Browse in image/link dialogs)
if (version_compare($oldversion, '4.0.2') < 0) {
    $dict = NewDataDictionary($db);
    $tablename = CMS_DB_PREFIX . TinyMCE::TINYMCE_PROFILES_TABLE;
    $cols = $dict->MetaColumns($tablename);
    $colNames = array();
    if (!empty($cols)) {
        foreach ($cols as $c) {
            $colNames[strtoupper($c->name)] = true;
        }
    }
    if (empty($colNames['FILEMANAGER_USE_RESPONSIVE_FM'])) {
        $sqlarray = $dict->AddColumnSQL($tablename, 'filemanager_use_responsive_fm I');
        $dict->ExecuteSQLArray($sqlarray);
        $db->Execute('UPDATE ' . $tablename . ' SET filemanager_use_responsive_fm = 1');
    }
}

// 4.0.3: Normalize all profiles: RFM toggle non-null; enable post-upload resize defaults where file manager is on but max size was never set (0×0)
if (version_compare($oldversion, '4.0.3') < 0) {
    $tablename = CMS_DB_PREFIX . TinyMCE::TINYMCE_PROFILES_TABLE;
    // Column may exist from 4.0.2; ensure no NULLs (e.g. partial import)
    $db->Execute('UPDATE ' . $tablename . ' SET filemanager_use_responsive_fm = 1 WHERE filemanager_use_responsive_fm IS NULL');
    // Where file manager is enabled but both max dimensions are unset, apply standard defaults (does not change custom width/height already set)
    $db->Execute(
        'UPDATE ' . $tablename . ' SET filemanager_image_resizing = 1, filemanager_image_resizing_width = 1280, filemanager_image_resizing_height = 720'
        . ' WHERE filemanager_use > 0 AND filemanager_image_resizing_width < 1 AND filemanager_image_resizing_height < 1'
    );
}

// 4.0.4: Regenerate TinyMCE JS cache and normalize strict-SQL int fields for resize settings
if (version_compare($oldversion, '4.0.4') < 0) {
    $tablename = CMS_DB_PREFIX . TinyMCE::TINYMCE_PROFILES_TABLE;
    $db->Execute(
        'UPDATE ' . $tablename . ' SET '
        . 'filemanager_image_resizing = COALESCE(NULLIF(filemanager_image_resizing, \'\'), 0), '
        . 'filemanager_image_resizing_width = COALESCE(NULLIF(filemanager_image_resizing_width, \'\'), 0), '
        . 'filemanager_image_resizing_height = COALESCE(NULLIF(filemanager_image_resizing_height, \'\'), 0)'
    );
    $utils = cms_join_path($this->GetModulePath(), 'lib', 'class.tinymce_utils.php');
    if (is_file($utils)) {
        require_once $utils;
        tinymce_utils::clear_tinymce_cache();
    }
}

// 4.0.5: Configurable admin submenu (GetAdminSection); default only if preference never set
if (version_compare($oldversion, '4.0.5') < 0) {
    $pref = $this->GetPreference(TinyMCE::PREF_ADMIN_SECTION, null);
    if ($pref === null || $pref === false || $pref === '') {
        $this->SetPreference(TinyMCE::PREF_ADMIN_SECTION, 'extensions');
    }
}

// 4.0.6: Remove bundled Responsive File Manager; FilePicker-only; clean toolbars and obsolete prefs
if (version_compare($oldversion, '4.0.6') < 0) {
    $rfmPath = $this->GetModulePath() . DIRECTORY_SEPARATOR . 'responsive_filemanager';
    if (is_dir($rfmPath)) {
        recursive_delete($rfmPath);
    }
    $tablename = CMS_DB_PREFIX . TinyMCE::TINYMCE_PROFILES_TABLE;
    $db->Execute('UPDATE ' . $tablename . ' SET filemanager_use_responsive_fm = 0');
    $db->Execute(
        'UPDATE ' . $tablename . ' SET toolbar1 = REPLACE(toolbar1, "responsivefilemanager", ""), toolbar2 = REPLACE(toolbar2, "responsivefilemanager", ""), plugins = REPLACE(plugins, "responsivefilemanager", "")'
    );
    $this->removePreference('filemanager_salt');
    $utils = cms_join_path($this->GetModulePath(), 'lib', 'class.tinymce_utils.php');
    if (is_file($utils)) {
        require_once $utils;
        tinymce_utils::clear_tinymce_cache();
    }
}

// 4.0.2: TinyMCE profile post-upload image resize for FilePicker (event handler + session policy by sig); cache refresh
if (version_compare($oldversion, '4.0.2') < 0) {
    $eid = (int)$db->GetOne(
        'SELECT event_id FROM ' . CMS_DB_PREFIX . 'events WHERE originator = ? AND event_name = ?',
        ['FileManager', 'OnFileUploaded']
    );
    if ($eid > 0) {
        $this->AddEventHandler('FileManager', 'OnFileUploaded');
    }
    $utils = cms_join_path($this->GetModulePath(), 'lib', 'class.tinymce_utils.php');
    if (is_file($utils)) {
        require_once $utils;
        tinymce_utils::clear_tinymce_cache();
    }
}

// 4.0.3: Update bundled TinyMCE core to 8.4.0; refresh TinyMCE JS cache and keep FileManager upload handler attached
if (version_compare($oldversion, '4.0.3') < 0) {
    $eid = (int)$db->GetOne(
        'SELECT event_id FROM ' . CMS_DB_PREFIX . 'events WHERE originator = ? AND event_name = ?',
        ['FileManager', 'OnFileUploaded']
    );
    if ($eid > 0) {
        $this->AddEventHandler('FileManager', 'OnFileUploaded');
    }
    $utils = cms_join_path($this->GetModulePath(), 'lib', 'class.tinymce_utils.php');
    if (is_file($utils)) {
        require_once $utils;
        tinymce_utils::clear_tinymce_cache();
    }
}

// 4.0.8: Add CMSMS external plugin flags for image editing and markdown (default off)
if (version_compare($oldversion, '4.0.8') < 0) {
    $dict = NewDataDictionary($db);
    $tablename = CMS_DB_PREFIX . TinyMCE::TINYMCE_PROFILES_TABLE;
    $cols = $dict->MetaColumns($tablename);
    $colNames = array();
    if (!empty($cols)) {
        foreach ($cols as $c) {
            $colNames[strtoupper($c->name)] = true;
        }
    }
    if (empty($colNames['ENABLE_IMAGEEDIT'])) {
        $sqlarray = $dict->AddColumnSQL($tablename, 'enable_imageedit I');
        $dict->ExecuteSQLArray($sqlarray);
        $db->Execute('UPDATE ' . $tablename . ' SET enable_imageedit = 0');
    } else {
        $db->Execute('UPDATE ' . $tablename . ' SET enable_imageedit = COALESCE(NULLIF(enable_imageedit, \'\'), 0)');
    }
    if (empty($colNames['ENABLE_MARKDOWN'])) {
        $sqlarray = $dict->AddColumnSQL($tablename, 'enable_markdown I');
        $dict->ExecuteSQLArray($sqlarray);
        $db->Execute('UPDATE ' . $tablename . ' SET enable_markdown = 0');
    } else {
        $db->Execute('UPDATE ' . $tablename . ' SET enable_markdown = COALESCE(NULLIF(enable_markdown, \'\'), 0)');
    }
    $utils = cms_join_path($this->GetModulePath(), 'lib', 'class.tinymce_utils.php');
    if (is_file($utils)) {
        require_once $utils;
        tinymce_utils::clear_tinymce_cache();
    }
}
