<?php
    require_once (dirname(dirname(__FILE__)) . '/config/config.php');
    define('DEFAULT_CONTROLLER', "Home");
    
    $url = $_SERVER['REQUEST_URI'];
    $url = trim($url, '/');
    $array_tmp_uri = explode('/', $url);

    if (isset($array_tmp_uri[0])) {
        $url_values['controller'] = $array_tmp_uri[0];
    }
    if (isset($array_tmp_uri[1])) { 
        $index_values = explode('?', $array_tmp_uri[1]);
        $url_values['action'] = isset($index_values[0]) ? $index_values[0] : $array_tmp_uri[1];
    }    
    if (isset($array_tmp_uri[2])) {
        $index_values = explode('?', $array_tmp_uri[2]);
        $url_values['id'] = isset($index_values[0]) ? $index_values[0] : $array_tmp_uri[2];
    }
    
    require_once("application/Application.php");

    //Special cases: login e logout
    if (($url_values['controller'] == 'login') || ($url_values['controller'] == 'logout')) {
        if ($url_values['controller'] == 'login') {
            $url_values['action'] = "login";
        }
        else {
            $url_values['action'] = "logout";
        }
        $url_values['controller'] = "Users";
        $url_values['id'] = "";
    }

    if ($url_values['controller'] == "") {
        $url_values['controller'] = DEFAULT_CONTROLLER;
        $url_values['action'] = "";
        $url_values['id'] = "";
    }
    
    $url_values['controller'] = ucfirst($url_values['controller']);
    $application = new Application($url_values);
    $application->loadController($url_values['controller']);
