<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guardar Carta Detallada</title>
</head>
<body>
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
$id_usr = $_POST['id_usr'];
$tel_user = $_POST['tel_user'];
$direccion_user = $_POST['direccion_user'];

$estado = $_POST['estado'];


// Insertar los datos en la base de datos
$sql = "UPDATE usuarios SET 
tel_user = '$tel_user',
direccion_user = '$direccion_user',
estado = '$estado'
 where id_usr='$id_usr'";
if ($conn->query($sql) === TRUE) {
    echo "Datos agregados correctamente";
} else {
    echo "Error al agregar los datos: " . $conn->error;
}

// Cerrar la conexión a la base de datos
$conn->close();
?>

</body>
</html>