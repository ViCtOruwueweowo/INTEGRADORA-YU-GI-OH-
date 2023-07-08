<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guardar Empleado</title>
</head>
<body>
<?php
// Establecer la conexión a la base de datos
class Database 
{

    private $hostname = "localhost";
    private $database = "workstack";
    private $username = "root";
    private $password = "";
    private $charset = "utf8";

    function conectar()
    {
        try{
        $conexion = "mysql:host=". $this->hostname . "; dbname=" . $this->database . "; charset=". $this->charset;
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_EMULATE_PREPARES => false
        ];

        $pdo = new PDO($conexion, $this->username,  $this->password , $options);

        return $pdo;
    }catch(PDOException $e){

        echo 'Error conexion:' . $e->getMessage();
        exit;
    }
    }

}

// Obtener los datos del formulario
$nombre_user = $_POST['nombre_user'];
$apellidos_user = $_POST['apellidos_user'];
$tel_user = $_POST['telefono'];
$f_nacimiento = $_POST['fechan'];
$direccion_user = $_POST['direccion'];
$usuario = $_POST['usuario'];
$contraseña = $_POST['contraseña'];
$tipo_usuario = 2;
$estado = 1;

// Insertar los datos en la base de datos
$sql = "INSERT INTO usuarios (nombre_user, apellidos_user, tel_user,f_nacimiento,direccion_user,usuario,contraseña,tipo_usuario,estado) VALUES ('$nombre_user', '$apellidos_user', '$tel_user','$f_nacimiento','$direccion_user','$usuario','$contraseña','$tipo_usuario','$estado')";
if ($conexion->query($sql) === TRUE) {
    echo "Datos agregados correctamente";
} else {
    echo "Error al agregar los datos: " . $conn->error;
}

// Cerrar la conexión a la base de datos
$conn->close();
?>

</body>
</html>