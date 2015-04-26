<?php if (!defined('FCPATH')) die('no direct script access allowed!');

class DWL_Config
{
    private $_config = array();

    public function item($key, $domain)
    {
        if (
            array_key_exists($domain, $this->_config) &&
            array_key_exists($key, $this->_config[$domain])
        ) {
            return $this->_config[$domain][$key];
        }

        return null;
    }

    public function add($domain, $config)
    {
        if (!is_array($config)) return false;

        $this->_config[$domain] = $config;
    }
}