 
<?php
session_start();

// Verificar si el usuario no ha iniciado sesión
if (!isset($_SESSION['usuario'])) {
    echo "Inicia sesión primero por favor :D";
    header("refresh:5 ../../../index.php");  // Redireccionamos al archivo de inicio de sesión
    exit();
}

// Verificar si el tipo de usuario no es 1 (Tipo de usuario que puede acceder a esta página, osea el admin)
if ($_SESSION['tipo_usuario'] !== "1") { 
      echo "Acceso no autorizado. Por favor, inicia sesión con una cuenta válida.";
    header("refresh:5 ../../../index.php");  // Redireccionamos al archivo de inicio de sesión
    exit();
}

$nombreUsuario = $_SESSION['usuario'];
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../../css/bootstrap.min.css">
    <script src="../../../js/bootstrap.bundle.min.js"></script>

    <title>Document</title>
</head>
<body>

    </head>
    <body>
    
    <header>
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
            <li><a class="dropdown-item" href="listarPersonasConBusqueda.php">Inventario Carta</a></li>
            <li><a class="dropdown-item" href="listarPersonasConBusqueda2.php">Inventario Productos</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="detallar.php">Detalle Carta</a></li>
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
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="agregar_comprac.php">Venta Cartas</a></li>
            <li><a class="dropdown-item" href="agregar_comprap.php">Venta Productos</a></li>
          </ul>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Registro
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="../bitacoras/upd_cartas.php">Actualizaciones En Cartas</a></li>
            <li><a class="dropdown-item" href="../bitacoras/upd_productos.php">Actualizaciones En Productos</a></li>
            <li><a class="dropdown-item" href="../bitacoras/upd_dc.php">Reporte Deuda Cartas</a></li>
            <li><a class="dropdown-item" href="../bitacoras/upd_dp.php">Reporte Deuda Productos</a></li>
            <li><a class="dropdown-item" href="../bitacoras/upd_dp.php">Reporte Acreedores</a></li>

          </ul>
        </li>

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          <?php $nombreUsuario = $_SESSION['usuario']; echo "$nombreUsuario";?>
          </a>
          <ul class="dropdown-menu">
          <a href="../../config/cerrarSesion.php" class="dropdown-item">Cerrar Sesion</a>
          </ul>
      </li>
          </ul>
  
       
        </div>
      </div>
    </div>
  </nav>

<?php
include 'date.php';
$conexion = new database();
$conexion->conectarDB();

// Obtener la lista de departamentos para el filtro
$consulta = "SELECT CONCAT(cartas.nombre_c, ' ', rareza.rareza) as nombre, car_rar.id_cr, car_rar.p_beto, car_rar.p_tcg, car_rar.p_price, car_rar.cantidad FROM car_rar INNER JOIN cartas ON car_rar.id_carar = cartas.id_car INNER JOIN rareza ON car_rar.id_rar = rareza.id_ra ORDER BY cartas.nombre_c ASC";
$tabla = $conexion->seleccionar($consulta);

// Filtrar el departamento seleccionado
if (isset($_POST['depa'])) {
    $depa = $_POST['depa'];
    $consultaf = "SELECT CONCAT(cartas.nombre_c, ' ', rareza.rareza) as nombre, car_rar.id_cr, car_rar.p_beto, car_rar.p_tcg, car_rar.p_price, car_rar.cantidad FROM car_rar INNER JOIN cartas ON car_rar.id_carar = cartas.id_car INNER JOIN rareza ON car_rar.id_rar = rareza.id_ra WHERE id_cr ='$depa'";
    $tablaf = $conexion->seleccionar($consultaf);
}
?>
<br>
<div class="container" style="color:whitesmoke;background-color: rgba(0, 0, 0, .550);
    box-shadow: 0 4px 5px rgba(10, 2, 1, 55);text-align:left;color:white">

<br>
    <form class="row g-3" method="POST">
        <div class="col-auto">
           <H2 style="text-align: center;">Seleccionar Carta</H2>
        </div>
        <div class="col-auto">
            <select class="form-select" name="depa" aria-label="Default select example">
                <?php
                foreach ($tabla as $registro) {
                    $selected = '';
                    if (isset($_POST['depa']) && $_POST['depa'] == $registro->id_cr) {
                        $selected = 'selected';
                    }
                    echo "<option value='" . $registro->id_cr . "' $selected>" . $registro->nombre . "</option>";
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
                echo "<input type='hidden' name='id_cr' value='$registro->id_cr'> ";
                echo "<label for='p_beto'>Precio</label>";
                echo "<input class='form-control' name='p_beto' value='$registro->p_beto' pattern='^[0-9]+(\.[0-9]+)?$' title='Ingrese un número válido' required> ";
                echo "<label for='p_tcg'>p_tcg</label>";
                echo "<input class='form-control' name='p_tcg' value='$registro->p_tcg'> ";
                echo "<label for='p_price'>p_price</label>";
                echo "<input class='form-control' name='p_price' value='$registro->p_price'> ";
                echo "<label for='cantidad'>Cantidad</label>";
                echo "<input type='number' min='0' class='form-control' name='cantidad'  value='$registro->cantidad' required> ";
            }

         //   <!-- Botón para enviar los datos al archivo car_rar.php -->
            echo "<div class='col-12'>
            <button type='submit' formaction='car_rar2.php' class='btn btn-primary'>Enviar Datos</button>
            </div>";
        } else {
          echo "<div class='col-12'>
          <button type='submit' formaction='car_rar2.php' class='btn btn-primary disabled'>Enviar Datos</button>
          </div>";
        }
        ?>


    </form>
</div>

</body>
</html>