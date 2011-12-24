<?php
    require_once('BaseController.php');

    class UsersController extends BaseController {
    
        public function __construct() {
            parent::__construct();
            $this->loadModel('Projects'); 
            $this->loadModel('Users');
        }

        public function add() {
            $name = $_POST["unregisteredName"];
            $email = $_POST["unregisteredEmail"];
            $username = $_POST["unregisteredUsername"];
            $password = $_POST["unregisteredPassword"];
            $user = (object) array("name" => $name, "email" => $email, 
                "username" => $username, "password" => $password);
            $message = $this->Users->addUser($user);
            $data['message'] = $message; 
            $this->loadView('UserAdd', $data);
        }

        public function login() {
            $username = $_POST["username"];
            $password = $_POST["password"];
            $auth_user = (object) array("username" => $username, 
                "password" => $password);
            $this->authenticatedUser = $this->Users->authenticateUser(
                $auth_user);
            if ($this->authenticatedUser != NULL) {
                $sessionUser = (object) array(
                    "id" => $this->authenticatedUser->id, 
                    "name" => $this->authenticatedUser->name, 
                    "username" => $this->authenticatedUser->username); 
                $this->Sessions->startSession($sessionUser);
                $projects = array();
                $user = $this->Sessions->getSession();
                $this->Projects->listProjectsByUserId(function($item) use(
                    &$projects) {
                    $projects[] = $item;
                }, $sessionUser->id);
                $data['user'] = $sessionUser;
                $data['projects'] = $projects;
                $this->loadView('Dashboard', $data);
            }
            else {
                $this->loadView('Home', NULL);
            }
        }

        public function logout() {
            $this->Sessions->quitSession();
            $this->loadView('Home', NULL);
        }

        protected function requiresAuth() {
            return $this->currentAction != 'login';
        }
    }
