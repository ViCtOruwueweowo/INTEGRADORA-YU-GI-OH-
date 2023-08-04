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
LIMIT 8;");
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
  <script src="js/bootstrap.bundle.js"></script>
  <script src="js/bootstrap.min.js"></script>
</head>
<body bgcolor="#ededed">
  
<body>
  <style>
    @media only screen and (max-width: 600px) { 
	body { 
    background-repeat: no-repeat;
		background-image: url(img/mbi8yz4o8ni81.png);
    background-attachment: fixed; 
	}   
}
  </style>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark" aria-label="Offcanvas navbar large">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php" style="  color: whitesmoke;
    font-size: 20px;
    font-family: 'Times New Roman', Times, serif;">WorkStack</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar2" aria-controls="offcanvasNavbar2" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
    </button>
    <div class="offcanvas offcanvas-end text-bg-dark" tabindex="-1" id="offcanvasNavbar2" aria-labelledby="offcanvasNavbar2Label">
    <div class="offcanvas-header" >
    <h5 class="offcanvas-title" id="offcanvasNavbar2Label" >Mis Atajos</h5>
    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
     <div class="offcanvas-body">
        <ul class="navbar-nav justify-content-center flex-grow-1 pe-3">
          <li class="nav-item">
          <a type="button" class="nav-link" href="cartas.php" data-bs-target="#staticBackdrop"> Cartas <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-book" viewBox="0 0 16 16">
  <path d="M1 2.828c.885-.37 2.154-.769 3.388-.893 1.33-.134 2.458.063 3.112.752v9.746c-.935-.53-2.12-.603-3.213-.493-1.18.12-2.37.461-3.287.811V2.828zm7.5-.141c.654-.689 1.782-.886 3.112-.752 1.234.124 2.503.523 3.388.893v9.923c-.918-.35-2.107-.692-3.287-.81-1.094-.111-2.278-.039-3.213.492V2.687zM8 1.783C7.015.936 5.587.81 4.287.94c-1.514.153-3.042.672-3.994 1.105A.5.5 0 0 0 0 2.5v11a.5.5 0 0 0 .707.455c.882-.4 2.303-.881 3.68-1.02 1.409-.142 2.59.087 3.223.877a.5.5 0 0 0 .78 0c.633-.79 1.814-1.019 3.222-.877 1.378.139 2.8.62 3.681 1.02A.5.5 0 0 0 16 13.5v-11a.5.5 0 0 0-.293-.455c-.952-.433-2.48-.952-3.994-1.105C10.413.809 8.985.936 8 1.783z"/>
</svg></a>
        </li>
        <li class="nav-item">
          <a type="button" class="nav-link" href="productos.php" data-bs-target="#staticBackdrop"> Productos <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-book" viewBox="0 0 16 16">
  <path d="M1 2.828c.885-.37 2.154-.769 3.388-.893 1.33-.134 2.458.063 3.112.752v9.746c-.935-.53-2.12-.603-3.213-.493-1.18.12-2.37.461-3.287.811V2.828zm7.5-.141c.654-.689 1.782-.886 3.112-.752 1.234.124 2.503.523 3.388.893v9.923c-.918-.35-2.107-.692-3.287-.81-1.094-.111-2.278-.039-3.213.492V2.687zM8 1.783C7.015.936 5.587.81 4.287.94c-1.514.153-3.042.672-3.994 1.105A.5.5 0 0 0 0 2.5v11a.5.5 0 0 0 .707.455c.882-.4 2.303-.881 3.68-1.02 1.409-.142 2.59.087 3.223.877a.5.5 0 0 0 .78 0c.633-.79 1.814-1.019 3.222-.877 1.378.139 2.8.62 3.681 1.02A.5.5 0 0 0 16 13.5v-11a.5.5 0 0 0-.293-.455c-.952-.433-2.48-.952-3.994-1.105C10.413.809 8.985.936 8 1.783z"/>
</svg></a>
        </li>
        <li class="nav-item">
          <a type="button" class="nav-link" href="index2.php" data-bs-target="#staticBackdrop"> Iniciar Sesion <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
  <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
  <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z"/>
</svg></a>
        </li>
        </ul>
    </div>
  </div>
</nav>

<!---->
<div class="p-4 p-md-5 mb-4 rounded text-body-emphasis bg-body-secondary">
    <div class="col-lg-6 px-0">
      <h1 class="display-4 fst-italic">¡Bienvenido!</h1>
      <p class="lead my-3">Bienvenido a WorkStack, tu tienda de compra de cartas, aqui podras encontrar cartas de yugioh, ademas de playmat's, micas, dados, entre muchos otros productos, visitanos cuando gustes en plaza de la tecnologia.</p>
    </div>
  </div>

  <p class="lead mb-0" style="text-align: center;"><a href="#" class="text-body-emphasis fw-bold">¡No Te Pierdas De Esta Selección De Cartas Para Ti!</a></p>
  <p class="lead mb-0" style="text-align: center;">¿No sabes que estas buscando? Mira lo que tenemos en venta, también puedes ver más <a class="text-body-emphasis fw-bold" href="cartas.php">aquí</a> </p>
  <br>
  <div class="container">
  <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 g-4 ">

