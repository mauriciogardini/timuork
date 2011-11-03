<html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=UTH-8" />
    <link rel="stylesheet" href="styles/bootstrap.min.css">
</head>
<body>

<?php
    require_once(dirname(__FILE__) . "/includes/session_includes.php");
    require_once(dirname(__FILE__) . "/includes/status_includes.php");
    require_once(dirname(__FILE__) . "/includes/user_includes.php");
    require_once(dirname(__FILE__) . "/includes/general_includes.php");

    if(check_session()) {
        $user = user_first(get_session());
?>
<h3>Usuários online</h3>
<?php        
        status_list(function($item) use($user) {
?>
<p>
<?php
    /* If there's less than 10 seconds of difference
     * between the record's timestamp and the 
     * present time, show it. */
        
    if ((idate("U") - $item->last_seen_at) < 10) {
        if (($item->user_id) != ($user->id)) {
            $logged_user = user_by_id($item->user_id);
            echo $logged_user->name;
        }
    }
?>
</p>
<?php
        }, 1);
    }
    redirect('online_users.php', 5);
?>
</body>
</html>
