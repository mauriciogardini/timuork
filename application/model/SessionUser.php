<?php

require_once("Sessions.php");

class SessionUser {
    protected $Sessions;
    protected $attributes = array("id", "name", "username", "email",
        "accountId", "accountValue", "accountType", "flash");

    public function __construct() {
        $this->Sessions = new Sessions;
        $this->Sessions->startSession();
    }

    public function __call($name, $arguments) {
        if(preg_match('/^get(\w+)/', $name, $results)) {
            $attribute = lcfirst($results[1]);
            return $this->getAttribute($attribute);
        }
        else if(preg_match('/^set(\w+)/', $name, $results)) {
            $attribute = lcfirst($results[1]);
            return $this->setAttribute($attribute, $arguments[0]);
        }
    }

    public function setAttribute($attribute, $value) {
        if(in_array($attribute, $this->attributes)) { 
            $this->Sessions->write($attribute, $value); 
        }
    }

    public function getAttribute($attribute) {
        if(in_array($attribute, $this->attributes)) {
            return $this->Sessions->read($attribute); 
        }
    }

    public function set($sessionUser) {
        foreach($sessionUser as $attribute => $value) {
            $this->setAttribute($attribute, $value);
        } 
    }
}
