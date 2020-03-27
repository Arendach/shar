<?php

function getComponentFiles($type, $component)
{
    $dir = public_path("$type/components/$component/");

    if (!is_dir($dir)) return [];

    $files = scandir($dir);

    $files = cleanFIlesList($type, $files);

    return $files;
}

function cleanFilesList($ext, $array)
{
    $temp = [];

    foreach ($array as $item) {
        if (preg_match("@\.$ext$@", $item))
            $temp[] = $item;
    }

    return $temp;
}

function jsWrite($files, $component)
{
    $temp = '';
    foreach ($files as $file) {
        $temp .= "<script src='" . asset("js/components/$component/$file") . "'></script>" . PHP_EOL;
    }

    return $temp;
}

function cssWrite($files, $component)
{
    $temp = '';
    foreach ($files as $file) {
        $temp .= "<link rel='stylesheet' href='" . asset("css/components/$component/$file") . "'>" . PHP_EOL;
    }

    return $temp;
}

$css_components = '';
$js_components = '';

if (isset($components)) {
    foreach ($components as $component) {
        $js_files = getComponentFiles('js', $component);
        $js_components .= jsWrite($js_files, $component);

        $css_files = getComponentFiles('css', $component);
        $css_components .= cssWrite($css_files, $component);
    }
}


?>
