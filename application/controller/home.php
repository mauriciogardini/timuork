<?php
    class Home extends Application {
        function index() {
            if ($this->authenticated()) {
                $this->loadView('view_dashboard', NULL);
            }
            else {
                $this->loadView('view_home', NULL);
            }
        }

        function requiresAuth() {
            return false;
        }
    }
