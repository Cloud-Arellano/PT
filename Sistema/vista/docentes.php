<?php
require_once "../modelo/pdo.php";
require_once "plantilla.php";

$consulta="SELECT claveUEA,nombre FROM UEA ORDER BY nombre";

session_start();
$_SESSION["trim"] = $_GET["trim"];
$_SESSION["fecha"] = $_GET["fecha"];

?>

<!DOCTYPE html>
<html>
<head>
	<title>Carga Docente</title>
</head>
<body>

  <div id="resp-warning" class="alert alert-primary text-center" role="alert">
  </div>

  <div id="resp-success" class="alert alert-success text-center" role="alert">
  </div>

  <div id="contenedor-docente" class="container">
    <div class="jumbotron" id="docentes">
      <p class="text-center h2"><strong>Programación Docente. Trimestre <?php echo $_SESSION["trim"]; ?>.</strong></p><br>
      <p class="h5 text-center">Profesoras y profesores del Departamento de Ciencias Básicas.
      </p>
      <p class="text-center">Con el propósito de asignar la carga docente para el trimestre <?php echo $_GET["trim"]; ?>, les solicito atentamente, contestar el siguiente formulario antes del <b><?php echo $_GET["fecha"]; ?></b>.</p>
      <form action="#" method="post" autocomplete="off" id="form-docentes">
      <p>Número económico:<br>
      <input type="number" id="noEcon" name="noEco" class="container_label" required></p>
      <p>Correo:<br>
      <input type="email" id="email" name="email" class="container_label" required></p>
      <p>Indique el número de grupos que desea impartir el próximo trimestre.<br>
      <input type="number" id="noGrup" name="noGrupos" class="container_label" required"></p>

      <!-- Selección de UEA -->
      <p>En los siguientes campos, indicar sus preferencias en cuanto a las UEA
      que desea impartir. Puede indicar hasta 5 UEA. <strong>La primera UEA y la segunda deben ser diferentes.</strong> En la medida de lo posible, el Departamento le asignará las UEA que usted indique como primera y segunda opción.</p>
  	  <p>Nota: indique 4 UEA diferentes como mínimo. Una de ellas, al menos, del
  	  Tronco General.</p>
  	  <p>1ra UEA (Seleccione una opción)<br>     
  	  <label>
        <select id="uea1" name="uea1">
          <option value="0">-- Seleccionar UEA --</option>
          <?php foreach ($pdo->query($consulta) as $uea): ?>
            <option value="<?php echo $uea['claveUEA'] ?>">
              <?php echo $uea['claveUEA']." ".$uea['nombre'] ?>
            </option>
          <?php endforeach ?>
        </select> 
      </label></p>
  	  <p>2da UEA (Seleccione una opción)<br>
  	  <label>
        <select id="uea2" name="uea2">
          <option value="0">-- Seleccionar UEA --</option>
          <?php foreach ($pdo->query($consulta) as $uea): ?>
            <option value="<?php echo $uea['claveUEA'] ?>">
              <?php echo $uea['claveUEA']." ".$uea['nombre'] ?>
            </option>
          <?php endforeach ?>
        </select> 
      </label></p>
  	  <p>3ra UEA (Seleccione una opción)<br>
  	  <label>
        <select id="uea3" name=uea3>
          <option value="0">-- Seleccionar UEA --</option>
          <?php foreach ($pdo->query($consulta) as $uea): ?>
            <option value="<?php echo $uea['claveUEA'] ?>">
              <?php echo $uea['claveUEA']." ".$uea['nombre'] ?>
            </option>
          <?php endforeach ?>
        </select> 
      </label></p>
  	  <p>4ta UEA (Seleccione una opción)<br>
  	  <label>
        <select id="uea4" name="uea4">
          <option value="0">-- Seleccionar UEA --</option>
          <?php foreach ($pdo->query($consulta) as $uea): ?>
            <option value="<?php echo $uea['claveUEA'] ?>">
              <?php echo $uea['claveUEA']." ".$uea['nombre'] ?>
            </option>
          <?php endforeach ?>
        </select> 
      </label></p>
  	  <p>5ta UEA (Seleccione una opción)<br>
  	  <label>
        <select id="uea5" name="uea5">
          <option value="0">-- Seleccionar UEA --</option>
          <?php foreach ($pdo->query($consulta) as $uea): ?>
            <option value="<?php echo $uea['claveUEA'] ?>">
              <?php echo $uea['claveUEA']." ".$uea['nombre'] ?>
            </option>
          <?php endforeach ?>
        </select> 
      </label></p>

  	  <p>En la siguiente tabla, indique los horarios de su preferencia. <strong>Como mínimo, debe indicar dos horarios por día.</strong> En la medida de lo posible, se tratará de atender los horarios de su preferencia. Los horarios que se asignen, estarán dentro de su horario de estancia en la Unidad.</p>
  	  <!-- Tabla de horarios -->
      <div id="hora-semana" class="container">
      <table id="horarios" class="table-bordered">
        <tr>
          <th scope="row"></th>
          <th>7:00 - 8:30</th>
          <th>8:30 - 10:00</th>
          <th>10:00 - 11:30</th>
          <th>11:30 - 13:00</th>
          <th>13:00 - 14:30</th>
          <th>14:30 - 16:00</th>
          <th>16:00 - 17:30</th>
          <th>17:30 - 19:00</th>
          <th>19:00 - 20:30</th>
        </tr>
        <tr>
          <th>Lunes</th> <!-- el value es el idHorario que corresponde a los lunes -->
          <td><input type="checkbox" name="horario[]" value="1"></td> <!--7-8:30-->
          <td><input type="checkbox" name="horario[]" value="6"></td> <!--8:30-10-->
          <td><input type="checkbox" name="horario[]" value="11"></td> <!--10-11:30-->
          <td><input type="checkbox" name="horario[]" value="16"></td> <!--11:30-13-->
          <td><input type="checkbox" name="horario[]" value="21"></td> <!--13-14:30-->
          <td><input type="checkbox" name="horario[]" value="26"></td> <!--14:30-16-->
          <td><input type="checkbox" name="horario[]" value="31"></td> <!--16-17:30-->
          <td><input type="checkbox" name="horario[]" value="36"></td> <!--17:30-19-->
          <td><input type="checkbox" name="horario[]" value="41"></td> <!--19-20:30-->
        </tr>
        <tr>
          <th>Martes</th> <!-- el value es el idHorario que corresponde a los martes -->
          <td><input type="checkbox" name="horario[]" value="2"></td> <!--7-8:30-->
          <td><input type="checkbox" name="horario[]" value="7"></td> <!--8:30-10-->
          <td><input type="checkbox" name="horario[]" value="12"></td> <!--10-11:30-->
          <td><input type="checkbox" name="horario[]" value="17"></td> <!--11:30-13-->
          <td><input type="checkbox" name="horario[]" value="22"></td> <!--13-14:30-->
          <td><input type="checkbox" name="horario[]" value="27"></td> <!--14:30-16-->
          <td><input type="checkbox" name="horario[]" value="32"></td> <!--16-17:30-->
          <td><input type="checkbox" name="horario[]" value="37"></td> <!--17:30-19-->
          <td><input type="checkbox" name="horario[]" value="42"></td> <!--19-20:30-->
        </tr>
        <tr>
          <th>Miércoles</th>
          <td><input type="checkbox" name="horario[]" value="3"></td>
          <td><input type="checkbox" name="horario[]" value="8"></td>
          <td><input type="checkbox" name="horario[]" value="13"></td>
          <td><input type="checkbox" name="horario[]" value="18"></td>
          <td><input type="checkbox" name="horario[]" value="23"></td>
          <td><input type="checkbox" name="horario[]" value="28"></td>
          <td><input type="checkbox" name="horario[]" value="33"></td>
          <td><input type="checkbox" name="horario[]" value="38"></td>
          <td><input type="checkbox" name="horario[]" value="43"></td>
        </tr>
        <tr>
          <th>Jueves</th>
          <td><input type="checkbox" name="horario[]" value="4"></td>
          <td><input type="checkbox" name="horario[]" value="9"></td>
          <td><input type="checkbox" name="horario[]" value="14"></td>
          <td><input type="checkbox" name="horario[]" value="19"></td>
          <td><input type="checkbox" name="horario[]" value="24"></td>
          <td><input type="checkbox" name="horario[]" value="29"></td>
          <td><input type="checkbox" name="horario[]" value="34"></td>
          <td><input type="checkbox" name="horario[]" value="39"></td>
          <td><input type="checkbox" name="horario[]" value="44"></td>
        </tr>
        <tr>
          <th>Viernes</th>
          <td><input type="checkbox" name="horario[]" value="5"></td>
          <td><input type="checkbox" name="horario[]" value="10"></td>
          <td><input type="checkbox" name="horario[]" value="15"></td>
          <td><input type="checkbox" name="horario[]" value="20"></td>
          <td><input type="checkbox" name="horario[]" value="25"></td>
          <td><input type="checkbox" name="horario[]" value="30"></td>
          <td><input type="checkbox" name="horario[]" value="35"></td>
          <td><input type="checkbox" name="horario[]" value="40"></td>
          <td><input type="checkbox" name="horario[]" value="45"></td>
        </tr>
      </table>
      </div>
      <br>
  	  <p class="navbar-center navbar-form"><label for="obs">Observaciones<br>
  	  <textarea onkeydown="pulsar(event)" rows="4" cols="45" name="obser" placeholder="Observaciones"></textarea></p>
  	  <!-- Botón de confirmación -->
      <p>Presione <b>UNA</b> sola vez el botón para Confirmar y espere el mensaje.</p>
      <p><button type="button" id="submit_docentes" class="btn container_submit" onclick="guardar()">Confirmar solicitud</button>
      </form>
    </div>
  </div>


