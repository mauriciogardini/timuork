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
    <link rel="stylesheet" href="/styles/timuork.css">
    <!--TODO Fav Icon -->
    <link rel="shortcut icon" href="images/favicon.ico">
</head>
<body>
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
                <div id="loginDiv" class="pull-right">
                    <form class="form-search" style="margin-bottom: 6px" id="login" action="/login" method="post"> 
                        <fieldset>
                            <input class="input-small" id="loginUsername" name="loginUsername"
                                type="text" placeholder="Username" maxlength="20" />
                            <input class="input-small" id="loginPassword" name="loginPassword"
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
                    caixa de entrada do seu e-mail lotada por causa disso.</span></h3>
                    <h4><span>Ao criar um projeto, você e seus colegas de trabalho tem 
                    à sua disposição um chat persistente para discutir o que for
                    necessário, bem como a opção de adicionar links pertinentes
                    ao assunto discutido. E, caso nem todos os membros do grupo
                    estejam online no momento, pode-se enviar notificações via
                    Twitter para os participantes ausentes. 
                    </span></h4>
                    </div>
                </div>
                <div class="span5 div-register">
                    <form id="addUser" method="post" class="center70" action="/users/add">
                        <h3>Novo aqui? Junte-se à nós!</h3>
                        <div id="nameDiv" class="control-group">
                                <input class="input-xlarge" id="name" name="name"
                                    size="30" type="text" placeholder="Nome completo" 
                                    maxlength="20" />
                            </div>
                        <div id="emailDiv" class="control-group">
                                <input class="input-xlarge" id="email" name="email"
                                    size="30" type="text" placeholder="E-mail" 
                                    maxlength="20" />
                            </div>
                        <div id="accountDiv" class="control-group">
                                <input class="input-xlarge" id="account"name="account"
                                    size="30" type="text" placeholder="Twitter"
                                    maxlength="15" />
                            </div>
                        <div hidden="hidden" id="accountTypeDiv">
                                <select class="input-xlarge" id="accountType" name="accountType">
                                    <option selected="selected" value="Twitter">Twitter</option>
                                </select>
                        </div>
                        <div id="usernameDiv" class="control-group">
                                <input class="input-xlarge" id="username" name="username" 
                                    size="30" type="text" placeholder="Username" 
                                    maxlength="20" />
                        </div>
                        <div id="passwordDiv" class="control-group">
                                <input class="input-xlarge" id="password" name="password"
                                    size="30" type="password" placeholder="Senha" />
                        </div>
                        <div>
                            <button id="registerButtonDiv" class="btn">Registrar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <footer id="bottom" class="footer">
            <p>&copy; Maurício Gardini - Alguns Direitos Reservados</p>
        </footer>
    </div>
<script src="/scripts/jquery.min.js" type="text/javascript"></script>
<script src="/scripts/bootstrap-tooltip.js" type="text/javascript"></script>
<script src="/scripts/bootstrap-popover.js" type="text/javascript"></script>
<script src="/scripts/timuork-home.js" type="text/javascript"></script>
<script type="text/javascript">
    var home = new Home();
</script>
</body>
</html>
