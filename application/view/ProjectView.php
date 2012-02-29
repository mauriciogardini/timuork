<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="content-type" content="text/html;charset=UTF-8" />    
    <title>Timuork</title>
    <meta name="description" content="Timuork é a solução para você, 
        que precisa fazer um trabalho de escola/faculdade, mas não 
        quer ver a caixa de entrada do seu e-mail lotada por causa disso.">
    <meta name="author" content="Maurício Gardini">
    <link rel="stylesheet" href="/styles/bootstrap.css">
    <link rel="stylesheet" href="/styles/general.css">
    <link rel="stylesheet" href="/styles/projectview.css">
    <!--TODO Fav Icon -->
    <link rel="shortcut icon" href="images/favicon.ico">
</head>
<body>
    <div class="navbar navbar-fixed-top">
        <div class="navbar-inner">
            <div class="container">
                <a class="brand" href="/">Timuork</a>
                <ul class="nav" id="navigationLinks">
                    <li><a href="#about">About</a></li>
                    <li><a href="#contact">Contact</a></li>
                </ul>
                <p class="pull-right logged-in">Logado como 
                    <a href="#"><?php echo $user->getName() ?></a> | 
                    <a href="/logout">Sair</a>
                </p>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="content">
            <div class="row">
                <div class="span12 chat-header"> 
                    <center><h1><?php echo $project->title ?></h1></center>    
                </div>
            </div>
            <div class="row">
                <div class="span8">
                    <div class="chat-content" id="chat-wrap">
                        <div id="chat">
                        </div>
                    </div>
                    <div class="chat-message" id="message-wrap">
                        <form id="newMessage">
                            <textarea id="message" 
                                class="span7"></textarea>
                            <input class="span1" type="submit" 
                                text="Enviar">
                        </form>
                    </div>
                </div>
                <div class="span4">
                    <div class="chat-sidebar">
                        <a href="#modalNotification" data-toggle="modal">Nova Notificação</a>
                        <a href="#modalLink" data-toggle="modal">Novo Link</a>
                        <a href="/">Sair</a>
                        <hr />
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
        <footer id="bottom" class="footer">
            <p>&copy; Maurício Gardini - Alguns Direitos Reservados</p> 
        </footer> 
     </div>

    <!-- MODALS -->
    <div id="modalNotification" class="modal fade">
        <div class="modal-header">
            <a class="close" data-dismiss="modal">&times;</a>
            <h3>Adicionar Notificação</h3>
        </div>
        <div class="modal-body">
            <form class="modal-form form-horizontal" id="newNotification">
                <fieldset>
                    <div class="modal-body">
                        <div id="forDiv" class="control-group">
                            <label class="control-label" for="for">Para</label>
                            <div class="controls">
                                <select class="span5" name="for" id="userSelect">
                                    <option id=-1>Todos</option>
                                    <?php foreach ($projectUsers as $projectUser) { ?>
                                    <option id=<?php echo $projectUser->id ?>>
                                        <?php echo $projectUser->name ?>
                                    </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div id="titleDiv" class="control-group">
                            <label class="control-label" for="title">Título</label>
                            <div class="controls">
                                <input id="title" name="title" class="span5" type="text">
                                <p class="help-block">Esta informação poderá ser exibida publicamente.</p>
                            </div>
                        </div> 
                        <div id="descriptionDiv" class="control-group">
                            <label for="description">Descrição</label>
                            <div class="controls">
                                <textarea class="span5" name="description" id="description"></textarea>
                            </div>
                        </div>                   
                    </div>
                    <div class="modal-footer">
                        <input type="submit" class="btn btn-primary" value="Criar" />
                    </div>
                </fieldset>
            </form>
        </div>
    </div>

    <div id="modalLink" class="modal fade">
        <div class="modal-header">
            <a class="close" data-dismiss="modal">&times;</a>
            <h3>Adicionar Link</h3>
        </div>
        <div class="modal-body">
            <form class="modal-form form-horizontal" id="newLink">
                <fieldset>
                    <div class="modal-body">
                        <div id="captionDiv" class="control-group">
                            <label class="control-label" for="caption">Título</label>
                            <div class="controls">
                                <input id="caption" title="caption" class="span5" type="text">
                            </div>
                        </div> 
                        <div id="urlDiv" class="control-group">
                            <label class="control-label" for="url">URL</label>
                            <div class="controls">
                                <input id="url" name="url" class="span5" type="text">
                            </div>
                        </div>                   
                    </div>
                    <div class="modal-footer">
                        <input type="submit" class="btn btn-primary" value="Criar" />
                    </div>
                </fieldset>
            </form>
        </div>
    </div>
   <div id="modalSettings" class="modal fade">
    <div class="modal-header">
        <a class="close" data-dismiss="modal">&times;</a>
        <h3>Configurações<h3>
    </div>
    <div class="modal-body">
        <form class="modal-form form-horizontal" id="settings">
            <fieldset>
                <div class="modal-body">
                    <div id="nameDiv" class="control-group">
                        <label class="control-label" for="name">Nome Completo</label>
                        <div class="controls">
                            <input type="text" class="span4" id="name" /> 
                        </div>
                    </div>
                    <div id="emailDiv" class="control-group">
                        <label class="control-label" for="email">E-mail</label>
                        <div class="controls">
                            <input type="text" class="span4" id="email" /> 
                        </div>
                    </div>
                    <div id="accountDiv" class="control-group">
                        <label class="control-label" for="account">Twitter</label>
                        <div class="controls">
                            <input type="text" class="span4" id="account" /> 
                        </div>
                    </div>
                    <div id="usernameDiv" class="control-group">
                        <label class="control-label" for="username">Username</label>
                        <div class="controls">
                            <input type="text" class="span4" id="username" /> 
                        </div>
                    </div>
                    <div id="passwordDiv" class="control-group">
                        <label class="control-label" for="password">Senha</label>
                        <div class="controls">
                            <input type="password" class="span4" id="password" /> 
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="submit" class="btn btn-primary" text="Criar" />
                </div>
            </fieldset>
        </form>
    </div>
 
    <script src="/scripts/jquery.min.js" type="text/javascript"></script>
    <script src="/scripts/bootstrap-twipsy.js" type="text/javascript"></script>
    <script src="/scripts/bootstrap-popover.js" type="text/javascript"></script>
    <script src="/scripts/bootstrap-modal.js" type="text/javascript"></script>
    <script src="/scripts/chat.js" type="text/javascript"></script>
        <script>
        var chat = new Chat(<?php echo $project->id ?>, <?php echo $user->getId() ?>);
    </script>
</body>
</html>
