<?php
require 'config/database.php';
$db = new Database();
$con = $db->conectar();

# Por defecto hacemos la consulta de todas las personas
$consulta = "SELECT *
FROM cartas
INNER JOIN car_rar ON cartas.id_car = car_rar.id_carar
LEFT JOIN rareza ON car_rar.id_rar = rareza.id_ra
ORDER BY cartas.tipo_c DESC
LIMIT 0;";

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
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscar Cartas</title>
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

<main role="main" class="flex-shrink-0">

<div class="container">
    <div class="row">
  <div class="col-md-12">
  </div>
</div>

<div class="row">
 <div class="col-md-12">   
 
 
 <br>
<form class="form-inline" action="cartas.php" method="GET">
  <div class="form-group ">
    
  <div class="row">
    <div class="col col-12 col-lg-10 text-center" >
    <input name="busqueda"  type="text" class="form-control "  placeholder="Buscar">
    </div>

    <div class="col col-sm-3 col-lg-2">
    <button type="submit" class="btn btn-warning btn-md">Buscar ahora</button>
    </div>

    </div>
  </div>
</form>
<br>

			
			<?php while ($resultado = $sentencia->fetchObject()) {?>
      
		
      <td style="color:whitesmoke;background-color: rgba(0, 0, 0, .550); box-shadow: 0 4px 5px rgba(10, 2, 1, 55); text-align:center">
                <?php
                $imagenPath = "imagenes/productos/" . $resultado->imagen_c;
                
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

         
<table style="font-size: 15px;border-color: aliceblue;border: 1px;">
        <tbody>
            <tr>
                <th rowspan="5"><img src="<?php echo $imagen; ?>" alt="" width="80%"></th>
            </tr>
            <tr>
                <th bgcolor=" #94a494 ">Nombre:</th>
                <td style="color:whitesmoke;background-color: rgba(0, 0, 0, .550);text-align:center"><?php echo $resultado->nombre_c ?></td>
            </tr>
            <tr>
                <th bgcolor=" #94a494 ">Rareza</th>
                <td style="color:whitesmoke;background-color: rgba(0, 0, 0, .550);text-align:center"><?php echo $resultado->rareza ?></td>
            </tr>
            <tr>
                <th bgcolor=" #94a494 ">Precio</th>
                <td style="color:whitesmoke;background-color: rgba(0, 0, 0, .550);text-align:center"><?php echo $resultado->p_beto ?></td>
            </tr>
        </tbody>
            </table>
     
     
			<?php }?>
            

</body>
</html>