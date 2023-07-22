<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Cliente</title>
    <link rel="stylesheet" href="../../../css/index2.css">
    <link rel="stylesheet" href="../../../css/bootstrap.min.css">
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
            <a href="../../../index.php" class="btn btn-outline-success">Cerrar Sesion</a>
          </form>
        </div>
      </div>
    </div>
  </nav>
<br>
<div class="container">
    <h1 class="text-center">Cliente</h1>
    <hr>
    <form action="update_cliente.php" method="post">

    <label for="id_cr" class="form-label">Agregar cliente:</label>
    <?php
      include 'date.php';
      $conexion = new Database();
      $conexion->conectarDB();
      ?>
      
    <div class="mb-3">
      <label for="nom_cli" class="form-label">Nombre</label>
      <input type="text" name="nom_cli" class="form-control" id="exampleFormControlInput1" placeholder="Nombre">
    </div>
    
    <div class="mb-3">
      <label for="tel_cli" class="form-label">Telefono</label>
      <input type="text" name="tel_cli" class="form-control" id="exampleFormControlInput1" placeholder="Telefono">
    </div>
    

    
    <div class="col-12">
      <button type="submit" value="Enviar" class="btn btn-primary">Guardar Registro</button>
    </div>

    </form>
</div>

</body>
</html>