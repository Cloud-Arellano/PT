<?php 
	require_once "plantilla.php";
	session_start();
	if(!isset($_SESSION["success"])){
		header('Location: login.php');
	}
	if(isset($_SESSION["trim"])){
		$trimestre = $_SESSION["trim"];
		$fecha = $_SESSION["fecha"];
	}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Preparar BD</title>
</head>
<body>
	<a class="volver btn" href="menu.php?user=1">Volver</a>
	<p class="text-center h3 titles">Preparar la base de datos</p>
	<div class="container">
		<div class="row">
		  <div id="carga" class="col-sm-6 col-xs-12">
		    <div class="card">
		      <div class="card-body">
		        <h5 class="card-title">Cargar Planeación de CBI</h5>
		        <p class="card-text">Los archivos soportados son del tipo CSV, XSL y XLSX.
		        <strong>Este proceso tardará en reflejarse en la página de programación.</strong> <a id="img_plan" onclick="cat_ejemplo('plan')">Ejemplo</a></p>
		        <form action="#" enctype="multipart/form-data">
		        	<div class="col-lg-12 col-xs-12">
		        	<input type="file" id="import-file" class="form-control" accept=".csv,.xsl,.xlsx">
			        </div><br>
			        <div id="btn-cargar" class="col-lg-12">
			        	<button class="btn btn-success" type="button" onclick="cargarPlaneacion()">Cargar archivo</button>
			        </div>
		        </form>
		      </div>
		    </div>
		  </div>
		  <div id="envio" class="col-sm-6 col-xs-12">
		    <div class="card">
		      <div class="card-body">
		        <h5 class="card-title">Enviar formulario a docentes</h5>
      			<form id="form-trim" autocomplete="off">
      				<p id="trimestre" class="card-text">Ingrese el trimestre a programar (Ej. 21-P):
      				<input type="text" size="5" id="trim" name="trim" class="container_label"></p>
      				<p id="fecha-trim" class="card-text">Ingrese la fecha límite de entrega (Ej. 6 de agosto de 2021):
      				<input type="text" size="15" id="fecha" name="fecha" class="container_label"></p>
      				<button class="btn btn-primary" id="nuevo-trim" onclick="nuevoTrim()" type="button">Confirmar y Revisar</button>
      				<button class="btn btn-success" type="button" onclick="enviarForm()">Enviar a docentes</button>
      			</form>
		        
		      </div>
		    </div>
		  </div>
		</div>
	</div>
	
	

	<div class="container">
		<p class="text-center h3 titles">Actualizar la base de datos</p>
		<div id="update-cat" class="col-md-12 col-sm-12 col-xs-12">
		    <div class="card">
		      <div class="card-body">
		        <h5 class="card-title text-center">Actualiza los catálogos del Departamento</h5>
		        <p class="card-text">Los archivos soportados son del tipo CSV, XSL y XLSX. Y deben seguir el formato mostrado en los ejemplos.</p>
		        <p class="card-text">Actualiza el catálogo de UEA. <a id="img_cat_uea" onclick="cat_ejemplo('uea')">Ejemplo</a></p>
		        <form action="#" enctype="multipart/form-data">
		        	<div class="col-lg-12 col-xs-12">
		        	<input type="file" id="update-uea" class="form-control" accept=".csv,.xsl,.xlsx">
			        </div><br>
			        <div class="col-lg-12">
			        	<button class="btn btn-primary" onclick="cargarCatalogo('1')">Actualizar UEA</button>
			        </div>
		        </form>
		        <br><p class="card-text">Actualiza el catálogo de docentes. <a id="img_cat_prof" onclick="cat_ejemplo('docentes')">Ejemplo</a></p>
		        <form action="#" enctype="multipart/form-data">
		        	<div class="col-lg-12 col-xs-12">
		        	<input type="file" id="update-docentes" class="form-control" accept=".csv,.xsl,.xlsx">
			        </div><br>
			        <div class="col-lg-12">
			        	<button class="btn btn-primary" onclick="cargarCatalogo('2')">Actualizar docentes</button>
			        </div>
		        </form>
		      </div>
		    </div>
		  </div>
	</div>
	<br>
	
	<!-- jQuery (Bootstrap JS plugins depend on it) -->
  <script src="js/jquery-3.5.1.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  
