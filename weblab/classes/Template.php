<?php if (!defined('FCPATH')) die('no direct script access allowed!');

class DWL_Template {
    private $_views = array();

    public function &view($view, $data=null) {
        $this->_views[] = (object) array(
            'view' => $view,
            'data' => $data
        );

        return $this;
    }

    public function display() {
        if(count($this->_views) == 0) return;

        $view = $this->_views[0];
        unset($this->_views[0]);

        $this->_views = array_values($this->_views);

        $this->load->view($view->view, $view->data);
    }

    public function __get($var) {
        return get_instance()->{$var};
    }
}
