<?php

/** PATH */
define('DIR_ROOT', dirname(__FILE__));
//define('DIR_INC', DIR_ROOT . '/inc');
//define('DIR_MEDIA', DIR_ROOT . '/media');
//define('DIR_VIEW', DIR_INC . '/views');
//define('DIR_CTRL', DIR_INC . '/controllers');

/** cookie session name */
define('SESSNAME', 'bostonsess');

/** make inc files not accessible directly */
$start_including = true;

/** instance dependent values */
define('DB_HOST', 'db01-share');
define('DB_USER', 'Custom App-10575');
define('DB_PASS', 'top-down');
define('DB_NAME', 'pb612-phpfogapp-com');

//define('ADMIN_PW', 'solong');
//define('SALT_PW', 'RubyOnRails');

/** error output */
//error_reporting(E_ALL ^ E_NOTICE | E_STRICT);
//error_reporting(E_ALL ^ E_NOTICE);
error_reporting(0);

/** simply redirect users to main page if error occurs */
function err($msg) {
    header('Location: /main.php' . $msg);
    exit;
}