</body>
</html>

<script>
	$('input[type="file"]').on('change',function(){
		var ext = $( this ).val().split('.').pop();
		if($( this ).val != ''){
			if(ext == "xsl" || ext == "xlsx" || ext == "csv"){
			}
			else{
				$( this ).val('');
				alert("Extensión de archivo, no compatible");
			}
		}
	});

	function cargarPlaneacion(){
		console.log("entro a la funcion");
		var archivo = $("#import-file").val();
		if(archivo===""){
			alert("El archivo está vacío");
		}
		var formData = new FormData();
		var files = $("#import-file")[0].files[0];
		formData.append('archivoexcel',files);
		$.ajax({
			url: '../controlador/guardar_planeacion.php',
			type: 'POST',
			data: formData,
			contentType: false,
			processData: false,
			success: function(resp){
				//registrarExcel(resp);
				alert(resp);
			}
		});
		return false;
	}


	function nuevoTrim(){
		var trim = document.getElementById("trim").value;
		var fecha = document.getElementById("fecha").value;
		if(trim == "" || fecha == ""){
			alert("Los campos de trimestre y fecha son requeridos");
		} else{
			var url= "http://localhost/PT/vista/docentes.php?trim="+trim+"&fecha="+fecha;
			window.location.href = url;
		}
	}
	
	function cargarCatalogo(tipo){
		console.log("entro a la funcion");
		if(tipo == '1'){
			var archivo = $("#update-uea").val();
			if(archivo===""){
				alert("El archivo está vacío");
			}
			//alert('tipo 1 archivo no vacío');
			const formData = new FormData();
			var files = $("#update-uea")[0].files[0];
			formData.append('tipo',tipo);
			formData.append('archivoexcel',files);
			// crear el llamado a ajax
			$.ajax({
				url: '../controlador/import_catalogo.php',
				type: 'POST',
				data: formData,
				contentType: false,
				processData: false,
				success: function(resp){
					//registrarExcel(resp);
					alert(resp);
				}
			});
			return false;

		}else if(tipo == '2'){
			var archivo = $("#update-docentes").val();
			if(archivo===""){
				alert("El archivo está vacío");
			}
			var formData = new FormData();
			var files = $("#update-docentes")[0].files[0];
			formData.append('tipo',tipo);
			formData.append('archivoexcel',files);
			// crear el llamado a ajax
			$.ajax({
				url: '../controlador/import_catalogo.php',
				type: 'POST',
				data: formData,
				contentType: false,
				processData: false,
				success: function(resp){
					//registrarExcel(resp);
					alert(resp);
				}
			});
			return false;
		}
	}

	function enviarForm(){
		var trim = '<?php if(isset($trimestre))echo $trimestre; else echo null;?>';
		var fecha = '<?php if(isset($fecha))echo $fecha; else echo null;?>';
		if(trim == '' || fecha == ''){
			alert('No se ha establecido el trimestre ni la fecha límite.');
		} else{
			var fecha_dos = fecha.replace(/ /g,"%20");
			console.log(fecha_dos);
			var formData = new FormData();
			formData.append('trim',trim);
			formData.append('fecha',fecha_dos);
			$.ajax({
				url: '../controlador/enviarForm.php',
				type: 'POST',
				data: formData,
				contentType: false,
				processData: false,
				success: function(resp){
					alert(resp);
				}
			});
		}
	}

	function cat_ejemplo(tipo){
		if(tipo == 'uea')
			myWindow=window.open('img_catalogos.php?cat=uea','myWin','width=750,height=800');
		else if(tipo == 'docentes')
			myWindow=window.open('img_catalogos.php?cat=prof','myWin','width=910,height=750');
		else if(tipo == 'plan')
			myWindow=window.open('img_catalogos.php?cat=plan','myWin','width=1200,height=750');
	}


</script>
