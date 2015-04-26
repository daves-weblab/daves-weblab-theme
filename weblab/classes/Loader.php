<?php if (!defined('FCPATH')) die('no direct script access allowed!');

class DWL_Loader
{
    private $_loaded_config_domains = array();
    private $_loaded_lang_files = array();

    private $_cached_variables = array();

    public function config($domain)
    {
        $file = APPPATH . 'configs' . DS . $domain . EXT;

        if (file_exists($file) && !in_array($domain, $this->_loaded_config_domains)) {
            $this->_loaded_config_domains[] = $domain;
            $config = array();

            include($file);

            $_DWL =& get_instance();
            $_DWL->config->add($domain, $config);
        }

        return false;
    }

    public function variable($key, $value = null)
    {
        if (!is_array($key)) {
            $key = array($key => $value);
        }

        $this->_cached_variables = array_merge($this->_cached_variables, $key);
    }

    public function clear_variables()
    {
        $this->_cached_variables = array();
    }

    public function view($_view, $_variables = null, $_return = false)
    {
        $_view = APPPATH . 'views' . DS . str_replace(array('/', '\\'), DS, $_view) . EXT;

        if (file_exists($_view)) {
            if (is_array($_variables)) {
                $this->_cached_variables = array_merge($this->_cached_variables, $_variables);
            }

            extract($this->_cached_variables);

            if ($_return) ob_start();

            include($_view);

            if ($_return) {
                $buffer = ob_get_contents();
                @ob_end_clean();
                return $buffer;
            }
        }

        return true;
    }

    public function lang($lang)
    {
        $_DWL =& get_instance();

        $file = APPPATH . 'language' . DS . $_DWL->lang->lang() . DS . $lang . '_lang' . EXT;

        if (file_exists($file) && !in_array($lang, $this->_loaded_lang_files)) {
            $this->_loaded_lang_files[] = $lang;
            $lang = array();

            include($file);


            $_DWL->lang->add($lang);
        }

        return false;
    }

    public function helper($helper)
    {
        $helper = 'helpers' . DS . $helper . '_helper' . EXT;

        foreach (array(APPPATH . $helper, SYSPATH . $helper) as $file) {
            if (file_exists($file)) {
                @include_once($file);
                break;
            }
        }
    }

    public function library($library, $prop_name = null, $args = null)
    {
        $lib_name = basename($library);
        $library = 'libraries' . DS . dirname($library) . DS;

        if ($library == '.') $library = '';

        if ($lib_name) {
            $_DWL =& get_instance();

            if (!$prop_name) {
                $prop_name = strtolower($lib_name);
            }

            if (isset($_DWL->{$prop_name})) return false;

            foreach (array(
                         APPPATH . $library . $lib_name . EXT,
                         APPPATH . $library . ucfirst(($lib_name)) . EXT) as $file) {

                if (file_exists($file)) {
                    @include_once($file);

                    $class_name = strtolower($lib_name);

                    if ($args !== null) $class = new $class_name($args);
                    else $class = new $class_name();

                    $this->{$prop_name} = $class;
                }
            }
        }
    }

    public function __get($var)
    {
        return get_instance()->{$var};
    }
}