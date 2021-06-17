<?php
	require_once "plantilla.php";
	require_once "../modelo/pdo.php";
	session_start();
	if(!isset($_SESSION["success"])){
		header('Location: login.php');
	}
	$busca_fis="SELECT claveUEA,nombre FROM UEA WHERE idArea=2 ORDER BY nombre";
	$busca_mat="SELECT claveUEA,nombre FROM UEA WHERE idArea=1 ORDER BY nombre";
	$busca_quimica="SELECT claveUEA,nombre FROM UEA WHERE idArea=3 ORDER BY nombre";
	$busca_tronco="SELECT claveUEA,nombre FROM UEA WHERE idArea=4 ORDER BY nombre";
	
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Programación docente</title>
</head>
<body>
 <a class="volver btn" href="menu.php?user=1">Volver</a>
	<div id="main-menu" class="container">
		<div id="menu-prog" class="row">
			<p id="menu-cbi" class="text-center h3">UEA a programar</p>
			<br><br><br><br>
			<div class="col-md-6 col-sm-6 col-xs-12">
				<button class="btn" id="fisica-tile" data-toggle="collapse" type="button" data-target="#busca_fisica" aria-expanded="false" aria-controls="busca_fisica">Física</button>
				<div class="collapse" id="busca_fisica">
					<form action="uea.php" method="POST">
					<p class="prog">Seleccione la UEA a programar:   
				  	  <label>
				        <select class ="ueaSelect" name="ueaFisica">
				          <option value="0">-- Seleccionar UEA --</option>
				          <?php foreach ($pdo->query($busca_fis) as $uea): ?>
				            <option value="<?php echo $uea['claveUEA'] ?>">
				              <?php echo $uea['claveUEA']." ".$uea['nombre'] ?>
				            </option>
				          <?php endforeach ?>
				        </select> 
				      </label>
				      <input type="submit" name="fisica" value="Programar"></p>
					</form>
				</div>
			</div>
			<div class="col-md-6 col-sm-6 col-xs-12">
				<button class="btn" id="quimica-tile" data-toggle="collapse" type="button" data-target="#busca_quimica" aria-expanded="false" aria-controls="busca_quimica">Química</button>
				<div class="collapse" id="busca_quimica">
					<form action="uea.php" method="POST">
					<p class="prog">Seleccione la UEA a programar:   
				  	  <label>
				        <select class ="ueaSelect" name="ueaQuimica">
				          <option value="0">-- Seleccionar UEA --</option>
				          <?php foreach ($pdo->query($busca_quimica) as $uea): ?>
				            <option value="<?php echo $uea['claveUEA'] ?>">
				              <?php echo $uea['claveUEA']." ".$uea['nombre'] ?>
				            </option>
				          <?php endforeach ?>
				        </select> 
				      </label>
				      <input type="submit" name="quimica" value="Programar"></p>
					</form>
				</div>
			</div>
			<div class="col-md-6 col-sm-6 col-xs-12">
				<button class="btn" id="mate-tile" data-toggle="collapse" type="button" data-target="#busca_mate" aria-expanded="false" aria-controls="busca_mate">Matemáticas</button>
				<div class="collapse" id="busca_mate">
					<form action="uea.php" method="POST">
					<p class="prog">Seleccione la UEA a programar:   
				  	  <label>
				        <select class ="ueaSelect" name="ueaMate">
				          <option value="0">-- Seleccionar UEA --</option>
				          <?php foreach ($pdo->query($busca_mat) as $uea): ?>
				            <option value="<?php echo $uea['claveUEA'] ?>">
				              <?php echo $uea['claveUEA']." ".$uea['nombre'] ?>
				            </option>
				          <?php endforeach ?>
				        </select> 
				      </label>
				      <input type="submit" name="mate" value="Programar"></p>
					</form>
				</div>
			</div>
			<div class="col-md-6 col-sm-6 col-xs-12">
				<button class="btn" id="tronco-tile" data-toggle="collapse" type="button" data-target="#busca_tronco" aria-expanded="false" aria-controls="busca_tronco">Tronco Inter y Multidisciplinar</button>
				<div class="collapse" id="busca_tronco">
					<form action="uea.php" method="POST">
					<p class="prog">Seleccione la UEA a programar:   
				  	  <label>
				        <select class ="ueaSelect" name="ueaTronco">
				          <option value="0">-- Seleccionar UEA --</option>
				          <?php foreach ($pdo->query($busca_tronco) as $uea): ?>
				            <option value="<?php echo $uea['claveUEA'] ?>">
				              <?php echo $uea['claveUEA']." ".$uea['nombre'] ?>
				            </option>
				          <?php endforeach ?>
				        </select> 
				      </label>
				      <input type="submit" name="tronco" value="Programar"></p>
					</form>
				</div>
			</div>
			
		</div>
	</div>
	<br>
	<div class="container">
		<p id="menu-desc" class="text-center h3">Descargables</p>	
		<br>	
		<div class="col text-center">
			<a class="exportar" href="../controlador/generar_xls_prog.php">Generar programación .XSL</a>
		</div>
		<br><br>
		<div class="col text-center">
			<a class="exportar" href="../controlador/generar_xls_prof.php">Generar preferencia docente .XSL</a>
		</div>
	</div>

<!-- jQuery (Bootstrap JS plugins depend on it) -->
  <script src="js/jquery-3.5.1.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
</body>
</html>
