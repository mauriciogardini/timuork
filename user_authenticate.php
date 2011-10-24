<html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=UTF-8" />    
</head>
<?php
require_once(dirname(__FILE__) . "/includes/user_includes.php");
require_once(dirname(__FILE__) . "/includes/general_includes.php");
require_once(dirname(__FILE__) . "/includes/security_includes.php");
$username = filter_var($_POST["username"], FILTER_SANITIZE_STRING);
$password = filter_var($_POST["password"], FILTER_SANITIZE_STRING);
$auth_user = (object) array("username" => $username, "password" => $password);
?>
<form action="index.php" method="post">
<?php
$authenticated = user_authenticate($auth_user); 
if ($authenticated) {
    echo "Seja bem-vindo! Você será redirecionado para o site principal em 3 segundos.";
    redirect("http://www.pudim.com.br", 3);
}
else {
    echo "Usuário ou senha incorretos. Tente novamente.";
}
?>
<input type=<?php echo $authenticated ? '"hidden"' : '"submit"' ?> value="Voltar"/>
</form>
</html>

