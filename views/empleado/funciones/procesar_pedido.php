
<?php
session_start();

// Verificar si el usuario no ha iniciado sesión
if (!isset($_SESSION['usuario'])) {
    echo "Inicia sesión primero por favor :D";
    header("refresh:5 ../../index.php");  // Redireccionamos al archivo de inicio de sesión
    exit();
}

// Verificar si el tipo de usuario no es 1 (Tipo de usuario que puede acceder a esta página, osea el admin)
if ($_SESSION['tipo_usuario'] !== "2") { 
      echo "Acceso no autorizado. Por favor, inicia sesión con una cuenta válida.";
    header("refresh:5 ../../index.php");  // Redireccionamos al archivo de inicio de sesión
    exit();
}

$nombreUsuario = $_SESSION['usuario'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guardar Carta Detallada</title>
    <link rel="stylesheet" href="../../../css/bootstrap.min.css">    <link rel="stylesheet" href="../../../css/index2.css">

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

    // Verificar si los datos del formulario fueron enviados
    if (isset($_POST['id_cli'], $_POST['cantidad_p'],  $_POST['id_pro'], $_POST['resultado'], $_POST['notas'])) {
        // Obtener los datos del formulario de manera segura
        $id_cli = $_POST['id_cli'];
        $cantidad_p = $_POST['cantidad_p'];
        $id_pro = $_POST['id_pro'];
        $concepto = 'COMPRA';
        $resultado = $_POST['resultado']; // Obtener el valor del campo oculto "resultado"
        $notas = $_POST['notas'];

         // Insertar los datos en la base de datos utilizando consultas preparadas
    $stmt = $conn->prepare("INSERT INTO deuda_p (id_clientep, cantidad_p, id_p, notas, concept, abono_p) VALUES (:id_cli, :cantidad_p, :id_pro, :notas, :concepto, :resultado)");


        $stmt->bindParam(':id_cli', $id_cli);
        $stmt->bindParam(':cantidad_p', $cantidad_p);
        $stmt->bindParam(':id_pro', $id_pro);
        $stmt->bindParam(':concepto', $concepto);
        $stmt->bindParam(':resultado', $resultado); // Insertar el valor del resultado en la consulta
        $stmt->bindParam(':notas', $notas);
        $stmt->execute();

        echo "<div class='container' id='contenedor'>
            <div class='alert alert-success text-center' role='alert'>
            <h1 style='text-align:center'>¡Éxito, Todos Los Cambios Fueron Realizados De Forma Exitosa, Buen Trabajo!</h1>
            <br>
            <div class='spinner-border text-dark' role='status'>
                <span class='visually-hidden'>Loading...</span>
            </div>
            <br>
            <h6>Espera Estás Siendo Redirigido</h6>
            </div>
        </div>";
        header("refresh:3; hola.php");
    }
} catch(PDOException $e) {
    echo "<div class='container' id='contenedor'>
        <div class='alert alert-danger text-center' role='alert'>
            <h1 style='text-align:center'>¡Ups!</h1>
            <br>
            <div class='spinner-border text-dark' role='status'>
                <span class='visually-hidden'>Loading...</span>
            </div>
            <br>
            <h6>Algo salió mal, verifica los datos ingresados.</h6>
        </div>
    </div>";
    header("refresh:3; hola.php");
}

// Cerrar la conexión a la base de datos
$conn = null;
?>
</body>
</html>
