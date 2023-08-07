
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

    <link rel="stylesheet" href="../../../css/bootstrap.min.css">
    <script src="../../../js/bootstrap.bundle.min.js"></script>
    <title>Document</title>


    <script>
        // Función para obtener la fecha máxima permitida (fecha actual más 1 año)
        function obtenerFechaMaxima() {
            const fechaActual = new Date();
            fechaActual.setFullYear(fechaActual.getFullYear() + 1); // Añadir 1 año a la fecha actual
            const fechaMaxima = fechaActual.toISOString().split('T')[0]; // Formato YYYY-MM-DD
            return fechaMaxima;
        }
    </script>


</head>
<body>
<link rel="stylesheet" href="../../../css/index2.css">

    </head>

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
            <li><a class="dropdown-item" href="../funciones/modificar_cliente.php">Modificar Cliente</a></li>
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

  <br>
  <div class="container" style="color:whitesmoke;background-color: rgba(0, 0, 0, .550);
    box-shadow: 0 4px 5px rgba(10, 2, 1, 55);text-align:left;color:white">
    <h1 style="text-align: center;">Agregar Nuevo Acreedor</h1>
    <form action="guardar_acre.php" method="post">

    <label for="id_cr" class="form-label" style="color: white;">Seleccionar cliente:</label>
    <?php
      include 'date.php';
      $conexion = new Database();
      $conexion->conectarDB();

      $consulta = "SELECT clientes.nom_cli as nombre, clientes.id_cli from clientes";
      $tabla = $conexion->seleccionar($consulta);
      echo "<select id='id_cli' name='id_cli' class='form-select'>";
      foreach ($tabla as $row)
      {
          echo "<option name='id_cli' value='".$row->id_cli."'>".$row->nombre."</option>";
      }
      echo "</select>";
      ?>

<div class="mb-3">
  <label for="descuento" class="form-label">Ingresar descuento</label>
  <input type="text" inputmode="numeric" pattern="[0-9]+" maxlength="2" name="descuento" class="form-control" id="exampleFormControlInput1" placeholder="Descuento (solo números por favor :D)" required>
  <div id="descuentoError" style="color: white; display: none;">¿Enserio creíste que ibamos a confiar en que no ibas a usar letras? Usa números, campeón.</div>
</div>

<script>
  const descuentoInput = document.querySelector('input[name="descuento"]');
  const descuentoError = document.getElementById('descuentoError');

  descuentoInput.addEventListener('input', function () {
    const inputValue = this.value;
    if (isNaN(inputValue)) {
      descuentoError.style.display = 'block';
    } else {
      descuentoError.style.display = 'none';
    }
  });
</script>

    <div class="mb-3">
      <label for="f_finalacreed" class="form-label">Fecha final</label>
      <?php
  // Obtenemos la fecha actual en formato ISO 8601 (YYYY-MM-DD)
  $fechaActual = date("Y-m-d");
  ?>
  <input type="date" name="f_finalacreed" class="form-control" min="<?= $fechaActual ?>" placeholder="Fecha final" required>
</div>

<script>
        // Establecer la fecha máxima permitida en el campo de entrada
        const fechaFinalInput = document.querySelector('input[name="f_finalacreed"]');
        fechaFinalInput.max = obtenerFechaMaxima();
    </script>

    <div class="mb-3">
      <label for="notas_ac" class="form-label" style="color: white;">Notas</label>
      <input type="text" name="notas_ac" class="form-control" id="exampleFormControlInput1" placeholder="Notas">
    </div>
    <div class="col-12">
      <button type="submit" value="Enviar" class="btn btn-primary">Guardar Registro</button>
    </div>
    </form>
</div>
</body>
</html>