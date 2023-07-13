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
            <li><a class="dropdown-item" href="../deudores.php"><b>Mis Deudores</b></a></li>
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
<?php
        include 'date.php';
        $conexion = new database();
        $conexion->conectarDB();

        //para el filtro
        $consulta = "SELECT id_car, nombre_c FROM cartas";  
        $tabla = $conexion->seleccionar($consulta);

        //para la tabla
        extract($_POST);
        $consultaf = "SELECT * FROM 
        cartas inner join car_rar on
        cartas.id_car=car_rar.id_carar inner join rareza on
        car_rar.id_rar=rareza.id_ra  WHERE id_car=('$depa')";  
        $tablaf = $conexion->seleccionar($consultaf);
?>

<br>
    <div class="container">
<form class="row g-3" method="POST">
  <div class="col-auto">
<h2>Seleccionar Carta:</h2>
</div>

    <div class="col-auto">
        <select class="form-select" name="depa" aria-label="Default select example">
    </div>
  
        <?php
            $tabla = $conexion->seleccionar($consulta);

            foreach($tabla as $registro)
            {
                echo "<option value='".$registro->id_car."'>".$registro->nombre_c."</option>";
            }
        ?>
        </select>
     </div>

  <div class="col-auto">
    <button type="submit" class="btn btn-primary mb-3">Consultar</button>
  </div>
  <br>
  <hr>
</form>

<?php
  
 
  
  if (isset($_POST['depa']))
  {


    foreach($tablaf as $registro)
          {
            echo "<div class=row style='background-color: rgba(0, 0, 0, 0.500);; ;color:white'>";  
            echo "<div class=col-6 row-cols-sm-2 row-cols-md-4 g-4>";
            echo "<img src='../../../imagenes/productos/$registro->imagen_c.jpg' style='width:270px'> ";
            echo "</div>";
            echo "<div class=col-6 col-md-6 col-lg-6>";          
            echo       "<h3 class='text-center'>Nombre            </h3>";
            echo         " <h4> $registro->nombre_c</h4>";
            echo "<br>";
            echo       "<h3 class='text-center'>rareza            </h3>";
            echo         " <h4> $registro->rareza</h4>";
            echo "<br>";
            echo       "<h3 class='text-center'>Precio          </h3>";
            echo         " <h4>$$registro->p_beto</h4>";
            echo "<br>";
echo "<div class=row>";  
echo "<div class=col-6 col-md-6 col-lg-6>";
echo       "<h3 class='text-center'>Precio En TCG           </h3>";
echo "<div class='d-grid gap-2'>";
echo         "<a href='$registro->p_tcg'  class='btn btn-danger'> Consultar Tcg </a>";
echo "</div>"; 
echo "</div>";
echo "<div class=col-6 col-md-6 col-lg-6>";
echo       "<h3 class='text-center'>Precio En Price       </h3>";
echo "<div class='d-grid gap-2'>";
echo         "<a href='$registro->p_price'  class='btn btn-danger'> Consultar Price </a>";
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