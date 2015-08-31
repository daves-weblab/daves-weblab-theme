<?php if (!defined('FCPATH')) die('no direct script access allowed!');

/**
 * return the templates HTTP URL
 */
function base_url() {
    return get_template_directory_uri() . '/';
}

/**
 * return the HTTP URL to the assets directory as defined
 * in config['assets_path']
 */
function assets_url() {
    return base_url() . DWL::getInstance()->config->item('assets_path', 'config') . '/';
}

/**
 * get the weblab instance
 */
function &get_instance()
{
    return DWL::getInstance();
}

/**
 * get a line translation using the language files
 *
 * @param $line
 *  the line to fetch
 * @param argument list
 *  used in sprintf (e.g. L('you bought %d apples, %s', $apple_count, 'thank you')
 *
 * @return the translated line
 */
function L($line) {
    $args = null;
    if(func_num_args() > 1) {
        $args = func_get_args();
        unset($args[0]);
    }

    return DWL::getInstance()->lang->line($line, $args);
}

/**
 * print a line translation using the language files
 *
 * @param $line
 *  the line to fetch
 * @param argument list
 *  used in sprintf (e.g. L('you bought %d apples, %s', $apple_count, 'thank you')
 */
function _L($line) {
    $args = null;
    if(func_num_args() > 1) {
        $args = func_get_args();
        unset($args[0]);
        $args = array_merge($args);
    }

    echo DWL::getInstance()->lang->line($line, $args);
}