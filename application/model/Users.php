
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

        public function isValidUser($userInfo) {
            $validationErrors = $this->getUserValidationErrors($userInfo);
            foreach($validationErrors as $error) {
                if ($error != NULL) {
                    return false;
                }
            }

            return true;
        }

        public function createUser($userInfo) {
            $crypted_password = $this->cryptPassword($userInfo->password); 
            if ($crypted_password == NULL) {
                return false;
            }
            else { 
                $userInfo->password = $crypted_password;
            }
            $sql = "INSERT INTO users
                (id, name, email, twitter, username, password) 
                VALUES(NULL, ?, ?, ?, ?, ?)";
            $values = array($userInfo->name, $userInfo->email, $userInfo->twitter, 
                $userInfo->username, $userInfo->password);

            return ((bool) $this->database->executeQueryDB($sql, 
                $values)->rowCount());
        }

        public function getUserValidationErrors($userInfo) {
            $validationErrors = array("name" => NULL,
                "email" => NULL, "username" => NULL, 
                "password" => NULL);
            if(!$this->validateUsername($userInfo->username)) {
                $validationErrors["username"] =  
                    "O username só pode conter letras, números e '_'";
            }
            else if($this->existsUser($userInfo->username)) {
                $validationErrors["username"] = 
                    "Já existe um usuário utilizando este username.";
            }

            if(!$this->validatePassword($userInfo->password)) {
                $validationErrors["password"] = 
                    "O password deve ter entre 6 e 24 caracteres.";
            }

            if(!$this->validateEmail($userInfo->email)) {
                $validationErrors["email"] = 
                    "E-mail inválido.";
            }

            if(!$this->validateTwitter($userInfo->twitter)) {
                $validationErrors["twitter"] = 
                    "Twitter inválido";
            }

            return $validationErrors;     
        }

        public function existsUser($username) {
            $sql = "SELECT COUNT(*) AS count 
                FROM users 
                WHERE username = ?";
            $count = $this->database->fetchDB($this->database->executeQueryDB($sql, array($username)))->count;

            return $count;
        }

        public function updateUser($userInfo) {
            $sql = "UPDATE users 
                SET name = ?, email = ?, username = ?, password = ? 
                WHERE id = ?";
            $values = array($userInfo->name, $userInfo->email, $userInfo->username, 
                $userInfo->password, $userInfo->id);
            return (bool) $this->database->executeQueryDB($sql, $values)->
                rowCount();
        }

        public function getUserByUsername($username) {
            $sql = "SELECT * 
                FROM users 
                WHERE username = ?";
            $values = array($username);
            return $this->database->fetchDB($this->database->executeQueryDB(
                $sql, $values));
        }

        public function getUserById($userId) {
            $sql = "SELECT * 
                FROM users 
                WHERE id = ?";
            $values = array($userId);
            return $this->database->fetchDB($this->database->executeQueryDB(
                $sql, $values));
        }

        //TODO - Improve authentication (getValidationErrors)
        public function authenticateUser($authenticationUserInfo) {
            if($this->existsUser($authenticationUserInfo->username)) {
                $user = $this->getUserByUsername($authenticationUserInfo->username);
                if ($this->comparePasswords($authenticationUserInfo->password, 
                    $user->password)) {
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
            if (preg_match('/^[a-zA-Z0-9_]{3,15}$/', $username)) {
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

        public function validateTwitter($twitter) {
            if (preg_match('/^[a-zA-Z0-9_]{3,15}$/', $twitter)) {
                return true;
            }
            else {
                return false;
            }
        }

        public function authenticate($authenticationUserInfo) {
            return $this->authenticateUser($suthenticationUserInfo);
        }
    }
?>
