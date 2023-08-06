<?php
session_start();

// Verificar si el usuario no ha iniciado sesión
if (!isset($_SESSION['usuario'])) {
    echo "Inicia sesión primero por favor :D";
    header("refresh:5 ../../index.php");  // Redireccionamos al archivo de inicio de sesión
    exit();
}

// Verificar si el tipo de usuario no es 1 (Tipo de usuario que puede acceder a esta página, osea el admin)
if ($_SESSION['tipo_usuario'] !== "1") { 
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
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
    <link rel="stylesheet" href="../../css/bootstrap.min.css">
    <link rel="stylesheet" href="../../img/fondo bonito.jpg">
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
              <a class="nav-link " aria-current="page" href="calendario.php">Calendario</a>
            </li>
            <li class="nav-item">
              <a class="nav-link " aria-current="page" href="empleados.php">Empleados</a>
            </li> 
            <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Inventario
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="funciones/listarPersonasConBusqueda.php">Inventario Carta</a></li>
            <li><a class="dropdown-item" href="funciones/listarPersonasConBusqueda2.php">Inventario Productos</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="funciones/detallar.php">Detalle Carta</a></li>
          </ul>
        </li>
            <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Agenda
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="acreedores.php">Mis Acreedores</a></li>
            <li><a class="dropdown-item" href="deudores_cartas.php">Mis Deudores Cartas</a></li>
            <li><a class="dropdown-item" href="deudores_productos.php">Mis Deudores Productos</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="funciones/agregar_cliente.php">Agregar Cliente</a></li>
            <li><a class="dropdown-item" href="funciones/modificar_cliente.php">Modificar Cliente</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="funciones/agregar_comprac.php">Venta Cartas</a></li>
            <li><a class="dropdown-item" href="funciones/agregar_comprap.php">Venta Productos</a></li>
          </ul>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Registro
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="bitacoras/upd_cartas.php">Actualizaciones En Cartas</a></li>
            <li><a class="dropdown-item" href="bitacoras/upd_productos.php">Actualizaciones En Productos</a></li>
            <li><a class="dropdown-item" href="bitacoras/upd_dc.php">Reporte Deuda Cartas</a></li>
            <li><a class="dropdown-item" href="bitacoras/upd_dp.php">Reporte Deuda Productos</a></li>
            <li><a class="dropdown-item" href="bitacoras/upd_acreedor.php">Reporte Acreedores</a></li>

          </ul>
        </li>
        <li class="nav-item dropdown responsive">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          <?php $nombreUsuario = $_SESSION['usuario']; echo "$nombreUsuario";?>
          </a>
          <ul class="dropdown-menu dropdown-responsive">
          <a href="../../config/cerrarSesion.php" class="dropdown-item dropdown-responsive">Cerrar Sesion</a>
          </ul>
      </li>
        </ul>
    </div>
  </div>
</nav>
<!--cabezera #212529-->
<br>
<div class="container">
<div class="row mb-2">
    <div class="col-md-12">
      <div class="row g-0 border rounded overflow-hidden flex-md-row mb-4 shadow-lg p-3 mb-5  h-md-200 position-relative" style="background-color: white;">
        <div class="col p-4 d-flex flex-column position-static">
          <h3 class="mb-0">¡Bienvenido           <?php $nombreUsuario = $_SESSION['usuario']; echo "$nombreUsuario";?>!</h3>
          <p class="card-text mb-auto">Aquí Tenemos Algunas De Las Cartas Más Vistas Por Los Visitantes</p>
        </div>
        <div class="col-auto d-none  d-lg-block">
<img src="../../img/guia.webp" style="width: 150px;" alt="">
       </div>
      </div>
    </div>
  </div> 
</div>

<?php
require '../../config/config.php';
require '../../config/database.php';
$db = new Database();
$con = $db->conectar();
$sql = $con->prepare("SELECT DISTINCT cartas.id_car, nombre_c, imagen_c, rareza.rareza,car_rar.p_beto
FROM cartas
INNER JOIN car_rar ON cartas.id_car = car_rar.id_carar
INNER JOIN rareza ON car_rar.id_rar = rareza.id_ra ORDER BY rand()
LIMIT 8;");
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

</div>

<br>

<div class="container">
<div class="row align-items-md-stretch">
      <div class="col-md-6">
        <div class="h-100 p-5 text-bg-dark rounded-3">
        <?php

$db = new Database();
$con = $db->conectar();
$sql = $con->prepare("SELECT nombre_user, f_nacimiento, apellidos_user, tel_user, direccion_user FROM usuarios WHERE tipo_usuario='2' AND estado='1'");
$sql->execute();
$resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
?>
          <h2><?php $nombreUsuario = $_SESSION['usuario']; echo "$nombreUsuario";?>, aquí están todos tus empleados.</h2>
          <p>    <?php foreach ($resultado as $fila): ?>
            <ul class="list-group list-group-flush" style="background-color: transparent;">
  <li class="list-group-item" style="background-color: transparent;color:white"><?php echo $fila['nombre_user'] ?> <?php echo $fila['apellidos_user'] ?></li>
</ul>
    <?php endforeach; $db->desconectarDB();?></p>
          <a href="empleados.php" class="btn btn-outline-light">Consultar Empleados</a>
        </div>
      </div>
      <?php

$db = new Database();
$con = $db->conectar();
$sql = $con->prepare("SELECT * from productos where existencias <= 5");
$sql->execute();
$resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
?>
      <div class="col-md-6">
        <div class="h-100 p-5 bg-light border rounded-3">
          <h2><?php $nombreUsuario = $_SESSION['usuario']; echo "$nombreUsuario";?>, parece ser que necesitas rellenar.</h2>
          <p>    <?php foreach ($resultado as $fila): ?>
            <ul class="list-group list-group-flush" style="background-color: transparent;">
  <li class="list-group-item" style="background-color: transparent;"><?php echo $fila['nom_p'] ?> </li>
</ul>
    <?php endforeach; $db->desconectarDB();?></p>         
    <a href="funciones/listarPersonasConBusqueda2.php"  class="btn btn-outline-secondary" >Consultar Productos</a>
        </div>
      </div>
    </div>
</div>

<br>

<div class="container">
<div class="row mb-2">
<div class="col-md-12">
<div class="row g-0 border rounded overflow-hidden flex-md-row mb-4 shadow-lg p-3 mb-5 h-md-250 position-relative" style="background-color: white;">
<div class="col p-4 d-flex flex-column position-static">
<h3 class="mb-0" style="text-align: center;">Todos Mis Atajos</h3>
<hr>
<div class="d-grid gap-2">
 <a href="funciones/listarPersonasConBusqueda.php" class="btn btn-outline-secondary">Inventario Productos</a>
 <a href="funciones/listarPersonasConBusqueda2.php" class="btn btn-outline-secondary">Inventario Cartas</a>
 <a href="bitacoras/upd_acreedor.php" class="btn btn-outline-secondary">Mis Clientes Favoritos</a>
 <a href="funciones/detallar.php" class="btn btn-outline-secondary">Detalles Cartas</a>


</div>
</div>
<div class="col-auto d-none d-lg-block">
<img src="../../img/albaz.png" style="width: 300px;" alt=""> 
</div>
</div>
</div>
</div> 
</div>


<script src="../../js/bootstrap.bundle.min.js"></script>
</body>
</html>
