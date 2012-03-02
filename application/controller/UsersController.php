
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
                $sessionUser = $this->SessionUser;
                $sessionUser->setAttribute("flash", array("welcome" => "Seja bem-vindo ao Timuork!"));
            }
            else {
                $errors = $this->Users->getUserValidationErrors($userInfo);
                $log = array("errors" => $errors);
            }

            echo json_encode($log);    
        }

        public function edit() {
            header('Content-type: application/json');
            $attributes = array('id', 'name', 'email', 'username', 'accountValue',
                'accountId', 'accountType', 'newPassword', 'oldPassword');
            $userEditInfo = (object) array_intersect_key($_POST, array_flip($attributes));  
            $log = array();  
            if ($this->Users->isValidUserEdit($userEditInfo)) {
                $this->Users->editUserAndDependencies($userEditInfo);
                $sessionUser = $this->SessionUser;
                $properties = array("id" => $userEditInfo->id,
                    "name" => $userEditInfo->name, 
                    "username" => $userEditInfo->username,
                    "email" => $userEditInfo->email,
                    "accountId" => $userEditInfo->accountId,
                    "accountValue" => $userEditInfo->accountValue,
                    "accountType" => $userEditInfo->accountType);
                $sessionUser->set($properties);
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

        public function refreshProjectUsers() {
            header('Content-type: application/json');
            $searchString = $_GET['searchString'];
            $excludeList = isset($_GET['excludeList']) ? $_GET['excludeList'] : NULL;
            $projectId = $_GET['projectId'];
            $users = array();
            $this->Users->listUsersByProjectIdExcludingListed(function($item) use(
                &$users) {
                $users[] = $item;
                }, $projectId, $searchString, $excludeList);
            $log['users'] = $users;
            echo json_encode($log);
        }

        public function login() {
            $username = $_POST["loginUsername"];
            $password = $_POST["loginPassword"];
            $authenticationUser = (object) array("username" => $username, 
                "password" => $password);
            $this->authenticatedUser = $this->Users->authenticateUser(
                $authenticationUser);
            if ($this->authenticatedUser != NULL) {
                $sessionUser = $this->SessionUser;
                $properties = array("id" => $this->authenticatedUser->id,
                    "name" => $this->authenticatedUser->name, 
                    "username" => $this->authenticatedUser->username,
                    "email" => $this->authenticatedUser->email,
                    "accountId" => $this->authenticatedUser->account_id,
                    "accountValue" => $this->authenticatedUser->account_value,
                    "accountType" => $this->authenticatedUser->account_type);
                $sessionUser->set($properties);
                header('Location: /');
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
