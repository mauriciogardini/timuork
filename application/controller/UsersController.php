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

        public function edit() {
            header('Content-type: application/json');
            $attributes = array('id', 'name', 'username', 'accountValue',
                'accountId', 'accountType', 'newPassword', 'oldPassword');
            $userEditInfo = (object) array_intersect_key($_POST, array_flip($attributes));  
            $log = array();  
            if ($this->Users->isValidUserEdit($userEditInfo)) {
                $this->Users->editUserAndDependencies($userEditInfo);
            }
            else {
                $errors = $this->Users->getUserEditValidationErrors($userEditInfo);
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
            $excludeList = isset($_GET['excludeList']) ? $_GET['excludeList'] : NULL;
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
                $sessionUser->setEmail($this->authenticatedUser->email);
                $sessionUser->setAccountId($this->authenticatedUser->account_id);
                $sessionUser->setAccountValue($this->authenticatedUser->account_value);
                $sessionUser->setAccountType($this->authenticatedUser->account_type); 
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
