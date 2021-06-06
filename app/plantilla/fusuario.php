<?php

// Guardo la salida en un buffer(en memoria)
// No se envia al navegador
ob_start();
?>
<div id='aviso'><b><?= (isset($msg))?$msg:"" ?></b></div>
<form name='LOGIN' enctype="multipart/form-data" method="POST" action="index.php?orden=Login">
<table>
<h1>Iniciar Sesion</h1>
<tr><td>Nombre    </td><td>   <input name="nombre" type="text" id="nombre"> </td></tr>
<tr><td>Contraseña  </td><td>  <input name="password" type="password" id="password"> </td></tr>

</table>
<input name="submit" type="submit" value="Enviar" id="submit">
<input type="button" value=" Volver " size="10" onclick="javascript:window.location='index.php'" >
</form>
<?php 
// Vacio el bufer y lo copio a contenido
// Para que se muestre en div de contenido
$contenido = ob_get_clean();
include_once "principal.php";

?>