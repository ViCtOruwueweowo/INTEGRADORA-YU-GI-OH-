<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<link rel="stylesheet" href="../../../css/bootstrap.min.css">
<body>
<link rel="stylesheet" href="../../../css/index2.css">
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
if (isset($_POST['id_cli'], $_POST['cantidad_c'], $_POST['notas'], $_POST['id_cr'], $_POST['abono_c'])) {
    // Obtener los datos del formulario de manera segura
    $id_cli = $_POST['id_cli'];
    $cantidad_c = $_POST['cantidad_c'];
    $notas = $_POST['notas'];
    $id_cr = $_POST['id_cr'];
    $abono_c = $_POST['abono_c'];
    $concepto = 'COMPRA';

    // Insertar los datos en la base de datos utilizando consultas preparadas
    try {
        $stmt = $conn->prepare("INSERT INTO deuda_c (id_clientec, cantidad_c, notas, cr_fk, abono_c, concepto)
                                VALUES (:id_cli, :cantidad_c, :notas, :id_cr, :abono_c, :concepto)
                                
                                UPDATE car_rar SET 
                                cantidad_c = cantidad_c - :cantidad
                                  WHERE id_cr = :cr_fk
                                
                                ");

                                

        $stmt->bindParam(':id_cli', $id_cli);
        $stmt->bindParam(':cantidad_c', $cantidad_c);
        $stmt->bindParam(':notas', $notas);
        $stmt->bindParam(':id_cr', $id_cr);
        $stmt->bindParam(':abono_c', $abono_c);
        $stmt->bindParam(':concepto', $concepto);
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
    header("refresh:3 ;agregar_comprac.php");
}


// Cerrar la conexión a la base de datos
$conn = null;
?>
<script src="../../../js/bootstrap.bundle.min.js"></script>
</body>
</html>