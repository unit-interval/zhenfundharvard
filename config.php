<?php

/** PATH */
define('DIR_ROOT', dirname(__FILE__));
//define('DIR_INC', DIR_ROOT . '/inc');

/** cookie session name */
define('SESSNAME', 'MITChiefSESS');

/** make inc files not accessible directly */
$start_including = true;

/** error output */
//error_reporting(E_ALL ^ E_NOTICE | E_STRICT);
//error_reporting(E_ALL ^ E_NOTICE);
error_reporting(0);

/** local settings */
include DIR_ROOT . '/config.local.php';
if(! $local_settings)
	die('setup database first.');

/** simply redirect users to main page if error occurs */
function err($msg) {
    header('Location: /main.php#' . $msg);
    exit;
}

