<?php 
header("Content-Type:application/vnd.ms-excel"); 
header("Content-Disposition: attachment; filename=PREFERENCIA_DOCENTE.xls"); 
header('Cache-Control: max-age=0');
header('Cache-Control: max-age=1');
//PIf you're serving IE over SSL
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); //fecha en el pasado
header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
header('Cache-Control: cache, must-revalidate');
header('Pragma: public'); //HTTP/1.0

require_once("../modelo/pdo.php");

$obtener_prof = $pdo->prepare("SELECT profesor.idProf,nombre,noGrupos,observaciones FROM (
		profesor INNER JOIN solicitud_profesor ON profesor.idProf = solicitud_profesor.idProf)");
$obtener_prof->execute();
$obtener_uea = $pdo->prepare("SELECT nombre FROM (UEA INNER JOIN solicitud_uea ON UEA.idUEA = solicitud_uea.idUEA) WHERE solicitud_uea.idProf = :idProf");
$obtener_hor = $pdo->prepare("SELECT solicitud_horario.idHorario,horaInicio,horaFin FROM (horario INNER JOIN solicitud_horario ON horario.idHorario = solicitud_horario.idHorario) WHERE 
		solicitud_horario.idProf = :idProf AND dia = :dia");
$lun=$mar=$mier=$jue=$vie=0;
 ?>

 <meta http-equiv='Content-Type' content='text/html; charset=utf-8'/>

<table border="1">
	<thead>
		<th>NOMBRE</th>
		<th>NO. DE GRUPOS QUE DESEA IMPARTIR</th>
		<th>1ra. UEA</th>
		<th>2da. UEA</th>
		<th>3ra. UEA</th>
		<th>4ta. UEA</th>
		<th>5ta. UEA</th>
		<th>LUNES</th>
		<th>MARTES</th>
		<th>MIERCOLES</th>
		<th>JUEVES</th>
		<th>VIERNES</th>
		<th>OBSERVACIONES</th>
	</thead>
	<tbody>
		<?php while($profes = $obtener_prof->fetch(PDO::FETCH_ASSOC)){
			?> 
		<tr> <td><?php echo $profes['nombre']; ?></td>
			<td><?php echo $profes['noGrupos']; ?></td>
			<?php 
			$obtener_uea->execute([':idProf'=>$profes['idProf']]);
			$uea = $obtener_uea->fetchAll(PDO::FETCH_COLUMN);?>
			<td><?php echo $uea[0]; ?></td>
			<td><?php echo $uea[1]; ?></td>
			<td><?php echo $uea[2]; ?></td>
			<td><?php echo $uea[3]; ?></td>
			<td><?php if(isset($uea[4])) echo $uea[4]; ?></td>
			<?php 
			echo "<td>";
			$obtener_hor->execute([':idProf'=>$profes['idProf'], ':dia'=>'Lunes']);
			while($horario_lunes = $obtener_hor->fetch(PDO::FETCH_ASSOC)){
				if($horario_lunes['idHorario'] <= 45)
				echo $horario_lunes['horaInicio']." - ".$horario_lunes['horaFin'].", ";
			}
			echo "</td><td>";
			$obtener_hor->execute([':idProf'=>$profes['idProf'], ':dia'=>'Martes']);
			while($horario_martes = $obtener_hor->fetch(PDO::FETCH_ASSOC)){
				if($horario_martes['idHorario'] <= 45)
				echo $horario_martes['horaInicio']." - ".$horario_martes['horaFin'].", ";
			}
			echo "</td><td>"; 
			$obtener_hor->execute([':idProf'=>$profes['idProf'], ':dia'=>'Miércoles']);
			while($horario_mier = $obtener_hor->fetch(PDO::FETCH_ASSOC)){
				if($horario_mier['idHorario'] <= 45)
				echo $horario_mier['horaInicio']." - ".$horario_mier['horaFin'].", ";
			}
			echo "</td><td>";
			$obtener_hor->execute([':idProf'=>$profes['idProf'], ':dia'=>'Jueves']);
			while($horario_jueves = $obtener_hor->fetch(PDO::FETCH_ASSOC)){
				if($horario_jueves['idHorario'] <= 45)
				echo $horario_jueves['horaInicio']." - ".$horario_jueves['horaFin'].", ";
			}
			echo "</td><td>"; 
			$obtener_hor->execute([':idProf'=>$profes['idProf'], ':dia'=>'Viernes']);
			while($horario_viernes = $obtener_hor->fetch(PDO::FETCH_ASSOC)){
				if($horario_viernes['idHorario'] <= 45)
				echo $horario_viernes['horaInicio']." - ".$horario_viernes['horaFin'].", ";
			}
			echo "</td>"; ?>
			<td style="min-width: 10em;"><?php echo $profes['observaciones']; ?></td>
		</tr>	
		<?php } ?>
	</tbody>
</table>