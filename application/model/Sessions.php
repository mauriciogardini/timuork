<?php
    class Sessions {
        public function startSession() {
            if (!$this->checkSession()) {
                session_start();
            }
        }

        public function destroySession() {
            if ($this->checkSession()) {
                session_destroy();
            }
        }

        private function checkSession() {
            return (bool) session_id();
        }

        public function read($key) {
            if(isset($_SESSION[$key])) {
                return $_SESSION[$key];
            }
        }

        public function write($key, $value) {
            $_SESSION[$key] = $value;
        }

        public function delete($key) {
            unset($_SESSION[$key]);
        }
    }
