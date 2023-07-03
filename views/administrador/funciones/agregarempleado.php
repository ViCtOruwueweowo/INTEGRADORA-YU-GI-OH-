<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Empleado</title>
</head>
<link rel="stylesheet" href="../../../css/bootstrap.min.css">
<link rel="stylesheet" href="../../../css/index2.css">
<body>
<header>
  <!-- Fixed navbar -->
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
            <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <b>Inventario</b>
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="listarPersonasConBusqueda.php"><b>Inventario Carta</b></a></li>
            <li><a class="dropdown-item" href="listarPersonasConBusqueda2.php"><b>Inventario Productos</b></a></li>
          </ul>
        </li>
         
            <li class="nav-item">
              <a class="nav-link " aria-current="page" href="../empleados.php"><b>Empleados</b></a>
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
          </ul>
          <form class="d-flex mt-3 mt-lg-0" role="search">
            <a href="../../index.php" class="btn btn-outline-success">Cerrar Sesion</a>
          </form>
        </div>
      </div>
    </div>
  </nav>
</header>
<br>
<div class="container">
  <h1 class="text-center"></h1>
  <h1 class="text-center">Agregar Empleados</h1>
<hr>
<form action="guardar_empleado.php" method="post">


<div class="row">
  <div class="col col-lg-6 col-6">
  <label for="nombre_user" class="form-label" ><h4><b>Nombre</b></h4></label>
  <input type="text" class="form-control"id="nombre" name="nombre_user" placeholder="Ingresar nombre..">
  </div>
  <div class="col col-lg-6 col-6">
  <label for="apellidos_user" class="form-label "><h4><b>Apellidos</b></h4></label>
  <input type="text" class="form-control col-lg-6" id="apellidos_user" name="apellidos_user" placeholder="Ingresar apellidos..">
  </div>
  <div class="col col-lg-4 col-6">
  <label for="telefono" class="form-label "><h4><b>Telefono</b></h4></label>
  <input type="text" class="form-control col-lg-6" id="telefono" name="telefono" placeholder="Ingresar telefono..">
  </div>
  <div class="col col-lg-4 col-6">
  <label for="fechan" class="form-label "><h4><b>Fecha De Nacimiento</b></h4></label>
  <input type="date" class="form-control col-lg-6" id="fechan" name="fechan">
  </div>
  <div class="col col-lg-4 col-12">
  <label for="direccion" class="form-label "><h4><b>Direccion</b></h4></label>
  <input type="text" class="form-control col-lg-6" id="direccion" name="direccion" placeholder="Ingresar direccion..">
  </div>
  <div class="col col-lg-4 col-12">
  <label for="usuario" class="form-label "><h4><b>Nombre De Usuario</b></h4></label>
  <input type="text" class="form-control col-lg-6" id="usuario" name="usuario" placeholder="Ingresar nuevo nombre de usuario..">
  </div>
  <div class="col col-lg-4 col-12">
  <label for="contraseña" class="form-label "><h4><b>Contraseña</b></h4></label>
  <input type="password" class="form-control col-lg-6" id="contraseña" name="contraseña"placeholder="Ingresar nueva contraseña">
  </div>
  <div class="col col-lg-4 col-12">
  <label for="estado" class="form-label"><h4><b>Estado:</b></h4></label>
  <input type="text" class="form-control col-lg-6" id="estado" name="estado" placeholder="Ingresar estado">
  </div>
 </div>
 <br>
 
 <input type="subit" value="Enviar" class="btn btn-primary btn-lg"></input>
</form>
  
</div>
<script src="../../../js/bootstrap.min.js"></script> 
<script src="../../../js/bootstrap.bundle.min.js"></script>
</body>
</html>