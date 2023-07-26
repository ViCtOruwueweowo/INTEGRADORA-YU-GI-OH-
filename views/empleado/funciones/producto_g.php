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

    if (move_uploaded_file($archivoTemp, $rutaDestino)) {
        echo "<div class='alert alert-success'>Carta Guardada Con Éxito</div>";
        header("refresh:1; listarPersonasConBusqueda2.php");
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
    $stmt = $pdo->prepare("INSERT INTO productos (nom_p, existencias, precio, notas_prod, imagen_p) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$nombre_p, $existencias, $precio, $notas_prod, $imagen_c]);

    // Redireccionar después de la inserción exitosa
    echo "<div class='alert alert-success'>
    <h1 class='text-center'>Datos Actualizados Correctamente</h1></div>";
    header("refresh:1; listarPersonasConBusqueda2.php");
} catch (PDOException $e) {
    echo "Error al agregar los datos: " . $e->getMessage();
}

// Cerrar la conexión a la base de datos
$pdo = null;
?>