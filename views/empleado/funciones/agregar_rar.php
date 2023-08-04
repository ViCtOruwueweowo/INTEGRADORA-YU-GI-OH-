<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../../../css/bootstrap.min.css">
</head>
<body style="background-color: rgba(235,235,235,255);">


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
            <li><a class="dropdown-item" href="funciones/agregar_comprac.php">Venta Cartas</a></li>
            <li><a class="dropdown-item" href="funciones/agregar_comprap.php">Venta Productos</a></li>
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
<div class="container"style="color:whitesmoke;background-color: rgba(0, 0, 0, .550);
    box-shadow: 0 4px 5px rgba(10, 2, 1, 55);text-align:left;color:white">
    <h1 class="text-center">Especificacion Carta</h1>
    <hr>
    <form action="car_rar.php" method="post">
    <label for="id_car" class="form-label">Seleccionar Carta:</label>
    <?php
include 'date.php';
$conexion = new Database();
$conexion->conectarDB();
$consulta = "SELECT*from cartas;";
$tabla = $conexion->seleccionar($consulta);
echo "<select name='id_carar' class='form-select'>";
foreach ($tabla as $row)
{
    echo "<option name='id_carar' value='".$row->id_car."'> ".$row->nombre_c."</option>";
}
echo "</select>";

?>
    <label for="id_rar" class="form-label">Seleccionar Rareza:</label>
<?php
$consulta = "SELECT*from rareza;";
$tabla = $conexion->seleccionar($consulta);
echo "<select name='id_rar' class='form-select'>";
foreach ($tabla as $row)
{
    echo "<option name='id_rar' value='".$row->id_ra."'> ".$row->rareza."</option>";
}
echo "</select>";

?>
<div class="mb-3">
  <label for="p_price" class="form-label">Ingresar Link De Price</label>
  <input type="text" name="p_price" class="form-control" id="exampleFormControlInput1" placeholder="Link Price">
</div>
<div class="mb-3">
  <label for="p_tcg" class="form-label">Ingresar Link De Tcg</label>
  <input type="text" name="p_tcg" class="form-control" id="exampleFormControlInput1" placeholder="Link Tcg">
</div>
<div class="mb-3">
  <label for="p_beto" class="form-label">Ingresar Precio En Tienda</label>
  <input type="number" name="p_beto" class="form-control" id="exampleFormControlInput1" placeholder="Precio Local" pattern="[0-9]+" inputmode="numeric" required
        oninvalid="setCustomValidity('Por favor, ingresa números y no dejes vacío este espacio.')"
        oninput="setCustomValidity('')">
</div>
<div class="mb-3">
  <label for="codigo" class="form-label">Ingresar Codigo</label>
  <input type="text" name="codigo" maxlength="10" class="form-control" id="exampleFormControlInput1" placeholder="Codigo" required>
</div>
<div class="mb-3">
  <label for="cantidad" class="form-label">Ingresar Cantidad</label>
  <input name="cantidad" type="number" min="1" step="1" class="form-control" id="exampleFormControlInput1" placeholder="Cantidad" required>
</div>
<div class="col-12">
    <button type="submit" value="Enviar" class="btn btn-primary">Guardar Registro</button>
  </div>
    </form>
</div>

<script src="../../../js/bootstrap.min.js"></script> 
<script src="../../../js/bootstrap.bundle.min.js"></script>

</body>
</html>