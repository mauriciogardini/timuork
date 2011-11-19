<!DOCTYPE html>
<html lang="en">
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
    <!-- Testing only -->
    <?php
        require_once(dirname(__FILE__) . "/includes/session_includes.php");

        if (isset($_GET['logout']) && $_GET['logout']) {
            quit_session();
        }
    ?>
    <?php
        require_once(dirname(__FILE__) . "/includes/general_includes.php");
        require_once(dirname(__FILE__) . "/includes/session_includes.php");
        if (check_session()) {
            redirect("home.php", 0);
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
                        ?>">Home</a>
                    </li>
                    <li><a href="#about">About</a></li>
                    <li><a href="#contact">Contact</a></li>
                </ul>
                <form action="user_authenticate.php" method="post" class="pull-right">    
                    <input class="input-small" id="username" name="username" size="30" type="text" placeholder="Username" />
                    <input class="input-small" id="password" name="password" size="30" type="password" placeholder="Senha" />
                    <button class="btn">Entrar</button>
                    <span class="help-block">
                        <input type="checkbox" name="remember_me" id="remember_me" value="remember_me"> Lembrar-me 
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <a href="forgot_password.php">Esqueceu sua senha?</a>
                    </span>
                </form>               
            </div>
        </div>
    </div>
    <div class="container">
        <div class="content" id="centered">
            <div class="row center">
                <div class="span14">
                    <form action="user_result.php" method="post" class="center">
                        <h3>Novo aqui? Junte-se à nós!</h3>
                        <p><input class="input-xlarge" id="unregistered_name" name="unregistered_name" size="30" type="text" placeholder="Nome completo" /></p>
                        <p><input class="input-xlarge" id="unregistered_email" name="unregistered_email" size="30" type="text" placeholder="E-mail" /></p>
                        <p><input class="input-xlarge" id="unregistered_username" name="unregistered_username" size="30" type="text" placeholder="Username" /></p>
                        <p><input class="input-xlarge" id="unregistered_password" name="unregistered_password" size="30" type="password" placeholder="Senha" /></p>
                        <p><button class="btn">Registrar</button>
                    </form>
                </div>
            </div>
        </div>
        <footer id="bottom">
            <p>&copy; Company 2011</p>
        </footer>
    </div>
</body>
</html>
