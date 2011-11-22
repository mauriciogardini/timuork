<?php
    require_once(INCLUDES_PATH . "/database_includes.php");

    class Projects {
        public function __construct() {
            //
        }

        public function createProject($project) {
            if(!projectExists($project)) {
                $sql = "INSERT INTO projects(id, name, description, admin_user_id) VALUES(NULL, ?, ?, ?)";
                $values = array($project->name, $project->description, $project->admin_user_id);
                return (bool) database_query($sql, $values)->rowCount();
            }
            else {
                return false;
            }
        }

        public function updateProject($project) {
            $sql = "UPDATE projects SET name = ?, description = ? WHERE id = ?";
            $values = array($project->name, $project->description, $project->id);
            return (bool) database_query($sql, $values)->rowCount();
        }

        public function existsProject($project) {
            $sql = "SELECT COUNT(*) AS count FROM projects WHERE name = ? AND admin_user_id = ?";
            $values = array($project->name, $project->admin_user_id);
            $count = database_fetch(database_query($sql, $values))->count;
            return $count;
        }

        public function getProjectById($project_id) {
            $sql = "SELECT * FROM projects WHERE id = ?";
            $values = array($project_id);
            return database_fetch(database_query($sql, $values));
        }

        public function getProjectByName($project_name, $user_id) {
            $sql = "SELECT * FROM projects WHERE name = ? AND admin_user_id = ?";
            $values = array($project_name, $user_id);
            return database_fetch(database_query($sql, $values));
        }

        public function listProjectsByUserId($fn, $user_id) {
            $sql = "SELECT projects.* FROM projects JOIN projects_users ON projects.id = projects_users.project_id WHERE projects_users.user_id = ?";
            $values = array($user_id);
            database_iterate(database_query($sql, $values), $fn);
        }

        public function isProjectAdmin($project_id, $user_id) {
            $sql = "SELECT admin_user_id FROM projects WHERE id = ?";
            $values = array($project_id);
            $result = database_fetch(database_query($sql, $values));
            if ($result->admin_user_id == $user_id) { 
                return true; 
            }
            else { 
                return false; 
            } 
        }

        public function existsProjectAllowance($project_id, $user_id) {
            $sql = "SELECT COUNT(*) AS count FROM projects_users WHERE project_id = ? AND user_id = ?";
            $values = array($project_id, $user_id);
            $count = database_fetch(database_query($sql, $values))->count;
            return $count;
        }

        public function listAllowedUsersByProjectId($fn, $project_id) {
            $sql = "SELECT users.* FROM users JOIN projects_users ON users.id = projects_users.user_id WHERE projects_users.project_id = ?";
            $values = array($project_id);
            database_iterate(database_query($sql, $values), $fn);
        }

        public function allowUser($project_id, $user_id) {
            $sql = "INSERT INTO projects_users(id, project_id, user_id) VALUES(NULL, ?, ?)";
            $values = array($project_id, $user_id);
            return (bool) database_query($sql, $values)->rowCount();
        }

        public function disallowUser($project_id, $user_id) {
            $sql = "REMOVE FROM projects_users WHERE project_id = ? AND user_id = ?";
            $values = array($project_id, $user_id);
            return (bool) database_query($sql, $values)->rowCount();
        }

        public function createChat($project_id, $user_id) {
            $sql = "INSERT INTO chats(id, project_id, user_id) VALUES(NULL, ?, ?)";
            $values = array($project_id, $user_id);
            return (bool) database_query($sql, $values)->rowCount();
        }

        public function getChatByProjectId($project_id) {
            $sql = "SELECT * FROM chats WHERE project_id = ? AND user_id = -1";
            $values = array($project_id);
            return database_fetch(database_query($sql, $values));
        }

        public function getChatByProjectIdAndUserId($project_id, $user_id) {
            $sql = "SELECT * FROM chats WHERE project_id = ? AND user_id = ?";
            $values = array($project_id, $user_id);
            return database_fetch(database_query($sql, $values));
        }
    }
?>
