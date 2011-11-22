<?php
    require_once(INCLUDES_PATH . "/session_includes.php" );
    require_once(INCLUDES_PATH . "/general_includes.php" );

    class BaseController {

        public function __construct() {
            $this->loadModel('Sessions');
        }

        protected function beforeFilter() {
            if($this->requiresAuth() && !($this->Sessions->checkSession())) {
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
            require_once(BASE_PATH . '/application/view/'.$view.'.php');
        }

        function loadModel($model)
        {
            require_once(BASE_PATH . '/application/model/'.$model.'.php');
            $this->$model = new $model;
        }

    }

