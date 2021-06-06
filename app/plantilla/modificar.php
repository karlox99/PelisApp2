<?php
ob_start();
?>

<table>

<form name='ALTA' method="POST" action="index.php?orden=Modificar">

<h1>Modificar película</h1>
<input type="hidden" name="codigo" id="cod_peli" readonly value="<?php echo $peli->codigo_pelicula ?>"> 	

<label for="nombre">Nombre: </label>
	<input type="text" name="titulo" id="titulo" value="<?php echo $peli->nombre ?>"/>
    </br></br>
	<label for="director">Director: </label>
	<input type="text" name="director" id="director" value="<?php echo $peli->director ?>"/>
	</br></br>
	<label for="genero">Genero: </label>
	<input type="text" name="genero" name="genero" value="<?php echo $peli->genero ?>"/>
	</br></br>
	<label for="imagen">Imagen: </label>
	<input type="file" name="imagen" name="imagen"/>
	<input type="hidden" name="imagen" value="<?php echo $peli->imagen ?>">
	</br></br>
	<label for="trailer">Trailer: </label>
	<input type="text" name="trailer" name="trailer" value="<?php echo $peli->trailer ?>"/>
	</br></br></br>
	<input type="submit" value="Modificar" />
    </form>
	
	
	
</form>


</table>
<input type="button" value=" Volver " size="10" onclick="javascript:window.location='index.php'" >
<?php 
// Vacio el bufer y lo copio a contenido
// Para que se muestre en div de contenido

$contenido = ob_get_clean();
include_once "principal.php";

?>