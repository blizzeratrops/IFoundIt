<?php
require_once('dbconfig.php');
require_once('user.php');

function search($query){

    $conn = conectarBD();

    $query = trim($query);

    $words = explode(" ", $query);
    $query = implode(" & ", $words);

    $sql = "SELECT a.anuncio_id as id,a.titulo as titulo,a.fecha_creacion as fecha,a.ciudad as ciudad,
            a.descripcion as descripcion,a.valor as monto,a.usr as usuario 
            FROM anuncios a
            WHERE to_tsvector(titulo || '. ' || descripcion) @@ to_tsquery('$query')
            ORDER BY a.fecha_creacion DESC;";
    /*$sql = "SELECT a.anuncio_id as id,a.titulo as titulo,a.fecha_creacion as fecha,a.ciudad as ciudad,
            a.descripcion as descripcion,a.valor as monto,a.usr as usuario
            FROM anuncios a
            WHERE a.titulo like '%$query%'
            OR a.descripcion like '%$query%'
            ORDER BY a.fecha_creacion DESC;";*/
    $stmt = runQuery($conn, $sql);
    $stmt->execute();
    //$row=$stmt->fetch(PDO::FETCH_ASSOC);
    $results = $stmt->fetchAll();
    if (!$results){
        return false;
    }
    return $results;
}