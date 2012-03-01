<div class="container">
    <div class="content">
        <div class="row">
        <div class="span8 div-content" data-project-id="<?php echo $project->id ?>"
            data-admin-user-id="<?php echo $project->admin_user_id ?>">
            <div class="center90"> 
                <h1 id="projectTitle"><?php echo $project->title ?></h1>
                <p id="projectDescription"><?php echo $project->description ?></p>
                <a href="/projects/view/<?php echo $project->id ?>">Ir para o projeto</a>
                </div>
            </div>
            <div class="span4 div-sidebar">
            <div class="center90">
                <a href="#modalEdit" data-toggle="modal">Editar</a>
                    <h3>Usuários participantes</h3>
                    <ul class="unstyled">
                        <?php foreach ($allowedUsers as $allowedUser) { ?>
                        <li data-allowed-user-id="<?php echo $allowedUser->id ?>">
                        <?php echo $allowedUser->name ?></li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- MODALS -->
<div id="modalEdit" class="modal fade">
    <div class="modal-header">
        <a class="close" data-dismiss="modal">&times;</a>
        <h3>Editar Projeto</h3>
    </div>
    <div class="modal-body">
        <form class="modal-form form-horizontal" id="editProject"
            data-edit-project-url="/projects/edit/">
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
                                <?php foreach ($allowedUsers as $allowedUser) { ?>
                                <?php if ($allowedUser->id != $user->getId()) { ?> 
                                <option data-select-user-id="<?php echo $allowedUser->id ?>">
                                <?php echo $allowedUser->name ?></option>
                                <?php } }?>
                            </select>
                            <input type="button" id="removeUser" class="btn"
                                value="Remover" />
                        </div>
                    </div>
                    <div id="titleDiv" class="control-group">
                        <label class="control-label" for="title">Título</label>
                        <div class="controls">
                            <input id="title" name="title" class="span5"
                            type="text" value="<?php echo $project->title ?>">
                            <p class="help-block">
                                Esta informação poderá ser exibida publicamente.
                            </p>
                        </div>
                    </div> 
                    <div id="descriptionDiv" class="control-group">
                        <label for="description">Descrição</label>
                        <div class="controls">
                            <textarea class="span5" name="description" 
                            id="description"><?php echo $project->description ?></textarea>
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

<script src="/scripts/jquery.min.js" type="text/javascript"></script>
<script src="/scripts/bootstrap-modal.js" type="text/javascript"></script>
<script src="/scripts/bootstrap-tooltip.js" type="text/javascript"></script>
<script src="/scripts/bootstrap-popover.js" type="text/javascript"></script>
<script src="/scripts/bootstrap-typeahead.js" type="text/javascript"></script>
<script src="/scripts/timuork-projectOverview.js" type="text/javascript"></script>
<script src="/scripts/timuork-general.js" type="text/javascript"></script>
<script type="text/javascript">
    var edit = new Edit();
</script>
