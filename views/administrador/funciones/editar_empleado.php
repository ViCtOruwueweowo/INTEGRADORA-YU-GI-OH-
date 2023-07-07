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
$nombre_user = $_POST['nombre'];
$tel_user = $_POST['telefono'];
$direccion_user = $_POST['direccion'];
$usuario = $_POST['usuario'];
$contraseña =md5($_POST['contraseña']);
$estado = $_POST['estado'];



// Insertar los datos en la base de datos
$sql = "UPDATE usuarios SET 
    nombre_user = '$nombre_user',
    tel_user = '$tel_user',
    direccion_user = '$direccion_user',
    usuario = '$usuario',
    contraseña = '$contraseña',
    estado = $estado,
    
    estado = '$estado' where nombre_user='$nombre_user'";

if ($conn->query($sql) === TRUE) {
    echo "Datos actualizados correctamente";
} else {
    echo "Error al actualizar los datos: " . $conn->error;
}

// Cerrar la conexión a la base de datos
$conn->close();
?>