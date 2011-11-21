<?php
    require_once(INCLUDES_PATH . "/session_includes.php" );
    require_once(INCLUDES_PATH . "/general_includes.php" );

    class BaseController {

        var $url;

        public function __construct($url) {
            $this->url = $url;
        }

        protected function authenticated() {
            return check_session();
        }

        protected function getSession() {
            return get_session();
        }
        protected function beforeFilter() {
            if($this->requiresAuth() && !$this->authenticated()) {
                redirect('/', 0);
            }
        }

        protected function requiresAuth() {
            return true;
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

