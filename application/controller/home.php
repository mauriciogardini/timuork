<?php
    class Home extends Application {
        function __construct() {
        }

        function index() {
            if ($this->authenticated) {
                $this->loadView('view_dashboard', NULL);
            }
            else {
                $this->loadView('view_home', NULL);
            }
        }
    }
