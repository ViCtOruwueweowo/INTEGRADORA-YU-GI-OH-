<?php
// Establecer la conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "workstack";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Error de conexión a la base de datos: " . $conn->connect_error);
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
$estado = $_POST['estado'];

// Insertar los datos en la base de datos
$sql = "INSERT INTO usuarios (nombre_user, apellidos_user, tel_user,f_nacimiento,direccion_user,usuario,contraseña,tipo_usuario,estado) VALUES ('$nombre_user', '$apellidos_user', '$tel_user','$f_nacimiento','$direccion_user','$usuario','$contraseña','$tipo_usuario','$estado')";
if ($conn->query($sql) === TRUE) {
    echo "Datos agregados correctamente";
} else {
    echo "Error al agregar los datos: " . $conn->error;
}

// Cerrar la conexión a la base de datos
$conn->close();
?>
