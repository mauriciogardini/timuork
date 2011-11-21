<?php
    class Application
    {
        var $url;
        var $model;

        public function __construct($url)
        {
            $this->url = $url;
        }

        public function loadController($class)
        {
            $class .= 'Controller';
            $file = 'controller/'. $class . '.php';
    
            if(!file_exists($file)) {
                die();
            }
            require_once($file);

            $controller = new $class($this->url);

            if(method_exists($controller, $this->url['action'])) {
                if (isset($this->url['id'])) {
                    $controller->{$this->url['action']}($this->url['id']);
                }
                else {
                    $controller->{$this->url['action']}();
                }    
            }
            else {
                $controller->index();
            }
        }
    }
