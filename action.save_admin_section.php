<?php
#CMS - CMS Made Simple
#(c)2004 by Ted Kulp (ted@cmsmadesimple.org)
#
if (!cmsms()) {
    exit;
}
if (!$this->VisibleToAdminUser()) {
    return;
}

$allowed = array(
    'extensions' => true,
    'content' => true,
    'siteadmin' => true,
    'usersgroups' => true,
    'layout' => true,
    'ecommerce' => true,
);

if (!isset($params['submit_admin_section'])) {
    $this->Redirect($id, 'defaultadmin', $returnid);
}

if (!isset($params['adminsection'])) {
    $this->Redirect($id, 'defaultadmin', $returnid, array('module_message' => $this->Lang('admin_section_invalid')));
}

$val = trim((string)$params['adminsection']);
if (!isset($allowed[$val])) {
    $this->Redirect($id, 'defaultadmin', $returnid, array('module_message' => $this->Lang('admin_section_invalid')));
}

$old = $this->GetPreference(TinyMCE::PREF_ADMIN_SECTION, 'extensions');
$this->SetPreference(TinyMCE::PREF_ADMIN_SECTION, $val);

if ($old !== $val) {
    $gCms = cmsms();
    if ($gCms && method_exists($gCms, 'ClearAdminMenuCache')) {
        $gCms->ClearAdminMenuCache();
    }
    if ($gCms && method_exists($gCms, 'ClearCache')) {
        $gCms->ClearCache();
    }
    $modops = $gCms->GetModuleOperations();
    if ($modops && method_exists($modops, 'ClearCache')) {
        $modops->ClearCache();
    }
}

$this->Redirect($id, 'defaultadmin', $returnid, array('module_message' => $this->Lang('admin_section_saved')));
