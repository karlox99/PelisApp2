<?php

// Guardo la salida en un buffer(en memoria)
// No se envia al navegador
ob_start();

if (isset($_POST['submit'])) {

    $nombre = $_POST['nombre'];
    $password = $_POST['password'];

    $query = $connection->prepare("SELECT * FROM usuarios WHERE nombre=:nombre");
    $query->bindParam("nombre", $nombre, PDO::PARAM_STR);
    $query->execute();

    $consulta = $query->fetch(PDO::FETCH_ASSOC);

    
}
// Vacio el bufer y lo copio a contenido
// Para que se muestre en div de contenido
$contenido = ob_get_clean();
include_once "principal.php";

?>