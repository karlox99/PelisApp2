<?php

include_once 'config.php';
include_once 'Pelicula.php';

class ModeloPeliDB {

     private static $dbh = null; 

     private static $consulta_peli = "Select * from peliculas where codigo_pelicula = ?";
     //Busquedas
     private static $peli_nombre = "select * from peliculas where nombre=?";
     private static $peli_genero = "select * from peliculas where genero=?";
     private static $peli_director = "select * from peliculas where director=?";

     private static $insert_peli   = "Insert into peliculas (nombre,director,genero,imagen,trailer)".
                                     " VALUES (?,?,?,?,?)";

     private static $insert_usuario   = "Insert into usuarios (nombre,password)".
                                     " VALUES (?,?)";      
                                     
     private static $activar_usuario = "select * from usuarios WHERE nombre=?";
     //Borrar
     private static $delete_peli = "Delete from peliculas where codigo_pelicula = ?";
     //Actualizar
     private static $update_peli = "update peliculas set nombre=?, director=?, genero=?, imagen=?, trailer=? where codigo_pelicula=?";
     //Votos
     private static $update_puntos = "update peliculas set votaciones=votaciones+1 where codigo_pelicula=?";

     //Usuarios
     private static $insert_user = "Insert into usuarios (nombre,password)".
     " VALUES (?,?)";
    
  /*
     private static $delete_peli   = "Delete from Usuarios where id = ?"; 
     
     private static $update_user    = "UPDATE Usuarios set  clave=?, nombre =?, ".
                                     "email=?, plan=?, estado=? where id =?";

     private static $update_puntos = "update peliculas set codigo_pelicula=codigo_pelicula, nombre=nombre,
     director=director, genero=genero, imagen=imagen, trailer=trailer, votaciones=votaciones+1";
 */    
     
public static function init(){
   
    if (self::$dbh == null){
        try {
            // Cambiar  los valores de las constantes en config.php
            $dsn = "mysql:host=".DBSERVER.";dbname=".DBNAME.";charset=utf8";
            self::$dbh = new PDO($dsn,DBUSER,DBPASSWORD);
            // Si se produce un error se genera una excepción;
            self::$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e){
            echo "Error de conexión ".$e->getMessage();
            exit();
        }
        
    }
    
}



public static function insert($peli):bool{
    $stmt = self::$dbh->prepare(self::$insert_peli);
    $stmt->bindValue(1,$peli->nombre);
    $stmt->bindValue(2,$peli->director);
    $stmt->bindValue(3,$peli->genero);
    $stmt->bindValue(4,$peli->imagen );
    $stmt->bindValue(5,$peli->trailer );
    $stmt->bindValue(6,$peli->votaciones );
    //$stmt->bindValue(7,$peli->media);
    if ($stmt->execute()){
       return true;
    }
    return false; 
}

/*
public static function insert($usuario):bool{
    $stmt = self::$dbh->prepare(self::$insert_usuario);
    $stmt->bindValue(1,$usuario->nombre);
    $stmt->bindValue(2,$usuario->password);

    if ($stmt->execute()){
       return true;
    }
    return false; 
}
*/

