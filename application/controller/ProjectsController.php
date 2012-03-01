<?php
    require_once('BaseController.php');    

    class ProjectsController extends BaseController {
        public function __construct() { 
            parent::__construct();
            $this->beforeFilter();
            $this->loadModel('Projects');
        }

        public function add() {
            header('Content-type: application/json');
            $log = array();
            $title = $_POST['title'];
            $description = $_POST['description'];
            $adminUserId = $_POST['userId'];
            $allowedUsers = isset($_POST['allowedUsers']) ? $_POST['allowedUsers'] : NULL;
            $projectInfo = (object) array('adminUserId' => $adminUserId,
                'title' => $title, 'description' => $description, "id" => NULL,
                'allowedUsersIds' => $allowedUsers);
            if($this->Projects->isValidProject($projectInfo)) {
                $this->Projects->createProjectAndDependencies($projectInfo);
            }
            else {
                $errors = $this->Projects->getProjectValidationErrors($projectInfo);
                $log = array("errors" => $errors);
            }

            echo json_encode($log);
        }

        public function updateMyProjects() {
            header('Content-type: application/json');
            $log = array();
            $projects = array();
            $sessionUser = $this->SessionUser;
            $this->Projects->listMyProjectsByUserId(function($item) use(
                &$projects) {
                $projects[] = $item;
            }, $sessionUser->getId());
            $log['myProjects'] = $projects;

            echo json_encode($log);
        }

        public function updateOtherProjects() {
            header('Content-type: application/json'); 
            $log = array();
            $projects = array();
            $sessionUser = $this->SessionUser;
            $this->Projects->listOtherProjectsByUserId(function($item) use(
                &$projects) {
                $projects[] = $item;
            }, $sessionUser->getId());
            $log['otherProjects'] = $projects;

            echo json_encode($log);
        }

        public function updateNotifications() {
            $log = array();
            $notifications = array();
            $sessionUser = $this->SessionUser;
            $this->Projects->listNotificationsByUserId(function($item) use(
                &$notifications) {
                $notifications[] = $item;
            }, $sessionUser->getId());
            $log['notifications'] = $notifications;

            echo json_encode($log);
        }

        public function updateProjectMessages($projectId) {
            $log = array();
            $timestamp = isset($_GET['timestamp']) ? $_GET['timestamp'] : NULL;
            $messages = array();
            $sessionUser = $this->SessionUser;
            $this->Projects->listMessagesByProjectId(function($item) use(
                &$messages) {
                $messages[] = $item;
            }, $projectId, $timestamp);
            $statusInfo = (object) array("projectId" => $projectId, 
                "userId" => $sessionUser->getId());       
            $this->Projects->manageStatus($statusInfo);
            $log['messages'] = $messages; 
            
            echo json_encode($log);
        }

        public function updateLinks($projectId) {
            $log = array();
            $links = array();
            $this->Projects->listLinksByProjectId(function(
                $item) use(&$links) {
                $links[] = $item;
            }, $projectId);
            $log['links'] = $links;

            echo json_encode($log);
        }
        
        public function sendMessage() {
            $text = $_POST['text'];
            $userId = $_POST['userId'];
            $projectId = $_POST['projectId'];
            $message = (object) array("text" => $text, "projectId" => $projectId, 
                "userId" => $userId);
            $this->Projects->createMessage($message);
        }

        public function updateOnlineUsers($projectId) {
            $log = array();
            $onlineUsers = array();
            $this->Projects->listOnlineUsersWithAdminFieldByProjectId(function(
                $item) use(&$onlineUsers) {
                $onlineUsers[] = $item;
            }, $projectId);
            $log['onlineUsers'] = $onlineUsers;

            echo json_encode($log); 
        }

        public function view($id) {
            $onlineUsers = array();
            $projectUsers = array();
            $sessionUser = $this->SessionUser;
            $project = $this->Projects->getProjectById($id);
            $this->Projects->listOnlineUsersWithAdminFieldByProjectId(function(
                $item) use(&$onlineUsers) {
                $onlineUsers[] = $item;                    
            }, $id);
            $this->Projects->listAllowedUsersByProjectId(function($item) use(
                &$projectUsers) {
                $projectUsers[] = $item;                    
            }, $id);

            $data['project'] = $project;
            $data['user'] = $sessionUser;
            $data['onlineUsers'] = $onlineUsers;
            $data['projectUsers'] = $projectUsers;
            $this->loadView('ProjectView', $data);
        }

        public function overview($id) {
            $allowedUsers = array();
            $sessionUser = $this->SessionUser;
            $project = $this->Projects->getProjectById($id);
            $data['project'] = $project;
            $data['user'] = $sessionUser;
            $this->Projects->listAllowedUsersByProjectId(function($item) use(
                &$allowedUsers) {
                $allowedUsers[] = $item;
            }, $id);
            $data['allowedUsers'] = $allowedUsers;
            $this->loadView('ProjectOverview', $data);
        }

        public function edit() {
            $log = array();
            $projectId = $_POST['projectId'];
            $users = $_POST['users'];
            $title = $_POST['title'];
            $adminUserId = $_POST['adminUserId'];
            $description = $_POST['description'];
            $projectInfo = (object) array("id" => $projectId,
                "title" => $title, "description" => $description,
                "usersIds" => $users, "adminUserId" => $adminUserId);
            if($this->Projects->isValidProject($projectInfo)) {
                $this->Projects->editProject($projectInfo);
            }
            else {
                $errors = $this->Projects->getProjectValidationErrors($projectInfo);
                $log["errors"] = $errors;
            }
            $log["project"] = array("title" => $title, "description" => $description);
            echo json_encode($log);
        }

        public function createNotification() {
            $projectId = $_POST['projectId'];
            $users = explode(',', $_POST['users']);
            $sessionUser = $this->SessionUser;        
            if ((bool)count($users)) {
                if ($users[0] == -1) {
                    $users = NULL;
                }
            }
            $title = $_POST['title'];
            $description = $_POST['description'];
            $notificationInfo = (object) array("title" => $title, 
                "description" => $description, "projectId" => $projectId, 
                "senderUserId" => $sessionUser->getId(),
                "senderUserName" => $sessionUser->getName(), "users" => $users);
            $this->Projects->createNotificationAndDependencies($notificationInfo);
        }

        public function createLink() {
            $log = array();
            $projectId = $_POST['projectId'];
            $caption = $_POST['caption'];
            $url = $_POST['url'];
            $url = $this->Projects->prependScheme($url);
            $linkInfo = (object) array("projectId" => $projectId,
                "caption" => $caption, "url" => $url);
            if ($this->Projects->isValidLink($linkInfo)) {
                $this->Projects->createLink($linkInfo);
            }
            else {
                $errors = $this->Projects->getValidationErrors($linkInfo);
                $log = array("errors" => $errors);
            }

            echo json_encode($log);    
        }
    }
