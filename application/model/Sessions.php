<?php
    
    class Sessions {
        public function startSession($user) {
            $s = session_id();
            if (empty($s)) {
                session_start();
            }
            //TODO: Verificar se o usuário existe no banco.
            $_SESSION['user'] = $user;
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
            if (isset($_SESSION['user'])) {
                return true;
            }
            else {
                return false;
            }
        }

        public function getSession() {
            return $this->checkSession() ? $_SESSION['user'] : NULL;
        }
    }
