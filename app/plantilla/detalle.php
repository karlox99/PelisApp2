<?php
ob_start();
?>
<h2> Detalles </h2>
<table>
<tr><td>Código de película  </td><td> <?= $peli->codigo_pelicula ?></td></tr>
<tr><td>Nombre   </td><td>   <?= $peli->nombre ?></td></tr>
<tr><td>Director  </td><td>  <?= $peli->director ?></td></tr>
<tr><td>Genero    </td><td>  <?= $peli->genero  ?></td></tr>

<tr><td>Imagen   </td><td>   
<img class="cartel" alt="&nbsp; Imagen no disponible" src="<?='app/img/'.$peli->imagen; ?>"></img></td></tr>

<tr><td>Trailer</td><td>
<iframe width="560" height="315"
src="<?php echo $peli->trailer ?>" title="YouTube video player" frameborder="0"
allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen>
</iframe></td></tr>

</table>
<input type="button" value=" Volver " size="10" onclick="javascript:window.location='index.php'" >
<?php 
// Vacio el bufer y lo copio a contenido
// Para que se muestre en div de contenido

$contenido = ob_get_clean();
include_once "principal.php";

?>