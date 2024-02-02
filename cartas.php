<?php
require 'config/database.php';
$db = new Database();
$con = $db->conectar();

$cartasPorPagina = 5;
$paginaActual = isset($_GET['pagina']) ? intval($_GET['pagina']) : 1;

$offset = ($paginaActual - 1) * $cartasPorPagina;

$consulta = "SELECT *
FROM cartas
INNER JOIN car_rar ON cartas.id_car = car_rar.id_carar
LEFT JOIN rareza ON car_rar.id_rar = rareza.id_ra
ORDER BY rand() DESC 
LIMIT :offset, :cartasPorPagina;";

$sentencia = $con->prepare($consulta, [
  PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL,
]);

$sentencia->bindParam(':offset', $offset, PDO::PARAM_INT);
$sentencia->bindParam(':cartasPorPagina', $cartasPorPagina, PDO::PARAM_INT);

$sentencia->execute();


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
  <title>Inventario Cartas</title>
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <script src="js/bootstrap.bundle.min.js"></script>
  <script src="js/bootstrap.bundle.js"></script>
  <script src="js/bootstrap.min.js"></script>
</head>
<body bgcolor="#ededed">
  
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
       
         <li class="nav-item justify-content-center">
        <form class="d-flex"  action="cartas.php" method="GET">
          <input class="form-control me-2" name="busqueda"  type="text" class="form-control "  placeholder="Buscar">
          <button class="btn btn-outline-warning" type="submit">Buscar</button>
        </form>
        </li>
      
        </ul>
    </div>
  </div>
</nav>
<div class="container">
<div class="row mb-2">
    <div class="col-md-12">
      <div class="row g-0 border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-200 position-relative">
        <div class="col p-4 d-flex flex-column position-static">
          <h3 class="mb-0">¡Hello Darling!</h3>
          <p class="card-text mb-auto">¿Buscando una carta en especifico?,¡Bien!, recuerda que debes ingresar el nombre de la carta que estas buscando en especifico, ¿No buscas nada en especifico?, ¡Sin problemas!, Solo ingresa el nombre del arquetipo del cual buscas contenido y te mostraremos todo lo que tenemos.</p>
        </div>
        <div class="col-auto d-none  d-lg-block">
<img src="img/guia.webp" style="width: 200px;" alt=""> 
       </div>
      </div>
    </div>
  </div> 
</div>


<div class="container">
    <?php while ($resultado = $sentencia->fetchObject()) { ?>
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

        <div class="row mb-2">
            <div class="col-md-12">
                <div class="row g-0 border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
                    <div class="col p-4 d-flex flex-column position-static">
                        <h3 class="mb-0" style="text-align: end;"><?php echo $resultado->nombre_c ?></h3>
                        <hr>
                        <h4 class="card-text mb-auto" style="text-align: end;">Rareza: <?php echo $resultado->rareza ?></h4>
                        <h4 class="card-text mb-auto" style="text-align: end;">Precio: <?php echo $resultado->p_beto ?></h4>
                    </div>
                    <div class="col-auto  d-lg-block">
                        <img src="<?php echo $imagen; ?>" style="width: 150px;" alt="">
                    </div>
                </div>
            </div>
        </div> 

    <?php } ?>

    <?php if ($sentencia->rowCount() === 0) { ?>
        <div class="container text-center" style="border: black;">
            <h3>¿Qué pasa?</h3>
            <img src="img/hola.webp" class="d-none d-lg-block" alt="">
            <h4>¿No encontraste lo que buscabas? ¡Vuelve a intentarlo, estamos para servirte!</h4>
        </div>
    <?php } ?>
</div>

    <div class="container text-center">
        <ul class="pagination justify-content-center">
            <?php
            $totalCartas = $sentencia->rowCount();
            $totalPaginas = ceil($totalCartas / $cartasPorPagina);

            for ($i = 1; $i <= $totalPaginas; $i++) {
                echo '<li class="page-item' . ($i === $paginaActual ? ' active' : '') . '"><a class="page-link" href="cartas.php?pagina=' . $i . '">' . $i . '</a></li>';
            }
            ?>
        </ul>
    </div>


<footer class="footer mt-auto py-3 bg-dark">
<div class="container text-center">
<span class="text-center" style="color:white">Aplicacion Desarrollada Unicamente Para Fines De Venta Y Distribucion De Menores.</span><br>
<span class="text-center" style="color:white">Plaza de la Tecnología Torreón, Av Hidalgo 1334, Primitivo Centro, 27000 Torreón, Coah. Segundo piso Local #288</span><br>
<span class="text-center  fw-bold" style="color:white">Cel. 871-33-44-172</span>
</div>
</footer> 
</body>
</html>