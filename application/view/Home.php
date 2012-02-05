<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="content-type" content="text/html;charset=UTF-8" />    
    <!--TODO: Título -->
    <title>#</title>
    <meta name="description" content="#">
    <meta name="author" content="Maurício Gardini">
    <link rel="stylesheet" href="/styles/bootstrap.css">
    <link rel="stylesheet" href="/styles/general.css">
    <link rel="stylesheet" href="/styles/home.css">

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
<body class="login-body">
    <div class="navbar navbar-fixed-top">
        <div class="navbar-inner">
            <div class="container">
                <a class="brand" href="/">Timuork</a>
                <ul class="nav">
                    <li><a href="#about">Sobre</a></li>
                    <li><a href="#contact">Contato</a></li>
                </ul>
                <div class="pull-right">
                    <form class="form-search" style="margin-bottom: 6px" id="login" action="/login" method="post"> 
                        <fieldset>
                            <input class="input-small" id="loginUsername" name="username"
                                type="text" placeholder="Username" />
                            <input class="input-small" id="loginPassword" name="password"
                                type="password" placeholder="Senha" />
                            <button type="submit" class="btn">Entrar</button>
                        </fieldset>
                    </form>
                    <fieldset>
                        <label class="sublogin-label">
                            <input class="sublogin-checkbox" type="checkbox" value="1" name="remember_me">
                            <span class="sublogin-span">Lembrar-me</span>
                        </label>
                        <span class="separator">&middot;</span> 
                        <a href="/forgotPassword">Esqueceu sua senha?</a>
                    </fieldset>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="content" id="centered">
            <div class="row">
                <div class="span6">
                    <span>
                    Timuork é a solução para você, que precisa fazer um
                    trabalho de escola/faculdade, mas não quer ver a 
                    caixa de entrada do seu e-mail lotada por causa disso.
                    </span>
                </div>
                <div class="span6">
                    <form id="addUser" method="post" class="center">
                        <h3>Novo aqui? Junte-se à nós!</h3>
                        <div class="control-group" id="nameDiv">
                            <div class="controls">
                                <input class="input-xlarge" id="name" name="name"
                                    size="30" type="text" placeholder="Nome completo" />
                            </div>
                        </div>
                        <div class="control-group" id="emailDiv">
                            <div class="controls">
                                <input class="input-xlarge" id="email" name="email"
                                    size="30" type="text" placeholder="E-mail" />
                            </div>
                        </div>
                        <div class="control-group" id="accountDiv">
                            <div class="controls">
                                <input class="input-xlarge" id="account"name="account"
                                    size="30" type="text" placeholder="Twitter" />
                            </div>
                        </div>
                        <div class="control-group" hidden="true" id="accountTypeDiv">
                            <div class="controls">
                                <select class="input-xlarge" id="accountType" name="accountType">
                                    <option selected="selected" value="Twitter">Twitter</option>
                                </select>
                            </div>
                        </div>
                        <div class="control-group" id="usernameDiv">
                            <div class="controls">
                                <input class="input-xlarge" id="username" name="username" 
                                    size="30" type="text" placeholder="Username" />
                            </div>
                        </div>
                        <div class="control-group" id="passwordDiv">
                            <div class="controls">
                                <input class="input-xlarge" id="password" name="password"
                                    size="30" type="password" placeholder="Senha" />
                            </div>
                        </div>
                        <div>
                            <button class="btn">Registrar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <footer id="bottom">
            <p>&copy; Company 2011</p>
        </footer>
    </div>
<script src="/scripts/jquery.min.js" type="text/javascript"></script>
<script src="/scripts/bootstrap-tooltip.js" type="text/javascript"></script>
<script src="/scripts/bootstrap-popover.js" type="text/javascript"></script>
<script src="/scripts/home.js" type="text/javascript"></script>
<script>
    var home = new Home();
</script>
</body>
</html>
