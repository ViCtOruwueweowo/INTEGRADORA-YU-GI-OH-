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


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle</title>
    <link rel="stylesheet" href="../../../css/bootstrap.min.css">
    <link rel="stylesheet" href="../../../css/index2.css">
    <link rel="stylesheet" href="../../../css/bootstrap.min.css">
    <script src="../../../js/bootstrap.bundle.min.js"></script>
</head>
<body>
  
<style>
  /* Custom CSS for the transparent navigation bar with shadow */
  .navbar {
    background-color: transparent !important;
    box-shadow: 0 10px 6px rgba(0, 0, 0, 0.1);
  }
  /* Adjust the color of the offcanvas menu content */
  .offcanvas-header {
    background-color: #333; /* Change this to your desired color */
  }

  /* Set the text color to black */
  .navbar-dark .navbar-nav .nav-link {
    color: whitesmoke;
    font-size: 20px;
    font-family: 'Times New Roman', Times, serif;
  }
</style>
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
          <ul class="navbar-nav justify-content-right flex-grow-1 pe-3">
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
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="agregar_cliente.php">Agregar Cliente</a></li>
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

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          <?php $nombreUsuario = $_SESSION['usuario']; echo "$nombreUsuario";?>
          </a>
          <ul class="dropdown-menu">
          <a href="../../config/cerrarSesion.php" class="dropdown-item">Cerrar Sesion</a>
          </ul>
      </li>
          </ul>
  
       
        </div>
      </div>
    </div>
  </nav>

<?php
    include 'date.php';
    $conexion = new database();
    $conexion->conectarDB();

    // Para el filtro
    $consulta = "SELECT id_car, nombre_c FROM cartas";
    $tabla = $conexion->seleccionar($consulta);

    // Para la tabla
    $depa = isset($_POST['depa']) ? $_POST['depa'] : '';

    if (!empty($depa)) {
        $consultaf = "SELECT * FROM cartas 
                      INNER JOIN car_rar ON cartas.id_car = car_rar.id_carar 
                      INNER JOIN rareza ON car_rar.id_rar = rareza.id_ra
                      WHERE id_car = '$depa'";
        $tablaf = $conexion->seleccionar($consultaf);
    }
?>

<br>
<div class="container" style="color: white;">
    <form class="row g-3" method="POST">
        <div class="col-auto">
            <h2>Seleccionar Carta:</h2>
        </div>

        <div class="col-auto">
            <select class="form-select" name="depa" aria-label="Default select example">
              <option value="">Selecciona Una Opcion</option>
                <?php
                    foreach($tabla as $registro) {
                        $selected = ($depa == $registro->id_car) ? 'selected' : '';
                        echo "<option value='".$registro->id_car."' ".$selected.">".$registro->nombre_c."</option>";
                    }
                ?>
            </select>
        </div>

        <div class="col-auto text-center">
            <button type="submit" class="btn btn-primary mb-3">Consultar</button>
        </div>
    </form>

    <hr>

    <?php
        if (!empty($depa)) {
            foreach($tablaf as $registro) {
                echo "<div class='row' style='text-aling:center;background-color: rgba(0, 0, 0, .550);
                box-shadow: 0 4px 5px rgba(10, 2, 1, 55); color: white'>";
                echo "<div class='col-6 row-cols-sm-2 row-cols-md-4 g-4'>";
                echo "<img src='../../../imagenes/productos/$registro->imagen_c.jpg' style='width:270px;text-aling:center'>";
                echo "</div>";
                echo "<div class='col-6 col-md-6 col-lg-6'>";
                echo "<h3 class='text-center'>Nombre</h3>";
                echo "<h4>$registro->nombre_c</h4>";
                echo "<br>";
                echo "<h3 class='text-center'>Rareza</h3>";
                echo "<h4>$registro->rareza</h4>";
                echo "<br>";
                echo "<h3 class='text-center'>Precio</h3>";
                echo "<h4>$$registro->p_beto</h4>";
                echo "<br>";
                echo "<div class='row'>";
                echo "<div class='col-6 col-md-6 col-lg-6'>";
                echo "<h3 class='text-center'>Precio En TCG</h3>";
                echo "<div class='d-grid gap-2'>";
                echo "<a href='$registro->p_tcg' class='btn btn-danger'>Consultar Tcg</a>";
                echo "</div>";
                echo "</div>";
                echo "<div class='col-6 col-md-6 col-lg-6'>";
                echo "<h3 class='text-center'>Precio En Price</h3>";
                echo "<div class='d-grid gap-2'>";
                echo "<a href='$registro->p_price' class='btn btn-danger'>Consultar Price</a>";
                echo "</div>";
                echo "</div>";
                echo "</div>";
                echo "</div>";
                echo "</div>";
                echo "<br>";
            }
        }
    ?>
</div>

</body>
</html>
