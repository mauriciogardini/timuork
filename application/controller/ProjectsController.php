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

        public function view($id) {
            $project = $this->Projects->getProjectById($id);
            $chat = $this->Projects->getChatByProjectId($id);
            $data['project'] = $project;
            $data['chat'] = $chat;
            $data['username'] = $this->Sessions->getSession();
            $this->loadView('ProjectView', $data);
        }

        public function overview($id) {
            $project = $this->Projects->getProjectById($id);
            $data['project'] = $project;
            $data['username'] = $this->Sessions->getSession();
            $this->loadView('ProjectOverview', $data);
        }

        public function edit($id) {
            $project = $this->Projects->getProjectById($id);
            $data['project'] = $project;
            $data['username'] = $this->Sessions->getSession();
            $this->loadView('ProjectEdit', $data);
        }
    }
?>
