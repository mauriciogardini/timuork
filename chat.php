<html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=UTF-8" />    
</head>
<body>
<?php
require_once(dirname(__FILE__) . "/includes/session_includes.php");

if(check_session()) {
    echo "42";
}
else {
    echo "Aqui deveria ter algo legal, mas você não está logado. Salsifufu.";
}
?>
<form action="index.php" method="post">
    <input type="hidden" name="logout" id="logout" value="true" />
    <input type="<?php echo check_session() ? 'submit' : 'hidden' ?>" value="Log out"/>
</form>
</body>
</html>
