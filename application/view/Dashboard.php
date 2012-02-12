<div class="container">
    <div class="content">
        <div class="row">
            <div class="span8 div-content">
                <div class="center95">
                    <h2>Últimas Notificações</h2>
                    <div id="notificationsWrap">
                        <div id="notifications">
                        </div>
                    </div>
                </div>
            </div>
            <div class="span4 div-sidebar">
                <div class="center90">
                    <h3>Meus Projetos</h3>
                    <div class="my-projects-content" id="myProjectsWrap">
                        <div id="myProjects">
                        </div>
                    </div>
                    <hr />
                    <h3>Outros Projetos</h3>
                    <div class="other-projects-content" id="otherProjectsWrap">
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
<div id="modalProject" class="modal fade">
    <div class="modal-header">
        <a class="close" data-dismiss="modal">&times;</a>
        <h3>Novo Projeto</h3>
    </div>
    <div class="modal-body">
        <form class="modal-form form-horizontal" id="newProject">
            <fieldset>
                <div class="modal-body">
                    <div id="titleDiv" class="control-group">
                        <label class="control-label" for="title">Título</label>
                        <div class="controls">
                            <input id="title" name="title" class="span5" type="text">
                            <p class="help-block">Esta informação poderá ser exibida publicamente.</p>
                        </div>
                    </div> 
                    <div id="descriptionDiv" class="control-group">
                        <label for="description">Descrição</label>
                        <div class="controls">
                            <textarea class="span5" name="description" id="description"></textarea>
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

<script src="/scripts/jquery.min.js" type="text/javascript"></script>
<script src="/scripts/bootstrap-twipsy.js" type="text/javascript"></script>
<script src="/scripts/bootstrap-popover.js" type="text/javascript"></script>
<script src="/scripts/bootstrap-modal.js" type="text/javascript"></script>
<script src="/scripts/mustache.js" type="text/javascript"></script>
<script src="/scripts/dashboard.js" type="text/javascript"></script>
<script>
    var dashboard = new Dashboard(<?php echo $user->getId() ?>);
</script>
