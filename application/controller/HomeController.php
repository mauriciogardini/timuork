<?php
    require_once("BaseController.php");

    class HomeController extends BaseController {
        public function __construct() {
            parent::__construct();
            $this->loadModel("Projects");
            $this->loadModel("Users");
        }
        
        public function index() {
            if($this->Sessions->checkSession()) {
                $projects = array();
                $user = $this->Sessions->getSession();
                $this->Projects->listProjectsByUserId(function($item) use(
                    &$projects) {
                    $projects[] = $item;
                }, $user->id);
                $data['user'] = $user;
                $data['projects'] = $projects;
                $this->loadView('Dashboard', $data);
            }
            else {
                $this->loadView('Home', NULL);
            }    
        }
    }
