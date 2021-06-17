<?php
require_once "../modelo/pdo.php";
require_once "plantilla.php";

$idProf = $_GET["id"];

//sentencia para obtener los datos del profesor
$obtener_datos = $pdo->prepare("SELECT * FROM Profesor WHERE idProf = :idProf");
$obtener_datos->execute([':idProf'=>$idProf]);
$datos = $obtener_datos->fetch(PDO::FETCH_ASSOC);
//sentencia para obtener noGrupos y observaciones
$obtener_sol = $pdo->prepare("SELECT * FROM Solicitud_profesor WHERE idProf = :idProf");
$obtener_sol->execute([':idProf'=>$idProf]);
$solicitud = $obtener_sol->fetch(PDO::FETCH_ASSOC);
//sentencia para obtener UEA solicitadas
$obtener_uea = $pdo->prepare("SELECT uea.nombre FROM (solicitud_uea INNER JOIN uea ON solicitud_uea.idUEA = uea.idUEA) WHERE solicitud_uea.idProf = :idProf");
$obtener_uea->execute([':idProf'=>$idProf]);
$uea = $obtener_uea->fetchAll(PDO::FETCH_COLUMN);
$uea4 = isset($uea[4]) ? $uea[4] : '';
//sentencia para obtener horarios solicitados
$obtener_horarios = $pdo->prepare("SELECT Horario.idHorario,horaInicio,horaFin FROM (horario INNER JOIN solicitud_horario ON Horario.idHorario = solicitud_horario.idHorario) WHERE solicitud_horario.idProf = :idProf AND dia = :dia");

?>

<!DOCTYPE html>
<html>
<head>
	<title>Preferencia Docente</title>
</head>
<body>


  <div id="contenedor-docente" class="container">
    <div class="jumbotron" id="docentes">
      <p class="text-center h2"><strong>Preferencia Docente</strong></p><br>
      <p><b>Nombre: </b><?php echo $datos['nombre']; ?></p>
      <p><b>Número de grupos: </b><?php echo $solicitud['noGrupos']; ?><br></p>
      <!-- Selección de UEA -->
      <p><b>UEA seleccionadas</b></p>
  	  <p><b>1ra UEA:</b> <?php if(isset($uea[0])) echo $uea[0]; ?></p>
  	  <p><b>2da UEA:</b> <?php if(isset($uea[1])) echo $uea[1]; ?></p>
  	  <p><b>3ra UEA:</b> <?php if(isset($uea[2])) echo $uea[2]; ?></p>
  	  <p><b>4ta UEA:</b> <?php if(isset($uea[3])) echo $uea[3]; ?></p>
  	  <p><b>5ta UEA:</b> <?php echo $uea4; ?></p><br>
  	  <p><b>Horarios seleccionados</b></p>
  	  <!-- Tabla de horarios -->
      <div id="hora-semana" class="container">
      <table id="horarios" class="table-bordered">
        <tr>
        	<th>Lunes</th>
        	<td>
        	<?php 
        	$obtener_horarios->execute([':idProf'=>$idProf, ':dia'=>'Lunes']);
			while($horario_lunes = $obtener_horarios->fetch(PDO::FETCH_ASSOC)){
				if($horario_lunes['idHorario'] <= 45)
				echo $horario_lunes['horaInicio']." - ".$horario_lunes['horaFin'].", ";
			}
        	 ?>
        	</td>
        </tr>
        <tr>
        	<th>Martes</th>
        	<td>
        	<?php 
        	$obtener_horarios->execute([':idProf'=>$idProf, ':dia'=>'Martes']);
			while($martes = $obtener_horarios->fetch(PDO::FETCH_ASSOC)){
				if($martes['idHorario'] <= 45)
				echo $martes['horaInicio']." - ".$martes['horaFin'].", ";
			}
        	 ?>
        	</td>
        </tr>
        <tr>
        	<th>Miércoles</th>
        	<td>
        	<?php 
        	$obtener_horarios->execute([':idProf'=>$idProf, ':dia'=>'Miércoles']);
			while($miercoles = $obtener_horarios->fetch(PDO::FETCH_ASSOC)){
				if($miercoles['idHorario'] <= 45)
				echo $miercoles['horaInicio']." - ".$miercoles['horaFin'].", ";
			}
        	 ?>
        	</td>
        </tr>
        <tr>
        	<th>Jueves</th>
        	<td>
        	<?php 
        	$obtener_horarios->execute([':idProf'=>$idProf, ':dia'=>'Jueves']);
			while($jueves = $obtener_horarios->fetch(PDO::FETCH_ASSOC)){
				if($jueves['idHorario'] <= 45)
				echo $jueves['horaInicio']." - ".$jueves['horaFin'].", ";
			}
        	 ?>
        	</td>
        </tr>
        <tr>
        	<th>Viernes</th>
        	<td>
        	<?php 
        	$obtener_horarios->execute([':idProf'=>$idProf, ':dia'=>'Viernes']);
			while($viernes = $obtener_horarios->fetch(PDO::FETCH_ASSOC)){
				if($viernes['idHorario'] <= 45)
				echo $viernes['horaInicio']." - ".$viernes['horaFin'].", ";
			}
        	 ?>
        	</td>
        </tr>
      </table>
      </div>
      <br>
  	  <p><b>Observaciones: </b><?php echo $solicitud['observaciones']; ?></p><br>
  	  
    </div>
  </div>


</body>
</html>
