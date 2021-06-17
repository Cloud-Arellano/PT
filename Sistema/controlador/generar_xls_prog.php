<?php 
header("Content-Type:application/vnd.ms-excel; charset=utf-8"); 
header("Content-Disposition: attachment; filename=PROGRAMACION_DOCENTE.xls"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: private",false);
header("Expires: 0");
//PIf you're serving IE over SSL
header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
header('Cache-Control: cache, must-revalidate');
header('Pragma: public'); //HTTP/1.0


require_once("../modelo/pdo.php");

$obtener_grupos = $pdo->prepare("SELECT * FROM grupo");
$obtener_grupos->execute();
$obtener_uea = $pdo->prepare("SELECT * FROM UEA WHERE idUEA = :idUEA");
$obtener_horarios = $pdo->prepare("SELECT * FROM (horario 
	INNER JOIN grupo_horario ON horario.idHorario = grupo_horario.idHorario) 
	WHERE grupo_horario.idGrupo = :idGrupo");
$obtener_prof = $pdo->prepare("SELECT noEconomico,nombre FROM (profesor INNER JOIN programacion 
	ON profesor.idProf = programacion.idProf) WHERE programacion.idGrupo = :idGrupo");

$lun=$mar=$mier=$jue=$vie=0;

?>

<meta http-equiv='Content-Type' content='text/html; charset=utf-8'/>

<table border="1">
	<thead>
		<th>CLAVE</th>
		<th>UEA</th>
		<th>GRUPO</th>
		<th>CUPO</th>
		<th>LUNES_I</th>
		<th>LUNES_F</th>
		<th>MARTES_I</th>
		<th>MARTES_F</th>
		<th>MIERCOLES_I</th>
		<th>MIERCOLES_F</th>
		<th>JUEVES_I</th>
		<th>JUEVES_F</th>
		<th>VIERNES_I</th>
		<th>VIERNES_F</th>
		<th>NO. ECO.</th>
		<th>PROFESOR PROPUESTO</th>
		<th>OBSERVACIONES JEFES DE DEPARTAMENTO</th>
	</thead>
	<tbody>
		<?php while($grupos = $obtener_grupos->fetch(PDO::FETCH_ASSOC)){
			$obtener_uea->execute([':idUEA'=>$grupos['idUEA']]);
			$uea = $obtener_uea->fetch(PDO::FETCH_ASSOC); 
			$obtener_prof->execute([':idGrupo'=>$grupos['idGrupo']]);
			$prof = $obtener_prof->fetch(PDO::FETCH_ASSOC);?> 
		<tr> 
			<td><?php echo $uea['claveUEA']; ?></td>
			<td><?php echo $uea['nombre']; ?></td>
			<td><?php echo $grupos['claveGrupo']; ?></td>
			<td><?php echo $grupos['cupo']; ?></td>
			<?php 
			$obtener_horarios->execute([':idGrupo'=>$grupos['idGrupo']]); 
			while($horario = $obtener_horarios->fetch(PDO::FETCH_ASSOC)){ 
				if($horario['dia']=='Lunes'){
					echo "<td>".$horario['horaInicio']."</td><td>".$horario['horaFin']."</td>";
					$lun++;
				} 
				else if($horario['dia']=='Martes'){
					if($lun!=0){
						echo "<td>".$horario['horaInicio']."</td><td>".$horario['horaFin']."</td>";
						$mar++;
					}
					else{
						echo "<td></td><td></td><td>".$horario['horaInicio']."</td><td>".$horario['horaFin']."</td>";
						$mar++;
					}
				} 
				else if($horario['dia']=='Miércoles'){
					if($mar!=0){
						echo "<td>".$horario['horaInicio']."</td><td>".$horario['horaFin']."</td>";
						$mier++;
					}
					else if($lun!=0 && $mar==0){
						echo "<td></td><td></td><td>".$horario['horaInicio']."</td><td>".$horario['horaFin']."</td>";
						$mier++;
					}
					else{
						echo "<td></td><td></td><td></td><td></td><td>".$horario['horaInicio']."</td><td>".$horario['horaFin']."</td>";
						$mier++;
					}
				} 
				else if($horario['dia']=='Jueves'){
					if($mier!=0){
						echo "<td>".$horario['horaInicio']."</td><td>".$horario['horaFin']."</td>";
						$jue++;
					}
					else if($mar!=0 && $mier==0){
						echo "<td></td><td></td><td>".$horario['horaInicio']."</td><td>".$horario['horaFin']."</td>";
						$jue++;
					}
					else{
						echo "<td></td><td></td><td></td><td></td><td></td><td></td><td>".$horario['horaInicio']."</td><td>".$horario['horaFin']."</td>";
						$jue++;
					}
				} 
				else if($horario['dia']=='Viernes'){
					if($jue!=0){
						echo "<td>".$horario['horaInicio']."</td><td>".$horario['horaFin']."</td>";
						$vie++;
					}
					else if($mier!=0){
						echo "<td></td><td></td><td>".$horario['horaInicio']."</td><td>".$horario['horaFin']."</td>";
						$vie++;
					}
					else{
						echo "<td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td>".$horario['horaInicio']."</td><td>".$horario['horaFin']."</td>";
						$vie++;
					}
				} 
			}
			if($vie!=0){
				echo '<td>';
				if(isset($prof['noEconomico'])){
					echo $prof['noEconomico'].'</td><td>'.$prof['nombre'];
				} else {
					echo '</td><td>';
				}
				echo '</td>';
			}
			else if($jue!=0){
				echo '<td></td><td></td><td>';
				if(isset($prof['noEconomico'])){
					echo $prof['noEconomico'].'</td><td>'.$prof['nombre'];
				} else {
					echo '</td><td>';
				}
				echo '</td>';
			}
			else if($mier!=0){
				echo '<td></td><td></td><td></td><td></td><td>';
				if(isset($prof['noEconomico'])){
					echo $prof['noEconomico'].'</td><td>'.$prof['nombre'];
				} else {
					echo '</td><td>';
				}
				echo '</td>';
			}
			else if($mar!=0){
				echo '<td></td><td></td><td></td><td></td><td></td><td></td><td>';
				if(isset($prof['noEconomico'])){
					echo $prof['noEconomico'].'</td><td>'.$prof['nombre'];
				} else {
					echo '</td><td>';
				}
				echo '</td>';
			}
			else if($lun!=0){
				echo '<td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td>';
				if(isset($prof['noEconomico'])){
					echo $prof['noEconomico'].'</td><td>'.$prof['nombre'];
				} else {
					echo '</td><td>';
				}
				echo '</td>';
			} 
			else {
				echo '<td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>';
			}
			$lun=$mar=$mier=$jue=$vie=0; ?>
			<td></td>
		</tr>	
		<?php } ?>
	</tbody>
</table>
