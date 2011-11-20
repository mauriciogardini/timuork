<?php
    class User extends Application {
        public function __construct() {
            $this->loadModel('model_user');
        }

        public function manage() {

            $name = $_POST["unregistered_name"];
            $email = $_POST["unregistered_email"];
            $username = $_POST["unregistered_username"];
            $password = $_POST["unregistered_password"];
            $user = (object) array("name" => $name, "email" => $email, "username" => $username, "password" => $password);
            $message = $this->model_user->add($user);
            $data['message'] = $message; 
            $this->loadView('view_user_manage', $data);
        }

        public function login() {
            $username = $_POST["username"];
            $password = $_POST["password"];
            $auth_user = (object) array("username" => $username, "password" => $password);
            $this->authenticated = $this->model_user->authenticate($auth_user);
            if ($this->authenticated) {
                $this->loadView('view_dashboard', NULL);
            }
            else {
                $this->loadView('view_home', NULL);
            }
        }

        protected function requiresAuth() {
            return $this->currentAction != 'login';
        }
    }
