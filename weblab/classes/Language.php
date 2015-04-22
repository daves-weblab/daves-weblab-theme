<?php if (!defined('FCPATH')) die('no direct script access allowed!');

class DWL_Language {
    private $_lang = array();

    public function line($line) {
        if($line && array_key_exists($line, $this->_lang)) {
            return $this->_lang[$line];
        }

        return $line;
    }

    public function add($lang) {
        $this->_lang = array_merge($this->_lang, $lang);
    }
}