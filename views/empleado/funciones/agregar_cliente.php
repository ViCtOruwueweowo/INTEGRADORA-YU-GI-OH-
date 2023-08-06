<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Cliente</title>
    <link rel="stylesheet" href="../../../css/bootstrap.min.css">
    <script src="../../../js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="../../../css/index2.css">

    <?php
session_start();

// Verificar si el usuario no ha iniciado sesión
if (!isset($_SESSION['usuario'])) {
  echo "Inicia sesión primero por favor :D";
  header("refresh:2 ../../index.php");  // Redireccionamos al archivo de inicio de sesión
  exit();
}

$nombreUsuario = $_SESSION['usuario'];
?>

</head>
<body>

    </head>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark" aria-label="Offcanvas navbar large">
  <div class="container-fluid">
    <a class="navbar-brand" href="../index.php" style="color: whitesmoke; font-size: 20px; font-family: 'Times New Roman', Times, serif;">
      WorkStack
    </a>
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
            <a type="button" class="nav-link" href="../calendario.php"  data-bs-target="#staticBackdrop">
              Calendario
            </a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Mi Inventario
            </a>
            <ul class="dropdown-menu">
              <li><a href="listarPersonasConBusqueda.php" class="dropdown-item">Cartas</a></li>
              <li><a href="listarPersonasConBusqueda2.php" class="dropdown-item">Productos</a></li>
            </ul>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Mi Agenda
            </a>
            <ul class="dropdown-menu">
          <li><a href="../ac.php" class="dropdown-item">Acreedores</a></li>
          <li><a href="../deuda_c.php" class="dropdown-item">Deudores Cartas</a></li>
          <li><a href="../deuda_p.php" class="dropdown-item">Deudores Productos</a></li>
          <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="agregar_cliente.php">Agregar Cliente</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="agregar_comprac.php">Venta Cartas</a></li>
            <li><a class="dropdown-item" href="agregar_comprap.php">Venta Productos</a></li>
          </ul>
          </li>
          <li class="nav-item dropdown" >
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <?php $nombreUsuario = $_SESSION['usuario']; echo "$nombreUsuario";?>
            </a>
            <ul class="dropdown-menu">
              <li><a href="../../../config/cerrarSesion.php" class="dropdown-item">Cerrar Sesion</a></li>
            </ul>
          </li>
        </ul>
      </div>
    </div>
  </div>
</nav>

<br>
<div class="container"style="color:whitesmoke;background-color: rgba(0, 0, 0, .550);
    box-shadow: 0 4px 5px rgba(10, 2, 1, 55);">
    <h1 class="text-center">Cliente</h1>
    <hr>
    <form action="update_cliente.php" method="post">

    <?php
      include 'date.php';
      $conexion = new Database();
      $conexion->conectarDB();
      ?>
      
    <div class="mb-3">
      <label for="nom_cli" class="form-label" style='color: white;'>Nombre</label>
      <input type="text" name="nom_cli" class="form-control" id="exampleFormControlInput1" placeholder="Nombre" required>
    </div>
    
    <div class="mb-3">
    <label for="tel_cli" class="form-label" style='color: white;'>Telefono</label>
<input type="text" name="tel_cli" class="form-control" id="exampleFormControlInput1" placeholder="Telefono" pattern="^[0-9]{10}$" title="Ingrese 10 dígitos por favor" oninput="this.value = this.value.replace(/[^0-9]/g, '');" maxlength="10">

    </div>
    

    
    <div class="col-12">
      <button type="submit" value="Enviar" class="btn btn-primary">Guardar Registro</button>
    </div>

    </form>
</div>

</body>
</html>