<!-- jQuery (Bootstrap JS plugins depend on it) -->
  <script src="js/jquery-3.5.1.min.js"></script>
  <script src="js/bootstrap.min.js"></script>

</body>
</html>

<script type="text/javascript">
 
var alertWarning = document.getElementById('resp-warning');
alertWarning.style.display = "none";  

var alertSuccess = document.getElementById('resp-success');
alertSuccess.style.display = "none";  

function pulsar(e) {
  if (e.which === 13 && !e.shiftKey) {
    e.preventDefault();
    console.log('prevented');
    return false;
  }
}


//Se ejecuta al dar click en "Guardar", realiza el llamado AJAX a insertarDatosDocentes.php
function guardar(){
 var grupos = document.getElementById("noGrup").value;
 if(grupos == "" || grupos<2){
  alert("El número mínimo de grupos es 2.");
 }
 var uea1 = document.getElementById("uea1").value;
 var uea2 = document.getElementById("uea2").value;
 var uea3 = document.getElementById("uea3").value;
 var uea4 = document.getElementById("uea4").value;
 if(uea1 == 0 || uea2 == 0 || uea3 == 0 || uea4 == 0){
  alert("Debe escoger 4 UEA como mínimo.");
 } 
 if(uea1 == uea2){
  alert("La primera y segunda UEA deben ser diferentes.");
 }
 formularioDocentes = document.querySelector('#form-docentes');
 const datos = new FormData(formularioDocentes);
 //console.log(...datos);
 var checkboxes = document.querySelectorAll('input[type="checkbox"]');
 var total_checkboxes=0;
 for(let k=0;k<checkboxes.length;k++){
    if(checkboxes[k].checked == true){
      total_checkboxes++;
    }
 }
 //var checkedOne = Array.prototype.slice.call(checkboxes).some(x => x.checked);
 //console.log(checkedOne);
 if(total_checkboxes >= 10){
  // crear el llamado a ajax
  const xhr = new XMLHttpRequest();
  
  // abrir la conexión.
  xhr.open('POST', '../controlador/insertarDatosDocentes.php', true);

  // retorno de datos
    xhr.onload = function() {
        if (this.status === 200) {
            const respuesta = JSON.parse(xhr.responseText);
            console.log(respuesta);

            // Si la respuesta es correcta
            if (respuesta.respuesta === 'correcto') {
                alertSuccess.innerHTML = '<h2 class="alert-heading">¡Gracias!</h2>'+'<h5>'+respuesta.mensaje+'</h5>'; 
                alertSuccess.style.display = "block";
                var contenedor = document.getElementById('contenedor-docente');
                alertWarning.style.display = "none";
                contenedor.style.display = "none";  
            } else {
                // Hubo un error
                alertWarning.innerHTML = '<h1 class="alert-heading">¡Atención!</h1>'+'<h3>'+respuesta.mensaje+'</h3>';
                alertWarning.style.display = "block";
                $('html, body').animate({scrollTop:0}, 'slow');
            }
        }
    }
    // Enviar la petición
    xhr.send(datos);
 } else {
    alert("Debe seleccionar al menos dos horarios por día.");   
 }
  
  
}

</script>