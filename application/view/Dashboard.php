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
        <form id="newProject">
            <fieldset>
                <div class="modal-body">
                    <div class="clearfix">
                        <label for="title">Título</label>
                        <div class="input">
                            <input id="title" class="large" size="30" 
                                type="text">
                        </div>
                    </div> 
                    <div class="clearfix">
                        <label for="description">Descrição</label>
                        <div class="input">
                            <textarea id="description"></textarea>
                        </div>
                    </div>                   
                </div>
                <div class="modal-footer">
                    <a href="#" type="submit" class="btn btn-primary">Criar</a>
                    <a href="#" class="btn">Fechar</a>
                </div>
            </fieldset>
        </form>
    </div>
</div>

<script src="/scripts/jquery.min.js" type="text/javascript"></script>
<script src="/scripts/bootstrap-twipsy.js" type="text/javascript"></script>
<script src="/scripts/bootstrap-popover.js" type="text/javascript"></script>
<script src="/scripts/bootstrap-modal.js" type="text/javascript"></script>
<script src="/scripts/dashboard.js" type="text/javascript"></script>
<script>
    var dashboard = new Dashboard(<?php echo $user->getId() ?>);
</script>
