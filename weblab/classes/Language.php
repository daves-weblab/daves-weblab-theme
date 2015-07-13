<?php if (!defined('FCPATH')) die('no direct script access allowed!');

class DWL_Language
{
    private $_lang = array();
    private $_current_lang;

    public function __construct() {
        $this->_current_lang = 'en';//substr(get_locale(), 0, 2);
    }

    public function line($line, $args=null)
    {
        if ($line && array_key_exists($line, $this->_lang)) {
            $line = $this->_lang[$line];
        }

        if($args === null) {
            return $line;
        } else {
            return vsprintf($line, $args);
        }
    }

    public function add($lang)
    {
        $this->_lang = array_merge($this->_lang, $lang);
    }

    public function lang()
    {
        return $this->_current_lang;
    }
}