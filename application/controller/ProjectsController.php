<?php
    require_once('BaseController.php');    

    class ProjectsController extends BaseController {
        public function __construct() { 
            parent::__construct();
            $this->beforeFilter();
            $this->loadModel('Projects');
            $this->loadModel('Interactions');
        }

        public function add() {
            $data['user'] = $this->Sessions->getSession();
            $this->loadView('ProjectAdd', $data);
        }

        public function updateChatMessages($chatId) {
            $log = array();
            $timestamp = isset($_GET['timestamp']) ? $_GET['timestamp'] : NULL;
            $messages = array();
            $user = $this->Sessions->getSession();
            $this->Projects->listMessagesByChatId(function($item) use(&$messages) {
                $messages[] = $item;
            }, $chatId, $timestamp);
            $statusInfo = (object) array("chatId" => $chatId, "userId" => $user->id);       
            $this->Projects->manageStatus($statusInfo);
            $log['messages'] = $messages; 
            
            echo json_encode($log);
        }

        public function sendMessage($chatId) {
            $text = $_POST['text'];
            $userId = $_POST['userId'];
            $message = (object) array("text" => $text, "chatId" => $chatId, "userId" => $userId);
            $this->Projects->createMessage($message);
        }

        public function updateOnlineUsers($projectId) {
            $log = array();
            $onlineUsers = array();
            $this->Projects->listOnlineUsersByProjectId(function($item) use(&$onlineUsers) {
                $onlineUsers[] = $item;
            }, $projectId);
            $log['onlineUsers'] = $onlineUsers;

            echo json_encode($log); 
        }

        public function view($id) {
            $onlineUsers = array();
            $project = $this->Projects->getProjectById($id);
            $chat = $this->Projects->getChatByProjectId($id);
            $user = $this->Sessions->getSession();
            $this->Projects->listOnlineUsersByProjectId(function($item) use(&$onlineUsers) {
                $onlineUsers[] = $item;
            }, $id);
             
            $data['project'] = $project;
            $data['chat'] = $chat;
            $data['user'] = $user;
            $data['onlineUsers'] = $onlineUsers;
            $this->loadView('ProjectView', $data);
        }

        public function overview($id) {
            $allowedUsers = array();
            $project = $this->Projects->getProjectById($id);
            $data['project'] = $project;
            $data['user'] = $this->Sessions->getSession();
            $this->Projects->listAllowedUsersByProjectId(function($item) use(&$allowedUsers) {
                $allowedUsers[] = $item;
            }, $id);
            $data['allowedUsers'] = $allowedUsers;
            $this->loadView('ProjectOverview', $data);
        }

        public function edit($id) {
            $project = $this->Projects->getProjectById($id);
            $data['project'] = $project;
            $data['user'] = $this->Sessions->getSession();
            $this->loadView('ProjectEdit', $data);
        }

        public function createInteraction() {
            $users = array(1, 2);
            $id = 1;
            $name = "Test";
            $interactionInfo = (object) array("title" => $name, "description" => $name, "projectId" => $id, 
                "users" => $users);
            $this->Interactions->createInteraction($interactionInfo);
        }
    }
?>
