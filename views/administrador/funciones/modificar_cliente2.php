<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../../../css/bootstrap.min.css">
    <script src="../../../js/bootstrap.bundle.min.js"></script>
      
    <link rel="stylesheet" href="../../../css/index2.css">
</head>
<body>
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "workstack";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $nom_cli = $_POST['nom_cli'];
    $tel_cli = $_POST['tel_cli'];

    $stmt = $conn->prepare("UPDATE clientes SET tel_cli=:tel_cli WHERE nom_cli=:nom_cli");
    

    $stmt->bindParam(':nom_cli', $nom_cli);
    $stmt->bindParam(':tel_cli', $tel_cli);

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
}

$conn = null;

header("refresh:3; url=../index.php");
?>

</body>
</html>