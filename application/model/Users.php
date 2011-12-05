<?php
    require_once("BaseModel.php");    
    require_once("lib/PasswordHash.php");
    require_once("config/config.php");

    class Users extends BaseModel {
        public function __construct() {
            $this->database = BaseModel::getInstance();
        }

        public function cryptPassword($word) {
            $hasher = new PasswordHash(STRETCHING_TIMES, PORTABLE_HASH);
            $hash = $hasher->HashPassword($word);
            if (strlen($hash) >= 20) {
                return $hash;
            } 
            else 
            {
                // Something went wrong - 20 is the minimum.
                return NULL; 
            }
        }

        public function comparePasswords($word, $wordHash) {
            $hasher = new PasswordHash(STRETCHING_TIMES, PORTABLE_HASH);
            return ($hasher->CheckPassword($word, $wordHash));
        }

        public function addUser($user) {
            if($this->validateUsername($user->username)) {
                if($this->validatePassword($user->password)) {
                    if($this->validateEmail($user->email)) {
                        $crypted_password = $this->cryptPassword($user->password);
                        if ($crypted_password != NULL)
                        {
                            $user->password = $crypted_password;
                            if(!$this->existsUser($user->username)) {
                                $sql = "INSERT INTO users(id, name, email, username, password) VALUES(NULL, ?, ?, ?, ?)";
                                $values = array($user->name, $user->email, $user->username, $user->password);
                                if((bool) $this->database->executeQueryDB($sql, $values)->rowCount()) {
                                    return "O usuário " . $user->name . " foi cadastrado com sucesso.";
                                }
                                else {
                                    return "O sistema está indisponível. Tente novamente mais tarde."; 
                                }
                            }
                            else {
                                return  "Já existe um usuário utilizando este username.";
                            }
                        }
                        else
                        {
                            return "O sistema está indisponível. Tente novamente mais tarde.";
                        }       
                    }
                    else {
                        return "E-mail inválido.";
                    }
                }
                else {
                    return "O password informado precisa ter entre 6 e 24 caracteres."; 
                }
            }
            else {
                return "O username só pode conter letras, números e '_'";
            }
        }

        public function createUser($user) {
            if(!$this->existsUser($user->username)) {
                            }
            else {
                return false;
            }
        }

        public function existsUser($username) {
            $sql = "SELECT COUNT(*) AS count FROM users WHERE username = ?";
            $count = $this->database->fetchDB($this->database->executeQueryDB($sql, array($username)))->count;
            return $count;
        }

        public function updateUser($user) {
            $sql = "UPDATE users SET name = ?, email = ?, username = ?, password = ? WHERE id = ?";
            $values = array($user->name, $user->email, $user->username, $user->password, $user->id);
            return (bool) $this->database->executeQueryDB($sql, $values)->rowCount();
        }

        public function getUserByUsername($username) {
            return $this->database->fetchDB($this->database->executeQueryDB("SELECT * FROM users WHERE username = ?", array($username)));
        }

        public function getUserById($id) {
            return $this->database->fetchDB($this->database->executeQueryDB("SELECT * FROM users WHERE id = ?", array($id)));
        }

        public function authenticateUser($auth_user) {
            if($this->existsUser($auth_user->username)) {
                $user = $this->getUserByUsername($auth_user->username);
                $check = $this->comparePasswords($auth_user->password, $user->password);

                if ($check) {
                    return $user;
                }
                else {
                    return NULL;
                }
            }
            else {
                return NULL;
            }
        }

        public function validateUsername($username) {
            if (preg_match('/^[a-zA-Z0-9_]{1,60}$/', $username)) {
                return true;
            }
            else {
                return false;
            }
        }

        public function validatePassword($password) {
            if (strlen($password) <= 24 && strlen($password) >= 6) {
                return true;
            }
            else {
                return false;
            }
        }

        public function validateEmail($email) {
            if (filter_var($email, FILTER_VALIDATE_EMAIL) == $email) {
                return true;
            }
            else {
                return false;
            }
        }

        public function authenticate($auth_user) {
            return $this->authenticateUser($auth_user);
        }
    }
?>
