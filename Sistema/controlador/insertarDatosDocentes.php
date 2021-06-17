<?php 
include_once "../modelo/pdo.php";

//se obtienen del formulario docentes.php
$noEco = $_POST["noEco"];
$correo = $_POST["email"];
$noGrupos = $_POST["noGrupos"];
$uea = [$_POST["uea1"],$_POST["uea2"],$_POST["uea3"],$_POST["uea4"],$_POST["uea5"]];
$obs = $_POST["obser"];
$registro_hecho=1;
$reg_exito=false;
$validacion_dos=false;
$i=0;
//arreglo que contendrá al $_POST['horario']
$idHorario=[];

//recupera el correo para revisar que coincida con el número económico del docente
$state = "SELECT idProf FROM Profesor WHERE (Profesor.correo_uam = :correo OR Profesor.correo_personal = :correo) AND Profesor.noEconomico = :noEcon";
$verificar = $pdo->prepare($state);
$verificar->execute([':correo'=>$correo, ':noEcon'=>$noEco]);
$row = $verificar->fetch(PDO::FETCH_ASSOC);
//para llenar la tabla solicitud profesor
$insert_sol_prof = $pdo->prepare("CALL INSERTA_SOL_PROF(:noEco,:noGrupos,:obs)");
//para llenar la tabla solicitud_UEA
$insert_sol_uea = $pdo->prepare("CALL INSERTA_SOL_UEA(:noEco,:claveUEA,:prior)");
//para llenar la tabla solicitud_horario
$insert_sol_hor = $pdo->prepare("CALL INSERTA_SOL_HOR(:noEco,:idHorario)");
//para llenar la tabla solicitud_horario cuando se pueden impartir tres horas seguidas
$insert_sol_hor_esp = $pdo->prepare("CALL INSERTA_SOL_HOR_ESPECIAL(:noEco, :idHorarioUno)");
//para llenar la tabla solicitud_horario cuando se pueden impartir 4.5 horas seguidas
$insert_sol_hor_esp_dos = $pdo->prepare("CALL INSERTA_SOL_HOR_ESPECIAL_DOS(:noEco, :idHorarioUno)");

//si coinciden
if($row){
	//el profesor está en la base de datos, pero puede que ya haya realizado el registro
	//el registro sólo se puede realizar una vez
	$registro_hecho = $pdo->prepare("SELECT Solicitud_profesor.idSolProf FROM 
		(Solicitud_profesor INNER JOIN Profesor ON Solicitud_profesor.idProf=Profesor.idProf) WHERE Profesor.noEconomico=:noEco");
	$registro_hecho->execute([':noEco'=>$noEco]);
	$validacion_dos = $registro_hecho->fetch();
	//si no ha realizado el registro, éste se lleva a cabo
	if(!$validacion_dos){
		//ejecutar el procedure INSERTA_SOL_PROF
		$insert_sol_prof->bindParam(':noEco',$noEco);
		$insert_sol_prof->bindParam(':noGrupos',$noGrupos);
		$insert_sol_prof->bindParam(':obs',$obs);
		$insert_sol_prof->execute();
		//echo "<p>Registro solicitud_prof logrado</p>";
		//para llenar la tabla solicitud_UEA
		while($i<5 && $uea[$i]!=0){
			$insert_sol_uea->execute([':noEco'=>$noEco, ':claveUEA'=>$uea[$i], ':prior'=>($i+1)]);
			//echo "<h5>Registro solicitud_UEA logrado</h5>";
			$i++;
		}
		$insert_sol_uea = null;
		//solicitud_horario
		if(!empty($_POST['horario'])){
			$idHorario=$_POST['horario'];
			foreach ($idHorario as $seleccion) {
				//para llenar la tabla solicitud_horario
				$insert_sol_hor->execute([':noEco'=>$noEco, ':idHorario'=>$seleccion]);
				//echo "<h5>Registro solicitud_horario logrado</h5>";
				if($insert_sol_hor ){
					$reg_exito=true;
				}
			}
			$insert_sol_hor = null;
			foreach ($idHorario as $seleccion) {
				//llenar solicitud_horario con horarios de corrido como 7-10
				if(in_array(($seleccion+5),$idHorario)){
					$insert_sol_hor_esp->execute([':noEco'=>$noEco, ':idHorarioUno'=>$seleccion]);
					if($insert_sol_hor_esp && in_array(($seleccion+10),$idHorario)){
						$insert_sol_hor_esp_dos->execute([':noEco'=>$noEco, ':idHorarioUno'=>$seleccion]);
					}
				}
				if($insert_sol_hor_esp){
					$reg_exito=true;
				}
			}
			$insert_sol_hor_esp=null;
		}
	}
}

if(!$row) {
  	$respuesta = array(
  		            'respuesta' => 'incorrecto',
                    'mensaje' => 'Número económico o correo electrónico
  									incorrecto'
                );  
} else {
	if($validacion_dos) { 
		$respuesta = array(
	  		            'respuesta' => 'incorrecto',
	                    'mensaje' => 'Ya se ha realizado un registro con el número económico proporcionado.'
	                );  
	} else {
	  	if($reg_exito){
	  		
	    	$cmd = 'C:\xampp\php\php.exe C:\xampp\htdocs\PT\controlador\preferencia_2do_plano.php '.$row['idProf'].' '.$correo;
			$handle = popen("start /B ".$cmd, "w");
			if(!$handle){
				$respuesta = array(
	  		            'respuesta' => 'correcto',
	                    'mensaje' => 'Solicitud registrada con éxito. Correo no enviado'
	            );
			} else{
				pclose($handle);
				$respuesta = array(
	  		            'respuesta' => 'correcto',
	                    'mensaje' => 'Solicitud registrada con éxito.'
	             );
			}    		
	  	} else {
	  		$respuesta = array(
	  		            'respuesta' => 'incorrecto',
	                    'mensaje' => 'Error en el registro. Inténtelo de nuevo.'
	                	);   
	  	}
	}
}


echo json_encode($respuesta);

?>