<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="content-type" content="text/html;charset=UTF-8" />    
    <title>Timuork</title>
    <meta name="description" content="Timuork">
    <meta name="author" content="Maurício Gardini">
    <link rel="stylesheet" href="/styles/bootstrap.css">
    <link rel="stylesheet" href="/styles/timuork.css">    
    <!--TODO Fav Icon -->
    <link rel="shortcut icon" href="images/favicon.ico">
</head>
<body>
    <div class="outerDiv">
        <div class="navbar navbar-fixed-top">
            <div class="navbar-inner">
                <div class="container">
                    <a class="brand" href="/">Timuork</a>
                    <ul class="nav" id="navigationLinks">
                        <li><a href="#modalAbout" data-toggle="modal">Sobre</a></li>
                        <li><a href="#contact">Contato</a></li>
                    </ul>
                    <p class="pull-right logged-in">Logado como 
                        <a data-toggle="modal" href="#modalSettings"
                        data-user-id="<?php echo $user->getId() ?>"
                        data-user-name="<?php echo $user->getName() ?>"
                        data-user-email="<?php echo $user->getEmail() ?>"
                        data-user-username="<?php echo $user->getUsername() ?>"
                        data-user-account-id="<?php echo $user->getAccountId() ?>"
                        data-user-account-type="<?php echo $user->getAccountType() ?>"
                        data-user-account-value="<?php echo $user->getAccountValue() ?>" ><?php
                            echo $user->getName() ?></a> | <a href="/logout">Sair</a>
                    </p>
                </div>
            </div>
        </div>
        <?php echo $contentForLayout ?>
    </div>
    <footer id="bottom" class="footer">
        <p>&copy; Maurício Gardini - Alguns Direitos Reservados</p> 
    </footer> 
</body>
</html>
