<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guardar Carta Detallada</title>
    <link rel="stylesheet" href="../../../css/index2.css">
    <link rel="stylesheet" href="../../../css/bootstrap.min.css">
</head>
<body>
<style>
    .contendor {
        width: 40%;
        margin: auto;
    }

    body {
        margin-top: 250px;
    }
</style>
<?php
// Establecer la conexión a la base de datos usando PDO
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "workstack";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Obtener los datos del formulario
    $id_usr = $_POST['id_usr'];
    $tel_user = $_POST['tel_user'];
    $direccion_user = $_POST['direccion_user'];
    $estado = $_POST['estado'];

    // Preparar y ejecutar la consulta SQL utilizando sentencias preparadas
    $sql = "UPDATE usuarios SET 
            tel_user = :tel_user,
            direccion_user = :direccion_user,
            estado = :estado
            WHERE id_usr = :id_usr";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':tel_user', $tel_user);
    $stmt->bindParam(':direccion_user', $direccion_user);
    $stmt->bindParam(':estado', $estado);
    $stmt->bindParam(':id_usr', $id_usr);

    if ($stmt->execute()) {
        echo "<div class='container' id='contenedor'>
                <div class='alert alert-success text-center' role='alert'>
                    <h1>¡Éxito!</h1>
                    <br>
                    <div class='spinner-border text-dark' role='status'>
                        <span class='visually-hidden'>Loading...</span>
                    </div>
                    <br>
                    <h6>¡Todos los cambios fueron realizados de forma exitosa, buen trabajo!</h6>
                </div>
            </div>";
            header("refresh:3 ../../administrador/empleados.php");

    } else {
        echo "<div class='container' id='contenedor'>
                <div class='alert alert-danger text-center' role='alert'>
                    <h1>¡Ups!</h1>
                    <br>
                    <div class='spinner-border text-dark' role='status'>
                        <span class='visually-hidden'>Loading...</span>
                    </div>
                    <br>
                    <h6>Algo salió mal, verifica los datos ingresados.</h6>
                </div>
            </div>";
            header("refresh:3 ../../administrador/empleados.php");

    }
} catch (PDOException $e) {
    echo "<div class='container' id='contenedor'>
    <div class='alert alert-danger text-center' role='alert'>
        <h1>¡Ups!</h1>
        <br>
        <div class='spinner-border text-dark' role='status'>
            <span class='visually-hidden'>Loading...</span>
        </div>
        <br>
        <h6>Algo salió mal, verifica los datos ingresados.</h6>
    </div>
</div>";
header("refresh:3 ../../administrador/empleados.php");

}

// Cerrar la conexión a la base de datos
$conn = null;
header("refresh:3 ../../administrador/empleados.php");
?>
</body>
</html>
