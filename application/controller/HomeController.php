<?php
    require_once("BaseController.php");

    class HomeController extends BaseController {
        public function index() {
            if($this->authenticated()) {
                $data['username'] = $this->getSession();
                $this->loadView('Dashboard', $data);
            }
            else {
                $this->loadView('Home', NULL);
            }    
        }
    }
