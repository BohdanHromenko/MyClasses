<?php


class Router
{

    /**
     * текущий маршрут
     * @var array
     */
    private static $route = [];

    /**
     * таблица маршрутов
     * @var array
     */
    private static $routes = [];

    /**
     * добавляет маршрут в таблицу маршрутов
     *
     * @param string $regexp регулярное выражение маршрута
     * @param array $route маршрут ([controller, action, params])
     */
    public static function add($regexp, $route = [])
    {
        self::$routes[$regexp] = $route;
    }

    /**
     * возврашяет таблицу маршрутов
     *
     * @return array
     */
    protected static function getRoutes()
    {
        return self::$routes;
    }

    /**
     * возврашяет текущий маршрут (controller, action)
     *
     * @return array
     */
    protected static function getRoute()
    {
        return self::$route;
    }

    /**
     * ишет URL в таблице маршрутов
     * @param string $url входяший URL
     * @return boolean
     */
    private static function matchRoute($url)
    {
        foreach (self::$routes as $pattern => $route) {
            if ( preg_match("#$pattern#i", $url, $matches) ){
                foreach ($matches as $k => $v){
                    if (is_string($k)){
                        $route[$k] = $v;
                    }
                }
                if (!isset($route['action'])){
                    $route['action'] = 'index';
                }
                self::$route = $route;
                return true;
            }
        }
        return false;
    }

    /**
     * перенаправляет URL по корректному маршруту
     * @param string $url входящий URL
     * @return void
     */
    public static function dispatch($url)
    {
        if (self::matchRoute($url)){
            $controller = self::$route['controller'] . 'Controller';
            $controller = self::upperCamelCase($controller);
            if (class_exists($controller)){
                $cObj = new $controller;
                $action = self::lowerCamelCase(self::$route['action']) . 'Action';
                if (method_exists($cObj, $action)){
                    $cObj->$action();
                }else{
                    echo "Method <b>$controller::$action</b> not found";
                }
            }else{
                echo "Controller <b>$controller</b> not found";
            }
        }else{
            http_response_code(404);
            include '404.html';
        }
    }

    /**
     * название контроллера с URI, заменяет тере на пробел,
     * название класса в CamelCase,
     * убирает пробелы
     * @param string $name входящее имя контроллера
     * @return string
     */
    private static function upperCamelCase($name)
    {
         return str_replace(' ', '', ucwords(str_replace('-', ' ', $name)));
    }

    /**
     * название action c URI, заменяет тере на пробел,
     * название класса в CamelCase, кроме первой буквы
     * убирает пробелы
     * @param string $name входящее имя action
     * @return string
     */
    private static function lowerCamelCase($name)
    {
         return lcfirst(self::upperCamelCase($name));
    }

}