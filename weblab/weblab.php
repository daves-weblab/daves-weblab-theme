<?php

define('DS', DIRECTORY_SEPARATOR);
define('EXT', '.php');

define('FCPATH', dirname(dirname(__FILE__)) . DS);
define('APPPATH', FCPATH . 'application' . DS);
define('SYSPATH', FCPATH . 'weblab' . DS);

require_once(SYSPATH . 'classes' . DS . 'DWL' . EXT);

$_DWL =& DWL::getInstance();

$_DWL->loadSystemClass('config', 'config');
$_DWL->loadSystemClass('input', 'input');
$_DWL->loadSystemClass('loader', 'load');
$_DWL->loadSystemClass('language', 'lang');
$_DWL->loadSystemClass('weblab', 'weblab');
$_DWL->loadSystemClass('template', 'tpl');

$_DWL->load->helper('general');
$_DWL->load->config('config');

$_DWL->load->variable('_DWL', $_DWL);

/**
 *
 * automatic class loading from classes
 * directory
 *
 */
function dwl_autoload_custom_classes($class)
{
    $dir = APPPATH . 'classes';
    dwl_autoload_custom_classes_rek(strtolower($class), $dir);
}

function dwl_autoload_custom_classes_rek($class, $dir)
{
    foreach (new DirectoryIterator($dir) as $file) {
        if ($file->isDot()) continue;

        if ($file->isDir()) {
            if (dwl_autoload_custom_classes_rek($class, $file->getPathname())) return TRUE;
        } else if ($file->isFile()) {
            $search = strtolower($file->getFilename());
            if (preg_match('/' . $class . '\.(class)?\.?php/', $search)) {
                include_once($file->getPathname());
                return TRUE;
            }
        }
    }

    return FALSE;
}

spl_autoload_register('dwl_autoload_custom_classes');
