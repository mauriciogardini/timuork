<div class="container">
    <div class="content">
        <div class="row">
            <div class="span8 div-content">
                <div class="center95">
                    <h2>Últimas Notificações</h2>
                    <div id="notificationsWrap"
                        data-update-notifications-url="/projects/updateNotifications/">
                        <div id="notifications">
                        </div>
                    </div>
                </div>
            </div>
            <div class="span4 div-sidebar">
                <div class="center90">
                    <h3>Meus Projetos</h3>
                    <div class="my-projects-content" id="myProjectsWrap"
                        data-update-my-projects-url="/projects/updateMyProjects/">
                        <div id="myProjects">
                        </div>
                    </div>
                    <hr />
                    <h3>Outros Projetos</h3>
                    <div class="other-projects-content" id="otherProjectsWrap"
                        data-update-other-projects-url="/projects/updateOtherProjects/">
                        <div id="otherProjects">
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
<div id="modalSettings" class="modal fade">
    <div class="modal-header">
        <a class="close" data-dismiss="modal">&times;</a>
        <h3>Configurações<h3>
    </div>
    <div class="modal-body">
        <form class="modal-form form-horizontal" id="settings"
            data-edit-settings-url="/users/edit">
            <fieldset>
                <div class="modal-body">
                    <div id="nameDiv" class="control-group">
                        <label class="control-label" for="name">Nome</label>
                        <div class="controls">
                            <input type="text" class="span5" id="name"
                                maxlength="20" name="name"/> 
                        </div>
                    </div>
                    <div id="emailDiv" class="control-group">
                        <label class="control-label" for="email">E-mail</label>
                        <div class="controls">
                            <input type="text" class="span5" id="email" id="email" /> 
                        </div>
                    </div>
                    <div id="accountValueDiv" class="control-group">
                        <label class="control-label" for="accountValue">Twitter</label>
                        <div class="controls">
                            <input type="text" class="span5" id="accountValue"
                                maxlength="15" name="accountValue" /> 
                        </div>
                    </div> 
                    <div hidden="hidden" id="accountTypeDiv" class="control-group">
                        <label class="control-label" for="accountType">Tipo</label>
                        <div class="controls">
                            <select class="span5" id="accountType" name="accountType">
                                <option selected="selected" value="Twitter">Twitter</option>
                            </select>
                        </div> 
                    </div>
                    <div id="newPasswordDiv" class="control-group">
                        <label class="control-label" for="newPassword">Nova Senha</label>
                        <div class="controls">
                            <input type="password" class="span5" id="newPassword" name="newPassword"/> 
                            <p class="help-block">
                                Deixe este campo em branco caso queira manter a senha atual.
                            </p>
                        </div>
                    </div>
                    <hr />
                    <div id="oldPasswordDiv" class="control-group">
                        <label class="control-label" for="oldPassword">Senha</label>
                        <div class="controls">
                            <input type="password" class="span5" id="oldPassword" name="oldPassword"/> 
                            <p class="help-block">
                                Informação necessária para a alteração dos dados.
                            </p> 
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="submit" class="btn btn-primary" value="Confirmar" />
                </div>
            </fieldset>
        </form>
    </div>
</div>
<div id="modalProject" class="modal fade">
    <div class="modal-header">
        <a class="close" data-dismiss="modal">&times;</a>
        <h3>Novo Projeto</h3>
    </div>
    <div class="modal-body">
        <form class="modal-form form-horizontal" id="newProject"
            data-add-project-url="/projects/add/">
            <fieldset>
                <div class="modal-body">
                    <div id="newUserDiv" class="control-group">
                        <label class="control-label" for="newUser"></label>
                        <div class="controls">
                            <input type="text" class="span4" id="newUser" 
                                data-search-url="/users/refreshUsers" placeholder=
                                "Digite o nome do usuário a ser adicionado." 
                                data-provide="typeahead" />
                            <input type="button" id="addUser" class="btn" 
                                value="Adicionar" />
                        </div>
                    </div>
                    <div id="usersDiv" class="control-group">
                        <label class="control-label" for="users">Usuários</label>
                        <div class="controls">
                            <select multiple="multiple" class="span4" id="users">
                            </select>
                            <input type="button" id="removeUser" class="btn"
                                value="Remover" />
                        </div>
                    </div>
                    <div id="titleDiv" class="control-group">
                        <label class="control-label" for="title">Título</label>
                        <div class="controls">
                            <input id="title" name="title" class="span5"
                                maxlength="20" type="text" />
                            <p class="help-block">
                                Esta informação poderá ser exibida publicamente.
                            </p>
                        </div>
                    </div> 
                    <div id="descriptionDiv" class="control-group">
                        <label for="description">Descrição</label>
                        <div class="controls">
                            <textarea class="span5" name="description" 
                            id="description"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="submit" class="btn btn-primary" text="Criar" />
                </div>
            </fieldset>
        </form>
    </div>
</div>
<div id="modalWelcome" class="modal fade">
    <div class="modal-body">
        <h1>Seja bem-vindo!</h1> 
    </div>
</div>
<div id="modalViewNotification" class="modal fade">
    <div class="modal-header">
        <a class="close" data-dismiss="modal">&times;</a>
        <h3 id="viewNotificationModalHeaderTitle"></h3>
    </div>
    <div class="modal-body">
        <form class="modal-form form-horizontal" id="viewNotification">
            <fieldset>
                <div class="modal-body">
                    <p id="notificationTimestamp"></p> 
                    <p id="notificationSender"></p>
                    <p><span id="notificationDescription"></span></p>
                    <p id="notificationProjectLink"></p> 
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
                        <ul class="nav nav-tabs">
                            <li class="active">
                                <a href="#project">O Projeto</a>
                            </li>
                            <li>
                                <a href="#author">O Autor</a>
                            </li>
                            <li>
                                <a href="#thanks">Agradecimentos</a>
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
                                feito pelo autor, espera-se que hajam erros, bugs e
                                afins, afinal este recém começou a aventurar nesta
                                área. Todavia, quaisquer críticas (Desde que coerentes e
                                bem-educadas), sugestões e elogios serão aceitos de bom 
                                grado.
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

<script src="/scripts/jquery.min.js" type="text/javascript"></script>
<script src="/scripts/bootstrap-modal.js" type="text/javascript"></script>
<script src="/scripts/bootstrap-tooltip.js" type="text/javascript"></script>
<script src="/scripts/bootstrap-popover.js" type="text/javascript"></script>
<script src="/scripts/bootstrap-typeahead.js" type="text/javascript"></script>
<script src="/scripts/bootstrap-tab.js" type="text/javascript"></script>
<script src="/scripts/mustache.js" type="text/javascript"></script>
<script src="/scripts/timuork-dashboard.js" type="text/javascript"></script>
<script src="/scripts/timuork-general.js" type="text/javascript"></script>
<script type="text/javascript">
    var dashboard = new Dashboard();
</script>
