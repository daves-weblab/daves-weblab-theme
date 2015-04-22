<?php if (!defined('FCPATH')) die('no direct script access allowed!');

function base_url() {
    return get_template_directory_uri();
}

function assets_url() {

}

function &get_instance() {
    return DWL::getInstance();
}

function L($line) {
    return DWL::getInstance()->language->line($line);
}

function _L($line) {
    echo L($line);
}