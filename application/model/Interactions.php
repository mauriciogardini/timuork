<?php
    require_once("BaseModel.php");

    class Interactions {
        private $database;
        public function __construct() {
            $this->database = BaseModel::getInstance();
        }

        function createInteraction($interactionInfo) {
            $sql = "INSERT INTO interactions(id, title, description, project_id) VALUES(NULL, ?, ?, ?)";
            $values = array($interactionInfo->title, $interactionInfo->description, $interactionInfo->projectId);
            $result = (bool) $this->database->executeQueryDB($sql, $values)->rowCount();
            echo "Interação criada";
            if ($result) {
                $interactionId = $this->database->fetchDB($this->database->executeQueryDB("SELECT last_insert_rowid() AS id", array()))->id;
                echo "Id conseguido - " . $interactionId;
                $sql = "INSERT INTO interactions_users(id, interaction_id, user_id) VALUES(NULL, ?, ?)";
                foreach($interactionInfo->users as $userId) {
                    $values = array($interactionId, $userId);
                    if (!(bool) $this->database->executeQueryDB($sql, $values)->rowCount()) {
                        return false;
                    }
                }
            }
            else {
                return false;
            }
        }
    }
