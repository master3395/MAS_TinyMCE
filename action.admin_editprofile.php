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

// Fix a security warning in Chrome
// see https://stackoverflow.com/questions/43249998/chrome-err-blocked-by-xss-auditor-details
header('X-XSS-Protection:0');

if (!isset($params['id_profile']))
{
	$mode = 'add';
	$profile = new tinymce_profile();
}
else
{
	$mode = 'edit';
	$profile = new tinymce_profile((int)$params['id_profile']);
}

// SUBMIT / SAVE
if (isset($params['cancel']))
	$this->Redirect($id,'defaultadmin',$returnid);
if (isset($params['submit']) || isset($params['apply']))
{
	$profile->load_profile_from_array($params);

	if ($profile->save())
	{
		// Clear JS cache so we can re-generate it after saving
		tinymce_utils::clear_tinymce_cache();

		// Save the HTML content
		$this->SetPreference('playground_content', $params['playground_content']);

		$saved_msg = $this->Lang('profile_saved');

		if (isset($params['apply']))
		{
			$mode = 'edit';
			$this->ShowMessage($saved_msg);
		}
		else // submit and go to default admin
		{
			$this->Redirect($id,'defaultadmin',$returnid,array("module_message"=>$saved_msg));
		}
	}
	else {
		echo cmsms()->getDb()->errorMsg();
		exit;
		$this->ShowMessage($this->Lang('error_saving_profile'));
	}
}

// Load the JS and re-generate the cache file
echo $this->WYSIWYGGenerateHeader(null, null, $profile, true);


// FILEPICKER PROFILES
$assign['filepicker_profiles'] = tinymce_utils::get_filepicker_profiles();


// ADDITIONAL DATA

// External capable modules
$assign['external_modules'] = tinymce_utils::get_wysiwygitems_modules();

// Users groups
$user_groups = tinymce_utils::get_user_groups();
$user_groups_smarty = array();
foreach ($user_groups as $group)
	$user_groups_smarty[$group->id] = $group->name;

// Add frontend
$user_groups_smarty[-1] = '- '.$this->Lang('group_frontend').' -';

// DesignManger Template linked to that profile
$templates = tinymce_utils::load_templates_by_type('js');

// Link a design for CSS
$designs = CmsLayoutCollection::get_all();



// ASSIGN FOR SMARTY
$assign['mode'] = $mode;
$assign['profile'] = $profile;

$assign['playground_content'] = $this->GetPreference('playground_content', '');

$assign['usergroups'] = $user_groups_smarty;

$assign['templates'] = $templates;
$assign['designs'] = $designs;

if (version_compare(CMS_VERSION, '2.2.99') > 0) {
	$assign['cmsms_version_23'] = true;
}

$userid = get_userid();
$default_cms_language = cms_userprefs::get_for_user($userid, 'default_cms_language');


// DISPLAY
cmsms()->GetSmarty()->assign($assign);
echo $this->ProcessTemplate('admin_editprofile.tpl');


