<?php if (!defined('FCPATH')) die('no direct script access allowed!');

class DWL_Weblab
{
    private $_body_class = '';

    public function body_class($class=null) {
        if($class === null) {
            return $this->_body_class ? ' ' . $this->_body_class : $this->_body_class;
        } else {
            $this->_body_class = $class;
        }
    }
}