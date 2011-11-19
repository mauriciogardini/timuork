<?php
    require_once(INCLUDES_PATH . "/project_includes.php");
    require_once(INCLUDES_PATH . "/chat_includes.php");

    class model_project extends Application {
        function __construct() {
            //
        }

        function select() {
        }

        function select_by_id($id) {
            return project_by_id($id);
        }

        function chat_by_project_id($id) {
            return chat_by_project_id($id);
        }
    }
?>
