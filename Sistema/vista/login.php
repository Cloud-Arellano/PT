<?php
require_once "plantilla.php";
require_once "../modelo/pdo.php";
session_start();
$failure = false;
if ( isset($_POST['usuario']) && isset($_POST['pwd'])  ) {

    $sql = "SELECT idUsuario FROM usuario
        WHERE nombre = :em AND pwd = :pw";

    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
        ':em' => $_POST['usuario'], 
        ':pw' => $_POST['pwd']));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
    //var_dump($row);
   if ( $row === FALSE ) {
      $_SESSION["error"] = "Usuario o contraseña incorrecto.";
      $failure = "El usuario o contraseña es incorrecto";
   } else { 
      $_SESSION["success"] = "Logged in.";
      header("Location: menu.php?user=".urlencode(true));
      return;
   }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Inicio</title>
</head>
<body>

  <div id="main-menu" class="container">
    <div id="menu" class="jumbotron">
      <h3 id="inicio-sesion">Iniciar sesión</h3>
      <?php
          if ( $failure != false ) {
              echo('<p style="color: red; text-align: center;">'.htmlentities($failure)."</p>\n");
          }
      ?>

      <form id="login" method="post" autocomplete="off">
      <p>Usuario:<br>
      <input type="text" id="usuario" size="30" class="campo_login" name="usuario"></p>
      <p>Contraseña:<br>
      <input type="password" id="passw" size="30" class="campo_login" name="pwd"></p>
      <br>
      <p><input class="container_submit" type="submit" value="Iniciar sesión"/>
      
      </form>
    </div>
  </div>

</body>
</html>
