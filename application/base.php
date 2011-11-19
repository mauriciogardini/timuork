<?php
class Application
{
    var $url;
    var $model;

    function __construct($url)
    {
        $this->url = $url;
    }

    function loadController($class)
    {
        $file = "controller/".$this->url['controller'].".php";
   
        if(!file_exists($file)) {
            die();
        }
        require_once($file);

        $controller = new $class();

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

    function loadView($view,$vars="")
    {
        if(is_array($vars) && count($vars) > 0) {
            extract($vars, EXTR_PREFIX_SAME, "wddx");
        }
        Require_once('view/'.$view.'.php');
    }

    function loadModel($model)
    {
        require_once('model/'.$model.'.php');
        $this->$model = new $model;
    }
}
