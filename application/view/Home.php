<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="content-type" content="text/html;charset=UTF-8" />    
    <!--TODO: Título -->
    <title>#</title>
    <meta name="description" content="#">
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
                <form action="/login" method="post" class="pull-right">    
                    <input class="input-small" id="username" name="username" size="30" type="text" placeholder="Username" />
                    <input class="input-small" id="password" name="password" size="30" type="password" placeholder="Senha" />
                    <button class="btn">Entrar</button>
                    <span class="help-block">
                        <input type="checkbox" name="rememberMe" id="rememberMe" value="rememberMe"> Lembrar-me 
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <a href="/forgotPassword">Esqueceu sua senha?</a>
                    </span>
                </form>               
            </div>
        </div>
    </div>
    <div class="container">
        <div class="content" id="centered">
            <div class="row center">
                <div class="span14">
                    <form action="/users/add" method="post" class="center">
                        <h3>Novo aqui? Junte-se à nós!</h3>
                        <p><input class="input-xlarge" id="unregisteredName" name="unregisteredName" size="30" type="text" placeholder="Nome completo" /></p>
                        <p><input class="input-xlarge" id="unregisteredEmail" name="unregisteredEmail" size="30" type="text" placeholder="E-mail" /></p>
                        <p><input class="input-xlarge" id="unregisteredUsername" name="unregisteredUsername" size="30" type="text" placeholder="Username" /></p>
                        <p><input class="input-xlarge" id="unregisteredPassword" name="unregisteredPassword" size="30" type="password" placeholder="Senha" /></p>
                        <p><button class="btn">Registrar</button>
                    </form>
                </div>
            </div>
        </div>
        <footer id="bottom">
            <p>&copy; Company 2011</p>
        </footer>
    </div>
</body>
</html>
