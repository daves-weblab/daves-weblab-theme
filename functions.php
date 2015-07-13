<?php

// time to load the weblab framework

require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'weblab' . DIRECTORY_SEPARATOR . 'weblab.php');

/**
 *
 * small sidenote, classes from the application/classes directory
 * are autoloaded if their name is the same as the Classname
 *
 * new TestClass() tries to load the files
 *      - application/classes/TestClass.php
 *      - application/classes/TestClass.class.php
 *
 */

// global theme logic goes here