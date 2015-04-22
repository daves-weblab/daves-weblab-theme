<?php if (!defined('FCPATH')) die('no direct script access allowed!');

class DWL_Loader {
    private $_loaded_config_domains = array();
    private $_cached_variables = array();

    public function config($domain) {
        $file = APPPATH . 'configs' . DS . $domain;

        if(file_exists($file) && !in_array($domain, $this->_loaded_config_domains)) {
            $this->_loaded_config_domains[] = $domain;
            $config = array();

            include($file);

            $_DWL =& get_instance();
            $_DWL->config->add($domain, $config);
        }

        return false;
    }

    public function view($_view, $_variables, $_return) {
        $_view = APPPATH . 'views' . DS . str_replace(array('/', '\\'), DS, $_view) . EXT;

        if(file_exists($_view)) {
            if(is_array($_variables)) {
                $this->cached_variables = array_merge($this->cached_variables, $_variables);
            }

            extract($this->cached_variables);

            if($_return) ob_start();

            include($_view);

            if($_return) {
                $buffer = ob_get_contents();
                @ob_end_clean();
                return $buffer;
            }
        }

        return true;
    }

    public function lang($file) {

    }

    public function helper($helper) {
        $helper = 'helpers' . DS . $helper . '_helper' . EXT;

        foreach(array(APPPATH . $helper, SYSPATH . $helper) as $file) {
            if(file_exists($file)) {
                @include_once($file);
            }
        }
    }

    public function library($library, $prop_name, $args) {

    }
}