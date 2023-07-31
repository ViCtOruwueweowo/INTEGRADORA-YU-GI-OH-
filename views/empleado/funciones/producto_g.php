<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../../../css/bootstrap.min.css">
    <link rel="stylesheet" href="../../../css/index3.css">
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
$nombre_p = $_POST['nom_p'];
$existencias = $_POST['existencias'];
$precio = $_POST['precio'];
$notas_prod = $_POST['notas_prod'];

// Procesar la imagen
if (isset($_FILES['imagen'])) {
    $nombreArchivo = $_FILES['imagen']['name'];
    $archivoTemp = $_FILES['imagen']['tmp_name'];
    $rutaDestino = "../../../imagenes/productos_2/" . $nombreArchivo;

    // Verificar si el archivo es una imagen
    $infoImagen = getimagesize($archivoTemp);
    if ($infoImagen === false) {
        echo "<div class='container' id='contenedor'>
        <div class='alert alert-warning text-center' role='alert'>
       <h1 style='text-aling:center'>¡Ups, Archivo Ingresado No Es Valido!</h1>
       <br>
       <div class='spinner-border text-dark' role='status'>
    <span class='visually-hidden'>Loading...</span>
  </div>
  <br>
       <h6>Espera Estas Siendo Redirigido</h6>
      </div>
      </div>   ";
        header("refresh:1 ;listarPersonasConBusqueda2.php");
        exit;
    }

    if (move_uploaded_file($archivoTemp, $rutaDestino)) {
        header("refresh:0 ;agregar_rar.php");
    } else {
        echo "Hubo un error al guardar la imagen.";
        header("refresh:1 ;listarPersonasConBusqueda2.php");
    }
} else {
    echo "No se ha seleccionado ninguna imagen.";
    header("refresh:1 ;listarPersonasConBusqueda2.php");
    exit;
}

// Eliminar la extensión del nombre del archivo
$nombreArchivoSinExtension = pathinfo($nombreArchivo, PATHINFO_FILENAME);

// Insertar los datos en la base de datos
try {
    // Aquí guardamos el nombre del archivo sin extensión en la variable $imagen_c
    $imagen_c = $nombreArchivoSinExtension;

    // Luego, ejecutamos la consulta de inserción con el nombre del archivo en $imagen_c
    $stmt = $pdo->prepare("INSERT INTO productos (nom_p, existencias, precio, notas_prod, imagen_p) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$nombre_p, $existencias, $precio, $notas_prod, $imagen_c]);

    // Redireccionar después de la inserción exitosa
    echo "<div class='container' id='contenedor'>
    <div class='alert alert-success text-center' role='alert'>
   <h1 style='text-aling:center'>¡Exito, Accion Realizada Sin Problemas!</h1>
   <br>
   <div class='spinner-border text-dark' role='status'>
<span class='visually-hidden'>Loading...</span>
</div>
<br>
   <h6>Espera Estas Siendo Redirigido</h6>
  </div>
  </div>   ";
    header("refresh:1; listarPersonasConBusqueda2.php");
} catch (PDOException $e) {
    echo "Error al agregar los datos: " . $e->getMessage();
}

// Cerrar la conexión a la base de datos
$pdo = null;
?>

</body>
</html>