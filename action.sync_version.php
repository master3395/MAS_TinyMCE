<?php
#CMS - CMS Made Simple
#One-time sync: set stored module version to match current files (fixes "Database Version Newer")
#
if (!cmsms()) exit;
if (!$this->VisibleToAdminUser()) return;

$db = cmsms()->GetDb();
$current_version = $this->GetVersion();
$query = 'SELECT version FROM ' . CMS_DB_PREFIX . 'modules WHERE module_name = ?';
$row = $db->GetRow($query, array('TinyMCE'));
$stored = isset($row['version']) ? $row['version'] : '';

if ($stored !== $current_version) {
	$upd = 'UPDATE ' . CMS_DB_PREFIX . 'modules SET version = ? WHERE module_name = ?';
	$db->Execute($upd, array($current_version, 'TinyMCE'));
	// Ensure CMSMS module manager picks up the DB version update immediately.
	\CMSMS\internal\global_cache::clear('modules');
	cmsms()->clear_cached_files();
	$this->Redirect($id, 'defaultadmin', $returnid, array('sync_version' => '1'));
} else {
	$this->Redirect($id, 'defaultadmin', $returnid);
}
