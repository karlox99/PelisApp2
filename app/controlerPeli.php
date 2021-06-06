<?php
// ------------------------------------------------
// Controlador que realiza la gestión de usuarios
// ------------------------------------------------

include_once 'config.php';
include_once 'modeloPeliDB.php'; 
include_once 'Pelicula.php';

/**********
/*
 * Inicio Muestra o procesa el formulario (POST)
 */

function  ctlPeliInicio(){
    die(" No implementado.");
   }

/*
 *  Muestra y procesa el formulario de alta 
 */

function ctlPeliAlta (){
    if  ($_SERVER['REQUEST_METHOD'] == 'GET'){
        include_once 'plantilla/fnuevo.php';
    } else {
        $peli = new Pelicula();
        $peli->nombre   = $_POST['nombre'];
        $peli->director = $_POST['director'];
        $peli->genero   = $_POST['genero'];
        $peli->trailer  = $_POST['trailer'];
        if ( isset($_FILES['imagen']['name']) ) { 
           if ( $msg = ErrordescargarPeli()){
            include_once 'plantilla/fnuevo.php';
            return;
           } else {
            $peli->imagen = $_FILES['imagen']['name'];
            
           }
        } else {
            $peli->imagen = NULL;
        }
        ModeloPeliDB::Insert($peli);
        header('Location: index.php');
    }
}

function ErrordescargarPeli(){
    $nombreFichero   =   $_FILES['imagen']['name'];
    $tipoFichero     =   $_FILES['imagen']['type'];
    $tamanioFichero  =   $_FILES['imagen']['size'];
    $temporalFichero =   $_FILES['imagen']['tmp_name'];
    $errorFichero    =   $_FILES['imagen']['error'];
    $msg=false;
    if ($errorFichero != 0 ){
        $msg="Error al subir el fichero $nombreFichero <br>";
    } else 
    if ($tipoFichero != "image/jpeg" && $tipoFichero != "image/png") {
        $msg =" Error el fichero no es una imagen jpeg o png";
    } else
    if (! move_uploaded_file($temporalFichero,'app/img/'. $nombreFichero )) {
       $msg= "ERROR: el fichero no se puede copiar en imagenes";
       return;
    }

    return $msg;
}


/*
 *  Muestra y procesa el formulario de Modificación 
 */
function ctlPeliDetalles (){
    if ( isset($_GET['codigo'])){
        $codigo = $_GET['codigo'];
        $peli = ModeloPeliDB::GetOne($codigo); 
        include_once 'plantilla/detalle.php';
    }
    
}



/*
 *  Muestra detalles de la pelicula
 */

function ctlPeliModificar(){
    //die(" No implementado.");
    if ( isset($_GET['codigo'])){
        $codigo = $_GET['codigo'];
        $peli = ModeloPeliDB::GetOne($codigo); 
        include_once 'plantilla/modificar.php';
    }
}
/*
 * Borrar Peliculas
 */

function ctlPeliBorrar(){
    
    
    $codigo = $_GET['userid'];
    $peli = ModeloPeliDB::PeliDel($codigo); 
    
    header('Location: index.php');
}
    

/*
 * Cierra la sesión y vuelca los datos
 */
function ctlPeliCerrar(){
    session_destroy();
    modeloPeliDB::closeDB();
    header('Location:index.php');
}

/*
 * Muestro la tabla con los usuario 
 */ 
function ctlPeliVerPelis (){
    // Obtengo los datos del modelo
    $peliculas = ModeloPeliDB::GetAll(); 
    // Invoco la vista 
    include_once 'plantilla/verpeliculas.php';
   
}

// Nombre
function ctlPeliBuscarNombre($nombre){
    $peli = ModeloPeliDB::ctlPeliBuscarNombre($nombre);
    include_once 'plantilla/detalle.php';
}
// Director
function ctlPeliBuscarDirector($director){
    $peli = ModeloPeliDB::ctlPeliBuscarDirector($director);
    include_once 'plantilla/detalle.php';
}
// Genero
function ctlPeliBuscarGenero($genero){
    $peli = ModeloPeliDB::ctlPeliBuscarGenero($genero);
    include_once 'plantilla/detalle.php';
}



/**
 * Busquedas de pelis, director, genero
 */
function ctlPeliBuscar (){
    if (isset($_POST['nombre']) || isset($_POST['director']) || isset($_POST['genero'])) {
        $nombre = $_POST['nombre'];
        $director = $_POST['director'];
        $genero = $_POST['genero'];   
    } 
    
    if ($nombre) {
        ctlPeliBuscarNombre($nombre);
    }
    if ($director) {
        ctlPeliBuscarDirector($director);
    }
    if ($genero) {
        ctlPeliBuscarGenero($genero);
    }
    else{
        include_once 'plantilla/errorbuscar.php';
    }
 
}

/* Trailer de peliculas */
function ctlPeliSubir(){
   $trailer = $_POST['trailer'];
   $trailer = str_replace("youtu.be","www.youtube.com/embed/", $trailer);
   

}

/* Votaciones de peliculas */
function ctlPeliVotar(){ //IFs
        ModeloUserDB::actualizarPuntos($_POST['votos'], $_GET['codigo']);
    }
 


 /*
 *  Muestra y procesa el formulario login
 */

function ctlUserLogin (){
    if  ($_SERVER['REQUEST_METHOD'] == 'GET'){
        include_once 'plantilla/fusuario.php';
    } else {
        $usuario = new Usuario();

        $usuario->nombre   = $_POST['nombre'];
        $usuario->password = $_POST['director'];


        ModeloPeliDB::Insert($usuario);
        header('Location: index.php');
    }
}