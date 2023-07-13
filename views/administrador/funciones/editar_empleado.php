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

// Obtener los datos del formulario
$nombre_user = $_POST['nombre_user'];
$tel_user = $_POST['tel_user'];
$direccion_user = $_POST['direccion_user'];
$usuario = $_POST['usuario'];
$contraseña = md5($_POST['contraseña']);
$estado = $_POST['estado'];

// Actualizar los datos en la base de datos
try {
    $stmt = $pdo->prepare("UPDATE usuarios SET 
                            nombre_user = :nombre_user,
                            tel_user = :tel_user,
                            direccion_user = :direccion_user,
                            usuario = :usuario,
                            contraseña = :contraseña,
                            estado = :estado
                            WHERE nombre_user = :nombre_user");

    $stmt->bindParam(':nombre_user', $nombre_user);
    $stmt->bindParam(':tel_user', $tel_user);
    $stmt->bindParam(':direccion_user', $direccion_user);
    $stmt->bindParam(':usuario', $usuario);
    $stmt->bindParam(':contraseña', $contraseña);
    $stmt->bindParam(':estado', $estado);
    
    $stmt->execute();

    echo "Datos actualizados correctamente";
} catch (PDOException $e) {
    echo "Error al actualizar los datos: " . $e->getMessage();
}

// Cerrar la conexión a la base de datos
$pdo = null;
?>