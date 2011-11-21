<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=UTF-8" />    
    <title>#</title>
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
                <form action="user_authenticate.php" method="post" class="pull-right">    
                    <input class="input-small" id="username" name="username" size="30" type="text" placeholder="Username" />
                    <input class="input-small" id="password" name="password" size="30" type="password" placeholder="Senha" />
                    <button class="btn">Entrar</button>
                    <span class="help-block">
                        <input type="checkbox" name="remember_me" id="remember_me" value="remember_me"> Lembrar-me 
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <a href="forgot_password.php">Esqueceu sua senha?</a>
                    </span>
                </form>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="content">
            <div class="row">
                <div class="span10">
                    <?php echo $message; ?></br>
                    <a href="/">Voltar para a página principal</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
