<?php

session_start(); // always start the session

set_include_path(dirname(__FILE__)); # include path - don't change

include_once 'config.php'; # include the config file

function __autoload($className) {
	require_once 'model/'.$className.'.class.php';
}
