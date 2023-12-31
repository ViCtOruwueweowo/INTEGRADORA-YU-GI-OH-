<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guardar Carta Detallada</title>
    <link rel="stylesheet" href="../../../css/bootstrap.min.css.">
   
    <link rel="stylesheet" href="../../../css/index2.css">


</head>
<body>
<?php
try {
    // Establecer la conexión a la base de datos con PDO
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "workstack";

    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Obtener los datos del formulario
    $id_dp = $_POST['id_dp'];
    $cantidad_p = $_POST['cantidad_p'];
    $abono_p = $_POST['abono_p'];
    $notas = $_POST['notas'];
    $estado_p = $_POST['estado_p'];

    // Preparar la consulta para actualizar los datos en la base de datos
    $sql = "UPDATE deuda_p SET 
            cantidad_p = :cantidad,
            abono_p = abono_p+:abono_p,
            notas = :notas,
            estado_p = estado_p
            WHERE id_dp = :id;


            UPDATE productos SET 
        existencias = existencias - :cantidad
        WHERE id_pro = (SELECT id_p FROM deuda_p WHERE id_dp = :id);";

            

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':cantidad', $cantidad_p);
    $stmt->bindParam(':abono_p', $abono_p);
    $stmt->bindParam(':notas', $notas);
    $stmt->bindParam(':estado_p', $estado_p);
    $stmt->bindParam(':id', $id_dp);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        echo "<div class='alert alert-success'>
        <h1 class='text-center'>Datos Actualizados Correctamente</h1>";
  header("refresh:10; ../deudores_productos.php");
    } else {
        echo "Error al agregar los datos";
    }
} catch (PDOException $e) {
    die("Error de conexión a la base de datos: " . $e->getMessage());
}
?>


</body>
</html>