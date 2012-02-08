<div class="container">
    <div class="content">
        <div class="row">
            <div class="span8 div-content">
                <div class="center90"> 
                <input type="hidden" name="id"
                    value="<?php echo $project->id ?>"/>
                <h1><?php echo $project->title ?></h1>
                <p><?php echo $project->description ?></p>
                <a href="/projects/view/<?php echo $project->id ?>">Ir para o projeto</a>
                </div>
            </div>
            <div class="span4 div-sidebar">
                <div class="center90">
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
