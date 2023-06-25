<?php
include_once "base_de_datos.php";
$sentencia = $base_de_datos->query("SELECT * FROM cartas inner join car_rar
on cartas.id_car=car_rar.id_carar left join rareza
on car_rar.id_rar=rareza.id_ra ;");
$personas = $sentencia->fetchAll(PDO::FETCH_OBJ);
?>
<!--Recordemos que podemos intercambiar HTML y PHP como queramos-->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Empleados</title>
    <link rel="stylesheet" href="../../../css/bootstrap.min.css">

</head>
<body>
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
              <a class="nav-link " aria-current="page" href="index.php">Inicio</a>
            </li>
            <li class="nav-item">
              <a class="nav-link " aria-current="page" href="calendario.php">Calendario</a>
            </li>
            <li class="nav-item">
              <a class="nav-link " aria-current="page" href="inventario.php">Inventario</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="empleados.php">Empleados</a>
            </li>
            <li class="nav-item">
              <a class="nav-link " aria-current="page" href="agenda.php">Agenda</a>
            </li>
          </ul>
          <form class="d-flex mt-3 mt-lg-0" role="search">
            <a href="../../index.php" class="btn btn-outline-success">Cerrar Sesion</a>
          </form>
        </div>
      </div>
    </div>
  </nav>
  <div class="container">
  <div class="row row-cols-4 row-cols-sm-4 row-cols-md-4 g-4">
<div class="col">
  <br>



      <form class="form-inline mt-2 mt-md-0">
        <input class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Busqueda</button>
      </form>
    </div>
    </div>
  </nav>
</header>

<!-- Begin page content -->
<hr>
<main role="main" class="flex-shrink-0">

<div class="container">
<div class="row">
<div class="col-md-12">
<h3 class="mt-5">Lista de personas con PDO </h3>
</div>
</div>
<hr>
<div class="row">
 <div class="col-md-12">   
	<table class="table">
		<thead>
			<tr>
				
				<th>Nombre</th>
				<th>Tipo</th>
				<th>Rareza</th>
        <th>Cantidad</th>
				<th>Editar</th>
				<th>Eliminar</th>
			</tr>
		</thead>
		<tbody>
			<!--
				Atención aquí, sólo esto cambiará
				Pd: no ignores las llaves de inicio y cierre {}
			-->
			<?php foreach($personas as $persona){ ?>
			<tr>
		
				<td><?php echo $persona->nombre_c ?></td>
				<td><?php echo $persona->tipo_c ?></td>
				<td><?php echo $persona->rareza ?></td>
        <td><?php echo $persona->cantidad ?></td>
				<td><a href="<?php echo "editar.php?id=" . $persona->id?>">Editar</a></td>
				<td><a href="<?php echo "eliminar.php?id=" . $persona->id?>">Eliminar</a></td>
			</tr>
			<?php } ?>
		</tbody>
	</table>
</div>

 </div>
 </div>
 </main>
 <footer class="footer mt-auto py-3">
  <div class="container">
    <span class="text-muted">Pie de pagina.</span>
  </div>
</footer>
    <!-- Aquí va el contenido de tu web -->
 
    <!-- JavaScript -->
    
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
  </body>
</html>