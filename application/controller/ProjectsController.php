<?php
    require_once('BaseController.php');    

    class ProjectsController extends BaseController {
        public function __construct() { 
            parent::__construct();
            $this->beforeFilter();
            $this->loadModel('Projects');
        }

        public function add() {
            $this->loadView('ProjectAdd', NULL);
        }

        public function update($id) {
            $log = array();
            $timestamp = isset($_GET['timestamp']) ? $_GET['timestamp'] : NULL;
            $messages = array();
            $this->Projects->listMessagesByChatId(function($item) use(&$messages) {
                $messages[] = $item;
            }, $id, $timestamp);
            $log['messages'] = $messages; 
                            
            echo json_encode($log);
        }

        public function sendMessage($id) {
            $text = $_POST['text'];
            echo $text;
            $timestamp = $_POST['timestamp'];
            $userId = $_POST['user_id'];
            $message = (object) array("text" => $text, "dateTime" => $timestamp, "chatId" => $id, "userId" => $userId);
            $this->Projects->createMessage($message);
        }

        public function view($id) {
            $onlineUsers = array();
            $project = $this->Projects->getProjectById($id);
            $chat = $this->Projects->getChatByProjectId($id);
            $this->Projects->listOnlineUsersByProjectId(function($item) use(&$onlineUsers) {
                /* If there's less than 10 seconds of difference
                * between the record's timestamp and the 
                * present time, show it. */
                if ((idate("U") - $item->last_seen_at) < 10) {
                    $onlineUsers[] = $item;
                }
            }, $id);
                            
            $data['project'] = $project;
            $data['chat'] = $chat;
            $data['user'] = $this->Sessions->getSession();
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
    }
?>
