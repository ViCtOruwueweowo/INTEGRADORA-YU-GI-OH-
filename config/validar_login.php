
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


    $query = $pdo->prepare("SELECT * FROM usuarios WHERE usuario= :u");
    $query->bindParam(":u", $u);
    $query->execute();
    $usuario = $query->fetch(PDO::FETCH_ASSOC);
 
    if ($usuario && $usuario["estado"] == 1) {
        // Usuario válido y estado es igual a 1
        // Verificar la contraseña proporcionada con la almacenada en la base de datos
        if (password_verify($p, $usuario["contraseña"])) {
        $_SESSION['usuario'] = $usuario["usuario"];
        if ($usuario["tipo_usuario"] == "1") {
            header("location: ../views/administrador/index.php");
            exit();

        } else if ($usuario["tipo_usuario"] == "2") {
            header("location: ../views/empleado/index.php");
        }
            exit();
        } else {
            echo "Usuario o contraseña incorrectos, vuelve a intentarlo :D";
            header("refresh:2 ../index.php");
            exit();
        }

        } elseif ($usuario && $usuario["estado"] != 1) {
            // Usuario válido pero estado no es igual a 1
            echo "Mmmm, parece que fuiste dado de baja :O.<br>Por favor habla con el Administrador más cercano para resolver dudas, gracias :D";
            header("refresh:5 ../index.php");
            exit();
        } else {
        echo "Usuario o contraseña incorrectos, vuelvelo a intentar :D";
        header("refresh:2 ../index.php");
        exit();
    }
}
?>
