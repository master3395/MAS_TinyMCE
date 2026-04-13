<?php
# TinyMCE. A TinyMCE wrapper for CMS Made Simple
# Copyright (c) 2015 by Mathieu Muths <contact@airelibre.fr>, Morten Poulsen <morten@poulsen.org>, Rolf Tjassens <rolf@cmsmadesimple.org>
#
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

class TinyMCE extends CMSModule
{
	const TINYMCE_PROFILES_TABLE = 'module_tinymce_profiles';
	const TINYMCE_PROFILEGROUP_TABLE = 'module_tinymce_profile_group';
	/** Site admin submenu key (extensions, content, siteadmin, usersgroups, layout, ecommerce). */
	const PREF_ADMIN_SECTION = 'adminsection';

	// Only for development - force clearing cache at every request when true
	const TINYMCE_DEV_MODE = false;
	// const TINYMCE_DEV_MODE = true;

	public function GetName() { return 'TinyMCE'; }
	public function GetFriendlyName() { return $this->Lang('friendlyname'); }
	public function GetVersion(){ return '4.0.8';}
	public function HasAdmin() { return true; }

	public function GetAdminSection()
	{
		return $this->GetPreference(self::PREF_ADMIN_SECTION, 'extensions');
	}
	public function IsPluginModule() { return true; }
	public function LazyLoadFrontend() { return true; }
	public function LazyLoadAdmin() { return true; }
	public function MinimumCMSVersion() { return '2.2.15'; }

	public function GetHelp() { return $this->Lang('help'); }
	public function GetAuthor() { return 'Mathieu Muths (airelibre), Chris Taylor (chrisbt), Morten Poulsen (silmarillion)'; }
	public function GetAuthorEmail() { return 'contact@airelibre.net'; }
	public function GetChangeLog() { return $this->ProcessTemplate('changelog.tpl'); }
	public function GetAdminDescription() { return $this->Lang('admindescription'); }
	public function InstallPostMessage() { return $this->Lang('postinstall');  }

	public function VisibleToAdminUser() 
	{
		return $this->CheckPermission('Manage TinyMCE profiles');
  	}

	public function HasCapability($capability, $params=array()) 
	{
		if ($capability==CmsCoreCapabilities::WYSIWYG_MODULE) {
	  		return true;
		}
		return false;
	}

	public function HandlesEvents()
	{
		return true;
	}


	// DesignManager
  	public static function page_type_lang_callback($str)
	{
		$mod = cms_utils::get_module('TinyMCE');
		if (is_object($mod) ) {
			return $mod->Lang('type_'.$str);
		}
	}

	public static function reset_page_type_defaults(CmsLayoutTemplateType $type)
	{
		if ($type->get_originator() != 'TinyMCE' ) {
			throw new CmsLogicException('Cannot reset contents for this template type');
		}

		$fn = null;
		switch ($type->get_name()) {
			case 'js':
				$fn = 'orig_js_template.tpl';
			  	break;

			case 'tinymcetemplate':
			  	$fn = 'orig_tinymcetemplate_template.tpl';
		  		break;
		}

		$fn = cms_join_path(__DIR__,'templates',$fn);
		if (file_exists($fn)) {
			return @file_get_contents($fn);
		}
  	}

