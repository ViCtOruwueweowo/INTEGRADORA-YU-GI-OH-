<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../../../css/bootstrap.min.css">
    <link rel="stylesheet" href="../../../css/index2.css">

    <script src="../../../js/bootstrap.bundle.min.js"></script>
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
$host = "localhost";
$dbname = "workstack";
$username = "root";
$password = "";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error de conexión a la base de datos: " . $e->getMessage());
}

// Obtener los datos del formulario
$nombre_c = $_POST['nombre_c'];
$tipo_c = $_POST['tipo_c'];

// Procesar la imagen
if (isset($_FILES['imagen'])) {
    $nombreArchivo = $_FILES['imagen']['name'];
    $archivoTemp = $_FILES['imagen']['tmp_name'];
    $rutaDestino = "../../../imagenes/productos/" . $nombreArchivo;

    // Verificar si el archivo es una imagen
    $infoImagen = getimagesize($archivoTemp);
    if ($infoImagen === false) {
        echo "<div class='container' id='contenedor'>
        <div class='alert alert-danger text-center' role='alert'>
       <h1 style='text-aling:center'>¡Ups, Algo Salio Mal!</h1>
       <br>
       <div class='spinner-border text-dark' role='status'>
    <span class='visually-hidden'>Loading...</span>
    </div>
    <br>
       <h6>Espera Estas Siendo Redirigido</h6>
      </div>";
    
        header("refresh:2 ;listarPersonasConBusqueda.php");
        exit;
    }

    if (move_uploaded_file($archivoTemp, $rutaDestino)) {
        header("refresh:0 ;agregar_rar.php");
    } else {
        echo "Hubo un error al guardar la imagen.";
        header("refresh:1 ;listarPersonasConBusqueda.php");
    }
} else {
    echo "No se ha seleccionado ninguna imagen.";
    header("refresh:1 ;listarPersonasConBusqueda.php");
    exit;
}

// Eliminar la extensión del nombre del archivo
$nombreArchivoSinExtension = pathinfo($nombreArchivo, PATHINFO_FILENAME);

// Insertar los datos en la base de datos
try {
    // Aquí guardamos el nombre del archivo sin extensión en la variable $imagen_c
    $imagen_c = $nombreArchivoSinExtension;

    // Luego, ejecutamos la consulta de inserción con el nombre del archivo en $imagen_c
    $stmt = $pdo->prepare("INSERT INTO cartas (nombre_c, imagen_c, tipo_c) VALUES (?, ?, ?)");
    $stmt->execute([$nombre_c, $imagen_c, $tipo_c]);
} catch (PDOException $e) {
    echo "<div class='container' id='contenedor'>
    <div class='alert alert-danger text-center' role='alert'>
   <h1 style='text-aling:center'>¡Ups, Algo Salio Mal!</h1>
   <br>
   <div class='spinner-border text-dark' role='status'>
<span class='visually-hidden'>Loading...</span>
</div>
<br>
   <h6>Espera Estas Siendo Redirigido</h6>
  </div>";

  echo " </div>     ";
  header("refresh:1 ;listarPersonasConBusqueda.php");

}

// Cerrar la conexión a la base de datos
$pdo = null;
?>

</body>
</html>