<html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
    <link rel="stylesheet" href="styles/bootstrap.min.css">
    <style type="text/css">
        .project_link {
            color: #000000;
        }
    </style>
</head>
<body>
<?php
    require_once(dirname(__FILE__) . "/includes/project_includes.php");
    require_once(dirname(__FILE__) . "/includes/user_includes.php");
    require_once(dirname(__FILE__) . "/includes/session_includes.php");

    if(check_session()) {
        $session = get_session();
        $user = user_first($session);
?>
<h2>Projetos</h2>
<?php
        project_by_user_id(function($item) {
?>
<p>
<a href="project_overview.php?id=<?php echo $item->id ?>" class="project_link" target="_parent"><?php echo $item->name ?></a>
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
