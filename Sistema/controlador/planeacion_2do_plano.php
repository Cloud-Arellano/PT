<?php 
//llama a la librería PHPExcel y la conexión
require_once 'phpexcel/Classes/PHPExcel.php';
require_once '../modelo/pdo.php';

//recibe esta variable de guardar_planeacion.php
$nombreArchivo = $_SERVER['argv'][1];
//query para insertar un grupo en la tabla grupo
$insert_grupo = $pdo->prepare("CALL INSERTA_GRUPO(:claveUEA,:grupo,:cupo)");
//query para insertar horario en grupo_horario
$insert_grupo_hor = $pdo->prepare("CALL INSERTA_GRUPO_HOR(:dia,:horI,:horF)");

//Cargar archivo
$leerfile = PHPExcel_IOFactory::load('archivo_tmp/'.$nombreArchivo);

//Cargar hoja a leer (0)
$hoja = $leerfile->setActiveSheetIndex(0);
$filas = $hoja->getHighestRow();

	for($i = 2; $i <= $filas; $i++){

			$claveUEA = $hoja->getCell('A'.$i)->getCalculatedValue(); //clave
			//$uea = $hoja->getCell('B'.$i)->getCalculatedValue();
			$claveGrupo = $hoja->getCell('C'.$i)->getCalculatedValue();//grupo
			$cupo = $hoja->getCell('D'.$i)->getCalculatedValue();//cupo
			if($cupo == 0){
				$cupo = null;
			}
			//insertar grupo
			$insert_grupo->execute([':claveUEA'=>$claveUEA, ':grupo'=>$claveGrupo, ':cupo'=>$cupo]);

			//lunes
			$lunes_i = $hoja->getCell('E'.$i)->getCalculatedValue();//lunes_i
			if($lunes_i!=0){
				$lun_i = PHPExcel_Style_NumberFormat::toFormattedString($lunes_i,'hh:mm:ss');
				//$lunes_f = $hoja->getCell('F'.$i);//lunes_f
				$lun_f = PHPExcel_Style_NumberFormat::toFormattedString($hoja->getCell('F'.$i)->getCalculatedValue(),'hh:mm:ss');
				$insert_grupo_hor->execute([':dia'=>'Lunes', ':horI'=>$lun_i, ':horF'=>$lun_f]);
			}

			//martes
			$martes_i = $hoja->getCell('G'.$i)->getCalculatedValue();//martes_i
			if($martes_i!=0){
				$mar_i = PHPExcel_Style_NumberFormat::toFormattedString($martes_i,'hh:mm:ss');
				//$martes_f = $hoja->getCell('H'.$i);//martes_f
				$mar_f = PHPExcel_Style_NumberFormat::toFormattedString($hoja->getCell('H'.$i)->getCalculatedValue(),'hh:mm:ss');
				$insert_grupo_hor->execute([':dia'=>'Martes', ':horI'=>$mar_i, ':horF'=>$mar_f]);
			}

			//miercoles
			$mier_i = $hoja->getCell('I'.$i)->getCalculatedValue();//mier_i
			if($mier_i!=0){
				$mie_i = PHPExcel_Style_NumberFormat::toFormattedString($mier_i,'hh:mm:ss');
				//$mier_f = $hoja->getCell('J'.$i);//mier_f
				$mie_f = PHPExcel_Style_NumberFormat::toFormattedString($hoja->getCell('J'.$i)->getCalculatedValue(),'hh:mm:ss');
				$insert_grupo_hor->execute([':dia'=>'Miércoles', ':horI'=>$mie_i, ':horF'=>$mie_f]);
			}

			//jueves
			$jueves_i = $hoja->getCell('K'.$i)->getCalculatedValue();//jueves_i
			if($jueves_i!=0){
				$jue_i = PHPExcel_Style_NumberFormat::toFormattedString($jueves_i,'hh:mm:ss');
				//$jueves_f = $hoja->getCell('L'.$i);//jueves_f
				$jue_f = PHPExcel_Style_NumberFormat::toFormattedString($hoja->getCell('L'.$i)->getCalculatedValue(),'hh:mm:ss');
				$insert_grupo_hor->execute([':dia'=>'Jueves', ':horI'=>$jue_i, ':horF'=>$jue_f]);
			}

			//viernes
			$viernes_i = $hoja->getCell('M'.$i)->getCalculatedValue();//viernes_i
			if($viernes_i!=0){
				$vie_i = PHPExcel_Style_NumberFormat::toFormattedString($viernes_i,'hh:mm:ss');
				//$viernes_f = $hoja->getCell('N'.$i);//viernes_f
				$vie_f = PHPExcel_Style_NumberFormat::toFormattedString($hoja->getCell('N'.$i)->getCalculatedValue(),'hh:mm:ss');
				$insert_grupo_hor->execute([':dia'=>'Viernes', ':horI'=>$vie_i, ':horF'=>$vie_f]);
			}

			//profesor propuesto por la dirección
			//$prof_propuesto = $hoja->getCell('O'.$i)->getCalculatedValue();
			//if($prof_propuesto!=0){
				//TODO
			//}

		}

		//Crear vista de programacion_actual, necesaria para la restricción de 
		//impedir programar a un docente en un horario ya programado en otra UEA
		//situación que ocurre en uea.php
		$crea_vista_prog = $pdo->prepare("CALL VISTA_PROGRAMACION_ACTUAL()");
		$crea_vista_prog->execute();


 ?>