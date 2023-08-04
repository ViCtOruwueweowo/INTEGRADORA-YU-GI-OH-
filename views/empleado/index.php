<?php
session_start();

// Verificar si el usuario no ha iniciado sesión
if (!isset($_SESSION['usuario'])) {
    echo "Inicia sesión primero por favor :D";
    header("refresh:50 ../../index.php");  // Redireccionamos al archivo de inicio de sesión
    exit();
}

// Verificar si el tipo de usuario no es 2 (Tipo de usuario que puede acceder a esta página, osea empleado)
if ($_SESSION['tipo_usuario'] !== "2") {
  echo "<div class='container' id='contenedor'>
  <div class='alert alert-danger text-center' role='alert'>
 <h1 style='text-aling:center'>¡Ups!</h1>
 <br>
 <div class='spinner-border text-dark' role='status'>
<span class='visually-hidden'>Loading...</span>
</div>
<br>
 <h6>Parece ser que no tienes acceso a este lugar, Asegurate de usar una cuenta valida</h6>
</div>
</div>   ";   
    header("refresh:5 ../../index.php");  // Redireccionamos al archivo de inicio de sesión otra vez
    exit();
}

$nombreUsuario = $_SESSION['usuario'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"> 
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Inicio Empleado</title>
<link rel="stylesheet" href="../../css/bootstrap.min.css">

<script src="../../js/bootstrap.bundle.min.js"></script>
</head>
<body style="background-color: rgba(235,235,235,255);">
<nav class="navbar navbar-expand-lg navbar-dark bg-dark" aria-label="Offcanvas navbar large">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php" style="  color: whitesmoke;
    font-size: 20px;
    font-family: 'Times New Roman', Times, serif;">WorkStack</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar2" aria-controls="offcanvasNavbar2" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
    </button>
    <div class="offcanvas offcanvas-end text-bg-dark" tabindex="-1" id="offcanvasNavbar2" aria-labelledby="offcanvasNavbar2Label">
    <div class="offcanvas-header" >
    <h5 class="offcanvas-title" id="offcanvasNavbar2Label" >Mis Atajos</h5>
    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
     <div class="offcanvas-body">
        <ul class="navbar-nav justify-content-center flex-grow-1 pe-3">
        <li class="nav-item">
          <a type="button" class="nav-link" href="calendario.php" data-bs-target="#staticBackdrop">
 Calendario 
</a>

          </li>
          <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" style=" background-color: transparent !important;
">
        Mi Inventario
          </a>
          <ul class="dropdown-menu" >
          <a href="funciones/listarPersonasConBusqueda.php" class="dropdown-item">Cartas</a>
          <a href="funciones/listarPersonasConBusqueda2.php" class="dropdown-item">Productos</a>
          </ul>
      </li>
      <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
        Mi Agenda
          </a>
          <ul class="dropdown-menu">
          <a href="ac.php" class="dropdown-item">Acreedores</a>
          <a href="deuda_c.php" class="dropdown-item">Deudores Cartas</a>
          <a href="deuda_p.php" class="dropdown-item">Deudores Productos</a>
          </ul>
      </li>
     <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          <?php $nombreUsuario = $_SESSION['usuario']; echo "$nombreUsuario";?>
          </a>
          <ul class="dropdown-menu">
          <a href="../../config/cerrarSesion.php" class="dropdown-item">Cerrar Sesion</a>
          </ul>
      </li>
        </ul>
    </div>
  </div>
</nav>
<br>
<!---->
<div class="container">
<div class="row mb-2">
    <div class="col-md-12">
      <div class="row g-0 border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-200 position-relative">
        <div class="col p-4 d-flex flex-column position-static">
          <h3 class="mb-0">¡Bienvenido           <?php $nombreUsuario = $_SESSION['usuario']; echo "$nombreUsuario";?>!</h3>
          <p class="card-text mb-auto">¡Recuerda Que En WorkStack Nos Preocupamos Por Ti!, Si Tienes Dudas Sobre Cuales Eventos Se Estaran Llevando En Todo Este Mes Da Clic Justo Sobre Mi.</p>
        </div>
        <div class="col-auto d-none  d-lg-block">
<a href="calendario.php"><img src="../../img/guia.webp" style="width: 200px;" alt=""> </a>
       </div>
      </div>
    </div>
  </div> 
</div>
<!--Cartas-->
<?php
require '../../config/config.php';
require '../../config/database.php';
$db = new Database();
$con = $db->conectar();
$sql = $con->prepare("SELECT DISTINCT cartas.id_car, nombre_c, imagen_c, rareza.rareza,car_rar.p_beto
FROM cartas
INNER JOIN car_rar ON cartas.id_car = car_rar.id_carar
INNER JOIN rareza ON car_rar.id_rar = rareza.id_ra
ORDER BY rand()
LIMIT 4;");
$sql->execute();
$resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
?>
<div class="container">
<div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 g-4 ">

<?php foreach ($resultado as $row) { ?>
  <div class="col">
    <div class="card shadow-sm " style="background-color: rgba(0, 0, 0, .550); box-shadow: 0 2px 4px rgba(10, 2, 1, 55);">
    <?php
      $id = $row['imagen_c'];
      $imagePath = "../../imagenes/productos/" . $id;
      
      // Verifica si el archivo existe con varias extensiones
      $extensionesPermitidas = array('jpg', 'jpeg', 'png', 'webp');
      $imagenEncontrada = false;
      foreach ($extensionesPermitidas as $ext) {
        if (file_exists($imagePath . "." . $ext)) {
          $imagen = $imagePath . "." . $ext;
          $imagenEncontrada = true;
          break;
        }
      }

      // Si no se encuentra ninguna imagen, utiliza una imagen predeterminada
      if (!$imagenEncontrada) {
        $imagen = "imagenes/no image.png";
      }
      ?>
      <img style="width: 100%;height: 350px;"src="<?php echo $imagen; ?>" class="img-fluid" alt="...">
      <div class="card-body">
        <h6 class="card-title text-center" style="color:white; font-size:20px; font-family: 'Times New Roman', Times, serif;"><?php echo $row['nombre_c']; ?></h6>
        <h6 class="card-title text-center" style="color:white; font-size:20px; font-family: 'Times New Roman', Times, serif;"><?php echo $row['rareza']; ?></h6>
        <div class="d-flex justify-content-between align-items-center">

        </div>

      </div>

    </div>
  </div>
<?php
}
$db->desconectarDB();
?>

    </div> 
    <div class="container">
    <br>
  <?php

$db = new Database();
$con = $db->conectar();
$sql = $con->prepare("SELECT * from productos
ORDER BY rand()
LIMIT 4;");
$sql->execute();
$resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
?>
  <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 g-4 ">

<?php foreach ($resultado as $row) { ?>
  <div class="col">
    <div class="card shadow-sm " style="background-color: rgba(0, 0, 0, .550); box-shadow: 0 2px 4px rgba(10, 2, 1, 55);">
      <?php
      $id = $row['imagen_p'];
      $imagePath = "../../imagenes/productos_2/" . $id;
      
      // Verifica si el archivo existe con varias extensiones
      $extensionesPermitidas = array('jpg', 'jpeg', 'png', 'webp');
      $imagenEncontrada = false;
      foreach ($extensionesPermitidas as $ext) {
        if (file_exists($imagePath . "." . $ext)) {
          $imagen = $imagePath . "." . $ext;
          $imagenEncontrada = true;
          break;
        }
      }

      // Si no se encuentra ninguna imagen, utiliza una imagen predeterminada
      if (!$imagenEncontrada) {
        $imagen = "imagenes/no image.png";
      }
      ?>
      <img style="width: 100%;height: 350px;"src="<?php echo $imagen; ?>" class="img-fluid" alt="...">
      <div class="card-body">
        <h6 class="card-title text-center" style="color:white; font-size:15px; font-family: 'Times New Roman', Times, serif;"><?php echo $row['nom_p']; ?></h6>
        <h6 class="card-title text-center" style="color:white; font-size:15px; font-family: 'Times New Roman', Times, serif;"><?php echo $row['precio']; ?></h6>
        <div class="d-flex justify-content-between align-items-center">

        </div>

      </div>

    </div>
  </div>
<?php
}
$db->desconectarDB();
?>

    </div>
    </div>

    <br>
    <div class="container">
    <div class="row mb-2">
    <div class="col-md-12">
      <div class="row g-0 border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-200 position-relative">
        <div class="col p-4 d-flex flex-column position-static">
          <h4 class="mb-0"><?php $nombreUsuario = $_SESSION['usuario']; echo "$nombreUsuario";?></h4>
          <p class="card-text mb-auto">Recuerda Siempre Revisar El Stock En Tienda Y Atender Al Cliente En Lo Que Necesite, ¿Necesitas Un Atajo? Aqui Lo Tienes <a href="funciones/listarPersonasConBusqueda.php" class="btn btn-primary">Visitar Inventario</a></p>
        </div>
        <div class="col-auto d-none  d-lg-block">
<img src="../../img/beto2.png" style="width: 100px;" alt="">
       </div>
      </div>
    </div>
  </div> 
    </div>
</div>

<br>
<footer class="footer mt-auto py-3 bg-dark">
<div class="container text-center">
<span class="text-center" style="color:white">Aplicacion Desarrollada Unicamente Para Fines De Venta Y Distribucion De Menores.</span>
</div>
</footer>
</body>
</html>