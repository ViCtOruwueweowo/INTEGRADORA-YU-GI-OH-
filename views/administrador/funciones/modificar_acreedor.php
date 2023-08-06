 
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
  
<link rel="stylesheet" href="../../../css/index2.css">

<script>
  function verificarFechas() {
    const fechaInicio = new Date(document.querySelector('input[name="f_inicioacreed"]').value);
    const fechaFinal = new Date(document.querySelector('input[name="f_finalacreed"]').value);

    if (fechaFinal < fechaInicio) {
      alert('La fecha final debe ser mayor o igual a la fecha de inicio de crédito.');
      return false;
    }
    return true;
  }
</script>


    <title>Document</title>
</head>
<body>

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
<?php
include 'date.php';
$conexion = new database();
$conexion->conectarDB();

// Obtener la lista de departamentos para el filtro
$consulta = "SELECT clientes.nom_cli as nombre, acreedor.id_acreedor, acreedor.descuento, acreedor.f_finalacreed, acreedor.notas_ac from acreedor inner join clientes on acreedor.id_clientu=clientes.id_cli WHERE acreedor.f_finalacreed > now() ";
$tabla = $conexion->seleccionar($consulta);

// Filtrar el departamento seleccionado
if (isset($_POST['depa'])) {
    $depa = $_POST['depa'];
    $consultaf = "SELECT clientes.nom_cli as nombre, acreedor.id_acreedor, acreedor.descuento, acreedor.f_inicioacreed, acreedor.f_finalacreed, acreedor.notas_ac from acreedor inner join clientes on acreedor.id_clientu=clientes.id_cli WHERE id_acreedor ='$depa' ";
    $tablaf = $conexion->seleccionar($consultaf);
}
?>

<div class="container" style="color:whitesmoke;background-color: rgba(0, 0, 0, .550);
    box-shadow: 0 4px 5px rgba(10, 2, 1, 55);text-align:left;color:white">


    <form class="row g-3" method="POST">
        <div class="col-auto">
<h2>Selecciona Un Cliente:</h2>
    </div>
        <div class="col-auto">
            <select class="form-select" name="depa" aria-label="Default select example">
                <?php
                foreach ($tabla as $registro) {
                    $selected = '';
                    if (isset($_POST['depa']) && $_POST['depa'] == $registro->id_acreedor) {
                        $selected = 'selected';
                    }
                    echo "<option value='" . $registro->id_acreedor . "' $selected>" . $registro->nombre . "</option>";
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

                echo "<input type='hidden' name='id_acreedor' value='$registro->id_acreedor'> ";

                //echo "<label for='descuento'>descuento</label>";
                //echo "<input class='form-control' name='descuento' value='$registro->descuento'> ";

                echo "<label for='descuento'>Descuento</label>";
                echo "<input type='text' inputmode='numeric' pattern='[0-9]+' maxlength='2' class='form-control' name='descuento' placeholder='Descuento (solo números por favor :D)' value='$registro->descuento' required>";
                
                // este es el div de arriba
                echo "<div id='descuentoError' style='color: white; display: none;'>Tal vez fue muy difícil para ti, va de nuevo, números sí, letras no, tú puedes :D.</div>";


                // Este ayuda a ver que si pone letras le manda el mensaje del div de arriba, salta cuando ve que lo que se desea ingresar no entra en los parámetros dados por el input, si no es lo que es lo bloquea, si sí, pasa 
                echo 
                "<script>
                const descuentoInput = document.querySelector('input[name=\"descuento\"]');
                const descuentoError = document.getElementById('descuentoError');

                descuentoInput.addEventListener('input', function () {
                const inputValue = this.value;
                if (isNaN(inputValue)) {
                descuentoError.style.display = 'block';
                } else {
                descuentoError.style.display = 'none'; 
                  }
                });
                </script>";

                echo "<label for='f_inicioacreed'>Fecha inicio de credito</label>";
                echo "<input class='-form-control col-md-6' type='date' name='f_inicioacreed' value='$registro->f_inicioacreed' readonly> ";

         // Calcular la fecha límite permitida (f_inicioacreed + 1 día)
         $fechaInicio = new DateTime($registro->f_inicioacreed);
         $fechaLimite = $fechaInicio->modify('+1 day')->format('Y-m-d');
 
         // Mostrar el campo de fecha con la fecha límite permitida
         echo "<label for='f_finalacreed'>Fecha final de crédito</label>";
         echo "<input class='-form-control col-md-6' type='date' min='$fechaLimite' name='f_finalacreed' value='$registro->f_finalacreed'> ";
 
                echo "<label for='notas_ac'>Notas</label>";
                echo "<input class='form-control' name='notas_ac' value='$registro->notas_ac'> ";
                
            }
           // <!-- Botón para enviar los datos al archivo car_rar.php -->
            echo "<div class='col-12'>
                <button type='submit' formaction='mod_acre.php' class='btn btn-primary'>Enviar Datos</button>
            </div>";
        } else {
          echo "<div class='col-12'>
          <button type='submit' formaction='mod_acre.php' class='btn btn-primary disabled'>Enviar Datos</button>
      </div>";
        }
        ?>

    </form>
</div>

</body>
</html>