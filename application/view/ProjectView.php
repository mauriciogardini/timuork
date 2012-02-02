<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=UTF-8" />    
    <title><?php echo $project->title ?></title> 
    <meta name="description" content="Log In">
    <meta name="author" content="Maurício Gardini">
    <meta http-equiv="content-script-type" content="text/javascript">
    <link rel="stylesheet" href="/styles/bootstrap.css">
    <link rel="stylesheet" href="/styles/snippets.css">

    <!-- Le HTML5 shim, for IE6-8 support of HTML elements -->
    <!--[if lt IE 9]>
        <script src="http://html5shim.googlecode.com/svn/trunk/html5.js">
        </script>
    <![endif]-->

    <!-- Le fav and touch icons -->
    <link rel="shortcut icon" href="images/favicon.ico">
    <link rel="apple-touch-icon" href="images/apple-touch-icon.png">
    <link rel="apple-touch-icon" sizes="72x72" href="#">
    <link rel="apple-touch-icon" sizes="114x114" href="#">
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
                <p class="pull-right">Logado como 
                    <a href="#"><?php echo $user->getName() ?></a> | 
                    <a href="/logout">Sair</a></p>
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
                    <center><h1><?php echo $project->title ?></h1></center>    
                </div>
                <div class="span10">
                    <div class="chat-content" id="chat-wrap">
                        <div id="chat">
                        </div>
                    </div>
                    <form id="new-message">
                        <p>
                            <textarea id="message" 
                                class="chat-text-box"></textarea>
                            <input class="chat-submit-button" type="submit" 
                                text="Enviar">
                        </p>    
                    </form>
                </div>
                <div class="span4">
                    <a data-controls-modal="modalNotification" data-backdrop="true" data-keyboard="true" href="#">Nova Interação</a>
                    &nbsp;&nbsp;
                    <a data-controls-modal="modalLink" data-backdrop="true" data-keyboard="true" href="#">Novo Link</a>
                    &nbsp;&nbsp;
                    <a href="/">Sair</a>
                    <h3>Usuários online</h3>
                    <div class="online-users-content" id="onlineUsersWrap">
                        <div id="onlineUsers">
                        </div>
                    </div>
                    <h3>Links</h3>
                    <div class="linksContent" id="linksWrap">
                        <div id="links">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- MODALS -->
    <div id="modalNotification" class="modal hide fade">
        <div class="modal-header">
            <a href="#" class="close">&times;</a>
            <h3>Adicionar Notificação</h3>
        </div>
        <div class="span4">
            <form id="newNotification">
                <fieldset>
                    <div class="modal-body">
                        <div class="clearfix">
                            <label for="for">Para</label>
                            <div class="input">
                            <select name="for" id="normalSelect">
                                <option id=-1>Todos</option>
                                <?php foreach ($projectUsers as $projectUser) { ?>
                                <option id=<?php echo $projectUser->id ?>>
                                    <?php echo $projectUser->name ?>
                                </option>
                                <?php } ?>
                            </select>
                            </div>
                        </div>
                        <div class="clearfix">
                            <label for="title">Título</label>
                            <div class="input">
                                <input id="title" class="large" size="30" 
                                    type="text">
                            </div>
                        </div> 
                        <div class="clearfix">
                            <label for="description">Descrição</label>
                            <div class="input">
                                <textarea id="description"></textarea>
                            </div>
                        </div>                   
                    </div>
                    <div class="modal-footer">
                        <input type="submit" class="btn" text="Criar">
                    </div>
                </fieldset>
            </form>
        </div>
    </div>

    <div id="modalLink" class="modal hide fade">
        <div class="modal-header">
            <a href="#" class="close">&times;</a>
            <h3>Adicionar Link</h3>
        </div>
        <div class="span4">
            <form id="newLink">
                <fieldset>
                    <div class="modal-body">
                       <div class="clearfix">
                            <label for="caption">Título</label>
                            <div class="input">
                                <input id="caption" class="large" size="30" 
                                    type="text">
                            </div>
                        </div> 
                        <div class="clearfix">
                            <label for="url">URL</label>
                            <div class="input">
                                <input id="url" class="large" size="30" 
                                    type="text">
                            </div>
                        </div>                   
                    </div>
                    <div class="modal-footer">
                        <input type="submit" class="btn" text="Criar">
                    </div>
                </fieldset>
            </form>
        </div>
    </div>

    <script src="/scripts/jquery.min.js" type="text/javascript"></script>
    <script src="/scripts/bootstrap-twipsy.js" type="text/javascript"></script>
    <script src="/scripts/bootstrap-popover.js" type="text/javascript"></script>
    <script src="/scripts/bootstrap-modal.js" type="text/javascript"></script>
    <script src="/scripts/chat.js" type="text/javascript"></script>
        <script>
        var chat = new Chat(<?php echo $chat->project_id ?>, 
            <?php echo $chat->id ?>, <?php echo $user->id ?>);
    </script>
</body>
</html>
