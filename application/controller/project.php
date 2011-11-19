<?php 
    class Project extends Application {
        function __construct() {
            $this->loadModel('model_project');
        }

        function index() {
        }

        function add() {
            $this->loadView('view_project_add', NULL);
        }

        function view($id) {
            $project = $this->model_project->select_by_id($id);
            $chat = $this->model_project->chat_by_project_id($id);
            $data['project'] = $project;
            $data['chat'] = $chat;
            $this->loadView('view_project_view', $data);
        }

        function overview($id) {
            $project = $this->model_project->select_by_id($id);
            $data['project'] = $project;
            $this->loadView('view_project_overview', $data);
        }

        function edit($id) {
            $project = $this->model_project->select_by_id($id);
            $data['project'] = $project;
            $this->loadView('view_project_edit', $data);
        }
    }
?>
