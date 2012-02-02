<?php
    require_once("includes/general_includes.php");

    class BaseController {

        public function __construct() {
            $this->loadModel('Sessions');
            $this->loadModel('SessionUser');
        }

        protected function beforeFilter() {
            $sessionUser = $this->SessionUser;
            if($this->requiresAuth() && !($sessionUser->getId())) {
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
            require_once('application/view/'.$view.'.php');
        }

        function loadModel($model)
        {
            require_once('application/model/'.$model.'.php');
            $this->$model = new $model;
        }
    }
