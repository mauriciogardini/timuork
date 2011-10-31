<html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=UTF-8" />    
</head>
<body>
<?php
    require_once(dirname(__FILE__) . "/includes/session_includes.php");
    require_once(dirname(__FILE__) . "/includes/user_includes.php");

    if (check_session()) {
        $session = get_session();
        $user = user_first($session);
        echo "Seja bem-vindo, " . $user->name;
?>
<iframe name="project_list" src="project_list.php" width="50%" height="300">
    <p>Eu acho que tá na hora de você trocar de browser, porque aparentente a sua lata velha não suporta frames.</p>
</iframe>
<?php
    }
    else {
        echo "Você está deslogado.";
    }
?>
</body>
</html>
