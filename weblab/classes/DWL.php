<?php if (!defined('FCPATH')) die('no direct script access allowed!');

class DWL
{

    // -------------------- Core --------------------

    // singleton holder
    private static $_instance;

    /**
     * private clone for singleton implementation
     */
    private function __clone()
    {
    }

    /**
     * private construct for singleton implementation
     *
     * registeres the assets action
     */
    private function __construct()
    {
        add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));
    }

    /**
     * get the weblab instance
     *
     * @return DWL
     *  singleton
     */
    public static function &getInstance()
    {
        if (self::$_instance === null) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    // hold the already loaded system classes
    private $_loaded_system_classes = array();

    /**
     * load a system class and attach it to the weblab singleton
     *
     * @param $class
     *  name of the system class
     * @param $prop_name
     *  name of the property the class is attached as
     */
    public function loadSystemClass($class, $prop_name)
    {
        $class = ucfirst($class);
        $file = SYSPATH . 'classes' . DS . $class . EXT;

        $class_name = 'DWL_' . $class;

        if (file_exists($file) && !in_array($class_name, $this->_loaded_system_classes)) {
            $this->_loaded_system_classes[] = $class_name;

            include_once($file);

            $this->{$prop_name} = new $class_name();
        }
    }

    // -------------------- Template Redirect --------------------

    /**
     * redirect to another template file in the theme's root directory
     * (e.g. index, 404, archive, single-xxx, page)
     *
     * @param $template
     *  name of the template file without .php
     */
    public function redirectTemplate($template)
    {
        // allow only files from main directory
        $template = preg_split('/(\/|\\\)/', $template);

        if (count($template) > 0) {
            $file = FCPATH . $template[0] . EXT;

            if (file_exists($file)) {
                include($file);
            }
        }
    }

    // -------------------- Assets --------------------

    // added styles
    private $_enqueued_styles = array();

    // added scripts
    private $_enqueued_scripts = array();

    /**
     * enqueue a style using wordpress's style enqueueing system
     *
     * @param $handle
     * @param bool $src
     * @param array $deps
     * @param bool $ver
     * @param string $media
     */
    public function addStyle($handle, $src = false, $deps = array(), $ver = false, $media = 'all')
    {
        $this->_enqueued_styles[] = array(
            'handle' => $handle,
            'src' => $src,
            'deps' => $deps,
            'ver' => $ver,
            'media' => $media
        );
    }

    /**
     * enqueue a script using wordpress's script enqueueing system
     *
     * @param $handle
     * @param bool $src
     * @param array $deps
     * @param bool $ver
     * @param bool $in_footer
     */
    public function addScript($handle, $src = false, $deps = array(), $ver = false, $in_footer = false)
    {
        $this->_enqueued_scripts[] = array(
            'handle' => $handle,
            'src' => $src,
            'deps' => $deps,
            'ver' => $ver,
            'in_footer' => $in_footer
        );
    }

    /**
     * enqueue a script in the footer section using wordpress's script enqueueing system
     *
     * @param $handle
     * @param bool $src
     * @param array $deps
     * @param bool $ver
     */
    public function addFooterScript($handle, $src = false, $deps = array(), $ver = false)
    {
        $this->_enqueued_scripts[] = array(
            'handle' => $handle,
            'src' => $src,
            'deps' => $deps,
            'ver' => $ver,
            'in_footer' => true
        );
    }

    /**
     * actually enqueue styles and scripts using
     * wp_enqueue_style and wp_enqueue_script in the
     * wp_enqueue_scripts hook
     */
    public function enqueue_scripts()
    {
        if(!empty($this->_enqueued_styles)) {
            foreach ($this->_enqueued_styles as $style) {
                wp_enqueue_style($style['handle'], $style['src'], $style['deps'], $style['ver'], $style['media']);
            }
        }

        if(!empty($this->_enqueued_scripts)) {
            foreach ($this->_enqueued_scripts as $script) {
                wp_enqueue_script($script['handle'], $script['src'], $script['deps'], $script['ver'], $script['in_footer']);
            }
        }
    }

    // -------------------- Global Variables --------------------

    /**
     * add a global variable to the weblab. possibilities:
     *  get variable
     *      instance->variable('key');
     *
     *  add variables
     *      instance->variable('key', $value);
     *      instance->variable(array('key' => $value, 'key2' => $value2));
     *
     * @param $key
     *  key to get or add
     *
     * @param null $value
     *  $value or null to fetch or to add array
     *
     * @return null
     *  return value or null if key does not exist when fetching a variable
     */
    public function globalVariable($key, $value=null) {
        if($value == null && is_string($key)) {
            if(isset($this->_variables[$key])) {
                return $this->_variables[$key];
            }

            return null;
        }

        if($value != null && is_string($key)) {
            $key = array($key => $value);
        }

        $this->_variables = array_merge($this->_variables, $key);
    }

    // -------------------- Head --------------------

    private $_meta = array();

    /**
     * print custom head section
     */
    public function head() {
        $head = '';

        $head .= implode('', $this->_meta);

        echo $head;
    }

    /**
     * add custom meta after wp_head using the weblab's head function
     *
     * @param $meta
     *  complete meta key (e.g. <meta name="" content=""/>)
     */
    public function addMeta($meta) {
        $this->_meta[] = $meta;
    }
}