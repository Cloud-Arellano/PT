<?php 

if(is_array($_FILES['archivoexcel']) && count($_FILES['archivoexcel'])>0){

	$nombre = $_FILES['archivoexcel']['name'];
	$guardado = $_FILES['archivoexcel']['tmp_name'];

	//Borrar los posibles registros dentro de la base de datos
	include_once "../modelo/pdo.php";

	//revisar si el folder donde se va a guardar el archivo está vacío o no.
	$carpeta = @scandir('archivo_tmp');
	if(count($carpeta)>2){
		//la carpeta tiene algún documento, por lo que hay tablas en la base de datos
		//que deben vaciarse
		$borrar_prog = $pdo->prepare("TRUNCATE TABLE programacion");
		$borrar_prog->execute();

		if($borrar_prog){
			$borrar_grupo_hor = $pdo->prepare("TRUNCATE TABLE grupo_horario");
			$borrar_grupo_hor->execute();

			if($borrar_grupo_hor){
				$borrar_grupo = $pdo->prepare("DELETE FROM grupo WHERE idGrupo>=1");
				$borrar_grupo->execute();
				if(!$borrar_grupo){
					echo "Error al vaciar la tabla Grupo";
				}
			} else {
				echo "Error al vaciar la tabla Grupo_Horario";
			}
		} else {
			echo "Error al vaciar la tabla Programación";
		}
		//una vez vaciadas las tablas en la base de datos, borrar el archivo que está
		//en archivo_tmp
		$borrado = unlink('archivo_tmp/'.$carpeta[2]);
		if($borrado){
			//después de borrarlo guardar el nuevo archivo en la carpeta archivo_tmp
			if(move_uploaded_file($guardado, 'archivo_tmp/'.$nombre)){
				//si se guarda correctamente llamar al proceso en 2do plano
				//encargadp de guardar los datos del excel.
				$cmd = 'C:\xampp\php\php.exe C:\xampp\htdocs\PT\controlador\planeacion_2do_plano.php '. $nombre;
				$handle = popen("start /B ".$cmd, "w");
				if(!$handle){
					echo "Error de segundo plano";
				} else{
					pclose($handle);
					echo "El archivo '".$nombre."' está cargándose.";
				}
			} else {
				echo 'Error al guardar el archivo';
			}
		}
	} else { //no hay archivo en la carpeta, por lo que no hay que vaciar la base de 
		//datos y se guarda el archivo directamente.
		if(move_uploaded_file($guardado, 'archivo_tmp/'.$nombre)){
				$cmd = 'C:\xampp\php\php.exe C:\xampp\htdocs\PT\controlador\planeacion_2do_plano.php '. $nombre;
				$handle = popen("start /B ".$cmd, "w");
				if(!$handle){
					echo "Error de segundo plano";
				} else{
					pclose($handle);
					echo "El archivo '".$nombre."' está cargándose.";
				}
			} else {
				echo 'Error al guardar el archivo';
			}
	}

}

 ?>