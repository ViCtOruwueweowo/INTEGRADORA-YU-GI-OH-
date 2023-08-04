<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guardar Carta Detallada</title>
    <link rel="stylesheet" href="../../../css/bootstrap.min.css.">
    <link rel="stylesheet" href="../../../css/index2.css.">
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
} catch(PDOException $e) {
    die("Error de conexión a la base de datos: " . $e->getMessage());
}

// Verificar si los datos del formulario fueron enviados
if (isset($_POST['id_cli'], $_POST['cantidad_p'], $_POST['notas'], $_POST['id_pro'], $_POST['abono_p'])) {
    // Obtener los datos del formulario de manera segura
    $id_cli = $_POST['id_cli'];
    $cantidad_p = $_POST['cantidad_p'];
    $notas = $_POST['notas'];
    $id_pro = $_POST['id_pro'];
    $abono_p = $_POST['abono_p'];
    $concepto = 'COMPRA';

    // Insertar los datos en la base de datos utilizando consultas preparadas
    try {
        $stmt = $conn->prepare("INSERT INTO deuda_p (id_clientep, cantidad_p, notas, id_p , abono_p, concepto)
                                VALUES (:id_cli, :cantidad_p, :notas, :id_pro, :abono_p, :concepto);
                               
                                
                                ");

                                

        $stmt->bindParam(':id_cli', $id_cli);
        $stmt->bindParam(':cantidad_p', $cantidad_p);
        $stmt->bindParam(':notas', $notas);
        $stmt->bindParam(':id_pro', $id_pro);
        $stmt->bindParam(':abono_p', $abono_p);
        $stmt->bindParam(':concepto', $concepto);
        $stmt->execute();
  

      

        $stmt->execute();
        echo "<div class='container' id='contenedor'>
        <div class='alert alert-success text-center' role='alert'>
       <h1 style='text-aling:center'>¡Exito, Todos Los Cambios Fueron Realizados De Forma Exitosa, Buen Trabajo!</h1>
       <br>
       <div class='spinner-border text-dark' role='status'>
    <span class='visually-hidden'>Loading...</span>
    </div>
    <br>
       <h6>Espera Estas Siendo Redirigido</h6>
      </div>
      </div>   ";
      header("refresh:3 ;../index.php");
    } catch(PDOException $e) {
        echo "<div class='container' id='contenedor'>
        <div class='alert alert-danger text-center' role='alert'>
       <h1 style='text-aling:center'>¡Ups!</h1>
       <br>
       <div class='spinner-border text-dark' role='status'>
    <span class='visually-hidden'>Loading...</span>
    </div>
    <br>
       <h6>Algo salio mal, verifica los datos ingresados.</h6>
      </div>
      </div>   ";
    }
    header("refresh:3 ;agregar_comprap.php");
}

// Cerrar la conexión a la base de datos
$conn = null;
?>
</body>
</html>