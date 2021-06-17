<?php
require_once "plantilla.php";

session_start();
if (!isset($_GET['user']) || strlen($_GET['user']) < 1  || !isset($_SESSION["success"])) {
    header('Location: login.php');
    return;
}

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Inicio</title>
</head>
<body>
<a class="volver btn" href="../controlador/logout.php">Cerrar sesión</a><br>
	<div id="main-menu" class="container">
		<p id="bienvenido" class="text-center h2">Bienvenido(a)</p><br>
		<div class="row">
			<div class="col-md-6 col-sm-6 col-xs-12">
				<a href="datos.php"><div id="datos-tile"><span>Preparar la Base de Datos</span></div></a>
			</div>
			<div class="col-md-6 col-sm-6 col-xs-12">
				<a href="programacion.php"><div id="prog-tile"><span>Realizar programación docente</span></div></a>
			</div>
		</div>
	</div>
	
<!-- jQuery (Bootstrap JS plugins depend on it) -->
  <script src="js/jquery-3.5.1.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
</body>
</html>