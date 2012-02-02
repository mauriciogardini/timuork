<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="content-type" content="text/html;charset=UTF-8" />    
    <!--TODO: Título -->
    <title>#</title>
    <meta name="description" content="#">
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
                <form id="login" action="/login" method="post" class="pull-right">    
                    <input class="input-small" id="loginUsername" name="username" 
                        size="30" type="text" placeholder="Username" />
                    <input class="input-small" id="loginPassword" name="password" 
                        size="30" type="password" placeholder="Senha" />
                    <button class="btn">Entrar</button>
                    <span class="help-block">
                        <input type="checkbox" name="rememberMe" id="rememberMe"
                            value="rememberMe"> Lembrar-me 
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;
                        <a href="/forgotPassword">Esqueceu sua senha?</a>
                    </span>
                </form>               
            </div>
        </div>
    </div>
    <div class="container">
        <div class="content" id="centered">
            <div class="row">
                <div class="span7">
                    <h4>Timuork é a solução para você, que precisa fazer um
                        trabalho de escola/faculdade, mas não quer ver a 
                        caixa de entrada do seu e-mail lotada por causa disso.
                    </h4>
                </div>
                <div class="span7">
                    <form id="addUser" method="post" class="center">
                        <h3>Novo aqui? Junte-se à nós!</h3>
                        <p><input class="input-xlarge" id="name" 
                            name="name" size="30" type="text" 
                            placeholder="Nome completo" /></p>
                        <p><input class="input-xlarge" id="email" 
                            name="email" size="30" type="text" 
                            placeholder="E-mail" /></p>
                        <p><input class="input-xlarge" id="twitter"
                            name="twitter" size="30" type="text"
                            placeholder="Twitter" /></p>
                        <p><input class="input-xlarge" id="username"
                            name="username" size="30" type="text" 
                            placeholder="Username" /></p>
                        <p><input class="input-xlarge" id="password"
                            name="password" size="30" 
                            type="password" placeholder="Senha" /></p>
                        <p><button class="btn">Registrar</button>
                    </form>
                </div>
            </div>
        </div>
        <footer id="bottom">
            <p>&copy; Company 2011</p>
        </footer>
    </div>
<script src="/scripts/jquery.min.js" type="text/javascript"></script>
<script src="/scripts/bootstrap-twipsy.js" type="text/javascript"></script>
<script src="/scripts/bootstrap-popover.js" type="text/javascript"></script>
<script src="/scripts/home.js" type="text/javascript"></script>
<script>
    var home = new Home();
</script>
</body>
</html>
