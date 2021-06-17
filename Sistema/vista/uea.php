<?php
require_once "plantilla.php";
require_once "../modelo/pdo.php";
require_once "../modelo/funciones.php";

session_start();
if(!isset($_SESSION["success"])){
		header('Location: login.php');
}

if(isset($_POST["ueaQuimica"])){
	$claveUEA = $_POST["ueaQuimica"];
} else if(isset($_POST["ueaFisica"])){
	$claveUEA = $_POST["ueaFisica"];
} else if(isset($_POST["ueaMate"])){
	$claveUEA = $_POST["ueaMate"];
} else if(isset($_POST["ueaTronco"])){
	$claveUEA = $_POST["ueaTronco"];
}
/***********   TODAS LAS FUNCIONES ESTÁN DEFINIDAS EN MODELO/FUNCIONES.PHP *******/
//obtener idUEA y nombre de la UEA a partir de su clave
$result_uea = obtener_uea($claveUEA);
$idUEA = $result_uea->idUEA;
$nombreUEA = $result_uea->nombre;
//crear vista horario_uea que junta los grupos con sus horarios según la UEA y nos
//permite organizar y crear la tabla de horarios que se desplegará
vista_horario_uea($idUEA);
//obtener los grupos a partir de su hora de inicio
$obtener_grupo = $pdo->prepare("SELECT idGrupo, claveGrupo FROM horario_uea ORDER BY horaInicio");
$obtener_grupo->execute();
//preparar la sentencia para recuperar los horarios de cada grupo
$obtener_hor = $pdo->prepare("SELECT idHorario,dia, horaInicio, horaFin FROM horario_uea WHERE idGrupo = :idGrupo");
//Para obtener profesores (idProf) interesados en la UEA y la prioridad en que la pusieron 
$profesores = obtener_profesor($idUEA);
//array de uea programadas por profesor
$prof_uea=[];
//array que contendrá horarios de clase y traslapados por cada profesor
$prof_traslape=[];
$i=$m=1; //llevará la posición del arreglo idGrupo
$j=0; //llevará la posición del arreglo idHorario
$n=0;
$lun=$mar=$mier=$jue=$vie=0; //banderas para saber en qué columna posicionar los horarios.
$idGrupo=[]; //guarda los idGrupo conforme fueron listados
//idHorario guarda la relación de (número de grupo) con todos los idHorario de ese grupo
//Por ejemplo: Array([1]=>Array([0]=>7 [1]=>9)) significa que el grupo 1 se imparte en los horarios 7 y 9.
$idHorario=[];
$nombre_id_prof=[]; //variable que guardará una relación entre el idProf y nombre del profesor
$prof_row=[]; //variable que guardará el id de los profesores según su fila

?>

<!DOCTYPE html>
<html>
<head>
	<title>UEA</title>
