<?php
ob_start();
?>
<h2> Error, no se encuentra ninguna coincidencia entre Titulo de pelicula, Director o Genero</h2>
</br>
<input type="button" value=" Volver " size="10" onclick="javascript:window.location='index.php'" >

<?php 
// Vacio el bufer y lo copio a contenido
// Para que se muestre en div de contenido

$contenido = ob_get_clean();
include_once "principal.php";

?>