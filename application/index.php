<?php
    define('BASE_PATH', dirname(dirname(__FILE__)));
    define('INCLUDES_PATH', BASE_PATH . "/includes");
    define('WEB_PATH', "/~mauriciogardini/PHP/MVCPHPChat/");
    define('DEFAULT_CONTROLLER', "home");
    
    $url = $_SERVER['REQUEST_URI'];
    $url = trim($url, '/');
    $array_tmp_uri = explode('/', $url);

    if (isset($array_tmp_uri[0])) {
        $url_values['controller'] = $array_tmp_uri[0];
    }
    if (isset($array_tmp_uri[1])) { 
        $url_values['action'] = $array_tmp_uri[1];
    }    
    if (isset($array_tmp_uri[2])) {
        $url_values['id'] = $array_tmp_uri[2];
    }
    
    //echo nl2br("</br>");
    //echo $url_values['controller'] . " | " . $url_values['action'] . " | " . $url_values['id'];
    
    require_once("base.php");

    if ($url_values['controller'] == "") {
        $url_values['controller'] = DEFAULT_CONTROLLER;
        $url_values['action'] = "";
        $url_values['id'] = "";
    }

    $application = new Application($url_values);
    $application->loadController($url_values['controller']);
