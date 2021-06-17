<?php 

$cat = $_GET['cat'];

if($cat == 'uea'){
	echo '<img src="images/ej_cat_uea.png" border="1" alt="Ejemplo del catálogo de UEA">';
} else if($cat == 'prof'){
	echo '<img src="images/ej_cat_prof.png" border="1" alt="Ejemplo del catálogo de Docentes">';
} else {
	echo '<img src="images/ej_planeacion.png" border="1" alt="Ejemplo de la Planeación de CBI">';
}

?>