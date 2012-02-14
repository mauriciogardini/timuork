<div class="container">
    <div class="content">
        <div class="row">
            <div class="span8 div-content">
                <div class="center90"> 
                <input type="hidden" id="projectId"
                    value="<?php echo $project->id ?>"/>
                <input type="hidden" id="userId"
                    value="<?php echo $user->getId() ?>"/>
                <h1><?php echo $project->title ?></h1>
                <p><?php echo $project->description ?></p>
                <a href="/projects/view/<?php echo $project->id ?>">Ir para o projeto</a>
                </div>
            </div>
            <div class="span4 div-sidebar">
                <div class="center90">
                <a href="#modalEdit" data-toggle="modal">Editar</a>
                    <h3>Usuários participantes</h3>
                    <ul class="unstyled">
                        <?php foreach ($allowedUsers as $allowedUser) { ?>
                        <li><?php echo $allowedUser->name ?></li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="modalEdit" class="modal fade">
    <div class="modal-header">
        <a class="close" data-dismiss="modal">&times;</a>
        <h3>Editar Projeto</h3>
    </div>
    <div class="modal-body">
        <form class="modal-form form-horizontal" id="editProject">
            <fieldset>
                <div class="modal-body">
                    <div id="usersDiv" class="control-group">
                        <label class="control-label" for="users">Usuários</label>
                        <div class="controls">
                            <input type="text" class="span4" id="newUser" 
                                data-search-url="/users/refreshUsers" placeholder=
                                "Digite o nome do usuário a ser adicionado." 
                                data-provide="typeahead" />
                            <input type="button" id="addUser" class="btn" 
                                value="Adicionar" />
                            <select multiple="multiple" class="span4" id="users">
                                <?php foreach ($allowedUsers as $allowedUser) { ?>
                                <option id="<?php echo $allowedUser->id ?>">
                                <?php echo $allowedUser->name ?></option>
                                <?php } ?>
                            </select>
                            <input type="button" id="removeUser" class="btn"
                                value="Remover" />
                        </div>
                    </div>
                    <div id="titleDiv" class="control-group">
                        <label class="control-label" for="title">Título</label>
                        <div class="controls">
                            <input id="title" name="title" class="span4"
                                type="text">
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
                    <input type="submit" class="btn btn-primary" value="Confirmar" />
                </div>
            </fieldset>
        </form>
    </div>
</div>
<script src="/scripts/jquery.min.js" type="text/javascript"></script>
<script src="/scripts/bootstrap-twipsy.js" type="text/javascript"></script>
<script src="/scripts/bootstrap-popover.js" type="text/javascript"></script>
<script src="/scripts/bootstrap-modal.js" type="text/javascript"></script>
<script src="/scripts/bootstrap-typeahead.js" type="text/javascript"></script>
<script src="/scripts/edit.js" type="text/javascript"></script>
<script type="text/javascript">
    var edit = new Edit();
</script>
