<?php if (!defined('FCPATH')) die('no direct script access allowed!');

class DWL_Input
{
    private $_post;
    private $_get;

    public function __construct() {
        $this->_post = $_POST;
        $this->_get = $_GET;
    }

    public function get($key, $default=null) {
        if(array_key_exists($key, $this->_get)) return $this->_get[$key];

        return $default;
    }

    public function post($key, $default=null) {
        if(array_key_exists($key, $this->_post)) return $this->_post[$key];

        return $default;
    }

    public function get_post($key, $default=null) {
        if(($input = $this->get($key, $default)) == $default) {
            $input = $this->post($key, $default);
        }

        return $input;
    }

    public function post_get($key, $default=null) {
        if(($input = $this->post($key, $default)) == $default) {
            $input = $this->get($key, $default);
        }

        return $input;
    }
}