 
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
<style>
  /* Custom CSS for the transparent navigation bar with shadow */
  .navbar {
    background-color: transparent !important;
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
    <header>
  <!-- Fixed navbar -->
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
          <ul class="navbar-nav justify-content-right flex-grow-1 pe-3">
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
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="agregar_cliente.php">Agregar Cliente</a></li>
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

  <br>
  <?php
include 'date.php';
$conexion = new database();
$conexion->conectarDB();

// Obtener la lista de departamentos para el filtro
$consulta = "SELECT CONCAT('Cliente:', ' ',clientes.nom_cli,'. ', 'Carta:',' ', cartas.nombre_c, ' ', rareza.rareza) as nombre, deuda_c.id_dc, deuda_c.precio_c,
 deuda_c.cantidad_c, deuda_c.precio_c, deuda_c.notas, deuda_c.abono_c,car_rar.cantidad FROM deuda_c INNER JOIN clientes ON deuda_c.id_clientec = clientes.id_cli 
 INNER JOIN car_rar ON car_rar.id_cr = deuda_c.cr_fk inner join cartas on car_rar.id_carar=cartas.id_car inner join rareza on car_rar.id_rar=rareza.id_ra  GROUP BY nombre";
$tabla = $conexion->seleccionar($consulta);

// Filtrar el departamento seleccionado
if (isset($_POST['depa'])) {
    $depa = $_POST['depa'];
    $consultaf = "SELECT CONCAT('Cliente:', ' ',clientes.nom_cli,'. ', 'Carta:',' ', cartas.nombre_c, ' ', rareza.rareza) as nombre, deuda_c.id_dc, deuda_c.precio_c,deuda_c.cantidad_c, deuda_c.precio_c, deuda_c.notas, deuda_c.abono_c,car_rar.cantidad FROM deuda_c INNER JOIN clientes ON deuda_c.id_clientec = clientes.id_cli INNER JOIN car_rar ON car_rar.id_cr = deuda_c.cr_fk 
    inner join cartas on car_rar.id_carar=cartas.id_car inner join rareza on car_rar.id_rar=rareza.id_ra WHERE id_dc ='$depa' ";
    $tablaf = $conexion->seleccionar($consultaf);
}
?>

<div class="container" style="color:whitesmoke;background-color: rgba(0, 0, 0, .550); box-shadow: 0 4px 5px rgba(10, 2, 1, 55); text-align:left">
    <h1 style="text-align: center;">Modificar Deudores Cartas</h1>

    <form class="row g-3" method="POST">
        <div class="col-auto">
        <h2>Seleccionar Deuda:</h2>
        </div>
        <div class="col-auto">
            <select class="form-select" name="depa" aria-label="Default select example">
                <?php
                foreach ($tabla as $registro) {
                    $selected = '';
                    if (isset($_POST['depa']) && $_POST['depa'] == $registro->id_dc) {
                        $selected = 'selected';
                    }
                    echo "<option value='" . $registro->id_dc . "' $selected>" . $registro->nombre . "</option>";
                }
                ?>
            </select>
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-primary mb-3">Filtrar</button>
        </div>
<div class="row">
  
<?php
        // Mostrar los campos dentro del formulario principal
        if (isset($tablaf)) {
            foreach ($tablaf as $registro) {
                echo "<input type='hidden' name='id_dc' value='$registro->id_dc'> ";
                echo "<div class='col-3 col-lg-12'>";
                echo "<h3 for='cantidad_c'>Cantidad:</h3>";
                echo "</div>"; 
                
                
                echo "<div class='col-9 col-lg-12'>";
                echo "<input class='form-control' name='cantidad_c' value='$registro->cantidad_c'> ";
                echo "</div>"; 

                echo "<div class='col-2 col-lg-12'>";
                echo "<h3 for='notas'>Notas:</h3>";
                echo "</div>"; 

                echo "<div class='col-10 col-lg-12'>";
                echo "<input class='form-control' name='notas' value='$registro->notas'> ";
                echo "</div>"; 


                echo "<div class='col-4 col-lg-12'>";
                echo "<h3 for='notas'>Nuevo Abono:</h3>";
                echo "</div>"; 


                echo "<div class='col-7 col-lg-12'>";
                echo "<input class='form-control' name='abono_c' > ";
                echo "</div>"; 


                echo "<div class='col-4 col-lg-12'>";
                echo "<h3 for='notas'>Estado Deuda:</h3>";
                echo "</div>"; 


                echo "<div class='col-6 col-lg-12'>";
                echo "<select class='form-control' name='estado_c'>";
                echo "<option value='ACTIVO' " . ($registro->estado == 'ACTIVO' ? 'selected' : '') . ">ACTIVO</option>";
                echo "<option value='CANCELADO' " . ($registro->estado == 'CANCELADO' ? 'selected' : '') . ">CANCELAR</option>";
                echo "</select>";
                echo "</div>"; 

                echo "<div class='col-4 col-lg-12'>";
                echo "<h3 for='notas' style='text-align:center'>Detalles Deuda</h3>";
                echo "</div>";



                echo "<div class='col-4 col-lg-3'>";
                echo "<h3 for='notas'>Precio Carta:</h3>";
                echo "</div>"; 

                echo "<div class='col-4 col-lg-3'>";
                echo "<label for='abono_c' value=>$registro->precio_c</label>";
                echo "</div>"; 


    
                echo "<div class='col-4 col-lg-3'>";
                echo "<h3 for='notas'>Abono:</h3>";
                echo "</div>"; 
              



                echo "<div class='col-6 col-lg-3'>";
                echo "<label for='abono_c' value=>$registro->abono_c</label>";
               echo "</div>"; 


               echo "<div class='col-4 col-lg-3'>";
               echo "<label for='cantidad_c'>cantidad en stock:$registro->cantidad</label>";
               echo "</div>"; 
             
                
            }
        }
        ?>

</div>
        <!-- Botón para enviar los datos al archivo car_rar.php -->
        <div class="col-12">
            <button type="submit" formaction="editar_dc.php" class="btn btn-primary">Enviar Datos</button>
        </div>
    </form>
</div>


</body>
</html>