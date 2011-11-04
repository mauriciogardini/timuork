<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=UTF-8" />    
    <!--TODO: Título -->
    <title>#</title>
    <meta name="description" content="-">
    <meta name="author" content="Maurício Gardini">
    <link rel="stylesheet" href="styles/bootstrap.min.css">

    <!-- Le HTML5 shim, for IE6-8 support of HTML elements -->
    <!--[if lt IE 9]>
        <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- Le styles -->
    <style type="text/css">
        /* Override some defaults */
        html, body {
        background-color: #eee;
        }
        body {
        padding-top: 40px; /* 40px to make the container go all the way to the bottom of the topbar */
        }
        .container > footer p {
        text-align: center; /* center align it with the container */
        }
        .container {
        width: 820px; /* downsize our container to make the content feel a bit tighter and more cohesive. NOTE: this removes two full columns from the grid, meaning you only go to 14 columns and not 16. */
        }

        /* The white background content wrapper */
        .content {
        background-color: #fff;
        padding: 20px;
        margin: 0 -20px; /* negative indent the amount of the padding to maintain the grid system */
        -webkit-border-radius: 0 0 6px 6px;
            -moz-border-radius: 0 0 6px 6px;
                border-radius: 0 0 6px 6px;
        -webkit-box-shadow: 0 1px 2px rgba(0,0,0,.15);
            -moz-box-shadow: 0 1px 2px rgba(0,0,0,.15);
                box-shadow: 0 1px 2px rgba(0,0,0,.15);
        }

        /* Page header tweaks */
        .page-header {
        background-color: #f5f5f5;
        padding: 20px 20px 10px;
        margin: -20px -20px 20px;
        }

        /* Styles you shouldn't keep as they are for displaying this base example only */
        .content .span10,
        .content .span4 {
        min-height: 500px;
        }
        /* Give a quick and non-cross-browser friendly divider */
        .content .span4 {
        margin-left: 0;
        padding-left: 19px;
        border-left: 1px solid #eee;
        }

        .topbar .btn {
        border: 0;
        }
        
        /*Centers the content*/
        .center {
        margin-left:auto;
        margin-right:auto;
        width:70%;
        }

    </style>

    <!-- Le fav and touch icons -->
    <link rel="shortcut icon" href="images/favicon.ico">
    <link rel="apple-touch-icon" href="images/apple-touch-icon.png">
    <link rel="apple-touch-icon" sizes="72x72" href="images/apple-touch-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="114x114" href="images/apple-touch-icon-114x114.png">
</head>
<body>
    <?php
        require_once(dirname(__FILE__) . "/includes/project_includes.php");
        require_once(dirname(__FILE__) . "/includes/session_includes.php");
        require_once(dirname(__FILE__) . "/includes/user_includes.php");

    if (check_session()) {
        $session = get_session();
        $user = user_first($session);
        if(isset($_GET["id"])) {
            $title = "Editar Projeto";
            $project = project_by_id($_GET["id"]);
        }
        else {
            $title = "Novo Projeto";
        }
    ?>
    <div class="topbar">
        <div class="fill">
            <div class="container">
                <a class="brand" href="#">Project name</a>
                <ul class="nav">
                <li><a href="
                    <?php 
                        if (check_session()) { 
                            echo "home.php";
                        }
                        else {
                            echo "index.php";
                        }    
                    ?>">Home</a></li>
                    <li><a href="#about">About</a></li>
                    <li><a href="#contact">Contact</a></li>
                </ul>
                <p class="pull-right">Logado como <a href="#"><?php echo $user->name ?></a> | <a href="index.php?logout=true">Sair</a></p>
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
                        <h1><?php echo $title ?></h1>
                        <input type="hidden" name="id" value="<?php echo isset($_GET["id"]) ? $project->id : -1 ?>"/>
                        <p>Nome <input type="text" id="name" name="name" value="<?php echo isset($_GET["id"]) ? $project->name : ''?>"/></p>
                        <p>Descrição <textarea id="description" name="description"><?php echo isset($_GET["id"]) ? $project->description : ''?></textarea></p>
                        <input type="submit" value="Confirmar"/>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php
    }
    else {
        redirect("index.php", 0);
    }
?>
</body>
</html>

