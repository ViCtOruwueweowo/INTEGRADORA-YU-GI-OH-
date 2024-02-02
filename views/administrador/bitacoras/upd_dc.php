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
require '../../../config/database.php';
$db = new Database();
$con = $db->conectar();
$sql = $con->prepare
("SELECT SIU.nom_cli, SIU.nombre_c, SIU.rareza, SIU.cantidad_c, SIU.precio_c, reporteactdeuda_c.fecha_actualizada,
reporteactdeuda_c.act_abono, SIU.concepto, reporteactdeuda_c.act_estado FROM reporteactdeuda_c INNER JOIN
(SELECT deuda_c.id_dc, clientes.nom_cli, WA.nombre_c, WA.rareza, deuda_c.cantidad_c, deuda_c.precio_c, deuda_c.concepto,
deuda_c.estado_c FROM clientes inner join deuda_c on clientes.id_cli=deuda_c.id_clientec INNER JOIN
(select cartas.nombre_c, rareza.rareza, car_rar.id_cr from cartas inner join car_rar on car_rar.id_carar=cartas.id_car inner join
rareza on rareza.id_ra=car_rar.id_rar) as WA on deuda_c.cr_fk=WA.id_cr) as SIU on SIU.id_dc=reporteactdeuda_c.id order by
reporteactdeuda_c.fecha_actualizada DESC");
$sql->execute();
$resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
?>

 

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bitacora Deuda Cartas</title>
    <link rel="stylesheet" href="../../../css/bootstrap.min.css">
    <script src="../../../js/bootstrap.bundle.min.js"></script>
</head>
<body>

    </head>
    <body>
   
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
<h1 class="text-center">Reporte Deuda Cartas</h1>
<hr>

<div class="table-responsive">
<table class="table table-dark table-striped">
<thead>
    <tr>
      <th scope="col">Fecha Actualizacion</th>
      <th scope="col">Deudor</th>
      <th scope="col">Carta</th>
      <th scope="col">Cantidad</th>
      <th scope="col">Precio</th>
      <th scope="col">Abono</th>
      <th scope="col">Nuevo Abono</th>
      <th scope="col">Estado Deudor</th>
    </tr>
  </thead>
  <tbody>
  <?php foreach($resultado as $fila): ?>
    <tr>
      <td style="color:whitesmoke;"> <?php echo $fila ['fecha_actualizada'] ?></td>
      <td  style="color:whitesmoke;"> <?php echo $fila ['nom_cli'] ?></td>
      <td  style="color:whitesmoke;"> <?php echo $fila ['nombre_c'] ?></td>
      <td style="color:whitesmoke;"><?php echo $fila ['cantidad'] ?></td>
      <td style="color:whitesmoke;"><?php echo $fila ['precio'] ?></td>
      <td style="color:whitesmoke;"><?php echo $fila ['abono'] ?></td>
      <td style="color:whitesmoke;"><?php echo $fila ['act_abono'] ?></td>
      <td style="color:whitesmoke;"><?php echo $fila ['act_estado'] ?></td>
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