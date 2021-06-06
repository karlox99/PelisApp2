<?php
include_once 'app/Pelicula.php';
include 'app/paginador.php';
// Guardo la salida en un buffer(en memoria)
// No se envia al navegador
ob_start();
$auto = $_SERVER['PHP_SELF'];

?>


<form action="index.php?orden=Buscar" method="post">
    <label>Nombre:</label>
    <input type="text" name="nombre">
    &nbsp;
    <label>Director:</label>
    <input type="text" name="director">
    &nbsp;
    <label>Género:</label>
    <input type="text" name="genero">
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <input type="submit" value="Buscar" name="submit">
</form>
</br>
<table>
    <th>Código</th>
    <th>Nombre</th>
    <th>Director</th>
    <th>Genero</th>
    
    <?php 
    if($totalregistros>=1):
    foreach ($registros as $reg) : 
    ?>
        <tr>
            <td><?php echo $reg['codigo_pelicula'] ?></td>
            <td><?php echo $reg['nombre'] ?></td>
            <td><?php echo $reg['director'] ?></td>
            <td><?php echo $reg['genero'] ?></td>
            <td><a href="#" onclick="confirmarBorrar('<?= $peli->nombre . "','" . $peli->codigo_pelicula . "'" ?>);">Borrar</a></td>
            <td><a href="<?= $auto ?>?orden=Modificar&codigo=<?= $peli->codigo_pelicula ?>">Modificar</a></td>
            <td><a href="<?= $auto ?>?orden=Detalles&codigo=<?= $peli->codigo_pelicula ?>">Detalles</a></td>
        </tr>
    <?php endforeach;
          else:
    ?>
        <tr>
            <td colspan="4">No hay registros</td>
        <tr>
    <?php endif; ?>
    
    <table>
    
    </br>
        
</form>
</div>

<?php if($totalregistros>=1): ?>
                <nav aria-label="Page navigation" class="text-center">
                    <ul class="pagination">
                        <?php if($pagina==1): ?>
                        <li class="disabled">
                            <a href="#" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                        <?php else: ?>
                        <li>
                            <a href="index.php?pagina=<?php echo $pagina-1; ?>" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                        <?php 
                            endif;

                            for($i=1; $i<=$numeropaginas; $i++){
                                if($pagina==$i){
                                    echo '<li class="active">
                                        <a href="index.php?pagina='.$i.'">'.$i.'</a>
                                    </li>';
                                }else{
                                    echo '<li>
                                        <a href="index.php?pagina='.$i.'">'.$i.'</a>
                                    </li>';
                                }
                            }

                            if($pagina==$numeropaginas): 
                        ?>
                        <li class="disabled">
                            <a href="#" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                        <?php else: ?>
                        <li>
                            <a href="index.php?pagina=<?php echo $pagina+1; ?>" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                        <?php endif; ?>
                    </ul>
                </nav>
                <?php endif; ?>
                
</table>
</br>
<form name='f2' action='index.php'>
    <input type='hidden' name='orden' value='Alta'>
    <input type='submit' value='Nueva Película'>
</form>

        <form name='f3' action='index.php'>
        <th>
        <li><a href="plantilla/registro.php">Administrar usuarios</a></li>
        <th>
        </form>
    
<?php
// Vacio el bufer y lo copio a contenido
// Para que se muestre en div de contenido de la página principal
$contenido = ob_get_clean();
include_once "principal.php";

?>