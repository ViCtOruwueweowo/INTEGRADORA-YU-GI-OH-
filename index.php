<?php
require 'config/config.php';
require 'config/database.php';
$db = new Database(); 
$con = $db->conectar();
$sql = $con->prepare("SELECT DISTINCT cartas.id_car, nombre_c, imagen_c, rareza.rareza,car_rar.p_beto
FROM cartas
INNER JOIN car_rar ON cartas.id_car = car_rar.id_carar
INNER JOIN rareza ON car_rar.id_rar = rareza.id_ra
ORDER BY rand()
LIMIT 8;
 ;");
$sql->execute();
$resultado = $sql->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <!--Contenido De La Cabecera-->

    <style>
        body{
            background-color: rgba(237,237,237,255);
        }
  /* Custom CSS for the transparent navigation bar with shadow */
  .navbar {
    background-color: rgba(14,14,14,255)!important;
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
    <div class="container-fluid" >
      <a class="navbar-brand" href="index.php">WorkStack</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar2" aria-controls="offcanvasNavbar2" aria-label="Toggle navigation" >
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="offcanvas offcanvas-end text-bg-dark" tabindex="-1" id="offcanvasNavbar2" aria-labelledby="offcanvasNavbar2Label" >
        <div class="offcanvas-header">
          <h5 class="offcanvas-title" id="offcanvasNavbar2Label"><b>Mis Atajos</b></h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body"  >
          <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
            <li class="nav-item">
              <a class="nav-link " aria-current="page" href="cartas.php">Cartas</a>
            </li>
            <li class="nav-item">
              <a class="nav-link " aria-current="page" href="productos.php">Productos</a>
            </li> 
            <li class="nav-item">
              <a class="nav-link " aria-current="page" href="index2.php">Iniciar</a>
            </li> 
          </ul>
        </div>
      </div>
    </div>
  </nav>
      <!--Final Contenido De La Cabecera-->

<br>
<div class="container" style="background-color:#212529;border-radius:10px">


      <div class="container">
      <h3 style="color: white;">Mira Todo Lo Nuevo Que Tenemos:</h3>
      <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 g-4 ">

        <?php foreach($resultado as $row) { ?>
        <div class="col">
        <div class="card shadow-sm " style=" background-color: rgba(0, 0, 0, .550);
    box-shadow: 0 2px 4px rgba(10, 2, 1, 55);">
      <?php
      $id = $row['imagen_c'];
      $imagePath = "imagenes/productos/" . $id;
      
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
        $imagen = "imagenes/no image.png";
      }
      ?>
      <img src="<?php echo $imagen; ?>" class="img-fluid" alt="...">
            <div class="card-body" >
              <h6 class="card-title text-center"  style="color:white; font-size:19px; font-family: 'Times New Roman', Times, serif;"><?php echo $row ['nombre_c']; ?></h6>
              <div  class="d-flex justify-content-between align-items-center">
              
  <h6  style="color:white; font-size:15px; "> <?php echo $row ['rareza']; ?></h6>
  <h6  style="color:white; font-size:15px; "> <?php echo $row ['p_beto']; ?></h6>

              </div>

              </div>
            
          </div>
        </div>
        <?php }?>   
    </div>     
    </div>
<br>
<h4 style="text-align: end;color:white">Conoce Mas Acerca De Nuestros Productos:</h4>
<div class="d-grid gap-2">
  <button class="btn btn-outline-warning" type="button">Buscar Cartas</button>
  <button class="btn btn-outline-warning" type="button">Buscar Productos</button>
</div>
<br>

<h3 style="color: white;">¿Quienes Somos?</h3>
    </div>  


</div>
<br>
<footer class="footer mt-auto py-3 bg-dark">
<div class="container text-center">
<span class="text-center" style="color:white">Aplicacion Desarrollada Unicamente Para Fines De Venta Y Distribucion De Menores.</span>
</div>
<!--Final Contenido De Cartas--->


</div>

</body>
</html>