<?php
require '../../config/database.php';
$db = new Database ;
$con = $db->conectar();
$sql = $con->prepare("SELECT nombre_user, f_nacimiento,apellidos_user, tel_user,  direccion_user FROM usuarios ");
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

</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark" aria-label="Offcanvas navbar large">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">WorkStack</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar2" aria-controls="offcanvasNavbar2" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="offcanvas offcanvas-end text-bg-dark" tabindex="-1" id="offcanvasNavbar2" aria-labelledby="offcanvasNavbar2Label">
        <div class="offcanvas-header">
          <h5 class="offcanvas-title" id="offcanvasNavbar2Label">Mis Atajos</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
          <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
            <li class="nav-item">
              <a class="nav-link " aria-current="page" href="index.php">Inicio</a>
            </li>
            <li class="nav-item">
              <a class="nav-link " aria-current="page" href="calendario.php">Calendario</a>
            </li>
            <li class="nav-item">
              <a class="nav-link " aria-current="page" href="funciones/listarPersonasConBusqueda.php">Inventario</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="empleados.php">Empleados</a>
            </li>
            <li class="nav-item">
              <a class="nav-link " aria-current="page" href="agenda.php">Agenda</a>
            </li>
          </ul>
          <form class="d-flex mt-3 mt-lg-0" role="search">
            <a href="../../index.php" class="btn btn-outline-success">Cerrar Sesion</a>
          </form>
        </div>
      </div>
    </div>
  </nav>
  <div class="container">
  <div class="row row-cols-4 row-cols-sm-4 row-cols-md-4 g-4">
<div class="col">
  <br>
      <!-- Button trigger modal -->
<button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
  Agregar
</button>

<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <form action="#" method="post">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <label class="form-label" for="">Nombre</label>
      <input type="nombre" id="" class="form-control form-control-lg"
                placeholder="Ingresar Nombre Carta" />
                <label class="form-label" for="">Apellidos</label>
      <input type="codigo" id="" class="form-control form-control-lg" placeholder="Ingresar Nombre" />
      <label class="form-label" for="">Fecha de nacimiento</label>
      <input type="precio" class="form-control form-control-lg" placeholder="Ingresar Apellido Paterno y Materno" />
      <label class="form-label" for="">Telefono</label>
      <input type="descuento" class="form-control form-control-lg" placeholder="Ingresar Telefono" />
      <label class="form-label" for="">Direccion</label>
      <input type="descuento" class="form-control form-control-lg" placeholder="Ingresar Direccion" />            
    </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" name="guardar" value="guardar" type="submit">Guardar</button>
      </div>
    </div>
  </div>
</div>
 
</div>

</div>
  </div>
</div>
<br>
<!--Tabla-->
<div class="container">
<table class="table table-hover">
  <thead class="table-dark">
    <tr>

      <th scope="col">Nombre</th>
      <th scope="col">Apellidos</th>
      <th scope="col">Fecha de nacimiento</th>
      <th scope="col">Telefono</th>
      <th scope="col">Direccion</th>
      <th scope="col">Opciones</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach($resultado as $fila): ?>
    <tr>
      <td scope="row"> <?php echo $fila ['nombre_user'] ?></td>
      <td><?php echo $fila ['apellidos_user'] ?></td>
      <td><?php echo $fila ['f_nacimiento'] ?></td>
      <td><?php echo $fila ['tel_user'] ?></td>
      <td><?php echo $fila ['direccion_user'] ?></td>
      <td><button type="button" class="btn btn-outline-warning">Editar</button> <button type="button" class="btn btn-outline-danger">Eliminar</button></td>
</td>
    </tr>
      <?php endforeach; ?>
  </tbody>
</table>
</div>

<script src="../../js/bootstrap.min.js"></script>
</body>
</html>