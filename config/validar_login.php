<?php
if($_POST)
{
    session_start();
    require('database.php');
    $u = $_POST['usuario'];
    $p = $_POST['contraseña'];

    $conexion = new Database();
    $pdo = $conexion->conectar();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


    $query = $pdo->prepare("SELECT * FROM usuarios WHERE usuario= :u AND contraseña = :p");
    $query->bindParam(":u", $u);
    $query->bindParam(":p", $p );
    $query->execute();
    $usuario = $query->fetch(PDO::FETCH_ASSOC);


    // if($usuario)
    // {
        
    //    $_SESSION['usuario'] = $usuario["usuario"];
    //    header("location:../views/administrador/index.php");
    // }



    if ($usuario && $usuario["estado"] == 1) {
        // Usuario válido y estado es igual a 1
        $_SESSION['usuario'] = $usuario["usuario"];
        if ($usuario["tipo_usuario"] == "1") {
            header("location: ../views/administrador/index.php");
            exit();
        } else if ($usuario["tipo_usuario"] == "2") {
            header("location: ../views/empleado/index.php");
        }
            exit();




        } elseif ($usuario && $usuario["estado"] != 1) {
            // Usuario válido pero estado no es igual a 1
            echo "Mmmm, parece que eres un fantasma que vuelve a su hogar porque fuiste dado de baja :O.<br>Si injustamente fuiste enviado aquí y este no es tu destino aún, por favor habla con el Administrador más cercano, gracias :D";
            header("refresh:3 ../index.php");
            exit();
        } else {
        echo "Usuario o contraseña incorrectos, vuelvelo a intentar :D";
        header("refresh:2 ../index.php");
        exit();
    }
}
?>
