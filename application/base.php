<?php
    require_once(INCLUDES_PATH . "/session_includes.php" );

    class Application
    {
        var $url;
        var $model;
        var $authenticated;

        function __construct($url)
        {
            $this->url = $url;
            $authenticated = $this->checkSession();
        }

        function checkSession() {
            return check_session();
        }

        public function beforeFilter() {
            if($this->requiresAuth() && !$this->authenticated()) {
                $this->redirect('/');
            }
        }

        protected function requiresAuth() {
            return true;
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
            require_once('view/'.$view.'.php');
        }

        function loadModel($model)
        {
            require_once('model/'.$model.'.php');
            $this->$model = new $model;
        }
    }