    //Inicio Sesion del usuario
    public static function iniciarSesion($nombre, $password){
        $stmt = self::$dbh->prepare(self::$iniciarSesion);
        $stmt->bindValue(1, $nombre);
        $stmt->execute();

        $userid = $stmt->fetch(PDO::FETCH_ASSOC);

        /*if (!$userid) {
            echo '<h1>ERROR.El nombre no existe en nuestro sistema!.</h1>';
        } else {*/

        if ($password == $userid['password']) {
            $_SESSION['usuario'] = $userid['nombre'];
            echo '<h1>Inicio correcto. '.$userid['nombre'].'</h1>'; ?>
            
            <input type="button" value="Volver" size="10" onclick="javascript:window.location='index.php'">
            </br>
            <input type="button" value="Cerrar sesión" size="10" onclick="javascript:window.location='./app/plantilla/sesioncerrar.php'">
            <!--Acaba inputs, inicio php-->
            <?php

        } else {
            echo '<h1>Error al iniciar sesion.</h1>';
        }
        
    }

// Borrar un usuario (boolean)
public static function PeliDel($peli){
    $stmt = self::$dbh->prepare(self::$delete_peli);
    $stmt->bindValue(1,$peli);
    $stmt->execute();
    if ($stmt->rowCount() > 0 ){
        return true;
    }
    return false;
}

//Actualizar una peli
 public static function peliculaUpdate($nombre, $director, $genero, $imagen, $trailer){
     $stmt = self::$dbh->prepare(self::$update_peli);

     $stmt->bindValue(1, $nombre);
     $stmt->bindValue(2, $director);
     $stmt->bindValue(3, $genero);
     $stmt->bindValue(4, $imagen);
     $stmt->bindValue(5, $trailer);
     if ($stmt->execute()) {
         return true;
     } else {
         echo "ERROR en la modificacion de los datos.";
     }
 }


/***
// Actualizar un nuevo usuario (boolean)
// GUARDAR LA CLAVE CIFRADA
public static function UserUpdate ($userid, $userdat){
    $clave = $userdat[0];
    // Si no tiene valor la cambio
    if ($clave == ""){ 
        $stmt = self::$dbh->prepare(self::$update_usernopw);
        $stmt->bindValue(1,$userdat[1] );
        $stmt->bindValue(2,$userdat[2] );
        $stmt->bindValue(3,$userdat[3] );
        $stmt->bindValue(4,$userdat[4] );
        $stmt->bindValue(5,$userid);
        if ($stmt->execute ()){
            return true;
        }
    } else {
        $clave = Cifrador::cifrar($clave);
        $stmt = self::$dbh->prepare(self::$update_user);
        $stmt->bindValue(1,$clave );
        $stmt->bindValue(2,$userdat[1] );
        $stmt->bindValue(3,$userdat[2] );
        $stmt->bindValue(4,$userdat[3] );
        $stmt->bindValue(5,$userdat[4] );
        $stmt->bindValue(6,$userid);
        if ($stmt->execute ()){
            return true;
        }
    }
    return false; 
}
****/




// Tabla de objetos con todas las peliculas
public static function GetAll ():array{
    // Genero los datos para la vista que no muestra la contraseña
    
    $stmt = self::$dbh->query("select * from peliculas");
    
    $tpelis = [];
    $stmt->setFetchMode(PDO::FETCH_CLASS, 'Pelicula');
    while ( $peli = $stmt->fetch()){
        $tpelis[] = $peli;       
    }
    return $tpelis;
}

// Tabla de objetos con todas las peliculas por titulo
public static function GetTitulo ():array{
    // Genero los datos para la vista que no muestra la contraseña
    
    $stmt = self::$dbh->query("select * from peliculas where titulo = ?");
    
    $tpelis = [];
    $stmt->setFetchMode(PDO::FETCH_CLASS, 'Pelicula');
    while ( $peli = $stmt->fetch()){
        $tpelis[] = $peli;       
    }
    return $tpelis;
}



// Datos de una película para visualizar
public static function GetOne ($codigo){
    $stmt = self::$dbh->prepare(self::$consulta_peli);
    $stmt->bindValue(1,$codigo);
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_CLASS, 'Pelicula');
    $peli = $stmt->fetch();
    return $peli; // Devuele una pelicula o false    
}

public static function closeDB(){
    self::$dbh = null;
}

//Buscar por Titulo, Genero, Director, cojo una al igual que getOne

public static function ctlPeliBuscarNombre($nombre){
    $stmt = self::$dbh->prepare(self::$peli_nombre);
    $stmt->bindValue(1, $nombre);
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_CLASS, 'Pelicula');
    $peli = $stmt->fetch();
    return $peli; 
}

public static function ctlPeliBuscarGenero($genero){
    $stmt = self::$dbh->prepare(self::$peli_genero);
    $stmt->bindValue(1, $genero);
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_CLASS, 'Pelicula');
    $peli = $stmt->fetch();
    return $peli;
}



    

public static function ctlPeliBuscarDirector($director){
    $stmt = self::$dbh->prepare(self::$peli_director);
    $stmt->bindValue(1, $director);
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_CLASS, 'Pelicula');
    $peli = $stmt->fetch();
    return $peli;  
}


//Votos //$codigo-$peli
public static function actualizarPuntos($votacion, $votos, $codigo){
    $stmt = self::$dbh->prepare(self::$votacion);
    $stmt->bindValue(1, $votacion);
    $stmt->bindValue(2, $votos);
    $stmt->bindValue(3, $codigo);
    
  
    if ($stmt->execute()){
        $media =($peli->media*$peli->votaciones+$puntos)/($peli->votaciones+1);
        echo "Su voto se introducció correctamente"; ?>
         <input type="button" value="Volver" size="10" onclick="javascript:window.location='index.php'">
         <?php
    }else{
        echo "Error en las votaciones.";
    }
}

}//Class