<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=UTF-8" />    
    <title><?php echo $project->name ?></title> 
    <meta name="description" content="Log In">
    <meta name="author" content="Maurício Gardini">
    <meta http-equiv="content-script-type" content="text/javascript">
    <link rel="stylesheet" href="/styles/bootstrap.min.css">
    <link rel="stylesheet" href="/styles/snippets.css">

    <!-- Le HTML5 shim, for IE6-8 support of HTML elements -->
    <!--[if lt IE 9]>
        <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- Le fav and touch icons -->
    <link rel="shortcut icon" href="images/favicon.ico">
    <link rel="apple-touch-icon" href="images/apple-touch-icon.png">
    <link rel="apple-touch-icon" sizes="72x72" href="images/apple-touch-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="114x114" href="images/apple-touch-icon-114x114.png">
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
                <div class "span15"> 
                    <center><h1><?php echo $project->name ?></h1></center>    
                </div>
                <div class="span3">
                    <h3>Interações</h3>
                    <form action="/test/test" method="post">
                    <input type="text" id="it">
                    <input type="submit" id="sit">
                    </form>
                </div>
                <div class="span8">
                    <div class="chat-content" id="chat-wrap">
                        <div id="chat">
                        </div>
                    </div>
                    <form id="new-message">
                        <p>
                            <textarea id="message-text" class="chat-text-box"></textarea>
                            <input class="chat-submit-button" type="submit" text="Enviar">
                        </p>    
                    </form>
                </div>
                <div class="span3">
                    <h3>Usuários online</h3>
                    <div id="online-users-wrap">
                        <div id="online-users">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="/scripts/jquery.min.js" type="text/javascript"></script>
    <script src="/scripts/chat.js" type="text/javascript"></script>
    <script>
        var chat = new Chat(<?php echo $chat->project_id ?>, <?php echo $chat->id ?>, <?php echo $user->id ?>);
    </script>
</body>
</html>
