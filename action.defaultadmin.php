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
if( !cmsms() ) exit;
if(!$this->VisibleToAdminUser() ) return;

// Get profiles to display the list
$assign['profiles'] = tinymce_utils::get_all_profiles_for_admin_list();
$assign['id_default_profile'] = $this->GetPreference('id_default_profile', 0);

// Show "Sync version" link when DB has a newer version than files (e.g. after deploying 4.0.0-beta4 over 4.0.1-beta2)
$db = cmsms()->GetDb();
$row = $db->GetRow('SELECT version FROM ' . CMS_DB_PREFIX . 'modules WHERE module_name = ?', array('TinyMCE'));
$stored_version = isset($row['version']) ? $row['version'] : '';
$assign['show_sync_version'] = ($stored_version !== '' && version_compare($stored_version, $this->GetVersion()) > 0);

$adminsections = array(
    $this->Lang('adminsub_extensions') => 'extensions',
    $this->Lang('adminsub_content') => 'content',
    $this->Lang('adminsub_siteadmin') => 'siteadmin',
    $this->Lang('adminsub_usersgroups') => 'usersgroups',
    $this->Lang('adminsub_layout') => 'layout',
    $this->Lang('adminsub_ecommerce') => 'ecommerce',
);
$current_admin_section = $this->GetPreference(TinyMCE::PREF_ADMIN_SECTION, 'extensions');
$assign['admin_section_formstart'] = $this->CreateFormStart($id, 'save_admin_section', $returnid);
$assign['admin_section_formend'] = $this->CreateFormEnd();
$assign['admin_section_label'] = $this->Lang('adminsection');
$assign['admin_section_help'] = $this->Lang('adminsectionhelp');
$assign['admin_section_dropdown'] = $this->CreateInputDropdown($id, 'adminsection', $adminsections, -1, $current_admin_section);
$assign['admin_section_submit'] = $this->CreateInputSubmit($id, 'submit_admin_section', $this->Lang('admin_section_save'));

cmsms()->GetSmarty()->assign($assign);

echo $this->ProcessTemplate('defaultadmin.tpl');