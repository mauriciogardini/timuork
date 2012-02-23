<?php

require_once("Sessions.php");

class SessionUser {
    protected $id;
    protected $name;
    protected $username;
    protected $email;
    protected $accountId;
    protected $accountValue;
    protected $accountType;
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

    public function getEmail() {
        $this->email = $this->email ? $this->email : $this->Sessions->read("email");
        return $this->email;
    }
   
    public function setEmail($value) {
        $this->Sessions->write("email", $value);
    }

    public function getAccountId() {
        $this->accountId = $this->accountId ? $this->accountId : $this->Sessions->read("accountId");
        return $this->accountId;
    }
   
    public function setAccountId($value) {
        $this->Sessions->write("accountId", $value);
    }
    
    public function getAccountValue() {
        $this->accountValue = $this->accountValue ? $this->accountValue : $this->Sessions->read("accountValue");
        return $this->accountValue;
    }
   
    public function setAccountValue($value) {
        $this->Sessions->write("accountValue", $value);
    }
    
    public function getAccountType() {
        $this->accountType = $this->accountType ? $this->accountType : $this->Sessions->read("accountType");
        return $this->accountType;
    }
   
    public function setAccountType($value) {
        $this->Sessions->write("accountType", $value);
    }
}
