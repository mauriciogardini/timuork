<div class="container">
    <div class="content">
        <div class="row">
            <div class="span10"> 
                <form action="project_result.php" method="post">
                    <h1>Editar Projeto</h1>
                    <input type="hidden" name="id" value="
                        <?php echo $project->id ?>"/>
                    <p>Nome 
                        <input type="text" id="name" name="name" 
                            value="<?php echo $project->name ?>"/>
                    </p>
                    <p>Descrição 
                        <textarea id="description" name="description">
                        <?php echo $project->description ?>
                        </textarea>
                    </p>
                    <input type="submit" value="Confirmar"/>
                </form>
            </div>
        </div>
    </div>
</div>
