<html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=UTF-8" />    
</head>
<?php
include(dirname(__FILE__) . "/includes/user_includes.php");
$name = filter_var($_POST["unregistered_name"], FILTER_SANITIZE_STRING);
$email = filter_var($_POST["unregistered_email"], FILTER_SANITIZE_STRING);
$username = filter_var($_POST["unregistered_username"], FILTER_SANITIZE_STRING);
$password = filter_var($_POST["unregistered_password"], FILTER_SANITIZE_STRING);
$user = (object) array("name" => $name, "email" => $email, 
    "username" => $username, "password" => $password);
if(user_create($user))
    echo "O usuário " . $user->name . " foi cadastrado com sucesso.";
else
    echo "Já existe um usuário utilizando este nome.";
