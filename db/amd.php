<?php
defined('MOODLE_INTERNAL') || die();
$builds = [];
$js_files = glob('amd/build/*.min.js');
foreach ($js_files as $file) {
    $module_name = pathinfo($file, PATHINFO_FILENAME);
    $builds[$module_name] = ['jsfiles' => [$file]];
}