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
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "workstack";

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error de conexión a la base de datos: " . $e->getMessage());
}
 
extract($_POST);

//hash lo hacemos variable que agarra la contraseña del form anterior
$hash = password_hash($contraseña, PASSWORD_DEFAULT);

// Obtener los datos del formulario
$nombre_user = $_POST['nombre_user']; 
$apellidos_user = $_POST['apellidos_user'];
$tel_user = $_POST['telefono'];
$f_nacimiento = $_POST['fechan'];
$direccion_user = $_POST['direccion'];
$usuario = $_POST['usuario']; 

$tipo_usuario = 2;
$estado = 1;

// Insertar los datos en la base de datos
try {
    $stmt = $pdo->prepare("INSERT INTO usuarios(nombre_user, apellidos_user, tel_user, f_nacimiento, direccion_user, usuario, contraseña, tipo_usuario, estado) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$nombre_user, $apellidos_user, $tel_user, $f_nacimiento, $direccion_user, $usuario, $hash, $tipo_usuario, $estado]);
    
    echo "Datos agregados correctamente";
    header("refresh:2 ; ../empleados.php");
} catch (PDOException $e) {
    echo "Error al agregar los datos: " . $e->getMessage();
}

// Cerrar la conexión a la base de datos
$pdo = null;
?>

</body>
</html>
