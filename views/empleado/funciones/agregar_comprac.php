
<?php
session_start();

// Verificar si el usuario no ha iniciado sesión
if (!isset($_SESSION['usuario'])) {
    echo "Inicia sesión primero por favor :D";
    header("refresh:5 ../../index.php");  // Redireccionamos al archivo de inicio de sesión
    exit();
}

// Verificar si el tipo de usuario no es 1 (Tipo de usuario que puede acceder a esta página, osea el admin)
if ($_SESSION['tipo_usuario'] !== "2") { 
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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</head>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark" aria-label="Offcanvas navbar large">
  <div class="container-fluid">
    <a class="navbar-brand" href="../index.php" style="  color: whitesmoke;
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
          <a type="button" class="nav-link" href="../calendario.php" data-bs-target="#staticBackdrop">
 Calendario 
</a>

          </li>
          <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" style=" background-color: transparent !important;
">
        Mi Inventario
          </a>
          <ul class="dropdown-menu" >
          <a href="listarPersonasConBusqueda.php" class="dropdown-item">Cartas</a>
          <a href="listarPersonasConBusqueda2.php" class="dropdown-item">Productos</a>
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
</nav>
<br>
<div class="container" style="color:whitesmoke;background-color: rgba(0, 0, 0, .550); box-shadow: 0 4px 5px rgba(10, 2, 1, 55); text-align:left">
<h1 style="text-align: center;">Agregar Nueva venta</h1>

<form  method="post" action="">

<h4>Seleccionar Cliente:</h4>
    <?php
      include 'date.php';
      $conexion = new Database();
      $conexion->conectarDB();

      $consulta = "SELECT clientes.nom_cli as nombre, clientes.id_cli from clientes";
      $tabla = $conexion->seleccionar($consulta);
      echo "<select id='id_cli' name='id_cli' class='form-select'> ";
      foreach ($tabla as $row)
      {
          echo "<option name='id_cli' value='".$row->id_cli."'>".$row->nombre."</option>";
      }
      echo "</select> ";
      echo "<h4 style='color: white;'>Selecciona Carta:</h4>";
      //carta
      $consulta = "SELECT CONCAT(cartas.nombre_c,' ', rareza.rareza) as nombre, car_rar.id_cr, car_rar.cantidad, car_rar.p_beto FROM cartas 
      INNER JOIN car_rar ON cartas.id_car=car_rar.id_carar INNER JOIN rareza ON car_rar.id_rar=rareza.id_ra ORDER BY 
      cartas.nombre_c ASC";
      $tabla = $conexion->seleccionar($consulta);
      echo "<select id='id_cr' name='id_cr' class='form-select'>";
      foreach ($tabla as $row)
      {
          echo "<option name='id_cr' value='".$row->id_cr."'>".$row->nombre."</option>";
      }
      echo "</select>";
      
       
      ?>




<br>

<div class="mb-3">



      
    <div class="mb-3">
    <h4>Cantidad Solicitada:</h4>     
      <input type="number" min="1" name="cantidad_c" class="form-control" id="exampleFormControlInput1" required>
    </div>
    
    <div class="mb-3">
    <h4>Precio:</h4>     <input type="text" name="precio" class="form-control" id="exampleFormControlInput1" required pattern="[0-9]+">
</div>

    <div class="mb-3">
    <h4>Notas:</h4>       <input type="text" name="notas" class="form-control" id="exampleFormControlInput1">
    </div>
    <div class="mb-3">

    <input type="hidden" name="concepto" class="form-control" id="exampleFormControlInput1" value="COMPRA" readonly>
</div>

    

<div class="d-grid gap-2">
<button type="submit" value="Calcular" class="btn btn-primary">Ver Datos Compra</button>
</div>
  

    </form>
<br>
  
    
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $numero1 = $_POST["precio"];
        $numero2 = $_POST["cantidad_c"];
        $notas =$_POST['notas'];
        $concepto =$_POST['concepto'];
        $nombre =$_POST['id_cli'];
        $suma = $numero1 * $numero2;
        
        echo "<div class'container'>
        <h5 class='text-center'>Detalle Compra</5>";
echo "<br>";
echo "<br>";
        echo "<p>El Total Por La Compra Es De: " . $suma . "</p>";
        echo "<p>Notas Realizadas: " . $notas . "</p>";
        echo "<p>Concepto De Venta: " . $concepto . "</p>";


        echo      " <div class='d-grid gap-2'>";
echo "<a class='btn btn-danger' href='agregar_comprac.php'>Cancelar Compra</a>";
echo "</div>";
        echo "</div>";
    }
    ?>
<script src="../../../js/bootstrap.min.js"></script> 
<script src="../../../js/bootstrap.bundle.min.js"></script>

</body>
</html>