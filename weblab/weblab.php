<?php

define('DS', DIRECTORY_SEPARATOR);
define('EXT', '.php');

define('FCPATH', direname(dirname(__FILE__)) . DS);
define('APPPATH', FCPATH . 'application' . DS);
define('SYSPATH', FCPATH . 'weblab'. DS);

include(SYSPATH . 'weblab' . EXT);

$weblab =& get_instance();

$weblab->loadSystemClass('config');
$weblab->loadSystemClass('input');
$weblab->loadSystemClass('loader');
$weblab->loadSystemClass('language');

$weblab->load->helper('general');

/**
 *
 * automatic class loading from classes
 * directory
 *
 */
function autoload_custom_classes($class) {
    $dir = APPPATH . 'classes';
    autoload_custom_classes_rek(strtolower($class), $dir);
}

function autoload_custom_classes_rek($class, $dir) {
    foreach(new DirectoryIterator($dir) as $file) {
        if($file->isDot()) continue;

        if($file->isDir()) {
            if(autoload_custom_classes_rek($class, $file->getPathname())) return TRUE;
        } else if($file->isFile()) {
            $search = strtolower($file->getFilename());
            if(preg_match('/' . $class . '\.(class)?\.?php/', $search)) {
                include_once($file->getPathname());
                return TRUE;
            }
        }
    }

    return FALSE;
}

spl_autoload_register('autoload_custom_classes');