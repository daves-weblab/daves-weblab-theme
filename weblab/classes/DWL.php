<?php if (!defined('FCPATH')) die('no direct script access allowed!');

class DWL {
    private static $_instance;

    public static function &getInstance() {
        if(self::$_instance === null) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    private $_loaded_system_classes = array();

    public function loadSystemClass($class) {
        $arg = $class;
        $class = ucfirst($class);
        $file = SYSPATH . 'classes' . DS . $class . EXT;

        $class_name = 'DWL_' . $class;

        if(file_exists($file) && !in_array($class_name, $this->_loaded_system_classes)) {
            $this->_loaded_system_classes[] = $class_name;

            include_once($file);

            $this->{$arg} = new $class_name();
        }
    }

    private function __clone() {}

    private function __construct() {}
}