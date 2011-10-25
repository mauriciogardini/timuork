<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=UTF-8" />    
    <!--TODO: Título -->
    <title>#</title>
    <meta name="description" content="Log In">
    <meta name="author" content="Maurício Gardini">
    <link rel="stylesheet" href="styles/bootstrap.min.css">
    <style type="text/css">
    </style>
</head>
<!-- Testing only -->
<?php
    require_once(dirname(__FILE__) . "/includes/session_includes.php");

    if (isset($_POST['logout']) && $_POST['logout']) {
        echo "Apaguei";
        quit_session();
    }
?>

<body>
    <div class="topbar">
        <div class="fill">
            <div class="container">
                <a class="brand" href="#">Project name</a>
                <ul class="nav">
                    <li class="active"><a href="#">Home</a></li>
                    <li><a href="#about">About</a></li>
                    <li><a href="#contact">Contact</a></li>
                </ul>
                <form action="user_authenticate.php" method="post" class="pull-right">    
                    <input class="input-small" id="username" name="username" size="30" type="text" placeholder="Username" />
                    <input class="input-small" id="password" name="password" size="30" type="password" placeholder="Password" />
                    <button class="btn">Sign In</button>
                </form>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="content" id="centered">
            <div class="row">
                <div class="span10">
                    <h2>Main content</h2>
                    Blablablablablabla
                </div>
                <div class="span6">
                    <form action="user_result.php" method="post">
                        <h3>New here? Join us today!</h3>
                        <p><input class="input-xlarge" id="unregistered_name" name="unregistered_name" size="30" type="text" placeholder="Full name" /></p>
                        <p><input class="input-xlarge" id="unregistered_email" name="unregistered_email" size="30" type="text" placeholder="E-mail" /></p>
                        <p><input class="input-xlarge" id="unregistered_username" name="unregistered_username" size="30" type="text" placeholder="Username" /></p>
                        <p><input class="input-xlarge" id="unregistered_password" name="unregistered_password" size="30" type="password" placeholder="Password" /></p>
                        <p><button class="btn">Submit</button>
                    </form>
                </div>
            </div>
        </div>
        <footer id="bottom" style="border:.2em dotted #900;">
            <p>&copy; Company 2011</p>
        </footer>
    </div>
</body>
</html>
