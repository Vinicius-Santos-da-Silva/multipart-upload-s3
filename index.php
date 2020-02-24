<?php
session_start();
error_reporting(E_ALL);
ini_set("display_errors", "on");
// require 'vendor/autoload.php';
require 'config.php';

// define('BASE_URL', 'http://localhost/app');
// define('BASE', 'http://localhost/app/');



spl_autoload_register(function ($class){
    if(strpos($class, 'Controller') > -1) {
        if(file_exists('controllers/'.$class.'.php')) {
                require_once 'controllers/'.$class.'.php';
        }
    } elseif(file_exists('models/'.$class.'.php')) {

            require_once 'models/'.$class.'.php';
    } elseif(file_exists('core/'.$class.'.php')) {

            require_once 'core/'.$class.'.php';
    }else{
                        //print_r('else');echo PHP_EOL;

    }
});

$core = new Core();
$core->run();
?>
