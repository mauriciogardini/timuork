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
    protected $reflection;

    public function __construct() {
        $this->Sessions = new Sessions;
        $this->Sessions->startSession();
    }

    public function __call($name, $arguments) {
        $this->reflection = new ReflectionClass(get_class($this)); 
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
        if($this->reflection->hasProperty($attribute)) { 
            $this->{$attribute} = $value;
        }
    }

    public function getProperty($attribute) {
        if($this->reflection->hasProperty($attribute)) { 
            return $this->{$attribute};
        }
    }

    public function set($sessionUser) {
        foreach($sessionUser as $attribute => $value) {
            $this->setAttribute($attribute, $value);
        } 
    }

    public function isDefined() {
        return isset($this->id);
    }
}
