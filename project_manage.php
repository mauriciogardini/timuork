<html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=UTF-8" />    
</head>
<body>

<?php

require_once(dirname(__FILE__) . "/includes/project_includes.php");

if(isset($_GET["id"])) {
    $title = "Editar Projeto";
    $project = project_by_id($_GET["id"]);
}
else {
    $title = "Novo Projeto";
}
?>

<form action="project_result.php" method="post">
<h1><?php echo $title ?></h1>
<input type="hidden" name="id" value="<?php echo isset($_GET["id"]) ? $series->id : -1 ?>"/>
Nome <input type="text" id="name" name="name" value="<?php echo isset($_GET["id"]) ? $project->name : ''?>"/></br>
Descrição <input type="text" id="description" name="description" value="<?php echo isset($_GET["id"]) ? $project->description : ''?>"/></br>
<input type="submit" value="Confirmar"/>
</form>
</body>
</html>

