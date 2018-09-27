<?php 

require_once 'application/lib/Dev.php';


use application\core\Router;

spl_autoload_register(function($class) {
    $path = str_replace('\\','/', $class.'.php');
    if (file_exists($path)) {
        require $path;
    }
});
session_start();

date_default_timezone_set('Etc/GMT-7');

$router = new Router;
$router->run();
