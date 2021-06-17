<?php 

include_once "../modelo/pdo.php";

if($_POST["trim"]){

	$trim=$_POST["trim"];
	$fecha=$_POST["fecha"];

	//vaciar la preferencia docente anterior
	$borrar_prog = $pdo->prepare("TRUNCATE TABLE programacion");
	$borrar_prog->execute();

	if($borrar_prog){
		$borrar_sol_hor = $pdo->prepare("TRUNCATE TABLE solicitud_horario");
		$borrar_sol_hor->execute();

		if($borrar_sol_hor){
			$borrar_sol_uea = $pdo->prepare("TRUNCATE TABLE solicitud_uea");
			$borrar_sol_uea->execute();

			if($borrar_sol_uea){
				$borrar_sol_prof = $pdo->prepare("TRUNCATE TABLE solicitud_profesor");
				$borrar_sol_prof->execute();

				if($borrar_sol_prof){
					//Una vez vaciada la preferencia anterior, llamar al proceso en
					//segundo plano que se encarga de enviar los correos.
					$cmd = 'C:\xampp\php\php.exe C:\xampp\htdocs\PT\controlador\enviarForm_2do_plano.php '.$trim.' '.$fecha;
					$handle = popen("start /B ".$cmd, "w");
					if(!$handle){
						echo "Error al llamar proceso en segundo plano";
					} else{
						pclose($handle);
						echo "Correos enviándose.";
					}

				} else{
					echo 'Error al limpiar la tabla solicitud_profesor.';
				}
			} else {
				echo 'Error al limpiar la tabla solocitud_uea.';
			}
		} else {
			echo 'Error al limpiar la tabla solicitud_horario.';
		}
	} else {
		echo 'Error al limpiar la tabla programacion.';
	}

}


?>