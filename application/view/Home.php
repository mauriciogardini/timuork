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
    <link rel="stylesheet" href="/styles/home.css">
    <!--TODO Fav Icon -->
    <link rel="shortcut icon" href="images/favicon.ico">
</head>
<body class="home-body">
    <div class="navbar navbar-fixed-top">
        <div class="navbar-inner">
            <div class="container">
                <div class="div-brand">
                <a class="brand" id="logo" href="/">Timuork</a>
                <ul class="nav" id="navigationLinks">
                    <li><a href="#about">Sobre</a></li>
                    <li><a href="#contact">Contato</a></li>
                </ul>
                </div>
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
                    <fieldset class="sublogin-fieldset">
                        <label class="checkbox sublogin-label">
                            <input class="sublogin-checkbox" id="rememberMe" type="checkbox" value="1" name="remember_me">
                            <span class="sublogin-span">Lembrar-me</span>
                        </label>
                        <a href="/forgotPassword">Esqueceu sua senha?</a>
                    </fieldset>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="content" id="centered">
            <div class="row">
                <div class="span7 div-description">
                    <div class="center85">
                    <h3><span>Timuork é a solução para você, que precisa fazer um
                    trabalho de escola/faculdade, mas não quer ver a 
                    caixa de entrada do seu e-mail lotada por causa disso.
                    </span></h3>
                    </div>
                </div>
                <div class="span5 div-register">
                    <form id="addUser" method="post" class="center70" action="/users/add">
                        <h3>Novo aqui? Junte-se à nós!</h3>
                        <div id="nameDiv" class="control-group">
                                <input class="input-xlarge" id="name" name="name"
                                    size="30" type="text" placeholder="Nome completo" />
                            </div>
                        <div id="emailDiv" class="control-group">
                                <input class="input-xlarge" id="email" name="email"
                                    size="30" type="text" placeholder="E-mail" />
                            </div>
                        <div id="accountDiv" class="control-group">
                                <input class="input-xlarge" id="account"name="account"
                                    size="30" type="text" placeholder="Twitter" />
                            </div>
                        <div hidden="hidden" id="accountTypeDiv">
                                <select class="input-xlarge" id="accountType" name="accountType">
                                    <option selected="selected" value="Twitter">Twitter</option>
                                </select>
                        </div>
                        <div id="usernameDiv" class="control-group">
                                <input class="input-xlarge" id="username" name="username" 
                                    size="30" type="text" placeholder="Username" />
                        </div>
                        <div id="passwordDiv" class="control-group">
                                <input class="input-xlarge" id="password" name="password"
                                    size="30" type="password" placeholder="Senha" />
                        </div>
                        <div>
                            <button class="btn">Registrar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <footer id="bottom" class="footer">
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
