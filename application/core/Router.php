<?php

namespace application\core;

use application\core\View;

class Router
{
    
    protected $routes = [];
    protected $params = [];

    function __construct() {
        $arr = require 'application/config/routes.php';
        foreach ($arr as $key => $value) {
            $this->add($key, $value);
        }
    }
    /*
        метод для формирования массива, где ключ регулярное выражение пути к странице, 
        а значение массив из контролера и экшена
    */
    public function add($route, $params) {
        $route = preg_replace('/{([a-z]+):([^\}]+)}/', '(?P<\1>\2)', $route);
        $route = '#^'.$route.'$#';
        $this->routes[$route] = $params;   
    }
    /*
        проверка соответсвия запроса uri со значением роута 
    */
    public function match() {
        $url = trim($_SERVER['REQUEST_URI'], '/');
        foreach ($this->routes as $route => $params) {
            if (preg_match($route, $url, $matches)) {
                foreach ($matches as $key => $match) {
                    if (is_string($key)) {
                        if (is_numeric($match)) {
                            $match = (int) $match;
                        }
                        $params[$key] = $match;
                    }
                }
                $this->params = $params;

                return true;
            }
        }
        return false;
    }
    /*
        Если есть сответсвие с функции матч
        запускается соотвествующий экш контроллера
    */
    public function run() {
        if ($this->match()) {
            $path = 'application\controllers\\'.ucfirst($this->params['controller']).'Controller';
            if (class_exists($path)) {
                $action = $this->params['action'].'Action';
                if (method_exists($path, $action)) {
                    $controller = new $path($this->params);
                    $controller->$action();
                } else {
                   // exit('метод не существует');
                    //View::errorCode(404);
                }
            } else {
                    //exit('класс несуществует');
                //View::errorCode(404);
            }
        } else {
                    //exit('нет совпадения');
            //View::errorCode(404);
        }
    }


}