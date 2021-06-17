<?php 

require_once '../modelo/pdo.php';
include_once '../modelo/email_settings.php';

//recibe esta variable de insertarDatosDocentes.php
$idProf = $_SERVER['argv'][1];
$correo = $_SERVER['argv'][2];
//$idProf = intval( $idProfesor );  

//título
$mail->Subject = 'Respuestas de su Preferencia Docente';
//cuerpo
$mail->Body = '<p>Profesoras, profesores.</p><br>
					<p>En la siguiente liga podrán consultar las respuestas que registraron en el formulario para la Programación Docente:</p><br>
					<p>http://localhost/PT/vista/preferencia_prof.php?id='.$idProf.'</p><br>
					<br><p>Agradezco su atención.</p>
					<br><p>Atentamente,</p>
					<br><p>“Casa Abierta al Tiempo”<br>Dr. Rafael Pérez Flores.<br>
					Jefe del Departamento de Ciencias Básicas.</p>';

$mail->addAddress($correo,'Docentes');
$mail->send();

 ?>