<html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
</head>
<body>
    <?php
        require_once(dirname(__FILE__) . "/includes/user_includes.php");
        require_once(dirname(__FILE__) . "/includes/session_includes.php");
        require_once(dirname(__FILE__) . "/includes/project_includes.php");
        
        if(check_session()) {
            if(isset($_GET["id"])) {
                $project_id = $_GET["id"];
                project_allowed_users_by_project_id(function($item) {
    ?>
    <p><?php echo $item->name ?></p>
    <?php
                }, $project_id);
            }
        }
    ?>
</body>
</html>

