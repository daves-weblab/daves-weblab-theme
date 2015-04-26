<?php if (!defined('FCPATH')) die('no direct script access allowed!');

class DWL_Language
{
    private $_lang = array();
    private $_current_lang;

    public function __construct() {
        $this->_current_lang = substr(get_locale(), 0, 2);
    }

    public function line($line)
    {
        if ($line && array_key_exists($line, $this->_lang)) {
            return $this->_lang[$line];
        }

        return $line;
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