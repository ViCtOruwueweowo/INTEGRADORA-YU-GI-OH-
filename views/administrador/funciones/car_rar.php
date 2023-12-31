<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guardar Carta Detallada</title>
    <link rel="stylesheet" href="../../../css/bootstrap.min.css">
    <link rel="stylesheet" href="../../../css/index3.css">
    <script src="../../../js/bootstrap.bundle.min.js"></script>    <link rel="stylesheet" href="../../../css/index2.css">

</head>
<body>
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
$id_carar = $_POST['id_carar'];
$id_rar = $_POST['id_rar'];
$p_price = $_POST['p_price'];
$p_tcg = $_POST['p_tcg'];
$p_beto = $_POST['p_beto'];
$codigo = $_POST['codigo'];
$cantidad = $_POST['cantidad'];

// Insertar los datos en la base de datos
try {
    $stmt = $pdo->prepare("INSERT INTO car_rar (id_carar, id_rar, p_price, p_tcg, p_beto, codigo, cantidad) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$id_carar, $id_rar, $p_price, $p_tcg, $p_beto, $codigo, $cantidad]);

    echo "<div class='container' id='contenedor'>
    <div class='alert alert-success text-center' role='alert'>
   <h1 style='text-aling:center'>¡Hecho!</h1>
   <h2>Accion Realizada De Forma Exitosa
   <br>
   <div class='spinner-border text-dark' role='status'>
<span class='visually-hidden'>Loading...</span>
</div>
<br>
   <h6>Espera Estas Siendo Redirigido, Vuelve Pronto</h6>
   
  </div>
  </div>   "; 
  
    header("refresh:2 ;listarPersonasConBusqueda.php");
}  catch (PDOException $e) {
    // Obtén el mensaje de la excepción sin el código SQLSTATE
    $errorMessage = $e->getMessage();
    $errorMessage = preg_replace('/SQLSTATE\[[0-9]+\]:\s+/', '', $errorMessage);

    // Muestra el mensaje de error personalizado sin el código SQLSTATE
    echo "<div class='container' id='contenedor'>
            <div class='alert alert-danger text-center' role='alert'>
                <h1 style='text-align:center'>¡Ups!</h1>
                <h2>Parece ser que algo salió mal</h2>
                <div class='spinner-border text-dark' role='status'>
                    <span class='visually-hidden'>Loading...</span>
                </div>
                <br>
                <h6>Error:$errorMessage</h6>
            </div>
        </div>";
}

  header("refresh:1 ;agregar_rar.php");


// Cerrar la conexión a la base de datos
$pdo = null;
?>

</body>
</html>

