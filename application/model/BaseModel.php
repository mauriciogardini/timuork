<?php
    require_once("config/config.php");

    class BaseModel {
        private $dbh;
        private static $baseModel;

        private function __construct() {
        }

        public static function getInstance() {
            if (!isset(self::$instance)) {
                self::$baseModel = new BaseModel();
            }
            return self::$baseModel;
        }

        public function connectDB($fn) {
            try {
                $this->getConnection();
                $fn($this->dbh);
            }
            catch(PDOException $e) {
                echo $e->getMessage();
            }
        }

        public function getConnection() {
            if ($this->dbh == NULL) {
                $this->dbh = new PDO("sqlite:" . ROOT . "/db/database");
            }
            return $this->dbh; 
        }

        public function executeQueryDB($query, $params = array()) {
            $this->connectDB(function($dbh) use($query, $params, &$sth) {
                $sth = $dbh->prepare($query);
                $sth->execute($params);
            });
            return $sth;
        }

        public function fetchDB($sth) {
            return $sth->fetch(PDO::FETCH_OBJ);
        }

        public function iterateDB($sth, $fn) {
            while($row = $this->fetchDB($sth)) {
                $result = $fn($row);
                if($result === false)
                {
                    break;
                }   
            }
        }

        public function iterateArray($arr, $fn) {
            foreach($arr as $item) {
                $result = $fn($item);
                if($result === false)
                {
                    break;
                }
            }
        }

        public function executeTransaction($fn) {
            $this->executeQueryDB("BEGIN TRANSACTION;", NULL);
            $fn();    
            $this->executeQueryDB("COMMIT;", NULL);
        } 
    }
