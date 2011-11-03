<html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=UTF-8" />    
</head>
<body>
    <?php
        require_once(dirname(__FILE__) . "/includes/session_includes.php");
        require_once(dirname(__FILE__) . "/includes/project_includes.php");

        if(check_session()) {
            if(isset($_GET["id"])) {
                $project = project_by_id($_GET["id"]);
            }
    ?>
    <h1><?php echo $project->name ?></h1>
    <?php 
        echo $project->description;
        }
        else {
            echo "Você não está logado.";
        }
    ?>
</body>
</html>
