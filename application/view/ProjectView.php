<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=UTF-8" />    
    <title><?php echo $project->name ?></title> 
    <meta name="description" content="Log In">
    <meta name="author" content="Maurício Gardini">
    <link rel="stylesheet" href="<?php echo WEB_PATH . '/styles/bootstrap.min.css'?>">
    <link rel="stylesheet" href="<?php echo WEB_PATH . '/styles/snippets.css'?>">

    <!-- Le HTML5 shim, for IE6-8 support of HTML elements -->
    <!--[if lt IE 9]>
        <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- Le fav and touch icons -->
    <link rel="shortcut icon" href="images/favicon.ico">
    <link rel="apple-touch-icon" href="images/apple-touch-icon.png">
    <link rel="apple-touch-icon" sizes="72x72" href="images/apple-touch-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="114x114" href="images/apple-touch-icon-114x114.png">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js"></script>
    <script src="<?php echo WEB_PATH . 'scripts/chat.js'?>"></script>
    <script>
        var chat =  new Chat(<?php echo $chat->id ?>);
        chat.update;

    </script>
</head>
<body>
    <div class="topbar">
        <div class="fill">
            <div class="container">
                <a class="brand" href="/">Timuork</a>
                <ul class="nav">
                    <li><a href="#about">About</a></li>
                    <li><a href="#contact">Contact</a></li>
                </ul>
                <p class="pull-right">Logado como <a href="#"><?php echo $user->name ?></a> | <a href="/logout">Sair</a></p>
                <span class="help-block">
                    &nbsp;
                </span>
        </div>
        </div>
    </div>
    <div class="container">
        <div class="content">
            <div class="row">
                <div class="span9">
                    <h1><?php echo $project->name ?></h1>    
                    <div id="chat-wrap">
                        <div id="chat">
                        </div>
                    </div>
                    <form id="new-message">
                        <p>
                            <textarea id="text" maxlength="100"></textarea>
                            <input type="submit" text="Enviar">
                        </p>    
                    </form>
                </div>
                <div class="span5">
                    <h3>Usuários online</h3>
                    <ul class="unstyled">
                        (Needs refreshing)
                        <?php foreach ($onlineUsers as $onlineUser) { ?>
                        <li><?php echo $onlineUser->name ?></li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <script>
        $('#new-message').submit(function() {
            chat.send($("#text").val(), <?php echo $user->id ?>, <?php echo $chat->id ?>)     
        });
    </script>
</body>
</html>
