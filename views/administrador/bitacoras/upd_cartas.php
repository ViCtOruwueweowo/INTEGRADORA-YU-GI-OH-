<?php
session_start();

// Verificar si el usuario no ha iniciado sesión
if (!isset($_SESSION['usuario'])) {
    echo "Inicia sesión primero por favor :D";
    header("refresh:5 ../../index.php");  // Redireccionamos al archivo de inicio de sesión
    exit();
}

// Verificar si el tipo de usuario no es 1 (Tipo de usuario que puede acceder a esta página, osea el admin)
if ($_SESSION['tipo_usuario'] !== "1") { 
      echo "Acceso no autorizado. Por favor, inicia sesión con una cuenta válida.";
    header("refresh:5 ../../index.php");  // Redireccionamos al archivo de inicio de sesión
    exit();
}

$nombreUsuario = $_SESSION['usuario'];

require '../../../config/database.php';
$db = new Database();
$con = $db->conectar();

// Obtén el valor del filtro si está presente en la URL
$filtroCarta = isset($_GET['filtro_carta']) ? $_GET['filtro_carta'] : null;

$sql = $con->prepare("
    SELECT * FROM bitacora_actualizacion_cartas
    INNER JOIN cartas ON bitacora_actualizacion_cartas.id_carar = cartas.id_car
    INNER JOIN rareza ON bitacora_actualizacion_cartas.id_rar = rareza.id_ra
    " . ($filtroCarta ? "WHERE cartas.id_car = :filtroCarta" : "") . " 
    ORDER BY bitacora_actualizacion_cartas.fecha DESC
");


// Si hay un filtro, bindea el valor a la consulta
if ($filtroCarta) {
    $sql->bindParam(':filtroCarta', $filtroCarta, PDO::PARAM_INT);
}

$sql->execute();
$resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bitacora Cartas</title>
    <link rel="stylesheet" href="../../../css/bootstrap.min.css">
    <script src="../../../js/bootstrap.bundle.min.js"></script>
</head>
<body>

    </head>
    <body>
    
    <header>
  <!-- Fixed navbar -->
    <!-- Fixed navbar -->
   
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark" aria-label="Offcanvas navbar large">
    <div class="container-fluid">
      <a class="navbar-brand" href="../index.php">WorkStack</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar2" aria-controls="offcanvasNavbar2" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="offcanvas offcanvas-end text-bg-dark" tabindex="-1" id="offcanvasNavbar2" aria-labelledby="offcanvasNavbar2Label">
        <div class="offcanvas-header">
          <h5 class="offcanvas-title" id="offcanvasNavbar2Label">Mis Atajos</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
          <ul class="navbar-nav justify-content-center flex-grow-1 pe-3">
            <li class="nav-item">
              <a class="nav-link " aria-current="page" href="../calendario.php">Calendario</a>
            </li>
            <li class="nav-item">
              <a class="nav-link " aria-current="page" href="../empleados.php">Empleados</a>
            </li>
            <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Inventario
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="../funciones/listarPersonasConBusqueda.php">Inventario Carta</a></li>
            <li><a class="dropdown-item" href="../funciones/listarPersonasConBusqueda2.php">Inventario Productos</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="../funciones/detallar.php">Detalle Carta</a></li>
          </ul>
        </li>
            <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Agenda
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="../acreedores.php">Mis Acreedores</a></li>
            <li><a class="dropdown-item" href="../deudores_cartas.php">Mis Deudores Cartas</a></li>
            <li><a class="dropdown-item" href="../deudores_productos.php">Mis Deudores Productos</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="agregar_cliente.php">Agregar Cliente</a></li>
            <li><a class="dropdown-item" href="../funciones/modificar_cliente.php">Modificar Cliente</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="../funciones/agregar_comprac.php">Venta Cartas</a></li>
            <li><a class="dropdown-item" href="../funciones/agregar_comprap.php">Venta Productos</a></li>
          </ul>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Registro
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="upd_cartas.php">Actualizaciones En Cartas</a></li>
            <li><a class="dropdown-item" href="upd_productos.php">Actualizaciones En Productos</a></li>
            <li><a class="dropdown-item" href="upd_dc.php">Reporte Deuda Cartas</a></li>
            <li><a class="dropdown-item" href="upd_dp.php">Reporte Deuda Productos</a></li>
            <li><a class="dropdown-item" href="upd_acreedor.php">Reporte Acreedores</a></li>

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
          </ul>
  
       
        </div>
      </div>
    </div>
  </nav>
<!--Cabecera-->
<br>
<!--Creacion De La Tabla-->
<div class="container" >
<h1 class="text-center">Reporte Actualizacion Cartas</h1>
<hr>

<!-- Formulario de filtro -->
<form method="get">
<?php
// Obtén las opciones de carta desde la base de datos
$sqlOpcionesCarta = $con->prepare("SELECT id_car, nombre_c FROM cartas ORDER BY nombre_c ASC");
$sqlOpcionesCarta->execute();
$opcionesCarta = $sqlOpcionesCarta->fetchAll(PDO::FETCH_ASSOC);
?>
    <label for="filtro_carta">Filtrar por Carta:</label>
    <select name="filtro_carta" id="filtro_carta">
        <?php foreach ($opcionesCarta as $opcion) : ?>
            <option value="<?php echo $opcion['id_car']; ?>"><?php echo $opcion['nombre_c']; ?></option>
        <?php endforeach; ?>
    </select>
    <button type="submit">Filtrar</button>
</form>
<br>


<div class="table-responsive"> 
<table class="table table-dark table-striped">
<thead>
    <tr>
      <th scope="col">Fecha Actualizacion</th>
      <th scope="col">Carta</th>
      <th scope="col">Rareza</th>
      <th scope="col">Precio</th>
      <th scope="col">Nuevo Precio</th>
      <th scope="col">Cantidad</th>
      <th scope="col">Nueva Cantidad</th>
    </tr>
  </thead>
  <tbody>
  <?php foreach($resultado as $fila): ?>
    <tr>
      <td style="color:whitesmoke;"><?php echo $fila ['fecha'] ?></td>
      <td style="color:whitesmoke;"><?php echo $fila ['nombre_c'] ?></td>
      <td style="color:whitesmoke;"><?php echo $fila ['rareza'] ?></td>
      <td style="color:whitesmoke;"><?php echo $fila ['p_beto'] ?></td>
      <td style="color:whitesmoke;"><?php echo $fila ['upd_beto'] ?></td>
      <td style="color:whitesmoke;"><?php echo $fila ['cantidad'] ?></td>
      <td style="color:whitesmoke;"><?php echo $fila ['upd_cantidad'] ?></td>
</td>
    </tr>
      <?php endforeach; ?>
  </tbody>
</table>
</div>
<!---->

</div>
</body>
</html>