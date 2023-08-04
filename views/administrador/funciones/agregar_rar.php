
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../../../css/bootstrap.min.css">
</head>
<body>

    </head>
    <body>
    
    <header>
  <!-- Fixed navbar -->
    <!-- Fixed navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark" aria-label="Offcanvas navbar large">
    <div class="container-fluid">
      <a class="navbar-brand" href="../index.php">WorkStack</a>
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
              <a class="nav-link " aria-current="page" href="../calendario.php">Calendario</a>
            </li>
            <li class="nav-item">
              <a class="nav-link " aria-current="page" href="../empleados.php">Empleados</a>
            </li>
            <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Inventario
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="listarPersonasConBusqueda.php">Inventario Carta</a></li>
            <li><a class="dropdown-item" href="listarPersonasConBusqueda2.php">Inventario Productos</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="detallar.php">Detalle Carta</a></li>
          </ul>
        </li>
            <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Agenda
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="../acreedores.php">Mis Acreedores</a></li>
            <li><a class="dropdown-item" href="../deudores_cartas.php">Mis Deudores Cartas</a></li>
            <li><a class="dropdown-item" href="../deudores_productos.php">Mis Deudores Productos</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="agregar_cliente.php">Agregar Cliente</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="agregar_comprac.php">Venta Cartas</a></li>
            <li><a class="dropdown-item" href="agregar_comprap.php">Venta Productos</a></li>
          </ul>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Registro
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="../bitacoras/upd_cartas.php">Actualizaciones En Cartas</a></li>
            <li><a class="dropdown-item" href="../bitacoras/upd_productos.php">Actualizaciones En Productos</a></li>
            <li><a class="dropdown-item" href="../bitacoras/upd_dc.php">Reporte Deuda Cartas</a></li>
            <li><a class="dropdown-item" href="../bitacoras/upd_dp.php">Reporte Deuda Productos</a></li>
            <li><a class="dropdown-item" href="../bitacoras/upd_dp.php">Reporte Acreedores</a></li>

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
    </div>
  </nav>
<br>
<div class="container" style="color: white;background-color: rgba(0, 0, 0, .550);">
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
    <button type="submit" value="Enviar" class="btn btn-outline-warning btn-g">Registrar Rareza</button>
  </div>
    </form>
</div>

<script src="../../../js/bootstrap.min.js"></script> 
<script src="../../../js/bootstrap.bundle.min.js"></script>

</body>
</html>