</head>
<body>

	<script type="text/javascript">
    	//función que definirá objetos del tipo 'seleccion' para guardar los drops que se han hecho (idGrupo, idProf)
		function seleccion(grupo, idProf) {
		  this.grupo = grupo;
		  this.idProf = idProf;
		}
		//array de objetos tipo 'seleccion' que guardará los drops que se han hecho
		var seleccion_actual = new Array(seleccion_actual);
		console.log(seleccion_actual);
		var v = 0; //variable que llevará las posiciones del array de objetos seleccion
    </script>

	<a class="volver btn" href="programacion.php">Volver</a>
  	<p class="text-center h4 titles"><?php echo $claveUEA." - ".$nombreUEA ?></p>

	<div id="alert-uea" class="alert alert-info" role="alert">
    </div>

	<div id="hor-qui" >
		<table class="table-striped table-responsive" id="prog-qui">
			<thead>
				<tr class="">
					<th class="td-horario text-center">Grupo</th>
					<th class="td-horario text-center">Lunes</th>
					<th class="td-horario text-center">Martes</th>
					<th class="td-horario text-center">Miércoles</th>
					<th class="td-horario text-center">Jueves</th>
					<th class="td-horario text-center">Viernes</th>
					<th class="td-horario text-center">Profesor</th>
					<th class="td-espacio"></th>
					<th class="prioridad text-center">1ra opción</th>
					<th class="prioridad text-center">2da opción</th>
					<th class="prioridad text-center">3ra opción</th>
					<th class="prioridad text-center">4ta opción</th>
					<th class="prioridad text-center">5ta opción</th>
				</tr>
			</thead>
			<tbody>
				<?php while($result_grupo = $obtener_grupo->fetch(PDO::FETCH_ASSOC)){
						if(!in_array($result_grupo['idGrupo'],$idGrupo)){
							$idGrupo[$i] = $result_grupo['idGrupo'];
							$obtener_hor->execute([':idGrupo'=>$idGrupo[$i]]);?>
					<tr>
						<td class="td-horario text-center"><?php echo $result_grupo['claveGrupo']; ?></td>
						<?php while($horario = $obtener_hor->fetch(PDO::FETCH_ASSOC)){ 
							if($horario['dia']=='Lunes'){
								echo "<td class='td-horario text-center'>".$horario['horaInicio']."<br>".$horario['horaFin']."</td>";
								$lun++;	
								$idHorario[$i][$j]=$horario['idHorario']; $j++;
							} 
							else if($horario['dia']=='Martes'){
								if($lun!=0){
									echo "<td class='td-horario text-center'>".$horario['horaInicio']."<br>".$horario['horaFin']."</td>";
									$mar++;
									$idHorario[$i][$j]=$horario['idHorario']; $j++;
								}
								else{
									echo "<td class='td-horario'></td><td class='td-horario text-center'>".$horario['horaInicio']."<br>".$horario['horaFin']."</td>";
									$mar++;
									$idHorario[$i][$j]=$horario['idHorario']; $j++;
								}
							} 
							else if($horario['dia']=='Miércoles'){
								if($mar!=0){
									echo "<td class='td-horario text-center'>".$horario['horaInicio']."<br>".$horario['horaFin']."</td>";
									$mier++;
									$idHorario[$i][$j]=$horario['idHorario']; $j++;
								}
								else if($lun!=0 && $mar==0){
									echo "<td class='td-horario'></td><td class='td-horario text-center'>".$horario['horaInicio']."<br>".$horario['horaFin']."</td>";
									$mier++;
									$idHorario[$i][$j]=$horario['idHorario']; $j++;
								}
								else{
									echo "<td class='td-horario'></td><td class='td-horario'></td><td class='td-horario text-center'>".$horario['horaInicio']."<br>".$horario['horaFin']."</td>";
									$mier++;
									$idHorario[$i][$j]=$horario['idHorario']; $j++;
								}
							} 
							else if($horario['dia']=='Jueves'){
								if($mier!=0){
									echo "<td class='td-horario text-center'>".$horario['horaInicio']."<br>".$horario['horaFin']."</td>";
									$jue++;
									$idHorario[$i][$j]=$horario['idHorario']; $j++;
								}
								else if($mar!=0 && $mier==0){
									echo "<td class='td-horario'></td><td class='td-horario text-center'>".$horario['horaInicio']."<br>".$horario['horaFin']."</td>";
									$jue++;
									$idHorario[$i][$j]=$horario['idHorario']; $j++;
								}
								else{
									echo "<td class='td-horario'></td><td class='td-horario'></td><td class='td-horario'></td><td class='td-horario text-center'>".$horario['horaInicio']."<br>".$horario['horaFin']."</td>";
									$jue++;
									$idHorario[$i][$j]=$horario['idHorario']; $j++;
								}
							} 
							else if($horario['dia']=='Viernes'){
								if($jue!=0){
									echo "<td class='td-horario text-center'>".$horario['horaInicio']."<br>".$horario['horaFin']."</td>";
									$vie++;
									$idHorario[$i][$j]=$horario['idHorario']; $j++;
								}
								else if($mier!=0){
									echo "<td class='td-horario'></td><td class='td-horario text-center'>".$horario['horaInicio']."<br>".$horario['horaFin']."</td>";
									$vie++;
									$idHorario[$i][$j]=$horario['idHorario']; $j++;
								}
								else{
									echo "<td class='td-horario'></td><td class='td-horario'></td><td class='td-horario'></td><td class='td-horario'></td><td class='td-horario text-center'>".$horario['horaInicio']."<br>".$horario['horaFin']."</td>";
									$vie++;
									$idHorario[$i][$j]=$horario['idHorario']; $j++;
								}
							} 
							}
							if($vie!=0){
								echo '<td class="td-horario" id="'.$i.'">
								<div id ="'.$idGrupo[$i].'" class="div-grupo"></div>
								</td><td class="td-espacio"></td>';
							}
							else if($jue!=0){
								echo '<td class="td-horario"></td>
								<td class="td-horario" id="'.$i.'">
								<div id ="'.$idGrupo[$i].'" class="div-grupo"></div>
								</td><td class="td-espacio"></td>';
							}
							else if($mier!=0){
								echo '<td class="td-horario"></td><td class="td-horario"></td><td class="td-horario" id="'.$i.'">
									<div id ="'.$idGrupo[$i].'" class="div-grupo"></div>
									</td><td class="td-espacio"></td>';
							}
							else if($mar!=0){
								echo '<td class="td-horario"></td><td class="td-horario"></td><td class="td-horario"></td><td class="td-horario" id="'.$i.'">
									<div id ="'.$idGrupo[$i].'" class="div-grupo"></div>
									</td><td class="td-espacio"></td>';	
							}
							else if($lun!=0){
								echo '<td class="td-horario"></td><td class="td-horario"></td><td class="td-horario"></td><td class="td-horario"></td><td class="td-horario" id="'.$i.'">
									<div id ="'.$idGrupo[$i].'" class="div-grupo"></div>
									</td><td class="td-espacio"></td>';	
							}
							//echo '<td><div id="'.$idGrupo[$i].'">'.$idGrupo[$i].'</div></td>';
							$i++;$lun=$mar=$mier=$jue=$vie=0;$j=0;

							while ($m<=count($idGrupo)){
								$n=0;
						?>
						<td class="td-docentes">
							<div id="<?php echo $m.'_prior_1' ?>" class="div_doc">
							<?php  
							if(isset($profesores) && isset($profesores[1])){
								$nombre_id_uno = obtenerProfesores(1,$m,$profesores,$idHorario);
								if($nombre_id_uno){
									foreach ($nombre_id_uno as $valor) { ?>
									<div draggable="true" class="div-prior div-prior-Uno" id="<?php echo $m.'_'.$n?>" data-id="<?php echo $valor['id'] ?>" data-prior="1">
										<button type="button" class="btn div-prior-Uno" onclick="obs(<?php echo $valor['noGrupos'].",'".$valor['obs']."','".$valor['uea'][0]."','".$valor['uea'][1]."','".$valor['uea'][2]."','".$valor['uea'][3]."','";if(isset($valor['uea'][4])){ echo $valor['uea'][4];} echo"'"?>)"><?php echo $valor['nombre'];?></button>
									</div> <?php
									$prog = obtener_programacion($idGrupo[$m]);
									if(isset($prog[0]) && $prog[0] === $valor['id']){?>
										<script type="text/javascript">
											var div = document.getElementById(<?php echo $idGrupo[$m]?>);
											var grup = "<?php echo $m;?>";
											var idP = "<?php echo $valor['id'];?>";
											if(!div.hasChildNodes()){
												seleccion_actual[v] = new seleccion(grup,idP);
		        								v++;
												div.appendChild(document.getElementById('<?php echo $m.'_'.$n;?>'));
											}
											console.log(seleccion_actual);
										</script>
									<?php  
									} $prof_row[$m][$n]=$valor['id']; $n++;
								 }
								}
							} ?>
							</div>
						</td>
						<td class="td-docentes">
							<div id="<?php echo $m.'_prior_2' ?>" class="div_doc">
							<?php  if(isset($profesores) && isset($profesores[2])){
								$nombre_id_dos = obtenerProfesores(2,$m,$profesores,$idHorario);
								if($nombre_id_dos){
									foreach ($nombre_id_dos as $valor) { ?>
									<div draggable="true" class="div-prior div-prior-Dos" id="<?php echo $m.'_'.$n?>" data-id="<?php echo $valor['id'] ?>" data-prior="2">
										<button type="button" class="btn div-prior-Dos" onclick="obs(<?php echo $valor['noGrupos'].",'".$valor['obs']."','".$valor['uea'][0]."','".$valor['uea'][1]."','".$valor['uea'][2]."','".$valor['uea'][3]."','";if(isset($valor['uea'][4])){ echo $valor['uea'][4];} echo"'"?>)"><?php echo $valor['nombre'];?></button>
										</div> <?php
									$prog = obtener_programacion($idGrupo[$m]);
									if(isset($prog[0]) && $prog[0] === $valor['id']){?>
										<script type="text/javascript">
											var div = document.getElementById(<?php echo $idGrupo[$m]?>);
											var grup = "<?php echo $m;?>";
											var idP = "<?php echo $valor['id'];?>";
											if(!div.hasChildNodes()){
												seleccion_actual[v] = new seleccion(grup,idP);
		        								v++;
												div.appendChild(document.getElementById('<?php echo $m.'_'.$n;?>'));
											}
											console.log(seleccion_actual);
										</script>
									<?php  
									} $prof_row[$m][$n]=$valor['id']; $n++;
								 	}
								}	
							}?>
							</div>
						</td>
						<td class="td-docentes">
							<div id="<?php echo $m.'_prior_3' ?>" class="div_doc">
							<?php  if(isset($profesores) && isset($profesores[3])){
							$nombre_id_tres = obtenerProfesores(3,$m,$profesores,$idHorario);
							if($nombre_id_tres){
								foreach ($nombre_id_tres as $valor) { ?>
								<div draggable="true" class="div-prior div-prior-tres" id="<?php echo $m.'_'.$n?>" data-id="<?php echo $valor['id'] ?>" data-prior="3">
									<button type="button" class="btn div-prior-tres" onclick="obs(<?php echo $valor['noGrupos'].",'".$valor['obs']."','".$valor['uea'][0]."','".$valor['uea'][1]."','".$valor['uea'][2]."','".$valor['uea'][3]."','";if(isset($valor['uea'][4])){ echo $valor['uea'][4];} echo"'"?>)"><?php echo $valor['nombre'];?></button>
								</div> <?php
								$prog = obtener_programacion($idGrupo[$m]);
								if(isset($prog[0]) && $prog[0] === $valor['id']){?>
									<script type="text/javascript">
										var div = document.getElementById(<?php echo $idGrupo[$m]?>);
										var grup = "<?php echo $m;?>";
										var idP = "<?php echo $valor['id'];?>";
										if(!div.hasChildNodes()){
											seleccion_actual[v] = new seleccion(grup,idP);
		        							v++;
											div.appendChild(document.getElementById('<?php echo $m.'_'.$n;?>'));
										}
										console.log(seleccion_actual);
									</script>
								<?php }  $prof_row[$m][$n]=$valor['id']; $n++;
								} 		
							} }?>
							</div>
						</td>
						<td class="td-docentes">
							<div id="<?php echo $m.'_prior_4' ?>" class="div_doc">
							<?php  if(isset($profesores) && isset($profesores[4])){
							$nombre_id_cuatro = obtenerProfesores(4,$m,$profesores,$idHorario);
							if($nombre_id_cuatro){
								foreach ($nombre_id_cuatro as $valor) { ?>
								<div draggable="true" class="div-prior div-prior-cuatro" id="<?php echo $m.'_'.$n?>" data-id="<?php echo $valor['id'] ?>" data-prior="4">
									<button type="button" class="btn div-prior-cuatro" onclick="obs(<?php echo $valor['noGrupos'].",'".$valor['obs']."','".$valor['uea'][0]."','".$valor['uea'][1]."','".$valor['uea'][2]."','".$valor['uea'][3]."','";if(isset($valor['uea'][4])){ echo $valor['uea'][4];} echo"'"?>)"><?php echo $valor['nombre'];?></button>
								</div> <?php
								$prog = obtener_programacion($idGrupo[$m]);
								if(isset($prog[0]) && $prog[0] === $valor['id']){?>
									<script type="text/javascript">
										var div = document.getElementById(<?php echo $idGrupo[$m]?>);
										var grup = "<?php echo $m;?>";
										var idP = "<?php echo $valor['id'];?>";
										if(!div.hasChildNodes()){
											seleccion_actual[v] = new seleccion(grup,idP);
		        							v++;
											div.appendChild(document.getElementById('<?php echo $m.'_'.$n;?>'));
										}
										console.log(seleccion_actual);
										</script>
								<?php } $prof_row[$m][$n]=$valor['id']; $n++;
								} 		
							} }?>
							</div>
						</td>
						<td class="td-docentes">
							<div id="<?php echo $m.'_prior_5' ?>" class="div_doc">
							<?php  if(isset($profesores) && isset($profesores[5])){
							$nombre_id_cinco = obtenerProfesores(5,$m,$profesores,$idHorario);
							if($nombre_id_cinco){
								foreach ($nombre_id_cinco as $valor) { ?>
								<div draggable="true" class="div-prior div-prior-cuatro" id="<?php echo $m.'_'.$n?>" data-id="<?php echo $valor['id'] ?>" data-prior="5">
									<button type="button" class="btn div-prior-cuatro" onclick="obs(<?php echo $valor['noGrupos'].",'".$valor['obs']."','".$valor['uea'][0]."','".$valor['uea'][1]."','".$valor['uea'][2]."','".$valor['uea'][3]."','";if(isset($valor['uea'][4])){ echo $valor['uea'][4];} echo"'"?>)"><?php echo $valor['nombre'];?></button>
								</div> <?php
								$prog = obtener_programacion($idGrupo[$m]);
								if(isset($prog[0]) && $prog[0] === $valor['id']){?>
									<script type="text/javascript">
										var div = document.getElementById(<?php echo $idGrupo[$m]?>);
										//console.log("<?php echo $idGrupo[$m];?>");
										//console.log("<?php echo $m.'_'.$n;?>");
										var grup = "<?php echo $m;?>";
										var idP = "<?php echo $valor['id'];?>";
										if(!div.hasChildNodes()){
											seleccion_actual[v] = new seleccion(grup,idP);
		        							v++;
											div.appendChild(document.getElementById('<?php echo $m.'_'.$n;?>'));
										}
										console.log(seleccion_actual);
									</script>
								<?php } $prof_row[$m][$n]=$valor['id']; $n++;
								} 
							} } ?>
							</div>
							<?php $m++;	
							}
							}
						}?>	
							
						</td>
					</tr>
				</tbody>
			</table>
	</div>

	<div class="text-center col-auto p-5">
		<button type="button" class="btn btn-guardar" onclick="guardarSeleccion()">Guardar</button>
	</div>

	<div class="col-auto" onclick="ver_docentes()">
		<p class="doc-interesados">Haga click para ver todos los docentes interesados en la UEA.</p>	
		<div id="doc-interesados">
			<table class="table-striped table-responsive">
				<thead>
					<tr>
						<th>noEco</th>
						<th>Nombre</th>
						<th>Lunes</th>
						<th>Martes</th>
						<th>Miércoles</th>
						<th>Jueves</th>
						<th>Viernes</th>
					</tr>
				</thead>
				<tbody>
					<?php $obtener_total_prof=obtener_total_prof($idUEA);
					while($profes = $obtener_total_prof->fetch(PDO::FETCH_ASSOC)) {?>
						<tr>
							<td><?php echo $profes['noEconomico'] ?></td>
							<td><?php echo $profes['nombre'] ?></td>
							<?php $obtener_total_hor = obtener_total_hor('Lunes', $profes['idProf']);
							echo "<td>";
							while($lunes = $obtener_total_hor->fetch(PDO::FETCH_ASSOC)) {?>
							<?php if($lunes['idHorario']<=45) echo $lunes['horaInicio']." - ".$lunes['horaFin'].", "; ?>
						<?php } echo "</td>";
							$obtener_total_hor = obtener_total_hor('Martes', $profes['idProf']);
							echo "<td>"; 
							while($martes = $obtener_total_hor->fetch(PDO::FETCH_ASSOC)){
							?>
							<?php if($martes['idHorario']<=45) echo $martes['horaInicio']." - ".$martes['horaFin'].", "; ?>
						<?php } echo "</td>";
							$obtener_total_hor=obtener_total_hor('Miércoles', $profes['idProf']);
							echo "<td>"; 
							while($mier = $obtener_total_hor->fetch(PDO::FETCH_ASSOC)) {?>
							<?php if($mier['idHorario']<=45) echo $mier['horaInicio']." - ".$mier['horaFin'].", "; ?>
							<?php } echo "</td>";
							$obtener_total_hor=obtener_total_hor('Jueves',$profes['idProf']);
							echo "<td>"; 
							while($jueves = $obtener_total_hor->fetch(PDO::FETCH_ASSOC)){?>
							<?php if($jueves['idHorario']<=45) echo $jueves['horaInicio']." - ".$jueves['horaFin'].", "; ?>
							<?php } echo "</td>";
							$obtener_total_hor=obtener_total_hor('Viernes', $profes['idProf']); 
							echo "<td>";
							while($viernes = $obtener_total_hor->fetch(PDO::FETCH_ASSOC)){?>
							<?php if($viernes['idHorario']<=45) echo $viernes['horaInicio']." - ".$viernes['horaFin'].", "; ?>
							<?php } echo "</td>"; ?>
						</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
	</div> <br>

	<!-- Los siguientes print_r de arrays sirvieron para monitorear que los datos 
		desplegados fueran correctos, los dejaré comentados para futuras consultas,
		testing o para el desarrollo de la versión 2.0-->
	<!--<br>
	<p><?php echo "idGrupo<br>"; print_r($idGrupo) ?></p><br>
				<p><?php if($idHorario) {
						echo "idHorario<br>";
						print_r($idHorario);
					}?></p>
	<p><?php echo "<br>(profesores) Profesores según la prioridad de la UEA <br>";
			print_r($profesores);?> -->
		<?php
		//una vez recuperados a los profesores compatibles con la UEA y cada grupo (en 
		// array $profesores), se crea el arreglo $prof_traslape para verificar si el 	//docente ya se encuentra programado en algún grupo de otra UEA. 
		if(isset($profesores) && count($idGrupo)!=0){
			$prof_uea = profesor_uea($profesores);
			$prof_traslape = profesor_traslape($profesores);
		}
		//print_r($prof_traslape);
		/*echo "<br><br>prof_uea<br>";
		print_r($prof_uea);	
		echo "<br><br>prof_traslape<br>";
		print_r($prof_traslape);
		echo "<br><br>prof_row<br>";
		print_r($prof_row);	*/							
		?>
	<!--</p>-->

</body>
</html>

<script type="text/javascript">

//ocultar div de alertas
var alerta = document.getElementById('alert-uea');
alerta.style.display = "none";	
 
var doc_interesados = document.getElementById('doc-interesados');
doc_interesados.style.display = "none";
//función que despliega el alert con el noGrupos y observaciones del profesor
//al que se le de click
function obs(grupos,obs,uea1,uea2,uea3,uea4,uea5){
	var grupos = grupos;
	var obs = obs;
	var uea1 = uea1;
	var uea2 = uea2;
	var uea3 = uea3;
	var uea4 = uea4;
	var uea5 = uea5;
	alert("No. Grupos: "+grupos+"\nObservaciones: "+obs+"\nUEA solicitadas: "+uea1+
		". "+uea2+". "+uea3+". "+uea4+". "+uea5);
}
  
//recuperar los td de los profesores y darles un div y dataset igual al id del grupo
//obtener_idGrupo arreglo que contiene el arreglo idGrupo: 1=>idGrupo1, 2=>idGrupo2, etc.
var obtener_idGrupo = JSON.parse('<?php echo json_encode($idGrupo); ?>');
console.log(obtener_idGrupo);
var noGrupos = Object.keys(obtener_idGrupo).length; //cantidad de grupos
console.log("No. de grupos: "+noGrupos);
//arreglo que está ligado a los td y div de c/grupo
var grupos = new Array(noGrupos); 

//recuperar los id de los docentes que pueden impartir cada grupo (ids por grupo)
var docentes_por_grupo = new Array(docentes_por_grupo);
docentes_por_grupo = JSON.parse('<?php echo json_encode($prof_row); ?>');
console.log('docentes_por_grupo');
console.log(docentes_por_grupo);
//arreglo que está ligado a los div de c/docente
var docentes = new Array(docentes); 

//recuperar el array idHorario
var obtener_idHorario = JSON.parse('<?php echo json_encode($idHorario); ?>');
console.log('obtener_idHorario');
console.log(obtener_idHorario);
//console.log(obtener_idHorario[1]);

//recuperar el array prof_traslape que contiene los horarios a los que han sido asignados 
//cada profesor que está interesado en la uea y los horarios con los que se traslaparía
var hor_prof_traslape = JSON.parse('<?php echo json_encode($prof_traslape); ?>');
console.log('hor_prof_traslape');
console.log(hor_prof_traslape);

//recuperar el array prof_uea que contiene las UEA a las que ha sido asignado 
//cada profesor que está interesado en la uea
var uea_prof_programado = JSON.parse('<?php echo json_encode($prof_uea); ?>');
console.log('uea_prof_programado');
console.log(uea_prof_programado);
//console.log(obtener_idHorario[1]);

//revisar si hay docentes interesados en la UEA
if(Object.entries(docentes_por_grupo).length === 0){
    alerta.style.display = "block";
    alerta.innerHTML = "No hay docentes que coincidan con los horarios para impartir esta UEA.";
    if(noGrupos==0)
    	alerta.innerHTML += "<br>No hay grupos programados para esta UEA.";
} else {
	for(let i = 1; i<=noGrupos; i++){
	  	if(docentes_por_grupo[i] !== undefined){
	  		for(let j=0; j<docentes_por_grupo[i].length; j++){
			  	var idDoc = i+'_'+j;
			  	//console.log("idDivDoc: "+idDoc);
			  	docentes[i] = document.getElementById(idDoc);
			  	docentes[i].addEventListener('dragstart', e => {
			  		e.dataTransfer.setData('id', e.target.id);
			  		e.dataTransfer.setData('idProf', e.target.dataset.id);
			  		e.dataTransfer.setData('prior', e.target.dataset.prior);
			  	});
			  }
		}
	  }
}

//crear eventos para los div que contienen los div de docentes
//arreglos que están ligados a los div que contienen los div de docentes, según prioridad
var div_prior_uno = new Array(div_prior_uno);
var div_prior_dos = new Array(div_prior_dos);
var div_prior_tres = new Array(div_prior_tres);
var div_prior_cuatro = new Array(div_prior_cuatro); 
var div_prior_cinco = new Array(div_prior_cinco); 

for(let i = 1; i <= noGrupos; i++){
  //recuperar divs de prioridad por priodidad
  div_prior_uno[i] = document.getElementById(i+'_prior_1');
  div_prior_dos[i] = document.getElementById(i+'_prior_2');
  div_prior_tres[i] = document.getElementById(i+'_prior_3');
  div_prior_cuatro[i] = document.getElementById(i+'_prior_4');
  div_prior_cinco[i] = document.getElementById(i+'_prior_5');

  //agregar eventos a los div de grupos.
  //hover cualdo un div se coloca encima
  div_prior_uno[i].addEventListener('dragover', e=> {
      e.preventDefault();
      //para colorear el div cuando se coloca un elemento encima
      e.target.classList.add('hover');
  });
  div_prior_dos[i].addEventListener('dragover', e=> {
      e.preventDefault();
      //para colorear el div cuando se coloca un elemento encima
      e.target.classList.add('hover');
  });
  div_prior_tres[i].addEventListener('dragover', e=> {
      e.preventDefault();
      //para colorear el div cuando se coloca un elemento encima
      e.target.classList.add('hover');
  });
  div_prior_cuatro[i].addEventListener('dragover', e=> {
      e.preventDefault();
      //para colorear el div cuando se coloca un elemento encima
      e.target.classList.add('hover');
  });
  div_prior_cinco[i].addEventListener('dragover', e=> {
      e.preventDefault();
      //para colorear el div cuando se coloca un elemento encima
      e.target.classList.add('hover');
  });

  //eliminar hover cuando un div se va
  div_prior_uno[i].addEventListener('dragleave', e=> {
      //para eliminar el efecto hover cuando un elemento deja el div
      e.target.classList.remove('hover');
  });
  div_prior_dos[i].addEventListener('dragleave', e=> {
      //para eliminar el efecto hover cuando un elemento deja el div
      e.target.classList.remove('hover');
  });
  div_prior_tres[i].addEventListener('dragleave', e=> {
      //para eliminar el efecto hover cuando un elemento deja el div
      e.target.classList.remove('hover');
  });
  div_prior_cuatro[i].addEventListener('dragleave', e=> {
      //para eliminar el efecto hover cuando un elemento deja el div
      e.target.classList.remove('hover');
  });
  div_prior_cinco[i].addEventListener('dragleave', e=> {
      //para eliminar el efecto hover cuando un elemento deja el div
      e.target.classList.remove('hover');
  });

  //drop de los div
  div_prior_uno[i].addEventListener('drop', e=> {
      //eliminar hover cuando un elemento deja el div
      e.target.classList.remove('hover');
      //obtener los datos del div docente
      const id = e.dataTransfer.getData('id');
      const idProf = e.dataTransfer.getData('idProf');
      const prior = e.dataTransfer.getData('prior');
      console.log("idProf: "+idProf);
      const grupo = id.split('_')[0];
      console.log("grupo "+grupo +" prior: "+prior);
      const div_doc = e.target.id;
      const div_grupo = div_doc.split('_')[0];
      const div_prior = div_doc.split('_')[2];
      console.log("caja doc: "+div_doc);
      console.log("div_grupo "+div_grupo+" div_prior "+div_prior);
      //revisar compatibilidad del docente con el div
      if(grupo == div_grupo && prior == div_prior){
      	e.target.appendChild(document.getElementById(id));
      	if(seleccion_actual !== undefined) {
      		for(let k=0;k<seleccion_actual.length;k++){
      			if(seleccion_actual[k].grupo == grupo){
      				seleccion_actual.splice(k,1);
      				v--;
      			}
      		}
      	}
      	console.log(seleccion_actual);
      } else{
      	console.log("divs no compatibles por grupo o prioridad");
      }
  });
  div_prior_dos[i].addEventListener('drop', e=> {
      //eliminar hover cuando un elemento deja el div
      e.target.classList.remove('hover');
      //obtener los datos del div docente
      const id = e.dataTransfer.getData('id');
      const idProf = e.dataTransfer.getData('idProf');
      const prior = e.dataTransfer.getData('prior');
      console.log("idProf: "+idProf);
      const grupo = id.split('_')[0];
      console.log("grupo "+grupo +" prior: "+prior);
      const div_doc = e.target.id;
      const div_grupo = div_doc.split('_')[0];
      const div_prior = div_doc.split('_')[2];
      console.log("caja doc: "+div_doc);
      console.log("div_grupo "+div_grupo+" div_prior "+div_prior);
      //revisar compatibilidad del docente con el div
      if(grupo == div_grupo && prior == div_prior){
      	e.target.appendChild(document.getElementById(id));
      	if(seleccion_actual !== undefined) {
      		for(let k=0;k<seleccion_actual.length;k++){
      			if(seleccion_actual[k].grupo == grupo){
      				seleccion_actual.splice(k,1);
      				v--;
      			}
      		}
      	}
      } else{
      	console.log("divs no compatibles por grupo o prioridad");
      }
  });
  div_prior_tres[i].addEventListener('drop', e=> {
      //eliminar hover cuando un elemento deja el div
      e.target.classList.remove('hover');
      //obtener los datos del div docente
      const id = e.dataTransfer.getData('id');
      const idProf = e.dataTransfer.getData('idProf');
      const prior = e.dataTransfer.getData('prior');
      console.log("idProf: "+idProf);
      const grupo = id.split('_')[0];
      console.log("grupo "+grupo +" prior: "+prior);
      const div_doc = e.target.id;
      const div_grupo = div_doc.split('_')[0];
      const div_prior = div_doc.split('_')[2];
      console.log("caja doc: "+div_doc);
      console.log("div_grupo "+div_grupo+" div_prior "+div_prior);
      //revisar compatibilidad del docente con el div
      if(grupo == div_grupo && prior == div_prior){
      	e.target.appendChild(document.getElementById(id));
      	if(seleccion_actual !== undefined) {
      		for(let k=0;k<seleccion_actual.length;k++){
      			if(seleccion_actual[k].grupo == grupo){
      				seleccion_actual.splice(k,1);
      				v--;
      			}
      		}
      	}
      } else{
      	console.log("divs no compatibles por grupo o prioridad");
      }
  });
  div_prior_cuatro[i].addEventListener('drop', e=> {
      //eliminar hover cuando un elemento deja el div
      e.target.classList.remove('hover');
      //obtener los datos del div docente
      const id = e.dataTransfer.getData('id');
      const idProf = e.dataTransfer.getData('idProf');
      const prior = e.dataTransfer.getData('prior');
      console.log("idProf: "+idProf);
      const grupo = id.split('_')[0];
      console.log("grupo "+grupo +" prior: "+prior);
      const div_doc = e.target.id;
      const div_grupo = div_doc.split('_')[0];
      const div_prior = div_doc.split('_')[2];
      console.log("caja doc: "+div_doc);
      console.log("div_grupo "+div_grupo+" div_prior "+div_prior);
      //revisar compatibilidad del docente con el div
      if(grupo == div_grupo && prior == div_prior){
      	e.target.appendChild(document.getElementById(id));
      	if(seleccion_actual !== undefined) {
      		for(let k=0;k<seleccion_actual.length;k++){
      			if(seleccion_actual[k].grupo == grupo){
      				seleccion_actual.splice(k,1);
      				v--;
      			}
      		}
      	}
      	console.log(seleccion_actual);
      } else{
      	console.log("divs no compatibles por grupo o prioridad");
      }
  });
  div_prior_cinco[i].addEventListener('drop', e=> {
      //eliminar hover cuando un elemento deja el div
      e.target.classList.remove('hover');
      //obtener los datos del div docente
      const id = e.dataTransfer.getData('id');
      const idProf = e.dataTransfer.getData('idProf');
      const prior = e.dataTransfer.getData('prior');
      console.log("idProf: "+idProf);
      const grupo = id.split('_')[0];
      console.log("grupo "+grupo +" prior: "+prior);
      const div_doc = e.target.id;
      const div_grupo = div_doc.split('_')[0];
      const div_prior = div_doc.split('_')[2];
      console.log("caja doc: "+div_doc);
      console.log("div_grupo "+div_grupo+" div_prior "+div_prior);
      //revisar compatibilidad del docente con el div
      if(grupo == div_grupo && prior == div_prior){
      	e.target.appendChild(document.getElementById(id));
      	if(seleccion_actual !== undefined) {
      		for(let k=0;k<seleccion_actual.length;k++){
      			if(seleccion_actual[k].grupo == grupo){
      				seleccion_actual.splice(k,1);
      				v--;
      			}
      		}
      	}
      	console.log(seleccion_actual);
      } else{
      	console.log("divs no compatibles por grupo o prioridad");
      }
  });
}

//función que revisa si dos arreglos contienen al menos un elemento igual
//y nos sirve para determinar si el profesor ya está asignado a al menos un horario
//de determinado grupo, evitando traslape de horarios.
function tester(array1,array2){
	array1.sort();
	array2.sort();
	var flag=0;
	if(array1.length === array2.length){
		for(let j=0;j<array1.length;j++){
			if(array1[j] === array2[j]){
				flag++;
			}
		}
	} else {
		if(array1.length>array2.length){
			for(let j=0;j<array2.length;j++){
				if(array1.includes(array2[j])){
					flag++;
				}
			}
		} else{
			for(let j=0;j<array1.length;j++){
				if(array2.includes(array1[j])){
					flag++;
				}
			}
		}

	}
	if(flag!==0){
		return true;
	} else {
		return false;
	}
}

//función para evaluar si un profesor, que ya está programado en alguna UEA y, por tanto
//se encuentra en el array prof_traslape, ya tiene asignado uno o varios horarios
//de la UEA a la que se le quiere asignar en el drop
function tester_traslape(array1,array2){
	//array1.sort();
	array2.sort();
	var flag=0;
	var i=0;
	while(array1[i] != undefined){
		array1[i].sort();
		if(array1[i].length === array2.length){
			for(let j=0;j<array2.length;j++){
				if(array1[i].includes(array2[j]))
					flag++;
			}
		} else {
			if(array1[i].length>array2.length){
				for(let j=0;j<array2.length;j++){
					if(array1[i].includes(array2[j])){
						flag++;
					}
				}
			} else{
				for(let j=0;j<array1[i].length;j++){
					if(array2.includes(array1[i][j])){
						flag++;
					}
				}
			}
		}
		i++;
	}
	if(flag!==0){
		return true;
	} else {
		return false;
	}
}

//crear eventos para los div de cada grupo, los que reciben los div de docentes 
for(let i = 1; i <= noGrupos; i++){
  //recupera los div de los grupos
  grupos[i] = document.getElementById(obtener_idGrupo[i]);
  //agregar eventos a los div de grupos
  grupos[i].addEventListener('dragover', e=> {
      e.preventDefault();
      //para colorear el div cuando se coloca un elemento encima
      e.target.classList.add('hover');
  });

  grupos[i].addEventListener('dragleave', e=> {
      //para eliminar el efecto hover cuando un elemento deja el div
      e.target.classList.remove('hover');
  });

  grupos[i].addEventListener('drop', e=> {
      //eliminar hover cuando un elemento se suelta en el div
      e.target.classList.remove('hover');
      //obtener los datos del div docente
      const id = e.dataTransfer.getData('id');
      const idProf = e.dataTransfer.getData('idProf');
      console.log("idProf: "+idProf);
      const grupo = id.split('_')[0];
      const prof = id.split('_')[1];
      const idGrupo = e.target.id;
      console.log("grupo "+grupo+" profEnArray "+prof);
      console.log("caja grupo: "+ idGrupo);
      //revisar compatibilidad del docente con el grupo
      for(let k=1; k<=noGrupos;k++){
        if (obtener_idGrupo[k] === idGrupo && k == grupo){
          console.log("compartibles");
          if(v === 0){
          	//no se ha guardado nadie en el arreglo de seleccion_actual
          	console.log(hor_prof_traslape[idProf]);
          	//se revisa si el profesor ha sido programado en alguna otra UEA
          	if(hor_prof_traslape.length !== 0 && hor_prof_traslape[idProf] !== undefined){
          		//Sí está programado. Revisar si el horario en cuestión coincide con 
          		//alguno en el que ya esté programado
	          	var sol3 = tester_traslape(hor_prof_traslape[idProf],obtener_idHorario[grupo]);
	          	//console.log(hor_prof_traslape[idProf]);
	          	//console.log(obtener_idHorario[grupo]);
	          	console.log("sol3: "+sol3);
	          	if(sol3 === false)
	          		var profe_guardado = false;
	          	else{
	          		var profe_guardado = true;
	          		var guardado = true;
	          	}
	        } else{
	        	var profe_guardado = false;
	        }
          } else { 
          	//console.log(seleccion_actual[0].idProf);
          	if(hor_prof_traslape.length !== 0 && hor_prof_traslape[idProf] !== undefined) {
          		var sol3 = tester_traslape(hor_prof_traslape[idProf],obtener_idHorario[grupo]);
	          	console.log("sol3: "+sol3);
	          	if(sol3 == false){
	          		var profe_guardado = false;
		          	var n=0;
		          	while(n<seleccion_actual.length){
		          		if(seleccion_actual[n].idProf == idProf){
		          			console.log("Profe ya seleccionado");
		          			var grupoUno = seleccion_actual[n].grupo;
		          			//var grupoDos = grupo;
		          			var sol = tester(obtener_idHorario[grupoUno],obtener_idHorario[grupo]);
		          			console.log("sol: "+sol);
		          			if(sol === false){
		          				profe_guardado = false;
		          			} else {
		          				profe_guardado = true;
		          				break;
		          			}
		          		}
		          		n++;
		          	}
	          	} else{
			        profe_guardado = true;
			        var guardado = true;
	          	}
	          } else{
	          	var n=0;
	        	while(n<seleccion_actual.length){
		          	if(seleccion_actual[n].idProf == idProf){
		          		console.log("Profe ya seleccionado");
		          		var grupoUno = seleccion_actual[n].grupo;
		          		var sol = tester(obtener_idHorario[grupoUno],obtener_idHorario[grupo]);
		          		console.log("sol: "+sol);
		          		if(sol === false){
		          			profe_guardado = false;
		          		} else {
		          			profe_guardado = true;
		          			break;
		          		}
		          	}
		          	n++;
		         }
	        }
          } 
          if(!profe_guardado){ //no está asignado en este horario (misma o diferente UEA)
          		e.target.appendChild(document.getElementById(id));
		        seleccion_actual[v] = new seleccion(grupo,idProf);
		        v++;
		        console.log(seleccion_actual);
          }
          if(guardado){ //significa que está asignado a otra UEA en ese horario
          		console.log('Profesor ocupado');
          		//Las UEA a las que se encuentra programado están en uea_prof_programado
          		alert('El profesor ya tiene asignado este horario o podría traslaparse.'+'\nUEA programadas: '+
          			uea_prof_programado[idProf]);
          }
        }
      }
  });
}
 
//Se ejecuta al dar click en "Guardar", realiza el llamado AJAX a guardar_seleccion.php
function guardarSeleccion(){

	const datos = new FormData();
	var grupo_id = new Array(noGrupos);
	var profe_id = new Array(noGrupos);
	datos.append('noGrupos', noGrupos);

	for(let n=1; n<=noGrupos; n++){
		var grupo_id_array = grupos[n].id;
		grupo_id[n] = grupos[n].id; //firstChild es el div del grupo
		if(grupos[n].firstChild !== null){
			profe_id[n] = grupos[n].firstChild.dataset.id;
		} else{
			profe_id[n] = null;
		}
		console.log(grupo_id[n]+" "+profe_id[n]);		
	}

	datos.append('idGrupo', JSON.stringify(grupo_id));
    datos.append('idProf', JSON.stringify(profe_id));

	// crear el llamado a ajax
    const xhr = new XMLHttpRequest();
	
	// abrir la conexión.
    xhr.open('POST', '../controlador/guardar_seleccion.php', true);

	// retorno de datos
    xhr.onload = function() {
        if (this.status === 200) {
            const respuesta = JSON.parse(xhr.responseText);
            console.log(respuesta);

            // Si la respuesta es correcta
            if (respuesta.respuesta === 'correcto') {  
                alert(respuesta.mensaje);                
                window.location.href = 'programacion.php';
            } else {
                // Hubo un error
                alert(respuesta.error);
            }
        }
    }
    // Enviar la petición
    xhr.send(datos);
}

 
function ver_docentes(){
    if (doc_interesados.style.display === "none") {
        doc_interesados.style.display = "block";
    } else {
        doc_interesados.style.display = "none";
    }
}

</script>
