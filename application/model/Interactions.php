<?php
    require_once("BaseModel.php");

    class Interactions {
        private $database;
        public function __construct() {
            $this->database = BaseModel::getInstance();
        }

            }
