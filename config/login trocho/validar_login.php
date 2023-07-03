<?php
if($_POST)
{
    session_start();
    require('database.php');
    $u = $_POST['usuario'];
    $p = $_POST['contraseña'];

    $conexion -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $query = $conexion->prepare("SELECT * FROM usuarios WHERE usuario= :u AND contraseña = :p");
    $query->bindParam(":u", $u);
    $query->bindParam(":p", $p );
    $query->execute();
    $usuario = $query->fetch(PDO::FETCH_ASSOC);
    $pase = 0;
    while($renglon=$usuario->fetch(PDO::FETCH_ASSOC))
    {
        if()
    }
    if($usuario)
    {
        $_SESSION['usuario'] = $usuario["usuario"];
        header("location:../views/administrador/index.php");
    }
    else
    if($usuario)
    {
        $_SESSION['usuario'] = $usuario["usuario"];
        header("location:../views/empleado/index.php");
    }
    else
    {
        echo "Usuario o contraseña incorrectos, vuelvelo a intentar :D";
        header("refresh:2 ../index.php");
    }
} 
?>
