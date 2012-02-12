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

        public function loadView($view,$vars="")
        {
            if(is_array($vars) && count($vars) > 0) {
                extract($vars, EXTR_PREFIX_SAME, "wddx");
            }

            if (($view == "Home")||($view == "ProjectView")) {    
                require_once('application/view/'.$view.'.php');
            }
            else {
                $contentForLayout = $this->renderView('application/view/'.$view.'.php', $vars);
                require_once('application/view/BaseView.php');
            }

        }

        public function renderView($filename, $data = array()) {
            extract($data);
            ob_start();
            require($filename);
            return ob_get_clean();
        }

        public function loadModel($model)
        {
            require_once('application/model/'.$model.'.php');
            $this->$model = new $model;
        }
    }
