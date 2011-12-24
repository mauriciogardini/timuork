<?php
    require_once("BaseModel.php");

    class Projects {
        private $database; 
        public function __construct() {
            $this->database = BaseModel::getInstance();
        }

        public function createProject($project) {
            if(!projectExists($project)) {
                $sql = "INSERT INTO projects
                    (id, name, description, admin_user_id) 
                    VALUES(NULL, ?, ?, ?)";
                $values = array($project->name, $project->description, 
                    $project->adminUserId);
                return (bool) $this->database->executeQueryDB($sql, 
                    $values)->rowCount();
            }
            else {
                return false;
            }
        }

        public function updateProject($project) {
            $sql = "UPDATE projects 
                SET name = ?, description = ? 
                WHERE id = ?";
            $values = array($project->name, $project->description, 
                $project->id);
            return (bool) $this->database->executeQueryDB($sql, 
                $values)->rowCount();
        }

        public function existsProject($project) {
            $sql = "SELECT COUNT(*) AS count 
                FROM projects 
                WHERE name = ? 
                AND admin_user_id = ?";
            $values = array($project->name, $project->adminUserId);
            $count = $this->database->fetchDB($this->database->executeQueryDB(
                $sql, $values))->count;
            return $count;
        }

        public function getProjectById($projectId) {
            $sql = "SELECT id, name, description, admin_user_id 
                FROM projects 
                WHERE id = ?";
            $values = array($projectId);
            return $this->database->fetchDB($this->database->executeQueryDB(
                $sql, $values));
        }

        public function getProjectByName($projectName, $userId) {
            $sql = "SELECT id, name, description, admin_user_id 
                FROM projects 
                WHERE name = ? 
                AND admin_user_id = ?";
            $values = array($projectName, $userId);
            return $this->database->fetchDB($database->executeQueryDB($sql, 
                $values));
        }

        public function listProjectsByUserId($fn, $userId) {
            $sql = "SELECT projects.id as id, 
                projects.name as name, 
                projects.description as description, 
                projects.admin_user_id as admin_user_id 
                FROM projects 
                JOIN projects_users ON projects.id = projects_users.project_id 
                WHERE projects_users.user_id = ?";
            $values = array($userId);
            $this->database->iterateDB($this->database->executeQueryDB($sql, 
                $values), $fn);
        }

        public function isProjectAdmin($projectId, $userId) {
            $sql = "SELECT admin_user_id 
                FROM projects 
                WHERE id = ?";
            $values = array($projectId);
            $result = $this->database->fetchDB($this->database->executeQueryDB(
                $sql, $values));
            if ($result->admin_user_id == $userId) { 
                return true; 
            }
            else { 
                return false; 
            } 
        }

        public function existsProjectAllowance($projectId, $userId) {
            $sql = "SELECT COUNT(*) AS count 
                FROM projects_users 
                WHERE project_id = ? 
                AND user_id = ?";
            $values = array($projectId, $userId);
            $count = $this->database->fetchDB($this->database->executeQueryDB(
                $sql, $values))->count;
            return $count;
        }

        public function listAllowedUsersByProjectId($fn, $projectId) {
            $sql = "SELECT users.id as id, 
                users.name as name, 
                users.email as email, 
                users.username as username 
                FROM users 
                JOIN projects_users ON users.id = projects_users.user_id 
                WHERE projects_users.project_id = ?";
            $values = array($projectId);
            $this->database->iterateDB($this->database->executeQueryDB(
                $sql, $values), $fn);
        }

        public function allowUser($projectId, $userId) {
            $sql = "INSERT INTO projects_users
                (id, project_id, user_id) 
                VALUES(NULL, ?, ?)";
            $values = array($projectId, $userId);
            return (bool) $this->database->executeQueryDB($sql, $values)->
                rowCount();
        }

        public function disallowUser($projectId, $userId) {
            $sql = "DELETE FROM projects_users 
                WHERE project_id = ? 
                AND user_id = ?";
            $values = array($projectId, $userId);
            return (bool) $this->database->executeQueryDB($sql, $values)->
                rowCount();
        }

        public function createChat($projectId, $userId) {
            $sql = "INSERT INTO chats
                (id, project_id, user_id) 
                VALUES(NULL, ?, ?)";
            $values = array($projectId, $userId);
            return (bool) $this->database->executeQueryDB($sql, $values)->
                rowCount();
        }

        public function getChatByProjectId($projectId) {
            $sql = "SELECT * 
                FROM chats 
                WHERE project_id = ? 
                AND user_id = -1";
            $values = array($projectId);
            return $this->database->fetchDB($this->database->executeQueryDB(
                $sql, $values));
        }

        public function getChatByProjectIdAndUserId($projectId, $userId) {
            $sql = "SELECT * 
                FROM chats 
                WHERE project_id = ? 
                AND user_id = ?";
            $values = array($projectId, $userId);
            return $this->database->fetchDB($this->database->executeQueryDB(
                $sql, $values));
        }

        public function createMessage($message) {
            $sql = "INSERT INTO messages
                (id, text, date_time, chat_id, user_id) 
                VALUES(NULL, ?, strftime('%s', 'now'), ?, ?)";
            $values = array($message->text, $message->chatId, $message->userId);
            return (bool) $this->database->executeQueryDB($sql, $values)->
                rowCount();
        }

        public function listMessagesByChatId($fn, $chatId, $date_time) {
            if ($date_time == NULL) {
                $sql = "SELECT messages.id as message_id, 
                    messages.text as message_text, 
                    messages.date_time as message_date_time, 
                    messages.chat_id as message_chat_id, 
                    users.id as user_id, 
                    users.name as user_name, 
                    users.username as user_username, 
                    users.email as user_email 
                    FROM users 
                    JOIN messages ON users.id = messages.user_id 
                    WHERE chat_id = ?";
                $values = array($chatId);
            }
            else {
                 $sql = "SELECT messages.id as message_id, 
                    messages.text as message_text, 
                    messages.date_time as message_date_time, 
                    messages.chat_id as message_chat_id, 
                    users.id as user_id, 
                    users.name as user_name, 
                    users.username as user_username, 
                    users.email as user_email 
                    FROM users 
                    JOIN messages ON users.id = messages.user_id 
                    WHERE chat_id = ? 
                    AND date_time > ?";
                $values = array($chatId, $date_time); 
            }    
            $this->database->iterateDB($this->database->executeQueryDB($sql, 
                $values), $fn);
        }

        public function manageStatus($statusInfo) {
            if ($this->existsStatus($statusInfo)) {
                return $this->updateStatus($statusInfo);
            }
            else {
                return $this->createStatus($statusInfo);
            }    
        }

        public function updateStatus($statusInfo) {
            $sql = "UPDATE online_users 
                SET last_seen_at = strftime('%s', 'now') 
                WHERE user_id = ? 
                AND chat_id = ?";
            $values = array($statusInfo->userId, $statusInfo->chatId);
            return (bool) $this->database->executeQueryDB($sql, $values)->
                rowCount();
        }

        public function createStatus($statusInfo) {
            $sql = "INSERT INTO online_users
                (id, chat_id, user_id, last_seen_at) 
                VALUES(NULL, ?, ?, strftime('%s', 'now'))";
            $values = array($statusInfo->chatId, $statusInfo->userId);
            return (bool) $this->database->executeQueryDB($sql, $values)->
                rowCount();    
        }

        public function existsStatus($statusInfo) {
            $sql = "SELECT COUNT(*) AS count 
                FROM online_users 
                WHERE chat_id = ? 
                AND user_id = ?";
            $values = array($statusInfo->chatId, $statusInfo->userId);
            $count = $this->database->fetchDB($this->database->executeQueryDB(
                $sql, $values))->count;
            return $count;
        }

        public function listOnlineUsersWithAdminFieldByProjectId($fn, $projectId) {
            $onlineUsers = array();
            $self = $this;
            $this->listOnlineUsersByProjectId(function($item) use(&$onlineUsers, 
                $projectId, $self) {
                $onlineUser['id'] = $item->id;
                $onlineUser['name'] = $item->name;
                $onlineUser['email'] = $item->email;
                $onlineUser['username'] = $item->username;
                if ($self->isProjectAdmin($projectId, $item->id)) {
                    $onlineUser['admin'] = true;
                }
                else {
                    $onlineUser['admin'] = false;
                } 
                $onlineUsers[] = (object) $onlineUser;
            }, $projectId);
            $this->database->iterateArray($onlineUsers, $fn);
        }

        private function listOnlineUsersByProjectId($fn, $projectId) {
            $sql = "SELECT users.id as id, 
                users.name as name, 
                users.email as email, 
                users.username as username  
                FROM users 
                JOIN online_users ON users.id = online_users.user_id 
                JOIN chats ON online_users.chat_id = chats.id 
                WHERE chats.project_id = ? 
                AND chats.user_id = -1 
                AND (strftime('%s', 'now') - online_users.last_seen_at) < 10";
            $values = array($projectId);
            $this->database->iterateDB($this->database->executeQueryDB($sql, 
                $values), $fn);
        }

        public function createInteraction($interactionInfo) {
            $sql = "INSERT INTO interactions
                (id, title, description, project_id)
                VALUES(NULL, ?, ?, ?)";
            $values = array($interactionInfo->title, 
                $interactionInfo->description, $interactionInfo->projectId);
            $result = (bool) $this->database->executeQueryDB(
                $sql, $values)->rowCount();
            if ($result) {
                $interactionId = $this->database->fetchDB(
                    $this->database->executeQueryDB(
                    "SELECT last_insert_rowid() AS id", array()))->id;
                $sql = "INSERT INTO interactions_users
                        (id, interaction_id, user_id) 
                        VALUES(NULL, ?, ?)";
                if ($users == NULL) {
                    $this->listAllowedUsersByProjectId(function($item) 
                        use($interactionId) {
                        $values = array($interactionId, $item->id);
                        if (!(bool) $this->database->executeQueryDB(
                            $sql, $values)->rowCount()) {
                            return false;
                        }
                    }, $interactionInfo->projectId);                     
                }
                else {
                    foreach($interactionInfo->users as $userId) {
                        $values = array($interactionId, $userId);
                        if (!(bool) $this->database->executeQueryDB(
                            $sql, $values)->rowCount()) {
                            return false;
                        }
                    }
                }
            }
            else {
                return false;
            }
        }
    }
?>
