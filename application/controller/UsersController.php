<?php
    require_once('BaseController.php');

    class UsersController extends BaseController {
    
        public function __construct() {
            parent::__construct();
            $this->loadModel('Projects'); 
            $this->loadModel('Users');
        }

        public function add() {
            $log = array();
            $name = $_POST["name"];
            $email = $_POST["email"];
            $account = $_POST["account"];
            $accountType = $_POST["accountType"];
            $username = $_POST["username"];
            $password = $_POST["password"];
            $userInfo = (object) array("name" => $name, "email" => $email, 
                "account" => $account, "accountType" => $accountType,
                "username" => $username, "password" => $password);
            if ($this->Users->isValidUser($userInfo)) {
                $this->Users->createUserAndDependencies($userInfo);
                //$_SESSION["flash"] = "Teste";
            }
            else {
                $errors = $this->Users->getUserValidationErrors($userInfo);
                $log = array("errors" => $errors);
            }

            echo json_encode($log);    
        }

        public function success() {
            $this->loadView("UserAdd", NULL);
        }

        public function refreshUsers() {
            header('Content-type: application/json');
            $searchString = $_GET['searchString'];
            $excludeList = $_GET['excludeList'];
            $users = array();
            $this->Users->listUsersExcludingListed(function($item) use(
                &$users) {
                $users[] = $item;
            }, $searchString, $excludeList);
            $log['users'] = $users;

            echo json_encode($log);
        }

        public function login() {
            $username = $_POST["username"];
            $password = $_POST["password"];
            $authenticationUser = (object) array("username" => $username, 
                "password" => $password);
            $this->authenticatedUser = $this->Users->authenticateUser(
                $authenticationUser);
            if ($this->authenticatedUser != NULL) {
                $this->Sessions->startSession();
                $sessionUser = $this->SessionUser;
                $sessionUser->setId($this->authenticatedUser->id);
                $sessionUser->setName($this->authenticatedUser->name);
                $sessionUser->setUsername($this->authenticatedUser->username);
                $myProjects = array();
                $otherProjects = array();
                $this->Projects->listMyProjectsByUserId(function($item) use(
                    &$myProjects) {
                    $myProjects[] = $item;
                }, $sessionUser->getId());
                $this->Projects->listOtherProjectsByUserId(function($item) use(
                    &$otherProjects) {
                    $otherProjects[] = $item;
                }, $sessionUser->getId());
                $data['myProjects'] = $myProjects;
                $data['otherProjects'] = $otherProjects;
                $data['user'] = $sessionUser;                
                if (isset($_SESSION["flash"])) {
                    $data['flash'] = $_SESSION["flash"];
                    $_SESSION["flash"] = NULL;
                }
                $this->loadView('Dashboard', $data);
            }
            else {
                $this->loadView('Home', NULL);
            }
        }

        public function logout() {
            $this->Sessions->destroySession();
            $this->loadView('Home', NULL);
        }
 
        protected function requiresAuth() {
            return $this->currentAction != 'login';
        }
    }
