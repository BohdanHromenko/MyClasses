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



















?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>Document</title>
</head>
<body>


<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-2">
        <!--<table class="table table-hover table-dark">
            <thead>
            <tr>
                <th scope="col">id</th>
                <th scope="col">id_user</th>
                <th scope="col">title</th>
                <th scope="col">img</th>
            </tr>
            </thead>
            <tbody>
<          --><?php /*//foreach($posts as $post):*/?>
            <tr>
                <th scope="row"><?/*=$post['id'];*/?></th>
                <td><?/*=$post['id_user'];*/?></td>
                <td><?/*=$post['title'];*/?></td>
                <td><?/*=$post['img'];*/?></td>
<!--                --><?php /*//endforeach;*/?>
            </tr>
            </tbody>
        </table>
        </div>
    </div>
</div>

</body>
</html>