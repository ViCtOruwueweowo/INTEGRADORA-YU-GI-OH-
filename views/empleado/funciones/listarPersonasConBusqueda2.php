<?php

include_once "base_de_datos.php";

# Por defecto hacemos la consulta de todas las personas
$consulta = "SELECT * FROM productos";

# Vemos si hay búsqueda
$busqueda = null;
if (isset($_GET["busqueda"])) {
    # Y si hay, búsqueda, entonces cambiamos la consulta
    # Nota: no concatenamos porque queremos prevenir inyecciones SQL
    $busqueda = $_GET["busqueda"];
    $consulta = "SELECT * FROM productos  WHERE productos.nom_p LIKE ?";
}
# Preparar sentencia e indicar que vamos a usar un cursor
$sentencia = $base_de_datos->prepare($consulta, [
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
<html lang="es" class="h-100">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="../../../css/bootstrap.min.css">
    <link rel="stylesheet" href="../../../css/index3.css">
    <title>Inventario Productos</title>
    </head>
    <body>
    <style>
  /* Custom CSS for the transparent navigation bar with shadow */
  .navbar {
    background-color: transparent !important;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
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
    <a class="navbar-brand" href="../index.php" style="  color: whitesmoke;
    font-size: 20px;
    font-family: 'Times New Roman', Times, serif;">WorkStack</a>
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
          <a class="nav-link" aria-current="page" href="../calendario.php">Calendario</a>
          </li>
          <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
        Mi Inventario
          </a>
          <ul class="dropdown-menu">
          <a href="listarPersonasConBusqueda.php" class="dropdown-item">Cartas</a>
          <a href="listarPersonasConBusqueda2.php" class="dropdown-item">Productos</a>
          </ul>
      </li>
      <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
        Mi Agenda
          </a>
          <ul class="dropdown-menu">
          <a href="../ac.php" class="dropdown-item">Acreedores</a>
          <a href="../deuda_c.php" class="dropdown-item">Deudores Cartas</a>
          <a href="../deuda_p.php" class="dropdown-item">Deudores Productos</a>
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
    </div>
  </div>
</nav>
<!-- Begin page content -->

<main role="main" class="flex-shrink-0">

<div class="container">
    <div class="row">
  <div class="col-md-12">
  </div>
</div>

<div class="row">
 <div class="col-md-12">   
 
 
 <br>
<form class="form-inline" action="listarPersonasConBusqueda2.php" method="GET">
  <div class="form-group mx-sm-3 mb-2">
    
  <div class="row">
    <div class="col col-lg-6 text-center" >
    <input name="busqueda" type="text" class="form-control"  placeholder="Buscar">
    </div>
    <div class="col col-lg-6">
    <button type="submit" class="btn btn-primary mb-2">Buscar ahora</button>
    <a href="form_agregar_p.php" class="btn btn-primary mb-2">Agregar Productos</a>
    <a href="mod_pro.php" class="btn btn-primary mb-2">Modificar</a>
    </div>
  </div>
</form>
<br>
<table class="table table-dark table-striped table-hover">
  <thead >
			<tr>
      <th>Imagen</th>
      <th>Nombre</th>
      <th>existencias</th>
				<th>Notas</th>
				<th>Precio</th>
			</tr>
		</thead>
		<tbody>
			
	
    <?php while ($resultado = $sentencia->fetchObject()) {?>
  <tr>
  <td style="color:whitesmoke;"><?php echo "<img src='../../../imagenes/productos_2/$resultado->imagen_p.webp' style='width:100px'> " ?></td>
  <td style="color:whitesmoke;"><?php echo $resultado->nom_p ?></td>
    <td style="color:whitesmoke;"><?php echo $resultado->existencias ?></td>
    <td style="color:whitesmoke;"><?php echo $resultado->notas_prod ?></td>
    <td style="color:whitesmoke;"><?php echo $resultado->precio ?></td>
  </tr>
  <?php }?>
		</tbody>
	</table>
  
</div>

 </div>
 </div>
 </main>
 
<!-- JavaScript -->
    
<script src="../../../js/bootstrap.min.js"></script> 
<script src="../../../js/bootstrap.bundle.min.js"></script>
 </body>
</html>
