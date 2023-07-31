<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <link rel="stylesheet" href="../../../css/index2.css">
    <link rel="stylesheet" href="../../../css/bootstrap.min.css">
    <script src="../../../js/bootstrap.bundle.min.js"></script>
    <style>
        #contendor{
            width: 40%;
            margin: auto;
        }
        body{
            margin-top: 250px;
        }
    </style>
<?php
// Establecer la conexión a la base de datos con PDO
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "workstack";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error de conexión a la base de datos: " . $e->getMessage());
}

// Obtener los datos del formulario
$id_cr = $_POST['id_cr'];
$p_price = $_POST['p_price'];
$p_tcg = $_POST['p_tcg'];
$p_beto = $_POST['p_beto'];
$cantidad = $_POST['cantidad'];

try {
    // Preparar la consulta SQL con parámetros para evitar inyección SQL
    $sql = "UPDATE car_rar SET 
            p_price = :p_price,
            p_tcg = :p_tcg,
            p_beto = :p_beto,
            cantidad = :cantidad
            WHERE id_cr = :id_cr";
    $stmt = $conn->prepare($sql);
    
    // Asignar los valores a los parámetros de la consulta
    $stmt->bindParam(':p_price', $p_price);
    $stmt->bindParam(':p_tcg', $p_tcg);
    $stmt->bindParam(':p_beto', $p_beto);
    $stmt->bindParam(':cantidad', $cantidad);
    $stmt->bindParam(':id_cr', $id_cr);
    
    // Ejecutar la consulta
    if ($stmt->execute()) {
        echo "<div class='container' id='contenedor'>
        <div class='alert alert-success text-center' role='alert'>
       <h1 style='text-aling:center'>¡Hecho!</h1>
       <h2>La Accion Fue Realizada Con Exito, Vuelve Pronto.</h2>
       <br>
       <div class='spinner-border text-dark' role='status'>
    <span class='visually-hidden'>Loading...</span>
  </div>
 
      </div>
      </div>   "; 
        header("refresh:2; listarPersonasConBusqueda.php");
    } else {
        echo "Error al actualizar los datos.";
    }
} catch (PDOException $e) {
    echo "Error al ejecutar la consulta: " . $e->getMessage();
}

// Cerrar la conexión a la base de datos
$conn = null;
?>

</body>
</html>