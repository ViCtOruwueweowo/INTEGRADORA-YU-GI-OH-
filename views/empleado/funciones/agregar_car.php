<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../../../css/bootstrap.min.css">

</head>
<body style="background-color: rgba(235,235,235,255);">
<link rel="stylesheet" href="../../../css/index2.css">
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
    <a class="navbar-brand" href="../index.php" style="color: whitesmoke; font-size: 20px; font-family: 'Times New Roman', Times, serif;">
      WorkStack
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar2" aria-controls="offcanvasNavbar2" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="offcanvas offcanvas-end text-bg-dark" tabindex="-1" id="offcanvasNavbar2" aria-labelledby="offcanvasNavbar2Label">
      <div class="offcanvas-header"> 
        <h5 class="offcanvas-title" id="offcanvasNavbar2Label">Mis Atajos</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>
      <div class="offcanvas-body">
        <ul class="navbar-nav justify-content-center flex-grow-1 pe-3">
          <li class="nav-item">
            <a type="button" class="nav-link" href="../calendario.php"  data-bs-target="#staticBackdrop">
              Calendario
            </a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Mi Inventario
            </a>
            <ul class="dropdown-menu">
              <li><a href="listarPersonasConBusqueda.php" class="dropdown-item">Cartas</a></li>
              <li><a href="listarPersonasConBusqueda2.php" class="dropdown-item">Productos</a></li>
            </ul>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Mi Agenda
            </a>
            <ul class="dropdown-menu">
          <li><a href="../ac.php" class="dropdown-item">Acreedores</a></li>
          <li><a href="../deuda_c.php" class="dropdown-item">Deudores Cartas</a></li>
          <li><a href="../deuda_p.php" class="dropdown-item">Deudores Productos</a></li>
          <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="funciones/agregar_cliente.php">Agregar Cliente</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="hola2.php">Venta Cartas</a></li>
            <li><a class="dropdown-item" href="hola.php">Venta Productos</a></li>
          </ul>
          </li>
          <li class="nav-item dropdown" >
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <?php $nombreUsuario = $_SESSION['usuario']; echo "$nombreUsuario";?>
            </a>
            <ul class="dropdown-menu">
              <li><a href="../../../config/cerrarSesion.php" class="dropdown-item">Cerrar Sesion</a></li>
            </ul>
          </li>
        </ul>
      </div>
    </div>
  </div>
</nav>


<br>

<!---->
   <div class="container" style="color:whitesmoke;background-color: rgba(0, 0, 0, .550);
    box-shadow: 0 4px 5px rgba(10, 2, 1, 55);text-align:left;color:white">
<h1 style="text-align: center;">Agregar Carta</h1>
<hr>
<form action="guardar_carta.php" method="post" enctype="multipart/form-data">
<div class="row">
    <div class="col-12">
    <label  class="form-label">Ingresar Nombre De La Carta:</label>
    <input type="text" class="form-control col-lg-6" id="nom_p" name="nombre_c" placeholder="Nombre Carta. . ." required>
    </div>
    <div class="col-12">
    <label  class="form-label">Ingresar Tipo De Carta:</label>
    <div style="margin-top: 10px" class="col-12">
    <select class="form-control" name="tipo_c" id="tipo_c" required>
  <option value="MAGIA">MAGIA</option>
  <option value="TRAMPA">TRAMPA</option>
  <option value="MONSTRUO">MONSTRUO</option>
</select>
    </div>
    <div class="col-12">
    <label  class="form-label">Ingresar Archivo</label><br>
    <input type="file" name="imagen" accept="image/*" required>
    </div>
    
    <div class="col-12">
        <br>
    <input type="submit" class="btn btn-primary btn-lg" value="Subir imagen">
    </div>
</div>
</form>
   </div>
   <script src="../../../js/bootstrap.bundle.min.js"></script>
</body>
</html>

      
