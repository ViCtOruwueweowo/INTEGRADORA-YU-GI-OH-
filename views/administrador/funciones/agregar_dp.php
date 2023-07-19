<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../../../css/bootstrap.min.css">
    <link rel="stylesheet" href="../../../css/index2.css">
    <script src="../../../js/bootstrap.bundle.min.js"></script>
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
            <li><a class="dropdown-item" href="../deudores_cartas.php"><b>Mis Deudores Cartas</b></a></li>
            <li><a class="dropdown-item" href="../deudores_productos.php"><b>Mis Deudores Productos</b></a></li>
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
    <form action="insert_dp.php" method="post">

    <label for="id_cr" class="form-label">Seleccionar cliente:</label>
    <?php
      include 'date.php';
      $conexion = new Database();
      $conexion->conectarDB();

      $consulta = "SELECT clientes.nom_cli as nombre, clientes.id_cli from clientes";
      $tabla = $conexion->seleccionar($consulta);
      echo "<select id='id_cli' name='id_cli' class='form-select'>";
      foreach ($tabla as $row)
      {
          echo "<option name='id_cli' value='".$row->id_cli."'>".$row->nombre."</option>";
      }
      echo "</select>";

echo "<br>";

echo "<label class='form-label'>Seleccionar Producto</label>";
      //carta
      $consulta = "SELECT productos.nom_p as nombre, productos.id_pro from productos";
      $tabla = $conexion->seleccionar($consulta);
      echo "<select id='id_pro' name='id_pro' class='form-select'>";
      foreach ($tabla as $row)
      {
          echo "<option name='id_pro' value='".$row->id_pro."'>".$row->nombre."</option>";
      }
      echo "</select>";
      
      ?>
      
    <div class="mb-3">
      <label for="cantidad_p" class="form-label">cantidad</label>
      <input type="text" name="cantidad_p" class="form-control" id="exampleFormControlInput1" placeholder="cantidad">
    </div>
    <div class="mb-3">
      <label for="abono_p" class="form-label">Abono</label>
      <input type="text" name="abono_p" class="form-control" id="exampleFormControlInput1" placeholder="Abono">
    </div>
    <div class="mb-3">
      <label for="notas" class="form-label">Notas</label>
      <input type="text" name="notas" class="form-control" id="exampleFormControlInput1" placeholder="Notas">
    </div>
    <label>
  <input type="radio" name="concepto" value="ENCARGO">ENCARGO
</label>
<br>
<label>
  <input type="radio" name="concepto" value="DEUDA">DEUDA
</label>

    
    <div class="col-12">
      <button type="submit" value="Enviar" class="btn btn-primary">Guardar Registro</button>
    </div>

    </form>
</div>

<script src="../../../js/bootstrap.min.js"></script> 
<script src="../../../js/bootstrap.bundle.min.js"></script>

</body>
</html>
</body>
</html>