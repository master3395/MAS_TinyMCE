<?php
/**
 * FileManager::OnFileUploaded — resize images after FilePicker upload when a TinyMCE profile requests it.
 *
 * @param string $originator FileManager
 * @param string $eventname OnFileUploaded
 * @param array $params expects keys: file (absolute path), filepicker_sig (optional)
 */

if (!isset($gCms)) {
    return;
}

require_once dirname(__FILE__) . '/lib/class.tinymce_upload_resize.php';

if (!isset($params['file']) || !is_string($params['file']) || $params['file'] === '') {
    return;
}

$sig = '';
if (isset($params['filepicker_sig']) && (is_string($params['filepicker_sig']) || is_numeric($params['filepicker_sig']))) {
    $sig = (string)$params['filepicker_sig'];
}

$policy = tinymce_upload_resize::get_policy_for_sig($sig);
if (!$policy) {
    return;
}

$path = $params['file'];
tinymce_upload_resize::maybe_resize_file($path, $policy);
