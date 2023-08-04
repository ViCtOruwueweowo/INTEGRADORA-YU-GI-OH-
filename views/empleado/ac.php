<?php
require '../../config/database.php';
$db = new Database ;
$con = $db->conectar();
$sql = $con->prepare("SELECT * FROM clientes inner join acreedor on clientes.id_cli=acreedor.id_clientu where f_finalacreed > now() ORDER BY clientes.nom_cli DESC; ");
$sql->execute();
$resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../../css/bootstrap.min.css">
<script src="../../js/bootstrap.bundle.min.js"></script>
</head>
<body style="background-color: rgba(235,235,235,255);">

<style>
        #contendor{
            width: 80%;
            margin: auto;
        }
    </style>
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
          <li><a href="ac.php" class="dropdown-item">Acreedores</a></li>
          <li><a href="deuda_c.php" class="dropdown-item">Deudores Cartas</a></li>
          <li><a href="deuda_p.php" class="dropdown-item">Deudores Productos</a></li>
          <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="funciones/agregar_cliente.php">Agregar Cliente</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="funciones/agregar_comprac.php">Venta Cartas</a></li>
            <li><a class="dropdown-item" href="funciones/agregar_comprap.php">Venta Productos</a></li>
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
<div class="container">
<div class="table-responsive">
<table class="table table-dark table-striped">
  <thead>
    <tr>
      <th scope="col">Nombre</th>
      <th scope="col">Telefono</th>
      <th scope="col">Descuento</th>
      <th scope="col">Inicio</th>
      <th scope="col">Final</th>
      <th scope="col">Notas</th>
    </tr>
  </thead>
  <tbody>
  <?php foreach($resultado as $fila): ?>
    <tr>
      <td scope="row" style="color:whitesmoke;"> <?php echo $fila ['nom_cli'] ?></td>
      <td style="color:whitesmoke;"><?php echo $fila ['tel_cli'] ?></td>
      <td style="color:whitesmoke;"><?php echo $fila ['descuento'] ?>%</td>
      <td style="color:whitesmoke;"><?php echo $fila ['f_inicioacreed'] ?></td>
      <td style="color:whitesmoke;"><?php echo $fila ['f_finalacreed'] ?></td>
      <td style="color:whitesmoke;"><?php echo $fila ['notas_ac'] ?></td>
    </tr>
      <?php endforeach; $db->desconectarDB(); ?>
  </tbody>
</table>
</div>
<?php

$db = new Database();
$con = $db->conectar();
$sql = $con->prepare("SELECT title, descripcion, color, textColor, start, end
FROM calendario
WHERE MONTH(start) = MONTH(CURRENT_DATE) OR 
      (MONTH(start) < MONTH(CURRENT_DATE) AND MONTH(end) >= MONTH(CURRENT_DATE));");
$sql->execute();
$resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
?>
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Eventos Para El Mes</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <table class="table table-dark table-striped">
  <thead>
    <tr>
      <th scope="col">Evento</th>
      <th scope="col">Notas</th>
      <th scope="col">Inicio</th>
      <th scope="col">Fin</th>
    </tr>
  </thead>
  <tbody>
  <?php foreach($resultado as $fila): ?>
    <tr>
      <td scope="row" style="color:whitesmoke;"> <?php echo $fila ['title'] ?></td>
      <td style="color:whitesmoke;"><?php echo $fila ['descripcion'] ?></td>
      <td style="color:whitesmoke;"><?php echo $fila ['start'] ?></td>
      <td style="color:whitesmoke;"><?php echo $fila ['end'] ?></td>
    </tr>
      <?php endforeach; ?>
  </tbody>
</table>
      </div>
  
    </div>
  </div>
</div>
</div>
</body>
</html>