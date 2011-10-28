<html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=UTF-8" />    
</head>
<body>
<?php
    require_once(dirname(__FILE__) . "/includes/message_includes.php");
    require_once(dirname(__FILE__) . "/includes/user_includes.php");
    require_once(dirname(__FILE__) . "/includes/session_includes.php");
    require_once(dirname(__FILE__) . "/includes/general_includes.php");
    require_once(dirname(__FILE__) . "/includes/status_includes.php");

    if(check_session()) {
        $user = user_first($_SESSION['username']); 
        if(isset($_POST['text'])) {
            $text = $_POST['text'];
            $message = (object) array("text" => $text, "date_time" => idate("U"), 
                "chat_id" => 1, "user_id" => $user->id);
            message_create($message);
        }
        $status_info = (object) array("chat_id" => "1", "user_id" => $user->id, 
            "timestamp" => idate("U"));
        status_manage($status_info);        
        message_by_chat_id(function($item) {
?>
<p>
<?php 
    $message_user = user_by_id($item->user_id);
    echo $message_user->name . " | " . $item->text;
?>
</p>
<?php
        }, 1);
        status_manage($status_info);
        redirect('chat.php', 5);
    }
    else {
         echo "Aqui deveria ter algo legal, mas você não está logado. Salsifufu.";
    }    
?>
