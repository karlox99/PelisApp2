<?php/*
    include_once 'modeloPeliDB.php';
    $pagina=isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;

    $regpagina=7;

    $inicio=($pagina>1) ? (($pagina * $regpagina)- $regpagina):0;

    $registros=$dsn->prepare("SELECT SQL_CALC_FOUND_ROWS * FROM peliculas LIMIT $inicio,
        ,$regpagina");
        
    $registros->execute();
    $registros=$registros->fetchAll();

    $totalregistros=$pdo->query("SELECT FOUND_ROWS() as total");
    $totalregistros=$totalregistros->fetch()['total'];

    $numeropaginas=ceil($totalregistros/$regpagina);