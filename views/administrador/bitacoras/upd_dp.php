<?php
require '../../../config/database.php';
$db = new Database();
$con = $db->conectar();
$sql = $con->prepare
("SELECT * FROM reporte_actualizacion_deuda_p");
$sql->execute();
$resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RegIstro Deuda Productos</title>
    <link rel="stylesheet" href="../../../css/bootstrap.min.css">
    <link rel="stylesheet" href="../../../css/index2.css">
    <script src="../../../js/bootstrap.bundle.min.js"></script>
</head>
<body>
<!--Cabecera-->
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
            <li><a class="dropdown-item" href="../funciones/listarPersonasConBusqueda.php"><b>Inventario Carta</b></a></li>
            <li><a class="dropdown-item" href="../funciones/listarPersonasConBusqueda2.php"><b>Inventario Productos</b></a></li>
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
            <li><a class="dropdown-item" href="upd_cartas.php"><b>Actualizaciones En Cartas</b></a></li>
            <li><a class="dropdown-item" href="upd_productos.php"><b>Actualizaciones En Productos</b></a></li>
            <li><a class="dropdown-item" href="upd_dc.php"><b>Reporte Deuda Cartas</b></a></li>
            <li><a class="dropdown-item" href="upd_dp.php"><b>Reporte Deuda Productos</b></a></li>
          </ul>
        </li>
          </ul>
          <form class="d-flex mt-3 mt-lg-0" role="search">
            <a href="../../../config/cerrarSesion.php" class="btn btn-outline-success">Cerrar Sesion</a>
          </form>
        </div>
      </div>
    </div>
  </nav>
<!--Cabecera-->
<br>
<!--Creacion De La Tabla-->
<div class="container">
<h1 class="text-center">Reporte Deuda Productos</h1>
<hr>

<table class="table table-dark table-striped">
<thead>
    <tr>
      <th scope="col">Fecha Actualizacion</th>
      <th scope="col">Precio</th>
      <th scope="col">Abono</th>
      <th scope="col">Nuevos Abonos</th>
      <th scope="col">Estado Deudor</th>
    </tr>
  </thead>
  <tbody>
  <?php foreach($resultado as $fila): ?>
    <tr>
      <td scope="col" style="color:whitesmoke;"> <?php echo $fila ['fecha_actualizacion'] ?></td>
      <td style="color:whitesmoke;"><?php echo $fila ['precio'] ?></td>
      <td style="color:whitesmoke;"><?php echo $fila ['abono'] ?></td>
      <td style="color:whitesmoke;"><?php echo $fila ['upd_abono'] ?></td>
      <td style="color:whitesmoke;"><?php echo $fila ['upd_estado'] ?></td>
</td>
    </tr>
      <?php endforeach; ?>
  </tbody>
</table>
<!---->

</div>
</body>
</html>