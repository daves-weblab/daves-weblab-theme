<?php

define('DS', DIRECTORY_SEPARATOR);
define('EXT', '.php');

define('FCPATH', direname(dirname(__FILE__)) . DS);
define('APPPATH', FCPATH . 'application' . DS);
define('SYSPATH', FCPATH . 'weblab'. DS);

include(SYSPATH . 'weblab' . EXT);

$weblab =& get_instance();

$weblab->loadSystemClass('config');
$weblab->loadSystemClass('input');
$weblab->loadSystemClass('loader');
$weblab->loadSystemClass('language');

$weblab->load->helper('general');