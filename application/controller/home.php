<?php
    class Home extends Application {
        function __construct() {
        }

        function index() {
            $this->loadView('view_home', NULL);
        }
    }
