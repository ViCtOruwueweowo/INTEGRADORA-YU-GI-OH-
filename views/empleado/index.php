<?php
session_start();

// Verificar si el usuario no ha iniciado sesión
if (!isset($_SESSION['usuario'])) {
    echo "Inicia sesión primero por favor :D";
    header("refresh:5 ../../index.php");  // Redireccionamos al archivo de inicio de sesión
    exit();
}

// Verificar si el tipo de usuario no es 2 (Tipo de usuario que puede acceder a esta página, osea empleado)
if ($_SESSION['tipo_usuario'] !== "2") {
    echo "Acceso no autorizado. Por favor, inicia sesión con una cuenta válida.";
    header("refresh:5 ../../index.php");  // Redireccionamos al archivo de inicio de sesión otra vez
    exit();
}

$nombreUsuario = $_SESSION['usuario'];
?>

<?php
require '../../config/config.php';
require '../../config/database.php';
$db = new Database();
$con = $db->conectar();
$sql = $con->prepare("SELECT distinct id_car,
nombre_c, imagen_c
FROM 
cartas inner join car_rar on
cartas.id_car=car_rar.id_carar inner join rareza on
car_rar.id_rar=rareza.id_ra where rareza.id_ra>='4' ;");
$sql->execute();
$resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"> 
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Inicio</title>
<link rel="stylesheet" href="../../css/bootstrap.min.css">
<script src="../../js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="../../css/index3.css">
</head>
<body>
<style>
  /* Custom CSS for the transparent navigation bar with shadow */
  .navbar {
    background-color: transparent !important;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  }

<<<<<<< HEAD
  /* Adjust the color of the offcanvas menu content */
  .offcanvas-header {
    background-color: #333; /* Change this to your desired color */
  }

  /* Set the text color to black */
  .navbar-dark .navbar-nav .nav-link {
    color: #000;
  }
</style>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark" aria-label="Offcanvas navbar large">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php" style="color:#000">WorkStack</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar2" aria-controls="offcanvasNavbar2" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
    </button>
    <div class="offcanvas offcanvas-end text-bg-dark" tabindex="-1" id="offcanvasNavbar2" aria-labelledby="offcanvasNavbar2Label">
    <div class="offcanvas-header">
    <h5 class="offcanvas-title" id="offcanvasNavbar2Label">Mis Atajos</h5>
    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
     <div class="offcanvas-body">
        <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
          <li class="nav-item">
          <a class="nav-link" aria-current="page" href="calendario.php">Calendario</a>
          </li>
          <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          <?php $nombreUsuario = $_SESSION['usuario']; echo "$nombreUsuario";?>
          </a>
          <ul class="dropdown-menu">
          <a href="../../config/cerrarSesion.php" class="dropdown-item">Cerrar Sesion</a>
          </ul>
      </li>
=======
      <ul class="nav col-12 col-md-auto mb-2 justify-content-center mb-md-0">
        <li><a href="#" class="nav-link px-2 link-secondary">Inicio</a></li>
        <li><a href="#" class="nav-link px-2">Inventario</a></li>
        <li><a href="#" class="nav-link px-2">Productos</a></li>
      </ul>
      <?php
              $nombreUsuario = $_SESSION['usuario'];
              echo "$nombreUsuario";
              ?>
      <div class="col-md-3 text-end">
<a href="../../config/cerrarSesion.php"><button type="button" class="btn btn-primary">Cerrar Sesion</button></a>
>>>>>>> be694cb3266bb11fd8c8771a7a89866e3bff210d
      </div>
    </div>
  </div>
</nav>

<!--Contenido Del Index Del EMPLEADO--->

<br>
<div class="container">
<div class="row row-cols-2 row-cols-sm-2 row-cols-md-4 g-4 ">

        <?php foreach($resultado as $row) { ?>
        <div class="col">
          <div class="card shadow-sm " style="background-color:#212529;">
            <?php
            $id =$row[('imagen_c')];
            $imagen = "../../imagenes/productos/".$id.".jpg";
            if(!file_exists($imagen)){
              $imagen="imagenes/no image.png";
            }
            ?>
            <img src="<?php echo $imagen; ?>" class="img-fluid" alt="...">
            <div class="card-body" >
              <h6 class="card-title text-center" style="color:white;"><?php echo $row ['nombre_c']; ?></h6>
              <div  class="d-flex justify-content-between align-items-center">
    
              </div>
            
              </div>
            
          </div>
        </div>
        <?php } ?>   
    </div> 
</div>
</body>
</html>