<?php if (!defined('FCPATH')) die('no direct script access allowed!');

function base_url() {
    return get_template_directory_uri() . '/';
}

function assets_url() {
    return base_url() . DWL::getInstance()->config->item('assets_path', 'config') . '/';
}

function &get_instance()
{
    return DWL::getInstance();
}

function L($line) {
    $args = null;
    if(func_num_args() > 1) {
        $args = func_get_args();
        unset($args[0]);
    }

    return DWL::getInstance()->lang->line($line, $args);
}

function _L($line) {
    $args = null;
    if(func_num_args() > 1) {
        $args = func_get_args();
        unset($args[0]);
        $args = array_merge($args);
    }

    echo DWL::getInstance()->lang->line($line, $args);
}