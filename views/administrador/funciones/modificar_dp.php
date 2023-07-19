 
<?php
session_start();

// Verificar si el usuario no ha iniciado sesión
if (!isset($_SESSION['usuario'])) {
  echo "Inicia sesión primero por favor :D";
  header("refresh:2 ../../index.php");  // Redireccionamos al archivo de inicio de sesión
  exit();
}

$nombreUsuario = $_SESSION['usuario'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../../../css/bootstrap.min.css">
    <link rel="stylesheet" href="../../../css/index2.css">
    <script src="../../../js/bootstrap.bundle.min.js"></script>
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
          <h5 class="offcanvas-title" id="offcanvasNavbar2Label"><b>Mis Atajos</b></h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
          <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
            <li class="nav-item">
              <a class="nav-link " aria-current="page" href="../calendario.php"><b>Calendario</b></a>
            </li>
            <li class="nav-item">
              <a class="nav-link " aria-current="page" href="../empleados.php"><b>Empleados</b></a>
            </li>
            <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <b>Inventario</b>
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="listarPersonasConBusqueda.php"><b>Inventario Carta</b></a></li>
            <li><a class="dropdown-item" href="listarPersonasConBusqueda2.php"><b>Inventario Productos</b></a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="detallar.php">Detalle Carta</a></li>
          </ul>
        </li>
            <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <b>Agenda</b>
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="../acreedores.php"><b>Mis Acreedores</b></a></li>
            <li><a class="dropdown-item" href="../deudores_cartas.php"><b>Mis Deudores Cartas</b></a></li>
            <li><a class="dropdown-item" href="../deudores_productos.php"><b>Mis Deudores Productos</b></a></li>
          </ul>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <b>Registro</b>
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="../bitacoras/upd_cartas.php"><b>Actualizaciones En Cartas</b></a></li>
            <li><a class="dropdown-item" href="../bitacoras/upd_productos.php"><b>Actualizaciones En Productos</b></a></li>
            <li><a class="dropdown-item" href="../bitacoras/upd_dc.php"><b>Reporte Deuda Cartas</b></a></li>
            <li><a class="dropdown-item" href="../bitacoras/upd_dp.php"><b>Reporte Deuda Productos</b></a></li>
          </ul>
        </li>
          </ul>
          <b>
        <?php echo "$nombreUsuario"; ?>
      </b>
          <form class="d-flex mt-3 mt-lg-0" role="search">
            <a href="../../config/cerrarSesion.php" class="btn btn-outline-success">Cerrar Sesion</a>
          </form>
        </div>
      </div>
    </div>
  </nav>

<br>
<?php
include 'date.php';
$conexion = new database();
$conexion->conectarDB();

// Obtener la lista de departamentos para el filtro
$consulta = "SELECT CONCAT('Cliente:', ' ',clientes.nom_cli,'. ', 'Prodcuto:',' ', productos.nom_p, '.') as nombre, deuda_p.id_dp, deuda_p.cantidad_p, deuda_p.precio_p, deuda_p.notas, deuda_p.abono_p FROM deuda_p INNER JOIN clientes ON deuda_p.id_clientep = clientes.id_cli INNER JOIN productos ON productos.id_pro = deuda_p.id_p";
$tabla = $conexion->seleccionar($consulta);

// Filtrar el departamento seleccionado
if (isset($_POST['depa'])) {
    $depa = $_POST['depa'];
    $consultaf = "SELECT CONCAT('Cliente:', ' ',clientes.nom_cli,'. ', 'Prodcuto:',' ', productos.nom_p, '.') as nombre, deuda_p.id_dp, deuda_p.cantidad_p, deuda_p.precio_p, deuda_p.notas, deuda_p.abono_p  FROM deuda_p INNER JOIN clientes ON deuda_p.id_clientep = clientes.id_cli INNER JOIN productos ON productos.id_pro = deuda_p.id_p WHERE id_dp ='$depa'";
    $tablaf = $conexion->seleccionar($consultaf);
}
?>

<div class="container">

    <form class="row g-3" method="POST">
        <div class="col-auto">
          <h2>Selecciona Una Deuda:</h2>
        </div>
        <div class="col-auto">
            <select class="form-select" name="depa" aria-label="Default select example">
                <?php
                foreach ($tabla as $registro) {
                    $selected = '';
                    if (isset($_POST['depa']) && $_POST['depa'] == $registro->id_dp) {
                        $selected = 'selected';
                    }
                    echo "<option value='" . $registro->id_dp . "' $selected>" . $registro->nombre . "</option>";
                }
                ?>
            </select>
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-primary mb-3">Filtrar</button>
        </div>

        <?php
        // Mostrar los campos dentro del formulario principal
        if (isset($tablaf)) {
            foreach ($tablaf as $registro) {
                echo "<input type='hidden' name='id_dp' value='$registro->id_dp'> ";
                echo "<label for='cantidad_p'>cantidad</label>";
                echo "<input class='form-control' name='cantidad_p' value='$registro->cantidad_p'> ";
                echo "<label for='notas'>Notas</label>";
                echo "<input class='form-control' name='notas' value='$registro->notas'> ";
                echo "<label for='abono_p'>abono</label>";
                echo "<input class='form-control' name='abono_p' value='$registro->abono_p'> ";
                echo "<select class='form-control' name='concepto'>";
echo "<option value='ENCARGO' " . ($registro->estado == 'ENCARGO' ? 'selected' : '') . ">ENCARGO</option>";
echo "<option value='DEUDA' " . ($registro->estado == 'DEUDA' ? 'selected' : '') . ">DEUDA</option>";
echo "</select>";



                
                
                
            }
        }
        ?>

        <!-- Botón para enviar los datos al archivo car_rar.php -->
        <div class="col-12">
            <button type="submit" formaction="update_dp.php" class="btn btn-primary">Enviar Datos</button>
        </div>
    </form>
</div>

</body>
</html>