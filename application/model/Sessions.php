<?php
    
    class Sessions {
        public function startSession($username) {
            $s = session_id();
            if (empty($s)) {
                session_start();
            }
            //TODO: Verificar se o usuário existe no banco.
            $_SESSION['username'] = $username;
        }

        public function quitSession() {
            if ($this->checkSession()) {
                session_destroy();
            }
        }

        public function checkSession() {
            $s = session_id();
            if (session_id() == "") {
                session_start();
            } 
            if (isset($_SESSION['username'])) {
                return true;
            }
            else {
                return false;
            }
        }

        public function getSession() {
            return $this->checkSession() ? $_SESSION['username'] : NULL;
        }
    }
