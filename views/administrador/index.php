<?php
require '../../config/config.php';
require '../../config/database.php';

$consulta = "SELECT id_car, nombre_c,imagen_c,tipo_c FROM cartas ";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
    <link rel="stylesheet" href="../../css/bootstrap.min.css">
    <link rel="stylesheet" href="../../css/index2.css">
</head>
<body >
<nav class="navbar navbar-expand-lg navbar-dark bg-dark" aria-label="Offcanvas navbar large">
    <div class="container-fluid">
      <a class="navbar-brand" href="index.php">WorkStack</a>
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
              <a class="nav-link " aria-current="page" href="calendario.php"><b>Calendario</b></a>
            </li>
            <li class="nav-item">
              <a class="nav-link " aria-current="page" href="funciones/listarPersonasConBusqueda.php"><b>Inventario</b></a>
            </li>
            <li class="nav-item">
              <a class="nav-link " aria-current="page" href="empleados.php"><b>Empleados</b></a>
            </li>
            <li class="nav-item">
              <a class="nav-link " aria-current="page" href="agenda.php"><b>Agenda</b></a>
            </li>
          </ul>
          <form class="d-flex mt-3 mt-lg-0" role="search">
            <a href="../../config/cerrarSesion.php" class="btn btn-outline-success">Cerrar Sesion</a>
          </form>
        </div>
      </div>
    </div>
  </nav>
<!--cabezera #212529-->
<br>
<br>
<!---->
<div class="container" style="background-color:transparent;border-radius:10px">
<main>
      <div class="container">
    <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 g-4 ">
        <?php foreach($resultado as $row) { ?>
        <div class="col">
          <div class="card shadow-sm " style="background-color:#212529;">
            <?php
            $id =$row[('imagen_c')];
            $imagen = "imagenes/productos/".$id.".jpg";
            if(!file_exists($imagen)){
              $imagen="imagenes/no image.png";
            }
            ?>
            <img  src="<?php echo $imagen; ?>">
            <div class="card-body" >
              <h6 class="card-title text-center" style="color:white;"><?php echo $row ['nombre_c']; ?></h6>
              <div  class="d-flex justify-content-between align-items-center">
              
              <a href="details.php?id=<?php echo $row ['id_car']; ?>&token=<?php echo 
             hash_hmac('sha1',$row['id_car'],KEY_TOKEN);?>" class="btn btn-outline-info"  type="button">Detalles</a>
                
              </div>
              
              </div>
              
          </div>
        </div>
        <?php } ?>   
    </div>     
    </div>
    <hr>
    <h4 class="text-center" >Todos Mis Atajos</h4>
    <hr style="border:solid;border-color:white">
   <div class="row">
    <div class="col-12 col-sm-12 col-lg-6">
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js'></script>
    <script>

      document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
         
          locale:"es",
          headerToolbar:{
         
           
         
          }
        });
        calendar.render();
      });

      
    </script>
     <div id='calendar' style="color:white"></div>
    </div>
    <div class="col-6">
    <div class="d-grid gap-2-center">
      <br>
      <br>
      <br>
      <br>
    <a class="btn btn-outline-primary" type="button" href="funciones/listarPersonasConBusqueda.php">Mi Inventario</a>
    <br>
    <a class="btn btn-outline-primary" type="button" href="agenda.php">Mi Agenda</a>
    <br>
    <a class="btn btn-outline-primary" type="button" href="empleados.php">Mis Empleados</a>
    <br>
    </div>
    </div>
   </div>
    </div>  
</main>

</div>
<br>
<footer class="footer mt-auto py-3 bg-dark">
<div class="container text-center">
<span class="text-center" style="color:white">Aplicacion Desarrollada Unicamente Para Fines De Venta Y Distribucion De Menores.</span>
</div>
</footer>
<script src="../../js/bootstrap.min.js"></script>
</body>
</html>
