<?php
require '../../../config/database.php';
$db = new Database();
$con = $db->conectar();

# Por defecto hacemos la consulta de todos los productos
$consulta = "SELECT * FROM productos ORDER BY rand() LIMIT 5;";

# Vemos si hay búsqueda
$busqueda = null;
if (isset($_GET["busqueda"])) {
    # Y si hay búsqueda, entonces cambiamos la consulta
    # Nota: no concatenamos porque queremos prevenir inyecciones SQL
    $busqueda = $_GET["busqueda"];
    $consulta = "SELECT * FROM productos WHERE productos.nom_p LIKE ?";
}

# Preparar sentencia e indicar que vamos a usar un cursor
$sentencia = $con->prepare($consulta, [
    PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL,
]);

# Aquí comprobamos otra vez si hubo búsqueda, ya que tenemos que pasarle argumentos al ejecutar
# Si no hubo búsqueda, entonces traer a todos los productos (mira la consulta de la línea 5)
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

<!DOCTYPE html>
<html lang="es" class="h-100">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="../../../css/bootstrap.min.css">
    <title>Inventario Productos</title>
    </head>
    <link rel="stylesheet" href="../../../css/index2.css">

    <body style="background-color: rgba(235,235,235,255);">
<style>
        #contendor{
            width: 80%;
            margin: auto;
        }
    </style>
<?php
session_start();

// Verificar si el usuario no ha iniciado sesión
if (!isset($_SESSION['usuario'])) {
    echo "Inicia sesión primero por favor :D";
    header("refresh:50 ../../index.php");  // Redireccionamos al archivo de inicio de sesión
    exit();
}

// Verificar si el tipo de usuario no es 2 (Tipo de usuario que puede acceder a esta página, osea empleado)
if ($_SESSION['tipo_usuario'] !== "2") {
  echo "<div class='container' id='contenedor'>
  <div class='alert alert-danger text-center' role='alert'>
 <h1 style='text-aling:center'>¡Ups!</h1>
 <br>
 <div class='spinner-border text-dark' role='status'>
<span class='visually-hidden'>Loading...</span>
</div>
<br>
 <h6>Parece ser que no tienes acceso a este lugar, Asegurate de usar una cuenta valida</h6>
</div>
</div>   ";   
    header("refresh:5 ../../index.php");  // Redireccionamos al archivo de inicio de sesión otra vez
    exit();
}

$nombreUsuario = $_SESSION['usuario'];
?>
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

<!-- Begin page content -->

<main role="main" class="flex-shrink-0">

<div class="container">
   
<div class="row">
 <div class="col-md-12">   
 
 
 <br>
<form class="form-inline" action="listarPersonasConBusqueda2.php" method="GET">
  <div class="form-group mx-sm-3 mb-2">
    
  <div class="row">

<div class="col col-12 col-lg-6 text-center" >
  <input name="busqueda" type="text" class="form-control"  placeholder="Buscar">
  </div>



  <div class="col col-sm-3 col-lg-2">
  <button type="submit" class="btn btn-warning btn-md">Buscar ahora</button>
  </div>

<div class="col col-sm-3 col-lg-2">
<a href="form_agregar_p.php" class="btn btn-warning mb-2">Agregar Productos</a>
</div>
<div class="col col-sm-3 col-lg-2">
<a href="mod_pro.php" class="btn btn-warning mb-2">Modificar Productos</a>
</div>


</div>
</form>
<br>
<div class="container">
<?php while ($resultado = $sentencia->fetchObject()) {?>
      
		
      <?php
      $imagenPath = "../../../imagenes/productos_2/" . $resultado->imagen_p;
      
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
    box-shadow: 0 4px 5px rgba(10, 2, 1, 55);">
<h3 class="mb-0" style="text-align: end;"><?php echo $resultado->nom_p ?></h3>
<hr>
<h5 class="card-text mb-auto" style="text-align: start;">Precio: </h5><p class="card-text mb-auto"><?php echo $resultado->precio ?></p>
<h5 class="card-text mb-auto" style="text-align: start;">Cantidad: </h5><p class="card-text mb-auto"><?php echo $resultado->existencias ?></p>
<h5 class="card-text mb-auto" style="text-align: start;">Descripcion: </h5><p class="card-text mb-auto"><?php echo $resultado->notas_prod ?></p>
</div>
<div class="col-auto d-none d-lg-block">
<img src="<?php echo $imagen; ?>" style="width: 200px;" alt=""> 
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
