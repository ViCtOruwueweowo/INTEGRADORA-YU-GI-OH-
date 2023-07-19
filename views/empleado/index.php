<?php
session_start();

// Verificar si el usuario no ha iniciado sesión
if (!isset($_SESSION['usuario'])) {
    echo "Inicia sesión primero por favor :D";
    header("refresh:5 ../../index.php");  // Redireccionamos al archivo de inicio de sesión
    exit();
}

// Verificar si el tipo de usuario no es 2 (Tipo de usuario que puede acceder a esta página, osea empleado)
if ($_SESSION['tipo_usuario'] !== "2") {
    echo "Acceso no autorizado. Por favor, inicia sesión con una cuenta válida.";
    header("refresh:5 ../../index.php");  // Redireccionamos al archivo de inicio de sesión otra vez
    exit();
}

$nombreUsuario = $_SESSION['usuario'];
?>

<?php
require '../../config/config.php';
require '../../config/database.php';
$db = new Database();
$con = $db->conectar();
$sql = $con->prepare("SELECT id_car, nombre_c,imagen_c,tipo_c FROM cartas ");
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
<script src="../../js/bootstrap.bundle.min.js"></script>
<style>
    .footer {
      background-color: #f8f9fa;
      padding: 20px;
      text-align: center;
    }
  </style>
</head>
<body>
<div class="container">
    <header class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-3 mb-4 border-bottom">
      <div class="col-md-3 mb-2 mb-md-0">
        <a href="/" class="d-inline-flex link-body-emphasis text-decoration-none">
          <svg class="bi" width="40" height="32" role="img" aria-label="Bootstrap"><use xlink:href="#bootstrap"></use></svg>
        </a>
      </div>

      <ul class="nav col-12 col-md-auto mb-2 justify-content-center mb-md-0">
        <li><a href="#" class="nav-link px-2 link-secondary">Inicio</a></li>
        <li><a href="#" class="nav-link px-2">Inventario</a></li>
        <li><a href="#" class="nav-link px-2">Productos</a></li>
      </ul>
      <?php
              $nombreUsuario = $_SESSION['usuario'];
              echo "$nombreUsuario";
              ?>
      <div class="col-md-3 text-end">
<a href="../../config/cerrarSesion.php"><button type="button" class="btn btn-primary">Cerrar Sesion</button></a>
      </div>
    </header>
  </div>


<!--Apartado De Cartas-->
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
              </div>
              </div>
          </div>
        </div>
        <?php } ?>   
    </div>     
</div>
<!--Fin Apartado De Cartas-->


<footer class="footer">
    <div class="container">
      <p>&copy; 2023 Mi Sitio Web. Todos los derechos reservados.</p>
    </div>
  </footer>
</body>
</html>