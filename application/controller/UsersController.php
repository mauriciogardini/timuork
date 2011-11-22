<?php
    require_once('BaseController.php');

    class UsersController extends BaseController {
    
        public function __construct($url) {
            $this->url = $url;
            $this->loadModel('Users'); 
            $this->loadModel('Sessions');
        }

        public function add() {
            $name = $_POST["unregistered_name"];
            $email = $_POST["unregistered_email"];
            $username = $_POST["unregistered_username"];
            $password = $_POST["unregistered_password"];
            $user = (object) array("name" => $name, "email" => $email, "username" => $username, "password" => $password);
            $message = $this->Users->addUser($user);
            $data['message'] = $message; 
            $this->loadView('UserAdd', $data);
        }

        public function login() {
            $username = $_POST["username"];
            $password = $_POST["password"];
            $auth_user = (object) array("username" => $username, "password" => $password);
            $this->authenticated = $this->Users->authenticateUser($auth_user);
            if ($this->authenticated) {
                $this->Sessions->startSession($username);
                $data['username'] = $this->Sessions->getSession();   
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
