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
            if ($sessionUser->getId()) {   
                $projects = array();
                $this->Projects->listProjectsByUserId(function($item) use(
                    &$projects) {
                    $projects[] = $item;
                }, $sessionUser->getId());
                $data['user'] = $sessionUser;
                $data['projects'] = $projects;
                $this->loadView('Dashboard', $data);
            }
            else {
                $this->loadView('Home', NULL);
            }
        }
    }
