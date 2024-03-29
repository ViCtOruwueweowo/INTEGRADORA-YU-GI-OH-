
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
<html lang="es" class="h-100">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="../../../css/bootstrap.min.css">
    <title>Inventario Cartas</title>
    </head>
    <body style="background-color: rgba(235,235,235,255);">
    
    <header>
  <!-- Fixed navbar -->
    <!-- Fixed navbar -->
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
            <li><a class="dropdown-item" href="../funciones/modificar_cliente.php">Modificar Cliente</a></li>
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
          <a href="../../../config/cerrarSesion.php" class="dropdown-item">Cerrar Sesion</a>
          </ul>
      </li>
          </ul>
  
       
        </div>
      </div>
    </div>
  </nav>

<!-- Begin page content -->
<?php
require '../../../config/database.php';
$db = new Database();
$con = $db->conectar();

# Por defecto hacemos la consulta de todas las personas
$consulta = "SELECT *
FROM cartas
INNER JOIN car_rar ON cartas.id_car = car_rar.id_carar
LEFT JOIN rareza ON car_rar.id_rar = rareza.id_ra
ORDER BY rand() DESC
LIMIT 5;";

# Vemos si hay búsqueda
$busqueda = null; 
if (isset($_GET["busqueda"])) {
    # Y si hay, búsqueda, entonces cambiamos la consulta
    # Nota: no concatenamos porque queremos prevenir inyecciones SQL
    $busqueda = $_GET["busqueda"];
    $consulta = "SELECT *
    FROM cartas
    INNER JOIN car_rar ON cartas.id_car = car_rar.id_carar
    LEFT JOIN rareza ON car_rar.id_rar = rareza.id_ra
    WHERE cartas.nombre_c LIKE ?;
    
    ";
}
# Preparar sentencia e indicar que vamos a usar un cursor
$sentencia = $con->prepare($consulta, [
    PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL,
]);
# Aquí comprobamos otra vez si hubo búsqueda, ya que tenemos que pasarle argumentos al ejecutar
# Si no hubo búsqueda, entonces traer a todas las personas (mira la consulta de la línea 5)
if ($busqueda === null) {
    # Ejecutar sin parámetros
    $sentencia->execute();
} else {
    # Ah, pero en caso de que sí, le pasamos la búsqueda
    # Un arreglo que nomás llevará la búsqueda con % al inicio y al final
    $parametros = ["%$busqueda%"];
    $sentencia->execute($parametros);
}
# Sin importar si hubo búsqueda o no, se nos habrá devuelto un cursor que iteramos más abajo...
?>
<link rel="stylesheet" href="../../../css/index2.css">
<br>
<div class="container d-none  d-lg-block">
<div class="row mb-2">
    <div class="col-md-12">
      <div class="row g-0 border rounded overflow-hidden flex-md-row mb-4 shadow-lg p-3 mb-5  h-md-200 position-relative" style="background-color: white;">
        <div class="col p-4 d-flex flex-column position-static">
          <h3 class="mb-0 text-start">¡Sr. <?php $nombreUsuario = $_SESSION['usuario']; echo "$nombreUsuario";?>!</h3>
          <p class="card-text mb-auto">Tu inventario personal de cartas, consulta todas las cartas que haz agregado a tu aplicacion, modificalas en caso de que tengas un error.</p>
        </div>
        <div class="col-auto d-none  d-lg-block">
<img src="../../../img/kas.png" style="width: 150px;" alt="">
       </div>
      </div>
    </div>
  </div> 
</div>
<main role="main" class="flex-shrink-0">

<div class="container">
    <div class="row">
  <div class="col-md-12">
  </div>
</div>

<div class="row">
 <div class="col-md-12">   
 
 
 <br>
<form class="form-inline" action="listarPersonasConBusqueda.php" method="GET">
  <div class="form-group mx-sm-3 mb-2">
    
  <div class="row">
    <div class="col col-12 col-lg-4 text-center" >
    <input name="busqueda"  type="text" class="form-control "  placeholder="Buscar">
    </div>

    <div class="col col-sm-3 col-lg-2">
    <button type="submit" class="btn btn-warning btn-md">Buscar ahora</button>
    </div>

    <div class="col col-sm-3 col-lg-2">
    <a href="agregar_car.php" class="btn btn-warning mb-2">Agregar Carta</a>
    </div>

    <div class="col col-sm-3 col-lg-2">
    <a href="agregar_rar.php" class="btn btn-warning mb-2">Agregar Rareza</a>
    </div>

    <div class="col col-sm-3 col-lg-2">
    <a href="modificar_car.php" class="btn btn-warning mb-2">Modificar Carta</a>
    </div>

    </div>
</form>
<br>


<div class="container">
<?php while ($resultado = $sentencia->fetchObject()) {?>
      
		
      <?php
      $imagenPath = "../../../imagenes/productos/" . $resultado->imagen_c;
      
      // Verifica si el archivo existe con varias extensiones
      $extensionesPermitidas = array('jpg', 'jpeg', 'png', 'gif', 'webp');
      $imagenEncontrada = false;
      foreach ($extensionesPermitidas as $ext) {
          if (file_exists($imagenPath . "." . $ext)) {
              $imagen = $imagenPath . "." . $ext;
              $imagenEncontrada = true;
              break;
          }
      }

      // Si no se encuentra ninguna imagen, utiliza una imagen predeterminada
      if (!$imagenEncontrada) {
          $imagen = "../../../imagenes/no_image.png";
      }
      ?>
<div class="row mb-2">
<div class="col-md-12">
<div class="row g-0 border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
<div class="col p-4 d-flex flex-column position-static" style="color:whitesmoke;background-color: rgba(0, 0, 0, .550);
    box-shadow: 0 4px 5px rgba(10, 2, 1, 55);text-align:center">
<h3 class="mb-0" style="text-align: end;"><?php echo $resultado->nombre_c ?></h3>
<hr>
<h5 class="card-text mb-auto" style="text-align: end;">Rareza: <?php echo $resultado->rareza ?></h5>
<h5 class="card-text mb-auto" style="text-align: end;">Precio: <?php echo $resultado->p_beto ?></h5>
<h5 class="card-text mb-auto" style="text-align: end;">Cantidad: <?php echo $resultado->cantidad?></h5>
<h5 class="card-text mb-auto" style="text-align: end;"><a href="<?php echo $resultado->p_tcg ?>">Visitar Tcg</a></h5>
<h5 class="card-text mb-auto" style="text-align: end;"><a href="<?php echo $resultado->p_price ?>">Visitar Price</a></h5>

</div>
<div class="col-auto d-none d-lg-block">
<img src="<?php echo $imagen; ?>" style="width: 180px;" alt=""> 
</div>
</div>
</div>
</div> 


<?php }?>
</div>
<script src="../../../js/bootstrap.min.js"></script> 
<script src="../../../js/bootstrap.bundle.min.js"></script>
 </body>
</html>
