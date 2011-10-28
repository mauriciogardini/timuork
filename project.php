<html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=UTF-8" />    
</head>
<body>
<?php
    require_once(dirname(__FILE__) . "/includes/session_includes.php");
    require_once(dirname(__FILE__) . "/includes/message_includes.php");
    require_once(dirname(__FILE__) . "/includes/user_includes.php");
    if(check_session()) { 
?>
<iframe name="chat" src="chat.php" width="50%" height="300">
    <p>Eu acho que tá na hora de você trocar de browser, porque aparentente a sua lata velha não suporta frames.</p>
</iframe>
<iframe name="online_users" src="online_users.php" width="20%" height="300">
    <p>Eu acho que tá na hora de você trocar de browser, porque aparentente a sua lata velha não suporta frames.</p>
</iframe> 
<?php
    }
    else {
        echo "Aqui deveria ter algo legal, mas você não está logado. Salsifufu.";
    }
?>
<form action="chat.php" method="post" target="chat">
    <input type="<?php echo check_session() ? 'text' : 'hidden' ?>" id="text" name="text"/>
    <input type="<?php echo check_session() ? 'submit' : 'hidden' ?>"/>
</form>
<form action="index.php" method="post">
    <input type="hidden" name="logout" id="logout" value="true" />
    <input type="<?php echo check_session() ? 'submit' : 'hidden' ?>" value="Log out"/>
</form>
</body>
</html>
