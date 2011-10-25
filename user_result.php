<html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=UTF-8" />    
</head>
<?php
require_once(dirname(__FILE__) . "/includes/user_includes.php");
require_once(dirname(__FILE__) . "/includes/security_includes.php");
$name = $_POST["unregistered_name"];
$email = $_POST["unregistered_email"];
$username = $_POST["unregistered_username"];
$password = $_POST["unregistered_password"];
$user = (object) array("name" => $name, "email" => $email, 
    "username" => $username, "password" => $password);
$crypted_password = crypt_word($password);
echo nl2br($crypted_password . "</br>");
if ($crypted_password != NULL)
{
    $user->password = $crypted_password;
    if(user_create($user))
        echo "O usuário " . $user->name . " foi cadastrado com sucesso.";
    else
        echo "Já existe um usuário utilizando este nome.";
}
else
{
    echo "Deu algum problema com o password.";
}
