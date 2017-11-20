<?php
require_once('dbconfig.php');
require_once('user.php');

function search($query){

    $conn = conectarBD();

    $query = trim($query);

    $words = explode(" ", $query);
    $query = implode(" & ", $words);

    $sql = "SELECT a.anuncio_id as id,a.titulo as titulo,a.fecha_creacion as fecha,c.c_name as ciudad,
            a.descripcion as descripcion,a.valor as monto,u.usr_name as usuario 
            FROM anuncios a
            JOIN ciudades c on a.ciudad = c.c_id
            JOIN usuarios u on a.usr = u.usr_id
            WHERE to_tsvector(titulo || '. ' || descripcion) @@ to_tsquery('$query')
            ORDER BY fecha DESC;";

    $stmt = runQuery($conn, $sql);
    $stmt->execute();
    //$row=$stmt->fetch(PDO::FETCH_ASSOC);
    $results = $stmt->fetchAll();
    if (!$results){
        return false;
    }
    return $results;
}