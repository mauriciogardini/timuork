<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="content-type" content="text/html;charset=UTF-8" />    
    <title>Timuork</title>
    <meta name="description" content="Timuork">
    <meta name="author" content="Maurício Gardini">
    <link rel="stylesheet" href="/styles/bootstrap.css">
    <link rel="stylesheet" href="/styles/general.css">    
    <!--TODO Fav Icon -->
    <link rel="shortcut icon" href="images/favicon.ico">
</head>
<body>
    <div class="navbar navbar-fixed-top">
        <div class="navbar-inner">
            <div class="container">
                <a class="brand" href="/">Timuork</a>
                <ul class="nav" id="navigationLinks">
                    <li><a href="#about">About</a></li>
                    <li><a href="#contact">Contact</a></li>
                </ul>
                <p class="pull-right logged-in">Logado como 
                    <a href="#"><?php echo $user->getName() ?></a> | 
                    <a href="/logout">Sair</a>
                </p>
            </div>
        </div>
    </div>
    <?php echo $contentForLayout ?>
</body>
</html>
