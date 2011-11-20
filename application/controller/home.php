<?php
    class Home extends Application {
        public function index() {
            if ($this->authenticated()) {
                $this->loadView('view_dashboard', NULL);
            }
            else {
                $this->loadView('view_home', NULL);
            }
        }

        protected function requiresAuth() {
            return false;
        }
    }
