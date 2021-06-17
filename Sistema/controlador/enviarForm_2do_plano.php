<?php 

include_once '../modelo/email_settings.php';
include_once "../modelo/pdo.php";

	//recibe esta variable de enviarForm.php
	$trim = $_SERVER['argv'][1];
	$fecha = $_SERVER['argv'][2];

	$recuperar_correos = $pdo->prepare("SELECT * FROM profesor WHERE noEconomico = 54321");
	$recuperar_correos->execute();
	//$correos = $recuperar_correos->fetch(PDO::FETCH_ASSOC);

	//título
	$mail->Subject = 'Programación Trimestre '.$trim;
	//cuerpo
	$mail->Body = '<p>Profesoras, profesores.</p><br>
					<p>Atentamente, les solicito contestar el formulario sobre la programación docente '.$trim.' que se encuentre en la siguiente liga:</p><br>
					<p>http://localhost/PT/vista/docentes.php?trim='.$trim.'&fecha='.$fecha.'</p><br>
					<p><b>Importante: El formulario sólo se puede contestar una vez.</b></p>
					<br><p>De antemano, agradezco su atención.</p>
					<br><p>Atentamente,</p>
					<br><p>“Casa Abierta al Tiempo”<br>Dr. Rafael Pérez Flores.<br>
					Jefe del Departamento de Ciencias Básicas.</p>';


	//receptor
	while ($correos = $recuperar_correos->fetch(PDO::FETCH_ASSOC)) {
		if($correos['correo_uam'] != null && $correos['correo_personal'] != null){
			$mail->addAddress($correos['correo_uam'],'Docentes');
			$mail->addAddress($correos['correo_personal'],'Docentes');
			$mail->send();
		} else if($correos['correo_personal'] != null){
			$mail->addAddress($correos['correo_personal'],'Docentes');
			$mail->send();
		} else {
			$mail->addAddress($correos['correo_uam'],'Docentes');
			$mail->send();
		}
	}


?>