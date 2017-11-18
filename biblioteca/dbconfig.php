<?php
function conectarBD()
{
    $pathArchivoConexion="../config/configpostgres.inc";
    $host     = null;
    $dbname   = null;
    $port     = null;
    $user     = null;
    $password = null;

    $manejador = fopen($pathArchivoConexion, "r");
    if (!$manejador) {
        echo "No se pudo abrir el archivo de configuracion de la base de datos!!!";
    }

    $paramConexion = file($pathArchivoConexion);
    $cierreArch = fclose($manejador);
    if(!$cierreArch){
       echo "No se pudo cerrar el archivo de configuracion de la base de datos. CUIDADO!!!!";
    }

    foreach ($paramConexion as $p) 
    {
        list($param, $valor) = explode("=", $p);
        $$param = $valor;
    }
    $host     = trim($host);
    $dbname   = trim($dbname);
    $port     = trim($port);
    $user     = trim($user);
    $password = trim($password);

    try 
    {
        $conn = new PDO("pgsql:host=$host;dbname=$dbname;port=$port;",$user,$password);
        return $conn;
    } catch (PDOException $e) {
        echo "Error al conectar: " . $e->getMessage();
    } 
}
