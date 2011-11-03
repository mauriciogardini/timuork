<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=UTF-8" />    
    <!--TODO: Título -->
    <title>#</title>
    <meta name="description" content="Log In">
    <meta name="author" content="Maurício Gardini">
    <link rel="stylesheet" href="styles/bootstrap.min.css">

    <!-- Le HTML5 shim, for IE6-8 support of HTML elements -->
    <!--[if lt IE 9]>
        <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- Le styles -->
    <style type="text/css">
        /* Override some defaults */
        html, body {
        background-color: #eee;
        }
        body {
        padding-top: 40px; /* 40px to make the container go all the way to the bottom of the topbar */
        }
        .container > footer p {
        text-align: center; /* center align it with the container */
        }
        .container {
        width: 820px; /* downsize our container to make the content feel a bit tighter and more cohesive. NOTE: this removes two full columns from the grid, meaning you only go to 14 columns and not 16. */
        }

        /* The white background content wrapper */
        .content {
        background-color: #fff;
        padding: 20px;
        margin: 0 -20px; /* negative indent the amount of the padding to maintain the grid system */
        -webkit-border-radius: 0 0 6px 6px;
            -moz-border-radius: 0 0 6px 6px;
                border-radius: 0 0 6px 6px;
        -webkit-box-shadow: 0 1px 2px rgba(0,0,0,.15);
            -moz-box-shadow: 0 1px 2px rgba(0,0,0,.15);
                box-shadow: 0 1px 2px rgba(0,0,0,.15);
        }

        /* Page header tweaks */
        .page-header {
        background-color: #f5f5f5;
        padding: 20px 20px 10px;
        margin: -20px -20px 20px;
        }

        /* Styles you shouldn't keep as they are for displaying this base example only */
        .content .span10,
        .content .span4 {
        min-height: 500px;
        }
        /* Give a quick and non-cross-browser friendly divider */
        .content .span4 {
        margin-left: 0;
        padding-left: 19px;
        border-left: 1px solid #eee;
        }

        .topbar .btn {
        border: 0;
        }
        
        /*Centers the content*/
        .center {
        margin-left:auto;
        margin-right:auto;
        width:70%;
        }

        .chat_textbox {
        width:460px;
        }

    </style>

    <!-- Le fav and touch icons -->
    <link rel="shortcut icon" href="images/favicon.ico">
    <link rel="apple-touch-icon" href="images/apple-touch-icon.png">
    <link rel="apple-touch-icon" sizes="72x72" href="images/apple-touch-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="114x114" href="images/apple-touch-icon-114x114.png">
</head>
<body>
<?php
    require_once(dirname(__FILE__) . "/includes/session_includes.php");
    require_once(dirname(__FILE__) . "/includes/message_includes.php");
    require_once(dirname(__FILE__) . "/includes/user_includes.php");
    require_once(dirname(__FILE__) . "/includes/project_includes.php");

    if(check_session()) {
        if(isset($_GET["id"])) {
            $project = project_by_id($_GET["id"]);
            $session = get_session();
            $user = user_first($session);
?>
<div class="topbar">
    <div class="fill">
        <div class="container">
            <a class="brand" href="#">Project name</a>
            <ul class="nav">
                <li><a href="
                    <?php 
                        if (check_session()) { 
                            echo "home.php";
                        }
                        else {
                            echo "index.php";
                        }    
                    ?>">Home</a>
                </li>
                <li><a href="#about">About</a></li>
                <li><a href="#contact">Contact</a></li>
            </ul>
            <p class="pull-right">Logado como <a href="#"><?php echo $user->name ?></a> | <a href="index.php?logout=true">Sair</a></p>
            <span class="help-block">
                &nbsp;
            </span>
       </div>
    </div>
</div>
<div class="container">
    <div class="content">
        <div class="row">
            <div class="span14">
                <h1><?php echo $project->name ?></h1>    
            </div>
        </div>
        <div class="row">
            <div class="span9">
            <iframe name="chat" src="chat.php?id=<?php echo $project->id ?>" width="100%" height="300">
                    <p>Eu acho que tá na hora de você trocar de browser, porque aparentente a sua lata velha não suporta frames.</p>
                </iframe>
                <form action="chat.php?id=<?php echo $project->id ?>" method="post" target="chat">
                    <input class="chat_textbox" type="<?php echo check_session() ? 'text' : 'hidden' ?>" id="text" name="text"/>
                    <input type="<?php echo check_session() ? 'submit' : 'hidden' ?>" value="Enviar"/>
                </form>
            </div>
            <div class="span5">
            <iframe name="online_users" src="online_users.php?id=<?php echo $project->id ?>" width="100%" height="300">
                    <p>Eu acho que tá na hora de você trocar de browser, porque aparentente a sua lata velha não suporta frames.</p>
                </iframe> 
            </div>
        </div> 
    </div>
</div>
<?php
        }
    }
    else {
        echo "Aqui deveria ter algo legal, mas você não está logado. Salsifufu.";
    }
?>
</body>
</html>
