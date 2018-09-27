<?php

namespace application\core;

class View
{

    public $route;
    public $path;
    public $layout = 'default';

    public function __construct($route) {
        $this->route = $route;
        $this->path = $route['controller'].'/'.$route['action'];
    }

    public function render($title, $vars=[]) {
        extract($vars);
        $path = 'application/views/'.$this->path.'.php';
        if ($path) {

            ob_start();
            require $path;
            $content = ob_get_clean();
            
            require 'application/views/'.$this->layout.'.php';
        }
    }

    public function render_message($vars=[]) {
        extract($vars);
        $path = 'application/views/message.php';
        if ($path) {
            ob_start();
            require $path;
            $message = ob_get_clean();
            return $message;
        }


    }


    public function redirect($url) {
        header('location: /'.$url);
        exit;
    }

    public function location($url) {
        exit(json_encode([
            'url' => $url,
        ]));
    }

    public function message($status, $message) {
        exit(json_encode([
            'status' => $status,
            'message' => $message,
        ]));
    }
}