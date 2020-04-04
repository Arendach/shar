<?php

/**
 * Очищення папки від файлів
 * @param $dir
 */
function dir_clean(string $dir): void
{
    dir_delete($dir);
    mkdir($dir);
}

/**
 * Видалення папки з файлами
 * @param string $dir
 */
function dir_delete(string $dir): void
{
    if (!is_dir($dir)) {
        return;
    }

    if (substr($dir, strlen($dir) - 1, 1) != '/') {
        $dir .= '/';
    }

    $files = glob($dir . '*', GLOB_MARK);

    foreach ($files as $file) {
        is_dir($file) ? dir_delete($file) : unlink($file);
    }

    rmdir($dir);
}

/**
 * @param $name
 */
function create_folder_if_not_exists(string $name): void
{
    if (!is_dir(base_path($name))) {
        mkdir(base_path($name), 0777, true);
    }
}

/**
 * @param $bytes
 * @param int $precision
 * @return string
 */
function my_file_size($bytes, $precision = 2)
{
    $units = array('B', 'KB', 'MB', 'GB', 'TB');
    $bytes = max($bytes, 0);
    $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
    $pow = min($pow, count($units) - 1);
    $bytes /= pow(1024, $pow);
    return round($bytes, $precision) . ' ' . $units[$pow];
}