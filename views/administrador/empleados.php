<?php
require '../../config/database.php';
$db = new Database ;
$con = $db->conectar();
$sql = $con->prepare("SELECT nombre_user, f_nacimiento,apellidos_user, tel_user,  direccion_user FROM usuarios where tipo_usuario='2' ");
$sql->execute();
$resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Empleados</title>
    <link rel="stylesheet" href="../../css/bootstrap.min.css">
    <link rel="stylesheet" href="../../css/index2.css">

</head>
<body>
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
              <a class="nav-link " aria-current="page" href="funciones/listarPersonasConBusqueda.php"><b>Inventario</b></a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="empleados.php"><b>Empleados</b></a>
            </li>
            <li class="nav-item">
              <a class="nav-link " aria-current="page" href="agenda.php"><b>Agenda</b></a>
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
<br>
<div class="container">
  <div class="row">
    <div class="col col-lg-12">
    <a href="funciones/agregarempleado.php" type="button" class="btn btn-outline-primary btn-lg">Agregar Nuevo Empleado</a>  
    <a href="funciones/editarempleado.php" type="button" class="btn btn-outline-info btn-lg">Editar Empleado Existente</a>
<br>
<br>
    </div>
    <div class="col col-md-12 col-lg-12">
<!--Tabla-->
<div class="container">
<table class="table table-dark table-striped">
  <thead >
    <tr>

      <th scope="col">Nombre</th>
      <th scope="col">Apellidos</th>
      <th scope="col">Fecha de nacimiento</th>
      <th scope="col">Telefono</th>
      <th scope="col">Direccion</th>

    </tr>
  </thead>
  <tbody>
    <?php foreach($resultado as $fila): ?>
    <tr>
      <td scope="row" style="color:whitesmoke;"> <?php echo $fila ['nombre_user'] ?></td>
      <td style="color:whitesmoke;"><?php echo $fila ['apellidos_user'] ?></td>
      <td style="color:whitesmoke;"><?php echo $fila ['f_nacimiento'] ?></td>
      <td style="color:whitesmoke;"><?php echo $fila ['tel_user'] ?></td>
      <td style="color:whitesmoke;"><?php echo $fila ['direccion_user'] ?></td>
</td>
    </tr>
      <?php endforeach; ?>
  </tbody>
</table>
    </div>
  </div>
</div>



  <script src="../../js/bootstrap.min.js"></script>
</body>
</html>