<?php

define('ROOT', dirname(__DIR__) );
define('APP', ROOT . '/controllers');

function dd($arr)
{
    echo '<pre><p style="font-family:Georgia, \'Times New Roman\', Times, serif;">' . print_r($arr, true) . '</p></pre>';
}

require_once '../Router.php';
$query = rtrim($_SERVER['QUERY_STRING'], '/');



spl_autoload_register('autoloader');
function autoloader($className)
{
    $path = APP . "/$className.php";
    if (is_file($path)) {
        require_once($path);
    }
}


Router::add('^$', ['controller' => 'Main', 'action' => 'index']);
Router::add('^(?P<controller>[a-z-]+)/?(?P<action>[a-z-]+)?$');


Router::dispatch($query);