<?php foreach ($resultado as $row) { ?>
  <div class="col">
    <div class="card shadow-sm " style="background-color: rgba(0, 0, 0, .550); box-shadow: 0 2px 4px rgba(10, 2, 1, 55);">
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
      <img style="width: 100%;height: 350px;"src="<?php echo $imagen; ?>" class="img-fluid" alt="...">
      <div class="card-body">
        <h6 class="card-title text-center" style="color:white; font-size:20px; font-family: 'Times New Roman', Times, serif;"><?php echo $row['nombre_c']; ?></h6>
        <h6 class="card-title text-center" style="color:white; font-size:20px; font-family: 'Times New Roman', Times, serif;"><?php echo $row['rareza']; ?></h6>
        <h6 class="card-title text-center" style="color:white; font-size:20px; font-family: 'Times New Roman', Times, serif;">$<?php echo $row['p_beto']; ?></h6>
        <div class="d-flex justify-content-between align-items-center">

        </div>

      </div>

    </div>
  </div>
<?php
}
$db->desconectarDB();
?>

    </div>
    <br>
    <div class="row mb-2">
    <div class="col-md-12">
      <div class="row g-0 border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
        <div class="col p-4 d-flex flex-column position-static">
          <h3 class="mb-0">Encuentranos Aquí:</h3>
          <p class="card-text mb-auto">Plaza de la Tecnología Torreón, Av Hidalgo 1334, Primitivo Centro, 27000 Torreón, Coah. Segundo piso, Local #288. ¡Justo aquí!</p>
          <img src="img/beto.jpeg" style="width: 450px;text-align:end" alt=""> 
        </div>
        <div class="col-auto d-none d-lg-block">
<img src="img/pngegg.png" style="width: 430px;" alt=""> 
       </div>
      </div>
    </div>
  </div> 
  <p class="lead mb-0" style="text-align: center;"><a href="#" class="text-body-emphasis fw-bold">¡Sé El Mejor Duelista Con Estos Productos!</a></p>
  <p class="lead mb-0" style="text-align: center;">Mira más de estos increíbles productos y cuida tu deck haciendo clic <a class="text-body-emphasis fw-bold" href="productos.php">aquí</a> </p>
<br>
  <?php

$db = new Database();
$con = $db->conectar();
$sql = $con->prepare("SELECT * from productos
ORDER BY rand()
LIMIT 4;");
$sql->execute();
$resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
?>
  <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 g-4 ">

<?php foreach ($resultado as $row) { ?>
  <div class="col">
    <div class="card shadow-sm " style="background-color: rgba(0, 0, 0, .550); box-shadow: 0 2px 4px rgba(10, 2, 1, 55);">
      <?php
      $id = $row['imagen_p'];
      $imagePath = "imagenes/productos_2/" . $id;
      
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
      <img style="width: 100%;height: 350px;"src="<?php echo $imagen; ?>" class="img-fluid" alt="...">
      <div class="card-body">
        <h6 class="card-title text-center" style="color:white; font-size:15px; font-family: 'Times New Roman', Times, serif;"><?php echo $row['nom_p']; ?></h6>
        <h6 class="card-title text-center" style="color:white; font-size:15px; font-family: 'Times New Roman', Times, serif;"><?php echo $row['precio']; ?></h6>
        <div class="d-flex justify-content-between align-items-center">

        </div>

      </div>

    </div>
  </div>
<?php
}
$db->desconectarDB();
?>

    </div>
    <br>
    <div class="p-4 p-md-5 mb-4 rounded text-body-emphasis bg-body-secondary" >
    <div class="col-lg-6 px-0" >
      <h1 class="display-4 fst-italic" >¡Nos Vemos Pronto!</h1>
      <p class="lead my-3">Recuerda seguir las normas de seguridad dentro que tenemos en la tienda, para mas dudas o preguntas sobre nosotros manda mensaje al sigueinte numero de telefono: </p>
      <p class="lead mb-0"><a href="#" class="text-body-emphasis fw-bold"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chat-square-dots" viewBox="0 0 16 16">
  <path d="M14 1a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1h-2.5a2 2 0 0 0-1.6.8L8 14.333 6.1 11.8a2 2 0 0 0-1.6-.8H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h2.5a1 1 0 0 1 .8.4l1.9 2.533a1 1 0 0 0 1.6 0l1.9-2.533a1 1 0 0 1 .8-.4H14a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
  <path d="M5 6a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
</svg> 871 103 4946</a></p>
    </div>
  </div>

  </div>
<br>

  <footer class="footer mt-auto py-3 bg-dark">
<div class="container text-center">
<span class="text-center" style="color:white">Aplicacion Desarrollada Unicamente Para Fines De Venta Y Distribucion De Menores.</span><br>
<span class="text-center" style="color:white">Plaza de la Tecnología Torreón, Av Hidalgo 1334, Primitivo Centro, 27000 Torreón, Coah. Segundo piso Local #288</span><br>
<span class="text-center  fw-bold" style="color:white">Cel. 871 103 4946</span>
</div>
</footer>
</body>
</html>
