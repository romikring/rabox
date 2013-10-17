<?php
/**
 * @author Roman Habrusionok
 */
// TODO: check include path
//ini_set('include_path', ini_get('include_path'));

defined('TESTS_PATH')
    || define('TESTS_PATH', realpath(dirname(__FILE__)).DIRECTORY_SEPARATOR);

defined('ROOT_PATH')
    || define('ROOT_PATH', realpath(TESTS_PATH.'..').DIRECTORY_SEPARATOR);

defined('PROJECT_PATH')
    || define('PROJECT_PATH', realpath(ROOT_PATH.'..').DIRECTORY_SEPARATOR);

defined('FIXTURES_PATH')
    || define('FIXTURES_PATH', TESTS_PATH.'Fixtures'.DIRECTORY_SEPARATOR);

include_once 'PHPUnit/Autoload.php';

spl_autoload_register(function($class) {
    if (strpos($class, 'PHPUnit') !== false) {
        $class = str_replace('_', '/', $class);
    }
    else {
        $class = PROJECT_PATH.str_replace('\\', '/', $class);
    }

    require_once $class.'.php';
});
