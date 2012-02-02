<?php

require_once("Sessions.php");

class SessionUser {
    protected $id;
    protected $name;
    protected $username;
    protected $Sessions;

    public function __construct() {
        $this->Sessions = new Sessions;
        $this->Sessions->startSession();
    }

    public function getId() {
        $this->id = $this->id ? $this->id : $this->Sessions->read("userId");
        return $this->id;
    }

    public function setId($value) {
        $this->Sessions->write("userId", $value);
    }

    public function getName() {
        $this->name = $this->name ? $this->name : $this->Sessions->read("name");
        return $this->name;
    }
   
    public function setName($value) {
        $this->Sessions->write("name", $value);
    }

    public function getUsername() {
        $this->username = $this->username ? $this->username : $this->Sessions->read("username");
        return $this->username;
    }

    public function setUsername($value) {
        $this->Sessions->write("username", $value);
    }
}
