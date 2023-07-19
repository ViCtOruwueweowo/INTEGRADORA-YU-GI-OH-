
<?php
require '../../config/database.php';
$db = new Database ;
$con = $db->conectar();
$sql = $con->prepare("SELECT nombre_user, f_nacimiento,apellidos_user, tel_user,  direccion_user FROM usuarios where tipo_usuario='2' and estado='1'");

$sql0 = $con->prepare("SELECT nombre_user, f_nacimiento,apellidos_user, tel_user,  direccion_user FROM usuarios where tipo_usuario='2' and estado='0'");

$sql->execute();
$resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
$resultado0 = $sql->fetchAll(PDO::FETCH_ASSOC);

// Verificar si el usuario no ha iniciado sesión
//if (!isset($_SESSION['usuario'])) {
//  echo "Inicia sesión primero por favor :D";
//  header("refresh:2 ../../index.php");  // Redireccionamos al archivo de inicio de sesión
//  exit();
//}
//?>

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
              <a class="nav-link " aria-current="page" href="empleados.php"><b>Empleados</b></a>
            </li>
            <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <b>Inventario</b>
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="funciones/listarPersonasConBusqueda.php"><b>Inventario Carta</b></a></li>
            <li><a class="dropdown-item" href="funciones/listarPersonasConBusqueda2.php"><b>Inventario Productos</b></a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="funciones/detallar.php">Detalle Carta</a></li>
          </ul>
        </li>
            <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <b>Agenda</b>
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="acreedores.php"><b>Mis Acreedores</b></a></li>
            <li><a class="dropdown-item" href="deudores_cartas.php"><b>Mis Deudores Cartas</b></a></li>
            <li><a class="dropdown-item" href="deudores_productos.php"><b>Mis Deudores Productos</b></a></li>
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
        <li>
            <b>
              <?php
            //  $nombreUsuario = $_SESSION['usuario'];
             // echo "$nombreUsuario"; 
              ?>
            </b>
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
  <div class="row">
    <div class="col col-lg-12">
      <!-- Button trigger modal -->
      <h1 class="text-center">Mis Empleados</h1>
      <hr>
<button type="button" class="btn btn-danger  btn-lg" data-bs-toggle="modal" data-bs-target="#Agregar">
  Agregar Empleado
</button>


<!-- Modal -->
<div class="modal fade" id="Agregar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Nuevos Empleados</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <form action="funciones/guardar_empleado.php" method="post"> 

<div class="row">
  <div class="col-12">
  <label for="nombre_user" class="form-label" >Nombre</label> 
  <input type="text" class="form-control"id="nombre" name="nombre_user" placeholder="Ingresar nombre.."required >
  </div>
  <div class="col-12">
  <label for="apellidos_user" class="form-label ">Apellidos</label>
  <input type="text" class="form-control col-lg-6" id="apellidos_user" name="apellidos_user" placeholder="Ingresar apellidos.." required>
  </div>
  <div class="col-6">
  <label for="telefono" class="form-label ">Telefono</label>
  <input type="text" class="form-control col-lg-6" id="telefono" name="telefono" placeholder="Ingresar telefono.." required>
  </div>
  <div class="col-6">
  <label for="fechan" class="form-label ">Fecha De Nacimiento</label>
  <input type="date" class="form-control col-lg-6" id="fechan" max="2023-01-01" name="fechan" required>
  </div>
  <div class="col-12">
  <label for="direccion" class="form-label ">Direccion</label>
  <input type="text" class="form-control col-lg-6" id="direccion" name="direccion" placeholder="Ingresar direccion.." required>
  </div>
  <div class="col-6">
  <label for="usuario" class="form-label ">Nombre De Usuario</label>
  <input type="text" class="form-control col-lg-6" id="usuario" name="usuario" placeholder="Ingresar nuevo nombre de usuario.." required>
  </div>
  <div class="col-6">
  <label for="contraseña" class="form-label ">Contraseña</label>
  <input type="password" class="form-control col-lg-6" id="contraseña" name="contraseña"placeholder="Ingresar nueva contraseña">
  </div>
 </div>
      </div>
      <div class="modal-footer">
        <input type="submit" value="Enviar" class="btn btn-outline-primary btn-lg">
      </div>
      </form>
    </div>
  </div>
</div>
   <!-- Button trigger modal -->
<button type="button" class="btn btn-danger btn-lg" data-bs-toggle="modal" data-bs-target="#exampleModal">
 Editar Empleados
</button>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Editar Empleados</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <form action="funciones/editar_empleado.php" method="POST">
   
   <div class="row ">
     <div class="col-12 ">
     <label for="nombre_user">Nombre:</label>
     <input type="text" class="form-control col-lg-6" id="nombre_user" name="nombre_user" required>
     </div>
     <div class="col-12 ">
     <label for="tel_user">Telefono:</label>
     <input type="text" class="form-control col-lg-6" id="tel_user" name="tel_user" required>
     </div>
     <div class="col-12">
     <label for="direccion_user">Direccion:</label>
     <input type="text" id="direccion" class="form-control" name="direccion_user" required>
     </div>
     <div class="col-6">
     <label for="usuario">Usuario:</label>
     <input type="text" id="usuario" class="form-control" name="usuario" required>
     </div>
     <div class="col-6">
     <label for="contraseña">Contraseña:</label>
     <input type="password" id="contraseña" class="form-control" name="contraseña" required>
     </div>
     <div class="col-12">
     <label>
  <input type="radio" name="estado" value="1">ACTIVO
</label>
<br>
<label>
  <input type="radio" name="estado" value="0">inactivo
</label>
     </div>
     <div class="col-12 d-grid gap-2">
     </div>
   </div>
   
      </div>
      <div class="modal-footer">
        <input type="submit" class="btn btn-primary btn-lg" value="Enviar">
      </div>
      </form>
    </div>
  </div>
</div>
<button href="" name="inactivos" type="button" class="btn btn-outline-info btn-lg">Mostrar empleados inactivos</button>
<hr>

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
  <script src="../../js/bootstrap.bundle.min.js"></script>

</body>
</html>