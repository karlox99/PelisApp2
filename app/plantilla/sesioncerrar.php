<?php

// Guardo la salida en un buffer(en memoria)
// No se envia al navegador
ob_start();

echo "Cerrando sesion";
session_destroy();

// Vacio el bufer y lo copio a contenido
// Para que se muestre en div de contenido
$contenido = ob_get_clean();
include_once "principal.php";

?>