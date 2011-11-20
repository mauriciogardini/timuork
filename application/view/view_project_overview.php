<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=UTF-8" />    
    <title>Overview - <?php echo $project->name ?></title>
    <meta name="description" content="<?php echo $project->name ?>">
    <meta name="author" content="Maurício Gardini">
    <link rel="stylesheet" href="<?php echo WEB_PATH . '/styles/bootstrap.min.css'?>">
    <link rel="stylesheet" href="<?php echo WEB_PATH . '/styles/snippets.css'?>">

    <!-- Le HTML5 shim, for IE6-8 support of HTML elements -->
    <!--[if lt IE 9]>
        <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- Le fav and touch icons -->
    <link rel="shortcut icon" href="images/favicon.ico">
    <link rel="apple-touch-icon" href="images/apple-touch-icon.png">
    <link rel="apple-touch-icon" sizes="72x72" href="images/apple-touch-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="114x114" href="images/apple-touch-icon-114x114.png">
</head>
<body>
    <div class="topbar">
        <div class="fill">
            <div class="container">
                <a class="brand" href="#">Timuork</a>
                <ul class="nav">
                    <li><a href="#about">About</a></li>
                    <li><a href="#contact">Contact</a></li>
                </ul>
                <p class="pull-right">Logado como <a href="#"><?php echo "Teste" ?></a> | <a href="index.php?logout=true">Sair</a></p>
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
                    <input type="hidden" name="id" value="<?php echo $project->id ?>"/>
                        <h1><?php echo $project->name ?></h1>
                        <p><?php echo $project->description ?></p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
