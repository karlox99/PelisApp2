<?php

// Guardo la salida en un buffer(en memoria)
// No se envia al navegador
ob_start();
?>
<div id='aviso'><b><?= (isset($msg))?$msg:"" ?></b></div>
<form name='VOTAR' enctype="multipart/form-data" method="POST"
      action="index.php?orden=Votar&codigo=<?php echo $codigo ?>">
<table>
<h1>Vote por su pelicula</h1>
    <select name="votos" id="votos">
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
    </select>

</table>
<input type="submit" value="Enviar">
</br>
<input type="button" value=" Volver " size="10" onclick="javascript:window.location='index.php'" >
</form>
<?php 
// Vacio el bufer y lo copio a contenido
// Para que se muestre en div de contenido
$contenido = ob_get_clean();
include_once "principal.php";

?>