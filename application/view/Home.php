<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="content-type" content="text/html;charset=UTF-8" />    
        <title>Timuork</title>
        <meta name="description" content="Timuork é a solução para você, 
            que precisa fazer um trabalho de escola/faculdade, mas não 
            quer ver a caixa de entrada do seu e-mail lotada por causa disso.">
        <meta name="author" content="Maurício Gardini">
        <meta name="google-site-verification" content="Po3uG-hyZF3gkCQ50utqfoik8BVeJS82f-EEQ26BzK8" />
        <link rel="stylesheet" href="/styles/bootstrap.css">
        <link rel="stylesheet" href="/styles/timuork.css">
        <link rel="shortcut icon" href="img/favicon.ico">
    </head>
    <body>
        <div class="outerDiv">
            <div class="navbar navbar-fixed-top">
                <div class="navbar-inner">
                    <div class="container">
                        <div class="div-brand">
                        <a class="brand" id="logo" href="/">Timuork</a>
                        <ul class="nav" id="navigationLinks">
                            <li><a href="#modalAbout" data-toggle="modal">Sobre</a></li>
                            <li><a href="#modalContact" data-toggle="modal">Contato</a></li>
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
                                <a href="#">Esqueceu sua senha?</a>
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
                            <p><h3><span>Timuork é a solução para quem precisa fazer um
                            trabalho de escola/faculdade, mas não quer a 
                            caixa de entrada do seu e-mail lotada por causa disso.</span></h3></p>
                            <p><h4><span>Ao criar um projeto, você e seus colegas de trabalho tem 
                            à sua disposição um chat persistente para discutir o que for
                            necessário, bem como a opção de adicionar links pertinentes
                            ao assunto discutido. E, caso nem todos os membros do grupo
                            estejam online no momento, pode-se enviar notificações via
                            Twitter para os participantes ausentes. 
                            </span></h4></p>
                            </div>
                        </div>
                        <div class="span5 div-register">
                            <form id="addUser" method="post" class="center70" action="/users/add">
                                <h3>Novo aqui? Junte-se à nós!</h3>
                                <div id="nameDiv" class="control-group">
                                    <div class="controls">
                                        <input class="input-xlarge" id="name" name="name"
                                            size="30" type="text" placeholder="Nome completo" 
                                            maxlength="20" />
                                    </div>
                                </div>
                                <div id="emailDiv" class="control-group">
                                    <div class="controls">
                                        <input class="input-xlarge" id="email" name="email"
                                            size="30" type="text" placeholder="E-mail" />
                                    </div>
                                </div>
                                <div id="accountDiv" class="control-group">
                                    <div class="controls">
                                        <input class="input-xlarge" id="account"name="account"
                                            size="30" type="text" placeholder="Twitter"
                                            maxlength="15" />
                                    </div>
                                </div>
                                <div hidden="hidden" id="accountTypeDiv">
                                    <div class="controls">
                                        <select class="input-xlarge" id="accountType" name="accountType">
                                            <option selected="selected" value="Twitter">Twitter</option>
                                        </select>
                                    </div>
                                </div>
                                <div id="usernameDiv" class="control-group">
                                    <div class="controls">
                                        <input class="input-xlarge" id="username" name="username" 
                                            size="30" type="text" placeholder="Username" 
                                            maxlength="20" />
                                    </div>
                                </div>
                                <div id="passwordDiv" class="control-group">
                                    <div class="controls">
                                        <input class="input-xlarge" id="password" name="password"
                                            size="30" type="password" placeholder="Senha" />
                                    </div>
                                </div>
                                <div>
                                    <button id="registerButtonDiv" class="btn">Registrar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="modalContact" class="modal fade">
            <div class="modal-header">
                <a class="close" data-dismiss="modal">&times;</a>
                <h3 id="modalContactHeader">Contato</h3>
            </div>
            <div class="modal-body">
                <form class="modal-form form-horizontal" id="contact">
                    <fieldset>
                        <div class="modal-body">
                            <div id="aboutText">
                                <h2><a href="mailto:contato@timuork.com">contato@timuork.com</a></h2>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input data-dismiss="modal" type="submit" class="btn btn-primary" value="Fechar" />
                        </div>
                    </fieldset>
                </form>
            </div>
        </div> 
        <div id="modalAbout" class="modal fade">
            <div class="modal-header">
                <a class="close" data-dismiss="modal">&times;</a>
                <h3 id="modalAboutHeader">Sobre</h3>
            </div>
            <div class="modal-body">
                <form class="modal-form form-horizontal" id="about">
                    <fieldset>
                        <div class="modal-body">
                            <div id="aboutText">
                                <ul id="tabs" class="nav nav-tabs">
                                    <li class="active">
                                        <a href="#project" data-toggle="tab">O Projeto</a>
                                    </li>
                                    <li>
                                        <a href="#author" data-toggle="tab">O Autor</a>
                                    </li>
                                    <li>
                                        <a href="#thanks" data-toggle="tab">Agradecimentos</a>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane active" id="project">
                                        <p><span>Timuork é um projeto feito com o 
                                        objetivo de tentar solucionar um problema 
                                        frequente para quem é estudante: a falta de um 
                                        ambiente/ferramenta adequada para a realização 
                                        dos já costumeiros trabalhos em grupo que
                                        vivem nos propondo ao longo de nossa vida
                                        estudantil/acadêmica.
                                        </span></p>
                                        <p><span>Como este é o primeiro desenvolvimento web
                                        feito pelo autor e o mesmo encontra-se em fase de
                                        testes/beta, espera-se que hajam erros, bugs e
                                        afins, afinal este recém começou a aventurar nesta
                                        área. Por isso, quaisquer críticas (Desde que coerentes e
                                        bem-educadas), sugestões e elogios serão aceitos de bom 
                                        grado e ajudarão a melhorar no que eu vier a produzir
                                        no futuro.
                                        </span></p>
                                        <hr /> 
                                        <p><span>
                                        Este projeto foi construído utilizando-se do 
                                        <a href="http://twitter.github.com/bootstrap/">Twitter Bootstap</a>.
                                        </span></p>
                                    </div>
                                    <div class="tab-pane" id="author">
                                        <p><span>Meu nome é Maurício Gardini, tenho 24 
                                        anos e atualmente curso Ciências da Computação 
                                        na Universidade de Caxias do Sul.
                                        </span></p>
                                        <p><span>Minha experiência com programação web
                                        ainda é pequena, e o Timuork foi o resultado
                                        dos meus estudos, experimentações e esforços
                                        para tentar assimilar a maior parte de 
                                        conhecimento deste ainda novo mundo para mim.
                                        </span></p>
                                        <hr />
                                        <p><ul class="unstyled">
                                            <li><a href="http://twitter.com/mauriciogardini">Twitter</a></li>
                                            <li><a href="http://www.linkedin.com/in/mauriciogardini">LinkedIn</a></li>
                                            <li><a href="https://github.com/mauriciogardini/">Github</a></li> 
                                            <li><a href="http://www.last.fm/user/Guitar_Otoko">Last.fm</a></li>
                                            <li><a href="http://goodreads.com/mauriciogardini">GoodReads</a></li>
                                        </ul></p>
                                    </div>
                                    <div class="tab-pane" id="thanks">
                                        <p><span>Um agradecimento enorme à Julio Greff,
                                            que acompanhou todo o processo de 
                                            desenvolvimento do projeto e que, sempre que
                                            requisitado, dispôs do seu parco tempo livre para
                                            sugerir, corrigir, ensinar e dar soluções.
                                        </span></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input data-dismiss="modal" type="submit" class="btn btn-primary" value="Fechar" />
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
        <footer id="bottom" class="footer">
            <p>&copy; Maurício Gardini - Alguns Direitos Reservados</p>
        </footer>

    <script src="/scripts/jquery.min.js" type="text/javascript"></script>
    <script src="/scripts/bootstrap-modal.js" type="text/javascript"></script>
    <script src="/scripts/bootstrap-tooltip.js" type="text/javascript"></script>
    <script src="/scripts/bootstrap-popover.js" type="text/javascript"></script>
    <script src="/scripts/bootstrap-tab.js" type="text/javascript"></script>
    <script src="/scripts/timuork-general.js" type="text/javascript"></script>
    <script src="/scripts/timuork-popoverHandler.js" type="text/javascript"></script>
    <script src="/scripts/timuork-home.js" type="text/javascript"></script>
    <script type="text/javascript">
        var _gaq = _gaq || [];
        _gaq.push(['_setAccount', 'UA-30009537-1']);
        _gaq.push(['_trackPageview']);
        (function() {
            var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
            ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
            var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
        })();
    </script>
    <script type="text/javascript">
        var home = new Home();
    </script>
    </body>
</html>
