<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="content-type" content="text/html;charset=UTF-8" />    
    <!--TODO: Título -->
    <title>Home</title>
    <meta name="description" content="Home">
    <meta name="author" content="Maurício Gardini">
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
                <div class="span9">
                    <h2>Últimas interações</h2>
                </div>
                <div class="span5">
                    <a data-controls-modal="modalProject" data-backdrop="true" data-keyboard="true" href="#">Novo Projeto</a>
                    <h3>Projetos</h3>
                    <div class="projects-content" id="projectsWrap">
                        <div id="projects">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="modalProject" class="modal hide fade">
        <div class="modal-header">
            <a href="#" class="close">&times;</a>
            <h3>Novo Projeto</h3>
        </div>
        <div class="span4">
            <form id="newProject">
                <fieldset>
                    <div class="modal-body">
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

    <script src="/scripts/jquery.min.js" type="text/javascript"></script>
    <script src="/scripts/bootstrap-twipsy.js" type="text/javascript"></script>
    <script src="/scripts/bootstrap-popover.js" type="text/javascript"></script>
    <script src="/scripts/bootstrap-modal.js" type="text/javascript"></script>
    <script src="/scripts/dashboard.js" type="text/javascript"></script>
    <script>
        var dashboard = new Dashboard(<?php echo $user->getId() ?>);
    </script>
</body>
</html>
