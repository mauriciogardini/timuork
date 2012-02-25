<?php
    require_once("BaseModel.php");
    require_once("lib/twitterOAuth/twitterOAuth.php");
    require_once("Users.php");

    class Projects {
        private $database; 
        private $users; 
        public function __construct() {
            $this->database = BaseModel::getInstance();
            $this->users = new Users; 
        }
        
        public function createProjectAndDependencies($projectInfo) {
            $self = $this;
            $function = function() use($projectInfo, $self) { 
                $self->createProject($projectInfo); 
            };
            $this->database->executeTransaction($function); 
        }

        public function createProject($projectInfo) {
            $sql = "INSERT INTO projects
                (id, title, description, admin_user_id)
                VALUES(NULL, ?, ?, ?)";
            $values = array($projectInfo->title, $projectInfo->description, 
                $projectInfo->adminUserId);
            $result = (bool) $this->database->executeQueryDB($sql, 
                $values)->rowCount();
            if ($result) {
                $projectId = $this->getLastInsertedId();
                if(isset($projectInfo->allowedUsersIds)) { 
                    foreach($projectInfo->allowedUsersIds as $allowedUserId) {
                        $this->allowUser($projectId, $allowedUserId);
                    }
                }
                $this->allowUser($projectId, $projectInfo->adminUserId);
            }
            else {
                return false;
            }
        }

        public function getLastInsertedId() {
            $sql = "SELECT last_insert_rowid() AS id";
            $result = $this->database->fetchDB($this->database->executeQueryDB(
                $sql));
            return $result->id;
        }

        public function isValidProject($projectInfo) {
            $validationErrors = $this->getProjectValidationErrors($projectInfo);
            foreach($validationErrors as $error) {
                if ($error != NULL) {
                    return false;
                }
            }
            return true;
        }

        public function getProjectValidationErrors($projectInfo) {
            $validationErrors = array("title" => NULL);
            if(!$this->validateProjectTitle($projectInfo->title, $projectInfo->id,
                $projectInfo->adminUserId)) {
                $validationErrors["title"] = "Já existe um projeto com este título.";
            }
            return $validationErrors;
        }

        public function validateProjectTitle($projectTitle, $projectId, $adminUserId) {
            if (isset($projectId)) { 
                $sql = "SELECT COUNT(*) AS count
                    FROM projects
                    WHERE LOWER(title) = LOWER(?)
                    AND admin_user_id = ?
                    AND id != ?";
                $values = array($projectTitle, $adminUserId, $projectId);
            }
            else {
                $sql = "SELECT COUNT(*) AS count
                    FROM projects
                    WHERE LOWER(title) = LOWER(?)
                    AND admin_user_id = ?";
                $values = array($projectTitle, $adminUserId);
            }
            $result = (bool) $this->database->fetchDB($this->database->executeQueryDB(
                $sql, $values))->count;
            return ($result ? false : true); 
        } 

        public function editProject($projectInfo) {
            $allowedUsers = array();
            $removedUsers = array();
            $addedUsers = array();
            $sql = "UPDATE projects
                SET title = ?, description = ?
                WHERE id = ?";
            $values = array($projectInfo->title, $projectInfo->description, 
                $projectInfo->id);
            $result = (bool) $this->database->executeQueryDB($sql, $values)->rowCount();
            if ($result) {
                $this->listAllowedUsersByProjectId(function($item) use(
                    &$allowedUsers) {
                    $allowedUsers[] = $item->id;
                    }, $projectInfo->id);
                var_dump($allowedUsers);
                var_dump($projectInfo->usersIds);
                $removedUsers = array_diff($allowedUsers, $projectInfo->usersIds);
                $addedUsers = array_diff($projectInfo->usersIds, $allowedUsers);
                $this->disallowUsers($projectInfo->id, $removedUsers);
                foreach($addedUsers as $userId) {
                    $this->allowUser($projectInfo->id, $userId);
                }
            }
            else {
                return false;
            }
        }

        public function getProjectById($projectId) {
            $sql = "SELECT id, title, description, admin_user_id
                FROM projects
                WHERE id = ?";
            $values = array($projectId);
            return $this->database->fetchDB($this->database->executeQueryDB(
                $sql, $values));
        }

        public function getProjectByTitle($projectTitle, $userId) {
            $sql = "SELECT id, title, description, admin_user_id
                FROM projects
                WHERE LOWER(title) = LOWER(?)
                AND admin_user_id = ?";
            $values = array($projectTitle, $userId);
            return $this->database->fetchDB($database->executeQueryDB($sql, 
                $values));
        }

        public function listMyProjectsByUserId($fn, $userId) {
            $sql = "SELECT projects.id as id,
                projects.title as title,
                projects.description as description,
                projects.admin_user_id as admin_user_id
                FROM projects
                WHERE projects.admin_user_id = ?";
            $values = array($userId); 
            $this->database->iterateDB($this->database->executeQueryDB($sql, 
                $values), $fn);
        }

        public function listOtherProjectsByUserId($fn, $userId) {
            $sql = "SELECT projects.id as id,
                projects.title as title,
                projects.description as description,
                projects.admin_user_id as admin_user_id
                FROM projects
                JOIN allowances ON projects.id = allowances.project_id
                WHERE allowances.user_id = ?
                AND projects.admin_user_id != ?";
            $values = array($userId, $userId); 
            $this->database->iterateDB($this->database->executeQueryDB($sql, 
                $values), $fn);
        }

        public function isProjectAdmin($projectId, $userId) {
            $sql = "SELECT COUNT(*) AS count
                FROM projects
                WHERE id = ? AND admin_user_id = ?";
            $values = array($projectId, $userId);
            return (bool) $this->database->fetchDB($this->database->executeQueryDB(
                $sql, $values))->count; 
        }

        public function existsProjectAllowance($projectId, $userId) {
            $sql = "SELECT COUNT(*) AS count
                FROM allowances
                WHERE project_id = ?
                AND user_id = ?";
            $values = array($projectId, $userId);
            $count = $this->database->fetchDB($this->database->executeQueryDB(
                $sql, $values))->count;
            return $count;
        }

        public function listAllowedUsersByProjectId($fn, $projectId) {
            $sql = "SELECT users.id AS id,
                users.name AS name,
                users.email AS email,
                users.username AS username,
                notification_accounts.id AS account_id,
                notification_accounts.value AS account_value,
                notification_accounts.type AS account_type
                FROM users
                JOIN notification_accounts ON users.id = notification_accounts.user_id
                JOIN allowances ON users.id = allowances.user_id
                WHERE allowances.project_id = ?
                ORDER BY id";
            $values = array($projectId);
            $this->database->iterateDB($this->database->executeQueryDB(
                $sql, $values), $fn);
        }

        public function allowUser($projectId, $userId) {
            if (isset($projectId)) { 
                $sql = "INSERT INTO allowances
                    (id, project_id, user_id)
                    VALUES(NULL, ?, ?)";
                $values = array($projectId, $userId);
            }
            else {
                $sql = "INSERT INTO allowances
                    (id, project_id, user_id)
                    VALUES(NULL, (SELECT last_insert_rowid() FROM projects), ?)";
                $values = array($userId);
            }    
            return (bool) $this->database->executeQueryDB($sql, $values)->
                rowCount();
        }

        public function disallowUser($projectId, $userId) {
            $sql = "DELETE FROM allowances
                WHERE project_id = ?
                AND user_id = ?";
            $values = array($projectId, $userId);
            return (bool) $this->database->executeQueryDB($sql, $values)->
                rowCount();
        }

        public function disallowUsers($projectId, $usersIds) {
            $sql = sprintf("DELETE FROM allowances
                WHERE project_id = ?
                AND user_id IN (%s)", rtrim(str_repeat('?,', count($usersIds)), ','));
            $values = array_merge((array)($projectId), $usersIds);
            return (bool) $this->database->executeQueryDB($sql, $values)->
                rowCount();
        }

        public function createMessage($message) {
            $sql = "INSERT INTO messages
                (id, text, timestamp, project_id, user_id)
                VALUES(NULL, ?, strftime('%s', 'now'), ?, ?)";
            $values = array($message->text, $message->projectId, $message->userId);
            return (bool) $this->database->executeQueryDB($sql, $values)->
                rowCount();
        }

        public function listMessagesByProjectId($fn, $projectId, $timestamp) {
            if ($timestamp == NULL) {
                $sql = "SELECT messages.id as message_id,
                    messages.text as message_text,
                    messages.timestamp as message_timestamp,
                    messages.project_id as message_project_id,
                    users.id as user_id,
                    users.name as user_name,
                    users.username as user_username,
                    users.email as user_email
                    FROM users
                    JOIN messages ON users.id = messages.user_id
                    WHERE project_id = ?";
                $values = array($projectId);
            }
            else {
                 $sql = "SELECT messages.id as message_id,
                    messages.text as message_text,
                    messages.timestamp as message_timestamp,
                    messages.project_id as message_project_id,
                    users.id as user_id,
                    users.name as user_name,
                    users.username as user_username,
                    users.email as user_email
                    FROM users
                    JOIN messages ON users.id = messages.user_id
                    WHERE project_id = ?
                    AND timestamp > ?";
                $values = array($projectId, $timestamp); 
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

        private function updateStatus($statusInfo) {
            $sql = "UPDATE statuses
                SET last_seen_at = strftime('%s', 'now')
                WHERE user_id = ?
                AND project_id = ?";
            $values = array($statusInfo->userId, $statusInfo->projectId);
            return (bool) $this->database->executeQueryDB($sql, $values)->
                rowCount();
        }

        private function createStatus($statusInfo) {
            $sql = "INSERT INTO statuses
                (id, project_id, user_id, last_seen_at)
                VALUES(NULL, ?, ?, strftime('%s', 'now'))";
            $values = array($statusInfo->projectId, $statusInfo->userId);
            return (bool) $this->database->executeQueryDB($sql, $values)->
                rowCount();    
        }

        private function existsStatus($statusInfo) {
            $sql = "SELECT COUNT(*) AS count
                FROM statuses
                WHERE project_id = ?
                AND user_id = ?";
            $values = array($statusInfo->projectId, $statusInfo->userId);
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
                JOIN statuses ON users.id = statuses.user_id
                WHERE statuses.project_id = ?
                AND (strftime('%s', 'now') - statuses.last_seen_at) < 10";
            $values = array($projectId);
            $this->database->iterateDB($this->database->executeQueryDB($sql, 
                $values), $fn);
        }

        public function createNotificationAndDependencies($notificationInfo) {
            $self = $this;
            $function = function() use($notificationInfo, $self) { 
                $self->createNotification($notificationInfo); 
            };
            $this->database->executeTransaction($function); 
        }

        public function createNotification($notificationInfo) {
            $allowedUsers = array();
            $project = $this->getProjectById($notificationInfo->projectId);
            $sql = "INSERT INTO notifications
                (id, title, description, sender_user_id, project_id)
                VALUES(NULL, ?, ?, ?, ?)";
            $values = array($notificationInfo->title, 
                $notificationInfo->description, $notificationInfo->senderUserId, 
                $notificationInfo->projectId);
            $result = (bool) $this->database->executeQueryDB(
                $sql, $values)->rowCount();
            echo("Notificação criada."); 
            if ($result) {
                $notificationId = $this->getLastInsertedId();
                if ($notificationInfo->users == NULL) {
                    $this->listAllowedUsersByProjectId(function($item) use(
                        $notificationId, &$allowedUsers) {
                            $allowedUsers[] = $item;
                            echo($item->id . " - " . $item->account_value);
                        }, $notificationInfo->projectId);
                }
                else {
                    foreach($notificationInfo->users as $userId) {
                        $allowedUsers[] = $this->users->getUserById($userId);
                    }
                }
                foreach($allowedUsers as $user) {
                    $result = $this->createNotificationAssociation($notificationId, $user->id);
                    echo("Associação para o usuário " . $user->id . " criada."); 
                    if ($user->account_type == "Twitter") {
                        echo ("Conta do Twitter"); 
                        $message = "O usuário " . $notificationInfo->senderUserName . 
                            " lhe enviou uma notificação intitulada \"" . $notificationInfo->title . 
                            "\" no projeto \"" . $project->title . "\"."; 
                        $this->tweet($user->account_value, $message);
                        echo("Tweet para o usuário " . $user->id . " enviado.");
                    }
                    else { echo("Não é conta do Twitter."); }
                }
            }
            else {
                echo("Falhou");
                return false;
            }
        }

        private function createNotificationAssociation($notificationId, $userId) {
            $sql = "INSERT INTO notifications_users
                (id, notification_id, user_id)
                VALUES(NULL, ?, ?)";
            $values = array($notificationId, $userId);
            if (!(bool) $this->database->executeQueryDB(
                $sql, $values)->rowCount()) {
                return false;
            }
        }

        public function listNotificationsByUserId($fn, $userId) {
            $sql = "SELECT notifications_users.notification_id AS id,
                notifications.title AS title,
                notifications.description AS description,
                notifications.sender_user_id AS sender_user_id,
                users.name AS sender_user_name,
                notifications.project_id AS project_id,
                projects.title AS project_title
                FROM notifications_users
                JOIN notifications ON notifications_users.notification_id = notifications.id
                JOIN users ON notifications.sender_user_id = users.id
                JOIN projects ON notifications.project_id = projects.id
                WHERE notifications_users.user_id = ?";
            $values = array($userId);
            $this->database->iterateDB($this->database->executeQueryDB($sql, 
                $values), $fn);
        }

        public function createLink($linkInfo) {
            $sql = "INSERT INTO links
                (id, caption, url, project_id)
                VALUES(NULL, ?, ?, ?)";
            $values = array($linkInfo->caption, $linkInfo->url, $linkInfo->projectId);
            return (bool) $this->database->executeQueryDB($sql, $values)->
                rowCount();     
        }

        public function listLinksByProjectId($fn, $projectId) {
            $sql = "SELECT id, caption, url
                FROM links
                WHERE project_id = ?";
            $values = array($projectId);
            $this->database->iterateDB($this->database->executeQueryDB($sql, 
                $values), $fn);
        }

        public function isValidLink($linkInfo) {
            $validationErrors = $this->getValidationErrors($linkInfo);
            foreach($validationErrors as $error) {
                if ($error != NULL) {
                    return false;
                }
            }
            return true;
        }

        public function prependScheme($url) {
            if (!preg_match('/^https?:\/\//', $url)) {
                $url = "http://" . $url;
            }
            return $url;
        }

        public function getValidationErrors($linkInfo) {
            $validationErrors = array("url" => NULL);
            if(!$this->validateUrl($linkInfo->url)) {
                $validationErrors["url"] = "URL inválida.";
            }
            return $validationErrors;
        }

        private function validateUrl($url) {
            if (filter_var($url, FILTER_VALIDATE_URL) == $url) {
                return true;
            }
            else {
                return false;
            }
        }

        public function tweet($twitterUsername, $message) {
            $twitterCredentials = $this->getTwitterCredentials();
            $oAuth = new TwitterOAuth($twitterCredentials->consumer_key,
                $twitterCredentials->consumer_secret,
                $twitterCredentials->access_token,
                $twitterCredentials->access_token_secret);
            //$credentials = $oAuth->get("account/verify_credentials");
            $oAuth->post("statuses/update", array(
                "status" => "@" . $twitterUsername . " " . $message));
        }

        private function getTwitterCredentials() {
            $sql = "SELECT *
                FROM twitter_credentials
                LIMIT 1";
            return $this->database->fetchDB($this->database->executeQueryDB(
                $sql));
        }
    }
?>
