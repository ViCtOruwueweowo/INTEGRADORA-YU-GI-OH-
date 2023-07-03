<?php
$conexion = null;
$servidor = 'localhost';
$bd = 'workstack';
$user = 'root';
$pass = '';

try
{
    $conexion = new PDO('mysql:host='.$servidor.';dbname='.$bd, $user, $pass);
}
catch (PDOException $e)
{
    echo "Revisa la conexión wacho que me muero aaaaaaaaaaaaaaaaaaa x _ x";
    exit;
}
return $conexion;
?>