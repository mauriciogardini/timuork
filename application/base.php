<?php
    require_once(INCLUDES_PATH . "/session_includes.php" );
    require_once(INCLUDES_PATH . "/general_includes.php" );

    class Application
    {
        var $url;
        var $model;

        public function __construct($url)
        {
            $this->url = $url;
            $this->beforeFilter();
        }

        protected function authenticated() {
            return check_session();
        }

        protected function beforeFilter() {
            if($this->requiresAuth() && !$this->authenticated()) {
                redirect('/', 0);
            }
        }

        protected function requiresAuth() {
            return true;
        }

        public function loadController($class)
        {
            $file = "controller/".$this->url['controller'].".php";
    
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
