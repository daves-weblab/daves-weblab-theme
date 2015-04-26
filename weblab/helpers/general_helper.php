<?php if (!defined('FCPATH')) die('no direct script access allowed!');

function base_url() {
    return get_template_directory_uri();
}

function assets_url() {
    return base_url() . DWL::getInstance()->config->item('assets_url', 'config') . '/';
}

function &get_instance()
{
    return DWL::getInstance();
}

function L($line) {
    return DWL::getInstance()->lang->line($line);
}

function _L($line) {
    echo L($line);
}