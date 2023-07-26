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

    if (move_uploaded_file($archivoTemp, $rutaDestino)) {
        echo "<div class='alert alert-success'>Carta Guardada Con Éxito</div>";
        header("refresh:1 ;agregar_rar.php");
    } else {
        echo "Hubo un error al guardar la imagen.";
    }
} else {
    echo "No se ha seleccionado ninguna imagen.";
    exit; // O puedes manejar el flujo del programa según tu necesidad.
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
    echo "Error al agregar los datos: " . $e->getMessage();
}

// Cerrar la conexión a la base de datos
$pdo = null;
?>
