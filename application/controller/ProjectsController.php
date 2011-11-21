<?php
    require_once('BaseController.php');    

    class ProjectsController extends BaseController {
        public function __construct() {
            $this->loadModel('Projects');
        }

        public function add() {
            $this->loadView('ProjectAdd', NULL);
        }

        public function view($id) {
            $project = $this->Projects->select_by_id($id);
            $chat = $this->Projects->chat_by_project_id($id);
            $data['project'] = $project;
            $data['chat'] = $chat;
            $data['username'] = $this->getSession();
            $this->loadView('ProjectView', $data);
        }

        public function overview($id) {
            $project = $this->Projects->select_by_id($id);
            $data['project'] = $project;
            $data['username'] = $this->getSession();
            $this->loadView('ProjectOverview', $data);
        }

        public function edit($id) {
            $project = $this->Projects->select_by_id($id);
            $data['project'] = $project;
            $data['username'] = $this->getSession();
            $this->loadView('ProjectEdit', $data);
        }
    }
?>