	// Note : $profile is internally used by tinymce to force loading a profile for demo while editing that profile
	// force : add a time info in the tinymce configuration js
	public function WYSIWYGGenerateHeader($selector = null, $cssname = null, $profile = null, $force = false)
  	{
		static $tinymce_first_time = true;
		$header = '';

		if (!isset($profile)) {
		  	$profile = tinymce_utils::get_best_profile();
		}
		// elseif ($profile->id_profile == 0)
		//   $profile->id_profile = 'init';

		// Current user id if connected
		/*if (cmsms()->is_frontend_request())
		  $userid = -1;
		else
		  $userid = get_userid();*/

		// get the latest modification time of this cssname // From MT
		// if fn does not exist or is older than the modification time, save the config.
		if ($cssname ) {
		  	try {
				$css = CmsLayoutStylesheet::load($cssname);
				$css_mtime = $css->get_modified();
		  	} catch( Exception $e ) {
				// couldn't load the stylesheet for some reason.
				$cssname = null;
		  	}
		} else {
		  	$css_mtime = 0;
		}


		$language = self::GetLanguageId(); // From microtiny

		$uniqueuserid=$_SESSION[CMS_USER_KEY];
		//was  session_id() which caused bug #12308
		$filename = 'tinymce_'. md5($profile->id_profile .$uniqueuserid .$language.$selector.$cssname) . '.js';
		$filepath = cms_join_path(PUBLIC_CACHE_LOCATION, $filename);





		// Force to regenerate the JS if one of the stylsheets linked to the selected design has been updated
		if (file_exists($filepath) && ($profile->id_design > 0)) {
		  $query = new CmsLayoutStylesheetQuery(array('design'=>$profile->id_design));

		  if ($query->TotalMatches() > 0) {
			$current_js_mtime = filemtime($filepath);
			$res = $query->GetMatches();
			foreach ($res as $one) {
			  if ($one->get_modified() > $current_js_mtime) {
				$force = true;
			  }
			}
		  }
		}

		// Force to regenerate JS if one of the CSS files has been updated
		if (file_exists($filepath) && (!empty($profile->css_files))) {
			foreach (explode("\n", $profile->css_files) as $cssFilePath) {
				$cssFilePath = cms_join_path(CMS_ROOT_PATH, trim($cssFilePath));
				if (filemtime($cssFilePath) > filemtime($filepath)) {
					$force = true;
					break;
				}
			}
		}


		if (!file_exists($filepath) || (filemtime($filepath) < $css_mtime) || self::TINYMCE_DEV_MODE || $force) {
		  $js_content = $profile->get_js_config($language, $selector, $cssname);
		  $res = file_put_contents($filepath, $js_content);
		  if (!$res ) {
		  	throw new CmsFileSystemException('Problem writing data to '.$filepath);
		  }
		}

		// Get the cache URL
		$config = cmsms()->GetConfig();

		// TINYMCE.MIN.JS - once per request
		if ($tinymce_first_time ) {
		  $tinymce_first_time = false;
		  $tinymceCorePath = cms_join_path($this->GetModulePath(), 'lib', 'js', 'tinymce', 'tinymce.min.js');
		  $tinymceCoreUrl = $this->getModuleURLPath() . '/lib/js/tinymce/tinymce.min.js';
		  if (is_file($tinymceCorePath)) {
		  	$tinymceCoreUrl .= '?v=' . filemtime($tinymceCorePath);
		  }
		  $header .= '<script type="text/javascript" src="' . $tinymceCoreUrl . '"></script>';

		  // Add the filepicker url for later use from the plugin
		  if (tinymce_utils::can_user_use_filemanager($profile)) {
		  	$fp = \cms_utils::get_filepicker_module();
			if ($fp) {
				if ($fp->getName() == 'FilePicker') {
					$filePickerDAO = new \FilePicker\ProfileDAO($fp);
					if ($profile->filemanager_id_profile) {
						$filePickerProfileObj = $filePickerDAO->loadById($profile->filemanager_id_profile);
						$filePickerProfileName = $filePickerProfileObj->name;
					} else {
						$filePickerProfileName = false;
					}

					// note : this method needs a profile name and not a profile ID
					// If the profile doesn't exists, revert back to the default one
					$filePickerProfile = $fp->get_profile_or_default($filePickerProfileName);

					// Calculate profile signature and put it in session
					$profile_sig = \FilePicker\TemporaryProfileStorage::set($filePickerProfile);

					$resize_helper = cms_join_path(__DIR__, 'lib', 'class.tinymce_upload_resize.php');
					if (is_file($resize_helper)) {
						require_once $resize_helper;
						tinymce_upload_resize::remember_for_sig($profile_sig, $profile);
					}

					$filePickerUrl = $fp->create_url('', 'filepicker', false, [
						'sig' => $profile_sig
					]) . '&showtemplate=false';
				} else {
					$filePickerUrl = $fp->get_browser_url();
				}
				$filePickerUrl = str_replace('&amp;', '&', $filePickerUrl) . '&showtemplate=false';
			}
		  	$header .= '
		  		<script>
		  			tinymce_filepicker_url = "' . $filePickerUrl . '";
		  		</script>
		  	';
		  }
		}

		// AND NOW THE JS FILE FOR PROFILE
		$header .= '<script type="text/javascript" src="' . PUBLIC_CACHE_URL .'/' . $filename;
		if ($force) {
		  $header .= '?'.time();
		}
		$header .= '"></script>';

		return $header;
	}




  // From MicroTiny : get current language
  private static function GetLanguageId()
  {
	$mylang = CmsNlsOperations::get_current_language();
	if ($mylang=='') return 'en'; //Lang setting "No default selected"
	$shortlang = substr($mylang,0,2);

	$mod = cms_utils::get_module('TinyMCE');
	$dir = $mod->GetModulePath().'/lib/js/tinymce/langs';
	$langs = array();

	$files = glob($dir.'/*.js');
	if (is_array($files) && count($files) ) {
	  foreach( $files as $one ) {
		$one = basename($one);
		$one = substr($one,0,-3);
		$langs[] = $one;
	  }
	}

	if (in_array($mylang,$langs) ) return $mylang;
	if (in_array($shortlang,$langs) ) return $shortlang;
	return 'en';
  }


}
?>
