<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../../../css/bootstrap.min.css">
    <script src="../../../js/bootstrap.bundle.min.js"></script>
</head><link rel="stylesheet" href="../../../css/bootstrap.min.css">
<link rel="stylesheet" href="../../../css/index2.css">

<body style="background-color: rgba(235,235,235,255);">


<style>
        #contendor{
            width: 80%;
            margin: auto;
        }
    </style>
<?php
session_start();

// Verificar si el usuario no ha iniciado sesión
if (!isset($_SESSION['usuario'])) {
    echo "Inicia sesión primero por favor :D";
    header("refresh:50 ../../index.php");  // Redireccionamos al archivo de inicio de sesión
    exit();
}

// Verificar si el tipo de usuario no es 2 (Tipo de usuario que puede acceder a esta página, osea empleado)
if ($_SESSION['tipo_usuario'] !== "2") {
  echo "<div class='container' id='contenedor'>
  <div class='alert alert-danger text-center' role='alert'>
 <h1 style='text-aling:center'>¡Ups!</h1>
 <br>
 <div class='spinner-border text-dark' role='status'>
<span class='visually-hidden'>Loading...</span>
</div>
<br>
 <h6>Parece ser que no tienes acceso a este lugar, Asegurate de usar una cuenta valida</h6>
</div>
</div>   ";   
    header("refresh:5 ../../index.php");  // Redireccionamos al archivo de inicio de sesión otra vez
    exit();
}

$nombreUsuario = $_SESSION['usuario'];
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark" aria-label="Offcanvas navbar large">
  <div class="container-fluid">
    <a class="navbar-brand" href="../index.php" style="color: whitesmoke; font-size: 20px; font-family: 'Times New Roman', Times, serif;">
      WorkStack
    </a>
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
            <a type="button" class="nav-link" href="../calendario.php"  data-bs-target="#staticBackdrop">
              Calendario
            </a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Mi Inventario
            </a>
            <ul class="dropdown-menu">
              <li><a href="listarPersonasConBusqueda.php" class="dropdown-item">Cartas</a></li>
              <li><a href="listarPersonasConBusqueda2.php" class="dropdown-item">Productos</a></li>
            </ul>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Mi Agenda
            </a>
            <ul class="dropdown-menu">
          <li><a href="../ac.php" class="dropdown-item">Acreedores</a></li>
          <li><a href="../deuda_c.php" class="dropdown-item">Deudores Cartas</a></li>
          <li><a href="../deuda_p.php" class="dropdown-item">Deudores Productos</a></li>
          <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="agregar_cliente.php">Agregar Cliente</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="hola2.php">Venta Cartas</a></li>
            <li><a class="dropdown-item" href="hola.php">Venta Productos</a></li>
          </ul>
          </li>
          <li class="nav-item dropdown" >
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <?php $nombreUsuario = $_SESSION['usuario']; echo "$nombreUsuario";?>
            </a>
            <ul class="dropdown-menu">
              <li><a href="../../../config/cerrarSesion.php" class="dropdown-item">Cerrar Sesion</a></li>
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
$consulta = "SELECT CONCAT(cartas.nombre_c, ' ', rareza.rareza) as nombre, car_rar.id_cr, car_rar.cantidad FROM car_rar INNER JOIN cartas ON car_rar.id_carar = cartas.id_car INNER JOIN rareza ON car_rar.id_rar = rareza.id_ra ORDER BY cartas.nombre_c ASC";
$tabla = $conexion->seleccionar($consulta);

// Filtrar el departamento seleccionado
if (isset($_POST['depa'])) {
    $depa = $_POST['depa'];
    $consultaf = "SELECT CONCAT(cartas.nombre_c, ' ', rareza.rareza) as nombre, car_rar.id_cr, car_rar.cantidad FROM car_rar INNER JOIN cartas ON car_rar.id_carar = cartas.id_car INNER JOIN rareza ON car_rar.id_rar = rareza.id_ra WHERE id_cr ='$depa' ";
    $tablaf = $conexion->seleccionar($consultaf);
}
?>
<br>
<div class="container" style="color:whitesmoke;background-color: rgba(0, 0, 0, .550);
    box-shadow: 0 4px 5px rgba(10, 2, 1, 55);text-align:center;color:white">
    <h1 style="text-align: center;">Actualizar Datos</h1>
<br>
<form class="row g-3" method="POST" onsubmit="return validateForm()">
    <div class="col-auto">
        <h2 class="form-label">Selecciona la carta a modificar:</h2>
    </div>
    <div class="col-auto">
        <select class="form-select" name="depa" aria-label="Default select example" required>
  
            <?php
            foreach ($tabla as $registro) {
                $selected = '';
                if (isset($_POST['depa']) && $_POST['depa'] == $registro->id_cr) {
                    $selected = 'selected';
                }
                echo "<option ari value='" . $registro->id_cr . "' $selected>" . $registro->nombre . "</option>";
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
            echo "<input type='hidden' name='id_cr' 'required' required value='$registro->id_cr'> ";
            echo "<label for='cantidad'>cantidad</label>";
            echo "<input type='number' min='0' class='form-control' name='cantidad' 'required'  value='$registro->cantidad' required> ";
        }

         //   <!-- Botón para enviar los datos al archivo car_rar.php -->
         echo "<div class='col-12'>
         <button type='submit' formaction='mod_car2.php' class='btn btn-primary'>Enviar Datos</button>
         </div>";
     } else {
       echo "<div class='col-12'>
       <button type='submit' formaction='mod_car2.php' class='btn btn-primary disabled'>Enviar Datos</button>
       </div>";
     }
     ?>
</form>

<script>
    function validateForm() {
        var selectElement = document.querySelector("select[name='depa']");
        var selectedValue = selectElement.value;
        
        if (selectedValue === "") {
            alert("Por favor, selecciona una opción antes de continuar.");
            return false; // Impide que el formulario se envíe si no hay opción seleccionada.
        }
        
        return true; // Permite enviar el formulario si se ha seleccionado una opción.
    }
</script>

</div>
</body>
</html>