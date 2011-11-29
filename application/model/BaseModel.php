<?php
    require_once("config/config.php");

    class BaseModel {
        public function connectDB($fn) {
            try {
                $dbh = new PDO("sqlite:" . ROOT . "/db/database");
                $fn($dbh);
                $dbh = null;
            }
            catch(PDOException $e) {
                echo $e->getMessage();
            }
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
    }
