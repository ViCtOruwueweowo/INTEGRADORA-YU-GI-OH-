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
?>

<?php
require '../../config/database.php';
$db = new Database ;
$con = $db->conectar();
$sql = $con->prepare("SELECT clientes.nom_cli as CLIENTE, clientes.tel_cli as TELEFONO,deuda_c.concepto as CONCEPTO, 
wa.nombre_c as CARTA, wa.rareza as RAREZA, deuda_c.abono_c as ABONO, deuda_c.precio_c as TOTAL,
wa.codigo as CODIGO, deuda_c.f_inicioc as FINICIO, deuda_c.f_finalc as FFINAL, deuda_c.notas as NOTAS 
from clientes inner join deuda_c on clientes.id_cli=deuda_c.id_clientec inner join 
(select car_rar.id_cr, car_rar.id_carar, car_rar.id_rar, car_rar.codigo, cartas.id_car, cartas.nombre_c, rareza.id_ra, 
rareza.rareza from rareza inner join car_rar on rareza.id_ra=car_rar.id_rar inner join cartas on car_rar.id_carar=cartas.id_car)
as wa on deuda_c.cr_fk=wa.id_cr where deuda_c.f_finalc = '0000-00-00';");
$sql->execute();
$resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deudores</title>
</head>
<link rel="stylesheet" href="../../img/fondo bonito.jpg">

<link rel="stylesheet" href="../../css/bootstrap.min.css">
<body style="background-color: rgba(235,235,235,255);">
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
              <a class="nav-link " aria-current="page" href="calendario.php">Calendario</a>
            </li>
            <li class="nav-item">
              <a class="nav-link " aria-current="page" href="empleados.php">Empleados</a>
            </li> 
            <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Inventario
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="funciones/listarPersonasConBusqueda.php">Inventario Carta</a></li>
            <li><a class="dropdown-item" href="funciones/listarPersonasConBusqueda2.php">Inventario Productos</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="funciones/detallar.php">Detalle Carta</a></li>
          </ul>
        </li>
            <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Agenda
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="acreedores.php">Mis Acreedores</a></li>
            <li><a class="dropdown-item" href="deudores_cartas.php">Mis Deudores Cartas</a></li>
            <li><a class="dropdown-item" href="deudores_productos.php">Mis Deudores Productos</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="funciones/agregar_cliente.php">Agregar Cliente</a></li>
            <li><a class="dropdown-item" href="funciones/modificar_cliente.php">Modificar Cliente</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="funciones/agregar_comprac.php">Venta Cartas</a></li>
            <li><a class="dropdown-item" href="funciones/agregar_comprap.php">Venta Productos</a></li>
          </ul>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Registro
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="bitacoras/upd_cartas.php">Actualizaciones En Cartas</a></li>
            <li><a class="dropdown-item" href="bitacoras/upd_productos.php">Actualizaciones En Productos</a></li>
            <li><a class="dropdown-item" href="bitacoras/upd_dc.php">Reporte Deuda Cartas</a></li>
            <li><a class="dropdown-item" href="bitacoras/upd_dp.php">Reporte Deuda Productos</a></li>
            <li><a class="dropdown-item" href="bitacoras/upd_acreedor.php">Reporte Acreedores</a></li>

          </ul>
        </li>
        <li class="nav-item dropdown responsive">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          <?php $nombreUsuario = $_SESSION['usuario']; echo "$nombreUsuario";?>
          </a>
          <ul class="dropdown-menu dropdown-responsive">
          <a href="../../config/cerrarSesion.php" class="dropdown-item dropdown-responsive">Cerrar Sesion</a>
          </ul>
      </li>
        </ul>
    </div>
  </div>
</nav>

<!---->
<br>
<div class="container">
<a href="funciones/agregar_dc.php" class="btn btn-primary">Agregar Nuevos Deudores</a>
<a href="funciones/modificar_dc.php" class="btn btn-primary">Editar Mis Deudores</a>
</div>
<br>
<div class="container">
<div class="table-responsive">
<table class="table table-dark table-striped">
  <thead>
    <tr>
      <th scope="col">Nombre</th>
      <th scope="col">Contacto</th>
      <th scope="col">Carta</th>
      <th scope="col">Rareza</th>
      <th scope="col">Total Deuda</th>
      <th scope="col">Abonos</th>
      <th scope="col">Inicio Deuda</th>
      <th scope="col">Final Deuda</th>
    </tr>
  </thead>
  <tbody>
  <?php foreach($resultado as $fila): ?>
    <tr>
      <td scope="row" style="color:whitesmoke;"> <?php echo $fila ['CLIENTE'] ?></td>
      <td scope="row" style="color:whitesmoke;"> <?php echo $fila ['TELEFONO'] ?></td>
      <td scope="row" style="color:whitesmoke;"> <?php echo $fila ['CARTA'] ?></td>
      <td scope="row" style="color:whitesmoke;"> <?php echo $fila ['RAREZA'] ?></td>
      <td scope="row" style="color:whitesmoke;"> <?php echo $fila ['TOTAL'] ?></td>
      <td scope="row" style="color:whitesmoke;"> <?php echo $fila ['ABONO'] ?></td>
      <td scope="row" style="color:whitesmoke;"> <?php echo $fila ['FINICIO'] ?></td>
      <td scope="row" style="color:whitesmoke;"> <?php echo $fila ['FFINAL'] ?></td>
    </tr>
      <?php endforeach; ?>
  </tbody>
</table>
</div>
</div>

<script src="../../js/bootstrap.bundle.min.js"></script>
</body>
</html>