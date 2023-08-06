
<?php
session_start();

// Verificar si el usuario no ha iniciado sesión
if (!isset($_SESSION['usuario'])) {
    echo "Inicia sesión primero por favor :D";
    header("refresh:5 ../../index.php");  // Redireccionamos al archivo de inicio de sesión
    exit();
}

// Verificar si el tipo de usuario no es 1 (Tipo de usuario que puede acceder a esta página, osea el admin)
if ($_SESSION['tipo_usuario'] !== "1") { 
      echo "Acceso no autorizado. Por favor, inicia sesión con una cuenta válida.";
    header("refresh:5 ../../index.php");  // Redireccionamos al archivo de inicio de sesión
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
    <link rel="stylesheet" href="../../../css/bootstrap.min.css">
    <script src="../../../js/bootstrap.bundle.min.js"></script>
</head>
<body>

    </head>
    <body>
    
    <header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark" aria-label="Offcanvas navbar large">
    <div class="container-fluid">
      <a class="navbar-brand" href="../index.php">WorkStack</a>
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
              <a class="nav-link " aria-current="page" href="../calendario.php">Calendario</a>
            </li>
            <li class="nav-item">
              <a class="nav-link " aria-current="page" href="../empleados.php">Empleados</a>
            </li>
            <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Inventario
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="listarPersonasConBusqueda.php">Inventario Carta</a></li>
            <li><a class="dropdown-item" href="listarPersonasConBusqueda2.php">Inventario Productos</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="detallar.php">Detalle Carta</a></li>
          </ul>
        </li>
            <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Agenda
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="../acreedores.php">Mis Acreedores</a></li>
            <li><a class="dropdown-item" href="../deudores_cartas.php">Mis Deudores Cartas</a></li>
            <li><a class="dropdown-item" href="../deudores_productos.php">Mis Deudores Productos</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="agregar_cliente.php">Agregar Cliente</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="agregar_comprac.php">Venta Cartas</a></li>
            <li><a class="dropdown-item" href="agregar_comprap.php">Venta Productos</a></li>
          </ul>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Registro
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="../bitacoras/upd_cartas.php">Actualizaciones En Cartas</a></li>
            <li><a class="dropdown-item" href="../bitacoras/upd_productos.php">Actualizaciones En Productos</a></li>
            <li><a class="dropdown-item" href="../bitacoras/upd_dc.php">Reporte Deuda Cartas</a></li>
            <li><a class="dropdown-item" href="../bitacoras/upd_dp.php">Reporte Deuda Productos</a></li>
            <li><a class="dropdown-item" href="../bitacoras/upd_dp.php">Reporte Acreedores</a></li>

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
<link rel="stylesheet" href="../../../css/index2.css">
<br>
<div class="container d-none  d-lg-block">
<div class="row mb-2">
    <div class="col-md-12">
      <div class="row g-0 border rounded overflow-hidden flex-md-row mb-4 shadow-lg p-3 mb-5  h-md-200 position-relative" style="background-color: white;">
        <div class="col p-4 d-flex flex-column position-static">
          <h3 class="mb-0 text-start">¡Sr. <?php $nombreUsuario = $_SESSION['usuario']; echo "$nombreUsuario";?>!</h3>
          <p class="card-text mb-auto">¿No te gusto el buscador?, aqui tienes uno mas fácil de usar.</p>
        </div>
        <div class="col-auto d-none  d-lg-block">
<img src="../../../img/labrynth.png" style="width: 150px;" alt="">
       </div>
      </div>
    </div>
  </div> 
</div>
<div class="container" ">
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
    foreach ($tablaf as $registro) {
        echo "<div class='row' style='text-align:center;background-color: rgba(0, 0, 0, .550); box-shadow: 0 4px 5px rgba(10, 2, 1, 55); color: white'>";
        echo "<div class='col-6 row-cols-sm-2 row-cols-md-4 g-4'>";

        // Movemos la obtención de la imagen aquí, dentro del bucle
        $imagen_c = $registro->imagen_c;
        $imagePath = "../../../imagenes/productos/" . $imagen_c;

        // Verifica si el archivo existe con varias extensiones
        $extensionesPermitidas = array('jpg', 'jpeg', 'png', 'webp');
        $imagenEncontrada = false;
        foreach ($extensionesPermitidas as $ext) {
            if (file_exists($imagePath . "." . $ext)) {
                $imagen = $imagePath . "." . $ext;
                $imagenEncontrada = true;
                break;
            }
        }

        // Si no se encuentra ninguna imagen, utiliza una imagen predeterminada
        if (!$imagenEncontrada) {
            $imagen = "../../imagenes/no image.png";
        }

        echo "<img src='$imagen' class='img-fluid' alt='...' style='width: 250px;'>";
        echo "</div>";
        echo "<div class='col-6 col-md-6 col-lg-6'>";
        echo "<h3 class='text-center'>Nombre</h3>";
        echo "<h4>" . $registro->nombre_c . "</h4>";
        echo "<br>";
        echo "<h3 class='text-center'>Rareza</h3>";
        echo "<h4>" . $registro->rareza . "</h4>";
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