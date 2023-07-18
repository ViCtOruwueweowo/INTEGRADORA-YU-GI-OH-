<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../../../css/bootstrap.min.css">
    <link rel="stylesheet" href="../../../css/index2.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark" aria-label="Offcanvas navbar large">
    <div class="container-fluid">
      <a class="navbar-brand" href="../index.php">WorkStack</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar2" aria-controls="offcanvasNavbar2" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="offcanvas offcanvas-end text-bg-dark" tabindex="-1" id="offcanvasNavbar2" aria-labelledby="offcanvasNavbar2Label">
        <div class="offcanvas-header">
          <h5 class="offcanvas-title" id="offcanvasNavbar2Label"><b>Mis Atajos</b></h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
          <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
            <li class="nav-item">
              <a class="nav-link " aria-current="page" href="../calendario.php"><b>Calendario</b></a>
            </li>
            <li class="nav-item">
              <a class="nav-link " aria-current="page" href="../empleados.php"><b>Empleados</b></a>
            </li>
            <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <b>Inventario</b>
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="listarPersonasConBusqueda.php"><b>Inventario Carta</b></a></li>
            <li><a class="dropdown-item" href="listarPersonasConBusqueda2.php"><b>Inventario Productos</b></a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="detallar.php">Detalle Carta</a></li>
          </ul>
        </li>
            <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <b>Agenda</b>
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="../acreedores.php"><b>Mis Acreedores</b></a></li>
            <li><a class="dropdown-item" href="../deudores.php"><b>Mis Deudores</b></a></li>
          </ul>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <b>Registro</b>
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="../bitacoras/upd_cartas.php"><b>Actualizaciones En Cartas</b></a></li>
            <li><a class="dropdown-item" href="../bitacoras/upd_productos.php"><b>Actualizaciones En Productos</b></a></li>
            <li><a class="dropdown-item" href="../bitacoras/upd_dc.php"><b>Reporte Deuda Cartas</b></a></li>
            <li><a class="dropdown-item" href="../bitacoras/upd_dp.php"><b>Reporte Deuda Productos</b></a></li>
          </ul>
        </li>
          </ul>
          <form class="d-flex mt-3 mt-lg-0" role="search">
            <a href="../../config/cerrarSesion.php" class="btn btn-outline-success">Cerrar Sesion</a>
          </form>
        </div>
      </div>
    </div>
  </nav>
<br>
<div class="container">
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
  <input type="text" name="p_price" class="form-control" id="exampleFormControlInput1" placeholder="Link Price" require>
</div>
<div class="mb-3">
  <label for="p_tcg" class="form-label">Ingresar Link De Tcg</label>
  <input type="text" name="p_tcg" class="form-control" id="exampleFormControlInput1" placeholder="Link Tcg" require>
</div>
<div class="mb-3">
  <label for="p_beto" class="form-label">Ingresar Precio En Tienda</label>
  <input type="text" name="p_beto" class="form-control" id="exampleFormControlInput1" placeholder="Precio Local" require>
</div>
<div class="mb-3">
  <label for="codigo" class="form-label">Ingresar Codigo</label>
  <input type="text" name="codigo" class="form-control" id="exampleFormControlInput1" placeholder="Codigo" require>
</div>
<div class="mb-3">
  <label for="cantidad" class="form-label">Ingresar Cantidad</label>
  <input type="text" name="cantidad" class="form-control" id="exampleFormControlInput1" placeholder="Cantidad" require>
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