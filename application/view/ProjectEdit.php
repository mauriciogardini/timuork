<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=UTF-8" />    
    <!--TODO: Título -->
    <title>Editar Projeto</title>
    <meta name="description" content="Editar Projeto">
    <meta name="author" content="Maurício Gardini">
    <link rel="stylesheet" href="/styles/bootstrap.min.css">
    <link rel="stylesheet" href="/styles/snippets.css">

    <!-- Le HTML5 shim, for IE6-8 support of HTML elements -->
    <!--[if lt IE 9]>
        <script src="http://html5shim.googlecode.com/svn/trunk/html5.js">
        </script>
    <![endif]-->

    <!-- Le fav and touch icons -->
    <link rel="shortcut icon" href="images/favicon.ico">
    <link rel="apple-touch-icon" href="images/apple-touch-icon.png">
    <link rel="apple-touch-icon" sizes="72x72" href="#">
    <link rel="apple-touch-icon" sizes="114x114" href="#">
</head>
<body>
    <div class="topbar">
        <div class="fill">
            <div class="container">
                <a class="brand" href="/">Timuork</a>
                <ul class="nav">
                    <li><a href="#about">About</a></li>
                    <li><a href="#contact">Contact</a></li>
                </ul>
                <p class="pull-right">Logado como 
                    <a href="#"><?php echo $user->name ?></a> | 
                    <a href="/logout">Sair</a>
                </p>
                <span class="help-block">
                    &nbsp;
                </span>
        </div>
        </div>
    </div>
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
</body>
</html>
