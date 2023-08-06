<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../../../css/bootstrap.min.css">
    <link rel="stylesheet" href="../../../css/index2.css">

</head>
<body>
<?php
// Establecer la conexión a la base de datos con PDO
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "workstack";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // Establecer el modo de error PDO en excepción
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Error de conexión a la base de datos: " . $e->getMessage());
}

// Verificar si los datos del formulario fueron enviados
if (isset($_POST['id_cli'], $_POST['cantidad_p'], $_POST['notas'], $_POST['id_pro'], $_POST['abono_p'])) {
    // Obtener los datos del formulario de manera segura
    $id_cli = $_POST['id_cli'];
    $cantidad_c = $_POST['cantidad_p'];
    $notas = $_POST['notas'];
    $id_pro = $_POST['id_pro'];
    $abono_p = $_POST['abono_p'];
    $concepto = 'COMPRA';

    // Comenzar una transacción para asegurar la integridad de los datos
    $conn->beginTransaction();

    try {
        // Insertar los datos en la tabla de deuda_p utilizando una consulta preparada
        $stmt = $conn->prepare("INSERT INTO deuda_p (id_clientep, cantidad_p, notas, abono_p, concept)
                                VALUES (:id_cli, :cantidad_p, :notas, :abono_p, :concept)");
        
        $stmt->bindParam(':id_cli', $id_cli);
        $stmt->bindParam(':cantidad_p', $cantidad_p);
        $stmt->bindParam(':notas', $notas);
        $stmt->bindParam(':abono_p', $abono_p);
        $stmt->bindParam(':concept', $concepto);
        
        $stmt->execute();

        // Actualizar la tabla de productos restando existencias
        $stmt = $conn->prepare("UPDATE productos SET existencias = existencias - :cantidad_p WHERE id_pro = :id_pro");
        
        $stmt->bindParam(':cantidad_p', $cantidad_p);
        $stmt->bindParam(':id_pro', $id_pro);
        
        $stmt->execute();

        // Confirmar la transacción
        $conn->commit();

        // Mostrar mensaje de éxito
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
    } catch (PDOException $e) {
        // Revertir la transacción en caso de error
        $conn->rollBack();

        // Mostrar mensaje de error
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
            echo $e;
        header("refresh:3 ../../administrador/empleados.php");
    }
}

// Cerrar la conexión a la base de datos
$conn = null;
?>

</body>
</html>