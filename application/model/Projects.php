<?php
    require_once(INCLUDES_PATH . "/project_includes.php");
    require_once(INCLUDES_PATH . "/chat_includes.php");

    class Projects extends Application {
        public function __construct() {
            //
        }

        public function select_by_id($id) {
            return project_by_id($id);
        }

        public function chat_by_project_id($id) {
            return chat_by_project_id($id);
        }
    }
?>
