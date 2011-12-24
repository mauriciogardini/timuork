<?php
    require_once("BaseModel.php");

    class Statuses {
        private $database; 
        public function __construct() {
            $this->database = BaseModel::getInstance();
        }
        
        function manageStatus($statusInfo) {
            if ($this->existsStatus($statusInfo)) {
                return $this->updateStatus($statusInfo);
            }
            else {
                return $this->createStatus($statusInfo);
            }    
        } 

        function updateStatus($statusInfo) {
            $sql = "UPDATE online_users 
                SET last_seen_at = strftime('%s', 'now') 
                WHERE user_id = ? 
                AND chat_id = ?";
            $values = array($statusInfo->userId, $statusInfo->chatId);
            return (bool) $this->database->executeQueryDB($sql, $values)->
                rowCount();
        }
 
        function createStatus($statusInfo) {
            $sql = "INSERT INTO online_users
                (id, chat_id, user_id, last_seen_at) 
                VALUES(NULL, ?, ?, strftime('%s', 'now'))";
            $values = array($statusInfo->chatId, $statusInfo->userId);
            return (bool) $this->database->executeQueryDB($sql, $values)->
                rowCount();    
        }

        function existsStatus($statusInfo) {
            $sql = "SELECT COUNT(*) AS count 
                FROM online_users 
                WHERE chat_id = ? 
                AND user_id = ?";
            $values = array($statusInfo->chatId, $statusInfo->userId);
            $count = $this->database->fetchDB($this->database->executeQueryDB(
                $sql, $values))->count;
            return $count;
        }

        function listStatuses($fn, $chatId) {
            $sql = "SELECT * 
                FROM online_users 
                WHERE chat_id = ?";
            $sth = $this->database->executeQueryDB($sql, array($chatId));
            $this->database->iterateDB($sth, $fn);
        }
    }
