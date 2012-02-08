<div class="container">
    <div class="content">
        <div class="row">
            <div class "span12"> 
                <center><h1><?php echo $project->title ?></h1></center>    
            </div>
            <div class="span9">
                <div class="chat-content" id="chat-wrap">
                    <div id="chat">
                    </div>
                </div>
                <form id="newMessage">
                    <p>
                        <textarea id="message" 
                            class="chat-text-box"></textarea>
                        <input class="chat-submit-button" type="submit" 
                            text="Enviar">
                    </p>    
                </form>
            </div>
            <div class="span3">
                <a data-controls-modal="modalNotification" data-backdrop="true" data-keyboard="true" href="#">Nova Interação</a>
                &nbsp;&nbsp;
                <a data-controls-modal="modalLink" data-backdrop="true" data-keyboard="true" href="#">Novo Link</a>
                &nbsp;&nbsp;
                <a href="/">Sair</a>
                <h3>Usuários online</h3>
                <div class="online-users-content" id="onlineUsersWrap">
                    <div id="onlineUsers">
                    </div>
                </div>
                <h3>Links</h3>
                <div class="linksContent" id="linksWrap">
                    <div id="links">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- MODALS -->
<div id="modalNotification" class="modal hide fade">
    <div class="modal-header">
        <a href="#" class="close">&times;</a>
        <h3>Adicionar Notificação</h3>
    </div>
    <div class="span4">
        <form id="newNotification">
            <fieldset>
                <div class="modal-body">
                    <div class="clearfix">
                        <label for="for">Para</label>
                        <div class="input">
                        <select name="for" id="normalSelect">
                            <option id=-1>Todos</option>
                            <?php foreach ($projectUsers as $projectUser) { ?>
                            <option id=<?php echo $projectUser->id ?>>
                                <?php echo $projectUser->name ?>
                            </option>
                            <?php } ?>
                        </select>
                        </div>
                    </div>
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
                    <input type="submit" class="btn" text="Criar">
                </div>
            </fieldset>
        </form>
    </div>
</div>

<div id="modalLink" class="modal hide fade">
    <div class="modal-header">
        <a href="#" class="close">&times;</a>
        <h3>Adicionar Link</h3>
    </div>
    <div class="span4">
        <form id="newLink">
            <fieldset>
                <div class="modal-body">
                    <div class="clearfix">
                        <label for="caption">Título</label>
                        <div class="input">
                            <input id="caption" class="large" size="30" 
                                type="text">
                        </div>
                    </div> 
                    <div class="clearfix">
                        <label for="url">URL</label>
                        <div class="input">
                            <input id="url" class="large" size="30" 
                                type="text">
                        </div>
                    </div>                   
                </div>
                <div class="modal-footer">
                    <input type="submit" class="btn" text="Criar">
                </div>
            </fieldset>
        </form>
    </div>
</div>

<script src="/scripts/jquery.min.js" type="text/javascript"></script>
<script src="/scripts/bootstrap-twipsy.js" type="text/javascript"></script>
<script src="/scripts/bootstrap-popover.js" type="text/javascript"></script>
<script src="/scripts/bootstrap-modal.js" type="text/javascript"></script>
<script src="/scripts/chat.js" type="text/javascript"></script>
    <script>
    var chat = new Chat(<?php echo $chat->project_id ?>, 
        <?php echo $chat->id ?>, <?php echo $user->getId() ?>);
</script>
