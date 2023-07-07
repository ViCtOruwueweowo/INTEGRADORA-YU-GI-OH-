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

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Error de conexión a la base de datos: " . $conn->connect_error);
}

// Obtener los datos del formulario
$nom_p= $_POST['nom_p'];
$existencias= $_POST['existencias'];
$precio = $_POST['precio'];
$imagen_p = $_POST['imagen_p'];
$notas_prod = $_POST['notas_prod'];



// Insertar los datos en la base de datos
$sql = "UPDATE productos SET 
     nom_p= '$nom_p',
    existencias = '$existencias',
    precio = '$precio',
    imagen_p = '$imagen_p',
    notas_prod='$notas_prod'

   where nom_p='$nom_p'";


if ($conn->query($sql) === TRUE) {
    echo "<div class='alert alert-success text-center'  role='alert'>
    <a href='listarPersonasConBusqueda2.php'> <h4 class='alert-heading'>¡Hecho!</h4>
     <p>Un Producto Modificado De Forma Exitosa</p> </a>
   </div>";
} else {
    echo "Error al actualizar los datos: " . $conn->error;
}

// Cerrar la conexión a la base de datos
$conn->close();
?>
</div>
</body>
</html>