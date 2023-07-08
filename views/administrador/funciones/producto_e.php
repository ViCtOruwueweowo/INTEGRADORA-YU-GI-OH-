<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../../../css/bootstrap.min.css">
</head>
<body>
<div class="container">
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
$nom_p = $_POST['nom_p'];
$existencias = $_POST['existencias'];
$precio = $_POST['precio'];
$imagen_p = $_POST['imagen_p'];
$notas_prod = $_POST['notas_prod'];

// Actualizar los datos en la base de datos
try {
    $stmt = $pdo->prepare("UPDATE productos SET 
                            nom_p = :nom_p,
                            existencias = :existencias,
                            precio = :precio,
                            imagen_p = :imagen_p,
                            notas_prod = :notas_prod
                            WHERE nom_p = :nom_p");

    $stmt->bindParam(':nom_p', $nom_p);
    $stmt->bindParam(':existencias', $existencias);
    $stmt->bindParam(':precio', $precio);
    $stmt->bindParam(':imagen_p', $imagen_p);
    $stmt->bindParam(':notas_prod', $notas_prod);
    
    $stmt->execute();

    echo "<div class='alert alert-success text-center' role='alert'>
            <a href='listarPersonasConBusqueda2.php'><h4 class='alert-heading'>¡Hecho!</h4>
            <p>Un Producto Modificado De Forma Exitosa</p></a>
          </div>";
} catch (PDOException $e) {
    echo "Error al actualizar los datos: " . $e->getMessage();
}

// Cerrar la conexión a la base de datos
$pdo = null;
?>
</div>
</body>
</html>