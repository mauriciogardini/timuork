<?php
    require_once('BaseController.php');    

    class ProjectsController extends BaseController {
        public function __construct() { 
            parent::__construct();
            $this->beforeFilter();
            $this->loadModel('Projects');
        }

        public function add() {
            $log = array();
            $title = $_POST['title'];
            $description = $_POST['description'];
            $userId = $_POST['userId'];
            $projectInfo = (object) array('userId' => $userId,
                'title' => $title, 'description' => $description);
            if($this->Projects->isValidProject($projectInfo)) {
                $this->Projects->createProject($projectInfo);
            }

            else {
                $errors = $this->Projects->getProjectValidationErrors($projectInfo);
                $log = array("errors" => $errors);
            }

            echo json_encode($log);
        }

        public function updateProjects() {
            $log = array();
            $projects = array();
            $sessionUser = $this->SessionUser;
            $this->Projects->listProjectsByUserId(function($item) use(
                &$projects) {
                $projects[] = $item;
            }, $sessionUser->getId());
            $log['projects'] = $projects;

            echo json_encode($log);
        }

        public function updateChatMessages($chatId) {
            $log = array();
            $timestamp = isset($_GET['timestamp']) ? $_GET['timestamp'] : NULL;
            $messages = array();
            $sessionUser = $this->SessionUser;
            $this->Projects->listMessagesByChatId(function($item) use(
                &$messages) {
                $messages[] = $item;
            }, $chatId, $timestamp);
            $statusInfo = (object) array("chatId" => $chatId, 
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
            $chatId = $_POST['chatId'];
            $message = (object) array("text" => $text, "chatId" => $chatId, 
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
            $chat = $this->Projects->getChatByProjectId($id);
            $this->Projects->listOnlineUsersWithAdminFieldByProjectId(function(
                $item) use(&$onlineUsers) {
                $onlineUsers[] = $item;                    
            }, $id);
            $this->Projects->listAllowedUsersByProjectId(function($item) use(
                &$projectUsers) {
                $projectUsers[] = $item;                    
            }, $id);

            $data['project'] = $project;
            $data['chat'] = $chat;
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

        public function edit($id) {
            $project = $this->Projects->getProjectById($id);
            $data['project'] = $project;
            $data['user'] = $this->SessionUser;
            $this->loadView('ProjectEdit', $data);
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
                "senderUserId" => $sessionUser->getId(), "users" => $users);
            $this->Projects->createNotification($notificationInfo);
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
