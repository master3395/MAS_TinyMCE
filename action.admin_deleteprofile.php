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
if(!$this->VisibleToAdminUser() ) {
    return;
}


if (!isset($params['id_profile'])) {
    exit;
}

$profile = new tinymce_profile((int)$params['id_profile']);
$default_profile = $this->GetPreference('id_default_profile');


if ($profile->id_profile != $default_profile) {
	if ($profile->delete_from_db()) {
        $this->setMessage($this->Lang('profile_deleted'));
        $this->Redirect($id,'defaultadmin',$returnid);
    } else {
        $this->setError($this->Lang('error_delete_profile'));
		$this->Redirect($id,'defaultadmin',$returnid);
    }
} else {
    $this->SetError($this->Lang('error_cannot_delete_default_profile'));
	$this->Redirect($id,'defaultadmin',$returnid);
}