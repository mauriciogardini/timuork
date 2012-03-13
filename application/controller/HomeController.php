<?php
    require_once("BaseController.php");


    class HomeController extends BaseController {
        public function __construct() {
            parent::__construct();
            $this->loadModel("Projects");
            $this->loadModel("Users");
        }
        
        public function index() {
            $sessionUser = $this->SessionUser;
            $flash = $sessionUser->getAttribute("flash");
            if($flash) {
                if(array_key_exists("welcome", $flash)) { 
                    $data["welcome"] = $flash["welcome"];
                    $sessionUser->setAttribute("flash", NULL);
                } 
            }      
            if ($sessionUser->getId()) {   
                $data['user'] = $sessionUser;
                $this->loadView('Dashboard', $data);
            }
            else {
                $this->loadView('Home', NULL);
            }
        }
    }
