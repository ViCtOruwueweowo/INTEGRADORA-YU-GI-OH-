<?php

include_once "base_de_datos.php";

# Por defecto hacemos la consulta de todas las personas
$consulta = "SELECT * FROM cartas inner join car_rar
on cartas.id_car=car_rar.id_carar left join rareza
on car_rar.id_rar=rareza.id_ra ORDER BY cartas.tipo_c DESC";

# Vemos si hay búsqueda
$busqueda = null;
if (isset($_GET["busqueda"])) {
    # Y si hay, búsqueda, entonces cambiamos la consulta
    # Nota: no concatenamos porque queremos prevenir inyecciones SQL
    $busqueda = $_GET["busqueda"];
    $consulta = "SELECT * FROM cartas inner join car_rar
    on cartas.id_car=car_rar.id_carar left join rareza
    on car_rar.id_rar=rareza.id_ra  WHERE cartas.nombre_c LIKE ?";
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
<!DOCTYPE html>
<html lang="es" class="h-100">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="../../../css/bootstrap.min.css">
 
    <title>Inventario</title>

    </head>
    <body>
    
    <header>
  <!-- Fixed navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark" aria-label="Offcanvas navbar large">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">WorkStack</a>
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
              <a class="nav-link " aria-current="page" href="../index.php">Inicio</a>
            </li>
            <li class="nav-item">
              <a class="nav-link " aria-current="page" href="../calendario.php">Calendario</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="funciones/listarPersonasConBusqueda.php">Inventario</a>
            </li>
            <li class="nav-item">
              <a class="nav-link " aria-current="page" href="../empleados.php">Empleados</a>
            </li>
            <li class="nav-item">
              <a class="nav-link " aria-current="page" href="../agenda.php">Agenda</a>
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
<form class="form-inline" action="listarPersonasConBusqueda.php" method="GET">
  <div class="form-group mx-sm-3 mb-2">
    
  <div class="row">
    <div class="col col-lg-6">
    <input name="busqueda" type="text" class="form-control"  placeholder="Buscar">
    </div>
    <div class="col col-lg-6">
    <button type="submit" class="btn btn-primary mb-2">Buscar ahora</button>

    </div>
  </div>
</form>
<table class="table table-hover">
  <thead class="table-dark table-hover">
			<tr>
      <th>Nombre</th>
				<th>Tipo</th>
				<th>Rareza</th>
        <th>Cantidad</th>
				<th>Tcg</th>
				<th>Price</th>
			</tr>
		</thead>
		<tbody>
			
			<?php while ($resultado = $sentencia->fetchObject()) {?>
			<tr>
      <td><?php echo $resultado->nombre_c ?></td>
				<td><?php echo $resultado->tipo_c ?></td>
				<td><?php echo $resultado->rareza ?></td>
        <td><?php echo $resultado->cantidad ?></td>
				<td><a href="<?php echo $resultado->p_tcg ?>">Link Directo</a></td>
				<td><a href="<?php echo $resultado->p_price ?>">Link Directo</a></td>
			</tr>
			<?php }?>
		</tbody>
	</table>
  
</div>

 </div>
 </div>
 </main>
    <!-- Aquí va el contenido de tu web -->
 
    <!-- JavaScript -->
    
    <script src="../../../js/bootstrap.min.js"></script>  </body>
</html>
