<html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
</head>
<body>
<?php
    require_once(dirname(__FILE__) . "/includes/project_includes.php");
    require_once(dirname(__FILE__) . "/includes/user_includes.php");
    require_once(dirname(__FILE__) . "/includes/session_includes.php");

    if(check_session()) {
        $session = get_session();
        $user = user_first($session);
        project_by_user_id(function($item) {
?>
<p>
<a href="project_manage.php?id=<?php echo $item->id ?>" target="_parent"><?php echo $item->name ?></a>
<?php 
     $item->name;
?>        
</p>
<?php
        }, $user->id);
?>
<a href="project_manage.php" target="_parent">Novo Projeto</a> 
<?php
    }
?>

</body>
</html>
