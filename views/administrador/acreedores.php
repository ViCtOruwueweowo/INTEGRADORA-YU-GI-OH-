<?php
require '../../config/database.php';
$db = new Database ;
$con = $db->conectar();
$sql = $con->prepare("SELECT * FROM clientes inner join acreedor on clientes.id_cli=acreedor.id_clientu");
$sql->execute();
$resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acreedores</title>
</head>
<body>
<link rel="stylesheet" href="../../css/index2.css">

<link rel="stylesheet" href="../../css/bootstrap.min.css">
<nav class="navbar navbar-expand-lg navbar-dark bg-dark" aria-label="Offcanvas navbar large">
    <div class="container-fluid">
      <a class="navbar-brand" href="index.php">WorkStack</a>
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
              <a class="nav-link " aria-current="page" href="calendario.php"><b>Calendario</b></a>
            </li>
          
         
            <li class="nav-item">
              <a class="nav-link " aria-current="page" href="empleados.php"><b>Empleados</b></a>
            </li>
            <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <b>Inventario</b>
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="funciones/listarPersonasConBusqueda.php"><b>Inventario Carta</b></a></li>
            <li><a class="dropdown-item" href="funciones/listarPersonasConBusqueda2.php"><b>Inventario Productos</b></a></li>
          </ul>
        </li>
            <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <b>Agenda</b>
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="acreedores.php"><b>Mis Acreedores</b></a></li>
            <li><a class="dropdown-item" href="deudores.php"><b>Mis Deudores</b></a></li>
          </ul>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <b>Registro</b>
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="bitacoras/upd_cartas.php"><b>Actualizaciones En Cartas</b></a></li>
            <li><a class="dropdown-item" href="bitacoras/upd_productos.php"><b>Actualizaciones En Productos</b></a></li>
            <li><a class="dropdown-item" href="bitacoras/upd_dc.php"><b>Reporte Deuda Cartas</b></a></li>
            <li><a class="dropdown-item" href="bitacoras/upd_dp.php"><b>Reporte Deuda Productos</b></a></li>
          </ul>
        </li>
          </ul>
          <form class="d-flex mt-3 mt-lg-0" role="search">
            <a href="../../index.php" class="btn btn-outline-success">Cerrar Sesion</a>
          </form>
        </div>
      </div>
    </div>
  </nav> 

 <br>

  <div class="container text-center">
 <h1>   Mis Acreedores</h1>
    <hr>
   <!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
 Agregar Nuevo Cliente
</button>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Nuevo Cliente</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body"> 
      <form action="funciones/agregar_nuevocliente.php" method="post">


<div class="row">
  <div class="col-12">
  <label for="nom_cli" class="form-label" ><h4><b>Nombre</b></h4></label>
  <input type="text" class="form-control"id="nombre" name="nom_cli" placeholder="Ingresar nombre..">
  </div>
  <div class="col-12">
  <label for="tel_cli" class="form-label "><h4><b>Teléfono</b></h4></label>
  <input type="text" class="form-control col-lg-6" id="telefono" name="tel_cli" placeholder="Ingresar apellidos..">
  </div>
 </div>
 <br>
 
 <input type="submit" value="Enviar" class="btn btn-primary btn-lg">
</form>
      </div>

    </div>
  </div>
</div>
    <hr>
  <table class="table table-dark table-striped table-hover">
  <thead>
    <tr>
      <th scope="col">Cliente</th>
      <th scope="col">Descuento</th>
      <th scope="col">Inicio</th>
      <th scope="col">Final</th>
      <th scope="col">Notas</th>
    </tr>
  </thead>
  <tbody>
  <?php foreach($resultado as $row) { ?>
    <tr>
      <th><?php echo $row ['nom_cli'] ?></th>
      <td><?php echo $row ['descuento'] ?></td>
      <td><?php echo $row ['f_inicioacreed'] ?></td>
      <td><?php echo $row ['f_finalacreed'] ?></td>
      <td><?php echo $row ['notas_ac'] ?></td>
      <?php } ?>
    </tr>
   
  </tbody>
</table>

  </div>

  
  <script src="../../js/bootstrap.bundle.min.js"></script>
</body>
</html>