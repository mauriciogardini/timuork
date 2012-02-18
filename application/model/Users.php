
<?php
    require_once("BaseModel.php");    
    require_once("lib/PasswordHash.php");
    require_once("config/config.php");

    class Users extends BaseModel {
        public function __construct() {
            $this->database = BaseModel::getInstance();
        }

        public function createUserAndDependencies($userInfo) {
            $self = $this;
            $function = function() use($userInfo, $self) { 
                $self->createUser($userInfo); 
            };
            $this->database->executeTransaction($function); 
        }

        public function createUser($userInfo) {
            $cryptedPassword = $this->cryptPassword($userInfo->password); 
            if ($cryptedPassword != NULL) {
                $userInfo->password = $cryptedPassword;
            }
            else { 
                return false;
            }
            $sql = "INSERT INTO users
                (id, name, email, username, password) 
                VALUES(NULL, ?, ?, ?, ?)";
            $values = array($userInfo->name, $userInfo->email, 
                $userInfo->username, $userInfo->password);
            $result = ((bool) $this->database->executeQueryDB($sql, 
                $values)->rowCount());
            if ($result) {
                $accountInfo = (object) array("value" => $userInfo->account, 
                    "type" => $userInfo->accountType);
                return $this->manageNotificationAccount($accountInfo); 
            }
            else {
                return false;
            }
        }

        public function manageNotificationAccount($accountInfo) {
            if (!isset($accountInfo->id)) {
                $this->createNotificationAccount($accountInfo);
            }
            else {
                $this->updateNotificationAccount($accountInfo);
            }
        }
        
        public function createNotificationAccount($accountInfo) {
            if (isset($accountInfo->userId)) {
                $sql = "INSERT INTO notification_accounts
                    (id, value, type, user_id)
                    VALUES(NULL, ?, ?, ?)";
                $values = array($accountInfo->value, $accountInfo->type,
                    $accountInfo->userId);
            }
            else {
                $sql = "INSERT INTO notification_accounts
                    (id, value, type, user_id)
                    VALUES(NULL, ?, ?, (SELECT last_insert_rowid() FROM users))";
                $values = array($accountInfo->value, $accountInfo->type);

            }
            return (bool) $this->database->executeQueryDB($sql, 
                $values)->rowCount();
        }

        public function removeNotificationAccount($accountId) {
            $sql = "DELETE FROM notification_accounts
                WHERE id = ?";
            $values = array($accountInfo->userId);
            return (bool) $this->database->executeQueryDB($sql, 
                $values)->rowCount();
        }

        public function updateNotificationAccount($accountInfo) {
            $sql = "UPDATE notification_accounts
                SET value = ?
                WHERE id = ?";
            $values = array($accountInfo->value, $accountInfo->userId);
            return (bool) $this->database->executeQueryDB($sql, 
                $values)->rowCount();
        }
        
        public function getNotificationAccount($userId, $accountType) {
            $sql = "SELECT *
                FROM notification_accounts
                WHERE user_id = ? AND type = ?";
            $values = $array($userId, $accountType);
            return $this->database->fetchDB($this->database->executeQueryDB(
                $sql, $values));
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

        public function getUserValidationErrors($userInfo) {
            $validationErrors = array("name" => NULL,
                "email" => NULL, "username" => NULL, 
                "account" => NULL, "password" => NULL);
            if(!$this->validateName($userInfo->username)) {
                $validationErrors["name"] =  
                    "O nome só pode conter letras, números e '_'";
            }
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
            if(!$this->validateAccount($userInfo->account, 
                $userInfo->accountType)) {
                if($userInfo->accountType == "Twitter") {
                    $validationErrors["account"] = "Twitter inválido";
                }
            }
            return $validationErrors;     
        }

        public function existsUser($username) {
            $sql = "SELECT COUNT(*) AS count 
                FROM users 
                WHERE username = ?";
            $count = $this->database->fetchDB($this->database->executeQueryDB(
                $sql, array($username)))->count;
            return $count;
        }

        public function updateUser($userInfo) {
            $sql = "UPDATE users 
                SET name = ?, email = ?, username = ?, password = ? 
                WHERE id = ?";
            $values = array($userInfo->name, $userInfo->email, 
                $userInfo->username, $userInfo->password, $userInfo->id);
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

        public function validateName($name) {
            if (preg_match('/^[a-zA-Z0-9_]{3,15}$/', $name)) {
                return true;
            }
            else {
                return false;
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

        public function validateAccount($account, $accountType) {
            if ($accountType == "Twitter") {
                if (preg_match('/^[a-zA-Z0-9_]{3,15}$/', $account)) {
                    return true;
                }
                else {
                    return false;
                }
            }
            return false;
        }

        public function authenticate($authenticationUserInfo) {
            return $this->authenticateUser($suthenticationUserInfo);
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

        public function listUsersExcludingListed($fn, $searchString, $excludeList) {
            if (isset($excludeList)) {
                $sql = sprintf("SELECT id, name
                    FROM users
                    WHERE name LIKE ?
                    AND id NOT IN (%s)", rtrim(str_repeat('?,', count($excludeList)), ','));
                $values = array_merge((array)($searchString . "%"), $excludeList);
            }
            else {
                $sql = "SELECT id, name
                    FROM users
                    WHERE name LIKE ?";
                $values = array($searchString . "%");
            }
            return $this->database->iterateDB($this->database->executeQueryDB($sql,
                $values), $fn);
        }
    }
?>
