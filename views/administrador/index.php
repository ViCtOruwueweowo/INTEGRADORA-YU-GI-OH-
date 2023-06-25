<?php
require '../../config/config.php';
require '../../config/database.php';
$db = new Database ;
$con = $db->conectar();
$sql = $con->prepare("SELECT id_car, nombre_c FROM cartas WHERE cartas.tipo_c='MONSTRUO' ORDER BY cartas.tipo_c ");
$sql->execute();
$resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
    <link rel="stylesheet" href="../../css/bootstrap.min.css">
   
    <script src="../../js/bootstrap.min.js"></script>
</head>
<body >
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
              <a class="nav-link active" aria-current="page" href="index.php">Inicio</a>
            </li>
            <li class="nav-item">
              <a class="nav-link " aria-current="page" href="calendario.php">Calendario</a>
            </li>
            <li class="nav-item">
              <a class="nav-link " aria-current="page" href="funciones/listarPersonasConBusqueda.php">Inventario</a>
            </li>
            <li class="nav-item">
              <a class="nav-link " aria-current="page" href="empleados.php">Empleados</a>
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
<!--cabezera-->
<br>

<!---->
<div class="container" style="background-color:whitesmoke">
<main>
      <div class="container">
    <div class="row row-cols-2 row-cols-sm-2 row-cols-md-3 g-3 ">
        <?php foreach($resultado as $row) { ?>
        <div class="col">
          <div class="card shadow-sm ">
            <?php

            $id =$row[('id_car')];
            $imagen = "imagenes/productos/".$id."/principal.jpg";

            if(!file_exists($imagen)){
              $imagen="imagenes/no image.png";
            }
            ?>
            <img src="<?php echo $imagen; ?>">
            <div class="card-body  d-block" ">
              <h6 class="card-title text-center" ><?php echo $row ['nombre_c']; ?></h6>
              <div  class="d-flex justify-content-between align-items-center">
          
              <div class="btn-group">

              <a href="details.php?id=<?php echo $row ['id_car']; ?>&token=<?php echo 
             hash_hmac('sha1',$row['id_car'],KEY_TOKEN);?>" class="btn btn-outline-success">Detalles</a>
           
                </div>
              </div>
              
              </div>
           
          </div>
        </div>
        <?php } ?>
        
        </div>
     
      </div>
    </div>
    </main>
</div>

<br>
<br>
    
<div class="container" style="background-color:whitesmoke">

<div class="row">


<div class="col col-lg-6 col-ms-12">
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js'></script>
    <script>

      document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
          initialView: 'dayGridMonth',
          locale:"es",
        });
        calendar.render();
      });

    </script>
     <div id='calendar'></div>
</div>

<div class="col col-lg-6 col-sm-12 text-center">
  <h1 class="text-center">Mis Atajos</h1>
<br>
<a href="agenda.php" class="btn btn-outline-success">Detalles</a>
 <br>
 <br>
 <br>
 <a href="agenda.php/menu1" class="btn btn-outline-success">Detalles</a>
 
</div>

</div>

</div>
<br>
<footer class="footer mt-auto py-3 bg-dark">
<div class="container">
<span class="text-center" style="color:white">Aplicacion Desarrollada Unicamente Para Fines De Venta Y Distribucion De Menores.</span>
</div>
</footer>
</body>
</html>