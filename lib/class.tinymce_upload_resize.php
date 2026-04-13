<?php
/**
 * TinyMCE profile–scoped post-upload image resize for FilePicker uploads.
 * Policy is keyed by the FilePicker temporary profile signature (same as URL ?sig=).
 */

if (!function_exists('cmsms')) {
    exit;
}

final class tinymce_upload_resize
{
    const SESSION_KEY = 'mod_tinymce_fp_resize_v1';
    const SESSION_TTL = 3600;

    /**
     * Store resize policy for the FilePicker profile signature used in tinymce_filepicker_url.
     */
    public static function remember_for_sig($sig, tinymce_profile $profile)
    {
        $sig = self::clean_sig($sig);
        if ($sig === '') {
            return;
        }

        if (!isset($_SESSION) || !is_array($_SESSION)) {
            return;
        }

        self::prune_stale();

        $_SESSION[self::SESSION_KEY][$sig] = [
            'resize' => !empty($profile->filemanager_image_resizing) ? 1 : 0,
            'w' => max(0, (int)$profile->filemanager_image_resizing_width),
            'h' => max(0, (int)$profile->filemanager_image_resizing_height),
            'ts' => time(),
        ];
    }

    /**
     * @return array|null Array with keys resize, w, h or null if not applicable.
     */
    public static function get_policy_for_sig($sig)
    {
        $sig = self::clean_sig($sig);
        if ($sig === '' || empty($_SESSION[self::SESSION_KEY][$sig])) {
            return null;
        }
        $row = $_SESSION[self::SESSION_KEY][$sig];
        if (!is_array($row) || empty($row['resize'])) {
            return null;
        }
        $w = isset($row['w']) ? (int)$row['w'] : 0;
        $h = isset($row['h']) ? (int)$row['h'] : 0;
        if ($w < 1 && $h < 1) {
            return null;
        }
        return ['resize' => 1, 'w' => $w, 'h' => $h];
    }

    /**
     * Resize image in place if policy applies; no-op for non-images or invalid paths.
     *
     * @param array $policy Keys w, h (max dimensions; at least one positive when resize is on).
     * @return bool True if file left in a valid state (resized or unchanged)
     */
    public static function maybe_resize_file($absPath, array $policy)
    {
        $absPath = (string)$absPath;
        if ($absPath === '' || !is_file($absPath) || !is_readable($absPath) || !is_writable($absPath)) {
            return false;
        }

        if (!self::is_path_under_cms_root($absPath)) {
            return false;
        }

        if (!function_exists('imagecreatetruecolor')) {
            return true;
        }

        $info = @getimagesize($absPath);
        if (!$info || empty($info[0]) || empty($info[1]) || empty($info[2])) {
            return true;
        }

        $ow = (int)$info[0];
        $oh = (int)$info[1];
        $type = (int)$info[2];
        if ($ow < 1 || $oh < 1) {
            return true;
        }

        $maxW = max(0, (int)$policy['w']);
        $maxH = max(0, (int)$policy['h']);
        if ($maxW < 1 && $maxH < 1) {
            return true;
        }

        $scaleW = ($maxW > 0) ? ($maxW / $ow) : PHP_INT_MAX;
        $scaleH = ($maxH > 0) ? ($maxH / $oh) : PHP_INT_MAX;
        $scale = min($scaleW, $scaleH);
        if ($scale >= 1.0 - 1.0e-9) {
            return true;
        }

        $nw = max(1, (int)round($ow * $scale));
        $nh = max(1, (int)round($oh * $scale));

        $src = self::imagecreatefromfile($absPath, $type);
        if (!$src) {
            return true;
        }

        $dst = @imagecreatetruecolor($nw, $nh);
        if (!$dst) {
            imagedestroy($src);
            return true;
        }

        if ($type === IMAGETYPE_PNG || $type === IMAGETYPE_GIF) {
            imagealphablending($dst, false);
            imagesavealpha($dst, true);
            $transparent = imagecolorallocatealpha($dst, 0, 0, 0, 127);
            imagefilledrectangle($dst, 0, 0, $nw, $nh, $transparent);
        }

        if (!@imagecopyresampled($dst, $src, 0, 0, 0, 0, $nw, $nh, $ow, $oh)) {
            imagedestroy($src);
            imagedestroy($dst);
            return true;
        }

        $ok = self::save_image($dst, $absPath, $type);
        imagedestroy($src);
        imagedestroy($dst);

        if (!$ok) {
            debug_to_log('TinyMCE upload resize: failed to write ' . basename($absPath));
        }

        return true;
    }

    private static function clean_sig($sig)
    {
        if (!is_string($sig) && !is_numeric($sig)) {
            return '';
        }
        $sig = trim((string)$sig);
        if ($sig === '' || strlen($sig) > 64 || !preg_match('/^[a-f0-9]{32}$/i', $sig)) {
            return '';
        }
        return strtolower($sig);
    }

    private static function prune_stale()
    {
        if (empty($_SESSION[self::SESSION_KEY]) || !is_array($_SESSION[self::SESSION_KEY])) {
            $_SESSION[self::SESSION_KEY] = [];
            return;
        }
        $cut = time() - self::SESSION_TTL;
        foreach ($_SESSION[self::SESSION_KEY] as $k => $row) {
            if (!is_array($row) || empty($row['ts']) || (int)$row['ts'] < $cut) {
                unset($_SESSION[self::SESSION_KEY][$k]);
            }
        }
    }

    private static function is_path_under_cms_root($absPath)
    {
        $rp = @realpath($absPath);
        if ($rp === false) {
            return false;
        }
        $root = @realpath(CMS_ROOT_PATH);
        if ($root === false) {
            return false;
        }
        $len = strlen($root);
        if ($len < 1) {
            return false;
        }
        if (strncmp($rp, $root, $len) !== 0) {
            return false;
        }
        $next = isset($rp[$len]) ? $rp[$len] : '';
        return ($next === '' || $next === DIRECTORY_SEPARATOR);
    }

    /**
     * @return resource|false
     */
    private static function imagecreatefromfile($path, $type)
    {
        switch ($type) {
            case IMAGETYPE_JPEG:
                if (!function_exists('imagecreatefromjpeg')) {
                    return false;
                }
                return @imagecreatefromjpeg($path);
            case IMAGETYPE_PNG:
                if (!function_exists('imagecreatefrompng')) {
                    return false;
                }
                return @imagecreatefrompng($path);
            case IMAGETYPE_GIF:
                if (!function_exists('imagecreatefromgif')) {
                    return false;
                }
                return @imagecreatefromgif($path);
            case IMAGETYPE_WEBP:
                if (!function_exists('imagecreatefromwebp')) {
                    return false;
                }
                return @imagecreatefromwebp($path);
            default:
                return false;
        }
    }

    /**
     * @param resource $im
     */
    private static function save_image($im, $path, $type)
    {
        switch ($type) {
            case IMAGETYPE_JPEG:
                return @imagejpeg($im, $path, 85);
            case IMAGETYPE_PNG:
                return @imagepng($im, $path, 6);
            case IMAGETYPE_GIF:
                return @imagegif($im, $path);
            case IMAGETYPE_WEBP:
                if (!function_exists('imagewebp')) {
                    return false;
                }
                return @imagewebp($im, $path, 85);
            default:
                return false;
        }
    }
}
